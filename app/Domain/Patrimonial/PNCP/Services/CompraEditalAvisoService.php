<?php

namespace App\Domain\Patrimonial\PNCP\Services;

use App\Domain\Patrimonial\Licitacoes\Models\EventoLicitacao;
use App\Domain\Patrimonial\Licitacoes\Models\Licitacao;
use App\Domain\Patrimonial\Licitacoes\Models\LiclicitaEncerramentoLicitacon;
use App\Domain\Patrimonial\PNCP\Clients\PNCPClient;
use App\Domain\Patrimonial\PNCP\Enum\ModalidadeCompraEnum;
use App\Domain\Patrimonial\PNCP\Exceptions\CompraEditalAvisoExcpetion;
use App\Domain\Patrimonial\PNCP\Models\ComprasPncp;
use App\Domain\Patrimonial\PNCP\Requests\InclusaoCEARequest;
use App\Domain\Patrimonial\PNCP\Resources\EditaisResource;
use App\Domain\Patrimonial\Protocolo\Model\Cgm;
use App\Domain\Patrimonial\Protocolo\Model\CgmEstrangeiro;
use App\Domain\Patrimonial\Protocolo\Repository\CgmRepository;
use db_stdClass;
use EventoLicitacao as Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LicitanteLicitaCon;

class CompraEditalAvisoService
{
    private $http;

    public function __construct()
    {
        $this->http = new PNCPClient();
    }

    /**
     * @param InclusaoCEARequest $request
     * @return string
     * @throws \DBException
     * @throws \ParameterException
     */
    public function incluirCompra(InclusaoCEARequest $request)
    {
        $dataAberturaProposta = (new \DateTime(
            $request->dataAberturaProposta . ' ' . $request->horaAberturaProposta
        ))->format('Y-m-d\TH:i:s');
        $dataEncerramentoProposta = (new \DateTime(
            $request->dataEncerramentoProposta . ' ' . $request->horaEncerramentoProposta
        ))->format('Y-m-d\TH:i:s');
        $this->verificaItens($request->itensCompra);
        $compra = (object)[
            'anoCompra' => intval($request->anoCompra),
            'itensCompra' => (json_decode(stripslashes(utf8_encode($request->itensCompra)))),
            'tipoInstrumentoConvocatorioId' => $request->instrumentoConvocatorio,
            'modalidadeId' => $request->modalidade,
            'numeroCompra' => $request->numeroCompra,
            'numeroProcesso' => $request->numeroProcesso,
            'objetoCompra' => stripslashes(utf8_encode($request->objetoCompra)),
            'informacaoComplementar' => stripslashes(utf8_encode($request->informacaoComplementar)),
            'amparoLegalId' => $request->amparoLegal,
            'srp' => $request->srp,
            'orcamentoSigiloso' => $request->orcamentoSigiloso === 't',
            'dataAberturaProposta' => $dataAberturaProposta,
            'dataEncerramentoProposta' => $dataEncerramentoProposta,
            'codeUnidadeCompradora' => $request->unidadeCompradora,
            'linkSistemaOrigem' => $request->linkSistemaOrigem,
            'codigoUnidadeCompradora' => $request->unidadeCompradora,
            'modoDisputaId' => $request->modoDisputa
        ];
        if (!isset($request->informacaoComplementar)) {
            unset($compra->informacaoComplementar);
        }

        $header = [
            'Titulo-Documento' => stripslashes($request->tituloDocumento),
            'Tipo-Documento-Id' => $request->tipoDocumento,
        ];

        $multipart = [
            [
                'name' => 'compra',
                'contents' => json_encode($compra),
                'headers' => ['Content-Type' => 'application/json']
            ],
            [
                'name' => 'documento',
                'contents' => fopen($request->anexoDocumento->getPathName(), 'r'),
                'filename' => $request->anexoDocumento->getClientOriginalName(),
                'headers' => [
                    'Content-Type' => 'multipart/form-data'
                ]
            ],
        ];

        try {
            $response = $this->http->incluirCompra($request->cnpj, null, $header, $multipart);
            $compra = (explode('/', explode("compras/", $response->compraUri)[1]));
            $linkCompra = "https://pncp.gov.br/app/editais/{$request->cnpj}/{$compra[0]}/$compra[1]";
            $dadosCompra = $this->http->doRequest('GET', $response->compraUri);
            $this->incluirEvento($request->modalidade, $request, $linkCompra);
            $this->excluiEncerramentoLicitacon($request->licitacao);
        } catch (CompraEditalAvisoExcpetion $e) {
            throw new \Exception($e->getErros());
        }
        $this->incluirDadosCompra($dadosCompra, $request);
        return $linkCompra;
    }

