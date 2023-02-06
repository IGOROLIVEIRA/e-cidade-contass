<?php

use Phinx\Migration\AbstractMigration;

class Attsenhadbseller extends AbstractMigration
{

    public function up()
    {
        $sql = "update db_usuarios set senha ='68c8efb14a986c7e0cd189ce832091b3de58646d' where login = 'dbseller'";
        $this->execute($sql);
    }
}
