<?
//MODULO: contabilidade

$aMeses = array(
    '01' => 'Janeiro',
    '02' => 'Fevereiro',
    '03' => 'Março',
    '04' => 'Abril',
    '05' => 'Maio',
    '06' => 'Junho',
    '07' => 'Julho',
    '08' => 'Agosto',
    '09' => 'Setembro',
    '10' => 'Outubro',
    '11' => 'Novembro',
    '12' => 'Dezembro'
);

?>

<style type="text/css">

    .bg_false {
        background-color: #dfe2ff;
    }

    .text-center {
        text-align: center;
    }
    .table {
        width: 100%;
        border: 1px solid #bbb;
        margin-bottom: 25px;
        border-collapse: collapse;
        background-color: #fff;
    }
    .table th,
    .table td {
        padding: 6px 13px;
        border: 1px solid #bbb;
    }
    .table th {
        background-color: #ddd;
    }
    .table .th_titulo {
        width: 575px;
    }
</style>

<form name="form1" method="post" action="" onsubmit="return processarRateio(this);">
    <center>
        <fieldset>
            <legend>Gerar Rateio</legend>

            <div>
                <strong>Mês</strong>
                <!-- <select name="mes" onchange="carregaEntesDotacoes(this.value);"> -->
                <select name="mes" onchange="carregaEntesProjetos(this.value);">
                    <?php foreach ($aMeses as $key => $value): ?>
                        <option value="<?= $key ?>"><?= $value ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <br>

            <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th class="th_titulo">Ente Consorciado</th>
                        <th>Percentual</th>
                    </tr>
                    </thead>

                    <tbody id="table_entes">

                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="table_entes">Percentual Total</th>
                        <th id="table_percentual">

                        </th>
                    </tr>
                    </tfoot>
                </table>

            </div>
 <!-- FEITO POR: Igor Ruas: foi solicitado para selecioar projetos no lugar de dotação.
 até ficar definido isso somente comentei a tabela antiga -->
            <!-- <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th class="th_titulo">Dotações para Rateio</th>
                        <th>Selecionar</th>
                    </tr>
                    </thead>

                    <tbody id="table_dotacoes">

                    </tbody>

                    <tbody>
                    <tr>
                        <td colspan="3" class="text-center">
                            <input type="button" value="Marcar todos" onclick="checkDotacoes(true);">
                            <input type="button" value="Desmarcar todos" onclick="checkDotacoes(false);">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div> -->

            <!-- <div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th class="th_titulo">Projetos para Rateio</th>
                        <th>Selecionar</th>
                    </tr>
                    </thead>

                    <tbody id="table_projetos">

                    </tbody>

                    <tbody>
                    <tr>
                        <td colspan="3" class="text-center">
                            <input type="button" value="Marcar todos" onclick="checkProjAtivs(true);">
                            <input type="button" value="Desmarcar todos" onclick="checkProjAtivs(false);">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div> -->

            <input name="processar" type="submit" id="processar" value="Processar">
        </fieldset>
    </center>

</form>

<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>

