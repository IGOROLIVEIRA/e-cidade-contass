<?php

require_once("fpdf151/pdf.php");
require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_sql.php");

header("Content-type: text/plain");
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");

$oGet = db_utils::postMemory($_GET);

/**
 * Periodo de calculo da folha
 */
$iAno = db_anofolha();
$iMes = db_mesfolha();

/**
 * Filtros
 */
$sTipoRelatorio    = $oGet->sTipoRelatorio;
$sTipoFiltro       = $oGet->sTipoFiltro;
$sTipoOrdem        = $oGet->sTipoOrdem;
$lImprimeAfastados = $oGet->lImprimeAfastados == 'true' ? true : false;

$sSelecionados     = '';
$sWhereSelecao     = '';
$iIntervaloInicial = 0;
$iIntervaloFinal   = 0;
$iRegime           = 0;

/**
 * Data do perido das ferias
 */
$sDataPesquisa = implode("-", array_reverse(explode("/",$oGet->periodo)));

/**
 * Intervalo inicial
 * tipo de filtro, intervalo
 */
if ( !empty($oGet->iIntervaloInicial) ) {
  $iIntervaloInicial = $oGet->iIntervaloInicial;
}

/**
 * Intervalo final
 * tipo de filtro, intervalo
 */
if ( !empty($oGet->iIntervaloFinal) ) {
  $iIntervaloFinal = $oGet->iIntervaloFinal;
}

/**
 * string com os codigos dos registros pelo tipo do relatorio
 */
if ( !empty($oGet->sSelecionados) ) {
  $sSelecionados = $oGet->sSelecionados;
}

if ( !empty($oGet->iRegime) ) {
  $iRegime = $oGet->iRegime;
}


/**
 * Periodo da pessoalmov
 */
$sWhereFuncionarios  = "       rh02_anousu = $iAno ";
$sWhereFuncionarios .= "   and rh02_mesusu = $iMes ";

/**
 * SELECAO
 * procura na tabela selecao o campo r44_where e adiciona no where dos funcionarios
 */
if ( !empty($oGet->iSelecao) && (int) $oGet->iSelecao > 0 ) {

  $oDaoSelecao = db_utils::getDao('selecao');
  $sSqlSelecao = $oDaoSelecao->sql_query_file((int) $oGet->iSelecao);
  $rsSelecao   = $oDaoSelecao->sql_record($sSqlSelecao);

  if ( $oDaoSelecao->numrows > 0 ) {

    $oSelecao = db_utils::fieldsMemory($rsSelecao, 0);
    $sWhereFuncionarios .= " and {$oSelecao->r44_where} ";
  }
}

/**
 * INSTITUICAO
 */
$sWhereFuncionarios .= " and rh02_instit = " . db_getsession("DB_instit") . " ";

/**
 * Codigo do regime
 * 1 - Estatutário
 * 2 - CLT
 * 3 - Extra Quadro
 */
if ( !empty($iRegime) ) {
  $sWhereFuncionarios .= " and rh30_regime = {$iRegime}";
}

/**
 * AFASTAMENTO
 * Procura funcionarios que nao possuam afastamento em aberto
 */
$sWhereFuncionarios .= " and not exists(select true                      ";
$sWhereFuncionarios .= "                  from afasta                    ";
$sWhereFuncionarios .= "                 where r45_regist = rh01_regist  ";
$sWhereFuncionarios .= "                   and r45_anousu = rh02_anousu and r45_mesusu = rh02_mesusu  ";
$sWhereFuncionarios .= "                   and r45_dtreto is null)       ";

/**
 * AFASTAMENTO
 * usuario marcou imprime afastados: nao, no formulario
 * Nao busca servidores com afastamento na data atual, DB_datausu
 */
if ( !$lImprimeAfastados ) {

  $sWhereFuncionarios .= " and not exists( select true                                                                ";
  $sWhereFuncionarios .= "                   from afasta                                                              ";
  $sWhereFuncionarios .= "                  where r45_regist = rh01_regist                                            ";
  $sWhereFuncionarios .= "                   and r45_anousu = rh02_anousu and r45_mesusu = rh02_mesusu  ";
  $sWhereFuncionarios .= "                    and fc_getsession('DB_datausu')::date between r45_dtafas and r45_dtreto ";
  $sWhereFuncionarios .= "               )                                                                            ";
}

