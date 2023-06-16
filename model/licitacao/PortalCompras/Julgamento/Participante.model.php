<?php

class Participante
{
    /**
     * @var string
     */
    private string $cnpj;

    /**
     * @var string
     */
    private string $representanteLegal;

    /**
     * Get the value of cnpj
     */
    public function getCnpj(): string
    {
        return $this->cnpj;
    }

    /**
     * Set the value of cnpj
     */
    public function setCnpj(string $cnpj): self
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    /**
     * Get the value of representanteLegal
     */
    public function getRepresentanteLegal(): string
    {
        return $this->representanteLegal;
    }

    /**
     * Set the value of representanteLegal
     */
    public function setRepresentanteLegal(string $representanteLegal): self
    {
        $this->representanteLegal = $representanteLegal;

        return $this;
    }
}