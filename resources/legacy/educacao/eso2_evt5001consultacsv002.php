<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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
require_once("libs/db_stdlib.php");
require_once "libs/db_conecta.php";
require_once("libs/db_sessoes.php");
include_once "libs/db_usuariosonline.php";
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("model/pessoal/DBPessoal.model.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$sWhere = " rh218_instit = " . db_getsession("DB_instit");

if (!empty($z01_cgccpf)) {
  $sWhere .= " and z01_cgccpf = '$z01_cgccpf' ";
}
if (!empty($rh218_numcgm)) {
  $sWhere .= " and rh218_numcgm = '$rh218_numcgm' ";
}
if (!empty($rh218_regist)) {
  $sWhere .= " and rh218_regist = $rh218_regist ";
}

if (!empty($rh218_perapurano)) {
  $sWhere .= " and rh218_perapurano = $rh218_perapurano ";
}
if (!empty($rh218_perapurmes)) {
  $sWhere .= " and rh218_perapurmes = $rh218_perapurmes ";
}
if (!empty($rh218_perapurano) && empty($rh218_perapurmes)) {
  $sWhere .= " and rh218_perapurmes is null ";
}

$oEvt5001Consulta = db_utils::getDao('evt5001consulta');

$campos = $oEvt5001Consulta->getCamposRelConsulta();
$sSql = $oEvt5001Consulta->sql_query(null, $campos, "rh218_sequencial desc", $sWhere);
$rsDados = $oEvt5001Consulta->sql_record($sSql);

if ($oEvt5001Consulta->numrows == 0) {
  db_redireciona("db_erros.php?fechar=true&db_erro=Não existem dados nesse período");
}

header("Content-type: text/plain");
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");

$totalBaseSistema = 0;
$totalContribSocial = 0;
$totalDescRealizado = 0;
$totalValorDevido = 0;
$totalDiferenca = 0;
$totalDiferencaBase = 0;

echo "CPF;Nome/Razão Social;Matrícula;Categoria;Base Sistema;Base eSocial;Diferença Base;Desconto Realizado;Valor Devido;Diferença;\n";

for ($iCont = 0; $iCont < pg_num_rows($rsDados); $iCont++) {

  $oDados = db_utils::fieldsMemory($rsDados, $iCont);
  $fDiferenca = DBPessoal::arredondarValor($oDados->diferenca);
  $fDifSistemaEsocial = DBPessoal::arredondarValor($oDados->vlr_sistema - $oDados->rh218_vlrbasecalc);

  echo db_formatar($oDados->z01_cgccpf, "cpf") . ";",
  "{$oDados->z01_nome};",
  "{$oDados->rh218_regist};",
  "{$oDados->rh218_codcateg};",
  "{$oDados->vlr_sistema};",
  "{$oDados->rh218_vlrbasecalc};",
  "{$fDifSistemaEsocial};",
  "{$oDados->rh218_vrdescseg};",
  "{$oDados->rh218_vrcpseg};",
  "{$fDiferenca};\n";

  $totalContribSocial += $oDados->rh218_vlrbasecalc;
  $totalDescRealizado += $oDados->rh218_vrdescseg;
  $totalValorDevido += $oDados->rh218_vrcpseg;
  $totalDiferenca += DBPessoal::arredondarValor($fDiferenca);
  $totalBaseSistema += $oDados->vlr_sistema;
  $totalDiferencaBase += $fDifSistemaEsocial;
}


echo "TOTAL DE REGISTROS :;",
pg_num_rows($rsDados) . ";",
";;",
"$totalBaseSistema;",
"$totalContribSocial;",
"$totalDiferencaBase;",
"$totalDescRealizado;",
"$totalValorDevido;",
"$totalDiferenca;\n";
