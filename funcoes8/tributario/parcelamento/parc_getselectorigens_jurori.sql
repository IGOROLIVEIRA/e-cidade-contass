create or replace function fc_parc_getselectorigens_jurori(integer,integer,integer) returns varchar as
$$
declare
  
  iParcelamento      alias for $1;
  iTipo              alias for $2;
  iTipoAnulacao      alias for $3;
  
  iAnoUsu            integer default 0;

  dDataCorrecao      date;

  sSqlRetorno     varchar default '';

begin
  
  iAnoUsu := cast( (select fc_getsession('DB_anousu')) as integer);
  if iAnoUsu is null then
    raise exception 'ERRO : Variavel de sessao [DB_anousu] nao encontrada.';
  end if;

  dDataCorrecao := cast( (select fc_getsession('DB_datausu')) as date);
  if dDataCorrecao is null then
    raise exception 'ERRO : Variavel de sessao [DB_datausu] nao encontrada.';
  end if;


  if iTipo = 1 then
    sSqlRetorno :=                ' select k00_numcgm, k00_dtoper, k00_receit, k00_hist, k00_valor, k00_dtvenc, k00_numpre, k00_numpar, k00_numtot, k00_numdig, k00_tipo, k00_tipojm, v01_exerc, v01_coddiv, ';
    sSqlRetorno := sSqlRetorno || '        termodiv.vlrcor as corrigido, ';
    sSqlRetorno := sSqlRetorno || '        termodiv.juros  as juros, ';
    sSqlRetorno := sSqlRetorno || '        termodiv.multa  as multa ';
    sSqlRetorno := sSqlRetorno || '   from termo ';
    sSqlRetorno := sSqlRetorno || '        inner join termodiv	on termo.v07_parcel 	= termodiv.parcel ';
    sSqlRetorno := sSqlRetorno || '        inner join divida   on termodiv.coddiv   	= divida.v01_coddiv ';
    sSqlRetorno := sSqlRetorno || '        inner join arreold 	on arreold.k00_numpre	= divida.v01_numpre and arreold.k00_numpar = divida.v01_numpar ';
    sSqlRetorno := sSqlRetorno || '  where termo.v07_parcel = ' || iParcelamento;
    sSqlRetorno := sSqlRetorno || '  order by v01_exerc,k00_dtvenc,k00_receit ';
  elsif iTipo = 2 then
    sSqlRetorno := sSqlRetorno || '   select distinct k00_numcgm, k00_dtoper, k00_receit, k00_hist, k00_valor, k00_dtvenc, k00_numpre, k00_numpar, k00_numtot, k00_numdig, k00_tipo, k00_tipojm, ';
    sSqlRetorno := sSqlRetorno || '          fc_corre(arreold.k00_receit,arreold.k00_dtvenc,arreold.k00_valor,v07_dtlanc, cast( extract(year from v07_dtlanc) as integer) ,v07_dtlanc) as corrigido, ';
    sSqlRetorno := sSqlRetorno || '          ( arreold.k00_valor * coalesce( fc_juros(arreold.k00_receit,arreold.k00_dtvenc,v07_dtlanc,v07_dtlanc,false,  cast( extract(year from v07_dtlanc) as integer)),0)) as juros, ';
    sSqlRetorno := sSqlRetorno || '          ( arreold.k00_valor * coalesce( fc_multa(arreold.k00_receit,arreold.k00_dtvenc,v07_dtlanc,arreold.k00_dtoper,cast( extract(year from v07_dtlanc) as integer)),0)) as multa ';
    sSqlRetorno := sSqlRetorno || '     from termoreparc ';
    sSqlRetorno := sSqlRetorno || '          inner join termo on v07_parcel            = termoreparc.v08_parcelorigem ';
    sSqlRetorno := sSqlRetorno || '          inner join arreold on arreold.k00_numpre  = termo.v07_numpre ';
    sSqlRetorno := sSqlRetorno || '   where termoreparc.v08_parcel = ' || iParcelamento;
    sSqlRetorno := sSqlRetorno || ' union all ';	-- tras os reparcelamentos de divida
    sSqlRetorno := sSqlRetorno || '   select distinct k00_numcgm, k00_dtoper, k00_receit, k00_hist, k00_valor, k00_dtvenc, k00_numpre, k00_numpar, k00_numtot, k00_numdig, k00_tipo, k00_tipojm, ';
    sSqlRetorno := sSqlRetorno || '          termodiv.vlrcor as corrigido, ';
    sSqlRetorno := sSqlRetorno || '          termodiv.juros  as juros, ';
    sSqlRetorno := sSqlRetorno || '          termodiv.multa  as multa ';
    sSqlRetorno := sSqlRetorno || '     from termoreparc ';
    sSqlRetorno := sSqlRetorno || '          inner join termo    on v07_parcel         = termoreparc.v08_parcel ';
    sSqlRetorno := sSqlRetorno || '          inner join termodiv on termo.v07_parcel 	= termodiv.parcel ';
    sSqlRetorno := sSqlRetorno || '          inner join divida 	on termodiv.coddiv   	= divida.v01_coddiv ';
    sSqlRetorno := sSqlRetorno || '          inner join arreold 	on arreold.k00_numpre	= divida.v01_numpre ';
	sSqlRetorno := sSqlRetorno || '                             and arreold.k00_numpar = divida.v01_numpar ';
    sSqlRetorno := sSqlRetorno || '   where termoreparc.v08_parcel = ' || iParcelamento;    
	sSqlRetorno := sSqlRetorno || ' union all ';	-- tras os reparcelamentos do foro
    sSqlRetorno := sSqlRetorno || '   select distinct k00_numcgm, k00_dtoper, k00_receit, k00_hist, k00_valor, k00_dtvenc, k00_numpre, k00_numpar, k00_numtot, k00_numdig, k00_tipo, k00_tipojm, ';
    sSqlRetorno := sSqlRetorno || '          termoini.vlrcor as corrigido, ';
    sSqlRetorno := sSqlRetorno || '          termoini.juros  as juros, ';
    sSqlRetorno := sSqlRetorno || '          termoini.multa  as multa ';
    sSqlRetorno := sSqlRetorno || '     from termoreparc ';
    sSqlRetorno := sSqlRetorno || '          inner join termo         on v07_parcel         = termoreparc.v08_parcel ';
    sSqlRetorno := sSqlRetorno || '          inner join termoini      on termo.v07_parcel 	 = termoini.parcel ';
    sSqlRetorno := sSqlRetorno || '          inner join inicialnumpre on inicialnumpre.v59_inicial = termoini.inicial ';
    sSqlRetorno := sSqlRetorno || '          inner join divida 	     on inicialnumpre.v59_numpre 	= divida.v01_numpre ';
    sSqlRetorno := sSqlRetorno || '          inner join arreold 	     on arreold.k00_numpre = divida.v01_numpre ';
	sSqlRetorno := sSqlRetorno || '                                  and arreold.k00_numpar = divida.v01_numpar ';
    sSqlRetorno := sSqlRetorno || '   where termoreparc.v08_parcel = ' || iParcelamento;			
	sSqlRetorno := sSqlRetorno || ' union all ';	-- tras os reparcelamentos de diversos
    sSqlRetorno := sSqlRetorno || '   select distinct k00_numcgm, k00_dtoper, k00_receit, k00_hist, k00_valor, k00_dtvenc, k00_numpre, k00_numpar, k00_numtot, k00_numdig, k00_tipo, k00_tipojm, ';
    sSqlRetorno := sSqlRetorno || '          termodiver.dv10_vlrcor as corrigido, ';
    sSqlRetorno := sSqlRetorno || '          termodiver.dv10_juros  as juros, ';
    sSqlRetorno := sSqlRetorno || '          termodiver.dv10_multa  as multa ';
    sSqlRetorno := sSqlRetorno || '     from termoreparc ';
    sSqlRetorno := sSqlRetorno || '          inner join termo         on v07_parcel                    = termoreparc.v08_parcel ';
    sSqlRetorno := sSqlRetorno || '          inner join termodiver    on termo.v07_parcel              = termodiver.dv10_parcel ';
    sSqlRetorno := sSqlRetorno || '          inner join diversos      on diversos.dv05_coddiver        = termodiver.dv10_coddiver ';
    sSqlRetorno := sSqlRetorno || '          inner join arreold 	  on arreold.k00_numpre            = diversos.dv05_numpre ';
    sSqlRetorno := sSqlRetorno || '   where termoreparc.v08_parcel = ' || iParcelamento;
	sSqlRetorno := sSqlRetorno || ' union all ';	-- tras os reparcelamentos de contribuicao de melhorias
    sSqlRetorno := sSqlRetorno || '   select distinct k00_numcgm, k00_dtoper, k00_receit, k00_hist, k00_valor, k00_dtvenc, k00_numpre, k00_numpar, k00_numtot, k00_numdig, k00_tipo, k00_tipojm, ';
    sSqlRetorno := sSqlRetorno || '          termocontrib.vlrcor as corrigido, ';
    sSqlRetorno := sSqlRetorno || '          termocontrib.juros  as juros, ';
    sSqlRetorno := sSqlRetorno || '          termocontrib.multa  as multa ';
    sSqlRetorno := sSqlRetorno || '     from termoreparc ';
    sSqlRetorno := sSqlRetorno || '          inner join termo         on v07_parcel                = termoreparc.v08_parcel ';
    sSqlRetorno := sSqlRetorno || '          inner join termocontrib  on termo.v07_parcel          = termocontrib.parcel ';
    sSqlRetorno := sSqlRetorno || '          inner join contricalc    on contricalc.d09_sequencial = termocontrib.contricalc ';
    sSqlRetorno := sSqlRetorno || '          inner join arreold 	     on arreold.k00_numpre        = contricalc.d09_numpre ';
	sSqlRetorno := sSqlRetorno || '          left  join divold  	     on arreold.k00_numpre        = divold.k10_numpre ';
	sSqlRetorno := sSqlRetorno || '                                  and arreold.k00_numpar        = divold.k10_numpar ';
	sSqlRetorno := sSqlRetorno || '                                  and arreold.k00_receit        = divold.k10_receita ';
    sSqlRetorno := sSqlRetorno || '   where ( divold.k10_numpre is null and divold.k10_numpar is null and divold.k10_receita is null ) ';
	sSqlRetorno := sSqlRetorno || '     and termoreparc.v08_parcel = ' || iParcelamento;
    sSqlRetorno := sSqlRetorno || '   order by k00_dtoper,k00_dtvenc,k00_receit ';

  elsif iTipo = 3 then  -- parcelamento de inicial 
    
    sSqlRetorno :=                'select * from ( '; 
    sSqlRetorno := sSqlRetorno || ' select distinct arreold.k00_numcgm, arreold.k00_dtoper, arreold.k00_receit, arreold.k00_hist, arreold.k00_valor, arreold.k00_dtvenc, arreold.k00_numpre, arreold.k00_numpar, arreold.k00_numtot, arreold.k00_numdig, arreold.k00_tipo, arreold.k00_tipojm, inicial, ';
    sSqlRetorno := sSqlRetorno || '        arreoldcalc.k00_vlrcor as corrigido,';         
    sSqlRetorno := sSqlRetorno || '        arreoldcalc.k00_vlrjur as juros, ';        
    sSqlRetorno := sSqlRetorno || '        arreoldcalc.k00_vlrmul as multa';
    sSqlRetorno := sSqlRetorno || '   from termo ';
    sSqlRetorno := sSqlRetorno || '        inner join termoini      on termo.v07_parcel 	 = termoini.parcel       ';
    sSqlRetorno := sSqlRetorno || '        inner join inicialnumpre on inicialnumpre.v59_inicial = termoini.inicial  ';
    sSqlRetorno := sSqlRetorno || '        inner join inicialcert   on termoini.inicial   = inicialcert.v51_inicial  ';
	sSqlRetorno := sSqlRetorno || '        inner join certdiv       on certdiv.v14_certid = inicialcert.v51_certidao ';
    sSqlRetorno := sSqlRetorno || '        inner join divida        on certdiv.v14_coddiv = divida.v01_coddiv ';
    sSqlRetorno := sSqlRetorno || '        inner join arreold 	    on arreold.k00_numpre = divida.v01_numpre ';
    sSqlRetorno := sSqlRetorno || '                                and arreold.k00_numpar = divida.v01_numpar '; 
    sSqlRetorno := sSqlRetorno || '        left join arreoldcalc   on arreoldcalc.k00_numpre = arreold.k00_numpre ';
    sSqlRetorno := sSqlRetorno || '                                and arreoldcalc.k00_numpar = arreold.k00_numpar ';
    sSqlRetorno := sSqlRetorno || '                                and arreoldcalc.k00_receit = arreold.k00_receit ';
    sSqlRetorno := sSqlRetorno || '  where termo.v07_parcel = ' || iParcelamento ;
	sSqlRetorno := sSqlRetorno || '  union ';
    sSqlRetorno := sSqlRetorno || ' select distinct arreold.k00_numcgm, arreold.k00_dtoper, arreold.k00_receit, arreold.k00_hist, arreold.k00_valor, arreold.k00_dtvenc, arreold.k00_numpre, arreold.k00_numpar, arreold.k00_numtot, arreold.k00_numdig, arreold.k00_tipo, arreold.k00_tipojm, inicial, ';
    sSqlRetorno := sSqlRetorno || '        arreoldcalc.k00_vlrcor as corrigido,';         
    sSqlRetorno := sSqlRetorno || '        arreoldcalc.k00_vlrjur as juros, ';        
    sSqlRetorno := sSqlRetorno || '        arreoldcalc.k00_vlrmul as multa';
    sSqlRetorno := sSqlRetorno || '   from termo ';
    sSqlRetorno := sSqlRetorno || '        inner join termoini    	on termo.v07_parcel 	  = termoini.parcel ';
    sSqlRetorno := sSqlRetorno || '        inner join inicialnumpre on inicialnumpre.v59_inicial = termoini.inicial ';
	sSqlRetorno := sSqlRetorno || '        inner join inicialcert   on termoini.inicial    = inicialcert.v51_inicial ';
	sSqlRetorno := sSqlRetorno || '        inner join certter       on certter.v14_certid  = inicialcert.v51_certidao ';
    sSqlRetorno := sSqlRetorno || '        inner join termo termo_origem on termo_origem.v07_parcel = certter.v14_parcel ';
    sSqlRetorno := sSqlRetorno || '        inner join arreold 	    on arreold.k00_numpre	= termo_origem.v07_numpre ';
    sSqlRetorno := sSqlRetorno || '         left join arreoldcalc   on arreoldcalc.k00_numpre = arreold.k00_numpre ';
    sSqlRetorno := sSqlRetorno || '                                and arreoldcalc.k00_numpar = arreold.k00_numpar ';
    sSqlRetorno := sSqlRetorno || '                                and arreoldcalc.k00_receit = arreold.k00_receit ';
    sSqlRetorno := sSqlRetorno || '  where termo.v07_parcel = ' || iParcelamento;
    sSqlRetorno := sSqlRetorno || '  ) as x order by k00_dtvenc,k00_dtoper,k00_receit ';

	elsif iTipo = 4 then -- parcelamento de diveros
    sSqlRetorno :=                ' select k00_numcgm, k00_dtoper, k00_receit, k00_hist, k00_valor, k00_dtvenc, k00_numpre, k00_numpar, k00_numtot, k00_numdig, k00_tipo, k00_tipojm, ';
    sSqlRetorno := sSqlRetorno || '        termodiver.dv10_vlrcor as corrigido, ';
    sSqlRetorno := sSqlRetorno || '        termodiver.dv10_juros  as juros, ';
    sSqlRetorno := sSqlRetorno || '        termodiver.dv10_multa  as multa ';
    sSqlRetorno := sSqlRetorno || '   from termo ';
    sSqlRetorno := sSqlRetorno || '        inner join termodiver	on termo.v07_parcel      	= termodiver.dv10_parcel ';
    sSqlRetorno := sSqlRetorno || '        inner join diversos   on diversos.dv05_coddiver = termodiver.dv10_coddiver ';
    sSqlRetorno := sSqlRetorno || '        inner join arreold   	on arreold.k00_numpre 	  = diversos.dv05_numpre ';
    sSqlRetorno := sSqlRetorno || '  where termo.v07_parcel = ' || iParcelamento;
    sSqlRetorno := sSqlRetorno || '  order by k00_dtoper,k00_dtvenc,k00_receit ';
	elsif iTipo = 5 then -- parcelamento de contribuicao de melhorias
    sSqlRetorno :=                ' select k00_numcgm, k00_dtoper, k00_receit, k00_hist, k00_valor, k00_dtvenc, k00_numpre, k00_numpar, k00_numtot, k00_numdig, k00_tipo, k00_tipojm, ';
    sSqlRetorno := sSqlRetorno || '        termocontrib.vlrcor as corrigido, ';
    sSqlRetorno := sSqlRetorno || '        termocontrib.juros  as juros, ';
    sSqlRetorno := sSqlRetorno || '        termocontrib.multa  as multa ';
    sSqlRetorno := sSqlRetorno || '   from termo ';
    sSqlRetorno := sSqlRetorno || '        inner join termocontrib on termo.v07_parcel          = termocontrib.parcel     ';
    sSqlRetorno := sSqlRetorno || '        inner join contricalc   on contricalc.d09_sequencial = termocontrib.contricalc ';
    sSqlRetorno := sSqlRetorno || '        inner join arreold	  	on arreold.k00_numpre        = contricalc.d09_numpre   ';
		-- left com divold porque o numpre da contricalc pode estar na arreold tanto por parcelamento como por importacao de divida mais como o que interessa e so os 
		-- registros referente ao parcelamento dou um left com divold para garantir que nao vira registros que sao oriundos da divida
	sSqlRetorno := sSqlRetorno || '        left  join divold       on arreold.k00_numpre        = divold.k10_numpre '; 
	sSqlRetorno := sSqlRetorno || '                               and arreold.k00_numpar        = divold.k10_numpar ';
	sSqlRetorno := sSqlRetorno || '                               and arreold.k00_receit        = divold.k10_receita ';
    sSqlRetorno := sSqlRetorno || '   where ( divold.k10_numpre is null and divold.k10_numpar is null and divold.k10_receita is null ) ';
    sSqlRetorno := sSqlRetorno || '     and termo.v07_parcel = ' || iParcelamento;
    sSqlRetorno := sSqlRetorno || '   order by k00_dtoper,k00_dtvenc,k00_receit ';
  end if;
  
  return sSqlRetorno;
  
end;
$$  language 'plpgsql';
