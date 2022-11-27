<?php

namespace core\user\controllers;

use core\base\settings\Settings;

class ProductController extends BaseUser
{


    protected function inputData($parameters) {

        if(!empty($_POST) && $parameters[0] === 'review') $this->makeReview();

        $this->typeOfPage = 'product';

        $this->titlePage = 'product';

        $this->init();

        $data['product'] = $this->model->get('products', [
            'where' => ['alias' => $parameters[0]],
            'join' => [
                'type' => [
                    'on' => ['products.type_id' => 'type.id'],
                    'fields' => ['name as category']
                ]
            ]
        ])[0];

        $id = $data['product']['id'];

        $data['product']['data_reviews'] = $this->getRating($id);

        $data['product']['slider_img'] = explode(',', $data['product']['slider_img']);

        if(empty($data['product']['slider_img'][0])) $data['product']['slider_img'] = null;

        $this->findFilters($data, $id);

        $data['bestSellerSlider'] = $this->model->getBestSellers($data['product']['type_id'], 4);

        return $data;

    }

    protected function findFilters(&$data, $id) {

        $filters = $this->model->getProductFilters($id);

        if(!empty($filters)) {

            $data['product']['filters'] = [];
            $FiltersTypeView = Settings::instance()->get('filterTypeView');

            foreach ($filters as $filter) {

                if(!array_key_exists($filter['filter_name'], $data['product']['filters'])) {

                    $data['product']['filters'][$filter['filter_name']] = [];

                }

                $data['product']['filters'][$filter['filter_name']][] = $filter['name'];

            }

            foreach ($data['product']['filters'] as $group_name => $group_filter) {

                unset($data['product']['filters'][$group_name]);

                $group_name = strtolower($group_name);

                $data['product']['filters'][$group_name] = [

                    'type' => $FiltersTypeView[$group_name],
                    'items' => $group_filter

                ];

            }

        }

    }

    protected function makeReview() {

        $a=1;

    }

}