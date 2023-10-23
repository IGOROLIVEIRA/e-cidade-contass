<?php

namespace App\Services\Patrimonial\Aditamento\Command;

use App\Domain\Patrimonial\Aditamento\Aditamento;
use App\Repositories\Contracts\Patrimonial\AcordoItemRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoAditamentoRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoRepositoryInterface;
use App\Repositories\Patrimonial\AcordoItemRepository;
use App\Repositories\Patrimonial\AcordoPosicaoAditamentoRepository;
use App\Repositories\Patrimonial\AcordoPosicaoRepository;
use App\Services\Contracts\Patrimonial\Aditamento\UpdateAditamentoInterfaceCommand;
use Illuminate\Support\Facades\DB;

class UpdateAditamentoCommand implements UpdateAditamentoInterfaceCommand
{

    private AcordoPosicaoRepositoryInterface $acordoPosicaoRepository;

    private AcordoPosicaoAditamentoRepositoryInterface $acordoPosAditRepository;

    private AcordoItemRepositoryInterface $acordoItemRepository;

    public function __construct()
    {
        $this->acordoPosicaoRepository = new AcordoPosicaoRepository();
        $this->acordoItemRepository = new AcordoItemRepository();
        $this->acordoPosAditRepository = new AcordoPosicaoAditamentoRepository();
    }

    public function execute(Aditamento $aditamento)
    {
        $acordoPosicao = $this->formatAcordoPosicao($aditamento);
        $acordoPosicaoAdimento = $this->formatAcordoPosicaoAditamento($aditamento);

        try {
            DB::beginTransaction();

            $this->acordoPosicaoRepository->update(
                $aditamento->getAcordoPosicaoSequencial(),
                $acordoPosicao
            );

            $this->acordoPosAditRepository->update(
                $aditamento->getPosicaoAditamentoSequencial(),
                $acordoPosicaoAdimento
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

        }

    }

    private function formatAcordoPosicao(Aditamento $aditamento): array
    {
        $acordoPosicao = [
            'ac26_acordoposicaotipo' => $aditamento->getTipoAditivo(),
            'ac26_numeroaditamento'  => $aditamento->getNumeroAditamento(),
            'ac26_vigenciaalterada'  => $aditamento->getVigenciaAlterada(),
        ];

        if ($aditamento->isReajuste()) {
            $acordoPosicao['ac26_indicereajuste'] = $aditamento->getIndiceReajuste();
            $acordoPosicao['ac26_percentualreajuste'] = $aditamento->getPercentualReajuste();
        }
    }

    private function formatAcordoPosicaoAditamento(Aditamento $aditamento): array
    {
        return [
            'ac35_dataassinaturatermoaditivo' => $aditamento->getDataAssinatura()->format('Y-m-d'),
            'ac35_datapublicacao' => $aditamento->getDataPublicacao()->format('Y-m-d'),
            'ac35_veiculodivulgacao' => $aditamento->getVeiculoDivulgacao(),
            'ac35_justificativa' => $aditamento->getJustificativa(),
        ];
    }
}
