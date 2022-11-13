<?php

namespace core\admin\controllers;

class SearchController extends BaseAdmin
{

    protected function inputData($parameters) {

        $this->init();

        $ajaxData = json_decode(file_get_contents('php://input'), true);

        if($ajaxData) {

            $areaSearch = '';

            if(!empty($parameters)) {

                $areaSearch = [];

                $areaSearch[0] = 'database';
                $areaSearch[1] = $parameters[0];

            } else {

                $str_replace = $this->protocol . $_SERVER['HTTP_HOST'] . '/' . $this->routes['alias'] . '/';

                $areaSearch = str_replace( $str_replace, '', $_SERVER['HTTP_REFERER']);
                $areaSearch = preg_replace('/^show\//', '', $areaSearch);
                $areaSearch = explode( '/' ,$areaSearch);


            }

            $data = [];

            if(count($areaSearch) > 1 && ($areaSearch[0] === 'database' || $areaSearch[0] === 'template')) {

                $table = $areaSearch[1];

                $data = $this->model->get($table, [
                    'fields' => ['id', 'name as value'],
                    'where' => ['name' =>  $ajaxData['query'] . '%'],
                    'operand' => [' LIKE '],
                    'limit' => $ajaxData['limit'],
                ]);

                foreach ($data as $key => $item) {

                    $data[$key]['value'] = $item['value'] . " ($table)";
                    $data[$key]['refer'] = PATH . $this->routes['alias'] . '/edit/database/' . $table . '/' . $item['id'];
                    $data[$key]['id'] = $item['id'];

                }

            }

            if (count($data) < $ajaxData['limit'] && empty($parameters)) {

                $tables = $this->model->get('admin_roles_to_project_tables', [
                    'where' => ['admin_roles_id' => $_SESSION['admin']['admin_roles_id']],
                    'join' => [
                        'project_tables' => [
                            'on' => ['admin_roles_to_project_tables.project_tables_id' => 'project_tables.id'],
                            'fields' => ['name']
                        ]
                    ]
                ]);

                if($this->checkAccess('template', false)) {

                    $template_tables = $this->model->showTables();

                    $template_tables = array_filter($template_tables, function ($table) {

                        if(preg_match('/^template_/', $table)) return true;

                        return false;

                    });

                    $template_tables = array_map(function ($table) {

                        $arr = [];

                        $arr['name'] = $table;

                        return $arr;

                    }, $template_tables);

                    $tables = array_merge($template_tables, $tables);

                }

                for($index = 0; $index < count($tables); $index++) {

                    if(isset($table) && $tables[$index]['name'] === $table) continue;

                    $other_data = $this->model->get($tables[$index]['name'], [
                        'fields' => ['id', 'name as value'],
                        'where' => ['name' =>  $ajaxData['query'] . '%'],
                        'operand' => [' LIKE '],
                        'limit' => $ajaxData['limit'],
                    ]);

                    foreach ($other_data as $item) {

                        if(count($data) >= $ajaxData['limit']) break 2;

                        $item['value'] = $item['value'] . ' (' . $tables[$index]['name'] . ')';
                        $item['refer'] = PATH . $this->routes['alias'] . '/edit/database/' . $tables[$index]['name'] . '/' . $item['id'];

                        $data[] = $item;

                    }

                }

            }

            $result = [];

            foreach ($data as $suggest) {

                $result['suggestions'][] = $suggest;

            }

            $result = json_encode($result);

            exit($result);

        }

    }

    protected function getDataFromTable($table, $ajaxData) {

        $data = [];

        $this->model->get($table, [

        ]);

    }
}