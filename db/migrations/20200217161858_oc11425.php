<?php

use Phinx\Migration\AbstractMigration;

class Oc11425 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL

        ALTER TABLE bpdcasp102019 DROP COLUMN si208_vlativonaocircucredilongoprazo;
        ALTER TABLE bpdcasp102019 DROP COLUMN si208_vlativonaocircuinvestemplongpraz;
        ALTER TABLE bpdcasp102019 DROP COLUMN si208_vlativonaocircuestoques;
        ALTER TABLE bpdcasp102019 DROP COLUMN si208_vlativonaocircuvpdantecipada;
        
        ALTER TABLE bpdcasp102019 DROP COLUMN si208_vlativonaocircurlp type ;

SQL;
        $this->execute($sql);
    }
}
