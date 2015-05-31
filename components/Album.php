<?php

namespace Algad\Photography\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\File;

class Album extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name' => 'Album',
            'description' => 'Photo album'
        ];
    }

    public function defineProperties()
    {
        return [
            'album_folder' => [
                'title' => 'Album folder',
                'description' => 'Album folder',
                'default' => 'storage/app/media',
                'type' => 'string'
            ]
        ];
    }

    private function getAlbumLocation()
    {
        return $this->property('album_folder');
    }

    public function getAlbumName()
    {
        $split = explode('/', $this->getAlbumLocation());
        $name = end($split);
        return $name;
    }

    public function getAlbumTitle()
    {
        $title = null;
        $albumPath = $this->getAlbumLocation();

        $titleFilePath = $albumPath . DIRECTORY_SEPARATOR . "title.txt";
        if (File::exists($titleFilePath))
        {
            $title = File::get($titleFilePath);
        }

        if (empty($title))
        {
            $title = $this->getAlbumName();
        }
        return $title;
    }

    public function getPhotoList()
    {
        $photos = null;

        $path = $this->getAlbumLocation();
        if (File::exists($path))
        {
            $photos = File::files($path);
        }
        return $photos;
    }

}
