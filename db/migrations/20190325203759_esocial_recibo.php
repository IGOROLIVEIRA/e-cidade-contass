<?php

use Classes\PostgresMigration;

class EsocialRecibo extends PostgresMigration
{

    public function change()
    {
        $table = $this->table('esocialrecibo', array('schema' => 'esocial', 'id' => 'rh215_sequencial'));
        $table->addColumn('rh215_esocialenvio', 'integer')
              ->addColumn('rh215_recibo', 'string', array('limit' => 100))
              ->addColumn('rh215_dataentrega', 'timestamp')
              ->addForeignKey('rh215_esocialenvio', 'esocialenvio', 'rh213_sequencial')
              ->create();
    }
}
