<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$db_opcao = 1;
$db_botao = true;
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>

    <link href="estilos.css" rel="stylesheet" type="text/css">
    <link href="estilos/grid.style.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>
    <?
    include("forms/db_frmalteramaterial.php");
    ?>
</center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
<style>
</style>
</html>
<script>
    js_tabulacaoforms("form1","obr06_pcmater",true,1,"obr06_pcmater",true);
</script>
<?
if(isset($incluir)){
    if($cllicitemobra->erro_status=="0"){
        $cllicitemobra->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($cllicitemobra->erro_campo!=""){
            echo "<script> document.form1.".$cllicitemobra->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$cllicitemobra->erro_campo.".focus();</script>";
        }
    }else{
        $cllicitemobra->erro(true,true);
    }
}
?>
