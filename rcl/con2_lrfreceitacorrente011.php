<?

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("libs/db_liborcamento.php");
db_postmemory($HTTP_POST_VARS);

$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt21');
$clrotulo->label('DBtxt22');

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
    alert('Você não escolheu nenhuma Instituição. Verifique!');
    return false;
  }else{
    obj = document.form1;
    periodo = obj.periodo.value;

    data_ini = '';
    data_fin = '';
    /*
    if (obj.DBtxt21_dia.value!=''&&obj.DBtxt22_dia.value!=''){
     data_ini = obj.DBtxt21_ano.value+'-'+obj.DBtxt21_mes.value+'-'+obj.DBtxt21_dia.value;
     data_fin = obj.DBtxt22_ano.value+'-'+obj.DBtxt22_mes.value+'-'+obj.DBtxt22_dia.value;
     if (data_ini > data_fin){
          alert("Data inicial maior que a final. Verifique!");
	  return false;
     }
    } 
    */
    jan = window.open('con2_lrfreceitacorrente002.php?db_selinstit='+obj.db_selinstit.value+'&dtini='+data_ini+'&dtfin='+data_fin+'&periodo='+periodo,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);
  }
}
</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table  align="center">
    <form name="form1" method="post" action="con2_lrfreceitacorrente002.php" >
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
   
    <tr>
        <td colspan=2>&nbsp; </td>
    </tr>
 
    <!--
      <tr>
      <td colspan=2 align="center">
        <table border="0"  width="250" height="100" style="border: 1px solid black" cellpadding="0" cellspacing="1" >
         <tr>
           <td align="center" colspan="2" title="Gera o saldo em um intervalo de datas"><strong>Saldo Por Data</strong></td>
         </tr>
      </tr>
      
      <tr>      
        <td nowrap align="right" title="<?=$TDBtxt21?>"><?=$LDBtxt21?> </td>
        <td>
	  <?
            $DBtxt21_ano = db_getsession("DB_anousu");
            db_inputdata('DBtxt21',@$DBtxt21_dia,@$DBtxt21_mes,@$DBtxt21_ano ,true,'text',4);
	  ?>
        </td>
      </tr>
        <td nowrap align="right" title="<?=$TDBtxt22?>"><?=$LDBtxt22?> </td>
        <td>
	  <?
            $DBtxt22_ano = db_getsession("DB_anousu");
            db_inputdata('DBtxt22',@$DBtxt22_dia,@$DBtxt22_mes,@$DBtxt22_ano ,true,'text',4);
	  ?>
        </td>
      </tr>           
     </table>
    </td>
    </tr>
    -->
    
     
     
     
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
