<?php

namespace core\admin\models;

use core\base\controllers\SingleTon;
use core\base\models\BaseModel;

class Model extends BaseModel
{

    use SingleTon;

    public function showInfoOfRecord($table, $id= '', $set = []) {

        $data = [];

        if(!empty($id)) {
            $data = $this->get($table, ['where' => ['id' => $id]])[0];
        } else {
            $columns = $this->showColumns($table);

            foreach ($columns as $column) {

                $data[$column] = '';

            }
        }


        $this->showForeignKeys($data, $set, $table);
       $method = !empty($id) ? 'edit' : 'add';
        $this->createManyToMany($data, $table, $method);
        $this->createPosition($data, $table, $method);

        return $data;

    }


    protected function showForeignKeys(&$data, $set, $main_table) {

        foreach ($data as $key => $value) {

            if(!preg_match('/_id$/i', $key)) continue;

            $table = preg_replace('/_id$/', '', $key);

            if(!empty($set) && array_search($key, $set['excluded']['foreignKeys']) !== false) {

                $data[$key] = $this->get($table, [
                    'fields' => ['id', 'name'],
                    'where' => ['id' => $value]
                ]);

                if(!empty($data[$key])) $data[$key] = $data[$key][0];

                continue;

            }

            $foreignData = '';

            if($key === 'admin_roles_id') {

                $priority = $this->get('admin_roles', [
                    'fields' => ['priority'],
                    'where' => ['id' => $_SESSION['admin']['admin_roles_id']]
                ])[0]['priority'];

                $foreignData = $this->get($table, [
                    'fields' => ['id', 'name'],
                    'where' =>  ['priority' => $priority],
                    'operand' => ['>='],
                ]);

            } else {

                if($table === $main_table) {

                    $foreignData = $this->get($table, [
                        'fields' => ['id', 'name'],
                        'where' => [$key => 'NULL']
                    ]);

                    $foreignData['root'] = ['id' => 'root', 'name' => 'root'];

                } else {

                    $foreignData = $this->get($table, [
                        'fields' => ['id', 'name']
                    ]);


                }


            }



            $data[$key] = ['selected' => $value];

            if(isset($foreignData['root']) && empty($value) && $value !== 0) {
                $data[$key] = ['selected' => 'root'];
            }


            foreach ($foreignData as $item) {
                $data[$key][$item['id']] = $item['name'];
            }

        }

    }

    protected function createManyToMany(&$data, $table, $method = 'edit') {

        $tables = $this->showTables();

        foreach ($tables as $manyToManyTable) {

            if(preg_match("/$table" . '_to_/', $manyToManyTable)) {

                $sec_table = preg_replace("/$table" . '_to_/', '', $manyToManyTable);

                $manyToManyData = '';

                if($method === 'edit') {
                    $manyToManyData = $this->get($manyToManyTable, [
                        'where' => [$table . '_id' => $data['id']],
                    ]);
                }


                $sec_table_data = $this->get($sec_table, [
                    'order_direction' => ['ASC'],
                    'order' => [$sec_table . '_id']
                ]);

                foreach ($sec_table_data as $item) {
                    if(empty($item[$sec_table . '_id'])) {
                        $data[$sec_table][$item['name']] = [];

                        foreach ($sec_table_data as $value) {
                            if($value[$sec_table . '_id'] === $item['id']) {

                                $isSelected = false;

                                if($method === 'edit') {
                                    foreach ($manyToManyData as $arr) {

                                        if($arr[$sec_table . '_id'] === $value['id']) {
                                            $isSelected = true;
                                            break;
                                        }

                                    }
                                }


                                $value['selected'] = $isSelected ? true : false;

                                $data[$sec_table][$item['name']][] = $value;

                            }
                        }

                    }
                }

            }

        }

    }

    protected function createPosition(&$data, $table, $method = 'edit', $input = true) {

        if($input) {

            foreach ($data as $key => $value) {

                if(preg_match('/_position$/i', $key)) {

                    $records = $this->get($table, [
                        'fields' => [$key],
                        'where' => [$key => 0],
                        'operand' => ['>'],
                        'order' => [$key],
                    ]);

                    if(!empty($records)) {
                        $maxPosition = $records[count($records)-1][$key] + ($method === 'edit' ? 0 : 1);
                    } else {
                        $maxPosition = '1';
                    }



                    if($maxPosition == '1') $end = 'st';
                    elseif($maxPosition == '2') $end = 'nd';
                    elseif($maxPosition == '3') $end = 'rd';
                    else $end = 'th';

                    $data[$key] = [
                        'selected' => $data[$key],
                        'message' => 'Max position is ' . $maxPosition . $end,
                        'maxValue' => $maxPosition,
                    ];

                }

            }

        } else {
            foreach ($data as $key => $value) {

                if(preg_match('/_position$/i', $key)) {

                    $data[$key] = [];

                    $data[$key]['selected'] = $value;

                    $records = $this->get($table, [
                        'fields' => [$key],
                        'where' => [$key => '0'],
                        'operand' => ['>'],
                        'order' => [$key],
                    ]);


                    foreach ($records as $record) {

                        $data[$key][$record[$key]] = $record[$key];

                    }

                    $data[$key][count($data[$key]) - 1 + 1] = $data[$key][count($data[$key]) - 1] + 1;


                }

            }
        }



    }