<script type="text/javascript">

    function processarRateio(form) {

        var params = {
            exec: 'processarRateio',
            mes: form.mes.value,
            entes: [],
            dotacoes: [],
            projetos: []
        };

        var entes = form.elements['entes[]'];
        if (entes) {
            if (entes['forEach']) {

                entes.forEach(function (item) {
                    params.entes.push({
                        id: item.dataset.ente,
                        percentual: item.value
                    });
                });

            } else {

                params.entes.push({
                    id: entes.dataset.ente,
                    percentual: entes.value
                });

            }
        }

        var dotacoes = form.elements['dotacoes[]'];
        if (dotacoes) {
            if (dotacoes['forEach']) {

                dotacoes.forEach(function (item) {
                    if (item.checked) {
                        params.dotacoes.push(item.value);
                    }
                });

            } else {

                if (dotacoes.checked) {
                    params.dotacoes.push(dotacoes.value);
                }

            }
        }
        var projetos = form.elements['projetos[]'];
        if (projetos) {
            if (projetos['forEach']) {

                projetos.forEach(function (item) {
                    if (item.checked) {
                        params.projetos.push(item.value);
                    }
                });

            } else {

                if (projetos.checked) {
                    params.projetos.push(projetos.value);
                }

            }
        }

        js_divCarregando('Aguarde', 'div_aguarde');

        novoAjax(params, function(r) {

            var retorno = JSON.parse(r.responseText);

            if (!!retorno.erro) {
                alert(retorno.erro);
            }

            if (!!retorno.sucesso) {
                alert(retorno.sucesso);
            }

            js_removeObj('div_aguarde');

        });

        return false;

    }

    function novoAjax(params, onComplete) {

        var request = new Ajax.Request('con4_gerarrateio.RPC.php', {
            method:'post',
            parameters:'json='+Object.toJSON(params),
            onComplete: onComplete
        });

    }

    // function carregaEntesDotacoes(mes) {
    //     carregarEntesConsorciados(mes);
    // }

    function carregaEntesProjetos(mes) {
        carregarEntesConsorciados(mes);
    }

    function carregarEntesConsorciados(mes) {

        var tableEntes = document.getElementById('table_entes');

        tableEntes.innerHTML = '<tr><td colspan="2" class="text-center">carregando...</td></tr>';

        var params = {
            exec: 'buscaEntesConsorcionados',
            mes: mes
        };

        novoAjax(params, function(e) {

            var entes = JSON.parse(e.responseText).entes;
            var trs   = [];

            tableEntes.innerHTML = '<tr><td colspan="2">' + entes.join('') + '</td></tr>';
            var percentualFinal = 0;
            entes.forEach(function(ente, i) {

                var tr = ''
                    + '<tr class="bg_' + (i % 2 == 0) + '">'
                    + '<td class="th_titulo">' + ente.cgm + ' - ' + ente.nome + '</td>'
                    + '<td>'
                    + '<input  value="' + ente.percentual + '" size="4" data-ente="' + ente.sequencial + '" name="entes[]" onchange="js_TotalPercent()" '
                    + ' oninput="js_ValidaCampos(this,4,\'Percentual\',\'t\',\'t\',event);" > % '
                    + '</td>'
                    + '</tr>';

                trs.push(tr);
                percentualFinal += new Number(ente.percentual);
            });

            tableEntes.innerHTML = trs.join('');
            $('table_percentual').innerHTML = js_round(percentualFinal,2)+'%';

            if (entes.length == 0) {
                tableEntes.innerHTML = '<tr><td colspan="2">Nenhum ente encontrado</td></tr>';
            }

        });

    }

    function js_TotalPercent(){

        var percentuais = document.getElementsByName('entes[]');
        var percentualFinal = 0;
        percentuais.forEach(function(perc){
            percentualFinal += new Number(perc.value);
        });
        //console.log(percentualFinal);
        $('table_percentual').innerHTML = js_round(percentualFinal,2)+'%';
    }

    function carregarDotacoesParaRateio(mes) {

        var tableDotacoes = document.getElementById('table_dotacoes');

        tableDotacoes.innerHTML = '<tr><td colspan="3" class="text-center">carregando...</td></tr>';

        var params = {
            exec: 'buscaDotacoes',
            mes: mes
        };

        novoAjax(params, function(e) {

            var dotacoes = JSON.parse(e.responseText).dotacoes;
            var trs   = [];

            dotacoes.forEach(function(dotacao, i) {

                var tr = ''
                    + '<tr class="bg_' + (i % 2 == 0) + '">'
                    + '<td class="text-center">' + dotacao.codigo + '</td>'
                    + '<td class="th_titulo">'
                    + [
                        dotacao.orgao,
                        dotacao.unidade,
                        dotacao.funcao,
                        dotacao.subfuncao,
                        dotacao.programa,
                        dotacao.projativ,
                        dotacao.elemento
                    ].join('.') + ' ' + dotacao.descricao
                    + '</td>'
                    + '<td class="text-center">'
                    + '<input value="' + dotacao.codigo + '" type="checkbox" name="dotacoes[]">'
                    + '</td>'
                    + '</tr>';

                trs.push(tr);

            });

            tableDotacoes.innerHTML = trs.join('');

        });

    }
    function carregarProjAtivParaRateio(mes) {

    var tableProjetos = document.getElementById('table_projetos');

    tableProjetos.innerHTML = '<tr><td colspan="3" class="text-center">carregando...</td></tr>';

    var params = {
        exec: 'buscaProjAtiv',
        mes: mes
    };

    novoAjax(params, function(e) {

        var projetos = JSON.parse(e.responseText).projetos;

        var trs   = [];

        projetos.forEach(function(projeto, i) {

            var tr = ''
                + '<tr class="bg_' + (i % 2 == 0) + '">'
                + '<td class="text-center">' + projeto.codigo + '</td>'
                + '<td class="th_titulo">'+ projeto.descricao + '</td>'
                + '<td class="text-center">'
                + '<input value="' + projeto.codigo + '" type="checkbox" name="projetos[]">'
                + '</td>'
                + '</tr>';

            trs.push(tr);

        });

        tableProjetos.innerHTML = trs.join('');

    });

    }


    function checkDotacoes(valor) {

        var dotacoes = document.form1.elements['dotacoes[]'];
        if (dotacoes) {
            if (dotacoes['forEach']) {

                dotacoes.forEach(function (item) {
                    item.checked = !!valor;
                });

            } else {
                dotacoes.checked = !!valor;
            }
        }

    }

    function checkProjAtivs(valor) {

      var projetos = document.form1.elements['projetos[]'];
      if (projetos) {
          if (projetos['forEach']) {

            projetos.forEach(function (item) {
                  item.checked = !!valor;
              });

          } else {
            projetos.checked = !!valor;
          }
      }

      }

    // carregaEntesDotacoes('01');
    carregaEntesProjetos('01');
    //carregarDotacoesParaRateio();
    //carregarProjAtivParaRateio();

</script>
