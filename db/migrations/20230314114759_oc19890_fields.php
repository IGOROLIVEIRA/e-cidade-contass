<?php

use Phinx\Migration\AbstractMigration;

class Oc19890Fields extends AbstractMigration
{
    public function up()
    {
        $sql =  "ALTER TABLE bodcasp302022 RENAME COLUMN si203_vlamortizaoutrasdivinter TO si203_vlamortizadividacontratualinternas;";
        $sql .= "ALTER TABLE bodcasp302022 RENAME COLUMN si203_vlamortizaoutrasdivext TO si203_vlamortizadividacontratualexternas;";

        $this->execute($sql);
    }
}
