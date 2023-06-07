<?php

class Lances
{
    private int    $idItem;
    private string $data;
    private string $horas;
    private string $idFornecedor;
    private string $tipo;
    private bool   $valido = false;
    private bool   $cancelado = false;
    private float  $valorUnitario = 0.0;




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
     * Get the value of tipo
     */
    public function getTipo(): string
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     */
    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

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
     * Get the value of cancelado
     */
    public function isCancelado(): bool
    {
        return $this->cancelado;
    }

    /**
     * Set the value of cancelado
     */
    public function setCancelado(bool $cancelado): self
    {
        $this->cancelado = $cancelado;

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
}