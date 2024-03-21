<?php

namespace App\Domain\Patrimonial\Aditamento;

use DateTime;

class Item
{
    /**
     * Undocumented variable
     *
     * @var integer|null
     */
    private ?int $itemSequencial = null;

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
    private float $quantidade = 0;

    /**
     * @var float
     */
    private float $quantidadeAnterior = 0;

    /**
     * @var float
     */
    private float $valorUnitario = 0;

    /**
     * @var float
     */
    private float $valorAnteriorUnitario = 0;

    /**
    * @var float
    */
    private float $valorTotal;

    /**
     * @var float
     */
    private float $quantidadeAditada = 0;

    /**
     * @var boolean
     */
    private bool $tipoControle = true;

    /**
     * @var boolean
     */
    private bool $servicoQuantidade = true;

    /**
     * @var integer
     */
    private ?int $acordoPosicaoTipo = null;

    /**
     *
     * @var DateTime|null
     */
    private ?DateTime $inicioExecucao = null;

    /**
     *
     * @var DateTime|null
     */
    private ?DateTime $fimExecucao = null;

    /**
     *
     * @var integer|null
     */
    private ?int $unidade = null;

    /**
     *
     * @var integer|null
     */
    private ?int $codigoElemento = null;

    /**
     *
     * @var integer|null
     */
    private ?int $ordem = null;

    /**
     *
     * @var array
     */
    private array $itemDotacoes = [];

    /**
     *
     * @var boolean
     */
    private bool $eExecutado = false;


    /**
     * Get the value of itemSequencial
     */
    public function getItemSequencial(): ?int
    {
        return $this->itemSequencial;
    }

    /**
     * Set the value of itemSequencial
     */
    public function setItemSequencial(?int $itemSequencial): self
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
        $this->descricaoItem =  mb_convert_encoding($descricaoItem,  "UTF-8", "ISO-8859-1");;

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

    /**
     * Get the value of valorAnteriorUnitario
     */
    public function getValorAnteriorUnitario(): float
    {
        return $this->valorAnteriorUnitario;
    }

    /**
     * Set the value of valorAnteriorUnitario
     */
    public function setValorAnteriorUnitario(float $valorAnteriorUnitario): self
    {
        $this->valorAnteriorUnitario = $valorAnteriorUnitario;

        return $this;
    }

    /**
     * Get the value of quantidadeAnterior
     */
    public function getQuantidadeAnterior(): float
    {
        return $this->quantidadeAnterior;
    }

    /**
     * Set the value of quantidadeAnterior
     */
    public function setQuantidadeAnterior(float $quantidadeAnterior): self
    {
        $this->quantidadeAnterior = $quantidadeAnterior;

        return $this;
    }

    /**
     * Get the value of itemDotacoes
     */
    public function getItemDotacoes(): array
    {
        return $this->itemDotacoes;
    }

    /**
     * Set the value of itemDotacoes
     */
    public function setItemDotacoes(array $itemDotacoes): self
    {
        $this->itemDotacoes = $itemDotacoes;

        return $this;
    }

    /**
     * Get the value of unidade
     */
    public function getUnidade(): ?int
    {
        return $this->unidade;
    }

    /**
     * Set the value of unidade
     */
    public function setUnidade(?int $unidade): self
    {
        $this->unidade = $unidade;

        return $this;
    }



    /**
     * Get the value of eExecutado
     */
    public function isEExecutado(): bool
    {
        return $this->eExecutado;
    }

    /**
     * Set the value of eExecutado
     */
    public function setEExecutado(bool $eExecutado): self
    {
        $this->eExecutado = $eExecutado;

        return $this;
    }

    /**
     * Get the value of codigoElemento
     */
    public function getCodigoElemento(): ?int
    {
        return $this->codigoElemento;
    }

    /**
     * Set the value of codigoElemento
     */
    public function setCodigoElemento(?int $codigoElemento): self
    {
        $this->codigoElemento = $codigoElemento;

        return $this;
    }

    /**
     * Get the value of ordem
     */
    public function getOrdem(): ?int
    {
        return $this->ordem;
    }

    /**
     * Set the value of ordem
     */
    public function setOrdem(?int $ordem): self
    {
        $this->ordem = $ordem;

        return $this;
    }

    /**
     * Get the value of valorAditado
     */
    public function getValorAditado(): float
    {
        return $this->getQuantidadeAditada() * $this->getValorUnitario();
    }

    /**
     * Get the value of quantidadeAditada
     */
    public function getQuantidadeAditada(): float
    {
        return $this->quantidadeAditada;
    }

    /**
     * Set the value of quantidadeAditada
     */
    public function setQuantidadeAditada(float $quantidadeAditada): self
    {
        $this->quantidadeAditada = $quantidadeAditada;

        return $this;
    }
}
