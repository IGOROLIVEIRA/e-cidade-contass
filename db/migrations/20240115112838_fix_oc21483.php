<?php

use Phinx\Migration\AbstractMigration;

class FixOc21483 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        BEGIN;

                -- Cria itens de menu

                INSERT INTO db_itensmenu
                VALUES (
                            (SELECT max(id_item)+1
                             FROM db_itensmenu),'Alteração de Placa',
                                                'Alteração de Placa',
                                                '',
                                                1,
                                                1,
                                                'Alteração de Placa',
                                                't');


                INSERT INTO db_menu
                VALUES(5338,
                           (SELECT max(id_item)
                            FROM db_itensmenu),9,
                                               633);


                INSERT INTO db_itensmenu
                VALUES (
                            (SELECT max(id_item)+1
                             FROM db_itensmenu),'Alteração',
                                                'Alteração',
                                                'vei1_alterarplaca002.php',
                                                1,
                                                1,
                                                'Alteração',
                                                't');


                INSERT INTO db_menu
                VALUES(
                           (SELECT id_item
                            FROM db_itensmenu
                            WHERE descricao LIKE 'Alteração de Placa'),
                           (SELECT max(id_item)
                            FROM db_itensmenu),1,
                                               633);


                INSERT INTO db_itensmenu
                VALUES (
                            (SELECT max(id_item)+1
                             FROM db_itensmenu),'Exclusão',
                                                'Exclusão',
                                                'vei1_alterarplaca003.php',
                                                1,
                                                1,
                                                'Exclusão',
                                                't');


                INSERT INTO db_menu
                VALUES(
                           (SELECT id_item
                            FROM db_itensmenu
                            WHERE descricao LIKE 'Alteração de Placa'),
                           (SELECT max(id_item)
                            FROM db_itensmenu),2,
                                               633);

                -- Altera o campo placa para 8 caracteres

                ALTER TABLE veiculos.veiculos
                ALTER COLUMN ve01_placa TYPE varchar(8);


                UPDATE db_syscampo
                SET conteudo = 'varchar(8)',
                    tamanho = 8
                WHERE nomecam = 've01_placa';

                -- Cria o sequencial da tablea

                CREATE SEQUENCE veiculos.veiculosplaca_ve76_sequencial_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807
                START 1 CACHE 1;

                -- Cria tabela

                CREATE TABLE veiculos.veiculosplaca ( ve76_sequencial int8 NOT NULL DEFAULT nextval('veiculosplaca_ve76_sequencial_seq'),
                                                                                            ve76_veiculo int4 NOT NULL,
                                                                                                              ve76_placa varchar(8) NOT NULL,
                                                                                                                                    ve76_placaanterior varchar(8),
                                                                                                                                                       ve76_obs varchar(200),
                                                                                                                                                                ve76_data date NOT NULL,
                                                                                                                                                                               ve76_usuario int4 NOT NULL,
                                                                                                                                                                                                 ve76_criadoem TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT now(),
                                                                                                                                                                                                                                                            PRIMARY KEY (ve76_sequencial),
                                                     FOREIGN KEY (ve76_veiculo) REFERENCES veiculos.veiculos(ve01_codigo) );

                -- Insere campos no dicionário

                INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES (
                            (SELECT MAX(codcam) + 1
                             FROM db_syscampo), 've76_sequencial',
                                                'int8',
                                                'Sequencial',
                                                '',
                                                'Código',
                                                8,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                1,
                                                'text',
                                                'Código');


                INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES (
                            (SELECT MAX(codcam) + 1
                             FROM db_syscampo), 've76_veiculo',
                                                'int4',
                                                'Código Veículo',
                                                '',
                                                'Veículo',
                                                4,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                1,
                                                'text',
                                                'Veículo');


                INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES (
                            (SELECT MAX(codcam) + 1
                             FROM db_syscampo), 've76_placa',
                                                'varchar(8)',
                                                'Placa',
                                                '',
                                                'Placa Atual',
                                                8,
                                                FALSE,
                                                TRUE,
                                                FALSE,
                                                0,
                                                'text',
                                                'Placa Atual');


                INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES (
                            (SELECT MAX(codcam) + 1
                             FROM db_syscampo), 've76_placaanterior',
                                                'varchar(7)',
                                                'Placa Anterior',
                                                '',
                                                'Placa Anterior',
                                                7,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                1,
                                                'text',
                                                'Placa Anterior');


                INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES (
                            (SELECT MAX(codcam) + 1
                             FROM db_syscampo), 've76_obs',
                                                'varchar(200)',
                                                'Observação',
                                                '',
                                                'Observação',
                                                200,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                1,
                                                'text',
                                                'Observação');


                INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES (
                            (SELECT MAX(codcam) + 1
                             FROM db_syscampo), 've76_data',
                                                'date',
                                                'Data',
                                                '',
                                                'Data',
                                                10,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                1,
                                                'text',
                                                'Data');


                INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES (
                            (SELECT MAX(codcam) + 1
                             FROM db_syscampo), 've76_usuario',
                                                'int4',
                                                'Usuário',
                                                '',
                                                'Usuário',
                                                4,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                1,
                                                'text',
                                                'Usuário');


                INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
                VALUES (
                            (SELECT MAX(codcam) + 1
                             FROM db_syscampo), 've76_criadoem',
                                                'timestamp without time zone',
                                                'Criado em',
                                                '',
                                                'Criado em',
                                                NULL,
                                                FALSE,
                                                FALSE,
                                                FALSE,
                                                1,
                                                'text',
                                                'Criado em');
        ";
        $this->execute($sql);
    }
}
