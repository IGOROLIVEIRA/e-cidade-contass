<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */
require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
include("libs/db_sql.php");
include("libs/db_utils.php");
include("model/caixa/slip/TipoSlip.model.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$clrotulo = new rotulocampo;
$clrotulo->label('k17_codigo');
$clrotulo->label('k17_data');
$clrotulo->label('k17_debito');
$clrotulo->label('k17_credito');
$clrotulo->label('k17_valor');
$clrotulo->label('k17_hist');
$clrotulo->label('k17_texto');
$clrotulo->label('k17_dtaut');
$clrotulo->label('k17_autent');
$clrotulo->label('c60_descr');
$clrotulo->label('z01_nome');

$sDbInstit = str_replace('-', ', ', $db_selinstit);
$iAnoUsu   = db_getsession("DB_anousu");

$sWhere = "";
$where1 = "";
$sAnd   = "";
$info   = "";

if (isset($db_selinstit) && $db_selinstit != "") {
  $sWhere .= "{$sAnd} k17_instit in ({$sDbInstit}) ";
  $sAnd   = " and ";
}

if (($data != "--") && ($data1 != "--")) {
  $sWhere .= "{$sAnd} k17_data  between '$data' and '$data1'  ";
  $sAnd   = " and ";
} else if ($data != "--") {
  $sWhere .= "{$sAnd} k17_data >= '$data'  ";
  $sAnd   = " and ";
} else if ($data1 != "--") {
  $sWhere .= "{$sAnd} k17_data <= '$data1'   ";
  $sAnd   = " and ";
}

if (($data_autenticacao != "--") && ($data_autenticacao1 != "--")) {
  $sWhere .= "{$sAnd} k17_dtaut  between '$data_autenticacao' and '$data_autenticacao1'  ";
  $sAnd   = " and ";
} else if ($data_autenticacao != "--") {
  $sWhere .= "{$sAnd} k17_dtaut >= '$data_autenticacao'  ";
  $sAnd   = " and ";
} else if ($data_autenticacao1 != "--") {
  $sWhere .= "{$sAnd} k17_dtaut <= '$data_autenticacao1'   ";
  $sAnd   = " and ";
}

// Filtro em conta espe
$codconta = isset($codconta) ? intval($codconta) : '';
$codcontacred = isset($codcontacred) ? intval($codcontacred) : '';

if (!empty($codconta) || !empty($codcontacred)) {
  if ($codconta > 0 and $codcontacred == 0) { //somente conta a debito
    $sWhere .= " AND (k17_debito = {$codconta}) ";
  } else if ($codconta == 0 and $codcontacred > 0) { //somente conta a credito
    $sWhere .= " AND (k17_credito = {$codcontacred}) ";
  } else {
    $sWhere .= " AND ( (k17_debito = {$codconta}) AND (k17_credito = {$codcontacred}) ) ";
  }
}

if ($situac == "A") {
  $where1 = "";
  $info   = "SITUAÇÂO: Todas ";
} else {
  $where1 = "{$sAnd} k17_situacao = $situac ";
  switch ($situac) {
    case 1:
      $tipo = " Não Autenticadas";
      break;
    case 2:
      $tipo = " Autenticadas";
      break;
    case 3:
      $tipo = " Revogadas";
      break;
    case 4:
      $tipo = " Canceladas";
      break;
  }
  $info = "SITUAÇÂO: $tipo";
}
if ($tiposlip != 0) {
  $sWhere3 .= "{$sAnd} k153_slipoperacaotipo = '$tiposlip'   ";
  $sAnd   = " and ";
}
if (trim($codigos) != "") {
  $sWhere .= "{$sAnd} k17_numcgm ";
  if ($parametro == "N") {
    $sWhere .= " not ";
  }
  $sWhere .= " in ($codigos) ";
  $sAnd   = " and ";
}
$whereslip = "";

if (isset($slip1) && trim($slip1) != "") {
  $whereslip = " slip.k17_codigo >= $slip1 ";
}

if (isset($slip2) && trim($slip2) != "") {
  if (trim($whereslip) != "") {
    $whereslip = " slip.k17_codigo between $slip1 and $slip2 ";
  } else {
    $whereslip = " slip.k17_codigo <= $slip2 ";
  }
}

if (isset($recurso) && $recurso != '0') {
  $whereslip .= " ( r1.c61_codigo =$recurso  or r2.c61_codigo =$recurso  ) ";
  $head4 = "RECURSO : $recurso";
}
if (isset($hist) && $hist != '') {
  $whereslip .= " slip.k17_hist = {$hist}";
}

if ($tipo != 0) {
  $sWhere3 .= "{$sAnd} k17_tiposelect = '$tipo'   ";
  $sAnd   = " and ";
}

if (!empty($whereslip)) {
  $sWhere .= $sAnd . $whereslip;
}

$sDescrInst = '';
$sVirg      = '';
$bFlagAbrev = false;
$sSqlInstit = "select codigo,nomeinst,nomeinstabrev from db_config where codigo in ({$sDbInstit}) ";
$resInst    = db_query($sSqlInstit);
$iInstit    = pg_num_rows($resInst);

if ($iInstit > 0) {
  for ($i = 0; $i < $iInstit; $i++) {
    $oDescrInst = db_utils::fieldsMemory($resInst, $i);
    if (strlen(trim($oDescrInst->nomeinstabrev)) > 0) {
      $sDescrInst .= $sVirg . "($oDescrInst->codigo)" . $oDescrInst->nomeinstabrev;
      $bFlagAbrev  = true;
    } else {
      $sDescrInst .= $sVirg . "($oDescrInst->codigo)" . $oDescrInst->nomeinst;
    }

    $sVirg = ', ';
  }
}

if ($bFlagAbrev == false) {
  if (strlen($sDescrInst) > 42) {
    $sDescrInst = substr($sDescrInst, 0, 100);
  }
}

$sCampoProcesso = '';
if (isset($k145_numeroprocesso) && !empty($k145_numeroprocesso)) {

  $sCampoProcesso = ' , k145_numeroprocesso as sprocesso ';
  $sWhere .= " and k145_numeroprocesso = '{$k145_numeroprocesso}'";
}

if ($agrupar == 1) {
  $sAgrupar = "cgm.z01_numcgm";
} elseif ($agrupar == 2) {
  $sAgrupar = "slip.k17_debito";
} elseif ($agrupar == 3) {
  $sAgrupar = "slip.k17_credito";
} elseif ($agrupar == 4) {
  $sAgrupar = "k29_recurso";
} elseif ($agrupar == 5) {
  $sAgrupar = "k17_tiposelect";
} else {
  $sAgrupar = "";
}

$sql = "SELECT 
        slip.k17_codigo {$sCampoProcesso},
        k17_data,
        k17_debito,
        c1.c60_descr AS debito_descr,
        k17_credito,
        c2.c60_descr AS credito_descr,
        k17_valor,
        (CASE WHEN k17_situacao = 1 THEN 'Não Autenticado'
          WHEN k17_situacao = 2 THEN 'Autenticado'
          WHEN k17_situacao = 3 THEN 'Estornado'
          WHEN k17_situacao = 4 THEN 'Cancelado'
        END) AS k17_situacao,
        k17_hist,
        k17_texto,
        k17_dtaut,
        k17_autent,
        z01_numcgm,
        z01_nome,
        CASE
          WHEN k29_recurso = 1 THEN 15000000
          else k29_recurso
        END AS k29_recurso,
        o15_descr,
        k17_tiposelect
        FROM slip
        INNER JOIN conplanoreduz r1        ON r1.c61_reduz       = k17_debito    AND r1.c61_anousu = {$iAnoUsu}
        INNER JOIN conplano c1             ON c1.c60_codcon      = r1.c61_codcon AND c1.c60_anousu = r1.c61_anousu
        INNER JOIN conplanoreduz r2        ON r2.c61_reduz       = k17_credito   AND r2.c61_anousu = {$iAnoUsu}
        INNER JOIN conplano c2             ON c2.c60_codcon      = r2.c61_codcon AND c2.c60_anousu = r2.c61_anousu
        LEFT  JOIN slipnum                 ON slipnum.k17_codigo = slip.k17_codigo
        LEFT  JOIN cgm                     ON cgm.z01_numcgm     = slipnum.k17_numcgm
        LEFT  JOIN slipprocesso            ON slip.k17_codigo    = k145_slip
        LEFT  JOIN sliptipooperacaovinculo ON slip.k17_codigo    = sliptipooperacaovinculo.k153_slip
        LEFT  JOIN sliprecurso             ON slip.k17_codigo    = k29_slip
        LEFT  JOIN orctiporec              ON k29_recurso        = o15_codigo
        WHERE {$sWhere} {$where1} {$sWhere3}";

if ($sAgrupar != "" || $ordenar != '0') {
  $sql .= "order by {$sAgrupar}";
  $sql .= $sAgrupar != "" && $ordenar != '0' ? "," : "";
  $sql .= ($ordenar == '1' ? " slip.k17_codigo" : ($ordenar == '2' ? " slip.k17_data" : ($ordenar == '3' ? " slip.k17_dtaut" : "")));
}

$result = db_query($sql);

if (pg_numrows($result) == 0) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros cadastrados.');
}

