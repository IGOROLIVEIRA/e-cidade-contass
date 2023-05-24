<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/LicitacaoFabricaInterface.model.php");
require_once("model/licitacao/PortalCompras/Modalidades/Pregao.model.php");
require("model/licitacao/PortalCompras/Fabricas/RegistroPrecosFabrica.model.php");
require("model/licitacao/PortalCompras/Comandos/ValidadorTipoPregao.model.php");

class PregaoFabrica implements LicitacaoFabricaInterface
{
    const MODO = [
        '1' => 'criarPregaoNormal',
        '2' => 'criarResgistroPreco'
    ];

    /**
     * Strategy de Pregão
     *
     * @param resource $dados
     * @param integer $numlinhas
     * @return Licitacao
     */
    public function criar($dados, int $numlinhas): Licitacao
    {
        $naturezaProcedimento = (db_utils::fieldsMemory($dados, 0))->naturezaprocedimento;
        $modoCriacao = self::MODO[$naturezaProcedimento];

        return $this->{$modoCriacao}($dados, $numlinhas);
    }

    /**
     * Cria Pregão Normal
     *
     * @param resource $dados
     * @param integer $numlinhas
     * @return Licitacao
     */
    public function criarPregaoNormal($dados, int $numlinhas): Licitacao
    {
        $loteFabrica = new LoteFabrica;
        $pregao = new Pregao();
        $linha = db_utils::fieldsMemory($dados, 0);
        $legislacaoAplicavel = (new ValidadorTipoPregao)->execute((int)$linha->tiporealizacao);

        $pregao->setId($linha->id);
        $pregao->setObjeto($linha->objeto);
        $pregao->setTipoRealizacao((int)$linha->tiporealizacao);
        $pregao->setTipoJulgamento((int)$linha->tipojulgamento);
        $pregao->setNumeroProcessoInterno($linha->numeroprocessointerno);
        $pregao->setNumeroProcesso((int)$linha->numeroprocesso);
        $pregao->setAnoProcesso((int)$linha->anoprocesso);
        $pregao->setDataInicioPropostas($linha->datainiciopropostas);
        $pregao->setDataFinalPropostas($linha->datafinalpropostas);
        $pregao->setDataLimiteImpugnacao($linha->datalimiteimpugnacao);
        $pregao->setDataAberturaPropostas($linha->dataaberturapropostas);
        $pregao->setDataLimiteEsclarecimento($linha->datalimiteesclarecimento);
        $pregao->setOrcamentoSigiloso((bool)$linha->orcamentosigiloso);
        $pregao->setExclusivoMPE($linha->exclusivompe);
        $pregao->setAplicar147($linha->aplicar147);
        $pregao->setBeneficioLocal($linha->beneficio);
        $pregao->setExigeGarantia($linha->exigegarantia);
        $pregao->setCasasDecimais((int)$linha->casasdecimais);
        $pregao->setCasasDecimaisQuantidade((int)$linha->casasdecimaisquantidade);
        $pregao->setLegislacaoAplicavel($legislacaoAplicavel);
        $pregao->setTratamentoFaseLance((int) $linha->tratamentofaselance);
        $pregao->setTipoIntervaloLance((int)$linha->tipointervalolance);
        $pregao->setValorIntervaloLance((float)$linha->valorintervalolance);
        $pregao->setSepararPorLotes($linha->separarporlotes);
        $pregao->setOperacaoLote($linha->operacaolote);
        $pregao->setPregoeiro($linha->pregoeiro);

        $lotes = $loteFabrica->criar($dados, $numlinhas);

        $pregao->setLotes($lotes);
        return $pregao;
    }

    /**
     * Undocumented function
     *
     * @param [type] $dados
     * @param integer $numlinhas
     * @return Licitacao
     */
    public function criarResgistroPreco($dados, int $numlinhas): Licitacao
    {
        $registroPrFabrica = new RegistroPrecosFabrica();
        return $registroPrFabrica->criar($dados, $numlinhas);
    }
}