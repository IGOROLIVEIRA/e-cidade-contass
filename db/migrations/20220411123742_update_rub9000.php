<?php

use Phinx\Migration\AbstractMigration;

class UpdateRub9000 extends AbstractMigration
{

    public function up()
    {
        $arrBaseRubric = array(
            '9000' => '6000',
            '9001' => '6002',
            '9002' => '6006',
            '9003' => '6007'
        );
        $sqlBaseEsocial = "";
        $sql = "
        UPDATE rhrubricas
        SET rh27_codincidprev = 3003781,
            rh27_codincidirrf = 3003844,
            rh27_codincidfgts = 3003851,
            rh27_codincidregime = 4000561,
            rh27_tetoremun = 't'
        WHERE rh27_rubric = '9000';        

        UPDATE rhrubricas
        SET rh27_codincidprev = 3003782,
            rh27_codincidirrf = 3003843,
            rh27_codincidfgts = 3003851,
            rh27_codincidregime = 4000562,
            rh27_tetoremun = 't'
        WHERE rh27_rubric = '9001';

        UPDATE rhrubricas
        SET rh27_codincidprev = 3003779,
            rh27_codincidirrf = 3003815,
            rh27_codincidfgts = 3003851,
            rh27_codincidregime = 4000559,
            rh27_tetoremun = 'f'
        WHERE rh27_rubric = '9002';

        UPDATE rhrubricas
        SET rh27_codincidprev = 3003779,
            rh27_codincidirrf = 3003815,
            rh27_codincidfgts = 3003851,
            rh27_codincidregime = 4000559,
            rh27_tetoremun = 'f'
        WHERE rh27_rubric = '9003';
        ";

        foreach ($arrBaseRubric as $rubric => $base) {
            $sqlBaseEsocial = "UPDATE baserubricasesocial SET e991_rubricasesocial = '{$base}' WHERE e991_rubricas = '{$rubric}';";
            if ($this->checkRub($rubric)) {
                $this->insertBaseRubricaEsocial($base,$rubric);
                $sqlBaseEsocial = "";
                $sql .= $sqlBaseEsocial;
            }
        }

        $this->execute($sql);

    }

    private function checkRub($rubric)
    {
        $result = $this->fetchRow("SELECT * FROM baserubricasesocial WHERE e991_rubricas = '{$rubric}'");
        return empty($result);
    }

    private function insertBaseRubricaEsocial($rubricEsocial, $rubric)
    {
        $result = $this->fetchAll("SELECT codigo FROM db_config WHERE codigo IN (SELECT rh27_instit FROM rhrubricas)");
        foreach ($result as $instit) {
            if ($this->checkRubInst($rubric)) {
                $this->execute("INSERT INTO baserubricasesocial VALUES ('{$rubricEsocial}','{$rubric}',{$instit['codigo']})");
            }
        }
    }

    private function checkRubInst($rubric)
    {
        $result = $this->fetchRow("SELECT rh27_instit FROM rhrubricas WHERE rh27_rubric = '{$rubric}'");
        return !empty($result);
    }
}
