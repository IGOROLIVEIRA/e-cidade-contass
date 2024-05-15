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
require_once("classes/db_credenciamentotermo_classe.php");

$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clempparametro         = new cl_empparametro;
$clpctabelaitem         = new cl_pctabelaitem;
$clpcmaterele           = new cl_pcmaterele;
$clempautitem           = new cl_empautitem;
$clcredenciamentotermo  = new cl_credenciamentotermo;

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
    <center>
        <fieldset style="margin-top:5px; width:45%;">
            <legend><b>Elemento dos Itens</b></legend>
            <table border="0" cellpadding='0' cellspacing='0'>
                <tr id="trelemento" style="height: 20px; display: none">
                    <td nowrap title="">
                        <b>Elemento do item: </b>
                    </td>
                    <td>
                        <select id="pc07_codele" onchange="js_troca();">
                        </select>
                    </td>
                </tr>
            </table>
        </fieldset>
        <div class="container">
    <div>
        <!-- Tabela de itens -->
        <table id="myTable" style="display: none" class="display nowrap">
            <!-- Cabeçalho da tabela -->
            <thead>
                <tr>
                    <!-- Cabeçalhos das colunas -->
                    <th data-orderable="false"></th>
                    <th data-orderable="false">Ordem</th>
                    <th data-orderable="false">Item</th>
                    <th data-orderable="false">Descrição Item</th>
                    <th data-orderable="false">Unidade</th>
                    <th data-orderable="false">Quantidade Disponivel</th>
                    <th data-orderable="false">Valor Disponivel</th>
                    <th data-orderable="false">Vl. Unitário</th>
                    <th data-orderable="false">Qtd. Solicitada</th>
                    <th data-orderable="false">Vlr. Total.</th>
                    <th data-orderable="false" style="display: none;">Serviço Quantidade.</th>
                </tr>
            </thead>
        </table>
            <div class="text" style="text-align: right;">
                <div id="total_container" style="display: none;">
                    <label for="total"><strong>Valor Total:</strong></label>
                    <input type="text" id="total" readonly style="width: 80px; margin-top: 5px; margin-right: 28px;">
                </div>
            </div>
        
    </div>
        
</div>
        <br />
        <input name="Salvar" type="button" id="salvar" value="Salvar" onclick="js_salvar();">
        <input name="Excluir" type="button" id="excluir" value="Excluir" onclick="js_excluir();">
    </center>
</form>
<script>
    function js_loadTable() {

        $('#myTable').DataTable().clear().destroy();
        var table = $('#myTable').DataTable({
            bAutoWidth: false,
            bInfo: false,
            searchable: false,
            paging: false,
            processing: true,
            serverSide: true,
            scrollY: "200px",
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
            ajax: {
                url: "emp1_empautitemcredenciamentotermo.RPC.php",
                type: "POST",
                data: {
                    action: 'buscaItens',
                    autori: <?php echo $e55_autori ?>,
                    licitacao: <?php echo $e54_codlicitacao ?>,
                    codele: document.getElementById('pc07_codele').value,
                    fornecedor: <?php echo $z01_numcgm ?>,
                    dataType: "json"
                }
            },
        });
    };

    function mostrarElemento() {

        let select = $('#pc07_codele');
        select.html('');

        // Cria option "default"
        let defaultOpt = document.createElement('option');
        defaultOpt.textContent = 'Selecione uma opção';
        select.append(defaultOpt);

        //Busco Elementos de acordo com a tabela
        let params = {
            action: 'getElementos',
            e55_autori: <?= $e55_autori ?>,
            e54_numcgm: <?= $z01_numcgm ?>,
            e54_codlicitacao: <?= $e54_codlicitacao ?>,
        };

        $.ajax({
            type: "POST",
            url: "emp1_empautitemcredenciamentotermo.RPC.php",
            data: params,
            success: function(data) {

                let elementos = JSON.parse(data);
                if (elementos.elementos.length != 0) {
                    elementos.elementos.forEach(function(oElementos, ele) {
                        let option = document.createElement('option');
                        option.value = oElementos.o56_elemento;
                        option.text = oElementos.o56_descr.urlDecode();
                        select.append(option);
                    })
                } else {
                    top.corpo.iframe_empautoriza.location.reload();
                }
            }
        });

        // Libera a Selecao do Elemento
        let tabela = $('#chave_tabela').val();

        if (tabela != "") {
            $('#trelemento').show();
        }
    }
    mostrarElemento();

    function js_troca() {
    if (document.getElementById('pc07_codele').value !== '...') {
      document.getElementById("myTable").style.display = "";
      document.getElementById("total_container").style.display = "";
      document.getElementById("salvar").disabled = false;
      document.getElementById("excluir").disabled = false;
      js_loadTable();
      document.getElementById("total").value = calculateTotal(); 
    } else {

      document.getElementById("myTable").style.display = "none";
      document.getElementById("total_container").style.display = "none";
      document.getElementById("salvar").disabled = true;
      document.getElementById("excluir").disabled = true;
    }
}
    

