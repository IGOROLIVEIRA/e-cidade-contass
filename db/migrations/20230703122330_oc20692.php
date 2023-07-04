<?php

use Phinx\Migration\AbstractMigration;

class Oc20692 extends AbstractMigration
{

    public function up()
    {
        $sql = "
            INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Anexos de Termos','Anexos de Termos','aco1_publicacaoanexostermos001.php',1,1,'Anexos de Termos','t');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec='PNCP'),(select max(id_item) from db_itensmenu),3,8251);

            INSERT INTO db_syscampo VALUES ((select max(codcam)+1 from db_syscampo), 'l214_numeroaditamento'         ,'int8' ,'Nº Aditamento'          ,'', 'Nº Aditamento'           ,11    ,false, false, false, 1, 'int8', 'Nº Aditamento');

            CREATE TABLE anexotermospncp(
                          ac56_sequencial                int8  ,
                          ac56_acocontroletermospncp     int8  ,
                          ac56_anexo                     oid,
                          ac56_tipoanexo                 int8);

            CREATE SEQUENCE anexotermospncp_ac56_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;
        ";

        $this->execute($sql);
    }
}
