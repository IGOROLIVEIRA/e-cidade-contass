<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use Illuminate\Database\Eloquent\Builder;

class ItbiDivida extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'itbi.itbi_divida';

    /**
     * @var string
     */
    protected $primaryKey = 'it36_guia, it36_coddiv';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'it36_guia',
        'it36_coddiv',
        'it36_data',
        'it36_usuario',
        'it36_observacao',
    ];

    public function scopeWhereCodGuia(Builder $query, int $codguia): void
    {
        $query->where('it36_guia', $codguia);
    }
}
