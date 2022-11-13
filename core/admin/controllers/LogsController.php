<?php

namespace core\admin\controllers;

class LogsController extends BaseAdmin
{

    protected $limitLoading = 3;

    protected function inputData() {

        $this->init();

        if(isset($_GET) && !empty($_GET)) {

            $res = $this->model->get('logs_activities', [
                'limit' => $this->limitLoading,
                'order' => ['id'],
                'order_direction' => ['DESC'],
                'where' => ['id' => $_GET['logs']],
                'operand' => ['<'],
                'join' => [
                    'admins' => [
                        'fields' => ['name', 'avatar'],
                        'on' => ['admins.id' => 'logs_activities.admin'],
                    ],
                    'admin_roles' => [
                        'fields' => ['name as role'],
                        'on' => ['admins.admin_roles_id' => 'admin_roles.id']
                    ]
                ]
            ]);

            foreach ($res as $key => $ava) {

                $res[$key]['avatar'] = $this->getImg() . $ava['avatar'];

            }

            $res = json_encode($res, JSON_UNESCAPED_UNICODE);
            exit($res);

        }

        if(isset($_POST) && !empty($_POST)) {

            $logs = '';

            $fromDate = $_POST['fromDate'];
            $toDate = $_POST['toDate'];

            if($fromDate && $toDate) {

                $logs = $this->model->query("SELECT logs_activities.*, admins.name, admins.avatar, admin_roles.name as role FROM logs_activities INNER JOIN admins ON admins.id=logs_activities.admin INNER JOIN admin_roles ON admins.admin_roles_id=admin_roles.id WHERE DATE(logs_activities.date) BETWEEN '$fromDate' AND '$toDate' ORDER BY logs_activities.id DESC");


            } elseif($toDate) {

                $logs = $this->model->query("SELECT logs_activities.*, admins.name, admins.avatar, admin_roles.name as role FROM logs_activities INNER JOIN admins ON admins.id=logs_activities.admin INNER JOIN admin_roles ON admins.admin_roles_id=admin_roles.id WHERE DATE(logs_activities.date) <= '$toDate' ORDER BY logs_activities.id DESC");


            } elseif ($fromDate){

                $logs = $this->model->query("SELECT logs_activities.*, admins.name, admins.avatar, admin_roles.name as role FROM logs_activities INNER JOIN admins ON admins.id=logs_activities.admin INNER JOIN admin_roles ON admins.admin_roles_id=admin_roles.id WHERE DATE(logs_activities.date) >= '$fromDate' ORDER BY logs_activities.id DESC");

            }

            foreach ($logs as $key => $value) {

                $logs[$key]['avatar'] = $this->getImg() . $value['avatar'];

            }

            $logs = json_encode($logs);
            exit($logs);

        }

        $data = $this->model->get('logs_activities', [
            'limit' => $this->limitLoading,
            'order' => ['id'],
            'order_direction' => ['DESC'],
            'join' => [
                'admins' => [
                    'fields' => ['name', 'avatar'],
                    'on' => ['admins.id' => 'logs_activities.admin'],
                ],
                'admin_roles' => [
                    'fields' => ['name as role'],
                    'on' => ['admins.admin_roles_id' => 'admin_roles.id']
                ]
            ]
        ]);


        $this->typeOfPage = 'logs';

        return $data;

    }

}