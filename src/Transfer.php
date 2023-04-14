<?php

declare(strict_types=1);

namespace LeXxyIT\YoutubeTransfer;

use Exception;
//use LeXxyIT\EnvParser;

class Transfer
{
    public $video_id = null;
    private $binary = null;
    private $youtube_response = [];

    public function __construct(string $video_id)
    {
        $this->video_id = $video_id;
        return $this->video_id;

        /*EnvParser::load(__DIR__ . '/../.env');

        $this->getBinary();
        $this->getVideoData();
        $this->downloadVideo();*/
    }

    private function getBinary()
    {
        if (!$this->binary = exec('which python')) {
            $this->binary = exec('which python3');
        }
    }

    private function getVideoData()
    {
        // Preparing API
        $client = new Google\Client();
        $client->setApplicationName('Get video data');
        $client->setDeveloperKey($_ENV['YOUTUBE_API_KEY']);

        // Get data
        $service = new Google_Service_YouTube($client);
        $response = $service->videos->listVideos('snippet', ['id' => $this->video_id]);
        $this->youtube_response = $response;
    }

    private function downloadVideo()
    {
        // Check if result exists
        if (isset($response[0]['snippet'])) {
            // Preparing data
            $video = [
                'title' => $response[0]['snippet']['title'],
                'description' => $response[0]['snippet']['description'],
                'tags' => $response[0]['snippet']['tags'],
            ];

            // Download video
            exec($this->binary . ' ' . __DIR__ . '/../libs/bin/pytube https://www.youtube.com/watch?v=' . $this->video_id);

            // Preparing data for replacing file
            $file_old = glob(__DIR__ . '/../*.mp4')[0];
            $path_new = __DIR__ . '/../media/' . $this->video_id;
            $file_new = $path_new . '/' . $video['title'] . '.mp4';

            // Replace file
            if (is_file($file_old)) {
                if (!is_dir($path_new)) mkdir($path_new, 0755, true);
                rename($file_old, $file_new);
                file_put_contents($path_new . '/meta.txt', json_encode($video));
            } else {
                throw new Exception('File not found: ' . $file_old);
            }
        }
    }

    public function toVK()
    {
        return true;
    }

    public function toRuTube()
    {
        return true;
    }
}