function js_calcula(id) {
    const quant = parseFloat($('#qtd_' + id).val()); // Obter a nova quantidade
    const vlun = parseFloat($('#vlr_' + id).val()); // Obter o valor unitário

    if (!isNaN(quant) && !isNaN(vlun)) { // Verificar se os valores são válidos
        const t = vlun * quant;
        $('#total_' + id).val(t.toFixed(2));

        // Atualizar o valor total geral independentemente do estado do checkbox
        atualizarTotalGeral();
    }
}


// Adicionar evento de mudança para os campos de quantidade
$(document).on('change', 'input[id^="qtd_"]', function() {
    const id = this.id.split('_')[1]; // Obter o ID do item
    js_calcula(id); // Chamar a função js_calcula() ao alterar a quantidade
});

function js_calculaVrUnit(origem) {
    const item = origem.id.split('_');
    const id = item[1];
    let quant = parseFloat($('#qtddisponivel_' + id).val());
    const vlun = parseFloat($('#vlr_' + id).val());

    if (isNaN(quant)) { // Verificar se a quantidade é um número válido
        quant = 0; // Definir a quantidade como 0 se não for um número válido
    }

    // Calcular o novo valor total e atualizar os campos
    const total = vlun * quant;
    $('#qtd_' + id).val(quant.toFixed(2));
    $('#total_' + id).val(total.toFixed(2));

    // Atualizar o valor total geral
    atualizarTotalGeral();
}


