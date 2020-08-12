<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBseller Servicos de Informatica
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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("classes/db_historicocgm_classe.php");

$oPost = db_utils::postMemory($_POST);
$cl_historicocgm = new cl_historicocgm;
$error = false;

if (isset($oPost->incluir)) {

    /*
     * Verifica o periodo de encerramento patrimonial
     * */

	$sSql = 'SELECT c99_datapat FROM condataconf WHERE c99_anousu = '.db_getsession('DB_anousu').' and c99_instit = '.db_getsession('DB_instit');
	$rsSql = db_query($sSql);
	$datapat = db_utils::fieldsMemory($rsSql, 0)->c99_datapat;

	$dataCadastro = join('-', array_reverse(explode('/', $oPost->z09_datacadastro)));

	if($datapat >= $dataCadastro){
	    $error = true;
	    $erro_msg = 'O período patrimonial encontra-se encerrado. Altere a Data de Cadastro do CGM para uma data posterior ou solicite a abertura do período.';
    }

	if(db_getsession('DB_datausu') < $dataCadastro){
		$error = true;
		$erro_msg = 'Não é possível realizar alteração para data futura.';
    }

	if(!$error){

	    if($oPost->z09_motivo == '' || $oPost->z09_motivo == null){
			$error = true;
			$erro_msg = 'Informe o motivo da alteração';
        }

	    if(!$error){
            $cl_historicocgm->z09_motivo        = $oPost->z09_motivo;
            $cl_historicocgm->z09_usuario       = db_getsession('DB_id_usuario');
            $cl_historicocgm->z09_numcgm        = $oPost->z09_numcgm;
            $cl_historicocgm->z09_datacadastro  = $oPost->z09_datacadastro;
            $cl_historicocgm->incluir();

            if($cl_historicocgm->erro_status == '0'){
                $error = true;
                $erro_msg = $cl_historicocgm->erro_msg;
            }else{
                $erro_msg = $cl_historicocgm->erro_msg;
            }
        }
    }

    echo "<script>";
    echo "alert('" . $erro_msg . "')";
    echo "</script>";

    if(!$error){
        echo '<script>js_limpaCampos();</script>';
    }
}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
	<?php
	db_app::load("scripts.js");
	db_app::load("prototype.js");
	db_app::load("strings.js");
	db_app::load("estilos.css,grid.style.css");
	?>

</head>
<style>
    tr{
        height: 1vh;
    }
</style>

<body class="body-default">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
        <td align="center" valign="top" bgcolor="#CCCCCC">
            <center>
                <?
                    include("forms/db_frmalteradatacadcgm.php");
			    ?>
            </center>
        </td>
    </tr>
</table>
</body>
</html>
<?php
    echo '<script>';
    if($error){
		echo "document.getElementById('z09_datacadastro').value = '". $oPost->z09_datacadastro ."'";
    }else{
        if($oPost->incluir){
            echo 'js_limpaCampos()';
        }
    }
    echo "</script>";
?>
