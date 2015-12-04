<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("libs/db_liborcamento.php");

$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt21');
$clrotulo->label('DBtxt22');

$clrotulo = new rotulocampo;
db_postmemory($HTTP_POST_VARS);
$anousu=db_getsession("DB_anousu");
if ($anousu<=2008){
   $fonte="con2_lrfnominal002.php"; 
}else{
   $fonte="con2_lrfnominal002_2009.php";
}


?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

<script>
function js_emite(){
  sel_instit  = new Number(document.form1.db_selinstit.value);
  if(sel_instit == 0){
    alert('Você não escolheu nenhuma Instituição. Verifique!');
    return false;
  }else{
    obj     = document.form1;
    periodo = obj.periodo.value;
    fonte="<? $fonte ?>";
    jan = window.open('<?=$fonte?>?db_selinstit='+obj.db_selinstit.value+'&periodo='+periodo,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);
  }
}
</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">  
  <table  align="center">
    <form name="form1" method="post" action="con2_lrfnominal002.php" >
    <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
    </tr>
    <tr>
        <td align="center" colspan="2">
	   <?	db_selinstit('',300,100); ?>
        </td>
    </tr>
   
    <tr>
        <td colspan=2 nowrap><b>Período :</b>
	    <select name=periodo> 
               <option value="1B">Primeiro Bimestre </option>
               <option value="2B">Segundo  Bimestre </option>
               <option value="3B">Terceiro Bimestre </option>
               <option value="4B">Quarto   Bimestre </option>
               <option value="5B">Quinto   Bimestre </option>
               <option value="6B">Sexto    Bimestre </option>
            </select>
        </td> 
    </tr>
    <tr><td colspab="2">&nbsp;</td></tr>
    <tr>
        <td align="center" colspan="2">
           <input  name="emite" id="emite" type="button" value="Imprimir" onclick="js_emite();">
        </td>
   </tr>

   
  </form>
  </table>



</body>
</html>
