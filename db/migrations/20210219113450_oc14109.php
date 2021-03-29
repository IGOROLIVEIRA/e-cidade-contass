<?php

use Phinx\Migration\AbstractMigration;

class Oc14109 extends AbstractMigration
{
    public function up(){
        $sql = "
                BEGIN;

                SELECT fc_startsession();
                
                ALTER TABLE acordo ADD COLUMN ac16_providencia integer;
                
                CREATE TABLE providencia(codigo integer PRIMARY KEY, descricao varchar(20));
                
                INSERT INTO providencia(codigo, descricao)
                VALUES (1, 'Finalizado'),
                       (2, 'Aditado');

                ALTER TABLE parametroscontratos ADD COLUMN pc01_liberargerenciamentocontratos boolean DEFAULT FALSE;                       

                INSERT INTO db_syscampo(codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                    VALUES(
                        (SELECT max(codcam)+1 FROM db_syscampo),
                        'pc01_liberargerenciamentocontratos',
                        'bool',
                        'Liberar gerenciamento de contratos',
                        'f',
                        'Liberar gerenciamento de contratos',
                        1,
                        'f',
                        'f',
                        'f',
                        5,
                        'text',
                        'Liberar gerenciamento');
                        
                COMMIT;
        ";

        $this->execute($sql);

    }

    public function down(){
        $sql = "
                BEGIN;

                SELECT fc_startsession();
                
                DROP TABLE providencia;

                ALTER TABLE acordo DROP COLUMN ac16_providencia;

                ALTER TABLE parametroscontratos DROP COLUMN pc01_liberargerenciamentocontratos;

                DELETE FROM db_syscampo WHERE rotulo = 'Liberar gerenciamento de contratos';

                COMMIT;
        ";

        $this->execute($sql);
        
    }
}
