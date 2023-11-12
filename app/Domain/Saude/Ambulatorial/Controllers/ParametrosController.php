<?php

namespace App\Domain\Saude\Ambulatorial\Controllers;

use App\Http\Controllers\Controller;
use App\Domain\Saude\Ambulatorial\Models\Parametros;
use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use Exception;

class ParametrosController extends Controller
{
    public function get()
    {
        $parametros = Parametros::get()->shift();

        if (!$parametros) {
            throw new Exception('N�o foram encontrados par�metros para o m�dulo Ambulatorial.');
        }

        return new DBJsonResponse($parametros);
    }
}
