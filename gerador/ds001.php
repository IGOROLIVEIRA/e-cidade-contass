<?
require(__DIR__ . "/../libs/db_stdlib.php");
require(__DIR__ . "/../libs/db_conecta.php");
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
   <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <meta http-equiv="Expires" CONTENT="0">
 <script language="JavaScript" type="text/javascript" src="../scripts/scripts.js"></script>
 <link href="../estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#cccccc" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<script>
 function nova(){
  location.href="../con2_gerelatorio006.php?vaite=true";
}
  function abra(){
 var   titulo=document.form1.titulo.value;   
 var   finalidade=document.form1.finalidade.value;   
 var   visualizacao=document.form1.visualizacao.value;   
 var   limite=document.form1.limite.value;   
 window.open("ds002.php?nome=ds&titulo="+titulo+"&finalidade="+finalidade+"&limite="+limite+"&visualizacao="+visualizacao+"&veri=res","Relatório","toolbar=no,menubar=no,scrollbars=no,resizable=yes,location=no,directories=no,status=no");
 }
</script>
<br>
<table border="0" cellpadding="0" align="center" cellspacing="0" bgcolor="#cccccc"><br><br>
<form name="form1" method="post">
  <tr align="100%">
   <td height="35" align="center" colspan="2"><h5>Dados Referentes ao Relatório</h5></td>
 </tr>
  <tr>
   <td height="35" width="10%"><b>Nome:</b></td>
   <td>ds</td>
 </tr> 
 <tr > 
   <td height="35"><b>Sintaxe SQL:</b></td>
   <td>select z01_nome, z01_ender from cgm where z01_nome like \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\'PAULO\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\%\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\'</td>
 </tr> 
 <tr> 
   <td height="35"><b>Titulo:</b></td>
   <td><input type="text" name="titulo" value="asD"></td>
 </tr> 
 <tr> 
   <td height="35"><b>Finalidade:</b></td>
   <td><input type="text" name="finalidade" value="ASd"></td>
 <tr> 
   <td height="35"><b>Pagina:</b></td> 
   <td><select  name="visualizacao">
      <option value="P" selected >Retrato</option>
      <option value="L" >Paisagem</option>
   </td> 
 </tr> 
   <td nowrap ><b>Limite de linhas:</b></td>
   <td><input  type="text" name="limite" value="0"></td>
 </tr> 
 <tr>
   <td height="40" align="center" colspan="2">
      <input type="button" name="abrir" value="Gerar Relatório" onclick="abra()">
   </td>
 </tr>
</form1>
</table>  
</body>
</html>
