<?php

namespace core\admin\controllers;

use core\base\exceptions\RouteException;
use libraries\FileEdit;

class DeleteController extends BaseAdmin
{

    protected function inputData($parameters) {

        $this->init();

        if(empty($parameters)) throw new RouteException('Отсутсвуют параметры для DeleteController');

        $this->table = $parameters[0];
        $id = $parameters[1];

        if(preg_match('/^template_/', $this->table)) {

            $this->checkAccess('template');

        } else {

            $this->checkAccess('db');

        }

        $tables = $this->model->showTables();
        $columns = $this->model->showColumns($this->table);

        foreach ($tables as $item) {
            if(preg_match("/^$this->table" . '_to_/i', $item)) {
                $this->model->insertManyToMany($item, $id, []);
            } elseif ( preg_match("/_to_$this->table" . '$/i', $item)) {
                $this->model->insertManyToMany($item, $id, [], true);
            }
        }

        foreach ($columns as $item) {
            if( preg_match('/_position$/i', $item)) {

                $pos = $this->model->get($this->table, [
                    'fields' => [$item],
                    'where' => ['id' => $id]
                ])[0];



                $this->model->decreasePosition($this->table, $item, "WHERE $item >= $pos[$item]");

            }
            elseif( preg_match('/img$/i', $item)) {

                $picutres = [];

                $images = $this->model->get($this->table, [
                    'fields' => [$item],
                    'where' => ['id' => $id]
                ])[0][$item];

                if(preg_match('/,/', $images)) {

                    $picutres = explode(',', $images);

                } else {
                    $picutres[] = $images;
                }


                $fileEdit = FileEdit::instance();
                $fileEdit->delete($picutres);

            }
        }

        $record_name = $this->model->get($this->table, [
            'fields' => ['name'],
            'where' => ['id' => $id],
        ])[0]['name'];

        $this->model->delete($this->table, [
            'where' => ['id' => $id]
        ]);

        $this->writeAdminLog( [
            'controller' => 'delete',
            'table' => $this->table,
            'id' => $id,
            'record_name' => $record_name,
        ] );

        if(preg_match('/^template_/', $this->table)) {

            $this->redirect(PATH . 'admin/show/template/' . $this->table);

        } else {

            $this->redirect(PATH . 'admin/show/database/' . $this->table);

        }

    }


}