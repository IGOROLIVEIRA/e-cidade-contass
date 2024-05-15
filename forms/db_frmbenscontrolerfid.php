<?
//MODULO: patrimonio
$clbenscontrolerfid->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tt214_sequencial?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Lt214_sequencial?>
    </td>
    <td> 
<?
db_input('t214_sequencial',8,$It214_sequencial,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tt214_codigobem?>">
       <?=@$Lt214_codigobem?>
    </td>
    <td> 
<?
db_input('t214_codigobem',8,$It214_codigobem,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tt214_placabem?>">
       <?=@$Lt214_placabem?>
    </td>
    <td> 
<?
db_input('t214_placabem',30,$It214_placabem,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tt214_descbem?>">
       <?=@$Lt214_descbem?>
    </td>
    <td> 
<?
db_input('t214_descbem',250,$It214_descbem,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tt214_usuario?>">
       <?=@$Lt214_usuario?>
    </td>
    <td> 
<?
db_input('t214_usuario',8,$It214_usuario,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tt214_dtlancamento?>">
       <?=@$Lt214_dtlancamento?>
    </td>
    <td> 
<?
db_inputdata('t214_dtlancamento',@$t214_dtlancamento_dia,@$t214_dtlancamento_mes,@$t214_dtlancamento_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tt214_instit?>">
       <?=@$Lt214_instit?>
    </td>
    <td> 
<?
db_input('t214_instit',8,$It214_instit,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tt214_controlerfid?>">
       <?=@$Lt214_controlerfid?>
    </td>
    <td> 
<?
db_input('t214_controlerfid',2,$It214_controlerfid,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_benscontrolerfid','func_benscontrolerfid.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_benscontrolerfid.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
