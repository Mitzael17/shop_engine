<?php

namespace core\admin\controllers;

use core\base\controllers\BaseController;
use core\base\controllers\SingleTon;
use core\base\settings\Settings;

class IndexController extends BaseAdmin
{

    protected function inputData() {

        $redirect = PATH . Settings::instance()->get('routes')['admin']['alias'] . '/show';
        $this->redirect($redirect);
    }

}