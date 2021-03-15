<?php

    class CSRF {

        public static function token()
        {
            if(!isset($_SESSION) && $_SESSION['id']){
                return false;
            }
            $salt = '$'.$_ENV['SECRET_TOKEN'].'$';
            return crypt($_SESSION['id'], $salt);
        }

        public static function verify($token)
        {
            if(!isset($_SESSION) && $_SESSION['id']){
                return false;
            }
            if(!hash_equals(self::token(), $token)){
                return false;
            }
            return true;
        }
    }