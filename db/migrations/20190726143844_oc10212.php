<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc10212 extends PostgresMigration
{

    public function up()
    {
        $this->alterColumnDestino();
    }

    private function alterColumnDestino()
    {
        $veicretirada = $this->table('veicretirada', array('schema' => 'veiculos'));
        $veicretirada->changeColumn('ve60_destino', 'text')
            ->save();
    }
}
