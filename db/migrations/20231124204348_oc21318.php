<?php

use Phinx\Migration\AbstractMigration;

class Oc21318 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

       INSERT INTO retencaotipocalc VALUES(10,'INSS Produção Rural');
       INSERT INTO retencaotipocalc VALUES(11,'GILRAT Produção Rural');
       INSERT INTO retencaotipocalc VALUES(12,'SENAR');
         
    COMMIT; 

SQL;
        $this->execute($sql);
    } 
}