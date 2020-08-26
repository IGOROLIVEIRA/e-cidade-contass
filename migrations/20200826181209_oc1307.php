<?php

use Phinx\Migration\AbstractMigration;

class Oc1307 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sql = <<<SQL

        BEGIN;
        
        SELECT fc_startsession();

        INSERT INTO db_estruturavalor
        VALUES (NEXTVAL('db_estruturavalor_db121_sequencial_seq'),
            5,
            '162',
            'TRANSF. PARA APLIC. ACOES EMERG. DE APOIO AO SETOR CULTURAL',
            0,
            1,
            1),
        (NEXTVAL('db_estruturavalor_db121_sequencial_seq'),
            5,
            '163',
            'TRANSFERENCIAS DE CONVENIOS VINCULADOS A SEGURANÇA PUBLICA',
            0,
            1,
            1),
        (NEXTVAL('db_estruturavalor_db121_sequencial_seq'),
            5,
            '164',
            'EMENDAS PARLAMENTARES INDIVIDUAIS - TRANSFERENCIA ESPECIAL',
            0,
            1,
            1),
        (NEXTVAL('db_estruturavalor_db121_sequencial_seq'),
            5,
            '165',
            'OUTROS RECURSOS VINCULADOS',
            0,
            1,
            1),
        (NEXTVAL('db_estruturavalor_db121_sequencial_seq'),
            5,
            '262',
            'TRANSF. PARA APLIC. ACOES EMERG. DE APOIO AO SETOR CULTURAL',
            0,
            1,
            1),
        (NEXTVAL('db_estruturavalor_db121_sequencial_seq'),
            5,
            '263',
            'TRANSFERENCIAS DE CONVENIOS VINCULADOS A SEGURANÇA PUBLICA',
            0,
            1,
            1),
        (NEXTVAL('db_estruturavalor_db121_sequencial_seq'),
            5,
            '264',
            'EMENDAS PARLAMENTARES INDIVIDUAIS - TRANSFERENCIA ESPECIAL',
            0,
            1,
            1),
        (NEXTVAL('db_estruturavalor_db121_sequencial_seq'),
            5,
            '265',
            'OUTROS RECURSOS VINCULADOS',
            0,
            1,
            1);

        INSERT INTO orctiporec
        VALUES (162,
            'TRANSF. PARA APLIC. ACOES EMERG. DE APOIO AO SETOR CULTURAL',
            '162',
            'Recursos de transferência da União destinados a ações emergenciais de apoio ao setor cultural, nos termos da  Lei nº 14.017, de 29 de junho de 2020.',
            2,
            NULL,
            (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '162'),
            19900000),
        (163,
            'TRANSFERENCIAS DE CONVENIOS VINCULADOS A SEGURANÇA PUBLICA',
            '163',
            'Recursos provenientes do Fundo Nacional de Segurança Pública recebidos por meio  de convênio, de contrato de repasse ou de instrumento congênere, nos termos do disposto no inciso II do caput do artigo 7º da Lei nº 13.756/2018.',
            2,
            NULL,
            (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '163'),
            19900000),
        (164,
            'EMENDAS PARLAMENTARES INDIVIDUAIS - TRANSFERENCIA ESPECIAL',
            '164',
            'Recursos provenientes de emendas individuais impositivas nos termos do art. 166-A, inciso I, da Constituição Federal e do art. 160-A, incisos I,  da Constituição do Estado de Minas Gerais.',
            2,
            NULL,
            (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '164'),
            15500000),
        (165,
            'OUTROS RECURSOS VINCULADOS',
            '165',
            'Recursos cuja aplicação seja vinculada e não tenha sido enquadrado em outras especificações.',
            2,
            NULL,
            (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '165'),
            19900000),
        (262,
            'TRANSF. PARA APLIC. ACOES EMERG. DE APOIO AO SETOR CULTURAL',
            '262',
            'Recursos de transferência da União destinados a ações emergenciais de apoio ao setor cultural',
            2,
            NULL,
            (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '262'),
            29900000),
        (263,
            'TRANSFERENCIAS DE CONVENIOS VINCULADOS A SEGURANÇA PUBLICA',
            '263',
            'Recursos provenientes DO Fundo Nacional de Segurança Pública recebidos por meio de convênio,de contrato de repasse ou de instrumento congênere, nos termos DO disposto NO inciso II DO caput DO artigo 7º da Lei nº 13.756/2018.',
            2,
            NULL,
            (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '263'),
            29900000),
        (264,
            'EMENDAS PARLAMENTARES INDIVIDUAIS - TRANSFERENCIA ESPECIAL',
            '264',
            'Recursos provenientes de emendas individuais impositivas nos termos DO art. 166-A, inciso I, da Constituição Federal e DO art. 160-A, incisos I, da Constituição DO Estado de Minas Gerais.',
            2,
            NULL,
            (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '264'),
            25500000),
        (265,
            'OUTROS RECURSOS VINCULADOS',
            '265',
            'Recursos cuja aplicação seja vinculada e não tenha sido enquadrado em outras especificações.',
            2,
            NULL,
            (SELECT max(db121_sequencial) FROM db_estruturavalor WHERE db121_estrutural = '265'),
            29900000);

        COMMIT;
        
        SQL;

        $this->execute($sql);

    }
}
