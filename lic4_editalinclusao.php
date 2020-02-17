<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclancedital_classe.php");
require_once("classes/db_cflicita_classe.php");
include("dbforms/db_classesgenericas.php");

$clliclancedital = new cl_liclancedital;
$clliclicita = new cl_liclicita;
$clcflicita = new cl_cflicita;

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$sqlerro = false;
$db_opcao = 1;
//  Realizar busca pelos campos

if ($licitacao) {
	$sqlLicita = $clliclicita->sql_query_edital('', 'DISTINCT l20_codigo, l20_edital, l20_nroedital, l20_objeto, pctipocompratribunal.l44_sequencial as tipo_tribunal,
        UPPER(pctipocompratribunal.l44_descricao) as descr_tribunal, l20_naturezaobjeto as natureza_objeto,
        l47_dataenvio', '', 'l20_codigo = ' . $licitacao . ' and EXTRACT(YEAR from l20_datacria) >= 2020 ', '', 1);
	$rsLicita = $clliclicita->sql_record($sqlLicita);
	$oDadosLicitacao = db_utils::fieldsMemory($rsLicita, 0);
	$natureza_objeto = $oDadosLicitacao->natureza_objeto;
	$objeto = $oDadosLicitacao->l20_objeto;
	$tipo_tribunal = $oDadosLicitacao->tipo_tribunal;
	$descr_tribunal = $oDadosLicitacao->descr_tribunal;
	$edital = $oDadosLicitacao->l20_edital;
	$codigolicitacao = $oDadosLicitacao->l20_codigo;
	$numero_edital = $oDadosLicitacao->l20_nroedital;

//  $licitacao = db_utils::fieldsMemory($rsLicita, 0);
}

if (isset($incluir) && isset($licitacao)) {
	$sSqlEdital = $clliclancedital->sql_query_file('', 'l47_sequencial', '',
		'l47_liclicita = ' . $codigolicitacao . ' and EXTRACT(YEAR from l20_datacria) >= 2020 ');
	$rsEdital = $clliclancedital->sql_record($sSqlEdital);

	if ($clliclancedital->numrows == 0) {
		$data_formatada = str_replace('/', '-', db_formatar($data_referencia, 'd'));
		$clliclancedital->l47_linkpub = $links;
		$clliclancedital->l47_origemrecurso = $origem_recurso;
		$clliclancedital->l47_descrecurso = $descricao_recurso;
		$clliclancedital->l47_dataenvio = $data_formatada;
		$clliclancedital->l47_liclicita = $codigolicitacao;
		$clliclancedital->incluir(null);

		if ($clliclancedital->erro_status) {
			$erro_msg = $clliclancedital->erro_sql;
		} else {
			$erro_msg = $clliclancedital->erro_sql;
			$sqlerro = true;
		}

		$sequencial = $clliclancedital->l47_sequencial;

		if ($clliclancedital->numrows_incluir) {
			$db_opcao = 2;
		}

		// Alterar o status da licita��o para Aguardando Envio;
        if(!$sqlerro){
            $clliclicita = new cl_liclicita;
            $clliclicita->l20_cadinicial = 2;
            $clliclicita->l20_codigo = $codigolicitacao;

            $clliclicita->alterar($codigolicitacao);

            if ($clliclicita->erro_status == "0") {
                $erro_msg = $clliclicita->erro_msg;
            }

        }
	}

}


?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbtextField.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbcomboBox.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbautocomplete.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.maskedinput.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
    <script language="JavaScript" type="text/javascript"
            src="scripts/classes/dbViewCadDadosComplementares.classe.js"></script>

    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<style>
    #msgBoardEnderecodadosCompl_title {
        padding-top: 15px;
    }
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td height="430" align="center" valign="top" bgcolor="#CCCCCC">
            <center>
				<?
				include("forms/db_frmlicedital.php");
				?>
            </center>
        </td>
    </tr>
</table>
<script>
</script>
</body>
</html>
<?

if (isset($incluir)) {
	echo "<script>";
	echo "alert('" . $erro_msg . "');";
	echo "</script>";

	if (!$sqlerro) {
		echo "<script>";
		echo "parent.iframe_editais.location.href='lic4_editalalteracao.php?numero_edital=$numero_edital';\n";
		echo "parent.document.formaba.documentos.disabled=false;";
		echo "parent.iframe_documentos.location.href='lic4_editaldocumentos.php?l20_codigo=$codigolicitacao&l20_nroedital=$numero_edital&l47_sequencial=$sequencial&natureza_objeto=$natureza_objeto&cod_tribunal=$tipo_tribunal';";
		echo "</script>";
	}
	echo "<script>document.form1.data_referencia.value = '" . $data_referencia . "';</script>";
}else{
    echo "<script>";
	echo "parent.document.formaba.documentos.disabled=true;";
	echo "</script>";
}

if (!trim($licitacao)) {
	echo "<script>";
	echo "parent.iframe_editais.js_pesquisa();";
	echo "</script>";
}
?>

