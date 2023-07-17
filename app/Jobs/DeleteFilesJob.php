<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class DeleteFilesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filesToDelete;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filesToDelete)
    {
        $this->filesToDelete = $filesToDelete;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->filesToDelete as $file) {
            Storage::delete('public/media/' . $file);
        }
    }
}
