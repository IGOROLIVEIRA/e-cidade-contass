<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class PixBb003 extends PostgresMigration
{

    public function up()
    {
        $this->addField();
        $this->parseData();
        $this->insertDicionarioReciboPagaQrcodePixTable();
    }

    public function down()
    {
        $this->dropDicionarioDados();
    }

    /**
     * @return void
     */
    public function addField(): void
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
    }

    /**
     * @return void
     */
    public function parseData(): void
    {
        $this->execute('alter table arrecadacao.recibopaga_qrcode_pix alter column k176_hist set data type jsonb using k176_hist::jsonb');
        $sqlConvert = <<<SQL
        update recibopaga_qrcode_pix set k176_codigo_conciliacao_recebedor = (select REPLACE((k176_hist->'codigoConciliacaoSolicitante')::VARCHAR,'"','') as codigoConciliacaoSolicitante from recibopaga_qrcode_pix as x where x.k176_sequencial = recibopaga_qrcode_pix.k176_sequencial);
SQL;
        $this->execute($sqlConvert);
    }

    private function insertDicionarioReciboPagaQrcodePixTable()
    {
        $sql = <<<SQL
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k176_codigo_conciliacao_recebedor', 'text', 'Codigo conciliacao recebedor', '', 'Codigo conciliacao recebedor', 1, false, false, false, 1, 'text', 'Codigo conciliacao recebedor');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'recibopaga_qrcode_pix'), (select codcam from db_syscampo where nomecam = 'k176_codigo_conciliacao_recebedor'), 9, 0);
SQL;
        $this->execute($sql);
    }

    private function dropDicionarioDados()
    {
        $this->execute("delete from db_sysarqcamp where codcam = (select codcam from db_syscampo where nomecam = 'k176_codigo_conciliacao_recebedor')");
        $this->execute("delete from db_syscampo where nomecam = 'k176_codigo_conciliacao_recebedor'");
    }
}
