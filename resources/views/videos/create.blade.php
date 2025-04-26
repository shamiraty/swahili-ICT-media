@extends('layouts.app')

@section('content')
<div class="container">
<h1>Add Video</h1>
<ul class="nav nav-tabs mb-4" id="videoTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab">
            <i class="fas fa-info-circle"></i> Basic Information
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab">
            <i class="fas fa-file-upload"></i> Files
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="extra-tab" data-bs-toggle="tab" data-bs-target="#extra" type="button" role="tab">
            <i class="fas fa-align-left"></i> Extra Details
        </button>
    </li>
</ul>

<form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="tab-content" id="videoTabContent">
        <div class="tab-pane fade show active" id="basic" role="tabpanel">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-control select2" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="headingTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="headingTitle" name="headingTitle">
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="files" role="tabpanel">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="video" class="form-label">Video File</label>
                    <input type="file" class="form-control" id="video" name="video" accept="video/*" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="playlists" class="form-label">Playlists</label>
                    <select class="form-control select2" id="playlists" name="playlists[]" multiple>
                        @foreach ($playlists as $playlist)
                            <option value="{{ $playlist->id }}">{{ $playlist->name }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">You can select multiple playlists.</small>
                </div>
                <div class="col-md-6">
                    <label for="thumbnail" class="form-label">Thumbnail Image</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="extra" role="tabpanel">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="targetAudience" class="form-label">Target Audience</label>
                    <input type="text" class="form-control" id="targetAudience" name="targetAudience">
                </div>
                <div class="col-md-6">
                    <label for="Author" class="form-label">Author</label>
                    <input type="text" class="form-control" id="Author" name="Author">
                </div>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Comments</label>
                <textarea class="form-control" id="comment" name="comment"></textarea>
            </div>
            <div class="mb-3">
                <label for="References" class="form-label">References</label>
                <input type="text" class="form-control" id="References" name="References">
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save"></i> Save</button>
    <a href="{{ route('videos.index') }}" class="btn btn-secondary mt-3"><i class="fas fa-times-circle"></i> Cancel</a>
</form>

@if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    </div>
@endif
@endsection