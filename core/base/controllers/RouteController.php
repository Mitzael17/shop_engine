<?php

namespace core\base\controllers;

use core\base\exceptions\RouteException;
use core\base\settings\Settings;

class RouteController extends BaseController
{

    use SingleTon;

    protected $routes;

    private function __construct() {

        $path = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php'));

        if($path === PATH) {

            $url = $_SERVER['REQUEST_URI'];

            $url = rtrim($url , '/');

            if(preg_match('/\?/', $url)) {
                $url = substr($url, 0,strpos($url, '?'));
            }

            $arrPath = explode( '/', substr($url, strlen(PATH)));

            $this->routes = Settings::instance()->get('routes');

            if(!$this->routes) throw new RouteException('Нету маршрутов', 1);

            if($arrPath[0] !== $this->routes['admin']['alias']) {

                $this->controller = $this->routes['user']['path'];

                $route = 'user';

            }
            else {

                array_shift($arrPath);

                $this->controller = $this->routes['admin']['path'];

                $route = 'admin';

            }



            $this->createRoute($route, $arrPath);


        } else {

            throw new RouteException('Не корректная директория', 1);

        }

    }

    private function createRoute($route, $url) {

        if(!empty($url[0])) {

            $this->controller .= ucfirst($url[0]) . 'Controller';


        } else {
            $this->controller .= $this->routes['default']['controller'];
        }

        array_shift($url);

        if(!empty($url[0])) {

            foreach ($url as $parameter) {

                $this->parameters[] = $parameter;

            }

        }

        $this->inputMethod = $this->routes['default']['inputMethod'];
        $this->outputMethod = $this->routes['default']['outputMethod'];

        return;
    }

}