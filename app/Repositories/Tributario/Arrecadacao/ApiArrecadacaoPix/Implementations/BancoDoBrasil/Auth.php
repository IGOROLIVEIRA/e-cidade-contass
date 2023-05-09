<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Implementations\BancoDoBrasil;

use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IAuth;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IConfiguration;
use BusinessException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

class Auth implements IAuth
{
    /**
     * @var IConfiguration
     */
    protected IConfiguration $configuration;

    protected bool $debug = false;

    public function __construct(IConfiguration $configuration)
    {
        $this->configuration = $configuration;
        $this->client = new Client();
    }

    /**
     * @return string
     * @throws \BusinessException|GuzzleException
     */
    public function auth(): string
    {
        $formParams = [];
        $headerParams = [];
        $token = "";

        $headerParams['Authorization'] = "Basic " . base64_encode($this->configuration->getClientId() .
                ":" . $this->configuration->getClientSecret());
        $headerParams['Content-Type'] = "application/x-www-form-urlencoded";
        $formParams['grant_type'] = "client_credentials";
        $formParams['scope'] = $this->configuration->getScopesOauth2();
        $httpBody = Query::build($formParams);

        $request = new Request('POST', $this->configuration->getUrlAuthOauth2(), $headerParams, $httpBody);

        $options = $this->createHttpClientOption();
        try {
            $response = $this->client->send($request, $options);
            if ($response->getBody()) {
                $bodyJson = json_decode($response->getBody());
                $token = $bodyJson->{'access_token'};
            }
        } catch (ClientException | RequestException $e) {

            $message =
                'Erro de autenticação com API pix da Instituição Financeira habilidata.';
            $error = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents());

            if (in_array($e->getResponse()->getStatusCode(), [401, 403])) {
                throw new BusinessException($message. ' Detalhes: '.utf8_decode($error->message));
            }

            if (!empty($error->error)) {
                $message .= ' Detalhes: '.utf8_decode($error->mensagem);
            }

            if (!empty($error->erros)) {
                $message .= ' Detalhes: '.utf8_decode($error->erros[0]->mensagem);
            }

            throw new BusinessException($message);
        }

        return $token;
    }

    /**
     * Create http client option
     *
     * @return array of http client options
     * @throws \BusinessException
     */
    protected function createHttpClientOption()
    {
        $options = [];
        if ($this->debug) {
            $filename = 'tmp/'.date('Y-m-d').'_pixlog.log';
            $options[RequestOptions::DEBUG] = fopen($filename, 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new \BusinessException('Failed to open the debug file: ' . $filename);
            }
        }

        return $options;
    }
}
