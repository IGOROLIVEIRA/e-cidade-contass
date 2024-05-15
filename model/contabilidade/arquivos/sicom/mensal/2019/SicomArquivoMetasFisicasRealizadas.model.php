<?php

require_once ("model/iPadArquivoBaseCSV.interface.php");
require_once ("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");
require_once ("classes/db_metareal102019_classe.php");
require_once ("model/contabilidade/arquivos/sicom/mensal/geradores/2019/GerarMETAREAL.model.php");

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

  protected $iCodigoPespectiva;

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

    $clmetareal10 = new cl_metareal102019();

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

    if($this->sDataFinal['5'].$this->sDataFinal['6'] == 12 && InstituicaoRepository::getInstituicaoByCodigo(db_getsession('DB_instit'))->getTipoInstit() == Instituicao::TIPO_INSTIT_PREFEITURA){

      require_once ("model/ppaVersao.model.php");
      require_once ("model/ppadespesa.model.php");

      $oPPAVersao  = new ppaVersao($this->getCodigoPespectiva());
      $oPPADespesa = new ppaDespesa($this->getCodigoPespectiva());

      $sSql  = "SELECT * FROM db_config ";
      $sSql .= "  WHERE prefeitura = 't'";

      $rsInst = db_query($sSql);
      $sCnpj  = db_utils::fieldsMemory($rsInst, 0)->cgc;

      $sSqlInstit  = "SELECT codigo FROM db_config ";
      $rsInstit    = db_query($sSqlInstit);

      // Lista das institui??es 
      for ($iCont = 0; $iCont < pg_num_rows($rsInstit); $iCont++) {
        $oReceita =  db_utils::fieldsMemory($rsInstit, $iCont);
        $sListaInstit[] = $oReceita->codigo;
      }

      // Lista das institui??es selecionadas
      $sListaInstit = implode(",",$sListaInstit);

      $sSqlMetasPPA  = " SELECT d.o58_funcao as o08_funcao,
                                d.o58_subfuncao as o08_subfuncao,
                                d.o58_programa as o08_programa,
                                p.o55_projativ,
                                p.o55_descr,
                                p.o55_finali,
                                pr.o22_descrprod,
                                p.o55_descrunidade,
                                p.o55_valorunidade, 
                                d.o58_orgao as o08_orgao, 
                                d.o58_unidade as o08_unidade,
                                si09_codorgaotce,
                                p.o55_valorunidade
                           FROM orcprojativ p
                           JOIN orcdotacao d ON p.o55_anousu = d.o58_anousu AND p.o55_projativ = d.o58_projativ
                           JOIN orcproduto pr ON p.o55_orcproduto = pr.o22_codproduto
                      LEFT JOIN db_config on o58_instit = codigo left join infocomplementaresinstit on codigo = si09_instit
                          WHERE p.o55_anousu = ".db_getsession('DB_anousu')."
                       GROUP BY d.o58_funcao,d.o58_subfuncao,d.o58_programa,p.o55_projativ,p.o55_descr,p.o55_finali,
                                pr.o22_descrprod,p.o55_descrunidade,p.o55_valorunidade,d.o58_orgao, d.o58_unidade,si09_codorgaotce,p.o55_valorunidade";

      //echo $sSqlMetasPPA;exit;
      $rsMetasPPA = db_query($sSqlMetasPPA);
      //db_criatabela($rsMetasPPA);




      $sSqlMetasFisica =" select * from orcprojativprogramfisica order by o28_orcprojativ, o28_anoref";
      $rsMetasFisica = db_query($sSqlMetasFisica);
      //db_criatabela($rsMetasFisica);

      /**
       * pegar estimativas por programa Acao/Projativ
       */
      $oPPADespesa->setInstituicoes($sListaInstit);
      $aDespesa = $oPPADespesa->getQuadroEstimativas(null, 6);

      $aDadosAgrupados = array();
      for ($iCont = 0; $iCont < pg_num_rows($rsMetasPPA); $iCont++) {

        $oMetasPPA =  db_utils::fieldsMemory($rsMetasPPA, $iCont);

        $sHash  = $oMetasPPA->si09_codorgaotce.$org.$unidade.$oMetasPPA->o08_funcao.$oMetasPPA->o08_subfuncao;
        $sHash .= $oMetasPPA->o08_programa.$oMetasPPA->o55_projativ;

        $rsCodTri = db_query("select o41_codtri from orcunidade where o41_unidade =". $oMetasPPA->o08_unidade ." 
          and o41_anousu = ".db_getsession('DB_anousu'));

        $oCodTri = db_utils::fieldsMemory($rsCodTri, 0);

        if($oCodTri == 0) {
          $unidade = $oMetasPPA->o08_unidade;
        }else {
          $unidade = $oCodTri;
        }


        $rsCodTriUnid = db_query("select o41_codtri from orcunidade where o41_unidade = ". $oMetasPPA->o08_unidade ."
        and o41_anousu = ".db_getsession('DB_anousu'));
        $oCodTriUnid = db_utils::fieldsMemory($rsCodTriUnid, 0);

        if($oCodTriUnid->o41_codtri == 0){
          $unidade = $oMetasPPA->o08_unidade;
        }else{
          $unidade = $oCodTriUnid->o41_codtri;
        }

        $rsCodTriOrg = db_query("select o40_codtri from orcorgao where o40_orgao = ". $oMetasPPA->o08_orgao ." 
            and o40_anousu = ".db_getsession('DB_anousu'));
        $oCodTriOrg = db_utils::fieldsMemory($rsCodTriOrg, 0);

        if($oCodTriOrg->o40_codtri == 0){
          $org = $oMetasPPA->o08_orgao;
        }else{
          $org = $oCodTriOrg->o40_codtri;
        }
        if (!isset($aDadosAgrupados[$sHash])) {

          $clmetareal10 = new cl_metareal102019();
          $clmetareal10->si171_tiporegistro    = 10;
          $clmetareal10->si171_codorgao        = str_pad($oMetasPPA->si09_codorgaotce, 2, "0", STR_PAD_LEFT);
          $clmetareal10->si171_codunidadesub   = str_pad($org, 2, "0", STR_PAD_LEFT);
          $clmetareal10->si171_codunidadesub  .= str_pad($unidade, 3, "0", STR_PAD_LEFT);
          $clmetareal10->si171_codfuncao       = str_pad($oMetasPPA->o08_funcao, 2, "0", STR_PAD_LEFT);
          $clmetareal10->si171_codsubfuncao    = str_pad($oMetasPPA->o08_subfuncao, 3, "0", STR_PAD_LEFT);
          $clmetareal10->si171_codprograma     = str_pad($oMetasPPA->o08_programa, 4, "0", STR_PAD_LEFT);
          $clmetareal10->si171_idacao          = str_pad($oMetasPPA->o55_projativ, 4, "0", STR_PAD_LEFT);
          $clmetareal10->si171_idsubacao       = 0;
          $clmetareal10->si171_metarealizada   = 0;
          $clmetareal10->si171_justificativa   = " ";
          $clmetareal10->si171_mes             = $this->sDataFinal['5'].$this->sDataFinal['6'];
          $clmetareal10->si171_instit          = db_getsession("DB_instit");

          $aDadosAgrupados[$sHash] = $clmetareal10;
        }

        for ($iConta = 0; $iConta < pg_num_rows($rsMetasFisica); $iConta++) {
          $oMetasFisica =  db_utils::fieldsMemory($rsMetasFisica, $iConta);
          if($oMetasPPA->o55_projativ == $oMetasFisica->o28_orcprojativ ){
            if($oMetasFisica->o28_anoref == db_getsession("DB_anousu")+2){
              $aDadosAgrupados[$sHash]->si171_metarealizada += $oMetasFisica->o28_valor;
              break;
            }
          }
        }
      }
      //echo "<pre>";print_r($aDadosAgrupados);
      foreach ($aDadosAgrupados as $oDado) {

        $clmetareal = new cl_metareal102019();

        $clmetareal->si171_tiporegistro    = 10;
        $clmetareal->si171_codorgao        = $oDado->si171_codorgao;
        $clmetareal->si171_codunidadesub   = $oDado->si171_codunidadesub;
        $clmetareal->si171_codfuncao       = $oDado->si171_codfuncao;
        $clmetareal->si171_codsubfuncao    = $oDado->si171_codsubfuncao;
        $clmetareal->si171_codprograma     = $oDado->si171_codprograma;
        $clmetareal->si171_idacao          = $oDado->si171_idacao;
        $clmetareal->si171_idsubacao       = 0;
        $clmetareal->si171_metarealizada   = $oDado->si171_metarealizada==""?1:$oDado->si171_metarealizada;
        $clmetareal->si171_justificativa   = " ";
        $clmetareal->si171_mes             = $this->sDataFinal['5'].$this->sDataFinal['6'];
        $clmetareal->si171_instit          = db_getsession("DB_instit");

        $clmetareal->incluir(null);

        if ($clmetareal->erro_status == 0) {
          throw new Exception($clmetareal->erro_msg);
        }

      }
    }
    db_fim_transacao();

    $oGerarMETAREAL = new GerarMETAREAL();
    $oGerarMETAREAL->iMes = $this->sDataFinal['5'].$this->sDataFinal['6'];
    $oGerarMETAREAL->gerarDados();

  }
  public function setCodigoPespectiva($iCodigoPespectiva) {
    $this->iCodigoPespectiva = $iCodigoPespectiva;
  }

  public function getCodigoPespectiva() {
    return $this->iCodigoPespectiva;
  }

}
