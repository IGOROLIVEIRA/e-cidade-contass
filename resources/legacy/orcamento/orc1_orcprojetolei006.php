<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_orcprojetolei_classe.php");
include("classes/db_orcprojetoorcprojetolei_classe.php");
include("classes/db_orcleiorcprojetolei_classe.php");
include("classes/db_orcleialtorcamentaria_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clorcprojetolei            = new cl_orcprojetolei;
$clorcprojetoorcprojetolei  = new cl_orcprojetoorcprojetolei;
$clorcleiorcprojetolei 		= new cl_orcleiorcprojetolei;
$clorcleialtorcamentaria	= new cl_orcleialtorcamentaria;
$db_botao = false;
$db_opcao = 33;
$sql_erro = false;
if(isset($excluir)){

    $rsVerifica = $clorcprojetolei->sql_record($clorcprojetolei->sql_query_orcprojetolei_suplem($o138_sequencial));

    if ($clorcprojetolei->numrows > 0) {
        db_msgbox("Existem suplementações processados vinculadas ao decreto, exclusão não permitida!");
    } else {

        db_inicio_transacao();
        $clorcprojetoorcprojetolei->excluir(null, "o139_orcprojetolei = {$o138_sequencial}");

        if ($clorcprojetoorcprojetolei->erro_status == 0) {
			$sql_erro = true;
			$clorcprojetolei->erro_msg = $clorcprojetoorcprojetolei->erro_msg;
		}

		if ($sql_erro == false) {

			$clorcleiorcprojetolei->excluir(null, "o140_orcprojetolei = {$o138_sequencial}");

			if ($clorcleiorcprojetolei->erro_status == 0) {
				$sql_erro = true;
				$clorcprojetolei->erro_msg = $clorcleiorcprojetolei->erro_msg;
			}

		}

		if ($sql_erro == false) {

			$clorcleialtorcamentaria->excluir(null, "o200_orcprojetolei = {$o138_sequencial}");

			if ($clorcleialtorcamentaria->erro_status == 0) {
				$sql_erro = true;
				$clorcprojetolei->erro_msg = $clorcleialtorcamentaria->erro_msg;
			}

		}

		if ($sql_erro == false) {
			$clorcprojetolei->excluir($o138_sequencial);
		}

		$db_opcao = 3;
		db_fim_transacao($sql_erro);

		if ($sql_erro == true) {
			$clorcprojetolei->erro_status = 0;
		}

    }

}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $clorcprojetolei->sql_record($clorcprojetolei->sql_query($chavepesquisa));
   db_fieldsmemory($result,0);
   $db_botao = true;
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmorcprojetolei.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($excluir)){
  if($clorcprojetolei->erro_status=="0"){
    $clorcprojetolei->erro(true,false);
  }else{
    $clorcprojetolei->erro(true,true);
  }
}
if (isset($chavepesquisa)) {
	echo "
      <script>
             parent.document.formaba.db_leialtorc.disabled=false;
             CurrentWindow.corpo.iframe_db_leialtorc.location.href='orc1_orcleialtorcamentaria001.php?o200_orcprojetolei=".@$o138_sequencial."&db_opcaoal=1';
      </script>
     ";
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
<script>
js_tabulacaoforms("form1","excluir",true,1,"excluir",true);
</script>
