<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use Illuminate\Database\Capsule\Manager as DB;

class AcordoItemDotacao extends LegacyModel
{
    use LegacyAccount;

    public $timestamps = false;

    protected $table = 'acordos.acordoitemdotacao';

    protected $primaryKey = 'ac22_sequencial';

    protected $fillable = [
        'ac22_sequencial',
        'ac22_coddot',
        'ac22_anousu',
        'ac22_acordoitem',
        'ac22_valor',
        'ac22_quantidade'
    ];

    public function scopeProcuraPorCodigoDotacao($query, $coddotacao)
    {
        return $query->where('ac22_coddot', $coddotacao);
    }

    public function scopeProcuraPorAno($query, $ano)
    {
        return $query->where('ac22_anousu', $ano);
    }

    public function scopeProcuraPorAcordoItem($query, $acordoitem)
    {
        return $query->where('ac22_acordoitem', $acordoitem);
    }

    public function scopeProcuraPorValor($query, $valor)
    {
        return $query->where('ac22_valor', $valor);
    }

    public function scopeProcuraPorQuantidade($query, $quantidade)
    {
        return $query->where('ac22_quantidade', $quantidade);
    }

    public function getProximoSequencial() {
        $proximo = DB::select("select nextval('acordoitemdotacao_ac22_sequencial_seq')");

        return intval($proximo['0']->nextval);
    }
}
