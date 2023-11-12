<?php

namespace App\Domain\Financeiro\Empenho\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServicoObra extends Model
{
    const TIPO_LABELS = [
        0 => '0 - N�o � obra de constru��o civil ou n�o est� sujeita a matr�cula de obra',
        1 => '1 - � obra de constru��o civil, modalidade empreitada total',
        2 => '2 - � obra de constru��o civil, modalidade empreitada parcial'
    ];

    protected $table = 'empenho.emptiposervicoobra';
    protected $primaryKey = 'e154_sequencial';
    public $timestamps = false;
}
