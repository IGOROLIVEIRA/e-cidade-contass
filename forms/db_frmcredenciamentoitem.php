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
                <tr id = "trelemento" style="height: 20px; display: none">
                    <td nowrap title="">
                        <b>Elemento dos item:  </b>
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
                <table id="myTable" style="display: none" class="display nowrap">
                    <thead>
                    <tr>
                        <th data-orderable="false"></th>
                        <th data-orderable="false">Ordem</th>
                        <th data-orderable="false">Item</th>
                        <th data-orderable="false">Descrição Item</th>
                        <th data-orderable="false">Unidade</th>
                        <th data-orderable="false">Quantidade Disponivel</th>
                        <th data-orderable="false">Vl. Unitário</th>
                        <th data-orderable="false">Qtd. Solicitada</th>
                        <th data-orderable="false">Vlr. Total.</th>
                    </tr>
                    </thead>
                </table>
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
            e55_autori: <?= $e55_autori?>,
            e54_numcgm: <?= $z01_numcgm?>,
            e54_codlicitacao: <?= $e54_codlicitacao?>,
        };

        $.ajax({
            type: "POST",
            url: "emp1_empautitemcredenciamentotermo.RPC.php",
            data: params,
            success: function(data) {

                let elementos = JSON.parse(data);
                if(elementos.elementos.length != 0){
                    elementos.elementos.forEach(function (oElementos, ele) {
                        let option = document.createElement('option');
                        option.value = oElementos.pc07_codele;
                        option.text = oElementos.o56_descr.urlDecode();
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
    mostrarElemento();
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

    function js_calcula(origem) {

        const item = origem.id.split('_');
        const id = item[1];
        const quant = new Number($('#qtd_' + id).val());
        const vlun = new Number($('#vlr_' + id).val());
        // $('checkbox_'+ id).attr("checked",true);
        t = new Number(vlun * quant);
        $('#total_' + id).val(t.toFixed(2));
    }

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
        oParam.autori = <?= $e55_autori?>;
        oParam.fornecedor = <?= $z01_numcgm?>;
        oParam.licitacao = <?= $e54_codlicitacao?>;
        oParam.codele = $('#pc07_codele').val();
        var oDados = {};
        var aDados = [];

        $("#mytable tr").each(function() {

            if ($(this).find("input[type='checkbox']").is(":checked")) {
                var qtdDisponivel = $(this).find("td").eq(5).find("input").val();
                console.log(qtdDisponivel);
                var qtdSolicitada = $(this).find("td").eq(7).find("input").val();
                console.log(qtdSolicitada);

                if(qtdSolicitada > qtdDisponivel){
                    alert('Quantidade não disponivel');
                    return false;
                }
                oDados.id = $(this).find("td").eq(2).html();
                oDados.unidade = $(this).find("td").eq(4).find("select").val();
                oDados.vlrunit = $(this).find("td").eq(6).find("input").val();
                oDados.qtd = $(this).find("td").eq(7).find("input").val();
                oDados.total = $(this).find("td").eq(8).find("input").val();

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
        oParam.autori = <?= $e55_autori?>;
        oParam.fornecedor = <?= $z01_numcgm?>;
        oParam.licitacao = <?= $e54_codlicitacao?>;
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
    
    function js_verificadisponivel() {

    }

</script>
