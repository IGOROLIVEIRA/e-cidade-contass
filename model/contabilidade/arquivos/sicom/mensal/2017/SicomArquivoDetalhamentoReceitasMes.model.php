<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_rec102017_classe.php");
require_once("classes/db_rec112017_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2017/GerarREC.model.php");

/**
 * detalhamento das receitas do m�s Sicom Acompanhamento Mensal
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
    $sArquivo = "legacy_config/sicom/" . db_getsession("DB_anousu") . "/{$sCnpj}_sicomnaturezareceita.xml";

    $sTextoXml = file_get_contents($sArquivo);
    $oDOMDocument = new DOMDocument();
    $oDOMDocument->loadXML($sTextoXml);
    $oNaturezaReceita = $oDOMDocument->getElementsByTagName('receita');


    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clrec10 = new cl_rec102017();
    $clrec11 = new cl_rec112017();

    $db_filtro = "o70_instit = " . db_getsession("DB_instit");
    $rsResult10 = db_receitasaldo(11, 1, 3, true, $db_filtro, db_getsession("DB_anousu"), $this->sDataInicial, $this->sDataFinal, false, ' * ', true, 0);
    //db_criatabela($rsResult10);
    /*$sSql   = "SELECT * FROM infocomplementaresinstit WHERE si09_tipoinstit != 2";
    $rsPref = db_query($sSql);
    if (pg_num_rows($rsPref) > 0) {
    	$rsResult10 = 0;
    }*/

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
      '242102', '199099', '247101', '172402', '172233');

    $aDadosAgrupados = array();
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $oDadosRec = db_utils::fieldsMemory($rsResult10, $iCont10);
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

          /*if (substr($oDadosRec->o57_fonte, 0, 1) == 49) {
            $sNaturezaReceita = substr($oDadosRec->o57_fonte, 1, 8);
          } else
          if (substr($oDadosRec->o57_fonte, 0, 1) == 4) {
            $sNaturezaReceita = substr($oDadosRec->o57_fonte, 0, 8);
          }*/

          $oDados10 = new stdClass();
          $oDados10->si25_tiporegistro = 10;
          $oDados10->si25_codreceita = $oDadosRec->o70_codrec;
          $oDados10->si25_codorgao = $sCodOrgaoTce;
          $oDados10->si25_ededucaodereceita = $iIdentDeducao != '0' ? 1 : 2;
          $oDados10->si25_identificadordeducao = $iIdentDeducao;//substr($oDadosRec->o70_concarpeculiar, -2);
          $oDados10->si25_naturezareceita = $sNaturezaReceita;
          $oDados10->si25_especificacao = $oDadosRec->o57_descr;
          $oDados10->si25_vlarrecadado = 0;
          $oDados10->si25_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
          $oDados10->Reg11 = array();

          $aDadosAgrupados[$sHash10] = $oDados10;

        }
        $aDadosAgrupados[$sHash10]->si25_vlarrecadado += $oDadosRec->saldo_arrecadado;

        /**
         * agrupar registro 11
         */
        $sHash11 = $oDadosRec->o70_codigo;
        if (!isset($aDadosAgrupados[$sHash10]->Reg11[$sHash11])) {


          $sSql = "select * from orctiporec where o15_codigo = " . $oDadosRec->o70_codigo;
          $result = db_query($sSql);
          $sCodFontRecursos = db_utils::fieldsMemory($result, 0)->o15_codtri;

          $oDados11 = new stdClass();
          $oDados11->si26_tiporegistro = 11;
          $oDados11->si26_codreceita = $oDadosRec->o70_codrec;
          $oDados11->si26_codfontrecursos = $sCodFontRecursos;
          $oDados11->si26_vlarrecadadofonte = 0;
          $oDados11->si26_mes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

          $aDadosAgrupados[$sHash10]->Reg11[$sHash11] = $oDados11;

        }
        $aDadosAgrupados[$sHash10]->Reg11[$sHash11]->si26_vlarrecadadofonte += $oDadosRec->saldo_arrecadado;

      }

    }
    //echo "<pre>";print_r($aDadosAgrupados);exit;
    $aRectceSaudEduc = array('11120101', '11120200', '11120431', '11120434', '11120800', '11130501', '11130502', '17210102', '17210105', '17213600',
      '17220101', '17220102', '17220104', '19110801', '19113800', '19113900', '19114000', '19130800', '19131100', '19131200',
      '19131300', '19310400', '19311100', '19311200', '19311300');
    foreach ($aDadosAgrupados as $oDados10) {

      $clrec10 = new cl_rec102017();
      $clrec10->si25_tiporegistro = $oDados10->si25_tiporegistro;
      $clrec10->si25_codreceita = $oDados10->si25_codreceita;
      $clrec10->si25_codorgao = $oDados10->si25_codorgao;
      $clrec10->si25_ededucaodereceita = $oDados10->si25_ededucaodereceita;
      $clrec10->si25_identificadordeducao = $oDados10->si25_identificadordeducao;
      $clrec10->si25_naturezareceita = $oDados10->si25_naturezareceita;
      $clrec10->si25_especificacao = $this->removeCaracteres($oDados10->si25_especificacao);
      $clrec10->si25_vlarrecadado = abs($oDados10->si25_vlarrecadado);
      $clrec10->si25_mes = $oDados10->si25_mes;
      $clrec10->si25_instit = db_getsession("DB_instit");

      $clrec10->incluir(null);
      if ($clrec10->erro_status == 0) {
        throw new Exception($clrec10->erro_msg);
      }
      foreach ($oDados10->Reg11 as $oDados11) {
        if (in_array($oDados10->si25_naturezareceita, $aRectceSaudEduc) &&
          ($oDados10->si25_identificadordeducao == 0 || $oDados10->si25_identificadordeducao == '') &&
          ($oDados11->si26_codfontrecursos != '101') && ($oDados11->si26_codfontrecursos != '102')
        ) {

          $clrec11 = new cl_rec112017();
          $clrec11->si26_tiporegistro = $oDados11->si26_tiporegistro;
          $clrec11->si26_reg10 = $clrec10->si25_sequencial;
          $clrec11->si26_codreceita = $oDados10->si25_codreceita;
          $clrec11->si26_codfontrecursos = '100';
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


          $clrec11 = new cl_rec112017();
          $clrec11->si26_tiporegistro = $oDados11->si26_tiporegistro;
          $clrec11->si26_reg10 = $clrec10->si25_sequencial;
          $clrec11->si26_codreceita = $oDados10->si25_codreceita;
          $clrec11->si26_codfontrecursos = $oDados11->si26_codfontrecursos;
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

    db_fim_transacao();

    $oGerarREC = new GerarREC();
    $oGerarREC->iMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];
    $oGerarREC->gerarDados();

  }

}
