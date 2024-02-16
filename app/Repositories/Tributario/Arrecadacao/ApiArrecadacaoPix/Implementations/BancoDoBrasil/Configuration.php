<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Implementations\BancoDoBrasil;

use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IAuth;
use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IConfiguration;
use Symfony\Component\HttpFoundation\Session\Session;

class Configuration implements IConfiguration
{
    public const TEST_ENV = 'T';
    public const PROD_ENV = 'P';

    protected IAuth $authService;
    /**
     * APi key da aplicação cadastrada no BB Developer
     * @var string
     */
    protected string $applicationKey;

    /**
     * Url para autenticação Oauth2 no Banco do Brasil;
     * @var string
     */
    protected string $hostAuthOauth2 = 'https://oauth.sandbox.bb.com.br/oauth/token';

    /**
     * Lista com as permissões de acesso necessárias para o token a ser gerado no processo de autenticacao
     */
    protected string $scopesOauth2 = "pix.arrecadacao-info pix.arrecadacao-requisicao";

    /**
     * The host
     *
     * @var string
     */
    protected string $host = 'https://api.sandbox.bb.com.br/pix-bb/v1';

    /**
     * Access token for OAuth
     *
     * @var string
     */
    protected string $accessToken = '';

    /**
     * É o identificador público e único no OAuth do Banco do Brasil (client_id)
     * @var string
     */
    protected string $clientId = '';

    /**
     * É o client_secret fornecido pelo Banco do Brasil
     * @var string
     */
    protected string $clientSecret = '';

    protected string $environment = 'T';

    protected string $numeroConvenio;

    protected string $chavePix;

    public function __construct()
    {
        $session = new Session();
        $this->authService = new Auth($this, $session);
    }

    /**
     * @return string
     */
    public function getApplicationKey(): string
    {
        return $this->applicationKey;
    }

    /**
     * @param string $applicationKey
     * @return Configuration
     */
    public function setApplicationKey(string $applicationKey): Configuration
    {
        $this->applicationKey = $applicationKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrlAuthOauth2(): string
    {
        return $this->urlAuthOauth2;
    }

    /**
     * @param string $urlAuthOauth2
     * @return Configuration
     */
    public function setUrlAuthOauth2(string $urlAuthOauth2): Configuration
    {
        $this->urlAuthOauth2 = $urlAuthOauth2;
        return $this;
    }

    /**
     * @return string
     */
    public function getScopesOauth2(): string
    {
        return $this->scopesOauth2;
    }

    /**
     * @param string $scopesOauth2
     * @return Configuration
     */
    public function setScopesOauth2(string $scopesOauth2): Configuration
    {
        $this->scopesOauth2 = $scopesOauth2;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return $this
     */
    public function setHost(string $host): Configuration
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    /**
     * @param string $accessToken
     * @return Configuration
     */
    public function setAccessToken(string $accessToken): Configuration
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     * @return Configuration
     */
    public function setClientId(string $clientId): Configuration
    {
        $this->clientId = $clientId;
        return $this;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     * @return Configuration
     */
    public function setClientSecret(string $clientSecret): Configuration
    {
        $this->clientSecret = $clientSecret;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroConvenio(): string
    {
        return $this->numeroConvenio;
    }

    /**
     * @param string $numeroConvenio
     */
    public function setNumeroConvenio(string $numeroConvenio): Configuration
    {
        $this->numeroConvenio = $numeroConvenio;
        return $this;
    }

    /**
     * @return string
     */
    public function getChavePix(): string
    {
        return $this->chavePix;
    }

    /**
     * @param string $chavePix
     */
    public function setChavePix(string $chavePix): Configuration
    {
        $this->chavePix = $chavePix;
        return $this;
    }

    /**
     * @return string
     */
    public function getHostAuthOauth2(): string
    {
        return $this->hostAuthOauth2;
    }

    /**
     * @param string $hostAuthOauth2
     */
    public function setHostAuthOauth2(string $hostAuthOauth2): Configuration
    {
        $this->hostAuthOauth2 = $hostAuthOauth2;
        return $this;
    }

    public function getEnvironment(): string
    {
        return $this->environment;
    }

    public function setEnvironment(string $env): Configuration
    {
        $this->environment = $env;
        return $this;
    }

    public function authenticate(): Configuration
    {
        $this->setAccessToken($this->authService->auth());
        return $this;
    }

    public function getFinancialProvider(): ApiPixArrecadacao
    {
        return new ApiPixArrecadacao($this);
    }

    public function isProductionEnvironment(): bool
    {
        return $this->getEnvironment() === self::PROD_ENV;
    }
}
