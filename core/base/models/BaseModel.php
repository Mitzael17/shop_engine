<?php

namespace core\base\models;


use core\base\exceptions\DbException;
use mysql_xdevapi\Exception;


abstract class BaseModel
{

//$this->get('test', [
//'fields' => ['name', 'price'],
//'where' => ['id' => 1],
//'operand' => ['='],
//'order' => ['price', 'name'],
//'order_direction' => ['DESC', 'ASC'],
//'limit' => 1
//]);

    use BaseModelMethods;

    protected $db;

    protected function connect() {
        $this->db = new \mysqli(HOST, USER, PASSWORD, DB_NAME);

        if($this->db->connect_error) {
            throw new DbException('Ошибка подключения к бд', 1);
        }

        $this->db->query("SET NAMES UTF8");

    }

    public function query($query, $flag = 'r', $return_id = false) {


        $result = $this->db->query($query);

        if($this->db->affected_rows === -1) {
            throw new DbException('Ошибка в SQL запросе: ' .
                $query . '-' . $this->db->errno . ' ' . $this->db->error);
        }

        switch ($flag) {

            case "r":

                return $result->fetch_all(MYSQLI_ASSOC);

                break;

            case 'c':
                if($return_id) return $this->db->insert_id;
                return true;
                break;

            default:
                return true;
                break;

        }
    }

    public function get($table, $set = []) {

        $fields = $this->createFields($table, $set);

        $join = $this->createJoin($set);

        $where = $this->createWhere($table, $set);

        $order = $this->createOrder($table, $set);

        $limit = isset($set['limit']) ? 'LIMIT ' . $set['limit'] : '';

        $query = "SELECT $fields FROM $table $join $where $order $limit";

        $result = $this->query($query);

        foreach ($result as $key => $record) {

            $foreignData = array_filter($record, function ($foreign_key) {

                if(preg_match('/TABLE\w+TABLE_\w+/', $foreign_key)) return true;

                return false;

            }, ARRAY_FILTER_USE_KEY);

            if(!empty($foreignData)) {


                foreach ($foreignData as $foreign_key => $data) {

                    $table = substr($foreign_key, strpos($foreign_key, 'TABLE') + 5, strpos($foreign_key,'TABLE_') - 5);

                    if(!array_key_exists($table, $result[$key])) {

                        $result[$key][$table] = [];

                    };

                    unset($result[$key][$foreign_key]);

                    $foreign_key = substr($foreign_key, strpos($foreign_key, 'TABLE_') + 6);
                    $result[$key][$table][$foreign_key] = $data;

                }

            }

        }

        return $result;

    }

    public function edit($table, $set = []) {

        $update = $this->createFieldsForUpdate($table, $set);

        $where = $this->createWhere($table, $set);

        $query = "UPDATE $table SET $update $where";

        return $this->query($query, 'c');

    }

    public function add($table, $set = []) {

        $set['fields'] = (isset($set['fields']) && !empty($set['fields'])) ? $set['fields'] : $_POST;

        $query = $this->createInsert($table, $set);

        $set['return_id'] = isset($set['return_id']) ?? false;

        return $this->query($query, 'c', $set['return_id']);

    }

    public function delete($table, $set = []) {

        $where = '';

        if(isset($set['where'])) {
            $where = $this->createWhere($table, $set);
        }

        $query = "DELETE FROM $table $where";

        return $this->query($query, 'd');

    }

    public function showColumns($table) {

        $query = "SHOW COLUMNS FROM $table";

        $data = $this->query($query);

        $columns = [];

        foreach ($data as $column) {
            $columns['columns'][] = $column['Field'];
        }

        return $columns['columns'];

    }

    public function showTables() {

        $tables =  $this->query('SHOW TABLES');

        $res = [];

        foreach ($tables as $table) {
            foreach ($table as $name_table) {
                $res[] = $name_table;
            }
        }

        return $res;

    }

}