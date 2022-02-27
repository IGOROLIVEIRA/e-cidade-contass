<?php

use Phinx\Migration\AbstractMigration;

class S2206 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        UPDATE configuracoes.db_itensmenu SET funcao='con4_manutencaoformulario001.php?esocial=39' WHERE descricao ilike 'S-2206%';

        UPDATE habitacao.avaliacaopergunta
        SET db103_camposql='tpinscestab'
        WHERE db103_sequencial=4000757;


        UPDATE habitacao.avaliacaopergunta
            SET db103_camposql='nrinscestab'
            WHERE db103_sequencial=4000758;

        update
                avaliacaopergunta
            set
                db103_avaliacaotiporesposta = 2
            where
                db103_sequencial in (4000760,4000748,4000767);

        delete from avaliacaoperguntaopcao where db104_avaliacaopergunta in (4000760,4000748,4000767);

        insert into avaliacaoperguntaopcao( db104_sequencial ,db104_avaliacaopergunta ,db104_descricao ,db104_identificador ,db104_aceitatexto ,db104_peso ,db104_identificadorcampo ,db104_valorresposta ) values ( 15 ,4000767 ,'' ,'uf-15' ,'true' ,0 ,'uf' ,'' );

SQL;
        $this->execute($sql);
    }
}
