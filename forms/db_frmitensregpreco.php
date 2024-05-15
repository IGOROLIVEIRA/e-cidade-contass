<?
//MODULO: sicom
$clitensregpreco->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc01_descrmater");

?>

<style type="text/css">
  .linhagrid.left {
    text-align: left;
  }

  .linhagrid input[type='text'] {
    width: 100%;
  }

  .linhagrid.fornecedor input[type='text'] {
    width: 85%;
  }

  .normal:hover {
    background-color: #eee;
  }

  .registro_preco {
    width: 90%;
    max-width: 1300px;
    min-width: 1000px;
    margin: 25px auto;
  }

  .DBGrid {
    width: 100%;
    border: 1px solid #888;
    margin: 20px 0;
  }

  .align-center {
    text-align: center;
  }

  .input-inativo {
    background-color: #EEEFF2;
  }

  .th_footer {
    padding: 10px;
  }
</style>

<div class="registro_preco">
  <?php

  $aItensColsuta = array();

  $whereDescontoTabela = "";

  if ($iCriterioAdjudicacao == 1) $whereDescontoTabela = " AND pc01_tabela = 't'";
  if ($iCriterioAdjudicacao == 2) $whereDescontoTabela = " AND pc01_taxa = 't'";
  

  $sSQL = "
    SELECT DISTINCT pc01_codmater,
                    pc11_seq,
                    pc81_codprocitem,
                    pc01_descrmater,
                    si06_sequencial,
                    m61_descr,
                    m61_codmatunid,
                    pc11_quant,
                    z01_nome,
                    itensregpreco.*,
                    case
                    when si07_percentual is null then si02_mediapercentual
                       else si07_percentual
                       end as percentual
    FROM pcproc
      INNER JOIN adesaoregprecos ON si06_processocompra = pc80_codproc
      INNER JOIN precoreferencia ON si01_processocompra = pc80_codproc
      INNER JOIN pcprocitem ON pc81_codproc = pc80_codproc
      INNER JOIN solicitem ON pc11_codigo = pc81_solicitem
      INNER JOIN solicitemunid ON pc17_codigo = pc11_codigo
      INNER JOIN solicitempcmater ON pc16_solicitem = pc11_codigo
      INNER JOIN matunid ON m61_codmatunid = pc17_unid
      INNER JOIN pcmater ON pc01_codmater = pc16_codmater
      LEFT JOIN itensregpreco ON si07_item = pc01_codmater AND si07_sequencialadesao = si06_sequencial
      LEFT JOIN cgm ON z01_numcgm = si07_fornecedor
      INNER JOIN pcorcamitemproc on pc31_pcprocitem = pc81_codprocitem
      INNER JOIN itemprecoreferencia on si02_itemproccompra = pc31_orcamitem
    WHERE si06_sequencial = {$codigoAdesao} AND si06_processocompra = {$iProcessoCompra} $whereDescontoTabela order by pc11_seq;
  ";

  $rsItensProcComp = db_query($sSQL);

  ?>

  <form action="" name="form1" method="post" onsubmit="return validaForm(this);">
    <fieldset>
      <legend> Edição em bloco </legend>

      <table>
        <tr>
          <td>
            <? db_ancora("Fornecedor Ganhador", "js_pesquisasi07_fornecedor(true);", $db_opcao); ?>
          </td>
          <td>
            <? db_input('si07_fornecedor', 10, $Isi07_fornecedor, true, 'text', $db_opcao, " onchange='js_pesquisasi07_fornecedor(false);'"); ?>
            <? db_input('z01_nomef', 40, $Iz01_nome, true, 'text', 3, '') ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="align-center">
            <hr>
            <input type="button" name="aplicao-alteracoes" value="Aplicar" onclick="aplicarEdicao();">
          </td>
        </tr>
      </table>
    </fieldset>

    <table class="DBGrid">
      <tr>
        <th class="table_header" style="width: 30px; cursor: pointer;" onclick="marcarTodos();">M</th>
        <th class="table_header" style="width: 20px;">Ordem</th>
        <th class="table_header" style="width: 50px;">Item</th>
        <th class="table_header" style="width: 220px;">Descrição Item</th>
        <th class="table_header" style="width: 80px;">Unidade</th>
        <th class="table_header coluna_quantidadeaderida" style="width: 70px;">Quantidade Aderida</th>
        <th class="table_header coluna_quantidadelicitada" style="width: 70px;">Quantidade Licitada</th>
        <th class="table_header coluna_precounitario" style="width: 70px;">Preço Unitário</th>
        <th class="table_header" style="width: 220px;">Fornecedor Ganhador</th>
        <th class="table_header coluna_numerolote" style="width: 70px;">Número do Lote</th>
        <th class="table_header coluna_descricaolote" style="width: 110px;">Descrição do Lote</th>
        <th class="table_header coluna_percentual" style="width: 110px;">Percentual %</th>

        <th class="table_header" style="width: 60px;"></th>
      </tr>

      <?php
      $aItensProcComp = db_utils::getCollectionByRecord($rsItensProcComp);
      //$aItensPrecoReferencia = db_utils::getCollectionByRecord($rsItensPrecoReferencia);

      $iTotalItens = 0;
      $indice = 0;
      foreach ($aItensProcComp as $key => $oItem) :

        $iItem = $oItem->pc01_codmater;

        if (isset($aItensColsuta[$iItem])) {
          continue;
        }

        $iTotalItens++;

        $aItensColsuta[$iItem] = $iItem;
      ?>

        <tr class="normal <?= empty($oItem->si07_numeroitem) ? '' : '' ?>">
          <th class="table_header">
            <input type="checkbox" class="marca_itens" name="aItonsMarcados[]" value="<?= $iItem ?>">
            <input type="hidden" name="aItensAdesaoRegPreco[<?= $iItem ?>][sequencial]" value="<?= $oItem->si07_sequencial ?>">
            <input type="hidden" name="aItensAdesaoRegPreco[<?= $iItem ?>][numeroItem]" value="<?= $oItem->si07_numeroitem ?>">
            <input type="hidden" name="aItensAdesaoRegPreco[<?= $iItem ?>][sequencialAdesao]" value="<?= $oItem->si06_sequencial ?>">
          </th>
          <td class="linhagrid">
            <?= $iTotalItens ?>
            </th>
          <td class="linhagrid">
            <?= $iItem ?>
          </td>
          <td class="linhagrid left">
            <?= $oItem->pc01_descrmater ?>
            <input type="hidden" name="aItensAdesaoRegPreco[<?= $iItem ?>][descricao]" value="<?= $oItem->pc01_descrmater ?>">
          </td>
          <td class="linhagrid">
            <?= $oItem->m61_descr ?>
            <input type="hidden" name="aItensAdesaoRegPreco[<?= $iItem ?>][codigoUnidade]" value="<?= $oItem->m61_codmatunid ?>">
            <input type="hidden" name="aItensAdesaoRegPreco[<?= $iItem ?>][descricaoUnidade]" value="<?= $oItem->m61_descr ?>">
          </td>
          <td class="linhagrid coluna_quantidadeaderida">
            <?= $oItem->pc11_quant ?>
            <input type="hidden" name="aItensAdesaoRegPreco[<?= $iItem ?>][qtdAderida]" value="<?= $oItem->pc11_quant ?>">
          </td>
          <td class="linhagrid coluna_quantidadelicitada">
            <input type="text" name="aItensAdesaoRegPreco[<?= $iItem ?>][qtdLicitada]" onkeypress="mascaraQtdLicitada(event,this,<?= $iItem ?>)" onblur="comparaValor(event,this,<?= $iItem ?>)" value="<?= $oItem->si07_quantidadelicitada ?>">
          </td>
          <td class="linhagrid coluna_precounitario">
            <input type="text" name="aItensAdesaoRegPreco[<?= $iItem ?>][precoUnitario]" onkeypress="mascaraPrecoUnitario(event,this)" onchange="verificaPrecoUnitario(event,this,<?= $iItem ?>,<?= $oItem->si07_precounitario ?>)" value="<?= $oItem->si07_precounitario ?>">
          </td>
          <td class="linhagrid fornecedor">
            <input type="text" name="aItensAdesaoRegPreco[<?= $iItem ?>][descricaoFornecedor]" value="<?= $oItem->z01_nome ?>" readonly class="input-inativo">
            <input type="hidden" name="aItensAdesaoRegPreco[<?= $iItem ?>][codigoFornecedor]" value="<?= $oItem->si07_fornecedor ?>">
            <input type="button" value="X" onclick="apagaFornecedor(<?= $iItem ?>);">
          </td>
          <td class="linhagrid coluna_numerolote">
            <input type="text" name="aItensAdesaoRegPreco[<?= $iItem ?>][numeroLote]" value="<?= $oItem->si07_numerolote ?>" <?= $iProcessoLote == 2 ? ' readonly class="input-inativo"' : '' ?>>
          </td>
          <td class="linhagrid coluna_descricaolote">
            <input type="text" name="aItensAdesaoRegPreco[<?= $iItem ?>][descricaoLote]" value="<?= $oItem->si07_descricaolote ?>" <?= $iProcessoLote == 2 ? ' readonly class="input-inativo"' : '' ?>>
          </td>
          <td class="linhagrid coluna_percentual">
            <input type="text" name="aItensAdesaoRegPreco[<?= $iItem ?>][percentual]" onkeypress="mascaraPrecoUnitario(event,this)" value="<?= $oItem->percentual; ?>">
          </td>
          <td class="linhagrid">
            <?php if (!empty($oItem->si07_sequencial)) : ?>
              <input type="button" value="Excluir" onclick="js_excluir(<?= $oItem->si07_sequencial ?>, <?= $iItem ?>);">
            <?php endif ?>
          </td>
        </tr>

      <?php $indice++;
      endforeach; ?>

      <tr>
        <th colspan="12" class="table_header th_footer">Total de itens: <?= $iTotalItens ?></th>
      </tr>

    </table>

    <center>
      <input type="submit" value="Salvar" id="salvar">
    </center>
  </form>
