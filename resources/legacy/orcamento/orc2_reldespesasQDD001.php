<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_orcsuplem_classe.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_orcsuplemtipo_classe.php");

$clcriaabas      = new cl_criaabas;
$clcriaabas->scrolling="yes";
$clorcsuplemtipo = new cl_orcsuplemtipo;

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$abas    = array();
$titulos = array();
$fontes  = array();
$sizecp  = array();

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
    <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
     <tr> 
        <td width="360" height="18">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="140">&nbsp;</td>
     </tr>
   </table>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
    <?
    $clcriaabas->identifica = array("g1"=>"Relatório","filtro"=>"Filtro");
    $clcriaabas->title      = array("g1"=>"Relatório","filtro"=>"Filtros");
    $clcriaabas->src  = array("g1"=>"orc2_reldespesasQDD011.php","filtro"=>"func_selorcdotacao_aba.php");
    $clcriaabas->funcao_js = array("g1"=>"","filtro"=>"js_atualizar_instit();");
    $clcriaabas->sizecampo= array("g1"=>"23","filtro"=>"15");
    $clcriaabas->cria_abas();    
    ?>
    </center>
	</td>
  </tr>
</table>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
<script>
  function js_atualizar_instit(){
    iframe_filtro.js_atualizar_instit();
  }
</script>
</html>
