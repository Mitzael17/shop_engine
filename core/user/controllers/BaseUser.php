<?php

namespace core\user\controllers;

use core\base\controllers\BaseController;
use core\base\controllers\SingleTon;
use core\user\models\Model;

abstract class BaseUser extends BaseController
{

    protected $model;

    protected $header;
    protected $content;
    protected $footer;

    protected $typeOfPage;

    protected function init() {

        if(!$this->model) $this->model = Model::instance();

        $this->setStyleAndScripts();

    }

    protected function outputData($data = '') {

        $header = $this->render(USER_TEMPLATE, '/includes/header.php');
        $footer = $this->render(USER_TEMPLATE, '/includes/footer.php');
        $content = $this->render(USER_TEMPLATE,  '/' . $this->typeOfPage . '.php', $data);

        return compact('header', 'content', 'footer');

    }

    protected function getRating($id) {

        $query = "SELECT COUNT(*) as quantity, SUM(stars) as stars FROM reviews WHERE products_id=$id";

        $reviews = $this->model->query($query)[0];



        if($reviews['quantity'] == 0) {
            $reviews['rating'] = 0;
            return $reviews;
        }

        $reviews['rating'] = $reviews['stars'] / $reviews['quantity'];

        return $reviews;

    }

}