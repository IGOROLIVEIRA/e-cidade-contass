<?php

use Phinx\Migration\AbstractMigration;

class AlterarElementosRubricas2023 extends AbstractMigration
{

    public function up()
    {
        /**
         * Outros -> Salário Contrato Temporário 
         */
        $sql = " UPDATE rhrubelemento SET rh23_codele = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh23_codele IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004990000'); ";

        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Salário Contrato Temporário 
         */
        $sql .= " UPDATE rhrubelemento SET rh23_codele = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh23_codele IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020000'); ";

        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Salário Contrato Temporário 
         */
        $sql .= " UPDATE rhrubelemento SET rh23_codele = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh23_codele IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020100'); ";

        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Salário Contrato Temporário 
         */
        $sql .= " UPDATE rhrubelemento SET rh23_codele = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh23_codele IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020200'); ";

        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Vencimentos e Salários - RPPS 
         */
        $sql .= " UPDATE rhrubelemento SET rh23_codele = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1)
        WHERE rh23_codele IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020000' LIMIT 1); ";


        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Vencimentos e Salários - RPPS 
         */
        $sql .= " UPDATE rhrubelemento SET rh23_codele = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010100' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh23_codele IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020100' LIMIT 1); ";

        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Vencimentos e Salários - RPPS 
         */
        $sql .= " UPDATE rhrubelemento SET rh23_codele = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh23_codele IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020200' LIMIT 1); ";

        /**
         * Pessoal de Cargo Efetivo (Vinculado ao RPPS), exceto FUNDEB  -> Vencimentos e Salários - RPPS 
         */
        $sql .= " UPDATE rhrubelemento SET rh23_codele = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010100' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh23_codele IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011030000' LIMIT 1); ";

        /**
         * Pessoal de Cargo Efetivo (Vinculado ao INSS), exceto FUNDEB, exceto FUNDEB  -> Vencimentos e Salários - RPPS 
         */
        $sql .= " UPDATE rhrubelemento SET rh23_codele = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh23_codele IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011040000' LIMIT 1); ";

        /**
         * Pessoal de Cargo Comissionado, exceto FUNDEB  -> Vencimentos e Salários - RGPS 
         */
        $sql .= " UPDATE rhrubelemento SET rh23_codele = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh23_codele IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011050000' LIMIT 1); ";


        $this->execute($sql);
    }

    public function down()
    {

    }
}
