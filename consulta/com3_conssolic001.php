<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_solicita_classe.php");
$clsolicita = new cl_solicita;
$clrotulo = new rotulocampo;
$clsolicita->rotulo->label();
db_postmemory($HTTP_POST_VARS);
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc" onload="">
<center>
<form name="form1" method="post" action="com3_conssolic002.php">
  <table border='0'>
    <tr height="20px">
      <td >&nbsp;</td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td align="left" nowrap title="<?=$Tpc10_numero?>"> <? db_ancora(@$Lpc10_numero,"js_pesquisapc10_numero(true);",1);?></td>
      <td align="left" nowrap>
      <?
      db_input('pc10_numero',8,$Ipc10_numero,true,"text",1,"onchange='js_pesquisapc10_numero(false);'");
      ?>
      </td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input name="enviar" type="button" id="enviar" value="Enviar dados" onclick='js_verifica();'>
      </td>
    </tr>
  </table>
</form>
</center>
</body>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</html>
<script>
function js_verifica(){
  if(document.form1.pc10_numero.value==''){
    alert("Informe o número da solicitação.");
  }else{
    document.form1.submit();
  }
}
function js_pesquisapc10_numero(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_solicita','func_solicita.php?funcao_js=parent.js_mostrapcorcamitem1|pc10_numero','Pesquisa',true);
  }else{
    if(document.form1.pc10_numero.value!=""){
      js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_solicita','func_solicita.php?funcao_js=parent.js_mostrapcorcamitem&pesquisa_chave='+document.form1.pc10_numero.value,'Pesquisa',false);
    }else{
      document.form1.pc10_numero.value = "";
    }
  }
}
function js_mostrapcorcamitem1(chave1,chave2){
  document.form1.pc10_numero.value = chave1;
  db_iframe_solicita.hide();
}
function js_mostrapcorcamitem(chave1,erro){
  if(erro==true){
    document.form1.pc10_numero.value = "";
  }
}
</script>
