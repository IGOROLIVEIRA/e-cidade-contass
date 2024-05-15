-- FUNCTION: public.fc_iptu_calculavvc_montalvania_2023(integer, integer, numeric, boolean, boolean)
-- DROP FUNCTION IF EXISTS public.fc_iptu_calculavvc_montalvania_2023(integer, integer, numeric, boolean, boolean);

CREATE OR REPLACE FUNCTION public.fc_iptu_calculavvc_montalvania_2023(integer, integer, numeric, boolean, boolean) RETURNS tp_iptu_calculavvc
    LANGUAGE 'plpgsql'
    COST 100 VOLATILE PARALLEL UNSAFE AS
$BODY$
declare

    iMatricula alias for $1;
    iAnousu alias for $2;
    ni02_valor alias for $3;
    bMostrademo alias for $4;
    bRaise alias for $5;
    nAreaconstr         numeric default 0;
    nValorConstr        numeric(15, 2) default 0;
    nValor              numeric(15, 2) default 0;
    nPerc               numeric(15, 2) default 0;
    iNumerocontr        integer default 0;
    iAuxMatric          integer default 0;
    iObsolencia         integer default 1;
    nFatorObsolencia    numeric(15, 2) default 0;
    tSql                text default '';
    bAtualiza           boolean default true;
    rConstr             record;
    iPadrao             integer default 0;
    nVm2c               numeric default 0;
    nVvc                numeric default 0;
    rtp_iptu_calculavvc tp_iptu_calculavvc%ROWTYPE;

