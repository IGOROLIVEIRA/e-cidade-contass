<?php

use Classes\PostgresMigration;

class Oc11017 extends PostgresMigration
{

    public function up()
    {
        $table  = $this->table('inssirf', array('schema' => 'pessoal'));
        $table->addColumn('rh31_novocalculo', 'boolean', array('default' => 'f'))
              ->save();
        $this->inserirDicionarioDados();

    }

    public function down()
    {
        $table  = $this->table('inssirf', array('schema' => 'pessoal'));
        $table->removeColumn('rh31_novocalculo')
              ->save();
        $codCam = $this->fetchRow("SELECT codcam FROM db_syscampo WHERE nomecam = 'rh31_novocalculo'")['codcam'];
        $sql = "DELETE FROM db_sysarqcamp WHERE codcam = {$codCam}";
        $this->execute($sql);
        $sql = "DELETE FROM db_syscampo WHERE codcam = {$codCam}";
        $this->execute($sql);
    }

    private function inserirDicionarioDados()
    {
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
            $aValues[0] = array($codCam['codcam'],
                          'rh31_novocalculo',
                          'bool',
                          'Novo Calculo EC nº 103/2019',
                          'f',
                          'Novo Calculo EC nº 103/2019',
                          '1',
                          'f',
                          'f',
                          'f',
                          5,
                          'text',
                          'Novo Calculo EC nº 103/2019'
                      );
            $table  = $this->table('db_syscampo', array('schema' => 'configuracoes'));
            $table->insert($aColumns, $aValues)->saveData();

            $aColumns = array('codarq',
                          'codcam',
                          'seqarq',
                          'codsequencia'
                      );
            $aValues[0] = array(561,
                          $codCam['codcam'],
                          20,
                          0
                      );
            $table  = $this->table('db_sysarqcamp', array('schema' => 'configuracoes'));
            $table->insert($aColumns, $aValues)->saveData();
    }
}
