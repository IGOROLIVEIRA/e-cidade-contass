<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/LicitacaoFabricaInterface.model.php");
require_once("model/licitacao/PortalCompras/Modalidades/Concorrencia.model.php");

class ConcorrenciaFabrica implements LicitacaoFabricaInterface
{
    const MODO = [
        '1' => 'criarNormal',
        '2' => 'criarResgistroPreco'
    ];

    /**
     * Strategy Concorrencia
     *
     * @param resource $dados
     * @param integer $numlinhas
     * @return Licitacao
     */
    public function criar($dados, int $numlinhas): Licitacao
    {
        $naturezaProcedimento = (db_utils::fieldsMemory($dados, 0))->naturezaprocedimento;
        $modoCriacao = array_key_exists($naturezaProcedimento, self::MODO)
            ? self::MODO[$naturezaProcedimento]
            : self::MODO['1'];

        return $this->{$modoCriacao}($dados, $numlinhas);
    }

    /**
     * Cria concorrencia
     *
     * @param resource $dados
     * @param integer $numlinhas
     * @return Licitacao
     */
    private function criarNormal($dados, int $numlinhas): Licitacao
    {
        $loteFabrica = new LoteFabrica;
        $concorrencia = new concorrencia();
        $linha = db_utils::fieldsMemory($dados, 0);

        $concorrencia->setId($linha->id);
        $concorrencia->setObjeto($linha->objeto);
        $concorrencia->setTipoRealizacao((int)$linha->tiporealizacao);
        $concorrencia->setTipoJulgamento((int)$linha->tipojulgamento);
        $concorrencia->setNumeroProcessoInterno($linha->numeroprocessointerno);
        $concorrencia->setNumeroProcesso((int)$linha->numeroprocesso);
        $concorrencia->setAnoProcesso((int)$linha->anoprocesso);
        $concorrencia->setDataInicioPropostas($linha->datainiciopropostas);
        $concorrencia->setDataFinalPropostas($linha->datafinalpropostas);
        $concorrencia->setDataLimiteImpugnacao($linha->datalimiteimpugnacao);
        $concorrencia->setDataAberturaPropostas($linha->dataaberturapropostas);
        $concorrencia->setDataLimiteEsclarecimento($linha->datalimiteesclarecimento);
        $concorrencia->setOrcamentoSigiloso((bool)$linha->orcamentosigiloso);
        $concorrencia->setExclusivoMPE($linha->exclusivompe);
        $concorrencia->setAplicar147($linha->aplicar147);
        $concorrencia->setBeneficioLocal($linha->beneficio);
        $concorrencia->setExigeGarantia($linha->exigegarantia);
        $concorrencia->setCasasDecimais((int)$linha->casasdecimais);
        $concorrencia->setCasasDecimaisQuantidade((int)$linha->casasdecimaisquantidade);
        $concorrencia->setTratamentoFaseLance((int) $linha->tratamentofaselance);
        $concorrencia->setTipoIntervaloLance((int)$linha->tipointervalolance);
        $concorrencia->setValorIntervaloLance((float)$linha->valorintervalolance);
        $concorrencia->setSepararPorLotes($linha->separarporlotes);
        $concorrencia->setOperacaoLote((int)$linha->operacaolote);
        $concorrencia->setPregoeiro($linha->pregoeiro);

        $lotes = $loteFabrica->criar($dados, $numlinhas);

        $concorrencia->setLotes($lotes);
        return $concorrencia;
    }

    /**
     * Cria registro de preco
     *
     * @param resource $dados
     * @param integer $numlinhas
     * @return Licitacao
     */
    private function criarResgistroPreco($dados, int $numlinhas): Licitacao
    {
        $registroPrFabrica = new RegistroPrecosFabrica();
        return $registroPrFabrica->criar($dados, $numlinhas);
    }
}