<?php

namespace App\Jobs;

use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPostCreation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $postData;
    protected $imageData;

    /**
     * Create a new job instance.
     */
    public function __construct(array $postData,array $imageData )
    {
        $this->postData = $postData;
        $this->imageData = $imageData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $post = Post::create($this->postData);

        if ($this->imageData) {
            $post->image()->create([
                'path' => $this->imageData['path'],
                'original_name' => $this->imageData['original_name'] ?? null,
                'hash' => $this->imageData['hash'] ?? null,
            ]);
        }

        Log::info('Post created successfully', ['post_id' => $post->id, 'title' => $post->title]);
    }
}
