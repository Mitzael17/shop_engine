<?php

namespace core\user\controllers;



class IndexController extends BaseUser
{

    protected function inputData() {

        $this->typeOfPage = 'index';

        $this->titlePage = 'Main page';

        $this->init();

        $data = [];

        $data['rubrics'] = $this->model->getRubrics(['main_slider', 'banner_commodities', 'features', 'news', 'feature_products', 'feature_products', 'main_banner']);

        return $data;

    }

}