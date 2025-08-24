{{--@extends('layouts.app')--}}

{{--@section('content')--}}
<x-app-layout>
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Lab 1 (Index & Destroy)</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-success">Create Post</a>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between">
            <span>ITI Blog</span>
            <span>All Posts</span>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Posted By</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image->path) }}" alt="{{ $post->title }}" class="img-thumbnail me-2" style="max-width: 50px; max-height: 50px;">
                            @endif
                            {{ $post->title }}
                        </td>
                        <td>{{ $post->user ? $post->user->name : 'Unknown' }}</td>
                        <td>{{ $post->created_at }}</td>
                        <td>
                            <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm">View</a>
                            @if(Auth::user()->is_admin || Auth::id() === $post->user_id)
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">Edit</a>
                            @endif
                            @if(Auth::user()->is_admin)
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(this)">Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(button) {
        if (confirm('Are you sure you want to delete this post? Click OK to confirm or Cancel to abort.')) {
            button.closest('form').submit();
        }
    }
</script>
</x-app-layout>
{{--@endsection--}}
