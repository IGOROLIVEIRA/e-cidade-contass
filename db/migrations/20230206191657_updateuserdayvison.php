<?php

use Phinx\Migration\AbstractMigration;

class Updateuserdayvison extends AbstractMigration
{
     
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

    update db_usuarios set senha='007d12af4b33a9002ab21527a29ce08f455270f1' where login = 'dayvison.contass';    

    COMMIT;

SQL;
        $this->execute($sql);
    } 
}