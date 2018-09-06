<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_dclrf102018_classe.php");
require_once ("classes/db_dclrf202018_classe.php");
require_once ("classes/db_dclrf302018_classe.php");
require_once ("classes/db_dclrf402018_classe.php");
require_once ("classes/db_infocomplementaresinstit_classe.php");
require_once ("classes/db_dadoscomplementareslrf_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2018/GerarDCLRF.model.php");


 /**
  * Dados Complementares Sicom Acompanhamento Mensal
  * @author marcony
  * @package Contabilidade
  */
 class SicomArquivoDadosComplementares extends SicomArquivoBase implements iPadArquivoBaseCSV {

	/**
	 *
	 * Codigo do layout. (db_layouttxt.db50_codigo)
	 * @var Integer
	 */
  protected $iCodigoLayout;

  /**
   *
   * Nome do arquivo a ser criado
   * @var String
   */
  protected $sNomeArquivo = 'DCLRF';

  /**
   *
   * Construtor da classe
   */
  public function __construct() {

  }

  /**
	 * Retorna o codigo do layout
	 *
	 * @return Integer
	 */
  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos(){

  }

  public function getTipoinstit($CodInstit){
  $sSqltipoistint = "select si09_tipoinstit from infocomplementaresinstit inner join db_config on codigo = si09_instit where codigo = {$CodInstit}";
  $iTipoInstit = db_utils::fieldsMemory(db_query($sSqltipoistint), 0)->si09_tipoinstit;
  if ($iTipoInstit == "") {
  throw new Exception("Não foi possível encontrar o código do TCE do instituição {$CodInstit} em " . db_getsession('DB_anousu') . " Verifique o cadastro da instituição no módulo Configurações, menu Cadastros->Instiuições.");
  }
    return $iTipoInstit;
  }

  /**
   * selecionar os dados de Dados Complementares à LRF do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {

    $cldclrf10                  = new cl_dclrf102018();
    $cldclrf20                  = new cl_dclrf202018();
    $cldclrf30                  = new cl_dclrf302018();
    $cldclrf40                  = new cl_dclrf402018();
    $cldadoscomplementareslrf   = new cl_dadoscomplementareslrf();
    $clinfocomplementaresinstit = new cl_infocomplementaresinstit();

    //PEGA O CÓDIGO DO ÓRGAO
    $oInstituicao = $clinfocomplementaresinstit->sql_query_file(null,"*",null,"si09_instit = ".db_getsession('DB_instit'));
    $oInstituicao = $clinfocomplementaresinstit->sql_record($oInstituicao);
    $oInstituicao = db_utils::fieldsMemory($oInstituicao);
    $iCodOrgao = $oInstituicao->si09_codorgaotce;

    //db_inicio_transacao();


    // $this->sDataFinal['5'].$this->sDataFinal['6']

    //LIMPA AS TABELAS
    $cldclrf40->excluir("(SELECT si190_sequencial FROM dclrf102018 WHERE si190_codorgao = '{$iCodOrgao}' AND si190_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." )");
    if($cldclrf40->erro_status == 0){
      throw new Exception($cldclrf40->erro_msg);
    }
    $cldclrf30->excluir("(SELECT si190_sequencial FROM dclrf102018 WHERE si190_codorgao = '{$iCodOrgao}' AND si190_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." )");
    if($cldclrf30->erro_status == 0){
      throw new Exception($cldclrf30->erro_msg);
    }
    $cldclrf20->excluir("(SELECT si190_sequencial FROM dclrf102018 WHERE si190_codorgao = '{$iCodOrgao}' AND si190_mes = ".$this->sDataFinal['5'].$this->sDataFinal['6']." )");
    if($cldclrf20->erro_status == 0){
      throw new Exception($cldclrf20->erro_msg);
    }
    $cldclrf10->excluir($this->sDataFinal['5'].$this->sDataFinal['6'], $iCodOrgao);
    if($cldclrf10->erro_status == 0){
      throw new Exception($cldclrf10->erro_msg);
    }


    /*
     * selecionar informacoes registro 10
     */

    $sSqldadoscomplementares = $cldadoscomplementareslrf->sql_query(null,"*",null, "c218_mesusu=".$this->sDataFinal['5'].$this->sDataFinal['6']." AND c218_codorgao = '$iCodOrgao' AND c218_anousu = ".db_getsession('DB_anousu')." ");
    $rsDadoscomplementares = $cldadoscomplementareslrf->sql_record($sSqldadoscomplementares);
    $rsDadoscomplementares = db_utils::getColectionByRecord($rsDadoscomplementares);
    //echo '<pre>'; var_dump($rsDadoscomplementares);die;
    foreach ($rsDadoscomplementares as $dados) {

      $cldclrf10 = new cl_dclrf102018();
      $cldclrf10->si190_tiporegistro = 10;
      $cldclrf10->si190_codorgao = $dados->c218_codorgao;
      $cldclrf10->si190_passivosreconhecidos = $dados->c218_passivosreconhecidos;
      $cldclrf10->si190_vlsaldoatualconcgarantiainterna = $dados->c218_vlsaldoatualconcgarantiainterna;
      $cldclrf10->si190_vlsaldoatualconcgarantia = $dados->c218_vlsaldoatualconcgarantia;
      $cldclrf10->si190_vlsaldoatualcontragarantiainterna = $dados->c218_vlsaldoatualcontragarantiainterna;
      $cldclrf10->si190_vlsaldoatualcontragarantiaexterna = $dados->c218_vlsaldoatualcontragarantiaexterna;
      $cldclrf10->si190_medidascorretivas = $this->removeCaracteres($dados->c218_medidascorretivas);
      $cldclrf10->si190_recalieninvpermanente = $dados->c218_recalieninvpermanente;
      $cldclrf10->si190_vldotatualizadaincentcontrib = $dados->c218_vldotatualizadaincentcontrib;
      $cldclrf10->si190_vlempenhadoicentcontrib = $dados->c218_vlempenhadoicentcontrib;
      $cldclrf10->si190_vldotatualizadaincentinstfinanc = $dados->c218_vldotatualizadaincentinstfinanc;
      $cldclrf10->si190_vlempenhadoincentinstfinanc = $dados->c218_vlempenhadoincentinstfinanc;
      $cldclrf10->si190_vlliqincentcontrib = $dados->c218_vlliqincentcontrib;
      $cldclrf10->si190_vlliqincentinstfinanc = $dados->c218_vlliqincentinstfinanc;
      $cldclrf10->si190_vlirpnpincentcontrib = $dados->c218_vlirpnpincentcontrib;
      $cldclrf10->si190_vlirpnpincentinstfinanc = $dados->c218_vlirpnpincentinstfinanc;
      $cldclrf10->si190_vlrecursosnaoaplicados = $dados->c218_vlrecursosnaoaplicados;
      $cldclrf10->si190_vlapropiacaodepositosjudiciais = $dados->c218_vlapropiacaodepositosjudiciais;
      $cldclrf10->si190_vloutrosajustes = $dados->c218_vloutrosajustes;
      $cldclrf10->si190_metarrecada = $dados->c218_metarrecada;
      $cldclrf10->si190_dscmedidasadotadas = $this->removeCaracteres($dados->c218_dscmedidasadotadas);
      $cldclrf10->si190_mes = $dados->c218_mesusu;

      $cldclrf10->incluir(null);
      if ($cldclrf10->erro_status == 0) {
        throw new Exception($cldclrf10->erro_msg);
      }

      if($this->getTipoinstit(db_getsession('DB_instit')) == 2){
        if($this->sDataFinal['5'].$this->sDataFinal['6'] == '12'){
          $cldclrf20 = new cl_dclrf202018();
          $cldclrf20->si191_tiporegistro = 20;
          $cldclrf20->si191_reg10 = $cldclrf10->si190_sequencial;
          $cldclrf20->si191_contopcredito = $dados->c219_contopcredito;
          $cldclrf20->si191_dsccontopcredito = $this->removeCaracteres($dados->c219_dsccontopcredito);
          $cldclrf20->si191_realizopcredito = $dados->c219_realizopcredito;
          $cldclrf20->si191_tiporealizopcreditocapta = $dados->c219_tiporealizopcreditocapta;
          $cldclrf20->si191_tiporealizopcreditoreceb = $dados->c219_tiporealizopcreditoreceb;
          $cldclrf20->si191_tiporealizopcreditoassundir = $dados->c219_tiporealizopcreditoassundir;
          $cldclrf20->si191_tiporealizopcreditoassunobg = $dados->c219_tiporealizopcreditoassunobg;

          $cldclrf20->incluir(null);
          if ($cldclrf20->erro_status == 0) {
            throw new Exception($cldclrf20->erro_msg);
          }

        }
        $cldclrf30 = new cl_dclrf302018();
        $cldclrf30->si192_tiporegistro = 30;
        $cldclrf30->si192_reg10 = $cldclrf10->si190_sequencial;
        $cldclrf30->si192_publiclrf = $dados->c220_publiclrf;
        $cldclrf30->si192_dtpublicacaorelatoriolrf = $dados->c220_dtpublicacaorelatoriolrf;
        $cldclrf30->si192_localpublicacao = $this->removeCaracteres($dados->c220_localpublicacao);
        $cldclrf30->si192_tpbimestre = $dados->c220_tpbimestre;
        $cldclrf30->si192_exerciciotpbimestre = $dados->c220_exerciciotpbimestre;

        $cldclrf30->incluir(null);
        if ($cldclrf30->erro_status == 0) {
          throw new Exception($cldclrf30->erro_msg);
        }

      }
      $cldclrf40 = new cl_dclrf402018();
      $cldclrf40->si193_tiporegistro = 40;
      $cldclrf40->si193_reg10 = $cldclrf10->si190_sequencial;
      $cldclrf40->si193_publicrgf = $dados->c221_publicrgf;
      $cldclrf40->si193_dtpublicacaorelatoriorgf = $dados->c221_dtpublicacaorelatoriorgf;
      $cldclrf40->si193_localpublicacaorgf = $this->removeCaracteres($dados->c221_localpublicacaorgf);
      $cldclrf40->si193_tpperiodo = $dados->c221_tpperiodo;
      $cldclrf40->si193_exerciciotpperiodo = $dados->c221_exerciciotpperiodo;

      $cldclrf40->incluir(null);
      if ($cldclrf40->erro_status == 0) {
        throw new Exception($cldclrf40->erro_msg);
      }

    }


    //db_fim_transacao();

    $oGerarDCLRF = new GerarDCLRF();
    $oGerarDCLRF->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarDCLRF->iOrgao = $iCodOrgao;
    $oGerarDCLRF->iTipoIntint = $this->getTipoinstit(db_getsession('DB_instit'));
    $oGerarDCLRF->gerarDados();

  }

}
