<?php

namespace App\Domain\Patrimonial\Licitacoes\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'licitacao.liclicitem';
    protected $primaryKey = 'l21_codigo';
    public $timestamps = false;

    public function licitacao()
    {
        return $this->hasOne(Licitacao::class, 'l21_codliclicita', 'l20_codigo');
    }
}
