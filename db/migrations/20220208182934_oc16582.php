<?php

use Phinx\Migration\AbstractMigration;

class Oc16582 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
        DROP TABLE flpgo122022;
        DROP TABLE flpgo112022;
        DROP TABLE flpgo102022;

        CREATE TABLE flpgo102022 (
            si195_sequencial int8 NOT NULL DEFAULT 0,
            si195_tiporegistro int8 NULL,
            si195_codvinculopessoa int8 NULL,
            si195_regime varchar(1) NULL,
            si195_indtipopagamento varchar(1) NULL,
            si195_dsctipopagextra varchar(150) NULL,
            si195_indsituacaoservidorpensionista varchar(2) NULL,
            si195_indpensionista int4 NULL,
            si195_nrocpfinstituidor varchar(11) NULL,
            si195_datobitoinstituidor date NULL,
            si195_tipodependencia int8 NULL,
            si195_dscdependencia varchar(150) NULL,
            si195_optouafastpreliminar int4 NULL,
            si195_datfastpreliminar date NULL,
            si195_datconcessaoaposentadoriapensao date NULL,
            si195_dsccargo varchar(120) NULL,
            si195_codcargo int8 NULL,
            si195_sglcargo varchar(3) NULL,
            si195_dscapo varchar(3) NULL,
            si195_natcargo int4 NULL,
            si195_dscnatcargo varchar(150) NULL,
            si195_indcessao varchar(3) NULL,
            si195_dsclotacao varchar(250) NULL,
            si195_indsalaaula varchar(1) NULL,
            si195_vlrcargahorariasemanal int8 NULL,
            si195_datefetexercicio date NULL,
            si195_datcomissionado date NULL,
            si195_datexclusao date NULL,
            si195_datcomissionadoexclusao date NULL,
            si195_vlrremuneracaobruta float8 NULL,
            si195_vlrdescontos float8 NULL,
            si195_vlrremuneracaoliquida float8 NULL,
            si195_natsaldoliquido varchar(1) NULL,
            si195_mes int8 NULL,
            si195_inst int8 NULL,
            CONSTRAINT flpgo102022_sequ_pk PRIMARY KEY (si195_sequencial)
        );

        CREATE TABLE flpgo112022 (
            si196_sequencial int8 NOT NULL DEFAULT 0,
            si196_tiporegistro int8 NULL,
            si196_indtipopagamento varchar(1) NULL,
            si196_codvinculopessoa varchar(15) NULL,
            si196_codrubricaremuneracao varchar(4) NULL,
            si196_desctiporubrica varchar(150) NULL,
            si196_vlrremuneracaodetalhada float8 NULL,
            si196_reg10 int8 NULL DEFAULT 0,
            si196_mes int8 NULL,
            si196_inst int8 NULL,
            CONSTRAINT flpgo112022_sequ_pk PRIMARY KEY (si196_sequencial),
            CONSTRAINT flpgo112022_reg10_fk FOREIGN KEY (si196_reg10) REFERENCES flpgo102022(si195_sequencial)
        );

        CREATE TABLE flpgo122022 (
            si197_sequencial int8 NOT NULL DEFAULT 0,
            si197_tiporegistro int8 NULL,
            si197_indtipopagamento varchar(1) NULL,
            si197_codvinculopessoa varchar(15) NULL,
            si197_codrubricadesconto varchar(4) NULL,
            si197_desctiporubricadesconto varchar(150) NULL,
            si197_vlrdescontodetalhado float8 NULL,
            si197_reg10 int8 NULL DEFAULT 0,
            si197_mes int8 NULL,
            si197_inst int8 NULL,
            CONSTRAINT flpgo122022_sequ_pk PRIMARY KEY (si197_sequencial),
            CONSTRAINT flpgo122022_reg10_fk FOREIGN KEY (si197_reg10) REFERENCES flpgo102022(si195_sequencial)
        );
