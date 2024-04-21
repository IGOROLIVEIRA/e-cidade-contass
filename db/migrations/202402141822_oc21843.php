<?php

use ECidade\Suporte\Phinx\PostgresMigration;

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

              ALTER TABLE transferenciaveiculos DROP COLUMN ve80_hora;
            COMMIT;
          SQL;
    $this->execute($sql);
  }

  private function _run()
  {
    $sql = <<<SQL
        BEGIN;
          
          -- Insere campos no dicionário 
          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 'vehistmov_codigo', 'int8', 'Código Movimentação', '', 'Código Movimentação', 8, false, false, false, 1, 'text', 'Código Movimentação');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 'vehistmov_tipo', 'varchar(50)', 'Tipo Movimentação', '', 'Tipo Movimentação', 50, false, false, false, 1, 'text', 'Tipo Movimentação');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 'vehistmov_data', 'date', 'Data Movimentação', '', 'Data Movimentação', 10, false, false, false, 1, 'text', 'Data Movimentação');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 'vehistmov_horas', 'varchar(8)', 'Hora Movimentaçãoo', '', 'Hora Movimentação', 200, false, false, false, 1, 'text', 'Hora Movimentação');
          
          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 'vehistmov_usuario', 'varchar(100)', 'Usuário', '', 'Usuário', 4, false, false, false, 1, 'text', 'Usuário');

          -- Cria novo campo de horas
          ALTER TABLE transferenciaveiculos ADD COLUMN ve80_hora VARCHAR(5);

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've80_hora', 'varchar(5)', 'Hora', '', 'Hora', 4, false, false, false, 1, 'text', 'Hora');
        COMMIT;
        SQL;

    $this->execute($sql);
  }
}
