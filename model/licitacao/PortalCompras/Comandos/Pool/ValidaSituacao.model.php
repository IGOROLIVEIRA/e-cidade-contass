<?php

require_once("model/licitacao/PortalCompras/Comandos/ValidaAcessoApiInterface.model.php");

class ValidaSituacao implements ValidaAcessoApiInterface
{
     /**
     * Verifica se a licitacao esta agendada
     *
     * @param resource|null $results
     * @return void
     */
    public function execute($results = null): void
    {
      $situacao =  db_utils::fieldsMemory($results,0)->situacao;
      if((int)$situacao != 0) {
        throw new Exception('Só é possível publicar licitações em situação "agendada"');
      }
    }
}