<?php

require_once("model/licitacao/PortalCompras/Comandos/ValidaAcessoApiInterface.model.php");

class ValidaResultadoVazio implements ValidaAcessoApiInterface
{
     /**
     * Verifica se resultado � vazio
     *
     * @param resource|null $results
     * @return void
     */
    public function execute($results = null): void
    {
        if (empty($results)) {
            throw new Exception("Registro n�o encontrado");
        }
    }
}