<?php

namespace App\Domain\Patrimonial\Aditamento;

use DateTime;

class Item
{
    /**
     * @var integer
     */
    private int $itemSequencial;

    /**
     * @var integer
     */
    private int $codigoPcMater;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private string $descricaoItem;

    /**
     * @var float
     */
    private float $quantidade;

    /**
     * @var float
     */
    private float $valorUnitario;

    /**
    * @var float
    */
    private float $valorTotal;

    /**
     * @var boolean
     */
    private bool $tipoControle;

    /**
     * @var boolean
     */
    private bool $servicoQuantidade;

    /**
     * @var integer
     */
    private ?int $acordoPosicaoTipo;

    /**
     *
     * @var DateTime|null
     */
    private ?DateTime $inicioExecucao;

    /**
     *
     * @var DateTime|null
     */
    private ?DateTime $fimExecucao;

    /**
     * Get the value of itemSequencial
     */
    public function getItemSequencial(): int
    {
        return $this->itemSequencial;
    }

    /**
     * Set the value of itemSequencial
     */
    public function setItemSequencial(int $itemSequencial): self
    {
        $this->itemSequencial = $itemSequencial;

        return $this;
    }

    /**
     * Get the value of codigoPcMater
     */
    public function getCodigoPcMater(): int
    {
        return $this->codigoPcMater;
    }

    /**
     * Set the value of codigoPcMater
     */
    public function setCodigoPcMater(int $codigoPcMater): self
    {
        $this->codigoPcMater = $codigoPcMater;

        return $this;
    }

    /**
     * Get the value of quantidade
     */
    public function getQuantidade(): float
    {
        return $this->quantidade;
    }

    /**
     * Set the value of quantidade
     */
    public function setQuantidade(float $quantidade): self
    {
        $this->quantidade = $quantidade;

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
     * Get the value of tipoControle
     */
    public function isTipoControle(): bool
    {
        return $this->tipoControle;
    }

    /**
     * Set the value of tipoControle
     */
    public function setTipoControle(bool $tipoControle): self
    {
        $this->tipoControle = $tipoControle;

        return $this;
    }

    /**
     * Get the value of servicoQuantidade
     */
    public function isServicoQuantidade(): bool
    {
        return $this->servicoQuantidade;
    }

    /**
     * Set the value of servicoQuantidade
     */
    public function setServicoQuantidade(bool $servicoQuantidade): self
    {
        $this->servicoQuantidade = $servicoQuantidade;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return integer|null
     */
    public function getAcordoPosicaoTipo(): ?int
    {
        return $this->acordoPosicaoTipo;
    }

    /**
     * Undocumented function
     *
     * @param integer|null $acordoPosicaoTipo
     * @return self
     */
    public function setAcordoPosicaoTipo(?int $acordoPosicaoTipo): self
    {
        $this->acordoPosicaoTipo = $acordoPosicaoTipo;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string
     */
    public function getDescricaoItem(): string
    {
        return $this->descricaoItem;
    }

    /**
     * Undocumented function
     *
     * @param string $descricaoItem
     * @return self
     */
    public function setDescricaoItem(string $descricaoItem): self
    {
        $this->descricaoItem = $descricaoItem;

        return $this;
    }

    /**
     * Get the value of inicioExecucao
     */
    public function getInicioExecucao(): ?DateTime
    {
        return $this->inicioExecucao;
    }

    /**
     * Set the value of inicioExecucao
     */
    public function setInicioExecucao(?DateTime $inicioExecucao): self
    {
        $this->inicioExecucao = $inicioExecucao;

        return $this;
    }

    /**
     * Get the value of fimExecucao
     */
    public function getFimExecucao(): ?DateTime
    {
        return $this->fimExecucao;
    }

    /**
     * Set the value of fimExecucao
     */
    public function setFimExecucao(?DateTime $fimExecucao): self
    {
        $this->fimExecucao = $fimExecucao;

        return $this;
    }
}
