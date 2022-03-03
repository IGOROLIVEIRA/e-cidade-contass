<?php

use Phinx\Migration\AbstractMigration;

class S2205 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        UPDATE configuracoes.db_itensmenu SET funcao='con4_manutencaoformulario001.php?esocial=38' WHERE descricao ilike 'S-2205%';

        UPDATE habitacao.avaliacao SET db101_avaliacaotipo=5, db101_descricao='Formulário S-2205 versão S-1.0', db101_obs='Formulário S-2205 versão S-1.0', db101_ativo=true, db101_identificador='s2205-vs1', db101_cargadados='select distinct
            --ideTrabalhador
                z01_cgccpf as cpfTrab,
            --alteracao
                fc_getsession(''DB_datausu'')::date as dtAlteracao,
            --dados trabalhador
                z01_nome as nmTrab,
                case when rh01_sexo = ''F'' then 4001214
                when rh01_sexo = ''M'' then 4001213
                    else 4000912
                end as sexo,
                CASE WHEN rh01_raca = 2 THEN 4001216
                WHEN rh01_raca = 4 THEN 4001218
                WHEN rh01_raca = 6 THEN 4001220
                WHEN rh01_raca = 8 THEN 4001220
                WHEN rh01_raca = 1 THEN 4001215
                WHEN rh01_raca = 9 THEN 4001220
                END AS racaCor,
                case when rh01_estciv = 1 then 4001221
                when rh01_estciv = 2 then 4001222
                when rh01_estciv = 5 then 4001225
                when rh01_estciv = 4 then 4001224
                when rh01_estciv = 3 then 4001223
                else 4001221
                end as estCiv,
                case when rh01_instru = 1 then 4001226
                when rh01_instru = 2 then 4001227
                when rh01_instru = 3 then 4001228
                when rh01_instru = 4 then 4001229
                when rh01_instru = 5 then 4001230
                when rh01_instru = 6 then 4001231
                when rh01_instru = 7 then 4001232
                when rh01_instru = 8 then 4001233
                when rh01_instru = 9 then 4001234
                when rh01_instru = 10 then 4001235
                when rh01_instru = 11 then 4001236
                    when rh01_instru = 12 then 4001237
                when rh01_instru = 0 then 4001232
                end as grauInstr,
                '''' as nmSoc,
	            105 as paisnac,
            --brasil
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

            --infoDeficiencia
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 1  then 4001261
                else 4001262
                end as defFisica,
                case when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 4001264
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 3 then 4001263
                else 4001264
                end as defVisual,
                case when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 4001266
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 2 then 4001265
                else 4001266
                end as defAuditiva,
                case when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 4001268
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 7 then 4001267
                else 4001268
                end as defMental,
                case when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 4001270
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 4 then 4000969
                else 4001270
                end as defIntelectual,
                case when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 4001272
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 6 then 4001271
                else 4001272
                end as reabReadap,
                case when rh02_cotadeficiencia = ''t'' then 4001273
                when rh02_cotadeficiencia = ''f'' then 4001274
                end as infoCota,
                '''' as observacao,
            -- 	Informações dos dependentes
                (select  case when rh31_gparen = ''C'' then 4000981
                when rh31_gparen = ''F'' then 4000983
                when rh31_gparen = ''P'' then 4000987
                when rh31_gparen = ''M'' then 4000987
                when rh31_gparen = ''A'' then 4000987
                when rh31_gparen = ''O'' then 4000991
                end as tpDep1 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 0),
                (select rh31_nome as nmDep1 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 0),
                (select rh31_dtnasc as dtNascto1 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 0),
                (select rh31_cpf as cpfDep1 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 0),
                (select case when rh31_sexo = ''F'' then 4000996
                when rh31_sexo = ''M'' then 4000995
                else 4000995
                end as sexoDep1 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 0),
                (select case when rh31_irf = ''0'' then 4000998
                else 4000997
                end as depIRRF1 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 0),
                (select case when rh31_depend = ''C'' or rh31_depend = ''S'' then 4000999
                when rh31_depend = ''S'' then 4000999
                else 4001000
                end as depSF1 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 0),
                (select case when rh31_especi = ''C'' or rh31_especi = ''S'' then 4001001
                when rh31_especi = ''N'' then 4001002
                end as incTrab1 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 0),

            --  Contato
                z01_telef as fonePrinc,
                z01_email as emailPrinc
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
                                      where     r33_anousu = fc_getsession(''DB_anousu'')::int
                                            and r33_mesusu = date_part(''month'',fc_getsession(''DB_datausu'')::date)
                                            and r33_instit = fc_getsession(''DB_instit'')::int
                                     ) as x on r33_codtab = rhpessoalmov.rh02_tbprev+2
left  join rescisao      on rescisao.r59_anousu       = rhpessoalmov.rh02_anousu
                                       and rescisao.r59_mesusu       = rhpessoalmov.rh02_mesusu
                                       and rescisao.r59_regime       = rhregime.rh30_regime
                                       and rescisao.r59_causa        = rhpesrescisao.rh05_causa
                                       and rescisao.r59_caub         = rhpesrescisao.rh05_caub::char(2)
where h13_categoria in (''101'', ''106'', ''111'', ''301'', ''302'', ''304'', ''305'', ''306'', ''309'', ''312'', ''313'', ''902'')
and rh30_vinculo = ''A''', db101_permiteedicao=false WHERE db101_sequencial=4000103;

SQL;
        $this->execute($sql);
    }
}
