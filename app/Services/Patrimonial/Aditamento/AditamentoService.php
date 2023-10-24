<?php

namespace App\Services\Patrimonial\Aditamento;

use App\Domain\Patrimonial\Aditamento\Factory\AditamentoFactory;
use App\Repositories\Patrimonial\AcordoPosicaoRepository;
use App\Services\Contracts\Patrimonial\Aditamento\AditamentoServiceInterface;
use App\Services\Patrimonial\Aditamento\Command\UpdateAditamentoCommand;
use Exception;
use stdClass;

class AditamentoService implements AditamentoServiceInterface
{
    /**
     * @var AcordoPosicaoRepository
     */
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

    public function updateAditamento(stdClass $aditamentoRaw): array
    {
        $aditamentoFactory = new AditamentoFactory();
        $aditamento = $aditamentoFactory->createByStdLegacy($aditamentoRaw);

        $updateCommand = new UpdateAditamentoCommand();
        try {
            $result = $updateCommand->execute($aditamento);

            if ($result === false) {
                throw new Exception("Não foi possivel atualizar");
            }

            return ['status' => true];
        } catch (\Exception $e) {
            return ['status' => false, 'message' => $e->getMessage()];
        }
    }
}
