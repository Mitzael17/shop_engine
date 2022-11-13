<?php

namespace core\admin\controllers;

use libraries\FileEdit;

class AdminsController extends BaseAdmin
{

    protected function inputData() {

        $this->init();

        $this->checkAccess('admins');

        $ajaxData = json_decode(file_get_contents('php://input'), true);

        if($ajaxData) {

            $nameMethod = $ajaxData['type'] . 'Admin';

            exit($this->$nameMethod($ajaxData));

        }

        $this->typeOfPage = 'admins';

        $data['admins'] = $this->model->get('admins', [
            'fields' => ['name', 'admin_roles_id as role', 'avatar', 'is_blocked'],
            'join' => [
                'admin_roles' => [
                    'fields' => ['name as role',  'priority'],
                    'on' => ['admins.admin_roles_id' => 'admin_roles.id'],
                ]
            ]
        ]);

        $priority = 10;

        foreach ($data['admins'] as $admin) {

            if( $admin['name'] !== $_SESSION['admin']['name']) continue;

            $priority = $admin['priority'];

            break;

        }
        foreach ($data['admins'] as $key => $admin) {

            if($admin['priority'] <= $priority) unset($data['admins'][$key]);

        }

        $data['blocked_admins'] = array_filter( $data['admins'], function ($admin) {

            return (int)$admin['is_blocked'];

        });

        $data['active_admins'] = array_filter( $data['admins'], function ($admin) {

            return !(int)$admin['is_blocked'];

        });

        unset($data['admins']);

        return $data;
    }


    protected function blockAdmin($data) {


        $this->model->edit('admins', [
           'fields' => ['is_blocked' => 1],
           'where' => ['name' => $data['admins']],
            'condition' => ['OR'],
            ''
        ]);

        $blockedAdmins = rtrim(array_reduce($data['admins'], function ($str, $value) {
            $str .= $value . ', ';
            return $str;
        }), ', ');


        $log = $_SESSION['name'] . 'blocked user' . (count($data['admins']) > 1 ? 's: ' : ': ') . $blockedAdmins;

        $this->writeAdminLog([
            'controller' => 'admin',
            'message' => $log,
        ]);

        return '';

    }

    protected function unblockAdmin($data) {
        $this->model->edit('admins', [
            'fields' => ['is_blocked' => '0'],
            'where' => ['name' => $data['admins']],
            'condition' => ['OR'],
        ]);

        $blockedAdmins = rtrim(array_reduce($data['admins'], function ($str, $value) {
            $str .= $value . ', ';
            return $str;
        }), ', ');


        $log = $_SESSION['name'] . 'unblocked user' . (count($data['admins']) > 1 ? 's: ' : ': ') . $blockedAdmins;

        $this->writeAdminLog([
            'controller' => 'admin',
            'message' => $log,
        ]);

        return '';
    }

    protected function deleteAdmin($data) {

        $avatars = $this->model->get('admins', [
            'fields' => ['avatar'],
            'where' => ['name' => $data['admins']],
            'condition' => ['OR']
        ]);


        $avatars = array_filter($avatars, function ($item) {

            if($item['avatar'] === 'adminImg/profile.png') return false;

            return true;

        });

        $avatars = array_map(function($item) {
            return $item['avatar'];
        }, $avatars);


        $this->model->delete('admins', [
            'where' => ['name' => $data['admins']],
            'condition' => ['OR']
        ]);

        FileEdit::instance()->delete($avatars);

        $blockedAdmins = rtrim(array_reduce($data['admins'], function ($str, $value) {
            $str .= $value . ', ';
            return $str;
        }), ', ');

        $log = $_SESSION['name'] . 'deleted user' . (count($data['admins']) > 1 ? 's: ' : ': ') . $blockedAdmins;

        $this->writeAdminLog([
            'controller' => 'admin',
            'message' => $log,
        ]);
    }

}