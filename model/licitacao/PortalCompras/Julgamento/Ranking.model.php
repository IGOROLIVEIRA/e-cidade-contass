<?php

class Ranking
{
    /**
     * @var string $idFornecedor
     */
    private string $idFornecedor;

    /**
     * @var integer $posicao
     */
    private int $posicao;

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
     * Get the value of posicao
     */
    public function getPosicao(): string
    {
        return $this->posicao;
    }

    /**
     * Set the value of posicao
     */
    public function setPosicao(int $posicao): self
    {
        $this->posicao = $posicao;

        return $this;
    }
}