<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class Cgm extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'cgm';

    /**
     * @var string
     */
    protected $primaryKey = 'z01_numcgm';

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
        'z01_numcgm'  ,
        'z01_nome',
        'z01_ender',
        'z01_numero',
        'z01_compl',
        'z01_bairro',
        'z01_munic',
        'z01_uf',
        'z01_cep',
        'z01_cxpostal',
        'z01_cadast',
        'z01_telef',
        'z01_ident',
        'z01_login',
        'z01_incest',
        'z01_telcel',
        'z01_email',
        'z01_endcon',
        'z01_numcon',
        'z01_comcon',
        'z01_baicon',
        'z01_muncon',
        'z01_ufcon',
        'z01_cepcon',
        'z01_cxposcon',
        'z01_telcon',
        'z01_celcon',
        'z01_emailc',
        'z01_nacion',
        'z01_estciv',
        'z01_profis',
        'z01_tipcre',
        'z01_cgccpf',
        'z01_fax',
        'z01_nasc',
        'z01_pai',
        'z01_mae',
        'z01_sexo',
        'z01_ultalt',
        'z01_contato',
        'z01_hora',
        'z01_nomefanta',
        'z01_cnh',
        'z01_categoria',
        'z01_dtemissao',
        'z01_dthabilitacao',
        'z01_nomecomple',
        'z01_dtvencimento',
        'z01_dtfalecimento',
        'z01_escolaridade',
        'z01_naturalidade',
        'z01_identdtexp',
        'z01_identorgao',
        'z01_trabalha',
        'z01_renda',
        'z01_localtrabalho',
        'z01_pis',
        'z01_obs',
        'z01_incmunici',
        'z01_ibge',
        'z01_notificaemail',
        'z01_naturezajuridica',
        'z01_anoobito',
        'z01_produtorrural',
        'z01_situacaocadastral',
    ];

    public function pcForne()
    {
        return $this->hasOne(PcForne::class, 'pc60_numcgm', 'z01_numcgm');
    }

    public function getZ01NomeUpperAttribute()
    {
        return strtoupper($this->z01_nome);
    }

    public function getz01UfUpperAttribute()
    {
        return strtoupper($this->z01_uf);
    }

    public function getZ01MunicAttribute()
    {
        return strtoupper($this->z01_munic);
    }

    public function getZ01BairroUpperAttribute()
    {
        return strtoupper($this->z01_bairro);
    }

    public function getZ01EnderUpperAttribute()
    {
        return strtoupper($this->z01_ender);
    }
}

