<?php

use Phinx\Migration\AbstractMigration;

class Oc11654novoano extends AbstractMigration
{
    public function up()
    {
      $sql = <<<SQL
        
        BEGIN;
                
        INSERT INTO conplanoorcamento
        SELECT c60_codcon,
               2021 AS c60_anousu,
               c60_estrut,
               c60_descr,
               c60_finali,
               c60_codsis,
               c60_codcla,
               c60_consistemaconta,
               c60_identificadorfinanceiro,
               c60_naturezasaldo,
               c60_funcao
        FROM conplanoorcamento
        WHERE c60_estrut IN ('331901150000000', '331901152000000', '331951150000000', '331951152000000', '331961150000000', '331961152000000')
          AND c60_anousu = 2020;
                
        INSERT INTO conplanoorcamentoanalitica
        SELECT c61_codcon,
               2021 AS c61_anousu,
               c61_reduz,
               c61_instit,
               c61_codigo
        FROM conplanoorcamentoanalitica
        INNER JOIN conplanoorcamento ON (c60_anousu, c60_codcon) = (c61_anousu, c61_codcon)
        WHERE c60_estrut IN ('331901150000000', '331901152000000', '331951150000000', '331951152000000', '331961150000000', '331961152000000')
          AND c60_anousu = 2020;        
        
        INSERT INTO orcelemento
        SELECT o56_codele,
               2021 AS o56_anousu,
               o56_elemento,
               o56_descr,
               o56_finali,
               o56_orcado
        FROM orcelemento
        WHERE o56_elemento IN ('3319011500000', '3319011520000', '3319511500000', '3319511520000', '3319611500000', '3319611520000')
          AND o56_anousu = 2020;        
        
        UPDATE conplanoorcamento
        SET c60_descr = 'LICENCA SAUDE'
        WHERE c60_anousu >= 2020
          AND c60_estrut IN
        ('331901152000000', '331951152000000', '331961152000000');        
        
        UPDATE orcelemento
        SET o56_descr = 'LICENCA SAUDE'
        WHERE o56_anousu >= 2020
          AND o56_elemento IN
        ('3319011520000', '3319511520000', '3319611520000');
        
        COMMIT;

SQL;
      $this->execute($sql);

    }
}
