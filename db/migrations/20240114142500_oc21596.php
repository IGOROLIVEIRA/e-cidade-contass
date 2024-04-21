<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc21596 extends PostgresMigration
{


  public function up()
  {
    $this->_run();
  }

  public function down()
  {
    $sql = <<<SQL
            BEGIN;
              DROP TABLE IF EXISTS veiculos.veicreativar;
              DROP SEQUENCE IF EXISTS veiculos.veicreativar_ve82_sequencial_seq;
            COMMIT;
          SQL;
    $this->execute($sql);
  }

  private function _run()
  {
    $sql = <<<SQL
        BEGIN;
          -- Cria itens de menu
          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Reativação de Veículos','Reativação de Veículos','vei1_veicbaixa002.php',1,1,'Reativação de Veículos','t');
          INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like 'Baixa de Veículos'),(select max(id_item) from db_itensmenu),201,633);
         
          -- INSERE db_sysarquivo
          INSERT INTO db_sysarquivo VALUES((SELECT max(codarq)+1 FROM db_sysarquivo), 'veicreativacao', 'Veículos Reativados', 've82', '2024-01-14', 'Reativação de Veículos', 0, 'f', 'f', 'f', 'f');

          -- INSERE db_sysarqmod
          INSERT INTO db_sysarqmod (codmod, codarq) VALUES ((SELECT codmod FROM db_sysmodulo WHERE nomemod LIKE 'veiculos%' and ativo=true), (SELECT max(codarq) FROM db_sysarquivo));

          -- Create sequence for ve82_sequencial
          CREATE SEQUENCE veiculos.veicreativar_ve82_sequencial_seq
              INCREMENT 1
              MINVALUE 1
              MAXVALUE 9223372036854775807
              START 1
              CACHE 1;

          -- Create veicreativar table
          CREATE TABLE veiculos.veicreativar (
              ve82_sequencial int8 NOT NULL DEFAULT nextval('veicreativar_ve82_sequencial_seq'),
              ve82_veiculo int4 NOT NULL,
              ve82_datareativacao date NOT NULL,
              ve82_obs varchar(200),
              ve82_usuario int4 NOT NULL,
              ve82_criadoem timestamp without time zone NOT NULL DEFAULT now(),
              PRIMARY KEY (ve82_sequencial),
              FOREIGN KEY (ve82_veiculo) REFERENCES veiculos.veiculos(ve01_codigo)
          );

          -- Insere campos no dicionário 
          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've82_sequencial', 'int8', 'Sequencial', '', 'Cód. Veículo', 8, false, false, false, 1, 'text', 'Cód. Veículo');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've82_veiculo', 'int4', 'Código Veículo', '', 'Cód. Veículo', 4, false, false, false, 1, 'text', 'Cód. Veículo');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've82_datareativacao', 'date', 'Data da Reativação', '', 'Data da Reativação', 10, false, false, false, 1, 'text', 'Data da Reativação');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've82_obs', 'varchar(200)', 'Observação', '', 'Observação', 200, false, false, false, 1, 'text', 'Observação');
          
          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've82_usuario', 'int4', 'Usuário', '', 'Usuário', 4, false, false, false, 1, 'text', 'Usuário');

          INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) 
          VALUES ((SELECT MAX(codcam) + 1 FROM db_syscampo), 've82_criadoem', 'timestamp without time zone', 'Criado em', '', 'Criado em', null, false, false, false, 1, 'text', 'Criado em');

        COMMIT;
        SQL;

    $this->execute($sql);
  }
}
