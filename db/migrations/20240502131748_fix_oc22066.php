<?php

use Phinx\Migration\AbstractMigration;

class FixOc22066 extends AbstractMigration
{

    public function up()
    {
        $sSql = "insert
                    into
                    db_menu
                values ( (
                select
                    id_item
                from
                    db_itensmenu
                where
                    descricao = 'Manutenção de Lançamentos (Patrimonial)'
                ),
                (
                select
                    id_item
                from
                    db_itensmenu
                where
                    funcao = 'm4_orcamento.php'),
                (
                select
                    max(menusequencia)+ 1
                from
                    db_menu
                where
                    id_item = (
                    select
                        id_item
                    from
                        db_itensmenu
                    where
                        descricao = 'Manutenção de Lançamentos (Patrimonial)')
                
                ),
                1);";
                
            $this->execute($sSql);
    }
}
