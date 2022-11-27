<?php

namespace core\user\models;

use core\base\controllers\SingleTon;
use core\base\models\BaseModel;

class Model extends BaseModel
{

    use SingleTon;

    public function getRubrics($rubrics) {

        $data = [];


        if(is_array($rubrics)) {

            $tables = array_map(function($table) {

                return 'template_' . $table;

            }, $rubrics);


            foreach ($tables as $key => $table) {

                $join = [];

                $columns = $this->showColumns($table);

                $foreignKeys = array_filter($columns, function($column) {

                    if(preg_match('/_id$/', $column)) return true;

                    return false;

                });

                if(!empty($foreignKeys)) {

                    foreach ($foreignKeys as $foreignKey) {

                        $join_table = preg_replace('/_id$/', '', $foreignKey);

                        $join[$join_table] = [
                            'on' => ["$join_table.id" => "$table.$foreignKey"],
                            'concat' => false,
                        ];

                    }

                }

                $data[$rubrics[$key]] = $this->get($table, [
                    'order' => ['menu_position'],
                    'join' => $join,
                ]);

            }

        } else {

            $join = [];

            $columns = $this->showColumns($rubrics);

            $foreignKeys = array_filter($columns, function($column) {

                if(preg_match('/_id$/', $column)) return true;

                return false;

            });

            if(!empty($foreignKeys)) {

                foreach ($foreignKeys as $foreignKey) {

                    $join_table = preg_replace('/_id$/', '', $foreignKey);

                    $join[$join_table] = [
                        'on' => ["$join_table.id" => "$rubrics.$foreignKey"],
                        'concat' => false,
                    ];

                }

            }

            $data[$rubrics] = $this->get('template_' . $rubrics, [
                'order' => ['menu_position'],
                'join' => $join
            ]);

        }


        return $data;
    }

    public function getEstimateOfProduct($products) {

        $data = [];

        if(is_array($products)) {

        } else {



        }

    }

    public function getBestSellerTabs() {

        $tabs = [];

        $tabs['menu'] = $this->getRubrics(['best_seller_tabs'])['best_seller_tabs'];

        array_unshift($tabs['menu'], ['name' => 'all']);



        foreach ($tabs['menu'] as $type_product) {

            $where = $type_product['name'] === 'all' ? [] : ['type_id' => $type_product['type_id']];

            $tabs['bodies'][$type_product['name']] = $this->get('products', [
                'fields' => ['name', 'img', 'price', 'discount', 'alias', 'rating', 'percentage_discount'],
                'where' => $where,
                'order' => ['quantity_purchases'],
                'order_direction' => ['DESC'],
                'limit' => 8
            ]);

        }

        return $tabs;

    }

}