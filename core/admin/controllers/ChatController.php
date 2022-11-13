<?php

namespace core\admin\controllers;

class ChatController extends BaseAdmin
{

    protected $limitMessages = 30;

    protected function inputData($parameters = false) {

        $this->init();

        $data = [];

        $ajaxData = json_decode(file_get_contents('php://input'), true);

        if(!empty($parameters) && $parameters[0] === 'socket') {
            $this->redirect(PATH . 'chatAdmin.php');
            exit;
        }

        if(!empty($ajaxData)) {
            if($ajaxData['type'] === 'readMessage') {

                $usersId = $this->model->get('admins', [
                    'fields' => ['id', 'name'],
                    'where' => ['name' => [$ajaxData['sender'], $ajaxData['reader']]],
                    'condition' => ['OR']
                ]);

                foreach ($usersId as $key => $user) {

                    if($user['name'] === $ajaxData['reader']) {
                        $usersId['reader'] = $user['id'];
                    }

                    if($user['name'] === $ajaxData['sender']) {
                        $usersId['sender'] = $user['id'];
                    }

                    unset($usersId[$key]);


                }

                $this->model->edit('chat', [
                    'fields' => ['is_read' => '1'],
                    'where' => ['user_to' => $usersId['reader'], 'user_from' => $usersId['sender'], 'is_read' => '0'],
                ]);
                exit;
            }
        }

        $this->typeOfPage = 'chat';

        $userId = $this->model->get('admins', [
            'fields' => ['id'],
            'where' => ['name' => $_SESSION['admin']['name']]
        ])[0]['id'];

        $admins = $this->model->get('admins', [
            'fields' => ['name', 'avatar'],
            'where' => ['name' => $_SESSION['admin']['name']],
            'operand' => ['<>'],
            'join' => [
                'admin_roles' => [
                    'fields' => ['name as role'],
                    'on' => ['admins.admin_roles_id' => 'admin_roles.id']
                ]
            ]
        ]);

        $data['users'] = $admins;

        $unreadMessages = $this->model->query(
            "SELECT COUNT(*) as numbers, name FROM chat 
            RIGHT JOIN admins ON admins.id=chat.user_from
            WHERE chat.is_read='0' AND chat.user_to=$userId
            GROUP BY name
        ");

        $data['unreadMessages'] = [];

        if(!empty($unreadMessages)) {

            foreach ($unreadMessages as $unreadMessage) {

                $data['unreadMessages'][$unreadMessage['name']] = $unreadMessage['numbers'];

            }
        }


        if(isset($_GET['chat'])) {

            $users = [$_GET['chat'], $_SESSION['admin']['name']];

            $usersArr = $this->model->get('admins', [
                'fields' => ['id', 'name'],
                'where' => ['name' => [$users[0],$users[1]]],
                'condition' => ['OR']
            ]);

            $usersId = [];

            foreach ($usersArr as $user) {
                $usersId[$user['name']] = $user['id'];
                if($_SESSION['admin']['name'] !== $user['name']) $data['interlocutor'] = $user['name'];
            }

            unset($usersArr);

            if(isset($_GET['lastDate'])) {

                $data['messages'] = $this->model->get('chat', [
                    'fields' => ['message', 'is_read', 'date'],
                    'order' => ['date'],
                    'where' => ['date' => $_GET['lastDate']],
                    'operand' => ['<'],
                    'groups' => ['date'],
                    'order_direction' => ['DESC'],
                    'limit' => $this->limitMessages,
                    'join' => [
                        'admins' => [
                            'type' => 'left',
                            'fields' => ['name'],
                            'where' => ['id' => [$usersId[$users[0]], $usersId[$users[1]]] ],
                            'condition' => ['OR'],
                            'groups' => ['id'],
                            'on' => ['chat.user_to' => [$usersId[$users[0]], $usersId[$users[1]]],  'chat.user_from' => [$usersId[$users[0]], $usersId[$users[1]]], 'admins.id' => 'chat.user_from'],
                            'group_condition' => ['OR', 'AND', 'OR', 'AND']
                        ]
                    ]

                ]);

                if(!empty($data['messages'])) $data['oldestDate'] = $data['messages'][count($data['messages']) - 1]['date'];
                else $data['oldestDate'] = false;

            } else {
                $data['messages'] = $this->model->get('chat', [
                    'fields' => ['message', 'is_read', 'date'],
                    'order' => ['date'],
                    'order_direction' => ['DESC'],
                    'limit' => $this->limitMessages,
                    'join' => [
                        'admins' => [
                            'type' => 'left',
                            'fields' => ['name'],
                            'where' => ['id' => [$usersId[$users[0]], $usersId[$users[1]]] ],
                            'condition' => ['OR'],
                            'on' => ['chat.user_to' => [$usersId[$users[0]], $usersId[$users[1]]],  'chat.user_from' => [$usersId[$users[0]], $usersId[$users[1]]], 'admins.id' => 'chat.user_from'],
                            'group_condition' => ['OR', 'AND', 'OR', 'AND']
                        ]
                    ]

                ]);
                $data['messages'] = array_reverse($data['messages']);

                if(!empty($data['messages'])) $data['oldestDate'] = $data['messages'][0]['date'];
                else $data['oldestDate'] = false;
            }

        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
            exit(json_encode($data));
        }

        return $data;
    }

}
