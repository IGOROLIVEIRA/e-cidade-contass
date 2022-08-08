<?
//MODULO: licitacao
$cldecretopregao->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-left: 80px; margin-top: 10px;">
<legend>Decreto</legend>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tl201_sequencial?>">
       <?=@$Ll201_sequencial?>
    </td>
    <td>
<?
db_input('l201_sequencial',10,$Il201_sequencial,true,'text',3,"")
?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$Tl201_tipodecreto?>">
       <?=@$Ll201_tipodecreto?>
    </td>
    <td>
<?
$x = array("1"=>"REGISTRO DE PREÇO","2"=>"PREGÃO");
db_select('l201_tipodecreto',$x,true,$db_opcao,"");
?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$Tl201_numdecreto?>">
       <?=@$Ll201_numdecreto?>
    </td>
    <td>
<?
db_input('l201_numdecreto',10,$Il201_numdecreto,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl201_datadecreto?>">
       <?=@$Ll201_datadecreto?>
    </td>
    <td>
<?
db_inputdata('l201_datadecreto',@$l201_datadecreto_dia,@$l201_datadecreto_mes,@$l201_datadecreto_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl201_datapublicacao?>">
       <?=@$Ll201_datapublicacao?>
    </td>
    <td>
<?
db_inputdata('l201_datapublicacao',@$l201_datapublicacao_dia,@$l201_datapublicacao_mes,@$l201_datapublicacao_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </fieldset>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_decretopregao','func_decretopregao.php?funcao_js=parent.js_preenchepesquisa|l201_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_decretopregao.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
