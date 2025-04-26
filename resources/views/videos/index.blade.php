@extends('layouts.app')

@section('content')
<div class="container"> 
    <h1>Videos</h1>
    <a href="{{ route('videos.create') }}" class="btn btn-primary mb-3">Add Video</a>
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
            @forelse ($videos as $video)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $video->headingTitle }}</td>
                    <td>{{ $video->category->name }}</td>
                    <td>{{ $video->created_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('videos.show', $video->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('videos.destroy', $video->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No videos available.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    </div>
@endsection