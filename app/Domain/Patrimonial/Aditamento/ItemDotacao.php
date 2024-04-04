<?php

namespace App\Domain\Patrimonial\Aditamento;

class ItemDotacao
{
    private ?int $sequencial;
    private int $codigoDotacao;
    private int $anoDotacao;
    private ?float $valor;
    private ?float $quantidade;

    public function __construct(
        int $codigoDotacao,
        int $anoDotacao,
        ?float $valor = null,
        ?float $quantidade = null,
        ?int $sequencial = null
    ) {
        $this->codigoDotacao = $codigoDotacao;
        $this->anoDotacao = $anoDotacao;
        $this->valor = $valor;
        $this->quantidade = $quantidade;
        $this->sequencial = $sequencial;
    }

    /**
     * Get the value of sequencial
     */
    public function getSequencial(): ?int
    {
        return $this->sequencial;
    }

    /**
     * Set the value of sequencial
     */
    public function setSequencial(?int $sequencial): self
    {
        $this->sequencial = $sequencial;

        return $this;
    }

    /**
     * Get the value of codigoDotacao
     */
    public function getCodigoDotacao(): int
    {
        return $this->codigoDotacao;
    }

    /**
     * Set the value of codigoDotacao
     */
    public function setCodigoDotacao(int $codigoDotacao): self
    {
        $this->codigoDotacao = $codigoDotacao;

        return $this;
    }

    /**
     * Get the value of anoDotacao
     */
    public function getAnoDotacao(): int
    {
        return $this->anoDotacao;
    }

    /**
     * Set the value of anoDotacao
     */
    public function setAnoDotacao(int $anoDotacao): self
    {
        $this->anoDotacao = $anoDotacao;

        return $this;
    }

    /**
     * Get the value of valor
     */
    public function getValor(): ?float
    {
        return $this->valor;
    }

    /**
     * Set the value of valor
     */
    public function setValor(?float $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get the value of quantidade
     */
    public function getQuantidade(): ?float
    {
        return $this->quantidade;
    }

    /**
     * Set the value of quantidade
     */
    public function setQuantidade(?float $quantidade): self
    {
        $this->quantidade = $quantidade;

        return $this;
    }
}

