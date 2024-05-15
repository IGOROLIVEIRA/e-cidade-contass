<?php

use Phinx\Migration\AbstractMigration;

class Oc20998 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        begin;
        CREATE TABLE tipomanubem (
            t100_codigo int8,
            t100_descr varchar(100)
        );
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 't100_codigo','int8' ,'Sequencial','', 'Sequencial'             ,11,false, false, false, 1, 'int8', 'Sequencial');
        INSERT INTO configuracoes.db_syscampo VALUES ((select max(codcam)+1 from configuracoes.db_syscampo), 't100_descr','varchar' ,'Tipo Manutenção','', 'Tipo Manutenção'    ,11,false, false, false, 1, 'varchar', 'Tipo Manutenção');

        INSERT INTO tipomanubem (t100_codigo,t100_descr) VALUES (1,'Acréscimo de Valor');
        INSERT INTO tipomanubem (t100_codigo,t100_descr) VALUES (2,'Decréscimo de Valor');
        INSERT INTO tipomanubem (t100_codigo,t100_descr) VALUES (3,'Adição de Componente');
        INSERT INTO tipomanubem (t100_codigo,t100_descr) VALUES (4,'Remoção de Componente');
        INSERT INTO tipomanubem (t100_codigo,t100_descr) VALUES (5,'Manutenção de Imovel');

        ALTER TABLE bemmanutencao
        ADD CONSTRAINT fk_usuario_id
        FOREIGN KEY (t98_idusuario)
        REFERENCES configuracoes.db_usuarios (id_usuario);

        ALTER TABLE tipomanubem ADD PRIMARY KEY (t100_codigo);

        ALTER TABLE bemmanutencao
        ADD CONSTRAINT fk_tipomanutbem_id
        FOREIGN KEY (t98_tipo)
        REFERENCES tipomanubem (t100_codigo);
        commit;
        ";
        $this->execute($sql);
    }
}
