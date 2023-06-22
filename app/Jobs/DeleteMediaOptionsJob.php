<?php

namespace App\Jobs;

use App\Models\Media_option;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteMediaOptionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $idsToDelete;
    protected $rowsToDelete;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($idsToDelete, $rowsToDelete)
    {
        $this->idsToDelete = $idsToDelete;
        $this->rowsToDelete = $rowsToDelete;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Media_option::whereIn('id', $this->idsToDelete)->delete();
    }
}
