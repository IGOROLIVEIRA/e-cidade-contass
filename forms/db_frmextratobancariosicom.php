<?
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
$clrotulo = new rotulocampo;
$clrotulo->label("k13_dtvlr");
$clrotulo->label("k13_conta");

$dados = "ordem";
require_once("std/db_stdClass.php");
$iTipoControleRetencaoMesAnterior = 0;
$lUsaData = true;
// Carregando as contas
$sSql = "select
            saltes.k13_reduz,
            saltes.k13_descr,
            c63_banco,
            c63_agencia,
            c63_dvagencia,
            c63_conta,
            c63_dvconta,
            case
                when contabancaria.db83_tipoconta = 1 then 'Corrente'
                when contabancaria.db83_tipoconta = 2 then 'Poupança'
                when contabancaria.db83_tipoconta = 3 then 'Aplicação'
                when contabancaria.db83_tipoconta = 4 then 'Salário'
            end as tipo,
            CASE WHEN k13_limite IS NULL
                THEN 'SIM'
                ELSE 'NAO'
            END ativa
            from
            saltes
            inner join conplanoreduz on conplanoreduz.c61_reduz = saltes.k13_reduz
            and c61_anousu = 2021
            inner join conplanoexe on conplanoexe.c62_reduz = conplanoreduz.c61_reduz
            and c61_anousu = c62_anousu
            inner join conplano on conplanoreduz.c61_codcon = conplano.c60_codcon
            and c61_anousu = c60_anousu
            left join conplanoconta on conplanoconta.c63_codcon = conplanoreduz.c61_codcon
            and conplanoconta.c63_anousu = conplanoreduz.c61_anousu
            left join conplanocontabancaria on c60_codcon = c56_codcon
            and c60_anousu = 2021
            left join contabancaria on c56_contabancaria = db83_sequencial
            where
            c61_instit = " . db_getsession('DB_instit') . "
            and c62_anousu = " . db_getsession('DB_anousu') . "
            and (k13_limite IS NULL OR k13_limite BETWEEN '" . db_getsession('DB_anousu') . "-01-01' AND '" . db_getsession('DB_anousu') . "-12-31')";
$rsResult = db_query($sSQL);
// Carrega os scripts
db_app::load("scripts.js");
db_app::load("prototype.js");
db_app::load("datagrid.widget.js");
db_app::load("strings.js");
db_app::load("grid.style.css");
db_app::load("estilos.css");
db_app::load("AjaxRequest.js");
db_app::load("widgets/windowAux.widget.js");
?>
<style type="text/css">
    #tabela-lancamentos {
        border-collapse: collapse;
        width: 98%;
        margin: 10px;
        border: 1px solid black;
    }
    #tabela-lancamentos tr {
        background-color: #fff;
    }
    #tabela-lancamentos td, #tabela-lancamentos th {
        padding: 5px;
        border: 1px solid #ddd;
}

#tabela-lancamentos tr:hover {background-color: #6a6a6a;}

#tabela-lancamentos th {

  text-align: left;
  background-color: #D3D3D3;
  font-weight: bold;
    color: #000;
}
    .pesquisaConta {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: none;
        overflow-y:auto;
        overflow-x: hidden;
        position: absolute;
        max-height: 200px;
    }

    .pesquisaConta li {
        border: 1px solid #ddd;
        margin-top: -1px;  /*Prevent double borders */
        background-color: #f6f6f6;
        padding: 10px;
        text-decoration: none;
        color: black;
        display: block
    }

    .pesquisaConta li:hover:not(.header) {
        background-color: #eee;
    }

    .codtipo {
        display: none;
    }

    .ctapag {
        width: 100%;
    }
</style>
<script>
    function js_mascara(evt){
        var evt = (evt) ? evt : (window.event) ? window.event : "";

        if((evt.charCode >46 && evt.charCode <58) || evt.charCode ==0){//8:backspace|46:delete|190:.
            return true;
        }else{
            return false;
        }
    }
</script>
<BR><BR>

