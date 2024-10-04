<?php

namespace Core;

class Config{
    private static $config = [
        "version" => '0.0.1',
        "root_dir" => '/cms/',  // "/" on live server
        "default_controller" => 'Blog',         //default home ctrler
        "default_layout" => 'default',      //default ;layout
        "default_site_title" => 'Freewriter',   //default site title
        "db_host" => '127.0.0.1',     //DB host ---faster with IP address
        "db_name" => 'cms_db',           //DB Name
        "db_user" => 'root',         //DB user
        "db_password" => '',       //DB password
        "login_cookie_name" => 'm#lc#nm'       //login cookie name
    ];

    public static function get($key){
        return array_key_exists($key, self::$config) ? self::$config[$key] : NULL;
    }
}