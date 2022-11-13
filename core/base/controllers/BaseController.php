<?php

namespace core\base\controllers;

use core\base\exceptions\RouteException;
use core\base\models\Crypt;



abstract class BaseController
{

    protected $controller;



    protected $inputMethod;
    protected $outputMethod;
    protected $parameters = [];

    protected $page;

    protected $styles = [];
    protected $scripts= [];

    protected $adminMode = false;


    use BaseMethods;

    public function route() {

        $controller = str_replace('/', '\\', $this->controller);


        try {

            $object = new \ReflectionMethod($controller, 'request');

            $args = [
                'parameters' => $this->parameters,
                'inputMethod' => $this->inputMethod,
                'outputMethod' => $this->outputMethod,
            ];

            $object->invoke(new $controller, $args);

        }
        catch (\ReflectionException $e) {

            throw new RouteException($e->getMessage());

        }

    }

    public function request($args) {

        $inputData = $args['inputMethod'];

        $outputData = $args['outputMethod'];

        $data = $this->$inputData($args['parameters']);

        if(method_exists($this, $outputData)) {

            $this->page = $this->$outputData($data);

        } elseif($data) {

            $this->page = $data;

        }

        $this->getPage();

    }


    protected function render($path, $file, $data = '') {

        $file = $path . $file;

        ob_start();

        if(!include_once $file) throw new RouteException('Отсутствуют шаблоны ');


        return ob_get_clean();

    }



    protected function getPage() {

        if(is_array($this->page)) {
            foreach ($this->page as $block) echo $block;
        } else {
            echo $this->page;
        }

        exit;


    }


    protected function redirect($refer = false) {

        if(!$refer) {
            $refer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
        }

        header("Location: $refer");

        exit;

    }


    protected function setStyleAndScripts($admin = false) {

        if(!$admin) {

            foreach ( USER_CSS_JS['styles'] as $item) {

                $this->styles[] = (!preg_match('/^\s*https?:\/\//i', $item) ? PATH . USER_TEMPLATE : '') . trim($item, '/');

            }

            foreach ( USER_CSS_JS['scripts'] as $item ) {

                $this->scripts[] = (!preg_match('/^\s*https?:\/\//i', $item) ? PATH . USER_TEMPLATE : '') . trim($item, '/');

            }

            $this->styles[] = PATH . USER_TEMPLATE . "css/$this->typeOfPage.min.css";
            $this->scripts[] = PATH . USER_TEMPLATE . "js/$this->typeOfPage.min.js";

        } else {
            foreach (ADMIN_CSS_JS['styles'] as $item) {

                $this->styles[] = (!preg_match('/^\s*https?:\/\//i', $item) ? PATH . ADMIN_TEMPLATE : '') . trim($item, '/');

            }
            foreach (ADMIN_CSS_JS['scripts'] as $item) {

                $this->scripts[] = (!preg_match('/^\s*https?:\/\//i', $item) ? PATH . ADMIN_TEMPLATE : '') . trim($item, '/');
            }

        }

    }


    protected function checkAuth() {

        if($this->adminMode) {
            if(isset($_SESSION['admin'])) {

                $is_blocked = $this->model->get('admins', [
                    'fields' => ['is_blocked'],
                    'where' => ['name' => $_SESSION['admin']['name']]
                ])[0]['is_blocked'];

                if($is_blocked === '1' || $is_blocked === null) {

                    setcookie('admin', '', time() + 1, PATH);

                    unset($_SESSION['admin']);

                    exit('The account was blocked');

                }

                return true;


            } elseif(isset($_COOKIE['admin'])) {

                $cookieData = Crypt::instance()->decrypt($_COOKIE['admin']);

                $cookieData = (array)json_decode($cookieData);

                $data = $this->model->get('admins', [
                    'where' => ['name' => $cookieData['name'], 'password' => $cookieData['password']],
                    'join' => [
                        'admin_roles' => [
                            'fields' => ['name AS role'],
                            'on' => ['admins.admin_roles_id' => 'admin_roles.id']
                        ]
                    ]
                ])[0];

                if(empty($data) || $data['is_blocked'] === '1') {
                    setcookie('admin', '', time() + 1, PATH);

                    unset($_SESSION['admin']);

                    exit('The account was blocked');
                }

                foreach ($data as $key => $value) {
                    $_SESSION['admin'][$key] = $value;
                };


                return true;


            } else {

                return false;

            }

        } else {



        }

    }

}