begin

    if bRaise then
        raise notice 'INICIANDO CALCULO VVC ...';
    end if;

    rtp_iptu_calculavvc.rnVvc := 0;
    rtp_iptu_calculavvc.rnTotarea := 0;
    rtp_iptu_calculavvc.riNumconstr := 0;
    rtp_iptu_calculavvc.rtDemo := '';
    rtp_iptu_calculavvc.rtMsgerro := 'Retorno ok';
    rtp_iptu_calculavvc.rbErro := 'f';
    rtp_iptu_calculavvc.riCodErro := 0;
    rtp_iptu_calculavvc.rtErro := '';

    if bRaise then
        raise notice 'VERIFICANDO SE HOUVE CALCULO NO ANO ANTERIOR %...',iAnousu - 1;
    end if;

    SELECT j22_vm2
    into nValor
    FROM iptuconstr
             INNER JOIN iptucale ON j22_matric = iptuconstr.j39_matric
        AND j22_idcons = iptuconstr.j39_idcons AND j39_dtdemo is null
        and not exists(select 1
                       from carconstr
                                inner join iptubase on j01_matric = j48_matric
                       where j48_caract = 36)
    WHERE j22_matric = iMatricula
      AND j22_anousu = iAnousu;

    if nValor > 0 then

        if bRaise then
            raise notice 'HOUVE CALCULO NO ANO ANTERIOR. VALORM2 = %...',nValor;
        end if;

        tSql := ' select iptuconstr.j39_matric,
                       j39_idcons,
                       j39_ano,
                       iptuconstr.j39_matric,
                       j39_idcons,
                       j39_area::numeric,
                       coalesce((select sum(j31_pontos)
                          from carconstr
                               inner join caracter on j48_caract = j31_codigo
                         where j48_matric = iptuconstr.j39_matric
                           and j48_idcons = iptuconstr.j39_idcons),0) as j31_pontos,
                       (select j48_caract
                          from carconstr
                               inner join caracter on j48_caract = j31_codigo
                         where j48_matric = iptuconstr.j39_matric
                           and j48_idcons = iptuconstr.j39_idcons
                           and j31_grupo = 10) as j48_tipoconst,
                           j22_vm2
                  from iptuconstr
                  INNER JOIN iptucale on j22_matric = iptuconstr.j39_matric and j22_idcons = iptuconstr.j39_idcons
                  and iptucale.j22_anousu = ' || iAnousu || '
                  where iptuconstr.j39_matric = ' || iMatricula || '
                  and j39_dtdemo is null
				  and not exists (select 1 from carconstr inner join iptubase on j01_matric = j48_matric where j48_caract = 36)';

        if bRaise then
            raise notice '%', tSql;
        end if;

        for rConstr in execute tSql
            loop

                select j34_area,
                       case when coalesce(j36_testle, 0) > 0 then j36_testle else coalesce(j36_testad, 0) end,
                       j81_valorterreno,
                       j81_valorconstr
                from lote
                         inner join testpri on j49_idbql = j34_idbql
                         inner join face on j37_face = j49_face
                         inner join testada on j36_idbql = j34_idbql and j36_face = j49_face
                         inner join facevalor on j81_face = j37_face and j81_anousu = iAnousu
                         inner join iptubase on j01_idbql = j34_idbql
                where j01_matric = iMatricula;

                if bRaise then
                    raise notice 'VERIFICANDO SE HA DIGITACAO MANUAL...';
                end if;
                /* Considera a digitação manual caso haja */
                if found or nVvc > 0 then
                    nVm2c := (nVvc / rConstr.j39_area);

                    nValorConstr := (nVm2c * rConstr.j39_area)::numeric;
                    nValor := nValor + nValorConstr;
                    iNumerocontr := iNumerocontr + 1;
                    nAreaconstr := nAreaconstr + rConstr.j39_area;

                    insert into tmpiptucale (anousu, matric, idcons, areaed, vm2, pontos, valor)
                    values (iAnousu, iMatricula, rConstr.j39_idcons, rConstr.j39_area, nVm2c, rConstr.j31_pontos,
                            nValorConstr);

                    if bAtualiza then
                        update tmpdadosiptu set predial = true;
                        bAtualiza = false;
                    end if;

                else

                    if bRaise then
                        raise notice 'NAO HA DIGITACAO MANUAL...';
                    end if;

                    select into nValor round(fc_INFLA('URM', rConstr.j22_vm2, (iAnousu || '-01-01')::DATE,
                                                      (iAnousu || '-01-01')::DATE), 2) as valorm2;

                    iNumerocontr := iNumerocontr + 1;
                    nAreaconstr := nAreaconstr + rConstr.j39_area;
                    nValorConstr := nValorConstr + (nValor * rConstr.j39_area);

                    insert into tmpiptucale (anousu, matric, idcons, areaed, vm2, pontos, valor)
                    values (iAnousu, iMatricula, rConstr.j39_idcons, rConstr.j39_area, nValor, rConstr.j31_pontos,
                            nValor * rConstr.j39_area);
                    if bAtualiza then
                        update tmpdadosiptu set predial = true;
                        bAtualiza = false;
                    end if;

                end if;
            end loop;

    else

        if bRaise then
            raise notice 'NAO HOUVE CALCULO NO ANO ANTERIOR.';
        end if;

        tSql := ' select iptuconstr.j39_matric,
                       j39_idcons,
                       j39_ano,
                       iptuconstr.j39_matric,
                       j39_idcons,
                       j39_area::numeric,
                       coalesce( (select sum(j31_pontos)
                          from carconstr
                               inner join caracter on j48_caract = j31_codigo
                         where j48_matric = iptuconstr.j39_matric
                           and j48_idcons = iptuconstr.j39_idcons),0) as j31_pontos,
                       (select j48_caract
                          from carconstr
                               inner join caracter on j48_caract = j31_codigo
                         where j48_matric = iptuconstr.j39_matric
                           and j48_idcons = iptuconstr.j39_idcons
                           and j31_grupo = 10) as j48_tipoconst
                  from iptuconstr
                  where iptuconstr.j39_matric = ' || iMatricula || '
                  and j39_dtdemo is null
				  and not exists (select 1 from carconstr inner join iptubase on j01_matric = j48_matric where j48_caract = 36)';

        if bRaise then
            raise notice '%', tSql;
        end if;

        for rConstr in execute tSql
            loop

                select j11_vlrcons
                into nVvc
                from iptucalcpadraoconstr
                         inner join iptucalcpadrao on j11_iptucalcpadrao = j10_sequencial
                where j11_matric = rConstr.j39_matric
                  and j11_idcons = rConstr.j39_idcons
                  and j10_anousu = iAnousu;

                if bRaise then
                    raise notice 'VERIFICANDO SE HA DIGITACAO MANUAL...';
                end if;
                /* Considera a digitação manual caso haja */
                if found or nVvc > 0 then
                    if bRaise then
                        raise notice 'HA DIGITACAO MANUAL...';
                    end if;
                    nVm2c := (nVvc / rConstr.j39_area);

                    nValorConstr := (nVm2c * rConstr.j39_area)::numeric;
                    nValor := nValor + nValorConstr;
                    iNumerocontr := iNumerocontr + 1;
                    nAreaconstr := nAreaconstr + rConstr.j39_area;

                    insert into tmpiptucale (anousu, matric, idcons, areaed, vm2, pontos, valor)
                    values (iAnousu, iMatricula, rConstr.j39_idcons, rConstr.j39_area, nVm2c, 0, nValorConstr);

                    if bAtualiza then
                        update tmpdadosiptu set predial = true;
                        bAtualiza = false;
                    end if;
                else
                    if bRaise then
                        raise notice 'NAO HA DIGITACAO MANUAL...';
                    end if;

                    nValor := 40.00;
                    iNumerocontr := iNumerocontr + 1;
                    nAreaconstr := nAreaconstr + rConstr.j39_area;
                    nValorConstr := nValorConstr + (nValor * rConstr.j39_area);

                    if bRaise then
                        raise notice 'nValor: %, iNumerocontr: %, nAreaconstr: %', nValor, iNumerocontr, nAreaconstr;
                    end if;

                    if bRaise then
                        raise notice 'nValorConstr: %, iAnousu%', nValorConstr, iAnousu;
                    end if;

                    insert into tmpiptucale (anousu, matric, idcons, areaed, vm2, pontos, valor)
                    values (iAnousu, iMatricula, rConstr.j39_idcons, rConstr.j39_area, nValor, rConstr.j31_pontos,
                            nValor * rConstr.j39_area);
                    if bAtualiza then
                        update tmpdadosiptu set predial = true;
                        bAtualiza = false;
                    end if;
                end if;
                --end if;
            end loop;
    end if;

    perform j39_matric
    from iptuconstr
    where j39_matric = iMatricula
      and j39_dtdemo is null
      and not exists(select 1
                     from carconstr
                              inner join iptubase on j01_matric = j48_matric
                     where j48_caract = 36)
    limit 1;

    if found then

        perform matric from tmpiptucale limit 1;

        if not found and iPadrao = 0 then
            rtp_iptu_calculavvc.rtDemo := 'sem caracteristica lancada';
            rtp_iptu_calculavvc.rbErro := 't';
        else

            rtp_iptu_calculavvc.rnVvc := nValorConstr;
            rtp_iptu_calculavvc.rnTotarea := nAreaconstr::numeric;
            rtp_iptu_calculavvc.riNumconstr := iNumerocontr;
            rtp_iptu_calculavvc.rtDemo := '';
            rtp_iptu_calculavvc.rbErro := 'f';

            update tmpdadosiptu set vvc = rtp_iptu_calculavvc.rnVvc;

        end if;

    end if;

    if bRaise then
        raise notice 'FIM DO CÁLCULO DO VVC';
    end if;

    return rtp_iptu_calculavvc;

end;

$BODY$;


ALTER FUNCTION public.fc_iptu_calculavvc_montalvania_2023(integer, integer, numeric, boolean, boolean) OWNER TO dbportal;