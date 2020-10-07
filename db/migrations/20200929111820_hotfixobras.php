<?php

use Phinx\Migration\AbstractMigration;

class Hotfixobras extends AbstractMigration
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

                ALTER TABLE licobrasanexo ADD COLUMN obr04_anexo oid;

                CREATE TEMP TABLE arquivosobras(
                    sequencial SERIAL,
                    sequenciadocumento bigint,
                    caminhoarquivo varchar(150)
                );
                
                insert into arquivosobras(sequenciadocumento, caminhoarquivo)  
                    (SELECT DISTINCT obr04_sequencial, obr04_codimagem
                        FROM licobrasanexo
                            WHERE obr04_codimagem IS not NULL);
                
                CREATE OR REPLACE FUNCTION setArquivo() RETURNS
                SETOF arquivosobras AS $$
                DECLARE
                    r arquivosobras%rowtype;
                
                BEGIN
                    FOR r IN SELECT * FROM arquivosobras
                    LOOP
                
                        UPDATE licobrasanexo SET obr04_anexo = (lo_import('/var/www/e-cidade/imagens/obras/'||r.caminhoarquivo)) WHERE obr04_sequencial = r.sequenciadocumento;
                
                        RETURN NEXT r;
                
                    END LOOP;
                    RETURN;
                END
                $$ LANGUAGE plpgsql;
                
                ALTER TABLE licobrasanexo DROP COLUMN obr04_codimagem;
                
                SELECT *
                FROM setArquivo();
                DROP FUNCTION setArquivo();
            COMMIT;

SQL;
    }
}
