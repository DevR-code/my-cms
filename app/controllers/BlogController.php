<?php

namespace App\Controllers;


use Core\{DB, Controller, H};


class BlogController extends Controller {

    public function indexAction(){
        $db = DB::getInstance();
        H::dnd($db, false);
       
        $this->view->setSiteTitle('Latest articles');    //you can set the blog title here  --before rendering
        $this->view->render();       
    }
}
    
//     public function indexAction($param1, $param2)    
//     {
//         die("You are at the index action!{$param1} {$param2}");
//     }
//     public function fooAction(){
//         die("now you're in the fooAction");
//     }

// }