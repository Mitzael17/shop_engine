<?php

namespace core\base\models;

use core\base\exceptions\DbException;

trait BaseModelMethods
{

    protected function createFields($table, $set) {

        $fields = '';

        if(isset($set['fields'])) {

            foreach ($set['fields'] as $field) {

                $fields .= "$table.$field, ";

            }

        } else {
            $fields = "$table.*, ";
        }

        if(isset($set['join'])) {

            foreach ($set['join'] as $join_table => $arr) {
                    if(isset($arr['fields'])) {

                        if(!isset($arr['concat']) || $arr['concat'] === true) {

                            foreach ($arr['fields'] as $field) {

                                $fields .= "$join_table.$field, ";

                            }

                        } else {

                            foreach ($arr['fields'] as $field) {

                                $fields .= "$join_table.$field as TABLE".$join_table."TABLE_$field, ";

                            }


                        }



                    } else {

                        if(!isset($arr['concat']) || $arr['concat'] === true) {

                            $fields .= "$join_table.*, ";


                        } else {

                            $columns = $this->showColumns($join_table);

                            foreach ($columns as $field) {

                                $fields .= "$join_table.$field as TABLE".$join_table."TABLE_$field, ";


                            }

                        }


                    }
            }

        }

        $fields = rtrim($fields, ', ');

        return $fields;

    }

    protected function createWhere($table, $set) {

        $where = '';
        $lastCondition = '';

        if(isset($set['where'])) {

            if(!isset($set['condition'])) {
                $set['condition'] = ['AND'];
            }

            if(!isset($set['operand'])) {

                $set['operand'] = '=';

            }

            $groups = [];

            if(isset($set['groups']) && !empty($set['groups'])) {

                foreach ($set['groups'] as $group) {
                    $groups[$group] = true;
                }

            }

            $indexOperand = 0;

            $indexCondition = 0;

            foreach ($set['where'] as $key => $value) {

                if(is_array($value)) {
                    if(!empty($groups) && array_key_exists($key, $groups)) {
                        $where .= ' (';
                    }
                    foreach ($value as $item) {
                        if(strtoupper($item) === 'NULL') {

                            $where .= ' ' . "$table.$key" . ' IS ' . ' NULL ' . $set['condition'][$indexCondition];

                        } else {
                            $where .= ' ' . "$table.$key" . $set['operand'][$indexOperand] . '\''. $item . '\' ' . $set['condition'][$indexCondition];
                        }
                    }

                    if(!empty($groups) && array_key_exists($key, $groups)) {
                        $where .= ') ';
                    }

                } else {
                    if(strtoupper($value) === 'NULL') {
                        if(!empty($groups) && array_key_exists($key, $groups)) {
                            $where .= ' (' . "$table.$key" . ' IS ' . ' NULL) ' . $set['condition'][$indexCondition];
                        }
                        $where .= ' ' . "$table.$key" . ' IS ' . ' NULL ' . $set['condition'][$indexCondition];
                    } else {
                        if(!empty($groups) && array_key_exists($key, $groups)) {
                            $where .= ' (' . "$table.$key" . $set['operand'][$indexOperand] . '\'' . $value . '\') ' . $set['condition'][$indexCondition];
                        } else {
                            $where .= ' ' . "$table.$key" . $set['operand'][$indexOperand] . '\'' . $value . '\' ' . $set['condition'][$indexCondition];
                        }

                    }
                }




                if(isset($set['operand'][$indexOperand + 1])) $indexOperand++;
                if(isset($set['condition'][$indexCondition + 1])) $indexCondition++;

                $lastCondition = $set['condition'][$indexCondition];

            }

        }

        if(isset($set['join'])) {

            foreach ($set['join'] as $table_name => $arr) {

                if(isset($arr['where'])) {

                    if(!isset($arr['operand'])) {
                        $arr['operand'] = ['='];
                    }

                    if(!isset($arr['condition'])) {
                        $arr['condition'] = ['AND'];
                    }

                    $groups = [];

                    if(isset($arr['groups']) && !empty($arr['groups'])) {

                        foreach ($arr['groups'] as $group) {
                            $groups[$group] = true;
                        }

                    }

                    $indexOperand = 0;

                    $indexCondition = 0;

                    foreach ($arr['where'] as $key => $value) {

                        if(is_array($value)) {

                            if(!empty($groups) && array_key_exists($key, $groups)) {
                                $where .= ' (';
                            }

                            foreach ($value as $item) {
                                $where .= ' ' . "$table_name.$key" . $arr['operand'][$indexOperand] . '\'' . $item . '\' ' . $arr['condition'][$indexCondition];
                            }

                            if(!empty($groups) && array_key_exists($key, $groups)) {
                                $where .= ') ';
                            }

                        } else {
                            //$where .= ' ' . "$table_name.$key" . $arr['operand'][$indexOperand] . '\'' . $value . '\' ' . $arr['condition'][$indexCondition];
                            if(!empty($groups) && array_key_exists($key, $groups)) {
                                $where .= ' (' . "$table_name.$key" . $arr['operand'][$indexOperand] . $value . ') ' . $arr['condition'][$indexCondition];
                            } else {
                                $where .= ' ' . "$table_name.$key" . $arr['operand'][$indexOperand] . '\'' . $value . '\' ' . $arr['condition'][$indexCondition];
                            }
                        }


                        if(isset($arr['operand'][$indexOperand + 1])) $indexOperand++;
                        if(isset($arr['condition'][$indexCondition + 1])) $indexCondition++;

                        $lastCondition = $arr['condition'][$indexCondition];

                    }


                }

            }

        }

        if(!empty($groups) && substr($where, strlen($where) - 2) === ') ') {
            $where = $where ? 'WHERE' . rtrim($where, "$lastCondition) ") : '';
            $where .= ') ';
        } else {
            $where = $where ? 'WHERE' . rtrim($where, "$lastCondition ") : '';
        }


        return $where;

    }

