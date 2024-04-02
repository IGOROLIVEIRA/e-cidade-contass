<?php

namespace App\Repositories\Patrimonial;

use App\Models\PcOrcam;
use Illuminate\Database\Capsule\Manager as DB;
use cl_pcorcam;
use db_stdClass;

class PcOrcamRepository 
{

    /**
     *
     * @var PcOrcam
     */
    private PcOrcam $model;

    public function __construct()
    {
        $this->model = new PcOrcam();
    }

    /**
     *
     * @param array $orcamento - dados do orçamento
     * @return bool
     */
    public function update($orcamento)
    {
       $pcOrcam = $this->model->find($orcamento->pc20_codorc);
       $pcOrcam->pc20_dtate = $orcamento->pc20_dtate;
       $pcOrcam->pc20_hrate = $orcamento->pc20_hrate;
       $pcOrcam->pc20_prazoentrega = $orcamento->pc20_prazoentrega;
       $pcOrcam->pc20_validadeorcamento = $orcamento->pc20_validadeorcamento;
       $pcOrcam->pc20_cotacaoprevia = $orcamento->pc20_cotacaoprevia;
       $pcOrcam->pc20_obs = utf8_decode(db_stdClass::db_stripTagsJsonSemEscape($orcamento->pc20_obs));
       
       return $pcOrcam->save();
    }

    /**
     *
     * @param int $sequencial - Sequencial do Orçamento/Licitação/Processo de Compra
     * @param string $origem - Origem do Orçamento
     * @return array
     */
    public function getDadosManutencaoOrcamento($sequencial,$origem)
    {
        $clPcOrcam = new cl_pcorcam();
        $sql = $clPcOrcam->getManutencaoOrcamento($sequencial,$origem);
        return DB::select($sql);
    }

}