/**
 * ADMISSAO
 * Busca com data de admisao menor ou igual ao periodo informado
 */
$sWhereFuncionarios .= " and rh01_admiss::date <= '{$sDataPesquisa}' ";

/**
 * RESCISAO
 * Servidores sem rescisao ou com data de rescisao maior ou igual a data do perido informado
 */
$sWhereFuncionarios .= " and not exists( select true                                   ";
$sWhereFuncionarios .= "                   from rhpesrescisao                          ";
$sWhereFuncionarios .= "                  where rh05_seqpes = rh02_seqpes              ";
$sWhereFuncionarios .= "                    and rh05_recis::date <= '{$sDataPesquisa}' ";
$sWhereFuncionarios .= "               )                                               ";

/**
 * Busca apenas servidores ativos
 * A - Ativo, I - Inativo, P - Pensionista
 */
$sWhereFuncionarios .= " and rh30_vinculo = 'A' ";

/**
 * Campos de acordo com o tipo de relatorio escolhido no formulario
 *
 * @var $sTituloAgrupador         - Titulo do agrupador
 * @var $sCampoTipoRelatorio      - campo por tipo de relatorio, usado no where, com in() ou between
 * @var $sCampoAgrupadorCodigo    - campo do codigo do agrupador
 * @var $sCampoAgrupadorDescricao - campo da descricao do agrupador
 */
switch ( $sTipoRelatorio ) {

  /**
   * Tipo de relatorio por ORGAO
   */
  case 'orgao' :

    $sTituloAgrupador         = 'Orgão';
    $sCampoTipoRelatorio      = 'o40_orgao';
    $sCampoAgrupadorCodigo    = "o40_orgao";
    $sCampoAgrupadorDescricao = "o40_descr";

  break;

  /**
   * Tipo de relatorio por LOCACAO
   */
  case 'lotacao' :

    $sTituloAgrupador         = 'Lotação';
    $sCampoTipoRelatorio      = 'rh02_lota';
    $sCampoAgrupadorCodigo    = 'r70_estrut';
    $sCampoAgrupadorDescricao = 'r70_descr';

  break;

  /**
   * Tipo de relatorio por LOCAIS DE TRABALHO
   */
  case 'locaistrabalho' :

    $sTituloAgrupador         = 'Local de trabalho';
    $sCampoTipoRelatorio      = 'rh56_localtrab';
    $sCampoAgrupadorCodigo    = "rh55_estrut";
    $sCampoAgrupadorDescricao = "rh55_descr";

  break;

  /**
   * Tipo de relatorio por MATRICULA
   */
  case 'matricula' :

    $sTituloAgrupador         = 'Matrícula';
    $sCampoTipoRelatorio      = 'rh01_regist';
    $sCampoAgrupadorCodigo    = "rh01_regist";
    $sCampoAgrupadorDescricao = "z01_nome";

  break;

  /**
   * Tipo de relatorio GERAL
   */
  default :

    $sTituloAgrupador         = null;
    $sCampoTipoRelatorio      = null;
    $sCampoAgrupadorCodigo    = "0";
    $sCampoAgrupadorDescricao = "''::text";

  break;
}

/**
 * Monta where por tipo de filtro, selecionado ou intervado de acordo com o tipo do relatorio
 * $sTipoRelatorio: lotacao, orgao, matricula ou local de trabalho
 */
if ( !empty($sCampoTipoRelatorio) ) {

  /**
   * Tipo do filtro, selecionado ou intervado
   */
  switch ($sTipoFiltro) {
    case 'intervalo' :
      $sWhereFuncionarios .= " and {$sCampoTipoRelatorio} between {$iIntervaloInicial} and {$iIntervaloFinal} ";
    break;

    case 'selecionado' :
      $sWhereFuncionarios .= " and {$sCampoTipoRelatorio} in($sSelecionados) ";
    break;
  }
}

/**
 * ORDENACAO - numerica
 * 1º - Codigo agrupador, 2º - descricao agrupador, 3º - matricula, 4º - nome funcionario
 */
$sOrdemFuncionarios = " 6, 7, 1, 2 ";

