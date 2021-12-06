<?php

use Phinx\Migration\AbstractMigration;

class Evento2200 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        BEGIN;
        SELECT fc_startsession();

        ALTER TABLE pessoal.rhpessoalmov ADD rh02_tipojornada int4 NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_horarionoturno boolean NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_cnpjcedente varchar(100) NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_mattraborgcedente varchar(100) NULL;
        ALTER TABLE pessoal.rhpessoalmov ADD rh02_dataadmisorgcedente date NULL;

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_tipojornada', 'int4', 'Tipo de Jornada', '', 'Tipo de Jornada', 3, false, false, false, 1, 'text', 'Tipo de Jornada');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (597, (select codcam from db_syscampo where nomecam = 'rh02_tipojornada'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_horarionoturno', 'boolean', 'Possui Horário Noturno', '', 'Possui Horário Noturno', 3, false, false, false, 1, 'text', 'Possui Horário Noturno');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (597, (select codcam from db_syscampo where nomecam = 'rh02_horarionoturno'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_cnpjcedente', 'varchar(100)', 'CNPJ Cedente', '', 'CNPJ Cedente', 3, false, false, false, 1, 'text', 'CNPJ Cedente');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (1186, (select codcam from db_syscampo where nomecam = 'rh02_cnpjcedente'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_mattraborgcedente', 'varchar(100)', 'Matricula do Trabalhador no órgão Cedente', '', 'Matricula do Trabalhador no órgão Cedente', 3, false, false, false, 1, 'text', 'Matricula do Trabalhador no órgão Cedente');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (561, (select codcam from db_syscampo where nomecam = 'rh02_mattraborgcedente'), 5, 0);

        INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'rh02_dataadmisorgcedente', 'date', 'Data de Admissão no órgão Cedente', '', 'Data de Admissão no órgão Cedente', 3, false, false, false, 1, 'text', 'Data de Admissão no órgão Cedente');
        INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (561, (select codcam from db_syscampo where nomecam = 'rh02_dataadmisorgcedente'), 5, 0);

        COMMIT;

SQL;
        $this->execute($sql);
    }
}
