<?php

class Lance
{
    /**
     * @var string $idFornecedor
     */
    private string $idFornecedor;

    /**
     * @var float  $valorUnitario
     */
    private float  $valorUnitario;

    /**
     * @var float  $valorTotal
     */
    private float  $valorTotal;


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
        $this->valorUnitario = round($valorUnitario,4);

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
        $this->valorTotal = round($valorTotal,4);

        return $this;
    }
}