/**
 * ORDENACAO - alfabetica
 * 1º - Descricao agrupador, 2º codigo agrupador, 3º - nome funcionario, 4º - matricula
 */
if ( $sTipoOrdem == 'alfabetica' ) {
  $sOrdemFuncionarios = " 7, 6, 2, 1 ";
}

/**
 * Campos dos funcionarios
 */
$sCamposFuncionarios  = " rh01_regist, ";
$sCamposFuncionarios .= " z01_nome,    ";
$sCamposFuncionarios .= " rh02_hrsmen, ";
$sCamposFuncionarios .= " rh01_admiss, ";
$sCamposFuncionarios .= " rh37_descr,  ";
$sCamposFuncionarios .= " {$sCampoAgrupadorCodigo}    as agrupador_codigo,   ";
$sCamposFuncionarios .= " {$sCampoAgrupadorDescricao} as agrupador_descricao ";

/**
 * Monta sql dos funcionarios
 */
$sSqlFuncionarios  = "select distinct {$sCamposFuncionarios}                   ";
$sSqlFuncionarios .= "  from rhpessoalmov                                      ";
$sSqlFuncionarios .= "       inner join rhpessoal on rh01_regist = rh02_regist ";

/**
 * Cargo
 */
$sSqlFuncionarios .= " inner join rhfuncao  on rh02_funcao = rh37_funcao ";
$sSqlFuncionarios .= "                     and rh02_instit = rh37_instit ";

/**
 * CGM
 */
$sSqlFuncionarios .= " inner join cgm on rh01_numcgm = z01_numcgm  ";

/**
 * Regime
 */
$sSqlFuncionarios .= " inner join rhregime  on rh30_codreg = rh02_codreg ";
$sSqlFuncionarios .= "                     and rh30_instit = rh02_instit ";

/**
 * Lotacao
 */
$sSqlFuncionarios .= " left join rhlota     on rh02_lota   = r70_codigo   ";
$sSqlFuncionarios .= " left join rhlotaexe  on rh26_codigo = rh02_lota    ";
$sSqlFuncionarios .= "                     and rh26_anousu = rh02_anousu  ";

/**
 * Orgao
 */
$sSqlFuncionarios .= " left join orcorgao  on o40_orgao  = rh26_orgao   ";
$sSqlFuncionarios .= "                    and o40_anousu = rh26_anousu  ";

/**
 * Locais de trabalho
 */
$sSqlFuncionarios .= " left join rhpeslocaltrab  on rh56_seqpes    = rh02_seqpes  ";
$sSqlFuncionarios .= "                          and rh56_princ     = 't'          ";
$sSqlFuncionarios .= " left join rhlocaltrab     on rh56_localtrab = rh55_codigo  ";

/**
 * Where
 */
$sSqlFuncionarios .= " where {$sWhereFuncionarios} ";

/**
 * Subquery
 */
$sSqlFuncionarios = " select * from ({$sSqlFuncionarios}) as subquery order by $sOrdemFuncionarios";
$rsFuncionarios   = db_query($sSqlFuncionarios);


/**
 * Erro na query
 */
if ( !$rsFuncionarios ) {

  $sMensagemErro = 'Erro ao buscar funcionarios: ' . pg_last_error();
  db_redireciona('db_erros.php?fechar=true&db_erro='. urlencode($sMensagemErro) );
  exit;
}

/**
 * Nenhum registro encontrado
 */
if ( pg_num_rows($rsFuncionarios) == 0 ) {

  $sMensagemErro = 'Nen;hum funcionário encontrado com os filtros utilizados.';
  db_redireciona('db_erros.php?fechar=true&db_erro='. urlencode($sMensagemErro) );
  exit;
}

// *
//  * Criamos um array com os agrupadores e seus funcionarios..
//  * teremos um array com a seguinte estrutura:
//  * Agrupador -> Funcionarios -> Dados das Férias abertas

$aAgrupador         = array();
$iTotalFuncionarios = pg_num_rows($rsFuncionarios);

