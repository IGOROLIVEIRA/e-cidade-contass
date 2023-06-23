<?php

require_once("model/licitacao/PortalCompras/Julgamento/Lote.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Participante.model.php");


class Julgamento
{
    /**
     * @var integer $idJulgamento
     */
    private int    $idJulgamento;

    /**
     * @var string $dataProposta
     */
    private string $dataProposta;

    /**
     * @var string $horaProposta
     */
    private string $horaProposta;

    /**
     * @var string $numero
     */
    private string $numero;

    /**
     * @var Lote[] $lotes
     */
    private array  $lotes;

   /**
    * @var string  $dataAberturaProposta
    */
    private string $dataAberturaProposta;

    /**
     * @var Participante[] $participantes
     */
    private array $participantes;

    /**
     * Get the value of dataProposta
     */
    public function getDataProposta(): string
    {
        return $this->dataProposta;
    }

    /**
     * Set the value of dataProposta
     */
    public function setDataProposta(string $dataProposta): self
    {
        $this->dataProposta = $dataProposta;

        return $this;
    }

    /**
     * Get the value of lotes
     */
    public function getLotes(): array
    {
        return $this->lotes;
    }

    /**
     * Set the value of lotes
     */
    public function setLotes(array $lotes): self
    {
        $this->lotes = $lotes;

        return $this;
    }

    /**
     * Get the value of idJulgamento
     */
    public function getId(): int
    {
        return $this->idJulgamento;
    }

    /**
     * Set the value of idJulgamento
     */
    public function setId(int $idJulgamento): self
    {
        $this->idJulgamento = $idJulgamento;

        return $this;
    }



    /**
     * Get the value of numero
     */
    public function getNumero(): string
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     */
    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get the value of horaProposta
     */
    public function getHoraProposta(): string
    {
        return $this->horaProposta;
    }

    /**
     * Set the value of horaProposta
     */
    public function setHoraProposta(string $horaProposta): self
    {
        $this->horaProposta = $horaProposta;

        return $this;
    }

    /**
     * Get the value of dataAberturaProposta
     */
    public function getDataAberturaProposta(): string
    {
        return $this->dataAberturaProposta;
    }

    /**
     * Set the value of dataAberturaProposta
     */
    public function setDataAberturaProposta(string $dataAberturaProposta): self
    {
        $date = DateTime::createFromFormat('d/m/Y', $dataAberturaProposta);
        $this->dataAberturaProposta = $date->format('Y-m-d');

        return $this;
    }

    /**
     * Get the value of participantes
     */
    public function getParticipantes(): array
    {
        return $this->participantes;
    }

    /**
     * Set the value of participantes
     */
    public function setParticipantes(array $participantes): self
    {
        $this->participantes = $participantes;

        return $this;
    }
}