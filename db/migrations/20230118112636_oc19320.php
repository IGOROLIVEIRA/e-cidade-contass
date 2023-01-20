<?php

use Phinx\Migration\AbstractMigration;

class Oc19320 extends AbstractMigration
{
    public function up()
    {

        $sql = <<<SQL

        BEGIN;

        SELECT fc_startsession();

        CREATE OR REPLACE FUNCTION public.fc_estruturaldotacao(integer, integer)
        RETURNS character varying
        LANGUAGE plpgsql
        AS $$
        DECLARE

        ANOUSU ALIAS FOR $1;
        CODDOT ALIAS FOR $2;
        ESTRUTURAL VARCHAR(200);

        BEGIN

        SELECT LPAD(O58_ORGAO,2,0)||'.'||
                LPAD(O58_UNIDADE,2,0)||'.'||
                LPAD(O58_FUNCAO,2,0)||'.'||
                LPAD(O58_SUBFUNCAO,3,0)||'.'||
                LPAD(O58_PROGRAMA,4,0)||'.'||
        LPAD(O58_PROJATIV,4,0)||'.'||
                LPAD(O56_ELEMENTO,13,0)||'.'||
                case when ANOUSU > 2022 THEN
                LPAD(O58_CODIGO,8,0)
                else
                LPAD(O58_CODIGO,4,0)
                END
        INTO ESTRUTURAL
        FROM ORCDOTACAO D
            INNER JOIN ORCELEMENTO O ON O.O56_CODELE = D.O58_CODELE AND O.O56_ANOUSU = D.O58_ANOUSU
        WHERE D.O58_ANOUSU = ANOUSU AND D.O58_CODDOT = CODDOT;
        
        RETURN ESTRUTURAL;
        
        END;
        $$
        ;


        CREATE OR REPLACE FUNCTION public.fc_estruturalreceita(integer, integer)
        RETURNS character varying
        LANGUAGE plpgsql
        AS $$
        DECLARE

        ANOUSU ALIAS FOR $1;
        CODREC ALIAS FOR $2;
        ESTRUTURAL VARCHAR(200);

        BEGIN

        SELECT SUBSTR(O57_FONTE,1,1)||'.'||
                SUBSTR(O57_FONTE,2,1)||'.'||
                SUBSTR(O57_FONTE,3,1)||'.'||
                SUBSTR(O57_FONTE,4,1)||'.'||
                SUBSTR(O57_FONTE,5,1)||'.'||
                SUBSTR(O57_FONTE,6,2)||'.'||
                SUBSTR(O57_FONTE,8,2)||'.'||
                SUBSTR(O57_FONTE,10,2)||'.'||
                SUBSTR(O57_FONTE,12,2)||'.'||
                SUBSTR(O57_FONTE,14,2)||'.'||
                case when ANOUSU > 2022 THEN
                LPAD(O70_CODIGO,8,0)
                else
                LPAD(O70_CODIGO,4,0)
                END
        INTO ESTRUTURAL
        FROM ORCRECEITA R
            INNER JOIN ORCFONTES O ON O.O57_CODFON = R.O70_CODFON AND O.O57_ANOUSU = R.O70_ANOUSU
        WHERE R.O70_ANOUSU = ANOUSU AND R.O70_CODREC = CODREC;
        
        RETURN ESTRUTURAL;
        
        END;
        $$
        ;

        update db_syscampo set tamanho = '8' where nomecam = 'o58_codigo' and rotulo = 'Tipo de Recurso';

        
        COMMIT;

SQL;
        $this->execute($sql);
    } 
}
