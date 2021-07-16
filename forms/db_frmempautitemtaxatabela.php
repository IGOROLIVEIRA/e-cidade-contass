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

//MODULO: empenho
require_once("classes/db_empparametro_classe.php");
require_once("dbforms/db_classesgenericas.php");
require_once("classes/db_pcmaterele_classe.php");
require_once("classes/db_empautitem_classe.php");
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clempparametro = new cl_empparametro;
$clpctabelaitem = new cl_pctabelaitem;
$clpcmaterele   = new cl_pcmaterele;
$clempautitem   = new cl_empautitem;

$aTabFonec = array("" => "Selecione");
$tabsFonecVencedor = $clpctabelaitem->buscarTabFonecVencedor($e55_autori, $z01_numcgm);
if (!empty($tabsFonecVencedor)) {
  foreach ($tabsFonecVencedor as $tabFonecVencedor) {
    $aTabFonec += array($tabFonecVencedor->pc94_sequencial => "$tabFonecVencedor->pc94_sequencial - $tabFonecVencedor->pc01_descrmater");
  }
}

$clempautitem->rotulo->label();
$clrotulo = new rotulocampo;
//solicitemunid
$clrotulo->label("pc17_unid");

$clrotulo->label("e54_anousu");
$clrotulo->label("o56_elemento");
$clrotulo->label("pc01_descrmater");

?>

<!-- <script type="text/javascript" src="scripts/scripts.js"></script> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css" />
<script type="text/javascript" src="scripts/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>

<form name="form1" method="post" action="">
  <input type="hidden" id="pc80_criterioadjudicacao" name="pc80_criterioadjudicacao">
  <input type="hidden" id="e55_quant_ant" name="e55_quant_ant" value="<?= $e55_quant ?>">
  <center>
    <fieldset style="margin-top:5px; width:45%;">
      <legend><b>Ítens</b></legend>
      <table border="0" cellpadding='0' cellspacing='0'>
        <tr style="height: 20px;">
          <td nowrap title="<?= @$Te55_autori ?>">
            <?= $Le55_autori ?>
          </td>
          <td>
            <?php db_input('e55_autori', 8, $Ie55_autori, true, 'text', 3); ?>
          </td>
        </tr>
        <tr style="height: 20px;">
          <td nowrap title="<?= @$Te55_sequen ?>">
            <?= @$Le55_sequen ?>
          </td>
          <td>
            <? db_input('e55_sequen', 8, $Ie55_sequen, true, 'text', 3)  ?>
          </td>
        </tr>
        <tr style="height: 20px;">
          <td nowrap title="<?= @$Te55_descr ?>">
            <?= @$Le55_descr ?>
          </td>
          <td>
            <?
            db_textarea('e55_descr', 3, 70, $Ie55_descr, true, 'text', $iOpcao, "");
            ?>
          </td>
        </tr>

        <tr style="height: 20px;">
          <td nowrap title="">
            <strong>Tabela:</strong>
          </td>
          <td>
            <?
            db_select('chave_tabela', $aTabFonec, true, $db_opcao, " onchange='js_mudaTabela(false)' style='width:452;' ");
            ?>
          </td>
        </tr>



        <tr style="height: 20px;">
          <td nowrap title="">
            <b>Ele. item</b>
          </td>
          <td>
            <? db_selectrecord("pc07_codele", $result_elemento, true, $db_opcao, '', '', '', '', "js_troca(this.value);");  ?>
          </td>
        </tr>


        <tr>
          <td><b>Desconto automático:</b></td>
          <td>
            <?
            $aDescAutomatico = array("f" => "Não", "t" => "Sim");
            db_select("descauto", $aDescAutomatico, true, $db_opcao, "onchange='js_desconto(this.value)'");
            ?>
          </td>
        </tr>
        <tr style="height: 20px;">
          <td>
            <strong>Utilizado: </strong>
          </td>
          <td>
            <? db_input('utilizado', 11, "", true, 'text', 3, ""); ?>
            <strong style="margin-right:15px">Disponível: </strong>
            <? db_input('disponivel', 10, "", true, 'text', 3, ""); ?>
            <strong style="margin-right:15px">A lançar: </strong>
            <? db_input('totalad', 9, "", true, 'text', 3, ""); ?>
          </td>
        </tr>
        <tr style="height: 20px;">
          <td>&nbsp;</td>
          <td>
            <?php if (isset($pc01_servico) && $pc01_servico == 't') :

              if (!isset($e55_servicoquantidade)) {
                $e55_servicoquantidade = "f";
              }
            ?>

              <b>Controlar por quantidade:</b>
              <select name="lControlaQuantidade" id="lControlaQuantidade" onchange="js_verificaControlaQuantidade(this.value);" <?php echo $db_opcao == 3 ? " disabled='true'" : "" ?>>
                <option value="false">NÃO</option>
                <option value="true">SIM</option>
              </select>
              <script>
                lControlaQuantidade = "<?php echo $e55_servicoquantidade == 't' ? 'true' : 'false'; ?>";
                $("lControlaQuantidade").value = lControlaQuantidade;
                js_verificaControlaQuantidade($F("lControlaQuantidade"));
              </script>
            <?php endif; ?>
          </td>
        </tr>

      </table>
    </fieldset>
    <div class="container">
      <table height="100%" width="400px" id="myTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>M</th>
            <th>Código</th>
            <th>Descrição</th>
            <th>Unidade</th>
            <th>Marca</th>
            <th>Qtdd</th>
            <th>Vlr. Unit.</th>
            <th>Desc. %</th>
            <th>Total</th>
          </tr>
        </thead>
      </table>
    </div>
    <input name="salvar" type="button" id="salvar" value="salvar" onclick="js_salvar();">
  </center>
