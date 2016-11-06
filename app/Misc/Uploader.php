<?php

namespace App\Misc;

use Greg\Support\Dir;
use Greg\Support\Image;
use Greg\Support\Session;
use Greg\Support\Str;

class Uploader
{
    protected $path = null;

    protected $publicPath = '/upload';

    public function __construct($path, $publicPath)
    {
        $this->setPath($path);

        $this->setPublicPath($publicPath);
    }

    public function move($file, $name = null)
    {
        return $this->exec('rename', $file, $name);
    }

    public function upload($file, $name = null)
    {
        return $this->exec('copy', $file, $name);
    }

    public function moveUploaded($file, $name = null)
    {
        return $this->exec('move_uploaded_file', $file, $name);
    }

    protected function exec($function, $file, $name = null)
    {
        if (!$name) {
            $info = pathinfo($file);

            $name = $info['basename'];
        }

        $path = $this->getPath();

        $currentPath = $this->getPublicCurrentPath();

        Dir::fixRecursive($path . $currentPath);

        $newFile = $currentPath . '/' . $name;

        if ($function($file, $path . $newFile) === false) {
            throw new \Exception('Source file cannot be modified.');
        }

        return $newFile;
    }

    public function getCurrentPathImages($types = [])
    {
        $images = [];

        $path = $this->getPath();

        foreach (glob($path . $this->getPublicCurrentPath() . '/*.*') as $file) {
            if (Image::isFile($file) && (!$types or in_array(mime_content_type($file), $types))) {
                $images[] = Str::shift($file, $path);
            }
        }

        return $images;
    }

    public function remove($file)
    {
        $path = $this->getPath();

        if ($realPath = realpath($path . $file)) {
            if (!Str::startsWith($realPath, $path)) {
                throw new \Exception('You don\'t have access to this file path.');
            }

            unlink($realPath);
        }

        return $this;
    }

    public function getSessionTmpPath($sessionId = null)
    {
        if (!$sessionId) {
            $sessionId = Session::getId();
        }

        return '/upload/tmp/' . $sessionId;
    }

    public function getPublicCurrentPath()
    {
        return $this->getPublicPath() . '/' . date('Y/m');
    }

    public function setPath($path)
    {
        $this->path = (string) $path;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPublicPath($path)
    {
        $this->publicPath = (string) $path;

        return $this;
    }

    public function getPublicPath()
    {
        return $this->publicPath;
    }
}
