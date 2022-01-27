<?php

use Phinx\Migration\AbstractMigration;

class AlterarMenusEventosIniciais extends AbstractMigration
{
    public function up()
    {
        $sSql = "
        UPDATE db_itensmenu SET descricao = 'S-1010 - Tabela de Rubricas' WHERE descricao ilike '%s1010';
        UPDATE db_itensmenu SET descricao = 'S-1020 - Tabela de Lotações Tributárias' WHERE descricao ilike '%s1020';
        UPDATE db_itensmenu SET descricao = 'S-1070 - Tabela de Processos Administrativos/Judiciais' WHERE descricao ilike '%s1070';

        UPDATE db_itensmenu SET itemativo = 0 WHERE descricao ilike '%s1030' OR descricao ilike '%s1035' OR descricao ilike '%s1040' OR descricao ilike '%s1050'
        OR descricao ilike '%s1060' OR descricao ilike '%s1080';
        ";

        $this->execute($sSql);
    }

    public function down()
    {
        $sSql = "
        UPDATE db_itensmenu SET descricao = 'Tabela de Rubricas - S1010' WHERE descricao ilike 's-1010%';
        UPDATE db_itensmenu SET descricao = 'Tabela de Lotação Tributária - S1020' WHERE descricao ilike 's-1020%';
        UPDATE db_itensmenu SET descricao = 'Tabela de Processos Administrativos/Judiciais - S1070' WHERE descricao ilike 's-1070%';

        UPDATE db_itensmenu SET itemativo = 1 WHERE descricao ilike '%s1030' OR descricao ilike '%s1035' OR descricao ilike '%s1040' OR descricao ilike '%s1050'
        OR descricao ilike '%s1060' OR descricao ilike '%s1080';
        ";

        $this->execute($sSql);
    }

}
