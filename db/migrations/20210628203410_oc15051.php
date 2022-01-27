<?php

use Phinx\Migration\AbstractMigration;

class Oc15051 extends AbstractMigration
{
    public function up()
    {
        if ($this->checkCausaAfast()) {
            $sSql = "INSERT INTO causaafastamento VAlUES (14,'','Rescisão por acordo entre trabalhador e empregador');
            INSERT INTO rescisao (r59_anousu, r59_mesusu, r59_regime, r59_causa, r59_descr, r59_caub, r59_descr1, r59_menos1, r59_aviso, r59_13sal, r59_fvenc, r59_fprop, r59_tercof, r59_codsaq, r59_mfgts, r59_479clt, r59_grfp, r59_finss, r59_ffgts, r59_firrf, r59_13inss, r59_13fgts, r59_13irrf, r59_rinss, r59_rfgts, r59_rirrf, r59_movsef, r59_instit, r59_causaafastamento) VALUES (2021, 6, 2, 91, 'RESCISÃO POR ACORDO', '01', 'RESCISÃO POR ACORDO', 'N', true, true, true, true, 100, '07', 20, false, true, false, false, false, true, true, true, false, false, false, 'I5', 8, 14);
            INSERT INTO rescisao (r59_anousu, r59_mesusu, r59_regime, r59_causa, r59_descr, r59_caub, r59_descr1, r59_menos1, r59_aviso, r59_13sal, r59_fvenc, r59_fprop, r59_tercof, r59_codsaq, r59_mfgts, r59_479clt, r59_grfp, r59_finss, r59_ffgts, r59_firrf, r59_13inss, r59_13fgts, r59_13irrf, r59_rinss, r59_rfgts, r59_rirrf, r59_movsef, r59_instit, r59_causaafastamento) VALUES (2021, 6, 2, 91, 'RESCISÃO POR ACORDO', '02', 'RESCISÃO POR ACORDO', 'S', true, true, true, true, 100, '07', 20, false, true, false, false, false, true, true, true, false, false, false, 'I5', 8, 14);";
            $this->execute($sSql);
        }
    }

    public function down()
    {
        $sSql = "DELETE FROM causaafastamento WHERE rh115_sequencial = 14;
        DELETE FROM rescisao WHERE r59_regime = 2 and r59_causaafastamento = 14;";
        $this->execute($sSql);
    }

    private function checkCausaAfast()
    {
        $result = $this->execute("SELECT * FROM causaafastamento WHERE rh115_sequencial = 14");
        if (empty($result)) {
            return true;
        }
        return false; 
    }
}
