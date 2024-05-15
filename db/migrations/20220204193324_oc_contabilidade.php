<?php

use Phinx\Migration\AbstractMigration;

class OcContabilidade extends AbstractMigration
{
    public function up()
    {
        $sSql = "
        select fc_startsession();
        begin;
            alter table public.entesconsorciadosreceitas alter column c216_saldo3112 type float8;
            alter table public.entesconsorciadosreceitas alter column c216_percentual type float8;
        commit;
        ";

        $this->execute($sSql);
    }
}
