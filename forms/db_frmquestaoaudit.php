<?
//MODULO: Controle Interno
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clquestaoaudit->rotulo->label();
if(isset($db_opcaoal) && !isset($opcao) && !isset($excluir)){
  $db_opcao=33;
   $db_botao=false;
}else if(isset($opcao) && $opcao=="alterar"){
   $db_botao=true;
   $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
   $db_opcao = 3;
   $db_botao=true;
}else{
  $db_opcao = 1;
  $db_botao=true;
  if(isset($novo) || isset($alterar) || isset($excluir) || (isset($incluir) && $sqlerro==false ) ){
    
    $ci02_codquestao      = "";
    $ci02_numquestao      = "";
    $ci02_questao         = "";
    $ci02_inforeq         = "";
    $ci02_fonteinfo       = "";
    $ci02_procdetal       = "";
    $ci02_objeto          = "";
    $ci02_possivachadneg  = "";

  }
} 
?>
<form name="form1" method="post" action="" <?= (isset($aProcesso) && $aProcesso != null) ? "onsubmit='js_submit()'" : "" ?>>
<center>
  <fieldset class="fildset-principal">
  <table border="0">
    <tr>
      <td nowrap title="<?=@$Tci02_codquestao?>">
      <input name="ci02_codquestao" type="hidden" value="<?=@$ci02_codquestao?>">
        <?=@$Lci02_codquestao?>
      </td>
      <td> 
  <?
  db_input('ci02_codquestao',11,$Ici02_codquestao,true,'text',3,"")
  ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Tci02_numquestao?>">
        <?=@$Lci02_numquestao?>
      </td>
      <td> 
  <?
  db_input('ci02_numquestao',11,$Ici02_numquestao,true,'text',$db_opcao,"")
  ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Tci02_questao?>">
        <?=@$Lci02_questao?>
      </td>
      <td> 
  <?
  db_textarea("ci02_questao",2,80, "", true, "text", $db_opcao, "", "", "",500);
  ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Tci02_inforeq?>">
        <?=@$Lci02_inforeq?>
      </td>
      <td> 
  <?
  db_textarea('ci02_inforeq',2,80,$Ici02_inforeq,true,'text',$db_opcao,"","","",500)
  ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Tci02_fonteinfo?>">
        <?=@$Lci02_fonteinfo?>
      </td>
      <td> 
  <?
  db_textarea('ci02_fonteinfo',2,80,$Ici02_fonteinfo,true,'text',$db_opcao,"","","",500)
  ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Tci02_procdetal?>">
        <?=@$Lci02_procdetal?>
      </td>
      <td> 
  <?
  db_textarea('ci02_procdetal',2,80,$Ici02_procdetal,true,'text',$db_opcao,"","","",500)
  ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Tci02_objeto?>">
        <?=@$Lci02_objeto?>
      </td>
      <td> 
  <?
  db_textarea('ci02_objeto',2,80,$Ici02_objeto,true,'text',$db_opcao,"","","",500)
  ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Tci02_possivachadneg?>">
        <?=@$Lci02_possivachadneg?>
      </td>
      <td> 
  <?
  db_textarea('ci02_possivachadneg',2,80,$Ici02_possivachadneg,true,'text',$db_opcao,"","","",500)
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
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onclick="js_imprime();" >
<input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" <?=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> >
<input name="ci02_codtipo" type="hidden" value="<?= $ci02_codtipo ?>" >
<table>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
<table>
  <tr>
    <td valign="top"  align="center">  
    <?
  $chavepri= array("ci02_codquestao"=>@$ci02_codquestao);
  $cliframe_alterar_excluir->chavepri=$chavepri;
  $cliframe_alterar_excluir->sql     = $clquestaoaudit->sql_query_file(null,"*","ci02_numquestao","ci02_codtipo = $ci02_codtipo and ci02_instit = ".db_getsession('DB_instit'));
  $cliframe_alterar_excluir->campos  ="ci02_numquestao,ci02_questao,ci02_inforeq,ci02_fonteinfo,ci02_procdetal,ci02_objeto,ci02_possivachadneg";
  $cliframe_alterar_excluir->legenda="QUESTÕES LANÇADAS";
  $cliframe_alterar_excluir->iframe_height ="320";
  $cliframe_alterar_excluir->iframe_width ="822";
  $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
    ?>
    </td>
  </tr>
</table>
</form>
<script>
function js_cancelar(){
	  var opcao = document.createElement("input");
	  opcao.setAttribute("type","hidden");
	  opcao.setAttribute("name","novo");
	  opcao.setAttribute("value","true");
	  document.form1.appendChild(opcao);
	  document.form1.submit();
	}  
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_questaoaudit','func_questaoaudit.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_questaoaudit.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_imprime() {

  var sUrl   = 'cin2_relquestaoaudit002.php';
  var sQuery = '?iCodTipo='+document.form1.ci02_codtipo.value;  

  jan = window.open(sUrl+sQuery,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');

  jan.moveTo(0,0);

}
</script>

<? if (isset($aProcesso)) { ?>
<script>
function js_submit() {
	
	var aProcessos  = <?= $aProcesso ?>;

	if (aProcessos.length > 0) {
		
		var iOpcao 		= <?= $db_opcao ?>;
		var sMensagem 	= '';
		var sOpcao 		= iOpcao == 2 ? 'alterar' : 'excluir';

		sMensagem += 'A questão que deseja '+sOpcao+' já está vinculada ao(s) seguinte(s) Processo(s) de Auditoria: ';

		sProcessos = '';

		for (var i = 0; i < aProcessos.length; i++) {
			
			sProcessos += aProcessos[i].ci03_numproc+'/'+aProcessos[i].ci03_anoproc;

			if (i < (aProcessos.length - 1)) {
				sProcessos += ', ';
			}
			
		}

		sMensagem += sProcessos;

		if (iOpcao == 2) {
			sMensagem += '. As modificações aqui realizadas também serão atualizadas no(s) processo(s), tem certeza que deseja prosseguir com a alteração?';
		} else if (iOpcao == 3) {
			sMensagem += '. A exclusão implicará também na remoção destes registros no(s) processo(s). Tem certeza que deseja excluir?';
		}

		if ( !confirm(sMensagem) ) {
			event.preventDefault();
		} 

	}

}
</script>
<? } ?>
