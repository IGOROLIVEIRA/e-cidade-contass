<?php
?>
<form>
    <fieldset style="width: 60%">
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
                            863 => 'pcorcamval'
                            );
                        db_select('tabela', $aValores, true, $db_opcao,"onchange=''");
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
                    db_select('tipo', $aValores, true, $db_opcao,"onchange=''");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Descrição:</strong>
                </td>
                <td>
                    <input type="text" id="description" onkeyup="js_getLogs()">
                </td>
            </tr>
        </table>
    </fieldset>
    <div>
        <input type="button" value="Processar" onclick="js_getLogs()">
    </div>
    <div id="divtable">

    </div>
</form>
<script>

    function js_getLogs() {
        var table         = document.getElementById('tabela').value;
        var dateini       = document.getElementById('dateini').value;
        var dateend       = document.getElementById('dateend').value;
        var tipo          = document.getElementById('tipo').value;
        var description   = document.getElementById('description').value;

        if (table == 0){
            alert('Escolha uma tabela');
            return
        }

        var oParam                    = new Object();
        oParam.exec                   = 'getLogs';
        oParam.table                  = table;
        oParam.periodoinicio          = dateini;
        oParam.periodofim             = dateend;
        oParam.tipo                   = tipo;
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
        js_removeObj("msgbox");

        var oRetorno = eval('('+oAjax.responseText+")");
        if (oRetorno.status == 2) {
            alert(oRetorno.message.urlDecode());
        }else{
            var divtable = document.getElementById('divtable');

            divtable.innerHTML = '';

            // var divtable = document.('divtable');
            var tablelogs = document.createElement('table');
            tablelogs.setAttribute('id','tablelogs');
            divtable.appendChild(tablelogs);

            //cabeçalho sequencial
            var logtr = document.createElement('tr');
            var logtd = document.createElement('td');
            logtd.setAttribute('class','table_header');
            var labelsequencial = document.createElement('label');
            var textsequencial = document.createTextNode('Sequencial');

            labelsequencial.appendChild(textsequencial);
            logtd.appendChild(labelsequencial);
            logtr.appendChild(logtd);
            tablelogs.appendChild(logtr);

            //cabeçalho descricao
            var logtd = document.createElement('td');
            logtd.setAttribute('class','table_header');
            logtd.setAttribute('style','width:425px');
            var labelsequencial = document.createElement('label');
            var textsequencial = document.createTextNode('Descrição');

            labelsequencial.appendChild(textsequencial);
            logtd.appendChild(labelsequencial);
            logtr.appendChild(logtd);
            tablelogs.appendChild(logtr);

            //cabeçalho data
            var logtd = document.createElement('td');
            logtd.setAttribute('class','table_header');
            var labelsequencial = document.createElement('label');
            var textsequencial = document.createTextNode('Data');

            labelsequencial.appendChild(textsequencial);
            logtd.appendChild(labelsequencial);
            logtr.appendChild(logtd);
            tablelogs.appendChild(logtr);

            //cabeçalho hora
            var logtd = document.createElement('td');
            logtd.setAttribute('class','table_header');
            var labelsequencial = document.createElement('label');
            var textsequencial = document.createTextNode('Hora');

            labelsequencial.appendChild(textsequencial);
            logtd.appendChild(labelsequencial);
            logtr.appendChild(logtd);
            tablelogs.appendChild(logtr);

            //cabeçalho usuario
            var logtd = document.createElement('td');
            logtd.setAttribute('class','table_header');
            var labelsequencial = document.createElement('label');
            var textsequencial = document.createTextNode('Usuario');

            labelsequencial.appendChild(textsequencial);
            logtd.appendChild(labelsequencial);
            logtr.appendChild(logtd);
            tablelogs.appendChild(logtr);

            //cabeçalho tabela
            var logtd = document.createElement('td');
            logtd.setAttribute('class','table_header');
            var labelsequencial = document.createElement('label');
            var textsequencial = document.createTextNode('Tabela');

            labelsequencial.appendChild(textsequencial);
            logtd.appendChild(labelsequencial);
            logtr.appendChild(logtd);
            tablelogs.appendChild(logtr);

            //cabeçalho tipo
            var logtd = document.createElement('td');
            logtd.setAttribute('class','table_header');
            var labelsequencial = document.createElement('label');
            var textsequencial = document.createTextNode('Tipo');

            labelsequencial.appendChild(textsequencial);
            logtd.appendChild(labelsequencial);
            logtr.appendChild(logtd);
            tablelogs.appendChild(logtr);

            if(oRetorno.logs.length === 0){
                divtable.innerHTML = '';
                var h3 = document.createElement('h3');
                var nenhumresultado = document.createTextNode('Nenhum registro encontrato!');
                h3.appendChild(nenhumresultado);
                divtable.appendChild(h3);
            }else {

                oRetorno.logs.forEach(function (oLog, iSeq) {
                    //tr Sequencial
                    var logtr = document.createElement('tr');
                    logtr.setAttribute('id', 'trlogs' + oLog.manut_sequencial);
                    var logtd = document.createElement('td');
                    logtd.setAttribute('class', 'linhagrid');
                    var labelsequencial = document.createElement('label');
                    var textsequencial = document.createTextNode(oLog.manut_sequencial);
                    labelsequencial.appendChild(textsequencial);
                    logtd.appendChild(labelsequencial);
                    logtr.appendChild(logtd);
                    tablelogs.appendChild(logtr);

                    //tr Descricao
                    var logtd = document.createElement('td');
                    logtd.setAttribute('class', 'linhagrid');
                    var labelsequencial = document.createElement('label');
                    var textsequencial = document.createTextNode(oLog.manut_descricao.urlDecode());
                    labelsequencial.appendChild(textsequencial);
                    logtd.appendChild(labelsequencial);
                    logtr.appendChild(logtd);
                    tablelogs.appendChild(logtr);

                    //tr Data
                    var logtd = document.createElement('td');
                    logtd.setAttribute('class', 'linhagrid');
                    var labelsequencial = document.createElement('label');
                    var textsequencial = document.createTextNode(oLog.manut_date);
                    labelsequencial.appendChild(textsequencial);
                    logtd.appendChild(labelsequencial);
                    logtr.appendChild(logtd);
                    tablelogs.appendChild(logtr);

                    //tr Hora
                    var logtd = document.createElement('td');
                    logtd.setAttribute('class', 'linhagrid');
                    var labelsequencial = document.createElement('label');
                    var textsequencial = document.createTextNode(oLog.manut_hora);
                    labelsequencial.appendChild(textsequencial);
                    logtd.appendChild(labelsequencial);
                    logtr.appendChild(logtd);
                    tablelogs.appendChild(logtr);

                    //tr Usuario
                    var logtd = document.createElement('td');
                    logtd.setAttribute('class', 'linhagrid');
                    var labelsequencial = document.createElement('label');
                    var textsequencial = document.createTextNode(oLog.manut_usuario);
                    labelsequencial.appendChild(textsequencial);
                    logtd.appendChild(labelsequencial);
                    logtr.appendChild(logtd);
                    tablelogs.appendChild(logtr);

                    //tr Tabela
                    var logtd = document.createElement('td');
                    logtd.setAttribute('class', 'linhagrid');
                    var labelsequencial = document.createElement('label');
                    var textsequencial = document.createTextNode(oLog.manut_tabela);
                    labelsequencial.appendChild(textsequencial);
                    logtd.appendChild(labelsequencial);
                    logtr.appendChild(logtd);
                    tablelogs.appendChild(logtr);

                    //tr Tipo
                    var logtd = document.createElement('td');
                    logtd.setAttribute('class', 'linhagrid');
                    var labelsequencial = document.createElement('label');
                    var textsequencial = document.createTextNode(oLog.manut_tipo.urlDecode());
                    labelsequencial.appendChild(textsequencial);
                    logtd.appendChild(labelsequencial);
                    logtr.appendChild(logtd);
                    tablelogs.appendChild(logtr);
                })
            }
        }
    }

</script>