</form>
<script>
  js_loadTable();

  function js_loadTable() {

    $('#myTable').DataTable().clear().destroy();
    $('#myTable').DataTable({
      language: {
        "sEmptyTable": "Nenhum registro encontrado",
        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
        "sInfoPostFix": "",
        "sInfoThousands": ".",
        "sLengthMenu": "_MENU_ resultados por página",
        "sLoadingRecords": "Carregando...",
        "sProcessing": "Processando...",
        "sZeroRecords": "Nenhum registro encontrado",
        "sSearch": "Pesquisar",
        "oPaginate": {
          "sNext": "Próximo",
          "sPrevious": "Anterior",
          "sFirst": "Primeiro",
          "sLast": "Último"
        },
        "oAria": {
          "sSortAscending": ": Ordenar colunas de forma ascendente",
          "sSortDescending": ": Ordenar colunas de forma descendente"
        },
        buttons: {
          pageLength: {
            _: "Mostrar %d linhas",
            '-1': "Mostrar todo"
          }
        },
        select: {
          rows: "%d linhas selecionadas"
        },
      },
      processing: true,
      serverSide: true,
      ajax: {
        url: "emp1_empautitemtaxatabela.RPC.php",
        type: "POST",
        data: {
          action: 'buscaItens',
          autori: <?php echo $e55_autori ?>,
          cgm: <?php echo $z01_numcgm ?>,
          tabela: document.getElementById('chave_tabela').value,
          dataType: "json"
        }
      },
    });
  };

  function js_salvar() {

    var oParam = new Object();
    oParam.action = "salvar";
    oParam.autori = $('#e55_autori').val();
    oParam.sequen = $('#e55_sequen').val();
    oParam.codele = $('#pc07_codele').val();
    oParam.descr = $('#e55_descr').val();
    var oDados = {};
    var aDados = [];

    $("#mytable tr").each(function() {

      if ($(this).find("input[type='checkbox']").is(":checked")) {

        oDados.id = $(this).find("td:eq(1)").html();
        oDados.unidade = $(this).find("td:eq(3) select").val();
        oDados.marca = $(this).find("td:eq(4) input").val();
        oDados.qtd = $(this).find("td:eq(5) input").val();
        oDados.vlrunit = $(this).find("td:eq(6) input").val();
        oDados.desc = $(this).find("td:eq(7) input").val();
        oDados.total = $(this).find("td:eq(8) input").val();

        aDados.push(oDados);
      }
    });

    oParam.dados = aDados;
    //js_divCarregando(_M(CAMINHO_MENSAGENS + "salvando"), 'msgBox');

    $.ajax({
      type: "POST",
      url: "emp1_empautitemtaxatabela.RPC.php",
      data: oParam,
      success: function(data) {
        console.log(data);
        //$('#target').html(data.msg);
      }
    });
  }

  function js_mudaTabela(campo) {
    js_loadTable();
  }

  function js_desconto(obj) {
    console.log(obj);
    if (obj == 't') {
      $("#mytable tr").each(function() {
        $(this).find("td:eq(7) input").style.backgroundColor = "#DEB887";
        $(this).find("td:eq(7) input").attr('readonly', true);
      });
    } else {
      $("#mytable tr").each(function() {
        $(this).find("td:eq(7) input").style.backgroundColor = "#DEB887";
        $(this).find("td:eq(7) input").attr('readonly', false);
      });
    }
  }

  function js_verificar() {

    let qt = new Number(document.form1.e55_quant.value);
    let qtant = new Number(document.form1.e55_quant_ant.value);
    let vluni = new Number(document.form1.e55_vluni.value);
    let vltot = new Number(document.form1.e55_vltot.value);
    let total = new Number(document.form1.totalad.value);
    let utili = new Number(document.form1.utilizado.value);
    let dispo = new Number(document.form1.disponivel.value);

    if (isNaN(qt) || qt <= 0) {
      alert('Quantidade do item é inválida!');
      return false;
    }

    if (isNaN(vluni) || vluni <= 0) {
      alert('Valor unitário é inválido!');
      return false;
    }

    if (isNaN(vltot) || vltot == 0 || vltot == ' ') {

      alert('Valor total inválido!');
      return false;
    }

    if ((vltot + utili) > total) {
      alert('O valor total do item não pode ser maior que o valor total do item Adjudicado!');
      return false;
    }

    return true;
  }

  function js_removeVirgula(valor) {
    let valor_unitario = '';
    if (valor.includes('.') && valor.includes(',')) {
      document.form1.e55_vluni.value = valor.replace(',', '');
    }

    if (valor.includes(',') && !valor.includes('.')) {
      document.form1.e55_vluni.value = valor.replace(',', '.');
    }
  }


  function js_calcula(origem) {

    const item = origem.id.split('_');

    const id = item[1];

    quant = new Number($('#qtd_' + id).val());
    uni = new Number($('#vlrunit_' + id).val());
    tot = new Number($('#total_' + id).val()).toFixed(2);

    conQt = 'false';

    // if (document.querySelector('#lControlaQuantidade')) {
    //   conQt = obj.lControlaQuantidade.value;
    // }

    if (conQt == 'true') {
      t = new Number(uni * quant);
      $('#total_' + id).val(t.toFixed(2));
    }

    if (item[0] == 'qtd' && quant != '' && conQt == 'false') {
      if (isNaN(quant)) {
        $('#qtd_' + id).focus();
        return false;
      }
      if (tot != 0) {
        t = new Number(tot / quant);
        $('#total_' + id).val(tot);

        $('#vlrunit_' + id).val(t.toFixed($('#desc_' + id).val()));
      } else {
        t = new Number(uni * quant);
        $('#total_' + id).val(t.toFixed(2));
      }
    }

    if (item[0] == "vlrunit") {
      if (isNaN(uni)) {
        //alert("Valor unico inváido!");
        $('#vlrunit_' + id).focus();
        return false;
      }
      t = new Number(uni * quant);
      $('#total_' + id).val(t.toFixed(2));
    }

    if (item[0] == "total" && conQt == 'false') {
      if (isNaN(tot)) {
        //alert("Valor total inváido!");
        $('#total_' + id).focus();
        return false;
      }
      if (quant != 0) {
        t = new Number(tot / quant);
        $('#total_' + id).val(tot);
        $('#vlrunit_' + id).val(t.toFixed($('#desc_' + id).val()));
      }
    }

  }

  // function js_consultaValores(params) {
  //   novoAjax(params, (e) => {
  //     let totitens = JSON.parse(e.responseText).itens;
  //     document.form1.utilizado.value = totitens[0].totalitens > 0 ? totitens[0].totalitens : "0";
  //     document.form1.disponivel.value = new Number(params.total - totitens[0].totalitens) > 0 ? new Number(params.total - totitens[0].totalitens) : "0";

  //     js_consulta();

  //     document.form1.e55_quant.focus();
  //   });
  // }

  function consultaValores(origem) {

    const item = origem.id.split('_');

    const id = item[1];

    var params = {
      action: 'verificaSaldoCriterio',
      e55_item: id,
      e55_autori: $('#e55_autori').val(),
      cgm: <?php echo $z01_numcgm ?>,
      //tipoitem: chave8,
      //pc94_sequencial: chave9,
      total: $('#total_' + id).val()
    };

    $.ajax({
      type: "POST",
      url: "emp1_empautitemtaxatabela.RPC.php",
      data: params,
      success: function(data) {
        console.log(data);
        // document.form1.utilizado.value  = totitens[0].totalitens > 0 ? totitens[0].totalitens : "0" ;
        // document.form1.disponivel.value = new Number(params.total - totitens[0].totalitens) > 0 ? new Number(params.total - totitens[0].totalitens) : "0";
      }
    });

    // var request = new Ajax.Request('lic4_geraAutorizacoes.RPC.php', {
    //   method: 'post',
    //   parameters: 'json=' + Object.toJSON(params),
    //   onComplete: onComplete
    // });

  }

  function js_troca(codele) {

    descr = eval("document.form1.ele_" + codele + ".value");
    arr = descr.split("#");

    elemento = arr[0];
    descricao = arr[1];
    document.form1.elemento01.value = elemento;
    document.form1.o56_descr.value = descricao;
  }

  // function js_verificaControlaQuantidade(lControla) {
  //   <?php
        //   if ($db_opcao == 3) {
        //     echo "return;";
        //   }
        //
        ?>
  //   if (lControla == "true") {
  //     $("e55_quant").style.backgroundColor = "#FFFFFF";
  //     $("e55_quant").removeAttribute("readonly");
  //     $("e55_vluni").style.backgroundColor = "#DEB887";
  //     $("e55_vluni").setAttribute("readonly", true);
  //   } else {
  //     $("e55_quant").style.backgroundColor = "#DEB887";
  //     $("e55_quant").setAttribute("readonly", true);
  //     //$("e55_quant").value = 1;
  //     $("e55_vluni").style.backgroundColor = "#FFFFFF";
  //     $("e55_vluni").removeAttribute("readonly");
  //     js_calcula('uni');
  //   }
  // }

  // <?
      // if (isset($incluir) || isset($alterar) || isset($excluir)) {

      //   echo "\n\ntop.corpo.iframe_empautidot.location.href =  'emp1_empautidottaxatabela001.php?anulacao=true&e56_autori=$e55_autori';\n";
      // }
      //
      ?>

  // <? if (isset($numrows99) && $numrows99 > 0) { ?>
  //   codele = document.form1.pc07_codele.value;
  //   if (codele != '') {
  //     js_troca(codele);
  //   }
  // <? } ?>
</script>
