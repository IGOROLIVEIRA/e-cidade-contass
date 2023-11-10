<?php

namespace App\Domain\RecursosHumanos\Pessoal\Controller;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Core\Models\BatchJob;
use App\Domain\RecursosHumanos\Pessoal\Services\ContraChequeService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class ContraChequesController extends Controller
{
    /**
     * @param Request $request
     * @return DBJsonResponse
     * @throws Exception
     */
    public function processarEmissao(Request $request)
    {
        validaRequest(
            $request->all(),
            [
                'DB_instit' => ['required', 'integer'],
                'ano' => ['required', 'integer'],
                'mes' => ['required', 'integer']
            ],
            [
                'DB_instit.required' => 'Instituição não informada'
            ]
        );

        $contraChequeService = new ContraChequeService();
        $contraChequeService->gerarContraChequePdf(
            $request->get('ano'),
            $request->get('mes'),
            db_getsession('DB_instit')
        );

        return new DBJsonResponse([], 'Emissão de contra cheques gerada com sucesso.');
    }

    /**
     * @param Request $request
     * @return DBJsonResponse
     * @throws Exception
     */
    public function buscarEmitidos(Request $request)
    {
        if (!$request->has('DB_instit')) {
            throw new Exception("Instituição não informada");
        }

        $contrachequeService = new ContraChequeService();
        $itens = $contrachequeService->buscarLotes($request->get('DB_instit'));

        return new DBJsonResponse($itens, '');
    }

    public function cancelarEmissao(Request $request)
    {
        if (!$request->has('batch_id')) {
            throw new Exception("Código do Lote não informado");
        }

        $batchJob = BatchJob::find($request->get('batch_id'));
        $batchJob->cancelled = true;
        $batchJob->save();

        return new DBJsonResponse([], 'Lote cancelado');
    }
}
