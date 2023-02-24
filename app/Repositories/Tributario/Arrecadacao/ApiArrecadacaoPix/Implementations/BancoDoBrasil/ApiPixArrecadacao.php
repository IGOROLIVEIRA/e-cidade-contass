<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Implementations\BancoDoBrasil;

use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IPixProvider;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\DTO\PixArrecadacaoPayloadDTO;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\DTO\PixArrecadacaoResponseDTO;
use BusinessException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;

class ApiPixArrecadacao implements IPixProvider
{
    private Configuration $configuration;
    private ClientInterface $client;

    public const INDICADOR_CODIGO_BARRAS_NAO = 'N';
    public const INDICADOR_CODIGO_BARRAS_SIM = 'S';

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration->authenticate();
        $this->client = new Client();
    }

    /**
     * @param array $payload
     * @return PixArrecadacaoResponseDTO
     */
    public function generatePixArrecadacaoQrCodes(array $payload): PixArrecadacaoResponseDTO
    {
        $payload['numeroConvenio'] = $this->configuration->getNumeroConvenio();
        $payload['indicadorCodigoBarras'] = self::INDICADOR_CODIGO_BARRAS_NAO;
        $payload['codigoSolicitacaoBancoCentralBrasil'] = $this->configuration->getChavePix();
        $pixArrecadacaoPayloadDTO = new PixArrecadacaoPayloadDTO($payload);
        $response = $this->send(
            $pixArrecadacaoPayloadDTO,
            $this->configuration->getAccessToken()
        );
        return new PixArrecadacaoResponseDTO((array) $response);
    }

    /**
     * @throws BusinessException|GuzzleException
     */
    public function send(PixArrecadacaoPayloadDTO $body, $authorization)
    {
        $request = $this->createRequest($body, $authorization);

        try {
            $response = $this->client->send($request);

        } catch (ClientException $e) {
            $message =
                'Erro ao integrar com API pix da Instituição Financeira habilidata. Verifique os parâmetros informados';
            $error = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents());
            if (!empty($error->erros)) {
                $message = utf8_decode($error->erros[0]->mensagem);
            }
            throw new BusinessException($message);
        }

        return \GuzzleHttp\json_decode(($response->getBody()));
    }

    protected function createRequest(PixArrecadacaoPayloadDTO $body, $authorization): Request
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
