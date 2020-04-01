<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
$clcriaabas = new cl_criaabas;
?>

<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
        <td width="25%" height="18">&nbsp;</td>
        <td width="25%">&nbsp;</td>
        <td width="25%">&nbsp;</td>
        <td width="25%">&nbsp;</td>
    </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
            <?
            $clcriaabas->identifica = array("db_atestoautoemp"=>"Autorizações de Empenho", "db_atestoautoprocomp"=>"Processos de compras");
            $clcriaabas->src = array("db_atestoautoemp"=>"cin4_atestocontintautoemp.php", "db_atestoautoprocomp"=>"cin4_atestocontintautoprocomp.php");
            $clcriaabas->sizecampo = array("db_atestoautoemp"=>"22","db_atestoautoprocomp"=>"22");
            $clcriaabas->cria_abas();
            ?>
        </td>
    </tr>
</table>
<form name="form1">
</form>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>