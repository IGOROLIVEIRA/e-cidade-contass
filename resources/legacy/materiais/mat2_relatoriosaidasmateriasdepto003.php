<?php

require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_matestoque_classe.php");
require_once("classes/db_matestoqueitem_classe.php");
require_once("classes/db_db_almox_classe.php");
require_once("classes/materialestoque.model.php");
require_once("classes/db_empparametro_classe.php");
require_once "libs/db_app.utils.php";
db_app::import("contabilidade.contacorrente.ContaCorrenteFactory");
db_app::import("Acordo");
db_app::import("AcordoComissao");
db_app::import("CgmFactory");
db_app::import("financeiro.*");
db_app::import("contabilidade.*");
db_app::import("contabilidade.lancamento.*");
db_app::import("Dotacao");
db_app::import("contabilidade.planoconta.*");
db_app::import("contabilidade.contacorrente.*");
$oParametros      = db_utils::postMemory($_GET);
$clmatestoque     = new cl_matestoque;
$clmatestoqueitem = new cl_matestoqueitem;
$cldb_almox       = new cl_db_almox;



$clrotulo = new rotulocampo;
$clrotulo->label('m60_descr');
$clrotulo->label('descrdepto');

/**
 * busca o parametro de casas decimais para formatar o valor jogado na grid
 */

$oDaoParametros          = new cl_empparametro;
$iAnoSessao              = db_getsession("DB_anousu");
$sWherePeriodoParametro  = " 1=1 limit 1";
$sSqlPeriodoParametro    = $oDaoParametros->sql_query_file(null, "e30_numdec", null, $sWherePeriodoParametro);
$rsPeriodoParametro      = $oDaoParametros->sql_record($sSqlPeriodoParametro);
$iParametroNumeroDecimal = db_utils::fieldsMemory($rsPeriodoParametro, 0)->e30_numdec;

$iAlt = 4;
$sOrderBy = "m80_data";
if (isset($oParametros->quebra) && $oParametros->quebra == "S") {

  $sOrderBy = 'm80_coddepto, m60_descr, m80_data';
} else if ($oParametros->ordem == 'a') {
  $sOrderBy = 'm70_codmatmater, m80_data';
} else  if ($oParametros->ordem == 'b') {
  $sOrderBy = 'm80_coddepto, m60_descr, m80_data';
} else  if ($oParametros->ordem == 'c') {
  $sOrderBy = 'm60_descr';
} else  if ($oParametros->ordem == 'd') {
  $sOrderBy = " m70_codmatmater,m80_data desc";
}

if ($oParametros->listamatestoquetipo != "") {
  $sWhere  = " m80_codtipo in ({$oParametros->listamatestoquetipo}) ";
} else {
  //$sWhere  = " m80_codtipo in (5, 17, 19, 21) ";
  $sWhere  = " m81_tipo = 2 ";
}
$sWhere .= " and m71_servico is false";
$sWhere .= " and instit=" . db_getsession('DB_instit');
if ($oParametros->listaorgao != "") {

  $sWhere .= " and o40_orgao in ({$oParametros->listaorgao}) ";
  $sWhere .= " and o40_anousu = " . db_getsession('DB_anousu');
  $sWhere .= " and o40_instit=" . db_getsession('DB_instit');
}

if ($oParametros->listadepart != "") {
  if (isset($oParametros->verdepart) && $oParametros->verdepart == "com") {
    $sWhere .= " and m80_coddepto in ({$oParametros->listadepart})";
  } else {
    $sWhere .= " and m80_coddepto not in ({$oParametros->listadepart})";
  }
}

if ($oParametros->listamat != "") {
  if (isset($oParametros->vermat) && $oParametros->vermat == "com") {
    $sWhere .= " and m70_codmatmater in ({$oParametros->listamat})";
  } else {
    $sWhere .= " and m70_codmatmater not in ({$oParametros->listamat})";
  }
}

if ($oParametros->listausu != "") {
  if (isset($oParametros->verusu) && $oParametros->verusu == "com") {
    $sWhere .= " and m80_login in ({$oParametros->listausu})";
  } else {
    $sWhere .= " and m80_login not in ({$oParametros->listausu})";
  }
}


if (isset($oParametros->listadepartDestino) && !empty($oParametros->listadepartDestino)) {

  $sWhere .= " and  m40_depto in ($oParametros->listadepartDestino) ";
}


/*
 * implementado logica para ir atÃ© os grupos caso eles venham selecionados
 */

$sInnerJoinGrupos = '';
$sFiltroGrupo     = '';

if (isset($oParametros->grupos) && trim($oParametros->grupos) != "") {

  $sWhere  .= " and materialestoquegrupo.m65_db_estruturavalor in ({$oParametros->grupos}) ";
  $sInnerJoinGrupos = " 
         inner join matmatermaterialestoquegrupo on matmater.m60_codmater = matmatermaterialestoquegrupo.m68_matmater 
         inner join materialestoquegrupo on matmatermaterialestoquegrupo.m68_materialestoquegrupo = materialestoquegrupo.m65_sequencial 
  ";

  $sFiltroGrupo     = 'Filtro por Grupos/Subgrupos';
  $head4 = $sFiltroGrupo; //"RelatÃ³rio de SaÃ­da de Material por Departamento";

}

