@extends('layouts.app')

@section('content')
<div class="container"> 
    <h1>Edit Document</h1>
    <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <ul class="nav nav-tabs mb-3" id="documentTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                    <i class="fas fa-info-circle me-2"></i> General
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="additional-info-tab" data-bs-toggle="tab" href="#additional-info" role="tab" aria-controls="additional-info" aria-selected="false">
                    <i class="fas fa-plus-circle me-2"></i> Additional Info
                </a>
            </li>
        </ul>
        <div class="tab-content" id="documentTabsContent">
            <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <div class="mb-3">
                    <label for="category_id" class="form-label"><i class="fas fa-folder-open me-2"></i> Category</label>
                    <select class="form-control select2" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $document->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="headingTitle" class="form-label"><i class="fas fa-heading me-2"></i> Title</label>
                    <input type="text" class="form-control" id="headingTitle" name="headingTitle" value="{{ $document->headingTitle }}">
                </div>
                <div class="mb-3">
                    <label for="document" class="form-label"><i class="fas fa-file-pdf me-2"></i> Document (PDF)</label>
                    <input type="file" class="form-control" id="document" name="document" accept="application/pdf">
                    @if ($document->document)
                        <small class="form-text text-muted">Current document: {{ basename($document->document) }}</small>
                    @endif
                </div>
            </div>

            <div class="tab-pane fade" id="additional-info" role="tabpanel" aria-labelledby="additional-info-tab">
                <div class="mb-3">
                    <label for="thumbnail" class="form-label"><i class="fas fa-image me-2"></i> Thumbnail</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                    @if ($document->thumbnail)
                        <img src="{{ asset('storage/' . $document->thumbnail) }}" alt="Thumbnail" width="100"class="img-thumbnail mt-2">
                    @endif
                </div>
                <div class="mb-3">
                    <label for="targetAudience" class="form-label"><i class="fas fa-users me-2"></i> Target Audience</label>
                    <input type="text" class="form-control" id="targetAudience" name="targetAudience" value="{{ $document->targetAudience }}">
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label"><i class="fas fa-comment-dots me-2"></i> Comments</label>
                    <textarea class="form-control" id="comment" name="comment">{{ $document->comment }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="Author" class="form-label"><i class="fas fa-user-pen me-2"></i> Author</label>
                    <input type="text" class="form-control" id="Author" name="Author" value="{{ $document->Author }}">
                </div>
                <div class="mb-3">
                    <label for="References" class="form-label"><i class="fas fa-link me-2"></i> References</label>
                    <input type="text" class="form-control" id="References" name="References" value="{{ $document->References }}">
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Update</button>
        <a href="{{ route('documents.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Cancel</a>
    </form>
    </div>
@endsection