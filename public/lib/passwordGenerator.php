<?php

function generatePasswords($length, $lowercase, $uppercase, $number, $symbols) {
        $password = '';
        $includeLowercase = $lowercase;
        $includeUppercase = $uppercase;
        $includeNumbers = $number;
        $includesymbols = $symbols;

        $allowedChars = array();
        $allowedChar = "";
        $lower_case = "abcdefghijklmnopqrstuvwxyz";
        $upper_case = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $num = "1234567890";
        $special_symbol = "!@#$%^&*~";

        if($includeLowercase) { $allowedChars[] = $lower_case; }
        if($includeUppercase) { $allowedChars[] = $upper_case; }
        if($includeNumbers) { $allowedChars[] = $num; }
        if($includesymbols) { $allowedChars[] = $special_symbol; }


        foreach($allowedChars as $chars){
            $password .= $chars[array_rand(str_split($chars))];
            $allowedChar .= $chars;
        }

        $allowedChar = str_split($allowedChar);
        for($i = count($allowedChars); $i < $length; $i++){
            $password .= $allowedChar[array_rand($allowedChar)];
        }
        $password = str_shuffle($password);

        $add_dashes = true;
        if(!$add_dashes)
		    return $password;

        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len)
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;

        return $dash_str;
    }

?>