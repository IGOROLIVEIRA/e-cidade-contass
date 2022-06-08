<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_eventos1020_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$cleventos1020 = new cl_eventos1020;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
    db_inicio_transacao();
    $cleventos1020->eso08_instit = db_getsession('DB_instit');
    $cleventos1020->incluir();
    db_fim_transacao();
}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/numbers.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBToogle.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >a
<div style=" width: 65%; margin-left: 20%;">
    <?
    include("forms/db_frmeventos1020.php");
    ?>
</div>
<?
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
    js_tabulacaoforms("form1","eso08_codempregadorlotacao",true,1,"eso08_codempregadorlotacao",true);
</script>
<?
if(isset($incluir)){
    if($cleventos1020->erro_status=="0"){
        $cleventos1020->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($cleventos1020->erro_campo!=""){
            echo "<script> document.form1.".$cleventos1020->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$cleventos1020->erro_campo.".focus();</script>";
        }
    }else{
        $cleventos1020->erro(true,true);
    }
}
?>
