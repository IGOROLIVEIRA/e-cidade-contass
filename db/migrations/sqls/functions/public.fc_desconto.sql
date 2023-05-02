CREATE OR REPLACE FUNCTION public.fc_desconto(
	integer,
	date,
	double precision,
	double precision,
	boolean,
	date,
	integer,
	integer)
    RETURNS double precision
    LANGUAGE 'plpgsql'
    COST 100
    VOLATILE PARALLEL UNSAFE
AS $BODY$
declare
receita              alias for $1;
  v_data_arre          alias for $2;
  valor                alias for $3;
  jurmulta             alias for $4;
  unica                alias for $5;
  v_data_venc          alias for $6;
  subdir               alias for $7;
  numpre               alias for $8;

  z99_carnes           char(10);
  descon               float8  default 0;
  v_tabrec             record;
  v_recibounica        integer;
  v_entroudesctabrecjm boolean default false;
  recunica             record;

  lRaise              boolean default false;

  dtDataVencimentoUnica    date;

begin

  lRaise := ( case when fc_getsession('DB_debugon') is null then false else true end );

  if lRaise is true then
    if fc_getsession('db_debug') <> '' then
      perform fc_debug('<desconto> Iniciando processamento', lRaise, false, false);
else
      perform fc_debug('<desconto> Iniciando processamento', lRaise, true, false);
end if;
end if;

select *
into v_tabrec
from tabrec
         inner join tabrecjm  on tabrec.k02_codjm = tabrecjm.k02_codjm
where k02_codigo = receita;

if not found then
    return 0;
end if;

  if unica is true then

    if lRaise is true then
      perform fc_debug('<desconto>  ', lRaise, false, false);
      perform fc_debug('<desconto> acessou unica is true - receita: '||receita||' - v_tabrec: '||v_tabrec.k02_codjm, lRaise, false, false);
      perform fc_debug('<desconto> k02_dtdes4: '||v_tabrec.k02_dtdes4||' - k02_dtdes4: '||v_tabrec.k02_dtdes4||' - k02_dtdes5: '||v_tabrec.k02_dtdes5||', k02_dtdes5: '||v_tabrec.k02_dtdes5, lRaise, false, false);
end if;

--if v_recibounica = 0 then

    if lRaise is true then
      perform fc_debug('<desconto> v_data_arre: '||v_data_arre||'  - v_data_venc: '||v_data_venc, lRaise, false, false);
end if;

    if not v_tabrec.k02_dtdes4 isnull and v_data_arre <= v_tabrec.k02_dtdes4 then

      if lRaise is true then
        perform fc_debug('<desconto>    entrou no if 1 do k02_dtdes4...', lRaise, false, false);
end if;

      if ( not v_tabrec.k02_caldes isnull and v_tabrec.k02_caldes = 't' ) or ( v_tabrec.k02_caldes = 'f' and v_data_venc >= v_data_arre ) then

        descon               := ( v_tabrec.k02_desco4 / 100::float8 );
        v_entroudesctabrecjm := true;

        if lRaise is true then
          perform fc_debug('<desconto>       entrou no if 2 do k02_dtdes4... k02_desco4: '||v_tabrec.k02_desco4||' - descon: '||descon, lRaise, false, false);
end if;

end if;

else
      if not v_tabrec.k02_dtdes5 isnull and v_data_arre <= v_tabrec.k02_dtdes5 then
        if lRaise is true then
          perform fc_debug('<desconto>    entrou no if 3 do k02_dtdes4...', lRaise, false, false);
end if;
        if ( not v_tabrec.k02_caldes isnull and v_tabrec.k02_caldes = 't' ) or ( v_tabrec.k02_caldes = 'f' and v_data_venc >= v_data_arre ) then
          descon               := ( v_tabrec.k02_desco5 / 100::float8 );
          v_entroudesctabrecjm := true;
          if lRaise is true then
            perform fc_debug('<desconto>       entrou no if 4 do k02_dtdes4... k02_desco4: '||v_tabrec.k02_desco4||' - descon: '||descon, lRaise, false, false);
