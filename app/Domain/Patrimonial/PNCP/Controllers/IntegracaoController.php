<?php

namespace App\Domain\Patrimonial\PNCP\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Patrimonial\PNCP\Requests\IntegracaoRequest;
use App\Domain\Patrimonial\PNCP\Services\HabilitarIntegracaoService;
use App\Http\Controllers\Controller;
use function App\Domain\Patrimonial\Patrimonio\Controllers\env;
use Illuminate\Http\Request;

class IntegracaoController extends Controller
{
    /**
     * @param IntegracaoRequest $request
     * @param HabilitarIntegracaoService $service
     * @return DBJsonResponse|void
     */
    public function habilitar(IntegracaoRequest $request, HabilitarIntegracaoService $service)
    {
        if ($request->request->get('habilitar_pncp') === "habilitar") {
            $habilitarPNCP = $service->habilitarIntegracaoPNCP(
                $request->documento,
                $request->DB_instit,
                $request->DB_id_usuario
            );

            return new DBJsonResponse([], $habilitarPNCP);
        }
    }

    /**
     * @param Request $request
     * @param HabilitarIntegracaoService $service
     * @return DBJsonResponse
     */
    public function verificaIntegracao(Request $request, HabilitarIntegracaoService $service)
    {
        $verificaEnteAutorizado = $service->verificaIntegracao($request->get('DB_instit'));
        return new DBJsonResponse($verificaEnteAutorizado, '');
    }
}
