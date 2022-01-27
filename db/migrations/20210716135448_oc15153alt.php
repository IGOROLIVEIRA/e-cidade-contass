<?php

use Phinx\Migration\AbstractMigration;

class Oc15153alt extends AbstractMigration
{
    public function up()
    {
        $sql = "UPDATE db_estruturavalor SEt db121_descricao = replace(db121_descricao,'INDIVIDUAIS -','-') WHERE db121_estrutural IN ('164','264');";
        $this->execute($sql);
    }
}
