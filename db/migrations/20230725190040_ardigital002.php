<?php


use Phinx\Migration\AbstractMigration;

class Ardigital002 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        BEGIN;
            INSERT INTO CONFIGURACOES.DB_LAYOUTCAMPOS(
                DB52_CODIGO,
                DB52_LAYOUTLINHA,
                DB52_NOME,
                DB52_DESCR,
                DB52_LAYOUTFORMAT,
                DB52_POSICAO,
                DB52_DEFAULT,
                DB52_TAMANHO,
                DB52_IDENT,
                DB52_IMPRIMIR,
                DB52_ALINHA,
                DB52_OBS,
                DB52_QUEBRAAPOS)
            VALUES (
                (SELECT nextval('db_layoutcampos_db52_codigo_seq')),
                (SELECT db51_codigo from db_layoutlinha where db51_layouttxt = 26),
                'numero_etiqueta',
                'NUMERO ETIQUETA AR DIGITAL',
                1,
                1808,
                '000000000',
                '9',
                false,
                true,
                'd',
                'NUMERO FORNECIDO PELOS CORREIOS',
                0
            );
        COMMIT;
SQL;
        $this->execute($sql);
    }

    public function down()
    {
        $this->execute("
                    DELETE
                    FROM CONFIGURACOES.DB_LAYOUTCAMPOS
                    WHERE DB52_LAYOUTLINHA =
                            (SELECT DB51_CODIGO
                                FROM DB_LAYOUTLINHA
                                WHERE DB51_LAYOUTTXT = 26)
                        AND DB52_NOME = 'numero_etiqueta'
        ");
    }
}
