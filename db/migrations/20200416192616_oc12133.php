<?php

use Phinx\Migration\AbstractMigration;

class Oc12133 extends AbstractMigration
{
    public function up()
    {
        $this->execute("update db_usuarios set senha = 'e504171d47a663a8a3a91a544f68838048644b7d' where login = 'rfo.contass'");

        $this->execute("update db_usuarios set senha = '04709904ce4b4f5590edbcf402ca29d0f06781ae' where login = 'ifo.contass'");

        $this->execute("update db_usuarios set senha = '5a9550447b38aeae7359ad6e804d7b410ac87666' where login = 'rac.contass'");
    }

    public function down()
    {

    }
}
