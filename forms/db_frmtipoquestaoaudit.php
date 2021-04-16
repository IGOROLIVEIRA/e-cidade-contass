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
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa(false);" >
<input name="importar" type="button" id="importar" value="Importar" onclick="js_pesquisa(true);" <?=($db_opcao==1||$db_opcao==3?"style='visibility:hidden;'":"")?> <?= (!isset($ci01_codtipo) || $ci01_codtipo == null ) ? "disabled":"" ?> >
<input type="hidden" name="NumQuestoesTipo" id="iNumQuestoesTipo" value="<?= $iNumQuestoesTipo > 0 ? $iNumQuestoesTipo : 0 ?>">
</form>
<script>

sRPC = 'cin4_questaoaudit.RPC.php';

function js_pesquisa(lImportar){
  
  if (lImportar) {
    js_OpenJanelaIframe('','db_iframe_tipoquestaoaudit','func_tipoquestaoaudit.php?funcao_js=parent.js_importar|0','Selecione',true,0);
  } else {
    js_OpenJanelaIframe('','db_iframe_tipoquestaoaudit','func_tipoquestaoaudit.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true,0);
  }
  
}

function js_preenchepesquisa(chave){
  db_iframe_tipoquestaoaudit.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_importar(iCodTipoOrigem) {

  if ( !confirm('Deseja importar as questões do tipo '+iCodTipoOrigem+"?") ) {
    return false;
  }

  db_iframe_tipoquestaoaudit.hide();

  try{

    js_divCarregando("Aguarde, buscando questões...", "msgBox");

    var oParametro            = new Object();
    oParametro.exec           = 'importarQuestao';
    oParametro.iCodTipoOrigem = iCodTipoOrigem;
    oParametro.iCodTipoDestino = $('ci01_codtipo').value;

    new Ajax.Request(sRPC,
                    {
                    method: 'post',
                    parameters: 'json='+Object.toJSON(oParametro),
                    onComplete: js_completaImportar
                    });

  } catch (e) {
    alert(e.toString());
  }
}

function js_completaImportar(oAjax) {

  js_removeObj('msgBox');
  var oRetorno = eval("("+oAjax.responseText+")");

  alert(oRetorno.sMensagem.urlDecode());

  if (oRetorno.status == 1) {    
    
    parent.mo_camada('questaoauditquestoes');
    top.corpo.iframe_questaoauditquestoes.location.reload();

  }

}

function js_excluir() {
  
  var iNumQuestoesTipo = document.getElementById("iNumQuestoesTipo").value;

  if(iNumQuestoesTipo > 0) {
    if ( !confirm("Existem questões de auditoria lançadas, tem certeza que deseja efetuar a exclusão?") ) {
      event.preventDefault();
    }
  }
  
}
</script>