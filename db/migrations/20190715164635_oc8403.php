<?php

use Phinx\Migration\AbstractMigration;

class Oc8403 extends AbstractMigration
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
        $sSql = "
                 SELECT fc_startsession();
                  
                 INSERT INTO empanuladotipo (e38_sequencial, e38_descr)
                 VALUES  (0, 'Selecione...'),
                         (3, 'FIM DA VIGENCIA CONTRATUAL'),
                         (4, 'FIM DO EXERCICIO FINANCEIRO'),
                         (5, 'RESCISAO CONTRATUAL');
                 ALTER TABLE empparametro ADD COLUMN e30_tipoanulacaopadrao INTEGER DEFAULT 2;
                 
                 ALTER TABLE empparametro ADD FOREIGN KEY (e30_tipoanulacaopadrao) REFERENCES empanuladotipo(e38_sequencial);";

        $this->execute($sSql);
    }
}
