<?php

namespace core\base\exceptions;


use core\base\controllers\BaseMethods;

class DbException extends \Exception
{

    use BaseMethods;

    public function __construct($message = "", $code = 0)
    {
        parent::__construct($message, $code);

        if(!empty($message)) {

            $error = $this->getMessage();

            $error .= "\r\n" . 'file ' . $this->getFile() . 'In Line ' . $this->getLine() . "\r\n";

            $this->writeLog('DBlog.txt', $error);
        }
    }
}