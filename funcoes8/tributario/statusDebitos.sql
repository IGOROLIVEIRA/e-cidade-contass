/**
* Funcao para retornar o status do debito
*
* @param iNumpre                        integer  Numpre  do debito a ser pesquisado
* @param iNumpar                        integer  Numpar  do debito a ser pesquisado
* @param iReceit                        integer  Receita do debito a ser pesquisado
* @param tWhere                         text     String para complementar a clausula where 
* @param bRaise                         boolean  Parametro boleano abilitar ou nao a saida(debug,raise notice) da funcao
*
* @return riNumpre                      integer  Numpre  do debito a ser pesquisado
* @return riNumpar                      integer  Numpar  do debito a ser pesquisado
* @return riReceit                      integer  Receita do debito a ser pesquisado
* @return rtStatus                      text     String para com o status do debito, ABERTO, PAGO, CANCELADO E PRESCRITO
* @return rtMsgerro                     text     String para mensagem de erro
* @return rbErro                        boolean  Parametro boleano informando se ocorreu erro

* @author Robson Inacio 
* @since  30/04/2007
*
* $id$
*/

drop function fc_statusdebitos(integer);                 -- wrapper passando apenas numpre
drop function fc_statusdebitos(integer,integer);         -- wrapper passando apenas numpre e numpar
drop function fc_statusdebitos(integer,integer,integer); -- wrapper passando apenas numpre,numpar e receit

drop function fc_statusdebitos(integer,integer,integer,text,boolean);

drop   type tp_statusdebitos;
create type tp_statusdebitos as (riNumpre    integer,
                                 riNumpar    integer,
                                 riReceit    integer,
                                 rtStatus    text,
                                 rtMsgerro   text,
                                 rbErro      boolean);

create or replace function fc_statusdebitos(integer,integer,integer,text,boolean) returns setof tp_statusdebitos as
$$
declare

    iNumpre        alias for $1;
    iNumpar        alias for $2;
	iReceit		   alias for $3;
    tWhere  	   alias for $4;
    bRaise         alias for $5;
  		
	iNumpren       integer;
	iNumparn       integer;
	iReceitn       integer;

	vStatus        varchar(10);

	bTemAberto     boolean default false;
	bTemPago       boolean default false;
	bTemCancelado  boolean default false;
	bTemPrescrito  boolean default false;

	tSql           text default '';
    tWheren  	   text default ' where 1=1 ';
    tWherep  	   text default ' where k30_anulado is false ';
    tWhereb        text default ' where 1=1 ';

    rDebitos       record;

    rtp_statusdebitos tp_statusdebitos%ROWTYPE;

begin
     
	if bRaise then 
	   raise notice ' Numpre : % Numpar : % receit : % TipoRetorno : % Where : % ',iNumpre,iNumpar,iReceit,iTipoRetorno,tWhere;
	end if;
    
    rtp_statusdebitos.riNumpre  := 0;
    rtp_statusdebitos.riNumpar  := 0;
    rtp_statusdebitos.riReceit  := 0;
    rtp_statusdebitos.rbErro    := false;
    rtp_statusdebitos.rtMsgerro := '';
    rtp_statusdebitos.rtStatus  := '';		

    if iNumpre is not null then 
      tWheren := tWheren||' and k00_numpre  = '||iNumpre; 
      tWherep := tWherep||' and k30_numpre  = '||iNumpre;
      tWhereb := tWhereb||' and ar22_numpre = '||iNumpre;
	end if;
		
	if iNumpar is not null then 
      tWheren := tWheren||' and k00_numpar  = '||iNumpar; 
      tWherep := tWherep||' and k30_numpar  = '||iNumpar;
      tWhereb := tWhereb||' and ar22_numpar = '||iNumpar;
	end if;

	if iReceit is not null then 
      tWheren := tWheren||' and k00_receit = '||iReceit; 
      tWherep := tWherep||' and k30_receit = '||iReceit; 
	end if;

--		if tWhere is not null and tWhere != '' then 
--      tWheren := tWheren||' and '||tWhere;
--		end if;
		
		tSql := 'select k00_numpre,
		                k00_numpar,
						k00_receit,
						status 
			  	   from ( select k00_numpre,
								 k00_numpar,
							     k00_receit,
							     \'ABERTO\'::varchar as status
						    from arrecad
							     '||tWheren||'
						   union all
						  select k00_numpre,
							     k00_numpar,
								 k00_receit,
							     \'PAGO\'::varchar as status
						    from arrepaga
							     '||tWheren||'
						   union all
						  select k00_numpre,
							     k00_numpar,
								 k00_receit,
							     \'CANCELADO\'::varchar as status
					        from arrecant
						   inner join cancdebitosreg on k21_numpre = k00_numpre
							                        and k21_numpar = k00_numpar
						   inner join cancdebitosprocreg on k24_cancdebitosreg = k21_sequencia
							     '||tWheren||'
						   union all
						  select k30_numpre,
							     k30_numpar,
								 k30_receit,
								 \'PRESCRITO\'::varchar as status
						    from arreprescr
							     '||tWherep||'
                           union all
                          select ar22_numpre,
                                 ar22_numpar,
                                 0 as ar22_receit, 
                                 \'BLOQUEADO\'::varchar as status
                            from numprebloqpag
                                 '||tWhereb||'
						) as debitos ';

		if bRaise then
			raise notice 'SQL PRINCIPAL : % ',tSql;
		end if;

		for rDebitos in	execute tSql loop

			rtp_statusdebitos.riNumpre  := rDebitos.k00_numpre;
			rtp_statusdebitos.riNumpar  := rDebitos.k00_numpar;
			rtp_statusdebitos.riReceit := rDebitos.k00_receit;
			rtp_statusdebitos.rtStatus  := rDebitos.status;
			rtp_statusdebitos.rbErro    := false ;
			rtp_statusdebitos.rtMsgerro := '';

 			return next rtp_statusdebitos;

		end loop;
