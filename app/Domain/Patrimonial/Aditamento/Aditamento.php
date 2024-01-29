<?php

namespace App\Domain\Patrimonial\Aditamento;

use DateTime;

class Aditamento
{
    private const TIPO_REAJUSTE = 5;

    private const TIPO_ALTERACAO_PRAZO = 8;

    private const TIPO_ALTERACAO_VIGENCIA = 6;

    private const TIPO_VIGENCIA_EXECUCAO = 13;

    private const TIPO_ACDC_CONJUGADO = 14;

    private const TIPO_ALTERACAO_PROJETO_ESPECIF = 12;

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
    private int $tipoAditivo = 0;

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
    private string $veiculoDivulgacao;

    /**
     * @var float|null
     */
    private ?float $indiceReajuste = null;

    /**
     * @var float|null
     */
    private ?float $percentualReajuste = null;

     /**
     *
     * @var string|null
     */
    private ?string $descricaoIndice = null;

    /**
     * @var integer|null
     */
    private ?int $criterioReajuste = null;

    /**
     * @var string|null
     */
    private ?string $resumoObjeto = null;

    /**
     * @var boolean
     */
    private bool $vigenciaAlterada = false;

    /**
     * @var DateTime
     */
    private DateTime $vigenciaInicio;

    /**
     * @var DateTime
     */
    private DateTime $vigenciaFim;

    /**
     * @var string|null
     */
    private ?string $justificativa = null;

    /**
     * @var string|null
     */
    private ?string $descricaoAlteracao = null;

    /**
     * @var DateTime|null
     */
    private ?DateTime $dataReferencia = null;

    /**
     * @var boolean
     */
    private bool $vigenciaIndeterminanda = false;

    /**
     * @var Item[]
     */
    private array $itens = [];

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


    /**
     * @return string|null
     */
    public function getJustificativa(): ?string
    {
        return $this->justificativa;
    }

    /**
     * @param string|null $justificativa
     * @return self
     */
    public function setJustificativa(?string $justificativa): self
    {
        $this->justificativa = $justificativa;

        return $this;
    }

    /**
     * Undocumented function
     *
     * @return float|null
     */
    public function getIndiceReajuste(): ?float
    {
        return $this->indiceReajuste;
    }

    /**
     * @param float|null $indiceReajuste
     * @return self
     */
    public function setIndiceReajuste(?float $indiceReajuste): self
    {
        $this->indiceReajuste = $indiceReajuste;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPercentualReajuste(): ?float
    {
        return $this->percentualReajuste;
    }

    /**
     * @param float|null $percentualReajuste
     * @return self
     */
    public function setPercentualReajuste(?float $percentualReajuste): self
    {
        $this->percentualReajuste = $percentualReajuste;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getResumoObjeto(): ?string
    {
        return $this->resumoObjeto;
    }

    /**
     * @param string|null $resumoObjeto
     * @return self
     */
    public function setResumoObjeto(?string $resumoObjeto): self
    {
        $this->resumoObjeto =  mb_convert_encoding($resumoObjeto,"UTF-8", "ISO-8859-1");

        return $this;
    }

    /**
     * Get the value of posicaoAditamentoSequencial
     */
    public function getPosicaoAditamentoSequencial(): int
    {
        return $this->posicaoAditamentoSequencial;
    }

    /**
     * Set the value of posicaoAditamentoSequencial
     */
    public function setPosicaoAditamentoSequencial(int $posicaoAditamentoSequencial): self
    {
        $this->posicaoAditamentoSequencial = $posicaoAditamentoSequencial;

        return $this;
    }

    /**
     * Get the value of descricaoIndice
     */
    public function getDescricaoIndice(): ?string
    {
        return $this->descricaoIndice;
    }

    /**
     * Set the value of descricaoIndice
     */
    public function setDescricaoIndice(?string $descricaoIndice): self
    {
        $this->descricaoIndice = $descricaoIndice;

        return $this;
    }

    /**
     * Get the value of descricaoAlteracao
     */
    public function getDescricaoAlteracao(): ?string
    {
        return $this->descricaoAlteracao;
    }

    /**
     * Set the value of descricaoAlteracao
     */
    public function setDescricaoAlteracao(?string $descricaoAlteracao): self
    {
        $this->descricaoAlteracao = $descricaoAlteracao;

        return $this;
    }

    /**
     *
     * @return boolean
     */
    public function isReajuste(): bool
    {
        return $this->getTipoAditivo() === self::TIPO_REAJUSTE;
    }

    /**
     *
     * @return boolean
     */
    public function isAlteracaoPrazo(): bool
    {
        return $this->getTipoAditivo() === self::TIPO_ALTERACAO_PRAZO;
    }

     /**
     *
     * @return boolean
     */
    public function isAlteracaoVigencia(): bool
    {
        return $this->getTipoAditivo() === self::TIPO_ALTERACAO_VIGENCIA;
    }

     /**
     *
     * @return boolean
     */
    public function isVigenciaExecucao(): bool
    {
        return $this->getTipoAditivo() === self::TIPO_VIGENCIA_EXECUCAO;
    }

     /**
     *
     * @return boolean
     */
    public function isAcdcConjugado(): bool
    {
        return $this->getTipoAditivo() === self::TIPO_ACDC_CONJUGADO;
    }

    public function isAlteracaoProjetoEspecificacao(): bool
    {
        return $this->getTipoAditivo() === self::TIPO_ALTERACAO_PROJETO_ESPECIF;
    }

    /**
     * Undocumented function
     *
     * @return DateTime|null
     */
    public function getDataReferencia(): ?DateTime
    {
        return $this->dataReferencia;
    }

    /**
     * Undocumented function
     *
     * @param DateTime|null $dataReferencia
     * @return self
     */
    public function setDataReferencia(?DateTime $dataReferencia): self
    {
        $this->dataReferencia = $dataReferencia;

        return $this;
    }

    /**
     * Get the value of vigenciaIndeterminanda
     */
    public function isVigenciaIndeterminanda(): bool
    {
        return $this->vigenciaIndeterminanda;
    }

    /**
     * Set the value of vigenciaIndeterminanda
     */
    public function setVigenciaIndeterminanda(bool $vigenciaIndeterminanda): self
    {
        $this->vigenciaIndeterminanda = $vigenciaIndeterminanda;

        return $this;
    }

    /**
     * Get the value of criterioReajuste
     */
    public function getCriterioReajuste(): ?int
    {
        return $this->criterioReajuste;
    }

    /**
     * Set the value of criterioReajuste
     */
    public function setCriterioReajuste(?int $criterioReajuste): self
    {
        $this->criterioReajuste = $criterioReajuste;

        return $this;
    }
}
