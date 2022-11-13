<?php

namespace core\admin\controllers;

use Cassandra\Set;
use core\admin\models\Model;
use core\base\controllers\BaseController;
use core\base\models\Crypt;
use core\base\settings\Settings;
use libraries\FileEdit;

abstract class BaseAdmin extends BaseController
{

    protected $model;

    protected $content;
    protected $header;
    protected $footer;
    protected $sidebar;

    protected $table;
    protected $typeOfPage;

    protected $templates = [];
    protected $protocol;
    protected $routes;




    protected function init() {

        if(!$this->model) $this->model = Model::instance();

        $this->adminMode = true;

        if(!$this->checkAuth() && $this->typeOfPage !== 'login') $this->redirect(PATH . Settings::instance()->get('routes')['admin']['alias'] . '/login');

        $this->noSendCache();

        $this->setStyleAndScripts(true);

        $this->routes = Settings::instance()->get('routes')['admin'];

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $this->protocol = 'https://';
        } else {
            $this->protocol = 'http://';
        }

    }


    protected function outputData($data = '') {

        $head = $this->render(ADMIN_TEMPLATE, 'includes/head.php');

        $header='';
        $sidebar='';



        if($this->typeOfPage !== 'login') {
            $userId = $_SESSION['admin']['id'];

            $this->quantityOfUnreadMessages = $this->model->query("SELECT COUNT(*) as sum FROM chat
            WHERE is_read='0' AND user_to='$userId'")[0]['sum'];

            $header = $this->render(ADMIN_TEMPLATE, 'includes/header.php');
            $sidebar = $this->render(ADMIN_TEMPLATE, 'includes/sidebar.php');

        }

        $content = $this->render(ADMIN_TEMPLATE, $this->typeOfPage . '.php', $data);

        $footer = $this->render(ADMIN_TEMPLATE, 'includes/footer.php');

        return compact('head', 'sidebar', 'header', 'content', 'footer');


    }

    protected function makeTemplateArr($data) {

        $templateArr = Settings::instance()->get('templateArr');

        foreach ($templateArr as $element => $columns) {

            foreach ($columns as $key => $value) {

                if($key === 'template') {
                    unset($templateArr[$element]['template']);

                    if(is_array($value)) {

                        foreach ($value as $regular_expression) {

                            foreach ($data as $key => $item) {

                                if(preg_match($regular_expression, $key)) {


                                    $templateArr[$element][] = $key;

                                }

                            }



                        }

                    } else {
                        foreach ($data as $key => $item) {

                            if(preg_match($value, $key)) {

                                $existFullName = false;

                                foreach ($templateArr as $arr) {

                                    if(array_search($key, $arr)) {
                                        $existFullName = true;
                                        break;
                                    }

                                }

                                if(!$existFullName) {

                                    $templateArr[$element][] = $key;


                                }


                            }

                        }
                    }


                }

            }

        }

        return $templateArr;

    }

    protected function checkFile($id = false, $dir = '') {

        $files = false;

        $fileEdit = FileEdit::instance();


        if(!empty($_FILES)) {

            $fields = [];



            foreach ($_FILES as $field => $value) {

                if(!is_array($_FILES[$field]['name'])) {
                    $fields[$field] = '';
                }

            }

            if($id !== false && !empty($fields)) {

                $this->model->edit($this->table, [
                    'fields' => $fields,
                    'where' => ['id' => $id],
                ]);

            }

            $files = $fileEdit->fileUpload($dir);


        }

        if(!empty($_POST['deletedFiles'])) {
            foreach ($_POST['deletedFiles'] as $column => $img) {

                foreach ($img as $key => $value) {

                    $replace = '#^' . $this->protocol . $_SERVER['HTTP_HOST'] . PATH . UPLOAD_DIR . '#';

                    $_POST['deletedFiles'][$column][$key] = urldecode(preg_replace($replace, '', $_POST['deletedFiles'][$column][$key]));

                }

            }

            foreach ($_POST['deletedFiles'] as $pictures) {

                $fileEdit->delete($pictures, $dir);

            }


        }

        return $files;

    }


    protected function writeAdminLog($record) {

        $date = date('Y-m-d : H:i:s');

        $admin = $_SESSION['admin']['name'];

        if(isset($record['message'])) {

            $message = $record['message'];


        } else {

            $message = $admin . ' ' . $record['controller'] . 'ed' . ' the record';

            $message = preg_replace('/eed/', 'ed', $message);

            $alias = NULL;

            if(isset($record['alias'])) {
                $message .= ' - ';
                $alias = $record['alias'];
            } else {
                $message .= ' №' . $record['id'] . '(' . $record['record_name'] . ')';
            }


        }



        $adminId = $this->model->get('admins', [
            'fields' => ['id'],
           'where' => ['name' => $admin]
        ])[0]['id'];

        $this->model->add('logs_activities', [
            'fields' => ['admin' => $adminId, 'date' => $date, 'alias' => $alias, 'message' => $message]
        ]);

    }

    protected function noSendCache() {
        header("Last-Modified: " . gmdate("D, d m Y H:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Cache-Control: max-age=0");
        header("Cache-Control: post-check,pre-check=0");
    }

    protected function checkAccess($type, $redirect = true) {

        if( $type === 'db' ) {

            $allowed_databases = $this->model->get('admin_roles_to_project_tables', [
                'where' => ['admin_roles_id' => $_SESSION['admin']['admin_roles_id']],
                'join' => [
                    'project_tables' => [
                        'fields' => ['name'],
                        'on' => ['admin_roles_to_project_tables.project_tables_id' => 'project_tables.id']
                    ]
                ]
            ]);


            foreach ($allowed_databases as $key => $database) {

                $allowed_databases[$key] = $database['name'];

            }

            if(array_search($this->table, $allowed_databases) !== false) return true;

            $_SESSION['answer'] = 'You don\'t have permissions';

            $redirect && $this->redirect();

            return false;

        }

        if( $type === 'admins') {


            $access = $this->model->get('admins', [
                'fields' => ['id'],
                'where' => ['name' => $_SESSION['admin']['name']],
                'join' => [
                    'admin_roles' => [
                        'fields' => ['allowed_manage_admins'],
                        'on' => ['admins.admin_roles_id' => 'admin_roles.id']
                    ]
                ]
            ])[0]['allowed_manage_admins'];

            if($access) return true;

            $_SESSION['answer'] = 'You don\'t have permissions';

            $redirect && $this->redirect();

            return false;
        }

        if( $type === 'template') {

            $access = $this->model->get('admin_roles', [
                'fields' => ['allowed_template'],
                'where' => ['id' => $_SESSION['admin']['admin_roles_id']]
            ])[0]['allowed_template'];

            if($access) return true;

            $_SESSION['answer'] = 'You don\'t have permissions';

            $redirect && $this->redirect();

            return false;
        }

    }

    protected function checkAdminName($name) {

        $user = $this->model->get('admins', [
            'fields' => ['name'],
            'where' => ['name' => $name],
        ]);

        if(empty($user)) return true;

        return false;

    }

    protected function getDiscountInPercentage($price, $discount) {

        $percentage = $price / 100;

        return (int)round($discount / $percentage);

    }
}