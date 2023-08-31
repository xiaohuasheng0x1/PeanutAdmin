<?php


namespace App\Common\Event;

class UploadAfter
{
    public array $fileInfo;

    public function __construct(array $fileInfo)
    {
        $this->fileInfo = $fileInfo;
    }
}