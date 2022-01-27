<?php

use Phinx\Migration\AbstractMigration;

class Menuscargadedados extends AbstractMigration
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
        BEGIN;
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Eventos Iniciais e de tabelas','Carga de dados Eventos Iniciais e de tabelas','con4_cargaformularioseventosiniciaisetabelas.php',1,1,'Eventos Iniciais e de tabelas','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao = 'Carga de Dados'),(select max(id_item) from db_itensmenu),1,10216);
            
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),'Periodicos','Carga de dados Periodicos','con4_cargaformularioseventosperiodicos.php',1,1,'Periodicos','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao = 'Carga de Dados'),(select max(id_item) from db_itensmenu),2,10216);
        COMMIT;
        ";
        $this->execute($sql);
    }
}
