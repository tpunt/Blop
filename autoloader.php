<?php

function autoload($className)
{
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $className);

    if($file = realpath(dirname(__FILE__)."/{$class}.php"))
        require $file;
    //else die($class);
}

spl_autoload_register('autoload');