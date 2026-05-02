<?php
spl_autoload_register(function($className){
    $directories = [
        APP_PATH . '/core/',
        APP_PATH . '/controllers/',
        APP_PATH . '/models/'
    ];
    foreach($directories as $directory){
        $file = $directory . $className . '.php';
        if (file_exists($file)){
            require_once $file;
            return ;
        }
    }
});