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


db_postmemory($HTTP_POST_VARS);

?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

<script>

variavel = 1;
function js_emite(){
  sel_instit  = new Number(document.form1.db_selinstit.value);
  if(sel_instit == 0){
    alert('Voc� n�o escolheu nenhuma Institui��o. Verifique!');
    return false;
  }else{
    obj = document.form1;
    jan = window.open('con2_lrfreceitacorrente002_var.php?db_selinstit='+obj.db_selinstit.value+'&bimestre='+obj.bimestre.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);
  }
}
</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table  align="center">
    <form name="form1" method="post" action="con2_lrfreceitacorrente002_var.php" >
    <tr>
         <td >&nbsp;</td>
         <td >&nbsp;</td>
    </tr>
    <tr>
        <td align="center" colspan="3">
	     <?	db_selinstit('',300,100);	?>
	    </td>
    </tr>
    
    <tr>
        <td colspan=2 nowrap><b>Bimestre :</b><select name=bimestre> 
               <option value="1">1� Bimestre</option>
               <option value="2">2� Bimestre</option>
               <option value="3">3� Bimestre</option>
               <option value="4">4� Bimestre</option>
	       <option value="5">5� Bimestre</option>
               <option value="6">6� Bimestre</option>
            </select>
        </td> 
    </tr>
 
     
     
     
     
     <tr>
        <td colspan=2>&nbsp; </td>
    </tr>
    
    <tr>
        <td align="center" colspan="2">
           <input  name="emite" id="emite" type="button" value="Imprimir" onclick="js_emite();">
        </td>
   </tr>
  </form>
    </table>

</body>
</html>
