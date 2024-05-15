<?php

use Phinx\Migration\AbstractMigration;

class Oc17258 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        
        select fc_startsession();

        BEGIN;

        ALTER TABLE hablic102022 ALTER COLUMN si57_presencalicitantes DROP NOT NULL;
        ALTER TABLE hablic102022 ALTER COLUMN si57_presencalicitantes DROP DEFAULT;
        ALTER TABLE hablic102022 ALTER COLUMN si57_renunciarecurso DROP NOT NULL;
        ALTER TABLE hablic102022 ALTER COLUMN si57_renunciarecurso DROP DEFAULT;
        
        ALTER TABLE julglic402022 ALTER COLUMN si62_presencalicitantes DROP NOT NULL;
        ALTER TABLE julglic402022 ALTER COLUMN si62_presencalicitantes DROP DEFAULT;
        ALTER TABLE julglic402022 ALTER COLUMN si62_renunciarecurso DROP NOT NULL;
        ALTER TABLE julglic402022 ALTER COLUMN si62_renunciarecurso DROP DEFAULT;

        ALTER TABLE resplic202022 ALTER COLUMN si56_codtipocomissao DROP NOT NULL;
        ALTER TABLE resplic202022 ALTER COLUMN si56_codtipocomissao DROP DEFAULT;
        
        COMMIT;
        
        ";

        $this->execute($sql);
    }

    public function down()
    {
    }
}
