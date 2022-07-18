<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_fornemensalemp_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clfornemensalemp = new cl_fornemensalemp;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){

    db_inicio_transacao();
    if ($fm101_datafim){
        $where = " (fm101_numcgm, fm101_datafim) = ({$fm101_numcgm}, to_date('{$fm101_datafim}', 'dd/mm/yyyy'))";
    } else{
        $where = " fm101_numcgm = $fm101_numcgm and fm101_datafim is null";
    }
    $sSqlRegDuplicado = $clfornemensalemp->sql_query_file('*',null, $where);

    if (pg_num_rows(db_query($sSqlRegDuplicado)) == 0) {
        $clfornemensalemp->incluir($fm101_numcgm);
    } else{
        echo "<script>alert(\"Usuário:\\nDados já existentes.\");</script>";
    }
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
<body bgcolor=#CCCCCC leftmargin="10" topmargin="0" marginwidth="450" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
        <td width="360" height="10">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="140">&nbsp;</td>
    </tr>
</table>
<table width="590" border="0" cellspacing="10" cellpadding="50">
    <tr>
        <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
            <center>
                <?
                include("forms/db_frmfornemensalemp.php");
                ?>
            </center>
        </td>
    </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
    js_tabulacaoforms("form1","fm101_numcgm",true,1,"fm101_numcgm",true);
</script>
<?
if(isset($incluir)){
    if($clfornemensalemp->erro_status=="0"){
        $clfornemensalemp->erro(true,false);
        $db_botao=true;
        echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
        if($clfornemensalemp->erro_campo!=""){
            echo "<script> document.form1.".$clfornemensalemp->erro_campo.".style.backgroundColor='#99A9AE';</script>";
            echo "<script> document.form1.".$clfornemensalemp->erro_campo.".focus();</script>";
        }
    }else{
        $clfornemensalemp->erro(true,true);
    }
}
?>
