<?php

namespace App\Jobs;

use App\Models\Media_option;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class InsertHashJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */


    protected $images;


    public function __construct($images)
    {
        $this->images = $images;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $start = microtime(true);
            $images = $this->images;
            $insertData = [];

            foreach ($images as $image) {
                $image_path = storage_path('app/public/media/' . $image->thumbnail);
                $insertData[] = [
                    'id' => $image->id,
                    'hash_image' => md5_file($image_path),
                ];
            }
//            DB::table('media_option')->upsert($insertData, ['id'], ['hash_image']);
            Media_option::upsert($insertData, ['id'], ['hash_image']);

            $end = microtime(true);
            $duration = $end - $start;
            Log::channel('insert-hash')->info('Inserted hash for ' . count($this->images) . ' images in ' . $duration . ' seconds.');
        } catch (\Exception $e) {
            Log::channel('insert-hash')->error('Inserted hash error: ' . $e->getMessage());
        }
    }


}
