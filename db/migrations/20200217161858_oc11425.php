<?php

use Phinx\Migration\AbstractMigration;

class Oc11425 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        
        BEGIN;
        
        DROP TABLE bpdcasp102019;
        
        CREATE TABLE bpdcasp102019 (
          si208_sequencial integer DEFAULT 0 NOT NULL,
          si208_tiporegistro integer DEFAULT 0 NOT NULL,
          si208_exercicio integer DEFAULT 0 NOT NULL,
          si208_vlativocircucaixaequicaixa double precision DEFAULT 0 NOT NULL,
          si208_vlativocircucredicurtoprazo double precision DEFAULT 0 NOT NULL,
          si208_vlativocircuinvestapliccurtoprazo double precision DEFAULT 0 NOT NULL,
          si208_vlativocircuestoques double precision DEFAULT 0 NOT NULL,
          si208_vlativocircuvpdantecipada double precision DEFAULT 0 NOT NULL,
          si208_vlativonaocircurlp double precision DEFAULT 0 NOT NULL,
          si208_vlativonaocircuinvestimentos double precision DEFAULT 0 NOT NULL,
          si208_vlativonaocircuimobilizado double precision DEFAULT 0 NOT NULL,
          si208_vlativonaocircuintagivel double precision DEFAULT 0 NOT NULL,
          si208_vltotalativo double precision DEFAULT 0,
          si208_ano integer DEFAULT 0 NOT NULL,
          si208_periodo integer DEFAULT 0 NOT NULL,
          si208_institu integer DEFAULT 0 NOT NULL
      );

      COMMIT;
SQL;
        $this->execute($sql);
    }
}
