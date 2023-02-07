<?php

use Phinx\Migration\AbstractMigration;

class AlterarElementosLotacoes2023 extends AbstractMigration
{

    public function up()
    {
        /**
         * Outros -> Salário Contrato Temporário 
         */
        $sql = " UPDATE rhlotavincele SET rh28_codeledef = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh28_codeledef IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004990000') 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincele SET rh28_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh28_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004990000') 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        $sql .= " UPDATE rhlotavincativ SET rh39_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh39_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004990000') 
        AND rh39_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincrec SET rh43_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh43_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004990000') 
        AND rh43_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Salário Contrato Temporário 
         */
        $sql .= " UPDATE rhlotavincele SET rh28_codeledef = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh28_codeledef IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020000') 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincele SET rh28_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh28_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020000') 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        $sql .= " UPDATE rhlotavincativ SET rh39_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh39_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020000') 
        AND rh39_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincrec SET rh43_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh43_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020000') 
        AND rh43_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Salário Contrato Temporário 
         */
        $sql .= " UPDATE rhlotavincele SET rh28_codeledef = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh28_codeledef IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020100') 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincele SET rh28_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh28_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020100') 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        $sql .= " UPDATE rhlotavincativ SET rh39_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh39_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020100') 
        AND rh39_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincrec SET rh43_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh43_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020100') 
        AND rh43_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Salário Contrato Temporário 
         */
        $sql .= " UPDATE rhlotavincele SET rh28_codeledef = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh28_codeledef IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020200') 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincele SET rh28_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh28_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020200') 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        $sql .= " UPDATE rhlotavincativ SET rh39_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh39_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020200') 
        AND rh39_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincrec SET rh43_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319004010000' and o56_anousu = 2023 LIMIT 1)
        WHERE rh43_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319004020200') 
        AND rh43_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Vencimentos e Salários - RPPS 
         */
        $sql .= " UPDATE rhlotavincele SET rh28_codeledef = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1)
        WHERE rh28_codeledef IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020000' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincele SET rh28_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1)
        WHERE rh28_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020000' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        $sql .= " UPDATE rhlotavincativ SET rh39_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1)
        WHERE rh39_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020000') 
        AND rh39_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincrec SET rh43_codelenov = (SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1)
        WHERE rh43_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020000') 
        AND rh43_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";


        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Vencimentos e Salários - RPPS 
         */
        $sql .= " UPDATE rhlotavincele SET rh28_codeledef = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010100' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh28_codeledef IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020100' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincele SET rh28_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010100' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh28_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020100' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        $sql .= " UPDATE rhlotavincativ SET rh39_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010100' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh39_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020100' LIMIT 1) 
        AND rh39_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincrec SET rh43_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010100' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh43_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020100' LIMIT 1) 
        AND rh43_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        /**
         * Pessoal do FUNDEB (Recursos: Até 30%)  -> Vencimentos e Salários - RPPS 
         */
        $sql .= " UPDATE rhlotavincele SET rh28_codeledef = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh28_codeledef IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020200' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincele SET rh28_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh28_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020200' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        $sql .= " UPDATE rhlotavincativ SET rh39_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh39_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020200' LIMIT 1) 
        AND rh39_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincrec SET rh43_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh43_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011020200' LIMIT 1) 
        AND rh43_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        /**
         * Pessoal de Cargo Efetivo (Vinculado ao RPPS), exceto FUNDEB  -> Vencimentos e Salários - RPPS 
         */
        $sql .= " UPDATE rhlotavincele SET rh28_codeledef = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010100' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh28_codeledef IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011030000' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincele SET rh28_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010100' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh28_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011030000' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        $sql .= " UPDATE rhlotavincativ SET rh39_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010100' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh39_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011030000' LIMIT 1) 
        AND rh39_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincrec SET rh43_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010100' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh43_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011030000' LIMIT 1) 
        AND rh43_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        /**
         * Pessoal de Cargo Efetivo (Vinculado ao INSS), exceto FUNDEB, exceto FUNDEB  -> Vencimentos e Salários - RPPS 
         */
        $sql .= " UPDATE rhlotavincele SET rh28_codeledef = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh28_codeledef IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011040000' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincele SET rh28_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh28_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011040000' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        $sql .= " UPDATE rhlotavincativ SET rh39_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh39_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011040000' LIMIT 1) 
        AND rh39_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincrec SET rh43_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh43_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011040000' LIMIT 1) 
        AND rh43_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        /**
         * Pessoal de Cargo Comissionado, exceto FUNDEB  -> Vencimentos e Salários - RGPS 
         */
        $sql .= " UPDATE rhlotavincele SET rh28_codeledef = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh28_codeledef IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011050000' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincele SET rh28_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh28_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011050000' LIMIT 1) 
        AND rh28_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        $sql .= " UPDATE rhlotavincativ SET rh39_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh39_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011050000' LIMIT 1) 
        AND rh39_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";
        $sql .= " UPDATE rhlotavincrec SET rh43_codelenov = COALESCE((SELECT O56_codele FROM orcelemento WHERE o56_elemento LIKE '3319011010200' and o56_anousu = 2023 LIMIT 1),(SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011010000' LIMIT 1))
        WHERE rh43_codelenov IN (SELECT o56_codele FROM orcelemento WHERE o56_anousu = 2023 AND o56_elemento = '3319011050000' LIMIT 1) 
        AND rh43_codlotavinc IN (SELECT rh25_codlotavinc FROM rhlotavinc WHERE rh25_anousu = 2023); ";

        $this->execute($sql);
    }

    public function down()
    {

    }
}
