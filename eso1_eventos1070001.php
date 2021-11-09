<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_eventos1070_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cleventos1070 = new cl_eventos1070;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
    db_inicio_transacao();
    $cleventos1070->eso09_instit = db_getsession('DB_instit');
    $cleventos1070->incluir();
    db_fim_transacao();
}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBToogle.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<div style=" width: 65%; margin-left: 20%;">
    <?
        include("forms/db_frmeventos1070.php");
    ?>
</div>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
    js_tabulacaoforms("form1","eso09_tipoprocesso",true,1,"eso09_tipoprocesso",true);
</script>
<?
if(isset($incluir)){
    if($cleventos1070->erro_status=="0"){
        $cleventos1070->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($cleventos1070->erro_campo!=""){
            echo "<script> document.form1.".$cleventos1070->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$cleventos1070->erro_campo.".focus();</script>";
        }
    }else{
        $cleventos1070->erro(true,true);
    }
}
?>
