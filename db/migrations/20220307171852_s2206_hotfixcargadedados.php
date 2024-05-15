<?php

use Phinx\Migration\AbstractMigration;

class S2206Hotfixcargadedados extends AbstractMigration
{
    public function up()
    {
        $sql = "
        UPDATE habitacao.avaliacao SET db101_avaliacaotipo=5, db101_descricao='Formulário S-2206 versão S-1.0', db101_obs='Formulário S-2206 versão S-1.0', db101_ativo=true, db101_identificador='s2206-vs1', db101_cargadados='select distinct
--  ideVinculo
    z01_cgccpf as cpfTrab,
    rh01_regist as matricula,
--  altContratual
    fc_getsession(''DB_datausu'')::date as dtAlteracao,
    fc_getsession(''DB_datausu'')::date as dtEf, -- cv com igor
    '''' as dscAlt,
--  vinculo
    case when r33_tiporegime = ''1'' then 4001306
    when r33_tiporegime = ''2'' then 4001307
    end as tpRegPrev,
--  Informações de trabalhador celetista ( infoCeletista )
    case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then 4001309
    end as tpRegJor,
    case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then 4001313
    end as natAtividade,
    '''' as dtBase,
    case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh116_cnpj
    end as cnpjSindCategProf,
--  trabTemp
    rh15_data as justContr,
--  aprend
    '''' as tpInsc,
    '''' as nrInsc,
--  infoEstatutario
    case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or  h13_categoria = 306 or h13_categoria = 309) and rh02_plansegreg = 1 and r33_tiporegime <> ''1'' then 4001322
    when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) and rh02_plansegreg = 2 and r33_tiporegime <> ''1'' then 4001323
    when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) and rh02_plansegreg = 3 and r33_tiporegime <> ''1'' then 4001324
    when r33_tiporegime = ''1'' then null
    else 4001321
    end as tpPlanRP,
    case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) and r33_tiporegime <> ''1'' then 4001326
    when r33_tiporegime = ''1'' then null
    end as indTetoRGPS,
    case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) and rh02_abonopermanencia = ''f'' and r33_tiporegime <> ''1'' then 4001328
    when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) and rh02_abonopermanencia = ''t'' and r33_tiporegime <> ''1'' then 4001327
    when r33_tiporegime = ''1'' then null
    end as indAbonoPerm,
--  infoContrato
    case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh37_descr
    end as nmCargo,
    case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh37_cbo
    end as CBOCargo,
    case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_descr is null then rh37_descr
         when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_descr is not null then rh04_descr
    END as nmFuncao,
    case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_cbo is null then rh37_cbo
         when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_cbo is not null then rh04_cbo
    end as CBOFuncao,
    case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh37_reqcargo in (1,2,3,5) then 4001335
         when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh37_reqcargo = 4 then 4001336
    end as acumCargo,
    case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then h13_categoria
    end as codCateg,
--  remuneracao
    rh02_salari as vrSalFx,
    case when rh02_tipsal = ''M'' then 4001345
    when rh02_tipsal = ''Q'' then 4001344
    when rh02_tipsal = ''D'' then 4001342
    when rh02_tipsal = ''H'' then 4001341
    end as undSalFixo,
    '''' as dscSalVar,
--  duracacao
    case when h13_tipocargo = 7 or rh164_datafim is not null then 4001350
    else 4001349
    end as tpContr,
    rh164_datafim as dtTerm,
    '''' as tpContr,
--  localTrabGeral
    4001354 as tpInscEstab,
    cgc as nrInscEstab,
    nomeinst as descComp,
--  localTrabDom
   case when ruas.j14_tipo is null then ''R''
    else j88_sigla
    end as tpLograd, -- table20
    z01_ender as dscLograd,
    z01_numero  as nrLograd,
    z01_compl as complemento,
    z01_bairro as bairro,
    rpad(z01_cep,8,''0'') as cep,
    (select
    db125_codigosistema
from
    cadendermunicipio
inner join cadendermunicipiosistema on
    cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial
    and cadendermunicipiosistema.db125_db_sistemaexterno = 4
inner join cadenderestado on
    cadendermunicipio.db72_cadenderestado = cadenderestado.db71_sequencial
inner join cadenderpais on
    cadenderestado.db71_cadenderpais = cadenderpais.db70_sequencial
inner join cadenderpaissistema on
    cadenderpais.db70_sequencial = cadenderpaissistema.db135_db_cadenderpais
where
    to_ascii(db72_descricao) = trim(cgm.z01_munic)
order by
    db72_sequencial asc limit 1) as codMunic,
    case when trim(z01_uf) = '''' then ''MG''
    when z01_uf is null then ''MG''
    else z01_uf
    end as uf,
-- horContratual
    rh02_hrssem as qtdHrsSem,
    case when rh02_tipojornada = 2 then 4001366
    when rh02_tipojornada = 3 then 4001367
    when rh02_tipojornada = 4 then 4001368
    when rh02_tipojornada = 5 then 4001369
    when rh02_tipojornada = 6 then 4001370
    when rh02_tipojornada = 7 then 4001371
    when rh02_tipojornada = 9 then 4001372
    end as tpJornada,
    4001373 as tmpParc,
    case when rh02_horarionoturno = ''f'' then 4001378
    when rh02_horarionoturno = ''t'' then 4001377
    end as horNoturno,
    jt_descricao as dscJorn,
-- alvaraJudicial
    '''' as nrProcJud,
