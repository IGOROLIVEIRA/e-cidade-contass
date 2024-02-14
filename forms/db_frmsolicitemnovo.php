<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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


//MODULO: compras
$sArquivoRedireciona = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
$result_tipo = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "pc30_seltipo,pc30_tipoemiss"));
if ($clpcparam->numrows > 0) {
  db_fieldsmemory($result_tipo, 0);
}

$iOpcaoTipoSolicitacao = $db_opcao;

if ((isset($opcao) && $opcao == "alterar")) {
  echo "<script>var operador = 1;</script>";
} else {
  echo "<script>var operador = 0;</script>";
}


?>
<style type="text/css">
    input::placeholder {
    color: black;
    }

    .hoverBox {
        background-color: #6699CC;
        max-width: 100%;
        max-height: 150px;
        position: absolute;
        bottom: 50%;
        text-align: start;
        padding: 15px;
        display: content;
    }
    .hoverBoxDisabled {
        display: none;
    }
</style>
<div id="hoverBox" class="hoverBox hoverBoxDisabled">
  <p><strong>Descricao Material: </strong></p>
  <p id="hoverText"></p>
</div>
<div>
  <form style="margin-top: 20px;" name="form1" method="post" action="" enctype="multipart/form-data">

    <fieldset style="width: 1000px;">
      <legend><strong>Importar Itens</strong></legend>
      <table align="left" style="margin-left:44px;">
        <tr>
          <td>
            <b> Importar Itens: </b>
            <select id="importaritens" name="importaritens" onchange="importar()" ali>
              <option value="1" selected>Não</option>
              <option value="2">Sim</option>
            </select>
          </td>
          <td id="anexarimportacao" style="display: none;">
            <b style="margin-left:100px;"> Importar xls: </b>
            <?php
            db_input("uploadfile", 30, 0, true, "file", 1);
            db_input("namefile", 31, 0, true, "hidden", 1);

            ?>
          </td>
        </tr>
      </table>
      <table id="inputimportacao" style="display: none;margin-top: 30px;margin-left: -200px;" align="left">
        <tr>
          <td>
            <input name='exportar' type='button' id="exportar" value="Gerar Planilha" onclick="gerar()" />
            <input name='processar' type='submit' id="Processar" value="Processar" onClick="return validaData()" />
          </td>
        </tr>
      </table>

    </fieldset>


    <fieldset style="width: 1000px;">
      <legend><strong>Adicionar Item</strong></legend>
      <table border="0">
      <tr style="display: none;">
        <td>
            <?php db_input("pc01_complmater", 10, "", false, "", 3); ?>
        </td>
      </tr>
        <tr>
          <td nowrap title="<?= @$Tpc16_codmater ?>">
            <?
            db_ancora("Código do material: ", "js_pesquisapc16_codmater(true);", $tranca);
            ?>
          </td>

          <td>
            <?


            // $tranca --> variável q torna o campo pc16_codmater readOnly
            $tranca = 1;
            // $tquant --> variável q passa para o iframe se valor ou quant é readOnly
            $tquant = false;

            if (isset($pc11_codigo) && trim($pc11_codigo) != "") {
              $result_dotacaoitem = $clpcdotac->sql_record($clpcdotac->sql_query_file(@$pc11_codigo, db_getsession("DB_anousu"), null, "pc13_coddot"));
              if ($clpcdotac->numrows > 0) {
                $tranca = 3;
              }
            }
            if ($iRegistroPreco != ""  && (isset($pc16_codmater) && trim($pc16_codmater) != "")) {

              $oRegistroPreco              = new compilacaoRegistroPreco($iRegistroPreco);
              $iFormaControleRegistroPreco = $oRegistroPreco->getFormaDeControle();

              if ($pc11_codigo != "") {

                $oDaoSolicitemVinculo = new cl_solicitemvinculo;
                $sSqlVerificaVinculo  = $oDaoSolicitemVinculo->sql_query_file(
                  null,
                  "*",
                  null,
                  "pc55_solicitemfilho={$pc11_codigo}"
                );
                $rsVerificaVinculo    = $oDaoSolicitemVinculo->sql_record($sSqlVerificaVinculo);
                if ($oDaoSolicitemVinculo->numrows > 0) {
                  $codigoitemregistropreco = db_utils::fieldsMemory($rsVerificaVinculo, 0)->pc55_solicitempai;
                }
              }
              if (!isset($codigoitemregistropreco)) {
                $codigoitemregistropreco = $registroprecoorigem;
              }
              $oFornecedor    = $oRegistroPreco->getFornecedorItem($pc16_codmater, $codigoitemregistropreco);
              $pc11_vlrun     = ($iFormaControleRegistroPreco == aberturaRegistroPreco::CONTROLA_QUANTIDADE ? $oFornecedor->valorunitario : '');
              $pc17_unid      = $oFornecedor->unidade;
              $pc17_quant     = $oFornecedor->quantidadeunidade;

              /**
               * devemos criar um input com o codigo do item original da Solicitacao:
               *
               */
              $registroprecoorigem = @$codigoitemregistropreco;
              db_input("registroprecoorigem", 10, $Ipc11_codigo, true, "hidden");
              if ($pc11_codigo == "") {

                $oItemCompilacao = new itemCompilacao($registroprecoorigem);
                $pc11_resum      = urldecode($oItemCompilacao->getResumo());
                $pc11_just       = urldecode($oItemCompilacao->getJustificativa());
                $pc11_prazo      = urldecode($oItemCompilacao->getPrazos());
                $pc11_pgto       = urldecode($oItemCompilacao->getPagamento());
              }
            } else {

              if ($pc30_valoraproximadoautomatico == "t") {
                if ($pc11_vlrun == "" && !empty($pc16_codmater)) {
                  $pc11_vlrun = itemSolicitacao::calculaMediaPrecoOrcamentos(itemSolicitacao::getUltimosOrcamentos($pc16_codmater, array($pc17_unid)));
                }
              }
            }
            if (isset($pc16_codmater) && trim($pc16_codmater) != "" && isset($verificado) && (!isset($sqlerro) || (isset($sqlerro) && $sqlerro != true))) {
              if ((isset($alterar) || isset($excluir) || isset($incluir) || (isset($opcao) && ($opcao == "alterar" || $opcao == "excluir"))) && isset($sqlerro) && $sqlerro == false) {
                $tranca = 3;
              }
              if ((isset($alterar) || isset($incluir) || (isset($opcao) && ($opcao == "alterar" || $opcao == "excluir"))) && isset($sqlerro) && $sqlerro == false) {
                if ($operadorRegistroPreco == 1 || $trancaIte == 1) {
                  $tranca = 3;
                } else {
                  $tranca = 1;
                }
              }
              $result_servico = $clpcmater->sql_record($clpcmater->sql_query($pc16_codmater, "pc01_servico, pc01_descrmater", "pc01_codmater"));
              if ($clpcmater->numrows > 0) {
                db_fieldsmemory($result_servico, 0);
                if ($pc01_servico == "t") {
                  $tquant = true;
                }
              }
            }
            if (!isset($pc01_servico) || (isset($pc01_servico) && $pc01_servico == "")) {
              $pc01_servico = 'f';
            }

            db_input('pc16_codmater', 8, $Ipc16_codmater, true, 'text', $db_opcao, " onchange='js_pesquisapc16_codmater(false);'");
            db_input("iCodigoRegistro", 8, "iCodigoRegistro", true, 'hidden', $db_opcao);
            db_input("pc01_veiculo", 8, "", true, 'hidden', $db_opcao);
            db_input("codigoitemregistropreco", 8, "", true, 'hidden', $db_opcao);
            db_input("pcmateranterior", 8, $pcmateranterior, true, 'hidden', $db_opcao);
            ?>
          </td>

          <td>
            <?
            db_input('pc01_descrmater', 45, $Ipc01_descrmater, true, 'text', $db_opcao, "style='width: 100%;'onchange='js_pesquisa_desdobramento();' onmouseover = 'js_inlineMouseHover(this.value);'");
            ?>
          </td>

          <td nowrap>
            <b> Quantidade: </b>
          </td>
          <td nowrap>

            <?
            db_input('pc11_quant', 8, 4, true, 'text', 1, 'onkeypress="mask_4casasdecimais(event)"');
            ?>

            <?
            $hidval = "text";
            if ($pc30_digval == 't') {
            } else {
              $hidval = "hidden";
              $pc11_vlrun_ant = $pc11_vlrun;
              $pc11_vlrun = 0;
            }
            ?>
            <?
            if (isset($pc11_vlrun) && $pc11_vlrun != "") {
              $pc11_vlrun = str_replace(",", ".", $pc11_vlrun);
              if (strpos($pc11_vlrun, ".") == "") {
                $pc11_vlrun .= ".";
                $tam = strlen($pc11_vlrun) + 2;
                $pc11_vlrun = str_pad($pc11_vlrun, $tam, '0', STR_PAD_RIGHT);
              }
              if ($hidval != "hidden") {
                $pc11_vlrun_ant = $pc11_vlrun;
              }
            }
            $db_opcaovunit = $iRegistroPreco == "" ? $db_opcao : 3;

            if (($pc11_vlrun == 0 || $pc11_vlrun == "") && $hidval != "hidden") {
              $pc11_vlrun = 1;
            }
            db_input('pc11_vlrun', 8, $Ipc11_vlrun, true, "hidden", 3);
            if ($pc30_digval == 't') {
              echo "</td>";
            }

            // Alteração feita para processo de compra e licitacao
            if (isset($param) && trim($param) != "") {
              db_input("param", 10, "", false, "hidden", 3);
              db_input("codproc", 10, "", false, "hidden", 3);
              db_input("codliclicita", 10, "", false, "hidden", 3);
            }
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            ?>

          </td>

          <td id="titleUnidade" nowrap>
            <b> Unidade: </b>
          </td>

          <td nowrap id="tdunidade">


            <?
            $unidade = array();


            $result = db_query("select * from matunid order by m61_descr");
            if (pg_numrows($result) != 0) {
              $numrows = pg_numrows($result);
              $unidade[0] = "";

              for ($i = 0; $i < $numrows; $i++) {
                $matunid = db_utils::fieldsMemory($result, $i);

                $unidade[$matunid->m61_codmatunid] = $matunid->m61_descr;
              }
            }

            if (isset($verificado)) {
              if (isset($pc11_codigo) && (!isset($pc17_unid) || (isset($pc17_unid) && $pc17_unid == ""))) {
                $result_solicitemunid = $clsolicitemunid->sql_record($clsolicitemunid->sql_query_file($pc11_codigo));
                if ($clsolicitemunid->numrows > 0) {
                  db_fieldsmemory($result_solicitemunid, 0);
                } else {
                  unset($pc17_unid);
                }
              }
              if (!isset($pc17_unid) || (isset($pc17_unid) && $pc17_unid == "")) {
                $result_uniddefault = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "pc30_unid as pc17_unid,pc30_digval"));
                if ($clpcparam->numrows > 0) {
                  db_fieldsmemory($result_uniddefault, 0);
                }
              }
            }

            if (!isset($pc17_quant)) {
              $pc17_quant = 1;
            }
            $db_opcaounidade = $db_opcao;
            if ($iRegistroPreco != "") {
              $db_opcaounidade = 33;
            }

            db_select(
              "pc17_unid",
              $unidade,
              true,
              $db_opcao,
              ""
            );

            ?>

          </td>

          <td><strong id='ctnServicoQuantidade' style="display:none;">Controlado por Quantidades: </strong></td>
          <td>
            <?php

            if (substr($o56_elemento, 0, 7) == '3449052') {
              $aOpcoes = array("true" => "SIM");
            } else {
              $aOpcoes = array("false" => "NÃO", "true" => "SIM");
            }

            db_select('pc11_servicoquantidade', $aOpcoes, true, $db_opcao, "style='display:none;' onchange='js_changeControladoPorQtd(this.value);'");


            if ($lMostraItensPacto) {


              db_input(
                'o103_pactovalor',
                8,
                $Io103_pactovalor,
                true,
                'text',
                $tranca,
                " onchange='js_pesquisao103_pactovalor(false);'"
              );

              db_input('o109_descricao', 40, $Io109_descricao, true, 'text', 3, '');
            }

            ?>
          </td>

        </tr>

        <tr>

          <div id="subEl">
            <td colspan="1" nowrap title="<?= @$To56_descr ?>">
              <strong>Desdobramento:</strong>
            <td colspan="2">
              <select style="width: 100%;" id="eleSub" name="eleSub">
                <option value="0"> </option>;
              </select>
            </td>
            </td>

          </div>

          <td style="display: none;" id="titleUnidade2" nowrap>
            <b> Unidade: </b>
          </td>

          <td id="tdunidade2" nowrap style='display: none;'>


            <?
            $unidade = array();


            $result = db_query("select * from matunid order by m61_descr");
            if (pg_numrows($result) != 0) {
              $numrows = pg_numrows($result);
              $unidade[0] = "";

              for ($i = 0; $i < $numrows; $i++) {
                $matunid = db_utils::fieldsMemory($result, $i);

                $unidade[$matunid->m61_codmatunid] = $matunid->m61_descr;
              }
            }

            db_select(
              "pc17_unid2",
              $unidade,
              true,
              $db_opcao,
              ""
            );

            ?>

          </td>

          <td>
            <b style="" id="titleOrdem"> Ordem: </b>
          </td>
          <td>
            <?
            db_input('pc11_codigo', 8, $pc11_codigo, true, 'hidden', $db_opcao, 'onkeypress="return event.charCode >= 48 && event.charCode <= 57" style=""');
            ?>
            <?
            db_input('pc11_seq', 8, 1, true, 'text', 1, 'onkeypress="return event.charCode >= 48 && event.charCode <= 57" style=""');
            ?>
          </td>

        </tr>

      </table>
      <input style="float:center; margin-top:10px;" name="incluir" type="submit" id="db_opcao" value="Adicionar Item" onclick="return js_adicionarItem()">
      <input style="float:center; margin-top:10px; display:none;" name="novo" type="button" id="novo" value="Novo" onclick="return js_novoitem()">

    </fieldset>

    <table>
      <tr>
        <td>
          <fieldset>
            <legend>Itens</legend>
            <div id='ctnGridItens' style="width: 1000px"></div>
          </fieldset>
        </td>
      </tr>
    </table>
    <input style="float:center; margin-top:10px;display:<? if ($pc30_permsemdotac == "f") {
                                                          echo "none";
                                                        } ?>" name="incluir" type="button" value="Liberar Solicitação" onclick="js_liberarSolicitacao()">


    <br>
    <?
    $pc11_liberado = 'f';
    if (!isset($pc11_resum) || (isset($pc11_resum) && $pc11_resum == "")) {
      $digitouresumo = "false";
    }
    @$pc11_pgto = stripslashes($pc11_pgto);
    @$pc11_just = stripslashes($pc11_just);
    @$pc11_resum = stripslashes($pc11_resum);
    @$pc11_prazo = stripslashes($pc11_prazo);
    $pc11_resum = addslashes($pc11_resum);
    db_input('pc11_liberado', 1, $Ipc11_liberado, true, 'hidden', 3);
    db_input('pc11_pgto', 40, $Ipc11_pgto, true, 'hidden', 3);
    db_textarea('pc11_resum', 10, 40, $Ipc11_resum, true, 'text', 3, "style='display:none'");
    db_textarea('pc11_just', 10, 40, $Ipc11_just, true, 'hidden', 3, "style='display:none'");
    db_textarea('pc11_prazo', 10, 40, $Ipc11_prazo, true, 'hidden', 3, "style='display:none'");
    db_input('digitouresumo', 5, 0, true, 'hidden', 3);

    db_input('pc11_vlrun_ant', 40, $Ipc11_vlrun, true, 'hidden', 3);
    db_input('pc11_quant_ant', 40, $Ipc11_vlrun, true, 'hidden', 3);
    db_input('pc16_codmater_ant', 40, $Ipc16_codmater, true, 'hidden', 3);
    db_input('pc01_servico', 40, $Ipc01_servico, true, 'hidden', 3);

    db_input('db_opcao', 5, 0, true, 'hidden', 3);
    db_input('db_botao', 5, 0, true, 'hidden', 3);

    ?>

  </form>
