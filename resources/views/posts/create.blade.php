@extends('layouts.app')

@section('content')
<div class="container"> 
    <h1>Add Post</h1>
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <ul class="nav nav-tabs" id="postTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1"
                        type="button" role="tab" aria-controls="tab1" aria-selected="true">Basic Details</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2"
                        type="button" role="tab" aria-controls="tab2" aria-selected="false">Image</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3"
                        type="button" role="tab" aria-controls="tab3" aria-selected="false">More Information</button>
            </li>
        </ul>

        <div class="tab-content p-3 border border-top-0" id="postTabsContent">
            <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-control select2" id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="headingTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="headingTitle" name="headingTitle">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
            </div>

            <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                </div>
                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Thumbnail</label>
                    <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                </div>
            </div>

            <div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                <div class="mb-3">
                    <label for="targetAudience" class="form-label">Target Audience</label>
                    <input type="text" class="form-control" id="targetAudience" name="targetAudience">
                </div>
                <div class="mb-3">
                    <label for="comment" class="form-label">Comments</label>
                    <textarea class="form-control" id="comment" name="comment"></textarea>
                </div>
                <div class="mb-3">
                    <label for="Author" class="form-label">Author</label>
                    <input type="text" class="form-control" id="Author" name="Author">
                </div>
                <div class="mb-3">
                    <label for="References" class="form-label">References</label>
                    <input type="text" class="form-control" id="References" name="References">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Save</button>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
    </div>
@endsection