<?php

class ValidaCamposBool
{
    /**
     * Undocumented function
     *
     * @param string $valor
     * @return boolean
     */
    public function execute(string $valor = null): bool
    {
        return $valor === 't';
    }
}
