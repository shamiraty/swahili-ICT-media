@extends('layouts.app')

@section('content')
<div class="container"> 
    <h1>{{ $category->name }}</h1>
    <p><strong>Tarehe Iliyoundwa:</strong> {{ $category->created_at->format('Y-m-d H:i:s') }}</p>
    @if ($category->date)
        <p><strong>Tarehe:</strong> {{ $category->date }}</p>
    @endif
    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Hariri</a>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Rudi</a>
    </div>
@endsection