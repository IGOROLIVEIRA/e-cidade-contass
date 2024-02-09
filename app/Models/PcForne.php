<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class PcForne extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'compras.pcforne';

    /**
     * @var string
     */
    protected $primaryKey = 'pc60_numcgm';

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
        'pc60_numcgm',
        'pc60_dtlanc',
        'pc60_obs',
        'pc60_bloqueado',
        'pc60_hora',
        'pc60_usuario',
        'pc60_objsocial',
        'pc60_orgaoreg',
        'pc60_dtreg',
        'pc60_cnpjcpf',
        'pc60_dtreg_cvm',
        'pc60_numerocvm',
        'pc60_inscriestadual',
        'pc60_uf',
        'pc60_numeroregistro',
        'pc60_databloqueio_ini',
        'pc60_databloqueio_fim',
        'pc60_motivobloqueio',
        'pc60_instit'
    ];

    public function cgm()
    {
        return $this->belongsTo(Cgm::class, 'pc60_numcgm', 'z01_numcgm');
    }

    public function getPc60ObsUpperAttribute()
    {
        return strtoupper($this->pc60_obs);
    }

    public function getPc60MotivobloqueioUpperAttribute()
    {
        return strtoupper($this->pc60_motivobloqueio);
    }

}
