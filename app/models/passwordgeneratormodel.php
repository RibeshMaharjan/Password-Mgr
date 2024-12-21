<?php

require_once __DIR__.'/../core/model.php';
if (!isset($_SESSION)) {
    session_start();
}

class GeneratorModel extends Model {

    public function __construct() {
    }

    public function generatePasswords($length, $lowercase, $uppercase, $number, $symbols) {
        $password = "";
        $lower_case = "abcdefghijklmnopqrstuvwxyz";
        $upper_case = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $num = "1234567890";
        $special_symbol = "!@#$%^&*~";

        $lower_case = str_shuffle($lower_case);
        $upper_case = str_shuffle($upper_case);
        $num = str_shuffle($num);
        $special_symbol = str_shuffle($special_symbol);

        $password .= substr($lower_case, 0, rand(1, strlen($lower_case) - 1));
        $password .= substr($upper_case, 0, rand(1, strlen($upper_case) - 1));
        $password .= substr($num, 0, rand(1, strlen($num) - 1));
        $password .= substr($special_symbol, 0, rand(1, strlen($special_symbol) - 1));

        $password = str_shuffle($password);
        
        return $password;
    }
}