<?php

use Phinx\Migration\AbstractMigration;

class Oc14725 extends AbstractMigration
{
    public function up()
    {
        $sSql = "";
        $aRowsInstit = $this->getInstit();
        foreach ($aRowsInstit as $aInstit) {
            $sSql .= "
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal) VALUES ('9000', 'SALDO DE SALÁRIO NA RESCISÃO', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA AUTOMÁTICA ', {$aInstit['codigo']}, true, 1, 0, 0, false, NULL);
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal) VALUES ('9001', '13° SALÁRIO PROPORCIONAL NA RESCISÃO', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA AUTOMÁTICA ', {$aInstit['codigo']}, true, 1, 0, 0, false, NULL);
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal) VALUES ('9002', 'FÉRIAS PROPORCIONAIS', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA AUTOMÁTICA', {$aInstit['codigo']}, true, 1, 0, 0, false, NULL);
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal) VALUES ('9003', 'FÉRIAS VENCIDAS NA RESCISÃO', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA AUTOMÁTICA', {$aInstit['codigo']}, true, 1, 0, 0, false, NULL);
        ";
        }
        $this->execute($sSql);
    }

    public function down() {
        $this->execute("DELETE FROM rhrubricas where rh27_rubric in ('9000','9001','9002','9003')");
    }

    private function getInstit()
    {
        return $this->fetchAll("SELECT codigo FROM db_config");
    }
}
