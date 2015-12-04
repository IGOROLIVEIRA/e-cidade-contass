drop   function fc_retornacomposicao(integer, integer, integer, date, date, integer, date);
drop   function fc_retornacomposicao(integer, integer, integer, integer, date, date, integer, date);

drop   type retornacomposicao; 
create type retornacomposicao as (  rnComposCorrecao   numeric(15,2),
                                    rnComposJuros      numeric(15,2),
                                                                  rnComposMulta      numeric(15,2),
                                    rnCorreComposJuros numeric(15,2),
                                    rnCorreComposMulta numeric(15,2),
                                    rtRetorno          varchar,
                                                                  rbErro boolean);

create or replace function fc_retornacomposicao(integer, integer, integer, integer, date, date, integer, date) returns retornacomposicao as 
$$
declare

  numpre   alias for $1;
  numpar   alias for $2;
  receit   alias for $3;
  hist     alias for $4;
  dtoper   alias for $5;
  dtvenc   alias for $6;
  anousu   alias for $7;
  datavenc alias for $8;

  v_composicao record;

  v_raise boolean default false;

  nComposCorrecao   numeric(15,2) default 0;
  nComposJuros      numeric(15,2) default 0;
  nComposMulta      numeric(15,2) default 0;

  nCorreComposJuros numeric(15,2) default 0;
  nCorreComposMulta numeric(15,2) default 0;

  nTeste float default 0;

  rRetorno retornacomposicao%ROWTYPE;

begin
  
  v_raise  := ( case when fc_getsession('DB_debugon') is null then false else true end );
     
  rRetorno.rnComposCorrecao   := 0::numeric(15,2);
  rRetorno.rnComposJuros      := 0::numeric(15,2);
  rRetorno.rnComposMulta      := 0::numeric(15,2);
  rRetorno.rnCorreComposJuros := 0::numeric(15,2);
  rRetorno.rnCorreComposMulta := 0::numeric(15,2);
  rRetorno.rtRetorno          := ''::varchar;
  rRetorno.rbErro             := false::boolean;

  select * 
    from arreckey 
    into v_composicao
         inner join arrecadcompos   on arrecadcompos.k00_arreckey = arreckey.k00_sequencial
   where k00_numpre = numpre 
     and k00_numpar = numpar 
     and k00_receit = receit
     and k00_hist   = hist;

  if found then

--    raise notice 'aaa';

    nComposCorrecao = v_composicao.k00_correcao;
    nComposJuros    = v_composicao.k00_juros;
    nComposMulta    = v_composicao.k00_multa;

    nTeste = fc_corre(receit,dtoper,nComposJuros,dtvenc,anousu,datavenc);

    if v_raise is true then
      raise notice 'nTeste: % - nComposJuros: %', nTeste, nComposJuros;
    end if;

    nCorreComposJuros := fc_corre(receit,dtoper,nComposJuros,dtvenc,anousu,datavenc) - nComposJuros;
    nCorreComposMulta := fc_corre(receit,dtoper,nComposMulta,dtvenc,anousu,datavenc) - nComposMulta;

    if hist = 918 then
      nComposCorrecao    = nComposCorrecao*-1;
      nComposJuros       = nComposJuros*-1;
      nComposMulta       = nComposMulta*-1;
      nCorreComposJuros  = nCorreComposJuros*-1;
      nCorreComposMulta  = nCorreComposMulta*-1;
    end if;

    rRetorno.rnComposCorrecao   := nComposCorrecao;
    rRetorno.rnComposJuros      := nComposJuros;
    rRetorno.rnComposMulta      := nComposMulta;
    rRetorno.rnCorreComposJuros := nCorreComposJuros;
    rRetorno.rnCorreComposMulta := nCorreComposMulta;

  end if;
  
  if v_raise is true then
    raise notice ' ';
    raise notice 'nComposCorrecao: %', nComposCorrecao;
    raise notice 'nComposJuros: %', nComposJuros;
    raise notice 'nComposMulta: %', nComposMulta;
    raise notice 'nCorreComposJuros: %', nCorreComposJuros;
    raise notice 'nCorreComposMulta: %', nCorreComposMulta;
    raise notice ' ';
  end if;
     
  return rRetorno;
   
end;
$$ language 'plpgsql';
