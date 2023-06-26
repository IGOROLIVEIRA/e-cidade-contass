<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");
require_once("model/licitacao/PortalCompras/Fabricas/LicitacaoFabricaInterface.model.php");
require_once("model/licitacao/PortalCompras/Comandos/ValidaCamposBool.model.php");
require_once("model/licitacao/PortalCompras/Modalidades/Dispensa.model.php");

class DispensaFabrica implements LicitacaoFabricaInterface
{
    /**
     * Cria dispensa
     *
     * @param resource $dados
     * @param integer $numlinhas
     * @return Licitacao
     */
    public function criar($dados, int $numlinhas): Licitacao
    {
        $loteFabrica = new LoteFabrica;
        $dispensa = new Dispensa;

        $validaBool = new ValidaCamposBool;

        $linha = db_utils::fieldsMemory($dados, 0);

        $dispensa->setId($linha->id);
        $dispensa->setObjeto($linha->objeto);
        $dispensa->setTipoJulgamento((int)$linha->tipojulgamento);
        $dispensa->setNumeroProcessoInterno($linha->numeroprocessointerno);
        $dispensa->setNumeroProcesso((int)$linha->numeroprocesso);
        $dispensa->setAnoProcesso((int)$linha->anoprocesso);
        $dispensa->setOrcamentoSigiloso($validaBool->execute($linha->orcamentosigiloso));
        $dispensa->setSepararPorLotes($validaBool->execute($linha->separarporlotes));
        $dispensa->setOperacaoLote((int)$linha->operacaolote);
        $dispensa->setCasasDecimais((int)$linha->casasdecimais);
        $dispensa->setCasasDecimaisQuantidade((int)$linha->casasdecimaisquantidade);
        $dispensa->setAceitaPropostaSuperior($validaBool->execute($linha->aceitapropostasuperior));
        $dispensa->setPossuiTempoAleatorio($validaBool->execute($linha->possuitempoaleatorio));
        $dispensa->setCodigoEnquadramentoJuridico(10);

        $lotes = $loteFabrica->criar($dados, $numlinhas);
        $dispensa->setLotes($lotes);

        return $dispensa;
    }
}
