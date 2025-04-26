@extends('layouts.app')

@section('content')
<div class="container"> 
    <h1>Posts</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Add Post</a>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" id="table">
            <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Category</th>
                <th>Uploaded</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($posts as $post)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $post->headingTitle }}</td>
                    <td>{{ $post->category->name }}</td>
                    <td>{{ $post->created_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No posts available.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    </div>
@endsection