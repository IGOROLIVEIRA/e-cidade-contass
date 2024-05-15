<?php

use Phinx\Migration\AbstractMigration;

class Oc16639 extends AbstractMigration
{
    public function up()
    {
        $sSql = "
        select fc_startsession();
        begin;
            alter table itemprecoreferencia add column si02_coditem int;
            alter table itemprecoreferencia add column si02_qtditem int;
            alter table itemprecoreferencia add column si02_codunidadeitem int;
            alter table itemprecoreferencia add column si02_reservado bool;
            alter table itemprecoreferencia add column si02_tabela bool;
            alter table itemprecoreferencia add column si02_taxa bool;
            alter table itemprecoreferencia add column si02_criterioadjudicacao int;
            alter table itemprecoreferencia add column si02_mediapercentual float8;
        commit;
        ";

        $this->execute($sSql);
    }
}
