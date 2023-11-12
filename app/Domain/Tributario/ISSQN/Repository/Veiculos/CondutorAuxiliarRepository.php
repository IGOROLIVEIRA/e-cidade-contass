<?php
namespace App\Domain\Tributario\ISSQN\Repository\Veiculos;

use Illuminate\Database\Eloquent\Builder as EloquentQueryBuilder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Pagination\AbstractPaginator as Paginator;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use App\Domain\Core\Base\Repository\BaseRepository;
use App\Domain\Tributario\ISSQN\Model\Veiculos\CondutorAuxiliar;
use App\Domain\Tributario\ISSQN\Repository\Veiculos\Contracts\CondutorAuxiliarRepository as RepositoryInterface;

use Exception;

/**
* Classe abstrata para Repositorys. Usa eloquent
*/
final class CondutorAuxiliarRepository extends BaseRepository implements RepositoryInterface
{
    /**
     * Model class for repo.
     * @var string
     */
    protected $modelClass = CondutorAuxiliar::class;

    /**
     * Fun��o que salva um novo registro
     *
     * @param CondutorAuxiliar $model
     * @return boolean
     */
    public function persist(
        CondutorAuxiliar $model
    ) {
        return $model->save();
    }

    /**
     * Fun��o que remove um registro
     * @param integer $id
     * @return boolean
     */
    public function delete($id)
    {
        return CondutorAuxiliar::destroy($id);
    }

    /**
     * Busca os condutores pelo c�digo da inscri��o do ve�culo
     * @param integer $codigoVeiculo
     * @return boolean
     */
    public function findByVeiculo($codigoVeiculo)
    {
        $query = $this->newQuery()
                      ->select('issveiculocondutorauxiliar.*', 'z01_nome')
                      ->join('protocolo.cgm', 'z01_numcgm', 'q173_cgm')
                      ->where('q173_issveiculo', '=', $codigoVeiculo);

        return $this->doQuery($query);
    }

    /**
     * Remove todos os condutores auxiliares de uma inscri��o de ve�culo
     * @param integer $codigoVeiculo
     */
    public function deleteByInscricaoVeiculo($codigoVeiculo)
    {
        return CondutorAuxiliar::where('q173_issveiculo', $codigoVeiculo)->delete();
    }
}
