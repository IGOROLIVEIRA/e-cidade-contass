<?php

namespace App\Repositories\Patrimonial;

use App\Models\AcordoPosicao;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoRepositoryInterface;
use DateTime;

class AcordoPosicaoRepository implements AcordoPosicaoRepositoryInterface
{
    private AcordoPosicao $acordoPosicao;

    public function __construct()
    {
        $this->acordoPosicao = new AcordoPosicao();
    }

     /**
     *
     * @param integer $ac26Acordo
     * @return AcordoPosicao
     */
    public function getAditamentoUltimaPosicao(int $ac26Acordo): AcordoPosicao
    {
        $acordoPosicao = $this->acordoPosicao
                ->with(['itens','posicaoAditamento','acordo'])
                ->where('ac26_acordo',$ac26Acordo)
                ->whereNotNull('ac26_numeroaditamento')
                ->orderBy('ac26_numeroaditamento', 'desc')
                ->first();

       return $acordoPosicao;
    }
}
