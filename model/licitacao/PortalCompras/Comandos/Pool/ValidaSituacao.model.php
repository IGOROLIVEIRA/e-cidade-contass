<?php

require_once("model/licitacao/PortalCompras/Comandos/ValidaAcessoApiInterface.model.php");

class ValidaSituacao implements ValidaAcessoApiInterface
{
     /**
     * Verifica se a licitacao esta em andamento
     *
     * @param resource $results
     * @return void
     */
    public function execute($results): void
    {
      $situacao =  db_utils::fieldsMemory($results,0)->situacao;
      if((int)$situacao != 0) {
        throw new Exception('Só é possível publicar licitações em situação "Em andamento"');
      }
    }
}
