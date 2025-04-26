@extends('layouts.app')

@section('content')
<div class="container"> 
    <h1>Edit Post</h1>
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <ul class="nav nav-tabs mb-3" id="postEditTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#infoTab" type="button" role="tab">
                    <i class="fas fa-info-circle me-2"></i> Post Info
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#imagesTab" type="button" role="tab">
                    <i class="fas fa-image me-2"></i> Images
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#detailsTab" type="button" role="tab">
                    <i class="fas fa-list-alt me-2"></i> Details
                </button>
            </li>
        </ul>

        <div class="tab-content" id="postEditTabContent">
            <div class="tab-pane fade show active" id="infoTab" role="tabpanel">
                <div class="mb-3">
                    <label for="category_id" class="form-label"><i class="fas fa-folder-open me-2"></i> Category</label>
                    <select class="form-control select2" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="headingTitle" class="form-label"><i class="fas fa-heading me-2"></i> Title</label>
                    <input type="text" class="form-control" id="headingTitle" name="headingTitle" value="{{ $post->headingTitle }}">
                </div>
            </div>

            <div class="tab-pane fade" id="imagesTab" role="tabpanel">
                <div class="mb-3">
                    <label for="image" class="form-label"><i class="fas fa-file-image me-2"></i> Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    @if ($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->headingTitle }}" class="img-thumbnail mt-2 mb-2" style="max-width: 300px;">
                        {{--<small class="form-text text-muted">Current image: {{ basename($post->image) }}</small>--}}
                    @endif
                </div>
                <div class="mb-3">
                    <label for="thumbnail" class="form-label"><i class="fas fa-image me-2"></i> Thumbnail</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                    @if ($post->thumbnail)
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail" width="200" class="img-thumbnail mt-2">
                    @endif
                </div>
            </div>

            <div class="tab-pane fade" id="detailsTab" role="tabpanel">
                <div class="mb-3">
                    <label for="description" class="form-label"><i class="fas fa-file-alt me-2"></i> Description</label>
                    <textarea class="form-control" id="description" name="description">{{ $post->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="targetAudience" class="form-label"><i class="fas fa-users me-2"></i> Target Audience</label>
                    <input type="text" class="form-control" id="targetAudience" name="targetAudience" value="{{ $post->targetAudience }}">
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label"><i class="fas fa-comment-dots me-2"></i> Comments</label>
                    <textarea class="form-control" id="comment" name="comment">{{ $post->comment }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="Author" class="form-label"><i class="fas fa-user-pen me-2"></i> Author</label>
                    <input type="text" class="form-control" id="Author" name="Author" value="{{ $post->Author }}">
                </div>
                <div class="mb-3">
                    <label for="References" class="form-label"><i class="fas fa-link me-2"></i> References</label>
                    <input type="text" class="form-control" id="References" name="References" value="{{ $post->References }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3"><i class="fas fa-save me-2"></i> Update</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3"><i class="fas fa-arrow-left me-2"></i> Cancel</a>
    </form>
    </div>
@endsection