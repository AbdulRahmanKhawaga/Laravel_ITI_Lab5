<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use Carbon\Carbon;

class DeleteOldSoftDeletedPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permanently delete posts that were soft deleted more than 1 month ago';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = Carbon::now()->subMonth();

        $count = Post::onlyTrashed()
            ->where('deleted_at', '<', $date)
            ->forceDelete();

        $this->info("Deleted {$count} old soft-deleted posts.");    }
}
