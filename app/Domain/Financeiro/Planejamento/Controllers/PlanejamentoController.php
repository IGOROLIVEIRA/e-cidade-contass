<?php


namespace App\Domain\Financeiro\Planejamento\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\Financeiro\Planejamento\Models\Planejamento;
use App\Domain\Financeiro\Planejamento\Requests\IdentidadeOrganizacionalRequest;
use App\Domain\Financeiro\Planejamento\Requests\SalvarComissaoRequest;
use App\Domain\Financeiro\Planejamento\Requests\SalvarLDORequest;
use App\Domain\Financeiro\Planejamento\Requests\SalvarObjetivoRequest;
use App\Domain\Financeiro\Planejamento\Requests\SalvarPPARequest;
use App\Domain\Financeiro\Planejamento\Services\LdoService;
use App\Domain\Financeiro\Planejamento\Services\LoaService;
use App\Domain\Financeiro\Planejamento\Services\PlanejamentoService;
use App\Domain\Financeiro\Planejamento\Services\PpaService;
use App\Domain\Financeiro\Planejamento\Services\Relatorios\ProjecoesPorRecursoService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

/**
 * Class PlanejamentoController
 * @package App\Domain\Financeiro\Planejamento\Controllers
 */
class PlanejamentoController extends Controller
{
    /**
     * @var PlanejamentoService
     */
    private $service;

    public function __construct(PlanejamentoService $service)
    {
        $this->service = $service;
    }

    /**
     * Salva o PPA
     * @param SalvarPPARequest $request
     * @param PpaService $service
     * @return DBJsonResponse
     * @throws Exception
     */
    public function salvarPPA(SalvarPPARequest $request, PpaService $service)
    {
        $ppa = $service->salvar($request);
        return new DBJsonResponse($ppa, "PPA salvo com sucesso.");
    }

    /**
     * Salva a LDO
     * @param SalvarLDORequest $request
     * @param LdoService $service
     * @return DBJsonResponse
     * @throws Exception
     */
    public function salvarLDO(SalvarLDORequest $request, LdoService $service)
    {
        $ppa = $service->salvar($request);
        return new DBJsonResponse($ppa, "LDO salva com sucesso.");
    }

    /**
     * Salva a LDO
     * @param SalvarLDORequest $request
     * @param LdoService $service
     * @return DBJsonResponse
     * @throws Exception
     */
    public function salvarLOA(SalvarLDORequest $request, LoaService $service)
    {
        $ppa = $service->salvar($request);
        return new DBJsonResponse($ppa, "LDO salva com sucesso.");
    }

    /**
     * Da manuten��o apenas na Identidade Organizacional do plano
     * @param IdentidadeOrganizacionalRequest $request
     * @return DBJsonResponse
     */
    public function salvarIdentidadeOrganizacional(IdentidadeOrganizacionalRequest $request)
    {
        $planejamento = $this->service->salvarIdentidadeOrganizacional($request);
        return new DBJsonResponse($planejamento, 'Identidade Organizacional salva com sucesso.');
    }

    /**
     * Retorna os dados de um planejamento
     * @param $id
     * @param PlanejamentoService $service
     * @return DBJsonResponse
     */
    public function show($id)
    {
        return new DBJsonResponse($this->service->find($id)->toArray(), 'Planejamento encontrado');
    }

    /**
     * @param string $tipo
     * @param integer $status
     * @return DBJsonResponse
     */
    public function index($tipo, $status)
    {
        $filtro = [['pl2_tipo', "$tipo"], ['pl2_ativo', 't'], ['pl2_status', 1]];
        if (!empty($status)) {
            $filtro = [['pl2_tipo', "$tipo"], ['pl2_ativo', 't'], ['pl2_status', $status]];
        }
        $planos = Planejamento::with('status')->where($filtro)
            ->orderBy('pl2_created_at')->get()
            ->toArray();

        return new DBJsonResponse($planos, 'Planejamento encontrado');
    }

