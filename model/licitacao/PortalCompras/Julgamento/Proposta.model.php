<?php

class Proposta
{
    private int    $idItem;
    private string $data;
    private string $horas;
    private string $idFornecedor;
    private string $modelo;
    private string $marca;
    private string $fabricante;
    private string $detalhamento;
    private string $validadeProposta;
    private int    $quantidade;
    private float  $valorDesconto = 0.0;
    private float  $valorUnitario;
    private float  $valorTotal;
    private bool   $valido = true;


    /**
     * Get the value of idItem
     */
    public function getIdItem(): int
    {
        return $this->idItem;
    }

    /**
     * Set the value of idItem
     */
    public function setIdItem(int $idItem): self
    {
        $this->idItem = $idItem;

        return $this;
    }

    /**
     * Get the value of data
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * Set the value of data
     */
    public function setData(string $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the value of horas
     */
    public function getHoras(): string
    {
        return $this->horas;
    }

    /**
     * Set the value of horas
     */
    public function setHoras(string $horas): self
    {
        $this->horas = $horas;

        return $this;
    }

    /**
     * Get the value of idFornecedor
     */
    public function getIdFornecedor(): string
    {
        return $this->idFornecedor;
    }

    /**
     * Set the value of idFornecedor
     */
    public function setIdFornecedor(string $idFornecedor): self
    {
        $this->idFornecedor = $idFornecedor;

        return $this;
    }

    /**
     * Get the value of marca
     */
    public function getMarca(): string
    {
        return $this->marca;
    }

    /**
     * Set the value of marca
     */
    public function setMarca(string $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get the value of fabricante
     */
    public function getFabricante(): string
    {
        return $this->fabricante;
    }

    /**
     * Set the value of fabricante
     */
    public function setFabricante(string $fabricante): self
    {
        $this->fabricante = $fabricante;

        return $this;
    }

    /**
     * Get the value of validadeProposta
     */
    public function getValidadeProposta(): string
    {
        return $this->validadeProposta;
    }

    /**
     * Set the value of validadeProposta
     */
    public function setValidadeProposta(string $validadeProposta): self
    {
        $this->validadeProposta = $validadeProposta;

        return $this;
    }

    /**
     * Get the value of quantidade
     */
    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    /**
     * Set the value of quantidade
     */
    public function setQuantidade(int $quantidade): self
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Get the value of valorDesconto
     */
    public function getValorDesconto(): float
    {
        return $this->valorDesconto;
    }

    /**
     * Set the value of valorDesconto
     */
    public function setValorDesconto(float $valorDesconto): self
    {
        $this->valorDesconto = $valorDesconto;

        return $this;
    }

    /**
     * Get the value of valorUnitario
     */
    public function getValorUnitario(): float
    {
        return $this->valorUnitario;
    }

    /**
     * Set the value of valorUnitario
     */
    public function setValorUnitario(float $valorUnitario): self
    {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }

    /**
     * Get the value of valorTotal
     */
    public function getValorTotal(): float
    {
        return $this->valorTotal;
    }

    /**
     * Set the value of valorTotal
     */
    public function setValorTotal(float $valorTotal): self
    {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    /**
     * Get the value of valido
     */
    public function isValido(): bool
    {
        return $this->valido;
    }

    /**
     * Set the value of valido
     */
    public function setValido(bool $valido): self
    {
        $this->valido = $valido;

        return $this;
    }

    /**
     * Get the value of modelo
     */
    public function getModelo(): string
    {
        return $this->modelo;
    }

    /**
     * Set the value of modelo
     */
    public function setModelo(string $modelo): self
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get the value of detalhamento
     */
    public function getDetalhamento(): string
    {
        return $this->detalhamento;
    }

    /**
     * Set the value of detalhamento
     */
    public function setDetalhamento(string $detalhamento): self
    {
        $this->detalhamento = $detalhamento;

        return $this;
    }
}