</div>

<script type="text/javascript" src="scripts/prototype.js"></script>

<script>
  /* Ocultando campos número e descrição do lote caso o processo da adesão seja por lote */

  iProcessoPorLote = <? echo $iProcessoLote; ?>;
  iDescontoTabela = <? echo $iDescontoTabela; ?>;
  quantidadeItens = document.getElementsByClassName('coluna_descricaolote').length;

  for (i = 0; i < quantidadeItens; i++) {
    if (iProcessoPorLote == 2) {
      document.getElementsByClassName('coluna_descricaolote')[i].style.display = 'none';
      document.getElementsByClassName('coluna_numerolote')[i].style.display = 'none';
    }

    if (iDescontoTabela == 1) {
      document.getElementsByClassName('coluna_quantidadeaderida')[i].style.display = 'none';
      document.getElementsByClassName('coluna_quantidadelicitada')[i].style.display = 'none';
      document.getElementsByClassName('coluna_precounitario')[i].style.display = 'none';
      document.getElementsByClassName('coluna_quantidadeaderida')[i].value = 0;
      document.getElementsByClassName('coluna_quantidadelicitada')[i].value = 0;
      document.getElementsByClassName('coluna_precounitario')[i].value = 0;
    }

    if (iDescontoTabela == 2) {
      document.getElementsByClassName('coluna_percentual')[i].style.display = 'none';
    }

  }

  function verificaPrecoUnitario(e, oObject, item, valorAntigo) {

    var precoUnitario = document.getElementsByName(`aItensAdesaoRegPreco[${item}][precoUnitario]`)[0];

    if (precoUnitario.value == '') {
      return false;
    }

    if (precoUnitario.value == 0) {
      alert('Erro! O preço unitário não pode ser zero ');
      if (valorAntigo == undefined) {
        oObject.value = "";
      } else {
        oObject.value = valorAntigo;

      }
      return false;
    }
  }

  function comparaValor(e, oObject, item) {
    var qtdAderida = document.getElementsByName(`aItensAdesaoRegPreco[${item}][qtdAderida]`)[0];


    if (parseFloat(qtdAderida.value) > parseFloat(oObject.value)) {
      alert('Usuário: Quantidade Aderida não pode ser maior que a quantidade licitada! ');

      oObject.value = qtdAderida.value;
      return false;
    }

  }

  function mascaraQtdLicitada(e, oObject, item) {

    novaString = oObject.value + e.key;



    var qtdAderida = document.getElementsByName(`aItensAdesaoRegPreco[${item}][qtdAderida]`)[0];
    var qtdLicitada = document.getElementsByName(`aItensAdesaoRegPreco[${item}][qtdLicitada]`)[0];


    if (novaString.includes('.')) {

      if (novaString.substr(novaString.indexOf(".")).length == 6) {
        e.preventDefault();
        return true;
      }

    }

    if (e.key == ",") {
      oObject.value = oObject.value + ".";
      e.preventDefault();
      return true;
    }

    if (!js_mask(e, '0-9|.|-')) {
      oObject.value = '';
      return false;
    }




  }

  function mascaraPrecoUnitario(e, oObject) {

    novaString = oObject.value + e.key;

    if (novaString.includes('.')) {

      if (novaString.substr(novaString.indexOf(".")).length == 6) {
        e.preventDefault();
        return true;
      }

    }

    if (e.key == ",") {
      oObject.value = oObject.value + ".";
      e.preventDefault();
      return true;
    }

    if (!js_mask(e, '0-9|.|-')) {
      oObject.value = '';
      return false;
    }




  }

  function retornoAjax(res) {

    var response = JSON.parse(res.responseText);

    if (response.status != 1) {
      alert(response.erro);
    } else if (!!response.sucesso) {

      alert(response.sucesso);
      location.reload();

    }

  }

  function js_excluir(sequencial, item) {
    if (confirm("Tem certeza que deseja excluir o item " + item + "?")) {

      novoAjax({

        exec: 'excluir',
        itemregpreco: sequencial

      }, retornoAjax);

    }
  }

  function js_novo(obj) {
    <?
    if ($db_opcao) {
      echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?opcao='+1";
    }
    ?>
  }

  function js_pesquisasi07_fornecedor(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_cgm', 'func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome', 'Pesquisa', true);
    } else {
      if (document.form1.si07_fornecedor.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_cgm', 'func_cgm.php?pesquisa_chave=' + document.form1.si07_fornecedor.value + '&funcao_js=parent.js_mostracgm', 'Pesquisa', false);
      } else {
        document.form1.z01_nomef.value = '';
      }
    }
  }

  function js_mostracgm(erro, chave) {
    document.form1.z01_nomef.value = chave;
    if (erro == true) {
      document.form1.si07_fornecedor.focus();
      document.form1.si07_fornecedor.value = '';
    }
  }

  function js_mostracgm1(chave1, chave2) {
    document.form1.si07_fornecedor.value = chave1;
    document.form1.z01_nomef.value = chave2;
    db_iframe_cgm.hide();
  }


  // ------------------


  function aItens() {
    var itensNum = document.querySelectorAll('.marca_itens');

    return Array.prototype.map.call(itensNum, function(item) {
      return item;
    });
  }

  function marcarTodos() {

    aItens().forEach(function(item) {

      var check = item.classList.contains('marcado');

      if (check) {
        item.classList.remove('marcado');
      } else {
        item.classList.add('marcado');
      }
      item.checked = !check;

    });

  }

  function apagaFornecedor(item) {

    document.form1['aItensAdesaoRegPreco[' + item + '][descricaoFornecedor]'].value = '';
    document.form1['aItensAdesaoRegPreco[' + item + '][codigoFornecedor]'].value = '';

  }

  function aplicarEdicao() {

    var itens = getItensMarcados();

    if (itens.length < 1) {

      alert('Selecione pelo menos um item da lista. ');
      return;

    }

    itens = itens.map(function(item) {
      return Number(item.value);
    });

    itens.forEach(function(item) {

      document.form1['aItensAdesaoRegPreco[' + item + '][descricaoFornecedor]'].value = document.form1.z01_nomef.value;
      document.form1['aItensAdesaoRegPreco[' + item + '][codigoFornecedor]'].value = document.form1.si07_fornecedor.value;

    });

  }

  function getItensMarcados() {
    return aItens().filter(function(item) {
      return item.checked;
    });
  }

  function validaForm(fORM) {

    console.log(iDescontoTabela);
    var itens = getItensMarcados();

    if (itens.length < 1) {

      alert('Selecione pelo menos um item da lista.');
      return false;

    }

    var itensEnviar = [];

    try {



      itens.forEach(function(item) {

        var elemento = 'aItensAdesaoRegPreco[' + item.value + ']';
        var novoItem;

        if (iDescontoTabela == 1) {

          if (item.value == '' ||
            fORM[elemento + "[codigoUnidade]"].value == '' ||
            fORM[elemento + "[codigoFornecedor]"].value == '' ||
            fORM[elemento + "[sequencialAdesao]"].value == '' ||
            fORM[elemento + "[descricaoUnidade]"].value == '' ||
            fORM[elemento + "[percentual]"].value == ''
          ) {
            throw new Error('Os dados do item ' + item.value + ' não foram preenchidos corretamente.');
          }

          novoItem = {
            si07_item: Number(item.value),
            si07_unidade: fORM[elemento + "[descricaoUnidade]"].value,
            si07_sequencial: fORM[elemento + "[sequencial]"].value,
            si07_numeroitem: fORM[elemento + "[numeroItem]"].value,
            si07_numerolote: fORM[elemento + "[numeroLote]"].value,
            si07_codunidade: fORM[elemento + "[codigoUnidade]"].value,
            si07_fornecedor: fORM[elemento + "[codigoFornecedor]"].value,
            si07_precounitario: 0,
            si07_descricaolote: fORM[elemento + "[descricaoLote]"].value,
            si07_sequencialadesao: fORM[elemento + "[sequencialAdesao]"].value,
            si07_quantidadeaderida: 0,
            si07_quantidadelicitada: 0,
            si07_percentual: fORM[elemento + "[percentual]"].value

          };

        }

        if (iDescontoTabela == 2) {
          if (item.value == '' ||
            fORM[elemento + "[qtdAderida]"].value == '' ||
            fORM[elemento + "[qtdLicitada]"].value == '' ||
            fORM[elemento + "[codigoUnidade]"].value == '' ||
            fORM[elemento + "[precoUnitario]"].value == '' ||
            fORM[elemento + "[codigoFornecedor]"].value == '' ||
            fORM[elemento + "[sequencialAdesao]"].value == '' ||
            fORM[elemento + "[descricaoUnidade]"].value == ''
          ) {
            throw new Error('Os dados do item ' + item.value + ' não foram preenchidos corretamente.');
          }

          novoItem = {
            si07_item: Number(item.value),
            si07_unidade: fORM[elemento + "[descricaoUnidade]"].value,
            si07_sequencial: fORM[elemento + "[sequencial]"].value,
            si07_numeroitem: fORM[elemento + "[numeroItem]"].value,
            si07_numerolote: fORM[elemento + "[numeroLote]"].value,
            si07_codunidade: fORM[elemento + "[codigoUnidade]"].value,
            si07_fornecedor: fORM[elemento + "[codigoFornecedor]"].value,
            si07_precounitario: fORM[elemento + "[precoUnitario]"].value,
            si07_descricaolote: fORM[elemento + "[descricaoLote]"].value,
            si07_sequencialadesao: fORM[elemento + "[sequencialAdesao]"].value,
            si07_quantidadeaderida: fORM[elemento + "[qtdAderida]"].value,
            si07_quantidadelicitada: fORM[elemento + "[qtdLicitada]"].value,
            si07_percentual: "0"

          };
        }



        itensEnviar.push(novoItem);

      });

      novoAjax({

        exec: 'salvar',
        itens: itensEnviar

      }, retornoAjax);

      let botao = $('salvar');
      /* Trecho comentado, pois desabilitava o botão de salvar 
       * após lançamento de exceção
      if (botao != null) {
        botao.disabled = true;
      }
       */


    } catch (e) {

      alert(e.toString());

    }

    return false;

  }


  function novoAjax(params, onComplete) {

    var request = new Ajax.Request('com4_adesaoregpreco.RPC.php', {
      method: 'post',
      parameters: 'json=' + JSON.stringify(params),
      onComplete: function(res) {

        js_divCarregando('Aguarde', 'div_aguarde');

        onComplete(res);

        js_removeObj('div_aguarde');

      }
    });

  }
</script>