<?php
namespace App\Domain\Patrimonial\Protocolo\Repository\Processo\Contracts;

use App\Domain\Patrimonial\Protocolo\Model\Processo\ArquivamentoProcesso;

/**
* Interface da classe ArquivamentoProcessoRepository
*
* @var string
*/
interface ArquivamentoProcessoRepository
{
    /**
     * Fun��o que salva um novo registro
     *
     * @param ArquivamentoProcesso $model
     */
    public function persist(ArquivamentoProcesso $model);
}
