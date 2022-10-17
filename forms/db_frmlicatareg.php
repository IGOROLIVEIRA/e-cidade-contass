<?
//MODULO: licitacao

use ECidade\V3\Extension\Document;
db_postmemory($HTTP_POST_VARS);
$cllicatareg->rotulo->label();
$cllicatareg = new cl_licatareg;
?>
<form name="form1" method="post" action="">
<center>
<table align=center style="margin-top:25px;">

  <tr>
    <td>
      <fieldset style="margin-top: 30px;">
        <legend>Ata de Registro de Preço</legend>
        <table border="0">
        <tr>
          <td nowrap title="<?=@$Tl221_sequencial?>">
          <input name="oid" type="hidden" value="<?=@$oid?>">
            <?=@$Ll221_sequencial?>
          </td>
          <td> 
          <?
            db_input('l221_sequencial',10,$Il221_sequencial,true,'text',3,"")
          ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tl221_licitacao?>">
          <?php 
            if(isset($l221_sequencial) && $l221_sequencial != "" && $l221_sequencial != null){
              echo "<b>Licitação:</b>";
            }else{
              db_ancora("Licitação: ", "js_pesquisarLicitacao(true);", $iOpcaoLicitacao); 
            }  
              ?>
          </td>
          <td> 
              <?php
              if(isset($l221_sequencial) && $l221_sequencial != "" && $l221_sequencial != null){
                db_input('l221_licitacao', 10, $Il221_licitacao, true, 'text', 3, " onChange='js_pesquisarLicitacao(false);'");
              }else{
                db_input('l221_licitacao', 10, $Il221_licitacao, true, 'text', $iOpcaoLicitacao," onChange='js_pesquisarLicitacao(false);'");
              }
              ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tl221_numata?>">
            <?echo "<b>Número da Ata:</b>" ?>
          </td>
          <td> 
          <?
            db_input('l221_numata',10,$Il221_numata,true,'text',$db_opcao,"")
          ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tl221_exercicio?>">
            <?echo "<b>Exercício da Ata:</b>" ?>
          </td>
          <td> 
          <?
            db_input('l221_exercicio',4,$Il221_exercicio,true,'text',3,"")
          ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tl221_fornecedor?>">
            <?=@$Ll221_fornecedor?>
          </td>
          <td> 
          <?
          
            if(isset($l221_fornecedor)){
              
                                        
                                        $result_forn = $cllicatareg->sql_record("select z01_numcgm,z01_nome from cgm JOIN habilitacaoforn ON z01_numcgm=l206_fornecedor where l206_licitacao = ".$l221_licitacao."and l206_fornecedor =".$l221_fornecedor);
                                        $oForn = db_utils::fieldsMemory($result_forn, $iIndiceTipo);
                                        $tipo[$oForn->z01_numcgm] = $oForn->z01_nome;
                                        db_select("l221_fornecedor", $tipo, true, $db_opcao, "");


            }else{
                                        $tipo = array();
                                        $tipo[0] = "Selecione";
                                        $result_forn = $cllicatareg->sql_record("select z01_numcgm,z01_nome from cgm JOIN habilitacaoforn ON z01_numcgm=l206_fornecedor where l206_licitacao = ".$l221_licitacao);
                                        

                                        for($iIndiceTipo=0;$iIndiceTipo < $cllicatareg->numrows;$iIndiceTipo++){

                                          $oForn = db_utils::fieldsMemory($result_forn, $iIndiceTipo);

                                          $tipo[$oForn->z01_numcgm] = $oForn->z01_nome;
                                        }

                                        
                                            db_select("l221_fornecedor", $tipo, true, $db_opcao, "style='width: 610px;'");
                                            
                                      }                                
                                        
          ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tl221_dataini?>">
            <? echo "<b>Vigência:</b>" ?>
          </td>
          <td> 
          <?
            db_inputdata('l221_dataini',@$l221_dataini_dia,@$l221_dataini_mes,@$l221_dataini_ano,true,'text',$db_opcao,"");echo "<b>á</b>";
            db_inputdata('l221_datafinal',@$l221_datafinal_dia,@$l221_datafinal_mes,@$l221_datafinal_ano,true,'text',$db_opcao,"");
          ?>
          </td>
        </tr>

        <tr>
          <td nowrap title="<?=@$Tl221_datapublica?>">
            <?echo "<b>Data de Publicação:</b>" ?>
          </td>
          <td> 
          <?
            db_inputdata('l221_datapublica',@$l221_datapublica_dia,@$l221_datapublica_mes,@$l221_datapublica_ano,true,'text',$db_opcao,"")
          ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tl221_veiculopublica?>">
            <?echo "<b>Veículo de Publicação:</b>" ?>
          </td>
          <td> 
          <?
            db_input('l221_veiculopublica',104,$Il221_veiculopublica,true,'text',$db_opcao,"")
          ?>
          </td>
        </tr>
        </table>
          <fieldset>
            <legend>Objeto</legend>
            <table>
            <tr>
              
              <td> 
              <?
                
                db_textarea('l20_objeto', 0, 125, $Il20_objeto, true, 'text', $db_opcao, "onkeyup='limitaTextareaobj(this);' onkeypress='doNothing()';");
                
              ?>
              </td>
            </tr>
            </table>
          </fieldset>
        
      </fieldset>

      </td>
    </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
document.form1.l221_exercicio.value = <?=db_getsession('DB_anousu')?>;
function js_pesquisa(){
  js_OpenJanelaIframe('','db_iframe_licatareg','func_licatareg.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_licatareg.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";

  }
  ?>
}

function js_pesquisarLicitacao(lMostra) {
  
  var sArquivo = 'func_liclicita.php?situacao=10&tiponatu=2&funcao_js=parent.';

  if (lMostra) {
    sArquivo += 'js_mostraLicitacao|l20_codigo|l20_objeto';
  } else {

    var iNumeroLicitacao = $('l221_licitacao').value;
    
    if (empty(iNumeroLicitacao)) {
      return false;
    }

    sArquivo += 'js_mostraLicitacaoHidden&pesquisa_chave=' + iNumeroLicitacao + '&sCampoRetorno=l20_codigo';
  }

  js_OpenJanelaIframe('', 'db_iframe_proc', sArquivo, 'Pesquisa de Licitação', lMostra);
}

function js_mostraLicitacao(iCodigoLicitacao, descricao) {
 
  location.href = 'lic1_licatareg001.php?l221_licitacao=' + iCodigoLicitacao + '&l20_objeto=' + descricao;

/*document.form1.l20_codigo.value = iCodigoLicitacao;
document.form1.l20_objeto.value = descricao;
document.form1.l221_exercicio.value = <?=db_getsession('DB_anousu')?>*/

db_iframe_proc.hide();


}

function js_mostraLicitacaoHidden(descricao, lErro) {

/**
 * Nao encontrou Licitacao
 */

  $('l20_codigo').value = '';

}
</script>
