<?php

spl_autoload_register(function($className) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    if($file = realpath(dirname(__FILE__)."/{$class}.php"))
        require $file;
});