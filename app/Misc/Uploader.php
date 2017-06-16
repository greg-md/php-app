<?php

namespace App\Misc;

use Greg\Support\Dir;
use Greg\Support\Image;
use Greg\Support\Str;

class Uploader
{
    private $rootPath;

    private $publicPath;

    public function __construct(string $rootPath, string $publicPath = '/')
    {
        $this->rootPath = $rootPath;

        $this->publicPath = $publicPath;
    }

    public function rootPath()
    {
        return $this->rootPath;
    }

    public function publicPath()
    {
        return $this->publicPath;
    }

    public function move(string $file, string $name = null)
    {
        return $this->exec('rename', $file, $name);
    }

    public function upload(string $file, string $name = null)
    {
        return $this->exec('copy', $file, $name);
    }

    public function moveUploaded(string $file, string $name = null)
    {
        return $this->exec('move_uploaded_file', $file, $name);
    }

    public function currentPathImages(array $types = [])
    {
        $images = [];

        foreach (glob($this->rootPath . $this->currentPath() . '/*.*') as $file) {
            if (Image::check($file, false) && (!$types or in_array(mime_content_type($file), $types))) {
                $images[] = Str::shift($file, $this->rootPath);
            }
        }

        return $images;
    }

    public function remove(string $file)
    {
        if ($realPath = realpath($this->rootPath . $file)) {
            if (!Str::startsWith($realPath, $this->rootPath)) {
                throw new \Exception('You don\'t have access to this file path.');
            }

            unlink($realPath);
        }

        return $this;
    }

    private function exec(string $function, string $file, string $name = null)
    {
        $name = $name ?: pathinfo($file, PATHINFO_BASENAME);

        $currentPath = $this->currentPath();

        Dir::make($this->rootPath . $currentPath, true);

        if ($function($file, $this->rootPath . $currentPath . '/' . $name) === false) {
            throw new \Exception('Source file cannot be modified.');
        }

        return $this->publicPath . $currentPath . '/' . $name;
    }

    private function currentPath()
    {
        return '/' . date('Y/m');
    }
}
