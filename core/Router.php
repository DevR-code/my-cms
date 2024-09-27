<?php
namespace Core;

class Router {
    public static function route($url) {
        //$urlParts = explode('/', $url);
        $urlParts = explode('/', trim($url, '/'));   //break up url into array.
      

        //set controller
        $controller = !empty($urlParts[1]) ? $urlParts[1] : Config::get('default_controller');        
        $controllerName = $controller;
        $controller = '\App\Controllers\\' . ucwords($controller) . 'Controller';
    //  var_dump($controller);
    //  echo("<br/>");
      // echo("<br/>");
        //set action
        array_shift($urlParts);
        $action = !empty($urlParts[1]) ? $urlParts[1] : 'index';
        $actionName = $action;
        $action .= "Action";
        array_shift($urlParts);
        //var_dump($action);
      
        // if(!class_exists($controller)){
        //      echo("class not exists");
        //      throw new \Exception("the controller \"{$controller}\" does not exist.");
        // } else{
        //     echo("<br />");
        //     echo ("it indeed exist");
        // }

         if(!class_exists($controller)){
            throw new \Exception("the controller \"{$controller}\" does not exist.");
        }
       
       
        $controllerClass = new $controller($controllerName, $actionName);
          //var_dump($controllerClass);

        if(!method_exists($controllerClass, $action)){
            throw new \Exception("the method\"{$action}\" does not exist on the \"{$controller}\" controller.");
        }

       call_user_func_array([$controllerClass, $action], $urlParts);


        //$controller = new BlogCtrlr('Blog', 'indexAction');
    }
}
