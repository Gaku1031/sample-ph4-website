<?php

namespace App\Mappers;

class YouTubeMapper
{
  /**
   * YouTube APIレスポンスをマッピングして簡略化
   *
   * @param object $youtubeResponse
   * @return array
   */
  public static function mapToSimpleFormat($youtubeResponse)
  {
    return collect($youtubeResponse->items)->map(function ($item) {
      return [
        'videoId' => $item->id->videoId ?? null, // 動画ID
        'title' => $item->snippet->title ?? null, // 動画タイトル
      ];
    })->filter(function ($video) {
      return $video['videoId'] !== null;
    })->toArray();
  }
}
