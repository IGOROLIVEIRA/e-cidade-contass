<?php

use Phinx\Migration\AbstractMigration;

class Eventos1010 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
        BEGIN;

        UPDATE avaliacaopergunta
        SET db103_camposql = LOWER(db103_identificadorcampo)
        WHERE db103_avaliacaogrupopergunta = 3000217;
        

        update avaliacao set db101_cargadados = 'SELECT rh27_rubric AS codigorubrica,
        rh27_instit AS instituicao,
        rh27_descr AS dscRubr,
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
        END AS tpRubr,
        rh27_codincidprev AS codIncCP,
        rh27_codincidirrf AS codIncIRRF,
        rh27_codincidfgts AS codIncFGTS,
        rh27_codincidregime AS codIncCPRP,
        CASE
            WHEN rh27_tetoremun = \'t\' THEN \'4000566\'
            ELSE \'4000567\'
        END AS tetoRemun,
        \'tabrub1\' AS codIncIRRF,
     (SELECT r11_anousu||\'\'||r11_mesusu AS anofolha
      FROM cfpess
      ORDER BY r11_anousu DESC
      LIMIT 1), e991_rubricasesocial AS natRubr
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
