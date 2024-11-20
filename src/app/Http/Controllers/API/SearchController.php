<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mappers\SpotifyMapper;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $youtubeService;
    private $spotifyService;

    public function __construct(YouTubeService $youtubeService, SpotifyService $spotifyService)
    {
        $this->youtubeService = $youtubeService;
        $this->spotifyService = $spotifyService;
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'maxResults' => 'nullable|integer|min:1|max:50',
            'q' => 'required|string|max:255',
        ]);

        $limit = $validated['maxResults'] ?? 10;
        $q = $validated['q'];

        $youtubeResults = $this->youtubeService->searchVideos($q, $limit);
        $mappedYouTubeResults = YouTubeMapper::mapToSimpleFormat($youtubeResults);

        $spotifyResults = $this->spotifyService->searchTracks($q, $limit);
        $spotifyResults = SpotifyMapper::mapToSimpleFormat($spotifyResults);

        return response()->json([
            'youtubeResults' => $mappedYouTubeResults,
            'spotifyResults' => $spotifyResults,
        ]);
    }
}
