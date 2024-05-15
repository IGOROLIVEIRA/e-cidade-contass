<?php

use Phinx\Migration\AbstractMigration;

class InserirNaturezaRubricasContribuinteIndividual extends AbstractMigration
{

    public function up()
    {
        $sql = "";
        $aRowsInstit = $this->getInstit();
        foreach ($aRowsInstit as $aInstit) {
            $sql .= "
            INSERT INTO baserubricasesocial (e991_rubricasesocial,e991_rubricas,e991_instit) VALUES (3501, 'R001', {$aInstit['codigo']});
            INSERT INTO baserubricasesocial (e991_rubricasesocial,e991_rubricas,e991_instit) VALUES (3501, 'R002', {$aInstit['codigo']});
            INSERT INTO baserubricasesocial (e991_rubricasesocial,e991_rubricas,e991_instit) VALUES (3501, 'R003', {$aInstit['codigo']});
            INSERT INTO baserubricasesocial (e991_rubricasesocial,e991_rubricas,e991_instit) VALUES (3501, 'R004', {$aInstit['codigo']});
            INSERT INTO baserubricasesocial (e991_rubricasesocial,e991_rubricas,e991_instit) VALUES (9201, 'R005', {$aInstit['codigo']});
            INSERT INTO baserubricasesocial (e991_rubricasesocial,e991_rubricas,e991_instit) VALUES (9203, 'R006', {$aInstit['codigo']});
            INSERT INTO baserubricasesocial (e991_rubricasesocial,e991_rubricas,e991_instit) VALUES (9217, 'R007', {$aInstit['codigo']});
            INSERT INTO baserubricasesocial (e991_rubricasesocial,e991_rubricas,e991_instit) VALUES (9217, 'R008', {$aInstit['codigo']});
            INSERT INTO baserubricasesocial (e991_rubricasesocial,e991_rubricas,e991_instit) VALUES (9299, 'R009', {$aInstit['codigo']});
                    ";
        }
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "DELETE FROM baserubricasesocial WHERE e991_rubricas in ('R001','R002','R003','R004','R005','R006','R007','R008','R009')";
        $this->execute($sql);
    }

    private function getInstit()
    {
        return $this->fetchAll("SELECT codigo FROM db_config");
    }
}
