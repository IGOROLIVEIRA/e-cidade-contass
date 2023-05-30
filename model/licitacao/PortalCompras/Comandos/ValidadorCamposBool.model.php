<?php


class ValidadorCamposBool
{
    /**
     * Undocumented function
     *
     * @param string $valor
     * @return boolean
     */
    public function execute(string $valor = null): bool
    {
        if ($valor == 't') {
            return true;
        }
        return false;
    }
}