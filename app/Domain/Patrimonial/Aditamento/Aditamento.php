<?php

namespace App\Domain\Patrimonial\Aditamento;

use DateTime;

class Aditamento
{
    /**
     * @var integer
     */
    private int $acordoPosicaoSequencial;

    /**
     * @var integer
     */
    private int $acordoSequencial;

    /**
     * @var integer
     */
    private int $posicaoAditamentoSequencial;

    /**
     * @var integer
     */
    private int $tipoAditivo;

    /**
     * @var integer
     */
    private int $numeroAditamento;

    /**
     * @var DateTime
     */
    private DateTime $dataAssinatura;

    /**
     * @var DateTime
     */
    private DateTime $dataPublicacao;

    /**
     * @var string
     */
    private string $descricaoAlteracao;

    /**
     * @var string
     */
    private string $veiculoDivulgacao;

    /**
     * @var float
     */
    private float $indiceReajuste = 0.0;

    /**
     * @var float
     */
    private float $percentualReajuste = 0.0;

    /**
     * @var boolean
     */
    private bool $vigenciaAlterada = false;

    /**
     * @var string
     */
    private string $descricaoIndice;

    /**
     * @var DateTime
     */
    private DateTime $vigenciaInicio;

    /**
     * @var DateTime
     */
    private DateTime $vigenciaFim;

    /**
     * @var Item[]
     */
    private array $itens;

    /**
     * @return integer
     */
    public function getAcordoPosicaoSequencial(): int
    {
        return $this->acordoPosicaoSequencial;
    }

    /**
     * @param integer $acordoPosicaoSequencial
     * @return self
     */
    public function setAcordoPosicaoSequencial(int $acordoPosicaoSequencial): self
    {
        $this->acordoPosicaoSequencial = $acordoPosicaoSequencial;
        return $this;
    }

    /**
     * @return integer
     */
    public function getAcordoSequencial(): int
    {
        return $this->acordoSequencial;
    }

    /**
     * @param integer $acordoSequencial
     * @return self
     */
    public function setAcordoSequencial(int $acordoSequencial): self
    {
        $this->acordoSequencial = $acordoSequencial;
        return $this;
    }

    /**
     * @return integer
     */
    public function getTipoAditivo(): int
    {
        return $this->tipoAditivo;
    }

    /**
     * @param integer $tipoAditivo
     * @return self
     */
    public function setTipoAditivo(int $tipoAditivo): self
    {
        $this->tipoAditivo = $tipoAditivo;
        return $this;
    }

    /**
     * @return integer
     */
    public function getNumeroAditamento(): int
    {
        return $this->numeroAditamento;
    }

    /**
     * @param integer $numeroAditamento
     * @return self
     */
    public function setNumeroAditamento(int $numeroAditamento): self
    {
        $this->numeroAditamento = $numeroAditamento;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDataAssinatura(): DateTime
    {
        return $this->dataAssinatura;
    }

    /**
     * @param DateTime $dataAssinatura
     * @return self
     */
    public function setDataAssinatura(DateTime $dataAssinatura): self
    {
        $this->dataAssinatura = $dataAssinatura;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDataPublicacao(): DateTime
    {
        return $this->dataPublicacao;
    }

    /**
     * @param DateTime $dataPublicacao
     * @return self
     */
    public function setDataPublicacao(DateTime $dataPublicacao): self
    {
        $this->dataPublicacao = $dataPublicacao;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescricaoAlteracao(): string
    {
        return $this->descricaoAlteracao;
    }

    /**
     * @param string $descricaoAlteracao
     * @return self
     */
    public function setDescricaoAlteracao(string $descricaoAlteracao): self
    {
        $this->descricaoAlteracao = $descricaoAlteracao;
        return $this;
    }

    /**
     * @return string
     */
    public function getVeiculoDivulgacao(): string
    {
        return $this->veiculoDivulgacao;
    }

    /**
     * @param string $veiculoDivulgacao
     * @return self
     */
    public function setVeiculoDivulgacao(string $veiculoDivulgacao): self
    {
        $this->veiculoDivulgacao = $veiculoDivulgacao;
        return $this;
    }

    /**
     * @return float
     */
    public function getIndiceReajuste(): float
    {
        return $this->indiceReajuste;
    }

    /**
     * @param float $indiceReajuste
     * @return self
     */
    public function setIndiceReajuste(float $indiceReajuste): self
    {
        $this->indiceReajuste = $indiceReajuste;
        return $this;
    }

    /**
     * @return float
     */
    public function getPercentualReajuste(): float
    {
        return $this->percentualReajuste;
    }

    /**
     * @param float $percentualReajuste
     * @return self
     */
    public function setPercentualReajuste(float $percentualReajuste): self
    {
        $this->percentualReajuste = $percentualReajuste;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getVigenciaAlterada(): bool
    {
        return $this->vigenciaAlterada;
    }

    /**
     * @param string $vigenciaAlterada
     * @return self
     */
    public function setVienciaAlterada(string $vigenciaAlterada): self
    {
        $this->vigenciaAlterada = true;

        if ($vigenciaAlterada === "n") {
            $this->vigenciaAlterada = false;
         }

         return $this;
    }

    /**
     * @return array
     */
    public function getItens(): array
    {
        return $this->itens;
    }

    /**
     * @param Item[] $itens
     * @return self
     */
    public function setItens(array $itens): self
    {
        $this->itens = $itens;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDescricaoIndice(): string
    {
        return $this->descricaoIndice;
    }

    /**
     * @param string $descricaoIndice
     * @return self
     */
    public function setDescricaoIndice(string $descricaoIndice): self
    {
        $this->descricaoIndice = $descricaoIndice;

        return $this;
    }

    /**
     * Get the value of vigenciaFim
     */
    public function getVigenciaFim(): DateTime
    {
        return $this->vigenciaFim;
    }

    /**
     * Set the value of vigenciaFim
     */
    public function setVigenciaFim(DateTime $vigenciaFim): self
    {
        $this->vigenciaFim = $vigenciaFim;

        return $this;
    }

    /**
     * Get the value of vigenciaInicio
     */
    public function getVigenciaInicio(): DateTime
    {
        return $this->vigenciaInicio;
    }

    /**
     * Set the value of vigenciaInicio
     */
    public function setVigenciaInicio(DateTime $vigenciaInicio): self
    {
        $this->vigenciaInicio = $vigenciaInicio;

        return $this;
    }
}