// Adicionar evento de mudança para os campos de valor unitário somente se o item estiver marcado
$(document).on('input', 'input[id^="vlr_"], input[id^="qtd_"]', function() {
    // Captura o ID do item a partir do ID do campo de entrada
    let id = $(this).attr('id').replace('vlr_', '').replace('qtd_', '');

    // Verifica se o item está marcado
    let isChecked = $('#checkbox_' + id).is(':checked');

    // Se o item estiver marcado, ou se a mudança foi em um campo de quantidade
    if (isChecked || $(this).is('input[id^="qtd_"]')) {
        // Obtém o valor unitário atual do item
        let valorUnitarioAtual = parseFloat($('#vlr_' + id).val());

        // Obtém a quantidade atual do item
        let quant = parseFloat($('#qtd_' + id).val());

        // Verifica se o valor unitário e a quantidade são números válidos
        if (!isNaN(valorUnitarioAtual) && !isNaN(quant)) {
            // Calcula o novo valor total
            let novoTotal = quant * valorUnitarioAtual;

            // Atualiza o campo de entrada do valor total para o item
            $('#total_' + id).val(novoTotal.toFixed(2));

            // Atualiza o valor total geral
            atualizarTotalGeral();
        }
    }
});






    function js_salvar() {

        if (!$("input[type='checkbox']").is(':checked')) {
            alert("É necessário marcar algum item");
            return false;
        }

        // let rsDisponivel;
        // rsDisponivel = Number($('#disponivel').val()) - Number($('#utilizado').val());
        //
        // if (Number($('#totalad').val()) > Number($('#disponivel').val())) {
        //     alert("Não há valor disponível");
        //     return false;
        // }

        var oParam = new Object();
        oParam.action = "salvar";
        oParam.autori = <?= $e55_autori ?>;
        oParam.fornecedor = <?= $z01_numcgm ?>;
        oParam.licitacao = <?= $e54_codlicitacao ?>;
        oParam.codele = $('#pc07_codele').val();
        var oDados = {};
        var aDados = [];

        $("#mytable tr").each(function() {

            if ($(this).find("input[type='checkbox']").is(":checked")) {
                var qtdDisponivel = $(this).find("td").eq(5).find("input").val();
                var qtdSolicitada = $(this).find("td").eq(8).find("input").val();
                var vlrDisponivel = $(this).find("td").eq(6).find("input").val();
                var vlrSolicitado = $(this).find("td").eq(7).find("input").val();

                if(Number(vlrSolicitado) <= 0){
                    alert('Vlr. Solicitado deve ser maior que Zero!');
                    return false;
                }

                if(Number(qtdSolicitada) <= 0){
                    alert('Qtd. Solicitada deve ser maior que Zero!');
                    return false;
                }

                if (Number(vlrSolicitado) > Number(vlrDisponivel)) {
                    alert('Vlr. Solicitado maior que a Vlr. Disponível!');
                    return false;
                }

                if (Number(qtdSolicitada) > Number(qtdDisponivel)) {
                    alert('Qtd. Solicitada maior que a Qtd. Disponível!');
                    return false;
                }
                oDados.id = $(this).find("td").eq(2).html();
                oDados.unidade = $(this).find("td").eq(4).find("select").val();
                oDados.vlrunit = $(this).find("td").eq(7).find("input").val();
                oDados.qtd = $(this).find("td").eq(8).find("input").val();
                oDados.total = $(this).find("td").eq(9).find("input").val();
                oDados.servicoquantidade = $(this).find("td").eq(10).find("input").val();

                aDados.push(oDados);
                oDados = {};
            }
        });

        oParam.dados = aDados;
        $.ajax({
            type: "POST",
            url: "emp1_empautitemcredenciamentotermo.RPC.php",
            data: oParam,
            success: function(data) {
                let response = JSON.parse(data);
                if (response.status == 0) {
                    alert(response.message.urlDecode());
                    return false;
                } else {
                    alert(response.message.urlDecode());
                }
            }
        });
    }

    function js_excluir() {

        if (!$("input[type='checkbox']").is(':checked')) {
            alert("É necessário marcar algum item");
            return false;
        }

        var oParam = new Object();
        oParam.action = "excluir";
        oParam.autori = <?= $e55_autori ?>;
        oParam.fornecedor = <?= $z01_numcgm ?>;
        oParam.licitacao = <?= $e54_codlicitacao ?>;
        oParam.codele = $('#pc07_codele').val();
        var oDados = {};
        var aDados = [];

        $("#mytable tr").each(function() {

            if ($(this).find("input[type='checkbox']").is(":checked")) {

                oDados.id = $(this).find("td").eq(2).html();
                aDados.push(oDados);
                oDados = {};
            }
        });

        oParam.dados = aDados;

        $.ajax({
            type: "POST",
            url: "emp1_empautitemcredenciamentotermo.RPC.php",
            data: oParam,
            success: function(data) {

                let response = JSON.parse(data);
                alert(response.message);
                top.corpo.iframe_empautoriza.location.reload();
            }
        });
    }
    

    function js_somaTotal(linha) {
    let total = 0;

    // Percorre todos os campos de checkbox para calcular o novo total
    $('input[id^="checkbox_"]:checked').each(function() {
        let id = $(this).attr('id').replace('checkbox_', '');
        let valortotal = parseFloat($('#total_' + id).val()); // Obter o valor total do item
        if (!isNaN(valortotal)) {
            total += valortotal; // Adicionar ao total apenas se o item estiver marcado
        }
    });

    document.getElementById('total').value = total.toFixed(2);
}

// Adicionar evento de mudança para os campos de quantidade e valor unitário
$(document).on('input', 'input[id^="qtd_"], input[id^="vlr_"]', function() {
    // Captura o ID do item a partir do ID do campo de entrada
    let id = $(this).attr('id').split('_')[1];

    // Obtém o valor unitário atual do item
    let valorUnitarioAtual = parseFloat($('#vlr_' + id).val());

    // Obtém a quantidade atual do item
    let quant = parseFloat($('#qtd_' + id).val());

    // Verifica se o valor unitário e a quantidade são números válidos
    if (!isNaN(valorUnitarioAtual) && !isNaN(quant)) {
        // Calcula o novo valor total
        let novoTotal = quant * valorUnitarioAtual;

        // Atualiza o campo de entrada do valor total para o item
        $('#total_' + id).val(novoTotal.toFixed(2));

        // Atualiza o valor total geral
        atualizarTotalGeral();
    }
});

function atualizarTotalGeral() {
    let totalGeral = 0;

    // Percorre todos os campos de valor total dos itens
    $('input[id^="total_"]').each(function() {
        let id = $(this).attr('id').split('_')[1];
        let isChecked = $('#checkbox_' + id).is(':checked');

        // Verifica se o item está marcado antes de adicionar ao total geral
        if (isChecked) {
            let valorTotalItem = parseFloat($(this).val());

            if (!isNaN(valorTotalItem)) {
                totalGeral += valorTotalItem;
            }
        }
    });

    // Atualiza o campo de entrada do valor total geral
    $('#total').val(totalGeral.toFixed(2));
}











</script>