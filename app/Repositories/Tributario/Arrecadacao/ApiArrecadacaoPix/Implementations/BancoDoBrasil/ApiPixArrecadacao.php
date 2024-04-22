<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Implementations\BancoDoBrasil;

use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IPixProvider;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\DTO\PixArrecadacaoPayloadDTO;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\DTO\PixArrecadacaoResponseDTO;
use BusinessException;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;

class ApiPixArrecadacao implements IPixProvider
{
    private Configuration $configuration;
    private ClientInterface $client;

    protected bool $debug = false;

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
        $payload['indicadorCodigoBarras'] = !empty($payload['indicadorCodigoBarras']) ?
            $payload['indicadorCodigoBarras'] : PixArrecadacaoPayloadDTO::INDICADOR_CODIGO_BARRAS_NAO;
        $payload['codigoSolicitacaoBancoCentralBrasil'] = $this->configuration->getChavePix();

        if (!empty($payload['k00_dtvenc'])) {
            $dateExpiration = $this->parseDate($payload['k00_dtvenc']);
            $payload['quantidadeSegundoExpiracao'] = $this->getExpirationSecondsQuantity($dateExpiration);
        }

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
            $options = $this->createHttpClientOption();
            $response = $this->client->send($request, $options);

        } catch (ClientException | RequestException $e) {
            $message = 'Erro ao integrar com API pix da Instituição Financeira habilidata.';

            if (empty($e->getResponse())) {
                throw new BusinessException($message. ' Detalhes: '.utf8_decode($e->getMessage()));
            }

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

        $queryParams['gw-dev-app-key'] = $this->configuration->getApplicationKey();

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

    /**
     * @throws Exception
     */
    private function getExpirationSecondsQuantity(DateTime $dateExpiration): int
    {
        $now = new DateTime(date('Y-m-d'));
        $diff = $dateExpiration->getTimestamp() - $now->getTimestamp();
        return $diff > 0 ? $diff : 3600;
    }

    private function parseDate(string $date): DateTime
    {
        $newDate = DateTime::createFromFormat('d/m/Y', $date);

        if(!$newDate) {
            $newDate = DateTime::createFromFormat('Y-m-d', $date);
        }

        if(!$newDate) {
            $newDate = DateTime::createFromFormat('Ymd', $date);
        }

        return $newDate;
    }

    /**
     * Create http client option
     *
     * @return array of http client options
     * @throws BusinessException
     */
    protected function createHttpClientOption(): array
    {
        $options = ['verify' => false];
        if ($this->debug) {
            $filename = 'tmp/' . date('Y-m-d') . '_pixlog.log';
            $options[RequestOptions::DEBUG] = fopen($filename, 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new BusinessException('Failed to open the debug file: ' . $filename);
            }
        }

        return $options;
    }
}
