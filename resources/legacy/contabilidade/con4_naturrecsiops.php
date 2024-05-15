<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_naturrecsiops_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clnaturrecsiops = new cl_naturrecsiops;

if(isset($incluir)){
    db_inicio_transacao();
    $clnaturrecsiops->incluir($c230_natrececidade,$c230_natrecsiops, $c230_anousu);
    db_fim_transacao();
}

if(isset($excluir)){
    db_inicio_transacao();
    $clnaturrecsiops->excluir($c230_natrececidade,$c230_natrecsiops,"c230_anousu = '$c230_anousu' and c230_natrececidade = '$c230_natrececidade' and c230_natrecsiops = '$c230_natrecsiops'");
    db_fim_transacao();
} else if(isset($chavepesquisa)){
    $result = $clnaturrecsiops->sql_record($clnaturrecsiops->sql_query($chavepesquisa));
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
        <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
        <link href="estilos.css" rel="stylesheet" type="text/css">
    </head>
    <body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
    <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    </table>
    <center>
        <?
        include("forms/frmnaturrecsiops.php");
        ?>
    </center>
    </td>
    </tr>
    </table>
    </body>
    </html>
<?
if(isset($incluir)){
    if($clnaturrecsiops->erro_status=="0"){
        $clnaturrecsiops->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clnaturrecsiops->erro_campo!=""){
            echo "<script> document.form1.".$clnaturrecsiops->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clnaturrecsiops->erro_campo.".focus();</script>";
        }
    }else{
        $clnaturrecsiops->erro(true,true);
    }
}

if(isset($excluir)){
    if($clnaturrecsiops->erro_status=="0"){
        $clnaturrecsiops->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clnaturrecsiops->erro_campo!=""){
            echo "<script> document.form1.".$clnaturrecsiops->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clnaturrecsiops->erro_campo.".focus();</script>";
        }
    }else{
        $clnaturrecsiops->erro(true,true);
    }
}
?>