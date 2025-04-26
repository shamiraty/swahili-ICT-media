<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::with('category')->get();
        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('documents.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'headingTitle' => 'nullable|string|max:255',
            'document' => 'required|file|mimes:pdf|max:10240', // Max 10MB
            'targetAudience' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'Author' => 'nullable|string|max:255',
            'References' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $documentPath = $request->file('document')->store('documents', 'public');
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $document = Document::create([
            'category_id' => $request->category_id,
            'headingTitle' => $request->headingTitle,
            'document' => $documentPath,
            'targetAudience' => $request->targetAudience,
            'comment' => $request->comment,
            'Author' => $request->Author,
            'References' => $request->References,
            'thumbnail' => $thumbnailPath,
            'document_size' => $request->file('document')->getSize(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Document imepakiwa.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $categories = Category::all();
        return view('documents.edit', compact('document', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'headingTitle' => 'nullable|string|max:255',
            'document' => 'nullable|file|mimes:pdf|max:10240', // Max 10MB
            'targetAudience' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'Author' => 'nullable|string|max:255',
            'References' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('document')) {
            Storage::disk('public')->delete($document->document);
            $document->document = $request->file('document')->store('documents', 'public');
            $document->document_size = $request->file('document')->getSize();
        }

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($document->thumbnail);
            $document->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $document->update($request->except(['document', 'thumbnail']));

        return redirect()->route('documents.index')->with('success', 'Document imebadilishwa.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->document);
        Storage::disk('public')->delete($document->thumbnail);
        $document->delete();
        return redirect()->route('documents.index')->with('success', 'Document imefutwa.');
    }
}