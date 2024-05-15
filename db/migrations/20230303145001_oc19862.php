<?php

use Phinx\Migration\AbstractMigration;

class Oc19862 extends AbstractMigration
{
    protected $sSql = "SELECT o41_anousu, o41_unidade, o41_instit, o41_orddespesa, o41_ordliquidacao, o41_ordpagamento FROM orcunidade ";
                       
    public function up()
    {
        if (!empty($this->getFieldsNulls())) {
            foreach ($this->getFieldsNulls() as $unidade) {
                $aUnidades = $this->getValuesFields($unidade['o41_unidade'], $unidade['o41_instit']);
                foreach ($aUnidades as $upUnidade):
                    if (!empty($upUnidade['o41_orddespesa']) && !empty($upUnidade['o41_ordliquidacao']) && !empty($upUnidade['o41_ordpagamento'])) {
                        $this->updateField(
                            2023,
                            $upUnidade['o41_unidade'],
                            $upUnidade['o41_instit'],
                            $upUnidade['o41_orddespesa'],
                            $upUnidade['o41_ordliquidacao'],
                            $upUnidade['o41_ordpagamento']
                        );
                    }
                endforeach;
            }
        }
    }

    public function getFieldsNulls()
    {
        $sSql = $this->sSql;
        $sSql .= "WHERE o41_anousu = 2023
                    AND (o41_orddespesa IS NULL OR o41_ordliquidacao IS NULL OR o41_ordpagamento IS NULL)";
        
        $sSql = $this->query($sSql);
        return $sSql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getValuesFields($iCodUnidade, $iInstit)
    {
        $sSql = $this->sSql;
        $sSql .= "WHERE o41_anousu = 2022
                   AND o41_unidade = $iCodUnidade
                   AND o41_instit = $iInstit";
        
        $sSql = $this->query($sSql);
        return $sSql->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateField($iAno, $iUnidade, $iInstit, $ordDespesa, $ordLiquidacao, $ordPagamento)
    {
        $builder = "UPDATE orcunidade
                    SET o41_orddespesa = $ordDespesa,
                        o41_ordliquidacao = $ordLiquidacao,
                        o41_ordpagamento = $ordPagamento
                    WHERE (o41_anousu, o41_unidade, o41_instit) = ($iAno, $iUnidade, $iInstit)";
        
        $this->execute($builder);
    }
}
