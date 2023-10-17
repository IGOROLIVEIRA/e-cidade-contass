<?php

namespace App\Domain\Patrimonial\Aditamento\Factory;

use App\Domain\Patrimonial\Aditamento\Aditamento;
use App\Models\AcordoPosicao;
use DateTime;

class AditamentoFactory
{
    private const TIPO_REAJUSTE = 5;

    public function createByEloquentModel(AcordoPosicao $acordoPosicao)
    {
        $aditamento = new Aditamento();
        $aditamento->setAcordoPosicaoSequencial((int) $acordoPosicao->ac26_sequencial)
            ->setAcordoSequencial((int) $acordoPosicao->ac26_acordo)
            ->setTipoAditivo((int) $acordoPosicao->ac26_acordoposicaotipo)
            ->setNumeroAditamento((int) $acordoPosicao->ac26_numeroaditamento)
            ->setDataAssinatura(new DateTime($acordoPosicao->ac26_data))
            ->setDataPublicacao(new DateTime($acordoPosicao->posicaoAditamento->ac16_datapublicacao))
            ->setVienciaAlterada($acordoPosicao->ac26_vigenciaalterada)
            ->setVeiculoDivulgacao($acordoPosicao->ac16_veiculodivulgacao);

        if (self::TIPO_REAJUSTE === (int) $acordoPosicao->ac26_acordoposicaotipo) {
            $aditamento->setIndiceReajuste((float) $acordoPosicao->ac26_indicereajuste)
                ->setPercentualReajuste((float) $acordoPosicao->ac26_percentualreajuste)
                ->setDescricaoIndice($acordoPosicao->ac26_descricaoindice);
        }



    }
}
