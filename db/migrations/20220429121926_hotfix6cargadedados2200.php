<?php

use Phinx\Migration\AbstractMigration;

class Hotfix6cargadedados2200 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        UPDATE habitacao.avaliacao SET db101_avaliacaotipo=5, db101_descricao='Formulário S-2200 versão S-1.0', db101_obs='Formulário S-2200 versão S-1.0', db101_ativo=true, db101_identificador='s2200-vs1', db101_cargadados='select distinct
            --Informações Pessoais do Trabalhador
                rh02_instit AS instituicao,
                z01_cgccpf as cpfTrab,
                z01_nome as nmTrab,
                case when rh01_sexo = ''F'' then 4000913
                when rh01_sexo = ''M'' then 4000912
                    else 4000912
                end as sexo,
                CASE WHEN rh01_raca = 2 THEN 4000914
                WHEN rh01_raca = 4 THEN 4000915
                WHEN rh01_raca = 6 THEN 4000917
                WHEN rh01_raca = 8 THEN 4000916
                WHEN rh01_raca = 1 THEN 4000918
                WHEN rh01_raca = 9 THEN 4000919
                END AS racaCor,
                case when rh01_estciv = 1 then 4000920
                when rh01_estciv = 2 then 4000921
                when rh01_estciv = 5 then 4000922
                when rh01_estciv = 4 then 4000923
                when rh01_estciv = 3 then 4000924
                else 4000920
                end as estCiv,
                case when rh01_instru = 1 then 4000925
                when rh01_instru = 2 then 4000926
                when rh01_instru = 3 then 4000927
                when rh01_instru = 4 then 4000928
                when rh01_instru = 5 then 4000929
                when rh01_instru = 6 then 4000930
                when rh01_instru = 7 then 4000931
                when rh01_instru = 8 then 4000932
                when rh01_instru = 9 then 4000933
                when rh01_instru = 10 then 4000935
                when rh01_instru = 11 then 4000936
                    when rh01_instru = 12 then 4000934
                when rh01_instru = 0 then 4000925
                end as grauInstr,
                '''' as nmSoc,
            --Grupo de informações do nascimento do trabalhador
            rh01_nasc as dtNascto,
            case when rh01_nacion = 10 then 105
                 when rh01_nacion = 20 then 105
                 when rh01_nacion = 21 then 063
                 when rh01_nacion = 22 then 097
                 when rh01_nacion = 23 then 158
                 when rh01_nacion = 24 then 586
                 when rh01_nacion = 25 then 845
                 when rh01_nacion = 26 then 850
                 when rh01_nacion = 27 then 169
                 when rh01_nacion = 28 then 589
                 when rh01_nacion = 29 then 239
                 when rh01_nacion = 30 then 023
                 when rh01_nacion = 31 then 087
                 when rh01_nacion = 32 then 367
                 --when rh01_nacion = 33 then 105
                 when rh01_nacion = 34 then 149
                 when rh01_nacion = 35 then 245
                 when rh01_nacion = 36 then 249
                 when rh01_nacion = 37 then 275
                 when rh01_nacion = 38 then 767
                 when rh01_nacion = 39 then 386
                 when rh01_nacion = 40 then 341
                 when rh01_nacion = 41 then 399
                 when rh01_nacion = 42 then 160
                 when rh01_nacion = 43 then 190
                 when rh01_nacion = 44 then 676
                 when rh01_nacion = 45 then 607
                 when rh01_nacion = 46 then 576
                 when rh01_nacion = 47 then 361
                 --when rh01_nacion = 48 then 105
                 --when rh01_nacion = 49 then 105
                 --when rh01_nacion = 50 then 105
                 --when rh01_nacion = 51 then 105
                 when rh01_nacion = 60 then 040
                 when rh01_nacion = 61 then 177
                 when rh01_nacion = 62 then 756
                 when rh01_nacion = 63 then 289
                 when rh01_nacion = 64 then 728
                 end as paisNascto,
            105 as paisnac,
            --Preenchimento obrigatório para trabalhador residente no Brasil
                case when ruas.j14_tipo is null then ''R''
                else j88_sigla
                end as tpLograd, -- table20
                z01_ender as dscLograd,
                z01_numero  as nrLograd,
                z01_compl as complemento,
                z01_bairro as bairro,
                rpad(z01_cep,8,''0'') as cep,case when (select
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
                db72_sequencial asc limit 1) is not null then (select
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
                db72_sequencial asc limit 1)
                else
                ( select
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
                to_ascii(db72_descricao) = ( select to_ascii(db72_descricao) from cadenderparam inner join cadenderpais on cadenderpais.db70_sequencial = cadenderparam.db99_cadenderpais inner join cadenderestado on cadenderestado.db71_sequencial = cadenderparam.db99_cadenderestado inner join cadendermunicipio on cadendermunicipio.db72_cadenderestado = cadenderestado.db71_sequencial inner join cadenderpais as p on p.db70_sequencial = cadenderestado.db71_cadenderpais inner join cadenderestado as a on a.db71_sequencial = cadendermunicipio.db72_cadenderestado INNER JOIN cadendermunicipiosistema ON cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial where db125_db_sistemaexterno = 4 and db72_sequencial = ( SELECT db125_cadendermunicipio FROM cadendermunicipiosistema INNER JOIN cadenderparam ON db125_cadendermunicipio = db99_cadendermunicipio AND db125_db_sistemaexterno = 4 LIMIT 1) order by db72_descricao asc limit 1)
                and cadenderestado.db71_descricao = (select cadenderestado.db71_descricao from cadenderparam inner join cadenderpais on cadenderpais.db70_sequencial = cadenderparam.db99_cadenderpais inner join cadenderestado on cadenderestado.db71_sequencial = cadenderparam.db99_cadenderestado inner join cadendermunicipio on cadendermunicipio.db72_cadenderestado = cadenderestado.db71_sequencial inner join cadenderpais as p on p.db70_sequencial = cadenderestado.db71_cadenderpais inner join cadenderestado as a on a.db71_sequencial = cadendermunicipio.db72_cadenderestado INNER JOIN cadendermunicipiosistema ON cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial where db125_db_sistemaexterno = 4 and db72_sequencial = ( SELECT db125_cadendermunicipio FROM cadendermunicipiosistema INNER JOIN cadenderparam ON db125_cadendermunicipio = db99_cadendermunicipio AND db125_db_sistemaexterno = 4 LIMIT 1) limit 1)
            order by
                db72_sequencial asc limit 1)
                end as codMunic,
                case when trim(z01_uf) = '''' then ''MG''
                when z01_uf is null then ''MG''
                else z01_uf
                end as uf,
            --Pessoa com Deficiência
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 1  then 4000966
                else 4000967
                end as defFisica,
                case when rh02_deficientefisico = false then 4000969
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 4000969
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 3 then 4000968
                else 4000969
                end as defVisual,
                case when rh02_deficientefisico = false then 4000971
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 4000971
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 2 then 4000970
                else 4000971
                end as defAuditiva,
                case when rh02_deficientefisico = false then 4000973
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 4000973
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 7 then 4000972
                else 4000973
                end as defMental,
                case when rh02_deficientefisico = false then 4000975
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 4000975
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 4 then 4000974
                else 4000975
                end as defIntelectual,
                case when rh02_deficientefisico = false then 4000977
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 4000977
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 6 then 4000976
                else 4000977
                end as reabReadap,
                case when rh02_cotadeficiencia = ''t'' then 4000978
                when rh02_cotadeficiencia = ''f'' then 4000979
                end as infoCota,
                '''' as observacao,
            --  Informações dos dependentes
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
            --2
            (select  case when rh31_gparen = ''C'' then 4002808
                when rh31_gparen = ''F'' then 4002810
                when rh31_gparen = ''P'' then 4002814
                when rh31_gparen = ''M'' then 4002814
                when rh31_gparen = ''A'' then 4002814
                when rh31_gparen = ''O'' then 4002818
                end as tpDep2 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 1),
                (select rh31_nome as nmDep2 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 1),
                (select rh31_dtnasc as dtNascto2 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 1),
                (select rh31_cpf as cpfDep2 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 1),
                (select case when rh31_sexo = ''F'' then 4002823
                when rh31_sexo = ''M'' then 4002822
                else 4002822
                end as sexoDep2 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 1),
                (select case when rh31_irf = ''0'' then 4002825
                else 4002824
                end as depIRRF2 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 1),
                (select case when rh31_depend = ''C'' or rh31_depend = ''S'' then 4002826
                when rh31_depend = ''S'' then 4002826
                else 4002827
                end as depSF2 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 1),
                (select case when rh31_especi = ''C'' or rh31_especi = ''S'' then 4002829
                when rh31_especi = ''N'' then 4002828
                end as incTrab2 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 1),
            --3
            (select  case when rh31_gparen = ''C'' then 4002830
                when rh31_gparen = ''F'' then 4002832
                when rh31_gparen = ''P'' then 4002836
                when rh31_gparen = ''M'' then 4002836
                when rh31_gparen = ''A'' then 4002836
                when rh31_gparen = ''O'' then 4002840
                end as tpDep3 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 2),
                (select rh31_nome as nmDep3 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 2),
                (select rh31_dtnasc as dtNascto3 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 2),
                (select rh31_cpf as cpfDep3 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 2),
                (select case when rh31_sexo = ''F'' then 4002845
                when rh31_sexo = ''M'' then 4002844
                else 4002844
                end as sexoDep3 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 2),
                (select case when rh31_irf = ''0'' then 4002847
                else 4002846
                end as depIRRF3 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 2),
                (select case when rh31_depend = ''C'' or rh31_depend = ''S'' then 4002848
                when rh31_depend = ''S'' then 4002848
                else 4002849
                end as depSF3 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 2),
                (select case when rh31_especi = ''C'' or rh31_especi = ''S'' then 4002851
                when rh31_especi = ''N'' then 4002850
                end as incTrab3 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 2),
            --4
            (select  case when rh31_gparen = ''C'' then 4002852
                when rh31_gparen = ''F'' then 4002854
                when rh31_gparen = ''P'' then 4002858
                when rh31_gparen = ''M'' then 4002858
                when rh31_gparen = ''A'' then 4002858
                when rh31_gparen = ''O'' then 4002862
                end as tpDep4 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 3),
                (select rh31_nome as nmDep4 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 3),
                (select rh31_dtnasc as dtNascto4 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 3),
                (select rh31_cpf as cpfDep4 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 3),
                (select case when rh31_sexo = ''F'' then 4002867
                when rh31_sexo = ''M'' then 4002866
                else 4002866
                end as sexoDep4 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 3),
                (select case when rh31_irf = ''0'' then 4002869
                else 4002868
                end as depIRRF4 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 3),
                (select case when rh31_depend = ''C'' or rh31_depend = ''S'' then 4002870
                when rh31_depend = ''S'' then 4002870
                else 4002871
                end as depSF4 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 3),
                (select case when rh31_especi = ''C'' or rh31_especi = ''S'' then 4002873
                when rh31_especi = ''N'' then 4002872
                end as incTrab4 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 3),
            --5
            (select  case when rh31_gparen = ''C'' then 4002874
                when rh31_gparen = ''F'' then 4002876
                when rh31_gparen = ''P'' then 4002880
                when rh31_gparen = ''M'' then 4002880
                when rh31_gparen = ''A'' then 4002880
                when rh31_gparen = ''O'' then 4002884
                end as tpDep5 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 4),
                (select rh31_nome as nmDep5 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 4),
                (select rh31_dtnasc as dtNascto5 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 4),
                (select rh31_cpf as cpfDep5 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 4),
                (select case when rh31_sexo = ''F'' then 4002889
                when rh31_sexo = ''M'' then 4002888
                else 4002888
                end as sexoDep5 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 4),
                (select case when rh31_irf = ''0'' then 4002891
                else 4002890
                end as depIRRF5 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 4),
                (select case when rh31_depend = ''C'' or rh31_depend = ''S'' then 4002892
                when rh31_depend = ''S'' then 4002892
                else 4002893
                end as depSF5 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 4),
                (select case when rh31_especi = ''C'' or rh31_especi = ''S'' then 4002895
                when rh31_especi = ''N'' then 4002894
                end as incTrab5 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 4),
            --6
            (select  case when rh31_gparen = ''C'' then 4002896
                when rh31_gparen = ''F'' then 4002898
                when rh31_gparen = ''P'' then 4002902
                when rh31_gparen = ''M'' then 4002902
                when rh31_gparen = ''A'' then 4002902
                when rh31_gparen = ''O'' then 4002906
                end as tpDep6 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 5),
                (select rh31_nome as nmDep6 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 5),
                (select rh31_dtnasc as dtNascto6 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 5),
                (select rh31_cpf as cpfDep6 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 5),
                (select case when rh31_sexo = ''F'' then 4002911
                when rh31_sexo = ''M'' then 4002910
                else 4002910
                end as sexoDep6 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 5),
                (select case when rh31_irf = ''0'' then 4002913
                else 4002912
                end as depIRRF6 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 5),
                (select case when rh31_depend = ''C'' or rh31_depend = ''S'' then 4002914
                when rh31_depend = ''S'' then 4002914
                else 4002915
                end as depSF6 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 5),
                (select case when rh31_especi = ''C'' or rh31_especi = ''S'' then 4002917
                when rh31_especi = ''N'' then 4002916
                end as incTrab6 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 5),
            --7
               (select  case when rh31_gparen = ''C'' then 4002918
                when rh31_gparen = ''F'' then 4002920
                when rh31_gparen = ''P'' then 4002924
                when rh31_gparen = ''M'' then 4002924
                when rh31_gparen = ''A'' then 4002924
                when rh31_gparen = ''O'' then 4002928
                end as tpDep7 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 6),
                (select rh31_nome as nmDep7 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 6),
                (select rh31_dtnasc as dtNascto7 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 6),
                (select rh31_cpf as cpfDep7 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 6),
                (select case when rh31_sexo = ''F'' then 4002933
                when rh31_sexo = ''M'' then 4002932
                else 4002932
                end as sexoDep7 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 6),
                (select case when rh31_irf = ''0'' then 4002935
                else 4002934
                end as depIRRF7 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 6),
                (select case when rh31_depend = ''C'' or rh31_depend = ''S'' then 4002936
                when rh31_depend = ''S'' then 4002936
                else 4002937
                end as depSF7 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 6),
                (select case when rh31_especi = ''C'' or rh31_especi = ''S'' then 4002939
                when rh31_especi = ''N'' then 4002938
                end as incTrab7 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 6),
            --8
            (select  case when rh31_gparen = ''C'' then 4002940
                when rh31_gparen = ''F'' then 4002942
                when rh31_gparen = ''P'' then 4002946
                when rh31_gparen = ''M'' then 4002946
                when rh31_gparen = ''A'' then 4002946
                when rh31_gparen = ''O'' then 4002950
                end as tpDep8 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 7),
                (select rh31_nome as nmDep8 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 7),
                (select rh31_dtnasc as dtNascto8 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 7),
                (select rh31_cpf as cpfDep8 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 7),
                (select case when rh31_sexo = ''F'' then 4002955
                when rh31_sexo = ''M'' then 4002954
                else 4002954
                end as sexoDep8 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 7),
                (select case when rh31_irf = ''0'' then 4002957
                else 4002956
                end as depIRRF8 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 7),
                (select case when rh31_depend = ''C'' or rh31_depend = ''S'' then 4002958
                when rh31_depend = ''S'' then 4002958
                else 4002959
                end as depSF8 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 7),
                (select case when rh31_especi = ''C'' or rh31_especi = ''S'' then 4002961
                when rh31_especi = ''N'' then 4002960
                end as incTrab8 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 7),
            --9
            (select  case when rh31_gparen = ''C'' then 4002962
                when rh31_gparen = ''F'' then 4002964
                when rh31_gparen = ''P'' then 4002968
                when rh31_gparen = ''M'' then 4002968
                when rh31_gparen = ''A'' then 4002968
                when rh31_gparen = ''O'' then 4002972
                end as tpDep9 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 8),
                (select rh31_nome as nmDep9 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 8),
                (select rh31_dtnasc as dtNascto9 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 8),
                (select rh31_cpf as cpfDep9 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 8),
                (select case when rh31_sexo = ''F'' then 4002977
                when rh31_sexo = ''M'' then 4002976
                else 4002976
                end as sexoDep9 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 8),
                (select case when rh31_irf = ''0'' then 4002979
                else 4002978
                end as depIRRF9 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 8),
                (select case when rh31_depend = ''C'' or rh31_depend = ''S'' then 4002980
                when rh31_depend = ''S'' then 4002980
                else 4002981
                end as depSF9 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 8),
                (select case when rh31_especi = ''C'' or rh31_especi = ''S'' then 4002983
                when rh31_especi = ''N'' then 4002982
                end as incTrab9 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 8),
            --10
            (select  case when rh31_gparen = ''C'' then 4002984
                when rh31_gparen = ''F'' then 4002986
                when rh31_gparen = ''P'' then 4002990
                when rh31_gparen = ''M'' then 4002990
                when rh31_gparen = ''A'' then 4002990
                when rh31_gparen = ''O'' then 4002994
                end as tpDep10 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 9),
                (select rh31_nome as nmDep10 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 9),
                (select rh31_dtnasc as dtNascto10 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 9),
                (select rh31_cpf as cpfDep10 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 9),
                (select case when rh31_sexo = ''F'' then 4002999
                when rh31_sexo = ''M'' then 4002998
                else 4002998
                end as sexoDep10 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 9),
                (select case when rh31_irf = ''0'' then 4003001
                else 4003000
                end as depIRRF10 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 9),
                (select case when rh31_depend = ''C'' or rh31_depend = ''S'' then 4003002
                when rh31_depend = ''S'' then 4003002
                else 4003003
                end as depSF10 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 9),
                (select case when rh31_especi = ''C'' or rh31_especi = ''S'' then 4003005
                when rh31_especi = ''N'' then 4003004
                end as incTrab10 from rhdepend where rh31_regist = rh01_regist order by rh31_codigo limit 1 offset 9),
            --  Informações de Contato
                z01_telef as fonePrinc,
                z01_email as emailPrinc,
            --  Grupo de informações do vínculo ( vinculo )
                rh01_regist as matricula,
                case when rh30_regime = 1 or rh30_regime = 3 then 4001007
                when rh30_regime = 2 then 4001006
                end as tpRegTrab,
                case when r33_tiporegime = ''1'' then 4001008
                when r33_tiporegime = ''2'' then 4001009
                end as tpRegPrev,
                case when DATE_PART(''YEAR'',rh01_admiss) <= 2021 and DATE_PART(''MONTH'',rh01_admiss) <= 11 then 4001011
                when DATE_PART(''YEAR'',rh01_admiss) < 2021 and DATE_PART(''MONTH'',rh01_admiss) <= 12 then 4001011
                when DATE_PART(''YEAR'',rh01_admiss) = 2021 and DATE_PART(''MONTH'',rh01_admiss) = 12 then 4001012
                when DATE_PART(''YEAR'',rh01_admiss) >= 2021 then 4001012
                end as cadIni,
            --  Informações de trabalhador celetista ( infoCeletista )
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh01_admiss
                end as dtAdm,
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and (rh01_tipadm = 1 or rh01_tipadm = 2) then 4001014
                when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and (rh01_tipadm = 3 or rh01_tipadm = 4) then 4001016
                end as tpAdmissao,
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then 4001020
                end as indAdmissao,
                '''' as nrProcTrab,
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then 4001023
                end as tpRegJor,
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then 4001027
                end as natAtividade,
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh116_cnpj
                end as cnpjSindCategProf,
            --  Informações do Fundo de Garantia
                rh15_data as dtOpcFGTS,
            --  Informações de trabalhador estatutário
                case when h13_categoria = 301 then 4001054
                when h13_categoria = 302 then 4001055
                when h13_categoria = 303 then 4001059
                when h13_categoria = 306 then 4001060
                when h13_categoria = 309 then 4001064
                end as tpProv,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) then rh01_admiss
                end as dtExercicio,
                case when r33_tiporegime = ''2'' then 4001066
                end as tpPlanRP,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) then 4001071
                end as indTetoRGPS,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) and rh02_abonopermanencia = ''f'' and r33_tiporegime = ''2'' then 4001073
                when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) and rh02_abonopermanencia = ''t'' and r33_tiporegime = ''2'' then 4001072
                end as indAbonoPerm,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) then rh02_datainicio
                end as dtIniAbono,
            --  Informações do contrato de trabalho
             case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh37_descr
                end as nmCargo,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh37_cbo
                end as CBOCargo,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh01_admiss
                end as dtIngrCargo,
                 case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_descr is null then rh37_descr
                     when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_descr is not null then rh04_descr
                     when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and h13_tipocargo = 6 and h13_dscapo = ''SCM'' and rh04_descr is not null then rh04_descr
                     when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and h13_tipocargo = 6 and h13_dscapo = ''SCM'' and rh04_descr is null then rh37_descr
                END as nmFuncao,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_cbo is null then rh37_cbo
                     when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_cbo is not null then rh04_cbo
                end as CBOFuncao,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh37_reqcargo in (1,2,3,5) then 4001083
                     when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh37_reqcargo = 4 then 4001084
                end as acumCargo,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then h13_categoria
                end as codCateg,
            --  Informações da remuneração e periodicidade de pagamento
                case when h13_categoria = 101 then rh02_salari
                end as vrSalFx,
                case when h13_categoria = 101 and rh02_tipsal = ''M'' then 4001092
                when h13_categoria = 101 and rh02_tipsal = ''Q'' then 4001091
                when h13_categoria = 101 and rh02_tipsal = ''D'' then 4001089
                when h13_categoria = 101 and rh02_tipsal = ''H'' then 4001088
                end as undSalFixo,
            --  Duração do contrato de trabalho
               case when h13_categoria = 101 and h13_tipocargo = 7 or rh164_datafim is not null then 4001097
                when h13_categoria = 101 then 4001096
                end as tpContr,
                rh164_datafim as dtTerm,
                case when h13_categoria = 101 and h13_tipocargo = 7 or rh164_datafim is not null then 4001101
                end as clauAssec,
            --Estabelecimento (CNPJ, CNO, CAEPF) onde o trabalhador (exceto doméstico) exercerá suas atividades
                    4001106 as tpinsc_localtrabgeral,
                    cgc as nrinsc_localtrabgeral,
                    nomeinst as desccomp_localtrabgeral,
            --  Informações do horário contratual do trabalhador
                rh02_hrssem as qtdHrsSem,
                case when rh02_tipojornada = 2 then 4001117
                when rh02_tipojornada = 3 then 4001118
                when rh02_tipojornada = 4 then 4001119
                when rh02_tipojornada = 5 then 4001120
                when rh02_tipojornada = 6 then 4001121
                when rh02_tipojornada = 7 then 4001122
                when rh02_tipojornada = 9 then 4001123
                end as tpJornada,
                4001124 as tmpParc,
                case when rh02_horarionoturno = ''f'' then 4001129
                when rh02_horarionoturno = ''t'' then 4001128
                end as horNoturno,
                jt_descricao as dscJorn
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
                        where h13_categoria in ( ''301'')
                        and rh30_vinculo = ''A''
            and (
                        (rh02_mesusu = 11
                        and rh02_anousu = 2021
                        and rh05_recis is not null
                        and date_part(''month'',rh01_admiss::date) <> 12
                        and date_part(''day'',rh05_recis::date) >= 21
                        and date_part(''month'',rh05_recis::date) = 11
                        and date_part(''year'',rh05_recis::date) = 2021
                        )
                        or
                        (rh02_mesusu = 11
                        and rh02_anousu = 2021
                        and rh05_recis is null
                        )
                        or
                        (rh02_anousu >= 2021
                        and date_part(''month'',rh01_admiss::date) = date_part(''month'',fc_getsession(''DB_datausu'')::date)
                        and date_part(''year'',rh01_admiss::date) = fc_getsession(''DB_anousu'')::int
                        )
                )', db101_permiteedicao=false WHERE db101_sequencial=4000102;

        ";

        $this->execute($sql);
    }
}
