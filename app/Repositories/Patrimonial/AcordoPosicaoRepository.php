<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoPosicao;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoRepositoryInterface;
use DateTime;

class AcordoPosicaoRepository implements AcordoPosicaoRepositoryInterface
{
    /**
     *
     * @var AcordoPosicao
     */
    private AcordoPosicao $model;

    public function __construct()
    {
        $this->model = new AcordoPosicao();
    }

    /**
     * Undocumented function
     *
     * @param integer $idAcordo
     * @param integer $numeroAditamento
     * @return AcordoPosicao|null
     */
    public function getAcordoPorNumeroAditamento(int $idAcordo, int $numeroAditamento): ?AcordoPosicao
    {
        return $this->model->where('ac26_acordo', $idAcordo)
                    ->where('ac26_numeroaditamento', $numeroAditamento)
                    ->first();
    }

     /**
     *
     * @param integer $ac26Acordo
     * @return AcordoPosicao
     */
    public function getAditamentoUltimaPosicao(int $ac26Acordo): AcordoPosicao
    {
        $acordoPosicao = $this->model
                ->with(['itens','posicaoAditamento','acordo'])
                ->where('ac26_acordo',$ac26Acordo)
                ->whereNotNull('ac26_numeroaditamento')
                ->orderBy('ac26_numeroaditamento', 'desc')
                ->first();

       return $acordoPosicao;
    }



    /**
     *
     * @param integer $codigo
     * @param array $dados
     * @return boolean
     */
    public function update(int $codigo, array $dados): bool
    {
        $acordoPosicao = $this->model->find($codigo);

        return $acordoPosicao->update($dados);
    }
}
