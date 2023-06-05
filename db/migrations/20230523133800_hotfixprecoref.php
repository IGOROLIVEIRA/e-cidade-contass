<?php

use Phinx\Migration\AbstractMigration;

class Hotfixprecoref extends AbstractMigration
{
    
    public function up()
    {
       /* $sql = "Begin;


        ALTER TABLE itemprecoreferencia ADD CONSTRAINT itemprecoreferencia_precoreferencia_fk
        FOREIGN KEY (si02_precoreferencia) REFERENCES precoreferencia (si01_sequencial);

        ALTER TABLE itemprecoreferencia ADD CONSTRAINT itemprecoreferencia_pcorcamitem_fk
        FOREIGN KEY (si02_itemproccompra) REFERENCES pcorcamitem (pc22_orcamitem);

        ALTER TABLE precoreferencia ADD CONSTRAINT precoreferencia_pcproc_fk
        FOREIGN KEY (si01_processocompra) REFERENCES pcproc (pc80_codproc);

        ALTER TABLE itemprecoreferencia ADD CONSTRAINT itemprecoreferencia_pcmater_fk
        FOREIGN KEY (si02_coditem) REFERENCES pcmater (pc01_codmater);

        ALTER TABLE itemprecoreferencia ADD CONSTRAINT itemprecoreferencia_matunid_fk
        FOREIGN KEY (si02_codunidadeitem) REFERENCES matunid (m61_codmatunid);

        ALTER TABLE itemprecoreferencia ADD si02_vltotalprecoreferencia float;

        UPDATE itemprecoreferencia SET si02_vltotalprecoreferencia = (si02_vlprecoreferencia * si02_qtditem) WHERE si02_tabela = 'f' AND si02_taxa = 'f';
        
        UPDATE itemprecoreferencia SET si02_vltotalprecoreferencia = si02_vlprecoreferencia WHERE si02_tabela = 't' OR si02_taxa = 't';

        CREATE TABLE precoreferenciaacount(
        si233_sequencial                int8  default 0,
        si233_precoreferencia           int8  default 0,
        si233_acao              varchar(50) NOT NULL ,
        si233_idusuario         int8  default 0,
        si233_datahr            date);

        CREATE SEQUENCE precoreferenciaacount_si233_sequencial_seq
        INCREMENT 1
        MINVALUE 1
        MAXVALUE 9223372036854775807
        START 1
        CACHE 1;
        
        commit;";

        $this->execute($sql);*/

    }
}
