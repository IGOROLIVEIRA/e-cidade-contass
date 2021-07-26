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
            <?
            if (pg_numrows($result) == 0) {
              db_selectrecord("pc07_codele", $result_elemento, true, $db_opcao, '', '', '', '', "js_troca();");
            } else {
              db_fieldsmemory($result_elemento, 0);
              db_input('pc07_codele', 50, 0, true, 'text', 3);
            }
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

      </table>
    </fieldset>
    <div class="container">
      <table height="100%" width="400px" id="myTable" class="table table-bordered table-striped">
        <thead>
          <!-- <tr>
            <th style="text-align: center"><input type="checkbox" id="select_all" onclick="selectall()" /></th> -->
          <th></th>
          <th>Código</th>
          <th>Item</th>
          <th>Descrição</th>
          <th>Unidade</th>
          <th>Marca</th>
          <th>Serviço</th>
          <th>Qtdd</th>
          <th>Vlr. Unit.</th>
          <th>Desc. %</th>
          <th>Total</th>
          </tr>
        </thead>
      </table>
    </div>
    <input name="e54_desconto" type="hidden" id="e54_desconto" value="<?php echo $e54_desconto ?>">
    <input name="salvar" type="button" id="salvar" value="salvar" onclick="js_salvar();">
    <input name="excluir" type="button" id="excluir" value="excluir" onclick="js_excluir();">
  </center>
