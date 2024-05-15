<?php

use Phinx\Migration\AbstractMigration;

class Oc18173 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES 
        ((select max(codcam)+1 from db_syscampo), 'c60_nregobrig', 'int4', 'N Reg. Obrigatorio', '0', 'N Reg. Obrigatorio', 11, false, false, true, 1, 'text', 'N Reg. Obrigatorio');
 

        COMMIT;

SQL;
        $this->execute($sql);
    } 
}