for ($i = 0; $i < $iTotalFuncionarios; $i++) {

  $oDados = db_utils::fieldsMemory($rsFuncionarios, $i);

  if ( !isset($aAgrupador[$oDados->agrupador_codigo]) ) {

    $aAgrupador[$oDados->agrupador_codigo] = new stdClass();
    $aAgrupador[$oDados->agrupador_codigo]->sAgrupadorDescricao = $oDados->agrupador_descricao;
    $aAgrupador[$oDados->agrupador_codigo]->funcionarios        = array();
  }

  $oFuncionario                       = new stdClass();
  $oFuncionario->matricula            = $oDados->rh01_regist;
  $oFuncionario->nome                 = $oDados->z01_nome;
  $oFuncionario->dataadmissao         = db_formatar($oDados->rh01_admiss, "d");
  $oFuncionario->periodogozadoinicial = '';
  $oFuncionario->periodogozadofinal   = '';
  $oFuncionario->periodoaquisitivoini = '';
  $oFuncionario->periodoaquisitivofim = '';
  $oFuncionario->periodosvencidos     = array();

  /**
   * Último período de férias gozados pelo funcionário
   */
  $sSqlUltimoPeriodoGozado  = "SELECT distinct r30_regist,";
  $sSqlUltimoPeriodoGozado .= "       r30_perai, ";
  $sSqlUltimoPeriodoGozado .= "       r30_peraf,";
  $sSqlUltimoPeriodoGozado .= "       r30_per1i,";
  $sSqlUltimoPeriodoGozado .= "       r30_per1f,";
  $sSqlUltimoPeriodoGozado .= "       r30_per2i,";
  $sSqlUltimoPeriodoGozado .= "       r30_per2f,";
  $sSqlUltimoPeriodoGozado .= "       r30_dias1,";
  $sSqlUltimoPeriodoGozado .= "       r30_dias2,";
  $sSqlUltimoPeriodoGozado .= "       r30_ndias ";
  $sSqlUltimoPeriodoGozado .= "  from cadferia ";
  $sSqlUltimoPeriodoGozado .= " where r30_anousu = {$iAno}";
  $sSqlUltimoPeriodoGozado .= "   and r30_mesusu = {$iMes} ";
  $sSqlUltimoPeriodoGozado .= "   and r30_regist = {$oDados->rh01_regist}";
  $sSqlUltimoPeriodoGozado .= " order by r30_perai desc limit 1";
  $rsUltimoPeriodoGozado    = db_query($sSqlUltimoPeriodoGozado);
  $iTemFerias               = pg_num_rows($rsUltimoPeriodoGozado);

  if ($iTemFerias > 0) {

    $oDadosPeriodoGozado                = db_utils::fieldsMemory($rsUltimoPeriodoGozado, 0);
    $oFuncionario->periodogozadoinicial = db_formatar($oDadosPeriodoGozado->r30_per1i, "d");
    $oFuncionario->periodogozadofinal   = db_formatar($oDadosPeriodoGozado->r30_per1f, "d");
    $oFuncionario->periodoaquisitivoini = $oDadosPeriodoGozado->r30_perai;
    $oFuncionario->periodoaquisitivofim = $oDadosPeriodoGozado->r30_peraf;

    if ($oDadosPeriodoGozado->r30_per2f != "") {

      $oFuncionario->periodogozadoinicial = db_formatar($oDadosPeriodoGozado->r30_per2i, "d");
      $oFuncionario->periodogozadofinal   = db_formatar($oDadosPeriodoGozado->r30_per2f, "d");
    }
  }

  /**
   * Verificamos quais as ferias que estão em aberto funcionario.
   * caso o usuario não possui ferias com dias em gozo, devemos calcular o primeiro periodo das ferias
   * acrescentando 1 ano na data de admissao;
   */
  $sSqlFeriasCadastradas  = "SELECT distinct r30_regist,";
  $sSqlFeriasCadastradas .= "       r30_perai, ";
  $sSqlFeriasCadastradas .= "       r30_peraf,";
  $sSqlFeriasCadastradas .= "       r30_per1i,";
  $sSqlFeriasCadastradas .= "       r30_per1f,";
  $sSqlFeriasCadastradas .= "       r30_per2i,";
  $sSqlFeriasCadastradas .= "       r30_per2f,";
  $sSqlFeriasCadastradas .= "       r30_dias1,";
  $sSqlFeriasCadastradas .= "       r30_dias2,";
  $sSqlFeriasCadastradas .= "       r30_ndias, ";
  $sSqlFeriasCadastradas .= "       coalesce(r30_dias1,0)+coalesce(r30_dias2,0) as diasgozados ";
  $sSqlFeriasCadastradas .= "  from cadferia ";
  $sSqlFeriasCadastradas .= " where coalesce(r30_dias1,0)+coalesce(r30_dias2,0) < r30_ndias ";
  $sSqlFeriasCadastradas .= "   and r30_peraf <= '{$sDataPesquisa}'";
  $sSqlFeriasCadastradas .= "   and r30_anousu = {$iAno}";
  $sSqlFeriasCadastradas .= "   and r30_mesusu = {$iMes} ";
  $sSqlFeriasCadastradas .= "   and r30_regist = {$oDados->rh01_regist}";
  $sSqlFeriasCadastradas .= " order by r30_perai asc";
  $nUltimaData = '';

  if ($iTemFerias == 0) {

     $sDataInicial = $oDados->rh01_admiss;

  } else {

    /**
     * periodos de ferias ainda nao gozados completamentes.
     */

    $rsFeriasVencidas     = db_query($sSqlFeriasCadastradas);
    $iTotalFeriasVencidas = pg_num_rows($rsFeriasVencidas);
    if ($iTotalFeriasVencidas > 0) {

      for ($iFerias = 0; $iFerias < $iTotalFeriasVencidas; $iFerias++) {

        $oDadosFerias = db_utils::fieldsMemory($rsFeriasVencidas, $iFerias);
        $oPeriodo = new stdClass();
        $oPeriodo->diasgozo    = $oDadosFerias->r30_ndias;
        $oPeriodo->diasgozados = $oDadosFerias->diasgozados;
        $oPeriodo->datainicial = $oDadosFerias->r30_perai;
        $oPeriodo->datafinal   = $oDadosFerias->r30_peraf;
        $aDataFinal  = explode("-", $oPeriodo->datafinal);
        $sDataLimite = date("Y-m-d", mktime(0, 0, 0, $aDataFinal[1], $aDataFinal[2]-30, $aDataFinal[0]+1));
        $oPeriodo->limite      = $sDataLimite;
        $oFuncionario->periodosvencidos[] = $oPeriodo;
      }
    }
  }

  if ($oFuncionario->periodoaquisitivofim != "") {

    $aDataFinal  = explode("-", $oFuncionario->periodoaquisitivofim);
    $sDataLimite = date("Y-m-d", mktime(0, 0, 0, $aDataFinal[1], $aDataFinal[2]+1, $aDataFinal[0]));
    $sDataInicial = date("Y-m-d", mktime(0, 0, 0, $aDataFinal[1], $aDataFinal[2]+1, $aDataFinal[0]));
  }

  /**
   * Criamos os novos periodos aquisivos...
   */
  $lTemFeriasVencidas = true;

  while ($lTemFeriasVencidas) {

    $oPeriodo = new stdClass();
    $oPeriodo->diasgozo    = 30;
    $oPeriodo->diasgozados = '';
    $oPeriodo->datainicial  = $sDataInicial;
    $aDataInicial   = explode("-", $sDataInicial);
    $sUltimaData    = date("Y-m-d", mktime(0, 0, 0, $aDataInicial[1]+12, $aDataInicial[2]-1, $aDataInicial[0]));
    $oPeriodo->datafinal   = $sUltimaData;
    $aDataFinal   = explode("-", $oPeriodo->datafinal);
    $sDataLimite = date("Y-m-d", mktime(0, 0, 0, $aDataFinal[1]+12, $aDataFinal[2]-30, $aDataFinal[0]));
    $oPeriodo->limite      = $sDataLimite;
    if (db_strtotime($oPeriodo->datafinal) >= db_strtotime($sDataPesquisa)) {
      $lTemFeriasVencidas = false;
    } else {
      $oFuncionario->periodosvencidos[] = $oPeriodo;
    }
    $aDataFinal   = explode("-", $sUltimaData);
    $sDataInicial = date("Y-m-d", mktime(0, 0, 0, $aDataFinal[1], $aDataFinal[2]+1, $aDataFinal[0]));;
  }

  $aAgrupador[$oDados->agrupador_codigo]->funcionarios[] = $oFuncionario;
}


