<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

require_once('model/contabilidade/relatorios/dcasp/BalancoPatrimonialDCASP2015.model.php');
require_once('libs/db_stdlib.php');
require_once('libs/db_conecta.php');
require_once('libs/db_sessoes.php');
require_once('libs/db_usuariosonline.php');
require_once('fpdf151/assinatura.php');
require_once('libs/db_utils.php');
require_once('libs/db_app.utils.php');
require_once('dbforms/db_funcoes.php');
require_once('libs/db_libcontabilidade.php');
require_once('libs/db_liborcamento.php');
require_once('fpdf151/PDFDocument.php');

require_once("classes/db_bpdcasp102017_classe.php");
require_once("classes/db_bpdcasp202017_classe.php");
require_once("classes/db_bpdcasp302017_classe.php");
require_once("classes/db_bpdcasp402017_classe.php");
require_once("classes/db_bpdcasp502017_classe.php");
require_once("classes/db_bpdcasp602017_classe.php");
require_once("classes/db_bpdcasp702017_classe.php");
require_once("classes/db_bpdcasp712017_classe.php");

require_once("model/contabilidade/arquivos/sicom/2016/dcasp/geradores/GerarBP.model.php");

/**
 * gerar arquivo de Balan�o Patrimonial
 * @author gabriel
 * @package Contabilidade
 */
