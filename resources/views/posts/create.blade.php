{{--@extends('layouts.app')--}}

{{--@section('content')--}}
<x-app-layout>
<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Create New Post</h1>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white">
            <span>New Post</span>
        </div>
        <div class="card-body">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label">Description:</label>
                    <textarea id="body" name="body" class="form-control @error('body') is-invalid @enderror" rows="5" required>{{ old('body') }}</textarea>
                    @error('body')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Post Creator:</label>
                    <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                        <option value="">Select a user</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Post Image:</label>
                    <input type="file" id="image" name="image" class="form-control @error('image') is-invalid @enderror" accept=".jpg,.png">
                    <small class="text-muted">Only JPG and PNG files are allowed (max 2MB)</small>
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div id="imagePreview" class="mt-2" style="display: none;">
                        <img id="previewImg" src="#" alt="Image Preview" style="max-width: 300px; max-height: 200px;" class="img-thumbnail">
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Create</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const preview = document.getElementById('imagePreview');
        const previewImg = document.getElementById('previewImg');
        const file = event.target.files[0];
        
        if (file) {
            previewImg.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });
</script>
</x-app-layout>
{{--@endsection--}}