    protected function createOrder($table, $set) {

        $order = '';

        if(isset($set['order'])) {

            if(!isset($set['order_direction'])) {
                $set['order_direction'] = ['ASC'];
            }

            $indexOrder = 0;
            $indexOrderDirection = 0;


            foreach ($set['order'] as $value) {

                $order .= $table . '.' . $set['order'][$indexOrder++] . ' ' . $set['order_direction'][$indexOrderDirection] . ', ';

                if(isset($set['order_direction'][$indexOrderDirection+1])) $indexOrderDirection++;

            }

        }

        if(isset($set['join'])) {

            foreach ($set['join'] as $table_name => $arr) {

                if(isset($arr['order'])) {

                    if(!isset($arr['order_direction'])) {
                        $arr['order_direction'] = ['ASC'];
                    }

                    $indexOrder = 0;
                    $indexOrderDirection = 0;

                    foreach ($arr['order'] as $value) {

                        $order .= $table_name . '.' . $arr['order'][$indexOrder++] . ' ' . $arr['order_direction'][$indexOrderDirection] . ', ';

                        if(isset($arr['order_direction'][$indexOrderDirection+1])) $indexOrderDirection++;
                    }

                }

            }

        }

        $order = $order ? 'ORDER BY ' . rtrim($order, ', ') : '';

        return $order;

    }

    protected function createJoin($set) {

        $join = '';

        if(isset($set['join'])) {

            foreach ($set['join'] as $join_table => $arr) {

                if($arr['on']) {

                    if(!isset($arr['type'])) {
                        $arr['type'] = 'INNER';
                    }

                    if(!isset($arr['group_condition']) && empty($arr['group_condition'])) {

                        $arr['group_condition'] = ['AND'];

                    }

                    $join .= ' ' . strtoupper($arr['type']) . ' JOIN ' . $join_table . ' ON ';

                    $idGroupCondition = 0;

                    foreach ($arr['on'] as $firstColumn => $secondColumn) {

                        if(is_array($secondColumn)) {

                            $join .= '(';
                            $lastGroupCondition = '';

                            foreach ($secondColumn as $column) {

                                $join .= $firstColumn . '=' . $column . ' '
                                    . $arr['group_condition'][$idGroupCondition] . ' ';

                                $lastGroupCondition = $arr['group_condition'][$idGroupCondition];
                                if(isset($arr['group_condition'][$idGroupCondition+1])) $idGroupCondition++;
                            }

                            $join = preg_replace('/' . $lastGroupCondition . '*\s$/', ") $lastGroupCondition ", $join);

                        } else {

                            $join .= $firstColumn . '=' . $secondColumn . ' '
                                . $arr['group_condition'][$idGroupCondition] . ' ';

                            if(isset($arr['group_condition'][$idGroupCondition+1])) $idGroupCondition++;
                        }



                    }

                    $lastOperand = $arr['group_condition'][count($arr['group_condition']) - 1] . ' ';

                    $join = rtrim($join, $lastOperand);


                } else {
                    throw new DbException('Отсутствует ON в запросе join');
                }

            }

        }

        return trim($join);

    }

    protected function createInsert($table, $set) {

        $columns = '(';
        $values = 'VALUES (';

        foreach ($set['fields'] as $column => $value) {
            if(empty($value) && $value !== '0') continue;

            $columns .= $column . ', ';
            $values .= "'" . $value . '\', ';

        }

        $columns = rtrim($columns, ', ') . ')';
        $values = rtrim($values, ', ') . ')';

        return "INSERT INTO $table " . $columns . ' ' . $values;

    }

    protected function createFieldsForUpdate($table, $set) {

        if(!isset($set['fields'])) throw new DbException('Отсутствуют данные для обновления ');

        $update = '';

        foreach ($set['fields'] as $field => $value) {
            if(empty($value) && $value !== '0') {
                $update .= $table . '.' . $field . '=' . " NULL " . ', ';
            } else {
                $update .= $table . '.' . $field . '=\'' . $value . '\', ';
            }

        }

        $update = rtrim($update,', ');

        return $update;

    }

}