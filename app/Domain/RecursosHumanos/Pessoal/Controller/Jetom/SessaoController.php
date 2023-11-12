<?php

namespace App\Domain\RecursosHumanos\Pessoal\Controller\Jetom;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Domain\RecursosHumanos\Pessoal\Model\Jetom\Sessao;
use App\Domain\RecursosHumanos\Pessoal\Model\Jetom\PermissaoComissao;
use App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\Sessao\SessaoProcessamentoRequest;
use App\Domain\RecursosHumanos\Pessoal\Requests\Jetom\Sessao\SessaoRequest;
use App\Domain\RecursosHumanos\Pessoal\Services\Jetom\SessaoService;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use ECidade\Lib\Session\DefaultSession;
use App\Domain\RecursosHumanos\Pessoal\Repository\Helper\CompetenciaHelper;

class SessaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request, Sessao $sessao)
    {
        try {
            $codigo_instituicao = $request->get('instituicao');

            if (isset($codigo_instituicao) && !empty($codigo_instituicao)) {
                DefaultSession::getInstance()->set('DB_instit', $codigo_instituicao);
            }

            DefaultSession::getInstance()->atualizaDadosUsuario($request->usuario);

            $db_session = [
                'id_usuario' => (int)DefaultSession::getInstance()->get('DB_id_usuario'),
                'instit' => (int)DefaultSession::getInstance()->get('DB_instit')
            ];

            $competencia = CompetenciaHelper::get();
            $ano_competencia = $competencia->getAno();
            $mes_competencia = $competencia->getMes();

            if ($request->ano) {
                $ano_competencia = $request->ano;
            }

            if ($request->mes) {
                $mes_competencia = $request->mes;
            }

            /* Retorno da rotina Sess�es */
            if (!$request->get('rh247_processada')) {
                $em_processo = [];

                return new DBJsonResponse(
                    Sessao::with('servidores')->where($em_processo)->orderBy('rh247_data', 'desc')
                    ->when($mes_competencia, function ($query) use ($mes_competencia) {
                        return $query->where('rh247_mes', $mes_competencia);
                    })
                    ->when($ano_competencia, function ($query) use ($ano_competencia) {
                        return $query->where('rh247_ano', $ano_competencia);
                    })->get()
                );
            }

            /**
             * Verificamos se o usuario logado e o dbseller
             */
            if (DefaultSession::getInstance()->get('DB_id_usuario') != 1) {
                $dataMatriculas = $sessao::usuarioLoginsAtivos($db_session);

                /* Busca dados da permiss�o para o servidor */
                $permissaoData = PermissaoComissao::whereIn(
                    'rh251_matricula',
                    $dataMatriculas
                )->get();

                /* Verifica se o servidor tem permiss�o */
                if ($permissaoData->isEmpty()) {
                    throw new Exception("Servidor sem permiss�o.");
                }

                // dados de comissoes
                $dataComissoes = $permissaoData->map(
                    function ($model) {
                        return $model->rh251_comissao;
                    }
                )->toArray();
            }
            /**
             * se estiver na pagina de processamento, seta coluna processada
             */
            $em_processo = $request->get('rh247_processada') ?
            ['rh247_processada' => $request->get('rh247_processada')]
            : [] ;

            /**
             * Verificamos se o usuario logado e o dbseller
             */
            $sessaoData = [];
            if (DefaultSession::getInstance()->get('DB_id_usuario') != 1) {
                $sessaoData = Sessao::with('servidores')
                ->where($em_processo)->orderBy('rh247_data', 'desc')
                ->when($mes_competencia, function ($query) use ($mes_competencia) {
                    return $query->where('rh247_mes', $mes_competencia);
                })->when($ano_competencia, function ($query) use ($ano_competencia) {
                    return $query->where('rh247_ano', $ano_competencia);
                })
                ->join('jetomcomissao', 'rh242_sequencial', 'rh247_comissao')
                ->where('rh242_instit', DefaultSession::getInstance()->get('DB_instit')) // busca por instituicao
                ->whereIn('rh242_sequencial', $dataComissoes) // busca por comiss�es
                ->get();
            } else {
                $sessaoData = Sessao::with('servidores')
                    ->where($em_processo)->orderBy('rh247_data', 'desc')
                    ->when($mes_competencia, function ($query) use ($mes_competencia) {
                        return $query->where('rh247_mes', $mes_competencia);
                    })->when($ano_competencia, function ($query) use ($ano_competencia) {
                        return $query->where('rh247_ano', $ano_competencia);
                    })
                    ->join('jetomcomissao', 'rh242_sequencial', 'rh247_comissao')
                    ->where('rh242_instit', DefaultSession::getInstance()->get('DB_instit')) // busca por instituica
                    ->get();
            }

            /* Retorno da rotina Processamento */
            return new DBJsonResponse(
                $sessaoData
            );
        } catch (Exception $exception) {
            return new DBJsonResponse(
                ['exception' => $exception->getMessage()],
                'N�o foi poss�vel buscar as informa��es da Sess�o.',
                400
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SessaoRequest $request
     * @return JsonResponse
     */
    public function store(SessaoRequest $request)
    {
        try {
            $erros = SessaoService::lancamentoLote($request);
            return new DBJsonResponse($erros, "Sess�es lan�adas com sucesso.");
        } catch (Exception $e) {
            return new DBJsonResponse(
                [],
                $e->getMessage(),
                400
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            $sessao = Sessao::with(['servidores', 'comissao.servidores'])->find($id);

            if (empty($sessao)) {
                return new DBJsonResponse([], 'Nenhuma Sess�o foi encontrada com o c�digo informado.', 410);
            }

            return new DBJsonResponse($sessao);
        } catch (Exception $exception) {
            return new DBJsonResponse(
                null,
                'N�o foi poss�vel buscar as informa��o da Sess�o.',
                400
            );
        }
    }

    /**
     * @param int $id
     * @return DBJsonResponse
     */
    public function destroy($id)
    {
        try {
            $sessao = Sessao::find($id);

            if (empty($sessao)) {
                throw new Exception('Nenhuma Sess�o foi encontrada com o c�digo informado.');
            }

            if ($sessao->isProcessada()) {
                throw new Exception('N�o � poss�vel excluir uma Sess�o j� processada.');
            }

            $sessao->servidores()->delete();
            $sessao->delete();
        } catch (Exception $exception) {
            return new DBJsonResponse(null, $exception->getMessage(), 400);
        }

        return new DBJsonResponse($sessao, 'Sess�o exclu�da com sucesso.');
    }

    /**
     * @param SessaoProcessamentoRequest $request
     * @return DBJsonResponse
     */
    public function processar(SessaoProcessamentoRequest $request)
    {
        try {
            $sessoesProcessadas = [];
            foreach ($request->get('ids') as $id) {
                $sessao = Sessao::with('servidores')->find($id);
                if (empty($sessao)) {
                    throw new Exception('Nenhuma Sess�o foi encontrada com o c�digo informado.');
                }

                if ($sessao->isProcessada()) {
                    throw new Exception('N�o � poss�vel reprocessar uma Sess�o.');
                }

                $sessao->processar();

                $sessoesProcessadas[] = $sessao;
            }

            $descricao = "Sess�o processada";
            if (count($request->get('ids')) > 1) {
                $descricao = "Sess�es processadas";
            }

            return new DBJsonResponse($sessoesProcessadas, "{$descricao} com sucesso.");
        } catch (Exception $exception) {
            return new DBJsonResponse(null, $exception->getMessage(), 400);
        }
    }
}
