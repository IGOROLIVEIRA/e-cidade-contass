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
    /*
     * base retirada do relatorio contido no arquivo orc2_demmetasanuais002.php
     */
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
    
    $sSqlInstit = "SELECT codigo FROM db_config ";
    $rsInstit = db_query($sSqlInstit);
    
    
    // Lista das instituições
    for ($iCont = 0; $iCont < pg_num_rows($rsInstit); $iCont++) {
      
      $oReceita = db_utils::fieldsMemory($rsInstit, $iCont);
      $sListaInstit[] = $oReceita->codigo;
    }
    
    
    $sListaInstit = implode(",", $sListaInstit);
    
    
    $cldb_config = new cl_db_config;
    $clorccenarioeconomicoparam = new cl_orccenarioeconomicoparam();
    $oRelatorioContabil = new relatorioContabil($iCodRel);
    
    
    // Objetos referente as linhas do Relatorio
    $oValorReceitaTotal = new linhaRelatorioContabil($iCodRel, 1);
    $oValorReceitasPrimarias = new linhaRelatorioContabil($iCodRel, 2);
    $oValorDespesaTotal = new linhaRelatorioContabil($iCodRel, 3);
    $oValorDespesasPrimarias = new linhaRelatorioContabil($iCodRel, 4);
    $oValorResultadoPrimario = new linhaRelatorioContabil($iCodRel, 5);
    $oValorResultadoNominal = new linhaRelatorioContabil($iCodRel, 6);
    $oValorDivPublicConsol = new linhaRelatorioContabil($iCodRel, 7);
    $oValorDivConsolLiquid = new linhaRelatorioContabil($iCodRel, 8);
    
    // Busca valores digitados manualmente para cada linha e coluna
    $aValorReceitaTotal = $oValorReceitaTotal->getValoresColunas();
    $aValorReceitasPrimarias = $oValorReceitasPrimarias->getValoresColunas();
    $aValorDespesaTotal = $oValorDespesaTotal->getValoresColunas();
    $aValorDespesasPrimarias = $oValorDespesasPrimarias->getValoresColunas();
    $aValorResultadoPrimario = $oValorResultadoPrimario->getValoresColunas();
    $aValorResultadoNominal = $oValorResultadoNominal->getValoresColunas();
    $aValorDivPublicConsol = $oValorDivPublicConsol->getValoresColunas();
    $aValorDivConsolLiquid = $oValorDivConsolLiquid->getValoresColunas();
    //print_r($aValorReceitaTotal);echo("<br>");
    //print_r($aValorDespesaTotal);exit("<br>");
    // Define todos anos utilizados no relatório apartir do ano de referência
    /*
     * Aqui queria colocar $iAno1 = $iAnoRef e os outros dois somando + 1 e + 2 pra pegar os tres anos que quero
     * porem colocando da forma que falei acima cai no if da linha 205
     * so funciona deixando os anos da forma que tá aqui
     */
    $iAnoRef = db_getsession("DB_anousu");
    $iAno1 = $iAnoRef;
    $iAno2 = $iAnoRef + 1;
    
    /**
     * Retirado pela validação do PPA
     */
    //$iAno3   = $iAnoRef+2;
    
    //Lista todos Anos
    //$aListaAnos = array($iAno1,$iAno2,$iAno3);
    $aListaAnos = array($iAno1, $iAno2);
    
    // Cria objeto valor para cada ano de cada linha
    $oValoresRel = new stdClass();
    $oValoresRel->Corrente = 0;
    $oValoresRel->Constante = 0;
    $oValoresRel->PIB = 0;
    
    $oReceitaTotal = new stdClass();
    $oReceitaTotal->Descricao = "";
    $oReceitaTotal->aValores = array();
    
    // Cria objeto para cada linha do relatório
    $oReceitasPrimarias = clone $oReceitaTotal;
    $oDespesaTotal = clone $oReceitaTotal;
    $oDespesasPrimarias = clone $oReceitaTotal;
    $oResultadoPrimario = clone $oReceitaTotal;
    $oResultadoNominal = clone $oReceitaTotal;
    $oDivPublicConsol = clone $oReceitaTotal;
    $oDivConsolLiquid = clone $oReceitaTotal;
    
    // Cria array com todos objetos "Linhas" do relatório
    $aLista = array($oReceitaTotal, $oReceitasPrimarias, $oDespesaTotal, $oDespesasPrimarias, $oResultadoPrimario, $oResultadoNominal, $oDivPublicConsol, $oDivConsolLiquid);
    
    // Cria dinamicamente o objeto valor para cada linha evitando referência de objetos
    foreach ($aLista as $iInd => $oLinha) {
      foreach ($aListaAnos as $iIndAno => $iAno) {
        ${"oValoresRel" . $iInd} = clone $oValoresRel;
        $oLinha->aValores[$iAno] = ${"oValoresRel" . $iInd};
      }
    }
    
    // Seta descrição de cada linha
    $oReceitaTotal->Descricao       = "Receita Total";
    $oReceitasPrimarias->Descricao  = "Receitas Primárias(I)";
    $oDespesaTotal->Descricao       = "Despesa Total";
    $oDespesasPrimarias->Descricao  = "Despesas Primárias(II)";
    $oResultadoPrimario->Descricao  = "Resultado Primário(III) = (I-II)";
    $oResultadoNominal->Descricao   = "Resultado Nominal";
    $oDivPublicConsol->Descricao    = "Dívida Pública Consolidada";
    $oDivConsolLiquid->Descricao    = "Dívida Consolidada Líquida";
    
    
    // Busca PIB de cada ano
    
    $sCamposDadosPIB = " o03_anoreferencia,                          ";
    $sCamposDadosPIB .= " sum(o03_valorparam) as valor                ";
    
    $sWhereDadosPIB = "     o02_orccenarioeconomicogrupo = 3        ";
    $sWhereDadosPIB .= " and o03_tipovalor                = 2        ";
    //$sWhereDadosPIB  .= " and o03_anoreferencia            between {$iAnoRef} and {$iAno3}";
    $sWhereDadosPIB .= " and o03_anoreferencia            between {$iAnoRef} and {$iAno2}";
    //$sWhereDadosPIB  .= " and o03_instit                   = ".db_getsession('DB_instit');
    $sWhereDadosPIB .= " group by o03_anoreferencia                  ";
    
    $sSqlDadosPIB = $clorccenarioeconomicoparam->sql_query(null, $sCamposDadosPIB, null, $sWhereDadosPIB);
    //die($sSqlDadosPIB);
    $rsDadosPIB = $clorccenarioeconomicoparam->sql_record($sSqlDadosPIB);
    $iLinhasDadosPIB = $clorccenarioeconomicoparam->numrows;
    $aPIB = pg_fetch_array($rsDadosPIB);
    
    if ($iLinhasDadosPIB > 0) {
      for ($iInd = 0; $iInd < $iLinhasDadosPIB; $iInd++) {
        $oDadosPIB = db_utils::fieldsMemory($rsDadosPIB, $iInd);
        $aPIB[$oDadosPIB->o03_anoreferencia] = $oDadosPIB->valor;
      }
    }
    //if ( !array_key_exists($iAno1,$aPIB) || !array_key_exists($iAno2,$aPIB) || !array_key_exists($iAno3,$aPIB)) {
    if (!array_key_exists($iAno1, $aPIB) || !array_key_exists($iAno2, $aPIB)) {
      throw new Exception("Valor do PIB do Cenário Macroeconômico não informado!", 4);
    }
    
    //print_r($aValorReceitaTotal);exit;
    
    // Busca taxa de inflação de cada ano
    $sCamposDadosTaxaInf = " o03_anoreferencia,                          ";
    $sCamposDadosTaxaInf .= " sum(o03_valorparam) as valor                ";
    
    $sWhereDadosTaxaInf = "     o02_orccenarioeconomicogrupo = 2        ";
    //$sWhereDadosTaxaInf  .= " and o03_anoreferencia            between {$iAnoRef} and {$iAno3}";
    $sWhereDadosTaxaInf .= " and o03_anoreferencia            between {$iAnoRef} and {$iAno2}";
    //$sWhereDadosTaxaInf  .= " and o03_instit                   = ".db_getsession('DB_instit');
    $sWhereDadosTaxaInf .= " group by o03_anoreferencia                  ";
    
    $sSqlDadosTaxaInf = $clorccenarioeconomicoparam->sql_query(null, $sCamposDadosTaxaInf, null, $sWhereDadosTaxaInf);
    $rsDadosTaxaInf = $clorccenarioeconomicoparam->sql_record($sSqlDadosTaxaInf);
    $iLinhasDadosTaxaInf = $clorccenarioeconomicoparam->numrows;
    
    if ($iLinhasDadosTaxaInf > 0) {
      for ($iInd = 0; $iInd < $iLinhasDadosTaxaInf; $iInd++) {
        $oDadosTaxaInf = db_utils::fieldsMemory($rsDadosTaxaInf, $iInd);
        $aValTaxaDefla[$oDadosTaxaInf->o03_anoreferencia] = 1 + ($oDadosTaxaInf->valor / 100);
      }
    }
    
    //if ( !array_key_exists($iAno1,$aValTaxaDefla) || !array_key_exists($iAno2,$aValTaxaDefla) || !array_key_exists($iAno3,$aValTaxaDefla)) {
    if (!array_key_exists($iAno1, $aValTaxaDefla) || !array_key_exists($iAno2, $aValTaxaDefla)) {
      throw new Exception("Valor das taxa de inflação do Cenário Macroeconômico não informado!");
    }
    
    // Calcula taxa de deflação de cada ano
    $aTaxaDefla[$iAno1] = $aValTaxaDefla[$iAno1];
    $aTaxaDefla[$iAno2] = $aTaxaDefla[$iAno1] * $aValTaxaDefla[$iAno2];
    //$aTaxaDefla[$iAno3] = $aTaxaDefla[$iAno2] * $aValTaxaDefla[$iAno3];
    
    
    $oPPAReceita = new ppaReceita($this->getCodigoPespectiva());
    $oPPADespesa = new ppaDespesa($this->getCodigoPespectiva());
    
    $oPPAReceita->setInstituicoes($sListaInstit);
    $oPPADespesa->setInstituicoes($sListaInstit);
    
    // Busca todos dados da Receita
    try {
      $aEstimativaReceita = $oPPAReceita->getQuadroEstimativas();
    } catch (Exception $eException) {
      $aEstimativaReceita = array();
    }
    
    
    // Busca todos dados da Despesa
    try {
      $aEstimativaDespesa = $oPPADespesa->getQuadroEstimativas("", 7);
    } catch (Exception $eException) {
      $aEstimativaDespesa = array();
    }
    
    foreach ($aListaAnos as $iIndAno => $iAno) {
      $aExcecaoPrimaria[$iAno] = 0;
    }
    
    // Busca valores "Corrente" da Receita para cada ano
    foreach ($aEstimativaReceita as $iInd => $oReceita) {
      
      if (substr($oReceita->iEstrutural, 0, 4) == 4000 || substr($oReceita->iEstrutural, 0, 4) == 9000) {
        
        foreach ($aListaAnos as $iIndAno => $iAno) {
          $oReceitaTotal->aValores[$iAno]->Corrente += $oReceita->aEstimativas[$iAno];
        }
        
      }
      
      if ($oReceita->iEstrutural == 413250000000000 || $oReceita->iEstrutural == 421000000000000 || $oReceita->iEstrutural == 423000000000000 || $oReceita->iEstrutural == 422000000000000) {
        
        foreach ($aListaAnos as $iIndAno => $iAno) {
          $aExcecaoPrimaria[$iAno] += $oReceita->aEstimativas[$iAno];
        }
        
      }
      
    }
    
    
    foreach ($aListaAnos as $iIndAno => $iAno) {
      $oReceitasPrimarias->aValores[$iAno]->Corrente += $oReceitaTotal->aValores[$iAno]->Corrente - $aExcecaoPrimaria[$iAno];
    }
    
    
    // Busca valores "Corrente" da Despesa para cada ano
    foreach ($aEstimativaDespesa as $iInd => $oDespesa) {
      
      if ($oDespesa->iElemento{0} == 3) {
        
        foreach ($aListaAnos as $iIndAno => $iAno) {
          $oDespesaTotal->aValores[$iAno]->Corrente += $oDespesa->aEstimativas[$iAno];
        }
        
      }
      
      if (substr($oDespesa->iElemento, 0, 3) != 332 && substr($oDespesa->iElemento, 0, 3) != 346) {
        
        foreach ($aListaAnos as $iIndAno => $iAno) {
          $oDespesasPrimarias->aValores[$iAno]->Corrente += $oDespesa->aEstimativas[$iAno];
        }
        
      }
      
    }
    //print_r($aEstimativaDespesa);exit;
    // Soma valores digitados manualmente as suas respectivas linhas e colunas
