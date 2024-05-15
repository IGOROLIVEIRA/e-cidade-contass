CREATE OR REPLACE FUNCTION fc_proprietario_nome(integer)
  RETURNS character varying AS
$BODY$
DECLARE
        V_MATRIC		ALIAS FOR $1;

        V_CGM			INTEGER;
        V_NOME			VARCHAR(100);
	V_TEXTOPROMI		VARCHAR(100) DEFAULT '';

BEGIN

select  coalesce(trim(j18_textoprom)||' ','')
	into V_TEXTOPROMI
	from cfiptu
	order by j18_anousu desc limit 1;

select 	J41_NUMCGM
	INTO V_CGM
	from promitente
	where 	J41_MATRIC = V_MATRIC AND
		J41_TIPOPRO IS TRUE;

	if V_CGM is null then
	  select J01_NUMCGM
	  	 INTO V_CGM
		 FROM IPTUBASE
		 WHERE J01_MATRIC = V_MATRIC;
	end if;

        if V_CGM is null then
	  V_NOME = '';
	else
	  select  z01_nome
		  into V_NOME
		  from CGM
		  WHERE z01_numcgm = V_CGM;
        end if;

	V_NOME = substr(V_TEXTOPROMI || ' ' || V_NOME,1,40);

RETURN TO_CHAR(V_CGM, '999999') ||  V_NOME;

END;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION fc_proprietario_nome(integer)
  OWNER TO dbportal;