<?php

use App\Support\Database\AsFunction;
use App\Support\Database\Sequence;
use ECidade\Suporte\Phinx\PostgresMigration;

class PixBb extends PostgresMigration
{
    use Sequence;
    use AsFunction;

    public const COD_MODULO_ARRECADACAO = 54;

    public function up()
    {
        $this->createInstituicoesFinanceirasApiPixTable();
        $this->createReciboPagaQrCodePixTable();
        $this->createConfiguracoesPixBancoDoBrasilTable();
        $this->insertDicionarioReciboPagaQrcodePixTable();
        $this->insertDicionarioDadosBBSettingsTable();
        $this->createSettingsFields();
        $this->insertDicionarioDadosSettingsFields();
        $this->upFcDesconto();
    }

    public function down()
    {
        $this->dropColumnsSettings();
        $this->dropTables();
        $this->dropDicionarioDados();
        $this->dropDicionarioDadosSettingsFields();
        $this->downFcDesconto();
    }

    private function upFcDesconto()
    {
        $this->createFunction('public.fc_desconto', '2023-04-06');
    }

    private function downFcDesconto()
    {
        $this->createFunction('public.fc_desconto', '2023-01-01');
    }

    private function createInstituicoesFinanceirasApiPixTable()
    {
        $this->createSequence('instituicoes_financeiras_api_pix_k175_sequencial', 'arrecadacao');

        $table = $this->table(
            'instituicoes_financeiras_api_pix',
            [
                'id' => false,
                'primary_key' => ['k175_sequencial'],
                'schema' => 'arrecadacao'
            ]
        );

        $table->addColumn(
            'k175_sequencial',
            'integer'
        );

        $table->addColumn('k175_nome', 'string', ['limit' => '100']);
        $table->create();

        $this->setAsAutoIncrement(
            'arrecadacao.instituicoes_financeiras_api_pix',
            'k175_sequencial',
            'arrecadacao.instituicoes_financeiras_api_pix_k175_sequencial'
        );


        $table->insert(['k175_nome'], [['Banco do Brasil']])->saveData();
    }

    private function createConfiguracoesPixBancoDoBrasilTable()
    {
        $table = $this->table(
            'configuracoes_pix_banco_do_brasil',
            [
                'id' => false,
                'primary_key' => ['k177_sequencial'],
                'schema' => 'arrecadacao'
            ]
        );

        $refTableInstituicaoFinanceira = $this->table(
            'instituicoes_financeiras_api_pix',
            [
                'id' => false,
                'primary_key' => ['k175_sequencial'],
                'schema' => 'arrecadacao'
            ]
        );

        $table->addColumn('k177_sequencial', 'integer');
        $table->addColumn('k177_instituicao_financeira', 'integer');
        $table->addColumn('k177_numero_convenio', 'integer');
        $table->addColumn('k177_develop_application_key', 'text');
        $table->addColumn('k177_url_api', 'text');
        $table->addColumn('k177_url_oauth', 'text');
        $table->addColumn('k177_client_id', 'text');
        $table->addColumn('k177_client_secret', 'text');
        $table->addColumn('k177_ambiente', 'string', ['limit' => 1]);
        $table->addColumn('k177_chave_pix', 'string', ['limit' => 200]);
        $table->addForeignKey('k177_instituicao_financeira', $refTableInstituicaoFinanceira, 'k175_sequencial');
        $table->create();
        $this->createSequence('configuracoes_pix_banco_do_brasil_k177_sequencial', 'arrecadacao');
        $this->setAsAutoIncrement(
            'arrecadacao.configuracoes_pix_banco_do_brasil',
            'k177_sequencial',
            'configuracoes_pix_banco_do_brasil_k177_sequencial'
        );
    }

    private function insertDicionarioDadosBBSettingsTable()
    {
        $codModuloArrecadacao = self::COD_MODULO_ARRECADACAO;
        $sql = <<<SQL
            INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'configuracoes_pix_banco_do_brasil', 'Configuracoes para integragacao com a API PIX BB', 'k176', '2022-12-30', 'Configuracoes para integragacao com a API PIX BB', 0, false, false, false, false);

