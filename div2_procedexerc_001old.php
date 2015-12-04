<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt12');
$clrotulo->label('DBtxt13');
db_postmemory($HTTP_POST_VARS);
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="file:///D|/www/dbportal2/scripts/scripts.js"></script>
<link href="file:///D|/www/dbportal2/estilos.css" rel="stylesheet" type="text/css">
<script>
function js_verifica(){
  var val1 = new Number(document.form1.DBtxt12.value);
  var val2 = new Number(document.form1.DBtxt13.value);
  if(val1.valueOf() > val2.valueOf()){
    alert('O Ano Final Não Pode Ser Menor Que o Inicial.');
    return false;
  } 
  return true;
}

</script>

<?
if(isset($ordem)){
?>
<script>
function js_emite(){
  window.open('div2_procedexerc_002.php?ordem=<?=$ordem?>&valormaximo=<?=$DBtxt13?>&valorminimo=<?=$DBtxt12?>','');
}
</script>  
<?
}
?>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" height="30" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="30">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" height="430" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
      <form name="form1" method="post" action="" onsubmit="return js_verifica();">
        <div align="center"> 
          <table width="31%" border="0" cellspacing="0">
            <tr> 
              <td height="30" bordercolor="#FFFFCC">&nbsp;</td>
            </tr>
            <tr> 
              <td width="100%" height="30" bordercolor="#FFFFCC"><font size="2"><strong>Ordem:</strong></font></td>
            </tr>
            <tr> 
              <td height="61" bordercolor="#FFFFCC"> <p> <font size="2"> 
                  <input name="ordem" type="radio" value="v01_proced" checked >
                  <strong>Proced&ecirc;ncia<br>
                  <input type="radio" name="ordem" value="v01_exerc">
                  Exerc&iacute;cio </strong></font></p></td>
            </tr>
            <tr> 
              <td height="44" bordercolor="#FFFFCC"><p>&nbsp;</p>
                <p><strong> Exerc&iacute;cios:</strong> </p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr> 
                    <td height="35"><div align="left"><font size="2"><strong>De</strong>: 
                        <?
						  db_input('DBtxt12',8,$IDBtxt12,true,'text',2);
						  ?>
                        </font></div></td>
                    <td>&nbsp;</td>
                    <td><div align="left"><font size="2"><strong>At&eacute;:</strong> 
                        <?
						  db_input('DBtxt13',8,$IDBtxt13,true,'text',2);
						  ?>
                        </font></div></td>
                  </tr>
                </table></td>
              <td width="2%" rowspan="5">&nbsp;</td>
            </tr>
            <tr> 
              <td bordercolor="#FFFFCC">&nbsp;</td>
            </tr>
            <tr> 
              <td bordercolor="#FFFFCC"><div align="center"><font size="2"> 
                  <input name="emite2" id="emite" type="submit" value="Processar">
                  </font></div></td>
            </tr>
            <tr> 
              <td bordercolor="#FFFFCC">&nbsp;</td>
            </tr>
            <tr> 
              <td bordercolor="#FFFFCC">&nbsp;</td>
            </tr>
          </table>
          <?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
        </div>
      </form> </td>
  </tr>
</table>
<p>&nbsp; </p>
<p>&nbsp;</p>

</body>
</html>
<?
if(isset($ordem)){
  echo "<script>
       js_emite();
       </script>";  
}
?>
