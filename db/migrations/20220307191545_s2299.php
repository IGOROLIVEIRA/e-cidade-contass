<?php

use Phinx\Migration\AbstractMigration;

class S2299 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        UPDATE configuracoes.db_itensmenu SET funcao='con4_manutencaoformulario001.php?esocial=43' WHERE descricao ilike 'S-2299%';

        UPDATE habitacao.avaliacao SET db101_avaliacaotipo=5, db101_descricao='Formulário S-2299 versão S-1.0', db101_obs='Formulário S-2299 versão S-1.0', db101_ativo=true, db101_identificador='s2299-vs1', db101_cargadados='select distinct
--  ideVinculo
	z01_cgccpf as cpfTrab,
    rh01_regist as matricula,
--  infoDeslig
    rh05_motivo as mtvDeslig, --aguardando criação do campo
    rh05_recis as dtDeslig,
    rh05_aviso as dtAvPrv,
    case when rh05_taviso = 2 then 4001620
    else 4001621
    end as indPagtoAPI,
    rh05_aviso + (select r19_quant from pontofr where (r19_anousu,r19_mesusu,r19_regist) = (rh02_anousu,rh02_mesusu,rh02_regist) and r19_rubric like ''6%'' limit 1)::int as dtProjFimAPI,
    0 as pensAlim,
    '''' as percAliment,
    '''' as vrAlim,
    '''' as nrProcTrab,
--  infoInterm
    '''' as dia,
--  observacoes
    '''' as observacao,
--  sucessaoVinc
	'''' as tpInsc,
	'''' as nrInsc,
--  transfTit
	'''' as cpfSubstituto,
	'''' as dtNascto,
--  mudancaCPF
	'''' as novoCPF,
--  dmDev
	'''' as ideDmDev, -- Ident
--  ideEstabLot_infoPerApur
	1 as tpInsc,
	cgc as nrInsc,
	(select eso08_codempregadorlotacao from eventos1020) as codLotacao,
	--eso08_codempregadorlotacao as codLotacao,
--  detVerbas_infoPerApur
	'''' as codeRubr,
	--rh27_rubric as codRubr,
	''tabrub1'' as ideTabRubr, -- cv com Ig Fran
	'''' as qtdRubr,
	'''' as fatorRubr,
	'''' as vrRubr,
	0  as indApurIR,
--  infoAgNocivo_infoPerApur
	case when rh02_ocorre = ''2'' or rh02_ocorre = ''6'' then 2
	when rh02_ocorre = ''3'' or rh02_ocorre = ''7'' then 3
	when rh02_ocorre = ''4'' or rh02_ocorre = ''8'' then 4
	else 1
	end as grauExp,
--  infoSimples_infoPerApur
	'''' as indSimples,
--  ideADC_infoPerAnt
	'''' as dtAcConv,
	'''' as tpAcConv,
	'''' as dsc,
--  idePeriodo_infoPerAnt
	'''' as perRef,
--  procJudTrab
	'''' as tpTrib,
	'''' as nrProcJud,
	'''' as codSusp,
--  infoMV
	rh51_indicadesconto as indMV,
--  remunOutrEmpr
	1 as tpInsc, --nome igual
	'''' as nrInsc,
	'''' as codCateg,
	--rh51_basefo as vlrRemunOE,
	rh51_basefo as vlrRemunOE,
--  procCS
	'''' as nrProcJud,
--  dtFimQuar
	'''' as dtFimQuar,
--  consigFGTS
	'''' as insConsig,
	'''' as nrContr
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
          left join rhinssoutros on rh51_seqpes = rh02_seqpes
where h13_categoria in (''101'', ''106'', ''111'', ''301'', ''302'', ''303'', ''305'', ''306'', ''309'', ''312'', ''313'', ''902'')
and rh30_vinculo = ''A''
and (
        (
        rh02_mesusu = 11
        and rh02_anousu = 2021
       	and date_part(''year'',rh05_recis::date) = 2021
		and date_part(''month'',rh05_recis::date) = 11
		and date_part(''day'',rh05_recis::date) >= 21
        )
    )', db101_permiteedicao=false WHERE db101_sequencial=4000112;

        ";
        $this->execute($sql);
    }
}
