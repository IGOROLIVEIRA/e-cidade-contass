<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/LicitacaoFabricaInterface.model.php");
require_once("model/licitacao/PortalCompras/Modalidades/RegistroPrecos.model.php");
require_once("model/licitacao/PortalCompras/Comandos/CalculaDiferencaData.model.php");

class RegistroPrecosFabrica implements LicitacaoFabricaInterface
{
    /**
     *
     * @param resource $dados
     * @param integer $numlinhas
     * @return Licitacao
     */
    public function criar($dados, int $numlinhas): Licitacao
    {
        $loteFabrica = new LoteFabrica;
        $registroPreco = new RegistroPrecos();
        $calcudadora = new CalculaDiferencaData();
        $linha = db_utils::fieldsMemory($dados, 0);

        $registroPreco->setId($linha->id);
        $registroPreco->setObjeto($linha->objeto);
        $registroPreco->setTipoRealizacao((int)$linha->tiporealizacao);
        $registroPreco->setNumeroProcessoInterno($linha->numeroprocessointerno);
        $registroPreco->setNumeroProcesso((int)$linha->numeroprocesso);
        $registroPreco->setAnoProcesso((int)$linha->anoprocesso);
        $registroPreco->setDataInicioPropostas($linha->datainiciopropostas);
        $registroPreco->setDataFinalPropostas($linha->datafinalpropostas);
        $registroPreco->setDataLimiteImpugnacao($linha->datalimiteimpugnacao);
        $registroPreco->setDataAberturaPropostas($linha->dataaberturapropostas);
        $registroPreco->setDataLimiteEsclarecimento($linha->datalimiteesclarecimento);
        $registroPreco->setExclusivoMPE($linha->exclusivompe);
        $registroPreco->setAplicar147($linha->aplicar147);
        $registroPreco->setBeneficioLocal($linha->beneficio);
        $registroPreco->setTratamentoFaseLance((int) $linha->tratamentofaselance);
        $registroPreco->setTipoIntervaloLance((int)$linha->tipointervalolance);
        $registroPreco->setSepararPorLotes($linha->separarporlotes);
        $registroPreco->setOperacaoLote($linha->operacaolote);

        $prazoValidade = $calcudadora->meses($linha->datainicio, $linha->datatermino);
        $registroPreco->setPrazoValidade($prazoValidade);

        $registroPreco->setValorReferencia((float)$linha->valorreferencia);

        $lotes = $loteFabrica->criar($dados, $numlinhas);
        $registroPreco->setLotes($lotes);

        return $registroPreco;
    }
}