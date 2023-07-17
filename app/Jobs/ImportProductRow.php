<?php

namespace App\Jobs;

use App\Models\Brand;
use App\Models\Media_option;
use App\Models\Pro_category;
use App\Models\Pro_image;
use App\Models\Product;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImportProductRow implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $categoriesCacheKey = 'import_categories';
    protected $brandsCacheKey = 'import_brands';
    protected $row;

    public $timeout = 1800;
    public $tries = 5;

    public function __construct(array $row)
    {
        ini_set('memory_limit', '2560M');
        $this->row = $row;
    }

    public function handle()
    {
        $validator = Validator::make($this->row, [
            'product_name' => 'required',
            'categories' => 'required',
            'brand' => 'required',
            'imageurls' => 'required',
        ]);


        if ($validator->fails()) {
            Log::error('Invalid product row: ' . json_encode($this->row));
            return;
        }

        $category = $this->findOrCreateCategory($this->row['categories']);
        $brand = $this->findOrCreateBrand($this->row['brand']);
        $downloadedImages = $this->downloadImages($this->row['imageurls']);

        if (empty($downloadedImages)) {
            Log::error($this->row['product_name'] . ' - No images found for the product.');
            return;
        }
        $imageFileNames = [];
        try {

            DB::transaction(function () use ($category, $brand, $downloadedImages, &$imageFileNames) {
                $product = $this->createProduct($category, $brand);

                $this->deleteRelatedImagesAndMediaOptionsForProduct($product);

                // Save new images and update product
                $imageFileNames = $this->saveImages($downloadedImages, $this->row['product_name']);
                $this->updateProductImages($product, $imageFileNames);
            });

        } catch (\Exception $e) {
            Log::error('Insert product error: ' . $e->getMessage());
            if ($imageFileNames) {
                $this->deleteRelatedImagesAndMediaOptions($imageFileNames);
            }

            throw $e;
        }

        $this->cleanUp();
    }

    private function createProduct($category, $brand)
    {
        $product = Product::updateOrCreate(
            [
                'title' => $this->row['product_name'],
            ],
            [
                'slug' => $this->uniqueSlug(Product::class, Str::slug($this->row['product_name'])),
                'cat_id' => $category->id,
                'brand_id' => $brand->id,
                'short_desc' => $this->row['description'] ?? null,
                'description' => $this->row['content'] ?? null,
                'sku' => $this->row['sku'] ?? null,

                'old_price' => $this->row['price'],
                'sale_price' => $this->row['sale_price'],

                'start_date' => $this->row['start_date_sale_price'] ?? null,
                'end_date' => $this->row['end_date_sale_price'] ?? null,
                'stock_qty' => $this->row['quantity'] ?? null,
                'stock_status_id' => $this->row['stock_status'] == 'in_stock' ? 1 : 0,
                'is_discount' => $this->row['is_discount'] ?? 0,
                'is_stock' => $this->row['is_stock'] ?? 1,
                'collection_id' => $this->row['collection_id'] ?? 1,
                'is_publish' => $this->row['is_publish'] ?? 1,
                'is_featured' => $this->row['is_featured'] ?? 1,
            ]
        );
        return $product;
    }

    private function updateProductImages(Product $product, array $imageFileNames)
    {
        $product->f_thumbnail = isset($imageFileNames[0]['thumbnail']) ? $imageFileNames[0]['thumbnail'] : null;
        $product->large_image = isset($imageFileNames[0]['large_image']) ? $imageFileNames[0]['large_image'] : null;

        foreach (array_slice($imageFileNames, 1) as $imageFileName) {
            $proImage = new Pro_image([
                'product_id' => $product->id,
                'thumbnail' => $imageFileName['thumbnail'],
                'large_image' => $imageFileName['large_image'],
                'desc' => null,
            ]);
            $proImage->save();
        }

        $product->save();
    }

    private function findOrCreateCategory($categoryName)
    {
        $categoryCacheKey = 'category_' . Str::slug($categoryName);
        return Cache::remember($categoryCacheKey, now()->addDay(), function () use ($categoryName) {
            return Pro_category::updateOrCreate(
                ['name' => trim($categoryName)],
                ['slug' => $this->uniqueSlug(Pro_category::class, Str::slug($categoryName)), 'is_publish' => 1]
            );
        });
    }

    private function findOrCreateBrand($brandName)
    {
        $brandCacheKey = 'brand_' . Str::slug($brandName);
        return Cache::remember($brandCacheKey, now()->addDay(), function () use ($brandName) {
            return Brand::updateOrCreate(
                ['name' => trim($brandName)],
                ['is_publish' => 1, 'is_featured' => 1]
            );
        });
    }

    private function uniqueSlug($model, $slug)
    {
        $baseSlug = $slug;
        $i = 1;

        while ($model::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $i;
            $i++;
        }
        return $slug;
    }

    private function downloadImages(string $imageURLs, int $maxImages = 5): array
    {
        $urls = $this->parseImageURLs($imageURLs);
        $downloadedImages = [];
        foreach ($urls as $imageURL) {
            if (count($downloadedImages) >= $maxImages) {
                break;
            }
            $decodedURL = urldecode($imageURL);
            $cleanURL = trim($this->removeQueryParams($decodedURL));
            if (!$this->isValidURL($cleanURL)) {
                Log::warning('Invalid image URL: ' . $cleanURL);
                continue;
            }
            $imageData = $this->downloadImage($cleanURL);
            if ($imageData !== null) {
                $downloadedImages[] = $imageData;
            }
        }
        return $downloadedImages;
    }

    private function parseImageURLs(string $imageURLs): array
    {
        $urls = preg_split('/[|,]+/', $imageURLs);

        if (count($urls) === 1 && $urls[0] === $imageURLs) {
            return [$imageURLs];
        }

        return $urls;
    }

    private function removeQueryParams(string $url): string
    {
        return preg_replace('/\?.*/', '', $url);
    }

    private function isValidURL(string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    private function downloadImage(string $url): ?array
    {
        $client = new Client([
            RequestOptions::VERIFY => false,
        ]);

        try {
            $response = $client->get($url);
            $imageContents = $response->getBody()->getContents();
            $image = Image::make($imageContents);

            $mimeType = $image->mime();
            $extension = $this->getExtensionFromMimeType($mimeType);

            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'], true)) {
                Log::warning('Invalid image extension: ' . $extension);
                return null;
            }

            return ['image' => $image, 'extension' => $extension];
        } catch (\Exception $e) {
            Log::error('downloadImage : ' . $e->getMessage() . ' - line: ' . $e->getLine());
            return null;
        }
    }

    private function getExtensionFromMimeType(string $mimeType): ?string
    {
        $mimeToExtension = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif',
            'image/bmp' => 'bmp',
            'image/webp' => 'webp',
        ];

        return $mimeToExtension[$mimeType] ?? null;
    }

    private function saveImages(array $downloadedImages, string $product_name)
    {
        $dateTime = date('Ymd');
        $thumbnail = thumbnail('Thumbnail');
        $width = $thumbnail['width'];
        $height = $thumbnail['height'];
        $savedImages = [];

        $originalDir = 'media/products/';
        $thumbnailDir = 'media/products/' . $width . 'x' . $height . '/';

        foreach ($downloadedImages as $index => $downloadedImage) {
            $image = $downloadedImage['image'];
            $extension = $downloadedImage['extension'];

            $product_name_formatted = ucwords($product_name);

            $product_name_short = str_replace(' ', '', ucwords($product_name_formatted));
            $product_name_first_character = substr($product_name_short, 0, 5);
            $imageName = $dateTime . '-' . time() . $product_name_first_character . '-' . $index . '.' . $extension;
            $originalPath = $originalDir . $imageName;
            $thumbnailPath = $thumbnailDir . $imageName;

            $thumbnail = $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            $thumbnail->stream()->detach();
            Storage::put('public/' . $thumbnailPath, $thumbnail->stream());
            Storage::put('public/' . $originalPath, $image->stream());

            $imageSize = Storage::size('public/' . $originalPath);

            $savedImage = [
                'title' => Str::slug($product_name) . '_' . $index,
                'alt_title' => Str::slug($product_name) . '_' . $index,
                'thumbnail' => 'products/' . $width . 'x' . $height . '/' . $imageName,
                'large_image' => 'products/' . $imageName,
                'option_value' => $imageSize,
            ];

            $savedImages[] = $savedImage;
        }

        try {
            Media_option::insert($savedImages);
        } catch (\Exception $e) {
            Log::error('Lỗi khi chèn dữ liệu vào bảng media_options: ' . $e->getMessage());
        }

        return $savedImages;
    }

    private function deleteRelatedImagesAndMediaOptions($imageFileNames)
    {
        try {
            foreach ($imageFileNames as $imageFileName) {
                if (isset($imageFileName['thumbnail'])) {
                    $thumbnailPath = public_path('media/') . $imageFileName['thumbnail'];

                    if (file_exists($thumbnailPath)) {
                        unlink($thumbnailPath);
                    }
                }

                if (isset($imageFileName['large_image'])) {
                    $largeImagePath = public_path('media/') . $imageFileName['large_image'];

                    if (file_exists($largeImagePath)) {
                        unlink($largeImagePath);
                    }
                }
            }

            if (!empty($imageFileNames)) {
                Media_option::whereIn('title', array_column($imageFileNames, 'title'))->delete();
            }
        } catch (\Exception $e) {
            Log::error('deleteRelatedImagesAndMediaOptions : ' . $e->getMessage() . ' - line: ' . $e->getLine());
            return null;
        }
    }

    private function deleteRelatedImagesAndMediaOptionsForProduct(Product $product)
    {
        try {
            $imageFileNames = Pro_image::where('product_id', $product->id)->get(['thumbnail', 'large_image'])->toArray();
            $imageFileNames[] = [
                'thumbnail' => $product->f_thumbnail,
                'large_image' => $product->large_image,
            ];
            $this->deleteRelatedImagesAndMediaOptions($imageFileNames);

            Pro_image::where('product_id', $product->id)->delete();
        } catch (\Exception $e) {
            Log::error('deleteRelatedImagesAndMediaOptionsForProduct : ' . $e->getMessage() . ' - line: ' . $e->getLine());
            return null;
        }
    }

    private function cleanUp()
    {
        $this->row = null;
        Cache::forget($this->categoriesCacheKey);
        Cache::forget($this->brandsCacheKey);
        if (function_exists('gc_mem_caches')) {
            gc_mem_caches();
        }
    }
}
