<?php

use Classes\PostgresMigration;

class Oc21843 extends PostgresMigration
{


  public function up()
  {
    $this->_run();
  }

  public function down()
  {
    $sql = <<<SQL
            BEGIN;
              DELETE FROM db_syscampo WHERE nomecam = 'vehistmov_codigo';
              DELETE FROM db_syscampo WHERE nomecam = 'vehistmov_tipo';
              DELETE FROM db_syscampo WHERE nomecam = 'vehistmov_data';
              DELETE FROM db_syscampo WHERE nomecam = 'vehistmov_horas';
              DELETE FROM db_syscampo WHERE nomecam = 'vehistmov_usuario';
            COMMIT;
          SQL;
    $this->execute($sql);
  }

  private function _run()
  {
    $sql = <<<SQL
        BEGIN;
          
          -- Insere campos no dicion�rio 
          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 'vehistmov_codigo', 'int8', 'C�digo Movimenta��o', '', 'C�digo Movimenta��o', 8, false, false, false, 1, 'text', 'C�digo Movimenta��o');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 'vehistmov_tipo', 'varchar(50)', 'Tipo Movimenta��o', '', 'Tipo Movimenta��o', 50, false, false, false, 1, 'text', 'Tipo Movimenta��o');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 'vehistmov_data', 'date', 'Data Movimenta��o', '', 'Data Movimenta��o', 10, false, false, false, 1, 'text', 'Data Movimenta��o');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 'vehistmov_horas', 'varchar(8)', 'Hora Movimenta��oo', '', 'Hora Movimenta��o', 200, false, false, false, 1, 'text', 'Hora Movimenta��o');
          
          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 'vehistmov_usuario', 'varchar(100)', 'Usu�rio', '', 'Usu�rio', 4, false, false, false, 1, 'text', 'Usu�rio');
        COMMIT;
        SQL;

    $this->execute($sql);
  }
}
