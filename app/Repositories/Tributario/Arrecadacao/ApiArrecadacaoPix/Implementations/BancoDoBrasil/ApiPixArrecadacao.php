<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Implementations\BancoDoBrasil;


use App\Exceptions\ApiException;
use App\Repositories\Arrecadacao\ApiArrecadacaoPix\DTO\PixArrecadacaoResponseDTO;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IPixProvider;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\DTO\PixArrecadacaoPayloadDTO;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;

class ApiPixArrecadacao implements IPixProvider
{

    private Configuration $configuration;
    private ClientInterface $client;


    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
        $this->client = new Client();
    }

    /**
     * @param array $payload
     * @return PixArrecadacaoResponseDTO
     */
    public function generatePixArrecadacaoQrCodes(array $payload): PixArrecadacaoResponseDTO
    {
        $pixArrecadacaoPayloadDTO = new PixArrecadacaoPayloadDTO($payload);
        $response = $this->criaBoletoBancarioIdWithHttpInfo(
            $pixArrecadacaoPayloadDTO,
            $this->configuration->getAccessToken()
        );
        return new PixArrecadacaoResponseDTO((array) $response);
    }

    /**
     * @throws GuzzleException
     * @throws ApiException
     * @throws \BusinessException
     */
    public function criaBoletoBancarioIdWithHttpInfo(PixArrecadacaoPayloadDTO $body, $authorization)
    {
        $request = $this->criaBoletoBancarioIdRequest($body, $authorization);

        try {
            $response = $this->client->send($request);
        } catch (RequestException $e) {
            throw new ApiException(
                "[{$e->getCode()}] {$e->getMessage()}",
                $e->getCode(),
                $e->getResponse() ? $e->getResponse()->getHeaders() : null,
                $e->getResponse() ? $e->getResponse()->getBody()->getContents() : null
            );
        }

        return json_decode($response->getBody());
    }

    protected function criaBoletoBancarioIdRequest(PixArrecadacaoPayloadDTO $body, $authorization): Request
    {
        if (empty($body)) {
            throw new InvalidArgumentException(
                'Missing the required parameter $body when calling criaBoletoBancarioId'
            );
        }

        if (empty($authorization)) {
            throw new InvalidArgumentException(
                'Missing the required parameter $authorization when calling criaBoletoBancarioId'
            );
        }

        $resourcePath = '/arrecadacao-qrcodes';
        $queryParams = [];
        $headerParams = [];

        $appKeyIndex = $this->configuration->isProductionEnvironment() ? 'gw-app-key' : 'gw-dev-app-key';
        $queryParams[$appKeyIndex] = $this->configuration->getApplicationKey();

        $headerParams['Content-Type'] = "application/json";
        $headerParams['Authorization'] = 'Bearer ' . $authorization;
        $httpBody = \GuzzleHttp\json_encode($body);

        $query = Query::build($queryParams);
        return new Request(
            'POST',
            $this->configuration->getHost() . $resourcePath . ($query ? "?{$query}" : ''),
            $headerParams,
            $httpBody
        );
    }
}
