<?php

namespace core\admin\controllers;

use Cassandra\Date;
use core\admin\models\Model;
use core\base\exceptions\DbException;
use core\base\models\Crypt;

class LoginController extends BaseAdmin
{

    protected function InputData($parameters = '') {

        if(!empty($parameters) && $parameters[0] === 'logout') {
            $this->logout();
        }

        if(!$this->model) $this->model = Model::instance();

        $this->typeOfPage = 'login';

        $crypt = Crypt::instance();

        if(isset($_POST) && !empty($_POST)) {

            $data = $this->model->get('admins', [
                'where' => ['name' => $_POST['name']]
            ]);

            $record = $this->model->get('blocked_admin_access', [
                'where' => ['ip' => $_SERVER['REMOTE_ADDR']],
            ]);

            if(!empty($data)) $data = $_POST['password'] === $crypt->decrypt($data[0]['password']) ? $data : null;

            if(empty($data)) {

                $date = date('Y-m-d H:i:s');

                if(empty($record)) {

                    $this->model->add('blocked_admin_access', [
                        'fields' => ['name' => $_POST['name'], 'ip' => $_SERVER['REMOTE_ADDR'], 'trying' => '1', 'date' => $date],
                    ]);

                } else {

                    $trying = $record[0]['trying'];

                    if($trying >= 3) {

                        $date = $record[0]['date'];

                        if(time() - strtotime($date) >= 3600) {

                            $this->model->delete('blocked_admin_access', [
                                'where' => ['ip' => $_SERVER['REMOTE_ADDR']],
                            ]);

                        } else {
                            $res = ['message' => 'Превышено количетсво попыток входа'];
                            $res = json_encode($res);
                            exit($res);
                        }
                    }

                    $this->model->edit('blocked_admin_access', [
                        'fields' => ['name' => $_POST['name'], 'trying' => $trying + 1, 'date' => $date]
                    ]);
                }

                $res = ['message' => 'Неверное имя пользователя или пароль'];

                $res = json_encode($res);

                exit($res);
            }

            if(!empty($record)) {
                if($record[0]['trying'] >= 3) {

                    $date = $record[0]['date'];

                    if(time() - strtotime($date) >= 3600) {

                        $this->model->delete('blocked_admin_access', [
                            'where' => ['ip' => $_SERVER['REMOTE_ADDR']],
                        ]);

                    } else {
                        $res = ['message' => 'Превышено количетсво попыток входа'];
                        $res = json_encode($res);
                        exit($res);
                    }


                } else {
                    $this->model->delete('blocked_admin_access', [
                        'where' => ['ip' => $_SERVER['REMOTE_ADDR']],
                    ]);
                }
            }

            $data = $data[0];

            $data['role'] = $this->model->get('admin_roles', [
                'fields' => ['name AS role'],
                'where' => [ 'id' => $data['admin_roles_id']]
            ])[0]['role'];

            foreach ($data as $key => $value) {

                $_SESSION['admin'][$key] = $value;

            }

           if(isset($_POST['keeplogin']) && $_POST['keeplogin'] === 'on') {

               $data = json_encode($data);

               $data = $crypt->encrypt($data);

               setcookie('admin', $data, time()+31536000, PATH);



           }

           $res = [
               'redirect' => PATH . 'admin/show/database',
           ];

           $res = json_encode($res);

           $_SESSION['answer'] = 'Добро пожаловать ' . $_SESSION['admin']['name'];

           exit($res);



        } else {
            $this->init();
        }




    }

    protected function logout() {

        $_SESSION = [];

        if(isset($_COOKIE['admin'])) {

            unset($_COOKIE['admin']);

            setcookie('admin', null, -1, PATH);

        }

        $this->redirect(PATH);

    }

}