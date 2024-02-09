<?php

try {

    if (preg_match('/[^?]*api\/v\d\//', $_SERVER['REQUEST_URI'])) {
        return require_once 'api/api.php';
    }

    if (preg_match('/[^?]*\/api/', $_SERVER['REQUEST_URI'])) {
        return require_once 'public/index.php';
    }

    return require('app.php');
} catch (Exception $e) {
    if (config('app.debug')) {
        throw $e;
    }
    //@todo - verificar a possíbilidade de enviar o erro para o monitoramento
    logger()->emergency($e->getMessage(), $e->getTrace());
}

