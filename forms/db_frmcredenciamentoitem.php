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
        <div class="container">
            <span id="textocontainer"><strong>Selecione uma tabela.</strong></span>
            <div>
                <table style="display: none" id="myTable" class="display nowrap">
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
        <input name="e54_desconto" type="hidden" id="e54_desconto" value="<?php echo $e54_desconto ?>">
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
                    fornecedor: <?php echo $z01_numcgm ?>,
                    dataType: "json"
                }
            },
        });
    };
    js_loadTable();
</script>
