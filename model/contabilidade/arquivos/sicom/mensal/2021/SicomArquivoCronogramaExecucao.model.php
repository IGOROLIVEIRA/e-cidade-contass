<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once("classes/db_cronem102020_classe.php");
require_once("classes/db_cronogramamesdesembolso_classe.php");
require_once("model/contabilidade/arquivos/sicom/mensal/geradores/2020/GerarCRONEM.model.php");

/**
 * gerar arquivo Cronograma de Execucao Mensal de Desembolso Sicom Acompanhamento Mensal
 * @author robson
 * @package Contabilidade
 */
class SicomArquivoCronogramaExecucao extends SicomArquivoBase implements iPadArquivoBaseCSV
{
  
  /**
   *
   * Codigo do layout. (db_layouttxt.db50_codigo)
   * @var Integer
   */
  protected $iCodigoLayout = 0;
  
  /**
   *
   * NOme do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'CRONEM';
  
  /**
   *
   * Contrutor da classe
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

    $aElementos = array(
      "tipoRegistro",
      "codOrgao",
      "codUnidadeSub",
      "grupoDespesa",
      "vlDotMensal"
    );

    return $aElementos;
  }
  
  /**
   * selecionar os dados de indentificacao da remessa pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {

    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clcronem10 = new cl_cronem102020();
    
    /**
     * inserir informacoes no banco de dados
     */
    db_inicio_transacao();
    $result = $clcronem10->sql_record($clcronem10->sql_query(null, "*", null, "si170_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si170_instit = " . db_getsession("DB_instit")));
    if (pg_num_rows($result) > 0) {
      $clcronem10->excluir(null, "si170_mes = " . $this->sDataFinal['5'] . $this->sDataFinal['6'] . " and si170_instit = " . db_getsession("DB_instit"));
      if ($clcronem10->erro_status == 0) {
        throw new Exception($clcronem10->erro_msg);
      }
    }
    db_fim_transacao();
    

    db_inicio_transacao();
    $sSqlTrataUnidade = "select si08_tratacodunidade from infocomplementares where si08_instit = " . db_getsession("DB_instit");
    $rsResultTrataUnidade = db_query($sSqlTrataUnidade);
    $sTrataCodUnidade = db_utils::fieldsMemory($rsResultTrataUnidade, 0)->si08_tratacodunidade;

    $aTipoDespesa = array("3310000000000" => "1",
    "3320000000000" => "2",
    "3330000000000" => "3",
    "3440000000000" => "4",
    "3450000000000" => "5",
    "3460000000000" => "6");

    $aMeses = array("01" => "o202_janeiro",
    "02" => "o202_fevereiro",
    "03" => "o202_marco",
    "04" => "o202_abril",
    "05" => "o202_maio",
    "06" => "o202_junho",
    "07" => "o202_julho",
    "08" => "o202_agosto",
    "09" => "o202_setembro",
    "10" => "o202_outubro",
    "11" => "o202_novembro",
    "12" => "o202_dezembro");
    $sMes = $this->sDataFinal['5'] . $this->sDataFinal['6'];

    $clcronogramamesdesembolso = new cl_cronogramamesdesembolso;
    $sWhere  = " o202_instit = ".db_getsession("DB_instit");
    $sWhere .= " and o202_anousu = ".db_getsession("DB_anousu");

    $sCampos  = "o202_unidade,o202_orgao,o202_elemento,".$aMeses[$sMes].",";
    $sCampos .= "(SELECT lpad(si09_codorgaotce::VARCHAR,2,0) FROM infocomplementaresinstit WHERE si09_instit = ".db_getsession("DB_instit").") as codorgao,";
    $sCampos .= "lpad((CASE WHEN orcorgao.o40_codtri = '0'
         OR NULL THEN orcorgao.o40_orgao::VARCHAR ELSE orcorgao.o40_codtri END),2,0)||lpad((CASE WHEN orcunidade.o41_codtri = '0'
           OR NULL THEN orcunidade.o41_unidade::VARCHAR ELSE orcunidade.o41_codtri END),3,0)||(CASE WHEN orcunidade.o41_subunidade = '0'
           OR NULL THEN '' ELSE lpad(orcunidade.o41_subunidade::VARCHAR,3,0) END) as codunidadesub";
    
    $sSql = $clcronogramamesdesembolso->sql_query(null,$sCampos,"",$sWhere);

    $rsResult = db_query($sSql);//db_criatabela($rsResult);
    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
      
      $clcronem10 = new cl_cronem102020();
      $oDados = db_utils::fieldsMemory($rsResult, $iCont);

      $clcronem10->si170_tiporegistro = "10";
      $clcronem10->si170_codorgao = $oDados->codorgao;
      $clcronem10->si170_codunidadesub = $oDados->codunidadesub;
      $clcronem10->si170_grupodespesa = $aTipoDespesa[$oDados->o202_elemento];
      $clcronem10->si170_vldotmensal = $oDados->$aMeses[$sMes];
      $clcronem10->si170_mes = $sMes;
      $clcronem10->si170_instit = db_getsession("DB_instit");


      $clcronem10->incluir(null);
      if ($clcronem10->erro_status == 0) {
        throw new Exception($clcronem10->erro_msg);
      }

    }
    
    db_fim_transacao();
    
    $oGerarCRONEM = new GerarCRONEM();
    $oGerarCRONEM->iMes = $sMes;
    $oGerarCRONEM->gerarDados();
    
  }
  
}
