<?php

use Phinx\Migration\AbstractMigration;

class Oc11435 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;
        
        DROP TABLE dfcdcasp102019;
        
        CREATE TABLE dfcdcasp102019 (
          si219_sequencial integer DEFAULT 0 NOT NULL,
          si219_tiporegistro integer DEFAULT 0 NOT NULL,
          
          si219_vlreceitatributaria double precision DEFAULT 0 NOT NULL,
          si219_vlreceitacontribuicao double precision DEFAULT 0 NOT NULL,
          si219_vlreceitapatrimonial double precision DEFAULT 0 NOT NULL,
          si219_vlreceitaagropecuaria double precision DEFAULT 0 NOT NULL,
          si219_vlreceitaindustrial double precision DEFAULT 0 NOT NULL,
          si219_vlreceitaservicos double precision DEFAULT 0 NOT NULL,
          si219_vlremuneracaodisponibilidade double precision DEFAULT 0 NOT NULL,
          si219_vloutrasreceitas double precision DEFAULT 0 NOT NULL,
          si219_vltransferenciarecebidas double precision DEFAULT 0 NOT NULL,
          
          si219_vltotalingressosativoperacionais double precision DEFAULT 0,
          si219_anousu integer DEFAULT 0 NOT NULL,
          si219_periodo integer DEFAULT 0 NOT NULL,
          si219_instit integer DEFAULT 0 NOT NULL
      );

      COMMIT;
SQL;
        $this->execute($sql);
    }
}
