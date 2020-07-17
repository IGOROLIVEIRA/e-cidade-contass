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
		$sSql = $clliclancedital->sql_query(null, 'l47_sequencial as codigo, l47_dataenvio', '', 'l47_liclicita = '.$oGet->codigo);
		$rsSql = $clliclancedital->sql_record($sSql);
		$codigo = db_utils::fieldsMemory($rsSql, 0)->codigo;
		$dataBuscada = db_utils::fieldsMemory($rsSql, 0)->l47_dataenvio;

		$dataFormatada = join('-', array_reverse(explode('/', $oPost->data_envio)));
		if($dataFormatada >= $dataBuscada){
			$clliclancedital->l47_dataenviosicom = $dataFormatada;

			// Altera o status de AGUARDANDO ENVIO para ENVIADO...
			$clliclicita->l20_codigo = $oGet->codigo;
			$clliclicita->l20_cadinicial = 3;
			$clliclicita->alterar($oGet->codigo);

			if($clliclicita->numrows_alterar){
				$clliclancedital->alterar($codigo);
				$msg = 'Data de Envio cadastrada com sucesso!';
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
	if($error){
		echo "<script>";
		echo "alert('".$msg."');";
		echo "</script>";
	}else{
		echo "<script>";
		echo "alert('".$msg."');";
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
							db_inputdata_position('data_envio',$data_envio_dia,$data_envio_mes,$data_envio_ano,true,'text',1,"","","","", "js_posiciona();", '', '', 'parent');
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

<script>

    // let elementoTela = parent.document.getElementById('Jandb_iframe_dataenvio');
    // elementoTela.addEventListener('drag', (e) => {
    //     console.log('Evento: ', e);
    //     e.preventDefault();
    // });

    function js_posiciona(){
        setTimeout(() => {
            // let elemento = document.getElementById('Jandb_iframe_dataenvio');
            // elemento.ondrag = (event) => {
            //     console.log('Enter in drag', event);
            //     event.preventDefault();
            // }
            //
            // elemento.ondragstart = (event) => {
            //     console.log('Inicio do drag', event);
            //     event.preventDefault();
            // }
            //
            // elemento.onclick = (e) => {
            //     console.log('Evento no click: ', e);
            // }
        }, 200);
    }

    function js_termina(valor){
        console.log('Valor do elemento');
    }
</script>
