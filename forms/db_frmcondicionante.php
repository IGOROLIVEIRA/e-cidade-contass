<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBseller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

$clrotulo = new rotulocampo;
$clrotulo->label("am10_sequencial");
$clrotulo->label("am10_descricao");
$clrotulo->label("am10_padrao");
$clrotulo->label("am10_tipolicenca");

$lHabilitaLancador = "true";
$sJsBotao          = "js_validaFormulario";

switch ( $db_opcao ) {

  case 2:
    $sBotao = "Alterar";
  break;

  case 3:

    $sBotao            = "Excluir";
    $lHabilitaLancador = "false";
    $sJsBotao          = "js_excluirCondicionante";
  break;

  default:
    $sBotao = "Incluir";
  break;
}
?>
<form name="formCondicionantes" id="formCondicionantes" method="post" action="">

<?php db_input( "am10_sequencial", null, null, true, "hidden" ); ?>

<fieldset style="width: 510px;">
  <legend>Condicionantes</legend>

  <table class="form-container" witdh="100%">
    <tr>
      <td title="Tipo de Condicionante" width="25%"><label for="tipoCondicionante">Tipo:</label></td>
      <td>
      <?php

        $aOpcoes = array( ""  => "Selecione",
                          "A" => "Atividade",
                          "L" => "Licença"   );
        db_select( 'tipoCondicionante', $aOpcoes, true, $aOpcoes, "onchange='js_alteraTipoCondicionante(this.value);'" );
      ?>
      </td>
    </tr>
    <tr id="cellDescricao" class="hide">
      <td title="<?php echo $Tam10_descricao; ?>"><label for="am10_descricao"><?php echo $Lam10_descricao; ?></label></td>
      <td>
        <?php db_textarea('am10_descricao', 3, 10, null, true, 'text', $db_opcao ); ?>
      </td>
    </tr>
  </table>

  <table id="formCondicionanteAtividade" class="form-container hide" witdh="100%">
    <tr>
      <td colspan="2"><div id="ctnLancadorAtividade" style=''></div></td>
    </tr>
  </table>

  <table id="formCondicionanteLicenca" class="form-container hide" witdh="100%">
    <tr>
      <td title="<?php echo $Tam10_tipolicenca; ?>" width="25%"><label for="am10_tipolicenca"><?php echo $Lam10_tipolicenca; ?></label></td>
      <td>
      <?php

        $oTipoLicenca  = new TipoLicenca();
        $aTiposLicenca = $oTipoLicenca->getTiposDescricoes();

        $aOpcoes = array( '' => 'Selecione' );
        foreach ($aTiposLicenca as $aTipos) {
          $aOpcoes[$aTipos->am09_sequencial] = $aTipos->am09_descricao;
        }

        db_select( 'am10_tipolicenca', $aOpcoes, true, $db_opcao );
      ?>
      </td>
    </tr>
    <tr>
      <td title="<?php echo $Tam10_padrao; ?>"><label for="am10_padrao"><?php echo $Lam10_padrao; ?></label></td>
      <td>
      <?php
        $aOpcoes = array("false"=>"Não","true"=>"Sim");
        db_select( 'am10_padrao', $aOpcoes, true, $db_opcao );
      ?>
      </td>
    </tr>
  </table>

</fieldset>

<input name="<?php echo $sBotao; ?>" type="button" id="botao" value="<?php echo $sBotao; ?>" onclick="return <?php echo $sJsBotao; ?>();"/>
<?php
  if ($db_opcao != 1) {
?>
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="return js_pesquisaCondicionante();"/>
<?php
  }
?>
</form>
<style type="text/css">
.form-container textarea{ min-height: 39px !important; }
</style>
<script type="text/javascript">

var iOpcao            = "<?php echo $db_opcao; ?>";
var lHabilita         = <?php echo $lHabilitaLancador; ?>;
var sCaminhoMensagens = "tributario.meioambiente.db_frmcondicionante.";
var sRpcCondicionante = "amb1_condicionante.RPC.php";

 $('tipoCondicionante').addClassName('field-size4');
 $('am10_tipolicenca').addClassName('field-size4');
 $('am10_descricao').addClassName('field-size9');

