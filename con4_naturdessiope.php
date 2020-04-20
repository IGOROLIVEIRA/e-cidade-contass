<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_naturdessiope_classe.php.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clnaturdessiope = new cl_naturdessiope;

if(isset($incluir)){
    db_inicio_transacao();
    $clnaturdessiope->incluir($c222_natdespecidade,$c222_natdespsiope, $c222_anousu, $c222_previdencia);
    db_fim_transacao();
}

if(isset($alterar)){
    db_inicio_transacao();
    $clnaturdessiope->alterar($c222_natdespecidade,$c222_natdespsiope,$c222_previdencia);
    db_fim_transacao();
}

if(isset($excluir)){
    db_inicio_transacao();
    $clnaturdessiope->excluir($c222_natdespecidade,$c222_natdespsiope,"c222_natdespecidade = '$c222_natdespecidade'and c222_natdespsiope = '$c222_natdespsiope' and c222_anousu = '$c222_anousu'");
    db_fim_transacao();
} else if(isset($chavepesquisa)){
    $result = $clnaturdessiope->sql_record($clnaturdessiope->sql_query($chavepesquisa));
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
        include("forms/frmnaturdessiope.php");
        ?>
    </center>
    </td>
    </tr>
    </table>
    </body>
    </html>
    <script>
        js_tabulacaoforms("form1","c222_natdespecidade",true,1,"c222_natdespecidade",true);
    </script>
<?
if(isset($incluir)){
    if($clnaturdessiope->erro_status=="0"){
        $clnaturdessiope->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clnaturdessiope->erro_campo!=""){
            echo "<script> document.form1.".$clnaturdessiope->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clnaturdessiope->erro_campo.".focus();</script>";
        }
    }else{
        $clnaturdessiope->erro(true,true);
    }
}

if(isset($alterar)){
    if($clnaturdessiope->erro_status=="0"){
        $clnaturdessiope->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clnaturdessiope->erro_campo!=""){
            echo "<script> document.form1.".$clnaturdessiope->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clnaturdessiope->erro_campo.".focus();</script>";
        }
    }else{
        $clnaturdessiope->erro(true,true);
    }
}

if(isset($excluir)){
    if($clnaturdessiope->erro_status=="0"){
        $clnaturdessiope->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clnaturdessiope->erro_campo!=""){
            echo "<script> document.form1.".$clnaturdessiope->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clnaturdessiope->erro_campo.".focus();</script>";
        }
    }else{
        $clnaturdessiope->erro(true,true);
    }
}
?>