@extends('layouts.app')

@section('content')
<div class="container mt-5"> 
    <h1>Add Category</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-3">
    <label for="name" class="form-label">Category Name(max 15)</label>
    <input type="text" class="form-control" id="name" name="name" maxlength="15" required>
</div>
        <div class="mb-3">
            <label for="date" class="form-label">Date (Optional)</label>
            <input type="date" class="form-control" id="date" name="date">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Ghairi</a>
    </form>
    </div>
@endsection