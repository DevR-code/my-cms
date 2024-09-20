<?php

namespace Core;
use App\Controller\BlogCtrlr;                                                                                                                                                                                                     
class Router {
    public static function route($url){
        //var_dump($url);

        $controller = new BlogCtrlr('Blog', 'indexAction');
    }
}