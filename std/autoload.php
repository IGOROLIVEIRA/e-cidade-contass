<?php

spl_autoload_register(function ($class_name) {
    $path = __DIR__ . '/{**/*,*}';
    $all_files = array_diff(
        glob($path, GLOB_BRACE),
        glob($path, GLOB_BRACE | GLOB_ONLYDIR)
    );

    foreach ($all_files as $file) {
        if (is_file($file) && strpos($file, $class_name . '.php') !== false) {
            require_once $file;
        }
    }
});
