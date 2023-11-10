<?php

namespace App\Domain\Patrimonial\PNCP\Services;

use App\Domain\Patrimonial\Licitacoes\Models\Licitacao;
use App\Domain\Patrimonial\PNCP\Clients\PNCPClient;
use App\Domain\Patrimonial\PNCP\Exceptions\CompraEditalAvisoExcpetion;
use App\Domain\Patrimonial\PNCP\Models\ComprasPncp;
use App\Domain\Patrimonial\PNCP\Repositories\ItensLicitacaoRepository;
use App\Domain\Patrimonial\PNCP\Resources\CompraEditalAvisoResource;
use DBAttDinamicoValor;
use licitacao as oLicitacao;
use OrcamentoLicitacao;

class ItensLicitacaoService
{
    private $repository;
    private $http;
    const INDEX_ORCAMENTO_SIGILOSO = 34;

    public function __construct(ItensLicitacaoRepository $repository)
    {
        $this->repository = $repository;
        $this->http = new PNCPClient();
    }

    public function buscarItens($where, $campos = '', $groupBy = '')
    {
        return $this->repository->get($campos, $where, $groupBy);
    }

    /**
     * @param oLicitacao $oLicitacao
     * @return string
     */
    private function getValorLicitacao(oLicitacao $oLicitacao)
    {
        $oOrcamentoLicitacao = new OrcamentoLicitacao($oLicitacao);
        return number_format($oOrcamentoLicitacao->getValorTotalEstimado(), 2, ',', '');
    }

    /**
     * @param $licitacao
     * @param $resultadoItem
     * @return object
     * @throws \Exception
     */
    public function dadosLicitacao($licitacao, $resultadoItem, $documento)
    {
        $dados = '';
        if (!empty($resultadoItem)) {
            $compra = ComprasPncp::where('pn03_liclicita', $licitacao)->first();
            if (is_null($compra)) {
                throw new \Exception("Não foi encontrado compra para a licitação {$licitacao}");
            }
            try {
                $resultado = $this->http->buscarCompra($documento, $compra->pn03_ano, $compra->pn03_numero);
            } catch (CompraEditalAvisoExcpetion $e) {
                throw new \Exception($e->getErros());
            }
            $dados = [
                'modalidadeCompra' => $resultado->modalidadeNome,
                'instrumentoConvocatorio' => $resultado->tipoInstrumentoConvocatorioNome,
                'numeroCompra' => "{$resultado->numeroCompra}/{$resultado->anoCompra}",
                'objetoCompra' => $resultado->objetoCompra
            ];
        } else {
            $compra = ComprasPncp::where('pn03_liclicita', $licitacao)->first();
            $cnpj = $documento;
            if (!empty($compra)) {
                return (object)[
                    'link' =>"https://pncp.gov.br/app/editais/{$cnpj}/{$compra->pn03_ano}/{$compra->pn03_numero}"
                ];
            }
        }

        if (empty($licitacao)) {
            throw new \Exception('Codigo da licitação não pode ser vazio');
        }
        $model = Licitacao::where('l20_codigo', $licitacao)->first();
        $licitacao = new \licitacao($licitacao);
        $itens = $licitacao->getItens();

        $orcamentoSigiloso = 'f';
        if (!is_null($model->orcamentoSigiloso()->first())) {
            $valores = DBAttDinamicoValor::getValores($model->getOrcamentoSigiloso());
            $orcamentoSigiloso = '';
            foreach ($valores as $valor) {
                if ($valor->getAtributo()->getNome() === 'orcamentosigiloso') {
                    $orcamentoSigiloso = $valor->getValor();
                }
            }
        }
        return CompraEditalAvisoResource::toResponse($model, $orcamentoSigiloso, $itens, $dados);
    }
}
