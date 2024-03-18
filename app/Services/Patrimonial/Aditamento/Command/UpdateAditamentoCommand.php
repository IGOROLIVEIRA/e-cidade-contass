<?php

namespace App\Services\Patrimonial\Aditamento\Command;

use App\Domain\Patrimonial\Aditamento\Aditamento;
use App\Domain\Patrimonial\Aditamento\Item;
use App\Repositories\Contracts\Patrimonial\AcordoItemDotacaoRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoItemPeriodoRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoItemRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoAditamentoRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoPosicaoRepositoryInterface;
use App\Repositories\Contracts\Patrimonial\AcordoVigenciaRepositoryInterface;
use App\Repositories\Patrimonial\AcordoItemDotacaoRepository;
use App\Repositories\Patrimonial\AcordoItemPeriodoRepository;
use App\Repositories\Patrimonial\AcordoItemRepository;
use App\Repositories\Patrimonial\AcordoPosicaoAditamentoRepository;
use App\Repositories\Patrimonial\AcordoPosicaoRepository;
use App\Repositories\Patrimonial\AcordoVigenciaRepository;
use App\Services\Contracts\Patrimonial\Aditamento\Command\UpdateAditamentoCommandInterface;
use App\Services\DTO\Patrimonial\InsertItemDto;
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

    /**
     *
     * @var AcordoItemDotacaoRepositoryInterface
     */
    private AcordoItemDotacaoRepositoryInterface $acordoItemDotacaoRepository;

    private AcordoVigenciaRepositoryInterface $acordoVigenciaRepository;

    public function __construct()
    {
        $this->acordoPosicaoRepository = new AcordoPosicaoRepository();
        $this->acordoItemRepository = new AcordoItemRepository();
        $this->acordoPosAditRepository = new AcordoPosicaoAditamentoRepository();
        $this->acordItemPeriodRepository = new AcordoItemPeriodoRepository();
        $this->acordoItemDotacaoRepository = new AcordoItemDotacaoRepository();
        $this->acordoVigenciaRepository = new AcordoVigenciaRepository();
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
                $sequencialAcordoPosicao,
                $acordoPosicao
            );

            if (!$resultAcordoPosicao) {
                throw new Exception("Não foi possível atualizar aditamento. Erro em acordoposicao!");
            }

            if ($aditamento->isAlteracaoVigencia() || $aditamento->isAcdcConjugado()) {
                $acordoVigenciaRepository = new AcordoVigenciaRepository();
                $resultVigencia =  $acordoVigenciaRepository->update(
                    $sequencialAcordoPosicao,
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
                $codigoItemPcMater = $item->getCodigoPcMater();
                $codigoItem = $item->getItemSequencial();

                if ($aditamento->isAlteracaoProjetoEspecificacao()) {
                    $acordoItem = $this->acordoItemRepository->getItemByPcmaterAndPosicao($codigoItemPcMater, $sequencialAcordoPosicao);

                    if (empty($acordoItem)) {
                        $insertDto = new InsertItemDto(
                            $item,
                            $sequencialAcordoPosicao,
                            $vigenciaIncio,
                            $vigenciaFim
                        );

                        (new InsereItemAditamentoCommand(
                            $this->acordoItemRepository,
                            $this->acordItemPeriodRepository,
                            $this->acordoItemDotacaoRepository,
                            $insertDto
                        ))->execute();
                        continue;
                    }
                }


                $resultItem = $this->acordoItemRepository->updateByPcmaterAndPosicao(
                    $codigoItemPcMater,
                    $sequencialAcordoPosicao,
                    [
                        'ac20_quantidade' => $item->getQuantidade(),
                        'ac20_valorunitario' => $item->getValorUnitario(),
                        'ac20_valortotal' => $item->getValorTotal(),
                        'ac20_valoraditado' => $item->getValorAditado(),
                        'ac20_quantidadeaditada' => $item->getQuantidadeAditada(),
                    ]
                );


                if (!$resultItem) {
                    throw new Exception("Não foi possível atualizar aditamento. Erro em acordoitem, no item: " .  $codigoItem);
                }

                $quantidadeDotacoes = $this->acordoItemDotacaoRepository->getQtdDotacaoByAcordoItem($codigoItem);

                if ($quantidadeDotacoes == 1) {
                    $resultDotacao = $this->acordoItemDotacaoRepository->updateByAcordoItem(
                        $codigoItem,
                        [
                            'ac22_quantidade' => $item->getQuantidade(),
                            'ac22_valor' => $item->getValorUnitario()
                        ]
                    );

                    if (!$resultDotacao) {
                        throw new Exception('Erro ao atualizar dotação');
                    }
                }

                if ($aditamento->isAlteracaoPrazo() || $aditamento->isAcdcConjugado()) {
                    $resultPeriodo = $this->acordItemPeriodRepository->update(
                        $codigoItem,
                        [
                            'ac41_datainicial' => $item->getInicioExecucao()->format('Y-m-d'),
                            'ac41_datafinal'   => $item->getFimExecucao()->format('Y-m-d'),
                            'ac41_acordoposicao' => $sequencialAcordoPosicao
                        ]
                    );

                    if (!$resultPeriodo) {
                        throw new Exception("Erro ao atualizar acordo item periodo");
                    }
                }

                if ($aditamento->isVigenciaExecucao()) {
                    $resultVigencia = $this->acordoVigenciaRepository->update(
                        $sequencialAcordoPosicao,
                        [
                            'ac18_datainicio' => $vigenciaIncio,
                            'ac18_datafim'   => $vigenciaFim,
                        ]
                    );

                    if (!$resultVigencia) {
                        throw new Exception("Erro ao atualizar acordo vigencia");
                    }
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
            'ac26_vigenciaalterada'  => $aditamento->getVigenciaAlterada()
        ];

        if ($aditamento->isReajuste()) {
            $acordoPosicao['ac26_indicereajuste'] = $aditamento->getIndiceReajuste();
            $acordoPosicao['ac26_percentualreajuste'] = $aditamento->getPercentualReajuste();
            $acordoPosicao['ac26_descricaoindice'] = $aditamento->getDescricaoIndice();
            $acordoPosicao['ac26_criterioreajuste'] = $aditamento->getCriterioReajuste();
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
            'ac35_descricaoalteracao' => $aditamento->getDescricaoAlteracao(),
            'ac35_datareferencia' => !empty($aditamento->getDataReferencia())
                ? $aditamento->getDataReferencia()->format('Y-m-d')
                : $dataAssinatura
        ];
    }
}