</form>
<script>
  js_loadTable();

  function js_loadTable() {

    $('#myTable').DataTable().clear().destroy();
    var table = $('#myTable').DataTable({
      searchable: false,
      paging: false,
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
          codele: document.getElementById('pc07_codele').value,
          desconto: document.getElementById('e54_desconto').value,
          dataType: "json"
        }
      },
    });
    consultaValores();
  };

  function selectall() {
    if ($('#select_all:checked').val() === 'on') {
      //table.rows().select();
      console.log('on');
    } else {
      console.log('off');
      //table.rows().deselect();
    }
  };

  function js_salvar() {

    if (!$("input[type='checkbox']").is(':checked')) {
      alert("É necessário marcar algum item");
      return false;
    }

    if (Number($('#disponivel').val()) < Number($('#totalad').val())) {
      alert("Não há valor disponível");
      return false;
    }

    var oParam = new Object();
    oParam.action = "salvar";
    oParam.autori = $('#e55_autori').val();
    oParam.codele = $('#pc07_codele').val();
    oParam.descr = $('#e55_descr').val();
    var oDados = {};
    var aDados = [];

    $("#mytable tr").each(function() {

      if ($(this).find("input[type='checkbox']").is(":checked")) {

        oDados.id = $(this).find("td").eq(1).html();
        oDados.descr = $(this).find("td").eq(3).find("input").val();
        oDados.unidade = $(this).find("td").eq(4).find("select").val();
        oDados.marca = $(this).find("td").eq(5).find("input").val();
        oDados.servico = $(this).find("td").eq(6).find("select").val();
        oDados.qtd = $(this).find("td").eq(7).find("input").val();
        oDados.vlrunit = $(this).find("td").eq(8).find("input").val();
        oDados.desc = $(this).find("td").eq(9).find("input").val();
        oDados.total = $(this).find("td").eq(10).find("input").val();

        aDados.push(oDados);
        oDados = {};
      }
    });
    console.log(aDados);
    oParam.dados = aDados;

    $.ajax({
      type: "POST",
      url: "emp1_empautitemtaxatabela.RPC.php",
      data: oParam,
      success: function(data) {
        let response = JSON.parse(data);
        console.log(response);
        if (response.status == 0) {
          alert(response.message.urlDecode());
          return false;
        } else {
          //js_loadTable();
          alert(response.message.urlDecode());
          window.location.reload();
        }
      }
    });
  }

  function js_excluir() {

    //console.log($("input[type='checkbox']").is(':checked'));
    if (!$("input[type='checkbox']").is(':checked')) {
      alert("É necessário marcar algum item");
      return false;
    }

    var oParam = new Object();
    oParam.action = "excluir";
    oParam.autori = $('#e55_autori').val();
    var oDados = {};
    var aDados = [];

    $("#mytable tr").each(function() {

      if ($(this).find("input[type='checkbox']").is(":checked")) {

        oDados.id = $(this).find("td").eq(1).html();
        aDados.push(oDados);
        oDados = {};
      }
    });

    oParam.dados = aDados;

    $.ajax({
      type: "POST",
      url: "emp1_empautitemtaxatabela.RPC.php",
      data: oParam,
      success: function(data) {
        console.log(data);
        // parent.location.reload();
        let response = JSON.parse(data);
        alert(response.message);
        window.location.reload();
        //js_loadTable();
      }
    });
  }

  function js_mudaTabela(campo) {
    js_loadTable();
  }

  function js_servico(origem) {

    //console.log(origem.id);
    const item = origem.id.split('_');
    const id = item[1];

    //console.log($('#servico_' + id).val());
    if ($('#servico_' + id).val() == 1) {
      $('#qtd_' + id).val(1);
      $('#qtd_' + id).attr('readonly', true);
    } else {
      $('#qtd_' + id).val(0);
      $('#qtd_' + id).attr('readonly', false);
    }

  }

  function js_desconto(obj) {
    if (obj == 't') {
      $("#mytable tr").each(function() {
        //$(this).find("td:eq(7) input").style.backgroundColor = "#DEB887";
        $(this).find("td:eq(9) input").attr('readonly', true);
      });
    } else {
      $("#mytable tr").each(function() {
        //$(this).find("td:eq(7) input").style.backgroundColor = "#DEB887";
        $(this).find("td:eq(9) input").attr('readonly', false);
      });
    }
  }

  function js_calcula(origem) {

    const item = origem.id.split('_');
    const id = item[1];
    console.log(item);
    const desc = new Number($('#desc_' + id).val());
    const quant = new Number($('#qtd_' + id).val());
    const uni = new Number($('#vlrunit_' + id).val());
    const tot = new Number($('#total_' + id).val()).toFixed(2);

    conQt = 'false';


    if ($('#e54_desconto' + id).val() == 'f') {
      t = new Number((uni - (desc / 100)) * quant);
      $('#total_' + id).val(t.toFixed(2));
    } else {
      t = new Number(uni * quant);
      $('#total_' + id).val(t.toFixed(2));
    }


    if (item[0] == 'qtd' && quant != '') {
      if (isNaN(quant)) {
        $('#qtd_' + id).focus();
        return false;
      }
      if ($('#e54_desconto' + id).val() == 'f') {
        t = new Number((uni - (desc / 100)) * quant);
        $('#total_' + id).val(t.toFixed(2));
      } else {
        t = new Number(uni * quant);
        $('#total_' + id).val(t.toFixed(2));
      }
    }

    if (item[0] == 'desc' && desc != '') {
      if (isNaN(quant)) {
        $('#desc_' + id).focus();
        return false;
      }
      if ($('#e54_desconto' + id).val() == 'f') {
        t = new Number((uni - (desc / 100)) * quant);
        $('#total_' + id).val(t.toFixed(2));
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
      if ($('#e54_desconto' + id).val() == 'f') {
        t = new Number((uni - (desc / 100)) * quant);
        $('#total_' + id).val(t.toFixed(2));
      } else {
        t = new Number(uni * quant);
        $('#total_' + id).val(t.toFixed(2));
      }
    }

    // if (item[0] == "total" && conQt == 'false') {
    //   if (isNaN(tot)) {
    //     //alert("Valor total inváido!");
    //     $('#total_' + id).focus();
    //     return false;
    //   }
    //   if (quant != 0) {
    //     t = new Number(tot / quant);
    //     $('#total_' + id).val(tot);
    //     $('#vlrunit_' + id).val(t.toFixed($('#desc_' + id).val()));
    //   }
    // }
    consultaLancar();
  }

  function consultaValores() {

    var params = {
      action: 'verificaSaldoCriterio',
      e55_autori: $('#e55_autori').val(),
      cgm: <?php echo $z01_numcgm ?>,
    };

    $.ajax({
      type: "POST",
      url: "emp1_empautitemtaxatabela.RPC.php",
      data: params,
      success: function(data) {

        let totitens = JSON.parse(data);
        console.log(totitens.itens[0]);
        // let utilizado = totitens.itens[0].totalitens > 0 ? totitens.itens[0].totalitens : "0";
        // let disponivel = new Number(params.total - totitens.itens[0].totalitens) > 0 ? new Number(params.total - totitens.itens[0].totalitens) : "0";
        $('#utilizado').val(totitens.itens[0].utilizado);
        $('#disponivel').val(totitens.itens[0].saldodisponivel);
      }
    });
  }

  function consultaLancar() {
    var total = 0;
    $("#mytable tr").each(function() {
      if ($(this).find("input[type='checkbox']").is(":checked")) {
        total += Number($(this).find("td:eq(10) input").val());
        console.log('total', total);
      }
    });
    $('#totalad').val(total);
  }

  function js_troca() {
    js_loadTable();
    consultaValores();
  }

  function onlynumber(evt) {
    var theEvent = evt || window.event;
    var key = theEvent.keyCode || theEvent.which;
    key = String.fromCharCode(key);
    //var regex = /^[0-9.,]+$/;
    var regex = /^[0-9.]+$/;
    if (!regex.test(key)) {
      theEvent.returnValue = false;
      if (theEvent.preventDefault) theEvent.preventDefault();
    }
  }
</script>
