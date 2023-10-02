<?php

use Phinx\Migration\AbstractMigration;

class Oc20693 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Anexos Atas PNCP', 'Anexos Atas PNCP', 'lic1_anexosatapncp.php', 1, 1, 'Anexos Atas PNCP', 't');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like 'Ata de Registro de Pre%'),(select max(id_item) from db_itensmenu),4,381);

            create table licanexoataspncp (
                         l216_sequencial int8,
                         l216_tipoanexo int8,
                         l216_codigoata int8,
                         l216_oid oid,
                         l216_instit int8
            );

            ALTER TABLE licanexoataspncp ADD PRIMARY KEY (l216_sequencial);

            ALTER TABLE licanexoataspncp ADD CONSTRAINT licanexoataspncp_licatareg_fk
            FOREIGN KEY (l216_codigoata) REFERENCES licatareg (l221_sequencial);

            -- Criando  sequences
            CREATE SEQUENCE licanexoataspncp_l216_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;

            ALTER TABLE anexotermospncp ADD PRIMARY KEY (ac56_sequencial);

            create table controleanexosataspncp (
            l217_sequencial int8,
            l217_licatareg int8,
            l217_usuario int8,
            l217_dataenvio date,
            l217_sequencialata int8,
            l217_tipoanexo int8,
            l217_sequencialarquivo int8,
            l217_anocompra int8,
            l217_sequencialpncp int8,
            l217_instit int8
            );

            CREATE SEQUENCE controleanexosataspncp_l217_sequencial_seq
            INCREMENT 1
            MINVALUE 1
            MAXVALUE 9223372036854775807
            START 1
            CACHE 1;

        ";

        $this->execute($sql);
    }
}