-- observacoes
    '''' as observacao,
-- treiCap
    '''' as codTreiCap
from
    rhpessoal
left join rhpessoalmov on
    rh02_anousu = fc_getsession(''DB_anousu'')::int
    and rh02_mesusu = date_part(''month'',fc_getsession(''DB_datausu'')::date)
    and rh02_regist = rh01_regist
    and rh02_instit = fc_getsession(''DB_instit'')::int
left join rhlota on
    rhlota.r70_codigo = rhpessoalmov.rh02_lota
    and rhlota.r70_instit = rhpessoalmov.rh02_instit
inner join cgm on
    cgm.z01_numcgm = rhpessoal.rh01_numcgm
inner join db_config on
    db_config.codigo = rhpessoal.rh01_instit
inner join rhestcivil on
    rhestcivil.rh08_estciv = rhpessoal.rh01_estciv
inner join rhraca on
    rhraca.rh18_raca = rhpessoal.rh01_raca
left join rhfuncao on
    rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
    and rhfuncao.rh37_instit = rhpessoalmov.rh02_instit
left join rhpescargo   on rhpescargo.rh20_seqpes   = rhpessoalmov.rh02_seqpes
left join rhcargo      on rhcargo.rh04_codigo      = rhpescargo.rh20_cargo
      and rhcargo.rh04_instit      = rhpessoalmov.rh02_instit
inner join rhinstrucao on
    rhinstrucao.rh21_instru = rhpessoal.rh01_instru
inner join rhnacionalidade on
    rhnacionalidade.rh06_nacionalidade = rhpessoal.rh01_nacion
left join rhpesrescisao on
    rh02_seqpes = rh05_seqpes
left join rhsindicato on
    rh01_rhsindicato = rh116_sequencial
inner join rhreajusteparidade on
    rhreajusteparidade.rh148_sequencial = rhpessoal.rh01_reajusteparidade
left join rhpesdoc on
    rhpesdoc.rh16_regist = rhpessoal.rh01_regist
left join rhdepend  on  rhdepend.rh31_regist = rhpessoal.rh01_regist
left join rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
left join rhpesfgts ON rhpesfgts.rh15_regist = rhpessoal.rh01_regist
inner join tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
left  join rhcontratoemergencial on rh163_matricula = rh01_regist
left  join rhcontratoemergencialrenovacao on rh164_contratoemergencial = rh163_sequencial
left join jornadadetrabalho on jt_sequencial = rh02_jornadadetrabalho
left join db_cgmbairro on cgm.z01_numcgm = db_cgmbairro.z01_numcgm
left join bairro on bairro.j13_codi = db_cgmbairro.j13_codi
left join db_cgmruas on cgm.z01_numcgm = db_cgmruas.z01_numcgm
left join ruas on ruas.j14_codigo = db_cgmruas.j14_codigo
left join ruastipo on j88_codigo = j14_tipo
left  outer join (
                  select distinct r33_codtab,r33_nome,r33_tiporegime
                                      from inssirf
                                      where     r33_anousu = (select r11_anousu from cfpess where r11_instit = fc_getsession(''DB_instit'')::int order by r11_anousu desc limit 1)
                                                        and r33_mesusu = (select r11_mesusu from cfpess where r11_instit = fc_getsession(''DB_instit'')::int order by r11_anousu desc, r11_mesusu desc limit 1)
                                            and r33_instit = fc_getsession(''DB_instit'')::int
                                     ) as x on r33_codtab = rhpessoalmov.rh02_tbprev+2
left  join rescisao      on rescisao.r59_anousu       = rhpessoalmov.rh02_anousu
                                       and rescisao.r59_mesusu       = rhpessoalmov.rh02_mesusu
                                       and rescisao.r59_regime       = rhregime.rh30_regime
                                       and rescisao.r59_causa        = rhpesrescisao.rh05_causa
                                       and rescisao.r59_caub         = rhpesrescisao.rh05_caub::char(2)
where h13_categoria in (''101'', ''106'', ''111'', ''301'', ''302'', ''303'', ''305'', ''306'', ''309'', ''312'', ''313'', ''902'')
and rh30_vinculo = ''A''
and rh05_recis is null
and (
        (
        rh02_mesusu = 11
        and rh02_anousu = 2021
        and date_part(''month'',rh01_admiss::date) <> 12
        and rh05_recis is null
        )
        or
        (rh02_mesusu = 11
            and rh02_anousu = 2021
            and (rh05_recis is not null
                and date_part(''month'',rh01_admiss::date) <> 12
                and date_part(''day'',rh05_recis::date) <= 21
                and date_part(''month'',rh05_recis::date) = 11
                )
            or
            (
            rh02_anousu > 2021
            and date_part(''month'',rh01_admiss::date) = date_part(''month'',fc_getsession(''DB_datausu'')::date)
            and date_part(''year'',rh01_admiss::date) = fc_getsession(''DB_anousu'')::int
            )
        )
    )', db101_permiteedicao=false WHERE db101_sequencial=4000104;

        ";
        $this->execute($sql);
    }
}
