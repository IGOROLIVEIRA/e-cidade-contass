<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoPosicao;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoRepositoryInterface;
use DateTime;

class AcordoPosicaoRepository implements AcordoPosicaoRepositoryInterface
{
    private AcordoPosicao $model;

    public function __construct()
    {
        $this->model = new AcordoPosicao();
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

    public function update(int $codigo, array $dados): bool
    {
        $acordoPosicao = $this->model->find($codigo);

        return $acordoPosicao->update($dados);
    }
}
