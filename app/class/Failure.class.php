<?php

class Failure{
    private static $codeMessage = array(
        400 => 'Bad Request',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        412 => 'Precondition Failed',
        500 => 'Internal Server Error'
    );

    public static function fail($code, $message = null) {
        $http = 'HTTP/1.1';
        header($http . ' ' . $code . ' ' . self::$codeMessage[$code]);
        if($message) {
            echo $message;
        }
        exit();
    }
}

?>