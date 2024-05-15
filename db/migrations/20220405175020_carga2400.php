<?php

use Phinx\Migration\AbstractMigration;

class Carga2400 extends AbstractMigration
{

    public function up()
    {
        $sql = "
        UPDATE avaliacaopergunta SET db103_camposql = db103_camposql||'ext' WHERE db103_avaliacaogrupopergunta = 4000356;
        UPDATE db_itensmenu SET funcao = 'con4_manutencaoformulario001.php?esocial=47' WHERE descricao ILIKE 'S-2400%';

        INSERT INTO avaliacaoperguntaopcao VALUES (
            (SELECT max(db104_sequencial)+1 FROM avaliacaoperguntaopcao),
            (SELECT db103_sequencial FROM avaliacaopergunta WHERE db103_identificador = 'tipo-de-logradouro-4001203'), 
            NULL,
            't',
            (SELECT db103_identificadorcampo FROM avaliacaopergunta WHERE db103_identificador = 'tipo-de-logradouro-4001203')||'-'||(SELECT max(db104_sequencial)+1 FROM avaliacaoperguntaopcao)::varchar,
            0,
            NULL,
            (SELECT db103_identificadorcampo FROM avaliacaopergunta WHERE db103_identificador = 'tipo-de-logradouro-4001203'));

        UPDATE avaliacaopergunta
        SET db103_camposql = 'incfismendep'
        WHERE db103_identificador = 'informar-se-o-dependente-e-pessoa-com-do-4001224';

        INSERT INTO habitacao.avaliacaopergunta (db103_sequencial, db103_avaliacaotiporesposta, db103_avaliacaogrupopergunta, db103_descricao, db103_obrigatoria, db103_ativo, db103_ordem, db103_identificador, db103_tipo, db103_mascara, db103_dblayoutcampo, db103_perguntaidentificadora, db103_camposql, db103_identificadorcampo)
        VALUES( (SELECT max(db103_sequencial)+1 FROM avaliacaopergunta), 
                                             2,
                                             4000354,
                                             'Instituição no e-Cidade:',
                                             TRUE,
                                             TRUE,
                                             1,
                                             'instituicao-no-ecidade-4000354',
                                             6,
                                             '',
                                             0,
                                             TRUE,
                                             'instituicao',
                                             'instituicao');

        INSERT INTO avaliacaoperguntaopcao
        VALUES (
            (SELECT max(db104_sequencial)+1 FROM avaliacaoperguntaopcao),
            (SELECT db103_sequencial FROM avaliacaopergunta WHERE db103_identificador = 'instituicao-no-ecidade-4000354'), 
            NULL, 
            't',
            (SELECT db103_identificadorcampo FROM avaliacaopergunta WHERE db103_identificador = 'instituicao-no-ecidade-4000354')||'-'|| (SELECT max(db104_sequencial)+1
             FROM avaliacaoperguntaopcao)::varchar, 0, NULL, (SELECT db103_identificadorcampo FROM avaliacaopergunta WHERE db103_identificador = 'instituicao-no-ecidade-4000354'));

        UPDATE avaliacaopergunta
        SET db103_perguntaidentificadora = 't'
        WHERE db103_identificador = 'informar-o-cpf-do-beneficiario-4001194';

        UPDATE avaliacao SET db101_cargadados = '
        SELECT DISTINCT z01_cgccpf AS cpfbenef,
                z01_nome AS nmbenefic,
                rh01_nasc AS dtnascto,
                CASE
                    WHEN rh01_admiss <= \'2021-11-22\' THEN \'2021-11-22\'
                    WHEN rh01_admiss > \'2021-11-22\' THEN rh01_admiss
                END AS dtinicio,
                CASE
                    WHEN rh01_sexo = \'F\' THEN 4002049
                    ELSE 4002048
                END AS sexo,
                CASE
                    WHEN rh01_raca = 1 THEN 4002054
                    WHEN rh01_raca = 2 THEN 4002050
                    WHEN rh01_raca = 4 THEN 4002051
                    WHEN rh01_raca = 6 THEN 4002053
                    WHEN rh01_raca = 8 THEN 4002052
                    WHEN rh01_raca = 9 THEN 4002055
                END AS racacor,
                CASE
                    WHEN rh01_estciv = 1 THEN 4002056
                    WHEN rh01_estciv = 2 THEN 4002057
                    WHEN rh01_estciv = 3 THEN 4002060
                    WHEN rh01_estciv = 4 THEN 4002059
                    WHEN rh01_estciv = 5 THEN 4002058
                    ELSE 4002056
                END AS estciv,
                CASE
                    WHEN rh02_portadormolestia = \'t\' THEN 4002061
                    ELSE 4002062
                END AS incfismen,
                CASE
                    WHEN ruas.j14_tipo IS NULL THEN \'R\'
                    ELSE j88_sigla
                END AS tplograd,
                z01_ender AS dsclograd,
                z01_numero AS nrlograd,
                z01_compl AS complementolograd,
                z01_bairro AS bairro,
                rpad(z01_cep,8,\'0\') AS cep,
                (coalesce((select
                    db125_codigosistema
                from
                    cadendermunicipio
                inner join cadendermunicipiosistema on
                    cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial
                    and cadendermunicipiosistema.db125_db_sistemaexterno = 4
                where to_ascii(db72_descricao) = to_ascii(trim(cgm.z01_munic)) limit 1), (select
                    db125_codigosistema
                from
                    cadendermunicipio
                inner join cadendermunicipiosistema on
                    cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial
                    and cadendermunicipiosistema.db125_db_sistemaexterno = 4
                where to_ascii(db72_descricao) = to_ascii(trim((SELECT z01_munic FROM cgm join db_config ON z01_numcgm = numcgm WHERE codigo = fc_getsession(\'DB_instit\')::int))) limit 1))
                ) AS codMunic,
                            4002082 AS uf
            FROM rhpessoal
            INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
            INNER JOIN db_config ON db_config.codigo = rhpessoal.rh01_instit
            LEFT JOIN db_cgmbairro ON cgm.z01_numcgm = db_cgmbairro.z01_numcgm
            LEFT JOIN bairro ON bairro.j13_codi = db_cgmbairro.j13_codi
            LEFT JOIN db_cgmruas ON cgm.z01_numcgm = db_cgmruas.z01_numcgm
            LEFT JOIN ruas ON ruas.j14_codigo = db_cgmruas.j14_codigo
            LEFT JOIN ruastipo ON j88_codigo = j14_tipo
            LEFT JOIN rhpessoalmov ON rh02_anousu = (select r11_anousu from cfpess where r11_instit = fc_getsession(\'DB_instit\')::int order by r11_anousu desc, r11_mesusu desc limit 1)
            AND rh02_mesusu = (select r11_mesusu from cfpess where r11_instit = fc_getsession(\'DB_instit\')::int order by r11_anousu desc, r11_mesusu desc limit 1)
            AND rh02_regist = rh01_regist
            AND rh02_instit = fc_getsession(\'DB_instit\')::int
            LEFT JOIN rhdepend ON rhdepend.rh31_regist = rhpessoal.rh01_regist
            LEFT JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
            LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
            LEFT JOIN rescisao ON rescisao.r59_anousu = rhpessoalmov.rh02_anousu
            AND rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu
            AND rescisao.r59_regime = rhregime.rh30_regime
            AND rescisao.r59_causa = rhpesrescisao.rh05_causa
            AND rescisao.r59_caub = rhpesrescisao.rh05_caub::char(2)
            where rh30_vinculo in (\'I\',\'P\')  
            AND (
            ( 
            (date_part(\'year\',rhpessoal.rh01_admiss)::varchar || lpad(date_part(\'month\',rhpessoal.rh01_admiss)::varchar,2,\'0\'))::integer <= 202207
            and (date_part(\'year\',fc_getsession(\'DB_datausu\')::date)::varchar || lpad(date_part(\'month\',fc_getsession(\'DB_datausu\')::date)::varchar,2,\'0\'))::integer <= 202207
            and (rh05_recis is null or (date_part(\'year\',rh05_recis)::varchar || lpad(date_part(\'month\',rh05_recis)::varchar,2,\'0\'))::integer > 202207)
            ) or (
            date_part(\'month\',rhpessoal.rh01_admiss) = date_part(\'month\',fc_getsession(\'DB_datausu\')::date)
            and date_part(\'year\',rhpessoal.rh01_admiss) = date_part(\'year\',fc_getsession(\'DB_datausu\')::date) 
            and (date_part(\'year\',fc_getsession(\'DB_datausu\')::date)::varchar || lpad(date_part(\'month\',fc_getsession(\'DB_datausu\')::date)::varchar,2,\'0\'))::integer > 202207
            )
            )
        ' 
        WHERE db101_identificador='s2400-vs1';
        ";
        $this->execute($sql);
    }

    public function down()
    {
        
    }
}
