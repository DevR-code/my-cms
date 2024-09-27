<?php

namespace App\Controllers;

use Core\Controller;


class BlogController extends Controller {

    public function indexAction(){
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