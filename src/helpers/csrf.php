<?php

    class CSRF {

        public static function token()
        {
            $data= random_bytes(32);
            $salt = '$'.$_ENV['SECRET_TOKEN'].'$';
            $token = crypt($data, $salt);
            $_SESSION['csrf'] = $token;

            return $token;
        }

        public static function verify($token)
        {
            if(!isset($_SESSION) && $_SESSION['id']){
                return false;
            }
            if($_SESSION['csrf'] != $token){
                return false;
            }
            unset($_SESSION['csrf']);
            return true;
        }
    }