<?php

namespace App\Domain\Patrimonial\PNCP\Clients;

use App\Domain\Patrimonial\PNCP\Exceptions\CompraEditalAvisoExcpetion;
use App\Domain\Patrimonial\PNCP\Exceptions\ContratoException;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Support\Facades\Cache;

class PNCPClient
{
    private $usuario;
    private $options;
    private $client;
    private $senha;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->usuario = env('PNCP_USUARIO');
        $this->senha = env('PNCP_SENHA');
        $this->client = new Client(['base_uri' => env('PNCP_URL')]);

        $this->options['synchronous'] = true;
        $this->options['headers']['Content-Type'] = 'application/json';
        $this->options['headers']['Accept'] = '*/*';
        $this->options['headers']['Accept-Encoding'] = 'gzip, deflate, br';
        $this->options['headers']['Connection'] = 'keep-alive';
        $this->options['headers']['Authorization'] = $this->getAcessToken();
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getAcessToken()
    {
        $cacheKey = "access_token_pncp#{$this->getAuthorizationCode()}}";
        $accessToken = Cache::get($cacheKey);
        if (!empty($accessToken)) {
            return $accessToken;
        }

        try {
            $options = [
                'json' => [
                    'login' => $this->usuario,
                    'senha' => $this->senha
                ],
                'headers' => [
                    'Accept' => 'application/json'
                ]
            ];
            $response = $this->client->post('v1/usuarios/login', $options);
            $accessToken = $response->getHeader('authorization')[0];

            Cache::put($cacheKey, $accessToken, 60);

            return $accessToken;
        } catch (Exception $e) {
            $erroMsg = $e->getMessage();

            if (property_exists('response', $e)) {
                $erroMsg = "ERRO {$e->response->statusCode} -- {$e->response->reasonPhrase}";
            }

            throw new Exception("Erro ao autenticar usuário no sistema PNCP\nMensagem do erro:\n{$erroMsg}");
        }
    }

    /**
     * @return string
     */
    private function getAuthorizationCode()
    {
        $data = "{$this->usuario}:{$this->senha}";
        return base64_encode($data);
    }

    /**
     * @param string $cnpj
     * @param array $dados
     * @return object
     * @throws Exception
     */
    public function incluirContrato($cnpj, $dados)
    {
        return $this->doRequestIncluirContrato($this->getUriIncluirContrato($cnpj), $dados);
    }

    /**
     * @param string $uri
     * @param array $dados
     * @return object
     * @throws Exception
     */
    private function doRequestIncluirContrato($uri, $dados = [])
    {
        try {
            $options = $this->options;

            if (!empty($dados)) {
                $options['body'] = json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }

            $response = $this->client->requestAsync('POST', $uri, $options)->wait();
            return $response->getHeader('location')[0];
        } catch (ClientException $e) {
            throw new ContratoException(
                $e->getMessage(),
                $e->getRequest(),
                $e->getResponse(),
                $e->getPrevious(),
                $e->getHandlerContext()
            );
        }
    }

    /**
     * @param $cnpj
     * @return string
     *
     */
    private function getUriIncluirContrato($cnpj)
    {
        return "v1/orgaos/{$cnpj}/contratos";
    }

    public function excluirContrato($contrato)
    {
        return $this->doRequestExcluirContrato(
            $this->getUriContrato($contrato)
        );
    }

    private function doRequestExcluirContrato($uri)
    {
        try {
            $options = $this->options;

            if (!empty($dados)) {
                $options['body'] = json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }

            $response = $this->client->requestAsync('DELETE', $uri, $options)->wait();
            return json_decode($response->getBody()->getContents());
        } catch (ClientException $e) {
            throw new ContratoException(
                $e->getMessage(),
                $e->getRequest(),
                $e->getResponse(),
                $e->getPrevious(),
                $e->getHandlerContext()
            );
        }
    }

    private function getUriContrato($contrato)
    {
        return "v1/orgaos/{$contrato->cnpj}/contratos/{$contrato->pn04_ano}/{$contrato->pn04_numero}";
    }

    public function incluirContratoDocumento($contrato, $dados)
    {
        return $this->doRequestIncluirDocumentoContrato(
            $this->getUriIncluirContratoDocumento($contrato),
            $dados
        );
    }

