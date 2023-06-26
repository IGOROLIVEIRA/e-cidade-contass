<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");

class RegistroPrecos extends Licitacao
{
    private string $prazoValidade = '';

    private float $valorReferencia = 0.0;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @param string|null $publicKey
     * @return string
     */
    public function getUrlPortalCompras(string $publicKey = null): string
    {
        return $this->envs['URL']."/comprador/$publicKey/processo/registroDePreco";
    }

    /**
     * Get the value of prazoValidade
     */
    public function getPrazoValidade(): string
    {
        return $this->prazoValidade;
    }

    /**
     * Set the value of prazoValidade
     */
    public function setPrazoValidade(string $prazoValidade): self
    {
        $this->prazoValidade = $prazoValidade;

        return $this;
    }

    /**
     * Get the value of valorReferencia
     */
    public function getValorReferencia(): float
    {
        return $this->valorReferencia;
    }

    /**
     * Set the value of valorReferencia
     */
    public function setValorReferencia(float $valorReferencia): self
    {
        $this->valorReferencia = $valorReferencia;

        return $this;
    }


    public function jsonSerialize(): array
    {
        return [
            "id"=> $this->id,
            "objeto"=> $this->objeto,
            "tipoRealizacao"=> $this->tipoRealizacao,
            "numeroProcessoInterno"=> $this->numeroProcessoInterno,
            "numeroProcesso"=> $this->numeroProcesso,
            "anoProcesso"=> $this->anoProcesso,
            "dataInicioPropostas"=> $this->dataInicioPropostas,
            "dataFinalPropostas"=> $this->dataFinalPropostas,
            "dataLimiteImpugnacao"=> $this->dataLimiteImpugnacao,
            "dataAberturaPropostas"=> $this->dataAberturaPropostas,
            "dataLimiteEsclarecimento"=> $this->dataLimiteEsclarecimento,
            "prazoValidade"=> $this->prazoValidade,
            "aplicar147"=> $this->aplicar147,
            "beneficioLocal"=> $this->beneficioLocal,
            "tratamentoFaseLance"=> $this->tratamentoFaseLance,
            "tipoIntervaloLance"=> $this->tipoIntervaloLance,
            "separarPorLotes"=> $this->separarPorLotes,
            "operacaoLote"=> $this->operacaoLote,
            "lotes"=> $this->lotes,
        ];
    }
}
