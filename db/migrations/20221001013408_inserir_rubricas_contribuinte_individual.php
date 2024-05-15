<?php

use Phinx\Migration\AbstractMigration;

class InserirRubricasContribuinteIndividual extends AbstractMigration
{

    public function up()
    {
        $sql = "";
        $aRowsInstit = $this->getInstit();
        foreach ($aRowsInstit as $aInstit) {
            $sql .= "
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal, rh27_codincidprev, rh27_codincidirrf, rh27_codincidfgts, rh27_codincidregime, rh27_tetoremun) VALUES ('R002', 'CONTRIBUINTE INDIVIDUAL FRETE REMUN', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA CONTABILIDADE', {$aInstit['codigo']}, true, 1, 0, 0, false, NULL, 3003779, 4003071, 3003851, 4000559, false);
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal, rh27_codincidprev, rh27_codincidirrf, rh27_codincidfgts, rh27_codincidregime, rh27_tetoremun) VALUES ('R001', 'CONTRIBUINTE INDIVIDUAL GERAL', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA CONTABILIDADE', {$aInstit['codigo']}, true, 1, 0, 0, false, NULL, 3003781, 3003844, 3003851, 4000559, false);
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal, rh27_codincidprev, rh27_codincidirrf, rh27_codincidfgts, rh27_codincidregime, rh27_tetoremun) VALUES ('R003', 'CONTRIBUINTE INDIVIDUAL FRETE REMUN INSS', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA CONTABILIDADE', {$aInstit['codigo']}, true, 1, 0, 0, false, NULL, 3003781, 4003071, 3003851, 4000559, false);
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal, rh27_codincidprev, rh27_codincidirrf, rh27_codincidfgts, rh27_codincidregime, rh27_tetoremun) VALUES ('R004', 'CONTRIBUINTE INDIVIDUAL FRETE REMUN IRRF', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA CONTABILIDADE', {$aInstit['codigo']}, true, 1, 0, 0, false, NULL, 3003779, 3003844, 3003851, 4000559, false);
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal, rh27_codincidprev, rh27_codincidirrf, rh27_codincidfgts, rh27_codincidregime, rh27_tetoremun) VALUES ('R005', 'CONTRIBUINTE INDIVIDUAL DESC INSS', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA CONTABILIDADE', {$aInstit['codigo']}, true, 2, 0, 0, false, NULL, 3003793, 3003834, 3003851, 4000559, false);
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal, rh27_codincidprev, rh27_codincidirrf, rh27_codincidfgts, rh27_codincidregime, rh27_tetoremun) VALUES ('R006', 'CONTRIBUINTE INDIVIDUAL DESC IRRF', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA CONTABILIDADE', {$aInstit['codigo']}, true, 2, 0, 0, false, NULL, 3003779, 3003839, 3003851, 4000559, false);
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal, rh27_codincidprev, rh27_codincidirrf, rh27_codincidfgts, rh27_codincidregime, rh27_tetoremun) VALUES ('R007', 'CONTRIBUINTE INDIVIDUAL DESC SEST', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA CONTABILIDADE', {$aInstit['codigo']}, true, 2, 0, 0, false, NULL, 3003795, 4003023, 3003851, 4000559, false);
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal, rh27_codincidprev, rh27_codincidirrf, rh27_codincidfgts, rh27_codincidregime, rh27_tetoremun) VALUES ('R008', 'CONTRIBUINTE INDIVIDUAL DESC SENAT', 0, '', '', '', '', '', '', 0, 0, false, 1, false, false, false, false, false, 'RUBRICA CONTABILIDADE', {$aInstit['codigo']}, true, 1, 0, 0, false, NULL, 3003796, 4003023, 3003851, 4000559, false);
            INSERT INTO rhrubricas (rh27_rubric, rh27_descr, rh27_quant, rh27_cond2, rh27_cond3, rh27_form, rh27_form2, rh27_form3, rh27_formq, rh27_calc1, rh27_calc2, rh27_calc3, rh27_tipo, rh27_limdat, rh27_presta, rh27_calcp, rh27_propq, rh27_propi, rh27_obs, rh27_instit, rh27_ativo, rh27_pd, rh27_valorpadrao, rh27_quantidadepadrao, rh27_complementarautomatica, rh27_rhfundamentacaolegal, rh27_codincidprev, rh27_codincidirrf, rh27_codincidfgts, rh27_codincidregime, rh27_tetoremun) VALUES ('R009', 'CONTRIBUINTE INDIVIDUAL DESC OUTROS', 0, '', '', '', '', '', '', 0, 0, false, 2, false, false, false, false, false, 'RUBRICA CONTABILIDADE', {$aInstit['codigo']}, true, 2, 0, 0, false, NULL, 3003779, 4003023, 3003851, 4000559, false); 
                    ";
        }
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DELETE FROM rhrubricas WHERE rh27_rubric in ('R001','R002','R003','R004','R005','R006','R007','R008','R009')";
        $this->execute($sql);
    }

    private function getInstit()
    {
        return $this->fetchAll("SELECT codigo FROM db_config");
    }
}
