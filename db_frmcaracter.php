<?
//MODULO: cadastro
$clcaracter->rotulo->label();
$clcarpadrao->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("j32_descr");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tj31_codigo?>">
       <?=@$Lj31_codigo?>
    </td>
    <td> 
<?
db_input('j31_codigo',4,$Ij31_codigo,true,'text',3,"")
?>
    <td>
  <tr>
  <tr>
    <td nowrap title="<?=@$Tj31_descr?>">
       <?=@$Lj31_descr?>
    </td>
    <td> 
<?
db_input('j31_descr',40,$Ij31_descr,true,'text',$db_opcao,"")
?>
    <td>
  <tr>
  <tr>
    <td nowrap title="<?=@$Tj31_grupo?>">
       <?
       db_ancora(@$Lj31_grupo,"js_pesquisaj31_grupo(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('j31_grupo',4,$Ij31_grupo,true,'text',$db_opcao," onchange='js_pesquisaj31_grupo(false);'")
?>
       <?
db_input('j32_descr',40,$Ij32_descr,true,'text',3,'')
       ?>
    <td>
  <tr>
  <tr>
    <td nowrap title="<?=@$Tj31_pontos?>">
       <?=@$Lj31_pontos?>
    </td>
    <td> 
<?
db_input('j31_pontos',4,$Ij31_pontos,true,'text',$db_opcao,"")
?>
    <td>
  <tr>
  <tr>
    <td nowrap title="<?=@$Tj33_codcaracter?>">
 <?=$Lj33_codcaracter?>
    </td>
    <td> 
<?
  $matriz = array('N'=>"NAO",'S'=>"SIM");
  db_select('j33_codcaracter',$matriz,true,$db_opcao);
  db_input('padrao',4,"padrao",true,'hidden',1,"")
   
?>
    </td>
  </tr>
  </table>
  </center>
<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
<input name="voltar" type="button" id="voltar" value="Voltar" onclick="js_volta();" >
</form>
<script>
function js_volta(chave){
  location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>';
}
function js_pesquisaj31_grupo(mostra){
  if(mostra==true){
    db_iframe.jan.location.href = 'func_cargrup.php?funcao_js=parent.js_mostracargrup1|0|1';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_cargrup.php?pesquisa_chave='+document.form1.j31_grupo.value+'&funcao_js=parent.js_mostracargrup';
  }
}
function js_mostracargrup(chave,erro){
  document.form1.j32_descr.value = chave; 
  if(erro==true){ 
    document.form1.j31_grupo.focus(); 
    document.form1.j31_grupo.value = ''; 
  }
}
function js_mostracargrup1(chave1,chave2){
  document.form1.j31_grupo.value = chave1;
  document.form1.j32_descr.value = chave2;
  db_iframe.hide();
}
function js_pesquisa(){
  db_iframe.jan.location.href = 'func_caracter.php?funcao_js=parent.js_preenchepesquisa|0';
  db_iframe.mostraMsg();
  db_iframe.show();
  db_iframe.focus();
}
function js_preenchepesquisa(chave){
  db_iframe.hide();
  location.href = '<?=basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])?>'+"?chavepesquisa="+chave;
}
</script>
<?
$func_iframe = new janela('db_iframe','');
$func_iframe->posX=1;
$func_iframe->posY=1;
$func_iframe->largura=780;
$func_iframe->altura=430;
$func_iframe->titulo='Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();
?>
