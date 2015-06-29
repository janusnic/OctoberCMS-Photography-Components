<?php

namespace Algad\Photography\Components;

use Cms\Classes\ComponentBase;

class Comment extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name' => 'Comment',
        ];
    }

    public function defineProperties()
    {
        return [
            'photo' => [
                'title' => 'Photo',
                'default' => 'storage/app/media',
                'type' => 'string'
            ],
            'title' => [
                'title' => 'Title',
                'type' => 'string'
            ],
            'text' => [
                'title' => 'Text',
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

    public function onRender()
    {
        return $this->renderPartial('@' . $this->property('view'));
    }

    public function onRun()
    {
        
    }

}
