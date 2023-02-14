<?php

namespace App\Repositories\Tributario\Arrecadacao\ApiArrecadacaoPix\DTO;

class PixArrecadacaoResponseDTO
{
    /**
     * @var string
     */
    public $timestampCriacaoSolicitacao;

    /**
     * @var string
     */
    public $estadoSolicitacao;

    /**
     * @var string
     */
    public $codigoConciliacaoSolicitante;

    /**
     * @var string
     */
    public $numeroVersaoSolicitacaoPagamento;

    /**
     * @var string
     */
    public $linkQrCode;

    /**
     * @var string
     */
    public $qrCode;

    public function __construct(array $data)
    {
        if (empty($data)) {
            return;
        }
        foreach ($data as $attribute => $value) {
            $this->$attribute = $value;
        }
    }
}
