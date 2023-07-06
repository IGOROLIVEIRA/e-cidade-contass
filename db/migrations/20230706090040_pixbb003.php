<?php

use Classes\PostgresMigration;

class PixBb003 extends PostgresMigration
{
    public function up()
    {
        $table = $this->table(
            'recibopaga_qrcode_pix',
            [
                'id' => false,
                'primary_key' => ['k176_sequencial'],
                'schema' => 'arrecadacao'
            ]
        );

        $table->addColumn('k176_codigo_conciliacao_recebedor', 'string', ['limit' => '150', 'null' => true])
            ->update();

        $this->execute('alter table arrecadacao.recibopaga_qrcode_pix alter column k176_hist set data type jsonb using k176_hist::jsonb');
        $sqlConvert = <<<SQL
        update recibopaga_qrcode_pix set k176_codigo_conciliacao_recebedor = (select REPLACE((k176_hist->'codigoConciliacaoSolicitante')::VARCHAR,'"','') as codigoConciliacaoSolicitante from recibopaga_qrcode_pix as x where x.k176_sequencial = recibopaga_qrcode_pix.k176_sequencial);
SQL;
        $this->execute($sqlConvert);
    }
}
