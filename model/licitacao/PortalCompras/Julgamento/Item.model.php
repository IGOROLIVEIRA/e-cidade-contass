<?php

require_once("model/licitacao/PortalCompras/Julgamento/Lance.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Ranking.model.php");
require_once("model/licitacao/PortalCompras/Julgamento/Proposta.model.php");

class Item
{
    /**
     * @var integer
     */
    private int $id;

    /**
     * @var Proposta[]
     */
    private array $propostas;

    /**
     * @var Lance[]
     */
    private array $lances = [];

    /**
     * @var Ranking[]
     */
    private array $ranking;

    /**
     * Get the value of lances
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    /**
     * Set the value of lances
     */
    public function setLances(array $lances): self
    {
        $this->lances = $lances;

        return $this;
    }

    /**
     * Get the value of ranking
     */
    public function getRanking(): array
    {
        return $this->ranking;
    }

    /**
     * Set the value of ranking
     */
    public function setRanking(array $ranking): self
    {
        $this->ranking = $ranking;

        return $this;
    }

    /**
     * Get the value of propostas
     */
    public function getPropostas(): array
    {
        return $this->propostas;
    }

    /**
     * Set the value of propostas
     */
    public function setPropostas(array $propostas): self
    {
        $this->propostas = $propostas;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}