<form name="form1" method="post" action="">
    <center>
        <table  border =0 style='width:90%'>
            <tr>
                <td>
                    <fieldset>
                        <legend><b>Extratos Bancários Sicom</b></legend>
                        <table width="100%">
                            <tr>
                            <div class='grid_planilha' id='grid_planilha' style='margin: 0 auto; width: 100%; text-align: center'>
                                <table id='tabela-lancamentos'>
                                    <thead>
                                        <tr>
                                            <th>Código CTB</th>
                                            <th>Descrição</th>
                                            <th>Banco</th>
                                            <th>Agência</th>
                                            <th>Conta</th>
                                            <th>Tipo</th>
                                            <th>Ativa</th>
                                            <th>Anexo</th>
                                            <th>Situação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                        db_utils::fieldsMemory($rsResult, 0)->c99_data ? date("d/m/Y", strtotime(db_utils::fieldsMemory($rsResult, 0)->c99_data)) : "";

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>
        </table>
    </form>
</center>
<div style='position:absolute;top: 200px; left:15px;
            border:1px solid black;
            width:300px;
            text-align: left;
            padding:3px;
            background-color: #FFFFCC;
            display:none;' id='ajudaItem'>

</div>
<div id='teste'></div>
<script>
    var encerramento_contabil = "<?=$encerramentoContabil?>";
    var dados_complementares_numcgm = new Array();
    var dados_complementares_coddoc = new Array();
    var dados_complementares_oprecslip = new Array();
    var dados_complementares_documento = new Array();
    var dados_complementares_valor_individual = new Array();
    var iZerarSaldoFinalExtrato = 0;

    // ----------------------------------------
    // Função verificadas
    js_reset();
    js_verifica_campos();
    js_init();

    function js_pesquisak13_conta(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_saltes', 'func_saltes.php?funcao_js=parent.js_preenche_k13_conta|k13_conta|k13_descr','Pesquisa', true);
        } else {
            if(document.form1.k13_conta.value != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_saltes', 'func_saltes.php?pesquisa_chave=' + document.form1.k13_conta.value + '&funcao_js=parent.js_preenche_k13_descr', 'Pesquisa', false);
            } else {
                document.form1.k13_conta.value = '';
            }
        }
    }

    function js_preenche_k13_descr(k13_descr, erro) {
        document.form1.k13_descr.value = k13_descr;
        if (erro == true) {
            document.form1.k13_conta.focus();
            document.form1.k13_conta = '';
        } else {
            js_verifica_campos();
        }
    }

    function js_preenche_k13_conta(k13_conta, k13_descr) {
        document.form1.k13_conta.value = k13_conta;
        document.form1.k13_descr.value = k13_descr;
        js_verifica_campos();
        db_iframe_saltes.hide();
    }

    document.form1.saldo_final_extrato.addEventListener('change', js_registraSaldoExtrato);

    function js_registraSaldoExtrato() {
        oParam                      = new Object();
        oParam.conta                = document.form1.k13_conta.value;
        oParam.data_final           = document.form1.data_final.value;
        oParam.saldo_final_extrato  = document.form1.saldo_final_extrato.value;

        var sParam  = js_objectToJson(oParam);
        var sJson   = '{"exec": "RegistrarSaldoExtrato", "params": ['+ sParam + ']}';
        var oAjax   = new Ajax.Request('cai4_conciliacaoBancariaNovo.RPC.php',
            {
                method    : 'post',
                parameters: 'json=' + sJson
            }
        );
        js_atualizar_diferenca();
    }

    function js_verifica_campos() {
        if (document.form1.data_inicial.value == "" || document.form1.data_final.value == "") {
            js_libera_botoes(false);
            return;
        }

        if (!js_verifica_datas())
            return false;

        if (!js_verifica_conta())
            return false;
    }

    function js_verifica_datas() {
        var dataInicial = js_formatar_data_reversa(document.form1.data_inicial.value);
        var dataFinal   = js_formatar_data_reversa(document.form1.data_final.value);

        if (dataInicial > dataFinal) {
            alert("Data Final inferior a Data Inicial!");
            document.form1.data_final.value = '';
            document.form1.data_final.focus();
            return false;
        }
        return true;
    }

    function js_formatar_data_reversa(data) {
        return new Date(data.split('/').reverse().join('/'));
    }

    function js_verifica_conta() {
        if (document.form1.k13_conta.value == "" || document.form1.k13_descr.value == "") {
            js_libera_botoes(false);
            return false;
        }

        js_busca_extrato();
        gridLancamentos.clearAll(true);
        document.form1.data_conciliacao.value = document.form1.data_final.value;
        js_libera_botoes(true, 'pesquisar');
        return true;
    }

    function js_libera_botoes(liberar, botao = null) {
        if (botao) {
            if (liberar) {
                $(botao).disabled = false;
            } else {
                $(botao).disabled = true;
            }
        }
        if (liberar) {
            $('pesquisar').disabled = false;
            $('atualizar').disabled = false;
            $('tipo_movimento').disabled = false;
            $('tipo_lancamento').disabled = false;
            $('data_conciliacao').disabled = false;
            $('saldo_final_extrato').disabled = false;
            $('desprocessar').disabled = false;
            $('emitir_capa').disabled = false;
            $('incluir_pendencias').disabled = false;
            $('nova_conciliacao').disabled = false;
        } else {
            $('pesquisar').disabled = true;
            $('atualizar').disabled = true;
            $('tipo_movimento').disabled = true;
            $('tipo_lancamento').disabled = true;
            $('data_conciliacao').disabled = true;
            $('saldo_final_extrato').disabled = true;
            $('desprocessar').disabled = true;
            $('emitir_capa').disabled = true;
            $('incluir_pendencias').disabled = true;
            $('nova_conciliacao').disabled = true;
        }
    }

    function js_busca_extrato() {
        oParam                = new Object();
        oParam.conta          = document.form1.k13_conta.value;
        oParam.data_inicial   = document.form1.data_inicial.value;
        oParam.data_final     = document.form1.data_final.value;
        var sParam = js_objectToJson(oParam);
        var url = 'cai4_conciliacaoBancariaNovo.RPC.php';
        var sJson = '{"exec": "getDadosExtrato", "params": ['+ sParam + ']}';
        var oAjax = new Ajax.Request(url,
            {
                method    : 'post',
                parameters: 'json=' + sJson,
                onComplete: js_retorno_dados_extrato
            }
        );
    }

    function js_retorno_dados_extrato(oAjax) {
        // console.log(oAjax);
        var oResponse = eval("(" + oAjax.responseText + ")");
        // console.log(oResponse);
        if (oResponse.status == 1) {
            // console.log(oResponse.aLinhasExtrato);
            for (var i = 0; i < oResponse.aLinhasExtrato.length; i++) {
                // console.log(oResponse.aLinhasExtrato[i]);
                with (oResponse.aLinhasExtrato[i]) {
                    var conciliado = parseFloat(saldo_anterior) - parseFloat(total_entradas) + parseFloat(total_saidas);
                    // console.log("Query da Entrada: " + total_entradas);
                    document.form1.saldo_inicial_tesouraria.value = js_formatar(saldo_anterior, "f");
                    document.form1.total_entradas.value           = js_formatar(total_entradas, "f");
                    document.form1.total_saidas.value             = js_formatar(total_saidas, "f");
                    document.form1.saldo_conciliado.value         = js_formatar(conciliado, "f");
                    if (iZerarSaldoFinalExtrato == 0) {
                        document.form1.saldo_final_extrato.value = valor_conciliado;
                    }
                    iZerarSaldoFinalExtrato = 0;
                    js_atualizar_diferenca();
                }
            }
        }
    }

    function js_atualizar_diferenca() {
        var conciliado  = js_valor_reverso(document.form1.saldo_conciliado.value);
        var saldo_final = js_valor_reverso(document.form1.saldo_final_extrato.value);
        document.form1.diferenca.value = js_formatar(conciliado - saldo_final, "f");
    }

    function js_valor_reverso(valor) {
        if (valor.indexOf(",") >= 0) {
            valor = valor.replaceAll(".", "").replace(",", ".");
        }
        return parseFloat(valor);
    }

    function js_pesquisar_lancamentos() {
        js_divCarregando("Aguarde, pesquisando Lançamentos.", "msgBox");
        js_libera_botoes(false);
        js_busca_extrato();

        oParam = new Object();
        oParam.conta = document.form1.k13_conta.value;
        oParam.data_inicial = document.form1.data_inicial.value;
        oParam.data_final = document.form1.data_final.value;
        oParam.tipo_lancamento = document.form1.tipo_lancamento.value;
        oParam.tipo_movimento  = document.form1.tipo_movimento.value;
        document.form1.total_selecionado.value = "0.00";

        var sParam = js_objectToJson(oParam);
        url = 'cai4_conciliacaoBancariaNovo.RPC.php';
        var sJson = '{"exec": "getLancamentos", "params": ['+ sParam + ']}';
        var oAjax = new Ajax.Request(url,
            {
                method    : 'post',
                parameters: 'json=' + sJson,
                onComplete: js_retorno_consulta_lancamentos
            }
        );
    }

    function js_retorno_consulta_lancamentos(oAjax) {
        js_removeObj("msgBox");
        js_libera_botoes(true);
        // console.log(oAjax);
        var oResponse = eval("(" + oAjax.responseText + ")");
        var iRowAtiva     = 0;
        var iTotalizador  = 0;
        console.log(oResponse);
        gridLancamentos.clearAll(true);
        gridLancamentos.setStatus("");

        if (oResponse.status == 1) {
            for (var iNotas = 0; iNotas < oResponse.aLinhasExtrato.length; iNotas++) {
                // console.log(oResponse.aLinhasExtrato[iNotas]);
                with (oResponse.aLinhasExtrato[iNotas]) {
                    var nValor = valor;
                    var lDisabled = false;
                    var lDisabledContaFornecedor = false;
                    var sDisabled = "";

                    if (nValor == 0) {
                        continue;
                    }

                    iTotalizador++;

                    var aLinha  = new Array();
                    aLinha[0] = iNotas + 1;
                    aLinha[1] = data_lancamento;
                    aLinha[2] = data_conciliacao;
                    aLinha[3] = credor;
                    aLinha[4] = tipo;
                    if (agrupado) {
                        aLinha[5] = ''
                        if (documento != 0) {
                            aLinha[6] = documento[0];
                        } else {
                            aLinha[6] = '';
                        }
                    } else {
                        aLinha[5] = op_rec_slip;
                        if (documento != 0) {
                            aLinha[6] = documento;
                        } else {
                            aLinha[6] = '';
                        }
                    }
                    var color = 'red';
                    if (movimento == 'E')
                        color = 'blue';
                    aLinha[7] = "<span style='color:" + color + "'>" + movimento + '</span>';
                    aLinha[8] = "<span style='color:" + color + "'>" + js_formatar(nValor, "f") + '</span>';
                    aLinha[9] = historico;

                    dados_complementares_numcgm[iNotas + 1]           = numcgm;
                    dados_complementares_coddoc[iNotas + 1]           = cod_doc;
                    dados_complementares_oprecslip[iNotas + 1]        = op_rec_slip;
                    dados_complementares_documento[iNotas + 1]        = documento;
                    dados_complementares_valor_individual[iNotas + 1] = valor_individual;

                    gridLancamentos.addRow(aLinha, false, lDisabled);

                    /*
                    document.getElementById("configuradas").checked = true;
                    document.getElementById("normais").checked = true;
                    document.getElementById("comMovs").checked = true;
                    */

                    js_linha_pendencia(iNotas, tipo_lancamento);
                    js_linha_conciliada(iNotas, data_conciliacao);

                    iRowAtiva++;
                }
            }
            gridLancamentos.renderRows();
            gridLancamentos.setNumRows(iTotalizador);
            // Bloco de conferencia do filtro
            js_showFiltro("conciliado", document.getElementById("configuradas").checked);
            js_showFiltro("normal", document.getElementById("normais").checked);
            js_showFiltro("pendente", document.getElementById("comMovs").checked);
            $('gridLancamentosstatus').innerHTML = "&nbsp;<span style='color:blue' id ='total_selecionados'>0</span> Selecionados";
        } else if (oResponse.status == 2) {
            gridLancamentos.setStatus("<b>Não foram encontrados movimentos.</b>");
        }
    }

    function js_linha_conciliada(row, data_conciliacao) {
        if (data_conciliacao != '')
            gridLancamentos.aRows[row].setClassName('conciliado');
    }

    function js_linha_pendencia(row, lancamento) {
    	if (lancamento > 0)
    		gridLancamentos.aRows[row].setClassName('pendente');
    }

   function js_showFiltro(sQualFiltro, lMostrar) {
        var aMatched = gridLancamentos.getElementsByClass(sQualFiltro);
        aMatched = aMatched.concat(gridLancamentos.getElementsByClass(sQualFiltro + "marcado"));
        var iTotalizador = 0;
        for (var i = 0; i < aMatched.length; i++) {
            if (lMostrar) {
                aMatched[i].style.display = '';
                iTotalizador++;
            } else {
                aMatched[i].style.display = 'none';
                iTotalizador--;
            }
        }
        var iTotal  = gridLancamentos.getNumRows();
        gridLancamentos.setNumRows(iTotal +iTotalizador);
    }

    function js_init() {
        document.form1.total_selecionado.value = "0.00";
        gridLancamentos = new DBGrid("gridLancamentos");
        gridLancamentos.nameInstance = "gridLancamentos";
        var alertError = false;

        gridLancamentos.selectSingle = function(oCheckbox, sRow, oRow, lVerificaSaldo, bSelectAll) {
            var limpar = true;
            var valor = document.form1.total_selecionado.value.replace('.', '');
            valor = valor.replace(',', '.');
            valor = parseFloat(valor);

            if (js_comparadata($F("data_conciliacao"), oRow.aCells[2].getValue(), "<")) {
                if (!alertError) {
                    var alertMensagem = "Lançamento com data superior a data da conciliação!";
                    if (bSelectAll)
                        alertMensagem = "Um ou mais Lançamentos com data superior a data da conciliação!";
                    alert(alertMensagem);
                    alertError = bSelectAll;
                }
                oCheckbox.checked = false;
                limpar = false;
                return false;
            }

            if (oCheckbox.checked) {
                oRow.isSelected = true;
                $(sRow).className += ' marcado';
                $('total_selecionados').innerHTML = new Number($('total_selecionados').innerHTML) + 1;

                // if (oRow.aCells[3].getValue().length == 1) {
                    if (oRow.aCells[8].getValue() == 'E')
                        valor += parseFloat(oRow.aCells[9].getValue().replace(".", "").replace(",", "."));
                    else
                        valor -= parseFloat(oRow.aCells[9].getValue().replace(".", "").replace(",", "."));
                // }
            } else {
                if (limpar) {
                    $(sRow).className = oRow.getClassName();
                    oRow.isSelected = false;
                    $('total_selecionados').innerHTML = new Number($('total_selecionados').innerHTML) - 1;

                    // f (oRow.aCells[3].getValue().length == 1) {
                        if (oRow.aCells[8].getValue() == 'S')
                            valor = parseFloat(valor) + parseFloat(oRow.aCells[9].getValue().replace(".", "").replace(",", "."));
                        else
                            valor = parseFloat(valor) - parseFloat(oRow.aCells[9].getValue().replace(".", "").replace(",", "."));
                    // }
                }
            }
            document.form1.total_selecionado.value = js_formatar(valor.toFixed(2), "f");
        }

        gridLancamentos.selectAll = function(idObjeto, sClasse, sLinha) {
            var obj = document.getElementById(idObjeto);

            if (obj.checked){
                obj.checked = false;
            } else{
                obj.checked = true;
            }

            itens = this.getElementsByClass(sClasse);
            for (var i = 0;i < itens.length; i++) {
                if (itens[i].disabled == false) {
                    if (obj.checked == true) {
                        if ($(this.aRows[i].sId).style.display != 'none') {
                            if (!itens[i].checked) {
                                itens[i].checked=true;
                                this.selectSingle($(itens[i].id), (sLinha+i), this.aRows[i], false, true);
                            }
                        }
                    } else {
                        if (itens[i].checked) {
                            itens[i].checked=false;
                            this.selectSingle($(itens[i].id), (sLinha+i), this.aRows[i], false, true);
                        }
                    }
                }
            }
            alertError = false;
        }

        gridLancamentos.setCheckbox(0);
        gridLancamentos.hasTotalizador = true;
        gridLancamentos.allowSelectColumns(true);
        gridLancamentos.setCellWidth(new Array("5%", "5%", "5%", "26%", "15%", "8%", "7%", "3%", "5%", "20%"));
        gridLancamentos.setCellAlign(new Array("center", "center", "center", "left", "left", "center", "center", "center", "right", "left"));
        gridLancamentos.setHeader(new Array("M", "Data", "Conciliado", "Credor", "Tipo", "OP/REC/SLIP", "Documento", "Mov", "Valor", "Histórico"));
        gridLancamentos.aHeaders[1].lDisplayed = false;
        gridLancamentos.show(document.getElementById('gridLancamentos'));
        $('gridLancamentosstatus').innerHTML = "&nbsp;<span style='color:blue' id ='total_selecionados'>0</span> Selecionados";
        document.form1.data_inicial.focus();
    }

    function js_janelaPlanilhaDetalhada(lancamentos) {
        var dtBase = 1;
        var iCheque = 2;
        var total = 0;
        windowLancamentoItem = new windowAux('wndReceitaItem', 'Informações Detalhadas', 1000, 250);

        var sContent = "<div class='grid_planilha' id='grid_planilha' style='margin: 0 auto; width: 100%; text-align: center'>";
        sContent += "       <table id='tabela-lancamentos'>";
        sContent += "           <thead>";
        sContent += "               <tr>";
        sContent += "                   <th>Planilha</th>";
        sContent += "                   <th>Código</th>";
        sContent += "                   <th>Data</th>";
        sContent += "                   <th width='80%'>Nomenclatura</th>";
        sContent += "                   <th>Valor</th>";
        sContent += "               </tr>";
        sContent += "           </thead>";
        sContent += "           <tbody>";

        lancamentos.forEach(function (data, index) {
            sContent += "           <tr>";
            sContent += "                   <td>" + data.planilha + "</td>";
            sContent += "                   <td>" + data.codigo + "</td>";
            sContent += "                   <td>" + data.data + "</td>";
            sContent += "                   <td>" + data.descricao + "</td>";
            sContent += "                   <td style='text-align: right'>" + js_formatar(data.valor, "f"); + "</td>";
            sContent += "           </tr>";
            total += parseFloat(data.valor);
        });

        sContent += "           </tbody>";
        sContent += "           <tfoot>";
        sContent += "           <tr>";
        sContent += "                   <td colspan='4'><b>Total:</b></td>";
        sContent += "                   <td style='text-align: right'><b>" + js_formatar(total, "f"); + "</b></td>";
        sContent += "           </tr>";
        sContent += "           </tfoot>";
        sContent += "       </table>";
        sContent += "</div>";

        windowLancamentoItem.setContent(sContent);

        windowLancamentoItem.setShutDownFunction(function () {
            windowLancamentoItem.destroy();
        });

        var w = ((screen.width - 1000) / 2);
        var h = ((screen.height / 2) - 300);
        windowLancamentoItem.setIndex(5);
        windowLancamentoItem.allowDrag(false);
        windowLancamentoItem.show(h, w);
    }

    function js_janelaAgrupados(lancamentos) {
        var dtBase = 1;
        var iCheque = 2;
        var total = 0;

        windowLancamentoItem = new windowAux('wndChequeItem', 'Informações Detalhadas', 1000, 250);
        var sContent = "<div class='grid_detalhamentos' id='grid_detalhamentos' style='margin: 0 auto; width: 100%; text-align: center'>";
        sContent += "       <table id='tabela-lancamentos'>";
        sContent += "           <thead>";
        sContent += "               <tr>";
        sContent += "                   <th>D. Lançamento</th>";
        sContent += "                   <th>Credor</th>";
        sContent += "                   <th>Tipo</th>";
        sContent += "                   <th>OP/REC/SLIP</th>";
        sContent += "                   <th>Documento</th>";
        sContent += "                   <th>Mov</th>";
        sContent += "                   <th>Valor</th>";
        sContent += "                   <th>Histórico</th>";
        sContent += "               </tr>";
        sContent += "           </thead>";
        sContent += "           <tbody>";

        lancamentos.forEach(function (data, index) {
            sContent += "           <tr>";
            sContent += "                   <td>" + data.data_lancamento + "</td>";
            sContent += "                   <td>" + data.credor + "</td>";
            sContent += "                   <td>" + data.tipo + "</td>";
            sContent += "                   <td>" + data.op_rec_slip + "</td>";
            sContent += "                   <td>" + data.documento + "</td>";
            sContent += "                   <td>" + data.movimento + "</td>";
            sContent += "                   <td style='text-align: right'>" + js_formatar(data.valor, "f"); + "</td>";
            sContent += "                   <td>" + data.historico + "</td>";
            sContent += "           </tr>";
            total += parseFloat(data.valor);
        });

        sContent += "           </tbody>";
        sContent += "           <tfoot>";
        sContent += "           <tr>";
        sContent += "                   <td colspan='6'><b>Total:</b></td>";
        sContent += "                   <td style='text-align: right'><b>" + js_formatar(total, "f"); + "</b></td>";
        sContent += "                   <td> </td>";
        sContent += "           </tr>";
        sContent += "           </tfoot>";
        sContent += "       </table>";
        sContent += "</div>";

        windowLancamentoItem.setContent(sContent);

        windowLancamentoItem.setShutDownFunction(function () {
            windowLancamentoItem.destroy();
        });

        var w = ((screen.width - 1000) / 2);
        var h = ((screen.height / 2) - 300);
        windowLancamentoItem.setIndex(5);
        windowLancamentoItem.allowDrag(false);
        windowLancamentoItem.show(h, w);
    }

    function js_janelaPendencia() {
        js_OpenJanelaIframe('top.corpo','db_iframe_extratobancariapendencia',
            'cai4_concbancpendencia001.php?funcao_js=parent.js_pesquisar_lancamentos&novo=true&reload=true&conta=' + $F("k13_conta") + "&data_inicial=" + $F("data_inicial"),
            'Cadastro de Pendências', true);
    }

    function js_janelaPendenciaAlterarPendencia(id, conciliacao) {
        var url = 'cai4_concbancpendencia001.php?funcao_js=parent.js_pesquisar_lancamentos&novo=false&reload=true&conta=' + $F("k13_conta") + "&data_inicial=" + $F("data_inicial") + "&sequencial=" + id + "&conciliacao=" + conciliacao;
        js_OpenJanelaIframe('top.corpo','db_iframe_extratobancariapendencia', url, 'Cadastro de Pendências', true);
    }

    function js_processar() {
        var movimentos = gridLancamentos.getSelection();
        var sem_erro = true;
        var aviso    = "";

        if (!js_validar_campos_processar(movimentos))
            return false;

        js_divCarregando("Aguarde, processando Lançamentos.", "msgBox");

        oParam = new Object();
        oParam.conta = document.form1.k13_conta.value;
        oParam.data_final = document.form1.data_final.value;
        oParam.data_conciliacao = document.form1.data_conciliacao.value;
        oParam.saldo_final_extrato = document.form1.saldo_final_extrato.value;
        oParam.movimentos = new Array();

        for (var iMov = 0; iMov < movimentos.length; iMov++) {
            // console.log("Data da Conciliação: " + movimentos[iMov][3].trim());
            // console.log("Encerramento: " + encerramento_contabil);
            if (encerramento_contabil != "" && movimentos[iMov][3].trim() != "") {
                if (js_comparadata(movimentos[iMov][3], encerramento_contabil, "<=")) {
                    alert("Não foi possível processar a conciliação pois já existe encerramento de período contábil para um ou mais lançamentos selecionados.");
                    js_removeObj("msgBox");
                    return false;
                }
            }
            var lancamento = js_preenche_lancamento(movimentos[iMov]);
            oParam.movimentos.push(lancamento);
        }
        // console.log(oParam);
        // Final dos movimentos
        var sParam = js_objectToJson(oParam);
        url = 'cai4_conciliacaoBancariaNovo.RPC.php';
        var sJson = '{"exec": "Processar", "params": ['+ sParam + ']}';
        var oAjax = new Ajax.Request(url,
            {
                method    : 'post',
                parameters: 'json=' + sJson,
                onComplete: js_retorno_processar_lancamentos
            }
        );
    }

    function js_retorno_processar_lancamentos(oAjax) {
        js_removeObj("msgBox");
        // console.log("Antes da resposta");
        console.log(oAjax.responseText);

        var oResponse = eval("(" + oAjax.responseText + ")");
        if (oResponse.error)
            alert(oResponse.error);
        js_pesquisar_lancamentos();
    }

    function js_pesquisar_lancamentos_conciliacao() {
        iZerarSaldoFinalExtrato = 1;
        js_pesquisar_lancamentos();
    }

    function js_desprocessar() {
        var movimentos = gridLancamentos.getSelection();
        var sem_erro = true;
        var aviso    = "";

        if (!js_validar_campos_processar(movimentos))
            return false;

        js_divCarregando("Aguarde, processando Lançamentos.", "msgBox");

        oParam = new Object();
        oParam.conta = document.form1.k13_conta.value;
        oParam.data_final = document.form1.data_final.value;
        oParam.data_conciliacao = document.form1.data_conciliacao.value;
        oParam.saldo_final_extrato = document.form1.saldo_final_extrato.value;
        oParam.movimentos = new Array();

        for (var iMov = 0; iMov < movimentos.length; iMov++) {
            if (encerramento_contabil == 10 && js_comparadata(movimentos[iMov][3], encerramento_contabil, "<=") && movimentos[iMov][3].length == 10) {
                alert("Não foi possível desprocessar a conciliação pois já existe encerramento de período contábil para um ou mais lançamentos selecionados.");
                js_removeObj("msgBox");
                return false;
            }

            var lancamento = js_preenche_lancamento(movimentos[iMov]);
            oParam.movimentos.push(lancamento);
        }
        // console.log(oParam);
        // Final dos movimentos
        var sParam = js_objectToJson(oParam);
        url = 'cai4_conciliacaoBancariaNovo.RPC.php';
        var saldo_final_extrato = $F("saldo_final_extrato");
        var sJson = '{"exec": "Desprocessar", "params": ['+ sParam + ']}';
        iZerarSaldoFinalExtrato = 1;
        var oAjax = new Ajax.Request(url,
            {
                method    : 'post',
                parameters: 'json=' + sJson,
                onComplete: js_retorno_processar_lancamentos
            }
        );
        document.form1.saldo_final_extrato.value = saldo_final_extrato;
    }

    function js_preenche_lancamento(movimento) {
        lancamento = new Object();
        lancamento.data_lancamento  = movimento[2];
        lancamento.data_conciliacao = movimento[3];
        lancamento.cgm              = dados_complementares_numcgm[movimento[1]];
        lancamento.tipo             = dados_complementares_coddoc[movimento[1]];
        lancamento.codigo           = dados_complementares_oprecslip[movimento[1]];
        lancamento.documento        = dados_complementares_documento[movimento[1]];
        lancamento.movimentacao     = movimento[8];
        lancamento.valor            = dados_complementares_valor_individual[movimento[1]];
        console.log(lancamento);
        return lancamento;
    }

    // Função que valida os campos para o processamento da conciliação
    function js_validar_campos_processar(movimentos) {
        if (movimentos.length == 0) {
            alert("Não há nenhum lançamento selecionado.");
            return false;
        }

        if ($F("data_conciliacao") == "") {
            alert("Informe a Data da Conciliação!");
            $F("data_conciliacao") = "";
            return false;
        }

        if (encerramento_contabil != "") {
            if (js_comparadata($F("data_conciliacao"), encerramento_contabil, "<=")) {
                alert("Não foi possível processar a conciliação pois já existe encerramento de período contábil para esta data.");
                return false;
            }
        }

        if (js_comparadata($F("data_conciliacao"), $F("data_inicial"), "<") || js_comparadata($F("data_conciliacao"), $F("data_final"), ">")) {
            alert("Data de Conciliação fora do período informado!");
            $F("data_conciliacao") = "";
            return false;
        }

        if ($F("saldo_final_extrato") == "") {
            alert("Informe o saldo final do extrato banc?rio!");
            return false;
        }

        return true;
    }

    function js_reset() {
        document.form1.k13_conta.value = "";
        document.form1.k13_descr.value = "";
        document.form1.data_inicial.value = "";
        document.form1.data_final.value = "";
        document.form1.tipo_lancamento.selectedIndex = 0;
        document.form1.tipo_movimento.selectedIndex = 0;
        document.form1.data_conciliacao.value = "";

        document.form1.saldo_inicial_tesouraria.value = "0,00";
        document.form1.total_entradas.value = "0,00";
        document.form1.total_saidas.value = "0,00";
        document.form1.saldo_conciliado.value = "0,00";
        document.form1.saldo_final_extrato.value = "0.00";
        document.form1.diferenca.value = "0,00";

        js_verifica_campos();
        js_init();
    }

    function js_data(data) {
        var data = data.split("/");
        return data[2] + "-" + data[1] + "-" + data[0];
    }

    document.form1.emitir_capa.onclick = function() {
        if (confirm("Deseja emitir também o extrato bancário?")) {
            var parametros = "conta=(" + $F("k13_conta") + ")&imprime_historico=s&imprime_analitico=s&totalizador_diario=n&somente_contas_com_movimento=s&datai=" + js_data($F("data_inicial")) + "&dataf=" + js_data($F("data_final")) + "&agrupapor=1&receitaspor=1&pagempenhos=1&imprime_pdf=p&somente_contas_bancarias=s&exibir_retencoes=n";
            jan = window.open('cai2_extratobancario002.php?'+parametros,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');
            jan.moveTo(0,0);
        }

        sUrl = "cai4_concbancnovo002.php?conta_nova=" + $F("k13_conta") + "&data_inicial=" + js_data($F("data_inicial")) + "&data_final=" + js_data($F("data_final")) + "&saldo_extrato=" + $F("saldo_conciliado");
        window.open(sUrl, '', 'location=0');
    }
    // Final das funções verificadas
</script>
