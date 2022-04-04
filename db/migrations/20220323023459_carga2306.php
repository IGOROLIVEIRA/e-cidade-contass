<?php

use Phinx\Migration\AbstractMigration;

class Carga2306 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        UPDATE db_itensmenu SET funcao = 'con4_manutencaoformulario001.php?esocial=45' WHERE descricao ILIKE 'S-2306%';

        UPDATE avaliacaopergunta SET db103_camposql = 'tpregprevsindical' WHERE db103_identificador = 'tipo-de-regime-previdenciario-ou-sistema-4001136';
        UPDATE avaliacaopergunta SET db103_camposql = 'tpregprevcedido' WHERE db103_identificador = 'tipo-de-regime-previdenciario-ou-sistema-d-4001137';

        UPDATE avaliacaopergunta SET db103_avaliacaotiporesposta = 2 WHERE db103_identificador = 'preencher-com-o-codigo-da-categoria-do-tr-4001123';
        INSERT INTO avaliacaoperguntaopcao VALUES (
            (SELECT max(db104_sequencial)+1 FROM avaliacaoperguntaopcao),
            (SELECT db103_sequencial FROM avaliacaopergunta WHERE db103_identificador = 'preencher-com-o-codigo-da-categoria-do-tr-4001123'), 
            NULL,
            't',
            (SELECT db103_identificadorcampo FROM avaliacaopergunta WHERE db103_identificador = 'preencher-com-o-codigo-da-categoria-do-tr-4001123')||'-'||(SELECT max(db104_sequencial)+1 FROM avaliacaoperguntaopcao)::varchar,
            0,
            NULL,
            (SELECT db103_identificadorcampo FROM avaliacaopergunta WHERE db103_identificador = 'tipo-de-logradouro-4001028'));

        UPDATE avaliacao SET db101_descricao = 'Formulário S-2306 versão S-1.0', db101_obs = 'Formulário S-2306 versão S-1.0', db101_cargadados = '
        SELECT distinct
        --ideTrabSemVinculo
        cgm.z01_cgccpf as cpfTrab,
        rhpessoal.rh01_regist as matricula,
        h13_categoria as codCateg,
        --infoTSVAlteracao
        --dtAlteracao VERIFICAR
        --natAtividade
        --cargoFuncao
        rh37_descr as nmCargo,
        rh37_cbo as CBOCargo,
        --'' as nmFuncao,
        --'' as CBOFuncao,
        --remuneracao
        round(rh02_salari,2) as vrSalFx,
        case when rh02_tipsal = \'M\' then 4001932
        when rh02_tipsal = \'Q\' then 4001931
        when rh02_tipsal = \'D\' then 4001929
        when rh02_tipsal = \'H\' then 4001928
            else 4001932 end as undSalFixo,
        \'\' as dscSalVar,
        --infoDirigenteSindical
        --tpRegPrev
        --infoTrabCedido
        --tpRegPrev
        --infoMandElet
        4001943 as indRemunCargo,
        case 
        when r33_tiporegime = \'1\' then 4001945 
        when r33_tiporegime = \'2\' then 4001946 
        else NULL end as tpRegPrev,
        --infoEstagiario
        CASE 
        WHEN h83_naturezaestagio = \'O\' THEN 4001948
        WHEN h83_naturezaestagio = \'N\' THEN 4001949
        ELSE NULL
        END as natEstagio,
        CASE 
        WHEN h83_nivelestagio = 1 THEN 4001950
        WHEN h83_nivelestagio = 2 THEN 4001951
        WHEN h83_nivelestagio = 3 THEN 4001952
        WHEN h83_nivelestagio = 4 THEN 4001953
        WHEN h83_nivelestagio = 8 THEN 4001954
        WHEN h83_nivelestagio = 9 THEN 4001955
        ELSE NULL
        END as nivEstagio,
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
        --supervisorEstagio,
        cgmsupervisor.z01_cgccpf as cpfSupervisor
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
        AND ((rh02_anousu,rh02_mesusu) = (2021,12) OR rh02_anousu > 2021)
        AND rh02_salari != (SELECT rh02_salari FROM rhpessoalmov mov 
            WHERE mov.rh02_regist = rhpessoalmov.rh02_regist AND mov.rh02_seqpes < rhpessoalmov.rh02_seqpes ORDER BY mov.rh02_seqpes desc limit 1)
        ' 
        WHERE db101_identificador='s2306-vs1';
        ";
        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        UPDATE avaliacao SET db101_descricao = 'Formulário S-2399 versão S-1.0', db101_obs = 'Formulário S-2399 versão S-1.0',db101_cargadados = NULL WHERE db101_identificador='s2306-vs1';
        ";
        $this->execute($sql);
    }
}
