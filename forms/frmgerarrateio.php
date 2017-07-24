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
        <select name="mes" onchange="carregaEntesDotacoes(this.value);">
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
        </table>
      </div>

      <div>
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
      </div>

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
    dotacoes: []
  };

  form.elements['entes[]'].forEach(function (item) {
    params.entes.push({
      id: item.dataset.ente,
      percentual: item.value
    });
  });

  form.elements['dotacoes[]'].forEach(function (item) {
    if (item.checked) {
      params.dotacoes.push(item.value);
    }
  });

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

function carregaEntesDotacoes(mes) {
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

    entes.forEach(function(ente, i) {

      var tr = ''
      + '<tr class="bg_' + (i % 2 == 0) + '">'
        + '<td class="th_titulo">' + ente.cgm + ' - ' + ente.nome + '</td>'
        + '<td>'
        + '<input value="' + ente.percentual + '" size="4" data-ente="' + ente.sequencial + '" name="entes[]"> %'
        + '</td>'
      + '</tr>';

      trs.push(tr);

    });

    tableEntes.innerHTML = trs.join('');

    if (entes.length == 0) {
      tableEntes.innerHTML = '<tr><td colspan="2">Nenhum ente encontrado</td></tr>';
    }

  });

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

function checkDotacoes(valor) {
  document.form1.elements['dotacoes[]'].forEach(function(x) {
    x.checked = !!valor;
  });
}

carregaEntesDotacoes('01');
carregarDotacoesParaRateio();

</script>
