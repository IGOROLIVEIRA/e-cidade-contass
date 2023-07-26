<?php

namespace App\Services\Tributario\Arrecadacao;

use App\Models\Concerns\IApiPixConfiguration;
use BusinessException;

class SavePixApiSettingsService
{
    private const ATIVO_SIM = 't';
    private const ATIVO_NAO = 'f';

    private IApiPixConfiguration $apiPixConfiguration;

    public function __construct(
        IApiPixConfiguration $apiPixConfiguration
    ) {
        $this->apiPixConfiguration = $apiPixConfiguration;
    }

    /**
     * @throws BusinessException
     */
    public function execute(array $data)
    {
        $active = $data['k03_ativo_integracao_pix'] === self::ATIVO_SIM;

        if (!$active) {
            $this->apiPixConfiguration
                ->where('k177_instituicao_financeira', $data['k03_instituicao_financeira'])
                ->delete();
            return;
        }

        $this->validate($data);

        $result = $this->apiPixConfiguration->updateOrCreate(
            ['k177_instituicao_financeira' => $data['k03_instituicao_financeira']],
            [
                'k177_instituicao_financeira' => $data['k03_instituicao_financeira'],
                'k177_numero_convenio' => $data['k177_numero_convenio'] ,
                'k177_develop_application_key' => $data['k177_develop_application_key'],
                'k177_url_api' => $data['k177_url_api'],
                'k177_url_oauth' => $data['k177_url_oauth'],
                'k177_client_id' => $data['k177_client_id'],
                'k177_client_secret' => $data['k177_client_secret'],
                'k177_ambiente' => $data['k177_ambiente'],
                'k177_chave_pix' => $data['k177_chave_pix'],
                ]
        );

        if (!$result) {
            throw new BusinessException('Não foi possível salvar');
        }
    }

    /**
     * @throws BusinessException
     */
    public function validate(array $data): void
    {
        $msg = '';
        if (empty($data['k03_instituicao_financeira'])) {
            $msg = 'Instituição financeira para integração com o PIX não foi informada';
        }
        if ($msg) {
            throw new BusinessException($msg);
        }
    }
}
