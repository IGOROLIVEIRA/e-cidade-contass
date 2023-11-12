<?php

namespace App\Domain\Financeiro\Empenho\Repositories;

use App\Domain\Core\Base\Repository\BaseRepository;
use App\Domain\Financeiro\Empenho\Models\TipoAquisicaoProducaoRural;
use ECidade\Financeiro\Empenho\Enum\TipoAquisicaoProducaoRural as EnumTipoAquisicaoProducaoRural;

class TipoAquisicaoProducaoRuralRepository extends BaseRepository
{
    /**
     * Model
     *
     * @var TipoAquisicaoProducaoRural
     */
    protected $modelClass = TipoAquisicaoProducaoRural::class;

    /**
     * Persiste informa��es na base de dados
     *
     * @param TipoAquisicaoProducaoRural $tipoAquisicaoProducaoRural
     * @return bool
     */
    public function persist(TipoAquisicaoProducaoRural $tipoAquisicaoProducaoRural)
    {
        return $tipoAquisicaoProducaoRural->save();
    }

    /**
     * Retorna uma instancia da model
     *
     * @param int $id
     * @return TipoAquisicaoProducaoRural
     */
    public function getModelInstance($id = null)
    {
        if (is_numeric($id)) {
            return TipoAquisicaoProducaoRural::find($id);
        }

        return new TipoAquisicaoProducaoRural;
    }

    /**
     * Retorna uma inst�ncia da model filtrando pelo numero de empenho
     *
     * @param int $numemp e60_numemp
     * @return TipoAquisicaoProducaoRural
     */
    public static function findByEmpenho($numemp)
    {
        return TipoAquisicaoProducaoRural::where('e159_empempenho', '=', $numemp)->first();
    }

    /**
     * Retorna os labels
     *
     * @param int $tipo
     * @param string $tipoPessoa pf (Pessoa F�sisca) ou pj (Pessoa Jur�dica)
     * @return array
     */
    public static function labels($tipo = null, $tipoPessoa = null)
    {
        $labels = EnumTipoAquisicaoProducaoRural::toArrayWithNames();

        if ($tipo) {
            $tipo = (int) $tipo;
            return (new EnumTipoAquisicaoProducaoRural($tipo))->name();
        }

        if (!empty($tipoPessoa)) {
            return self::filterLabels($labels, $tipoPessoa);
        }

        return $labels;
    }

    /**
     * Helper para filtrar os labels
     *
     * @param array $labels
     * @param int $tipoPessoa
     * @return array
     */
    private function filterLabels($labels, $tipoPessoa)
    {
        $pjLabels = [3, 6];
        $pfLabels = [1, 2, 4, 5, 7];
        $labelFiltered = [];

        switch ($tipoPessoa) {
            case 'pj':
                $labelFiltered = array_filter($labels, function ($item) use ($pjLabels) {
                    return in_array($item['value'], $pjLabels);
                });
                break;
            case 'pf':
                $labelFiltered = array_filter($labels, function ($item) use ($pfLabels) {
                    return in_array($item['value'], $pfLabels);
                });
                break;
        }

        return array_values($labelFiltered);
    }
}
