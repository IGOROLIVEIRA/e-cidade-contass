<?php

use Phinx\Migration\AbstractMigration;

class Oc21342 extends AbstractMigration
{
    public function up()
    {
     $sql = "BEGIN;
     
            UPDATE db_usuarios SET usuarioativo = 2 where login in ('amc.contass','guilherme.contass','mfs.contass','wanderson.alves','vfro.contass','cess.contass','crb.contass');
     
            COMMIT;";

     $this->execute($sql);

    }
    public function down()
    {
     $sql = "BEGIN;
     
            UPDATE db_usuarios SET usuarioativo = 1 where login in ('amc.contass','guilherme.contass','mfs.contass','wanderson.alves','vfro.contass','cess.contass','crb.contass');
     
            COMMIT;";

     $this->execute($sql);

    }
}
