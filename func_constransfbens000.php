<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
require_once("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_benstransf_classe.php");

$clbenstransf = new cl_benstransf;
$clbenstransf->rotulo->label();
$clrotulo = new rotulocampo;

db_postmemory($HTTP_POST_VARS);
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>

<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC onLoad="document.form1.t93_codtran.focus();">
<form class="container" name="form1" method="post">
  <fieldset>
    <legend>Consulta de Transferência de Bens:</legend>
    <table class="form-container">

      <tr>
        <td title="<?=$Tt93_codtran?>"> <? db_ancora(@$Lt93_codtran,"js_pesquisa_benstransf(true);",1);?>  </td>
        <td>
          <?
             db_input("t93_codtran",8,$It93_codtran,true,"text",4,"onchange='js_pesquisa_benstransf(false);'");
          ?>
        </td>
      </tr>

    </table>
  </fieldset>
  <input name="pesquisa" type="button" onclick='js_abre(this.name);'  value="Pesquisa">
</form>
<? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
<script>

function js_abre(botao){

  if(document.form1.t93_codtran == ''){
    alert("Selecione uma Transferência");
  } else {

    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_func_constransfbens001','pat1_constransfbens002.php?t93_codtran='+document.form1.t93_codtran.value,'Pesquisa',true);

    jan.moveTo(0,0);
    document.form1.t93_codtran.style.backgroundColor='';
  }
}

//--------------------------------
function js_pesquisa_benstransf(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_benstransf','func_benstransf.php?funcao_js=parent.js_mostrabemtransf1|t93_codtran','Pesquisa',true);
  }else{
     if(document.form1.t93_codtran.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_benstransf','func_benstransf?pesquisa_chave='+document.form1.t93_codtran.value+'&funcao_js=parent.js_mostrabemtransf','Pesquisa',false);
     }
  }
}
function js_mostrabemtransf(chave,erro){
  if(erro==true){
    document.form1.t93_codtran.focus();
    document.form1.t93_codtran.value = '';
  }
}
function js_mostrabemtransf1(chave1){
  document.form1.t93_codtran.value = chave1;
  db_iframe_benstransf.hide();
}
</script>
</body>
</html>
