<?php

use Phinx\Migration\AbstractMigration;

class Pncpenviodetermos extends AbstractMigration
{

    
    public function up()
    {
        $sql = "
                INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Publicação de Termos', 'Publicação de Termos', 'aco1_pncppublicacaotermos001.php', 1, 1, 'Publicação de Termos', 't');
                INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao='PNCP'),(select max(id_item) from db_itensmenu),2,8251);
                
                CREATE TABLE acocontroletermospncp(
                    l214_sequencial           int8 NOT NULL,
                    l214_numerotermo          int8 NOT NULL,
                    l214_numcontratopncp      int8 NOT NULL,
                    l213_usuario              int8 NOT NULL,
                    l213_dtlancamento         date NOT NULL,
                    l214_anousu               int8 NOT NULL,
                    l214_acordo               int8 NOT NULL,
                    l214_numeroaditamento     int8 NOT NULL,
                    l214_acordoposicao        int8 NOT NULL,
                    l214_instit               int8 NOT NULL,
                    PRIMARY KEY (l214_sequencial)
                );
                
                --criando sequencia
                CREATE SEQUENCE acocontroletermospncp_l214_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;
                ";
        $this->execute($sql);
    }
}
