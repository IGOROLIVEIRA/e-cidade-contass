<?php

namespace App\Services\Patrimonial\Orcamento;

use App\Repositories\Patrimonial\PcOrcamValRepository;
use Exception;

class PcOrcamValService
{

    /**
     * @var PcOrcamValRepository
     */
    private $pcOrcamValRepository;

    public function __construct()
    {
        $this->pcOrcamValRepository = new PcOrcamValRepository();
    }

    /**
     *
     * @param array $pcOrcamVal - dados do orçamento
     * @return bool
     */
    public function updateOrcamVal($pcOrcamVal)
    {

        if($pcOrcamVal['pc23_quant'] == ""){
            throw new Exception("Usuário: Campo Quantidade Orçada não Informado.");
        }

        if($pcOrcamVal['pc23_vlrun'] == ""){
            throw new Exception("Usuário: Campo Valor Unitário não Informado.");
        }    

        if($pcOrcamVal['pc23_valor'] == ""){
            throw new Exception("Usuário: Campo Valor não Informado.");
        }   
        
        $result = $this->pcOrcamValRepository->update($pcOrcamVal);
        return $result;

    }
}
