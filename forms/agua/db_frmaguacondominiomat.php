<?
//MODULO: agua
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$claguacondominiomat->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("x01_numcgm");
$clrotulo->label("x31_matric");
if(isset($db_opcaoal)){
   $db_opcao=33;
    $db_botao=false;
}else if(isset($opcao) && $opcao=="alterar"){
    $db_botao=true;
    $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
    $db_opcao = 3;
    $db_botao=true;
}else{
    $db_opcao = 1;
    $db_botao=true;
    if(isset($novo) || isset($alterar) ||   isset($excluir) || (isset($incluir) && $sqlerro==false ) ){
     $x40_codcondominio = "";
   }
}
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx40_codcondominio?>">
       <?
       db_ancora(@$Lx40_codcondominio,"js_pesquisax40_codcondominio(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x40_codcondominio',8,$Ix40_codcondominio,true,'text',$db_opcao," onchange='js_pesquisax40_codcondominio(false);'")
?>
       <?
db_input('x31_matric',10,$Ix31_matric,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx40_matric?>">
       <?
       db_ancora(@$Lx40_matric,"js_pesquisax40_matric(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x40_matric',10,$Ix40_matric,true,'text',$db_opcao," onchange='js_pesquisax40_matric(false);'")
?>
       <?
db_input('x01_numcgm',10,$Ix01_numcgm,true,'text',3,'')
       ?>
    </td>
  </tr>
  </tr>
    <td colspan="2" align="center">
 <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  >
 <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" <?=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> >
    </td>
  </tr>
  </table>
 <table>
  <tr>
    <td valign="top"  align="center">
    <?
	 $chavepri= array("x40_matric"=>@$x40_matric,"x40_codcondominio"=>@$x40_codcondominio);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $claguacondominiomat->sql_query_file($x40_matric);
	 $cliframe_alterar_excluir->campos  ="x40_codcondominio,x40_matric";
	 $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
	 $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
    ?>
    </td>
   </tr>
 </table>
  </center>
</form>
<script>
function js_cancelar(){
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","novo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);
  document.form1.submit();
}
function js_pesquisax40_matric(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacondominiomat','db_iframe_aguabase','func_aguabase.php?funcao_js=parent.js_mostraaguabase1|x01_matric|x01_numcgm','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.x40_matric.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacondominiomat','db_iframe_aguabase','func_aguabase.php?pesquisa_chave='+document.form1.x40_matric.value+'&funcao_js=parent.js_mostraaguabase','Pesquisa',false);
     }else{
       document.form1.x01_numcgm.value = '';
     }
  }
}
function js_mostraaguabase(chave,erro){
  document.form1.x01_numcgm.value = chave;
  if(erro==true){
    document.form1.x40_matric.focus();
    document.form1.x40_matric.value = '';
  }
}
function js_mostraaguabase1(chave1,chave2){
  document.form1.x40_matric.value = chave1;
  document.form1.x01_numcgm.value = chave2;
  db_iframe_aguabase.hide();
}
function js_pesquisax40_codcondominio(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacondominiomat','db_iframe_aguacondominio','func_aguacondominio.php?funcao_js=parent.js_mostraaguacondominio1|x31_codcondominio|x31_matric','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.x40_codcondominio.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguacondominiomat','db_iframe_aguacondominio','func_aguacondominio.php?pesquisa_chave='+document.form1.x40_codcondominio.value+'&funcao_js=parent.js_mostraaguacondominio','Pesquisa',false);
     }else{
       document.form1.x31_matric.value = '';
     }
  }
}
function js_mostraaguacondominio(chave,erro){
  document.form1.x31_matric.value = chave;
  if(erro==true){
    document.form1.x40_codcondominio.focus();
    document.form1.x40_codcondominio.value = '';
  }
}
function js_mostraaguacondominio1(chave1,chave2){
  document.form1.x40_codcondominio.value = chave1;
  document.form1.x31_matric.value = chave2;
  db_iframe_aguacondominio.hide();
}
</script>
