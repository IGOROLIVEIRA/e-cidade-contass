<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Implementations\BancoDoBrasil;

use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IAuth;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IConfiguration;
use BusinessException;
use DateTime;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Query;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Auth implements IAuth
{
    public const PIX_TOKEN_SESSION_NAME = 'pix_token';
    public const PIX_TOKEN_EXPIRATION_DATE_SESSION_NAME = 'pix_tokenExpirationDate';

    /**
     * @var IConfiguration
     */
    protected IConfiguration $configuration;

    protected bool $debug = false;

    protected SessionInterface $session;

    public function __construct(IConfiguration $configuration, SessionInterface $session)
    {
        $this->configuration = $configuration;
        $this->client = new Client();
        $this->session = $session;
    }

    /**
     * @return string
     * @throws BusinessException|GuzzleException
     */
    public function auth(): string
    {
        if (!$this->isTokenExpirated()) {
            return $this->session->get(self::PIX_TOKEN_SESSION_NAME);
        }
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
                $expriresIn = $bodyJson->{'expires_in'};
                $tokenCreationDate = new DateTime();
                $this->storeInSession($tokenCreationDate, $expriresIn, $token);
            }
        } catch (ClientException|RequestException $e) {

            $message =
                'Erro de autenticação com API pix da Instituição Financeira habilidata.';

            if (empty($e->getResponse())) {
                throw new BusinessException($message . ' Detalhes: ' . utf8_decode($e->getMessage()));
            }
            $error = \GuzzleHttp\json_decode($e->getResponse()->getBody()->getContents());

            if (in_array($e->getResponse()->getStatusCode(), [401, 403])) {
                throw new BusinessException($message . ' Detalhes: ' . utf8_decode($error->message));
            }

            if (!empty($error->error)) {
                $message .= ' Detalhes: ' . utf8_decode($error->mensagem);
            }

            if (!empty($error->erros)) {
                $message .= ' Detalhes: ' . utf8_decode($error->erros[0]->mensagem);
            }

            throw new BusinessException($message);
        }

        return $token;
    }

    private function isTokenExpirated(): bool
    {
        if (!$this->session->has(self::PIX_TOKEN_SESSION_NAME) ||
            !$this->session->has(self::PIX_TOKEN_EXPIRATION_DATE_SESSION_NAME)
        ) {
            return true;
        }

        $expirationDate = $this->session->get(self::PIX_TOKEN_EXPIRATION_DATE_SESSION_NAME);

        if (!$expirationDate instanceof DateTime) {
            return true;
        }

        $now = new DateTime();

        return $now >= $expirationDate;
    }

    /**
     * Create http client option
     *
     * @return array of http client options
     * @throws BusinessException
     */
    protected function createHttpClientOption()
    {
        $options = ['verify' => false];
        if ($this->debug) {
            $filename = 'tmp/' . date('Y-m-d') . '_authpixlog.log';
            $options[RequestOptions::DEBUG] = fopen($filename, 'a');
            if (!$options[RequestOptions::DEBUG]) {
                throw new BusinessException('Failed to open the debug file: ' . $filename);
            }
        }

        return $options;
    }

    public function storeInSession(DateTime $tokenCreationDate, string $expriresIn, string $token): void
    {
        $this->session->set(self::PIX_TOKEN_EXPIRATION_DATE_SESSION_NAME, $tokenCreationDate->modify("+{$expriresIn} seconds"));
        $this->session->set(self::PIX_TOKEN_SESSION_NAME, $token);
    }
}
