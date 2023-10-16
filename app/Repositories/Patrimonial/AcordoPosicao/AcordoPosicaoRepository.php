<?php

namespace App\Repositories\Patrimonial\AcordoPosicao;

use App\Models\AcordoPosicao;
use App\Repositories\Contracts\Patrimonial\AcordoPosicao\AcordoPosicaoRepositoryInterface;

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
     * @return void
     */
    public function getAditamentoUltimaPosicao(int $ac26Acordo)
    {
        $acordoPosicao = $this->acordoPosicao
                ->where('ac26_acordo',$ac26Acordo)
                ->whereNotNull('ac26_numeroaditamento')
                ->orderBy('ac26_numeroaditamento', 'desc')
                ->first();
        $itens = $acordoPosicao->itens();

        echo "<pre>";
        var_dump($acordoPosicao);
        var_dump($itens);
        die();
    }
}
