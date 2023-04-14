<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$transfer = new LeXxyIT\YoutubeTransfer\Transfer('video_id');
print_r($transfer);
