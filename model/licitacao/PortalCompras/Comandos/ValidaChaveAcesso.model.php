<?php

require_once("model/licitacao/PortalCompras/Comandos/ValidadorAcessoApiInterface.model.php");
require_once("classes/db_liclicitaportalcompras_classe.php");

class ValidaChaveAcesso
{
    /**
     * Valida se existe chave de acesso a api
     *
     * @param resource|null $results
     * @return string
     */
    public function execute($results = null): string
    {
        $cl_liclicitaportalcompras = new cl_liclicitaportalcompras;
        $chaveAcesso = db_utils::fieldsMemory(
            $cl_liclicitaportalcompras->buscaChaveDeAcesso(
                db_getsession("DB_instit")
                )
        , 0)->chaveacesso;

        if (empty($chaveAcesso)) {
            throw new Exception(utf8_encode("Chave de acesso não esta cadastrada"));
        }
        return $chaveAcesso;
    }
}