<?php

namespace core\base\settings;

use core\base\controllers\SingleTon;
use core\base\models\BaseModel;

class Settings
{

    use SingleTon;


    private $routes = [
        'admin' => [
            'alias' => 'admin',
            'path' => 'core/admin/controllers/',
            'hrUrl' => false,
        ],
        'user' => [
            'path' => 'core/user/controllers/',
            'hrUrl' => true,
        ],
        'default' => [
            'controller' => 'IndexController',
            'inputMethod' => 'inputData',
            'outputMethod' => 'outputData'
        ]
    ];

    private $filterTypeView = [
        'size' => 'select',
        'color' => 'radioColor',
    ];

    private $templateArr = [
        'input' => ['name', 'discount', 'price', 'template' => '/_position$/i', 'priority', 'alias', 'alias_text', 'quantity'],
        'password' => ['password'],
        'textarea' => ['keywords', 'content', 'text'],
        'radio' => ['visible', 'allowed_manage_admins', 'allowed_template', 'allowed_off_site'],
        'checkbox' => ['filters', 'test', 'project_tables'],
        'gallery_img' => ['gallery_img', 'slider_img'],
        'img' => ['img', 'avatar'],
        'list' => ['template' => '/_id$/i'],
        'search' => ['products_id']
    ];


    private $positionsBlocks = [
        'right' => ['gallery_img', 'img', 'slider_img', 'avatar'],
        'full' => ['content']
    ];



    public function get($property) {

        return $this->$property;

    }

}