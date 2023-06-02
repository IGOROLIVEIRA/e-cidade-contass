<?
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");//ini_set("display_errors",true);
include("classes/db_naturrecsiope_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clnaturrecsiope = new cl_naturrecsiope;

if(isset($incluir)){
    db_inicio_transacao();
    $clnaturrecsiope->incluir($c224_natrececidade,$c224_natrecsiope, $c224_anousu);
    db_fim_transacao();
}

if(isset($excluir)){
    db_inicio_transacao();
    $clnaturrecsiope->excluir($c224_natrececidade,$c224_natrecsiope, "c224_anousu = '$c224_anousu' and c224_natrececidade = '$c224_natrececidade' and c224_natrecsiope = '$c224_natrecsiope'");
    db_fim_transacao();
} else if(isset($chavepesquisa)){
    $result = $clnaturrecsiope->sql_record($clnaturrecsiope->sql_query($chavepesquisa));
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
        include("forms/frmnaturrecsiope.php");
        ?>
    </center>
    </td>
    </tr>
    </table>
    </body>
    </html>
<?
if(isset($incluir)){
    if($clnaturrecsiope->erro_status=="0"){
        $clnaturrecsiope->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clnaturrecsiope->erro_campo!=""){
            echo "<script> document.form1.".$clnaturrecsiope->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clnaturrecsiope->erro_campo.".focus();</script>";
        }
    }else{
        $clnaturrecsiope->erro(true,true);
    }
}

if(isset($excluir)){
    if($clnaturrecsiope->erro_status=="0"){
        $clnaturrecsiope->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clnaturrecsiope->erro_campo!=""){
            echo "<script> document.form1.".$clnaturrecsiope->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clnaturrecsiope->erro_campo.".focus();</script>";
        }
    }else{
        $clnaturrecsiope->erro(true,true);
    }
}
?>