function js_limparFormulario() {

  $('tipoCondicionante').value = "";
  $('am10_descricao').value    = "";
  $('am10_tipolicenca').value  = "";
  $('am10_padrao').value       = "";

  oLancadorAtividade.clearAll();
  $('cellDescricao').addClassName('hide');
  $('formCondicionanteLicenca').addClassName('hide');
  $('formCondicionanteAtividade').addClassName('hide');
}

function js_validaFormulario(){

  $('botao').disabled = 'disabled';

  if( empty( $F('tipoCondicionante') ) ){

    alert( _M( sCaminhoMensagens + 'tipocondicionante_obrigatorio' ) );
    $('botao').disabled = '';
    return false;
  }

  if ( empty( $F('am10_descricao') ) ) {

    alert( _M( sCaminhoMensagens + 'descricao_obrigatorio' ) );
    $('botao').disabled = '';
    return false;
  }

  /**
   * Verifica tipo de condicionante
   */
  if ( $F('tipoCondicionante') == 'L' ) {

    if ( empty( $F('am10_tipolicenca') ) ) {

      alert( _M( sCaminhoMensagens + 'tipolicenca_obrigatorio' ) );
      $('botao').disabled = '';
      return false;
    }

    var aParametros = {
      sExecucao    : 'inserirCondicionanteLicenca',
      iSequencial  : $F('am10_sequencial'),
      sDescricao   : encodeURIComponent(tagString($F('am10_descricao'))),
      sTipoLicenca : $F('am10_tipolicenca'),
      lPadrao      : $F('am10_padrao')
    };
  }

  if ( $F('tipoCondicionante') == 'A' ) {

    var aAtividades = oLancadorAtividade.getRegistros();
    if (aAtividades.length == 0) {

      alert( _M( sCaminhoMensagens + 'atividade_obrigatorio' ) );
      $('botao').disabled = '';
      return false;
    }

    var aParametros = {
      sExecucao   : 'inserirCondicionanteAtividade',
      iSequencial : $F('am10_sequencial'),
      sDescricao  : encodeURIComponent(tagString($F('am10_descricao'))),
      aAtividades : aAtividades
    };
  }

  new AjaxRequest(sRpcCondicionante, aParametros, function(oRetorno, erro) {

    alert(oRetorno.sMessage.urlDecode());

    if (erro) {
      return false;
    }
    if (aParametros.iSequencial == "") {
      js_limparFormulario();
    }

  }).setMessage(_M( sCaminhoMensagens + 'incluindo_condicionante' ) ).execute();

  $('botao').disabled = '';
  return true;
}

function js_excluirCondicionante(){

  if( !confirm( _M ( sCaminhoMensagens + 'confirma_exclusao_condicionante' ) ) ) {
    return false;
  }

  var aParametros = {
      sExecucao   : 'excluirCondicionante',
      iSequencial : $F('am10_sequencial')
    };

  new AjaxRequest(sRpcCondicionante, aParametros, function(oRetorno, erro) {

    alert(oRetorno.sMessage.urlDecode());

    if (erro) {
      return false;
    }

    js_limparFormulario();
    js_pesquisaCondicionante();

  }).setMessage(_M( sCaminhoMensagens + 'excluindo_condicionante' ) ).execute();

  return true;
}

function js_alteraTipoCondicionante ( sTipoCondicionante ){

  $('am10_descricao').value    = "";
  $('am10_tipolicenca').value  = "";
  $('am10_padrao').value       = "";

  oLancadorAtividade.clearAll();
  $('cellDescricao').addClassName('hide');
  $('formCondicionanteLicenca').addClassName('hide');
  $('formCondicionanteAtividade').addClassName('hide');

  switch ( sTipoCondicionante ) {

    case 'A':

      $('cellDescricao').removeClassName('hide');
      $('formCondicionanteAtividade').removeClassName('hide');
      oLancadorAtividade.show($("ctnLancadorAtividade"));
    break;

    case 'L':

      $('cellDescricao').removeClassName('hide');
      $('formCondicionanteLicenca').removeClassName('hide');
    break;

    default:
      $('cellDescricao').addClassName('hide');
    break;
  }
}

