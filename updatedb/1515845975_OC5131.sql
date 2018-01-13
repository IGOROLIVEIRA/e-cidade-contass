begin;
CREATE OR REPLACE FUNCTION public.fc_statusdebitos(integer, integer, integer, text, boolean)
  RETURNS SETOF tp_statusdebitos AS
$BODY$
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
               union all
              select k00_numpre,
                     k00_numpar,
                     0 as k00_receit,
                     \'DIVIDA\'::varchar as status
                from arreold
                     inner join divold d on d.k10_numpre  = arreold.k00_numpre
                                        and d.k10_numpar  = arreold.k00_numpar
                                        and d.k10_receita = arreold.k00_receit
                    '||tWheren||'
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
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION public.fc_statusdebitos(integer, integer, integer, text, boolean)
  OWNER TO postgres;

  commit;
