<?
//MODULO: licitacao
$cllicatareg->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tl221_sequencial?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       <?=@$Ll221_sequencial?>
    </td>
    <td> 
<?
db_input('l221_sequencial',8,$Il221_sequencial,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl221_licitacao?>">
       <?=@$Ll221_licitacao?>
    </td>
    <td> 
<?
db_input('l221_licitacao',8,$Il221_licitacao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl221_numata?>">
       <?=@$Ll221_numata?>
    </td>
    <td> 
<?
db_input('l221_numata',15,$Il221_numata,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl221_exercicio?>">
       <?=@$Ll221_exercicio?>
    </td>
    <td> 
<?
db_input('l221_exercicio',4,$Il221_exercicio,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl221_fornecedor?>">
       <?=@$Ll221_fornecedor?>
    </td>
    <td> 
<?
db_input('l221_fornecedor',8,$Il221_fornecedor,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl221_dataini?>">
       <?=@$Ll221_dataini?>
    </td>
    <td> 
<?
db_inputdata('l221_dataini',@$l221_dataini_dia,@$l221_dataini_mes,@$l221_dataini_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl221_datafinal?>">
       <?=@$Ll221_datafinal?>
    </td>
    <td> 
<?
db_inputdata('l221_datafinal',@$l221_datafinal_dia,@$l221_datafinal_mes,@$l221_datafinal_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl221_datapublica?>">
       <?=@$Ll221_datapublica?>
    </td>
    <td> 
<?
db_inputdata('l221_datapublica',@$l221_datapublica_dia,@$l221_datapublica_mes,@$l221_datapublica_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl221_veiculopublica?>">
       <?=@$Ll221_veiculopublica?>
    </td>
    <td> 
<?
db_input('l221_veiculopublica',100,$Il221_veiculopublica,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('top.corpo','db_iframe_licatareg','func_licatareg.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_licatareg.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
