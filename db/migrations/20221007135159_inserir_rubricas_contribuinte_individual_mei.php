<?php

use Phinx\Migration\AbstractMigration;

class InserirRubricasContribuinteIndividualMei extends AbstractMigration
{
    public function up()
    {
        $sql = "";
        $aRowsInstit = $this->getInstit();
        foreach ($aRowsInstit as $aInstit) {
            $sql .= "
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal, rh27_codincidprev, rh27_codincidirrf, rh27_codincidfgts, rh27_codincidregime, rh27_tetoremun) VALUES ('R010', 'CONTRIBUINTE INDIVIDUAL MEI', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA CONTABILIDADE', {$aInstit['codigo']}, true, 1, 0, 0, false, NULL, 3003783, 4003015, 3003851, 4000559, false);
            INSERT INTO baserubricasesocial (e991_rubricasesocial,e991_rubricas,e991_instit) VALUES (3501, 'R010', {$aInstit['codigo']});
                    ";
        }
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        DELETE FROM rhrubricas WHERE rh27_rubric in ('R010');
        DELETE FROM baserubricasesocial WHERE e991_rubricas in ('R010');
        ";
        $this->execute($sql);
    }

    private function getInstit()
    {
        return $this->fetchAll("SELECT codigo FROM db_config");
    }
}
