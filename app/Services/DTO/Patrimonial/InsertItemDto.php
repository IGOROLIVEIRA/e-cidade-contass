<?php
namespace App\Services\DTO\Patrimonial;

use App\Domain\Patrimonial\Aditamento\Item;

class InsertItemDto
{
    private Item $item;
    private int $sequencialAcordoPosicao;
    private string $vigenciaIncio;
    private string $vigenciaFim;

    public function __construct(
        Item $item,
        int $sequencialAcordoPosicao,
        string $vigenciaIncio,
        string $vigenciaFim
    ) {
        $this->item = $item;
        $this->sequencialAcordoPosicao = $sequencialAcordoPosicao;
        $this->vigenciaIncio = $vigenciaIncio;
        $this->vigenciaFim = $vigenciaFim;
    }


    /**
     * Get the value of item
     */
    public function getItem(): Item
    {
        return $this->item;
    }

    /**
     * Get the value of sequencialAcordoPosicao
     */
    public function getSequencialAcordoPosicao(): int
    {
        return $this->sequencialAcordoPosicao;
    }

    /**
     * Get the value of vigenciaIncio
     */
    public function getVigenciaIncio(): string
    {
        return $this->vigenciaIncio;
    }

    /**
     * Get the value of vigenciaFim
     */
    public function getVigenciaFim(): string
    {
        return $this->vigenciaFim;
    }
}
