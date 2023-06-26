<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");

class Pregao extends Licitacao
{
    /**
     * @var integer
     */
    private int $tipoJulgamento;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retorna url da APIPCP
     *
     * @param string|null $publicKey
     * @return string
     */
    public function getUrlPortalCompras(string $publicKey = null): string
    {
        return $this->envs['URL']."/comprador/$publicKey/processo/pregao";
    }

    /**
     * Get the value of tipoJulgamento
     */
    public function getTipoJulgamento(): int
    {
        return $this->tipoJulgamento;
    }

    /**
     * Set the value of tipoJulgamento
     */
    public function setTipoJulgamento(int $tipoJulgamento): self
    {
        $this->tipoJulgamento = $tipoJulgamento;

        return $this;
    }

    /**
     * Return class in array
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id"=> $this->id,
            "objeto"=> $this->objeto,
            "tipoRealizacao"=> $this->tipoRealizacao,
            "tipoJulgamento"=> $this->tipoJulgamento,
            "numeroProcessoInterno"=> $this->numeroProcessoInterno,
            "numeroProcesso"=> $this->numeroProcesso,
            "anoProcesso"=> $this->anoProcesso,
            "dataInicioPropostas"=> $this->dataInicioPropostas,
            "dataFinalPropostas"=> $this->dataFinalPropostas,
            "dataLimiteImpugnacao"=> $this->dataLimiteImpugnacao,
            "dataAberturaPropostas"=> $this->dataAberturaPropostas,
            "dataLimiteEsclarecimento"=> $this->dataLimiteEsclarecimento,
            "orcamentoSigiloso"=> $this->orcamentoSigiloso,
            "aplicar147"=> $this->aplicar147,
            "exigeGarantia"=> $this->exigeGarantia,
            "exclusivoMPE"=> $this->exclusivoMPE,
            "beneficioLocal"=> $this->beneficioLocal,
            "casasDecimais"=> $this->casasDecimais,
            "casasDecimaisQuantidade"=> $this->casasDecimaisQuantidade,
            "legislacaoAplicavel"=> $this->legislacaoAplicavel,
            "tratamentoFaseLance"=> $this->tratamentoFaseLance,
            "tipoIntervaloLance"=> $this->tipoIntervaloLance,
            "valorIntervaloLance"=> $this->valorIntervaloLance,
            "separarPorLotes"=> $this->separarPorLotes,
            "operacaoLote"=> $this->operacaoLote,
            "lotes"=> $this->lotes,
            "arquivos"=> $this->arquivos,
            "pregoeiro"=> $this->pregoeiro,
            "autoridadeCompetente"=> $this->autoridadeCompetente,
            "equipeDeApoio"=> $this->equipeDeApoio,
            "documentosHabilitacao"=> $this->documentosHabilitacao,
            "declaracoes"=> $this->declaracoes,
            "origensRecursos" => $this->origensRecursos,
        ];
    }
}
