<?php

use Phinx\Migration\AbstractMigration;

class Oc21031 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            begin;
                insert into amparolegal values (137, 'Lei 13.979/2020, Art. 4�, � 1�');
                insert into amparolegal values (138, 'Lei 11.947/2009, Art. 14, 1�');
                insert into amparolegal values (139, 'Lei 11.947/2009, Art. 21');
                insert into amparolegal values (140, 'Lei 14.133/2021, Art. 79, I');
                insert into amparolegal values (141, 'Lei 14.133/2021, Art. 79, II');
                insert into amparolegal values (142, 'Lei 14.133/2021, Art. 79, III');
            commit;
        ";
        $this->execute($sql);
    }
}
