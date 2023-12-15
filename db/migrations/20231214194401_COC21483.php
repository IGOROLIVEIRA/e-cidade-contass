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
          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteracão de Placa','Alteracão de Placa','',1,1,'Alteracão de Placa','t');
          INSERT INTO db_menu VALUES(5338,(select max(id_item) from db_itensmenu),9,633);
        
          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Alteracão','Alteracão','vei1_alterarplaca002.php',1,1,'Alteracão','t');
          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like 'Alteracão de Placa'),(select max(id_item) from db_itensmenu),1,633);
        
          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Exclusão','Exclusão','vei1_alterarplaca003.php',1,1,'Exclusão','t');
          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like 'Alteracão de Placa'),(select max(id_item) from db_itensmenu),2,633);

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
              ve76_placa varchar(7) NOT NULL,
              ve76_placaanterior varchar(7),
              ve76_obs varchar(200),
              ve76_data date NOT NULL,
              ve76_usuario int4 NOT NULL,
              ve76_criadoem timestamp without time zone NOT NULL DEFAULT now(),
              PRIMARY KEY (ve76_sequencial)
          );
        COMMIT;
        ";

    $this->execute($sql);
  }
}
