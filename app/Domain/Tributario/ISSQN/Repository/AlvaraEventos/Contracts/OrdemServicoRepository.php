<?php
namespace App\Domain\Tributario\ISSQN\Repository\AlvaraEventos\Contracts;

use App\Domain\Tributario\ISSQN\Model\AlvaraEventos\OrdemServico;

/**
* Interface da classe AndamentoPadraoRepository
*
* @var string
*/
interface OrdemServicoRepository
{
    /**
     * Fun��o que salva um novo registro
     *
     * @param OrdemServico $model
     */
    public function persist(OrdemServico $model);

    /**
     * Fun��o que remove um registro
     *
     * @param integer $id
     */
    public function delete($id);
}
