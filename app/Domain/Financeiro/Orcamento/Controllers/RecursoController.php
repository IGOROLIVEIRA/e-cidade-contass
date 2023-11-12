<?php

namespace App\Domain\Financeiro\Orcamento\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Financeiro\Orcamento\Models\FonteRecurso;
use App\Domain\Financeiro\Orcamento\Models\RecursoDetalhamento;
use App\Domain\Financeiro\Orcamento\Requests\Cadastro\RecursosExcluirRequest;
use App\Domain\Financeiro\Orcamento\Requests\Cadastro\RecursosInativarRequest;
use App\Domain\Financeiro\Orcamento\Requests\Cadastro\RecursosSalvarRequest;
use App\Domain\Financeiro\Orcamento\Requests\ImportaDeParaSiconfi2022Request;
use App\Domain\Financeiro\Orcamento\Services\DeParaRecursosSiconfiService;
use App\Domain\Financeiro\Orcamento\Services\RecursoService;
use App\Domain\Financeiro\Orcamento\Services\RecursosSiconfiService;
use App\Domain\Financeiro\Orcamento\Services\Relatorios\ListaRecusosSiconfiService;
use Exception;

class RecursoController
{
    /**
     * @var RecursoService
     */
    private $service;

    public function __construct(RecursoService $recursoService)
    {
        $this->service = $recursoService;
    }

    public function salvar(RecursosSalvarRequest $request)
    {
        $this->service->salvar($request->all());

        return new DBJsonResponse([], 'Recurso salvo com sucesso.');
    }

    public function buscar($id, $exercicio)
    {
        $recurso = $this->service->buscar($id, $exercicio);
        return new DBJsonResponse($recurso, 'Recurso salvo com sucesso.');
    }

    public function recursosInativar($exercicio)
    {
        $service = new RecursosSiconfiService();
        $recursos = array_values($service->getRecursos($exercicio)->toArray());
        return new DBJsonResponse($recursos, 'Lista de Recursos.');
    }

    public function inativar(RecursosInativarRequest $request)
    {
        $this->service->inativar($request->all());
        return new DBJsonResponse([], 'Recursos inativados.');
    }

    /**
     * @param RecursosExcluirRequest $request
     * @return DBJsonResponse
     * @throws Exception
     */
    public function excluir(RecursosExcluirRequest $request)
    {
        $recursosUtilizados = $this->service->excluir($request->all());

        $msg = "Nem todos recursos foram exclu�dos. Recursos que j� foram utilizados devem ser inativados.";
        if (empty($recursosUtilizados)) {
            $msg = "Todos recursos foram exclu�dos com sucesso.";
        }
        return new DBJsonResponse([], $msg);
    }


    /**
     * @return DBJsonResponse
     */
    public function listaSiconfi2022()
    {
        $service = new ListaRecusosSiconfiService();
        return new DBJsonResponse($service->emitir(), 'Lista de Recursos');
    }

    public function exportarPlanilhaSiconfi($exercicio)
    {
        $service = new DeParaRecursosSiconfiService();
        return new DBJsonResponse($service->exportar($exercicio), 'Lista de Recursos');
    }

    public function importarPlanilhaSiconfi(ImportaDeParaSiconfi2022Request $request)
    {
        $service = new DeParaRecursosSiconfiService();
        $service->importar($request->all());
        return new DBJsonResponse([], 'Recursos atualizados');
    }

    public function tiposDetalhamento()
    {
        $detalhamentos = RecursoDetalhamento::all()
            ->sortBy('o203_codigo')
            ->map(function (RecursoDetalhamento $detalhamento) {
                $codigo = str_pad($detalhamento->o203_codigo, 2, '0', STR_PAD_LEFT);
                return ['codigo' => $codigo, 'descricao' => $detalhamento->o203_descricao];
            });

        return new DBJsonResponse($detalhamentos, 'Recursos atualizados');
    }

    /**
     * Retorna os recursos sabidos depreciados em 2022 para 2023 pois esses devem ser recriados com os complementos
     * @return DBJsonResponse
     */
    public function depreciados2022($exercicio)
    {
        $recursos = FonteRecurso::with('recurso')
            ->where('exercicio', $exercicio)
            ->orderBy('gestao')
            ->get()
            ->filter(function (FonteRecurso $fonteRecurso) {
                return in_array($fonteRecurso->recurso->o15_recurso, ['0001', '0020', '0030', '0031', '0040']);
            })
            ->toArray();
        return new DBJsonResponse(array_values($recursos), 'Recursos atualizados');
    }

    public function get($exercicio, $data = null)
    {
        if (!empty($data)) {
            $exercicio = explode('-', $data)[0];
        }
        $recursos = FonteRecurso::where('exercicio', $exercicio)
            ->join('orctiporec', 'o15_codigo', 'orctiporec_id')
            ->join('complementofonterecurso', 'o200_sequencial', 'o15_complemento')
            ->when(!empty($data), function ($query) use ($data) {
                    $query->whereRaw("(o15_datalimite is null or o15_datalimite >= ?)", [$data]);
            })
            ->orderBy('o15_recurso')
            ->orderBy('o15_complemento')
            ->orderBy('gestao')
            ->get()
            ->toArray();
        return new DBJsonResponse(array_values($recursos), 'Recursos atualizados');
    }
}
