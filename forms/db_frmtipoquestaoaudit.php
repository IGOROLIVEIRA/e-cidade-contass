<?
//MODULO: Controle Interno
$cltipoquestaoaudit->rotulo->label();
?>
<form name="form1" method="post" action="" <?= $db_opcao == 3 ? "onsubmit='js_excluir()'" : "" ?>>
<center>

    <fieldset class="fildset-principal">
        <legend>
            <b>Cadastro de Questões de Auditoria</b>
        </legend>

        <table border="0">
          <tr>
            <td nowrap title="<?=@$Tci01_codtipo?>">
            <input name="oid" type="hidden" value="<?=@$oid?>">
              <?=@$Lci01_codtipo?>
            </td>
            <td> 
        <?
        db_input('ci01_codtipo',11,$Ici01_codtipo,true,'text',3,"")
        ?>
            </td>
          </tr>
          <tr>
            <td nowrap title="<?=@$Tci01_tipoaudit?>">
              <?=@$Lci01_tipoaudit?>
            </td>
            <td> 
        <?
        db_input('ci01_tipoaudit',150,$Ici01_tipoaudit,true,'text',$db_opcao,"")
        ?>
            </td>
          </tr>
        </table>
    </fieldset>
</center>
<table>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Salvar":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
<input name="importar" type="button" id="importar" value="Importar" onclick="js_importar();" <?=($db_opcao==1||$db_opcao==3?"style='visibility:hidden;'":"")?> >
<input type="hidden" name="NumQuestoesTipo" id="iNumQuestoesTipo" value="<?= $iNumQuestoesTipo > 0 ? $iNumQuestoesTipo : 0 ?>">
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('','db_iframe_tipoquestaoaudit','func_tipoquestaoaudit.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true,0);
}

function js_preenchepesquisa(chave){
  db_iframe_tipoquestaoaudit.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_importar() {
  alert('importar');
}

function js_excluir() {
  
  // console.log($('iNumQuestoesTipo'));
  var iNumQuestoesTipo = document.getElementById("iNumQuestoesTipo").value;

  if(iNumQuestoesTipo > 0) {
    if ( !confirm("Existem questões de auditoria lançadas, tem certeza que deseja efetuar a exclusão?") ) {
      event.preventDefault();
    }
  }
  
}
</script>