</div>


<script>

  function importar() {
    if (document.getElementById('importaritens').value == "2") {
      document.getElementById('inputimportacao').style.display = '';
      document.getElementById('anexarimportacao').style.display = '';
    } else {
      document.getElementById('inputimportacao').style.display = 'none';
      document.getElementById('anexarimportacao').style.display = 'none';
    }
  }

  function gerar() {
    window.location.href = "com1_xlsitenssolicitacaoplanilha.php?numero=" + CurrentWindow.corpo.iframe_solicita.document.form1.pc10_numero.value;
  }

  function mask_4casasdecimais(e) {
    var valor = e.target.value.replace(/[^0-9\.]/g, "");

    if (valor.lastIndexOf('.') != -1) {
      if (valor.substring(valor.indexOf(".") + 1).length == 4) {
        e.preventDefault();
        return false;

      }
    }

  }

  function js_alterar(indice) {

    if (document.getElementById('pc17_unid2').style.display == '') {
      document.getElementById('pc17_unid').value = document.getElementById('pc17_unid2').value;
      if ($F('pc17_unid2') == "0") {
        alert('Informe a Unidade!');
        return false;
      }
    } else {
      if ($F('pc17_unid') == "0" && document.getElementById('pc11_servicoquantidade').style.display != '') {

        alert('Informe a unidade!');
        return false;

      }

    }

    if ($F('eleSub') == "0") {

      alert('Informe o Desdobramento!');
      return false;

    }

    if ($F('pc16_codmater') == "") {

      alert('Informe o material!');
      return false;

    }

    if ($F('pc11_seq') == "") {

      alert('Informe a ordem!');
      return false;

    }

    if ($F('pc11_quant') == "") {

      alert('Informe a quantidade!');
      return false;

    }

    if (document.getElementById('pc11_servicoquantidade').value == 'false' && document.getElementById('pc11_servicoquantidade').style.display != 'none') {
      document.getElementById('pc17_unid').value = 999999;
    }


    var sizeItens = oGridItens.aRows.length;
    for (var i = 0; i < sizeItens; i++) {
      if (indice != i) {
        if (document.getElementById('pc11_seq').value == document.getElementsByName("ordem[]")[i].value && document.getElementById('pc16_codmater').value != document.getElementsByName("codmaterial[]")[i].value) {
          alert('A ordem ' + document.getElementById('pc11_seq').value + ' já foi utilizada nesta solicitação.');
          return false;
        }
        if (document.getElementById('pc16_codmater').value == document.getElementsByName("codmaterial[]")[i].value) {
          alert('AVISO Item ja cadastrado nesta solicitação..');
          return false;
        }
      }
    }
  }

  function js_alterarLinha(indice) {


    document.getElementById('novo').style.display = "";
    servicoquantidade = document.getElementsByName("servicoquantidade[]")[indice].value;
    servico = document.getElementsByName("servico[]")[indice].value;


    document.getElementById('db_opcao').value = "Alterar";
    document.getElementById("db_opcao").setAttribute('name', 'alterar');
    document.getElementById("db_opcao").setAttribute('type', 'submit');
    document.getElementById("db_opcao").setAttribute('onclick', 'return js_alterar(' + indice + ')');



    document.getElementById('pc16_codmater').value = document.getElementsByName("codmaterial[]")[indice].value;
    document.getElementById('pc01_descrmater').value = document.getElementsByName("descmaterial[]")[indice].value;
    document.getElementById('pc11_seq').value = document.getElementsByName("ordem[]")[indice].value;
    document.getElementById('pc11_quant').value = document.getElementsByName("quantidade[]")[indice].value;
    document.getElementById('pc17_unid').value = document.getElementsByName("codigo_unidade[]")[indice].value;
    document.getElementById('pc11_servicoquantidade').value = document.getElementsByName("servicoquantidade[]")[indice].value;
    document.getElementById('pc11_codigo').value = document.getElementsByName("codigo[]")[indice].value;
    //$('eleSub').options[0] = new Option(document.getElementsByName("descrelemento[]")[indice].value.urlDecode(), document.getElementsByName("codele[]")[indice].value);


    if (servico == 'Sim') {
      document.getElementById('titleUnidade').style.display = "none";
      document.getElementById('pc17_unid').style.display = "none";
      document.getElementById('ctnServicoQuantidade').style.display = "";
      document.getElementById('pc11_servicoquantidade').style.display = "";
      document.getElementById('pc11_quant').readOnly = true;
      document.getElementById('pc11_quant').style.background = "#EEE";
      document.getElementById('tdunidade').style.display = "none";

      if (servicoquantidade == 't') {
        document.getElementById('pc17_unid2').style.display = "";
        document.getElementById('titleUnidade2').style.display = "";
        document.getElementById('pc11_seq').style.marginLeft = "0px";
        document.getElementById('titleOrdem').style.marginLeft = "";
        document.getElementById('ctnServicoQuantidade').style.marginLeft = "-20%";
        document.getElementById('pc11_servicoquantidade').style.marginLeft = "";
        document.getElementById('pc11_servicoquantidade').style.width = "100%";
        document.getElementById('pc11_quant').readOnly = false;
        document.getElementById('pc11_quant').style.background = "";
        document.getElementById("pc11_servicoquantidade").options[1].selected = true;
        document.getElementById('tdunidade2').style.display = "";


      } else {
        document.getElementById("pc11_servicoquantidade").value = false;
        document.getElementById('tdunidade2').style.display = "none";
        document.getElementById('titleUnidade2').style.display = "none";
        document.getElementById('ctnServicoQuantidade').style.marginLeft = "";


      }

    } else {
      document.getElementById('titleUnidade').style.display = "";
      document.getElementById('pc17_unid').style.display = "";
      document.getElementById('ctnServicoQuantidade').style.display = "none";
      document.getElementById('pc11_servicoquantidade').style.display = "none";
      document.getElementById('pc17_unid2').style.display = "none";
      document.getElementById('titleUnidade2').style.display = "none";
      document.getElementById('pc11_seq').style.marginLeft = "";
      document.getElementById('titleOrdem').style.marginLeft = "";
      document.getElementById('tdunidade2').style.display = "none";
      document.getElementById('tdunidade').style.display = "";



    }

    var options = document.querySelectorAll('#eleSub option');
    options.forEach(o => o.remove());
    js_buscarEle();
    document.getElementById('eleSub').value = document.getElementsByName("codele[]")[indice].value;


  }

  function js_excluirLinha(indice) {

    document.getElementById('novo').style.display = "";

    document.getElementById('db_opcao').value = "Excluir";
    document.getElementById("db_opcao").setAttribute('name', 'excluir');
    document.getElementById("db_opcao").setAttribute('type', 'submit');
    document.getElementById("db_opcao").setAttribute('onclick', '');



    document.getElementById('pc16_codmater').value = document.getElementsByName("codmaterial[]")[indice].value;
    document.getElementById('pc01_descrmater').value = document.getElementsByName("descmaterial[]")[indice].value;
    document.getElementById('pc11_seq').value = document.getElementsByName("ordem[]")[indice].value;
    document.getElementById('pc11_quant').value = document.getElementsByName("quantidade[]")[indice].value;
    document.getElementById('pc17_unid').value = document.getElementsByName("codigo_unidade[]")[indice].value;
    document.getElementById('pc11_servicoquantidade').value = document.getElementsByName("servicoquantidade[]")[indice].value;
    document.getElementById('pc11_codigo').value = document.getElementsByName("codigo[]")[indice].value;
    $('eleSub').options[0] = new Option(document.getElementsByName("descrelemento[]")[indice].value, document.getElementsByName("descrelemento[]")[indice].value);

    document.getElementById('pc16_codmater').disabled = true;
    document.getElementById('pc01_descrmater').disabled = true;
    document.getElementById('pc11_seq').disabled = true;
    document.getElementById('pc11_quant').disabled = true;
    document.getElementById('pc17_unid').disabled = true;
    document.getElementById('pc11_servicoquantidade').disabled = true;
    document.getElementById('eleSub').disabled = true;


  }

  function js_changeControladoPorQtd(quantidade) {


    if (quantidade == 'true') {

      document.getElementById('pc17_unid2').style.display = "";
      document.getElementById('titleUnidade2').style.display = "";
      document.getElementById('pc11_seq').style.marginLeft = "0px";
      document.getElementById('titleOrdem').style.marginLeft = "";
      document.getElementById('ctnServicoQuantidade').style.marginLeft = "-20%";
      document.getElementById('pc11_servicoquantidade').style.marginLeft = "";
      document.getElementById('pc11_servicoquantidade').style.width = "100%";
      document.getElementById('pc11_quant').readOnly = false;
      document.getElementById('pc11_quant').style.background = "";
      document.getElementById('tdunidade2').style.display = "";




    } else {
      document.getElementById('pc17_unid2').style.display = "none";
      document.getElementById('titleUnidade2').style.display = "none";
      document.getElementById('pc11_seq').style.marginLeft = "";
      document.getElementById('titleOrdem').style.marginLeft = "";
      document.getElementById('ctnServicoQuantidade').style.marginLeft = "0px";
      document.getElementById('pc11_servicoquantidade').style.marginLeft = "0px";
      document.getElementById('pc11_servicoquantidade').style.width = "";
      document.getElementById('pc11_quant').readOnly = true;
      document.getElementById('pc11_quant').style.background = "#EEE";
      document.getElementById('pc11_quant').value = 1;
      document.getElementById('tdunidade2').style.display = "none";



    }

  }

  function js_liberarSolicitacao() {
    var sUrl = "com4_materialsolicitacao.RPC.php";
    var oRequest = new Object();
    oRequest.numero = parent.iframe_solicita.document.getElementById('pc10_numero').value;
    oRequest.exec = "liberarSolicitacao";
    var oAjax = new Ajax.Request(
      sUrl, {
        method: 'post',
        parameters: 'json=' + js_objectToJson(oRequest),
        onComplete: js_retornoliberarSolicitacao
      }
    );

  }

  function js_retornoliberarSolicitacao(oAjax) {
    var oRetorno = eval("(" + oAjax.responseText + ")");

    if (oRetorno.erro == true) {
      alert(oRetorno.message.urlDecode());
      return false;

    } else {
      alert('Solicitação de compra Liberada !');
    }

    numero = top.corpo.iframe_solicita.document.form1.pc10_numero.value;
    data = top.corpo.iframe_solicita.document.form1.pc10_data.value;
    descrdepto = top.corpo.iframe_solicita.document.form1.descrdepto.value;


    parent.window.location.href = "com1_pcproc001.php?pc10_numero=" + numero + "&data=" + data + "&descrdepto=" + descrdepto + "";


  }

  function js_buscarEle() {
    var sUrl = "com4_materialsolicitacao.RPC.php";

    var oRequest = new Object();
    oRequest.pc_mat = $F('pc16_codmater').valueOf();
    oRequest.exec = "getDadosElementos";
    var oAjax = new Ajax.Request(
      sUrl, {
        method: 'post',
        asynchronous: false,
        parameters: 'json=' + js_objectToJson(oRequest),
        onComplete: js_retornogetDados
      }
    );

  }

  function js_retornogetDados(oAjax) {
    var oRetorno = eval("(" + oAjax.responseText + ")");
    var i = 0;

    if (oRetorno.dados.length > 1) {
      $('eleSub').options[0] = new Option('Selecione', '0');

      i = 1;
    }


    oRetorno.dados.forEach(function(oItem) {
      valor = oItem.codigo + " - " + oItem.elemento + " - " + oItem.nome.urlDecode();
      valorElem = oItem.elemento;
      document.getElementById('pc01_complmater').value = oItem.complemento.urlDecode().toUpperCase();
      $('eleSub').options[i] = new Option(valor, oItem.codigo);
      i++;
    });


  }

  function js_materanterior() {

    <?
    echo "materanterior = '$pcmateranterior';\n";
    if ($iRegistroPreco != "") {
      echo  "document.form1.submit();";
    } else {
      echo "
    if(materanterior!=document.form1.pc16_codmater.value){
      document.form1.submit();
    }
  //js_pesquisapc01_servico(document.form1.pc16_codmater.value);
  ";
    }
    ?>
  }

  function js_pesquisapc16_codmater(mostra) {


    var iRegistroPrecoFuncao = false;
    <?
    $sUrlLookup = "func_pcmatersolicita.php";
    $sFiltro    = "";
    if ($iRegistroPreco != "") {

      $sUrlLookup = 'func_pcmaterregistropreco.php';
      echo "iRegistroPrecoFuncao = true;\n";
      $sFiltro = "|pc11_codigo";
    }
    ?>
    if (mostra == true || iRegistroPrecoFuncao) {
      js_OpenJanelaIframe('',
        'db_iframe_pcmater',
        '<?= $sUrlLookup ?>?funcao_js=parent.js_mostrapcmater1' +
        '|pc01_codmater|pc01_descrmater|o56_codele|pc01_servico|pc01Complmater<?= $sFiltro ?><?= $db_opcao == 1 ? "&opcao_bloq=3&opcao=f" : "&opcao_bloq=1&opcao=i" ?>' +
        '&iRegistroPreco=<?= $iRegistroPreco; ?>',
        'Pesquisa de Materiais',
        true);
    } else {
      if (document.form1.pc16_codmater.value != '') {
        js_OpenJanelaIframe('',
          'db_iframe_pcmater',
          '<?= $sUrlLookup ?>?pesquisa_chave=' +
          document.form1.pc16_codmater.value +
          '&iRegistroPreco=<?= $iRegistroPreco; ?>' +
          '&funcao_js=parent.js_mostrapcmater<?= $db_opcao == 1 ? "&opcao_bloq=3&opcao=f" : "&opcao_bloq=1&opcao=i" ?>',
          'Pesquisa', false, '0');
      } else {
        document.form1.pc01_descrmater.value = '';

        document.form1.submit();
      }
    }
  }

  function js_pesquisa_desdobramento() {

    if (document.form1.pc01_descrmater.value == '') {
      document.form1.pc16_codmater.value = '';

      var options = document.querySelectorAll('#eleSub option');
      options.forEach(o => o.remove());
      $('eleSub').options[0] = new Option('', '0');

      return false;
    }

    var iRegistroPrecoFuncao = false;
    <?
    $sUrlLookup = "func_pcmatersolicita.php";
    $sFiltro    = "";
    if ($iRegistroPreco != "") {

      $sUrlLookup = 'func_pcmaterregistropreco.php';
      echo "iRegistroPrecoFuncao = true;\n";
      $sFiltro = "|pc11_codigo";
    }
    ?>

    if (document.form1.pc16_codmater.value != '') {
      js_OpenJanelaIframe('',
        'db_iframe_pcmater',
        '<?= $sUrlLookup ?>?pesquisa_chave=' +
        document.form1.pc16_codmater.value +
        '&iRegistroPreco=<?= $iRegistroPreco; ?>' +
        '&funcao_js=parent.js_mostrapcmater<?= $db_opcao == 1 ? "&opcao_bloq=3&opcao=f" : "&opcao_bloq=1&opcao=i" ?>',
        'Pesquisa', false, '0');
    } else {
      document.form1.pc01_descrmater.value = '';

      document.form1.submit();
    }
  }

  function js_mostrapcmater(chave, erro, lVeic, servico) {

    if (erro == true) {
      document.form1.pc16_codmater.focus();
      document.form1.pc16_codmater.value = '';


    } else {
      document.form1.pc01_descrmater.value = chave;
      if (servico == 't') {
        document.getElementById('titleUnidade').style.display = "none";
        document.getElementById('pc17_unid').style.display = "none";
        document.getElementById('ctnServicoQuantidade').style.display = "";
        document.getElementById('pc11_servicoquantidade').style.display = "";
        document.getElementById('pc17_unid2').style.display = "none";
        document.getElementById('titleUnidade2').style.display = "none";
        document.getElementById('pc11_seq').style.marginLeft = "";
        document.getElementById('titleOrdem').style.marginLeft = "";
        document.getElementById('ctnServicoQuantidade').style.marginLeft = "0px";
        document.getElementById('pc11_servicoquantidade').style.marginLeft = "0px";
        document.getElementById('pc11_servicoquantidade').style.width = "";
        document.getElementById('pc11_quant').readOnly = true;
        document.getElementById('pc11_quant').style.background = "#EEE";
        document.getElementById('pc11_quant').value = 1;
        document.getElementById('pc11_servicoquantidade').value = "false";
        document.getElementById('tdunidade').style.display = "none";
        document.getElementById('tdunidade2').style.display = "none";


      } else {
        document.getElementById('titleUnidade').style.display = "";
        document.getElementById('pc17_unid').style.display = "";
        document.getElementById('ctnServicoQuantidade').style.display = "none";
        document.getElementById('pc11_servicoquantidade').style.display = "none";
        document.getElementById('pc11_servicoquantidade').value = "true";
        document.getElementById('pc17_unid2').style.display = "none";
        document.getElementById('titleUnidade2').style.display = "none";
        document.getElementById('pc11_seq').style.marginLeft = "";
        document.getElementById('titleOrdem').style.marginLeft = "";
        document.getElementById('pc11_quant').value = "";
        document.getElementById('pc11_quant').readOnly = false;
        document.getElementById('pc11_quant').style.background = "";
        document.getElementById('tdunidade2').style.display = "none";
        document.getElementById('tdunidade').style.display = "";



      }
      js_buscarEle();

    }
  }

  function js_mostrapcmater1(chave1, chave2, codele, servico, pc01Complmater, iRegistro) {

    document.form1.pc16_codmater.value = chave1;
    document.form1.pc01_descrmater.value = chave2;
    document.form1.pc01_complmater.value = pc01Complmater;

    db_iframe_pcmater.hide();

    if (servico == 'Sim') {
      document.getElementById('titleUnidade').style.display = "none";
      document.getElementById('pc17_unid').style.display = "none";
      document.getElementById('ctnServicoQuantidade').style.display = "";
      document.getElementById('pc11_servicoquantidade').style.display = "";
      document.getElementById('pc17_unid2').style.display = "none";
      document.getElementById('titleUnidade2').style.display = "none";
      document.getElementById('pc11_seq').style.marginLeft = "";
      document.getElementById('titleOrdem').style.marginLeft = "";
      document.getElementById('ctnServicoQuantidade').style.marginLeft = "0px";
      document.getElementById('pc11_servicoquantidade').style.marginLeft = "0px";
      document.getElementById('pc11_servicoquantidade').style.width = "";
      document.getElementById('pc11_quant').readOnly = true;
      document.getElementById('pc11_quant').style.background = "#EEE";
      document.getElementById('pc11_quant').value = 1;
      document.getElementById('pc11_servicoquantidade').value = "false";
      document.getElementById('tdunidade').style.display = "none";
      document.getElementById('tdunidade2').style.display = "none";

    } else {
      document.getElementById('titleUnidade').style.display = "";
      document.getElementById('pc17_unid').style.display = "";
      document.getElementById('ctnServicoQuantidade').style.display = "none";
      document.getElementById('pc11_servicoquantidade').style.display = "none";
      document.getElementById('pc11_servicoquantidade').value = "true";
      document.getElementById('pc17_unid2').style.display = "none";
      document.getElementById('titleUnidade2').style.display = "none";
      document.getElementById('pc11_seq').style.marginLeft = "";
      document.getElementById('titleOrdem').style.marginLeft = "";
      document.getElementById('pc11_quant').value = "";
      document.getElementById('pc11_quant').readOnly = false;
      document.getElementById('pc11_quant').style.background = "";
      document.getElementById('tdunidade2').style.display = "none";
      document.getElementById('tdunidade').style.display = "";



    }

    js_buscarEle();

  }

  function js_esconteVeic(mostra) {

    if (!mostra) {
      mostra = "f";
    }

    if (mostra == "t") {
      document.form1.pc01_veiculo.value = "t";
    } else {
      if (document.form1.pc01_veiculo.value == "t") {
        document.getElementById("MostraVeiculos").style.display = "none";
        document.form1.ve01_placa = "";
        document.form1.pc14_veiculos.value = "";
      }
      document.form1.pc01_veiculo.value = "";
    }

  }

  indice = 0;

  function js_novoitem() {

    document.getElementById('db_opcao').value = "Adicionar Item";
    document.getElementById("db_opcao").setAttribute('name', 'incluir');
    document.getElementById("db_opcao").setAttribute('type', 'submit');
    document.getElementById("db_opcao").setAttribute('onclick', '');

    document.getElementById('novo').style.display = "none";
    document.getElementById('pc16_codmater').value = '';
    document.getElementById('pc01_descrmater').value = '';
    document.getElementById('pc11_quant').value = '';
    document.getElementById('pc17_unid').value = "1";
    document.getElementById('pc17_unid2').value = "1";
    document.getElementById('eleSub').value = "0";

    document.getElementById('titleUnidade').style.display = "";
    document.getElementById('pc17_unid').style.display = "";
    document.getElementById('ctnServicoQuantidade').style.display = "none";
    document.getElementById('pc11_servicoquantidade').style.display = "none";
    document.getElementById('pc17_unid2').style.display = "none";
    document.getElementById('titleUnidade2').style.display = "none";
    document.getElementById('pc11_seq').style.marginLeft = "";
    document.getElementById('titleOrdem').style.marginLeft = "";
    document.getElementById('pc11_quant').value = "";
    document.getElementById('pc11_quant').readOnly = false;
    document.getElementById('pc11_quant').style.background = "";
    document.getElementById('tdunidade2').style.display = "none";
    document.getElementById('tdunidade').style.display = "";
    document.getElementById('ctnServicoQuantidade').style.marginLeft = "";


    sequencial = 0;
    for (var i = 0; i < oGridItens.aRows.length; i++) {

      if (parseInt(document.getElementsByName("ordem[]")[i].value) > sequencial) {
        sequencial = parseInt(document.getElementsByName("ordem[]")[i].value);
      }
    }
    document.getElementById("pc11_seq").value = parseInt(sequencial) + 1;

    document.getElementById('pc16_codmater').disabled = false;
    document.getElementById('pc01_descrmater').disabled = false;
    document.getElementById('pc11_quant').disabled = false;
    document.getElementById('pc11_seq').disabled = false;
    document.getElementById('pc17_unid').disabled = false;
    document.getElementById('eleSub').disabled = false;
    document.getElementById('pc11_servicoquantidade').disabled = false;
  }

  function js_adicionarItem() {



    if (document.getElementById('pc17_unid2').style.display == '') {
      document.getElementById('pc17_unid').value = document.getElementById('pc17_unid2').value;
      if ($F('pc17_unid2') == "0") {
        alert('Informe a Unidade!');
        return false;
      }
    } else {
      if ($F('pc17_unid') == "0" && document.getElementById('pc11_servicoquantidade').style.display != '') {

        alert('Informe a unidade!');
        return false;

      }

    }

    if ($F('eleSub') == "0") {

      alert('Informe o Desdobramento!');
      return false;

    }

    if ($F('pc16_codmater') == "") {

      alert('Informe o material!');
      return false;

    }

    if ($F('pc11_seq') == "") {

      alert('Informe a ordem!');
      return false;

    }

    if ($F('pc11_quant') == "") {

      alert('Informe a quantidade!');
      return false;

    }

    if (document.getElementById('pc11_servicoquantidade').value == 'false' && document.getElementById('pc11_servicoquantidade').style.display != 'none') {
      document.getElementById('pc17_unid').value = 999999;
    }



    var sizeItens = oGridItens.aRows.length;

    itens_antigos = oGridItens.aRows;

    // Verifica se o item já foi incluído com o sequencial informado.
    for (var i = 0; i < sizeItens; i++) {
      if (document.getElementById('pc11_seq').value == document.getElementsByName("ordem[]")[i].value) {
        alert('A ordem ' + document.getElementById('pc11_seq').value + ' já foi utilizada nesta solicitação.');
        return false;
      }
    }

  }



  oGridItens = new DBGrid('oGridItens');
  oGridItens.nameInstance = 'oGridItens';
  oGridItens.setCellAlign(['center', 'center', "center", "center", "center", "center", "center", "center", "center", "center", "center", "center"]);
  oGridItens.setCellWidth(["10%", "10%", "40%", "20%", "10%", "10%", "0%", "0%", "0%", "0%", "0%", "0%"]);
  oGridItens.setHeader(["Ordem", "Código", "Descrição", "Unidade", "Quantidade", "Ação", "", "", "", "", "", ""]);
  oGridItens.aHeaders[6].lDisplayed = false;
  oGridItens.aHeaders[7].lDisplayed = false;
  oGridItens.aHeaders[8].lDisplayed = false;
  oGridItens.aHeaders[9].lDisplayed = false;
  oGridItens.aHeaders[10].lDisplayed = false;
  oGridItens.aHeaders[11].lDisplayed = false;



  oGridItens.setHeight(200);
  oGridItens.show($('ctnGridItens'));
  var db_opcao = <?php echo $db_opcao; ?>;


  var sUrl = "com4_materialsolicitacao.RPC.php";

  var oRequest = new Object();
  oRequest.numero = CurrentWindow.corpo.iframe_solicita.document.form1.pc10_numero.value;
  oRequest.exec = "getItens";
  var oAjax = new Ajax.Request(
    sUrl, {
      method: 'post',
      parameters: 'json=' + js_objectToJson(oRequest),
      onComplete: js_retornogetItens
    }
  );

  function js_retornogetItens(oAjax) {
    var oRetorno = eval("(" + oAjax.responseText + ")");

    oGridItens.clearAll(true);
    var aLinha = new Array();
    sequencial = 0;
    for (var i = 0; i < oRetorno.aItens.length; i++) {
      if (parseInt(oRetorno.aItens[i].pc11_seq) > parseInt(sequencial)) {
        sequencial = oRetorno.aItens[i].pc11_seq;
      }

      aLinha[0] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='ordem[]' value='" + oRetorno.aItens[i].pc11_seq + "'>"

      aLinha[1] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='codmaterial[]' value='" + oRetorno.aItens[i].pc01_codmater + "'>"


      aLinha[2] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='descmaterial[]' value='" + oRetorno.aItens[i].pc01_descrmater.urlDecode() + "'>"

      aLinha[3] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='unidade[]' value='" + oRetorno.aItens[i].m61_descr.urlDecode() + "'>";

      aLinha[4] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='quantidade[]' value='" + oRetorno.aItens[i].pc11_quant + "'>";


      aLinha[5] = "<input type='button' value='A'  onclick='js_alterarLinha(" + i + ")'> <input type='button' name='excluir' value='E' onclick='js_excluirLinha(" + i + ")'>";


      aLinha[6] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='codele[]' value='" + oRetorno.aItens[i].pc18_codele + "'>";



      aLinha[7] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='servicoquantidade[]' value='" + oRetorno.aItens[i].pc11_servicoquantidade + "'>";

      aLinha[8] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='codigo_unidade[]' value='" + oRetorno.aItens[i].m61_codmatunid + "'>";

      aLinha[9] = " <input style='text-align:center; width:90%; border:none;' readonly='' type='text' name='codigo[]' value='" + oRetorno.aItens[i].pc11_codigo + "'>";

      valor = oRetorno.aItens[i].o56_codele + " - " + oRetorno.aItens[i].o56_elemento + " - " + oRetorno.aItens[i].o56_descr;

      aLinha[10] = "  <input style='text-align:center; width:90%; border:none;' readonly='' type='text'  name='descrelemento[]' value='" + valor + "'>";

      aLinha[11] = "  <input style='text-align:center; width:90%; border:none;' readonly='' type='text'  name='servico[]' value='" + oRetorno.aItens[i].pc01_servico + "'>";



      oGridItens.addRow(aLinha);


    }

    document.getElementById("pc11_seq").value = parseInt(sequencial) + 1;

    oGridItens.renderRows();

  }


  oAutoComplete = new dbAutoComplete($('pc01_descrmater'), 'com4_pesquisamateriais.RPC.php');
  oAutoComplete.setTxtFieldId(document.getElementById('pc16_codmater'));
  oAutoComplete.show();

  document.getElementById('pc16_codmater').value = '';
  document.getElementById('pc01_descrmater').value = '';
  document.getElementById('pc11_quant').value = '';
  document.getElementById('pc17_unid').value = "1";
  document.getElementById('pc17_unid2').value = "1";
  document.getElementById('eleSub').value = "0";

  function js_inlineMouseHover(value) {

    let descricao = document.getElementById('pc01_descrmater').value;
    let complemento = document.getElementById('pc01_complmater').value;

    if (value != "") {
        document.getElementById('hoverBox').classList.remove('hoverBoxDisabled');
        document.getElementById('hoverText').textContent = descricao + " " + complemento;
    }

    setTimeout(()=>{
        document.getElementById('hoverBox').classList.add('hoverBoxDisabled');
    }, 3000);

  }
</script>