--	
		return ;
   
end;
$$ language 'plpgsql';


/**
* Funcao para retornar o status do debito ( wrapper para fc_statusdebitos original passando somente o numpre )
*
* @param iNumpre                        integer  Numpre  do debito a ser pesquisado
*
* @return riNumpre                      integer  Numpre  do debito a ser pesquisado
* @return riNumpar                      integer  Numpar  do debito a ser pesquisado
* @return riReceit                      integer  Receita do debito a ser pesquisado
* @return rtStatus                      text     String para com o status do debito, ABERTO, PAGO, CANCELADO E PRESCRITO
* @return rtMsgerro                     text     String para mensagem de erro
* @return rbErro                        boolean  Parametro boleano informando se ocorreu erro

* @author Robson Inacio 
* @since  30/04/2007
*
* $id$
*/
 
create or replace function fc_statusdebitos(integer) returns setof tp_statusdebitos as
$$
declare

    iNumpre        alias for $1;

    rtp_statusdebitos record;

begin

    for rtp_statusdebitos in select * from fc_statusdebitos(iNumpre,null,null,null,false)
		loop
			return next rtp_statusdebitos;
		end loop;
		return;
   
end;
$$ language 'plpgsql';

/**
* Funcao para retornar o status do debito ( wrapper para fc_statusdebitos original passando somente o numpre e numpar )
*
* @param iNumpre                        integer  Numpre  do debito a ser pesquisado
* @param iNumpar                        integer  Numpar  do debito a ser pesquisado
*
* @return riNumpre                      integer  Numpre  do debito a ser pesquisado
* @return riNumpar                      integer  Numpar  do debito a ser pesquisado
* @return riReceit                      integer  Receita do debito a ser pesquisado
* @return rtStatus                      text     String para com o status do debito, ABERTO, PAGO, CANCELADO E PRESCRITO
* @return rtMsgerro                     text     String para mensagem de erro
* @return rbErro                        boolean  Parametro boleano informando se ocorreu erro

* @author Robson Inacio 
* @since  30/04/2007
*
* $id$
*/
 
create or replace function fc_statusdebitos(integer,integer) returns setof tp_statusdebitos as
$$
declare

    iNumpre        alias for $1;
    iNumpar        alias for $2;

    rtp_statusdebitos record;

begin

    for rtp_statusdebitos in select * from fc_statusdebitos(iNumpre,iNumpar,null,null,false)
		loop
			return next rtp_statusdebitos;
		end loop;
		return;
   
end;
$$ language 'plpgsql';

/**
* Funcao para retornar o status do debito ( wrapper para fc_statusdebitos original passando somente o numpre, numpar e receit )
*
* @param iNumpre                        integer  Numpre  do debito a ser pesquisado
* @param iNumpar                        integer  Numpar  do debito a ser pesquisado
* @param iReceit                        integer  Receita do debito a ser pesquisado
*
* @return riNumpre                      integer  Numpre  do debito a ser pesquisado
* @return riNumpar                      integer  Numpar  do debito a ser pesquisado
* @return riReceit                      integer  Receita do debito a ser pesquisado
* @return rtStatus                      text     String para com o status do debito, ABERTO, PAGO, CANCELADO E PRESCRITO
* @return rtMsgerro                     text     String para mensagem de erro
* @return rbErro                        boolean  Parametro boleano informando se ocorreu erro

* @author Robson Inacio 
* @since  30/04/2007
*
* $id$
*/
 
create or replace function fc_statusdebitos(integer,integer,integer) returns setof tp_statusdebitos as
$$
declare

    iNumpre        alias for $1;
    iNumpar        alias for $2;
    iReceit        alias for $3;

    rtp_statusdebitos record;

begin

    for rtp_statusdebitos in select * from fc_statusdebitos(iNumpre,iNumpar,iReceit,null,false)
		loop
			return next rtp_statusdebitos;
		end loop;
		return;
   
end;
$$ language 'plpgsql';
