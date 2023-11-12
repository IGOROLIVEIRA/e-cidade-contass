<?php

namespace App\Domain\Client\Repositories;

use App\User;
use ECidade\Lib\Session\DefaultSession;

class ClientRepository
{
    /**
     * Busca um usu�rio pelo CPF ou CNPJ
     * @param $sCpfCnpj
     * @return array
     * @throws \Exception
     */
    public function getUserEcidadeAuthByCpfCnpj($sCpfCnpj)
    {
        $user = new User();
        $aUser = $user->getUserEcidadeByCpfCnpj($sCpfCnpj);

        if (!$aUser->count()) {
            throw new \Exception("Usu�rio n�o encontrado na base do e-cidade.", 401);
        }

        $oUser = $aUser->offsetGet(0);

        $oRetorno = new \stdClass();
        $oRetorno->oUser = $oUser;
        $oRetorno->aUser = $oUser->toArray();

        return $oRetorno;
    }

    /**
     * Gera um access token de usu�rio para autenticar as rotas privadas do e-cidade
     * @param User $user
     * @return string
     */
    public function getAccessTokenUser(User $user)
    {
        return $user->createToken('tokenId')->accessToken;
    }

    /**
     * Atualiza a sess�o do usu�rio com base no usu�rio autenticado
     * @param $id_usuario
     * @throws \DBException
     */
    public function updateSession($id_usuario)
    {
        DefaultSession::getInstance()->atualizaDadosUsuario($id_usuario);
    }
}
