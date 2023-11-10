<?php

namespace App\Domain\Patrimonial\PNCP\Exceptions;

use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CompraEditalAvisoExcpetion extends ClientException
{
    /**
     * @var object
     */
    private $erro;

    public function __construct(
        $message,
        RequestInterface $request,
        ResponseInterface $response = null,
        \Exception $previous = null,
        array $handlerContext = []
    ) {
        $erroJson = $message;

        if ($response !== null) {
            $erroJson = $response->getBody()->getContents();
            $this->erro = (object)json_decode($erroJson);
        }

        parent::__construct($message, $request, $response, $previous, $handlerContext);
    }

    public function getErros()
    {
        if (property_exists($this->erro, 'status')) {
            return utf8_decode("{$this->erro->message}");
        }
        if (property_exists($this->erro, 'erros')) {
            return utf8_decode("{$this->erro->erros[0]->mensagem}");
        }

        return $this->getMessage();
    }
}
