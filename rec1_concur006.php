<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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
include("classes/db_concur_classe.php");
include("classes/db_concurcargo_classe.php");
include("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);

$clconcur = new cl_concur;
$clconcurcargo = new cl_concurcargo;

if(isset($h06_refer)){

  $db_opcao = 3;
  $db_botao = true;

} else {

  $db_opcao = 33;
  $db_botao = false;
}

if ( isset($excluir) ) {

  $sqlerro=false;
  db_inicio_transacao();

  /**
   * Exclui da tabela concurcargo
   */
  if ( !$sqlerro ) {

    $clconcurcargo->excluir(null, "h82_concur = {$h06_refer}");

    if ( $clconcurcargo->erro_status == 0 ) {

      $sqlerro  = true;
      $erro_msg = $clconcurcargo->erro_msg;
    }
  }

	/**
	 * Excluir da tabela concur
	 */
	if ( $sqlerro == false ) {

    $clconcur->h06_refer = $h06_refer;
    $clconcur->excluir($h06_refer);
		$erro_msg = $clconcur->erro_msg;

		if ( $clconcur->erro_status == 0 ) {
      $sqlerro  = true;
    }
  }

  db_fim_transacao($sqlerro);
}else if(isset($chavepesquisa)){
   $db_opcao = 3;
   $result = $clconcur->sql_record($clconcur->sql_query($chavepesquisa));
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmconcur.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?php
if ( isset($excluir)) {

	if ( $sqlerro == true ) {

    db_msgbox($erro_msg);
		if($clconcur->erro_campo!=""){

      echo "<script> document.form1.".$clconcur->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clconcur->erro_campo.".focus();</script>";
		};

	} else {
    db_msgbox($erro_msg);
    db_redireciona("rec1_concur006.php");
  };

};

if ( isset($chavepesquisa) ) {
  echo "
        <script>
          parent.document.formaba.concurcargo.disabled = false;
	      CurrentWindow.corpo.iframe_concurcargo.location.href = 'rec1_concurcargo001.php?chavepesquisa=$h06_refer&db_opcaoal=false';
	    </script>
       ";
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}
?>
