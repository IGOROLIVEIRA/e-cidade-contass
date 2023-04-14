<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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

//MODULO: patrim



?>
<form class="container" style="width: 600px;" name="form1" method="post" action="<?= $db_action ?>">
  <fieldset>
    <legend>Manutenção</legend>
    <table class="form-container">
      <tr>
        <td nowrap title="<?= @$Tt93_codtran ?>">
          Código:
        </td>
        <td>
          <?
          db_input('t93_codtran', 8, $It93_codtran, true, 'text', 1, "");
          db_input('t93_codtran', 40, $It93_codtran, true, 'text', 1, 'style="width: 303px;"');

          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt93_id_usuario ?>">
          Placa:
        </td>
        <td>
          <?
          db_input('t93_id_usuario', 8, $It93_id_usuario, true, 'text', 1, "");
          ?>
          <b> Vlr Aquisição: </b>
          <?
          db_input('t93_id_usuario', 8, $It93_id_usuario, true, 'text', 3, "");
          ?>
          <b> Vlr Atual: </b>
          <?
          db_input('t93_id_usuario', 8, $It93_id_usuario, true, 'text', 3, "");
          ?>
        </td>

      </tr>


      <tr>
        <td nowrap title="<?= @$Tt94_depart ?>">
          Tipo Manutenção:
        </td>
        <td>
          <?
          $tiposmanutencao  = array('Selecione', 'Acréscimo de valor', 'Decréscimo de valor', 'Adição de componente', 'Remoção de componente', 'Manunteção de Imóvel');

          db_select('preferencia_menu', $tiposmanutencao, true, 1, 'style="width: 80px;"');          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt93_data ?>">
          Data:
        </td>
        <td>
          <?
          if (!isset($t93_data)) {
            $t93_data_ano = date('Y', db_getsession("DB_datausu"));
            $t93_data_mes = date('m', db_getsession("DB_datausu"));
            $t93_data_dia = date('d', db_getsession("DB_datausu"));
          }
          db_inputdata('t93_data', @$t93_data_dia, @$t93_data_mes, @$t93_data_ano, true, 'text', $db_opcao, "");
          db_input('db_param', 3, 0, true, 'hidden', 3)
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt93_codtran ?>">
          Departamento:
        </td>
        <td>
          <?
          db_input('t93_codtran', 8, $It93_codtran, true, 'text', 3, "");
          db_input('t93_codtran', 40, $It93_codtran, true, 'text', 3, "");

          ?>
        </td>
      </tr>
      <tr>
        <td colspan="2" title="<?= @$Tt93_obs ?>">
          <fieldset class="separator">
            <legend>Descrição</legend>
            <?php db_textarea("t93_obs", 10, 50, $It93_obs, true, "text", $db_opcao, null, null, null, 500); ?>
          </fieldset>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?= @$Tt93_codtran ?>">
          Vlr Manut.:
        </td>
        <td>
          <?
          db_input('t93_codtran', 8, $It93_codtran, true, 'text', 1, "");

          ?>
        </td>
      </tr>
    </table>
  </fieldset>
  <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?> <?= (($db_opcao == 1 || $db_opcao == 2 || $db_opcao == 22) ? "onClick = 'return ver_depto_destino()'" : "") ?>>
  <input name="excluir" type="button" id="excluir" value="Excluir" onclick="js_pesquisa();">
  <input name="processar" type="button" id="processar" value="Processar" onclick="js_imprime();"> <br>
  <input style="margin-top: 10px;" name="inserircomponente" type="button" id="inserircomponente" value="Inserir Componente" onclick="js_imprime();">

