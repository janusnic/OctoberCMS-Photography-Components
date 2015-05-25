<?php

namespace Algad\Photography;

use System\Classes\PluginBase;
use Event;

/**
 * Algad Photography Plugin Information File.
 */
class Plugin extends PluginBase
{

    /**
     * Algad Photography plugin information.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Photography Components',
            'description' => 'Photography components',
            'author' => 'Alexandre GADIOU',
            'homepage' => 'http://alexandre-gadiou.appspot.com',
            'icon' => 'icon-camera'
        ];
    }

    /**
     * Add a tab 'Photography' in page settings
     *
     */
    public function register()
    {
        Event::listen('backend.form.extendFields', function($widget)
        {
            if (!$widget->model instanceof \Cms\Classes\Page)
                return;


            if ($widget->model->layout == 'album-list')
            {
                $widget->addFields([
                    'settings[albums_folder]' => [
                        'label' => 'Albums Folder',
                        'description' => 'Write the location where are stored your photo albums',
                        'tab' => 'Photography',
                        'default' => 'storage/app/media'
                    ]
                        ], 'primary');
            }
        });
    }

    public function registerComponents()
    {
        return [
            'Algad\Photography\Components\AlbumList' => 'album_list'
        ];
    }

}
