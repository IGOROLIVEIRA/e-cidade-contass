<?php

use Phinx\Migration\AbstractMigration;

class Oc18994 extends AbstractMigration
{
    public function up()
    {
        $sql = "
            BEGIN;
                INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'pc30_liboccontrato', 'bool', 'Liberar', '0', 'Liberar', 1, false, false, true, 1, 'bool', 'Liberar');
                ALTER TABLE pcparam ADD COLUMN pc30_liboccontrato bool DEFAULT FALSE;
                UPDATE pcparam SET pc30_liboccontrato=TRUE;
            COMMIT;
      ";
        $this->execute($sql);
    }
}