</form>
<script>
  function ver_depto_destino() {
    if (document.form1.t94_depart.value == "" || document.form1.t94_depart.value == null) {

      alert(_M("patrimonial.patrimonio.db_frmbenstransf.infrome_departamento"));
      document.form1.t94_depart.style.backgroundColor = '#99A9AE';
      document.form1.t94_depart.focus();
      return false;
    } else {
      document.form1.t94_depart.style.backgroundColor = '';
      return true;
    }
  }

  function js_pesquisat94_depart(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo.iframe_benstransf', 'db_iframe_depart', 'func_db_depart.php?funcao_js=parent.js_mostradb_depart1|coddepto|descrdepto&chave_t93_depart=' + document.form1.t93_depart.value + '&db_param=<?= ($db_param) ?>', 'Pesquisa', true);
    } else {
      if (document.form1.t94_depart.value != '') {
        js_OpenJanelaIframe('top.corpo.iframe_benstransf', 'db_iframe_depart', 'func_db_depart.php?pesquisa_chave=' + document.form1.t94_depart.value + '&funcao_js=parent.js_mostradb_depart&chave_t93_depart=' + document.form1.t93_depart.value + '&db_param=<?= ($db_param) ?>', 'Pesquisa', false);
      } else {
        document.form1.t94_depart.value = '';
      }
    }
  }

  function js_mostradb_depart(chave, erro) {
    document.form1.depto_destino.value = chave;
    if (erro == true) {
      document.form1.t94_depart.focus();
      document.form1.t94_depart.value = '';
    }
  }

  function js_mostradb_depart1(chave1, chave2) {
    document.form1.t94_depart.value = chave1;
    document.form1.depto_destino.value = chave2;
    db_iframe_depart.hide();
  }

  function js_pesquisat93_depart(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo.iframe_benstransf', 'db_iframe_depart', 'func_db_depart.php?funcao_js=parent.js_mostradb_depart1t93_depart|coddepto|descrdepto&chave_t93_depart=' + document.form1.t93_depart.value + '&db_param=<?= ($db_param) ?>', 'Pesquisa', true);
    } else {
      if (document.form1.t93_depart.value != '') {
        js_OpenJanelaIframe('top.corpo.iframe_benstransf', 'db_iframe_depart', 'func_db_depart.php?pesquisa_chave=' + document.form1.t93_depart.value + '&funcao_js=parent.js_mostradb_departt93_depart&chave_t93_depart=' + document.form1.t93_depart.value + '&db_param=<?= ($db_param) ?>', 'Pesquisa', false);
      } else {
        document.form1.t93_depart.value = '';
      }
    }
  }

  function js_mostradb_departt93_depart(chave, erro) {
    document.form1.descrdepto.value = chave;
    if (erro == true) {
      document.form1.t93_depart.focus();
      document.form1.descrdepto.value = '';
    }
  }

  function js_mostradb_depart1t93_depart(chave1, chave2) {
    document.form1.t93_depart.value = chave1;
    document.form1.descrdepto.value = chave2;
    db_iframe_depart.hide();
  }

  function js_pesquisa() {
    js_OpenJanelaIframe('top.corpo.iframe_benstransf', 'db_iframe_benstransf', 'func_benstransf001.php?funcao_js=parent.js_preenchepesquisa|t93_codtran&t93=true&db_param=<?= ($db_param) ?>&transfdireta=<?= $transfdireta ?>', 'Pesquisa', true);
  }

  function js_preenchepesquisa(chave) {
    db_iframe_benstransf.hide();
    <?
    if ($db_opcao != 1) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave+'&db_param=$db_param'";
    }
    ?>
  }

  function js_imprime() {
    let param = "<?= $db_param ?>";

    if (param != 'ext' && param == 'int') {
      jan = window.open('pat2_relbenstransf002.php?t96_codtran=' + document.form1.t93_codtran.value + '&texto_info=true', '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
      jan.moveTo(0, 0);
    } else {
      jan = window.open('pat2_relbenstransf002.php?t96_codtran=' + document.form1.t93_codtran.value, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
      jan.moveTo(0, 0);
      forms / db_frmbenstransfcodigolote.php
    }
  }
</script>