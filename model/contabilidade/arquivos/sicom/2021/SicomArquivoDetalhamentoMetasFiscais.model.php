<?php
require_once("model/iPadArquivoBaseCSV.interface.php");
require_once("model/contabilidade/arquivos/sicom/SicomArquivoBase.model.php");

class SicomArquivoDetalhamentoMetasFiscais extends SicomArquivoBase implements iPadArquivoBaseCSV
{

  protected $iCodigoLayout = 100222;

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

    $aElementos = array("exercicio", "vlCorrenteReceitaTotal","vlCorrenteRecImpTaxContrMelh","vlCorrenteRecContribuicoes","vlCorrenteRecTransfCorr","vlCorrenteDemaisRecPrimCorr", "vlCorrenteRecPrimCap", "vlCorrenteDespesaTotal","vlCorrenteDespPessEncSoc","vlCorrenteOutrasDespCorr", "vlCorrenteDespPrimCap","vlCorrentePagRPDespPrim","vlCorrenteJurEncVarMonAtiv","vlCorrenteJurEncVarMonPass","vlCorrenteDividaPublicaConsolidada","vlCorrenteDividaConsolidadaLiquida", "vlConstanteReceitaTotal","vlConstanteRecImpTaxContrMelh","vlConstanteRecContribuicoes","vlConstanteRecTransfCorr","vlConstanteDemaisRecPrimCorr", "vlConstanteRecPrimCap", "vlConstanteDespesaTotal","vlConstanteDespPessEncSoc","vlConstanteOutrasDespCorr", "vlConstanteDespPrimCap","vlConstantePagRPDespPrim","vlConstanteJurEncVarMonAtiv","vlConstanteJurEncVarMonPass","vlConstanteDividaPublicaConsolidada","vlConstanteDividaConsolidadaLiquida","vlCorrenteRecPrimariasAdv","vlConstanteRecPrimariasAdv","vlCorrenteDspPrimariasGeradas","vlConstanteDspPrimariasGeradas");

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
      require_once("classes/db_mtfis_ldo_classe.php");
      require_once("classes/db_mtfis_anexo_classe.php");

      $clmtfis_ldo = new cl_mtfis_ldo;
      $clmtfis_anexo = new cl_mtfis_anexo;
      //$oPPAVersao = new ppaVersao($this->getCodigoPespectiva());

// Código do Relatório
      //$iCodRel = 64;

// Lista das instituições selecionadas
      //$rsInstit = db_query($sSqlInstit);


      // Lista das instituições
//    for ($iCont = 0; $iCont < pg_num_rows($rsInstit); $iCont++) {
//
//      $oReceita = db_utils::fieldsMemory($rsInstit, $iCont);
//      $sListaInstit[] = $oReceita->codigo;
//    }


      //$sListaInstit = implode(",", $sListaInstit);


      $cldb_config = new cl_db_config;
      $clorccenarioeconomicoparam = new cl_orccenarioeconomicoparam();


      $rsConfig = $cldb_config->sql_record($cldb_config->sql_query_file(db_getsession('DB_instit')));
      $oConfig = db_utils::fieldsMemory($rsConfig, 0);

      $oDadosMTFIS = new stdClass();
      //$iAnoUsu = "iAno" . $iCont;
      //exit(number_format($oDespesaTotal->aValores[${$iAnoUsu}]->Corrente, 2, "", ""));

      $rsLdo = $clmtfis_ldo->sql_record($clmtfis_ldo->sql_query('', 'mtfis_sequencial,mtfis_anoinicialldo','',"mtfis_anoinicialldo = ".db_getsession("DB_anousu")));

      //db_criatabela($rsLdo);exit;
      //db_fieldsmemory($clmtfis_ldo->sql_record($clmtfis_ldo->sql_query('','mtfis_anoinicialldo')), 0);

      $dadosLdo = db_utils::fieldsMemory($rsLdo, 0);

      //print_r($clmtfis_anexo->sql_query('','','',"mtfisanexo_especificacao = 'Receita Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial"));exit;
      //echo db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('','*','',"mtfisanexo_especificacao = 'Receita Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1;exit;

      for ($iCont = 0; $iCont <= 3; $iCont++) {
          $oDadosMTFIS = new stdClass();
          if($iCont == 1) {
              $oDadosMTFIS->exercicio = db_getsession("DB_anousu");
              $oDadosMTFIS->vlCorrenteReceitaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecImpTaxContrMelh = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Impostos, Taxas e Contribuições de Melhoria' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecContribuicoes = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Contribuições' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecTransfCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Transferências Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDemaisRecPrimCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Demais Receitas Primárias Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDespesaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesa Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDespPessEncSoc = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas de  Pessoal e Encargos Sociais' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteOutrasDespCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Outras Despesas Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDespPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrentePagRPDespPrim = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteJurEncVarMonAtiv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Ativos (IV)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteJurEncVarMonPass = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Passivos (V)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDividaPublicaConsolidada = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Pública Consolidada' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDividaConsolidadaLiquida = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Consolidada Líquida' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");
              $oDadosMTFIS->vlConstanteReceitaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecImpTaxContrMelh = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Impostos, Taxas e Contribuições de Melhoria' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecContribuicoes = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Contribuições' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecTransfCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Transferências Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteDemaisRecPrimCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Demais Receitas Primárias Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteDespesaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesa Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteDespPessEncSoc = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas de  Pessoal e Encargos Sociais' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteOutrasDespCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Outras Despesas Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteDespPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstantePagRPDespPrim = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteJurEncVarMonAtiv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Ativos (IV)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteJurEncVarMonPass = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Passivos (V)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteDividaPublicaConsolidada = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Pública Consolidada' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");
              $oDadosMTFIS->vlConstanteDividaConsolidadaLiquida = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Consolidada Líquida' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");

              $oDadosMTFIS->vlCorrenteRecPrimariasAdv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita primária advindas de PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");

              $oDadosMTFIS->vlConstanteRecPrimariasAdv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita primária advindas de PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");

              $oDadosMTFIS->vlCorrenteDspPrimariasGeradas = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas primária geradas por PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente1, 2, ",", "");

              $oDadosMTFIS->vlConstanteDspPrimariasGeradas = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas primária geradas por PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante1, 2, ",", "");

