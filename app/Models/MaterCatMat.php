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

    public function sqlQueryCatmat($where) {
        $sql = $this->newQuery()
            ->select([
                '*',
            ])
            ->where($where)
            ->toSql();
        $sql = str_replace('"','',$sql);
        $sql = str_replace('is null','',$sql);

        return $sql;
    }

    public function sqlQueryAllCatMat() {
        $sql = $this->newQuery()
            ->select([
                '*',
            ])
            ->toSql();
        return str_replace('"','',$sql);
    }
}
