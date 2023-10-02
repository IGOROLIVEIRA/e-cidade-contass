<?php

use Phinx\Migration\AbstractMigration;

class Hotfixoc19911 extends AbstractMigration
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
        $existe = $this->fetchAll("select column_name from information_schema.columns where table_name ='itemprecoreferencia' and column_name = 'si02_vltotalprecoreferencia'");
        if(empty($existe)){

            $sql = "Begin;
    
            ALTER TABLE itemprecoreferencia ADD si02_vltotalprecoreferencia float;
    
            UPDATE itemprecoreferencia SET si02_vltotalprecoreferencia = (si02_vlprecoreferencia * si02_qtditem) WHERE si02_tabela = 'f' AND si02_taxa = 'f';
            
            UPDATE itemprecoreferencia SET si02_vltotalprecoreferencia = si02_vlprecoreferencia WHERE si02_tabela = 't' OR si02_taxa = 't';
    
            CREATE TABLE precoreferenciaacount(
            si233_sequencial                int8  default 0,
            si233_precoreferencia           int8  default 0,
            si233_acao              varchar(50) NOT NULL ,
            si233_idusuario         int8  default 0,
            si233_datahr            date);
    
            CREATE SEQUENCE precoreferenciaacount_si233_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
            
            commit;";
    
            $this->execute($sql);

        }

    }
}
