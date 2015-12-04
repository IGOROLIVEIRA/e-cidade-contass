<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
db_postmemory($HTTP_POST_VARS);
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
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table valign="top" marginwidth="0" width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
     <td>
     <?
     	// filtro = Motivo, data, cliente, técnico, procedimento, modulo
       $clcriaabas->identifica = array("g1"=>"Motivo/Data/Cliente","g2"=>"Técnico/Modulo","g3"=>"Procedimento");
       $clcriaabas->title = array("g1"=>"Selecionar Motivo/Data/Cliente","g2"=>"Selecionar Técnico/Modulo","g3"=>"Selecionar Procedimento");
       $clcriaabas->src = array("g1"=>"ate2_confereatendaba1.php","g2"=>"ate2_confereatendaba2.php","g3"=>"ate2_confereatendaba3.php");
       $clcriaabas->funcao_js = array("g1"=>"","g2"=>"","g3"=>"js_teste();");
       $clcriaabas->cria_abas();    
     ?> 
     </td>
  </tr>
<tr>
</tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
<script>
function js_teste(){
  iframe_g3.document.form1.submit();
}
  document.formaba.g1.size = 20; 
  document.formaba.g2.size = 20; 
  document.formaba.g3.size = 20; 
  
</script>
</html>
