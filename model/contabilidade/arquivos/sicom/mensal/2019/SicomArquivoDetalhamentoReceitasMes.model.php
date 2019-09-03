<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_rec102019_classe.php");
require_once("classes/db_rec112019_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2019/GerarREC.model.php");

/**
 * detalhamento das receitas do mês Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoDetalhamentoReceitasMes extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 149;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'REC';

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

    $aElementos[10] = array(
      "tipoRegistro",
      "codReceita",
      "codOrgao",
      "identificadorDeducao",
      "rubrica",
      "especificacao",
      "vlArrecadado",
      "vlAcumuladoMesAnt"
    );
    $aElementos[11] = array(
      "tipoRegistro",
      "codReceita",
      "codFonte",
      "vlArrecadadoFonte",
      "vlAcumuladoFonteMesAnt"
    );

    return $aElementos;
  }

  /**
   * selecionar os dados das receitas do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {


    /**
     * selecionar arquivo xml com dados das receitas
     */
    $sSql = "SELECT * FROM db_config ";
    $sSql .= "	WHERE prefeitura = 't'";

    $rsInst = db_query($sSql);
    $sCnpj = db_utils::fieldsMemory($rsInst, 0)->cgc;
    $sArquivo = "config/sicom/" . db_getsession("DB_anousu") . "/{$sCnpj}_sicomnaturezareceita.xml";

    $sTextoXml = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oNaturezaReceita = $oDOMDocument->getElementsByTagName('receita');


    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clrec10 = new cl_rec102019();
    $clrec11 = new cl_rec112019();

    $db_filtro = "o70_instit = " . db_getsession("DB_instit");
    $rsResult10 = db_receitasaldo(11, 1, 3, true, $db_filtro, db_getsession("DB_anousu"), $this->sDataInicial, $this->sDataFinal, false, ' * ', true, 0);
    //db_criatabela($rsResult10);

    $sSql = "select si09_codorgaotce from infocomplementaresinstit where si09_instit = " . db_getsession("DB_instit");
    $rsResult = db_query($sSql);
    $sCodOrgaoTce = db_utils::fieldsMemory($rsResult, 0)->si09_codorgaotce;

    /**
     * exlcuir informacoes do mes selecionado
     */
    db_inicio_transacao();

    $result = $clrec11->sql_record($clrec11->sql_query(null, "*", null, "si26_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6']) . " and si26_instit = " . db_getsession("DB_instit"));
    if (pg_num_rows($result) > 0) {
      $clrec11->excluir(null, "si26_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si26_instit = " . db_getsession("DB_instit"));
      if ($clrec11->erro_status == 0) {
        throw new Exception($clrec11->erro_msg);
      }
    }

    $result = $clrec10->sql_record($clrec10->sql_query(null, "*", null, "si25_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si25_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clrec10->excluir(null, "si25_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si25_instit = " . db_getsession("DB_instit"));
      if ($clrec10->erro_status == 0) {
        throw new Exception($clrec10->erro_msg);
      }
    }
    /* RECEITAS QUE DEVEM SER SUBSTIUIDAS RUBRICA CADASTRADA ERRADA */
    $aRectce = array('111202', '111208', '172136', '191138', '191139', '191140',
      '191308', '191311', '191312', '191313', '193104', '193111', '193112',
      '193113', '172401', '247199', '247299', '176299', '172199', '172134',
      '160099', '112299', '176202', '242201', '242202', '222900', '193199',
      '191199', '176101', '160004', '132810', '132820', '132830', '192210',
      '242102', '247101', '172402', '172233');

    $aDadosAgrupados = array();
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $oDadosRec = db_utils::fieldsMemory($rsResult10, $iCont10);

      $sSql = "SELECT c74_codlan, c70_valor, c53_tipo, o57_fonte FROM conlancamrec
               JOIN conlancamdoc ON c71_codlan = c74_codlan
               JOIN conhistdoc ON c71_coddoc = c53_coddoc
               JOIN conlancam ON c70_codlan = c74_codlan
               JOIN orcreceita ON (c74_anousu, c74_codrec) = (o70_anousu, o70_codrec)
               JOIN orcfontes ON (o70_codfon, o70_anousu) = (o57_codfon, o57_anousu)
               WHERE c74_anousu = ". db_getsession("DB_anousu") ."
                 AND c74_data BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}'
                 AND o57_fonte = '{$oDadosRec->o57_fonte}'
               ORDER BY 4, 3";

      $sSqlValor = "SELECT sum(c70_valor) c70_valor FROM (" . $sSql . ") x WHERE (c53_tipo = 100 OR substr(o57_fonte,1,2) = '49')";

      $rsDocRec = db_query($sSql);
      $rsDocRecVlr = db_query($sSqlValor);
      
      $oCodDoc = db_utils::fieldsMemory($rsDocRec, 0);
      $oCodDocVlr = db_utils::fieldsMemory($rsDocRecVlr, 0);
      
      if (($oCodDoc->c53_tipo == 100 && substr($oDadosRec->o57_fonte, 0, 2) != '49') || ($oCodDoc->c53_tipo == 101 && substr($oDadosRec->o57_fonte, 0, 2) == '49')) {

      if ($oDadosRec->o70_codigo != 0 && $oDadosRec->saldo_arrecadado) {


        $sNaturezaReceita = substr($oDadosRec->o57_fonte, 1, 8);
        foreach ($oNaturezaReceita as $oNatureza) {

          if ($oNatureza->getAttribute('instituicao') == db_getsession("DB_instit")
            && $oNatureza->getAttribute('receitaEcidade') == $sNaturezaReceita
          ) {
            $sNaturezaReceita = $oNatureza->getAttribute('receitaSicom');
            break;

          }

        }

        if (substr($oDadosRec->o57_fonte, 1, 8) == $sNaturezaReceita) {

          if (in_array(substr($oDadosRec->o57_fonte, 1, 6), $aRectce)) {
            $sNaturezaReceita = substr($oDadosRec->o57_fonte, 1, 6) . "00";
          } else if (substr($oDadosRec->o57_fonte, 0, 2) == '49') {
            $sNaturezaReceita = substr($oDadosRec->o57_fonte, 3, 8);
          } else {
            $sNaturezaReceita = substr($oDadosRec->o57_fonte, 1, 8);
          }

        }
        $iIdentDeducao = (substr($oDadosRec->o57_fonte, 0, 2) == 49) ? substr($oDadosRec->o57_fonte, 1, 2) : "0";
        $sHash10 = $iIdentDeducao . $sNaturezaReceita . substr($oDadosRec->o70_concarpeculiar, -2);


        if (!isset($aDadosAgrupados[$sHash10])) {

          $oDados10 = new stdClass();
          $oDados10->si25_tiporegistro = 10;
          $oDados10->si25_codreceita = $oDadosRec->o70_codrec;
          $oDados10->si25_codorgao = $sCodOrgaoTce;
          $oDados10->si25_ededucaodereceita = $iIdentDeducao != '0' ? 1 : 2;
          $oDados10->si25_identificadordeducao = $iIdentDeducao;
          $oDados10->si25_naturezareceita = $sNaturezaReceita;
          $oDados10->si25_vlarrecadado = 0;
          $oDados10->si25_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $oDados10->Reg11 = array();

          $aDadosAgrupados[$sHash10] = $oDados10;

        }
          $aDadosAgrupados[$sHash10]->si25_vlarrecadado += $oCodDocVlr->c70_valor;
          
        /**
         * agrupar registro 11
         */
        $sHash11 = $oDadosRec->o70_codigo;
        if (!isset($aDadosAgrupados[$sHash10]->Reg11[$sHash11])) {
            
          $sSql = "SELECT taborc.k02_estorc,
                          CASE
                              WHEN substr(taborc.k02_estorc,2,4) IN ('1218','7218') THEN cgm.z01_cgccpf
                              ELSE ''
                          END AS z01_cgccpf,
                          o70_codrec,
                          o15_codtri,
                          SUM(CASE
                                  WHEN c53_tipo = 100 THEN ROUND(c70_valor,2)::FLOAT8
                                  WHEN c53_tipo = 101 THEN ROUND(c70_valor*-1,2)::FLOAT8
                                  ELSE 0::FLOAT8
                              END) AS c70_valor,
                          c206_nroconvenio,
                          c206_dataassinatura,
                          c53_tipo
                   FROM conlancamrec
                   INNER JOIN orcreceita ON (c74_anousu, c74_codrec) = (o70_anousu, o70_codrec)
                   INNER JOIN orctiporec ON o70_codigo = o15_codigo
                   LEFT JOIN conlancamcorrente on c86_conlancam = c74_codlan
                   LEFT JOIN corplacaixa on (k82_id, k82_data, k82_autent) = (c86_id, c86_data, c86_autent)
                   LEFT JOIN placaixarec on k81_seqpla = k82_seqpla
                   LEFT JOIN convconvenios on c206_sequencial = k81_convenio
                   LEFT JOIN taborc ON (k02_anousu, k02_codrec) = (o70_anousu, o70_codrec)
                         AND k02_codigo = (SELECT max(k02_codigo) FROM taborc tab
                                           WHERE (tab.k02_codrec, tab.k02_anousu) = (taborc.k02_codrec, taborc.k02_anousu))
                   LEFT JOIN conlancam ON c74_codlan = c70_codlan
                   LEFT JOIN conlancamcgm ON c76_codlan = c70_codlan
                   INNER JOIN conlancamdoc ON c71_codlan = c70_codlan
                   INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
                   LEFT JOIN cgm ON k81_numcgm = cgm.z01_numcgm
                   WHERE o15_codigo = " . $oDadosRec->o70_codigo . "
                     AND o70_instit = " . db_getsession('DB_instit') . "
                     AND (CASE
                             WHEN substr(taborc.k02_estorc,1,2) = '49'
                                 THEN substr(taborc.k02_estorc,2,10) = '". substr($oDadosRec->o57_fonte,1,10)."'
                             ELSE substr(taborc.k02_estorc,2,8) = '". substr($oDadosRec->o57_fonte,1,8)."'
                          END)
                     AND conlancamrec.c74_data BETWEEN '{$this->sDataInicial}' AND '{$this->sDataFinal}'
                   GROUP BY 1,2,3,4,c53_tipo,c70_valor,c206_nroconvenio,c206_dataassinatura
                   ORDER BY 1,4,3";

          $result = db_query($sSql);

          $aDadosCgm11 = array();

          for ($iContCgm = 0; $iContCgm < pg_num_rows($result); $iContCgm++){

          $oCodFontRecursos = db_utils::fieldsMemory($result, $iContCgm);
          $sHashCgm = $oCodFontRecursos->z01_cgccpf.$oCodFontRecursos->c206_nroconvenio.$oCodFontRecursos->c206_dataassinatura;

          if (!isset($aDadosCgm11[$sHashCgm])){

          $oDados11 = new stdClass();
          $oDados11->si26_tiporegistro = 11;
          $oDados11->si26_codreceita = $oCodFontRecursos->o70_codrec;
          $oDados11->si26_codfontrecursos = $oCodFontRecursos->o15_codtri;
          if(strlen($oCodFontRecursos->z01_cgccpf) == 11){
              $oDados11->si26_tipodocumento = 1;
          } elseif (strlen($oCodFontRecursos->z01_cgccpf) == 14){
              $oDados11->si26_tipodocumento = 2;
          }else{
              $oDados11->si26_tipodocumento = "";
          }
          $oDados11->si26_cnpjorgaocontribuinte = $oCodFontRecursos->z01_cgccpf;
          $oDados11->si26_nroconvenio = $oCodFontRecursos->c206_nroconvenio;
          $oDados11->si26_dataassinatura = $oCodFontRecursos->c206_dataassinatura;
          $oDados11->si26_vlarrecadadofonte = 0;
          $oDados11->si26_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

          $aDadosCgm11[$sHashCgm] = $oDados11;
          }
           if ($oCodFontRecursos->c53_tipo == 100 || substr($oCodFontRecursos->k02_estorc, 0, 2) == '49') {
             $aDadosCgm11[$sHashCgm]->si26_vlarrecadadofonte += $oCodFontRecursos->c70_valor;
           }
              
          }
          $aDadosAgrupados[$sHash10]->Reg11[$sHash11] = $aDadosCgm11;
        }
       }
      }

    }

    /*
     * Alteração das fontes de receitas, para considerar os novos estruturais disponibilizados pelo TCE para 2019!
     * */

    $aRectceSaudEduc = array('11120111', '11180111', '11130311', '11130341', '11180141', '11180231', '11180241', '17180121', '17180151', '17180611',
      '17280111', '17280121', '17280131', '11120112', '11180112', '11180142', '11180232', '19130800', '11180114', '11180144',
      '11180234', '19310400', '11180113', '11180143', '11180233');

    foreach ($aDadosAgrupados as $oDados10) {

      $clrec10 = new cl_rec102019();
      $clrec10->si25_tiporegistro = $oDados10->si25_tiporegistro;
      $clrec10->si25_codreceita = $oDados10->si25_codreceita;
      $clrec10->si25_codorgao = $oDados10->si25_codorgao;
      $clrec10->si25_ededucaodereceita = $oDados10->si25_ededucaodereceita;
      $clrec10->si25_identificadordeducao = $oDados10->si25_identificadordeducao;
      $clrec10->si25_naturezareceita = $oDados10->si25_naturezareceita;
      $clrec10->si25_vlarrecadado = abs($oDados10->si25_vlarrecadado);
      $clrec10->si25_mes = $oDados10->si25_mes;
      $clrec10->si25_instit = db_getsession("DB_instit");

      $clrec10->incluir(null);
      if ($clrec10->erro_status == 0) {
        throw new Exception($clrec10->erro_msg);
      }
      foreach ($oDados10->Reg11 as $aDados11) {
        foreach ($aDados11 as $oDados11) {
          if (in_array($oDados10->si25_naturezareceita, $aRectceSaudEduc) &&
            ($oDados10->si25_identificadordeducao == 0 || $oDados10->si25_identificadordeducao == '91' || $oDados10->si25_identificadordeducao == '') &&
            ($oDados11->si26_codfontrecursos != '101') && ($oDados11->si26_codfontrecursos != '102')
          ) {

            $clrec11 = new cl_rec112019();
            $clrec11->si26_tiporegistro = $oDados11->si26_tiporegistro;
            $clrec11->si26_reg10 = $clrec10->si25_sequencial;
            $clrec11->si26_codreceita = $oDados10->si25_codreceita;
            $clrec11->si26_codfontrecursos = '100';
            $clrec11->si26_tipodocumento = $oDados11->si26_tipodocumento;
            $clrec11->si26_nrodocumento = $oDados11->si26_cnpjorgaocontribuinte;
            $clrec11->si26_nroconvenio = $oDados11->si26_nroconvenio;
            $clrec11->si26_dataassinatura = $oDados11->si26_dataassinatura;
            $clrec11->si26_vlarrecadadofonte = number_format(abs($oDados10->si25_vlarrecadado * 0.60), 2, ".", "");
            $clrec11->si26_mes = $oDados11->si26_mes;
            $clrec11->si26_instit = db_getsession("DB_instit");

            $clrec11->incluir(null);
            if ($clrec11->erro_status == 0) {
              throw new Exception($clrec11->erro_msg);
            }

            $clrec11->si26_sequencial = null;
            $clrec11->si26_codfontrecursos = '101';
            $clrec11->si26_vlarrecadadofonte = number_format(abs($oDados10->si25_vlarrecadado * 0.25), 2, ".", "");
            $clrec11->incluir(null);
            if ($clrec11->erro_status == 0) {
              throw new Exception($clrec11->erro_msg);
            }

            $clrec11->si26_sequencial = null;
            $clrec11->si26_codfontrecursos = '102';
            $clrec11->si26_vlarrecadadofonte = number_format(abs($oDados10->si25_vlarrecadado), 2, ".", "") - (number_format(abs($oDados10->si25_vlarrecadado * 0.60), 2, ".", "") + number_format(abs($oDados10->si25_vlarrecadado * 0.25), 2, ".", ""));
            $clrec11->incluir(null);
            if ($clrec11->erro_status == 0) {
              throw new Exception($clrec11->erro_msg);
            }
            break;
          } else if (!in_array($oDados10->si25_naturezareceita, $aRectceSaudEduc)
            || $oDados10->si25_identificadordeducao != 0
            || $oDados10->si25_identificadordeducao != ''
          ) {


            $clrec11 = new cl_rec112019();
            $clrec11->si26_tiporegistro = $oDados11->si26_tiporegistro;
            $clrec11->si26_reg10 = $clrec10->si25_sequencial;
            $clrec11->si26_codreceita = $oDados10->si25_codreceita;
            $clrec11->si26_codfontrecursos = $oDados11->si26_codfontrecursos;
            $clrec11->si26_tipodocumento = $oDados11->si26_tipodocumento;
            $clrec11->si26_nrodocumento = $oDados11->si26_cnpjorgaocontribuinte;
            $clrec11->si26_nroconvenio = $oDados11->si26_nroconvenio;
            $clrec11->si26_dataassinatura = $oDados11->si26_dataassinatura;
            $clrec11->si26_vlarrecadadofonte = abs($oDados11->si26_vlarrecadadofonte);
            $clrec11->si26_mes = $oDados11->si26_mes;
            $clrec11->si26_instit = db_getsession("DB_instit");

            $clrec11->incluir(null);
            if ($clrec11->erro_status == 0) {
              throw new Exception($clrec11->erro_msg);
            }

          }
        }
      }


    }

    db_fim_transacao();

    $oGerarREC = new GerarREC();
    $oGerarREC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarREC->gerarDados();

  }

}
