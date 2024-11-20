<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyService
{
  private $accessToken;

  public function __construct()
  {
    $clientId = env('SPOTIFY_CLIENT_ID');
    $clientSecret = env('SPOTIFY_CLIENT_SECRET');

    $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
      'grant_type' => 'client_credentials',
      'client_id' => $clientId,
      'client_secret' => $clientSecret,
    ]);

    $data = $response->json();
    $this->accessToken = $data['access_token'];
  }

  public function searchTracks(string $query, int $limit)
  {
    $spotifyApi = new SpotifyWebAPI();
    $spotifyApi->setAccessToken($this->accessToken);

    return $spotifyApi->search($query, 'track', ['limit' => $limit]);
  }
}
