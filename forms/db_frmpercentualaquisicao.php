<?
//MODULO: sicom
$clpercentualaquisicao->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-left: 80px; margin-top: 10px;">
<legend>Percentual Licitável</legend>
<table border="0">
  <tr>
    <td>

    </td>
    <td>
<?
db_input('si90_sequencial',11,$Isi90_sequencial,true,'hidden',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi90_contemplaperc?>">
       <?=@$Lsi90_contemplaperc?>
    </td>
    <td>
<?
db_input('si90_contemplaperc',11,$Isi90_contemplaperc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi90_percentualestabelecido?>">
       <?=@$Lsi90_percentualestabelecido?>
    </td>
    <td>
<?
db_input('si90_percentualestabelecido',11,$Isi90_percentualestabelecido,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi90_anoreferencia?>">
       <?=@$Lsi90_anoreferencia?>
    </td>
    <td>
<?
db_input('si90_anoreferencia',11,$Isi90_anoreferencia,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </fieldset>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Salvar":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="excluir" type="submit" id="excluir" value="Excluir" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_percentualaquisicao','func_percentualaquisicao.php?funcao_js=parent.js_preenchepesquisa|si90_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_percentualaquisicao.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
