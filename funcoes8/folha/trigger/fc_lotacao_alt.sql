--drop function fc_lotacao_alt();
CREATE OR REPLACE FUNCTION fc_lotacao_alt()
RETURNS TRIGGER
AS '
DECLARE 

    _LOTAC      CHAR(4);
    _MAX        INTEGER;
    _ANO	    INTEGER;
    _MES	    INTEGER;
    _ORGAO	    VARCHAR(40);
    _UNIDADE 	VARCHAR(40);

BEGIN

SELECT max(r11_anousu||lpad(r11_mesusu,2,0)) 
INTO _MAX 
FROM cfpess;

_ANO = SUBSTR(_MAX,1,4)::INT;
_MES = SUBSTR(_MAX,5,2)::INT;

    -- INCLUIR DADOS NO LOTACAO

    SELECT R13_CODIGO
    INTO _LOTAC
    FROM LOTACAO
    WHERE R13_CODIGO = NEW.R70_CODIGO
      AND R13_ANOUSU = _ANO
      AND R13_MESUSU = _MES
      and r13_instit = new.r70_instit;


--raise notice ''_lotac : %  '', _LOTAC;

    IF FOUND THEN

       UPDATE LOTACAO SET R13_DESCR = TRIM(SUBSTR(NEW.R70_DESCR,1,40)) 
       WHERE R13_CODIGO = NEW.R70_CODIGO
         AND R13_ANOUSU = _ANO
         AND R13_MESUSU = _MES
         and r13_instit = new.r70_instit;

    END IF;

    RETURN NEW;
       
END;
' LANGUAGE 'plpgsql';