SQL;
        $this->execute($sql);
    }

    public function down()
    {
        $sql = <<<SQL
        DROP TABLE flpgo122022;
        DROP TABLE flpgo112022;
        DROP TABLE flpgo102022;

        CREATE TABLE flpgo102022 (
            si195_sequencial int8 NOT NULL DEFAULT 0,
            si195_tiporegistro int8 NULL,
            si195_codvinculopessoa int8 NULL,
            si195_regime varchar(1) NULL,
            si195_indtipopagamento varchar(1) NULL,
            si195_dsctipopagextra varchar(150) NULL,
            si195_indsituacaoservidorpensionista varchar(1) NULL,
            si195_dscsituacao varchar(150) NULL,
            si195_indpensionistaprevidenciario int4 NULL,
            si195_nrocpfinstituidor varchar(11) NULL,
            si195_datobitoinstituidor date NULL,
            si195_tipodependencia int8 NULL,
            si195_dscdependencia varchar(150) NULL,
            si195_datafastpreliminar date NULL,
            si195_datconcessaoaposentadoriapensao date NULL,
            si195_dsccargo varchar(120) NULL,
            si195_codcargo int8 NULL,
            si195_sglcargo varchar(3) NULL,
            si195_dscsiglacargo varchar(150) NULL,
            si195_dscapo varchar(3) NULL,
            si195_natcargo int4 NULL,
            si195_dscnatcargo varchar(150) NULL,
            si195_indcessao varchar(3) NULL,
            si195_dsclotacao varchar(250) NULL,
            si195_indsalaaula varchar(1) NULL,
            si195_vlrcargahorariasemanal int8 NULL,
            si195_datefetexercicio date NULL,
            si195_datcomissionado date NULL,
            si195_datexclusao date NULL,
            si195_datcomissionadoexclusao date NULL,
            si195_vlrremuneracaobruta float8 NULL,
            si195_vlrdescontos float8 NULL,
            si195_vlrremuneracaoliquida float8 NULL,
            si195_natsaldoliquido varchar(1) NULL,
            si195_mes int8 NULL,
            si195_inst int8 NULL,
            CONSTRAINT flpgo102022_sequ_pk PRIMARY KEY (si195_sequencial)
        );
        
        CREATE TABLE flpgo112022 (
            si196_sequencial int8 NOT NULL DEFAULT 0,
            si196_tiporegistro int8 NULL,
            si196_indtipopagamento varchar(1) NULL,
            si196_codvinculopessoa varchar(15) NULL,
            si196_codrubricaremuneracao varchar(4) NULL,
            si196_desctiporubrica varchar(150) NULL,
            si196_vlrremuneracaodetalhada float8 NULL,
            si196_reg10 int8 NULL DEFAULT 0,
            si196_mes int8 NULL,
            si196_inst int8 NULL,
            CONSTRAINT flpgo112022_sequ_pk PRIMARY KEY (si196_sequencial),
            CONSTRAINT flpgo112022_reg10_fk FOREIGN KEY (si196_reg10) REFERENCES flpgo102022(si195_sequencial)
        );
        
        CREATE TABLE flpgo122022 (
            si197_sequencial int8 NOT NULL DEFAULT 0,
            si197_tiporegistro int8 NULL,
            si197_indtipopagamento varchar(1) NULL,
            si197_codvinculopessoa varchar(15) NULL,
            si197_codrubricadesconto varchar(4) NULL,
            si197_desctiporubricadesconto varchar(150) NULL,
            si197_vlrdescontodetalhado float8 NULL,
            si197_reg10 int8 NULL DEFAULT 0,
            si197_mes int8 NULL,
            si197_inst int8 NULL,
            CONSTRAINT flpgo122022_sequ_pk PRIMARY KEY (si197_sequencial),
            CONSTRAINT flpgo122022_reg10_fk FOREIGN KEY (si197_reg10) REFERENCES flpgo102022(si195_sequencial)
        );
SQL;
        $this->execute($sql);
    }
}