$sDataIni = implode('-', array_reverse(explode('/', $oParametros->dataini)));
$sDataFin = implode('-', array_reverse(explode('/', $oParametros->datafin)));

if ((trim($oParametros->dataini) != "--") && (trim($oParametros->datafin) != "--")) {

  $sWhere .= " and m80_data between '{$sDataIni}' and '{$sDataFin}' ";
  $info    = "De " . $oParametros->dataini . " até " . $oParametros->datafin;
} else if (trim($oParametros->dataini) != "--") {

  $sWhere .= " and m80_data >= '{$sDataIni}' ";
  $info  = "Apartir de " . $oParametros->dataini;
} else if (trim($oParametros->datafin) != "--") {

  $sWhere .= " and m80_data <= '{$sDataFin}' ";
  $info   = "Até " . $oParametros->datafin;
}
$info_listar_serv = " LISTAR: TODOS";
$head3 = "Relatório de Saída de Material por Departamento";
$head5 = "$info";
$head7 = "$info_listar_serv";

$sSqlSaidas   = "SELECT m80_codigo, m61_abrev, ";
$sSqlSaidas  .= "       m70_coddepto,  ";
$sSqlSaidas  .= "       m70_codmatmater, ";
$sSqlSaidas  .= "       m80_coddepto, ";
$sSqlSaidas  .= "       m60_descr,  ";
$sSqlSaidas  .= "       descrdepto,  ";
$sSqlSaidas  .= "       sum(m82_quant) as qtde, ";
$sSqlSaidas  .= "       m80_data,  ";
$sSqlSaidas  .= "       m80_codtipo,  ";
$sSqlSaidas  .= "       m83_coddepto,  ";
$sSqlSaidas  .= "       m81_descr,  ";
$sSqlSaidas  .= "       m41_codmatrequi, ";
$sSqlSaidas  .= "       m89_precomedio as precomedio, ";
$sSqlSaidas  .= "       sum(m89_valorfinanceiro) as m89_valorfinanceiro, ";
$sSqlSaidas  .= "       m40_depto ";
$sSqlSaidas  .= "  from matestoqueini  ";
$sSqlSaidas  .= "       inner join matestoqueinimei    on m80_codigo              = m82_matestoqueini ";
$sSqlSaidas  .= "       inner join matestoqueinimeipm  on m82_codigo              = m89_matestoqueinimei ";
$sSqlSaidas  .= "       inner join matestoqueitem      on m82_matestoqueitem      = m71_codlanc  ";
$sSqlSaidas  .= "       inner join matestoque          on m70_codigo              = m71_codmatestoque ";
$sSqlSaidas  .= "       inner join matmater            on m70_codmatmater         = m60_codmater  ";
$sSqlSaidas  .= "       inner join matestoquetipo      on m80_codtipo             = m81_codtipo  ";
$sSqlSaidas  .= "       left  join db_depart           on m70_coddepto            = coddepto  ";
$sSqlSaidas  .= "       left  join db_departorg        on db01_coddepto           = db_depart.coddepto  ";
$sSqlSaidas  .= "                                     and db01_anousu             = " . db_getsession("DB_anousu");
$sSqlSaidas  .= "       left  join orcorgao            on o40_orgao               = db_departorg.db01_orgao ";
$sSqlSaidas  .= "                                     and o40_anousu              = " . db_getsession("DB_anousu");
$sSqlSaidas  .= "       left  join matestoquetransf    on m83_matestoqueini       = m80_codigo   ";
$sSqlSaidas  .= "       left  join matestoqueinimeiari on m49_codmatestoqueinimei = m82_codigo  ";
$sSqlSaidas  .= "       left  join atendrequiitem      on m49_codatendrequiitem   = m43_codigo  ";
$sSqlSaidas  .= "       left  join matrequiitem        on m41_codigo              = m43_codmatrequiitem ";
$sSqlSaidas  .= "       left  join matrequi            on m40_codigo              = m41_codmatrequi ";
$sSqlSaidas  .= "       left  join matunid             on matmater.m60_codmatunid = matunid.m61_codmatunid ";

$sSqlSaidas  .= $sInnerJoinGrupos; // string de inner caso venha grupos selecionados

$sSqlSaidas  .= " where {$sWhere} ";
$sSqlSaidas  .= " group by m80_codigo, m61_abrev, ";
$sSqlSaidas  .= "          m70_coddepto,  ";
$sSqlSaidas  .= "          m70_codmatmater, ";
$sSqlSaidas  .= "          m80_data,  ";
$sSqlSaidas  .= "          m40_depto,  ";
$sSqlSaidas  .= "          m81_descr,  ";
$sSqlSaidas  .= "          m80_codtipo,  ";
$sSqlSaidas  .= "          m80_coddepto,  ";
$sSqlSaidas  .= "          m83_coddepto,  ";
$sSqlSaidas  .= "          descrdepto,  ";
$sSqlSaidas  .= "          m89_precomedio,  ";
$sSqlSaidas  .= "          m60_descr,  ";
$sSqlSaidas  .= "          m41_codmatrequi ";
$sSqlSaidas  .= " order by {$sOrderBy} ";
