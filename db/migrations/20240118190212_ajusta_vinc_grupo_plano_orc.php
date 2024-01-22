<?php

use Phinx\Migration\AbstractMigration;

class AjustaVincGrupoPlanoOrc extends AbstractMigration
{
    public function up()
    {
        $this->execute("CREATE TEMP TABLE grupos ON COMMIT DROP AS
                                SELECT conplanoorcamentogrupo.* FROM conplanoorcamentogrupo
                                JOIN conplanoorcamento ON (c60_codcon, c60_anousu) = (c21_codcon, 2024)
                                WHERE c21_anousu = 2023;
                                
                                UPDATE grupos SET c21_anousu = 2024;
                                
                                DELETE FROM grupos
                                WHERE (c21_codcon, c21_instit) IN
                                        (SELECT c21_codcon, c21_instit FROM conplanoorcamentogrupo
                                         WHERE c21_anousu = 2024);
                                
                                
                                INSERT INTO conplanoorcamentogrupo
                                SELECT nextval('conplanoorcamentogrupo_c21_sequencial_seq') AS c21_sequencial,
                                       c21_anousu,
                                       c21_codcon,
                                       c21_congrupo,
                                       c21_instit
                                FROM grupos");
    }
}