    /**
     * @param $itens
     * @return void
     * @throws \Exception
     */
    private function verificaItens($itens)
    {
        $itens = (json_decode(stripslashes(utf8_encode($itens))));

        foreach ($itens as $item) {
            if ($item->tipoBeneficioId === "0") {
                throw new \Exception('Selecione o "Tipo Benefício" para o Item ' . $item->numeroItem . '.');
            }
            if ($item->incentivoProdutivoBasico === "0") {
                throw new \Exception('Selecione o "Incentivo Fiscal PPB" para o Item '. $item->numeroItem . '.');
            }
            if ($item->criterioJulgamentoId === "0") {
                throw new \Exception('Selecione o "Critério Julgamento" para o Item ' . $item->numeroItem . '.');
            }
            if (!empty($item->dadosFornecedor)) {
                if ($item->indicadorSubcontratacao === "0") {
                    $mensagem = 'Selecione o "Indicador sub-contratação" para o Item ' . $item->numeroItem . '.';
                    throw new \Exception($mensagem);
                }
            }
        }
    }

    /**
     * @param $licitacao
     * @return array
     */
    public function buscarEditais($licitacao)
    {
        $editais = [];
        $licitacao = Licitacao::where('l20_codigo', $licitacao)->first();
        if (!is_null($licitacao->editais)) {
            $editais = $licitacao->editais->toArray();
            return EditaisResource::toArray($editais);
        }
        return $editais;
    }

    /**
     * @param $dadosCompra
     * @param InclusaoCEARequest $request
     * @param $compra
     * @return void
     */
    private function incluirDadosCompra($dadosCompra, InclusaoCEARequest $request)
    {
        $publicacao = new ComprasPncp();
        $publicacao->pn03_liclicita = $request->licitacao;
        $publicacao->pn03_numero = $dadosCompra->sequencialCompra;
        $publicacao->pn03_unidade = $request->unidadeCompradora;
        $publicacao->pn03_ano = $dadosCompra->anoCompra;
        $publicacao->pn03_instituicao = $request->DB_instit;
        $publicacao->pn03_usuario = $request->DB_id_usuario;
        $publicacao->pn03_datapublicacao = date('Y-m-d');
        $publicacao->save();
    }

    /**
     * @param $modalidadeCompra
     * @param InclusaoCEARequest $request
     * @param $linkCompra
     * @return void
     * @throws \DBException
     * @throws \ParameterException
     */
    private function incluirEvento($modalidadeCompra, InclusaoCEARequest $request, $linkCompra)
    {
        $fase = Evento::FASE_EDITAL_PUBLICADO;
        $tipoEvento = Evento::TIPO_EVENTO_PUBLICACAO_EDITAL;
        $tipoPublicacao = Evento::TIPO_PUBLICACAO_PUBLICACAO_CONTRATACOES_PUBLICAS;
        $data = date('Y-m-d');
        $dataEvento = new \DBDate(urldecode($data));
        if ($modalidadeCompra === ModalidadeCompraEnum::DISPENSA_DE_LICITACAO ||
            $modalidadeCompra === ModalidadeCompraEnum::INEXIGIBILIDADE
        ) {
            $fase = Evento::FASE_PUBLICACAO;
            $tipoEvento = Evento::TIPO_EVENTO_PUBLICACAO;
        }
        $evento = new Evento();
        $evento->setCodigoLicitacao($request->licitacao);
        $evento->setFase($fase);
        $evento->setTipo($tipoEvento);
        $evento->setData($dataEvento);
        $evento->setTipoPublicacao($tipoPublicacao);
        $evento->setDescricaoPublicacao(db_stdClass::normalizeStringJsonEscapeString($linkCompra));
        $evento->setCodigoAutor(0);
        $evento->salvar();
    }

