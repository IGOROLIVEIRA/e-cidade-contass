<?php

use Phinx\Migration\AbstractMigration;

class Oc20736 extends AbstractMigration
{
    public function up()
    {
        $sSql = 
            "
                BEGIN;
                --Cria o campo k02_descrjm na tabela tabrecjm no módulo caixa.
                ALTER TABLE tabrecjm ADD k02_descrjm varchar(40) NULL;
                --Inserção dos dados do campo na tabela db_syscampo no módulo configuracoes.
                INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES(2013000, 'k02_descrjm                             ', 'varchar(40)                             ', 'Descrição de juros e multa', '', 'Descrição de juros e multa', 40, NULL, true, false, 0, NULL, 'Descrição de juros e multa');
                --Alteração do sequencial do campo codcam da tabela db_syscampo.
                ALTER SEQUENCE db_syscampo_codcam_seq RESTART WITH 2013001;
                COMMIT;
            ";
        $this->execute($sSql);
    }
}
