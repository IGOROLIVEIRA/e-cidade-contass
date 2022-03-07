<?
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
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clbensimoveis->rotulo->label();
$clrotulo = new rotulocampo;

?>
<fieldset style="text-align: left;">
  <legend><b>Dados do Imóvel</b></legend>
  <form name="form1" method="post" action="">
    <center>
      <table border="0">
        <tr>
          <td nowrap title="<?= @$Tt54_codbem ?>">
            <?= @$Lt54_codbem ?>
          </td>
          <td>
            <?
            db_input('t54_codbem', 8, $It54_codbem, true, 'text', 3, "");
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tt54_idbql ?>">
            <?
            db_ancora(@$Lt54_idbql, "js_pesquisat54_idbql(true);", $db_opcao);
            ?>
          </td>
          <td>
            <?
            db_input('t54_idbql', 8, $It54_idbql, true, 'text', $db_opcao, " onchange='js_pesquisat54_idbql(false);'")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?= @$Tt54_obs ?>">
            <?= @$Lt54_obs ?>
          </td>
          <td>
            <?
            db_textarea('t54_obs', 3, 30, $It54_obs, true, 'text', $db_opcao, "")
            ?>
          </td>

        </tr>

        <tr>
          <td nowrap="nowrap" title="Valor do terreno:">
            <b>Valor do terreno:</b>
          </td>
          <td title="Valor do terreno:">
            <?php
            db_input('valorTerreno', 10, $It44_valorTerreno, true, 'text', $db_opcao, '');
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Valor área construída:">
            <b>Valor área construída:</b>
          </td>
          <td title="Valor área construída:">
            <?php
            db_input('valorArea', 10, $It44_valorAreaConstruida, true, 'text', $db_opcao, '');
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Valor Total:">
            <b>Valor Total:</b>
          </td>
          <td title="Valor Total:">
            <?php
            db_input('valorTotal', 10, $It44_valorTotal, true, 'text', 1, '');
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Limites e confrontações:">
            <b>Limites e confrontações:</b>
          </td>
          <td title="Limites e confrontações:">
            <?php
            db_textarea('limiteConfrontacao', 3, 30, $It54_limiteConfrontacao, true, 'text', $db_opcao, "")
            ?>
          </td>
        </tr>

        <tr>
          <td nowrap="nowrap" title="Aplicação:">
            <b>Aplicação:</b>
          </td>
          <td title="Aplicação:">
            <?php
            db_input('aplicacao', 32, $It44_aplicacao, true, 'text', 1, '');
            ?>
          </td>
        </tr>

</fieldset>
</table>




<fieldset style="text-align: center; border: none; border-top: 2px groove #FFF;">
  <legend class="bold">Origem</legend>
  <table width="500" border="0" align="center">


    <tr>
      <td nowrap="nowrap" title="Aplicação:">
        <b>Proprietário Anterior:</b>
      </td>
      <td title="Proprietário Anterior:">
        <?php
        db_input('proprietarioAnterior', 32, $It44_aplicacao, true, 'text', 1, '');
        ?>
      </td>
    </tr>

    <tr>
      <td nowrap="nowrap" title="CPF / CNPJ::">
        <b>CPF / CNPJ:</b>
      </td>
      <td title="CPF / CNPJ::">
        <?php
        db_input('cpfcnpj', 32, $It44_aplicacao, true, 'text', 1, '');
        ?>
      </td>
    </tr>

  </table>


</fieldset>

<fieldset style="text-align: center; border: none; border-top: 2px groove #FFF;">
  <legend class="bold">Transcrição no Cartório</legend>
  <table width="500" border="0" align="center">


    <tr>
      <td nowrap="nowrap" title="Cartório:">
        <b>Cartório:</b>
      </td>
      <td title="Proprietário Anterior:">
        <?php
        db_input('proprietarioAnterior', 32, $It44_aplicacao, true, 'text', 1, '');
        ?>
      </td>
    </tr>

    <tr>
      <td nowrap="nowrap" title="Comarca:">
        <b>Comarca:</b>
      </td>
      <td title="Comarca:">
        <?php
        db_input('cpfcnpj', 32, $It44_aplicacao, true, 'text', 1, '');
        ?>
      </td>
    </tr>

    <tr>
      <td nowrap="nowrap" title="Nº Registro:">
        <b>Nº Registro:</b>
      </td>
      <td title="Nº Registro:">
        <?php
        db_input('numeroRegistro', 32, $It44_aplicacao, true, 'text', 1, '');
        ?>
      </td>
    </tr>

    <tr>
      <td nowrap="nowrap" title="Livro:">
        <b>Livro:</b>
      </td>
      <td title="Livro:">
        <?php
        db_input('livro', 32, $It44_aplicacao, true, 'text', 1, '');
        ?>
      </td>
    </tr>

    <tr>
      <td nowrap="nowrap" title="folha:">
        <b>Folha:</b>
      </td>
      <td title="Folha:">
        <?php
        db_input('folha', 32, $It44_aplicacao, true, 'text', 1, '');
        ?>
      </td>
    </tr>

    <tr>
      <td nowrap="nowrap" title="data:">
        <b>Data:</b>
      </td>
      <td title="Data:">
        <?php
        db_input('data', 32, $It44_aplicacao, true, 'text', 1, '');
        ?>
      </td>
    </tr>


  </table>


</fieldset>



<table>
  <tr>
    <td colspan="2" align="center">
      <input name="<?= ($db_opcao == 1 ? 'incluir' : 'alterar') ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? 'Incluir' : 'Alterar') ?>" <?= ($db_botao == false || (isset($tipo_inclui) && $tipo_inclui == "true" || isset($global) && $global == "true") ? "disabled" : "") ?>>
      <input name="excluir" type="submit" id="db_opcao" value="Excluir" <?= ($db_opcao == 1 || $db_opcao == 22 || $db_opcao == 33 || (isset($tipo_inclui) && $tipo_inclui == "true" || isset($global) && $global == "true") ? "disabled" : "") ?>>
    </td>
  </tr>
</table>
</center>
</form>

<script>
  function js_pesquisat54_idbql(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('top.corpo.iframe_bensimoveis', 'db_iframe_lote', 'func_lote.php?funcao_js=parent.js_mostralote1|j34_idbql', 'Pesquisa', true);
    } else {
      if (document.form1.t54_idbql.value != '') {
        js_OpenJanelaIframe('top.corpo.iframe_bensimoveis', 'db_iframe_lote', 'func_lote.php?pesquisa_chave=' + document.form1.t54_idbql.value + '&funcao_js=parent.js_mostralote', 'Pesquisa', false);
      }
    }
  }

  function js_mostralote(chave, erro) {
    if (erro == true) {
      document.form1.t54_idbql.focus();
      document.form1.t54_idbql.value = '';
    }
  }

  function js_mostralote1(chave1) {
    document.form1.t54_idbql.value = chave1;
    db_iframe_lote.hide();
  }
  <?
  if (isset($incluir) || isset($excluir)) {
    $clbensimoveis->sql_record($clbensimoveis->sql_query_file($t54_codbem));
    if ($clbensimoveis->numrows > 0) {
      echo "top.corpo.iframe_bensmater.location.href='pat1_bensmater001.php?desabilita=true&t53_codbem=$t54_codbem';";
    } else {
      if (isset($excluir)) {
        echo "top.corpo.iframe_bensmater.location.href='pat1_bensmater001.php?t53_codbem=$t54_codbem';";
      }
    }
  }
  ?>
</script>