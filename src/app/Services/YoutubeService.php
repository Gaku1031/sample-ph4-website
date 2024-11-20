<?php

namespace App\Services;

use Google_Client;
use Google_Service_YouTube;

class YouTubeService
{
  private $youtubeService;

  public function __construct()
  {
    $client = new Google_Client();
    $client->setDeveloperKey(env('GOOGLE_DEVELOPER_KEY'));
    $this->youtubeService = new Google_Service_YouTube($client);
  }

  public function searchVideos(string $query, int $maxResults)
  {
    return $this->youtubeService->search->listSearch('id, snippet', [
      'q' => $query,
      'maxResults' => $maxResults,
      'type' => 'video',
    ]);
  }
}
