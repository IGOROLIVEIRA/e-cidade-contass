<?php

namespace App\Services\Patrimonial\Aditamento;

use App\Domain\Patrimonial\Aditamento\Aditamento;
use App\Domain\Patrimonial\Aditamento\Factory\AditamentoFactory;
use App\Repositories\Patrimonial\AcordoPosicaoRepository;
use App\Services\Contracts\Patrimonial\Aditamento\AditamentoServiceInterface;

class AditamentoService implements AditamentoServiceInterface
{
    private AcordoPosicaoRepository $acordoPosicaoRepository;

    public function __construct()
    {
        $this->acordoPosicaoRepository = new AcordoPosicaoRepository();
    }

    /**
     *
     * @param integer $ac16Sequencial
     * @return AditamentoSerializeService
     */
    public function getDadosAditamento(int $ac16Sequencial): AditamentoSerializeService
    {
        $acordoPosicao = $this->acordoPosicaoRepository->getAditamentoUltimaPosicao($ac16Sequencial);

        $aditamentoFactory = new AditamentoFactory();
        $aditamento = $aditamentoFactory->createByEloquentModel($acordoPosicao);

        return new AditamentoSerializeService($aditamento);
    }
}
