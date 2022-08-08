<?
//MODULO: agua
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$claguaconstr->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("x01_numcgm");
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
     $x11_matric = "";
     $x11_numero = "";
     $x11_complemento = "";
     $x11_area = "";
     $x11_pavimento = "";
     $x11_qtdfamilia = "";
     $x11_qtdpessoas = "";
   }
}
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tx11_codconstr?>">
       <?=@$Lx11_codconstr?>
    </td>
    <td>
<?
db_input('x11_codconstr',6,$Ix11_codconstr,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx11_matric?>">
       <?
       db_ancora(@$Lx11_matric,"js_pesquisax11_matric(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('x11_matric',10,$Ix11_matric,true,'text',$db_opcao," onchange='js_pesquisax11_matric(false);'")
?>
       <?
db_input('x01_numcgm',10,$Ix01_numcgm,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx11_numero?>">
       <?=@$Lx11_numero?>
    </td>
    <td>
<?
db_input('x11_numero',8,$Ix11_numero,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx11_complemento?>">
       <?=@$Lx11_complemento?>
    </td>
    <td>
<?
db_input('x11_complemento',20,$Ix11_complemento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx11_area?>">
       <?=@$Lx11_area?>
    </td>
    <td>
<?
db_input('x11_area',6,$Ix11_area,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx11_pavimento?>">
       <?=@$Lx11_pavimento?>
    </td>
    <td>
<?
db_input('x11_pavimento',20,$Ix11_pavimento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx11_qtdfamilia?>">
       <?=@$Lx11_qtdfamilia?>
    </td>
    <td>
<?
db_input('x11_qtdfamilia',4,$Ix11_qtdfamilia,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tx11_qtdpessoas?>">
       <?=@$Lx11_qtdpessoas?>
    </td>
    <td>
<?
db_input('x11_qtdpessoas',4,$Ix11_qtdpessoas,true,'text',$db_opcao,"")
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
	 $chavepri= array("x11_codconstr"=>@$x11_codconstr);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $claguaconstr->sql_query_file($x11_codconstr);
	 $cliframe_alterar_excluir->campos  ="x11_codconstr,x11_matric,x11_numero,x11_complemento,x11_area,x11_pavimento,x11_qtdfamilia,x11_qtdpessoas";
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
function js_pesquisax11_matric(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguaconstr','db_iframe_aguabase','func_aguabase.php?funcao_js=parent.js_mostraaguabase1|x01_matric|x01_numcgm','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.x11_matric.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_aguaconstr','db_iframe_aguabase','func_aguabase.php?pesquisa_chave='+document.form1.x11_matric.value+'&funcao_js=parent.js_mostraaguabase','Pesquisa',false);
     }else{
       document.form1.x01_numcgm.value = '';
     }
  }
}
function js_mostraaguabase(chave,erro){
  document.form1.x01_numcgm.value = chave;
  if(erro==true){
    document.form1.x11_matric.focus();
    document.form1.x11_matric.value = '';
  }
}
function js_mostraaguabase1(chave1,chave2){
  document.form1.x11_matric.value = chave1;
  document.form1.x01_numcgm.value = chave2;
  db_iframe_aguabase.hide();
}
</script>
