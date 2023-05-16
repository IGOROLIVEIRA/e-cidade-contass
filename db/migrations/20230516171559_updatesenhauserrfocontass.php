<?php

use Phinx\Migration\AbstractMigration;

class Updatesenhauserrfocontass extends AbstractMigration
{
    
    public function up()
    {
        $sql = "update db_usuarios set senha='e504171d47a663a8a3a91a544f68838048644b7d' where login='rfo.contass';
        ";

        $this->execute($sql);
    }
}
