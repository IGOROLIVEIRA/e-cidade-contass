<?php

use Phinx\Migration\AbstractMigration;

class Addcontroleanexos extends AbstractMigration
{

    public function up()
    {
        $sql = "CREATE TABLE liccontroleanexopncp(
                l218_sequencial          int8 NOT NULL,
                l218_licitacao           int8,
                l218_usuario             int8 NOT NULL,
                l218_dtlancamento        date NOT NULL,
                l218_numerocontrolepncp  text NOT NULL,
                l218_tipoanexo           int8 NOT NULL,
                l218_instit              int8 NOT NULL,
                l218_ano                 int8 NOT NULL,    
                l218_sequencialpncp      int8 NOT NULL,
                l218_sequencialarquivo   int8 NOT NULL,
                l218_processodecompras   int8,
                PRIMARY KEY (l218_sequencial)
            );
            --criando sequencia
            CREATE SEQUENCE liccontroleanexopncp_l218_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1";
        $this->execute($sql);
    }
}
