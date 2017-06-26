<?php
    session_start();
    class Settings{
        public static function database(){
            $hostname = 'localhost';
            $dbName = 'purichco_tgssys';
            $username = 'purichco_tgssys';
            $password = 'tyubLhZGn';



            $db = new PDO("mysql:host=$hostname;dbname=$dbName; charset=utf8", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $db;
        }

        public static function full_url(){
            $actual_link = '';
            $actual_link .= isset($_SERVER['HTTPS']) ? "https" : "http";
            $actual_link .= '://';
            $actual_link .= $_SERVER['HTTP_HOST'];
            //$actual_link .= explode('/',explode('?',$_SERVER['REQUEST_URI'])[0])[0].'/';
            //$actual_link .= explode('/',explode('?',$_SERVER['REQUEST_URI'])[0])[1].'/';
            $actual_link .= '/visa2017/Cores/';
            return $actual_link;
        }
        public static function full_path(){
            $actual_link = '';
            $actual_link .= isset($_SERVER['HTTPS']) ? "https" : "http";
            $actual_link .= '://';
            $actual_link .= $_SERVER['HTTP_HOST'];
            //$actual_link .= explode('/',explode('?',$_SERVER['REQUEST_URI'])[0])[0].'/';
            //$actual_link .= explode('/',explode('?',$_SERVER['REQUEST_URI'])[0])[1].'/';
            $actual_link .= '/visa2017/';
            return $actual_link;
        }

    }