class SicomArquivoBP extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  protected $iCodigoLayout = 151; // C�digo do relat�rio

  protected $sNomeArquivo = 'BP';

  protected $iCodigoPespectiva;

  public function getCampos(){

  }

  public function getCodigoLayout(){
    return $this->iCodigoLayout;
  }

  public function getNomeArquivo(){
    return $this->sNomeArquivo;
  }
  /**
   * Contrutor da classe
   */
  public function __construct() { }

  /**
   * selecionar os dados do balan�o patrimonial pra gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados()
  {
    $iAnoUsu            = db_getsession("DB_anousu");
    $iCodigoPeriodo     = 28;
    $iCodigoRelatorio   = $this->iCodigoLayout;
    $oInstit            = new Instituicao(db_getsession("DB_instit"));

    if ($oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_PREFEITURA) {

      $sSqlInstit = "select codigo from db_config ";
      $aInstits   = db_utils::getColectionByRecord(db_query($sSqlInstit));
      $aInstituicoes = array_map(function ($oItem) {
        return $oItem->codigo;
      }, $aInstits);

    } else {
      $aInstituicoes = array(db_getsession("DB_instit"));
    }

    $sListaInstituicoes = implode(',', $aInstituicoes);


    /**
     * classe para inclusao dos dados na tabela do sicom correspondente ao arquivo
     */
    $clbpdcasp10 = new cl_bpdcasp102017();
    $clbpdcasp20 = new cl_bpdcasp202017();
    $clbpdcasp30 = new cl_bpdcasp302017();
    $clbpdcasp40 = new cl_bpdcasp402017();
    $clbpdcasp50 = new cl_bpdcasp502017();
    $clbpdcasp60 = new cl_bpdcasp602017();
    $clbpdcasp70 = new cl_bpdcasp702017();
    $clbpdcasp71 = new cl_bpdcasp712017();

    /**
     * excluir informacoes caso estejam repetidas
     */
    db_inicio_transacao();

    /** BPDCASP10 */
    $sWhereSelectDelete = "si208_ano = {$iAnoUsu} AND si208_periodo = {$iCodigoPeriodo} AND si208_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $clbpdcasp10->sql_query(null,"*",null,$sWhereSelectDelete);
    $result = $clbpdcasp10->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp10->excluir(null, $sWhereSelectDelete);
      if ($clbpdcasp10->erro_status == 0) {
        throw new Exception($clbpdcasp10->erro_msg);
      }
    }

    /** BPDCASP20 */
    $sWhereSelectDelete = "si209_ano = {$iAnoUsu} AND si209_periodo = {$iCodigoPeriodo} AND si209_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $clbpdcasp20->sql_query(null,"*",null,$sWhereSelectDelete);
    $result = $clbpdcasp20->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp20->excluir(null, $sWhereSelectDelete);
      if ($clbpdcasp20->erro_status == 0) {
        throw new Exception($clbpdcasp20->erro_msg);
      }
    }

    /** BPDCASP30 */
    $sWhereSelectDelete = "si210_ano = {$iAnoUsu} AND si210_periodo = {$iCodigoPeriodo} AND si210_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $clbpdcasp30->sql_query(null,"*",null,$sWhereSelectDelete);
    $result = $clbpdcasp30->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp30->excluir(null, $sWhereSelectDelete);
      if ($clbpdcasp30->erro_status == 0) {
        throw new Exception($clbpdcasp30->erro_msg);
      }
    }

    /** BPDCASP40 */
    $sWhereSelectDelete = "si211_ano = {$iAnoUsu} AND si211_periodo = {$iCodigoPeriodo} AND si211_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $clbpdcasp40->sql_query(null,"*",null,$sWhereSelectDelete);
    $result = $clbpdcasp40->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp40->excluir(null, $sWhereSelectDelete);
      if ($clbpdcasp40->erro_status == 0) {
        throw new Exception($clbpdcasp40->erro_msg);
      }
    }

    /** BPDCASP50 */
    $sWhereSelectDelete = "si212_ano = {$iAnoUsu} AND si212_periodo = {$iCodigoPeriodo} AND si212_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $clbpdcasp50->sql_query(null,"*",null,$sWhereSelectDelete);
    $result = $clbpdcasp50->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp50->excluir(null, $sWhereSelectDelete);
      if ($clbpdcasp50->erro_status == 0) {
        throw new Exception($clbpdcasp50->erro_msg);
      }
    }
    /** BPDCASP60 */
    $sWhereSelectDelete = "si213_ano = {$iAnoUsu} AND si213_periodo = {$iCodigoPeriodo} AND si213_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $clbpdcasp60->sql_query(null,"*",null,$sWhereSelectDelete);
    $result = $clbpdcasp60->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp60->excluir(null, $sWhereSelectDelete);
      if ($clbpdcasp60->erro_status == 0) {
        throw new Exception($clbpdcasp60->erro_msg);
      }
    }
    /** BPDCASP70 */
    $sWhereSelectDelete = "si214_ano = {$iAnoUsu} AND si214_periodo = {$iCodigoPeriodo} AND si214_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $clbpdcasp70->sql_query(null,"*",null,$sWhereSelectDelete);
    $result = $clbpdcasp70->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp70->excluir(null, $sWhereSelectDelete);
      if ($clbpdcasp70->erro_status == 0) {
        throw new Exception($clbpdcasp70->erro_msg);
      }
    }
    /** BPDCASP71 */
    $sWhereSelectDelete = "si215_ano = {$iAnoUsu} AND si215_periodo = {$iCodigoPeriodo} AND si215_institu IN ({$sListaInstituicoes}) ";
    $sSQL   = $clbpdcasp71->sql_query(null,"*",null,$sWhereSelectDelete);
    $result = $clbpdcasp71->sql_record($sSQL);
    if (pg_num_rows($result) > 0) {
      $clbpdcasp71->excluir(null, $sWhereSelectDelete);
      if ($clbpdcasp71->erro_status == 0) {
        throw new Exception($clbpdcasp71->erro_msg);
      }
    }

    /*------------------------------------------------------------------------*/


    /**
     * O m�todo `getDados()`, da classe `BalancoPatromonialDCASP2015()`,
     * retorna um array enorme. Para pegar os dados necess�rios para cada
     * registro do SICOM DCASP, estamos passando os �ndices exatos do array.
     * Se eles forem alterados (nas configura��es dos relat�rios), devem
     * ser alterados aqui tamb�m.
     */

    $oBalancoPatrimonial = new BalancoPatrimonialDCASP2015($iAnoUsu, $iCodigoRelatorio, $iCodigoPeriodo);
    $oBalancoPatrimonial->setInstituicoes($sListaInstituicoes);
    $oBalancoPatrimonial->setExibirExercicioAnterior(true);

    $aQuadros   = array();
    $aQuadros[] = BalancoPatrimonialDCASP2015::QUADRO_PRINCIPAL;
    $aQuadros[] = BalancoPatrimonialDCASP2015::QUADRO_ATIVOS_PASSIVOS;
    $aQuadros[] = BalancoPatrimonialDCASP2015::QUADRO_CONTAS_COMPENSACAO;
    $aQuadros[] = BalancoPatrimonialDCASP2015::QUADRO_SUPERAVIT;

    $oBalancoPatrimonial->setExibirQuadros($aQuadros);

    $oRetornoBP = $oBalancoPatrimonial->getDados();

    /** BPDCASP102017
     *  Quadro principal do relat�rio
     */

    $aExercicios = array(
        1 => 'vlrexatual',
        2 => 'vlrexanter'
    );

    foreach ($aExercicios as $iValorNumerico => $sChave) {

      $clbpdcasp10  = new cl_bpdcasp102017();

      $clbpdcasp10->si208_ano                               = $iAnoUsu;
      $clbpdcasp10->si208_periodo                           = $iCodigoPeriodo;
      $clbpdcasp10->si208_institu                           = db_getsession("DB_instit");
      $clbpdcasp10->si208_tiporegistro                      = 10;
      $clbpdcasp10->si208_exercicio                         = $iValorNumerico;
      $clbpdcasp10->si208_vlativocircucaixaequicaixa        = $oRetornoBP[2]->$sChave;
      $clbpdcasp10->si208_vlativocircucredicurtoprazo       = $oRetornoBP[3]->$sChave;
      $clbpdcasp10->si208_vlativocircuinvestapliccurtoprazo = $oRetornoBP[4]->$sChave;
      $clbpdcasp10->si208_vlativocircuestoques              = $oRetornoBP[5]->$sChave;
      $clbpdcasp10->si208_vlativocircuvpdantecipada         = $oRetornoBP[6]->$sChave;
      $clbpdcasp10->si208_vlativonaocircucredilongoprazo    = $oRetornoBP[10]->$sChave;
      $clbpdcasp10->si208_vlativonaocircuinvestemplongpraz  = $oRetornoBP[11]->$sChave;
      $clbpdcasp10->si208_vlativonaocircuestoques           = $oRetornoBP[12]->$sChave;
      $clbpdcasp10->si208_vlativonaocircuvpdantecipada      = $oRetornoBP[13]->$sChave;
      $clbpdcasp10->si208_vlativonaocircuinvestimentos      = $oRetornoBP[14]->$sChave;
      $clbpdcasp10->si208_vlativonaocircuimobilizado        = $oRetornoBP[15]->$sChave;
      $clbpdcasp10->si208_vlativonaocircuintagivel          = $oRetornoBP[16]->$sChave;
      $clbpdcasp10->si208_vltotalativo                      = $oRetornoBP[19]->$sChave;

      $clbpdcasp10->incluir(null);
      if ($clbpdcasp10->erro_status == 0) {
        throw new Exception($clbpdcasp10->erro_msg);
      }

    }

    foreach ($aExercicios as $iValorNumerico => $sChave) {

      $clbpdcasp20  = new cl_bpdcasp202017();

      $clbpdcasp20->si209_ano                                 = $iAnoUsu;
      $clbpdcasp20->si209_periodo                             = $iCodigoPeriodo;
      $clbpdcasp20->si209_institu                             = db_getsession("DB_instit");
      $clbpdcasp20->si209_tiporegistro                        = 20;
      $clbpdcasp20->si209_exercicio                           = $iValorNumerico;
      $clbpdcasp20->si209_vlpassivcircultrabprevicurtoprazo   = $oRetornoBP[21]->$sChave;
      $clbpdcasp20->si209_vlpassivcirculemprefinancurtoprazo  = $oRetornoBP[22]->$sChave;
      $clbpdcasp20->si209_vlpassivocirculafornecedcurtoprazo  = $oRetornoBP[23]->$sChave;
      $clbpdcasp20->si209_vlpassicircuobrigfiscacurtoprazo    = $oRetornoBP[24]->$sChave;
      $clbpdcasp20->si209_vlpassivocirculaobrigacoutrosentes  = $oRetornoBP[25]->$sChave;
      $clbpdcasp20->si209_vlpassivocirculaprovisoecurtoprazo  = $oRetornoBP[26]->$sChave;
      $clbpdcasp20->si209_vlpassicircudemaiobrigcurtoprazo    = $oRetornoBP[27]->$sChave;
      $clbpdcasp20->si209_vlpassinaocircutrabprevilongoprazo  = $oRetornoBP[30]->$sChave;
      $clbpdcasp20->si209_vlpassnaocircemprfinalongpraz       = $oRetornoBP[31]->$sChave;
      $clbpdcasp20->si209_vlpassivnaocirculforneclongoprazo   = $oRetornoBP[32]->$sChave;
      $clbpdcasp20->si209_vlpassnaocircobrifisclongpraz       = $oRetornoBP[33]->$sChave;
      $clbpdcasp20->si209_vlpassivnaocirculprovislongoprazo   = $oRetornoBP[34]->$sChave;
      $clbpdcasp20->si209_vlpassnaocircdemaobrilongpraz       = $oRetornoBP[35]->$sChave;
      $clbpdcasp20->si209_vlpassivonaocircularesuldiferido    = $oRetornoBP[36]->$sChave;
      $clbpdcasp20->si209_vlpatriliquidocapitalsocial         = $oRetornoBP[39]->$sChave;
      $clbpdcasp20->si209_vlpatriliquidoadianfuturocapital    = $oRetornoBP[40]->$sChave;
      $clbpdcasp20->si209_vlpatriliquidoreservacapital        = $oRetornoBP[41]->$sChave;
      $clbpdcasp20->si209_vlpatriliquidoajustavaliacao        = $oRetornoBP[42]->$sChave;
      $clbpdcasp20->si209_vlpatriliquidoreservalucros         = $oRetornoBP[43]->$sChave;
      $clbpdcasp20->si209_vlpatriliquidodemaisreservas        = $oRetornoBP[44]->$sChave;
      
      //para pegar o superavit do exercicio atual e anterior � necess�rio alterar o anousu
      $iAno = db_getsession("DB_anousu");
      if($iValorNumerico == 2){
        $iAno = $iAno-1;
      }
      
      $nValorResultadoExecAnterior = db_utils::fieldsMemory(db_query($clbpdcasp20->sql_query_vlpatriliquidresultacumexeranteri($sListaInstituicoes,$iAno)))->resultacumexeranteri;
      
      //no arquivo o sinal deve ser negativo para saldo credor e positivo para saldo devedor.
      $nValorResultadoExecAnterior = $nValorResultadoExecAnterior*-1;

      $nValorResultadoExec= db_utils::fieldsMemory(db_query($clbpdcasp20->sql_query_vlpatriliquidresultacumexer($sListaInstituicoes,$iAno)))->resultacumexeranteri;
      
      //no arquivo o sinal deve ser negativo para saldo credor e positivo para saldo devedor.
      $nValorResultadoExec = $nValorResultadoExec*-1;

      $clbpdcasp20->si209_vlpatriliquidoresultexercicio       = $nValorResultadoExec;
      $clbpdcasp20->si209_vlpatriliquidresultacumexeranteri   = $nValorResultadoExecAnterior;//$oRetornoBP[45]->$sChave;
      
      $clbpdcasp20->si209_vlpatriliquidoacoescotas            = $oRetornoBP[46]->$sChave;
      $clbpdcasp20->si209_vltotalpassivo                      = $oRetornoBP[48]->$sChave;

      $clbpdcasp20->incluir(null);
      if ($clbpdcasp20->erro_status == 0) {
        throw new Exception($clbpdcasp20->erro_msg);
      }

    }

    foreach ($aExercicios as $iValorNumerico => $sChave) {

      $clbpdcasp30  = new cl_bpdcasp302017();

      $clbpdcasp30->si210_ano                               = $iAnoUsu;
      $clbpdcasp30->si210_periodo                           = $iCodigoPeriodo;
      $clbpdcasp30->si210_institu                           = db_getsession("DB_instit");
      $clbpdcasp30->si210_tiporegistro                      = 30;
      $clbpdcasp30->si210_exercicio                         = $iValorNumerico;
      $clbpdcasp30->si210_vlativofinanceiro                 = $oRetornoBP[50]->$sChave;
      $clbpdcasp30->si210_vlativopermanente                 = $oRetornoBP[51]->$sChave;
      $clbpdcasp30->si210_vltotalativofinanceiropermanente  = $oRetornoBP[52]->$sChave;

      $clbpdcasp30->incluir(null);
      if ($clbpdcasp30->erro_status == 0) {
        throw new Exception($clbpdcasp30->erro_msg);
      }

    }


    foreach ($aExercicios as $iValorNumerico => $sChave) {

      $clbpdcasp40  = new cl_bpdcasp402017();

      $clbpdcasp40->si211_ano                                 = $iAnoUsu;
      $clbpdcasp40->si211_periodo                             = $iCodigoPeriodo;
      $clbpdcasp40->si211_institu                             = db_getsession("DB_instit");
      $clbpdcasp40->si211_tiporegistro                        = 40;
      $clbpdcasp40->si211_exercicio                           = $iValorNumerico;
      $clbpdcasp40->si211_vlpassivofinanceiro                 = $oRetornoBP[54]->$sChave;
      $clbpdcasp40->si211_vlpassivopermanente                 = $oRetornoBP[55]->$sChave;
      $clbpdcasp40->si211_vltotalpassivofinanceiropermanente  = $oRetornoBP[56]->$sChave;

      $clbpdcasp40->incluir(null);
      if ($clbpdcasp40->erro_status == 0) {
        throw new Exception($clbpdcasp40->erro_msg);
      }

    }


    foreach ($aExercicios as $iValorNumerico => $sChave) {

      $clbpdcasp50  = new cl_bpdcasp502017();

      $clbpdcasp50->si212_ano                 = $iAnoUsu;
      $clbpdcasp50->si212_periodo             = $iCodigoPeriodo;
      $clbpdcasp50->si212_institu             = db_getsession("DB_instit");
      $clbpdcasp50->si212_tiporegistro        = 50;
      $clbpdcasp50->si212_exercicio           = $iValorNumerico;
      $clbpdcasp50->si212_vlsaldopatrimonial  = $oRetornoBP[57]->$sChave;

      $clbpdcasp50->incluir(null);
      if ($clbpdcasp50->erro_status == 0) {
        throw new Exception($clbpdcasp50->erro_msg);
      }

    }


    foreach ($aExercicios as $iValorNumerico => $sChave) {

      $clbpdcasp60  = new cl_bpdcasp602017();

      $clbpdcasp60->si213_ano                                 = $iAnoUsu;
      $clbpdcasp60->si213_periodo                             = $iCodigoPeriodo;
      $clbpdcasp60->si213_institu                             = db_getsession("DB_instit");
      $clbpdcasp60->si213_tiporegistro                        = 60;
      $clbpdcasp60->si213_exercicio                           = $iValorNumerico;
      $clbpdcasp60->si213_vlatospotenativosgarancontrarecebi  = $oRetornoBP[59]->$sChave;
      $clbpdcasp60->si213_vlatospotenativodirconveoutroinstr  = $oRetornoBP[60]->$sChave;
      $clbpdcasp60->si213_vlatospotenativosdireitoscontratua  = $oRetornoBP[61]->$sChave;
      $clbpdcasp60->si213_vlatospotenativosoutrosatos         = $oRetornoBP[62]->$sChave;
      $clbpdcasp60->si213_vlatospotenpassivgarancontraconced  = $oRetornoBP[65]->$sChave;
      $clbpdcasp60->si213_vlatospotepassobriconvoutrinst      = $oRetornoBP[66]->$sChave;
      $clbpdcasp60->si213_vlatospotenpassivoobrigacocontratu  = $oRetornoBP[67]->$sChave;
      $clbpdcasp60->si213_vlatospotenpassivooutrosatos        = $oRetornoBP[68]->$sChave;

      $clbpdcasp60->incluir(null);
      if ($clbpdcasp60->erro_status == 0) {
        throw new Exception($clbpdcasp60->erro_msg);
      }

    } // $rsResult60

    /**
     * @see funcao getSuperavitDeficit em BalancoPatrimonialDCASP2015.model.php
     */

    $aDadosSuperavitFontes = $oBalancoPatrimonial->getSuperavitDeficit();

    foreach ($aExercicios as $iValorNumerico => $sChave) {
      $nVltotalsupdef =0;
      foreach($aDadosSuperavitFontes as $oDadosBP71) {
        if (isset($oDadosBP71->codigo)) {
          $clbpdcasp71 = new cl_bpdcasp712017();
          $clbpdcasp71->si215_ano = $iAnoUsu;
          $clbpdcasp71->si215_periodo = $iCodigoPeriodo;
          $clbpdcasp71->si215_institu = $sListaInstituicoes;
          $clbpdcasp71->si215_tiporegistro = 71;
          $clbpdcasp71->si215_exercicio = $iValorNumerico;
          $clbpdcasp71->si215_codfontrecursos = $oDadosBP71->codigo;
          $clbpdcasp71->si215_vlsaldofonte = $oDadosBP71->$sChave;

          $clbpdcasp71->incluir(null);
          if ($clbpdcasp71->erro_status == 0) {
            throw new Exception($clbpdcasp71->erro_msg);
          }
          $nVltotalsupdef =  $nVltotalsupdef + $oDadosBP71->$sChave;
        }
      }
      /**
       * o registro 70 � o total do registro 71
       */
      $clbpdcasp70  = new cl_bpdcasp702017();

      $clbpdcasp70->si214_ano           = $iAnoUsu;
      $clbpdcasp70->si214_periodo       = $iCodigoPeriodo;
      $clbpdcasp70->si214_institu       = $sListaInstituicoes;
      $clbpdcasp70->si214_tiporegistro  = 70;
      $clbpdcasp70->si214_exercicio     =  $iValorNumerico;
      $clbpdcasp70->si214_vltotalsupdef = $nVltotalsupdef;
      $clbpdcasp70->incluir(null);
      if ($clbpdcasp70->erro_status == 0) {
        throw new Exception($clbpdcasp70->erro_msg);
      }
    } // $rsResult71


    db_fim_transacao();

    $oGerarBP = new GerarBP();
    $oGerarBP->iAno = $iAnoUsu;
    $oGerarBP->iPeriodo = $iCodigoPeriodo;
    $oGerarBP->gerarDados();

  }

}
