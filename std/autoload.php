<?php

spl_autoload_register(function ($class_name) {
    $path = __DIR__ . '/{**/*,*}';
    $all_files = array_diff(
        glob($path, GLOB_BRACE),
        glob($path, GLOB_BRACE | GLOB_ONLYDIR)
    );

    foreach ($all_files as $file) {
        if (is_file($file)) {
            require_once $file;
        }
    }
});
