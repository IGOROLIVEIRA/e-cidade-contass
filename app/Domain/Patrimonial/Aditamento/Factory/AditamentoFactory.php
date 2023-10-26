<?php

namespace App\Domain\Patrimonial\Aditamento\Factory;

use App\Domain\Patrimonial\Aditamento\Aditamento;
use App\Models\AcordoPosicao;
use DateTime;
use stdClass;

class AditamentoFactory
{

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
            ->setVigenciaInicio(new DateTime($acordoPosicao->vigencia->ac18_datainicio))
            ->setVigenciaFim(new DateTime($acordoPosicao->vigencia->ac18_datafim))
            ->setResumoObjeto($acordoPosicao->acordo->ac16_resumoobjeto)
            ->setDescricaoAlteracao($acordoPosicao->posicaoAditamento->ac35_descricaoalteracao);


        if ($aditamento->isReajuste()) {
            $aditamento->setIndiceReajuste((float) $acordoPosicao->ac26_indicereajuste)
                ->setPercentualReajuste((float) $acordoPosicao->ac26_percentualreajuste)
                ->setDescricaoIndice($acordoPosicao->ac26_descricaoindice);
        }

        $itemFactory = new ItemFactory();
        $itens = $itemFactory->createListByCollection($acordoPosicao->itens);

        $aditamento->setItens($itens);

        return $aditamento;
    }

    public function createByStdLegacy(stdClass $aditamentoRaw)
    {
        $aditamento = new Aditamento();

        $aditamento->setAcordoPosicaoSequencial((int) $aditamentoRaw->acordoPosicaoSequencial)
            ->setAcordoSequencial((int) $aditamentoRaw->iAcordo)
            ->setTipoAditivo((int) $aditamentoRaw->tipoalteracaoaditivo)
            ->setNumeroAditamento((int) $aditamentoRaw->sNumeroAditamento)
            ->setDataAssinatura(DateTime::createFromFormat('d/m/Y', $aditamentoRaw->dataassinatura))
            ->setDataPublicacao(DateTime::createFromFormat('d/m/Y', $aditamentoRaw->datapublicacao))
            ->setVienciaAlterada($aditamentoRaw->sVigenciaalterada)
            ->setVeiculoDivulgacao($aditamentoRaw->veiculodivulgacao)
            ->setJustificativa($aditamentoRaw->justificativa)
            ->setPosicaoAditamentoSequencial((int)$aditamentoRaw->posicaoAditamentoSequencial)
            ->setVigenciaInicio(DateTime::createFromFormat('d/m/Y', $aditamentoRaw->datainicial))
            ->setVigenciaFim(DateTime::createFromFormat('d/m/Y', $aditamentoRaw->datafinal));

        if ($aditamento->isReajuste()) {
            $aditamento->setIndiceReajuste((float) $aditamentoRaw->indicereajuste)
                ->setPercentualReajuste((float) $aditamentoRaw->percentualreajuste)
                ->setDescricaoIndice($aditamentoRaw->descricaoindice);
        }

        $itemFactory = new ItemFactory();
        $itens = $itemFactory->createSelectedList($aditamentoRaw->aItens, $aditamentoRaw->aSelecionados);

        $aditamento->setItens($itens);
        return $aditamento;
    }
}
