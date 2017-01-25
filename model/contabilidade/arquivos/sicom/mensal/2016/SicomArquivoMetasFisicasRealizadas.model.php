<?php
require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_metareal102016_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2016/GerarMETAREAL.model.php");

/**
 * Dados Complementares Sicom Acompanhamento Mensal
 * @author marcelo
 * @package Contabilidade
 */
class SicomArquivoMetasFisicasRealizadas extends SicomArquivoBase implements iPadArquivoBaseCSV {

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
  protected $sNomeArquivo = 'METAREAL';

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

  /**
   * selecionar os dados de Dados Complementares à LRF do mes para gerar o arquivo
   * @see iPadArquivoBase::gerarDados()
   */
  public function gerarDados() {

    $clmetareal10 = new cl_metareal102016();

    db_inicio_transacao();

    /*
     * excluir informacoes do mes selecionado registro 10
     */
    $result = $clmetareal10->sql_record($clmetareal10->sql_query(NULL,"*",NULL," si171_instit = ".db_getsession("DB_instit") ));
    if (pg_num_rows($result) > 0) {
      $clmetareal10->excluir(NULL," si171_instit = ".db_getsession("DB_instit"));
      if ($clmetareal10->erro_status == 0) {
        throw new Exception($clmetareal10->erro_msg);
      }
    }

    $sSql  = "SELECT si09_codorgaotce AS codorgao, si09_tipoinstit AS tipoinstit
              FROM infocomplementaresinstit
              WHERE si09_instit = ".db_getsession("DB_instit");

    $rsResult    = db_query($sSql);
    $sCodorgao   = db_utils::fieldsMemory($rsResult, 0)->codorgao;
    $sCodTipoOrgao   = db_utils::fieldsMemory($rsResult, 0)->tipoinstit;

    /*
     * selecionar informacoes registro 10
     */
    if($this->sDataFinal['5'].$this->sDataFinal['6'] == 12 && $sCodTipoOrgao == '2'){
      $sSql = " select distinct lpad(case when o40_codtri in ('','0') then o40_codtri else o40_orgao::char end,2,0)||
         lpad(case when o41_codtri in ('','0') then o41_codtri else o41_unidade::char end,3,0)||'000' as codunidadesub, 
         lpad(o58_funcao,2,0) as funcao, 
         lpad(o58_subfuncao,3,0) as subfuncao,
         lpad(o58_programa,4,0) as programa, 
         lpad(o28_orcprojativ,4,0) as idacao, 
         ' ' as idsubacao, 
         o28_valor as meta 
        from  orcprojativprogramfisica
      inner join orcdotacao  on o58_anousu = o28_anousu and o58_projativ = o28_orcprojativ
      inner join orcunidade on o58_anousu = o41_anousu and o58_unidade = o41_unidade
      inner join orcorgao on o58_anousu = o40_anousu and o58_orgao = o40_orgao
           where o28_anoref = ".db_getsession("DB_anousu")."
        order by codunidadesub,funcao,subfuncao,programa,idacao ";
    }else{
       $sSql = "select * from dadoscomplementareslrf where si170_mesreferencia = '{$this->sDataFinal['6']}' and si170_instit = ". db_getsession("DB_instit") . 'limit 0';
    }
   
    $rsResult10 = db_query($sSql);
    
    for ($iCont10 = 0; $iCont10 < pg_num_rows($rsResult10); $iCont10++) {

      $clmetareal10 = new cl_metareal102016();
      $oDados10 = db_utils::fieldsMemory($rsResult10, $iCont10);

      $clmetareal10->si171_tiporegistro    = 10;
      $clmetareal10->si171_codorgao        = $sCodorgao;
      $clmetareal10->si171_codunidadesub   = $oDados10->codunidadesub;
      $clmetareal10->si171_codfuncao       = $oDados10->funcao;
      $clmetareal10->si171_codsubfuncao    = $oDados10->subfuncao;
      $clmetareal10->si171_codprograma     = $oDados10->programa;
      $clmetareal10->si171_idacao          = $oDados10->idacao;
      $clmetareal10->si171_idsubacao       = 0;
      $clmetareal10->si171_metarealizada   = $oDados10->meta;
      $clmetareal10->si171_justificativa   = " ";
      $clmetareal10->si171_mes             = $this->sDataFinal['5'].$this->sDataFinal['6'];
      $clmetareal10->si171_instit          = db_getsession("DB_instit");

      $clmetareal10->incluir(null);
      
      if ($clmetareal10->erro_status == 0) {
        throw new Exception($clmetareal10->erro_msg);
      }

    }

    db_fim_transacao();

    $oGerarMETAREAL = new GerarMETAREAL();
    $oGerarMETAREAL->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarMETAREAL->gerarDados();

  }

}