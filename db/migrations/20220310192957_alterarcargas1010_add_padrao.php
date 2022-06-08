<?php

use Phinx\Migration\AbstractMigration;

class Alterarcargas1010AddPadrao extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        BEGIN;

        
        UPDATE avaliacaopergunta
        SET db103_camposql = 'codidentpadrao'
        WHERE db103_sequencial = 3000941;


        update avaliacao set db101_cargadados = 'SELECT rh27_rubric AS codrubr,
        rh27_instit AS instituicao,
        rh27_descr AS dscrubr,
        CASE
            WHEN rh27_pd =1 THEN \'3003778\'
            WHEN rh27_pd =2 THEN \'3003777\'
            WHEN rh27_pd =3
                 AND rh27_rubric IN (\'R992\',
                                     \'R991\',
                                     \'R981\',
                                     \'R982\',
                                     \'R983\',
                                     \'R997\',
                                     \'R999\') THEN \'3003776\'
            WHEN rh27_pd =3
                 AND rh27_rubric IN (\'R984\') THEN \'3003775\'
        END AS tprubr,
        rh27_codincidprev AS codinccp,
        rh27_codincidirrf AS codincirrf,
        rh27_codincidfgts AS codincfgts,
        rh27_codincidregime AS codinccprp,
        CASE
            WHEN rh27_tetoremun = \'t\' THEN \'4000566\'
            ELSE \'4000567\'
        END AS tetoremun,
        \'TABRUB1\' AS codidentpadrao,
     (SELECT r11_anousu||\'\'||r11_mesusu AS anofolha
      FROM cfpess
      ORDER BY r11_anousu DESC
      LIMIT 1), e991_rubricasesocial AS natrubr
 FROM rhrubricas
 INNER JOIN baserubricasesocial ON e991_rubricas = rh27_rubric
 AND e991_instit = rh27_instit
 INNER JOIN rubricasesocial ON e991_rubricasesocial = e990_sequencial
 WHERE rh27_pd IS NOT NULL
     AND rh27_codincidprev IS NOT NULL
     AND rh27_codincidirrf IS NOT NULL
     AND rh27_codincidfgts IS NOT NULL
     AND rh27_codincidregime IS NOT NULL
     AND rh27_rubric NOT IN (\'R978\')
     AND rh27_instit = fc_getsession(\'DB_instit\')::int' where db101_sequencial = 3000016;
        COMMIT;
SQL;
        $this->execute($sql);
    }
}
