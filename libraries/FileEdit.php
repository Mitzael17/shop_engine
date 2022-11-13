<?php

namespace libraries;

use core\base\controllers\SingleTon;

class FileEdit {

    use SingleTon;

    protected $directory;

    public function fileUpload($directory = '') {

        $files = [];

        $this->directory = $directory;

        foreach ($_FILES as $name_field => $file) {
            if(empty($file['name'])) continue;

            if(is_array($file['name'])) {

                foreach ($file['name'] as $key => $name) {
                    $files[$name_field][$key] = $_FILES[$name_field]['name'][$key] = $this->changeName($file['name'][$key]);
                    move_uploaded_file($_FILES[$name_field]['tmp_name'][$key], UPLOAD_DIR . $files[$name_field][$key]);

                }

            } else {
                $files[$name_field] = $_FILES[$name_field]['name'] = $this->changeName($file['name']);
                move_uploaded_file($_FILES[$name_field]['tmp_name'], UPLOAD_DIR . $files[$name_field]);
            }


        }



        return $files;

    }

    protected function changeName($file) {

        if(!file_exists(UPLOAD_DIR . $this->directory . $file)) {
            return $this->directory . $file;
        }

        return $this->changeName(hash('crc32', time() . mt_rand(1, 1000)) . '_' . $file);

    }


    public function delete($images, $dir = '') {

        foreach ($images as $img) {

            if(empty($img)) continue;

            if (file_exists(UPLOAD_DIR . $img)) {
                unlink(UPLOAD_DIR . $dir .  $img);
            };
        }

    }

}