//$iAno1  = 2011;
    foreach ($aValorReceitaTotal as $iInd => $oLinhaManual) {
      $oReceitaTotal->aValores[$iAno1]->Corrente += $oLinhaManual->colunas[0]->o117_valor;
      $oReceitaTotal->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oReceitaTotal->aValores[$iAno2]->Corrente += $oLinhaManual->colunas[2]->o117_valor;
      $oReceitaTotal->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      //$oReceitaTotal->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      //$oReceitaTotal->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }
    //print_r($aValorReceitaTotal);exit("teste");
    foreach ($aValorReceitasPrimarias as $iInd => $oLinhaManual) {
      $oReceitasPrimarias->aValores[$iAno1]->Corrente += $oLinhaManual->colunas[0]->o117_valor;
      $oReceitasPrimarias->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oReceitasPrimarias->aValores[$iAno2]->Corrente += $oLinhaManual->colunas[2]->o117_valor;
      $oReceitasPrimarias->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      //$oReceitasPrimarias->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      //$oReceitasPrimarias->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }
    
    foreach ($aValorDespesaTotal as $iInd => $oLinhaManual) {
      $oDespesaTotal->aValores[$iAno1]->Corrente += $oLinhaManual->colunas[0]->o117_valor;
      $oDespesaTotal->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oDespesaTotal->aValores[$iAno2]->Corrente += $oLinhaManual->colunas[2]->o117_valor;
      $oDespesaTotal->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      //$oDespesaTotal->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      //$oDespesaTotal->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }
    
    foreach ($aValorDespesasPrimarias as $iInd => $oLinhaManual) {
      $oDespesasPrimarias->aValores[$iAno1]->Corrente += $oLinhaManual->colunas[0]->o117_valor;
      $oDespesasPrimarias->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oDespesasPrimarias->aValores[$iAno2]->Corrente += $oLinhaManual->colunas[2]->o117_valor;
      $oDespesasPrimarias->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      //$oDespesasPrimarias->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      //$oDespesasPrimarias->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }
    
    foreach ($aValorResultadoPrimario as $iInd => $oLinhaManual) {
      $oResultadoPrimario->aValores[$iAno1]->Corrente += $oLinhaManual->colunas[0]->o117_valor;
      $oResultadoPrimario->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oResultadoPrimario->aValores[$iAno2]->Corrente += $oLinhaManual->colunas[2]->o117_valor;
      $oResultadoPrimario->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      //$oResultadoPrimario->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      //$oResultadoPrimario->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }
    
    foreach ($aValorResultadoNominal as $iInd => $oLinhaManual) {
      $oResultadoNominal->aValores[$iAno1]->Corrente += $oLinhaManual->colunas[0]->o117_valor;
      $oResultadoNominal->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oResultadoNominal->aValores[$iAno2]->Corrente += $oLinhaManual->colunas[2]->o117_valor;
      $oResultadoNominal->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      //$oResultadoNominal->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      //$oResultadoNominal->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }
    
    foreach ($aValorDivPublicConsol as $iInd => $oLinhaManual) {
      $oDivPublicConsol->aValores[$iAno1]->Corrente += $oLinhaManual->colunas[0]->o117_valor;
      $oDivPublicConsol->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oDivPublicConsol->aValores[$iAno2]->Corrente += $oLinhaManual->colunas[2]->o117_valor;
      $oDivPublicConsol->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      //$oDivPublicConsol->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      //$oDivPublicConsol->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }
    
    foreach ($aValorDivConsolLiquid as $iInd => $oLinhaManual) {
      $oDivConsolLiquid->aValores[$iAno1]->Corrente += $oLinhaManual->colunas[0]->o117_valor;
      $oDivConsolLiquid->aValores[$iAno1]->Constante += $oLinhaManual->colunas[1]->o117_valor;
      $oDivConsolLiquid->aValores[$iAno2]->Corrente += $oLinhaManual->colunas[2]->o117_valor;
      $oDivConsolLiquid->aValores[$iAno2]->Constante += $oLinhaManual->colunas[3]->o117_valor;
      //$oDivConsolLiquid->aValores[$iAno3]->Corrente  += $oLinhaManual->colunas[4]->o117_valor;
      //$oDivConsolLiquid->aValores[$iAno3]->Constante += $oLinhaManual->colunas[5]->o117_valor;
    }
    
    
    foreach ($aListaAnos as $iInd => $iAno) {
      $oResultadoPrimario->aValores[$iAno]->Corrente += $oReceitasPrimarias->aValores[$iAno]->Corrente - $oDespesasPrimarias->aValores[$iAno]->Corrente;
    }
    
    foreach ($aLista as $iInd => $oLinha) {
      foreach ($aListaAnos as $iIndAno => $iAno) {
        $oLinha->aValores[$iAno]->Constante += $oLinha->aValores[$iAno]->Corrente / $aTaxaDefla[$iAno];
        $oLinha->aValores[$iAno]->PIB += ($oLinha->aValores[$iAno]->Corrente / $aPIB[$iAno]) * 100;
      }
    }
    
    for ($iCont = 1; $iCont <= 3; $iCont++) {
      
      $oDadosMTFIS = new stdClass();
      $iAnoUsu = "iAno" . $iCont;
      //exit(number_format($oDespesaTotal->aValores[${$iAnoUsu}]->Corrente, 2, "", ""));
      
      if (${$iAnoUsu}) {
        $oDadosMTFIS->exercicio = ${$iAnoUsu};
      } else {
        $oDadosMTFIS->exercicio = '2018';
      }
      $oDadosMTFIS->vlCorrenteReceitaTotal              = number_format($oReceitaTotal->aValores[${$iAnoUsu}]->Corrente, 2, ",", "");
      $oDadosMTFIS->vlCorrenteReceitaPrimaria           = number_format($oReceitasPrimarias->aValores[${$iAnoUsu}]->Corrente, 2, ",", "");
      $oDadosMTFIS->vlCorrenteDespesaTotal              = number_format($oDespesaTotal->aValores[${$iAnoUsu}]->Corrente, 2, ",", "");
      $oDadosMTFIS->vlCorrenteDespesaPrimaria           = number_format($oDespesasPrimarias->aValores[${$iAnoUsu}]->Corrente, 2, ",", "");
      $oDadosMTFIS->vlResultadoPrimario                 = number_format($oResultadoPrimario->aValores[${$iAnoUsu}]->Corrente, 2, ",", "");// agora chama vlCorrenteResultadoPrimario
      $oDadosMTFIS->vlCorrenteResultadoNominal          = number_format($oResultadoNominal->aValores[${$iAnoUsu}]->Corrente, 2, ",", "");
      $oDadosMTFIS->vlCorrenteDividaPublicaConsolidada  = number_format($oDivPublicConsol->aValores[${$iAnoUsu}]->Corrente, 2, ",", "");
      $oDadosMTFIS->vlCorrenteDividaConsolidadaLiquida  = number_format($oDivConsolLiquid->aValores[${$iAnoUsu}]->Corrente, 2, ",", "");
      $oDadosMTFIS->vlConstanteReceitaTotal             = number_format($oReceitaTotal->aValores[${$iAnoUsu}]->Constante, 2, ",", "");
      $oDadosMTFIS->vlConstanteReceitaPrimaria          = number_format($oResultadoPrimario->aValores[${$iAnoUsu}]->Constante, 2, ",", "");
      $oDadosMTFIS->vlConstanteDespesaTotal             = number_format($oDespesaTotal->aValores[${$iAnoUsu}]->Constante, 2, ",", "");
      $oDadosMTFIS->vlConstanteDespesaPrimaria          = number_format($oDespesasPrimarias->aValores[${$iAnoUsu}]->Constante, 2, ",", "");
      $oDadosMTFIS->vlConstanteResultadoPrimario        = number_format($oResultadoPrimario->aValores[${$iAnoUsu}]->Constante, 2, ",", "");
      $oDadosMTFIS->vlConstanteResultadoNominal         = number_format($oResultadoNominal->aValores[${$iAnoUsu}]->Constante, 2, ",", "");
      $oDadosMTFIS->vlConstanteDividaPublicaConsolidada = number_format($oDivPublicConsol->aValores[${$iAnoUsu}]->Constante, 2, ",", "");
      $oDadosMTFIS->vlConstanteDividaConsolidadaLiquida = number_format($oDivConsolLiquid->aValores[${$iAnoUsu}]->Constante, 2, ",", "");
      $oDadosMTFIS->pcPIBReceitaTotal                   = number_format($oReceitaTotal->aValores[${$iAnoUsu}]->PIB, 3, ",", "");
      $oDadosMTFIS->pcPIBReceitaPrimaria                = number_format($oReceitasPrimarias->aValores[${$iAnoUsu}]->PIB, 3, ",", "");
      $oDadosMTFIS->pcPIBDespesaTotal                   = number_format($oDespesaTotal->aValores[${$iAnoUsu}]->PIB, 3, ",", "");
      $oDadosMTFIS->pcPIBDespesaPrimaria                = number_format($oDespesasPrimarias->aValores[${$iAnoUsu}]->PIB, 3, ",", "");
      $oDadosMTFIS->pcPIBResultadoPrimario              = number_format($oResultadoPrimario->aValores[${$iAnoUsu}]->PIB, 3, ",", "");
      $oDadosMTFIS->pcPIBResultadoNominal               = number_format($oResultadoNominal->aValores[${$iAnoUsu}]->PIB, 3, ",", "");
      $oDadosMTFIS->pcPIBDividaPublicaConsolidada       = number_format($oDivPublicConsol->aValores[${$iAnoUsu}]->PIB, 3, ",", "");
      $oDadosMTFIS->pcPIBDividaConsolidadaLiquida       = number_format($oDivConsolLiquid->aValores[${$iAnoUsu}]->PIB, 3, ",", "");
      $oDadosMTFIS->vlCorrenteRecPrimariasAdv           = number_format(0, 2, ",", "");
      $oDadosMTFIS->vlConstanteRecPrimariasAdv          = number_format(0, 2, ",", "");
      $oDadosMTFIS->vlCorrenteDspPrimariasGeradas       = number_format(0, 2, ",", "");
      $oDadosMTFIS->vlConstanteDspPrimariasGeradas      = number_format(0, 2, ",", "");
      $oDadosMTFIS->pcPIBrecPrimariasAdv                = number_format(0, 3, ",", "");
      $oDadosMTFIS->pcPIBDspPrimariasGeradas            = number_format(0, 3, ",", "");
      
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