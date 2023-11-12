<?php

namespace App\Domain\Assinador\Service;

use Exception;
use GuzzleHttp\Client;

class AssinadorECidadeService
{
    /**
     * Assina o documento no assinador autoassinado do e-cidade
     * @param array
     * @return string base64
     */
    public function assinar(array $params)
    {
        $urlSignerApi = env('URL_ECIDADE_SIGNER');

        if (empty($urlSignerApi)) {
            throw new Exception("API do assinador do e-cidade n�o configurado!");
        }

        if (empty($params)) {
            throw new Exception("Par�metros n�o informados");
        }

        $options = [];
        $disableVerifySSl = (env("ECIDADE_SIGNER_SSL_VERIFY") === 'true' ? true : false);

        if ($disableVerifySSl) {
            $options['verify'] = false;
        }

        $http = new Client($options);
        $response = $http->post(
            "{$urlSignerApi}/signer/do/make",
            [
                'multipart' => $params
            ]
        );

        return $response->getBody()->getContents();
    }
}
