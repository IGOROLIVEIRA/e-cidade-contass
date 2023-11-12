<?php
namespace App\Domain\Tributario\ISSQN\Repository\Veiculos\Contracts;

use App\Domain\Tributario\ISSQN\Model\Veiculos\CondutorAuxiliar;

/**
* Interface da classe CondutorAuxiliarRepository
*
* @var string
*/
interface CondutorAuxiliarRepository
{
    /**
     * Fun��o que salva um novo registro
     *
     * @param CondutorAuxiliar $model
     */
    public function persist(CondutorAuxiliar $model);

    /**
     * Fun��o que remove um registro
     *
     * @param integer $id
     */
    public function delete($id);
}