            INSERT INTO db_sysarqmod (codmod, codarq) VALUES ($codModuloArrecadacao, (select max(codarq) from db_sysarquivo));

            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k177_sequencial', 'int8', 'Código Sequencial', '', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k177_instituicao_financeira', 'int8', 'Código da Instituição Financeira Habilitada', '', 'Instituição Financeira', 11, false, false, false, 1, 'text', 'Instituição Financeira');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k177_numero_convenio', 'int8', 'Código do convênio PIX com BB.', '', 'Convênio', 11, false, false, false, 1, 'text', 'Convênio');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k177_url_api', 'text', 'End Point API URL', '', 'End Point API URL', 200, false, false, false, 0, 'text', 'End Point API URL');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k177_develop_application_key', 'text', 'É a credencial para acionar as APIS do Banco do Brasil.', '', 'Develop Application Key', 200, false, false, false, 0, 'text', 'Develop Application Key');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k177_url_oauth   ', 'text', 'End Point API OAuth2', '', 'End Point API OAuth2', 200, false, false, false, 0, 'text', 'End Point API OAuth2');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k177_client_id   ', 'text', 'Identificador OAuth do Banco do Brasil.', '', 'Client ID', 200, false, false, false, 0, 'text', 'Client ID');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k177_client_secret   ', 'text', 'Client Secret', '', 'Client Secret', 500, false, false, false, 0, 'text', 'Client Secret');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k177_chave_pix', 'text', 'Chave Pix do Recebedor', '', 'Chave PIX', 200, false, false, false, 0, 'text', 'Chave PIX');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k177_ambiente', 'varchar(1)', 'T - Test | P - Produção', '', 'Ambiente', 1, false, true, false, 0, 'text', 'Ambiente');

            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'), (select codcam from db_syscampo where nomecam = 'k177_sequencial'), 1, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'), (select codcam from db_syscampo where nomecam = 'k177_instituicao_financeira'), 2, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'), (select codcam from db_syscampo where nomecam = 'k177_url_api'), 3, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'), (select codcam from db_syscampo where nomecam = 'k177_url_oauth'), 4, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'), (select codcam from db_syscampo where nomecam = 'k177_develop_application_key'), 5, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'), (select codcam from db_syscampo where nomecam = 'k177_client_id'), 6, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'), (select codcam from db_syscampo where nomecam = 'k177_client_secret'), 7, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'), (select codcam from db_syscampo where nomecam = 'k177_ambiente'), 8, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'), (select codcam from db_syscampo where nomecam = 'k177_numero_convenio'), 9, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'), (select codcam from db_syscampo where nomecam = 'k177_chave_pix'), 10, 0);

            INSERT INTO db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'), (select codcam from db_syscampo where nomecam = 'k177_sequencial'), 1, 0, 0);
