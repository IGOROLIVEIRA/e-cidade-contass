<?php

use Phinx\Migration\AbstractMigration;

class Fixoc19535 extends AbstractMigration
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
        $sql = "
        select fc_startsession();
        
        begin;
        
        alter table rhpessoal add column rh01_esocial char(30);
        
        insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'rh01_esocial', 'char(30)', 'Matricula do Servidor Esocial',0,'Matricula do Servidor Esocial',30,'f','f','f',1,'text','Matricula Esocial');
        
        commit;";
    
        $this->execute($sql);
    }
}
