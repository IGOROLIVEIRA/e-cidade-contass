<?php

namespace App\Services\Tributario\Arrecadacao;

use App\Models\ConfiguracaoPixBancoDoBrasil;
use App\Models\Numpref;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IConfiguration;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Implementations\BancoDoBrasil\Configuration;

class ResolvePixProviderService
{
    /**
     * @throws \BusinessException
     */
    public function execute(Numpref $config): IConfiguration
    {
        $financialProviderId = $config->k03_instituicao_financeira;
        if ($financialProviderId === ConfiguracaoPixBancoDoBrasil::CODIGO) {
            $bbProviderConfig = ConfiguracaoPixBancoDoBrasil::where(
                'k177_instituicao_financeira',
                $financialProviderId
            )->first();
            return (new Configuration())
                ->setHost($bbProviderConfig->k177_url_api)
                ->setUrlAuthOauth2($bbProviderConfig->k177_url_oauth)
                ->setClientSecret($bbProviderConfig->k177_client_secret)
                ->setClientId($bbProviderConfig->k177_client_id)
                ->setApplicationKey($bbProviderConfig->k177_develop_application_key)
                ->setNumeroConvenio($bbProviderConfig->k177_numero_convenio)
                ->setChavePix($bbProviderConfig->k177_chave_pix)
                ->setEnvironment($bbProviderConfig->k177_ambiente);
        }
        throw new \BusinessException('Instituição financeira para o PIX não configurada.');
    }
}