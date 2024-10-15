<?php

namespace App\Controllers;


use Core\{DB, Controller, H};


class BlogController extends Controller {

    public function indexAction(){
        $db = DB::getInstance();
        //$sql = "INSERT INTO articles (`title`, `body`)  VALUES (:title, :body)";
        // $bind = ['title' => 'new article', 'body' => 'article body'];
        // $query =  $db->execute($sql, $bind);
        // $lastId = $query->lastInsertId();
        // H::dnd($lastId);
        //=========================//
        //$db->insert('articles', ['title' => 'article', 'body' => 'Heres Article Body']);
        //$db->update('articles', ['title' => 'article update', 'body' => 'body updated'], ['id' => '12', 'article' => 'foo']);
        $db->update('articles', ['title' => 'article updated', 'body' => 'body updated'], ['id' => 13]);
        //$db->update('articles', ['title' => 'Updated Title', 'body' => 'Updated Body'], ['id' => 54]);


        //H::dnd($db, false);

        // $sql = "SELECT * FROM articles";
        // $query = $db->query($sql);
        // $articles = $db->query($sql) -> getResults();
        // $count = $query->lastInsertId();

        // H::dnd($articles);
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