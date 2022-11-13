<?php

namespace core\admin\controllers;


use core\base\settings\Settings;

class ShowController extends BaseAdmin
{



    protected function inputData($parameters = false) {

        $this->init();

        $data = '';

        $this->typeOfPage = 'show';

        if(!empty($parameters) && $parameters[0] !== 'home') {

            $this->typeOfPage = $parameters[0];

            $nameMethod = 'show' . ucfirst($this->typeOfPage);

            array_shift($parameters);

            $this->parameters = $parameters;

            $data = $this->$nameMethod();

        }

        return $data;

    }


    protected function showDatabase() {

        $data = '';

        if(empty($this->parameters)) {

            $data = $this->model->get('admin_roles_to_project_tables', [
                'where' => ['admin_roles_id' => $_SESSION['admin']['admin_roles_id']],
                'join' => [
                    'project_tables' => [
                        'fields' => ['name'],
                        'on' => ['admin_roles_to_project_tables.project_tables_id' => 'project_tables.id']
                    ]
                ]
            ]);


            foreach ($data as $key => $database) {

                $data[$key] = $database['name'];

            }

        } else {

            $this->table = $this->parameters[0];

            $this->checkAccess('db');

            $columns = $this->model->showColumns($this->table);

            $fields = ['id', 'name'];

            if(array_search('img', $columns)) {
                $fields[] = 'img';
            }

            if(array_search('menu_position', $columns)) {
                $data = $this->model->get($this->table, [
                    'fields' => $fields,
                    'order' => ['menu_position'],
                ]);
            } else {
                $data = $this->model->get($this->table, [
                    'fields' => $fields,
                ]);
            }


        }


        return $data;
    }

    protected function showTemplate() {

        $this->checkAccess('template');

        if(isset($this->parameters[0]) && !empty($this->parameters[0])) {

            $this->table = $this->parameters[0];

            $data = $this->model->get($this->table, [
                'fields' => ['id', 'name'],
                'order' => ['menu_position']
            ]);

            return $data;

        }

        $data = $this->model->showTables();

        $data = array_filter($data, function ($table) {

            if(preg_match('/^template_/', $table)) return true;

            return false;

        });

        $data = array_map(function ($table) {

            $arr = [];

            $arr['name'] = str_replace('template_', '', $table);
            $arr['name'] = str_replace('_', ' ', $arr['name']);
            $arr['refer'] = $table;

            return $arr;

        }, $data);

        return $data;

    }

}