{{--@extends('layouts.app')--}}

{{--@section('content')--}}
<x-app-layout>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Post Details</h1>
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <span>Post #{{ $post->id }}</span>
                <span>{{ $post->created_at }}</span>
            </div>
            <div class="card-body">
                @if($post->image)
                <div class="mb-4 text-center">
                    <img src="{{ asset('storage/' . $post->image->path) }}" alt="{{ $post->title }}" class="img-fluid rounded" style="max-height: 400px;">
                    <p class="text-muted mt-2">Original image: {{ $post->image->original_name }}</p>
                </div>
                @endif

                <div class="mb-3">
                    <h5>Post Info</h5>
                    <p><strong>Title:</strong> {{ $post->title }}</p>
                    <p><strong>Description:</strong> {{ $post->body }}</p>
                </div>

                <div class="mb-3">
                    <h5>Post Creator Info</h5>
                    <p><strong>Name:</strong> {{ $post->user ? $post->user->name : 'Unknown' }}</p>
                    <p><strong>Created At:</strong> {{ $post->created_at_human }} ({{ $post->created_at }})</p>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">Comments</h5>
            </div>
            <div class="card-body">
                @if($post->comments->count() > 0)
                    @foreach($post->comments as $comment)
                        <div class="border-bottom mb-3 pb-3">
                            <p>{{ $comment->content }}</p>
                            <p><strong>By:</strong> {{ $comment->user ? $comment->user->name : 'Unknown' }}</p>
                            <small class="text-muted">{{ $comment->created_at_human }}</small>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">No comments yet.</p>
                @endif

                <div class="mt-4">
                    <h6>Add a Comment</h6>
                    <form action="{{ route('posts.comments.store', $post->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3" required>{{ old('content') }}</textarea>
                            @error('content')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="comment_user_id" class="form-label">Comment as:</label>
                            <select id="comment_user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                <option value="">Select a user</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
{{--@endsection--}}
