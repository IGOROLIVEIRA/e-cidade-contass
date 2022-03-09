<?php

use Phinx\Migration\AbstractMigration;

class Oc16926 extends AbstractMigration
{

    public function up()
    {
        $sql = " 
        {$this->getDropViews()}

        ALTER TABLE rhfuncao ALTER COLUMN rh37_descr TYPE varchar(100);
        UPDATE db_syscampo SET tamanho = 100 WHERE nomecam = 'rh37_descr';

        {$this->getCreateViews()}
        ";
        $this->execute($sql);
    }

    public function down() 
    {
        $sql = " 
        {$this->getDropViews()}

        ALTER TABLE rhfuncao ALTER COLUMN rh37_descr TYPE varchar(30);
        UPDATE db_syscampo SET tamanho = 30 WHERE nomecam = 'rh37_descr';

        {$this->getCreateViews()}
        ";
        $this->execute($sql);
    }

    private function getDropViews()
    {
        return "DROP VIEW averbacoes;
        DROP VIEW cadastro_pessoal_2008;
        DROP VIEW cadastro_portaria;
        DROP VIEW venal;
        ";
    }

    private function getCreateViews()
    {
        return "CREATE OR REPLACE VIEW averbacoes AS 
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


        CREATE VIEW cadastro_pessoal_2008 AS 
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

        CREATE VIEW cadastro_portaria AS
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

        CREATE VIEW venal AS 
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
        ";
    }
}
