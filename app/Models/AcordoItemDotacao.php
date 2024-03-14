<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class AcordoItemDotacao extends LegacyModel
{
    use LegacyAccount;

    /**
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $table = 'acordos.acordoitemdotacao';

    /**
     * @var string
     */
    protected $primaryKey = 'ac22_sequencial';

    protected string $sequenceName = 'acordoitemdotacao_ac22_sequencial_seq';

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
}
