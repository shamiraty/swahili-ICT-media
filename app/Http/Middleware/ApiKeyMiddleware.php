<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'API key is missing.'], 401);
        }

        $apiKeyRecord = ApiKey::where('api_key', $apiKey)
            ->where('end_date', '>=', now()->toDateString())
            ->first();

        if (!$apiKeyRecord) {
            return response()->json(['error' => 'Invalid or expired API key.'], 401);
        }

        // Angalia kama status ni false
        if (!$apiKeyRecord->status) {
            return response()->json(['error' => 'API key is inactive.'], 401);
        }

        // Sasisha taarifa za matumizi
        $apiKeyRecord->last_used = now();
        $apiKeyRecord->number_of_requests++;

        // Ongeza kwenye historia ya matumizi
        $history = $apiKeyRecord->access_history ?? [];
        $history[] = ['accessed_at' => now()->toDateTimeString()]; // Hifadhi tarehe na saa
        $apiKeyRecord->access_history = $history;

        $apiKeyRecord->save();

        // Optionally, you can attach the API key record to the request for later use
        $request->attributes->add(['apiKey' => $apiKeyRecord]);

        return $next($request);
    }
}