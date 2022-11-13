<?php

namespace core\base\controllers;

trait BaseMethods
{

    protected function writeLog($file, $message) {

        file_put_contents( 'log/' . $file, $message, FILE_APPEND);

    }

    protected function getStyles() {
        foreach ($this->styles as $style) {
            echo "<link rel='stylesheet' href='$style'>";
        }
    }

    protected function getScripts() {
        foreach ($this->scripts as $script) {
            echo "<script src='$script'></script>";
        }
    }

    protected function getImg($img = '') {
        return  PATH . UPLOAD_DIR . $img;
    }
}