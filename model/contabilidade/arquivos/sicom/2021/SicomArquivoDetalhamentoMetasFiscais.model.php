<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoDetalhamentoMetasFiscais extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  protected $iCodigoLayout = 143;

  protected $sNomeArquivo = 'MTFIS';

  protected $iCodigoPespectiva;

  public function __construct()
  {

  }

  public function getCodigoLayout()
  {
    return $this->iCodigoLayout;
  }

  /**
   *esse metodo sera implementado criando um array com os campos que serao necessarios para o escritor gerar o arquivo CSV
   */
  public function getCampos()
  {

    $aElementos = array("exercicio", "vlCorrenteReceitaTotal", "vlCorrenteReceitaPrimaria", "vlCorrenteDespesaTotal", "vlCorrenteDespesaPrimaria", "vlResultadoPrimario", "vlCorrenteResultadoNominal", "vlCorrenteDividaPublicaConsolidada", "vlCorrenteDividaConsolidadaLiquida", "vlConstanteReceitaTotal", "vlConstanteReceitaPrimaria", "vlConstanteDespesaTotal", "vlConstanteDespesaPrimaria", "vlConstanteResultadoPrimario", "vlConstanteResultadoNominal", "vlConstanteDividaPublicaConsolidada", "vlConstanteDividaConsolidadaLiquida", "pcPIBReceitaTotal", "pcPIBReceitaPrimaria", "pcPIBDespesaTotal", "pcPIBDespesaPrimaria", "pcPIBResultadoPrimario", "pcPIBResultadoNominal", "pcPIBDividaPublicaConsolidada", "pcPIBDividaConsolidadaLiquida", "vlCorrenteRecPrimariasAdv", "vlConstanteRecPrimariasAdv", "vlCorrenteDspPrimariasGeradas", "vlConstanteDspPrimariasGeradas", "pcPIBrecPrimariasAdv", "pcPIBDspPrimariasGeradas",);

    return $aElementos;
  }

  public function gerarDados()
  {
    require_once("libs/db_sql.php");
    require_once("libs/db_utils.php");
    require_once("classes/db_db_config_classe.php");
    require_once("libs/db_liborcamento.php");
    require_once("libs/db_libcontabilidade.php");
    require_once("classes/db_orccenarioeconomicoparam_classe.php");
    require_once("dbforms/db_funcoes.php");
    require_once("model/linhaRelatorioContabil.model.php");
    require_once("model/relatorioContabil.model.php");
    require_once("std/db_stdClass.php");
    require_once("model/ppa.model.php");
    require_once("model/ppaReceita.model.php");
    require_once("model/ppadespesa.model.php");
    require_once("model/ppaVersao.model.php");


    $oPPAVersao = new ppaVersao($this->getCodigoPespectiva());
// Código do Relatório
    $iCodRel = 64;

// Lista das instituições selecionadas
    $rsInstit = db_query($sSqlInstit);


    // Lista das instituições
    for ($iCont = 0; $iCont < pg_num_rows($rsInstit); $iCont++) {

      $oReceita = db_utils::fieldsMemory($rsInstit, $iCont);
      $sListaInstit[] = $oReceita->codigo;
    }


    $sListaInstit = implode(",", $sListaInstit);


    $cldb_config                = new cl_db_config;
    $clorccenarioeconomicoparam = new cl_orccenarioeconomicoparam();
    $oRelatorioContabil         = new relatorioContabil($iCodRel);


// Objetos referente as linhas do Relatório
    $oValorReceitaTotal             = new linhaRelatorioContabil($iCodRel,1);
    $oValorReceitasPrimarias        = new linhaRelatorioContabil($iCodRel,2);
    $oValorDespesaTotal             = new linhaRelatorioContabil($iCodRel,3);
    $oValorDespesasPrimarias        = new linhaRelatorioContabil($iCodRel,4);
    $oValorResultadoPrimario        = new linhaRelatorioContabil($iCodRel,5);
    $oValorResultadoNominal         = new linhaRelatorioContabil($iCodRel,6);
    $oValorDivPublicConsol          = new linhaRelatorioContabil($iCodRel,7);
    $oValorDivConsolLiquid          = new linhaRelatorioContabil($iCodRel,8);
    $oValorReceitaPrimariaAdvindas  = new linhaRelatorioContabil($iCodRel,9);
    $oValorDespesasPrimariasGeradas = new linhaRelatorioContabil($iCodRel,10);
    $oValorImpactoSaldo             = new linhaRelatorioContabil($iCodRel,11);

// Busca valores digitados manualmente para cada linha e coluna
    $aValorReceitaTotal             = $oValorReceitaTotal->getValoresColunas();
    $aValorReceitasPrimarias        = $oValorReceitasPrimarias->getValoresColunas();
    $aValorDespesaTotal             = $oValorDespesaTotal->getValoresColunas();
    $aValorDespesasPrimarias        = $oValorDespesasPrimarias->getValoresColunas();
    $aValorResultadoPrimario        = $oValorResultadoPrimario->getValoresColunas();
    $aValorResultadoNominal         = $oValorResultadoNominal->getValoresColunas();
    $aValorDivPublicConsol          = $oValorDivPublicConsol->getValoresColunas();
    $aValorDivConsolLiquid          = $oValorDivConsolLiquid->getValoresColunas();

    $aValorReceitaPrimariaAdvindas  = $oValorReceitaPrimariaAdvindas->getValoresColunas();
    $aValorDespesasPrimariasGeradas = $oValorDespesasPrimariasGeradas->getValoresColunas();
    $aValorImpactoSaldo             = $oValorImpactoSaldo->getValoresColunas();

// Define todos anos utilizados no relatório apartir do ano de referência
    $iAnoRef = db_getsession("DB_anousu")-1;
    $iAno1   = $iAnoRef;
    $iAno2   = $iAnoRef+1;
    $iAno3   = $iAnoRef+2;

//Lista todos Anos
    $aListaAnos = array($iAno1,$iAno2,$iAno3);


// Cria objeto valor para cada ano de cada linha
    $oValoresRel = new stdClass();
    $oValoresRel->Corrente  = 0;
    $oValoresRel->Constante = 0;
    $oValoresRel->PIB       = 0;

    $oReceitaTotal = new stdClass();
    $oReceitaTotal->Descricao  = "";
    $oReceitaTotal->aValores   = array();

// Cria objeto para cada linha do relatório
    $oReceitasPrimarias        = clone $oReceitaTotal;
    $oDespesaTotal             = clone $oReceitaTotal;
    $oDespesasPrimarias        = clone $oReceitaTotal;
    $oResultadoPrimario        = clone $oReceitaTotal;
    $oResultadoNominal         = clone $oReceitaTotal;
    $oDivPublicConsol          = clone $oReceitaTotal;
    $oDivConsolLiquid          = clone $oReceitaTotal;

    $oReceitaPrimariaAdvindas  = clone $oReceitaTotal;
    $oDespesasPrimariasGeradas = clone $oReceitaTotal;
    $oImpactoSaldo             = clone $oReceitaTotal;


// Cria array com todos objetos "Linhas" do relatório
    $aLista = array( $oReceitaTotal,
     $oReceitasPrimarias,
     $oDespesaTotal,
     $oDespesasPrimarias,
     $oResultadoPrimario,
     $oResultadoNominal,
     $oDivPublicConsol,
     $oDivConsolLiquid,
     $oReceitaPrimariaAdvindas,
     $oDespesasPrimariasGeradas,
     $oImpactoSaldo
     );

// Cria dinâmicamente o objeto valor para cada linha evitando referência de objetos
    foreach ( $aLista as $iInd => $oLinha ){
      foreach ( $aListaAnos as $iIndAno => $iAno ) {
        ${"oValoresRel".$iInd}   = clone $oValoresRel;
        $oLinha->aValores[$iAno] = ${"oValoresRel".$iInd};
      }
    }

// Seta descrição de cada linha
    $oReceitaTotal->Descricao              = $oValorReceitaTotal->getDescricaoLinha();
    $oReceitasPrimarias->Descricao         = $oValorReceitasPrimarias->getDescricaoLinha();
    $oDespesaTotal->Descricao              = $oValorDespesaTotal->getDescricaoLinha();
    $oDespesasPrimarias->Descricao         = $oValorDespesasPrimarias->getDescricaoLinha();
    $oResultadoPrimario->Descricao         = $oValorResultadoPrimario->getDescricaoLinha();
    $oResultadoNominal->Descricao          = $oValorResultadoNominal->getDescricaoLinha();
    $oDivPublicConsol->Descricao           = $oValorDivPublicConsol->getDescricaoLinha();
    $oDivConsolLiquid->Descricao           = $oValorDivConsolLiquid->getDescricaoLinha();
    $oReceitaPrimariaAdvindas->Descricao   = $oValorReceitaPrimariaAdvindas->getDescricaoLinha();
    $oDespesasPrimariasGeradas->Descricao  = $oValorDespesasPrimariasGeradas->getDescricaoLinha();
    $oImpactoSaldo->Descricao              = $oValorImpactoSaldo->getDescricaoLinha();


// Busca PIB de cada ano

    $sCamposDadosPIB  = " o03_anoreferencia,                          ";
    $sCamposDadosPIB .= " sum(o03_valorparam) as valor                ";

    $sWhereDadosPIB   = "     o02_orccenarioeconomicogrupo = 3        ";
    $sWhereDadosPIB  .= " and o03_tipovalor                = 2        ";
    $sWhereDadosPIB  .= " and o03_anoreferencia            between {$iAnoRef} and {$iAno3}";
    $sWhereDadosPIB  .= " and o03_instit                   = ".db_getsession('DB_instit');
    $sWhereDadosPIB  .= " group by o03_anoreferencia                  ";

    $sSqlDadosPIB     = $clorccenarioeconomicoparam->sql_query(null,$sCamposDadosPIB,null,$sWhereDadosPIB);
    $rsDadosPIB       = $clorccenarioeconomicoparam->sql_record($sSqlDadosPIB);
    $iLinhasDadosPIB  = $clorccenarioeconomicoparam->numrows;

    if ( $iLinhasDadosPIB > 0 ) {
      for( $iInd=0; $iInd < $iLinhasDadosPIB; $iInd++ ) {
        $oDadosPIB = db_utils::fieldsMemory($rsDadosPIB,$iInd);
        $aPIB[$oDadosPIB->o03_anoreferencia] = $oDadosPIB->valor;
      }
    }

    if ( !array_key_exists($iAno1,$aPIB) ) {
      db_redireciona("db_erros.php?fechar=true&db_erro=1 - Valor do PIB do Cenário Macroeconômico para o exercício $iAno1 não informado!");
    }

    if ( !array_key_exists($iAno2,$aPIB) ) {
      db_redireciona("db_erros.php?fechar=true&db_erro=1 - Valor do PIB do Cenário Macroeconômico para o exercício $iAno2 não informado!");
    }

    if ( !array_key_exists($iAno3,$aPIB)) {
      db_redireciona("db_erros.php?fechar=true&db_erro=1 - Valor do PIB do Cenário Macroeconômico para o exercício $iAno3 não informado!");
    }


// Busca taxa de inflação de cada ano
    $sCamposDadosTaxaInf  = " o03_anoreferencia,                          ";
    $sCamposDadosTaxaInf .= " sum(o03_valorparam) as valor                ";

    $sWhereDadosTaxaInf   = "     o02_orccenarioeconomicogrupo = 2        ";
    $sWhereDadosTaxaInf  .= " and o03_anoreferencia            between {$iAnoRef} and {$iAno3}";
    $sWhereDadosTaxaInf  .= " and o03_instit                   = ".db_getsession('DB_instit');
    $sWhereDadosTaxaInf  .= " group by o03_anoreferencia                  ";

    $sSqlDadosTaxaInf     = $clorccenarioeconomicoparam->sql_query(null,$sCamposDadosTaxaInf,null,$sWhereDadosTaxaInf);
    $rsDadosTaxaInf       = $clorccenarioeconomicoparam->sql_record($sSqlDadosTaxaInf);
    $iLinhasDadosTaxaInf  = $clorccenarioeconomicoparam->numrows;

    if ( $iLinhasDadosTaxaInf > 0 ) {
      for ( $iInd=0; $iInd < $iLinhasDadosTaxaInf; $iInd++ ) {
        $oDadosTaxaInf = db_utils::fieldsMemory($rsDadosTaxaInf,$iInd);
        $aValTaxaDefla[$oDadosTaxaInf->o03_anoreferencia] = 1 + ($oDadosTaxaInf->valor/100);
      }
    }

    if ( !array_key_exists($iAno1,$aValTaxaDefla) ) {
      db_redireciona("db_erros.php?fechar=true&db_erro=Valor das taxa de inflação do Cenário Macroeconômico para o exercício $iAno1 não informado!");
    }

    if ( !array_key_exists($iAno2,$aValTaxaDefla) ) {
      db_redireciona("db_erros.php?fechar=true&db_erro=Valor das taxa de inflação do Cenário Macroeconômico para o exercício $iAno2 não informado!");
    }

    if ( !array_key_exists($iAno3,$aValTaxaDefla) ) {
      db_redireciona("db_erros.php?fechar=true&db_erro=Valor das taxa de inflação do Cenário Macroeconômico para o exercício $iAno3 não informado!");
    }

// Calcula taxa de deflação de cada ano
    $aTaxaDefla[$iAno1] = $aValTaxaDefla[$iAno1];
    $aTaxaDefla[$iAno2] = $aTaxaDefla[$iAno1] * $aValTaxaDefla[$iAno2];
    $aTaxaDefla[$iAno3] = $aTaxaDefla[$iAno2] * $aValTaxaDefla[$iAno3];


    $oPPAReceita = new ppaReceita($this->getCodigoPespectiva());
    $oPPADespesa = new ppaDespesa($this->getCodigoPespectiva());

    $oPPAReceita->setInstituicoes($sListaInstit);
    $oPPADespesa->setInstituicoes($sListaInstit);


// Busca todos dados da Receita
    try {
      $aEstimativaReceita = $oPPAReceita->getQuadroEstimativas();
    } catch (Exception $eException ){
      $aEstimativaReceita = array();
    }


// Busca todos dados da Despesa
    try {
      $aEstimativaDespesa = $oPPADespesa->getQuadroEstimativas("",7);
    } catch (Exception $eException ){
      $aEstimativaDespesa = array();
    }


    foreach ( $aListaAnos as $iIndAno => $iAno ) {
      $aExcecaoPrimaria[$iAno] = 0 ;
    }

// Busca valores "Corrente" da Receita para cada ano
    foreach ( $aEstimativaReceita as $iInd => $oReceita ){

      if ( substr($oReceita->iEstrutural,0,4) == 4000 || substr($oReceita->iEstrutural,0,4) == 9000 ) {

        foreach ( $aListaAnos as $iIndAno => $iAno ) {
          $oReceitaTotal->aValores[$iAno]->Corrente += $oReceita->aEstimativas[$iAno];
        }
      }
      if ( $oReceita->iEstrutural == 413250000000000 ||
       $oReceita->iEstrutural == 421000000000000 ||
       $oReceita->iEstrutural == 423000000000000 ||
       $oReceita->iEstrutural == 422000000000000 ) {

        foreach ( $aListaAnos as $iIndAno => $iAno ) {
          $aExcecaoPrimaria[$iAno] += $oReceita->aEstimativas[$iAno];
        }
      }
    }

    foreach ( $aListaAnos as $iIndAno => $iAno ) {
      $oReceitasPrimarias->aValores[$iAno]->Corrente += $oReceitaTotal->aValores[$iAno]->Corrente - $aExcecaoPrimaria[$iAno];
    }

// Busca valores "Corrente" da Despesa para cada ano
    foreach ( $aEstimativaDespesa as $iInd => $oDespesa ) {

      if ( $oDespesa->iElemento{0} == 3 ) {

        foreach ( $aListaAnos as $iIndAno => $iAno ) {
          $oDespesaTotal->aValores[$iAno]->Corrente += $oDespesa->aEstimativas[$iAno];
        }

      }
      if ( substr($oDespesa->iElemento,0,3) != 332 &&
       substr($oDespesa->iElemento,0,3) != 346 ) {

        foreach ( $aListaAnos as $iIndAno => $iAno ) {
          $oDespesasPrimarias->aValores[$iAno]->Corrente += $oDespesa->aEstimativas[$iAno];
        }
      }
    }

// Soma valores digitados manualmente as suas respectivas linhas e colunas

    foreach ( $aValorReceitaTotal as $iInd => $oLinhaManual ){
      $oReceitaTotal->aValores[$iAno1]->Corrente  += $oLinhaManual->colunas[0]->o117_valor;
      $oReceitaTotal->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oReceitaTotal->aValores[$iAno2]->Corrente  += $oLinhaManual->colunas[2]->o117_valor;
      $oReceitaTotal->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      $oReceitaTotal->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      $oReceitaTotal->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }

    foreach ( $aValorReceitasPrimarias as $iInd => $oLinhaManual ){
      $oReceitasPrimarias->aValores[$iAno1]->Corrente  += $oLinhaManual->colunas[0]->o117_valor;
      $oReceitasPrimarias->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oReceitasPrimarias->aValores[$iAno2]->Corrente  += $oLinhaManual->colunas[2]->o117_valor;
      $oReceitasPrimarias->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      $oReceitasPrimarias->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      $oReceitasPrimarias->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }

    foreach ( $aValorDespesaTotal as $iInd => $oLinhaManual ){
      $oDespesaTotal->aValores[$iAno1]->Corrente  += $oLinhaManual->colunas[0]->o117_valor;
      $oDespesaTotal->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oDespesaTotal->aValores[$iAno2]->Corrente  += $oLinhaManual->colunas[2]->o117_valor;
      $oDespesaTotal->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      $oDespesaTotal->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      $oDespesaTotal->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }

    foreach ( $aValorDespesasPrimarias as $iInd => $oLinhaManual ){
      $oDespesasPrimarias->aValores[$iAno1]->Corrente  += $oLinhaManual->colunas[0]->o117_valor;
      $oDespesasPrimarias->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oDespesasPrimarias->aValores[$iAno2]->Corrente  += $oLinhaManual->colunas[2]->o117_valor;
      $oDespesasPrimarias->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      $oDespesasPrimarias->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      $oDespesasPrimarias->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }

    foreach ( $aValorResultadoPrimario as $iInd =>   $oLinhaManual ){
      $oResultadoPrimario->aValores[$iAno1]->Corrente  += $oLinhaManual->colunas[0]->o117_valor;
      $oResultadoPrimario->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oResultadoPrimario->aValores[$iAno2]->Corrente  += $oLinhaManual->colunas[2]->o117_valor;
      $oResultadoPrimario->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      $oResultadoPrimario->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      $oResultadoPrimario->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }

    foreach ( $aValorResultadoNominal as $iInd => $oLinhaManual ){
      $oResultadoNominal->aValores[$iAno1]->Corrente  += $oLinhaManual->colunas[0]->o117_valor;
      $oResultadoNominal->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oResultadoNominal->aValores[$iAno2]->Corrente  += $oLinhaManual->colunas[2]->o117_valor;
      $oResultadoNominal->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      $oResultadoNominal->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      $oResultadoNominal->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }

    foreach ( $aValorDivPublicConsol as $iInd => $oLinhaManual ){
      $oDivPublicConsol->aValores[$iAno1]->Corrente  += $oLinhaManual->colunas[0]->o117_valor;
      $oDivPublicConsol->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oDivPublicConsol->aValores[$iAno2]->Corrente  += $oLinhaManual->colunas[2]->o117_valor;
      $oDivPublicConsol->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      $oDivPublicConsol->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      $oDivPublicConsol->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }

    foreach ( $aValorDivConsolLiquid as $iInd => $oLinhaManual ){
      $oDivConsolLiquid->aValores[$iAno1]->Corrente  += $oLinhaManual->colunas[0]->o117_valor;
      $oDivConsolLiquid->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oDivConsolLiquid->aValores[$iAno2]->Corrente  += $oLinhaManual->colunas[2]->o117_valor;
      $oDivConsolLiquid->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      $oDivConsolLiquid->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      $oDivConsolLiquid->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }

    foreach ( $aValorReceitaPrimariaAdvindas as $iInd => $oLinhaManual ){
      $oReceitaPrimariaAdvindas->aValores[$iAno1]->Corrente  += $oLinhaManual->colunas[0]->o117_valor;
      $oReceitaPrimariaAdvindas->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oReceitaPrimariaAdvindas->aValores[$iAno2]->Corrente  += $oLinhaManual->colunas[2]->o117_valor;
      $oReceitaPrimariaAdvindas->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      $oReceitaPrimariaAdvindas->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      $oReceitaPrimariaAdvindas->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }

    foreach ( $aValorDespesasPrimariasGeradas as $iInd => $oLinhaManual ){
      $oDespesasPrimariasGeradas->aValores[$iAno1]->Corrente  += $oLinhaManual->colunas[0]->o117_valor;
      $oDespesasPrimariasGeradas->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oDespesasPrimariasGeradas->aValores[$iAno2]->Corrente  += $oLinhaManual->colunas[2]->o117_valor;
      $oDespesasPrimariasGeradas->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      $oDespesasPrimariasGeradas->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      $oDespesasPrimariasGeradas->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }

    foreach ( $aValorImpactoSaldo as $iInd => $oLinhaManual ){
      $oImpactoSaldo->aValores[$iAno1]->Corrente  += $oLinhaManual->colunas[0]->o117_valor;
      $oImpactoSaldo->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oImpactoSaldo->aValores[$iAno2]->Corrente  += $oLinhaManual->colunas[2]->o117_valor;
      $oImpactoSaldo->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      $oImpactoSaldo->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      $oImpactoSaldo->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }
/*
$oImpactoSaldo
*/


foreach ( $aListaAnos as $iInd => $iAno ) {
  $oResultadoPrimario->aValores[$iAno]->Corrente += $oReceitasPrimarias->aValores[$iAno]->Corrente -
  $oDespesasPrimarias->aValores[$iAno]->Corrente;
}

foreach ( $aLista as $iInd => $oLinha ){
  foreach ( $aListaAnos as $iIndAno => $iAno ){
   $oLinha->aValores[$iAno]->Constante += $oLinha->aValores[$iAno]->Corrente/$aTaxaDefla[$iAno];
   $oLinha->aValores[$iAno]->PIB       += ($oLinha->aValores[$iAno]->Corrente/$aPIB[$iAno])*100;
 }
}

$rsConfig = $cldb_config->sql_record($cldb_config->sql_query_file(db_getsession('DB_instit')));
$oConfig  = db_utils::fieldsMemory($rsConfig,0);

$aRegistrosporAno = array();

//esses 4 foreach reorganizam no array aRegistrosporAno a listagem dos valores na seguinte
//ordem $aRegistrosporAno[<ano>][<descricao da coluna>][<tipo do registro (corrente/constante/pib)>] = $valor;
//a partir da ocorrencia 5058 o sicom passa a ser mais preciso com o relatóro de demonstracao
//alteracao realizada por Marcony
foreach ($aListaAnos as $iano) {

  foreach($aLista as $coluna => $valores){


    foreach($valores->aValores as $ano => $oValores){

      foreach($oValores as $nome => $valor){
        if($ano == $iano){
          $aRegistrosporAno[$iano][$valores->Descricao][$nome] = $valor;
        }

      }
    }
  }

}


for ($iCont = 1; $iCont <= 3; $iCont++) {

  $oDadosMTFIS = new stdClass();
  $iAnoUsu = "iAno" . $iCont;
      //exit(number_format($oDespesaTotal->aValores[${$iAnoUsu}]->Corrente, 2, "", ""));

  if (${$iAnoUsu}) {
    $oDadosMTFIS->exercicio = ${$iAnoUsu};
  } else {
    $oDadosMTFIS->exercicio = '2020';
  }

  $oDadosMTFIS->vlCorrenteReceitaTotal = number_format($aRegistrosporAno[${$iAnoUsu}]["Receita Total"]["Corrente"], 2, ",", "");
  $oDadosMTFIS->vlCorrenteReceitaPrimaria = number_format($aRegistrosporAno[${$iAnoUsu}]["Receitas Primárias(I)"]["Corrente"], 2, ",", "");
  $oDadosMTFIS->vlCorrenteDespesaTotal = number_format($aRegistrosporAno[${$iAnoUsu}]["Despesa Total"]["Corrente"], 2, ",", "");
  $oDadosMTFIS->vlCorrenteDespesaPrimaria = number_format($aRegistrosporAno[${$iAnoUsu}]["Despesas Primárias(II)"]["Corrente"], 2, ",", "");
  $oDadosMTFIS->vlResultadoPrimario = number_format($aRegistrosporAno[${$iAnoUsu}]["Resultado Primário(III) = (I-II)"]["Corrente"], 2, ",", "");
  $oDadosMTFIS->vlCorrenteResultadoNominal = number_format($aRegistrosporAno[${$iAnoUsu}]["Resultado Nominal"]["Corrente"], 2, ",", "");
  $oDadosMTFIS->vlCorrenteDividaPublicaConsolidada = number_format($aRegistrosporAno[${$iAnoUsu}]["Dívida Pública Consolidada"]["Corrente"], 2, ",", "");
  $oDadosMTFIS->vlCorrenteDividaConsolidadaLiquida = number_format($aRegistrosporAno[${$iAnoUsu}]["Dívida Consolidada Líquida"]["Corrente"], 2, ",", "");
  $oDadosMTFIS->vlConstanteReceitaTotal = number_format($aRegistrosporAno[${$iAnoUsu}]["Receita Total"]["Constante"], 2, ",", "");
  $oDadosMTFIS->vlConstanteReceitaPrimaria = number_format($aRegistrosporAno[${$iAnoUsu}]["Receitas Primárias(I)"]["Constante"], 2, ",", "");
  $oDadosMTFIS->vlConstanteDespesaTotal = number_format($aRegistrosporAno[${$iAnoUsu}]["Despesa Total"]["Constante"], 2, ",", "");
  $oDadosMTFIS->vlConstanteDespesaPrimaria = number_format($aRegistrosporAno[${$iAnoUsu}]["Despesas Primárias(II)"]["Constante"], 2, ",", "");
  $oDadosMTFIS->vlConstanteResultadoPrimario = number_format($aRegistrosporAno[${$iAnoUsu}]["Resultado Primário(III) = (I-II)"]["Constante"], 2, ",", "");
  $oDadosMTFIS->vlConstanteResultadoNominal = number_format($aRegistrosporAno[${$iAnoUsu}]["Resultado Nominal"]["Constante"], 2, ",", "");
  $oDadosMTFIS->vlConstanteDividaPublicaConsolidada = number_format($aRegistrosporAno[${$iAnoUsu}]["Dívida Pública Consolidada"]["Constante"], 2, ",", "");
  $oDadosMTFIS->vlConstanteDividaConsolidadaLiquida = number_format($aRegistrosporAno[${$iAnoUsu}]["Dívida Consolidada Líquida"]["Constante"], 2, ",", "");
  $oDadosMTFIS->pcPIBReceitaTotal = number_format($aRegistrosporAno[${$iAnoUsu}]["Receita Total"]["PIB"], 3, ",", "");
  $oDadosMTFIS->pcPIBReceitaPrimaria = number_format($aRegistrosporAno[${$iAnoUsu}]["Receitas Primárias(I)"]["PIB"], 3, ",", "");
  $oDadosMTFIS->pcPIBDespesaTotal = number_format($aRegistrosporAno[${$iAnoUsu}]["Despesa Total"]["PIB"], 3, ",", "");
  $oDadosMTFIS->pcPIBDespesaPrimaria = number_format($aRegistrosporAno[${$iAnoUsu}]["Despesas Primárias(II)"]["PIB"], 3, ",", "");
  $oDadosMTFIS->pcPIBResultadoPrimario = number_format($aRegistrosporAno[${$iAnoUsu}]["Resultado Primário(III) = (I-II)"]["PIB"], 3, ",", "");
  $oDadosMTFIS->pcPIBResultadoNominal = number_format($aRegistrosporAno[${$iAnoUsu}]["Resultado Nominal"]["PIB"], 3, ",", "");
  $oDadosMTFIS->pcPIBDividaPublicaConsolidada = number_format($aRegistrosporAno[${$iAnoUsu}]["Dívida Pública Consolidada"]["PIB"], 3, ",", "");
  $oDadosMTFIS->pcPIBDividaConsolidadaLiquida = number_format($aRegistrosporAno[${$iAnoUsu}]["Dívida Consolidada Líquida"]["PIB"], 3, ",", "");
  $oDadosMTFIS->vlCorrenteRecPrimariasAdv = number_format($aRegistrosporAno[${$iAnoUsu}]["Receitas Primárias Advindas de PPP (IV)"]["Corrente"], 2, ",", "");
  $oDadosMTFIS->vlConstanteRecPrimariasAdv = number_format($aRegistrosporAno[${$iAnoUsu}]["Receitas Primárias Advindas de PPP (IV)"]["Constante"], 2, ",", "");
  $oDadosMTFIS->vlCorrenteDspPrimariasGeradas = number_format($aRegistrosporAno[${$iAnoUsu}]["Despesas Primárias Geradas por PPP (V)"]["Corrente"], 2, ",", "");
  $oDadosMTFIS->vlConstanteDspPrimariasGeradas = number_format($aRegistrosporAno[${$iAnoUsu}]["Despesas Primárias Geradas por PPP (V)"]["Constante"], 2, ",", "");
  $oDadosMTFIS->pcPIBrecPrimariasAdv = number_format($aRegistrosporAno[${$iAnoUsu}]["Receitas Primárias Advindas de PPP (IV)"]["PIB"], 3, ",", "");
  $oDadosMTFIS->pcPIBDspPrimariasGeradas = number_format($aRegistrosporAno[${$iAnoUsu}]["Despesas Primárias Geradas por PPP (V)"]["PIB"], 3, ",", "");

  $this->aDados[] = $oDadosMTFIS;
}

}

public function setCodigoPespectiva($iCodigoPespectiva)
{
  $this->iCodigoPespectiva = $iCodigoPespectiva;
}

public function getCodigoPespectiva()
{
  return $this->iCodigoPespectiva;
}
}
