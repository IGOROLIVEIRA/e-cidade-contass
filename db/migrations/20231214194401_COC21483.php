<?php

use Classes\PostgresMigration;

class AddTableVeiculosplaca extends PostgresMigration
{


  public function up()
  {
    $this->_run();
  }

  public function down()
  {
    $sql = "
            BEGIN;
              DROP TABLE IF EXISTS veiculos.veiculosplaca;
              DROP SEQUENCE IF EXISTS veiculos.veiculosplaca_ve76_sequencial_seq;
            COMMIT;
        ";
    $this->execute($sql);
  }

  private function _run()
  {
    $sql = "
        BEGIN;
          -- Cria itens de menu
          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alterac�o de Placa','Alterac�o de Placa','',1,1,'Alterac�o de Placa','t');
          INSERT INTO db_menu VALUES(5338,(select max(id_item) from db_itensmenu),9,633);
        
          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alterac�o','Alterac�o','vei1_alterarplaca002.php',1,1,'Alterac�o','t');
          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like 'Alterac�o de Placa'),(select max(id_item) from db_itensmenu),1,633);
        
          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclus�o','Exclus�o','vei1_alterarplaca003.php',1,1,'Exclus�o','t');
          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like 'Alterac�o de Placa'),(select max(id_item) from db_itensmenu),2,633);

          -- Altera o campo placa para 8 caracteres
          ALTER TABLE veiculos.veiculos ALTER COLUMN ve01_placa TYPE varchar(8);
          UPDATE db_syscampo SET conteudo = 'varchar(8)', tamanho = 8 WHERE nomecam = 've01_placa';

          -- Cria o sequencial da tablea
          CREATE SEQUENCE veiculos.veiculosplaca_ve76_sequencial_seq
              INCREMENT 1
              MINVALUE 1
              MAXVALUE 9223372036854775807
              START 1
              CACHE 1;

          -- Cria tabela
          CREATE TABLE veiculos.veiculosplaca (
              ve76_sequencial int8 NOT NULL DEFAULT nextval('veiculosplaca_ve76_sequencial_seq'),
              ve76_veiculo int4 NOT NULL,
              ve76_placa varchar(8) NOT NULL,
              ve76_placaanterior varchar(8),
              ve76_obs varchar(200),
              ve76_data date NOT NULL,
              ve76_usuario int4 NOT NULL,
              ve76_criadoem timestamp without time zone NOT NULL DEFAULT now(),
              PRIMARY KEY (ve76_sequencial),
              FOREIGN KEY (ve76_veiculo) REFERENCES veiculos.veiculos(ve01_codigo)
          );

          -- Insere campos no dicion�rio 
          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've76_sequencial', 'int8', 'Sequencial', '', 'C�digo', 8, false, false, false, 1, 'text', 'C�digo');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've76_veiculo', 'int4', 'C�digo Ve�culo', '', 'Ve�culo', 4, false, false, false, 1, 'text', 'Ve�culo');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've76_placa', 'varchar(8)', 'Placa', '', 'Placa Atual', 8, false, true, false, 0, 'text', 'Placa Atual');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've76_placaanterior', 'varchar(7)', 'Placa Anterior', '', 'Placa Anterior', 7, false, false, false, 1, 'text', 'Placa Anterior');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've76_obs', 'varchar(200)', 'Observa��o', '', 'Observa��o', 200, false, false, false, 1, 'text', 'Observa��o');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've76_data', 'date', 'Data', '', 'Data', 10, false, false, false, 1, 'text', 'Data');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've76_usuario', 'int4', 'Usu�rio', '', 'Usu�rio', 4, false, false, false, 1, 'text', 'Usu�rio');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've76_criadoem', 'timestamp without time zone', 'Criado em', '', 'Criado em', null, false, false, false, 1, 'text', 'Criado em');
        COMMIT;
        ";

    $this->execute($sql);
  }
}
