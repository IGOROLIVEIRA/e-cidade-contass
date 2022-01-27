<?php

use Phinx\Migration\AbstractMigration;

class OcViradaGruposContratos extends AbstractMigration
{
    public function up()
    {
        $getIstints = $this->fetchAll('SELECT codigo FROM db_config');
        foreach ($getIstints as $instit) {
            $this->getGruposAcordo($instit['codigo']);
        }
    }

    private function getGruposAcordo($instit)
    {
        $resultGrupo = $this->fetchAll("select distinct ac03_acordogrupo from acordogruponumeracao where ac03_instit = '{$instit}'");

        foreach ($resultGrupo as $grupo) {
            $this->inserirGrupos($grupo['ac03_acordogrupo'], $instit);
        }
    }

    private function inserirGrupos($ac03_acordogrupo, $ac03_instit)
    {
        $sql = "
            begin;
                INSERT INTO acordogruponumeracao VALUES (nextval('acordogruponumeracao_ac03_sequencial_seq'),'{$ac03_acordogrupo}',2022,0,'{$ac03_instit}');
            commit;
        ";
        $this->execute($sql);
    }
}
