<?php

use Phinx\Migration\AbstractMigration;

class Oc14284 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sSql = <<<SQL
         BEGIN;

        ALTER TABLE matparaminstit ADD COLUMN m10_consumo_imediato boolean;
        INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'm10_consumo_imediato'	 		,'boolean' ,'Consumo imediato automático'			,'', 'Consumo imediato automático'			 ,11	,false, false, false, 1, 'boolean', 'Consumo imediato automático');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'm10_consumo_imediato')		 	, 1, 0);

        COMMIT;
        SQL;
        $this->execute($sSql);
    }
}
