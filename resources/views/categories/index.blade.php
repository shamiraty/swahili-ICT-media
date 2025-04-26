@extends('layouts.app')

@section('content')
<div class="container"> 
    <h1>Kategoria</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Ongeza Kategoria</a>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover"id="table">
            <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Jina</th>
                <th>Tarehe Iliyoundwa</th>
                <th>Kitendo</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-info btn-sm">Ona</a>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">Hariri</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Una uhakika unataka kufuta?')">Futa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">Hakuna kategoria zilizopo.</td></tr>
            @endforelse
        </tbody>
    </table>
    </div>
@endsection