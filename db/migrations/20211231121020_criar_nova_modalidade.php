<?php

use Phinx\Migration\AbstractMigration;

class CriarNovaModalidade extends AbstractMigration
{
    public function up()
    {
        $getIstints = $this->fetchAll('SELECT codigo FROM db_config');
        foreach ($getIstints as $instit) {
            $this->inserirModalidade($instit['codigo']);
        }
    }

    private function inserirModalidade($instit)
    {
        $sql = "
            begin;
                insert into cflicita values(nextval('cflicita_l03_codigo_seq'),'DIALOGO COMPETITIVO','H',23,'{$instit}','f',110);
            commit;
        ";
        $this->execute($sql);
    }
}
