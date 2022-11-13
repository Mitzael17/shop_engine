<?php

namespace core\admin\controllers;

use core\base\exceptions\RouteException;
use core\base\models\Crypt;
use core\base\settings\Settings;

class AddController extends BaseAdmin
{

    protected function inputData($parameters) {

        $this->init();

        if(empty($parameters)) throw new RouteException('Отсутсвуют параметры для AddController');

        if(!empty($_POST)) {

            $this->table = $parameters[0];

            if($this->table === 'admins') {

                $this->checkAccess('admin');

                if(!$this->checkAdminName($_POST['name'])) {

                    $res = [
                        'message' => 'The name has already declared'
                    ];

                    $res = json_encode($res);

                    exit($res);
                }

            } elseif(preg_match('/^template_/', $this->table)) {

                $this->checkAccess('template');

            } else {

                $this->checkAccess('db');

            }


            $dir = $this->table === 'admins' ? 'adminImg/' : '';

            $fields = [];

            $manyToManyFields = [];

            $positions_fields = [];

            $files = $this->checkFile(false, $dir);

            if($files) {

                $columns = [];

                foreach ($files as $name_field => $item) {

                    if(array_search($name_field, $columns)) continue;

                    $columns[] = $name_field;

                }

                foreach ($files as $name_field => $file)  {

                    if(is_array($file)) {

                        $string_files = '';

                        foreach ($file as $key => $value) {

                            $string_files .= ',' . $value ;

                        }

                        $fields[$name_field] = $string_files;

                        $fields[$name_field] = trim($fields[$name_field], ',');



                    } else {
                        $fields[$name_field] = $file;
                    }


                }
            }

            foreach ($_POST as $key => $value) {
                if(!empty($value) || $value === '0') {
                    if(preg_match('/_to_/', $key)) {
                        $manyToManyFields[$key] = $value;
                    } elseif(preg_match('/_position$/i', $key)) {

                        if(!empty($value)) {
                            $positions_fields[] = $key;
                            $fields[$key] = $value;
                        }

                    } elseif($key === 'password') {

                        $fields[$key] = Crypt::instance()->encrypt($value);

                    } elseif($key === 'discount') {

                        $fields[$key] = $value;
                        $fields['percentage_discount'] = $this->getDiscountInPercentage($_POST['price'], $value);

                    } else {
                        $fields[$key] = $value === 'root' ? '' : $value;
                    }
                }

            }


            if(!empty($positions_fields)) {

                foreach ($positions_fields as $field) {

                    $this->model->increasePosition($this->table, $field,  "WHERE $field >= " . $fields[$field]);

                }

            }

            $id = $this->model->add($this->table, [
                'fields' => $fields,
                'return_id' => true
            ]);

            if(!empty($manyToManyFields)) {
                foreach ($manyToManyFields as $table => $data) {
                    $this->model->insertManyToMany($table, $id, $data );
                }
            }

            $this->writeAdminLog( [
                'controller' => 'add',
                'table' => $this->table,
                'id' => $id,
                'alias' => "edit/database/$this->table/$id"
            ] );

            $res = [
                'redirect' => $this->table === 'admins' ? PATH . $this->routes['alias'] . '/admins' : PATH . $this->routes['alias'] . "/edit/database/$this->table/$id",
            ];

            $res = json_encode($res);

            exit($res);


        }

        $this->typeOfPage = $parameters[0];

        unset($parameters[0]);

        $this->parameters = $parameters;

        $nameMethod = 'add' . ucfirst($this->typeOfPage);

        $this->typeOfPage = 'edit' . $this->typeOfPage;

        return $this->$nameMethod();

    }


    protected function addDatabase() {

        $this->table = $this->parameters[1];

        if($this->table === 'admins') {

            $this->checkAccess('admins');


        } else {

            $this->checkAccess('db');

        }

        $data = $this->model->showInfoOfRecord($this->table);

        $templatesArr = $this->makeTemplateArr($data);

        $positionsBlocks = Settings::instance()->get('positionsBlocks');


        foreach ($templatesArr as $key => $template) {
            foreach ($template as $value) {

                if(array_search($value, $positionsBlocks['right']) !== false) {
                    $this->templates['right'][$value] = $key;
                } elseif (array_search($value, $positionsBlocks['full']) !== false) {
                    $this->templates['full'][$value] = $key;
                } else {
                    $this->templates['left'][$value] = $key;
                }


            }
        }

        return $data;

    }

    protected function addTemplate() {

        $this->checkAccess('template');

        $this->table = $this->parameters[1];

        $this->typeOfPage = 'editdatabase';

        $set = [
          'excluded' => [
              'foreignKeys' => [
                  0 => 'products_id'
              ]
          ]
        ];

        $data = $this->model->showInfoOfRecord($this->table, '' , $set);

        $templatesArr = $this->makeTemplateArr($data);

        $positionsBlocks = Settings::instance()->get('positionsBlocks');


        foreach ($templatesArr as $key => $template) {
            foreach ($template as $value) {

                if(array_search($value, $positionsBlocks['right']) !== false) {
                    $this->templates['right'][$value] = $key;
                } elseif (array_search($value, $positionsBlocks['full']) !== false) {
                    $this->templates['full'][$value] = $key;
                } else {
                    $this->templates['left'][$value] = $key;
                }


            }
        }

        return $data;

    }

}