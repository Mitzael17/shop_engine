<?php

const ACCESS = true;
require_once ("libraries/Chat.php");
require_once ('config.php');

$port = '8195';
$chat = new Chat();

$socket = socket_create(AF_INET, SOCK_STREAM, 0);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socket, '0', $port);
socket_listen($socket, 5);

$clientSocketArray = array($socket);

while(true) {

    $newSocketArray = $clientSocketArray;
    $nullA = [];
    socket_select($newSocketArray, $nullA, $nullA, 0,10);

    if(in_array($socket, $newSocketArray)) {

        $newSocket = socket_accept($socket);
        $clientSocketArray[] = $newSocket;
        echo(json_encode($clientSocketArray));
        $header = socket_read($newSocket, 1024);
        $chat->sendHeaders($header, $newSocket);

        $newSocketArrayIndex = array_search($socket, $newSocketArray);
        unset($newSocketArray[$newSocketArrayIndex]);

    }

    foreach ($newSocketArray as $newSocketArrayResource ) {

        while(socket_recv($newSocketArrayResource, $socketData, 1024, 0) >= 1) {
            $socketMessage = $chat->unseal($socketData);

            $messageObj = json_decode($socketMessage);


            $chatMessage = $chat->createChatMessage($messageObj->sender, $messageObj->recipient, $messageObj->chat_message);

            $chat->send($chatMessage, $clientSocketArray);

            if(!empty($messageObj->sender) && !empty($messageObj->recipient) && !empty($messageObj->chat_message)) {

                $db = new \mysqli(HOST, USER, PASSWORD, DB_NAME);

                $sender = $messageObj->sender;
                $recipient = $messageObj->recipient;

                $users = $db->query("SELECT id, name FROM admins WHERE name='$sender' OR name='$recipient' LIMIT 2");

                $users = $users->fetch_all(MYSQLI_ASSOC);

                $senderId = '';
                $recipientId = '';

                foreach ($users as $user) {

                    if(array_search($sender, $user)) $senderId = $user['id'];
                    elseif(array_search($recipient, $user)) $recipientId = $user['id'];

                }

                $date = new \DateTimeImmutable();;

                $date = $date->format('Y-m-d H:i:s.v');

                $db->query("INSERT INTO chat (user_from, user_to, message, date) VALUES('$senderId', '$recipientId', '$messageObj->chat_message', '$date')");

                $db->close();

            }

            break 2;

        }

        $socketData = @socket_read($newSocketArrayResource, 1024, PHP_NORMAL_READ);
        if($socketData === false) {
            $newSocketArrayIndex = array_search($newSocketArrayResource, $clientSocketArray);
            unset($clientSocketArray[$newSocketArrayIndex]);
        }

    }

}

socket_close($socket);