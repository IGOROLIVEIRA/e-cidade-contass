<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\DTO;

use App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\Contracts\IPixPayload;

class PixArrecadacaoPayloadDTO implements IPixPayload
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
        $this->fill($data);
    }

    /**
     * Business logic to fill the payload
     * @param array $data
     * @return void
     */
    public function fill(array $data): void
    {
        foreach ($data as $attribute => $value) {
            if ($attribute === 'valorOriginalSolicitacao') {
                $value = number_format($value, 2);
            }
            $this->$attribute = $value;
        }
    }

    /**
     * @return false|string
     */
    public function toJson()
    {
        return json_encode($this);
    }
}
