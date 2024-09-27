<?php 
namespace Core;
use Core\{View, Config};
class Controller{
    private $_controllerName, $_actionName;
    public $view, $request;

    public function __construct($controller, $action){
        $this->_controllerName = $controller;
        $this-> _actionName = $action;
        //var_dump($controller);
        $viewPath = strtolower($controller) . '/' .$action;       //while loading blog index, looks for dir- blog and view -index
        $this->view = new View($viewPath);
        $this->view->setLayout(Config::get('default_layout'));
    }
}