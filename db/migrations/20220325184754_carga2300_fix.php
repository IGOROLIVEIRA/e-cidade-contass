<?php

use Phinx\Migration\AbstractMigration;

class Carga2300Fix extends AbstractMigration
{
    public function up()
    {
        $sql = "
        UPDATE avaliacaopergunta
        SET db103_camposql = db103_camposql||'ext'
        WHERE db103_avaliacaogrupopergunta = 4000312;

        UPDATE avaliacaopergunta
        SET db103_camposql = db103_camposql||'instensino'
        WHERE db103_avaliacaogrupopergunta = 4000326
            AND db103_camposql != 'cnpjinstensino';

        UPDATE avaliacaopergunta
        SET db103_camposql = db103_camposql||'dep'
        WHERE db103_identificador = 'preencher-com-a-data-de-nascimento-4001054';

        UPDATE avaliacaopergunta
        SET db103_camposql = 'undsalfixo', db103_identificadorcampo = 'undSalFixo'
        WHERE db103_identificador = 'unidade-de-pagamento-da-parte-fixa-da-rem-4001075';

        UPDATE avaliacao SET db101_cargadados = '
        SELECT distinct
        --trabalhador
        cgm.z01_cgccpf as cpfTrab,
        cgm.z01_nome as nmTrab,
        CASE WHEN rhpessoal.rh01_sexo = \'M\' THEN 4001709
             WHEN rhpessoal.rh01_sexo = \'F\' THEN 4001710
             END AS sexo,
        CASE WHEN rhpessoal.rh01_raca = 2 THEN 4001711
            WHEN rhpessoal.rh01_raca = 4 THEN 4001712
            WHEN rhpessoal.rh01_raca = 6 THEN 4001714
            WHEN rhpessoal.rh01_raca = 8 THEN 4001713
            WHEN rhpessoal.rh01_raca = 1 THEN 4001715
            WHEN rhpessoal.rh01_raca = 9 THEN 4001716
            END AS racaCor,
            case when rhpessoal.rh01_estciv = 1 then 4001717
            when rhpessoal.rh01_estciv = 2 then 4001718
            when rhpessoal.rh01_estciv = 5 then 4001719
            when rhpessoal.rh01_estciv = 4 then 4001720
            when rhpessoal.rh01_estciv = 3 then 4001721
            else 4001717
            end as estCiv,
            case when rhpessoal.rh01_instru = 1 then 4001722
            when rhpessoal.rh01_instru = 2 then 4001723
            when rhpessoal.rh01_instru = 3 then 4001724
            when rhpessoal.rh01_instru = 4 then 4001725
            when rhpessoal.rh01_instru = 5 then 4001726
            when rhpessoal.rh01_instru = 6 then 4001727
            when rhpessoal.rh01_instru = 7 then 4001728
            when rhpessoal.rh01_instru = 8 then 4001729
            when rhpessoal.rh01_instru = 9 then 4001730
            when rhpessoal.rh01_instru = 10 then 4001732 
            when rhpessoal.rh01_instru = 11 then 4001733
            when rhpessoal.rh01_instru = 0 then 4001722
            end as grauInstr,
            \'\' as nmSoc,
            --nascimento
            rhpessoal.rh01_nasc as dtNascto,
            \'105\' as paisNascto,
            \'105\' as paisNac,
            case when ruas.j14_tipo is null then \'R\'
            else j88_sigla
            --brasil
            end as tpLograd,
            cgm.z01_ender as dscLograd, 
            cgm.z01_numero  as nrLograd,
            cgm.z01_compl as complemento,
            cgm.z01_bairro as bairro,
            cgm.z01_cep as cep,
            (select
            db125_codigosistema
        from
            cadendermunicipio
        inner join cadendermunicipiosistema on
            cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial
            and cadendermunicipiosistema.db125_db_sistemaexterno = 4
        where to_ascii(db72_descricao) = to_ascii(trim(cgm.z01_munic))) AS codMunic,
            CASE WHEN cgm.z01_uf is null or trim(cgm.z01_uf) = \'\' then \'MG\'
            else cgm.z01_uf end as uf,
            --exterior
            --\'\' as paisResid,
            --\'\' as dscLogradExterior,
            --\'\' as nrLogradExterior,
            --\'\' as complementoExterior,
            --\'\' as bairroExterior,
            --\'\' as nmCidExterior,
            --\'\' as codPostalExterior,
            --trabImig
            \'\' as tmpResid,
            \'\' as condIng,
            --infoDeficiencia
            case when rh02_deficientefisico = true then 4001756 else 4001757 end as defFisica,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 3 then 4001758 else 4001759 end as defVisual,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 2 then 4001760 else 4001761 end as defAuditiva,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 7 then 4001762 else 4001763 end as defMental,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 4 then 4001764 else 4001765 end as defIntelectual,
            case when rh02_reabreadap = true then 4001766 else 4001767 end as reabReadap,
            \'\' as observacao,
            --dependente
            --case when rh31_gparen \'C\' then \'01\' 
            --when rh31_gparen \'F\' and rh31_irf IN(\'0\',\'2\') then \'03\' 
            --when rh31_gparen \'F\' and rh31_irf IN(\'3\') then \'04\' 
            --when rh31_gparen in(\'P\',\'M\',\'A\') then \'09\' 
            --when rh31_gparen = \'O\' then \'99\' 
            --end as tpDep,
            --rh31_nome as nmDep,
            --rh31_dtnasc as dtNascto,
            --rh31_cpf as cpfDep,
            --rh31_sexo as sexoDep,
            --case when rh31_irf in (1,2,3,4,5,6,7,8) then \'S\'
            --case when rh31_irf = 0 then \'N\'
            --else \'N\' end as depIRRF
            --case when rh31_depend in (\'C\',\'S\') then \'S\'
            --when rh31_depend = \'N\' then \'N\'
            --else \'N\' end as depSF
            --case when rh31_especi in (\'C\',\'S\') then \'S\'
            --when rh31_especi = \'N\' then \'N\'
            --else \'N\' end as incTrab
            --contato
            cgm.z01_telef as fonePrinc,
            cgm.z01_email as emailPrinc,
            --infoTSVInicio
            CASE WHEN rhpessoal.rh01_admiss <= \'2021-11-22\'::date then 4001792 else 4001793 end as cadIni,
            rhpessoal.rh01_regist as matricula,
            h13_categoria as codCateg,
            rhpessoal.rh01_admiss as dtInicio,
            --\'\' as nrProcTrab,
            --cargoFuncao
            rh37_descr as nmCargo,
            rh37_cbo as CBOCargo,
            --\'\' as nmFuncao,
            --\'\' as CBOFuncao,
            --remuneracao
            round(rh02_salari,2) as vrSalFx,
            case when rh02_tipsal = \'M\' then 4001808
        when rh02_tipsal = \'Q\' then 4001807
        when rh02_tipsal = \'D\' then 4001805
        when rh02_tipsal = \'H\' then 4001804
            else 4001808 end as undSalFixo,
            \'\' as dscSalVar,
            --FGTS
            \'\' as dtOpcFGTS,
            --infoDirigenteSindical
            --\'\' as categOrigInfoDirigenteSindical,
            --\'\' as tpInscInfoDirigenteSindical,
            --\'\' as nrInscInfoDirigenteSindical,
            --\'\' as dtAdmOrigInfoDirigenteSindical,
            --\'\' as matricOrigInfoDirigenteSindical,
            --\'\' as tpRegTrabInfoDirigenteSindical,
            --\'\' as tpRegPrevInfoDirigenteSindical,
            --infoTrabCedido
            case when rhpessoal.rh01_tipadm in (3,4) then h13_categoria else NULL end as categOrig,
            case when rhpessoal.rh01_tipadm in (3,4) then rh02_cnpjcedente else \'\' end as cnpjCednt,
            case when rhpessoal.rh01_tipadm in (3,4) then rh02_mattraborgcedente else \'\' end as matricCed,
            case when rhpessoal.rh01_tipadm in (3,4) then rh02_dataadmisorgcedente else NULL end as dtAdmCed,
            case when rhpessoal.rh01_tipadm in (3,4) and rh30_regime in (1,3) then 2
            when rhpessoal.rh01_tipadm in (3,4) and rh30_regime = 2 then 1
            else NULL end as tpRegTrab,
            case when rhpessoal.rh01_tipadm in (3,4) and r33_tiporegime in(\'1\',\'2\') then r33_tiporegime
            else \'\' end as tpRegPrev,
            --infoMandElet
            case when h13_categoria = 304 then \'N\' end as indRemunCargo,
            case when h13_categoria = 304 and rh30_regime in (1,3) then 2 
            when h13_categoria = 304 and rh30_regime = 2 then 1 
            end as tpRegTrabInfoMandElet,
            case when h13_categoria = 304 and r33_tiporegime in (\'1\',\'2\') then r33_tiporegime 
            else \'\' end as tpRegPrevInfoMandElet,
            --infoEstagiario
            h83_naturezaestagio as natEstagio,
            h83_nivelestagio as nivEstagio,
            h83_curso as areaAtuacao,
            h83_numapoliceseguro as nrApol,
            h83_dtfim as dtPrevTerm,
            --instEnsino
            h83_cnpjinstensino as cnpjInstEnsino,
            --\'\' as nmRazao,
            --\'\' as dscLogradInstEnsino,
            --\'\' as nrLogradInstEnsino,
            --\'\' as bairroInstEnsino,
            --\'\' as cepInstEnsino,
            --\'\' as codMunicInstEnsino,
            --\'\' as ufInstEnsino,
            --ageIntegracao
            \'\' as cnpjAgntInteg,
            --supervisorEstagio
            cgmsupervisor.z01_cgccpf as cpfSupervisor,
            --mudancaCPF
            --\'\' as cpfAnt,
            --\'\' as matricAnt,
            --\'\' as dtAltCPF,
            --\'\' as observacao,
            --afastamento
            \'\' as dtIniAfast,
            \'\' as codMotAfast,
            --termino
            \'\' as dtDeslig
            FROM rhpessoal
            join cgm on rhpessoal.rh01_numcgm = cgm.z01_numcgm
            join rhpessoalmov on rhpessoal.rh01_regist = rh02_regist and (rh02_anousu,rh02_mesusu) = (fc_getsession(\'DB_anousu\')::int,date_part(\'month\',fc_getsession(\'DB_datausu\')::date)::int)
            left join tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            left join rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
            left join rhfuncao on rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
            and rhfuncao.rh37_instit = rhpessoalmov.rh02_instit
            left join db_cgmruas on cgm.z01_numcgm = db_cgmruas.z01_numcgm
        left join ruas on ruas.j14_codigo = db_cgmruas.j14_codigo
        left join ruastipo on j88_codigo = j14_tipo
        left join rhestagiocurricular on rhpessoal.rh01_regist = h83_regist
        left join rhpessoal as rhpessoalsupervisor on h83_supervisor = rhpessoalsupervisor.rh01_regist
        left join cgm as cgmsupervisor ON cgmsupervisor.z01_numcgm = rhpessoalsupervisor.rh01_numcgm
        left join inssirf on (r33_codtab::integer-2,r33_anousu,r33_mesusu) = (rh02_tbprev,rh02_anousu,rh02_mesusu)
        left join rhpesrescisao on rh05_seqpes = rh02_seqpes
        WHERE rhpessoal.rh01_instit = fc_getsession(\'DB_instit\')::int 
        AND h13_categoria in (304,701,711,712,721,722,723,731,734,738,771,901,903)
        AND rh30_vinculo = \'A\'
        AND (
        (
        rh02_mesusu = 11
        and rh02_anousu = 2021
        and date_part(\'month\',rhpessoal.rh01_admiss::date) <> 12
        and rh05_recis is null
        )
        or
        (rh02_mesusu = 11
            and rh02_anousu = 2021
            and (rh05_recis is not null
                and date_part(\'month\',rhpessoal.rh01_admiss::date) <> 12
                and date_part(\'day\',rh05_recis::date) <= 21
                and date_part(\'month\',rh05_recis::date) = 11
                )
            or
            ( 
            rh02_anousu > 2021
            and date_part(\'month\',rhpessoal.rh01_admiss::date) = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
            and date_part(\'year\',rhpessoal.rh01_admiss::date) = fc_getsession(\'DB_anousu\')::int
            )
        )
    )
        ' 
        WHERE db101_identificador='s2300-vs1'";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        UPDATE avaliacao SET db101_cargadados = '
        SELECT distinct
        --trabalhador
        cgm.z01_cgccpf as cpfTrab,
        cgm.z01_nome as nmTrab,
        rhpessoal.rh01_sexo as sexo,
        CASE WHEN rhpessoal.rh01_raca = 2 THEN 4001711
            WHEN rhpessoal.rh01_raca = 4 THEN 4001712
            WHEN rhpessoal.rh01_raca = 6 THEN 4001714
            WHEN rhpessoal.rh01_raca = 8 THEN 4001713
            WHEN rhpessoal.rh01_raca = 1 THEN 4001715
            WHEN rhpessoal.rh01_raca = 9 THEN 4001716
            END AS racaCor,
            case when rhpessoal.rh01_estciv = 1 then 4001717
            when rhpessoal.rh01_estciv = 2 then 4001718
            when rhpessoal.rh01_estciv = 5 then 4001719
            when rhpessoal.rh01_estciv = 4 then 4001720
            when rhpessoal.rh01_estciv = 3 then 4001721
            else 4001717
            end as estCiv,
            case when rhpessoal.rh01_instru = 1 then 4001722
            when rhpessoal.rh01_instru = 2 then 4001723
            when rhpessoal.rh01_instru = 3 then 4001724
            when rhpessoal.rh01_instru = 4 then 4001725
            when rhpessoal.rh01_instru = 5 then 4001726
            when rhpessoal.rh01_instru = 6 then 4001727
            when rhpessoal.rh01_instru = 7 then 4001728
            when rhpessoal.rh01_instru = 8 then 4001729
            when rhpessoal.rh01_instru = 9 then 4001730
            when rhpessoal.rh01_instru = 10 then 4001732 
            when rhpessoal.rh01_instru = 11 then 4001733
            when rhpessoal.rh01_instru = 0 then 4001722
            end as grauInstr,
            \'\' as nmSoc,
            --nascimento
            rhpessoal.rh01_nasc as dtNascto,
            \'105\' as paisNascto,
            \'105\' as paisNac,
            case when ruas.j14_tipo is null then \'R\'
            else j88_sigla
            --brasil
            end as tpLograd,
            cgm.z01_ender as dscLograd, 
            cgm.z01_numero  as nrLograd,
            cgm.z01_compl as complemento,
            cgm.z01_bairro as bairro,
            cgm.z01_cep as cep,
            (select
            db125_codigosistema
        from
            cadendermunicipio
        inner join cadendermunicipiosistema on
            cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial
            and cadendermunicipiosistema.db125_db_sistemaexterno = 4
        where to_ascii(db72_descricao) = to_ascii(trim(cgm.z01_munic))) AS codMunic,
            CASE WHEN cgm.z01_uf is null or trim(cgm.z01_uf) = \'\' then \'MG\'
            else cgm.z01_uf end as uf,
            --exterior
            --\'\' as paisResid,
            --\'\' as dscLogradExterior,
            --\'\' as nrLogradExterior,
            --\'\' as complementoExterior,
            --\'\' as bairroExterior,
            --\'\' as nmCidExterior,
            --\'\' as codPostalExterior,
            --trabImig
            \'\' as tmpResid,
            \'\' as condIng,
            --infoDeficiencia
            case when rh02_deficientefisico = true then \'S\' else \'N\' end as defFisica,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 3 then \'S\' else \'N\' end as defVisual,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 2 then \'S\' else \'N\' end as defAuditiva,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 7 then \'S\' else \'N\' end as defMental,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 4 then \'S\' else \'N\' end as defIntelectual,
            case when rh02_reabreadap = true then \'S\' else \'N\' end as reabReadap,
            \'\' as observacao,
            --dependente
            --case when rh31_gparen \'C\' then \'01\' 
            --when rh31_gparen \'F\' and rh31_irf IN(\'0\',\'2\') then \'03\' 
            --when rh31_gparen \'F\' and rh31_irf IN(\'3\') then \'04\' 
            --when rh31_gparen in(\'P\',\'M\',\'A\') then \'09\' 
            --when rh31_gparen = \'O\' then \'99\' 
            --end as tpDep,
            --rh31_nome as nmDep,
            --rh31_dtnasc as dtNascto,
            --rh31_cpf as cpfDep,
            --rh31_sexo as sexoDep,
            --case when rh31_irf in (1,2,3,4,5,6,7,8) then \'S\'
            --case when rh31_irf = 0 then \'N\'
            --else \'N\' end as depIRRF
            --case when rh31_depend in (\'C\',\'S\') then \'S\'
            --when rh31_depend = \'N\' then \'N\'
            --else \'N\' end as depSF
            --case when rh31_especi in (\'C\',\'S\') then \'S\'
            --when rh31_especi = \'N\' then \'N\'
            --else \'N\' end as incTrab
            --contato
            cgm.z01_telef as fonePrinc,
            cgm.z01_email as emailPrinc,
            --infoTSVInicio
            CASE WHEN rhpessoal.rh01_admiss <= \'2021-11-22\'::date then \'S\' else \'N\' end as cadIni,
            rhpessoal.rh01_regist as matricula,
            h13_categoria as codCateg,
            rhpessoal.rh01_admiss as dtInicio,
            --\'\' as nrProcTrab,
            --cargoFuncao
            rh37_descr as nmCargo,
            rh37_cbo as CBOCargo,
            --\'\' as nmFuncao,
            --\'\' as CBOFuncao,
            --remuneracao
            rh02_salari as vrSalFx,
            case when rh02_tipsal = \'M\' then 5
        when rh02_tipsal = \'Q\' then 4
        when rh02_tipsal = \'D\' then 2
        when rh02_tipsal = \'H\' then 1
            else 5 end as undSalFixo,
            \'\' as dscSalVar,
            --FGTS
            \'\' as dtOpcFGTS,
            --infoDirigenteSindical
            --\'\' as categOrigInfoDirigenteSindical,
            --\'\' as tpInscInfoDirigenteSindical,
            --\'\' as nrInscInfoDirigenteSindical,
            --\'\' as dtAdmOrigInfoDirigenteSindical,
            --\'\' as matricOrigInfoDirigenteSindical,
            --\'\' as tpRegTrabInfoDirigenteSindical,
            --\'\' as tpRegPrevInfoDirigenteSindical,
            --infoTrabCedido
            case when rhpessoal.rh01_tipadm in (3,4) then h13_categoria else NULL end as categOrig,
            case when rhpessoal.rh01_tipadm in (3,4) then rh02_cnpjcedente else \'\' end as cnpjCednt,
            case when rhpessoal.rh01_tipadm in (3,4) then rh02_mattraborgcedente else \'\' end as matricCed,
            case when rhpessoal.rh01_tipadm in (3,4) then rh02_dataadmisorgcedente else NULL end as dtAdmCed,
            case when rhpessoal.rh01_tipadm in (3,4) and rh30_regime in (1,3) then 2
            when rhpessoal.rh01_tipadm in (3,4) and rh30_regime = 2 then 1
            else NULL end as tpRegTrab,
            case when rhpessoal.rh01_tipadm in (3,4) and r33_tiporegime in(\'1\',\'2\') then r33_tiporegime
            else \'\' end as tpRegPrev,
            --infoMandElet
            case when h13_categoria = 304 then \'N\' end as indRemunCargo,
            case when h13_categoria = 304 and rh30_regime in (1,3) then 2 
            when h13_categoria = 304 and rh30_regime = 2 then 1 
            end as tpRegTrabInfoMandElet,
            case when h13_categoria = 304 and r33_tiporegime in (\'1\',\'2\') then r33_tiporegime 
            else \'\' end as tpRegPrevInfoMandElet,
            --infoEstagiario
            h83_naturezaestagio as natEstagio,
            h83_nivelestagio as nivEstagio,
            h83_curso as areaAtuacao,
            h83_numapoliceseguro as nrApol,
            h83_dtfim as dtPrevTerm,
            --instEnsino
            h83_cnpjinstensino as cnpjInstEnsino,
            --\'\' as nmRazao,
            --\'\' as dscLogradInstEnsino,
            --\'\' as nrLogradInstEnsino,
            --\'\' as bairroInstEnsino,
            --\'\' as cepInstEnsino,
            --\'\' as codMunicInstEnsino,
            --\'\' as ufInstEnsino,
            --ageIntegracao
            \'\' as cnpjAgntInteg,
            --supervisorEstagio
            cgmsupervisor.z01_cgccpf as cpfSupervisor,
            --mudancaCPF
            --\'\' as cpfAnt,
            --\'\' as matricAnt,
            --\'\' as dtAltCPF,
            --\'\' as observacao,
            --afastamento
            \'\' as dtIniAfast,
            \'\' as codMotAfast,
            --termino
            \'\' as dtDeslig
            FROM rhpessoal
            join cgm on rhpessoal.rh01_numcgm = cgm.z01_numcgm
            join rhpessoalmov on rhpessoal.rh01_regist = rh02_regist and (rh02_anousu,rh02_mesusu) = (fc_getsession(\'DB_anousu\')::int,date_part(\'month\',fc_getsession(\'DB_datausu\')::date)::int)
            left join tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            left join rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
            left join rhfuncao on rhfuncao.rh37_funcao = rhpessoalmov.rh02_funcao
            and rhfuncao.rh37_instit = rhpessoalmov.rh02_instit
            left join db_cgmruas on cgm.z01_numcgm = db_cgmruas.z01_numcgm
        left join ruas on ruas.j14_codigo = db_cgmruas.j14_codigo
        left join ruastipo on j88_codigo = j14_tipo
        left join rhestagiocurricular on rhpessoal.rh01_regist = h83_regist
        left join rhpessoal as rhpessoalsupervisor on h83_supervisor = rhpessoalsupervisor.rh01_regist
        left join cgm as cgmsupervisor ON cgmsupervisor.z01_numcgm = rhpessoalsupervisor.rh01_numcgm
        left join inssirf on (r33_codtab::integer-2,r33_anousu,r33_mesusu) = (rh02_tbprev,rh02_anousu,rh02_mesusu)
        left join rhpesrescisao on rh05_seqpes = rh02_seqpes
        WHERE rhpessoal.rh01_instit = fc_getsession(\'DB_instit\')::int 
        AND h13_categoria in (304,701,711,712,721,722,723,731,734,738,771,901,903)
        AND rh30_vinculo = \'A\'
        AND (
        (
        rh02_mesusu = 11
        and rh02_anousu = 2021
        and date_part(\'month\',rhpessoal.rh01_admiss::date) <> 12
        and rh05_recis is null
        )
        or
        (rh02_mesusu = 11
            and rh02_anousu = 2021
            and (rh05_recis is not null
                and date_part(\'month\',rhpessoal.rh01_admiss::date) <> 12
                and date_part(\'day\',rh05_recis::date) <= 21
                and date_part(\'month\',rh05_recis::date) = 11
                )
            or
            ( 
            rh02_anousu > 2021
            and date_part(\'month\',rhpessoal.rh01_admiss::date) = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
            and date_part(\'year\',rhpessoal.rh01_admiss::date) = fc_getsession(\'DB_anousu\')::int
            )
        )
    )
        ' 
        WHERE db101_identificador='s2300-vs1'";
        $this->execute($sql);
    }
}
