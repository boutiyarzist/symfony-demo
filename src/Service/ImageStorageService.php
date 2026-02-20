<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageStorageService
{
    private $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function store(UploadedFile $file): string
    {
        $filename = uniqid() . '.' . $file->guessExtension();
        $file->move($this->targetDirectory, $filename);

        return $filename;
    }
}