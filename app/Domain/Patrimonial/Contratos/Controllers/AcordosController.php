<?php

namespace App\Domain\Patrimonial\Contratos\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Patrimonial\Contratos\Services\AcordoService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcordosController extends Controller
{
    public function buscarAcordos(Request $request, AcordoService $service)
    {
        $acordos = $service->buscarAcordos($request);
        return new DBJsonResponse($acordos);
    }
}
