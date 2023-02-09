<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\DTO;

class PixArrecadacaoPayloadDTO
{
    /**
     * @var int
     */
    public int $numeroConvenio;

    /**
     * @var string
     */
    public string $indicadorCodigoBarras;

    /**
     * @var string
     */
    public string $codigoGuiaRecebimento;

    /**
     * @var string
     */
    public string $emailDevedor;

    /**
     * @var int
     */
    public int $codigoPaisTelefoneDevedor;

    /**
     * @var int
     */
    public int $dddTelefoneDevedor;

    /**
     * @var string
     */
    public string $numeroTelefoneDevedor;

    /**
     * @var string
     */
    public string $codigoSolicitacaoBancoCentralBrasil;

    /**
     * @var string
     */
    public string $descricaoSolicitacaoPagamento;

    /**
     * @var number
     */
    public float $valorOriginalSolicitacao;

    /**
     * @var string
     */
    public string $cpfDevedor;

    /**
     * @var string
     */
    public string $nomeDevedor;

    /**
     * @var string
     */
    public string $quantidadeSegundoExpiracao;

    /**
     * @var array
     */
    public array $listaInformacaoAdicional;

    public function __construct($data = null)
    {
        if (empty($data)) {
           return;
        }
        foreach ($data as $attribute => $value) {
            $this->$attribute = $value;
        }
    }

    public function toJson()
    {
        return json_encode($this);
    }
}
