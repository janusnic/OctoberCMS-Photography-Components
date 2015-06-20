<?php

namespace Algad\Photography\Components;

use Cms\Classes\ComponentBase;
use Illuminate\Support\Facades\File;
use Algad\Photography\Helpers\StringUtils;

abstract class AbstractAlbum extends ComponentBase
{

    public function getAlbumName($albumLocation)
    {
        $name = null;
        $split = explode('/', $albumLocation);
        $name = end($split);
        return $name;
    }

    public function getAlbumTitle($albumLocation)
    {
        $title = null;
        $titleFilePath = $albumLocation . DIRECTORY_SEPARATOR . "title.txt";
        if (File::exists($titleFilePath))
        {
            $title = File::get($titleFilePath);
        }

        if (empty($title))
        {
            $title = $this->getAlbumName($albumLocation);
        }
        return $title;
    }

    public function getAlbumComments($albumLocation)
    {
        $comments = null;
        $commentsFilePath = $albumLocation . DIRECTORY_SEPARATOR . "comments.txt";
        if (File::exists($commentsFilePath))
        {
            $comments = File::get($commentsFilePath);
        }


        return $comments;
    }

    public function getAlbumLogo($albumLocation)
    {
        $logo = null;
        $photos = $this->getAlbumPhotoList($albumLocation);
        foreach ($photos as $photo)
        {
            if (strpos(strtolower($photo), "/logo.") !== FALSE)
            {
                $logo = $photo;
            }
        }
        return $logo;
    }

    public function isAlbumList($location)
    {
        $directories = File::directories($location);

        if (sizeof($directories) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isAlbum($location)
    {
        return !$this->isAlbumList($location);
    }

    public function getEncodedURL($path)
    {
        $encodedURL = "";
        $split = explode('/', $path);
        foreach ($split as $s)
        {
            $encoded = rawurlencode($s);
            if ($encodedURL == "")
            {
                $encodedURL = $encoded;
            }
            else
            {
                $encodedURL = $encodedURL . DIRECTORY_SEPARATOR . $encoded;
            }
        }
        return $encodedURL;
    }

    public function getAlbumPhotoList($albumLocation)
    {
        $photos = array();
        if (File::exists($albumLocation))
        {
            $files = File::files($albumLocation);
            foreach ($files as $p)
            {
                $fhandle = finfo_open(FILEINFO_MIME);
                $mime_type = finfo_file($fhandle, $p);
                if (StringUtils::getInstance()->startsWith($mime_type, "image"))
                {
                    array_push($photos, $p);
                }
            }
        }
        return $photos;
    }

    public function getProperty($propertyName)
    {
        return $this->property($propertyName);
    }

}

?>
