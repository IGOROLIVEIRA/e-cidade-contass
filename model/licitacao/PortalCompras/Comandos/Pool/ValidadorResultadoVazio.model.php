<?php

require_once("model/licitacao/PortalCompras/Comandos/ValidadorAcessoApiInterface.model.php");

class ValidadorResultadoVazio implements ValidadorAcessoApiInterface
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