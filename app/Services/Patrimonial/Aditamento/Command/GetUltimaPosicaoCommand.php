<?php
namespace App\Services\Patrimonial\Aditamento\Command;

use App\Models\AcordoPosicao;
use App\Repositories\Patrimonial\AcordoPosicaoRepository;

class GetUltimaPosicaoCommand
{
    public static function execute(
        AcordoPosicaoRepository $acordoPosicaoRepository,
        AcordoPosicao $acordoPosicao,
        int $ac16Sequencial
    ): AcordoPosicao {
        $quantidadeAditamentos = $acordoPosicaoRepository->getQtdAditamentoPorAcordo($ac16Sequencial);

        if( $quantidadeAditamentos > 1) {
            return $acordoPosicaoRepository->getAditamentoPosicaoAnterior($ac16Sequencial, $acordoPosicao->ac26_sequencial);
        }

        return $acordoPosicaoRepository->getPosicaoInicial($ac16Sequencial);
    }
}
