<?
//MODULO: issqn
$clativtipo->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("q03_descr");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tq80_ativ?>">
       <?
       db_ancora(@$Lq80_ativ,"js_pesquisaq80_ativ(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('q80_ativ',4,$Iq80_ativ,true,'text',$db_opcao," onchange='js_pesquisaq80_ativ(false);'")
?>
       <?
db_input('q03_descr',40,$Iq03_descr,true,'text',3,'')
       ?>
    <td>
  <tr>
  <tr>
    <td nowrap title="<?=@$Tq80_tipcal?>">
       <?=@$Lq80_tipcal?>
    </td>
    <td> 
<?
db_input('q80_tipcal',4,$Iq80_tipcal,true,'text',$db_opcao,"")
?>
    <td>
  <tr>
  </table>
  </center>
<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisaq80_ativ(mostra){
  if(mostra==true){
    db_iframe.jan.location.href = 'func_ativid.php?funcao_js=parent.js_mostraativid1|0|1';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }else{
    db_iframe.jan.location.href = 'func_ativid.php?pesquisa_chave='+document.form1.q80_ativ.value+'&funcao_js=parent.js_mostraativid';
  }
}
function js_mostraativid(chave,erro){
  document.form1.q03_descr.value = chave; 
  if(erro==true){ 
    document.form1.q80_ativ.focus(); 
    document.form1.q80_ativ.value = ''; 
  }
}
function js_mostraativid1(chave1,chave2){
  document.form1.q80_ativ.value = chave1;
  document.form1.q03_descr.value = chave2;
  db_iframe.hide();
}
function js_pesquisa(){
  db_iframe.jan.location.href = 'func_ativtipo.php?funcao_js=parent.js_preenchepesquisa|0';
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
$func_iframe->posY=20;
$func_iframe->largura=780;
$func_iframe->altura=430;
$func_iframe->titulo='Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();
?>
