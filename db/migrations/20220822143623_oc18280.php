<?php

use Phinx\Migration\AbstractMigration;

class Oc18280 extends AbstractMigration
{
    public function up()
    {
        $sql = "BEGIN;

        SELECT FC_STARTSESSION();

        CREATE TABLE veicespecificacao (
        si05_codigo int CONSTRAINT veicespecificacao_si05_codigo_pk PRIMARY KEY NOT NULL,
        si05_descricao varchar(30) NOT NULL);

        INSERT INTO veicespecificacao VALUES (1,'Aeronaves'),
 	        (2,'Embarcacoes'),
 	        (3,'Veiculo de Passeio'),
 	        (4,'Utilitario (Camionete)'),
 	        (5,'Onibus'),
 	        (6,'Caminhao'),
 	        (7,'Motocicleta'),
 	        (8,'Van'),
 	        (9,'Trator de Esteira'),
 	        (10,'Trator de Pneu'),
 	        (11,'Moto niveladora'),
 	        (12,'Pa-Carregadeira'),
 	        (13,'Retro Escavadeira'),
 	        (14,'Mini Carregadeira'),
 	        (15,'Escavadeira'),
 	        (16,'Empilhadeira'),
 	        (17,'Compactador'),
 	        (18,'Gerador'),
 	        (19,'Moto bomba'),
 	        (20,'Rocadeira'),
 	        (21,'Motoserra'),
 	        (22,'Pulverizador'),
 	        (23,'Compactador de Mo'),
 	        (24,'Oficina'),
 	        (25,'Motor de Popa'),
 	        (99,'Outros');

        ALTER TABLE tipoveiculos ADD CONSTRAINT tipoveiculos_veicespecificacao_fk FOREIGN KEY (si04_especificacao) REFERENCES veicespecificacao(si05_codigo);

        insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'si05_codigo','int4','Código da Especificação',0,'Código da Especificação',10,'f','f','f',1,'text','Código da Especificação');
        insert into db_syscampo values ((select max(codcam)+1 from db_syscampo),'si05_descricao','varchar(30)','Descrição da Especificação',null,'Descrição da Especificação',40,'f','t','f',0,'text','Descrição da Especificação');

        ";

        $this->execute($sql);
    }
}
