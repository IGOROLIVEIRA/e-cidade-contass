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
    public function createByEloquentModel(AcordoPosicao $acordoPosicao, ?AcordoPosicao $acordoPosicaoAnterior = null): Aditamento
    {
        $dataAssinatura = $acordoPosicao->posicaoAditamento->ac35_dataassinaturatermoaditivo;

        $aditamento = new Aditamento();
        $aditamento->setAcordoPosicaoSequencial((int) $acordoPosicao->ac26_sequencial)
            ->setAcordoSequencial((int) $acordoPosicao->ac26_acordo)
            ->setTipoAditivo((int) $acordoPosicao->ac26_acordoposicaotipo)
            ->setNumeroAditamento((int) $acordoPosicao->ac26_numeroaditamento)
            ->setDataAssinatura(new DateTime($dataAssinatura))
            ->setDataPublicacao(new DateTime($acordoPosicao->posicaoAditamento->ac35_datapublicacao))
            ->setVienciaAlterada($acordoPosicao->ac26_vigenciaalterada)
            ->setVeiculoDivulgacao(mb_convert_encoding($acordoPosicao->posicaoAditamento->ac35_veiculodivulgacao, "UTF-8", "ISO-8859-1"))
            ->setJustificativa(mb_convert_encoding($acordoPosicao->posicaoAditamento->ac35_justificativa, "UTF-8", "ISO-8859-1"))
            ->setPosicaoAditamentoSequencial((int)$acordoPosicao->posicaoAditamento->ac35_sequencial)
            ->setVigenciaInicio(new DateTime($acordoPosicao->vigencia->ac18_datainicio))
            ->setVigenciaFim(new DateTime($acordoPosicao->vigencia->ac18_datafim))
            ->setResumoObjeto($acordoPosicao->acordo->ac16_resumoobjeto)
            ->setDescricaoAlteracao($acordoPosicao->posicaoAditamento->ac35_descricaoalteracao)
            ->setDataReferencia(new DateTime($acordoPosicao->posicaoAditamento->ac35_datareferencia ?? $dataAssinatura));

        if ($aditamento->isReajuste()) {
            $aditamento->setIndiceReajuste((float) $acordoPosicao->ac26_indicereajuste)
                ->setPercentualReajuste((float) $acordoPosicao->ac26_percentualreajuste)
                ->setDescricaoIndice($acordoPosicao->ac26_descricaoindice)
                ->setCriterioReajuste($acordoPosicao->ac26_criterioreajuste);
        }

        $itemFactory = new ItemFactory();

        $itensPosicaoAnterior = null;
        if (!empty($acordoPosicaoAnterior)) {
            $itensPosicaoAnterior = $acordoPosicaoAnterior->itens;
        }

        $itens = $itemFactory->createListByCollection($acordoPosicao->itens, $itensPosicaoAnterior);
        $aditamento->setItens($itens);

        $vigenciaIndeterminada = $acordoPosicao->acordo->ac16_vigenciaindeterminada === 't';
        $aditamento->setVigenciaIndeterminanda($vigenciaIndeterminada);

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
            ->setVeiculoDivulgacao(mb_convert_encoding($aditamentoRaw->veiculodivulgacao, "ISO-8859-1", "UTF-8"))
            ->setJustificativa(mb_convert_encoding($aditamentoRaw->justificativa, "ISO-8859-1", "UTF-8"))
            ->setPosicaoAditamentoSequencial((int)$aditamentoRaw->posicaoAditamentoSequencial)
            ->setDescricaoAlteracao($aditamentoRaw->descricaoalteracao ?? '')
            ->setVigenciaInicio(DateTime::createFromFormat('d/m/Y', $aditamentoRaw->datainicial))
            ->setVigenciaFim(DateTime::createFromFormat('d/m/Y', $aditamentoRaw->datafinal));

        if ($aditamento->isReajuste()) {
            $aditamento->setIndiceReajuste((float) $aditamentoRaw->indicereajuste)
                ->setPercentualReajuste((float) $aditamentoRaw->percentualreajuste)
                ->setDescricaoIndice($aditamentoRaw->descricaoindice)
                ->setCriterioReajuste((int)$aditamentoRaw->criterioreajuste);
        }

        if (!empty($aditamentoRaw->datareferencia)) {
            $aditamento->setDataReferencia(DateTime::createFromFormat('d/m/Y', $aditamentoRaw->datareferencia));
        }

        $itemFactory = new ItemFactory();
        $itens = $itemFactory->createSelectedList($aditamentoRaw->aItens, $aditamentoRaw->aSelecionados);

        $aditamento->setItens($itens);
        return $aditamento;
    }
}
