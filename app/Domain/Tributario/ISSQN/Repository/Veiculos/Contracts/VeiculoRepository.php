<?php
namespace App\Domain\Tributario\ISSQN\Repository\Veiculos\Contracts;

use App\Domain\Tributario\ISSQN\Model\Veiculos\Veiculo;

/**
* Interface da classe VeiculoRepository
*
* @var string
*/
interface VeiculoRepository
{
    /**
     * Fun��o que salva um novo registro
     *
     * @param Veiculo $model
     */
    public function persist(Veiculo $model);

    /**
     * Fun��o que remove um registro
     *
     * @param integer $id
     */
    public function delete($id);
}
