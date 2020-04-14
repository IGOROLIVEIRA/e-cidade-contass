<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_naturdessiops_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clnaturdessiops = new cl_naturdessiops;

if(isset($incluir)){
    db_inicio_transacao();
    $clnaturdessiops->incluir($c226_natdespecidade,$c226_natdespsiops, $c226_anousu);
    db_fim_transacao();
}

if(isset($excluir)){
    db_inicio_transacao();
    $clnaturdessiops->excluir($c226_natdespecidade,$c226_natdespsiops,"c226_anousu = '$c226_anousu' and c226_natdespecidade = '$c226_natdespecidade' and c226_natdespsiops = '$c226_natdespsiops'");
    db_fim_transacao();
} else if(isset($chavepesquisa)){
    $result = $clnaturdessiops->sql_record($clnaturdessiops->sql_query($chavepesquisa));
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
        include("forms/frmnaturdessiops.php");
        ?>
    </center>
    </td>
    </tr>
    </table>
    </body>
    </html>
    <script>
        js_tabulacaoforms("form1","c226_natdespecidade",true,1,"c226_natdespecidade",true);
    </script>
<?
if(isset($incluir)){
    if($clnaturdessiops->erro_status=="0"){
        $clnaturdessiops->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clnaturdessiops->erro_campo!=""){
            echo "<script> document.form1.".$clnaturdessiops->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clnaturdessiops->erro_campo.".focus();</script>";
        }
    }else{
        $clnaturdessiops->erro(true,true);
    }
}

if(isset($excluir)){
    if($clnaturdessiops->erro_status=="0"){
        $clnaturdessiops->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clnaturdessiops->erro_campo!=""){
            echo "<script> document.form1.".$clnaturdessiops->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clnaturdessiops->erro_campo.".focus();</script>";
        }
    }else{
        $clnaturdessiops->erro(true,true);
    }
}
?>