end if;
end if;
else
        if not v_tabrec.k02_dtdes6 isnull and v_data_arre <= v_tabrec.k02_dtdes6 then
          if lRaise is true then
            perform fc_debug('<desconto>    entrou no if 5 do k02_dtdes4...', lRaise, false, false);
end if;
          if ( not v_tabrec.k02_caldes isnull and v_tabrec.k02_caldes = 't' ) or ( v_tabrec.k02_caldes = 'f' and v_data_venc >= v_data_arre ) then
            descon               := ( v_tabrec.k02_desco6 / 100::float8 );
            v_entroudesctabrecjm := true;
            if lRaise is true then
              perform fc_debug('<desconto>       entrou no if 6 do k02_dtdes4... k02_desco4: '||v_tabrec.k02_desco4||' - descon: '||descon, lRaise, false, false);
end if;
end if;
end if;
end if;
end if;

--          end if;


    if lRaise is true then
      perform fc_debug('<desconto>    v_entroudesctabrecjm: '||v_entroudesctabrecjm, lRaise, false, false);
end if;

    if v_entroudesctabrecjm is false or (unica is true and v_tabrec.k02_caldes is false) then

      v_recibounica := 0;


for recunica in

select k00_dtvenc,
       k00_percdes,
       k00_receit
from recibounica
where recibounica.k00_numpre = numpre
  and v_data_arre <= fc_proximo_dia_util(recibounica.k00_dtvenc)
  order by k00_dtvenc

    loop

        if lRaise is true then
          perform fc_debug('<desconto> Encontrou percentual desconto da Tabela recibounica', lRaise, false, false);
end if;

        if v_recibounica = 0 and v_data_arre <= fc_proximo_dia_util(recunica.k00_dtvenc)
            and (recunica.k00_receit = 0 OR recunica.k00_receit = receita) then

          descon        := descon + ( recunica.k00_percdes / 100::float8 );
          v_recibounica := 1;
end if;

end loop;

end if;

else

    if not v_tabrec.k02_dtdes1 isnull and v_data_arre <= v_tabrec.k02_dtdes1 then

      if ( not v_tabrec.k02_caldes isnull and v_tabrec.k02_caldes = 't' ) or ( v_tabrec.k02_caldes = 'f' and v_data_venc >= v_data_arre )   then
        descon := ( v_tabrec.k02_desco1 / 100::float8 ) ;
end if;

else

      if not v_tabrec.k02_dtdes2 isnull and v_data_arre <= v_tabrec.k02_dtdes2 then

        if ( not v_tabrec.k02_caldes isnull and v_tabrec.k02_caldes = 't' ) or ( v_tabrec.k02_caldes = 'f' and v_data_venc >= v_data_arre )   then
          descon := ( v_tabrec.k02_desco2 / 100::float8 ) ;
end if;

else

        if not v_tabrec.k02_dtdes3 isnull and v_data_arre <= v_tabrec.k02_dtdes3 then

          if ( not v_tabrec.k02_caldes isnull and v_tabrec.k02_caldes = 't' ) or ( v_tabrec.k02_caldes = 'f' and v_data_venc >= v_data_arre )   then
            descon := ( v_tabrec.k02_desco3 / 100::float8 ) ;
end if;
end if;

end if;
end if;

end if;

  if lRaise is true then
    perform fc_debug('<desconto> descon: '||descon, lRaise, false, false);
end if;

  if descon <> 0 then
    if not v_tabrec.k02_integr isnull and v_tabrec.k02_integr = 't' then
      descon := round( ( valor + jurmulta ) * descon ,2)::float8 ;
else
      descon := round( valor * descon ,2)::float8 ;
end if;
end if;

  if lRaise is true then
    perform fc_debug('<desconto> Fim do processamento. Retorno: '||round(descon,2), lRaise, false, true);
end if;
return round(descon,2);
end;
$BODY$;

ALTER FUNCTION public.fc_desconto(integer, date, double precision, double precision, boolean, date, integer, integer)
    OWNER TO dbportal;