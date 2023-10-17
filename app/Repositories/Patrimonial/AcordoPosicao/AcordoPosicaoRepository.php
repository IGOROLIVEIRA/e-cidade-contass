<?php

namespace App\Repositories\Patrimonial\AcordoPosicao;

use App\Models\AcordoPosicao;
use App\Repositories\Contracts\Patrimonial\AcordoPosicao\AcordoPosicaoRepositoryInterface;
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
     * @return void
     */
    public function getAditamentoUltimaPosicao(int $ac26Acordo): AcordoPosicao
    {
        $acordoPosicao = $this->acordoPosicao
                ->with(['itens','posicaoAditamento'])
                ->where('ac26_acordo',$ac26Acordo)
                ->whereNotNull('ac26_numeroaditamento')
                ->orderBy('ac26_numeroaditamento', 'desc')
                ->first();

        echo "<pre>";
        var_dump($acordoPosicao);
        //var_dump($acordoPosicao->ac26_numero);
        var_dump($acordoPosicao->posicaoAditamento->ac35_datapublicacao);
        //var_dump(new DateTime($acordoPosicao->ac26_data));
        die();
    }
}
