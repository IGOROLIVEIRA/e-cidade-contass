<?php

use Phinx\Migration\AbstractMigration;

class Oc20998 extends AbstractMigration
{
  
    public function up()
    {
        $sql = "
        begin;
        CREATE TABLE tipomanutbem(
            t100_codigo int8,
            t100_descr varchar(100),
            t100_usuario int8
        );
        INSERT INTO tipomanutbem (t100_codigo,t100_descr) VALUES (1,'Acr�scimo de Valor');
        INSERT INTO tipomanutbem (t100_codigo,t100_descr) VALUES (2,'Decr�scimo de Valor');
        INSERT INTO tipomanutbem (t100_codigo,t100_descr) VALUES (3,'Adi��o de Componente');
        INSERT INTO tipomanutbem (t100_codigo,t100_descr) VALUES (4,'Remo��o de Componente');
        INSERT INTO tipomanutbem (t100_codigo,t100_descr) VALUES (5,'Manuten��o de Imovel');

        ALTER TABLE tipomanutbem
        ADD CONSTRAINT fk_usuario_id
        FOREIGN KEY (t100_usuario)
        REFERENCES db_usuarios (id_usuario);
        commit;
        ";
        $this->execute($sql);
    }
}