$aDescricoes = array(
  'numerica'       => 'Numérica',
  'alfabetica'     => 'Alfabética',
  'selecionado'    => 'Selecionado',
  'intervalo'      => 'Intervalo',
  'geral'          => 'Geral',
  'orgao'          => 'Orgão',
  'lotacao'        => 'Lotação',
  'matricula'      => 'Matrícula',
  'locaistrabalho' => 'Locais de Trabalho'
);



echo "ESCALA DE FÉRIAS: \n";
echo "Período: ".$iMes." / ".$iAno." \n";
echo "Períodos Vencidos até: {$oGet->periodo} \n";
echo "Tipo de Relatório: $aDescricoes[$sTipoRelatorio] \n";
echo "Tipo de Filtro: $aDescricoes[$sTipoFiltro] \n";
echo "Imprime Afastados: " . ($lImprimeAfastados ? 'Sim' : 'Não')." \n";
echo "Tipo de Ordem:  $aDescricoes[$sTipoOrdem] \n\n";

// $iCont = 0;
echo "Funcionario;";
echo "Periodo Aquisitivo;";
echo "Gozados;";
echo "A Gozar;";
echo "Limite;";
echo "Programacao;";
echo "Abono;";
echo "Assinatura;\n";
echo "\n";

foreach ($aAgrupador as $iAgrupador => $oAgrupador) {

  $iTotalSemFerias = 0;
  $iTotalFuncionariosFeriasVencidas = 0;

  foreach ($oAgrupador->funcionarios as $oFuncionario) {

    if (count($oFuncionario->periodosvencidos) == 0) {
      $iTotalSemFerias++;
    }
  }

  if ($iTotalSemFerias == count($oAgrupador->funcionarios)) {
    continue;
  }

  foreach ($oAgrupador->funcionarios as $oFuncionario) {

    if (count($oFuncionario->periodosvencidos) == 0) {
      continue;
    }

    $iTotalFuncionariosFeriasVencidas++;

    $oDadosDaLinha = new stdClass();
    $oDadosDaLinha->funcionario = "$oFuncionario->matricula - $oFuncionario->nome";//$oFuncionario->nome;
    if($oFuncionario->periodogozadoinicial == null){
      $oFuncionario->periodogozadoinicial = ' - ';
    }
    if($oFuncionario->periodogozadofinal == null){
      $oFuncionario->periodogozadofinal = ' - ';
    }

    $oDadosDaLinha->periodoGozado = "{$oFuncionario->periodogozadoinicial} a {$oFuncionario->periodogozadofinal}";

    foreach ($oFuncionario->periodosvencidos as $oPeriodo) {
      $oDadosDaLinha->periodoAquisitivo = $sPeriodoAquisitivo = db_formatar($oPeriodo->datainicial, "d")." - ".db_formatar($oPeriodo->datafinal, "d");
      $oDadosDaLinha->periodoDiasGozados = $oPeriodo->diasgozados;
      $oDadosDaLinha->periodoDiasGozo = $oPeriodo->diasgozo - $oPeriodo->diasgozados;
      $oDadosDaLinha->periodoLimite = db_formatar($oPeriodo->limite,"d");
      $oDadosDaLinha->programacao = "____/____/_______ a ____/____/______";
      $oDadosDaLinha->abono = " ";
      $oDadosDaLinha->assinatura = " ";


      echo "$oDadosDaLinha->funcionario;";
      echo "$oDadosDaLinha->periodoAquisitivo;";
      echo "$oDadosDaLinha->periodoDiasGozados;";
      echo "$oDadosDaLinha->periodoDiasGozo;";
      echo "$oDadosDaLinha->periodoLimite;";
      echo "$oDadosDaLinha->programacao;";
      echo "$oDadosDaLinha->abono;";
      echo "$oDadosDaLinha->assinatura;\n";
      if($oDadosDaLinha->funcionario != ''){
          echo "Último Gozo: ".$oDadosDaLinha->periodoGozado;
      }
      $oDadosDaLinha->ident="";
      $oDadosDaLinha->periodoGozado = "-";
      $oDadosDaLinha->funcionario = "";
    }
    echo "\n";

    if (count($oFuncionario->periodosvencidos) == 1){
        echo "\n";
    }
  }
}
