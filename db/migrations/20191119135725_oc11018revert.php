<?php

use Phinx\Migration\AbstractMigration;

class Oc11018revert extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sql = <<<SQL
                
        BEGIN;
        SELECT fc_startsession();
        
        DROP VIEW empresa;
        DROP VIEW cadastro_portaria;
        DROP VIEW cadastro_pessoal_2008;
        DROP VIEW averbacoes;
        DROP VIEW proprietario_nome;
        DROP VIEW venal;
        DROP VIEW proprietario;

        UPDATE cgmalt
        SET z05_nome=SUBSTR(z05_nome, 0, 100)
        WHERE length(z05_nome) > 100;
        
        UPDATE cgm
        SET z01_nome=SUBSTR(z01_nome, 0, 40)
        WHERE length(z01_nome) > 40;


        ALTER TABLE cgm
        ALTER COLUMN z01_nome TYPE varchar(100);

        ALTER TABLE cgm
        ALTER COLUMN z01_nomecomple TYPE varchar(100);

        ALTER TABLE cgmalt
        ALTER COLUMN z05_nome TYPE varchar(100);


        ALTER TABLE cgmalt
        ALTER COLUMN z05_nomefanta TYPE varchar(100);

        UPDATE cgm
        SET z01_nomecomple=SUBSTR(z01_nomecomple, 0, 100)
        WHERE length(z01_nomecomple) > 100;

        UPDATE db_syscampo
        SET tamanho = 40
        WHERE codcam = 217;
        
        --CRIAR VIEW empresa
        
        CREATE OR REPLACE VIEW empresa AS 
         SELECT issbase.q02_inscr, issbase.q02_dtcada, issbase.q02_dtinic, 
            issbase.q02_dtbaix, tabativ.q07_ativ, tabativ.q07_perman, ativid.q03_descr, 
            tabativ.q07_datain, tabativ.q07_datafi, tabativ.q07_databx, 
            tabativ.q07_quant, tabativ.q07_tipbx, 
            to_ascii(cgm.z01_nome::text, 'LATIN2'::name) AS z01_nome, 
            cgm.z01_nomecomple, 
            to_ascii(cgm2.z01_nome::text, 'LATIN2'::name) AS q02_escrit, 
            cgm.z01_nomefanta, cgm.z01_cgccpf, cgm.z01_incest, 
                CASE
                    WHEN issruas.q02_inscr IS NULL THEN cgm.z01_ender::bpchar
                    ELSE ruas.j14_nome
                END AS z01_ender, 
                CASE
                    WHEN issruas.q02_inscr IS NULL THEN ''::character varying
                    ELSE ruastipo.j88_sigla
                END AS j14_tipo, 
                CASE
                    WHEN cgm.z01_nomecomple IS NULL OR btrim(cgm.z01_nomecomple::text) = ''::text THEN cgm.z01_nome
                    ELSE cgm.z01_nomecomple
                END AS razao, 
                CASE
                    WHEN issruas.q02_inscr IS NULL THEN cgm.z01_numero
                    ELSE issruas.q02_numero
                END AS z01_numero, 
                CASE
                    WHEN issruas.q02_inscr IS NULL THEN cgm.z01_compl
                    ELSE issruas.q02_compl
                END AS z01_compl, 
                CASE
                    WHEN issruas.q02_inscr IS NULL THEN cgm.z01_cxpostal::bpchar
                    ELSE issruas.q02_cxpost
                END AS z01_cxpostal, 
                CASE
                    WHEN issruas.z01_cep IS NULL THEN cgm.z01_cep
                    ELSE issruas.z01_cep
                END AS z01_cep, 
                CASE
                    WHEN issbairro.q13_inscr IS NULL THEN cgm.z01_bairro
                    ELSE bairro.j13_descr
                END AS z01_bairro, 
                CASE
                    WHEN issruas.q02_inscr IS NULL THEN cgm.z01_munic
                    ELSE ( SELECT db_config.munic
                       FROM db_config
                      WHERE db_config.prefeitura = true
                     LIMIT 1)
                END AS z01_munic, 
                CASE
                    WHEN issruas.q02_inscr IS NULL THEN cgm.z01_uf::bpchar
                    ELSE ( SELECT db_config.uf
                       FROM db_config
                      WHERE db_config.prefeitura = true
                     LIMIT 1)
                END AS z01_uf, 
                CASE
                    WHEN issruas.q02_inscr IS NULL THEN 0
                    ELSE issruas.j14_codigo
                END AS q02_lograd, 
                CASE
                    WHEN issbairro.q13_inscr IS NULL THEN 0
                    ELSE bairro.j13_codi
                END AS q02_bairro, 
            cgm.z01_telef, issbase.q02_numcgm, ativid.q03_atmemo, issbase.q02_memo, 
                CASE
                    WHEN ativprinc.q88_inscr IS NOT NULL THEN 'P'::text
                    ELSE 'S'::text
                END AS q88_tipo, 
            issbase.q02_inscmu, cgm.z01_ident
           FROM issbase
           JOIN cgm ON cgm.z01_numcgm = issbase.q02_numcgm
           LEFT JOIN issruas ON issruas.q02_inscr = issbase.q02_inscr
           LEFT JOIN ruas ON issruas.j14_codigo = ruas.j14_codigo
           LEFT JOIN ruastipo ON ruas.j14_tipo = ruastipo.j88_codigo
           LEFT JOIN issbairro ON issbairro.q13_inscr = issbase.q02_inscr
           LEFT JOIN bairro ON issbairro.q13_bairro = bairro.j13_codi
           LEFT JOIN issmatric ON issmatric.q05_inscr = issbase.q02_inscr
           LEFT JOIN iptubase ON iptubase.j01_matric = issmatric.q05_matric
           LEFT JOIN issprocesso ON issprocesso.q14_inscr = issbase.q02_inscr
           JOIN tabativ ON tabativ.q07_inscr = issbase.q02_inscr
           LEFT JOIN ativprinc ON ativprinc.q88_inscr = tabativ.q07_inscr AND ativprinc.q88_seq = tabativ.q07_seq
           JOIN ativid ON tabativ.q07_ativ = ativid.q03_ativ
           LEFT JOIN escrito ON escrito.q10_inscr = issbase.q02_inscr
           LEFT JOIN cgm cgm2 ON escrito.q10_numcgm = cgm2.z01_numcgm
          ORDER BY 
        CASE
            WHEN ativprinc.q88_inscr IS NOT NULL THEN 'P'::text
            ELSE 'S'::text
        END;
        
        ALTER TABLE empresa
          OWNER TO dbportal;
        GRANT ALL ON TABLE empresa TO dbportal;
        GRANT SELECT ON TABLE empresa TO dbseller;
        GRANT SELECT ON TABLE empresa TO plugin;
        
        
        --CRIAR VIEW cadastro_portaria
        
        CREATE OR REPLACE VIEW cadastro_portaria AS 
         SELECT rhpessoal.rh01_regist, cgm.z01_nome, portaria.h31_dtportaria, 
            portaria.h31_numero, portaria.h31_anousu, portaria.h31_dtlanc, 
            rhpessoal.rh01_numcgm, cgm.z01_ident, cgm.z01_ender, cgm.z01_numero, 
            cgm.z01_compl, cgm.z01_bairro, cgm.z01_cep, cgm.z01_munic, 
            rhpessoal.rh01_admiss, 
                CASE rhregime.rh30_regime
                    WHEN 1 THEN 'ESTATUTARIO'::text
                    WHEN 2 THEN 'CLT'::text
                    WHEN 3 THEN 'EXTRA QUADRO'::text
                    ELSE NULL::text
                END AS rh30_regime, 
            rhfuncao.rh37_descr, rhlocaltrab.rh55_descr, padroes.r02_descr, 
                CASE
                    WHEN substr(padroes.r02_descr::text, 1, 1) = 'P'::text THEN ''::text
                    ELSE btrim(substr(padroes.r02_descr::text, 3, 2))
                END AS r02_nivel, 
                CASE
                    WHEN substr(padroes.r02_descr::text, 1, 1) <> 'P'::text THEN ''::text
                    ELSE btrim(split_part(padroes.r02_descr::text, '-'::text, 1))
                END AS r02_padrao, 
                CASE
                    WHEN substr(padroes.r02_descr::text, 1, 1) <> 'P'::text THEN ''::text
                    ELSE btrim(split_part(padroes.r02_descr::text, '-'::text, 2))
                END AS r02_grau, 
                CASE
                    WHEN substr(padroes.r02_descr::text, 1, 1) = 'P'::text THEN ''::text
                    ELSE btrim(substr(padroes.r02_descr::text, 6, 1))
                END AS r02_classe, 
            tipoasse.h12_descr, btrim(portaria.h31_amparolegal) AS h31_amparolegal, 
            assenta.h16_histor, assenta.h16_hist2, portariaproced.h40_descr, 
            portariaenvolv.h42_descr, assenta.h16_dtconc, assenta.h16_quant, 
            assenta.h16_dtterm, portaria.h31_portariatipo, f.rh37_descr AS h07_cant, 
            rhpessoal.rh01_nasc, orcorgao.o40_descr, portaria.h31_dtinicio, 
            portariaassinatura.rh136_nome, portariaassinatura.rh136_cargo, 
            portariaassinatura.rh136_amparo
           FROM portaria
           JOIN portariaassenta ON portaria.h31_sequencial = portariaassenta.h33_portaria
           JOIN portariatipo ON portariatipo.h30_sequencial = portaria.h31_portariatipo
           JOIN portariaenvolv ON portariaenvolv.h42_sequencial = portariatipo.h30_portariaenvolv
           JOIN portariaproced ON portariaproced.h40_sequencial = portariatipo.h30_portariaproced
           JOIN assenta ON portariaassenta.h33_assenta = assenta.h16_codigo
           JOIN tipoasse ON assenta.h16_assent = tipoasse.h12_codigo
           JOIN rhpessoal ON assenta.h16_regist = rhpessoal.rh01_regist
           JOIN cgm ON rhpessoal.rh01_numcgm = cgm.z01_numcgm
           LEFT JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist AND rhpessoalmov.rh02_anousu = fc_anofolha(rhpessoalmov.rh02_instit) AND rhpessoalmov.rh02_mesusu = fc_mesfolha(rhpessoalmov.rh02_instit)
           JOIN rhfuncao ON rhfuncao.rh37_funcao = rhpessoal.rh01_funcao AND rhfuncao.rh37_instit = rhpessoalmov.rh02_instit
           LEFT JOIN rhlota ON rhpessoalmov.rh02_lota = rhlota.r70_codigo AND rhpessoalmov.rh02_instit = rhlota.r70_instit
           LEFT JOIN rhlotaexe ON rhpessoalmov.rh02_anousu = rhlotaexe.rh26_anousu AND rhlota.r70_codigo = rhlotaexe.rh26_codigo
           LEFT JOIN orcorgao ON orcorgao.o40_anousu = rhlotaexe.rh26_anousu AND orcorgao.o40_orgao = rhlotaexe.rh26_orgao
           LEFT JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
           LEFT JOIN rhpeslocaltrab ON rhpeslocaltrab.rh56_seqpes = rhpessoalmov.rh02_seqpes AND rhpeslocaltrab.rh56_princ = true
           LEFT JOIN rhlocaltrab ON rhlocaltrab.rh55_codigo = rhpeslocaltrab.rh56_localtrab
           LEFT JOIN rhpespadrao ON rhpespadrao.rh03_seqpes = rhpessoalmov.rh02_seqpes
           LEFT JOIN padroes ON padroes.r02_anousu = rhpessoalmov.rh02_anousu AND padroes.r02_mesusu = rhpessoalmov.rh02_mesusu AND padroes.r02_regime = rhregime.rh30_regime AND btrim(padroes.r02_codigo::text) = btrim(rhpespadrao.rh03_padrao::text) AND padroes.r02_instit = rhpessoalmov.rh02_instit
           LEFT JOIN admissao ON rhpessoal.rh01_regist = admissao.h07_regist
           LEFT JOIN rhfuncao f ON f.rh37_funcao = admissao.h07_cant::integer AND f.rh37_instit = rhpessoalmov.rh02_instit
           LEFT JOIN flegal ON flegal.h04_codigo = admissao.h07_fundam
           LEFT JOIN concur ON concur.h06_refer = admissao.h07_refe
           LEFT JOIN areas ON areas.h05_codigo = admissao.h07_area
           LEFT JOIN portariaassinatura ON portaria.h31_portariaassinatura = portariaassinatura.rh136_sequencial;
        
        ALTER TABLE cadastro_portaria
          OWNER TO dbportal;
        GRANT ALL ON TABLE cadastro_portaria TO dbportal;
        GRANT SELECT ON TABLE cadastro_portaria TO dbseller;
        GRANT SELECT ON TABLE cadastro_portaria TO plugin;
        
        -- CRIAR VIEW cadastro_pessoal_2008
        
        CREATE OR REPLACE VIEW cadastro_pessoal_2008 AS 
         SELECT rhpessoalmov.rh02_instit, rhpessoalmov.rh02_anousu, 
            rhpessoalmov.rh02_mesusu, rhpessoalmov.rh02_regist, 
            rhpessoalmov.rh02_portadormolestia, rhpessoalmov.rh02_deficientefisico, 
            rhpessoal.rh01_regist, rhpessoalmov.rh02_hrssem, rhpessoalmov.rh02_hrsmen, 
            padroes.r02_anousu, padroes.r02_mesusu, padroes.r02_regime, 
            padroes.r02_codigo, padroes.r02_descr, padroes.r02_valor, 
            padroes.r02_hrssem, padroes.r02_hrsmen, padroes.r02_tipo, padroes.r02_form, 
            padroes.r02_minimo, padroes.r02_instit, cgm.z01_nome, rhpessoal.rh01_admiss, 
            rhpesrescisao.rh05_recis, rhpessoal.rh01_sexo, rhpessoal.rh01_nasc, 
            rhpessoalmov.rh02_tbprev, rhlota.r70_estrut, rhlota.r70_descr, 
            rhpessoal.rh01_funcao, btrim(rhfuncao.rh37_descr::text) AS rh37_descr, 
            rhinstrucao.rh21_descr, rhestcivil.rh08_descr, rhipe.rh14_matipe, 
            rhpesdoc.rh16_titele, rhpesdoc.rh16_zonael, rhpesdoc.rh16_secaoe, 
            rhpesdoc.rh16_reserv, rhpesdoc.rh16_catres, rhpesdoc.rh16_ctps_n, 
            rhpesdoc.rh16_ctps_s, rhpesdoc.rh16_ctps_d, rhpesdoc.rh16_ctps_uf, 
            rhpesdoc.rh16_pis, cgm.z01_cgccpf, cgm.z01_ident, cgm.z01_telef, 
            cgm.z01_ender, cgm.z01_compl, cgm.z01_numero, cgm.z01_munic, cgm.z01_bairro, 
            cgm.z01_cep, cgm.z01_numcgm, rhpesdoc.rh16_carth_n, rhpesdoc.r16_carth_cat, 
            rhpesdoc.rh16_carth_val, rhpespadrao.rh03_padrao, rhregime.rh30_descr, 
            rhregime.rh30_regime, rhregime.rh30_vinculo, rhpesbanco.rh44_codban, 
            rhpesbanco.rh44_agencia, rhpesbanco.rh44_dvagencia, rhpesbanco.rh44_conta, 
            rhpesbanco.rh44_dvconta, rhlocaltrab.rh55_estrut, rhlocaltrab.rh55_descr, 
            rhpessoal.rh01_trienio, rhpessoal.rh01_progres, rhraca.rh18_descr, 
            f.rh37_descr AS h07_cant, admissao.h07_regist, admissao.h07_tipadm, 
            admissao.h07_dato, admissao.h07_dhist, admissao.h07_ddem, admissao.h07_icon, 
            admissao.h07_ires, admissao.h07_class, admissao.h07_refe, admissao.h07_area, 
            admissao.h07_nrato, admissao.h07_nrfich, admissao.h07_impofi, 
            admissao.h07_dpubl, admissao.h07_fundam, admissao.h07_defet, 
            admissao.h07_tempor, admissao.h07_termin, admissao.h07_justif, 
            flegal.h04_descr, areas.h05_descr, concur.h06_refer, concur.h06_eaber, 
            concur.h06_daber, concur.h06_ehomo, concur.h06_dhomo, concur.h06_concur, 
            concur.h06_dvalid, concur.h06_dprorr, concur.h06_dpubl, concur.h06_nrproc, 
            ( SELECT 
                        CASE
                            WHEN rhpessoalmov.rh02_tbprev = 0 THEN 'SEM PREVIDENCIA'::bpchar
                            ELSE inssirf.r33_nome
                        END AS r33_nome
                   FROM inssirf
                  WHERE inssirf.r33_codtab = (rhpessoalmov.rh02_tbprev + 2) AND inssirf.r33_anousu = rhpessoalmov.rh02_anousu AND rhpessoalmov.rh02_mesusu = inssirf.r33_mesusu AND rhpessoalmov.rh02_instit = inssirf.r33_instit
                 LIMIT 1) AS r33_nome
           FROM rhpessoal
           JOIN cgm ON rhpessoal.rh01_numcgm = cgm.z01_numcgm
           JOIN rhpessoalmov ON rhpessoalmov.rh02_anousu = fc_anofolha(rhpessoalmov.rh02_instit) AND rhpessoalmov.rh02_mesusu = fc_mesfolha(rhpessoalmov.rh02_instit) AND rhpessoalmov.rh02_regist = rhpessoal.rh01_regist
           LEFT JOIN rhpesrescisao ON rhpesrescisao.rh05_seqpes = rhpessoalmov.rh02_seqpes
           JOIN rhlota ON rhlota.r70_codigo = rhpessoalmov.rh02_lota AND rhlota.r70_instit = rhpessoalmov.rh02_instit
           JOIN rhfuncao ON rhpessoal.rh01_funcao = rhfuncao.rh37_funcao AND rhfuncao.rh37_instit = rhpessoalmov.rh02_instit
           JOIN rhinstrucao ON rhpessoal.rh01_instru = rhinstrucao.rh21_instru
           JOIN rhestcivil ON rhpessoal.rh01_estciv = rhestcivil.rh08_estciv
           LEFT JOIN rhiperegist ON rhiperegist.rh62_regist = rhpessoal.rh01_regist
           LEFT JOIN rhipe ON rhipe.rh14_sequencia = rhiperegist.rh62_sequencia AND rhipe.rh14_instit = rhpessoalmov.rh02_instit
           LEFT JOIN rhpeslocaltrab ON rhpeslocaltrab.rh56_seqpes = rhpessoalmov.rh02_seqpes AND rhpeslocaltrab.rh56_princ = true
           LEFT JOIN rhlocaltrab ON rhpeslocaltrab.rh56_localtrab = rhlocaltrab.rh55_codigo AND rhlocaltrab.rh55_instit = rhpessoalmov.rh02_instit
           LEFT JOIN rhpesdoc ON rhpesdoc.rh16_regist = rhpessoal.rh01_regist
           LEFT JOIN rhpespadrao ON rhpessoalmov.rh02_seqpes = rhpespadrao.rh03_seqpes
           LEFT JOIN padroes ON padroes.r02_anousu = rhpespadrao.rh03_anousu AND padroes.r02_mesusu = rhpespadrao.rh03_mesusu AND padroes.r02_regime = rhpespadrao.rh03_regime AND padroes.r02_codigo = rhpespadrao.rh03_padrao AND padroes.r02_instit = rhpessoalmov.rh02_instit
           JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg AND rhregime.rh30_instit = rhpessoalmov.rh02_instit
           LEFT JOIN rhpesbanco ON rhpesbanco.rh44_seqpes = rhpessoalmov.rh02_seqpes
           LEFT JOIN admissao ON rhpessoal.rh01_regist = admissao.h07_regist
           LEFT JOIN rhfuncao f ON f.rh37_funcao = admissao.h07_cant::integer AND f.rh37_instit = rhpessoalmov.rh02_instit
           LEFT JOIN flegal ON flegal.h04_codigo = admissao.h07_fundam
           LEFT JOIN concur ON concur.h06_refer = admissao.h07_refe
           LEFT JOIN areas ON areas.h05_codigo = admissao.h07_area
           LEFT JOIN rhraca ON rhpessoal.rh01_raca = rhraca.rh18_raca
          ORDER BY cgm.z01_nome;
        
        ALTER TABLE cadastro_pessoal_2008
          OWNER TO dbportal;
        GRANT ALL ON TABLE cadastro_pessoal_2008 TO dbportal;
        GRANT SELECT ON TABLE cadastro_pessoal_2008 TO dbseller;
        GRANT SELECT ON TABLE cadastro_pessoal_2008 TO plugin;
        
        --CRIAR VIEW proprietario
        
        CREATE OR REPLACE VIEW proprietario AS 
         SELECT x.z01_numcgm, x.j01_matric, x.z01_cgccpf, 
                CASE
                    WHEN x.totpropri > 1 THEN 
                    CASE
                        WHEN x.totpropri = 2 THEN rtrim(x.proprietario::text) || ' E OUTRO'::text
                        ELSE rtrim(x.proprietario::text) || ' E OUTROS'::text
                    END::character varying
                    ELSE x.proprietario
                END AS proprietario, 
            btrim(substr(
                CASE
                    WHEN x.totpromi > 1 THEN 
                    CASE
                        WHEN x.totpropri = 2 THEN rtrim(x.z01_nome) || ' E OUTRO'::text
                        ELSE rtrim(x.z01_nome) || ' E OUTROS'::text
                    END
                    ELSE x.z01_nome
                END, 1, 40))::character varying AS z01_nome, 
            btrim(
                CASE
                    WHEN x.totpromi > 1 THEN 
                    CASE
                        WHEN x.totpropri = 2 THEN rtrim(x.z01_nomecompleto) || ' E OUTRO'::text
                        ELSE rtrim(x.z01_nomecompleto) || ' E OUTROS'::text
                    END
                    ELSE x.z01_nomecompleto
                END)::character varying AS z01_nomecompleto, 
                CASE
                    WHEN length(btrim(x.z01_ender::text)) = 0 AND length(btrim(x.z01_cxpostal::text)) > 0 AND to_number(x.z01_cxpostal::text, '999999'::text) > 0::numeric THEN ('CAIXA POSTAL: '::text || x.z01_cxpostal::text)::character varying
                    ELSE x.z01_ender::character varying(80)
                END AS z01_ender, 
            x.z01_munic, x.z01_bairro, x.z01_cep, x.z01_uf, x.z01_numero, x.z01_compl, 
            x.codpri, x.nomepri::character varying(40) AS nomepri, 
            x.tipopri::character varying(40) AS tipopri, x.j39_numero, x.j39_compl, 
            x.j34_setor, x.j34_quadra, x.j34_lote, x.j34_zona, x.j34_bairro, 
            x.j40_refant, x.j01_idbql, x.j14_codigo, x.j14_nome, x.j14_tipo, x.j13_codi, 
            x.j13_descr, x.j01_baixa, x.j34_area, x.j34_areal, x.j44_numcgm, 
            x.j41_numcgm, x.j43_matric, 
                CASE
                    WHEN x.j43_munic IS NULL THEN x.z01_munic
                    ELSE x.j43_munic
                END AS j43_munic, 
                CASE
                    WHEN x.j43_ender IS NULL THEN x.z01_ender
                    ELSE x.j43_ender
                END AS j43_ender, 
                CASE
                    WHEN x.j43_cep IS NULL THEN x.z01_cep
                    ELSE x.j43_cep
                END AS j43_cep, 
                CASE
                    WHEN x.j43_uf IS NULL THEN x.z01_uf
                    ELSE x.j43_uf
                END AS j43_uf, 
            x.j43_dest, 
                CASE
                    WHEN x.j43_numimo IS NULL THEN x.z01_numero
                    ELSE x.j43_numimo
                END AS j43_numimo, 
                CASE
                    WHEN x.j43_cxpost IS NULL THEN x.z01_cxpostal::text
                    ELSE to_char(x.j43_cxpost, '99999999999999999999'::text)
                END AS j43_cxpost, 
                CASE
                    WHEN x.j43_comple IS NULL THEN x.z01_compl
                    ELSE x.j43_comple
                END AS j43_comple, 
            x.j01_tipoimp::character varying(20) AS j01_tipoimp, x.j01_codave, 
            x.j37_zona, x.z01_cgmpri, x.j39_pavim, x.j05_codigoproprio, x.j06_setorloc, 
            x.j06_quadraloc, x.j06_lote, x.j05_descr, x.pql_localizacao, 
            cgmpropri.z01_cgccpf AS z01_cgccpfpropri, 
            cgmpropri.z01_nomecomple AS z01_nomecomplepri, 
            cgmpropri.z01_ender AS z01_enderpri, cgmpropri.z01_munic AS z01_municpri, 
            cgmpropri.z01_bairro AS z01_bairropri, cgmpropri.z01_cep AS z01_ceppri, 
            cgmpropri.z01_uf AS z01_ufpri, cgmpropri.z01_numero AS z01_numeropri, 
            cgmpropri.z01_compl AS z01_complpri
           FROM ( SELECT iptubase.j01_matric, cgm.z01_numcgm, 
                        CASE
                            WHEN promite.z01_numcgm IS NULL THEN cgm.z01_cgccpf
                            ELSE cgmpromite.z01_cgccpf
                        END AS z01_cgccpf, 
                        CASE
                            WHEN promite.z01_nome IS NULL THEN cgm.z01_nome::text
                            ELSE (( SELECT COALESCE(btrim(cfiptu.j18_textoprom::text) || ' '::text, ''::text) AS "coalesce"
                               FROM cfiptu
                              ORDER BY cfiptu.j18_anousu DESC
                             LIMIT 1)) || substr(promite.z01_nome, 1, 29)::text
                        END AS z01_nome, 
                        CASE
                            WHEN promite.z01_nome IS NULL THEN cgm.z01_nome::text
                            ELSE (( SELECT COALESCE(btrim(cfiptu.j18_textoprom::text) || ' '::text, ''::text) AS "coalesce"
                               FROM cfiptu
                              ORDER BY cfiptu.j18_anousu DESC
                             LIMIT 1)) || promite.z01_nome::text
                        END AS z01_nomecompleto, 
                        CASE
                            WHEN promite.z01_numcgm IS NULL THEN cgm.z01_numcgm
                            ELSE promite.z01_numcgm
                        END AS z01_cgmpri, 
                    cgm.z01_nome AS proprietario, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_ender
                                ELSE promite.z01_ender
                            END
                            ELSE iptuender.j43_ender
                        END AS z01_ender, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_munic
                                ELSE promite.z01_munic
                            END
                            ELSE iptuender.j43_munic
                        END AS z01_munic, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_bairro
                                ELSE promite.z01_bairro
                            END
                            ELSE iptuender.j43_bairro
                        END AS z01_bairro, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_cep
                                ELSE promite.z01_cep
                            END::bpchar
                            ELSE iptuender.j43_cep
                        END AS z01_cep, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_uf
                                ELSE promite.z01_uf
                            END::bpchar
                            ELSE iptuender.j43_uf
                        END AS z01_uf, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_numero
                                ELSE promite.z01_numero
                            END
                            ELSE iptuender.j43_numimo
                        END AS z01_numero, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_compl
                                ELSE promite.z01_compl
                            END::bpchar
                            ELSE iptuender.j43_comple
                        END AS z01_compl, 
                        CASE
                            WHEN iptuender.j43_cxpost IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_cxpostal
                                ELSE promite.z01_cxpostal
                            END
                            ELSE iptuender.j43_cxpost::character varying(20)
                        END AS z01_cxpostal, 
                        CASE
                            WHEN rr.j14_codigo IS NULL THEN r.j14_codigo
                            ELSE rr.j14_codigo
                        END AS codpri, 
                        CASE
                            WHEN rr.j14_nome IS NULL THEN r.j14_nome
                            ELSE rr.j14_nome
                        END AS nomepri, 
                        CASE
                            WHEN rr.j14_tipo IS NULL THEN rt.j88_sigla
                            ELSE rrt.j88_sigla
                        END AS tipopri, 
                        CASE
                            WHEN length(btrim(testadanumero.j15_numero::character varying::text)) > 0 AND iptuconstr.j39_matric IS NULL THEN testadanumero.j15_numero
                            ELSE iptuconstr.j39_numero
                        END AS j39_numero, 
                        CASE
                            WHEN length(btrim(testadanumero.j15_compl::text)) > 0 AND iptuconstr.j39_matric IS NULL THEN testadanumero.j15_compl
                            ELSE iptuconstr.j39_compl
                        END AS j39_compl, 
                    lote.j34_setor, lote.j34_quadra, lote.j34_lote, lote.j34_zona, 
                    lote.j34_bairro, iptuant.j40_refant, iptubase.j01_idbql, 
                    r.j14_codigo, r.j14_nome, rt.j88_sigla::text AS j14_tipo, 
                    bairro.j13_codi, bairro.j13_descr, iptubase.j01_baixa, 
                    lote.j34_area, lote.j34_areal, imobil.j44_numcgm, 
                    promitente.j41_numcgm, iptuender.j43_matric, iptuender.j43_dest, 
                    iptuender.j43_ender, iptuender.j43_numimo, iptuender.j43_comple, 
                    iptuender.j43_bairro, iptuender.j43_munic, iptuender.j43_uf, 
                    iptuender.j43_cep, iptuender.j43_cxpost, 
                        CASE
                            WHEN iptuconstr.j39_idcons IS NULL THEN 'Territorial'::text
                            ELSE 'Predial'::text
                        END AS j01_tipoimp, 
                    iptubase.j01_codave, face.j37_zona, iptuconstr.j39_pavim, 
                    ( SELECT count(propri.j42_matric) AS count
                           FROM propri
                          WHERE propri.j42_matric = iptubase.j01_matric) AS totpropri, 
                    ( SELECT count(promitente.j41_matric) AS count
                           FROM promitente
                          WHERE promitente.j41_matric = iptubase.j01_matric) AS totpromi, 
                    setorloc.j05_codigoproprio, loteloc.j06_setorloc, 
                    loteloc.j06_quadraloc, loteloc.j06_lote, setorloc.j05_descr, 
                    (((((setorloc.j05_codigoproprio::text || '-'::text) || setorloc.j05_descr::text) || '/'::text) || loteloc.j06_quadraloc::text) || '/'::text) || loteloc.j06_lote::text AS pql_localizacao
                   FROM iptubase
              JOIN cgm ON cgm.z01_numcgm = iptubase.j01_numcgm
           LEFT JOIN iptuconstr ON iptuconstr.j39_matric = iptubase.j01_matric AND iptuconstr.j39_idprinc IS TRUE AND iptuconstr.j39_dtdemo IS NULL
           LEFT JOIN ruas rr ON rr.j14_codigo = iptuconstr.j39_codigo
           LEFT JOIN ruastipo rrt ON rrt.j88_codigo = rr.j14_tipo
           LEFT JOIN iptuant ON iptuant.j40_matric = iptubase.j01_matric
           JOIN lote ON iptubase.j01_idbql = lote.j34_idbql
           LEFT JOIN testpri ON testpri.j49_idbql = lote.j34_idbql
           LEFT JOIN testadanumero ON testadanumero.j15_idbql = testpri.j49_idbql AND testadanumero.j15_face = testpri.j49_face
           LEFT JOIN face ON face.j37_face = testpri.j49_face
           LEFT JOIN ruas r ON r.j14_codigo = testpri.j49_codigo
           LEFT JOIN ruastipo rt ON rt.j88_codigo = r.j14_tipo
           LEFT JOIN imobil ON iptubase.j01_matric = imobil.j44_matric
           LEFT JOIN promitente ON iptubase.j01_matric = promitente.j41_matric AND promitente.j41_tipopro IS TRUE
           LEFT JOIN cgm cgmpromite ON promitente.j41_numcgm = cgmpromite.z01_numcgm
           LEFT JOIN cgm promite ON promite.z01_numcgm = promitente.j41_numcgm
           LEFT JOIN bairro ON bairro.j13_codi = lote.j34_bairro
           LEFT JOIN iptuender ON iptubase.j01_matric = iptuender.j43_matric
           LEFT JOIN loteloc ON loteloc.j06_idbql = iptubase.j01_idbql
           LEFT JOIN setorloc ON setorloc.j05_codigo = loteloc.j06_setorloc
           LEFT JOIN setor ON setor.j30_codi = lote.j34_setor) x
           LEFT JOIN cgm cgmpropri ON x.z01_numcgm = cgmpropri.z01_numcgm;
        
        ALTER TABLE proprietario
          OWNER TO dbportal;
        GRANT ALL ON TABLE proprietario TO dbportal;
        GRANT SELECT ON TABLE proprietario TO dbseller;
        GRANT SELECT ON TABLE proprietario TO plugin;
        
        
        -- CRIAR VIEW averbacoes
        
        CREATE OR REPLACE VIEW averbacoes AS 
         SELECT protprocesso.p58_codproc, protprocesso.p58_dtproc, averbacao.j75_codigo, 
            averbacao.j75_matric, averbacao.j75_data, averbacao.j75_obs, 
            averbacao.j75_tipo, averbacao.j75_dttipo, averbacao.j75_situacao, 
            averbacao.j75_regra, proprietario.j40_refant, setorloc.j05_codigoproprio, 
            loteloc.j06_setorloc, loteloc.j06_quadraloc, loteloc.j06_lote, 
            loteam.j34_descr, proprietario.codpri, proprietario.nomepri, 
            proprietario.z01_cgccpf, proprietario.tipopri, proprietario.j39_numero, 
            proprietario.j39_compl, proprietario.j34_area, proprietario.j34_setor, 
            proprietario.j34_quadra, proprietario.j34_lote, proprietario.j01_baixa, 
            iptuconstr.j39_area, 
            ( SELECT array_to_string(array_accum((cgm.z01_numcgm || ' - '::text) || cgm.z01_nome::text), ','::text) AS array_to_string
                   FROM cgm
              JOIN averbacgm ON cgm.z01_numcgm = averbacgm.j76_numcgm
             WHERE averbacao.j75_codigo = averbacgm.j76_averbacao) AS z01_nomeadq, 
            ( SELECT array_to_string(array_accum((cgm.z01_numcgm || ' - '::text) || cgm.z01_nome::text), ','::text) AS array_to_string
                   FROM cgm
              JOIN averbacgmold ON cgm.z01_numcgm = averbacgmold.j79_numcgm
             WHERE averbacao.j75_codigo = averbacgmold.j79_averbacao) AS z01_nometrans, 
            db_usuarios.login, db_usuarios.nome, rhpessoal.rh01_regist, 
            rhfuncao.rh37_descr
           FROM averbacao
           LEFT JOIN averbaprocesso ON averbacao.j75_codigo = averbaprocesso.j77_averbacao
           LEFT JOIN protprocesso ON protprocesso.p58_codproc = averbaprocesso.j77_codproc
           JOIN iptubase ON averbacao.j75_matric = iptubase.j01_matric
           LEFT JOIN loteloc ON iptubase.j01_idbql = loteloc.j06_idbql
           LEFT JOIN setorloc ON loteloc.j06_setorloc = setorloc.j05_codigo
           JOIN proprietario ON iptubase.j01_matric = proprietario.j01_matric
           LEFT JOIN iptuconstr ON iptubase.j01_matric = iptuconstr.j39_matric
           LEFT JOIN loteloteam ON proprietario.j01_idbql = loteloteam.j34_idbql
           LEFT JOIN loteam ON loteloteam.j34_loteam = loteam.j34_loteam
           LEFT JOIN db_usuarios ON db_usuarios.id_usuario = fc_getsession('db_id_usuario'::text)::integer
           LEFT JOIN db_usuacgm ON db_usuacgm.id_usuario = db_usuarios.id_usuario
           LEFT JOIN rhpessoal ON rhpessoal.rh01_numcgm = db_usuacgm.cgmlogin
           LEFT JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist AND rhpessoalmov.rh02_anousu = fc_anofolha(fc_getsession('db_instit'::text)::integer) AND rhpessoalmov.rh02_mesusu = fc_mesfolha(fc_getsession('db_instit'::text)::integer)
           LEFT JOIN rhpesrescisao ON rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes
           LEFT JOIN rhfuncao ON rhpessoalmov.rh02_funcao = rhfuncao.rh37_funcao AND rhpessoalmov.rh02_instit = rhfuncao.rh37_instit
          WHERE db_usuarios.usuarioativo::text = 1::text AND db_usuarios.usuext = 0 AND rhpessoalmov.rh02_instit::text = fc_getsession('db_instit'::text) AND rhpesrescisao.rh05_recis IS NULL;
        
        ALTER TABLE averbacoes
          OWNER TO dbportal;
        GRANT ALL ON TABLE averbacoes TO dbportal;
        GRANT SELECT ON TABLE averbacoes TO dbseller;
        GRANT SELECT ON TABLE averbacoes TO plugin;
        
        -- CRIAR VIEW proprietario_nome
        
        CREATE OR REPLACE VIEW proprietario_nome AS 
         SELECT x.z01_numcgm, x.j01_matric, x.z01_cgccpf, 
                CASE
                    WHEN x.totpropri > 1 THEN 
                    CASE
                        WHEN x.totpropri = 2 THEN rtrim(x.proprietario::text) || ' e outro'::text
                        ELSE rtrim(x.proprietario::text) || ' e outros'::text
                    END::character varying
                    ELSE x.proprietario
                END AS proprietario, 
            substr(
                CASE
                    WHEN x.totpromi > 1 THEN 
                    CASE
                        WHEN x.totpromi = 2 THEN rtrim(x.z01_nome) || ' e outro'::text
                        ELSE rtrim(x.z01_nome) || ' e outros'::text
                    END
                    ELSE x.z01_nome
                END, 1, 40)::character varying(40) AS z01_nome, 
            x.z01_ender::character varying(80) AS z01_ender, x.z01_munic, x.z01_bairro, 
            x.z01_cep, x.z01_uf, x.z01_numero, x.z01_compl, x.j01_idbql, x.z01_cgmpri, 
            x.j01_baixa
           FROM ( SELECT iptubase.j01_matric, cgm.z01_numcgm, cgm.z01_cgccpf, 
                    iptubase.j01_idbql, iptubase.j01_baixa, 
                        CASE
                            WHEN promite.z01_nome IS NULL OR fc_regrasconfig(1) = 1 THEN cgm.z01_nome::text
                            ELSE (( SELECT COALESCE(btrim(cfiptu.j18_textoprom::text) || ' '::text, ''::text) AS "coalesce"
                               FROM cfiptu
                              ORDER BY cfiptu.j18_anousu DESC
                             LIMIT 1)) || substr(promite.z01_nome, 1, 29)::text
                        END AS z01_nome, 
                        CASE
                            WHEN promite.z01_numcgm IS NULL OR fc_regrasconfig(1) = 1 THEN cgm.z01_numcgm
                            ELSE promite.z01_numcgm
                        END AS z01_cgmpri, 
                    cgm.z01_nome AS proprietario, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_ender
                                ELSE promite.z01_ender
                            END
                            ELSE iptuender.j43_ender
                        END AS z01_ender, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_munic
                                ELSE promite.z01_munic
                            END
                            ELSE iptuender.j43_munic
                        END AS z01_munic, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_bairro
                                ELSE promite.z01_bairro
                            END
                            ELSE iptuender.j43_bairro
                        END AS z01_bairro, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_cep
                                ELSE promite.z01_cep
                            END::bpchar
                            ELSE iptuender.j43_cep
                        END AS z01_cep, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_uf
                                ELSE promite.z01_uf
                            END::bpchar
                            ELSE iptuender.j43_uf
                        END AS z01_uf, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_numero
                                ELSE promite.z01_numero
                            END
                            ELSE iptuender.j43_numimo
                        END AS z01_numero, 
                        CASE
                            WHEN iptuender.j43_ender IS NULL THEN 
                            CASE
                                WHEN promitente.j41_numcgm IS NULL THEN cgm.z01_compl
                                ELSE promite.z01_compl
                            END::bpchar
                            ELSE iptuender.j43_comple
                        END AS z01_compl, 
                    ( SELECT count(propri.j42_matric) AS count
                           FROM propri
                          WHERE propri.j42_matric = iptubase.j01_matric) AS totpropri, 
                    ( SELECT count(promitente.j41_matric) AS count
                           FROM promitente
                          WHERE promitente.j41_matric = iptubase.j01_matric) AS totpromi
                   FROM iptubase
              JOIN cgm ON cgm.z01_numcgm = iptubase.j01_numcgm
           LEFT JOIN promitente ON iptubase.j01_matric = promitente.j41_matric AND promitente.j41_tipopro IS TRUE
           LEFT JOIN cgm promite ON promite.z01_numcgm = promitente.j41_numcgm
           LEFT JOIN iptuender ON iptubase.j01_matric = iptuender.j43_matric) x;
        
        ALTER TABLE proprietario_nome
          OWNER TO dbportal;
        GRANT ALL ON TABLE proprietario_nome TO dbportal;
        GRANT SELECT ON TABLE proprietario_nome TO dbseller;
        GRANT SELECT ON TABLE proprietario_nome TO plugin;
        
        --CRIAR VIEW venal
        
        CREATE OR REPLACE VIEW venal AS 
         SELECT COALESCE(( SELECT sum(iptucale.j22_valor) AS sum
                   FROM iptucale
                  WHERE iptucale.j22_anousu = iptucalc.j23_anousu AND iptucale.j22_matric = iptucalc.j23_matric), 0::double precision) AS j22_valor, 
            'R$ '::text || translate(to_char(iptucalc.j23_vlrter + COALESCE(( SELECT sum(iptucale.j22_valor) AS sum
                   FROM iptucale
                  WHERE iptucale.j22_anousu = iptucalc.j23_anousu AND iptucale.j22_matric = iptucalc.j23_matric), 0::double precision), '999,999,999,990.99'::text), ',.'::text, '.,'::text) AS j23_venaltotal, 
            proprietario.j40_refant, loteloc.j06_setorloc, loteloc.j06_quadraloc, 
            loteloc.j06_lote, loteam.j34_descr, proprietario.j01_matric, 
            proprietario.codpri, proprietario.nomepri, proprietario.z01_cgccpf, 
            proprietario.tipopri, proprietario.j39_numero, proprietario.j39_compl, 
            proprietario.j34_area, iptucalc.j23_anousu, iptucalc.j23_matric, 
            iptucalc.j23_testad, iptucalc.j23_arealo, iptucalc.j23_areafr, 
            iptucalc.j23_areaed, iptucalc.j23_m2terr, iptucalc.j23_vlrter, 
            iptucalc.j23_aliq, iptucalc.j23_vlrisen, iptucalc.j23_tipoim, 
            iptucalc.j23_manual, iptucalc.j23_tipocalculo, 
            to_date(fc_getsession('db_datausu'::text), 'YYYY-MM-DD'::text) AS data_sessao, 
            fc_dataextenso(to_date(fc_getsession('db_datausu'::text), 'YYYY-MM-DD'::text)) AS data_sessao_extenso, 
            db_usuarios.login, db_usuarios.nome, rhpessoal.rh01_regist, 
            rhfuncao.rh37_descr
           FROM iptucalc
           JOIN proprietario ON iptucalc.j23_matric = proprietario.j01_matric
           LEFT JOIN loteloc ON proprietario.j01_idbql = loteloc.j06_idbql
           LEFT JOIN loteloteam ON proprietario.j01_idbql = loteloteam.j34_idbql
           LEFT JOIN loteam ON loteloteam.j34_loteam = loteam.j34_loteam
           LEFT JOIN db_usuarios ON db_usuarios.id_usuario = fc_getsession('db_id_usuario'::text)::integer
           LEFT JOIN db_usuacgm ON db_usuacgm.id_usuario = db_usuarios.id_usuario
           LEFT JOIN rhpessoal ON rhpessoal.rh01_numcgm = db_usuacgm.cgmlogin
           LEFT JOIN rhpessoalmov ON rhpessoalmov.rh02_regist = rhpessoal.rh01_regist AND rhpessoalmov.rh02_anousu = fc_anofolha(fc_getsession('db_instit'::text)::integer) AND rhpessoalmov.rh02_mesusu = fc_mesfolha(fc_getsession('db_instit'::text)::integer)
           LEFT JOIN rhpesrescisao ON rhpessoalmov.rh02_seqpes = rhpesrescisao.rh05_seqpes
           LEFT JOIN rhfuncao ON rhpessoalmov.rh02_funcao = rhfuncao.rh37_funcao AND rhpessoalmov.rh02_instit = rhfuncao.rh37_instit
          WHERE rhpesrescisao.rh05_seqpes IS NULL AND rhpessoalmov.rh02_instit = fc_getsession('db_instit'::text)::integer AND db_usuarios.usuarioativo = 1 AND db_usuarios.usuext = 0 AND iptucalc.j23_anousu = fc_getsession('db_anousu'::text)::integer;
        
        ALTER TABLE venal
          OWNER TO dbportal;
        GRANT ALL ON TABLE venal TO dbportal;
        GRANT SELECT ON TABLE venal TO dbseller;
        GRANT SELECT ON TABLE venal TO plugin;
        
        COMMIT;

SQL;
        $this->execute($sql);
    }
}
