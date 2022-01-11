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
$extratoBancario = new ExtratoBancarioSicom(db_getsession("DB_anousu"), db_getsession("DB_instit"));

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

<br/><br/>
<form name="form1" method="post" action="">
    <center>
        <table  border =0 style='width:90%'>
            <tr>
                <td>
                    <fieldset>
                        <legend><b>Extratos Bancários Sicom</b></legend>

                        <table width="100%">
                            <tr>
                                <td>
                                    <center>
                                        <b>Ano Referência:</b>
                                        <select name="ano" id="ano" onchange='buscarExtrato()'>
                                            <option value="0" selected="selected">Selecione</option>
                                            <?php
                                                for ($i = 2021; $i <= date("Y"); $i++) {
                                                    echo "<option value='{$i}'><b>$i</b></option>";
                                                }    
                                            ?>
                                        </select>
                                        <input type="button" value="Relatório de Conferência" onclick="js_gerarRelatorio();"/>
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <div class='grid_planilha' id='grid_planilha' style='margin: 0 auto; width: 100%; text-align: center'>
                                    <table id='tabela-lancamentos'>
                                        <thead>
                                            <tr>
                                                <th>Reduzido</th>
                                                <th>Código TCE</th>
                                                <th>Agrupados</th>
                                                <th>Descrição</th>
                                                <th>Banco</th>
                                                <th>Agência</th>
                                                <th>Conta</th>
                                                <th>Tipo</th>
                                                <th>Data Limite</th>
                                                <th>Anexo</th>
                                                <th>Situação</th>
                                                <th>Download</th>
                                            </tr>
                                        </thead>
                                        <tbody id='retorno'>
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
<script>
    function js_gerarRelatorio(){
        jan = window.open('con4_contasextratobancariosicom.php?ano=' + document.getElementById("ano").value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
        jan.moveTo(0,0);
	}

    function buscarExtrato() {
        js_divCarregando("Aguarde, processando Lançamentos.", "msgBox");
        $('retorno').innerHTML = "";
        oParam = new Object();
        oParam.ano = document.getElementById("ano").value;        
        var sParam = js_objectToJson(oParam);
        url = 'cai4_extratobancariosicom.RPC.php';
        var sJson = '{"exec": "getContas", "params": ['+ sParam + ']}';
        var oAjax = new Ajax.Request(url,
            {
                method    : 'post',
                parameters: 'json=' + sJson,
                onComplete: js_retorno
            }
        );
    }

    function js_retorno(oAjax) {
        js_removeObj('msgBox');
        var ano = document.getElementById("ano").value;        
        var oRetorno = eval("("+oAjax.responseText+")");
        console.log(oRetorno);
        if (oRetorno.status == 1) {
            var sContent = '';
            oRetorno.contas.forEach(function (data, index) {
                sContent +=  "           <tr>";
                sContent +=  "<td>" + data.reduzido + "</td>";
                sContent +=  "<td>" + data.codtce + "</td>";
                if (data.contas === undefined) {
                    sContent +=  "<td></td>";
                } else {
                    sContent +=  "<td>" + data.contas + "</td>";
                }
                sContent +=  "<td>" + data.descricao + "</td>";
                sContent +=  "<td>" + data.banco + "</td>";
                sContent +=  "<td>" + data.agencia + "-" + data.digito_agencia + "</td>";
                sContent +=  "<td>" + data.conta + "-" + data.digito_conta + "</td>";
                sContent +=  "<td>" + data.tipo + "</td>";
                sContent +=  "<td>" + data.limite + "</td>";
                sContent +=  "<td>";
                sContent +=  "<input type='file' name='arquivo-" + data.codtce + "'/>&nbsp&nbsp"; 
                sContent +=  "<input type='button' value='Enviar' onclick=\"micoxUpload(this.form,'upload_extrato_bancario_sicom.php?cnpj=" + data.cnpj + "&orgao=" + data.orgao + "&reduzido=" + data.codtce + "&ano=" + ano + "','retorno-" + data.reduzido + "','Carregando...','Erro ao carregar')\" />";  
                sContent +=  "</td>";
                sContent +=  "<td id='retorno-" + data.reduzido + "'><span class='" + data.situacao + "'>" + data.situacao + "</span></td>";
                var download = data.situacao == 'enviado' ? "<a target='_blank' href='extratobancariosicom/" + data.cnpj + "/" + ano + "/CTB_" + data.orgao + "_" + data.codtce + ".pdf'>DOWNLOAD</a>" : "";
                sContent +=  "<td>" + download + "</td>";
                sContent += "           </tr>";
                $('retorno').innerHTML = sContent;
            });
        }
    }
</script>