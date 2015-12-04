<?
//MODULO: issqn
$clcadvencdesc->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tq92_codigo?>">
       <?=@$Lq92_codigo?>
    </td>
    <td> 
<?
db_input('q92_codigo',4,$Iq92_codigo,true,'text',$db_opcao,"")
?>
    <td>
  <tr>
  <tr>
    <td nowrap title="<?=@$Tq92_descr?>">
       <?=@$Lq92_descr?>
    </td>
    <td> 
<?
db_input('q92_descr',40,$Iq92_descr,true,'text',$db_opcao,"")
?>
    <td>
  <tr>
  <tr>
    <td nowrap title="<?=@$Tq92_codbco?>">
       <?=@$Lq92_codbco?>
    </td>
    <td> 
<?
db_input('q92_codbco',4,$Iq92_codbco,true,'text',$db_opcao,"")
?>
    <td>
  <tr>
  <tr>
    <td nowrap title="<?=@$Tq92_codage?>">
       <?=@$Lq92_codage?>
    </td>
    <td> 
<?
db_input('q92_codage',5,$Iq92_codage,true,'text',$db_opcao,"")
?>
    <td>
  <tr>
  <tr>
    <td nowrap title="<?=@$Tq92_tipo?>">
       <?=@$Lq92_tipo?>
    </td>
    <td> 
<?
db_input('q92_tipo',4,$Iq92_tipo,true,'text',$db_opcao,"")
?>
    <td>
  <tr>
  </table>
  </center>
<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  db_iframe.jan.location.href = 'func_cadvencdesc.php?funcao_js=parent.js_preenchepesquisa|0';
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
