<?php

use Phinx\Migration\AbstractMigration;

class Oc11271 extends AbstractMigration
{
    public function up()
    {
    	$sql = "
    			INSERT into db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
				values ((select max(id_item) from db_itensmenu) + 1, 'Envio do edital', 'Envio do edital', '', 1, 1, 'Envio do edital', 't');
				
				--INSERE o campo status para ser utilizado na inclusão de editais
				
        INSERT into db_menu(id_item, id_item_filho, menusequencia, modulo) values (1818, (select id_item from db_itensmenu where descricao = 'Envio do edital'), (select max(menusequencia) from db_menu where id_item = 1818 and modulo = 381)+1, 381);

				-- Menu Inclusão

				INSERT into db_itensmenu (id_item, descricao, help, funcao, itemativo, manutencao, desctec, libcliente)
				values ((select max(id_item) from db_itensmenu) + 1, 'Inclusão', 'Inclusão do edital', 'lic4_editalabas.php', 1, 1, 'Inclusão do edital', 't');

				INSERT into db_menu (id_item, id_item_filho, menusequencia, modulo) values ((select id_item from db_itensmenu where descricao = 'Envio do edital'), (select max(id_item) from db_itensmenu), 1, 381);

        
        CREATE TABLE liclancedital(
          l47_sequencial BIGINT NOT NULL PRIMARY KEY,
          l47_linkpub VARCHAR(200),
          l47_origemrecurso INTEGER,
          l47_descrecurso VARCHAR(250),
          l47_dataenvio DATE,
          l47_liclicita BIGINT,
          FOREIGN KEY(l47_liclicita) REFERENCES liclicita(l20_codigo)
        );

        CREATE SEQUENCE liclancedital_l47_sequencial_seq
                  START WITH 1
                  INCREMENT BY 1
                  NO MINVALUE
                  NO MAXVALUE
                  CACHE 1;

                  
        CREATE TABLE editaldocumentos(
          l48_sequencial BIGINT NOT NULL DEFAULT 0,
          l48_nomearquivo varchar(100),
          l48_tipo varchar(2),
          l48_caminho VARCHAR(150),
          l48_liclicita bigint,
          FOREIGN KEY(l48_liclicita) REFERENCES liclicita(l20_codigo)
        );
        
        CREATE SEQUENCE editaldocumentos_l48_sequencial_seq
                  START WITH 1
                  INCREMENT BY 1
                  NO MINVALUE
                  NO MAXVALUE
                  CACHE 1;
        
        CREATE TABLE obrasdadoscomplementares(
          db150_sequencial BIGINT NOT NULL DEFAULT 0,
          db150_codobra BIGINT NOT NULL,
          db150_pais INTEGER NOT NULL,
          db150_estado INTEGER NOT NULL,
          db150_municipio INTEGER NOT NULL,
          db150_distrito VARCHAR(100),
          db150_bairro VARCHAR(100),
          db150_numero INTEGER,
          db150_logradouro VARCHAR(100),
          db150_grauslatitude VARCHAR(2) NOT NULL,
          db150_minutolatitude VARCHAR(2) NOT NULL,
          db150_segundolatitude double precision,
          db150_grauslongitude VARCHAR(2) NOT NULL,
          db150_minutolongitude VARCHAR(2) NOT NULL,
          db150_segundolongitude double precision,
          db150_classeobjeto INTEGER,
          db150_grupobempublico INTEGER,
          db150_subgrupobempublico INTEGER,
          db150_atividadeobra INTEGER,
          db150_atividadeservico INTEGER,
          db150_descratividadeservico VARCHAR(150),
          db150_atividadeservicoesp INTEGER,
          db150_descratividadeservicoesp VARCHAR(150),
          db150_bdi FLOAT,
          db150_liclicita BIGINT,
          db150_cep CHAR(8),
          PRIMARY KEY(db150_sequencial)
        );
        
        ALTER TABLE ONLY obrasdadoscomplementares
            ADD CONSTRAINT obrasdadoscomplementares_fk FOREIGN KEY (db150_liclicita) REFERENCES liclicita(l20_codigo);
        
        CREATE SEQUENCE obrasdadoscomplementares_db150_sequencial_seq
          START WITH 1
          INCREMENT BY 1
          NO MINVALUE
          NO MAXVALUE
          CACHE 1;

      ";
    	$this->execute($sql);
    }

    public function down(){
      $sql = "
          DELETE from db_menu where id_item = (select id_item from db_itensmenu where descricao = 'Envio do edital');
			    DELETE from db_itensmenu where help = 'Envio do edital';
          DROP TABLE liclanceditaldocumentos;
          DROP SEQUENCE editaldocumentos_l48_sequencial_seq;
          DROP TABLE liclancedital;
          DROP SEQUENCE liclancedital_l47_sequencial_seq;
          DROP TABLE obrasdadoscomplementares;
          DROP SEQUENCE obrasdadoscomplementares_db150_sequencial_seq;
      ";
      $this->execute($sql);
    }
}
