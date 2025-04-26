@extends('layouts.app')

@section('content')
<div class="container"> 
    <h1>Edit Video</h1>
    <ul class="nav nav-tabs mb-4" id="videoTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="basic-tab" data-bs-toggle="tab" href="#basic" role="tab">
                <i class="fas fa-info-circle"></i> Basic
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="media-tab" data-bs-toggle="tab" href="#media" role="tab">
                <i class="fas fa-photo-video"></i> Media
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="extra-tab" data-bs-toggle="tab" href="#extra" role="tab">
                <i class="fas fa-book"></i> More Details
            </a>
        </li>
    </ul>

    <form action="{{ route('videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="tab-content" id="videoTabContent">
            {{-- Tab 1: Basic --}}
            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control select2" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $video->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="headingTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="headingTitle" name="headingTitle" value="{{ $video->headingTitle }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="playlists" class="form-label">Playlists</label>
                        <select class="form-control select2" id="playlists" name="playlists[]" multiple>
                            @foreach ($playlists as $playlist)
                                <option value="{{ $playlist->id }}" {{ $video->playlists->contains($playlist->id) ? 'selected' : '' }}>
                                    {{ $playlist->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">You can select or remove playlists.</small>
                    </div>
                </div>
            </div>

            {{-- Tab 2: Media --}}
            <div class="tab-pane fade" id="media" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="video" class="form-label">Video</label>
                        <input type="file" class="form-control" id="video" name="video" accept="video/*">
                        @if ($video->video)
                            <small class="form-text text-muted">Current video: {{ basename($video->video) }}</small>
                        @endif
                        <div class="position-relative rounded-3 overflow-hidden mb-3" style="aspect-ratio: 16/9;">
                                @if ($video->video)
                                    @if ($video->thumbnail)
                                        <div id="thumbnail-container"
                                             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                                                    background-image: url('{{ asset('storage/' . $video->thumbnail) }}');
                                                    background-size: cover; background-position: center; cursor: pointer;
                                                    display: flex; justify-content: center; align-items: center;
                                                    transition: opacity 0.3s ease-in-out;"
                                             onclick="playVideo(this)">
                                            <i class="btn btn-danger btn-lg rounded-circle shadow">
                                                <i class="fas fa-play fa-2x"></i>
                                            </i>
                                        </div>
                                        <video id="myVideo"
                                               src="{{ asset('storage/' . $video->video) }}"
                                               style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: none;"
                                               controls muted class="w-100 h-100"></video>
                                    @else
                                        <video src="{{ asset('storage/' . $video->video) }}" class="w-100 h-100 rounded-3" controls muted></video>
                                    @endif
                                @else
                                    <div class="alert alert-warning mt-3">Video not available.</div>
                                @endif
                            </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="thumbnail" class="form-label">Thumbnail</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                        @if ($video->thumbnail)
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Thumbnail" width="200" class="mt-2 img-thumbnail">
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tab 3: Extra Info --}}
            <div class="tab-pane fade" id="extra" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="targetAudience" class="form-label">Target Audience</label>
                        <input type="text" class="form-control" id="targetAudience" name="targetAudience" value="{{ $video->targetAudience }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="Author" class="form-label">Author</label>
                        <input type="text" class="form-control" id="Author" name="Author" value="{{ $video->Author }}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Comments</label>
                    <textarea class="form-control" id="comment" name="comment">{{ $video->comment }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="References" class="form-label">References</label>
                    <input type="text" class="form-control" id="References" name="References" value="{{ $video->References }}">
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
            <a href="{{ route('videos.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancel
            </a>
        </div>
    </form>
    </div>
    {{-- Script --}}
<script>
    function playVideo(thumbnailElement) {
        const videoElement = document.getElementById('myVideo');
        const thumbnailContainer = document.getElementById('thumbnail-container');
        if (thumbnailContainer) {
            thumbnailContainer.style.display = 'none';
        }
        videoElement.style.display = 'block';
        videoElement.play().catch(error => {
            console.error("Video could not be played:", error);
        });
    }
</script>

@endsection