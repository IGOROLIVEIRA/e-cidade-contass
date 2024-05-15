<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class FixOc22066 extends PostgresMigration
{

    public function up()
    {
        $sSql = "insert
                    into
                    configuracoes.db_menu
                values ( (
                select
                    id_item
                from
                    configuracoes.db_itensmenu
                where
                    descricao = 'Manutenção de Lançamentos (Patrimonial)'
                ),
                (
                select
                    id_item
                from
                    configuracoes.db_itensmenu
                where
                    funcao = 'm4_orcamento.php'),
                (
                select
                    max(menusequencia)+ 1
                from
                    configuracoes.db_menu
                where
                    id_item = (
                    select
                        id_item
                    from
                        configuracoes.db_itensmenu
                    where
                        descricao = 'Manutenção de Lançamentos (Patrimonial)')

                ),
                1);";

            $this->execute($sSql);
    }
}
