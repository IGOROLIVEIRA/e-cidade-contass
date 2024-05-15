<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc11340 extends PostgresMigration
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
        $table  = $this->table('rhdepend', array('schema' => 'pessoal'));
        $column = $table->hasColumn('rh31_cpf');

        if (!$column) {
            $table->addColumn('rh31_cpf', 'string', array('limit' => 11,'null' => true))
                  ->save();
            $aColumns = array('codcam',
                          'nomecam',
                          'conteudo',
                          'descricao',
                          'valorinicial',
                          'rotulo',
                          'tamanho',
                          'nulo',
                          'maiusculo',
                          'autocompl',
                          'aceitatipo',
                          'tipoobj',
                          'rotulorel'
                      );
            $codCam = $this->fetchRow("SELECT MAX(codcam)+1 AS codcam FROM db_syscampo");
            $aValues[] = array($codCam['codcam'],
                          'rh31_cpf',
                          'varchar(11)',
                          'CPF do Dependente',
                          '',
                          'CPF do Dependente',
                          '11',
                          't',
                          't',
                          't',
                          0,
                          'text',
                          'CPF do Dependente'
                      );
            $table  = $this->table('db_syscampo', array('schema' => 'configuracoes'));
            $table->insert($aColumns, $aValues)->saveData();
        }
    }

    public function down()
    {
        $table  = $this->table('rhdepend', array('schema' => 'pessoal'));
        $column = $table->hasColumn('rh31_cpf');

        if ($column) {
            $table->removeColumn('rh31_cpf')
                ->save();
            $sql = "DELETE FROM db_syscampo WHERE nomecam = 'rh31_cpf'";
            $this->execute($sql);
        }
    }
}
