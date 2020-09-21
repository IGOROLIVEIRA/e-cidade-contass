<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_liclancedital_classe.php");
require_once("classes/db_liclicita_classe.php");

$oPost = db_utils::postMemory($_POST);
$oGet = db_utils::postMemory($_GET);
$clliclancedital = new cl_liclancedital;
$clliclicita = new cl_liclicita;
$error = false;

if($oPost->atualizar){
	if($oPost->data_envio){
		$sSql = $clliclancedital->sql_query(null, 'liclancedital.*', '', 'l47_liclicita = '.$oGet->codigo);
		$rsSql = $clliclancedital->sql_record($sSql);
		$oEdital = db_utils::fieldsMemory($rsSql, 0);
		$codigo = $oEdital->l47_sequencial;
		$dataBuscada = $oEdital->l47_dataenvio;

		$dataFormatada = join('-', array_reverse(explode('/', $oPost->data_envio)));

		if($dataFormatada >= $dataBuscada){
			$clliclancedital->l47_dataenvio = $dataFormatada;
			// Altera o status de AGUARDANDO ENVIO para ENVIADO...
			$clliclicita->l20_codigo = $oGet->codigo;
			$clliclicita->l20_cadinicial = 3;
			$clliclicita->alterar($oGet->codigo);

			if($clliclicita->numrows_alterar){
			    $clliclancedital->l47_sequencial = $oEdital->l47_sequencial;
			    $clliclancedital->l47_linkpub = $oEdital->l47_linkpub;
			    $clliclancedital->l47_origemrecurso = $oEdital->l47_origemrecurso;
			    $clliclancedital->l47_descrecurso = $oEdital->l47_descrecurso;
			    $clliclancedital->l47_liclicita = $oEdital->l47_liclicita;
			    $clliclancedital->alterar($codigo);
				if($clliclancedital->erro_status == '0'){
					$error = true;
					$msg = $clliclancedital->erro_sql;
                }else{
				    $msg = 'Data de Envio cadastrada com sucesso!';
                }
			}else{
				$error = true;
				$msg = $clliclicita->erro_sql;
			}
		}else{
			$error = true;
			$msg = 'Data Informada menor que a data de Envio';
		}

	}else{
		$error = true;
		$msg = 'Informe a data de Envio!';
	}

	echo "<script>";
	echo "alert('".$msg."');";

	if($error){
		echo "</script>";
	}else{
		echo "parent.db_iframe_dataenvio.hide();";
		echo "parent.parent.js_pesquisa();";
		echo "</script>";
	}
}

?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="estilos.css" rel="stylesheet" type="text/css">
	<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<style>
	table{
		margin-top: 20px;
	}
	#atualizar{
		margin-top: 4px;
	}
</style>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0"  align="center" cellspacing="0" bgcolor="#CCCCCC">
	<tr>
		<td height="63" align="center" valign="top">
			<table width="35%" border="0" align="center" cellspacing="0">
				<form name="form1" method="post" action="" >

					<tr>
						<td width="4%" align="right" nowrap title="Data de Envio">
							<?='Data:'?>
						</td>
						<td width="96%" align="left" nowrap>
							<?
							db_inputdata_position('data_envio',$data_envio_dia,$data_envio_mes,$data_envio_ano,true,'text',1,"","","","", "", '', '', 'parent');
							?>
						</td>
					</tr>
					<tr>
					<tr>
						<td colspan="2" align="center">
							<input name="atualizar" type="submit" id="atualizar" value="atualizar">
						</td>
					</tr>
				</form>
			</table>
		</td>
	</tr>

</table>
</body>
</html>