              $this->aDados[] = $oDadosMTFIS;
          }elseif($iCont == 2){
              $oDadosMTFIS->exercicio = db_getsession("DB_anousu") + 1;
              $oDadosMTFIS->vlCorrenteReceitaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecImpTaxContrMelh = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Impostos, Taxas e Contribuições de Melhoria' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecContribuicoes = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Contribuições' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecTransfCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Transferências Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDemaisRecPrimCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Demais Receitas Primárias Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDespesaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesa Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDespPessEncSoc = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas de  Pessoal e Encargos Sociais' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteOutrasDespCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Outras Despesas Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDespPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrentePagRPDespPrim = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteJurEncVarMonAtiv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Ativos (IV)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteJurEncVarMonPass = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Passivos (V)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDividaPublicaConsolidada = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Pública Consolidada' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDividaConsolidadaLiquida = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Consolidada Líquida' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");
              $oDadosMTFIS->vlConstanteReceitaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecImpTaxContrMelh = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Impostos, Taxas e Contribuições de Melhoria' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecContribuicoes = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Contribuições' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecTransfCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Transferências Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteDemaisRecPrimCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Demais Receitas Primárias Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteDespesaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesa Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteDespPessEncSoc = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas de  Pessoal e Encargos Sociais' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteOutrasDespCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Outras Despesas Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteDespPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstantePagRPDespPrim = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteJurEncVarMonAtiv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Ativos (IV)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteJurEncVarMonPass = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Passivos (V)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteDividaPublicaConsolidada = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Pública Consolidada' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");
              $oDadosMTFIS->vlConstanteDividaConsolidadaLiquida = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Consolidada Líquida' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");

              $oDadosMTFIS->vlCorrenteRecPrimariasAdv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita primária advindas de PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");

              $oDadosMTFIS->vlConstanteRecPrimariasAdv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita primária advindas de PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");

              $oDadosMTFIS->vlCorrenteDspPrimariasGeradas = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas primária geradas por PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente2, 2, ",", "");

              $oDadosMTFIS->vlConstanteDspPrimariasGeradas = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas primária geradas por PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante2, 2, ",", "");

              $this->aDados[] = $oDadosMTFIS;
          }elseif($iCont == 3){
              $oDadosMTFIS->exercicio = db_getsession("DB_anousu") + 2;
              $oDadosMTFIS->vlCorrenteReceitaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecImpTaxContrMelh = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Impostos, Taxas e Contribuições de Melhoria' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecContribuicoes = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Contribuições' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecTransfCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Transferências Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDemaisRecPrimCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Demais Receitas Primárias Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteRecPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDespesaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesa Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDespPessEncSoc = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas de  Pessoal e Encargos Sociais' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteOutrasDespCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Outras Despesas Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDespPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrentePagRPDespPrim = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteJurEncVarMonAtiv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Ativos (IV)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteJurEncVarMonPass = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Passivos (V)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDividaPublicaConsolidada = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Pública Consolidada' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlCorrenteDividaConsolidadaLiquida = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Consolidada Líquida' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");
              $oDadosMTFIS->vlConstanteReceitaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecImpTaxContrMelh = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Impostos, Taxas e Contribuições de Melhoria' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecContribuicoes = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Contribuições' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecTransfCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas de Transferências Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteDemaisRecPrimCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Demais Receitas Primárias Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteRecPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receitas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteDespesaTotal = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesa Total' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteDespPessEncSoc = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas de  Pessoal e Encargos Sociais' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteOutrasDespCorr = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Outras Despesas Correntes' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteDespPrimCap = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstantePagRPDespPrim = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas Primárias de Capital' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteJurEncVarMonAtiv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Ativos (IV)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteJurEncVarMonPass = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Juros, Encargos e Variáveis Monetárias Passivos (V)' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteDividaPublicaConsolidada = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Pública Consolidada' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");
              $oDadosMTFIS->vlConstanteDividaConsolidadaLiquida = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Dívida Consolidada Líquida' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");

              $oDadosMTFIS->vlCorrenteRecPrimariasAdv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita primária advindas de PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");

              $oDadosMTFIS->vlConstanteRecPrimariasAdv = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Receita primária advindas de PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");

              $oDadosMTFIS->vlCorrenteDspPrimariasGeradas = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas primária geradas por PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorcorrente3, 2, ",", "");

              $oDadosMTFIS->vlConstanteDspPrimariasGeradas = number_format(db_utils::fieldsMemory($clmtfis_anexo->sql_record($clmtfis_anexo->sql_query('', '*', '', "mtfisanexo_especificacao = 'Despesas primária geradas por PPP' and mtfisanexo_ldo = $dadosLdo->mtfis_sequencial")), 0)->mtfisanexo_valorconstante3, 2, ",", "");

              $this->aDados[] = $oDadosMTFIS;
          }
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