    /**
     * @param $licitacao
     * @param $item
     * @return array
     * @throws \Exception
     */
    public static function getFornecedorJulgado($licitacao, $item)
    {
        $itemLicitacao = DB::table('liclicitem')
            ->join('pcorcamitemlic', 'pc26_liclicitem', 'l21_codigo')
            ->where('l21_codliclicita', $licitacao)
            ->where('l21_codigo', $item)
            ->select('pc26_orcamitem', 'l21_codigo')
            ->get();

        if ($itemLicitacao->count() === 0) {
            return [];
        }

        $fornecedor = DB::table('pcorcamjulg')
            ->join('pcorcamforne', 'pc21_orcamforne', 'pc24_orcamforne')
            ->join('pcorcamval', 'pcorcamval.pc23_orcamforne', 'pcorcamforne.pc21_orcamforne')
            ->where('pc24_orcamitem', $itemLicitacao[0]->pc26_orcamitem)
            ->select(
                'pc21_numcgm',
                'pc24_orcamitem',
                'pc21_orcamforne',
                'pc23_valor',
                'pc23_vlrun',
                'pc23_quant',
                'pc23_percentualdesconto'
            )
            ->first();

        if (is_null($fornecedor)) {
            return [];
        }
        $porteFornecedorId = DB::table('pcorcamfornelic')
            ->where('pc31_orcamforne', $fornecedor->pc21_orcamforne)
            ->select('pc31_liclicitatipoempresa')->first();

        $cgmRepository = new CgmRepository();
        $cgm = $cgmRepository->getByNumcgm($fornecedor->pc21_numcgm);
        $tipoPessoaId = "PE";
        if ($cgm->z01_nacion !== 2) {
            if (LicitanteLicitaCon::getTipoPessoaPorCGM($fornecedor->pc21_numcgm) === "F") {
                $tipoPessoaId = "PF";
            } else {
                $tipoPessoaId = "PJ";
            }
        }

        $dados = [
            "quantidadeHomologada" => $fornecedor->pc23_quant,
            'valorUnitarioHomologado' => $fornecedor->pc23_vlrun,
            'valorTotalHomologado' => $fornecedor->pc23_valor,
            'tipoPessoaId' => $tipoPessoaId,
            'niFornecedor' => $cgm->z01_cgccpf,
            'nomeRazaoSocialFornecedor' => $cgm->z01_nome,
            'percentualDesconto' => $fornecedor->pc23_percentualdesconto,
            'porteFornecedorId' => self::getFornecedorIdPNCP($porteFornecedorId->pc31_liclicitatipoempresa),
            'numcgm' => $cgm->z01_numcgm
        ];

        if ($dados['tipoPessoaId'] === 'PE') {
            $cgmFornecedor = $fornecedor->pc21_numcgm;
            $dados['niFornecedor'] = self::buscaNiFornecedorEstrangeiro($cgmFornecedor);
        }

        return $dados;
    }

    private static function getFornecedorIdPNCP($fornecedor)
    {
        switch ($fornecedor) {
            case 1:
                $porteFornecedor =  3;
                break;
            case 2:
                $porteFornecedor = 1;
                break;
            default:
                $porteFornecedor = 2;
                break;
        }

        return $porteFornecedor;
    }

    private static function buscaNiFornecedorEstrangeiro($numcgm)
    {
        $cgm = new Cgm();
        $dadosCgm = $cgm->with('cgmEstrangeiro')->find($numcgm);
        $dadosCgmEstrangeiro = $dadosCgm->cgmEstrangeiro;
        if (!empty($dadosCgmEstrangeiro)) {
            return $dadosCgmEstrangeiro->z09_documento;
        }

        return 'Não informado';
    }

    /**
     * @param $licitacao
     * @param $cnpj
     * @param $itens
     * @return bool
     * @throws \Exception
     */
    public function incluirResultadoItem($licitacao, $cnpj, $itens)
    {
        $itensCompra = (json_decode(stripslashes(utf8_encode($itens))));
        $publicacao = ComprasPncp::where('pn03_liclicita', $licitacao)->first();
        if (is_null($publicacao)) {
            return false;
        }

        $resultadoItem = $this->http->buscarResultadoItem(
            $cnpj,
            $publicacao->pn03_ano,
            $publicacao->pn03_numero,
            $itensCompra[0]->numeroItem
        );

        if (!empty((array)$resultadoItem)) {
            throw new \Exception('Compra/Edital/Aviso já possui resultado(s), verifique.');
        }

        $compra = (object)ComprasPncp::where('pn03_liclicita', $licitacao)->first()->toArray();
        foreach ($itensCompra as $item) {
            if ($item->situacao === "Homologada") {
                if ($item->indicadorSubcontratacao === '0') {
                    $mensagem = 'Selecione o "Indicador sub-contratação" para o Item ' . $item->numeroItem . '.';
                    throw new \Exception($mensagem);
                }
            }

            if ($item->situacao !== "Homologada" || $item->dataHomologacao === '') {
                return false;
            }
            if (!isset($item->dadosFornecedor->niFornecedor)) {
                return false;
            }

            $data = explode("/", $item->dataHomologacao);
            $dataHomologacao = $data[2] . '-' . $data[1] . '-' . $data[0];
            $dados = [
                "quantidadeHomologada" => $item->dadosFornecedor->quantidadeHomologada,
                "valorUnitarioHomologado" => $item->dadosFornecedor->valorUnitarioHomologado,
                "valorTotalHomologado" => $item->dadosFornecedor->valorTotalHomologado,
                "percentualDesconto" => $item->dadosFornecedor->percentualDesconto,
                "porteFornecedorId" => $item->dadosFornecedor->porteFornecedorId,
                "tipoPessoaId" => $item->dadosFornecedor->tipoPessoaId,
                "niFornecedor" => $item->dadosFornecedor->niFornecedor,
                "nomeRazaoSocialFornecedor" => $item->dadosFornecedor->nomeRazaoSocialFornecedor,
                "indicadorSubcontratacao" => $item->indicadorSubcontratacao,
                "naturezaJuridicaId" => '0000',
                "codigoPais" => "BRA",
                "ordemClassificacaoSrp" => 1,
                "dataResultado" => $dataHomologacao
            ];
            try {
                $this->http->incluirResultadoItem(
                    $cnpj,
                    $compra->pn03_ano,
                    $compra->pn03_numero,
                    $item->numeroItem,
                    $dados
                );
            } catch (CompraEditalAvisoExcpetion $e) {
                throw new \Exception($e->getErros());
            }
        }
    }

