@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Hariri Kategoria</h1>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Jina la Kategoria</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Tarehe (Si Lazima)</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $category->date }}">
        </div>
        <button type="submit" class="btn btn-primary">Sasisha</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Ghairi</a>
    </form>
    </div>
@endsection