    /**
     * @param $tipo
     * @return DBJsonResponse
     */
    public function porTipo($tipo)
    {
        $filtro = [['pl2_tipo', "$tipo"], ['pl2_ativo', 't']];
        $planos = Planejamento::with('status')->where($filtro)
            ->orderBy('pl2_created_at')->get()
            ->toArray();

        return new DBJsonResponse($planos, 'Planejamento encontrado');
    }

    /**
     * @param null $tipo
     * @return DBJsonResponse
     */
    public function planejamentoEmDesenvolvimento($tipo = null)
    {
        $service = new PlanejamentoService();
        $plano = $service->planejamentoEmDesenvolvimento($tipo)->toArray();
        return new DBJsonResponse($plano, 'Planejamentos encontrados.');
    }

    /**
     * Retorna as situa��es que pode ser atualizado o plano.
     * @param $id
     * @return DBJsonResponse
     * @throws Exception
     */
    public function possiveisSituacoesAtualizar($id)
    {
        return new DBJsonResponse($this->service->possiveisSituacoesAtualizar(Planejamento::find($id)), "");
    }

    /**
     * @param Request $request
     * @return DBJsonResponse
     * @throws Exception
     */
    public function remove(Request $request)
    {
        $this->service->remover($request->get('pl2_codigo'));
        return new DBJsonResponse([], 'Planejamento removido com sucesso.');
    }

    /**
     * Salva a comiss�o do plano
     * @param SalvarComissaoRequest $request
     * @return DBJsonResponse
     */
    public function salvarComissao(SalvarComissaoRequest $request)
    {
        $planejamento = $this->service->salvarComissao($request);
        return new DBJsonResponse($planejamento->toArray(), 'Comiss�o do planejamento salva.');
    }

    /**
     * @param SalvarObjetivoRequest $request
     * @return DBJsonResponse
     */
    public function salvarObjetivoEstrategico(SalvarObjetivoRequest $request)
    {
        $msg = 'Objetivo Estrat�gicos adicionado a �rea de Trabalho.';
        if ($request->has('pl5_codigo') && $request->get('pl5_codigo') != '') {
            $msg = 'Altera��es efetuada com sucesso.';
        }

        return new DBJsonResponse($this->service->salvarObjetivoEstrategico($request)->toArray(), $msg);
    }

    /**
     * Remove o objetivo estrat�gico
     * @param Request $request
     * @return DBJsonResponse
     * @throws Exception
     */
    public function removerObjetivoEstrategico(Request $request)
    {
        if ($request->has('pl5_codigo') && $request->get('pl5_codigo') === '') {
            throw new Exception("Informe o c�digo do Objetivo que deseja excluir.", 406);
        }
        $this->service->removerObjetivoEstrategico($request->get('pl5_codigo'));
        return new DBJsonResponse([], "Objetivo Estrat�gico removido com sucesso.");
    }

    /**
     * Cria um novo plano vinculado ao plano pai
     * @param Request $request
     * @return DBJsonResponse
     * @throws Exception
     */
    public function criarVinculo(Request $request)
    {
        if (!$request->has('tipo') || $request->get('tipo') === '') {
            throw new Exception("Voc� deve informar o tipo a qual deseja criar.", 406);
        }

        if (!$request->has('tipoVincular') || $request->get('tipoVincular') === '') {
            throw new Exception("Voc� deve informar o tipo a qual deseja vincular.", 406);
        }

        $plano = $this->service->criarVinculo($request->get('tipo'), $request->get('tipoVincular'));
        return new DBJsonResponse($plano->toArray(), "V�nculado com sucesso sucesso.");
    }


    public function porRecurso(Request $request)
    {

        $service = new ProjecoesPorRecursoService($request->all());
        return new DBJsonResponse($service->emitir(), "Proje��es por recurso");
    }
}
