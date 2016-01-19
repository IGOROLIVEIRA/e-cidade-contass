<?php
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_liborcamento.php");
require_once("dbforms/db_classesgenericas.php");

$clcriaabas = new cl_criaabas;
$oGet = db_utils::postMemory($_GET);
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt21');
$clrotulo->label('DBtxt22');
$sProgramaRelatorio = isset($oGet->sProgramaRelatorio) ? $oGet->sProgramaRelatorio : null;
$codigoRelatorio = $oGet->codRelatorio;
$iAnoSessao = db_getsession('DB_anousu');

if ($iAnoSessao >= 2015 && $codigoRelatorio == BalancoPatrimonialDcasp::CODIGO_RELATORIO) {
    $codigoRelatorio = BalancoPatrimonialDCASP2015::CODIGO_RELATORIO;
}

if ($iAnoSessao >= 2015 && $codigoRelatorio == FluxoCaixaDCASP::CODIGO_RELATORIO) {
    $codigoRelatorio = FluxoCaixaDCASP2015::CODIGO_RELATORIO;
}

if ($iAnoSessao >= 2015 && $codigoRelatorio == VariacaoPatrimonialDCASP::CODIGO_RELATORIO) {
    $codigoRelatorio = VariacaoPatrimonialDCASP2015::CODIGO_RELATORIO;
}

$sPathFiltrosRelatorio = "con2_relatoriosdcasp011.php?codigoRelatorio={$codigoRelatorio}&sProgramaRelatorio={$sProgramaRelatorio}";

if ($iAnoSessao >= 2015 && $codigoRelatorio == BalancoFinanceiroDcasp::CODIGO_RELATORIO) {

    $codigoRelatorio       = BalancoFinanceiroDCASP2015::CODIGO_RELATORIO;
    $sPathFiltrosRelatorio = "con2_relatoriodcaspBalancoFinanceiro2015011.php?codigoRelatorio={$codigoRelatorio}";
}

if ($codigoRelatorio == BalancoOrcamentarioDCASP2015::CODIGO_RELATORIO) {
    $sPathFiltrosRelatorio = "con2_relatoriodcaspBalancoOrcamentario2015011.php?codigoRelatorio={$codigoRelatorio}";
}

?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body class="body-default abas">

<?php
$clcriaabas->identifica = array("relatorio" => "Relatório",
    "parametro" => "Parâmetros",
    "notas"     => "Fonte/Notas Explicativas");

$clcriaabas->title      = array("relatorio" => "Relatório",
    "parametro" => "Parâmetros",
    "notas"     => "Fonte/Notas Explicativas");

$clcriaabas->src        = array("relatorio" => $sPathFiltrosRelatorio,
    "parametro" => "con4_parametrosrelatorioslegais001.php?c83_codrel={$codigoRelatorio}",
    "notas"     => "con2_conrelnotas.php?c83_codrel={$codigoRelatorio}");

$clcriaabas->sizecampo  = array("relatorio"=>"23",
    "parametro"=>"23",
    "notas"    =>"23");

$clcriaabas->cria_abas();
?>

<?php db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
</body>
</html>
