<?
include("libs/db_stdlibwebseller.php");
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_matricula_classe.php");
include("classes/db_calendario_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clmatricula = new cl_matricula;
$clcalendario = new cl_calendario;
$db_opcao = 1;
$db_botao = true;
$nomeescola = db_getsession("DB_nomedepto");
$escola = db_getsession("DB_coddepto");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
 <tr>
  <td width="360" height="18">&nbsp;</td>
  <td width="263">&nbsp;</td>
  <td width="25">&nbsp;</td>
  <td width="140">&nbsp;</td>
 </tr>
</table>
<?MsgAviso(db_getsession("DB_coddepto"),"escola");?>
<a name="topo"></a>
<form name="form1" method="post" action="">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
  <td valign="top" bgcolor="#CCCCCC">
   <br>
   <fieldset style="width:95%"><legend><b>Quadro de Falecimento</b></legend>
    <table border="0">
     <tr>
      <td align="left">
       <b>Selecione o Calendário:</b><br>
       <select name="calendario" style="font-size:9px;width:150px;height:18px;">
        <option></option>
        <?
        $sql = "SELECT ed52_i_codigo,ed52_i_ano,ed52_c_descr
                FROM calendario
                 inner join calendarioescola on ed38_i_calendario = ed52_i_codigo
                WHERE ed38_i_escola = $escola
                AND ed52_c_passivo = 'N'
                ORDER BY ed52_i_ano DESC";
        $sql_result = pg_query($sql);
        while($row=pg_fetch_array($sql_result)){
         $cod_curso=$row["ed52_i_ano"];
         $desc_curso=$row["ed52_c_descr"];
         ?>
         <option value="<?=$cod_curso;?>" <?=$cod_curso==@$calendario?"selected":""?>><?=$desc_curso;?></option>
         <?
        }
        ?>
       </select>
      </td>
      <td>
       <b>Selecione o Mês:</b><br>
       <select name="mes" style="font-size:9px;width:150px;height:18px;">
        <option value=""></option>
        <option value="1">JANEIRO</option>
        <option value="2">FEVEREIRO</option>
        <option value="3">MARÇO</option>
        <option value="4">ABRIL</option>
        <option value="5">MAIO</option>
        <option value="6">JUNHO</option>
        <option value="7">JULHO</option>
        <option value="8">AGOSTO</option>
        <option value="9">SETEMBRO</option>
        <option value="10">OUTUBRO</option>
        <option value="11">NOVEMBRO</option>
        <option value="12">DEZEMBRO</option>
       </select>
      </td>
      <td valign='bottom'>
       <input type="button" name="procurar" value="Processar" onclick="js_procurar(document.form1.calendario.value,document.form1.mes.value)">
      </td>
     </tr>
    </table>
   </fieldset>
  </td>
 </tr>
</table>
</form>
<?db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
</body>
</html>
<script>
function js_procurar(calendario,mes){
 if(calendario!="" && mes!=""){
  jan = window.open('edu2_qd_especifalecimento002.php?fg=fg&calendario='+calendario+'&mes='+mes,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
 }
}
<?if(pg_num_rows($sql_result)>0){?>
 document.form1.calendario.options[1].selected = true;
<?}?>
</script>
