<?php

namespace App\Services\Patrimonial\Aditamento;

use App\Repositories\Patrimonial\AcordoPosicao\AcordoPosicaoRepository;
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
        $this->acordoPosicaoRepository->getAditamentoUltimaPosicao($ac16Sequencial);
        return [];
    }
}
