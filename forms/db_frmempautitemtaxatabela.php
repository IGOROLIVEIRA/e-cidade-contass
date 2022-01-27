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

<!-- <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
<script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script> -->

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
                        db_select('chave_tabela', $aTabFonec, true, $db_opcao, " onchange='mostrarElemento();' style='width:452;' ");
                        ?>
                    </td>
                </tr>

                <tr id = "trelemento" style="height: 20px; display: none">
                    <td nowrap title="">
                        <b>Ele. item</b>
                    </td>
                    <td>
                        <select id="pc07_codele" onchange="js_troca();">
                        </select>
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
            <span id="textocontainer"><strong>Selecione uma tabela.</strong></span>
            <div>
            
                <table style="display: none" id="myTable" class="display nowrap">
                    <thead>
                    <tr>
                        <th data-orderable="false"></th>
                        <th data-orderable="false">Código</th>
                        <th data-orderable="false">Item</th>
                        <th data-orderable="false">Descrição</th>
                        <th data-orderable="false">Unidade</th>
                        <th data-orderable="false">Marca</th>
                        <th data-orderable="false">Serviço</th>
                        <th data-orderable="false">Qtdd</th>
                        <th data-orderable="false">Vlr. Unit.</th>
                        <th data-orderable="false">Desc. %</th>
                        <th data-orderable="false">Total</th>
                        <th data-orderable="false" style="display:none;">Teste</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <br />
        <input name="e54_desconto" type="hidden" id="e54_desconto" value="<?php echo $e54_desconto ?>">
        <input name="Salvar" type="button" id="salvar" value="Salvar" onclick="js_salvar();">
        <input name="Excluir" type="button" id="excluir" value="Excluir" onclick="js_excluir();">
    </center>
</form>
<script>
    // js_troca();

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

    function js_salvar() {

        if ($('#pc07_codele').val() == '...') {
            alert("É necessário escolher um elemento");
            return false;
        }

        if (!$("input[type='checkbox']").is(':checked')) {
            alert("É necessário marcar algum item");
            return false;
        }
        let rsDisponivel;
        rsDisponivel = Number($('#disponivel').val()) - Number($('#utilizado').val());

        if (Number($('#totalad').val()) > Number($('#disponivel').val())) {
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

        oParam.dados = aDados;

        $.ajax({
            type: "POST",
            url: "emp1_empautitemtaxatabela.RPC.php",
            data: oParam,
            success: function(data) {
                let response = JSON.parse(data);
                if (response.status == 0) {
                    alert(response.message.urlDecode());
                    return false;
                } else {
                    //js_loadTable();
                    alert(response.message.urlDecode());
                    top.corpo.iframe_empautidot.location.reload();
                    // window.location.reload();
                }
            }
        });
    }

    function js_excluir() {

        if ($('#pc07_codele').val() == '...') {
            alert("É necessário escolher um elemento");
            return false;
        }

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

                let response = JSON.parse(data);
                alert(response.message);
                //top.corpo.iframe_empautitem.location.reload();
                top.corpo.iframe_empautoriza.location.reload();
                //window.location.reload();
                //js_loadTable();
            }
        });
    }

    console.log($(this).find("input[type='checkbox']"));
    function js_mudaTabela(campo) {
        js_loadTable();
    }

    function js_servico(origem) {

        const item = origem.id.split('_');
        const id = item[1];

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
        const desc = new Number($('#desc_' + id).val());
        const quant = new Number($('#qtd_' + id).val());
        const uni = new Number($('#vlrunit_' + id).val());
        //const tot = new Number($('#total_' + id).val()).toFixed(2);


        if ($('#e54_desconto').val() == 't') {
            t = new Number((uni - (uni * desc / 100)) * quant);
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
            if ($('#e54_desconto').val() == 't') {
                // alert((desc / 100));
                // alert(uni);
                // alert((uni - (desc / 100)));
                // alert(quant);
                // alert((uni - (desc / 100)) * quant);
                t = new Number((uni - (uni * desc / 100)) * quant);
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
            if ($('#e54_desconto').val() == 't') {
                t = new Number((uni - (uni * desc / 100)) * quant);
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
            if ($('#e54_desconto').val() == 't') {
                t = new Number((uni - (uni * desc / 100)) * quant);
                $('#total_' + id).val(t.toFixed(2));
            } else {
                t = new Number(uni * quant);
                $('#total_' + id).val(t.toFixed(2));
            }
        }
        consultaLancar();
    }

    function consultaValores() {

        var params = {
            action: 'verificaSaldoCriterio',
            e55_autori: $('#e55_autori').val(),
            tabela: $('#chave_tabela').val(),
            cgm: <?php echo $z01_numcgm ?>,
        };

        $.ajax({
            type: "POST",
            url: "emp1_empautitemtaxatabela.RPC.php",
            data: params,
            success: function(data) {

                let totitens = JSON.parse(data);
                $('#utilizado').val(totitens.itens.utilizado);
                $('#disponivel').val(totitens.itens.disponivel);
            }
        });
    }
    
    function mostrarElemento() {

        let select = $('#pc07_codele');
        select.html('');

        // Cria option "default"
        let defaultOpt = document.createElement('option');
        defaultOpt.textContent = 'Selecione uma opção';
        select.append(defaultOpt);

        //Busco Elementos de acordo com a tabela
        let params = {
            action: 'getElementosTabela',
            e55_autori: $('#e55_autori').val(),
            tabela: $('#chave_tabela').val(),
        };

        $.ajax({
            type: "POST",
            url: "emp1_empautitemtaxatabela.RPC.php",
            data: params,
            success: function(data) {

                let elementos = JSON.parse(data);

                if(elementos.elementos.length != 0){
                    elementos.elementos.forEach(function (oElementos, ele) {
                        let option = document.createElement('option');
                        option.value = oElementos.pc07_codele;
                        option.text = oElementos.o56_descr;
                        select.append(option);
                    })
                }else{
                    top.corpo.iframe_empautoriza.location.reload();
                }
            }
        });

        // Libera a Selecao do Elemento
        let tabela = $('#chave_tabela').val();

        if(tabela != ""){
            $('#trelemento').show();
        }
    }

    function consultaLancar() {
        var total = 0;
        $("#mytable tr").each(function() {
            if ($(this).find("input[type='checkbox']").is(":checked")) {
                total += Number($(this).find("td:eq(10) input").val());
            }
        });
        $('#totalad').val(total);
    }

    function js_troca() {
        if (document.getElementById('pc07_codele').value == '...') {
            $('#textocontainer').css("display", "inline");
            $('#myTable').DataTable().clear().destroy();
            $('#myTable').css("display", "none");
            $('#salvar').css("display", "none");
            $('#excluir').css("display", "none");
        } else {
            $('#textocontainer').css("display", "none");
            $('#myTable').css("display", "inline");
            $('#salvar').css("display", "inline");
            $('#excluir').css("display", "inline");
            js_loadTable();
        }
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
    $(document).ready(function() {
        $('input[type="text"]').each(function() {
            var val = $(this).val().replace(',', '.');
            $(this).val(val);
        });
    });
</script>
