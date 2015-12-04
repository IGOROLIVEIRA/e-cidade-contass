<?php

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_bensbaix_classe.php");
$clbensbaix = new cl_bensbaix;
$clrotulo = new rotulocampo;
$clbensbaix->rotulo->label();
db_postmemory($HTTP_POST_VARS);
$t93_dataINI="";
$t93_dataFIM = "";

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>

<script>
function js_abre(botao){
  dataINI="";
  dataFIM="";
  if(document.form1.t93_dataINI_dia.value!="" && document.form1.t93_dataINI_mes.value!="" && document.form1.t93_dataINI_ano.value!=""){
    dataINI = document.form1.t93_dataINI_ano.value+'-'+document.form1.t93_dataINI_mes.value+'-'+document.form1.t93_dataINI_dia.value;
    inicio= new Date(document.form1.t93_dataINI_ano.value,document.form1.t93_dataINI_mes.value-1,document.form1.t93_dataINI_dia.value);
  }
  if(document.form1.t93_dataFIM_dia.value!="" && document.form1.t93_dataFIM_mes.value!="" && document.form1.t93_dataFIM_ano.value!=""){
    dataFIM = document.form1.t93_dataFIM_ano.value+'-'+document.form1.t93_dataFIM_mes.value+'-'+document.form1.t93_dataFIM_dia.value;
    fim= new Date(document.form1.t93_dataFIM_ano.value,document.form1.t93_dataFIM_mes.value-1,document.form1.t93_dataFIM_dia.value);
  }
  if ( dataINI != "" && dataFIM != "" && fim < inicio ) { 
    alert(_M("patrimonial.patrimonio.func_periodobenstrans002.data_inicial_menor_data_final"));
    document.form1.t93_dataINI_dia.focus();
  }else{
    if(botao=="relatorio"){
      jan = window.open('func_periodobenstrans002.php?dataINI='+dataINI+'&dataFIM='+dataFIM,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
    }
    jan.moveTo(0,0);
  }
}
</script>  
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC onload="document.form1.t93_dataINI_dia.focus();">
<form class="container" name="form1" method="post" >
  <fieldset>
    <legend>Consulta - Transferência de Bens</legend>
    <table class="form-container">
      <tr> 
        <td title="Bens baixados no intervalo de data"> <? db_ancora(@$Lt55_baixa,"js_pesquisa_bem(true);",3);?>  </td>
        <td>
          <?
            db_inputdata('t93_dataINI',@$t93_dataINI_dia,@$t93_dataINI_mes,@$t93_dataINI_ano,true,'text',1,"");
          ?>
        </td>
        <td> &nbsp;&nbsp;&nbsp;<b>a</b>&nbsp;&nbsp;&nbsp;</td>
        <td>
          <?
            db_inputdata('t93_dataFIM',@$t93_dataFIM_dia,@$t93_dataFIM_mes,@$t93_dataFIM_ano,true,'text',1,"");
          ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <input name="relatorio" type="button" onclick='js_abre(this.name);'  value="Gerar relatório">
</form>
 

</center>
<? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
</body>
</html>