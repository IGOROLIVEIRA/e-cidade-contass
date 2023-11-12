<?php
namespace App\Domain\Financeiro\Contabilidade\Controllers;

use App\Domain\Financeiro\Contabilidade\Services\DisponibilidadeRecursoService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use stdClass;
use DBDate;

/**
 * Class DisponibilidadeRecursoController
 * @package App\Domain\Financeiro\Contabilidade\Controllers
 */
class DisponibilidadeRecursoController extends Controller
{
    private $service;
    private $filtros;

    public function __construct(DisponibilidadeRecursoService $service)
    {
        $this->service = $service;
    }

    public function processarSaldoDisponibilidadeRecurso(Request $request)
    {
        $this->parseFiltros($request);
        $file = $this->service->relatorioSaldoDisponibilidadeRecurso($this->filtros);
        return new DBJsonResponse(['pdf' => $file]);
    }

    public function relatorioConferenciaPorRecurso(Request $request)
    {
        $this->parseFiltros($request);
        $file = $this->service->relatorioConferenciaPorRecurso($this->filtros);
        return new DBJsonResponse(['pdf' => $file]);
    }
    
    public function obterDadosConferenciaPorRecurso(Request $request)
    {
        $this->parseFiltros($request);
        $response = $this->service->obterDadosConferenciaPorRecurso($this->filtros);
        return new DBJsonResponse($response);
    }

    private function parseFiltros(Request $request)
    {
        $rule = [

            "dataInicial" => ['required', 'date'],
            "dataFinal" => ['required', 'date'],
            "instituicoes" =>  ['required', 'array'],
            "instituicoes.*" =>  ['required', 'integer']
        ];

        $mensagens = [
            "instituicoes.*" => "Selecione uma Institui��o V�lida."
        ];


        validaRequest($request->all(), $rule, $mensagens);

        $filtros = new stdClass();
        $filtros->dataInicial = DBDate::converter($request->dataInicial);
        $filtros->dataFinal = DBDate::converter($request->dataFinal);
        $filtros->instituicoes = implode(", ", $request->instituicoes);
        $filtros->ano = $request->DB_anousu;

        $this->filtros =  $filtros;
    }
}
