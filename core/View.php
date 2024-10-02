<?php
namespace Core;

use Core\Config;
class View {

    private $_siteTitle = '', $_content = [], $_currentContent, $buffer, $_layout;
    private $_defaultViewPath;

    public function __construct($path = '') {
        $this->_defaultViewPath = $path;
        $this->_siteTitle = config::get('default_site_title');
    }

    public function setLayout($layout){
        $this->_layout = $layout;
    }
    public function setSiteTitle($title){
        $this->_siteTitle = $title;
    }
     public function getSiteTitle(){
        return $this->_siteTitle;
    }
    public function render($path=''){

        if(empty($path)){
            $path = $this->_defaultViewPath;
        }
        $layoutPath = PROOT . DS . 'app' . DS . 'views' . DS . 'layouts' .DS. $this->_layout . '.php';
        $fullPath = PROOT . DS . 'app' . DS . 'views' . DS . $path . '.php';

        var_dump($layoutPath);

        if(!file_exists($fullPath)){
            throw new \Exception("This view \"{$path}\" does not exist.");
        }
        if(!file_exists($layoutPath)){
            throw new \Exception("This layout \"{$this->_layout}\"does not exist.");

        }

        include($fullPath);
        include($layoutPath);
    }

    public function start($key){
        if(empty($key)){
            throw new \Exception("start method needs a valid key");
        }
        $this -> _buffer = $key ;    //buffer is set stored

        ob_start();     //output buffer starrt;
    }

    public function end(){
        if(empty($this->_buffer)){
            throw new \Exception("run the start method first");
        }
        $this->_content[$this->_buffer] = ob_get_clean();
        $this->_buffer = null;
    }

    public function content($key){
        if(array_key_exists($key, $this->_content)){
            echo $this->_content[$key];
        } else {
            echo '';
        }
    }

    public function partial($path){
        $fullPath = PROOT . DS . 'app' . DS . 'views' . DS . $path . '.php';
        if(file_exists($fullPath)){
            include($fullPath);
        }
    }


}