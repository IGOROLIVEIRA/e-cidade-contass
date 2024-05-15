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
include("classes/db_tipoproc_classe.php");
include("classes/db_numeracaotipoproc_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);
$cltipoproc = new cl_tipoproc;
$clnumeracaotipoproc = new cl_numeracaotipoproc;
$db_opcao = 1;
$db_botao = true;
if((isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"])=="Incluir"){

  db_inicio_transacao();

  $cltipoproc->p51_tipoprocgrupo = 1;
  $cltipoproc->p51_identificado  = 'false';
  $cltipoproc->p51_instit        = db_getsession("DB_instit");
  $cltipoproc->incluir($p51_codigo);

  $clnumeracaotipoproc->p200_ano = db_getsession("DB_anousu");
  $clnumeracaotipoproc->p200_numeracao = null;
  $clnumeracaotipoproc->p200_tipoproc = $cltipoproc->p51_codigo;
  $clnumeracaotipoproc->incluir(null);

  db_fim_transacao();
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
	include("forms/db_frmtipoproc.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?

if((isset($HTTP_POST_VARS["db_opcao"]) && $HTTP_POST_VARS["db_opcao"])=="Incluir"){

  if($sqlerro == true){
      if (trim($erro_msg) == ""){
           $erro_msg = "Inclusão abortada";
      }

      db_msgbox($erro_msg);

//    $clliclicita->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clliclicita->erro_campo!=""){
      echo "<script> document.form1.".$clliclicita->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clliclicita->erro_campo.".focus();</script>";
    };
  }else{
     $db_botao = true;
    db_msgbox("Inclusão Efetuada com Sucesso!!");

    echo "<script> document.form1.db_opcao.disabled=true;</script>  ";

    $script = "<script>
               parent.iframe_numeracao.location.href='pro1_numeracaotipoproc002.php?chavepesquisa=$cltipoproc->p51_codigo;';\n
               parent.document.formaba.numeracao.disabled=false;\n
               parent.mo_camada('numeracao');\n";

    $script .= "</script>\n";

    echo $script;
  };
};

?>
