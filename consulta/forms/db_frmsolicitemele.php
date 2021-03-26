<?
$clrotulo = new rotulocampo;
$clrotulo->label("pc01_descrmater");
$clrotulo->label("pc80_codproc");
?>
<center>
<form name='form1'>
<table border="0">
  <tr>
    <td align="center" nowrap>
      <center>
      <iframe name="iframe_solicitemele" id="solicitem" marginwidth="0" marginheight="0" frameborder="0" src="com1_solicitemeleiframe001.php" width="770" height="380"></iframe>
      <?
      db_input('pc80_codproc',8,$Ipc80_codproc,true,'hidden',3);
      ?>
      </center>
    </td>
  </tr>
  <tr>
    <td align="center">
      <input name="incluir" type="button" id="incluir" value="Incluir sub-elementos" onclick='js_submit();'>
      <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
    </td>
  </tr>
</table>
</form>
</center>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pcproc','func_pcproc.php?funcao_js=parent.js_preenchepesquisa|pc80_codproc','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_pcproc.hide();
  <?
  echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave+'&liberaaba=false'";
  ?>
}
function js_submit(){
  erro = 0;
  x = iframe_solicitemele.document.form1;
  for(i=0;i<x.length;i++){
    if(x.elements[i].type == "checkbox"){
      if(x.elements[i].checked == true){
	erro++;
      }
    }
  }
  if(erro!=0){
    obj=iframe_solicitemele.document.createElement('input');
    obj.setAttribute('name','incluir');
    obj.setAttribute('type','hidden');
    obj.setAttribute('value','incluir');
    iframe_solicitemele.document.form1.appendChild(obj);
    iframe_solicitemele.document.form1.submit();
  }else{
    alert("Selecione um ou mais itens para continuar.");
  }
}
</script>
