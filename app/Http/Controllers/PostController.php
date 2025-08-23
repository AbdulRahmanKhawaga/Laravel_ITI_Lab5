<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Jobs\ProcessPostCreation;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $users = User::all();
        return view('posts.create', compact('users'));
    }

    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validated();

        $postData = [
            'title' => $validatedData['title'],
            'body' => $validatedData['body'],
            'user_id' => $validatedData['user_id'],
        ];

        $imageData = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $uniqueFileName = \Illuminate\Support\Str::uuid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('post-images', $uniqueFileName, 'public');

            $imageData = [
                'path' => $imagePath,
                'original_name' => $image->getClientOriginalName(),
                'hash' => hash_file('sha256', $image->getRealPath()),
            ];
        }

        ProcessPostCreation::dispatch($postData, $imageData);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post creation has been queued.');
    }




    public function show(Post $post)
    {
        $users = User::all();
        return view('posts.show', compact('post', 'users'));
    }

    public function edit(Post $post)
    {
        $users = User::all();
        return view('posts.edit', compact('post', 'users'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $validatedData = $request->validated();
        $post->update($validatedData);

        // If request has delete_image flag
        if (!empty($request->delete_image) && $post->image) {
            $this->deleteImageIfExists($post->image->path);
            $post->image->delete();
        }

        // If new image uploaded
        if ($request->hasFile('image')) {
            if ($post->image) {
                $this->deleteImageIfExists($post->image->path);
                $post->image->delete();
            }
            $this->handleImageUpload($request, $post);
        }

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {

        $post->delete();
        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }

    public function trashed()
    {
        $posts = Post::onlyTrashed()->with('user')->paginate(10);
        return view('posts.trashed', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();

        return redirect()
            ->route('posts.trashed')
            ->with('success', 'Post restored successfully.');
    }

    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        // Delete associated image file
        if ($post->image) {
            $this->deleteImageIfExists($post->image->path);
            $post->image->delete();
        }

        $post->forceDelete();

        return redirect()
            ->route('posts.trashed')
            ->with('success', 'Post permanently deleted.');
    }

    private function handleImageUpload(Request $request, Post $post): void
    {
        if (!$request->hasFile('image')) {
            return;
        }

        $image = $request->file('image');
        $originalName = $image->getClientOriginalName();
        $fileHash = hash_file('sha256', $image->getRealPath());

        // Check for existing image (avoid duplicates)
        $existingImage = Image::where('hash', $fileHash)->first();

        if ($existingImage) {
            $post->image()->create([
                'path' => $existingImage->path,
                'original_name' => $originalName,
                'hash' => $fileHash,
            ]);
            return;
        }

        // Store new image with unique filename
        $uniqueFileName = Str::uuid() . '.' . $image->getClientOriginalExtension();
        $imagePath = $image->storeAs('post-images', $uniqueFileName, 'public');

        $post->image()->create([
            'path' => $imagePath,
            'original_name' => $originalName,
            'hash' => $fileHash,
        ]);
    }

    private function deleteImageIfExists(?string $imagePath): void
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
