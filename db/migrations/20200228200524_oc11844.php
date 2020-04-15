<?php

use Classes\PostgresMigration;

class Oc11844 extends PostgresMigration
{   
    public function up()
    {
        $table  = $this->table('rhpessoalmov', array('schema' => 'pessoal'));
        $table->addColumn('rh02_desctipoparentescoinst', 'text', array('null' => true))
                  ->save();

        $codCam = $this->fetchRow("SELECT MAX(codcam)+1 AS codcam FROM db_syscampo");
            
        $this->insertDbSysCampo($codCam['codcam']);
        $this->insertDbSysArqCamp($codCam['codcam']);
    }

    public function down()
    {
        $table  = $this->table('rhpessoalmov', array('schema' => 'pessoal'));
        $table->removeColumn('rh02_desctipoparentescoinst')
                ->save();

        $codCam = $this->fetchRow("SELECT codcam FROM db_syscampo WHERE nomecam = 'rh02_desctipoparentescoinst'");

        $this->deleteDbSysArqCamp($codCam['codcam']);
        $this->deleteDbSysCampo($codCam['codcam']);
    }

    private function insertDbSysCampo($codCam) {
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

        $aValues[] = array($codCam,
                      'rh02_desctipoparentescoinst',
                      'text',
                      'Descrição Tipo do Parentesco',
                      '',
                      'Descrição Tipo do Parentesco',
                      '500',
                      't',
                      'f',
                      'f',
                      0,
                      'text',
                      'Descrição Tipo do Parentesco'
                  );
        $table  = $this->table('db_syscampo', array('schema' => 'configuracoes'));
        $table->insert($aColumns, $aValues)->saveData();
    }

    private function insertDbSysArqCamp($codCam) {
        $aColumns = array('codarq',
                          'codcam',
                          'seqarq',
                          'codsequencia'
                      );
        $aValues[] = array(1158,
                      $codCam,
                      100,
                      0
                  );
        $table  = $this->table('db_sysarqcamp', array('schema' => 'configuracoes'));
        $table->insert($aColumns, $aValues)->saveData();
    }

    private function deleteDbSysArqCamp($codCam) {
        $sql = "DELETE FROM db_sysarqcamp WHERE codcam = {$codCam}";
        $this->execute($sql);
    }

    private function deleteDbSysCampo($codCam) {
        $sql = "DELETE FROM db_syscampo WHERE codcam = {$codCam}";
        $this->execute($sql);
    }
}