    /**
     * @param $uri
     * @param $dados
     * @return mixed
     */
    private function doRequestIncluirDocumentoContrato($uri, $dados = [])
    {
        try {
            $options = $this->options;
            unset($options['headers']['Content-Type']);

            if (!empty($dados['body'])) {
                $options['body'] = json_encode($dados, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }

            if (!empty($dados['headers'])) {
                if (!empty($options['headers'])) {
                    $options['headers'] = array_merge($options['headers'], $dados['headers']);
                } else {
                    $options['headers'] = $dados['headers'];
                }
            }

            if (!empty($dados['multipart'])) {
                $options['multipart'] = $dados['multipart'];
            }

            $response = $this->client->requestAsync('POST', $uri, $options)->wait();
            return $response->getHeader('location')[0];
        } catch (ClientException $e) {
            throw new ContratoException(
                $e->getMessage(),
                $e->getRequest(),
                $e->getResponse(),
                $e->getPrevious(),
                $e->getHandlerContext()
            );
        }
    }

    private function getUriIncluirContratoDocumento($contrato)
    {
        return "v1/orgaos/{$contrato['cnpj']}/contratos/{$contrato['ano']}/{$contrato['sequencial']}/arquivos";
    }

    /**
     * @param $documento
     * @param $dados
     * @param $header
     * @param $multipart
     * @return object
     * @throws Exception
     */
    public function incluirCompra($documento, $dados, $header, $multipart)
    {
        return $this->doRequestInclusaoCEA('POST', $this->getUriIncluirCompra($documento), $dados, $header, $multipart);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array|object $dados
     * @param array|object $headers
     * @return object
     * @throws Exception
     */
    private function doRequestInclusaoCEA($method, $uri, $dados = null, $headers = null, $multipart = null)
    {
        try {
            $options = $this->options;
            unset($options['headers']['Content-Type']);

            if (!empty($dados)) {
                $options['body'] = json_encode($dados);
            }

            if (!empty($multipart)) {
                $options['multipart'] = $multipart;
            }

            if (!empty($headers)) {
                foreach ($headers as $k => $header) {
                    $options['headers'][$k] = $header;
                }
            }

            $response = $this->client->requestAsync($method, $uri, $options)->wait();
            return json_decode($response->getBody()->getContents());
        } catch (ClientException $e) {
            throw new CompraEditalAvisoExcpetion(
                $e->getMessage(),
                $e->getRequest(),
                $e->getResponse(),
                $e->getPrevious(),
                $e->getHandlerContext()
            );
        }
    }

    /**
     * @param $documento
     * @return string
     */
    public function getUriIncluirCompra($documento)
    {
        return "v1/orgaos/{$documento}/compras";
    }

    /**
     * @param $cnpj
     * @param $ano
     * @param $numero
     * @return object
     */
    public function excluirCompra($cnpj, $ano, $numero)
    {
        return $this->doRequest('DELETE', $this->getUriExcluirCompra($cnpj, $ano, $numero));
    }


    /**
     * @param $method
     * @param $uri
     * @param $dados
     * @return object
     * @throws Exception
     */
    public function doRequest($method, $uri, $dados = null, $ataRP = null)
    {
        try {
            $options = $this->options;
            if (!empty($dados)) {
                $options['body'] = json_encode($dados);
            }

            $response = $this->client->requestAsync($method, $uri, $options)->wait();
            if (!empty($ataRP)) {
                return $response->getHeader('location')[0];
            }
            return (object)json_decode($response->getBody());
        } catch (Exception $e) {
            if ($e instanceof ClientException || $e instanceof ServerException) {
                throw new CompraEditalAvisoExcpetion(
                    $e->getMessage(),
                    $e->getRequest(),
                    $e->getResponse(),
                    $e->getPrevious(),
                    $e->getHandlerContext()
                );
            }
            throw $e;
        }
    }

    /**
     * @param $cnpj
     * @param $ano
     * @param $numero
     * @return string
     */
    public function getUriExcluirCompra($cnpj, $ano, $numero)
    {
        return "v1/orgaos/{$cnpj}/compras/{$ano}/{$numero}";
    }

    /**
     * @param $client_id
     * @param $dados
     * @return object
     * @throws Exception
     */
    public function incluirEnteAutorizado($client_id, $dados)
    {
        return $this->doRequest('POST', $this->getUriInsereEnte($client_id), $dados);
    }

    /**
     * @param $client_id
     * @return string
     */
    private function getUriInsereEnte($client_id)
    {
        return "v1/usuarios/{$client_id}/orgaos";
    }

    /**
     * @param $documento
     * @param $dados
     * @return object
     * @throws Exception
     */
    public function incluirUnidade($documento, $dados)
    {
        return $this->doRequest('POST', $this->getUriIncluirUnidade($documento), $dados);
    }

    /**
     * @param $documento
     * @return string
     */
    private function getUriIncluirUnidade($documento)
    {
        return "v1/orgaos/{$documento}/unidades";
    }

    /**
     * @param $cnpj
     * @param $ano
     * @param $sequencial
     * @param $numeroItem
     * @param $dados
     * @return object
     */
    public function incluirResultadoItem($cnpj, $ano, $sequencial, $numeroItem, $dados)
    {
        return $this->doRequest(
            'POST',
            $this->getUriIncluirResultadoItem($cnpj, $ano, $sequencial, $numeroItem),
            $dados
        );
    }

    public function getUriIncluirResultadoItem($cnpj, $ano, $sequencial, $numeroItem)
    {
        return "v1/orgaos/{$cnpj}/compras/{$ano}/{$sequencial}/itens/{$numeroItem}/resultados";
    }

    /**
     * @param $client_id
     * @return object
     * @throws Exception
     */
    public function verificaEnteAutorizado($client_id)
    {
        return $this->doRequest('GET', $this->getUriVerificaEntidade($client_id));
    }

    /**
     * @param $client_id
     * @return string
     */
    private function getUriVerificaEntidade($client_id)
    {
        return "v1/usuarios/{$client_id}";
    }

    /**
     * @param $documento
     * @return object
     * @throws Exception
     */
    public function buscarEntidade($documento)
    {
        return $this->doRequest('GET', $this->getUriBuscarEntidade($documento));
    }

    /**
     * @param $documento
     * @return string
     */
    private function getUriBuscarEntidade($documento)
    {
        return "v1/orgaos/{$documento}";
    }

    /**
     * @param $documento
     * @return object
     */
    public function buscarUnidades($documento)
    {
        return $this->doRequest('GET', $this->getUriBuscarUnidades($documento));
    }

    /**
     * @param $documento
     * @return string
     */
    private function getUriBuscarUnidades($documento)
    {
        return "v1/orgaos/{$documento}/unidades";
    }

    /**
     * @param $documento
     * @param $codigoUnidade
     * @return object
     */
    public function buscarUnidade($documento, $codigoUnidade)
    {
        return $this->doRequest('GET', $this->getUriBuscarUnidade($documento, $codigoUnidade));
    }

    /**
     * @param $documento
     * @param $codigoUnidade
     * @return string
     */
    private function getUriBuscarUnidade($documento, $codigoUnidade)
    {
        return "v1/orgaos/{$documento}/unidades/{$codigoUnidade}";
    }

    /**
     * @param $documento
     * @param $ano
     * @param $sequencial
     * @return object
     */
    public function buscarCompra($documento, $ano, $sequencial)
    {
        return $this->doRequest('GET', $this->getUriBuscarCompra($documento, $ano, $sequencial));
    }

    /**
     * @param $documento
     * @param $ano
     * @param $sequencial
     * @return string
     */
    private function getUriBuscarCompra($documento, $ano, $sequencial)
    {
        return "v1/orgaos/{$documento}/compras/{$ano}/{$sequencial}";
    }

    /**
     * @param $documento
     * @param $ano
     * @param $sequencial
     * @param $numeroItem
     * @return object
     */
    public function buscarResultadoItem($documento, $ano, $sequencial, $numeroItem)
    {
        return $this->doRequest('GET', $this->getResultadoItem($documento, $ano, $sequencial, $numeroItem));
    }

    /**
     * @param $documento
     * @param $ano
     * @param $sequencial
     * @param $numeroItem
     * @return string
     */
    private function getResultadoItem($documento, $ano, $sequencial, $numeroItem)
    {
        return "v1/orgaos/{$documento}/compras/{$ano}/{$sequencial}/itens/{$numeroItem}/resultados";
    }
}
