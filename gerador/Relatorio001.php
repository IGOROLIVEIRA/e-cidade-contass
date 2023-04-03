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
<body bgcolor=#CCCCCC bgcolor="#cccccc" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<script>
 function nova(){
  location.href="../con2_gerelatorio006.php?vaite=true";
}
  function abra(){
 var   titulo=document.form1.titulo.value;   
 var   finalidade=document.form1.finalidade.value;   
 var   visualizacao=document.form1.visualizacao.value;   
 var   limite=document.form1.limite.value;   
 window.open("Relatorio002.php?nome=Relatorio&titulo="+titulo+"&finalidade="+finalidade+"&limite="+limite+"&visualizacao="+visualizacao+"&veri=res","Relatório","toolbar=no,menubar=no,scrollbars=no,resizable=yes,location=no,directories=no,status=no");
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
   <td>Relatorio</td>
 </tr> 
 <tr > 
   <td height="35"><b>Sintaxe SQL:</b></td>
   <td>select  rh01_regist,
        z01_nome,
        rh37_descr,
        r70_descr,
        rh02_codreg
   from rhpessoal
                inner join cgm on z01_numcgm = rh01_numcgm
                inner join rhfuncao on rh01_funcao = rh37_funcao
                inner join rhlota on rh01_lotac = r70_codigo
                inner join rhpessoalmov on rh01_regist =rh02_regist
                left join rhpesrescisao on rh02_seqpes = rh05_seqpes
                inner join rhregime on rh02_codreg = rh30_codreg
   where rh01_admiss between \\\'1996-01-01\\\' and \\\'2006-07-31\\\'
                and rh02_codreg = 1
                and rh05_recis is null
                and rh02_anousu = 2006
                and rh02_mesusu = 07
  order by rh01_lotac, rh37_descr</td>
 </tr> 
 <tr> 
   <td height="35"><b>Titulo:</b></td>
   <td><input type="text" name="titulo" value="Admitidos entre 01/01/1996 e 31/07/2006"></td>
 </tr> 
 <tr> 
   <td height="35"><b>Finalidade:</b></td>
   <td><input type="text" name="finalidade" value="Por secretaria e funcao"></td>
 <tr> 
   <td height="35"><b>Pagina:</b></td> 
   <td><select  name="visualizacao">
      <option value="P">Retrato</option>
      <option value="L" selected>Paisagem</option>
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
