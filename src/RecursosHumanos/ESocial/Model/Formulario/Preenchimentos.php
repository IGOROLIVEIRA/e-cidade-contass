<?php

namespace ECidade\RecursosHumanos\ESocial\Model\Formulario;

use ECidade\RecursosHumanos\ESocial\Model\Formulario\DadosResposta;

/**
 * Classe respons?vel por buscar os dados de preenchimento dos formul?rios
 * @package ECidade\RecursosHumanos\ESocial\Model\Formulario
 */
class Preenchimentos
{
    /**
     * Respons?vel pelo preenchimento do formul?rio
     *
     * @var mixed
     */
    private $responsavelPreenchimento;

    /**
     * Informa o respons?vel pelo preenchimento. Se n?o indormado, busca de todos
     *
     * @param mixed $responsavel
     */
    public function setReponsavelPeloPreenchimento($responsavel)
    {
        $this->responsavelPreenchimento = $responsavel;
    }

    /**
     * Busca os preenchimentos dos empregadores
     *
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarUltimoPreenchimentoEmpregador($codigoFormulario)
    {
        $where = array(" db101_sequencial = {$codigoFormulario} ");
        if (!empty($this->responsavelPreenchimento)) {
            $where[] = "eso03_cgm = {$this->responsavelPreenchimento}";
        }

        $where = implode(' and ', $where);

        $group = " group by eso03_cgm";
        $campos = 'eso03_cgm as cgm, max(db107_sequencial) as preenchimento, ';
        $campos .= '(SELECT z01_cgccpf from cgm where z01_numcgm = eso03_cgm) as inscricao_empregador ';
        $dao = new \cl_avaliacaogruporespostacgm;
        $sql = $dao->sql_avaliacao_preenchida(null, $campos, null, $where . $group);
        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos dos formul?rios dos empregadores.");
        }

        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * Busca os preenchimentos dos servidores
     *
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarUltimoPreenchimentoServidor($codigoFormulario)
    {
        $where = " db101_sequencial = {$codigoFormulario} ";
        $group = " group by eso02_rhpessoal";
        $campos = 'eso02_rhpessoal as matricula, max(db107_sequencial) as preenchimento';
        $dao = new \cl_avaliacaogruporespostarhpessoal;
        $sql = $dao->sql_avaliacao_preenchida(null, $campos, null, $where . $group);
        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos dos formul?rios dos servidores xx. $sql");
        }

        /**
         * Para pegar o empregador, vai ter que ver a lota??o do servidor na compet?ncia.
         */
        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * Busca o preenchimento dos formul?rios gen?ricos.
     * Aqueles que possuem uma carga de dados e um campo pk (Uma chave ?nica )
     *
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarUltimoPreenchimento($codigoFormulario)
    {
        $where = " db101_sequencial = {$codigoFormulario} ";
        $campos = 'distinct db107_sequencial as preenchimento, ';
        $campos .= '(SELECT db106_resposta';
        $campos .= '   from avaliacaoresposta as ar ';
        $campos .= '   join avaliacaogrupoperguntaresposta as preenchimento on preenchimento.db108_avaliacaoresposta = ar.db106_sequencial ';
        $campos .= '   join avaliacaoperguntaopcao as apo on apo.db104_sequencial = ar.db106_avaliacaoperguntaopcao ';
        $campos .= '   join avaliacaopergunta as ap on ap.db103_sequencial = apo.db104_avaliacaopergunta ';
        $campos .= '  where ap.db103_perguntaidentificadora is true ';
        $campos .= '    and preenchimento.db108_avaliacaogruporesposta = db107_sequencial ';
        $campos .= ') as pk ';
        $dao = new \cl_avaliacaogruporesposta;
        $sql = $dao->sql_avaliacao_preenchida(null, $campos, null, $where);

        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos dos formul?rios.");
        }

        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarUltimoPreenchimentoInstituicao($codigoFormulario, $matricula = null)
    {
        $where  = " db101_sequencial = {$codigoFormulario} ";

        if ($matricula != null) {
            $where .= " AND COALESCE((SELECT db106_resposta::integer
            FROM avaliacaogrupoperguntaresposta
            JOIN avaliacaoresposta ON avaliacaogrupoperguntaresposta.db108_avaliacaoresposta=avaliacaoresposta.db106_sequencial
            JOIN avaliacaoperguntaopcao ON avaliacaoperguntaopcao.db104_sequencial = avaliacaoresposta.db106_avaliacaoperguntaopcao
            WHERE db108_avaliacaogruporesposta=db107_sequencial and db104_identificadorcampo = 'matricula'),0) IN ($matricula)";
        }

        $where .= " AND COALESCE((SELECT db106_resposta::integer
                FROM avaliacaogrupoperguntaresposta
                JOIN avaliacaoresposta ON avaliacaogrupoperguntaresposta.db108_avaliacaoresposta=avaliacaoresposta.db106_sequencial
                JOIN avaliacaoperguntaopcao ON avaliacaoperguntaopcao.db104_sequencial = avaliacaoresposta.db106_avaliacaoperguntaopcao
                WHERE db108_avaliacaogruporesposta=db107_sequencial and db104_identificadorcampo = 'instituicao'),0) IN (" . db_getsession("DB_instit") . ",0)
                AND db107_datalancamento::varchar || db107_hora = (SELECT db107_datalancamento::varchar || db107_hora FROM avaliacaogruporesposta ORDER BY db107_sequencial DESC LIMIT 1)";
        $campos = 'distinct db107_sequencial as preenchimento, ';
        $campos .= '(SELECT db106_resposta';
        $campos .= '   from avaliacaoresposta as ar ';
        $campos .= '   join avaliacaogrupoperguntaresposta as preenchimento on preenchimento.db108_avaliacaoresposta = ar.db106_sequencial ';
        $campos .= '   join avaliacaoperguntaopcao as apo on apo.db104_sequencial = ar.db106_avaliacaoperguntaopcao ';
        $campos .= '   join avaliacaopergunta as ap on ap.db103_sequencial = apo.db104_avaliacaopergunta ';
        $campos .= '  where ap.db103_perguntaidentificadora is true ';
        $campos .= '    and preenchimento.db108_avaliacaogruporesposta = db107_sequencial ';
        $campos .= "    and db103_identificadorcampo != 'instituicao' ";
        $campos .= "    order by db106_resposta desc limit 1 ";
        $campos .= ') as pk ';
        $dao = new \cl_avaliacaogruporesposta;
        $sql = $dao->sql_avaliacao_preenchida(null, $campos, "preenchimento desc", $where);

        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos dos formul?rios das rubricas.");
        }

        $rubricas = \db_utils::getCollectionByRecord($rs);

        /**
         * @todo busca os empregadores da institui??o e adicona para cada rubriuca
         */
        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * Busca os preenchimentos Lotacao
     *
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarUltimoPreenchimentoLotacao($codigoFormulario)
    {
        $where = " db101_sequencial = {$codigoFormulario} ";
        $group = "";
        $campos = "(SELECT z01_numcgm from cgm where z01_numcgm = $this->responsavelPreenchimento) as cgm, max(db107_sequencial) as preenchimento, ";
        $campos .= "(SELECT z01_cgccpf from cgm where z01_numcgm = $this->responsavelPreenchimento) as inscricao_empregador ";
        $dao = new \cl_avaliacaogruporespostalotacao;
        $sql = $dao->buscaAvaliacaoPreenchida(null, $campos, null, $where . $group);
        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos dos formul?rios dos empregadores.");
        }

        return \db_utils::getCollectionByRecord($rs);
    }


    /**
     * Buscas as respostas de um preenchimento
     *
     * @param integer $preenchimentoId
     * @return DadosResposta[]
     */
    public static function buscaRespostas($preenchimentoId)
    {
        $dao = new \cl_avaliacaogruporesposta;
        $campos = array(
            "db102_identificadorcampo as grupo",
            "db103_identificadorcampo as pergunta",
            "db103_sequencial as idpergunta",
            "db104_valorresposta as valorresposta",
            "db106_resposta as resposta",
            "db103_avaliacaotiporesposta as tipopergunta",
            "db103_obrigatoria as obrigatoria"
        );

        $campos = implode(', ', $campos);
        $sql = $dao->busca_resposta_preenchimento($preenchimentoId, $campos);
        $rs = \db_query($sql);

        return \db_utils::makeCollectionFromRecord($rs, function ($dado) {
            $dadoResposta = new DadosResposta();
            $dadoResposta->grupo = $dado->grupo;
            $dadoResposta->pergunta = $dado->pergunta;
            $dadoResposta->idPergunta = $dado->idpergunta;
            $dadoResposta->valorResposta = $dado->valorresposta;
            $dadoResposta->resposta = $dado->resposta;
            $dadoResposta->tipoPergunta = $dado->tipopergunta;
            $dadoResposta->obrigatoria = $dado->obrigatoria == 't';

            return $dadoResposta;
        });
    }

    public function buscarPreenchimentoS1010($codigoFormulario, $rubrica)
    {
        if ($rubrica != null) {
            $andRubricas = "
                AND rh27_rubric IN (" . str_replace(' ', '', $rubrica) . ")
            ";
        }
        $sql = "SELECT
        rh27_rubric AS codrubr,
        rh27_instit AS instituicao,
        rh27_descr AS dscRubr,
        rh27_pd AS tpRubr,

     (SELECT db104_valorresposta
      FROM avaliacaopergunta
      INNER JOIN avaliacaoperguntaopcao ON db104_avaliacaopergunta = db103_sequencial
      WHERE db104_sequencial = rh27_codincidprev) AS codIncCP,

     (SELECT db104_valorresposta
      FROM avaliacaopergunta
      INNER JOIN avaliacaoperguntaopcao ON db104_avaliacaopergunta = db103_sequencial
      WHERE db104_sequencial = rh27_codincidirrf) AS codIncIRRF,

     (SELECT db104_valorresposta
      FROM avaliacaopergunta
      INNER JOIN avaliacaoperguntaopcao ON db104_avaliacaopergunta = db103_sequencial
      WHERE db104_sequencial = rh27_codincidfgts) AS codIncFGTS,

     (SELECT db104_valorresposta
      FROM avaliacaopergunta
      INNER JOIN avaliacaoperguntaopcao ON db104_avaliacaopergunta = db103_sequencial
      WHERE db104_sequencial = rh27_codincidregime) AS codIncCPRP,
        CASE
            WHEN rh27_tetoremun = 't' THEN 'S'
            ELSE 'N'
        END AS tetoRemun,
        'TABRUB1' AS codidentpadrao,
     (SELECT r11_anousu||''||r11_mesusu AS anofolha
      FROM cfpess
      ORDER BY r11_anousu DESC
      LIMIT 1), e991_rubricasesocial AS natRubr
        FROM rhrubricas
        INNER JOIN baserubricasesocial ON e991_rubricas = rh27_rubric
        AND e991_instit = rh27_instit
        INNER JOIN rubricasesocial ON e991_rubricasesocial = e990_sequencial
        WHERE rh27_pd IS NOT NULL
            $andRubricas
            AND rh27_codincidprev IS NOT NULL
            AND rh27_codincidirrf IS NOT NULL
            AND rh27_codincidfgts IS NOT NULL
            AND rh27_codincidregime IS NOT NULL
            AND rh27_rubric NOT IN ('R978')
            AND rh27_instit = " . db_getsession('DB_instit');
        $rsRubrica = \db_query($sql);

        if (!$rsRubrica) {
            throw new \Exception("Erro ao buscar os preenchimentos do S1010");
        }

        /**
         * @todo busca os empregadores da institui??o e adicona para cada rubrica
         */
        return \db_utils::getCollectionByRecord($rsRubrica);
    }

    /**
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarPreenchimentoS2200($codigoFormulario, $matricula = null)
    {
        $sql = "SELECT distinct
                rh02_instit AS instituicao,
                z01_cgccpf as cpfTrab,
                z01_nome as nmTrab,
                rh01_sexo as sexo,
                CASE WHEN rh01_raca = 2 THEN 1
                WHEN rh01_raca = 4 THEN 2
                WHEN rh01_raca = 6 THEN 4
                WHEN rh01_raca = 8 THEN 3
                WHEN rh01_raca = 1 THEN 5
                WHEN rh01_raca = 9 THEN 6
                END AS racaCor,
                case when rh01_estciv = 1 then 1
                when rh01_estciv = 2 then 2
                when rh01_estciv = 5 then 3
                when rh01_estciv = 4 then 4
                when rh01_estciv = 3 then 5
                else 1
                end as estCiv,
                case when rh01_instru = 1 then 01
                when rh01_instru = 2 then 02
                when rh01_instru = 3 then 03
                when rh01_instru = 4 then 04
                when rh01_instru = 5 then 05
                when rh01_instru = 6 then 06
                when rh01_instru = 7 then 07
                when rh01_instru = 8 then 08
                when rh01_instru = 9 then 09
                when rh01_instru = 10 then 11
                when rh01_instru = 11 then 12
                    when rh01_instru = 12 then 10
                when rh01_instru = 0 then 01
                end as grauInstr,
                '' as nmSoc,

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
                 when rh01_nacion = 60 then 040
                 when rh01_nacion = 61 then 177
                 when rh01_nacion = 62 then 756
                 when rh01_nacion = 63 then 289
                 when rh01_nacion = 64 then 728
                 end as paisNascto,
            105 as paisnac,
            (SELECT j88_sigla from cgm intcgm
            inner join patrimonio.cgmendereco as cgmendereco on (intcgm.z01_numcgm=cgmendereco.z07_numcgm)
            inner join configuracoes.endereco as endereco on (cgmendereco.z07_endereco = endereco.db76_sequencial)
            inner join cadenderlocal on cadenderlocal.db75_sequencial = db76_sequencial
            inner join cadenderbairrocadenderrua on db87_sequencial = db75_cadenderbairrocadenderrua
             inner join cadenderbairro     on  db73_sequencial  = db87_cadenderbairro
             inner join cadenderrua        on  db74_sequencial  = db87_cadenderrua
             inner join cadendermunicipio  on  db72_sequencial  = db73_cadendermunicipio
             inner join cadendermunicipio  as a on a.db72_sequencial = db74_cadendermunicipio
             inner join cadenderestado     on  db71_sequencial  = a.db72_cadenderestado
             inner join cadenderpais       on  db70_sequencial  = db71_cadenderpais
             inner join cadenderruaruastipo on db85_cadenderrua = db74_sequencial
             inner join ruastipo           on  j88_codigo       = db85_ruastipo
            where z01_numcgm = intcgm.z01_numcgm limit 1) as tpLograd,
                z01_ender as dscLograd,
                z01_numero  as nrLograd,
                z01_compl as complemento,
                z01_bairro as bairro,
                rpad(z01_cep,8,'0') as cep,case when (SELECT
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
                db72_sequencial asc limit 1) is not null then (SELECT
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
                ( SELECT
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
                to_ascii(db72_descricao) = ( SELECT to_ascii(db72_descricao) from cadenderparam inner join cadenderpais on cadenderpais.db70_sequencial = cadenderparam.db99_cadenderpais inner join cadenderestado on cadenderestado.db71_sequencial = cadenderparam.db99_cadenderestado inner join cadendermunicipio on cadendermunicipio.db72_cadenderestado = cadenderestado.db71_sequencial inner join cadenderpais as p on p.db70_sequencial = cadenderestado.db71_cadenderpais inner join cadenderestado as a on a.db71_sequencial = cadendermunicipio.db72_cadenderestado INNER JOIN cadendermunicipiosistema ON cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial where db125_db_sistemaexterno = 4 and db72_sequencial = ( SELECT db125_cadendermunicipio FROM cadendermunicipiosistema INNER JOIN cadenderparam ON db125_cadendermunicipio = db99_cadendermunicipio AND db125_db_sistemaexterno = 4 LIMIT 1) order by db72_descricao asc limit 1)
                and cadenderestado.db71_descricao = (SELECT cadenderestado.db71_descricao from cadenderparam inner join cadenderpais on cadenderpais.db70_sequencial = cadenderparam.db99_cadenderpais inner join cadenderestado on cadenderestado.db71_sequencial = cadenderparam.db99_cadenderestado inner join cadendermunicipio on cadendermunicipio.db72_cadenderestado = cadenderestado.db71_sequencial inner join cadenderpais as p on p.db70_sequencial = cadenderestado.db71_cadenderpais inner join cadenderestado as a on a.db71_sequencial = cadendermunicipio.db72_cadenderestado INNER JOIN cadendermunicipiosistema ON cadendermunicipiosistema.db125_cadendermunicipio = cadendermunicipio.db72_sequencial where db125_db_sistemaexterno = 4 and db72_sequencial = ( SELECT db125_cadendermunicipio FROM cadendermunicipiosistema INNER JOIN cadenderparam ON db125_cadendermunicipio = db99_cadendermunicipio AND db125_db_sistemaexterno = 4 LIMIT 1) limit 1)
            order by
                db72_sequencial asc limit 1)
                end as codMunic,
                case when trim(z01_uf) = '' then 'MG'
                when z01_uf is null then 'MG'
                else z01_uf
                end as uf,
            case when rh02_deficientefisico = true and rh02_tipodeficiencia = 1  then 'S'
                else 'N'
                end as defFisica,
            case when rh02_deficientefisico = false then 'N'
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 'N'
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 3 then 'S'
                else 'N'
                end as defVisual,
            case when rh02_deficientefisico = false then 'N'
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 'N'
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 2 then 'S'
                else 'N'
                end as defAuditiva,
            case when rh02_deficientefisico = false then 'N'
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 'N'
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 7 then 'S'
                else 'N'
                end as defMental,
            case when rh02_deficientefisico = false then 'N'
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 'N'
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 4 then 'S'
                else 'N'
                end as defIntelectual,
            case when rh02_deficientefisico = false then 'N'
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 0 then 'N'
                when rh02_deficientefisico = true and rh02_tipodeficiencia = 6 then 'S'
                else 'N'
                end as reabReadap,
            case when rh02_cotadeficiencia = 't' then 'S'
                when rh02_cotadeficiencia = 'f' then 'N'
                end as infoCota,
                '' as observacao,

                z01_telef as fonePrinc,
                z01_email as emailPrinc,

                rh01_regist as matricula,
                case when rh30_regime = 1 or rh30_regime = 3 then 2
                when rh30_regime = 2 then 1
                end as tpRegTrab,
                case when r33_tiporegime = '1' then 1
                when r33_tiporegime = '2' then 2
                end as tpRegPrev,
                case when DATE_PART('YEAR',rh01_admiss) < 2021 then 'S'
               	when DATE_PART('YEAR',rh01_admiss) = 2021 and DATE_PART('MONTH',rh01_admiss) < 11 then 'S'
               	when DATE_PART('YEAR',rh01_admiss) = 2021 and DATE_PART('MONTH',rh01_admiss) = 11 and DATE_PART('DAY',rh01_admiss) <= 21  then 'S'
                else 'N'
                end as cadIni,
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh01_admiss
                end as dtAdm,
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and (rh01_tipadm = 1 or rh01_tipadm = 2) then 1
                when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and (rh01_tipadm = 3 or rh01_tipadm = 4) then 3
                end as tpAdmissao,
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then 1
                end as indAdmissao,
                '' as nrProcTrab,
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then 1
                end as tpRegJor,
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then 1
                end as natAtividade,
                case when (h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh116_cnpj
                end as cnpjSindCategProf,

                rh15_data as dtOpcFGTS,

                case when h13_categoria = 301 then 1
                when h13_categoria = 302 then 2
                when h13_categoria = 303 then 6
                when h13_categoria = 306 then 7
                when h13_categoria = 309 then 99
                end as tpProv,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) then rh01_admiss
                end as dtExercicio,
                case when r33_tiporegime = '2' then 0
                else 1
                end as tpPlanRP,
                case when r33_tiporegime = '2' then 'N'
                end as indTetoRGPS,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) and rh02_abonopermanencia = 'f' and r33_tiporegime = '2' then 'N'
                when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) and rh02_abonopermanencia = 't' and r33_tiporegime = '2' then 'S'
                end as indAbonoPerm,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309) then rh02_datainicio
                end as dtIniAbono,

             case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh37_descr
                end as nmCargo,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh37_cbo
                end as CBOCargo,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh01_admiss
                end as dtIngrCargo,
                 case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_descr is null then rh37_descr
                     when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_descr is not null then rh04_descr
                     when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and h13_tipocargo = 6 and h13_dscapo = 'SCM' and rh04_descr is not null then rh04_descr
                     when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and h13_tipocargo = 6 and h13_dscapo = 'SCM' and rh04_descr is null then rh37_descr
                END as nmFuncao,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_cbo is null then rh37_cbo
                     when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh30_naturezaregime = 2 and rh04_cbo is not null then rh04_cbo
                end as CBOFuncao,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh37_reqcargo in (1,2,3,5) then 'S'
                     when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh37_reqcargo in (4,6,7,8) then 'N'
                end as acumCargo,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then h13_categoria
                end as codCateg,

                case when h13_categoria = 101 then rh02_salari
                end as vrSalFx,
                case when h13_categoria = 101 and rh02_tipsal = 'M' then 5
                when h13_categoria = 101 and rh02_tipsal = 'Q' then 4
                when h13_categoria = 101 and rh02_tipsal = 'D' then 2
                when h13_categoria = 101 and rh02_tipsal = 'H' then 1
                end as undSalFixo,

                case when h13_categoria = 101 and h13_tipocargo = 7 or rh164_datafim is not null then 2
                when h13_categoria = 101 then 1
                end as tpContr,
                rh164_datafim as dtTerm,
                case when h13_categoria = 101 and h13_tipocargo = 7 or rh164_datafim is not null then 'S'
                end as clauAssec,

                1 as tpinsc_localtrabgeral,
                cgc as nrinsc_localtrabgeral,
                nomeinst as desccomp_localtrabgeral,

                rh02_hrssem as qtdHrsSem,
                rh02_tipojornada as tpJornada,
                0 as tmpParc,
                case when rh02_horarionoturno = 'f' then 'N'
                when rh02_horarionoturno = 't' then 'S'
                end as horNoturno,
                jt_descricao as dscJorn
                        from
                            rhpessoal
                        left join rhpessoalmov on
                            rh02_anousu = fc_getsession('DB_anousu')::int
                            and rh02_mesusu = date_part('month',fc_getsession('DB_datausu')::date)
                            and rh02_regist = rh01_regist
                            and rh02_instit = fc_getsession('DB_instit')::int
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
                                        SELECT distinct r33_codtab,r33_nome,r33_tiporegime
                                                            from inssirf
                                                            where     r33_anousu = (SELECT r11_anousu from cfpess where r11_instit = fc_getsession('DB_instit')::int order by r11_anousu desc limit 1)
                                                                    and r33_mesusu = (SELECT r11_mesusu from cfpess where r11_instit = fc_getsession('DB_instit')::int order by r11_anousu desc, r11_mesusu desc limit 1)
                                                                    and r33_instit = fc_getsession('DB_instit')::int
                                                            ) as x on r33_codtab = rhpessoalmov.rh02_tbprev+2
                        left  join rescisao      on rescisao.r59_anousu       = rhpessoalmov.rh02_anousu
                                                            and rescisao.r59_mesusu       = rhpessoalmov.rh02_mesusu
                                                            and rescisao.r59_regime       = rhregime.rh30_regime
                                                            and rescisao.r59_causa        = rhpesrescisao.rh05_causa
                                                            and rescisao.r59_caub         = rhpesrescisao.rh05_caub::char(2)
                        where h13_categoria in ('101', '106', '111', '301', '302', '303', '305', '306', '309', '312', '313', '902')
                        and rh30_vinculo = 'A' ";
        if ($matricula != null) {
            $sql .= "and rh01_regist in ($matricula) ";
        }
        $sql .= "and (
					            (
					            (date_part('year',rhpessoal.rh01_admiss)::varchar || lpad(date_part('month',rhpessoal.rh01_admiss)::varchar,2,'0'))::integer <= 202207
					            and (date_part('year',fc_getsession('DB_datausu')::date)::varchar || lpad(date_part('month',fc_getsession('DB_datausu')::date)::varchar,2,'0'))::integer <= 202207
					            and (rh05_recis is null or (date_part('year',rh05_recis)::varchar || lpad(date_part('month',rh05_recis)::varchar,2,'0'))::integer > 202207)
					            ) or (
					            date_part('month',rhpessoal.rh01_admiss) = date_part('month',fc_getsession('DB_datausu')::date)
					            and date_part('year',rhpessoal.rh01_admiss) = date_part('year',fc_getsession('DB_datausu')::date)
					            and (date_part('year',fc_getsession('DB_datausu')::date)::varchar || lpad(date_part('month',fc_getsession('DB_datausu')::date)::varchar,2,'0'))::integer > 202207
					            )
				            ) order by z01_nome asc";

        $rs = \db_query($sql);
        // echo $sql;
        // db_criatabela($rs);
        // exit;
        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos do S2200");
        }


        /**
         * @todo busca os empregadores da institui??o e adicona para cada rubriuca
         */
        return \db_utils::getCollectionByRecord($rs);
    }


    /**
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarPreenchimentoS2206($codigoFormulario, $matricula = null)
    {
        $sql = "SELECT distinct
                rh02_instit AS instituicao,
                z01_cgccpf as cpfTrab,
                z01_nome as nmTrab,
                rh01_sexo as sexo,
                rh01_regist as matricula,
                

                rh02_salari,
                rh02_funcao,
                rh20_cargo,
                r33_tiporegime,
                rh01_rhsindicato,
                rh116_cnpj,
                rh02_plansegreg,
                rh02_abonopermanencia,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh37_cbo
                end as CBOCargo,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) then rh37_descr
                end as nmCargo,
                case when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh37_reqcargo in (1,2,3,5) then 'S'
                     when (h13_categoria = 301 or h13_categoria = 302 or h13_categoria = 303 or h13_categoria = 306 or h13_categoria = 309 or h13_categoria = 101 or h13_categoria = 106 or h13_categoria = 111) and rh37_reqcargo in (4,6,7,8) then 'N'
                end as acumCargo,

                h13_categoria,
                
                case when rh02_tipsal = 'M' then 5
                when rh02_tipsal = 'Q' then 4
                when rh02_tipsal = 'D' then 2
                when rh02_tipsal = 'H' then 1
                end as undSalFixo,
                case when h13_tipocargo = 7 or rh164_datafim is not null then 2
                else 1
                end as tpContr,
                rh164_datafim as dtTerm,
                cgc as nrinsc_localtrabgeral,
                nomeinst as desccomp_localtrabgeral,
                rh02_hrssem,
                rh02_tipojornada,
                rh02_horarionoturno,
                jt_nome,
                rh30_regime
                        from
                            rhpessoal
                        left join rhpessoalmov on
                            rh02_anousu = fc_getsession('DB_anousu')::int
                            and rh02_mesusu = date_part('month',fc_getsession('DB_datausu')::date)
                            and rh02_regist = rh01_regist
                            and rh02_instit = fc_getsession('DB_instit')::int
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
                                        SELECT distinct r33_codtab,r33_nome,r33_tiporegime
                                                            from inssirf
                                                            where     r33_anousu = (SELECT r11_anousu from cfpess where r11_instit = fc_getsession('DB_instit')::int order by r11_anousu desc limit 1)
                                                                    and r33_mesusu = (SELECT r11_mesusu from cfpess where r11_instit = fc_getsession('DB_instit')::int order by r11_anousu desc, r11_mesusu desc limit 1)
                                                                    and r33_instit = fc_getsession('DB_instit')::int
                                                            ) as x on r33_codtab = rhpessoalmov.rh02_tbprev+2
                        left  join rescisao      on rescisao.r59_anousu       = rhpessoalmov.rh02_anousu
                                                            and rescisao.r59_mesusu       = rhpessoalmov.rh02_mesusu
                                                            and rescisao.r59_regime       = rhregime.rh30_regime
                                                            and rescisao.r59_causa        = rhpesrescisao.rh05_causa
                                                            and rescisao.r59_caub         = rhpesrescisao.rh05_caub::char(2)
                        where h13_categoria in ('101', '106', '111', '301', '302', '303', '305', '306', '309', '312', '313', '902')
                        and rh30_vinculo = 'A'
                        and rh05_recis is null
                        ";
        if ($matricula != null) {
            $sql .= "and rh01_regist in ($matricula) ";
        }

        $rs = \db_query($sql);
        // echo $sql;
        // db_criatabela($rs);
        // exit;
        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos do S2206");
        }
        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarPreenchimentoS2410($codigoFormulario, $matricula = null)
    {
        $sql = "SELECT cgm.z01_cgccpf AS cpfbenef,
       rh01_matorgaobeneficio AS matricula,
       rh01_cnpjrespmatricula AS cnpjorigem,
       cgc,
       CASE
           WHEN rh01_admiss < '2021-11-21' THEN 'S'
           ELSE 'N'
       END AS cadini,
       1 AS indsitbenef,
       rh01_regist AS nrbeneficio,
       rh01_admiss AS dtinibeneficio,
       date_part('month', rh01_admiss) as rh01_admiss_mes,
       date_part('year', rh01_admiss) as rh01_admiss_ano,
       rh02_tipobeneficio AS tpbeneficio,
       CASE
           WHEN rh02_plansegreg IS NULL THEN 0
           ELSE rh02_plansegreg
       END AS tpplanrp,
       rh02_descratobeneficio AS dsc,
       CASE
           WHEN rh01_concedido = 't' THEN 'S'
           ELSE 'N'
       END AS inddecjud,
       CASE
           WHEN rh02_validadepensao IS NOT NULL THEN 2
           ELSE 1
       END AS tppenmorte,
       instituidor.z01_cgccpf AS cpfinst,
       rh02_dtobitoinstituidor AS dtinst,
       rh30_vinculo,
       rh02_rhtipoapos
FROM rhpessoal
INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
LEFT JOIN rhpessoalmov ON rh02_anousu = fc_getsession('DB_anousu')::int
AND rh02_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
AND rh02_regist = rh01_regist
AND rh02_instit = fc_getsession('DB_instit')::int
LEFT JOIN rhpesrescisao ON rh02_seqpes = rh05_seqpes
LEFT JOIN rhregime ON rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
LEFT JOIN rescisao ON rescisao.r59_anousu = rhpessoalmov.rh02_anousu
AND rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu
AND rescisao.r59_regime = rhregime.rh30_regime
AND rescisao.r59_causa = rhpesrescisao.rh05_causa
AND rescisao.r59_caub = rhpesrescisao.rh05_caub::char(2)
LEFT JOIN cgm instituidor ON instituidor.z01_numcgm = rh02_cgminstituidor
inner join db_config on
                            db_config.codigo = rhpessoal.rh01_instit
WHERE rh30_vinculo IN ('I',
                       'P')
  AND (date_part('month', rh01_admiss) = date_part('month', fc_getsession('DB_datausu')::date) AND date_part('year', rh01_admiss) = fc_getsession('DB_anousu')::int)
  AND r59_anousu IS NULL ";
        if ($matricula != null) {
            $sql .= " and rh01_regist in ($matricula) ";
        }

        $rs = \db_query($sql);

        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos do S2410");
        }


        /**
         * @todo busca os empregadores da institui??o e adicona para cada rubriuca
         */
        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarPreenchimentoS1200($codigoFormulario, $matricula = null, $cgm = null, $tipoevento = null)
    {
        $anofolha = db_anofolha();
        $mesfolha = db_mesfolha();
        if (empty($mesfolha)) {
            $anofolha = db_getsession("DB_anousu");
            $mesfolha = date("m", db_getsession("DB_datausu"));
        }
        if ($tipoevento == 1) {
            $sql = "SELECT distinct z01_cgccpf from rhpessoal
                left join rhpessoalmov on
                rh02_anousu = fc_getsession('DB_anousu')::int
                and rh02_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
                and rh02_regist = rh01_regist
                and rh02_instit = fc_getsession('DB_instit')::int
            inner join cgm on
                cgm.z01_numcgm = rhpessoal.rh01_numcgm
            left join rhpesrescisao on
                rh02_seqpes = rh05_seqpes
            left join rhdepend on
                rhdepend.rh31_regist = rhpessoal.rh01_regist
            left join rhregime on
                rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
            inner join tpcontra on
                tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            left join rescisao on
                rescisao.r59_anousu = rhpessoalmov.rh02_anousu
                and rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu
                and rescisao.r59_regime = rhregime.rh30_regime
                and rescisao.r59_causa = rhpesrescisao.rh05_causa
                and rescisao.r59_caub = rhpesrescisao.rh05_caub::char(2)
            left  outer join (
                    SELECT distinct r33_codtab,r33_nome,r33_tiporegime
                                        from inssirf
                                        where     r33_anousu = $anofolha
                                            and r33_mesusu = $mesfolha
                                            and r33_instit = fc_getsession('DB_instit')::int
                                    ) as x on r33_codtab = rhpessoalmov.rh02_tbprev+2
                where (
                    (h13_categoria = '901' and rh30_vinculo = 'A')
                    or
                    (h13_categoria in ('101', '106', '111', '301', '302', '303', '305', '306', '309', '312', '313','410', '902','701','712','771','711')
                    and rh30_vinculo = 'A'
                    and r33_tiporegime = '1')
                )
                and ((rh05_recis is not null
                and date_part('month', rh05_recis) = date_part('month', fc_getsession('DB_datausu')::date)
                and date_part('year', rh05_recis) = date_part('year', fc_getsession('DB_datausu')::date)
                )
                or
                rh05_recis is null
                ) ";

            if ($matricula != null) {
                $sql .= "and cgm.z01_cgccpf in (select z01_cgccpf from cgm join rhpessoal on cgm.z01_numcgm = rhpessoal.rh01_numcgm where rh01_regist in ($matricula)) ";
            }
        } else {
            $ano = date("Y", db_getsession("DB_datausu"));
            $mes = date("m", db_getsession("DB_datausu"));
            $data = "$ano-$mes-01";
            $data = new \DateTime($data);
            $data->modify('last day of this month');
            $ultimoDiaDoMes = $data->format('d');

            $sql = "SELECT distinct
                cgm.z01_cgccpf
            from
                empnota
            inner join empempenho on
                e69_numemp = e60_numemp
            inner join cgm as cgm on
                e60_numcgm = cgm.z01_numcgm
            inner join empnotaele on
                e69_codnota = e70_codnota
            inner join orcelemento on
                empnotaele.e70_codele = orcelemento.o56_codele
            left join cgmfisico on
                z04_numcgm = cgm.z01_numcgm
            left join rhcbo on
                rh70_sequencial = z04_rhcbo
            left join conlancamemp on
                c75_numemp = e60_numemp
            left join conlancamdoc on
                c71_codlan = c75_codlan
                and c71_coddoc = 904
            left join pagordemnota on
                e71_codnota = e69_codnota
                and e71_anulado is false
            left join pagordem on
                e71_codord = e50_codord
            left join pagordemele on
                e53_codord = e50_codord
            left join cgm as empresa on
                empresa.z01_numcgm = e50_empresadesconto
            left join categoriatrabalhador as cattrabalhador on
                cattrabalhador.ct01_codcategoria = e50_cattrabalhador
            left join categoriatrabalhador as catremuneracao on
                catremuneracao.ct01_codcategoria = e50_cattrabalhadorremurenacao
            left join retencaopagordem on
                pagordem.e50_codord = retencaopagordem.e20_pagordem
            left join retencaoreceitas on
                retencaoreceitas.e23_retencaopagordem = retencaopagordem.e20_sequencial
            left join retencaotiporec on
                retencaotiporec.e21_sequencial = retencaoreceitas.e23_retencaotiporec
            left join db_config on
		        db_config.codigo = empempenho.e60_instit
            where e50_data BETWEEN '$ano-$mes-01' AND '$ano-$mes-$ultimoDiaDoMes'
                and Length(cgm.z01_cgccpf) like '11'
                and e50_cattrabalhador is not null
                and db_config.codigo = fc_getsession('DB_instit')::int
            ";
            if ($cgm != null) {
                $sql .= " and cgm.z01_numcgm in ($cgm) ";
            }
        }
        $rs = \db_query($sql);
        // echo $sql;
        // db_criatabela($rs);
        // exit;
        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos do S1200");
        }
        /**
         * @todo busca os empregadores da institui??o e adicona para cada rubriuca
         */
        return \db_utils::getCollectionByRecord($rs);
    }
    /**
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarPreenchimentoS1202($codigoFormulario, $matricula = null)
    {
        $anofolha = db_anofolha();
        $mesfolha = db_mesfolha();
        $sql = "SELECT distinct z01_cgccpf from rhpessoal
        left join rhpessoalmov on
        rh02_anousu = fc_getsession('DB_anousu')::int
        and rh02_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
        and rh02_regist = rh01_regist
        and rh02_instit = fc_getsession('DB_instit')::int
    inner join cgm on
        cgm.z01_numcgm = rhpessoal.rh01_numcgm
    left join rhpesrescisao on
        rh02_seqpes = rh05_seqpes
    left join rhdepend on
        rhdepend.rh31_regist = rhpessoal.rh01_regist
    left join rhregime on
        rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
    inner join tpcontra on
        tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
    left join rescisao on
        rescisao.r59_anousu = rhpessoalmov.rh02_anousu
        and rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu
        and rescisao.r59_regime = rhregime.rh30_regime
        and rescisao.r59_causa = rhpesrescisao.rh05_causa
        and rescisao.r59_caub = rhpesrescisao.rh05_caub::char(2)
    left  outer join (
            SELECT distinct r33_codtab,r33_nome,r33_tiporegime
                                from inssirf
                                where     r33_anousu = $anofolha
                                            and r33_mesusu = $mesfolha
                                      and r33_instit = fc_getsession('DB_instit')::int
                               ) as x on r33_codtab = rhpessoalmov.rh02_tbprev+2
                    where h13_categoria in ('301', '302', '303', '305', '306', '309', '410')
                and rh30_vinculo = 'A'
                and r33_tiporegime = '2'
                and ((rh05_recis is not null
                and date_part('month', rh05_recis) = date_part('month', fc_getsession('DB_datausu')::date)
                and date_part('year', rh05_recis) = date_part('year', fc_getsession('DB_datausu')::date)
                )
                or
                rh05_recis is null
                ) ";

        if ($matricula != null) {
            $sql .= "and cgm.z01_cgccpf in (select z01_cgccpf from cgm join rhpessoal on cgm.z01_numcgm = rhpessoal.rh01_numcgm where rh01_regist in ($matricula)) ";
        }
        $rs = \db_query($sql);
        // echo $sql;
        // db_criatabela($rs);
        // exit;
        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos do S1202");
        }
        /**
         * @todo busca os empregadores da institui??o e adicona para cada rubriuca
         */
        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarPreenchimentoS1207($codigoFormulario, $matricula = null)
    {
        $sql = "select distinct z01_cgccpf from rhpessoal
        left join rhpessoalmov on
        rh02_anousu = fc_getsession('DB_anousu')::int
        and rh02_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
        and rh02_regist = rh01_regist
        and rh02_instit = fc_getsession('DB_instit')::int
        inner join cgm on
            cgm.z01_numcgm = rhpessoal.rh01_numcgm
        left join rhpesrescisao on
            rh02_seqpes = rh05_seqpes
        left join rhdepend on
            rhdepend.rh31_regist = rhpessoal.rh01_regist
        left join rhregime on
            rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
        inner join tpcontra on
            tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
        left join rescisao on
            rescisao.r59_anousu = rhpessoalmov.rh02_anousu
            and rescisao.r59_mesusu = rhpessoalmov.rh02_mesusu
            and rescisao.r59_regime = rhregime.rh30_regime
            and rescisao.r59_causa = rhpesrescisao.rh05_causa
            and rescisao.r59_caub = rhpesrescisao.rh05_caub::char(2)
        left  outer join (
                SELECT distinct r33_codtab,r33_nome,r33_tiporegime
                                    from inssirf
                                    where     r33_anousu = fc_getsession('DB_anousu')::int
                                        and r33_mesusu = date_part('month',fc_getsession('DB_datausu')::date)
                                        and r33_instit = fc_getsession('DB_instit')::int
                                ) as x on r33_codtab = rhpessoalmov.rh02_tbprev+2
                                    where rh30_vinculo in ('I','P')
                                    and ((rh05_recis is not null
                                    and date_part('month', rh05_recis) = date_part('month', fc_getsession('DB_datausu')::date)
                                    and date_part('year', rh05_recis) = date_part('year', fc_getsession('DB_datausu')::date)
                                    )
                                    or
                                    rh05_recis is null
                                    ) ";

        if ($matricula != null) {
            $sql .= " and cgm.z01_cgccpf in (select z01_cgccpf from cgm join rhpessoal on cgm.z01_numcgm = rhpessoal.rh01_numcgm where rh01_regist in ($matricula)) ";
        }
        $rs = \db_query($sql);
        // echo $sql;
        // db_criatabela($rs);
        // exit;
        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos do S1207");
        }
        /**
         * @todo busca os empregadores da institui??o e adicona para cada rubriuca
         */
        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarPreenchimentoS1210($codigoFormulario, $matricula = null, $cgm = null, $tipoevento = null)
    {
        $ano = date("Y", db_getsession("DB_datausu"));
        $mes = date("m", db_getsession("DB_datausu"));

        $anofolha = db_anofolha();
        $mesfolha = db_mesfolha();

        if ($tipoevento == 1) {
            $sql = "SELECT distinct z01_cgccpf from rhpessoal
            left join rhpessoalmov on
                rh02_anousu = fc_getsession('DB_anousu')::int
                and rh02_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
                and rh02_regist = rh01_regist
                and rh02_instit = fc_getsession('DB_instit')::int
            left join rhinssoutros on
	rh51_seqpes = rh02_seqpes
    inner join cgm on
        cgm.z01_numcgm = rhpessoal.rh01_numcgm
    inner join db_config on
	db_config.codigo = rhpessoal.rh01_instit
    left join rhpesrescisao on
	rh02_seqpes = rh05_seqpes
    left join rhregime on
        rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
    inner join tpcontra on
        tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            left  outer join (
                    SELECT distinct r33_codtab,r33_nome,r33_tiporegime
                                        from inssirf
                                        where     r33_anousu = $anofolha
                                            and r33_mesusu = $mesfolha
                                            and r33_instit = fc_getsession('DB_instit')::int
                                    ) as x on r33_codtab = rhpessoalmov.rh02_tbprev+2
             where 1=1
                and ((rh05_recis is not null
                and date_part('month', rh05_recis) = date_part('month', fc_getsession('DB_datausu')::date)
                and date_part('year', rh05_recis) = date_part('year', fc_getsession('DB_datausu')::date)
                )
                or
                rh05_recis is null
                ) ";

            if ($matricula != null) {
                $sql .= " and cgm.z01_cgccpf in (select z01_cgccpf from cgm join rhpessoal on cgm.z01_numcgm = rhpessoal.rh01_numcgm where rh01_regist in ($matricula)) ";
            }
        } else {
            $sql = "SELECT distinct z01_cgccpf
            FROM (
                    select
                        z01_cgccpf,
                        sum(
                            case
                                when corgrupotipo.k106_sequencial = 4 then corrente.k12_valor * -1
                                else corrente.k12_valor
                            end
                        ) as vr_liq
                    from pagordem
                        inner join empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
                        inner join cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
                        inner join empord on empord.e82_codord = pagordem.e50_codord
                        inner join empagemov on empagemov.e81_codmov = empord.e82_codmov
                        inner join corempagemov on corempagemov.k12_codmov = empagemov.e81_codmov
                        inner join corrente on (
                            corrente.k12_id,
                            corrente.k12_data,
                            corrente.k12_autent
                        ) = (
                            corempagemov.k12_id,
                            corempagemov.k12_data,
                            corempagemov.k12_autent
                        )
                        inner join corgrupocorrente on (
                            corrente.k12_id,
                            corrente.k12_data,
                            corrente.k12_autent
                        ) = (
                            corgrupocorrente.k105_id,
                            corgrupocorrente.k105_data,
                            corgrupocorrente.k105_autent
                        )
                        inner join corgrupo ON corgrupo.k104_sequencial = corgrupocorrente.k105_corgrupo
                        inner join corgrupotipo on corgrupotipo.k106_sequencial = corgrupocorrente.k105_corgrupotipo
                        inner join pagordemele on e50_codord = e53_codord
                    where e50_cattrabalhador is not null
                        and date_part('month',corrente.k12_data) = $mes
                        and date_part('year',corrente.k12_data) = $ano
                        and corgrupotipo.k106_sequencial in (1, 4)
                        and length(z01_cgccpf) = 11";
            if ($cgm != null) {
                $sql .= " and e60_numcgm in ($cgm) ";
            }
            $sql .= " group by 1 ) AS pagamentos
            WHERE vr_liq > 0
            ";
        }
        $rs = \db_query($sql);
        // echo $sql;
        // db_criatabela($rs);
        // exit;
        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos do S1210");
        }
        /**
         * @todo busca os empregadores da institui??o e adicona para cada rubriuca
         */
        return \db_utils::getCollectionByRecord($rs);
    }

    /**
     * @param integer $codigoFormulario
     * @return stdClass[]
     */
    public function buscarPreenchimentoS1299($codigoFormulario, $matricula = null, $cgm = null, $tipoevento = null)
    {
        $ano = date("Y", db_getsession("DB_datausu"));
        $mes = date("m", db_getsession("DB_datausu"));

        $anofolha = db_anofolha();
        $mesfolha = db_mesfolha();

        $sql = "SELECT distinct z01_cgccpf from rhpessoal
            left join rhpessoalmov on
                rh02_anousu = fc_getsession('DB_anousu')::int
                and rh02_mesusu = date_part('month', fc_getsession('DB_datausu')::date)
                and rh02_regist = rh01_regist
                and rh02_instit = fc_getsession('DB_instit')::int
            left join rhinssoutros on
	rh51_seqpes = rh02_seqpes
    inner join cgm on
        cgm.z01_numcgm = rhpessoal.rh01_numcgm
    inner join db_config on
	db_config.codigo = rhpessoal.rh01_instit
    left join rhpesrescisao on
	rh02_seqpes = rh05_seqpes
    left join rhregime on
        rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
    inner join tpcontra on
        tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            left  outer join (
                    SELECT distinct r33_codtab,r33_nome,r33_tiporegime
                                        from inssirf
                                        where     r33_anousu = $anofolha
                                            and r33_mesusu = $mesfolha
                                            and r33_instit = fc_getsession('DB_instit')::int
                                    ) as x on r33_codtab = rhpessoalmov.rh02_tbprev+2
             where 1=1
                and ((rh05_recis is not null
                and date_part('month', rh05_recis) = date_part('month', fc_getsession('DB_datausu')::date)
                and date_part('year', rh05_recis) = date_part('year', fc_getsession('DB_datausu')::date)
                )
                or
                rh05_recis is null
                ) ";

        if ($matricula != null) {
            $sql .= " and cgm.z01_cgccpf in (select z01_cgccpf from cgm join rhpessoal on cgm.z01_numcgm = rhpessoal.rh01_numcgm where rh01_regist in ($matricula)) ";
        }

        $sql .= ' limit 1';

        $rs = \db_query($sql);
        // echo $sql;
        // db_criatabela($rs);
        // exit;
        if (!$rs) {
            throw new \Exception("Erro ao buscar os preenchimentos do S1210");
        }
        /**
         * @todo busca os empregadores da institui??o e adicona para cada rubriuca
         */
        return \db_utils::getCollectionByRecord($rs);
    }

    public function buscarPreenchimentoS2230($codigoFormulario, $matricula)
    {
        $sql = "
        SELECT DISTINCT *
            FROM
                (SELECT cgm.z01_cgccpf AS cpftrab,
                        rhpessoal.rh01_esocial AS matricula,
                        rhpessoal.rh01_regist AS matricula_sistema,
                        tpcontra.h13_categoria AS codcateg,
                        afasta.r45_dtafas AS dtiniafast,
                        afasta.r45_codigoafasta AS codmotafast,
                        afasta.r45_mesmadoenca AS infomesmomtv,
                        afasta.r45_dtreto dttermafast,
                        NULL AS dtiniafastferias,
                        NULL AS dtinicio,
                        NULL AS dtfim,
                        NULL AS dttermafastferias,
                        rh30_regime
                FROM afasta
                INNER JOIN rhpessoal ON rhpessoal.rh01_regist = afasta.r45_regist
                LEFT JOIN rhpessoalmov ON rh02_anousu = fc_getsession('DB_anousu')::int
            AND rh02_mesusu = date_part('month',fc_getsession('DB_datausu')::date)
            AND rh02_regist = rh01_regist
            AND rh02_instit = fc_getsession('DB_instit')::int
            INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
            left join rhregime on rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
            WHERE date_part('month',afasta.r45_dtafas::date) = date_part('month',fc_getsession('DB_datausu')::date)
                AND date_part('year',afasta.r45_dtafas::date) = fc_getsession('DB_anousu')::int
            UNION
            SELECT cgm.z01_cgccpf AS cpftrab,
                rhpessoal.rh01_esocial AS matricula,
                rhpessoal.rh01_regist AS matricula_sistema,
                tpcontra.h13_categoria AS codcateg,
                cadferia.r30_per1i AS dtiniafast,
                '15' AS codmotafast,
                '' AS infomesmomtv,
                cadferia.r30_per1f AS dttermafast,
                cadferia.r30_per1i AS dtiniafastferias,
                cadferia.r30_perai AS dtinicio,
                CASE
                    WHEN (cadferia.r30_peraf - cadferia.r30_perai) < 365 THEN cadferia.r30_peraf
                    WHEN (cadferia.r30_peraf - cadferia.r30_perai) > 365 THEN cadferia.r30_peraf
                    ELSE NULL
                END AS dtfim,
                r30_per1f AS dttermafastferias,
                rh30_regime
            FROM cadferia
            INNER JOIN rhpessoal ON rhpessoal.rh01_regist = cadferia.r30_regist
            LEFT JOIN rhpessoalmov ON rh02_anousu = fc_getsession('DB_anousu')::int
            AND rh02_mesusu = date_part('month',fc_getsession('DB_datausu')::date)
            AND rh02_regist = rh01_regist
            AND rh02_instit = fc_getsession('DB_instit')::int
            INNER JOIN tpcontra ON tpcontra.h13_codigo = rhpessoalmov.rh02_tpcont
            INNER JOIN cgm ON cgm.z01_numcgm = rhpessoal.rh01_numcgm
            left join rhregime on rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
            WHERE date_part('month',cadferia.r30_per1i::date) = date_part('month',fc_getsession('DB_datausu')::date)
                AND date_part('year',cadferia.r30_per1i::date) = fc_getsession('DB_anousu')::int) AS xxx
        ";
        if ($matricula != null) {
            $sql .= "where matricula_sistema::int in ($matricula) ";
        }

        $rsAfasta = \db_query($sql);
        // echo $sql;
        // db_criatabela($rsAfasta);
        // exit;
        if (!$rsAfasta) {
            throw new \Exception("Erro ao buscar os preenchimentos do S2230");
        }

        /**
         * @todo busca os empregadores da institui??o e adicona para cada rubrica
         */
        return \db_utils::getCollectionByRecord($rsAfasta);
    }

    /**
     * Buscar dados para preenchimento de um evento espec?fico
     *
     * @param integer $tipo - ECidade\RecursosHumanos\ESocial\Model\Formulario\Tipo
     * @param integer $matricula
     * @return array 10:31
     */
    public function buscarPreenchimento($tipo, $matricula = null)
    {

        $eventoCargaFactory = new EventoCargaFactory($tipo);
        $eventoCarga = $eventoCargaFactory->getEvento();
        $rsResult = $eventoCarga->execute($matricula);
        return \db_utils::getCollectionByRecord($rsResult);
    }
}
