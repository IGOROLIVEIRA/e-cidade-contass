<?php

require_once("model/licitacao/PortalCompras/Modalidades/Licitacao.model.php");



class Dispensa extends Licitacao
{
    /**
     * @var boolean
     */
    private bool $aceitaPropostaSuperior = false;
    /**
     * @var boolean
     */
    private bool $possuiTempoAleatorio = false;
    /**
     * @var integer
     */
    private int  $codigoEnquadramentoJuridico = 0;
      /**
     * @var integer
     */
    private int  $tipoJulgamento = 0;

    /**
     * Metodo Construtror
     */
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
        return $this->envs['URL']."/comprador/$publicKey/processo/dispensa";
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
     * Get the value of aceitaPropostaSuperior
     */
    public function isAceitaPropostaSuperior(): bool
    {
        return $this->aceitaPropostaSuperior;
    }

    /**
     * Set the value of aceitaPropostaSuperior
     */
    public function setAceitaPropostaSuperior(bool $aceitaPropostaSuperior): self
    {
        $this->aceitaPropostaSuperior = $aceitaPropostaSuperior;

        return $this;
    }

    /**
     * Get the value of possuiTempoAleatorio
     */
    public function isPossuiTempoAleatorio(): bool
    {
        return $this->possuiTempoAleatorio;
    }

    /**
     * Set the value of possuiTempoAleatorio
     */
    public function setPossuiTempoAleatorio(bool $possuiTempoAleatorio): self
    {
        $this->possuiTempoAleatorio = $possuiTempoAleatorio;

        return $this;
    }

    /**
     * Get the value of codigoEnquadramentoJuridico
     */
    public function getCodigoEnquadramentoJuridico(): int
    {
        return $this->codigoEnquadramentoJuridico;
    }

    /**
     * Set the value of codigoEnquadramentoJuridico
     */
    public function setCodigoEnquadramentoJuridico(int $codigoEnquadramentoJuridico): self
    {
        $this->codigoEnquadramentoJuridico = $codigoEnquadramentoJuridico;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id"=> $this->id,
            "objeto"=> $this->objeto,
            "tipoJulgamento"=> $this->tipoJulgamento,
            "numeroProcessoInterno"=> $this->numeroProcessoInterno,
            "numeroProcesso"=> $this->numeroProcesso,
            "anoProcesso"=> $this->anoProcesso,
            "orcamentoSigiloso"=> $this->orcamentoSigiloso,
            "aceitaPropostaSuperior" => $this->aceitaPropostaSuperior,
            "possuiTempoAleatorio" => $this->possuiTempoAleatorio,
            "separarPorLotes"=> $this->separarPorLotes,
            "operacaoLote"=> $this->operacaoLote,
            "codigoEnquadramentoJuridico" => $this->codigoEnquadramentoJuridico,
            "casasDecimais"=> $this->casasDecimais,
            "casasDecimaisQuantidade"=> $this->casasDecimaisQuantidade,
            "lotes"=> $this->lotes,
        ];
    }
}