SQL;
        $this->execute($sql);
    }

    private function createReciboPagaQrCodePixTable()
    {
        $table = $this->table(
            'recibopaga_qrcode_pix',
            [
                'id' => false,
                'primary_key' => ['k176_sequencial'],
                'schema' => 'arrecadacao'
            ]
        );

        $refTableInstituicaoFinanceira = $this->table(
            'instituicoes_financeiras_api_pix',
            [
                'id' => false,
                'primary_key' => ['k175_sequencial'],
                'schema' => 'arrecadacao'
            ]
        );

        $table->addColumn('k176_sequencial', 'integer');
        $table->addColumn('k176_numnov', 'integer', ['null' => true]);
        $table->addColumn('k176_numpre', 'integer', ['null' => true]);
        $table->addColumn('k176_numpar', 'integer', ['null' => true]);
        $table->addColumn('k176_dtcriacao', 'date');
        $table->addColumn('k176_qrcode', 'text');
        $table->addColumn('k176_hist', 'text');
        $table->addColumn('k176_instituicao_financeira', 'integer');
        $table->addForeignKey('k176_instituicao_financeira', $refTableInstituicaoFinanceira, 'k175_sequencial');
        $table->create();

        $this->createSequence('recibopaga_qrcode_pix_k176_sequencial', 'arrecadacao');
        $this->setAsAutoIncrement(
            'arrecadacao.recibopaga_qrcode_pix',
            'k176_sequencial',
            'recibopaga_qrcode_pix_k176_sequencial'
        );
    }

    private function dropTables()
    {
        $this->table(
            'recibopaga_qrcode_pix',
            [
                'id' => false,
                'primary_key' => ['k176_sequencial'],
                'schema' => 'arrecadacao'
            ]
        )->drop();

        $this->table(
            'configuracoes_pix_banco_do_brasil',
            [
                'id' => false,
                'primary_key' => ['k177_sequencial'],
                'schema' => 'arrecadacao'
            ]
        )->drop();

        $this->table(
            'instituicoes_financeiras_api_pix',
            [
                'id' => false,
                'primary_key' => ['k175_sequencial'],
                'schema' => 'arrecadacao'
            ]
        )->drop();

        $this->dropSequence('recibopaga_qrcode_pix_k176_sequencial', 'arrecadacao');
        $this->dropSequence('instituicoes_financeiras_api_pix_k175_sequencial', 'arrecadacao');
        $this->dropSequence('configuracoes_pix_banco_do_brasil_k177_sequencial', 'arrecadacao');
    }

    private function insertDicionarioReciboPagaQrcodePixTable()
    {
        $codModuloArrecadacao = self::COD_MODULO_ARRECADACAO;
        $sql = <<<SQL
        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'recibopaga_qrcode_pix', 'QRCode gerado para um recibo de pagamento', 'k176', '2023-12-30', 'QRCode gerado para um recibo de pagamento', 0, false, false, false, false);

        INSERT INTO db_sysarqmod (codmod, codarq) VALUES ($codModuloArrecadacao, (select max(codarq) from db_sysarquivo));

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k176_sequencial                          ', 'int8                                    ', 'Código Sequencial', '', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k176_numnov                              ', 'int8                                    ', 'Numero do recibo', '', 'Numero do recibo', 11, false, false, false, 1, 'text', 'Numero do recibo');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k176_numpre                              ', 'int8                                    ', 'Numpre do debito', '', 'Numpre do debito', 11, false, false, false, 1, 'text', 'Numpre do debito');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k176_numpar                              ', 'int4                                    ', 'Numpar do debito', '', 'Numpar do debito', 11, false, true, false, 0, 'text', 'Numpar do debito');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k176_dtcriacao                           ', 'date                                    ', 'Data de criação', '', 'Data de Início', 10, false, false, false, 1, 'text', 'Data de Início');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k176_qrcode                              ', 'text                                    ', 'QRCode', '', 'QRCode', 1, false, false, false, 1, 'text', 'QRCode');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k176_hist                                ', 'text                                    ', 'Histórico', '', 'Histórico', 1, false, false, false, 1, 'text', 'Código do Usuário');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k176_instituicao_financeira              ', 'int8                                    ', 'Código da Instituição Financeira', '', 'Código da Instituição Financeira', 11, false, true, false, 0, 'text', 'Código da Instituição Financeira');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'k176_sequencial'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'k176_numnov'), 2, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'k176_numpre'), 3, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'k176_numpar'), 4, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'k176_dtcriacao'), 5, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'k176_qrcode'), 6, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'k176_hist'), 7, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'k176_instituicao_financeira'), 8, 0);

        INSERT INTO db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select codarq from db_sysarquivo where nomearq = 'recibopaga_qrcode_pix'), (select codcam from db_syscampo where nomecam = 'k176_sequencial'), 1, 0, 0);

        INSERT INTO db_sysarquivo (codarq, nomearq, descricao, sigla, dataincl, rotulo, tipotabela, naolibclass, naolibfunc, naolibprog, naolibform) VALUES ((select max(codarq)+1 from db_sysarquivo), 'instituicoes_financeiras_api_pix', 'Instituições Financeiras habilitadas', 'k175', '2022-12-30', 'Instituições Financeiras habilitadas', 0, false, false, false, false);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k175_sequencial                          ', 'int8                                    ', 'Código Sequencial', '', 'Código Sequencial', 11, false, false, false, 1, 'text', 'Código Sequencial');
        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k175_nome                             ', 'varchar(200)                            ', 'Nome', '', 'Nome', 200, false, true, false, 0, 'text', 'Nome');

        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'k175_sequencial'), 1, 0);
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'k175_nome'), 2, 0);

        INSERT INTO db_sysprikey (codarq, codcam, sequen, referen, camiden) VALUES ((select codarq from db_sysarquivo where nomearq = 'instituicoes_financeiras_api_pix'), (select codcam from db_syscampo where nomecam = 'k175_sequencial'), 1, 0, 0);


