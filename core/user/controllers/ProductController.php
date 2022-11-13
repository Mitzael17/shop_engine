<?php

namespace core\user\controllers;

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

        return $data;

    }

    protected function findFilters(&$data, $id) {

        $query = "SELECT products_to_filters.*, f1.*, f2.name as filter_name FROM products_to_filters LEFT JOIN filters as f1 ON f1.id=products_to_filters.filters_id LEFT JOIN filters as f2 ON f1.filters_id=f2.id WHERE products_to_filters.products_id=$id";

        $filters = $this->model->query($query);

        if(!empty($filters)) {

            $data['product']['filters'] = [];

            foreach ($filters as $filter) {

                if(!array_key_exists($filter['filter_name'], $data['product']['filters'])) {

                    $data['product']['filters'][$filter['filter_name']] = [];

                }

                $data['product']['filters'][$filter['filter_name']][] = $filter['name'];

            }

        }

    }

    protected function makeReview() {

        $a=1;

    }

}