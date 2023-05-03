<?php


require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/LicitacaoFabricaInterface.model.php");
require_once("model/licitacao/PortalCompras/Modalidades/Pregao.model.php");

class PregaoFabrica implements LicitacaoFabricaInterface
{
    public function create($data, int $numrows): Licitacao
    {
        $pregao = new Pregao();
        $linha = db_utils::fieldsMemory($data, 0);
        $pregao->setId($linha->id);
        $pregao->setObjeto($linha->objeto);
        $pregao->setNumeroProcessoInterno($linha->numeroprocessointerno);
        $pregao->setNumeroProcesso((int)$linha->numeroprocesso);
        $pregao->setAnoProcesso((int)$linha->anoprocesso);
        $pregao->setDataInicioPropostas($linha->datainiciopropostas);
        $pregao->setDataFinalPropostas($linha->datafinalpropostas);
        $pregao->setDataLimiteImpugnacao($linha->datalimiteimpugnacao);
        $pregao->setDataLimiteEsclarecimento($linha->datalimiteesclarecimento);
        $pregao->setOrcamentoSigiloso((bool)$linha->orcamentosigiloso);
        $pregao->setExclusivoMPE((bool)$linha->exclusivompe);
        $pregao->setAplicar147((bool)$linha->aplicar147);
        $pregao->setBeneficioLocal((bool)$linha->beneficio);
        $pregao->setCasasDecimais((int)$linha->casasdecimais);
        $pregao->setCasasDecimaisQuantidade((int)$linha->casadecimaisquantidade);
        $pregao->setLegislacaoAplicavel((int)$linha->legislacaoaplicavel);
        $pregao->setTratamentoFaseLance((int) $linha->tratamentofaselance);
        $pregao->setTipoIntervaloLance((int)$linha->tipointervalolance);
        $pregao->setValorIntervaloLance((float)$linha->valorintervalolance);
        $pregao->setSepararPorLotes((bool)$linha->separarporlotes);
        $pregao->setOperacaoLote((bool)$linha->operacaolote);
        $pregao->setPregoeiro($linha->pregoeiro);

        var_dump("chegou pregao fabrica");
        var_dump($pregao->getDataInicioPropostas());
        die();
    }

    private function adicionarItems()
    {

    }
}