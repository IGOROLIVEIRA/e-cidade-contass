<?php


class Lote
{
    /**
     * @var integer
     */
    private int   $id;

    /**
     * @var array
     */
    private array $items;

    /**
     * Get the value of items
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Set the value of items
     */
    public function setItems(array $items): self
    {
        $this->items = $items;

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