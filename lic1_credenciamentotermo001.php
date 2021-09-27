<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_credenciamentotermo_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clcredenciamentotermo = new cl_credenciamentotermo;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
    db_inicio_transacao();
    $clcredenciamentotermo->l212_instit = db_getsession('DB_instit');;
    $clcredenciamentotermo->incluir();
    db_fim_transacao();
}
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css" />
    <script type="text/javascript" src="scripts/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
    <?
    include("forms/db_frmcredenciamentotermo.php");
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
    ?>
</body>
</html>
<script>
    js_tabulacaoforms("form1","l212_licitacao",true,1,"l212_licitacao",true);
</script>
<?
if(isset($incluir)){
    if($clcredenciamentotermo->erro_status=="0"){
        $clcredenciamentotermo->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clcredenciamentotermo->erro_campo!=""){
            echo "<script> document.form1.".$clcredenciamentotermo->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clcredenciamentotermo->erro_campo.".focus();</script>";
        }
    }else{
        $clcredenciamentotermo->erro(true,true);
    }
}
?>
