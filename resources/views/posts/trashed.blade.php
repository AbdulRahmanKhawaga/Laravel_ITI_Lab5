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
        <h1>Trashed Posts</h1>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
    </div>

    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between">
            <span>ITI Blog</span>
            <span>Trashed Posts</span>
        </div>
        <div class="card-body">
            @if($posts->count() > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Posted By</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->user ? $post->user->name : 'Unknown' }}</td>
                            <td>{{ $post->deleted_at }}</td>
                            <td>
                                <form action="{{ route('posts.restore', $post->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                </form>
                                <form action="{{ route('posts.force-delete', $post->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmForceDelete(this)">Force Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            @else
                <p class="text-center">No trashed posts found.</p>
            @endif
        </div>
    </div>
</div>

<script>
    function confirmForceDelete(button) {
        if (confirm('Are you sure you want to permanently delete this post? This action cannot be undone.')) {
            button.closest('form').submit();
        }
    }
</script>
</x-app-layout>
{{--@endsection--}}
