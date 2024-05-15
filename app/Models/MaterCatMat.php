<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use Illuminate\Database\Query\Expression;

class MaterCatMat extends LegacyModel
{
    use LegacyAccount;

    public $timestamps = false;

    protected $table = 'farmacia.far_matercatmat';

    protected $primaryKey = 'faxx_i_codigo';

    protected string $sequenceName = 'far_matercatmat_faxx_i_codigo_seq';

    protected $fillable = [
        'faxx_i_codigo',
        'faxx_i_catmat',
        'faxx_i_desc',
        'faxx_i_ativo',
        'faxx_i_susten',
    ];
    public function sqlQueryCatmat($campos,$where) {
        $sql = $this->select([
            new Expression($campos),
            ])
            ->whereRaw($where)
            ->toSql();

        $sql = str_replace('"','',$sql);

        return $sql;
    }

    public function sqlQueryAllCatMat($campos) {
        $sql = $this->select([
                $campos,
            ])
            ->toSql();
        return str_replace('"','',$sql);
    }
    public function getFirstCatMat($campos,$where) {
        return $this->select([
            new Expression($campos),
        ])
            ->whereRaw(new Expression($where))
            ->first();
    }
}
