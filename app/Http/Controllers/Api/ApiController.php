<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
class ApiController extends Controller
{
    /**
     * Returns a list of videos with their playlists if any.
     *
     * @return JsonResponse
     */
    public function getVideos(): JsonResponse
    {
        $videos = Video::with('playlists')->get();

        $formattedVideos = $videos->map(function ($video) {
            return [
                'id' => $video->id,
                'category' => $video->category ? $video->category->name : null,
                //'category_id' => $video->category_id,
                'uploadedDate' => ($video->uploadedDate instanceof \DateTimeInterface) ? $video->uploadedDate->format('Y-m-d') : null,
                'uploadedDateVirtual' => ($video->uploadedDate instanceof \DateTimeInterface) ? Carbon::parse($video->uploadedDate)->diffForHumans()  : null,
                'lengthHours' => $video->lengthHours,
                'headingTitle' => $video->headingTitle,
                'video' => $video->video,
                'targetAudience' => $video->targetAudience,
                'comment' => $video->comment,
                'Author' => $video->Author,
                'References' => $video->References,
                'uploaded_by' => $video->uploaded_by,
                'thumbnail' => $video->thumbnail,
               'size' => $video->size ? round($video->size / (1024 * 1024), 2) : null, // Convert bytes to MB and round to 2 decimal places
                'created_at' => $video->created_at,
                'updated_at' => $video->updated_at,
                'playlists' => $video->playlists->map(function ($playlist) {
                    return [
                        'id' => $playlist->id,
                        'name' => $playlist->name,
                        'description' => $playlist->description,
                        'created_at' => $playlist->created_at,
                        'updated_at' => $playlist->updated_at,
                    ];
                }),
            ];
        });

        return response()->json($formattedVideos);
    }

    /**
     * Returns a list of documents.
     *
     * @return JsonResponse
     */
    public function getDocuments(): JsonResponse
    {
        $documents = Document::all();

        $formattedDocuments = $documents->map(function ($document) {
            return [
                'id' => $document->id,
                'category_id' => $document->category_id,
                'category' => $document->category ? $document->category->name : null,
                //'uploadedDate' => ($document->uploadedDate instanceof \DateTimeInterface) ? $document->uploadedDate->format('Y-m-d') : null,
                'uploadedDate' => ($document->uploadedDate instanceof \DateTimeInterface) ? $document->uploadedDate->format('Y-m-d') : null,
                'uploadedDateVirtual' => ($document->uploadedDate instanceof \DateTimeInterface) ? Carbon::parse($document->uploadedDate)->diffForHumans()  : null,
                'headingTitle' => $document->headingTitle,
                'document' => $document->document,
                'targetAudience' => $document->targetAudience,
                'comment' => $document->comment,
                'Author' => $document->Author,
                'References' => $document->References,
                'uploaded_by' => $document->uploaded_by,
                'thumbnail' => $document->thumbnail,
                'document_size' => $document->document_size,
                'created_at' => $document->created_at,
                'updated_at' => $document->updated_at,
            ];
        });

        return response()->json($formattedDocuments);
    }

    /**
     * Returns a list of posts.
     *
     * @return JsonResponse
     */
    public function getPosts(): JsonResponse
    {
        $posts = Post::all();

        $formattedPosts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'category_id' => $post->category_id,
                'uploadedDate' => ($post->uploadedDate instanceof \DateTimeInterface) ? $post->uploadedDate->format('Y-m-d') : null,
                'headingTitle' => $post->headingTitle,
                'image' => $post->image,
                'description' => $post->description,
                'targetAudience' => $post->targetAudience,
                'comment' => $post->comment,
                'Author' => $post->Author,
                'References' => $post->References,
                'uploaded_by' => $post->uploaded_by,
                'thumbnail' => $post->thumbnail,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ];
        });

        return response()->json($formattedPosts);
    }
}