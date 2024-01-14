<?php

use Phinx\Migration\AbstractMigration;

class Oc21578Hotfix extends AbstractMigration
{
  public function up()
  {
      $this->atualizaEmpdiaria();
  }

  public function atualizaEmpdiaria(){
    $sSql = "
          BEGIN;

          ALTER TABLE empenho.empdiaria ALTER COLUMN e140_qtddiarias TYPE float4;
          ALTER TABLE empenho.empdiaria ALTER COLUMN e140_qtdhospedagens TYPE float4;
          ALTER TABLE empenho.empdiaria ALTER COLUMN e140_qtddiariaspernoite TYPE float4;

          COMMIT;
    ";

    $this->execute($sSql);
  }

}
