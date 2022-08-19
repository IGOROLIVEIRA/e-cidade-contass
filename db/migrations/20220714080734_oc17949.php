<?php

use Phinx\Migration\AbstractMigration;

class Oc17949 extends AbstractMigration
{
    public function up()
    {
        $this->createMenuInscricaoDA();
        $this->createParametroProced();
        $this->createParametroDevedorPrincipal();
        $this->obrigaCgmParaITBI();
        $this->createTableItbiDivida();
    }

    private function createMenuInscricaoDA()
    {
        $sql = "
        begin;
            INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Inscrição em Dívida Ativa', 'Rotina de Inscrição de ITBI em Dívida Ativa', 'itb1_inscrdivida001.php', 1, 1, 'Rotina de Inscrição de ITBI em Dívida Ativa', 't');
            INSERT INTO db_menu VALUES(1818,(select max(id_item) from db_itensmenu),5,2544);
        commit;
        ";
        $this->execute($sql);
    }

    private function createParametroProced()
    {
        $sql = <<<'SQL'
            BEGIN;
            ALTER TABLE paritbi ADD COLUMN it24_proced int8;
            --Inserção dos campos
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'it24_proced', 'int4', 'Procedência D.A', 'FALSE' , 'Procedência D.A', 1, false, false, false, 5, 'text', 'Procedência D.A');
            -- Vínculo tabelas com campos
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (2362, (select codcam from db_syscampo where nomecam = 'it24_proced'), 15, 0);
            COMMIT;
SQL;
        $this->execute($sql);
    }

    private function createParametroDevedorPrincipal()
    {
        $sql = <<<'SQL'
            BEGIN;
            ALTER TABLE paritbi ADD COLUMN it24_devedor int8;
            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'it24_devedor', 'int4', 'Devedor Principal', 'FALSE' , 'Devedor Principal', 1, false, false, false, 5, 'text', 'Devedor Principal');
            INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (2362, (select codcam from db_syscampo where nomecam = 'it24_devedor'), 16, 0);
            COMMIT;
SQL;
        $this->execute($sql);
    }

    private function obrigaCgmParaITBI()
    {
        $sql = <<<'SQL'
                BEGIN;
                    ALTER TABLE "itbi"."paritbi" ALTER COLUMN "it24_cgmobrigatorio" SET DEFAULT TRUE;
                    update itbi.paritbi set it24_cgmobrigatorio = true;
                COMMIT;
SQL;
        $this->execute($sql);
    }

    private function createTableItbiDivida()
    {
        $sql = <<<'SQL'
            BEGIN;
                CREATE TABLE itbi.itbi_divida (
                it36_guia int8 NOT NULL,
                it36_coddiv int8 NOT NULL,
                it36_data date NOT NULL,
                it36_usuario int8 NOT NULL,
                it36_observacao varchar(200),
                CONSTRAINT itbi_divida_pk PRIMARY KEY (it36_guia, it36_coddiv)
                );
            ALTER TABLE itbi.itbi_divida
            ADD CONSTRAINT itbi_didiva_itbi FOREIGN KEY (it36_guia)
            REFERENCES itbi;

            ALTER TABLE itbi.itbi_divida
            ADD CONSTRAINT itbi_didiva_divida FOREIGN KEY (it36_coddiv)
            REFERENCES divida;
            COMMIT;
SQL;
        $this->execute($sql);
    }
}
