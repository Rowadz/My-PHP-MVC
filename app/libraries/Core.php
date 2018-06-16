<?php 
    /*
    * App Core Class
    * Creates URL & Loads core Controller
    * URL Format - /controller/method/params
    */

class Core{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
        // print_r($this->getUrl());
        $url = $this->getUrl();
        // Look in contollers for first value
        // the path is defined as if we are in the public/index.php
        if(file_exists('../app/controllers/'.ucwords($url[0].'.php'))){
            // is exisits, set as controller
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }
        // Require the controller 
        require_once "../app/controllers/{$this->currentController}.php";
        
        // Instantiate controller class
        $this->currentController = new $this->currentController;
        
        // check for second part of url
        if(isset($url[1])){
            // if method exists in controller
            if(method_exists($this->currentController, $url[1])){
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // GET params
        $this->params = $url ? array_values($url) : [];
        
        // call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

    }

    public function getUrl(): array{
        if(isset($_GET['url'])){
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
        return [0];
    }
}