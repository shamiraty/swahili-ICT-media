@extends('layouts.app')

@section('content')
<div class="container"> 
    <h1>Documents</h1>
    <a href="{{ route('documents.create') }}" class="btn btn-primary mb-3"><i class="fas fa-plus-circle me-2"></i> Add Document</a>
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
                @forelse ($documents as $document)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $document->headingTitle }}</td>
                        <td>{{ $document->category->name }}</td>
                        <td>{{ $document->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('documents.show', $document->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye me-1"></i> View</a>
                            <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit me-1"></i> Edit</a>
                            <form action="{{ route('documents.destroy', $document->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')"><i class="fas fa-trash-alt me-1"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No documents available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
@endsection