SQL;
        $this->execute($sql);
    }

    private function dropDicionarioDados()
    {
        $fields = [
            'k176_sequencial',
            'k176_numnov',
            'k176_numpre',
            'k176_numpar',
            'k176_dtcriacao',
            'k176_qrcode',
            'k176_hist',
            'k176_instituicao_financeira',
            'k175_sequencial',
            'k175_nome',
            'k177_sequencial',
            'k177_instituicao_financeira',
            'k177_develop_application_key',
            'k177_url_api',
            'k177_url_oauth',
            'k177_client_id',
            'k177_client_secret',
            'k177_numero_convenio',
            'k177_ambiente',
            'k177_chave_pix',
        ];

        $this->execute("delete from db_sysprikey where codcam in (select codcam from db_syscampo where nomecam = 'k175_sequencial')");
        $this->execute("delete from db_sysprikey where codcam in (select codcam from db_syscampo where nomecam = 'k176_sequencial')");
        $this->execute("delete from db_sysprikey where codcam in (select codcam from db_syscampo where nomecam = 'k177_sequencial')");

        $this->execute("delete from db_sysarqcamp where codarq in (select codarq from db_sysarquivo where nomearq = 'recibopaga_qrcode_pix')");
        $this->execute("delete from db_sysarqcamp where codarq in (select codarq from db_sysarquivo where nomearq = 'instituicoes_financeiras_api_pix')");
        $this->execute("delete from db_sysarqcamp where codarq in (select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil')");

        foreach ($fields as $field) {
            $this->execute("delete from db_syscampo where nomecam = '{$field}'");
        }
        $this->execute("delete from db_sysarqmod where codmod = ".self::COD_MODULO_ARRECADACAO." and codarq in (select codarq from db_sysarquivo where nomearq = 'recibopaga_qrcode_pix')");
        $this->execute("delete from db_sysarqmod where codmod = ".self::COD_MODULO_ARRECADACAO." and codarq in (select codarq from db_sysarquivo where nomearq = 'instituicoes_financeiras_api_pix')");
        $this->execute("delete from db_sysarqmod where codmod = ".self::COD_MODULO_ARRECADACAO." and codarq in (select codarq from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil')");
        $this->execute("delete from db_sysarquivo where nomearq = 'recibopaga_qrcode_pix'");
        $this->execute("delete from db_sysarquivo where nomearq = 'instituicoes_financeiras_api_pix'");
        $this->execute("delete from db_sysarquivo where nomearq = 'configuracoes_pix_banco_do_brasil'");
    }

    private function createSettingsFields()
    {
        $table = $this->table(
            'numpref',
            [
                'id' => false,
                'primary_key' => ['k03_anousu', 'k03_instit'],
                'schema' => 'caixa'
            ]
        );

        $refTableInstituicaoFinanceira = $this->table(
            'instituicoes_financeiras_api_pix',
            [
                'id' => false,
                'primary_key' => ['k175_sequencial'],
                'schema' => 'arrecadacao'
            ]
        );

        $table->addColumn('k03_ativo_integracao_pix', 'boolean', ['default' => false]);
        $table->addColumn('k03_instituicao_financeira', 'integer', ['null' => true]);
        $table->addForeignKey('k03_instituicao_financeira', $refTableInstituicaoFinanceira, 'k175_sequencial');
        $table->save();
    }

    private function dropColumnsSettings()
    {
        $table = $this->table(
            'numpref',
            [
                'id' => false,
                'primary_key' => ['k03_anousu', 'k03_instit'],
                'schema' => 'caixa'
            ]
        );
        $table->removeColumn('k03_ativo_integracao_pix');
        $table->removeColumn('k03_instituicao_financeira');
        $table->save();
    }

    private function insertDicionarioDadosSettingsFields()
    {
        $sql = <<<SQL
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k03_ativo_integracao_pix', 'bool', 'Identifica se a integração com o pix está ativada', 'f', 'Ativo', 1, false, false, false, 5, 'text', 'Ativo');
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'k03_instituicao_financeira', 'int8', 'Código da Instituição Financeira', '', 'Código da Instituição Financeira', 11, false, true, false, 0, 'text', 'Código da Instituição Financeira');

            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'numpref'), (select codcam from db_syscampo where nomecam = 'k03_ativo_integracao_pix'), 39, 0);
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select codarq from db_sysarquivo where nomearq = 'numpref'), (select codcam from db_syscampo where nomecam = 'k03_instituicao_financeira'), 40, 0);
SQL;
        $this->execute($sql);
    }

    private function dropDicionarioDadosSettingsFields()
    {
        $fields = [
            'k03_ativo_integracao_pix',
            'k03_instituicao_financeira'
        ];

        foreach ($fields as $field) {
            $this->execute(
                "delete from db_sysarqcamp
                    where codarq in (
                    select codarq from db_sysarquivo where nomearq = 'numpref')
                      and codcam in (select codcam from db_syscampo where nomecam = '".$field."')");
            $this->execute("delete from db_syscampo where nomecam = '".$field."'");
        }
    }
}
