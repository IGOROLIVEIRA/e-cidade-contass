<?php

use Phinx\Migration\AbstractMigration;

class Addtableliccontrolepncp extends AbstractMigration
{

    public function up()
    {
        $sql = " 
        BEGIN;

            CREATE TABLE licsituacaocontrolepncp(
                l214_sequencial           int8 NOT NULL,
                l214_situacao             varchar(55) NOT NULL,
                PRIMARY KEY (l214_sequencial)
            );
            
            insert into licsituacaocontrolepncp values(1,'Enviada');
            insert into licsituacaocontrolepncp values(2,'Ratificada');
            insert into licsituacaocontrolepncp values(3,'Excluida');
            
            CREATE TABLE liccontrolepncp(
                l213_sequencial           int8 NOT NULL,
                l213_licitacao            int8 NOT NULL,
                l213_usuario			  int8 NOT NULL,
                l213_dtlancamento         date NOT NULL,
                l213_numerocontrolepncp   text NOT NULL,
                l213_situacao			  int8 NOT NULL,
                l213_numerocompra   	  int8 NOT NULL,
                l213_anousu 			  int8 NOT NULL,
                l213_instit               int8 NOT NULL,
                PRIMARY KEY (l213_sequencial),
                FOREIGN KEY (l213_licitacao) REFERENCES liclicita (l20_codigo)
            );

            ALTER TABLE liccontrolepncp
            ADD CONSTRAINT fk_id_licsituacaocontrolepncp FOREIGN KEY (l213_situacao) REFERENCES licsituacaocontrolepncp(l214_sequencial);
            
            --criando sequencia
            CREATE SEQUENCE liccontrolepncp_l213_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;

            CREATE TABLE liccontrolepncpitens(
                l214_sequencial           int8 NOT NULL,
                l214_numeroresultado      int8 NOT NULL,
                l214_numerocompra         int8 NOT NULL,
                l214_anousu               int8 NOT NULL,
                l214_licitacao            int8 NOT NULL,
                l214_ordem                int8 NOT NULL,
                PRIMARY KEY (l214_sequencial)
            );
    
                --criando sequencia
                CREATE SEQUENCE liccontrolepncpitens_l214_sequencial_seq
                INCREMENT 1
                MINVALUE 1
                MAXVALUE 9223372036854775807
                START 1
                CACHE 1;

        COMMIT;
        ";
        $this->execute($sql);
    }
}
