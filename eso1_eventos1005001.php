<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_eventos1005_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cleventos1005 = new cl_eventos1005;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
    db_inicio_transacao();
    $cleventos1005->eso06_instit = db_getsession('DB_instit');
    $cleventos1005->incluir();
    db_fim_transacao();
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/numbers.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBToogle.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<div style=" width: 65%; margin-left: 20%;">
    <?
    include("forms/db_frmeventos1005.php");
    ?>
</div>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
    js_tabulacaoforms("form1","eso06_tipoinscricao",true,1,"eso06_tipoinscricao",true);
</script>
<?
if(isset($incluir)){
    if($cleventos1005->erro_status=="0"){
        $cleventos1005->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($cleventos1005->erro_campo!=""){
            echo "<script> document.form1.".$cleventos1005->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$cleventos1005->erro_campo.".focus();</script>";
        }
    }else{
        $cleventos1005->erro(true,true);
    }
}
?>
