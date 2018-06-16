<?php
    
    require_once 'config/config.php';
    
    // loading Libraries
    // require_once 'libraries/core.php';
    // require_once 'libraries/controller.php';
    // require_once 'libraries/database.php';

    // Autoload Core Libraries
    // file name should be the same as the class name
    spl_autoload_register(function($className){
        require_once "libraries/{$className}.php";
    });