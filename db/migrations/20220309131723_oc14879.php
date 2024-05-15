<?php

use Phinx\Migration\AbstractMigration;

class Oc14879 extends AbstractMigration
{

    public function up()
    {
        $sSql = "alter table bensimoveis add column t54_endereco text NOT null DEFAULT 0;
        alter table bensimoveis add column t54_valor_terreno float8 NOT null DEFAULT 0;
        alter table bensimoveis add column t54_valor_area float8 NOT null DEFAULT 0;
        alter table bensimoveis add column t54_valor_total float8 NOT null DEFAULT 0;
        alter table bensimoveis add column t54_limites_confrontacoes varchar(200) NOT null DEFAULT 0;
        alter table bensimoveis add column t54_aplicacao varchar(200) NOT null DEFAULT 0;
        alter table bensimoveis add column t54_prop_anterior varchar (200);
        alter table bensimoveis add column t54_cpfcnpj int;
        alter table bensimoveis add column t54_cartorio_tc varchar (200);
        alter table bensimoveis add column t54_comarca_tc varchar (200);
        alter table bensimoveis add column t54_registro_tc int;
        alter table bensimoveis add column t54_livro_tc varchar (200);
        alter table bensimoveis add column t54_folha_tc int;
        alter table bensimoveis add column t54_data_tc date;
        alter table bensimoveis add column t54_cartorio_tp varchar (200);
        alter table bensimoveis add column t54_tabeliao_tp varchar (200);
        alter table bensimoveis add column t54_livro_tp varchar (200);
        alter table bensimoveis add column t54_folha_tp int;
        alter table bensimoveis add column t54_data_tp date;
        alter table bensimoveis add column t54_escritura_tp varchar(200);
        alter table bensimoveis add column t54_carta_tp varchar(200);
        alter table bensimoveis drop constraint bensimoveis_codb_idbq_pk;
        ALTER TABLE bensimoveis ADD PRIMARY KEY (t54_codbem);
        ALTER TABLE bensimoveis ALTER column t54_idbql DROP NOT NULL;
        ALTER TABLE bensimoveis ALTER column t54_idbql DROP DEFAULT;
        ALTER TABLE patrimonio.bensimoveis DROP constraint bensimoveis_idbql_fk;
        ALTER TABLE patrimonio.bensimoveis ADD constraint bensimoveis_idbql_fk FOREIGN KEY (t54_idbql) REFERENCES cadastro.lote(j34_idbql);";

        $this->execute($sSql);
    }
}
