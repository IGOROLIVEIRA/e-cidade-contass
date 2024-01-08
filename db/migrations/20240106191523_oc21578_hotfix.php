<?php

use Phinx\Migration\AbstractMigration;

class Oc21578_hotfix extends AbstractMigration
{
  public function up()
  {
      $this->atualizaEmpdiaria();
  }

  public function atualizaEmpdiaria(){
    $sSql = "
          BEGIN;

          ALTER TABLE empenho.empdiaria ALTER COLUMN e140_qtddiarias float4;
          ALTER TABLE empenho.empdiaria ALTER COLUMN e140_qtdhospedagens float4;
          ALTER TABLE empenho.empdiaria ALTER COLUMN e140_qtddiariaspernoite float4;

          COMMIT;
    ";

    $this->execute($sSql);
  }

}