    public function increasePosition($table, $field, $where = '') {

        $this->query("UPDATE $table SET $field =`$field` + 1 $where", 'c');

    }

    public function decreasePosition($table, $field, $where = '') {

        $this->query("UPDATE $table SET $field =`$field` - 1 $where", 'c');


    }

    public function insertManyToMany($table, $id, $filters, $reverse = false) {


        $tables = explode('_to_', $table);

        if($reverse) {
            $tables = array_reverse($tables);
        }

        $records = $this->get($table, [
            'where' => [$tables[0] . '_id' => $id],
        ]);

        $deleteFilters = [];

        $addFilters = [];

        if(count($filters) > 1) {

            unset($filters['init']);
            $arr = [];

            if(empty($records)) {
                foreach ($filters as $key => $value) {
                    $addFilters[] = $key;
                }
            }

            foreach ($records as $record) {


                foreach ($filters as $filterId => $value) {

                    if(!isset($filters[$record[$tables[1] . '_id']])) {
                        $arr[$record[$tables[1] . '_id']] = 'delete';
                    }

                    if(isset($arr[$filterId]) && $arr[$filterId] === 'no-change') continue;

                    if($record[$tables[1] . '_id'] == $filterId) {
                        $arr[$filterId] = 'no-change';
                    } else {
                        $arr[$filterId] = 'add';
                    }



                }

            }
            foreach ($arr as $key => $value) {

                if($value === 'delete') $deleteFilters[] = $key;
                elseif($value === 'add') $addFilters[] = $key;

            }

            if(!empty($deleteFilters)) {

                $this->delete($table, [
                    'where' => [$tables[0] . '_id' => $id, $tables[1] . '_id' => $deleteFilters],
                    'condition' => ['AND', 'OR'],
                    'groups' => [$tables[0] . '_id', $tables[1] . '_id'],
                ]);

            }

            if(!empty($addFilters)) {

                foreach ($addFilters as $filter) {
                    $this->add($table, [
                        'fields' => [$tables[0] . '_id' => $id, $tables[1] . '_id' => $filter]
                    ]);
                }


            }

        } else {

            $this->delete($table, [
                'where' => [$tables[0] . '_id' => $id]
            ]);


        }

    }


    public function test() {

//        $res = $this->get('products', [
//            'fields' => ['name', 'price'],
//            'where' => ['id' => 1],
//            'condition' => ['AND'],
//            'operand' => ['='],
//            'order' => ['price', 'name'],
//            'order_direction' => ['DESC', 'ASC'],
//            'groups' => ['id']
//            'limit' => 1,
//            'join' => [
//                'type' => [
//                    'fields' => ['type'],
//                    'type' => 'left',
//                    'where' => ['id' => 3],
//                    'operand' => '<',
//                    'on' => ['type.id' => 'products.id'],
//                    //'group_condition' => ['AND'],
//                    'order' => ['id', 'type'],
//                    'order_direction' => ['DESC', 'ASC'],
//                ],
//                'manufacturer' => [
//                    'fields' => ['manufacturer'],
//                    'type' => 'left',
//                    'where' => ['id' => 2],
//                    'on' => ['manufacturer.id' => 'products.id'],
//                    //'group_condition' => ['AND'],
//                ]
//            ]
//        ]);


//        $res = $this->add('products', [
//            'fields' => ['name' => 'fgddg', 'price' => '120'],
//            'files' => ['cow.png'],
//            'return_id' => true,
//        ]);

//        $res = $this->edit('products', [
//            'fields' => ['price' => '', 'name' =>'testForReturn'],
//            'where' => ['price' => [
//                'null', 1
//            ]],
//            'condition' => ['OR'],
//            'operand' => ['='],
//        ]);

//        $this->delete('products', [
//            //'where' => ['id' => 1],
//        ]);


    }

}