<?php

use Phinx\Migration\AbstractMigration;

class Oc22320 extends AbstractMigration
{
    public function up()
    {
        $consulta = "SELECT * FROM conhistdocregra WHERE c92_conhistdoc = 101 ORDER BY 1 LIMIT 1";

        $resultado = $this->fetchRow($consulta);

        $regra = $resultado['c92_regra'];
        $seq = $resultado['c92_sequencial'];

        if (strpos($regra, 'AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta]') === false
            && strpos($regra, 'AND c21_instit = [instituicaogrupoconta]') === false) {

            $regra = str_replace(';', ' AND conplanoorcamentogrupo.c21_instit = [instituicaogrupoconta];', $regra);
            $novaRegra = $regra;

            $sqlUpdate = "UPDATE conhistdocregra SET c92_regra = '{$novaRegra}' WHERE c92_conhistdoc = 101 AND c92_sequencial = {$seq}";
            $this->execute($sqlUpdate);

        }
    }

}
