<?php

namespace App\Services\Patrimonial\Aditamento\Command;

use App\Domain\Patrimonial\Aditamento\Aditamento;
use App\Domain\Patrimonial\Aditamento\Item;
use App\Repositories\Contracts\Patrimonial\AcordoItemPeriodoRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoItemRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoAditamentoRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoRepositoryInterface;
use App\Repositories\Patrimonial\AcordoItemPeriodoRepository;
use App\Repositories\Patrimonial\AcordoItemRepository;
use App\Repositories\Patrimonial\AcordoPosicaoAditamentoRepository;
use App\Repositories\Patrimonial\AcordoPosicaoRepository;
use App\Repositories\Patrimonial\AcordoVigenciaRepository;
use App\Services\Contracts\Patrimonial\Aditamento\Command\UpdateAditamentoCommandInterface;
use Exception;
use Illuminate\Database\Capsule\Manager as DB;

class UpdateAditamentoCommand implements UpdateAditamentoCommandInterface
{
    /**
     * @var AcordoPosicaoRepositoryInterface
     */
    private AcordoPosicaoRepositoryInterface $acordoPosicaoRepository;

    /**
     * @var AcordoPosicaoAditamentoRepositoryInterface
     */
    private AcordoPosicaoAditamentoRepositoryInterface $acordoPosAditRepository;

    /**
     * @var AcordoItemRepositoryInterface
     */
    private AcordoItemRepositoryInterface $acordoItemRepository;

    /**
     * @var AcordoItemPeriodoRepositoryInterface
     */
    private AcordoItemPeriodoRepositoryInterface $acordItemPeriodRepository;

    public function __construct()
    {
        $this->acordoPosicaoRepository = new AcordoPosicaoRepository();
        $this->acordoItemRepository = new AcordoItemRepository();
        $this->acordoPosAditRepository = new AcordoPosicaoAditamentoRepository();
        $this->acordItemPeriodRepository = new AcordoItemPeriodoRepository();
    }

    /**
     *
     * @param Aditamento $aditamento
     * @return boolean
     */
    public function execute(Aditamento $aditamento): bool
    {

        $this->validaNumeroAditamento($aditamento);

        $acordoPosicao = $this->formatAcordoPosicao($aditamento);
        $acordoPosicaoAdimento = $this->formatAcordoPosicaoAditamento($aditamento);
        $vigenciaIncio = $aditamento->getVigenciaInicio()->format('Y-m-d');
        $vigenciaFim = $aditamento->getVigenciaFim()->format('Y-m-d');
        $sequencialAcordoPosicao = $aditamento->getAcordoPosicaoSequencial();

        try {
            DB::beginTransaction();

            $resultAcordoPosicao = $this->acordoPosicaoRepository->update(
                $aditamento->getAcordoPosicaoSequencial(),
                $acordoPosicao
            );

            if (!$resultAcordoPosicao) {
                throw new Exception("Não foi possível atualizar aditamento. Erro em acordoposicao!");
            }

            if ($aditamento->isAlteracaoVigencia() || $aditamento->isAcdcConjugado()) {
                $acordoVigenciaRepository = new AcordoVigenciaRepository();
                $resultVigencia =  $acordoVigenciaRepository->update(
                    $aditamento->getAcordoPosicaoSequencial(),
                    [
                        'ac18_datainicio' => $vigenciaIncio,
                        'ac18_datafim' => $vigenciaFim
                    ]
                );

                if (!$resultVigencia) {
                    throw new Exception("Não foi possível atualizar aditamento. Erro em acordoVigencia!");
                }

            }


            $resultacordoPosAdit = $this->acordoPosAditRepository->update(
                $aditamento->getPosicaoAditamentoSequencial(),
                $acordoPosicaoAdimento
            );

            if (!$resultacordoPosAdit) {
                throw new Exception("Não foi possível atualizar aditamento. Erro em acordoposicaoaditamento!");
            }

            $itens = $aditamento->getItens();

            /** @var Item $item */
            foreach ($itens as $item) {
                $codigoItem = $item->getItemSequencial();
                $resultItem = $this->acordoItemRepository->update(
                    $codigoItem,
                    [
                        'ac20_quantidade' => $item->getQuantidade(),
                        'ac20_valorunitario' => $item->getValorUnitario(),
                        'ac20_valortotal' => $item->getValorTotal()
                    ]);

                if (!$resultItem) {
                    throw new Exception("Não foi possível atualizar aditamento. Erro em acordoitem, no item: ".  $codigoItem);
                }

                if($aditamento->isAlteracaoPrazo() || $aditamento->isAcdcConjugado()) {
                    $this->acordItemPeriodRepository->update(
                        $codigoItem,
                        [
                            'ac41_datainicial' => $item->getInicioExecucao()->format('Y-m-d'),
                            'ac41_datafinal'   => $item->getFimExecucao()->format('Y-m-d'),
                            'ac41_acordoposicao' => $sequencialAcordoPosicao
                        ]);
                }

                if($aditamento->isVigenciaExecucao()) {
                    $this->acordItemPeriodRepository->update(
                        $codigoItem,
                        [
                            'ac41_datainicial' => $vigenciaIncio,
                            'ac41_datafinal'   => $vigenciaFim,
                            'ac41_acordoposicao' => $sequencialAcordoPosicao
                        ]);
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    private function validaNumeroAditamento(Aditamento $aditamento): void
    {
        $posicao = $this->acordoPosicaoRepository
                ->getAcordoPorNumeroAditamento(
                    $aditamento->getAcordoSequencial(),
                    $aditamento->getNumeroAditamento()
                );

        if (!empty($posicao) && (int)$posicao->ac26_sequencial !== $aditamento->getAcordoPosicaoSequencial()) {
            throw new \Exception('Numero de aditamento já esta em uso');
        }
    }

    /**
     *
     * @param Aditamento $aditamento
     * @return array
     */
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

        return $acordoPosicao;
    }

    /**
     *
     * @param Aditamento $aditamento
     * @return array
     */
    private function formatAcordoPosicaoAditamento(Aditamento $aditamento): array
    {
        $dataAssinatura = $aditamento->getDataAssinatura()->format('Y-m-d');
        return [
            'ac35_dataassinaturatermoaditivo' => $dataAssinatura,
            'ac35_datapublicacao' => $aditamento->getDataPublicacao()->format('Y-m-d'),
            'ac35_veiculodivulgacao' => $aditamento->getVeiculoDivulgacao(),
            'ac35_justificativa' => $aditamento->getJustificativa(),
            'ac35_datareferencia' => !empty($aditamento->getDataReferencia())
                                    ? $aditamento->getDataReferencia()->format('Y-m-d')
                                    : $dataAssinatura
        ];
    }
}
