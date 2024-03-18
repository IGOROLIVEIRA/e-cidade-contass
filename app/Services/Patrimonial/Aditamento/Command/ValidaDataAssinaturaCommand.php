<?php

namespace App\Services\Patrimonial\Aditamento\Command;

use App\Domain\Patrimonial\Aditamento\Aditamento;
use App\Repositories\Contracts\Patrimonial\AcordoRepositoryInterface;
use App\Repositories\Patrimonial\AcordoRepository;
use App\Services\Contracts\Patrimonial\Aditamento\Command\ValidaDataAssinaturaCommandInterface;
use DateTime;

class ValidaDataAssinaturaCommand implements ValidaDataAssinaturaCommandInterface
{
    private AcordoRepositoryInterface $acordoRepository;

    public function __construct()
    {
        $this->acordoRepository = new AcordoRepository();
    }

    /**
     * Undocumented function
     *
     * @param Aditamento $aditamento
     * @return void
     */
    public function execute(Aditamento $aditamento): void
    {
        $acordo = $this->acordoRepository->getAcordo(
            $aditamento->getAcordoSequencial(),
            ['ac16_dataassinatura']);

        $dataAssinaturaAcordo = new DateTime($acordo->ac16_dataassinatura);

        if ($dataAssinaturaAcordo > $aditamento->getDataAssinatura()) {
            throw new \Exception("Data de assinatura do aditivo não pode ser menor que a data de assinatura do contrato");
        }
    }
}
