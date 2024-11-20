<?php

namespace App\Mappers;

class SpotifyMapper
{
  /**
   * Spotify APIレスポンスをマッピングして簡略化
   *
   * @param object $spotifyResponse
   * @return array
   */
  public static function mapToSimpleFormat($spotifyResponse)
  {
    return collect($spotifyResponse->tracks->items)->map(function ($item) {
      return [
        'id' => $item->id ?? null,
      ];
    })->toArray();
  }
}
