<?php

namespace Algad\Photography\Components;

use Illuminate\Support\Facades\File;
use Algad\Photography\Components\AbstractAlbum;

class AlbumList extends AbstractAlbum
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
            ],
            'view' => [
                'title' => 'View',
                'default' => 'default',
                'type' => 'dropdown',
                'options' => [
                    'default' => 'default',
                ],
            ],
        ];
    }

    private function getAlbumsFolderLocation()
    {
        return $this->getProperty('albums_folder');
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

    public function onRender()
    {
        return $this->renderPartial('@' . $this->property('view'));
    }

    public function onRun()
    {
        if ($this->property('view') == 'default')
        {
            $this->addCss('/plugins/algad/photography/assets/vendor/animate/animate.css');
            $this->addCss('/plugins/algad/photography/assets/vendor/animate/set.css');
            $this->addCss('/plugins/algad/photography/assets/css/albumList.css');
        }
    }

}
