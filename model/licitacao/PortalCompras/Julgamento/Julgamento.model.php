<?php

require_once("model/licitacao/PortalCompras/Julgamento/Lotes.model.php");


class Julgamento
{
    /**
     * @var integer
     */
    private int    $idJulgamento;
    /**
     * @var string
     */
    private string $dataProposta;

    /**
     * @var string
     */
    private string $horaProposta;

    /**
     * @var string
     */
    private string $numero;

    /**
     * @var Lote[] $lotes
     */
    private array  $lotes;

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
}