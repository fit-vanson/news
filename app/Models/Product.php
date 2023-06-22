<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'f_thumbnail',
        'large_image',
        'short_desc',
        'description',
        'extra_desc',
        'cost_price',
        'sale_price',
        'old_price',
        'start_date',
        'end_date',
        'is_discount',
        'is_stock',
        'sku',
        'stock_status_id',
        'stock_qty',
        'u_stock_qty',
        'category_ids',
        'cat_id',
        'brand_id',
        'collection_id',
        'label_id',
        'variation_color',
        'variation_size',
        'tax_id',
        'is_featured',
        'is_publish',
        'user_id',
        'og_title',
        'og_image',
        'og_description',
        'og_keywords',
    ];
//    protected $appends = ['averageRating'];

    public function tp_status(){
        return $this->belongsTo(Tp_status::class,'is_publish');
    }

    public function categories(){
        return $this->belongsTo(Pro_category::class,'cat_id');
    }

    public function brand(){
        return $this->belongsTo(Brand::class,'brand_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class,'item_id');
    }

    public function ratings()
    {
        return $this->hasMany(Review::class,'item_id')
            ->selectRaw('item_id, AVG(rating) AS average_rating,COUNT(id) TotalReview,SUM(IFNULL(rating, 0)) TotalRating')
            ->groupBy('item_id');
    }

    public function order_items(){
        return $this->hasMany(Order_item::class,'product_id');
    }
}
