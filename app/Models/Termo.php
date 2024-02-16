<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class Termo extends LegacyModel
{
    use LegacyAccount;

    public const STATE_ACTIVED = 1;
    public const STATE_REVOKED = 2;

    /**
     * O parcelamento ganha este status quando foi reparcelado
     */
    public const STATE_IN_INSTALLMENTS = 3;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    public $timestamps = false;
    /**
     * @var string
     */
    protected $table = 'divida.termo';
    /**
     * @var string
     */
    protected $primaryKey = 'v07_parcel';

    protected $fillable = [
        'v07_parcel',
        'v07_dtlanc',
        'v07_valor',
        'v07_numpre',
        'v07_totpar',
        'v07_vlrpar',
        'v07_dtvenc',
        'v07_vlrent',
        'v07_datpri',
        'v07_vlrmul',
        'v07_vlrjur',
        'v07_perjur',
        'v07_permul',
        'v07_login',
        'v07_mtermo',
        'v07_numcgm',
        'v07_hist',
        'v07_ultpar',
        'v07_desconto',
        'v07_descjur',
        'v07_descmul',
        'v07_situacao',
        'v07_instit',
        'v07_vlrhis',
        'v07_vlrcor',
        'v07_vlrdes',
        'v07_desccor',
    ];

    public function isActived(): bool
    {
        return $this->v07_situacao === self::STATE_ACTIVED;
    }

    public function isRevoked(): bool
    {
        return $this->v07_situacao === self::STATE_REVOKED;
    }

    public function isInInstallment(): bool
    {
        return $this->v07_situacao === self::STATE_IN_INSTALLMENTS;
    }

}
