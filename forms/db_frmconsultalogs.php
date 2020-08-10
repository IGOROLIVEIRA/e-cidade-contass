<?php
?>
<form>
    <fieldset id="fieldsetLogs">
        <legend>Logs</legend>
        <table>
            <tr>
                <td>
                    <strong>Tabela:</strong>
                </td>
                <td>
                    <?php
                        $aValores = array(
                            0 => 'Selecione',
                            889 => 'empempenho',
                            );
                        db_select('table', $aValores, true, $db_opcao,"onchange=''");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Periodo:</strong>
                </td>
                <td>
                    <?php
                    db_inputdata('dateini', @$dia, @$mes, @$ano,true, 'text', $iCampo, "onchange=''","", "", "");
                    ?>
                    <strong>a</strong>
                    <?php
                    db_inputdata('dateend', @$dia, @$mes, @$ano,true, 'text', $iCampo, "onchange=''","", "", "");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Tipo:</strong>
                </td>
                <td>
                    <?php
                    $aValores = array(
                        0 => 'Todos',
                        1 => 'Inclusão',
                        2 => 'Alteração',
                        3 => 'Exclusão'
                    );
                    db_select('type', $aValores, true, $db_opcao,"onchange=''");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Descrição:</strong>
                </td>
                <td>
                    <input type="text" id="description">
                </td>
            </tr>
        </table>
    </fieldset>
    <div>
        <input type="button" value="Processar" onclick="js_getLogs()">
    </div>
    <table id="tablelogs" border="0" class="DBGrid">
        <tr>
            <td class="table_header">
                sequencial
            </td>
            <td class="table_header">
                Descricao
            </td>
            <td class="table_header">
                Data
            </td>
            <td class="table_header">
                Hora
            </td>
            <td class="table_header">
                usuario
            </td>
            <td class="table_header">
                table
            </td>
            <td class="table_header">
                tipo
            </td>
        </tr>
<!--        <tr>-->
<!--            <td class="linhagrid">-->
<!--                <label>teste22</label>-->
<!--            </td>-->
<!--        </tr>-->
    </table>
</form>
<script>
    function js_getLogs() {
        var table         = document.getElementById('table').value;
        var dateini       = document.getElementById('dateini').value;
        var dateend       = document.getElementById('dateend').value;
        var type          = document.getElementById('type').value;
        var description   = document.getElementById('description').value;

        var oParam                    = new Object();
        oParam.exec                   = 'getLogs';
        oParam.table                  = table;
        oParam.periodoinicio          = dateini;
        oParam.periodofim             = dateend;
        oParam.type                   = type;
        oParam.descricao              = description;
        js_divCarregando('Aguarde... Carregando Foto','msgbox');
        var oAjax         = new Ajax.Request(
            'db_consultalogs.RPC.php',
            { parameters: 'json='+Object.toJSON(oParam),
                asynchronous:false,
                method: 'post',
                onComplete : js_setLogs
            });
    }

    function js_setLogs(oAjax) {
        var tablelogs = document.getElementById('tablelogs');

        js_removeObj("msgbox");
        var oRetorno = eval('('+oAjax.responseText+")");
        if (oRetorno.status == 2) {
            alert(oRetorno.message.urlDecode());
        }else{
            console.log(oRetorno.logs);
            oRetorno.logs.forEach(function (oLog, iSeq) {
                var logtr = document.createElement('tr');
                var logtd = document.createElement('td');
                logtd.setAttribute('class','linhagrid');
                var labelsequencial = document.createElement('label');
                var textsequencial = document.createTextNode(oLog.manut_sequencial);
                labelsequencial.appendChild(textsequencial);
                logtd.appendChild(labelsequencial);
                logtr.appendChild(logtd);
                tablelogs.appendChild(logtr);
            })
        }
    }

</script>