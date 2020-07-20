<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_cvc102020_classe.php");
require_once("classes/db_cvc202020_classe.php");
require_once("classes/db_cvc302020_classe.php");
require_once("classes/db_cvc402020_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarCVC.model.php");


/**
 * Dados Cadastro de Veículos Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoCadastroVeiculos extends SicomArquivoBase implements iPadArquivoBaseCSV
{

    /**
     *
     * Codigo do layout. (db_layouttxt.db50_codigo)
     * @var Integer
     */
    protected $iCodigoLayout = 175;

    /**
     *
     * Nome do arquivo a ser criado
     * @var String
     */
    protected $sNomeArquivo = 'CVC';

    /**
     *
     * Construtor da classe
     */
    public function __construct()
    {

    }

    /**
     * Retorna o codigo do layout
     *
     * @return Integer
     */
    public function getCodigoLayout()
    {
        return $this->iCodigoLayout;
    }

    /**
     *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
     */
    public function getCampos()
    {


    }

    /**
     * selecionar os dados do cadastro de veículos
     * @see iPadArquivoBase::gerarDados()
     */
    public function gerarDados()
    {

        /**
         * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
         */
        $clcvc10 = new cl_cvc102020();
        $clcvc20 = new cl_cvc202020();
        $clcvc30 = new cl_cvc302020();
        $clcvc40 = new cl_cvc402020();

        $sSqlTrataUnidade = "SELECT si08_tratacodunidade FROM infocomplementares WHERE si08_instit = " . db_getsession("DB_instit");
        $rsResultTrataUnidade = db_query($sSqlTrataUnidade);
        $sTrataCodUnidade = db_utils::fieldsMemory($rsResultTrataUnidade, 0)->si08_tratacodunidade;


        /**
         * excluir informacoes do mes selecioado
         */
        db_inicio_transacao();
        $result = db_query($clcvc10->sql_query(null, "*", null, "si146_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
               and si146_instit=" . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clcvc10->excluir(null, "si146_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si146_instit=" . db_getsession("DB_instit"));
            if ($clcvc10->erro_status == 0) {
                throw new Exception($clcvc10->erro_msg);
            }
        }

        $result = db_query($clcvc20->sql_query(null, "*", null, "si147_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
        and si147_instit=" . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clcvc20->excluir(null, "si147_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si147_instit=" . db_getsession("DB_instit"));
            if ($clcvc20->erro_status == 0) {
                throw new Exception($clcvc20->erro_msg);
            }
        }

        $result = db_query($clcvc30->sql_query(null, "*", null, "si148_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si148_instit=" . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clcvc30->excluir(null, "si148_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si148_instit=" . db_getsession("DB_instit"));
            if ($clcvc30 > erro_status == 0) {
                throw new Exception($clcvc30->erro_msg);
            }
        }

        $result = db_query($clcvc40->sql_query(null, "*", null, "si149_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si149_instit=" . db_getsession("DB_instit")));
        if (pg_num_rows($result) > 0) {
            $clcvc40->excluir(null, "si149_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si149_instit=" . db_getsession("DB_instit"));
            if ($clcvc40->erro_status == 0) {
                throw new Exception($clcvc40->erro_msg);
            }
        }
        db_fim_transacao();

        db_inicio_transacao();
        $sSql = "
      SELECT DISTINCT '10' AS tipoRegistro,
                      si09_codorgaotce AS codOrgao,
                      CASE
                          WHEN (unveic.o41_codtri::INT != 0
                                AND orveic.o40_codtri::INT = 0) THEN lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_codtri,3,0)
                          WHEN (unveic.o41_codtri::INT = 0
                                AND orveic.o40_codtri::INT != 0) THEN lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_unidade,3,0)
                          WHEN (unveic.o41_codtri::INT != 0
                                AND orveic.o40_codtri::INT != 0) THEN lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_codtri,3,0)
                          ELSE lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_unidade,3,0)
                      END AS codunidadesub,
                      CASE
                          WHEN veiculos.ve01_codigoant IS NULL
                               OR veiculos.ve01_codigoant = 0 THEN veiculos.ve01_codigo
                          ELSE veiculos.ve01_codigoant
                      END AS codVeiculo,
                      veiculos.ve01_codunidadesub,
                      tipoveiculos.si04_tipoveiculo AS tpVeiculo,
                      tipoveiculos.si04_especificacao AS subTipoVeiculo,
                      substr(tipoveiculos.si04_descricao, 1, 100) AS descVeiculo,
                      veiccadmarca.ve21_descr AS marca,
                      veiccadmodelo.ve22_descr AS modelo,
                      veiculos.ve01_anofab AS ano,
                      veiculos.ve01_placa AS placa,
                      veiculos.ve01_chassi AS chassi,
                      veiculos.ve01_ranavam AS numeroRenavam,
                      veiculos.ve01_nroserie AS nroSerie,
                      tipoveiculos.si04_situacao AS situacao,
                      '01' AS tpDeslocament,
                      o41_subunidade AS subunidade,
                      z01_cgccpf AS nrodocumento
      FROM veiculos.veiculos AS veiculos
      INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
      INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
      INNER JOIN veiculos.veiccadmarca AS veiccadmarca ON (veiculos.ve01_veiccadmarca=veiccadmarca.ve21_codigo)
      INNER JOIN veiculos.veiccadmodelo AS veiccadmodelo ON (veiculos.ve01_veiccadmodelo=veiccadmodelo.ve22_codigo)
      INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
      INNER JOIN configuracoes.db_departorg AS db_departorg ON (db_depart.coddepto =db_departorg.db01_coddepto AND db01_anousu = " . db_getsession("DB_anousu") . ")
      INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
      INNER JOIN tipoveiculos ON (veiculos.ve01_codigo=tipoveiculos.si04_veiculos)
      INNER JOIN orcunidade unveic ON db01_orgao = unveic.o41_orgao AND db01_unidade = unveic.o41_unidade AND unveic.o41_anousu = " . db_getsession("DB_anousu") . "
      INNER JOIN orcorgao orveic ON o41_anousu = orveic.o40_anousu AND o41_orgao = orveic.o40_orgao

      LEFT JOIN infocomplementaresinstit ON si09_instit = db_depart.instit
      LEFT JOIN cgm ON tipoveiculos.si04_numcgm = cgm.z01_numcgm
      WHERE db_config.codigo = " . db_getsession("DB_instit") . "
          AND DATE_PART('YEAR',veiculos.ve01_dtaquis) = " . db_getsession("DB_anousu") . "
          AND DATE_PART('MONTH',veiculos.ve01_dtaquis) = " . $this->sDataFinal['5'] . $this->sDataFinal['6']. "

      UNION
      SELECT DISTINCT '10' AS tipoRegistro,
                      si09_codorgaotce AS codOrgao,
                      veiculostransf.ve81_codunidadesubatual AS codunidadesub,
                      veiculostransf.ve81_codigo codVeiculo,
                      veiculostransf.ve81_codunidadesubatual AS ve01_codunidadesub,
                      tipoveiculos.si04_tipoveiculo AS tpVeiculo,
                      tipoveiculos.si04_especificacao AS subTipoVeiculo,
                      substr(tipoveiculos.si04_descricao, 1, 100) AS descVeiculo,
                      veiccadmarca.ve21_descr AS marca,
                      veiccadmodelo.ve22_descr AS modelo,
                      veiculos.ve01_anofab AS ano,
                      veiculos.ve01_placa AS placa,
                      veiculos.ve01_chassi AS chassi,
                      veiculos.ve01_ranavam AS numeroRenavam,
                      veiculos.ve01_nroserie AS nroSerie,
                      tipoveiculos.si04_situacao AS situacao,
                      '01' AS tpDeslocament,
                      o41_subunidade AS subunidade,
                      z01_cgccpf AS nrodocumento
      FROM veiculos.veiculos AS veiculos
      INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
      INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
      INNER JOIN veiculos.veiccadmarca AS veiccadmarca ON (veiculos.ve01_veiccadmarca=veiccadmarca.ve21_codigo)
      INNER JOIN veiculos.veiccadmodelo AS veiccadmodelo ON (veiculos.ve01_veiccadmodelo=veiccadmodelo.ve22_codigo)
      INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
      INNER JOIN configuracoes.db_departorg AS db_departorg ON (db_depart.coddepto =db_departorg.db01_coddepto)
      INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
      INNER JOIN tipoveiculos ON (veiculos.ve01_codigo=tipoveiculos.si04_veiculos)
      INNER JOIN orcunidade unveic ON db01_orgao = unveic.o41_orgao AND db01_unidade = unveic.o41_unidade AND unveic.o41_anousu = " . db_getsession("DB_anousu") . "
      INNER JOIN veicbaixa on veicbaixa.ve04_veiculo = veiculos.ve01_codigo
      INNER JOIN(select ve81_codigo, max(ve81_transferencia) ve81_transferencia, ve81_codunidadesubatual
                      from veiculostransferencia
                        group by ve81_codigo, ve81_codunidadesubatual
                          order by ve81_codigo
                  ) veiculostransf on veiculostransf.ve81_codigo = veiculos.ve01_codigo
      INNER JOIN transferenciaveiculos ON transferenciaveiculos.ve80_sequencial = veiculostransf.ve81_transferencia
      INNER JOIN orcorgao orveic ON o41_anousu = orveic.o40_anousu
      AND o41_orgao = orveic.o40_orgao
      LEFT JOIN infocomplementaresinstit ON si09_instit = db_depart.instit
      LEFT JOIN cgm ON tipoveiculos.si04_numcgm = cgm.z01_numcgm
      WHERE db_config.codigo = " . db_getsession("DB_instit") . "
          AND veicbaixa.ve04_veiccadtipobaixa = 7
          AND DATE_PART('YEAR',veicbaixa.ve04_data) = " . db_getsession("DB_anousu") . "
          AND DATE_PART('MONTH',veicbaixa.ve04_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'];

        $rsResult10 = db_query($sSql);

        if (pg_num_rows($rsResult10) > 0) {
            for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

                $clcvc10 = new cl_cvc102020();
                $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

                if ($oDados10->subunidade == 1) {
                    $oDados10->codunidadesub .= str_pad($oDados10->subunidade, 3, "0", STR_PAD_LEFT);
                }

                $sSqlBaixa = "
             select ve04_codigo
              from veicbaixa
                where ve04_veiculo = '{$oDados10->codveiculo}'
                  and ve04_veiccadtipobaixa = 7 and to_char(ve04_data,'MM') = '" . $this->sDataFinal['5'] . $this->sDataFinal['6']."'";

                $sSqlVerifica = "select si146_sequencial from cvc102020 where si146_codveiculo = '{$oDados10->codveiculo}'
        and si146_mes <= " . $this->sDataFinal['5'] . $this->sDataFinal['6'];
                $sSqlVerifica .= " union select si146_sequencial from cvc102015 where si146_codveiculo = '{$oDados10->codveiculo}'";
                $sSqlVerifica .= " union select si146_sequencial from cvc102014 where si146_codveiculo = '{$oDados10->codveiculo}'";

                $sSqlNaoRepete = "
          select * from cvc102020 where si146_codveiculo = '{$oDados10->codveiculo}' and si146_codunidadesub = '{$oDados10->ve01_codunidadesub}'
        ";
                $rsVerifica = db_query($sSqlNaoRepete);
                if (pg_num_rows($rsVerifica) > 0) {
                    continue;
                }

                $rsResultVerifica = db_query($sSqlVerifica);
                $rsResultVerificaBaixa = db_query($sSqlBaixa);

                if (pg_num_rows($rsResultVerificaBaixa) > 0) {
                    if (!empty($oDados10->nrodocumento)) {
                        if (strlen($oDados10->nrodocumento) == 11) {
                            $tipodocumento = 1;
                        } elseif (strlen($oDados10->nrodocumento) == 14) {
                            $tipodocumento = 2;
                        }
                        $nrodocumento = $oDados10->nrodocumento;
                    } else {
                        $tipodocumento = NULL;
                        $nrodocumento = ' ';
                    }

                    $clcvc10->si146_tiporegistro = 10;
                    $clcvc10->si146_codorgao = $oDados10->codorgao;
                    $clcvc10->si146_codunidadesub = $oDados10->ve01_codunidadesub != '' || $oDados10->ve01_codunidadesub != 0 ? $oDados10->ve01_codunidadesub : $oDados10->codunidadesub;
                    $clcvc10->si146_codveiculo = $oDados10->codveiculo;
                    $clcvc10->si146_tpveiculo = $oDados10->tpveiculo;
                    $clcvc10->si146_subtipoveiculo = $oDados10->subtipoveiculo;
                    $clcvc10->si146_descveiculo = $this->removeCaracteres($oDados10->descveiculo);
                    $clcvc10->si146_marca = $this->removeCaracteres($oDados10->marca);
                    $clcvc10->si146_modelo = $this->removeCaracteres($oDados10->modelo);
                    $clcvc10->si146_ano = $oDados10->ano;
                    $clcvc10->si146_placa = $oDados10->tpveiculo == 3 ? $oDados10->placa : ' ';
                    $clcvc10->si146_chassi = $oDados10->tpveiculo == 3 ? $oDados10->chassi : ' ';
                    if($oDados10->tpveiculo == 3) {
                        $clcvc10->si146_numerorenavam = $oDados10->numerorenavam;
                    } else{
                        $clcvc10->si146_numerorenavam = '';
                    }
                    $clcvc10->si146_nroserie = $oDados10->nroserie;
                    $clcvc10->si146_situacao = $oDados10->situacao;
                    $clcvc10->si146_tipodocumento = $tipodocumento;
                    $clcvc10->si146_nrodocumento = $nrodocumento;
                    $clcvc10->si146_tpdeslocamento = $oDados10->tpdeslocament;
                    $clcvc10->si146_instit = db_getsession("DB_instit");
                    $clcvc10->si146_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

                    $clcvc10->incluir(null);
                    if ($clcvc10->erro_status == 0) {
                        throw new Exception($clcvc10->erro_msg);
                    }

                    continue;
                }

                if (pg_num_rows($rsResultVerifica) > 0) {
                    continue ;
                }

                if (!empty($oDados10->nrodocumento)) {
                    if (strlen($oDados10->nrodocumento) == 11) {
                        $tipodocumento = 1;
                    } elseif (strlen($oDados10->nrodocumento) == 14) {
                        $tipodocumento = 2;
                    }
                    $nrodocumento = $oDados10->nrodocumento;
                } else {
                    $tipodocumento = NULL;
                    $nrodocumento = ' ';
                }

                $clcvc10->si146_tiporegistro = 10;
                $clcvc10->si146_codorgao = $oDados10->codorgao;
                $clcvc10->si146_codunidadesub = $oDados10->ve01_codunidadesub != '' || $oDados10->ve01_codunidadesub != 0 ? $oDados10->ve01_codunidadesub : $oDados10->codunidadesub;
                $clcvc10->si146_codveiculo = $oDados10->codveiculo;
                $clcvc10->si146_tpveiculo = $oDados10->tpveiculo;
                $clcvc10->si146_subtipoveiculo = $oDados10->subtipoveiculo;
                $clcvc10->si146_descveiculo = $this->removeCaracteres($oDados10->descveiculo);
                $clcvc10->si146_marca = $oDados10->marca;
                $clcvc10->si146_modelo = $oDados10->modelo;
                $clcvc10->si146_ano = $oDados10->ano;
                $clcvc10->si146_placa = $oDados10->tpveiculo == 3 ? $oDados10->placa : ' ';
                $clcvc10->si146_chassi = $oDados10->tpveiculo == 3 ? $oDados10->chassi : ' ';
                if($oDados10->tpveiculo == 3) {
                    $clcvc10->si146_numerorenavam = $oDados10->numerorenavam;
                } else{
                    $clcvc10->si146_numerorenavam = '';
                }
                $clcvc10->si146_nroserie = $oDados10->nroserie;
                $clcvc10->si146_situacao = $oDados10->situacao;
                $clcvc10->si146_tipodocumento = $tipodocumento;
                $clcvc10->si146_nrodocumento = $nrodocumento;
                $clcvc10->si146_tpdeslocamento = $oDados10->tpdeslocament;
                $clcvc10->si146_instit = db_getsession("DB_instit");
                $clcvc10->si146_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

                $clcvc10->incluir(null);
                if ($clcvc10->erro_status == 0) {
                    throw new Exception($clcvc10->erro_msg);
                }
            }
        }

        /*
         * Registro 20
         */
        $sSql = "SELECT DISTINCT  * FROM (
                    SELECT DISTINCT
                      '20' AS tipoRegistro,
                      si09_codorgaotce AS codOrgao,
                      CASE
                          WHEN (unveic.o41_codtri::INT != 0
                                AND orveic.o40_codtri::INT = 0) THEN lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_codtri,3,0)
                          WHEN (unveic.o41_codtri::INT = 0
                                AND orveic.o40_codtri::INT != 0) THEN lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_unidade,3,0)
                          WHEN (unveic.o41_codtri::INT != 0
                                AND orveic.o40_codtri::INT != 0) THEN lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_codtri,3,0)
                          ELSE lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_unidade,3,0)
                      END AS codunidadesub,
                     case when veiculos.ve01_codigoant is null or veiculos.ve01_codigoant = 0 then veiculos.ve01_codigo else veiculos.ve01_codigoant end AS codVeiculo,
                     veiculos.ve01_codunidadesub,
                     ve62_origemgasto AS origemGasto,
                     CASE
                  WHEN (unemp.o41_codtri::INT != 0
                      AND orcemp.o40_codtri::INT = 0) THEN lpad(o58_orgao,2,0)||lpad(unemp.o41_codtri,3,0)
                      WHEN (unemp.o41_codtri::INT = 0
                      AND orcemp.o40_codtri::INT != 0) THEN lpad(orcemp.o40_codtri,2,0)||lpad(o58_unidade,3,0)
                      WHEN (unemp.o41_codtri::INT != 0
                      AND orcemp.o40_codtri::INT != 0) THEN lpad(orcemp.o40_codtri,2,0)||lpad(unemp.o41_codtri,3,0)
                  ELSE lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0)
                  END AS codUnidadeSubEmpenho,
                     e60_codemp AS nroEmpenho,
                     e60_emiss::VARCHAR AS dtEmpenho,
                     ve62_tipogasto::varchar AS tipoGasto,
                   sum(DISTINCT veicmanutitem.ve63_quant) AS qtdeUtilizada,
                   sum(DISTINCT veicmanutitem.ve63_quant * veicmanutitem.ve63_vlruni) AS vlGasto,
                     pc01_descrmater AS dscPecasServicos,
                     pc01_codmater as codmater,
                     ve62_atestado::varchar AS atestadoControle,
                     unveic.o41_subunidade AS subunidade,
                     DATE_PART('YEAR',veiculos.ve01_dtaquis) AS anoveiculo
                  FROM veiculos.veiculos AS veiculos
                  INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
                  INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
                  INNER JOIN veicretirada ON veiculos.ve01_codigo = veicretirada.ve60_veiculo
                  INNER JOIN configuracoes.db_depart AS db_depart ON (veicretirada.ve60_coddepto =db_depart.coddepto)
                  INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
                  INNER JOIN veiculos .veicmanut AS veicmanut ON (veiculos. ve01_codigo=veicmanut. ve62_veiculos)
                  LEFT JOIN veiculos.veicmanutitem AS veicmanutitem ON (veicmanut.ve62_codigo = veicmanutitem.ve63_veicmanut)
                  LEFT JOIN veiculos.veicmanutitempcmater as veicmanutitempcmater on ve64_veicmanutitem = ve63_codigo
                  LEFT JOIN pcmater on pc01_codmater = ve64_pcmater
                  LEFT JOIN empenho.empempenho AS empempenho ON (veicmanut.ve62_numemp = empempenho.e60_numemp)
                  LEFT JOIN orcamento.orcdotacao AS orcdotacao ON (empempenho.e60_coddot = orcdotacao.o58_coddot
                                                                    AND empempenho.e60_anousu = orcdotacao.o58_anousu)
                  LEFT JOIN db_departorg ON db01_coddepto = db_depart.coddepto
                  AND db01_anousu = " . db_getsession("DB_anousu") . "
                  LEFT JOIN orcunidade unveic ON db01_orgao = unveic.o41_orgao
                  AND db01_unidade = unveic.o41_unidade
                  AND unveic.o41_anousu = db01_anousu
                  LEFT JOIN orcorgao orveic ON o41_anousu = orveic.o40_anousu
                  AND o41_orgao = orveic.o40_orgao
                  LEFT JOIN orcunidade unemp ON orcdotacao.o58_orgao = unemp.o41_orgao
                  AND orcdotacao.o58_unidade = unemp.o41_unidade
                  AND unemp.o41_anousu = orcdotacao.o58_anousu
                  LEFT JOIN orcorgao orcemp ON unemp.o41_anousu = orcemp.o40_anousu
                  AND unemp.o41_orgao = orcemp.o40_orgao
                  INNER JOIN infocomplementaresinstit ON si09_instit = db_config.codigo
                  WHERE db_config.codigo = " . db_getsession("DB_instit") . "
                  AND DATE_PART('YEAR',veicmanut.ve62_dtmanut) = " . db_getsession("DB_anousu") . "
                  AND DATE_PART('MONTH',veicmanut.ve62_dtmanut) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                  GROUP BY veiculos.ve01_codigo,
                           ve62_atestado,
                           o58_orgao,
                           unemp.o41_codtri,
                           orcemp.o40_codtri,
                           orcemp.o40_orgao,
                           unemp.o41_unidade,
                           unveic.o41_codtri,
                           orveic.o40_codtri,
                           orveic.o40_orgao,
                           unveic.o41_unidade,
                           si09_codorgaotce,
                           o58_unidade,
                           db_config.db21_tipoinstit,
                           empempenho.e60_codemp,
                           empempenho.e60_emiss,
                           db_depart.coddepto,
                           unveic.o41_subunidade,
                           ve62_origemgasto,
                           veicmanut.ve62_tipogasto,
                           veicmanut.ve62_descr,
                           pc01_codmater,
                           pc01_descrmater
                    UNION
                    SELECT '20' AS tipoRegistro,
                    si09_codorgaotce AS codOrgao,
                    CASE WHEN (unveic.o41_codtri::INT != 0 AND orveic.o40_codtri::INT = 0) THEN lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_codtri,3,0)
                    WHEN (unveic.o41_codtri::INT = 0 AND orveic.o40_codtri::INT != 0) THEN lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_unidade,3,0)
                    WHEN (unveic.o41_codtri::INT != 0 AND orveic.o40_codtri::INT != 0) THEN lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_codtri,3,0)
                        ELSE lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_unidade,3,0) END AS codunidadesub,
                    case when veiculos.ve01_codigoant is null or veiculos.ve01_codigoant = 0 then veiculos.ve01_codigo else veiculos.ve01_codigoant end AS codVeiculo,
                    veiculos.ve01_codunidadesub,
                    2 AS origemGasto,
                    CASE WHEN (unemp.o41_codtri::INT != 0 AND orcemp.o40_codtri::INT = 0) THEN lpad(o58_orgao,2,0)||lpad(unemp.o41_codtri,3,0)
                    WHEN (unemp.o41_codtri::INT = 0 AND orcemp.o40_codtri::INT != 0) THEN lpad(orcemp.o40_codtri,2,0)||lpad(o58_unidade,3,0)
                    WHEN (unemp.o41_codtri::INT != 0 AND orcemp.o40_codtri::INT != 0) THEN lpad(orcemp.o40_codtri,2,0)||lpad(unemp.o41_codtri,3,0)
                        ELSE lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) END AS codUnidadeSubEmpenho,
                    e60_codemp AS nroEmpenho,
                    e60_emiss::VARCHAR  AS dtEmpenho,
                    (CASE veicabast.ve70_veiculoscomb
                    WHEN 1 THEN '02'
                    WHEN 2 THEN '01'
                    WHEN 3 THEN '04'
                    WHEN 4 THEN '03'
                    ELSE '02'
                    END) AS tipoGasto,
                    SUM(DISTINCT ve70_litros) AS qtdeUtilizada,
                    SUM(DISTINCT ve70_valor) AS vlGasto,
                    NULL AS codmater,
                    NULL AS dscPecasServicos,
                    (CASE empveiculos.si05_atestado
                    WHEN 't' THEN '2'
                    ELSE '1'
                    END) AS atestadoControle,
                    unveic.o41_subunidade AS subunidade,
                    DATE_PART('YEAR',veiculos.ve01_dtaquis) AS anoveiculo
                    FROM veiculos.veiculos AS veiculos
                    INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
                    INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
                    INNER JOIN veicretirada ON veiculos.ve01_codigo = veicretirada.ve60_veiculo
                    INNER JOIN configuracoes.db_depart AS db_depart ON (veicretirada.ve60_coddepto =db_depart.coddepto)
                    INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
                    INNER JOIN veiculos.veicabast AS veicabast ON (veiculos.ve01_codigo=veicabast.ve70_veiculos)
                    LEFT JOIN empveiculos ON (veicabast.ve70_codigo = empveiculos.si05_codabast)
                    LEFT JOIN empenho.empempenho AS empempenho ON (empveiculos.si05_numemp = empempenho.e60_numemp)
                    LEFT JOIN orcamento.orcdotacao AS orcdotacao ON (empempenho.e60_coddot = orcdotacao.o58_coddot
                    AND empempenho.e60_anousu = orcdotacao.o58_anousu)
                    LEFt JOIN db_departorg ON db01_coddepto = db_depart.coddepto AND db01_anousu = " . db_getsession("DB_anousu") . "
                    LEFT JOIN orcunidade unveic ON db01_orgao = unveic.o41_orgao AND db01_unidade = unveic.o41_unidade AND unveic.o41_anousu = db01_anousu
                    LEFt JOIN orcorgao orveic ON o41_anousu = orveic.o40_anousu AND o41_orgao = orveic.o40_orgao
                    LEFT JOIN orcunidade unemp ON orcdotacao.o58_orgao = unemp.o41_orgao AND orcdotacao.o58_unidade = unemp.o41_unidade AND unemp.o41_anousu = orcdotacao.o58_anousu
                    LEFT JOIN orcorgao orcemp ON unemp.o41_anousu = orcemp.o40_anousu AND unemp.o41_orgao = orcemp.o40_orgao
                    LEFT JOIN infocomplementaresinstit ON si09_instit = db_config.codigo
                    WHERE db_config.codigo =" . db_getsession("DB_instit") . "
                    AND DATE_PART('YEAR' ,veicabast.ve70_dtabast) = " . db_getsession("DB_anousu") . "
                    AND DATE_PART('MONTH',veicabast.ve70_dtabast) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
                    GROUP BY infocomplementaresinstit.si09_codorgaotce,
                             unveic.o41_codtri,
		                     orveic.o40_codtri,
		                     orveic.o40_orgao,
		                     unveic.o41_unidade,
		                     veiculos.ve01_codigoant,
		                     veiculos.ve01_codigo,
		                     unemp.o41_codtri,
		                     orcemp.o40_codtri,
		                     orcdotacao.o58_orgao,
		                     orcdotacao.o58_unidade,
		                     empempenho.e60_codemp,
		                     empempenho.e60_emiss,
		                     veicabast.ve70_veiculoscomb,
		                     empveiculos.si05_atestado,
		                     unveic.o41_subunidade,
		                     codmater) as teste";

        $rsResult20 = db_query($sSql) or die(pg_last_error());
        /**
         * registro 20
         */
        $aDadosAgrupados20 = array();
        for ($iCont20 = 0; $iCont20 < pg_num_rows($rsResult20); $iCont20++) {

            $oResult20 = db_utils::fieldsMemory($rsResult20, $iCont20);

            $sHash20 = $oResult20->codveiculo . $oResult20->codmater . $oResult20->nroempenho . $oResult20->dtempenho . $oResult20->tipogasto . $oResult20->atestadocontrole;

            if (!isset($aDadosAgrupados20[$sHash20])) {

                $oDados20 = new stdClass();

                if ($oResult20->subunidade != 0 ||$oResult20->subunidade = null) {
                    /*
                    * O campo codUnidadeSubEmpenho torna-se de
                    * preenchimento obrigatório se a origem do gasto foi
                    * através de abastecimento em posto/ Comércio ( origemGasto = 2 ).
                    */
                    if ($oResult20->origemgasto == 2) {
                        $oResult20->codunidadesubempenho .= str_pad($oResult20->subunidade, 3, "0", STR_PAD_LEFT);
                    } else {
                        $oResult20->codunidadesubempenho = "";
                    }
                    if ($oResult20->anoveiculo >= 2014) {
                        $oResult20->codunidadesub .= str_pad($oResult20->subunidade, 3, "0", STR_PAD_LEFT);
                    }
                }

                $oDados20->si147_tiporegistro = 20;
                $oDados20->si147_codorgao = $oResult20->codorgao;
                $oDados20->si147_codunidadesub = $oResult20->ve01_codunidadesub != '' || $oResult20->ve01_codunidadesub != 0 ? $oResult20->ve01_codunidadesub : $oResult20->codunidadesub;
                $oDados20->si147_codveiculo = $oResult20->codveiculo;
                $oDados20->si147_origemgasto = $oResult20->origemgasto;
                $oDados20->si147_codunidadesubempenho = $oResult20->codunidadesubempenho;
                $oDados20->si147_nroempenho = $oResult20->nroempenho;
                $oDados20->si147_dtempenho = $oResult20->dtempenho;
                $oDados20->si147_tipogasto = $oResult20->tipogasto;
                $oDados20->si147_qtdeutilizada = $oResult20->qtdeutilizada;
                $oDados20->si147_vlgasto = $oResult20->vlgasto;
                if(in_array( $oResult20->tipogasto , array(8,9,99))){
                    $oDados20->si147_dscpecasservicos = $this->removeCaracteres(substr($oResult20->dscpecasservicos, 0, 49));
                }else{
                    $oDados20->si147_dscpecasservicos = " ";
                }
                $oDados20->si147_atestadocontrole = $oResult20->atestadocontrole;
                $oDados20->si147_instit = db_getsession("DB_instit");
                $oDados20->si147_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

                /**
                 *          MARCAÇÃO INICIAL E FINAL DO VEICULO:
                 */

                $sSqlKm = "select min(ve60_medidasaida) as km_inicial, max(ve61_medidadevol) as km_final
								  FROM veiculos.veicmanut  as veicmanut
								  inner join veicmanutretirada on ve65_veicmanut = ve62_codigo
								  inner join veicretirada on ve65_veicretirada = ve60_codigo
								  inner join veicdevolucao on ve61_veicretirada = ve60_codigo
							  WHERE veicmanut.ve62_veiculos =  $oResult20->codveiculo
							  AND  DATE_PART('YEAR',veicmanut.ve62_dtmanut)= " . db_getsession("DB_anousu") . "
							  AND DATE_PART('MONTH',veicmanut.ve62_dtmanut)=  " . $this->sDataFinal['5'] . $this->sDataFinal['6'];

                $oDadosVeiculo = pg_fetch_object(pg_query($sSqlKm));

                $oDados20->si147_marcacaoinicial = $oDadosVeiculo->km_inicial;
                $oDados20->si147_marcacaofinal = $oDadosVeiculo->km_final;

                $aDadosAgrupados20[$sHash20] = $oDados20;

            }
        }

        foreach ($aDadosAgrupados20 as $oDadosAgrupados20) {

            $clcvc20 = new cl_cvc202020();
            $clcvc20->si147_tiporegistro = 20;
            $clcvc20->si147_codorgao = $oDadosAgrupados20->si147_codorgao;
            $clcvc20->si147_codunidadesub = $oDadosAgrupados20->si147_codunidadesub;
            $clcvc20->si147_codveiculo = $oDadosAgrupados20->si147_codveiculo;
            $clcvc20->si147_origemgasto = $oDadosAgrupados20->si147_origemgasto;
            $clcvc20->si147_codunidadesubempenho = $oDadosAgrupados20->si147_codunidadesubempenho;
            $clcvc20->si147_nroempenho = $oDadosAgrupados20->si147_nroempenho;
            $clcvc20->si147_dtempenho = $oDadosAgrupados20->si147_dtempenho;
            $clcvc20->si147_tipogasto = $oDadosAgrupados20->si147_tipogasto;
            $clcvc20->si147_qtdeutilizada = $oDadosAgrupados20->si147_qtdeutilizada;
            $clcvc20->si147_vlgasto = $oDadosAgrupados20->si147_vlgasto;
            if (in_array($oDadosAgrupados20->si147_tipogasto, array(8,9,99))){
                $clcvc20->si147_dscpecasservicos = $oDadosAgrupados20->si147_dscpecasservicos;
            }else{
                $clcvc20->si147_dscpecasservicos=" ";
            }
            $clcvc20->si147_atestadocontrole = $oDadosAgrupados20->si147_atestadocontrole;
            $clcvc20->si147_marcacaoinicial = $oDadosAgrupados20->si147_marcacaoinicial;
            $clcvc20->si147_marcacaofinal = $oDadosAgrupados20->si147_marcacaofinal;
            $clcvc20->si147_instit = db_getsession("DB_instit");
            $clcvc20->si147_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

            $clcvc20->incluir(null);
            if ($clcvc20->erro_status == 0) {
                throw new Exception($clcvc20->erro_msg);
            }

        }

        /*
         * Registro 30
         */
        $sSql = " SELECT '30' AS tipoRegistro,
       si09_codorgaotce AS codOrgao,
       CASE WHEN (unveic.o41_codtri::INT != 0 AND orveic.o40_codtri::INT = 0) THEN lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_codtri,3,0)
	    WHEN (unveic.o41_codtri::INT = 0 AND orveic.o40_codtri::INT != 0) THEN lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_unidade,3,0)
	    WHEN (unveic.o41_codtri::INT != 0 AND orveic.o40_codtri::INT != 0) THEN lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_codtri,3,0)
            ELSE lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_unidade,3,0) END AS codunidadesub,
       case when veiculos.ve01_codigoant is null or veiculos.ve01_codigoant = 0 then veiculos.ve01_codigo else veiculos.ve01_codigoant end AS codVeiculo,
       veiculos.ve01_codunidadesub,
       transporteescolar.v200_escola AS nomeEstabelecimento,
       transporteescolar.v200_localidade AS localidade,
       transporteescolar.v200_diasrodados AS qtdeDiasRodados,
       transporteescolar.v200_distancia AS distanciaEstabelecimento,
       transporteescolar.v200_numpassageiros AS numeroPassageiros,
       transporteescolar.v200_turno AS turnos,
       o41_subunidade AS subunidade
		FROM veiculos.veiculos AS veiculos
		INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
		INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
		INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
		INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
		INNER JOIN transporteescolar ON ve01_codigo = v200_veiculo
		INNER JOIN db_departorg ON db01_coddepto = db_depart.coddepto AND db01_anousu = " . db_getsession("DB_anousu") . "
		INNER JOIN orcunidade unveic ON db01_orgao = unveic.o41_orgao AND db01_unidade = unveic.o41_unidade AND unveic.o41_anousu = db01_anousu
		LEFT JOIN orcorgao orveic ON o41_anousu = orveic.o40_anousu AND o41_orgao = orveic.o40_orgao
		INNER JOIN infocomplementaresinstit ON si09_instit = db_config.codigo
		WHERE v200_anousu = " . db_getsession("DB_anousu") . "
		AND v200_periodo = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . "
		AND db_config.codigo =" . db_getsession("DB_instit");

        $rsResult30 = db_query($sSql);
        /**
         * registro 30
         */

        if (pg_num_rows($rsResult30) > 0) {
            for ($iCont30 = 0; $iCont30 < pg_num_rows($rsResult30); $iCont30++) {

                $clcvc30 = new cl_cvc302020();
                $oDados30 = db_utils::fieldsMemory($rsResult30, $iCont30);

                if ($oDados30->subunidade == 1) {
                    $oDados30->codunidadesub .= str_pad($oDados30->subunidade, 3, "0", STR_PAD_LEFT);
                }

                $clcvc30->si148_tiporegistro = 30;
                $clcvc30->si148_codorgao = $oDados30->codorgao;
                $clcvc30->si148_codunidadesub = $oDados30->ve01_codunidadesub != '' || $oDados30->ve01_codunidadesub != 0 ? $oDados30->ve01_codunidadesub : $oDados30->codunidadesub;
                $clcvc30->si148_codveiculo = $oDados30->codveiculo;
                $clcvc30->si148_nomeestabelecimento = $this->removeCaracteres($oDados30->nomeestabelecimento);
                $clcvc30->si148_localidade = $this->removeCaracteres($oDados30->localidade);
                $clcvc30->si148_qtdediasrodados = $oDados30->qtdediasrodados;
                $clcvc30->si148_distanciaestabelecimento = $oDados30->distanciaestabelecimento;
                $clcvc30->si148_numeropassageiros = $oDados30->numeropassageiros;
                $clcvc30->si148_turnos = $oDados30->turnos;
                $clcvc30->si148_instit = db_getsession("DB_instit");
                $clcvc30->si148_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

                $clcvc30->incluir(null);
                if ($clcvc30->erro_status == 0) {
                    throw new Exception($clcvc30->erro_msg);
                }

            }
        }
        $sSql = "
      SELECT DISTINCT '40' AS tipoRegistro,
                si09_codorgaotce AS codOrgao,
                CASE
                    WHEN (unveic.o41_codtri::INT != 0
                          AND orveic.o40_codtri::INT = 0) THEN lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_codtri,3,0)
                    WHEN (unveic.o41_codtri::INT = 0
                          AND orveic.o40_codtri::INT != 0) THEN lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_unidade,3,0)
                    WHEN (unveic.o41_codtri::INT != 0
                          AND orveic.o40_codtri::INT != 0) THEN lpad(orveic.o40_codtri,2,0)||lpad(unveic.o41_codtri,3,0)
                    ELSE lpad(orveic.o40_orgao,2,0)||lpad(unveic.o41_unidade,3,0)
                END AS codunidadesub,
                CASE
                    WHEN veiculos.ve01_codigoant IS NULL
                         OR veiculos.ve01_codigoant = 0 THEN veiculos.ve01_codigo
                    ELSE veiculos.ve01_codigoant
                END AS codVeiculo,
                veicbaixa.ve04_veiccadtipobaixa AS tipoBaixa,
                veicbaixa.ve04_motivo AS descBaixa,
                veicbaixa.ve04_data AS dtBaixa
      FROM veiculos.veiculos AS veiculos
      INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
      INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
      INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
      INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
      LEFT JOIN veiculos.veicabast AS veicabast ON (veiculos.ve01_codigo=veicabast.ve70_veiculos)
      LEFT JOIN empveiculos ON (veicabast.ve70_codigo = empveiculos.si05_codabast)
      LEFT JOIN empenho.empempenho AS empempenho ON (empveiculos.si05_numemp = empempenho.e60_numemp)
      LEFT JOIN orcamento.orcdotacao AS orcdotacao ON (empempenho.e60_coddot = orcdotacao.o58_coddot
                                                        AND empempenho.e60_anousu = orcdotacao.o58_anousu)
      INNER JOIN veiculos.veicitensobrig AS veicitensobrig ON (veiculos.ve01_codigo=veicitensobrig.ve09_veiculos)
      INNER JOIN veiculos.veiccaditensobrig AS veiccaditensobrig ON (veicitensobrig.ve09_veiccaditensobrig=veiccaditensobrig.ve08_sequencial)
      INNER JOIN db_departorg ON db01_coddepto = db_depart.coddepto
      INNER JOIN veiculos.veicbaixa AS veicbaixa ON (veicitensobrig.ve09_veiculos=veicbaixa.ve04_veiculo)
      AND db01_anousu = " . db_getsession("DB_anousu") . "
      INNER JOIN orcunidade unveic ON db01_orgao = unveic.o41_orgao
      AND db01_unidade = unveic.o41_unidade
      AND unveic.o41_anousu = db01_anousu
      INNER JOIN orcorgao orveic ON o41_anousu = orveic.o40_anousu
      AND o41_orgao = orveic.o40_orgao
      LEFT JOIN infocomplementaresinstit ON si09_instit = db_config.codigo
      WHERE db_config.codigo =  " . db_getsession("DB_instit") . "
          AND DATE_PART('YEAR',veicbaixa.ve04_data) = " . db_getsession("DB_anousu") . "
          AND DATE_PART('MONTH',veicbaixa.ve04_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6']."
          AND veicbaixa.ve04_veiccadtipobaixa <> 7
      UNION
      SELECT DISTINCT '40' AS tipoRegistro,
                      si09_codorgaotce AS codOrgao,
                      veiculostransferencia.ve81_codunidadesubant AS codunidadesub,
                      CASE
                          WHEN veiculos.ve01_codigoant IS NULL
                               OR veiculos.ve01_codigoant = 0 THEN veiculos.ve01_codigo
                          ELSE veiculos.ve01_codigoant
                      END AS codVeiculo,
                      veicbaixa.ve04_veiccadtipobaixa AS tipoBaixa,
                      veicbaixa.ve04_motivo AS descBaixa,
                      veicbaixa.ve04_data AS dtBaixa
      FROM veiculos.veiculos AS veiculos
      INNER JOIN veiculos.veiccentral AS veiccentral ON (veiculos.ve01_codigo =veiccentral.ve40_veiculos)
      INNER JOIN veiculos.veiccadcentral AS veiccadcentral ON (veiccentral.ve40_veiccadcentral =veiccadcentral.ve36_sequencial)
      INNER JOIN configuracoes.db_depart AS db_depart ON (veiccadcentral.ve36_coddepto =db_depart.coddepto)
      INNER JOIN configuracoes.db_config AS db_config ON (db_depart.instit=db_config.codigo)
      LEFT JOIN veiculos.veicabast AS veicabast ON (veiculos.ve01_codigo=veicabast.ve70_veiculos)
      LEFT JOIN empveiculos ON (veicabast.ve70_codigo = empveiculos.si05_codabast)
      LEFT JOIN empenho.empempenho AS empempenho ON (empveiculos.si05_numemp = empempenho.e60_numemp)
      LEFT JOIN orcamento.orcdotacao AS orcdotacao ON (empempenho.e60_coddot = orcdotacao.o58_coddot
                                                        AND empempenho.e60_anousu = orcdotacao.o58_anousu)
      INNER JOIN veiculos.veicitensobrig AS veicitensobrig ON (veiculos.ve01_codigo=veicitensobrig.ve09_veiculos)
      INNER JOIN veiculos.veiccaditensobrig AS veiccaditensobrig ON (veicitensobrig.ve09_veiccaditensobrig=veiccaditensobrig.ve08_sequencial)
      INNER JOIN db_departorg ON db01_coddepto = db_depart.coddepto
      INNER JOIN veiculos.veicbaixa AS veicbaixa ON (veicitensobrig.ve09_veiculos=veicbaixa.ve04_veiculo)
      AND db01_anousu = " . db_getsession("DB_anousu") . "
      LEFT JOIN veiculostransferencia on ve81_codigo=ve01_codigo
      INNER JOIN orcunidade unveic ON db01_orgao = unveic.o41_orgao
      AND db01_unidade = unveic.o41_unidade
      AND unveic.o41_anousu = db01_anousu
      INNER JOIN orcorgao orveic ON o41_anousu = orveic.o40_anousu
      AND o41_orgao = orveic.o40_orgao
      LEFT JOIN infocomplementaresinstit ON si09_instit = db_config.codigo
      WHERE ve81_codunidadesubant is not null
          AND db_config.codigo =  " . db_getsession("DB_instit") . "
          AND DATE_PART('YEAR',veicbaixa.ve04_data) = " . db_getsession("DB_anousu") . "
          AND DATE_PART('MONTH',veicbaixa.ve04_data) = " . $this->sDataFinal['5'] . $this->sDataFinal['6'];

        $rsResult40 = db_query($sSql);

        /**
         * registro 40
         */
        if (pg_num_rows($rsResult40) > 0) {
            for ($iCont40 = 0; $iCont40 < pg_num_rows($rsResult40); $iCont40++) {

                $clcvc40 = new cl_cvc402020();
                $oDados40 = db_utils::fieldsMemory($rsResult40, $iCont40);

                if ($oDados10->subunidade == 1) {
                    $oDados30->codunidadesub .= str_pad($oDados30->subunidade, 3, "0", STR_PAD_LEFT);
                }

                $clcvc40->si149_tiporegistro = 40;
                $clcvc40->si149_codorgao = $oDados40->codorgao;
                $clcvc40->si149_codunidadesub = $oDados40->ve01_codunidadesub != '' || $oDados40->ve01_codunidadesub != 0 ? $oDados40->ve01_codunidadesub : $oDados40->codunidadesub;
                $clcvc40->si149_codveiculo = $oDados40->codveiculo;
                $clcvc40->si149_tipobaixa = $oDados40->tipobaixa;
                if($oDados40->tipobaixa == 99){
                    $clcvc40->si149_descbaixa = $this->removeCaracteres($oDados40->descbaixa);
                }else{
                    $clcvc40->si149_descbaixa = " ";
                }
                $clcvc40->si149_dtbaixa = $oDados40->dtbaixa;
                $clcvc40->si149_instit = db_getsession("DB_instit");
                $clcvc40->si149_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];


                $clcvc40->incluir(null);
                if ($clcvc40->erro_status == 0) {
                    throw new Exception($clcvc40->erro_msg);
                }
            }
        }

        db_fim_transacao();

        $oGerarCVC = new GerarCVC();
        $oGerarCVC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
        $oGerarCVC->gerarDados();

    }
}
