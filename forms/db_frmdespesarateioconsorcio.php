<?
//MODULO: contabilidade
$cldespesarateioconsorcio->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc217_sequencial?>">
       <?=@$Lc217_sequencial?>
    </td>
    <td>
<?
db_input('c217_sequencial',11,$Ic217_sequencial,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_enteconsorciado?>">
       <?=@$Lc217_enteconsorciado?>
    </td>
    <td>
<?
db_input('c217_enteconsorciado',11,$Ic217_enteconsorciado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_funcao?>">
       <?=@$Lc217_funcao?>
    </td>
    <td>
<?
db_input('c217_funcao',11,$Ic217_funcao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_subfuncao?>">
       <?=@$Lc217_subfuncao?>
    </td>
    <td>
<?
db_input('c217_subfuncao',11,$Ic217_subfuncao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_natureza?>">
       <?=@$Lc217_natureza?>
    </td>
    <td>
<?
db_input('c217_natureza',6,$Ic217_natureza,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_subelemento?>">
       <?=@$Lc217_subelemento?>
    </td>
    <td>
<?
db_input('c217_subelemento',2,$Ic217_subelemento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_fonte?>">
       <?=@$Lc217_fonte?>
    </td>
    <td>
<?
db_input('c217_fonte',11,$Ic217_fonte,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_mes?>">
       <?=@$Lc217_mes?>
    </td>
    <td>
<?
db_input('c217_mes',2,$Ic217_mes,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_anousu?>">
       <?=@$Lc217_anousu?>
    </td>
    <td>
<?
$c217_anousu = db_getsession('DB_anousu');
db_input('c217_anousu',4,$Ic217_anousu,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_valorempenhado?>">
       <?=@$Lc217_valorempenhado?>
    </td>
    <td>
<?
db_input('c217_valorempenhado',11,$Ic217_valorempenhado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_valorempenhadoanulado?>">
       <?=@$Lc217_valorempenhadoanulado?>
    </td>
    <td>
<?
db_input('c217_valorempenhadoanulado',11,$Ic217_valorempenhadoanulado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_valorliquidado?>">
       <?=@$Lc217_valorliquidado?>
    </td>
    <td>
<?
db_input('c217_valorliquidado',11,$Ic217_valorliquidado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_valorliquidadoanulado?>">
       <?=@$Lc217_valorliquidadoanulado?>
    </td>
    <td>
<?
db_input('c217_valorliquidadoanulado',11,$Ic217_valorliquidadoanulado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_valorpago?>">
       <?=@$Lc217_valorpago?>
    </td>
    <td>
<?
db_input('c217_valorpago',11,$Ic217_valorpago,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_valorpagoanulado?>">
       <?=@$Lc217_valorpagoanulado?>
    </td>
    <td>
<?
db_input('c217_valorpagoanulado',11,$Ic217_valorpagoanulado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc217_percentualrateio?>">
       <?=@$Lc217_percentualrateio?>
    </td>
    <td>
<?
db_input('c217_percentualrateio',11,$Ic217_percentualrateio,true,'text',$db_opcao,"")
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
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_despesarateioconsorcio','func_despesarateioconsorcio.php?funcao_js=parent.js_preenchepesquisa|c217_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_despesarateioconsorcio.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
