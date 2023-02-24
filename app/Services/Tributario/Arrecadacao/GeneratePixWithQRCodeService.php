<?php

namespace App\Services\Tributario\Arrecadacao;

use App\Models\RecibopagaQrcodePix;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IConfiguration;
use DateTime;

class GeneratePixWithQRCodeService
{
    private IConfiguration $configuration;

    public function __construct(IConfiguration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function execute(array $data): void
    {
        if ($this->hasQrCode($data)) {
            return;
        }
        $provider = $this->configuration->getFinancialProvider();
        $response = $provider->generatePixArrecadacaoQrCodes($data);
        RecibopagaQrcodePix::create(
            [
                'k176_numnov' => $data['k00_numnov'],
                'k176_numpre' => $data['k00_numpre'],
                'k176_numpar' => $data['k00_numpar'],
                'k176_dtcriacao' => (new DateTime($response->timestampCriacaoSolicitacao))->format('Y-m-d'),
                'k176_qrcode' => $response->qrCode,
                'k176_hist' => json_encode($response),
                'k176_instituicao_financeira' => $data['k03_instituicao_financeira']
            ]
        );
    }

    private function hasQrCode(array $data): bool
    {
        $builder = RecibopagaQrcodePix::query();
        if (isset($data['k00_numnov'])) {
           $builder->where('k176_numnov', $data['k00_numnov']);
        }

        if (isset($data['k00_numpre'])) {
            $builder->where('k176_numpre', $data['k00_numpre']);
            $builder->where('k176_numpar', $data['k00_numpar']);
        }
        return $builder->exists();
    }
}
