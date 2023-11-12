<?php
namespace App\Domain\Tributario\ISSQN\Repository\AlvaraEventos\Contracts;

use App\Domain\Tributario\ISSQN\Model\AlvaraEventos\OrdemServicoFiscal;

/**
* Interface da classe AndamentoPadraoRepository
*
* @var string
*/
interface OrdemServicoFiscalRepository
{
    /**
     * Fun��o que salva um novo registro
     *
     * @param OrdemServicoFiscal $model
     */
    public function persist(OrdemServicoFiscal $model);

    /**
     * Fun��o que remove todos registros de uma ordem de servico
     *
     * @param integer $ordemServicoId
     */
    public function deleteByOrdemServico($ordemServicoId);
}
