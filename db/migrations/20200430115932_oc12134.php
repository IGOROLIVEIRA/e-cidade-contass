<?php

use Phinx\Migration\AbstractMigration;

class Oc12134 extends AbstractMigration
{
    public function up()
    {
        $sql = "INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Manutenção de dados', 'Manutenção de dados', '', 1, 1, 'Manutenção de dados', 't');

        INSERT INTO db_menu VALUES (32, 
            (SELECT max(id_item) FROM db_itensmenu), 
            (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 32), 
            (1));

        INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu), 'Empenhos', 'Empenhos', 'm4_empenhos.php', 1, 1, 'Empenhos', 't');

        INSERT INTO db_menu VALUES (
            (SELECT id_item from db_itensmenu where descricao = 'Manutenção de dados'), 
            (SELECT max(id_item) FROM db_itensmenu), 
            (SELECT max(menusequencia)+1 as count FROM db_menu  WHERE id_item = 32), 
            (1));

        create sequence configuracoes.db_manut_log_manut_sequencial_seq
                increment 1
                minvalue 1
                maxvalue 9223372036854775807
                start 1
                cache 1;

         create table configuracoes.db_manut_log(
                manut_sequencial    int4 not null default nextval('db_manut_log_manut_sequencial_seq'),
                manut_descricao     varchar(100) not null,
                manut_timestamp     bigint,
                manut_id_usuario    int4 not null,
                constraint db_manut_log_sequ_pk primary key (manut_sequencial));";

        $this->execute($sql);
    }
}
