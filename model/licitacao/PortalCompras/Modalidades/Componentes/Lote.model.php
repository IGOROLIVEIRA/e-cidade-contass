<?php

class Lote implements \JsonSerializable
{
    /**
     * @var integer
     */
    private int $numero;

    /**
     * @var string
     */
    private string $descricao;

    /**
     * @var boolean
     */
    private bool $exclusivoMPE;

    /**
     * @var boolean
     */
    private bool $cotaReservada;

    /**
     * @var string
     */
    private string $justificativa;

    /**
     * Undocumented variable
     *
     * @var Item[]
     */
    private array $itens;

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
     * Get the value of descricao
     */
    public function getDescricao(): int
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     */
    public function setDescricao(string $descricao): self
    {
        $this->descricao = utf8_encode($descricao);

        return $this;
    }

    /**
     * Get the value of exclusivoMPE
     */
    public function isExclusivoMPE(): bool
    {
        return $this->exclusivoMPE;
    }

    /**
     * Set the value of exclusivoMPE
     */
    public function setExclusivoMPE(bool $exclusivoMPE): self
    {
        $this->exclusivoMPE = $exclusivoMPE;

        return $this;
    }

    /**
     * Get the value of cotaReservada
     */
    public function iscotaReservada(): bool
    {
        return $this->cotaReservada;
    }

    /**
     * Set the value of cotaReservada
     */
    public function setcotaReservada(string $cotaReservada): self
    {
        $this->cotaReservada = true;

        if ($cotaReservada == 'f') {
            $this->cotaReservada = false;
        }

        return $this;
    }

    /**
     * Get the value of justificativa
     */
    public function getJustificativa(): string
    {
        return $this->justificativa;
    }

    /**
     * Set the value of justificativa
     */
    public function setJustificativa(string $justificativa): self
    {
        $this->justificativa = $justificativa;

        return $this;
    }

    /**
     * Get the value of itens
     */
    public function getItensArray(): array
    {
        return $this->itens;
    }

    /**
     * Set the value of itens
     */
    public function setItens(Item $item): self
    {
        $this->itens[] = $item;

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
            "numero"=> $this->numero,
            "descricao"=> $this->descricao,
            "exclusivoMPE"=> $this->exclusivoMPE,
            "cotaReservada"=> $this->cotaReservada,
            "justificativa"=> $this->justificativa,
            "itens" => $this->getItensArray(),
        ];
    }
}