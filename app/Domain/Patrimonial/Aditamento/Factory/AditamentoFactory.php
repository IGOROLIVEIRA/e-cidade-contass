<?php

namespace App\Domain\Patrimonial\Aditamento\Factory;

use App\Domain\Patrimonial\Aditamento\Aditamento;
use App\Models\AcordoPosicao;
use DateTime;

class AditamentoFactory
{
    private const TIPO_REAJUSTE = 5;

    /**
     * @param AcordoPosicao $acordoPosicao
     * @return Aditamento
     */
    public function createByEloquentModel(AcordoPosicao $acordoPosicao): Aditamento
    {
        $aditamento = new Aditamento();
        $aditamento->setAcordoPosicaoSequencial((int) $acordoPosicao->ac26_sequencial)
            ->setAcordoSequencial((int) $acordoPosicao->ac26_acordo)
            ->setTipoAditivo((int) $acordoPosicao->ac26_acordoposicaotipo)
            ->setNumeroAditamento((int) $acordoPosicao->ac26_numeroaditamento)
            ->setDataAssinatura(new DateTime($acordoPosicao->posicaoAditamento->ac35_dataassinaturatermoaditivo))
            ->setDataPublicacao(new DateTime($acordoPosicao->posicaoAditamento->ac35_datapublicacao))
            ->setVienciaAlterada($acordoPosicao->ac26_vigenciaalterada)
            ->setVeiculoDivulgacao($acordoPosicao->posicaoAditamento->ac35_veiculodivulgacao)
            ->setJustificativa($acordoPosicao->posicaoAditamento->ac35_justificativa)
            ->setPosicaoAditamentoSequencial((int)$acordoPosicao->posicaoAditamento->ac35_sequencial)
            ->setVigenciaInicio(new DateTime($acordoPosicao->acordo->ac16_datainicio))
            ->setVigenciaFim(new DateTime($acordoPosicao->acordo->ac16_datafim))
            ->setResumoObjeto($acordoPosicao->acordo->ac16_resumoobjeto)
            ->setDescricaoAlteracao($acordoPosicao->posicaoAditamento->ac35_descricaoalteracao);


        if (self::TIPO_REAJUSTE === (int) $acordoPosicao->ac26_acordoposicaotipo) {
            $aditamento->setIndiceReajuste((float) $acordoPosicao->ac26_indicereajuste)
                ->setPercentualReajuste((float) $acordoPosicao->ac26_percentualreajuste)
                ->setDescricaoIndice($acordoPosicao->ac26_descricaoindice);
        }

        $itemFactory = new ItemFactory();
        $itens = $itemFactory->createListByCollection($acordoPosicao->itens);

        $aditamento->setItens($itens);

        return $aditamento;
    }
}
