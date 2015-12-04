<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
$clrotulo = new rotulocampo;
$clrotulo->label('at05_data');
?>
<html>
<head>
<title>Documento sem t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script>
</script>
</head>
<body bgcolor=#CCCCCC bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<center>
<form method="post" name="form1" target="relat">
<table width="60%">
    <tr>
   	   <td align="center"><br><br><font face="Arial, Helvetica, sans-serif"><strong>Relatório de Atendimentos Vencidos</strong></font></td>
    </tr>
    <tr>
      <td><table width="100%">
  <tr>
    <td nowrap title="<?=$Tat05_data?>">
       <?=$Lat05_data?>
    </td>
    <td> 
<?
$at05_data_dia = date("d",db_getsession("DB_datausu"));
$at05_data_mes = date("m",db_getsession("DB_datausu"));
$at05_data_ano = date("Y",db_getsession("DB_datausu"));
db_inputdata('at05_data',@$at05_data_dia,@$at05_data_mes,@$at05_data_ano,true,'text','1',"")
?>
    </td>
  </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center"><input name="consulta" type="button" value="Relatório" onClick="js_relatorio()">
      </td>
      </tr>
  </table>
</form>
<script>
function js_relatorio(){
  window.open('ate2_relatorioitem001.php?&at05_data_dia='+document.form1.at05_data_dia.value+'&at05_data_mes='+document.form1.at05_data_mes.value+'&at05_data_ano='+document.form1.at05_data_ano.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
}
</script>
</center>
<? 
 db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