    /**
     * @param $cnpj
     * @param $codigoCompra
     * @return string
     * @throws \DBException
     * @throws \ParameterException
     */
    public function excluirCompra($cnpj, $codigoCompra)
    {
        $compra = (object)ComprasPncp::where('pn03_codigo', $codigoCompra)->first()->toArray();
        if (is_null($compra)) {
            throw new \Exception('Compra não encontrada');
        }
        $eventoPublicacao = \EventoLicitacao::TIPO_EVENTO_PUBLICACAO;
        $eventoPublicacaoEdital = \EventoLicitacao::TIPO_EVENTO_PUBLICACAO_EDITAL;
        $eventoLicitacao = (object)EventoLicitacao::where('l46_liclicita', $compra->pn03_liclicita)
            ->where(function ($query) use ($eventoPublicacao, $eventoPublicacaoEdital) {
                $query->where('l46_liclicitatipoevento', $eventoPublicacao)
                    ->orWhere('l46_liclicitatipoevento', $eventoPublicacaoEdital);
            })->first()->toArray();

        $model = new \EventoLicitacao($eventoLicitacao->l46_sequencial);
        try {
            $this->http->excluirCompra($cnpj, $compra->pn03_ano, $compra->pn03_numero);
            $model->excluir();
        } catch (CompraEditalAvisoExcpetion $e) {
            throw new \Exception($e->getErros());
        }
        $publicacao = ComprasPncp::find($compra->pn03_codigo);
        $publicacao->delete();

        return 'Compra excluída com sucesso.';
    }

    /**
     * @param Request $request
     * @return ComprasPncp $object
     */
    public function buscarCompra(Request $request)
    {
        $compra = [];
        $condicoes = $this->montaCondicoesCompra($request);
        $condicoesSql = implode('AND', $condicoes);

        if (!empty($condicoes)) {
            $compra = ComprasPncp::whereRaw($condicoesSql)->first();
        }

        if (empty($condicoes)) {
            $compra = ComprasPncp::all();
        }

        return $compra;
    }

    /**
     * @param $licitacao
     * @return void
     * @throws \Exception
     */
    private function excluiEncerramentoLicitacon($licitacao)
    {
        $liclicita = LiclicitaEncerramentoLicitacon::where('l18_liclicita', $licitacao)->first();
        if ($liclicita !== null) {
            $sql = "delete from liclicitaencerramentolicitacon where l18_liclicita = {$licitacao}";
            $rs = db_query($sql);
            if (!$rs) {
                throw new \Exception("Erro ao excluir encerramento de licitacao no licitacon.");
            }
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    private function montaCondicoesCompra(Request $request)
    {
        $condicoes = [];

        if (!empty($request->pn03_codigo)) {
            $condicoes[] = "pn03_codigo = {$request->pn03_codigo}";
        }

        if (!empty($request->pn03_ano)) {
            $condicoes[] = "pn03_ano = {$request->pn03_ano}";
        }

        if (!empty($request->pn03_numero)) {
            $condicoes[] = "pn03_numero = {$request->pn03_numero}";
        }

        if (!empty($request->pn03_instituicao)) {
            $condicoes[] = "pn03_instituicao = {$request->pn03_instituicao}";
        }

        if (!empty($request->pn03_liclicita)) {
            $condicoes[] = "pn03_liclicita = {$request->pn03_liclicita}";
        }

        return $condicoes;
    }
}
