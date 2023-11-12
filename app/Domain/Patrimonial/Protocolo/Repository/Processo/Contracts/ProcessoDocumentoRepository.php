<?php
namespace App\Domain\Patrimonial\Protocolo\Repository\Processo\Contracts;

use App\Domain\Patrimonial\Protocolo\Model\Processo\ProcessoDocumento;

/**
* Interface da classe ProcessoRepository
*
* @var string
*/
interface ProcessoDocumentoRepository
{
    /**
     * Fun��o que salva um novo registro
     *
     * @param ProcessoDocumento $model
     */
    public function persist(ProcessoDocumento $model);
}