$aLinhas = array();
for ($i = 0; $i < pg_numrows($result); $i++) {
  $oLinha = db_utils::fieldsMemory($result, $i);

  $aLinha = array();
  $aLinha['codslip'] = $oLinha->k17_codigo;
  $aLinha['dtemissao'] = str_replace('/', '', db_formatar($oLinha->k17_data, 'd'));
  $aLinha['dtautenticacao'] = str_replace('/', '', db_formatar($oLinha->k17_dtaut, 'd'));
  $aLinha['contadebito'] = $oLinha->k17_debito;
  $aLinha['descrdebito'] = substr($oLinha->debito_descr, 0, 44);
  $aLinha['contacredito'] = $oLinha->k17_credito;
  $aLinha['descrcredito'] = substr($oLinha->credito_descr, 0, 44);
  $aLinha['situacao'] = $oLinha->k17_situacao;
  $aLinha['valor'] = number_format($oLinha->k17_valor, 2, ",", "");
  $aLinhas[] = $aLinha;
}

$csv = fopen('php://output', "w");

header("Content-type: text/csv");
header("Content-Disposition: attachment; filename=RelatorioSlip.csv");
header("Pragma: no-cache");

foreach ($aLinhas as $aLinha) {
  fputcsv($csv, $aLinha, ';');
}

fclose($csv);
