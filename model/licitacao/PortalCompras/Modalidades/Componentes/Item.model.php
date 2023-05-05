<?php

class Item implements \JsonSerializable
{
    /**
     * @var integer|null
     */
    private ?int $numeroCatalogo = null;

    /**
     * @var integer
     */
    private int $numero;

    /**
     * @var integer
     */
    private int $numeroInterno;

    /**
     * @var string
     */
    private string $descricao = "";

    /**
     * @var integer
     */
    private int $natureza;

    /**
     * @var string
     */
    private string $siglaUnidade;

    /**
     * @var float
     */
    private float $valorReferencia;

    /**
     * @var float
     */
    private float $quantidadeTotal;

    /**
     * @var float
     */
    private float $quantidadeCota;


    /**
     * Get the value of numeroCatalogo
     */
    public function getNumeroCatalogo(): ?int
    {
        return $this->numeroCatalogo;
    }

    /**
     * Set the value of numeroCatalogo
     */
    public function setNumeroCatalogo(?int $numeroCatalogo): self
    {
        $this->numeroCatalogo = $numeroCatalogo;

        return $this;
    }

    /**
     * Get the value of numero
     */
    public function getNumero(): int
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     */
    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of numeroInterno
     */
    public function getNumeroInterno(): int
    {
        return $this->numeroInterno;
    }

    /**
     * Set the value of numeroInterno
     */
    public function setNumeroInterno(int $numeroInterno): self
    {
        $this->numeroInterno = $numeroInterno;

        return $this;
    }

    /**
     * Get the value of descricao
     */
    public function getDescricao(): string
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     */
    public function setDescricao(string $descricao): self
    {
        $this->descricao = mb_convert_encoding($descricao, "UFT-8");

        return $this;
    }

    /**
     * Get the value of natureza
     */
    public function getNatureza(): int
    {
        return $this->natureza;
    }

    /**
     * Set the value of natureza
     */
    public function setNatureza(int $natureza): self
    {
        $this->natureza = $natureza;

        return $this;
    }

    /**
     * Get the value of siglaUnidade
     */
    public function getSiglaUnidade(): string
    {
        return $this->siglaUnidade;
    }

    /**
     * Set the value of siglaUnidade
     */
    public function setSiglaUnidade(string $siglaUnidade): self
    {
        $this->siglaUnidade = $siglaUnidade;

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

    /**
     * Get the value of quantidadeTotal
     */
    public function getQuantidadeTotal(): float
    {
        return $this->quantidadeTotal;
    }

    /**
     * Set the value of quantidadeTotal
     */
    public function setQuantidadeTotal(float $quantidadeTotal): self
    {
        $this->quantidadeTotal = $quantidadeTotal;

        return $this;
    }

    /**
     * Get the value of quantidadeCota
     */
    public function getQuantidadeCota(): float
    {
        return $this->quantidadeCota;
    }

    /**
     * Set the value of quantidadeCota
     */
    public function setQuantidadeCota(float $quantidadeCota): self
    {
        $this->quantidadeCota = $quantidadeCota;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
                "numeroCatalogo"=> $this->numeroCatalogo,
                "numero"=> $this->numero,
                "numeroInterno"=> $this->numeroInterno,
                "descricao" => $this->descricao,
                "natureza"=> $this->natureza,
                "siglaUnidade"=> $this->siglaUnidade,
                "valorReferencia"=> $this->valorReferencia,
                "quantidadeTotal"=> $this->quantidadeTotal,
                "quantidadeCota"=> $this->quantidadeCota
        ];
    }
}