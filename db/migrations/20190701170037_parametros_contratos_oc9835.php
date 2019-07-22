<?php

use Phinx\Migration\AbstractMigration;

class ParametrosContratosOc9835 extends AbstractMigration
{
  
  public function up()
  {
    $sSQL = <<<SQL
      SELECT fc_startsession();

      ALTER TABLE parametroscontratos ADD COLUMN pc01_libcontratodepart BOOLEAN DEFAULT TRUE;

      INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
      VALUES ((select max(codcam)+1 from db_syscampo), 'pc01_libcontratodepart', 'boolean', 'Controla alteração dados contrato departamento', '', 'Controla alteração dados contrato departamento', 1, false, true, false, 0, 'text', 'Ctrl alteração dados contrato depart');
  
SQL;
  $this->execute($sSQL);
  }

}
