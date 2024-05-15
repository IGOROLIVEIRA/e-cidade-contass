<?php

require_once('interfaces/orcamento/ITipoSuplementacaoSuperavitDeficitRepository.php');

/**
 * @author widouglas
 */
class TipoSuplementacaoSuperavitDeficitRepositoryLegacy implements ITipoSuplementacaoSuperavitDeficitRepository
{
    public function pegarTipoSup()
    {
        return array('1003', '1008', '1024', '1028', '2026');
    }
}
