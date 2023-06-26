<?php

require_once("model/licitacao/PortalCompras/Comandos/ValidaAcessoApiInterface.model.php");
require_once("classes/db_liclicitaportalcompras_classe.php");

class ValidaChaveAcesso
{
    /**
     * Valida se existe chave de acesso a api
     *
     * @param resource|null $results
     * @return string
     */
    public function execute(): string
    {
        $cl_liclicitaportalcompras = new cl_liclicitaportalcompras;
        $chaveAcesso = db_utils::fieldsMemory(
            $cl_liclicitaportalcompras->buscaChaveDeAcesso(
                db_getsession("DB_instit")
                )
        , 0)->chaveacesso;

        if (empty($chaveAcesso)) {
            throw new Exception(utf8_encode("Parâmetros de integração não localizados, favor entrar em contato com o suporte"));
        }
        return $chaveAcesso;
    }
}