oLancadorAtividade = new DBLancador("oLancadorAtividade");
oLancadorAtividade.setNomeInstancia("oLancadorAtividade");
oLancadorAtividade.setLabelAncora("Atividade:");
oLancadorAtividade.setTextoFieldset("Atividades");
oLancadorAtividade.setParametrosPesquisa("func_atividadeimpacto.php", ['am03_sequencial', 'am03_descricao']);
oLancadorAtividade.setGridHeight("200");
oLancadorAtividade.setTipoValidacao('3');

/**
 * Quando for exclusão, desabilita grid para lançar atividades
 */
oLancadorAtividade.setHabilitado( lHabilita );

oLancadorAtividade.show($("ctnLancadorAtividade"));

/**
 * Verifica se é alteração
 */
if( iOpcao != 1 ){

  /**
   * Tipo de Condicionantte
   */
  var sOpcaoTipo = '<?php echo $sOpcaoTipo; ?>';
  var oSelect    = $('tipoCondicionante');
  for(var iIndice = 0; iIndice < oSelect.length; iIndice++) {

    if( oSelect[iIndice].value == sOpcaoTipo ){
      oSelect[iIndice].selected = 'selected';
    }else{
      oSelect[iIndice].removeChild;
    }
    js_alteraTipoCondicionante( sOpcaoTipo );
  }

  oSelect.disabled = true; // Bloqueamos o campo de tipo quando é alteração

  /**
   * Descrição
   */
   <?php
    if (!empty($am10_descricao)) {
   ?>
      var sDescricao = '<?php echo addslashes($am10_descricao); ?>';
      $('am10_descricao').value = sDescricao.urlDecode();
   <?php
    }
   ?>

  /**
   * Tipo de Condicionante de Licença
   */
  if( sOpcaoTipo == 'L' ){

    /**
     * Tipo de Licença
     */
    var iOpcaoLicenca = <?php echo $iOpcaoLicenca; ?>;
    var oSelect       = $('am10_tipolicenca');
    for(var iIndice = 0; iIndice < oSelect.length; iIndice++) {

      if( iIndice == iOpcaoLicenca ){
        oSelect[iOpcaoLicenca].selected = 'selected';
      }
    }

    /**
     * Padrão
     */
    var sOpcaoPadrao  = '<?php echo $sOpcaoPadrao; ?>';
    var oSelect       = $('am10_padrao');
    for(var iIndice = 0; iIndice < oSelect.length; iIndice++) {

      if( oSelect[iIndice].value == sOpcaoPadrao ){
        oSelect[iIndice].selected = 'selected';
      }
    }

  }else{

    /**
     * Busca Atividades Vinculadas a Condicionante
     */
    var aParametros = {
        sExecucao            : 'pesquisarCondicionanteAtividade',
        iCodigoCondicionante : $F('am10_sequencial')
        };

    new AjaxRequest( sRpcCondicionante, aParametros, function(oRetorno, erro ) {

      if (erro) {
        return false;
      }

      aAtividadesLancadas = new Array();

      /**
       * Percorre o array retornado pelo RPC das Atividades e adiciona a grid do DBLancador
       */
      for( var iIndice in oRetorno.aAtividadesLancadas ) {
        aAtividadesLancadas.push([ iIndice, oRetorno.aAtividadesLancadas[iIndice]]);
      }
      oLancadorAtividade.carregarRegistros(aAtividadesLancadas);

    }).setMessage(_M( sCaminhoMensagens + 'pesquisando_atividades' ) ).execute();

  }

}

function js_pesquisaCondicionante() {
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_condicionante','func_condicionante.php?funcao_js=parent.js_preenchepesquisaCondicionante|am10_sequencial','Pesquisa',true);
}

function js_preenchepesquisaCondicionante(chave) {

  db_iframe_condicionante.hide();
  <?php

    if ( $db_opcao == 2 ) {
      echo " location.href = 'amb1_condicionante002.php?chavepesquisa='+chave";
    }elseif ( $db_opcao == 3 ) {
      echo " location.href = 'amb1_condicionante003.php?chavepesquisa='+chave";
    }
  ?>
}
</script>
