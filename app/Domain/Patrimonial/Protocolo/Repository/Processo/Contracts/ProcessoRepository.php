<?php
namespace App\Domain\Patrimonial\Protocolo\Repository\Processo\Contracts;

use App\Domain\Patrimonial\Protocolo\Model\Processo\Processo;

/**
* Interface da classe ProcessoRepository
*
* @var string
*/
interface ProcessoRepository
{
    /**
     * Fun��o que salva um novo registro
     *
     * @param ProcessoTransferenciaAndamento $model
     */
    public function persist(Processo $model);
}
