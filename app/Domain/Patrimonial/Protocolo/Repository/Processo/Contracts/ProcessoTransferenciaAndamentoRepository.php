<?php
namespace App\Domain\Patrimonial\Protocolo\Repository\Processo\Contracts;

use App\Domain\Patrimonial\Protocolo\Model\Processo\ProcessoTransferenciaAndamento;

/**
* Interface da classe ProcessoTransferenciaAndamentoRepository
*
* @var string
*/
interface ProcessoTransferenciaAndamentoRepository
{
    /**
     * Fun��o que salva um novo registro
     *
     * @param ProcessoTransferenciaAndamento $model
     */
    public function persist(ProcessoTransferenciaAndamento $model);
}
