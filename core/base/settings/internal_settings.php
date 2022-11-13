<?php

use core\base\exceptions\RouteException;

const CRYPT_KEY = 'G-KaPdSgVkYp3s6v8y/B?E(H+MbQeThW%C*F-JaNdRgUkXp2s5v8x/A?D(G+KbPew9z$C&F)J@NcRfUjXn2r5u7x!A%D*G-K3s6v9y$B&E)H@McQfTjWnZr4u7w!z%C*kYp3s5v8y/B?E(H+MbQeThWmZq4t7w9zRgUkXp2s5u8x/A?D(G+KbPeShVmYq3t6@NcRfUjXn2r4u7x!A%D*G-KaPdSgVkYpE)H@McQfTjWnZr4t7w!z%C*F-JaNdRgU/B?E(H+MbQeThWmZq4t6w9z$C&F)J@Ncu8x/A?D(G+KbPeShVmYq3t6v9y$B&E)H';


const ADMIN_TEMPLATE = 'core/admin/views/';
const USER_TEMPLATE =  'templates/default/';
const UPLOAD_DIR = 'userfiles/';

const ADMIN_CSS_JS = [
    'styles' => ['css/main.min.css'],
    'scripts' => ['js/main.min.js', 'js/tinymce/tinymce.min.js',
        'js/tinymce/tinymce_init.js']
];

const USER_CSS_JS = [
    'styles' => ['css/reset.min.css','css/main.min.css'],
    'scripts' => ['js/main.min.js']
];


function autoloadClasses($class_name) {

    $class_name = str_replace('\\', '/', $class_name);

    if(@!include_once $class_name . '.php') {

        throw new RouteException('Не верное имя контроллера - ' . $class_name);

    }

}

spl_autoload_register('autoloadClasses');