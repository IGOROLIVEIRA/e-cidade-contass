<?php

namespace App\Repositories\Patrimonial;

use App\Models\PcOrcamVal;
use Illuminate\Database\Capsule\Manager as DB;

class PcOrcamValRepository 
{

    /**
     *
     * @var PcOrcamVal
     */
    private PcOrcamVal $model;

    public function __construct()
    {
        $this->model = new PcOrcamVal();
    }

    /**
     *
     * @param array $dados - itens do orçamento
     * @return bool
     */
    public function update($dados)
    {
       return DB::table('compras.pcorcamval')->where('pc23_orcamforne',$dados['pc23_orcamforne'])->where('pc23_orcamitem',$dados['pc23_orcamitem'])->update($dados);
    }

}
