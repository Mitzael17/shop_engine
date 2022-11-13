<?php

namespace core\admin\controllers;

use core\base\exceptions\RouteException;
use core\base\models\Crypt;
use core\base\settings\Settings;


class EditController extends BaseAdmin
{


    protected function inputData($parameters) {

        $this->init();

        if(empty($parameters)) throw new RouteException('Отсутсвуют параметры для EditController');

        if(!empty($_POST)) {

            $this->table = $parameters[0];

            if($this->table === 'admins' && $_POST['name'] !== $_SESSION['admin']['name'] && !$this->checkAdminName($_POST['name'])) {

                $res = [
                    'message' => 'The name has already declared'
                ];

                $res = json_encode($res);

                exit($res);
            }

            $response = [];

            $fields = [];


            $id = $parameters[1];

            $manyToManyFields = [];

            $positions_fields = [];

            $files = $this->checkFile($id);

            if($files || (isset($_POST['deletedFiles']) && !empty($_POST['deletedFiles']))) {

                $columns = [];

                if($files) {
                    foreach ($files as $name_field => $item) {

                        if(array_search($name_field, $columns)) continue;

                        $columns[] = $name_field;

                    }
                }

                if(isset($_POST['deletedFiles']) && !empty($_POST['deletedFiles'])) {
                    foreach ($_POST['deletedFiles'] as $name_field => $item) {

                        if(array_search($name_field, $columns) !== false) continue;

                        $columns[] = $name_field;

                    }
                }


                $data = $this->model->get($this->table, [
                    'fields' => $columns,
                    'where' => ['id' => $id],
                ])[0];

                if($files) {

                    foreach ($files as $name_field => $file)  {

                        if(is_array($file)) {

                            $string_files = '';

                            foreach ($file as $key => $value) {

                                $response['images'][$name_field][] = PATH . UPLOAD_DIR . $value;
                                $string_files .= ',' . $value ;

                            }

                            $fields[$name_field] = $data[$name_field] . $string_files;

                            $fields[$name_field] = trim($fields[$name_field], ',');



                        } else {
                            $response['images'][$name_field][] = PATH . UPLOAD_DIR . $file;
                            $fields[$name_field] = $file;
                        }


                    }

                }

                if(isset($_POST['deletedFiles']) && !empty($_POST['deletedFiles'])) {

                    foreach ($_POST['deletedFiles'] as $name_field => $file) {

                        $arr = [];

                        if(isset($fields[$name_field]) && !empty($fields[$name_field])) {

                            $arr = explode(',', $fields[$name_field]);

                            foreach ($file as $item) {

                                // $fields[$name_field] = preg_replace('/' . $item . ')/', '', $fields[$name_field], 1);
                                $index = array_search($item, $arr);

                                unset($arr[$index]);

                            }

                            $fields[$name_field] = implode( ',', $arr);

                        } else {
                            $arr = explode(',', $data[$name_field]);
                            foreach ($file as $item) {


                                //$fields[$name_field] = $data[$name_field] = preg_replace('/' . $item . '/', '', $data[$name_field], 1);

                                $index = array_search($item, $arr);
                                unset($arr[$index]);
                                $a=1;
                            }

                            $fields[$name_field] = implode( ',', $arr);


                        }

                    }

                }
            }

            foreach ($_POST as $key => $value) {
                if(!empty($value) || $value === '0') {
                    if(preg_match('/_to_/', $key)) {

                        $manyToManyFields[$key] = $value;

                    } elseif(preg_match('/_position$/i', $key)) {

                        $positions_fields[] = $key;
                        $fields[$key] = $value;

                    } elseif($key === 'password') {

                        $fields[$key] = Crypt::instance()->encrypt($value);

                    } elseif($key === 'discount') {

                        $fields[$key] = $value;
                        $fields['percentage_discount'] = $this->getDiscountInPercentage($_POST['price'], $value);

                    } else {
                        if($key === 'deletedFiles') continue;
                        $fields[$key] = $value === 'root' ? 'NULL' : $value;
                    }

                }

            }

            if(!empty($positions_fields)) {

                $record = $this->model->get($this->table, [
                    'fields' => $positions_fields,
                    'where' => ['id' => $id]
                ])[0];

                foreach ($record as $key => $value) {

                    if($value !== $fields[$key]) {

                        if($fields[$key] < $value) {

                            $this->model->increasePosition($this->table, $key, "WHERE $key >= $fields[$key] AND $key < $value");

                        } else {

                            $this->model->decreasePosition($this->table, $key, "WHERE $key <= $fields[$key] AND $key > $value");

                        }

                    }

                }

            }


            $this->model->edit($this->table, [
                'fields' => $fields,
                'where' => ['id' => $id]
            ]);


            if(!empty($manyToManyFields)) {
                foreach ($manyToManyFields as $table => $data) {
                    $this->model->insertManyToMany($table, $id, $data );
                }
            }

            if($this->table !== 'admins') {

                $this->writeAdminLog( [
                    'controller' => 'edit',
                    'table' => $this->table,
                    'id' => $id,
                    'alias' => "edit/database/$this->table/$id"
                ] );

            }


            $response['message'] = 'The data was successfully changed';
            $response = json_encode($response);

            exit($response);



        }

        $this->typeOfPage = $parameters[0];

        unset($parameters[0]);

        $this->parameters = $parameters;

        $nameMethod = 'edit' . ucfirst($this->typeOfPage);

        $this->typeOfPage = 'edit' . $this->typeOfPage;

        return $this->$nameMethod();

    }


    protected function editDatabase() {

        $this->table = $this->parameters[1];
        $id = $this->parameters[2];


        if($this->table === 'admins') {

            if($_SESSION['admin']['id'] !== $id) {

                $_SESSION['answer'] = 'You don\'t have permissions';

                $this->redirect();
            }

        } elseif(preg_match( '/^template_/', $this->table)) {

            $this->checkAccess('template');

        } else {

            $this->checkAccess('db');

        }

        $set = [
            'excluded' => [
                'foreignKeys' => [
                    0 => 'products_id'
                ]
            ]
        ];

        $data = $this->model->showInfoOfRecord($this->table, $id, $set);

        $templatesArr =  $this->makeTemplateArr($data);

        if(array_key_exists('password', $data)) {

            $data['password'] = Crypt::instance()->decrypt($data['password']);

        }

        if(array_key_exists('admin_roles_id', $data)) unset($data['admin_roles_id']);


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