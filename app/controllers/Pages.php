<?php 
    class Pages extends Controller{
        public function __construct(){
            
        }
        public function index(){
            $x =  [
                'title' => 'welcome'
            ];
            
            $this->view('pages/index', $x);
        }
        public function about(){
            $x = [
                'title' => 'about us'
            ];
            $this->view('pages/about', $x);
        }
    }