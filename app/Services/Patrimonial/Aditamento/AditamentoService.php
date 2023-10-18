<?php

namespace App\Services\Patrimonial\Aditamento;

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
     * @return array
     */
    public function getDadosAditamento(int $ac16Sequencial): array
    {
        $acordoPosicao = $this->acordoPosicaoRepository->getAditamentoUltimaPosicao($ac16Sequencial);

        $aditamentoFactory = new AditamentoFactory();
        $aditamento = $aditamentoFactory->createByEloquentModel($acordoPosicao);

        $seriealizer = new AditamentoSerializeService($aditamento);
        return $seriealizer->jsonSerialize();
    }
}
