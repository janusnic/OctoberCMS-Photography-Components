<?php

namespace Algad\Photography\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Theme;
use Illuminate\Support\Facades\File;

class AlbumList extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name' => 'Album list',
            'description' => 'Photos Albums list'
        ];
    }

    public function defineProperties()
    {
        return [
            'albums_folder' => [
                'title' => 'Albums folder',
                'description' => 'Folder where the albums are stored',
                'default' => 'storage/app/media',
                'type' => 'string'
            ]
        ];
    }

    public function getOptions()
    {
        return $this->getProperties();
    }

    private function getAlbumsFolderLocation()
    {

        return $this->getOptions()['albums_folder'];
    }

    public function getAlbumsList()
    {
        $directoryPath = $this->getAlbumsFolderLocation();
        $albums_list = null;
        if (File::exists($directoryPath))
        {
            $albums_list = File::directories($directoryPath);
        }
        return $albums_list;
    }

    public function getAlbumName($album)
    {
        $name = null;
        $split = explode('/', $album);
        $name = end($split);
        return $name;
    }

    public function getAlbumTitle($album)
    {
        $title = null;
        $titleFilePath = $album . DIRECTORY_SEPARATOR . "title.txt";
        if (File::exists($titleFilePath))
        {
            $title = File::get($titleFilePath);
        }

        if (empty($title))
        {
            $title = $this->getAlbumName($album);
        }
        return $title;
    }

    public function getAlbumLogo($album)
    {
        $logo = null;

        $photos = $this->getPhotoList($album);

        foreach ($photos as $photo)
        {
            if (strpos($photo, "/logo.") !== FALSE)
            {
                $logo = $photo;
            }
        }

        return $logo;
    }

    public function getAlbumLink($album)
    {
        $link = null;
        $link = str_replace("storage/app/media/", "", $album);
        return $link;
    }

    public function getPhotoList($album)
    {
        $photos = null;
        if (File::exists($album))
        {
            $photos = File::files($album);
        }
        return $photos;
    }

}
