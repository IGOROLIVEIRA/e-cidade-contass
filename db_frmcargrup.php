<?
//MODULO: cadastro
$clcargrup->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tj32_grupo?>">
       <?=@$Lj32_grupo?>
    </td>
    <td>
<?
db_input('j32_grupo',4,$Ij32_grupo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tj32_descr?>">
       <?=@$Lj32_descr?>
    </td>
    <td>
<?
db_input('j32_descr',40,$Ij32_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tj32_tipo?>">
       <?=@$Lj32_tipo?>
    </td>
    <td>
<?
$x = array('L'=>'Lote','F'=>'Face','C'=>'Construção');
db_select('j32_tipo',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  </table>
  </center>
<input name="db_opcao" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cargrup','func_cargrup.php?funcao_js=parent.js_preenchepesquisa|j32_grupo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_cargrup.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave;";
  }
  ?>
}
</script>
