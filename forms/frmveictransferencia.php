<style type="text/css">

legend {
  font-size: 15px;
}

div .formatdiv{
  margin-top: 5px;
  margin-bottom: 10px;
  padding-left: 5px;
}

.formatstrong {
  margin-left: 5px;
}

.formatselect {
  width: 280px;
  height: 18px;

}

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
  padding: 3px 7px;
  border: 1px solid #bbb;
}
.table th {
  background-color: #ddd;
}
.th_size {
  font-size: 12px;
}
.table .th_tipo {
  width: 450px;
  font-size: 12px;
}
#formatspan{
  float: right;
  margin-right: 40px;
  font-weight: bold;
}
#mdtodos{
  display: none;
}

.button{
  padding: 5px;
}

</style>
<script>
  function Contador(field,MaxLength) {
      obj = document.all(field);
        if (MaxLength !=0) {
          if (obj.value.length > MaxLength)  {
            obj.value = obj.value.substring(0, MaxLength);
          }
        }
        document.form1.motivo.value = obj.value.length + '/300';
  } </script>
<form name="form1" method="post" action="">
  <center>
    <fieldset>
      <legend>Dados da transferência</legend>
        <div class="formatdiv" align="left">
          <strong>Data Transferência:&nbsp;</strong>
            <span style='width: 270px;'>
              <? db_inputdata('data',@$dia,@$mes,@$ano,true,'text',$db_opcao,"style='height:25px'") ?>
          </span>
        </div>

        <div class="formatdiv" align="left">
          <strong style="margin-right: 15px;">Departamento Atual:&nbsp;</strong>
          <select name="departamento_atual" onchange="carregaVeiculos(this.value);" class="formatselect">
              <option value="">SELECIONE...</option>
                <?php foreach ($aDepartamentos as $aDepartamento) : ?>
                  <option value="<?= $aDepartamento->coddepto ?>"
                  <?php
                    $depart = db_getsession('DB_coddepto');
                    echo $depart == $aDepartamento->coddepto ? 'selected' : '';
                  ?>>
                    <?= $aDepartamento->descrdepto ?>
                  </option>
                <?php endforeach; ?>
          </select>

          <strong class="formatstrong">Departamento Destino:&nbsp;</strong>
          <select name="departamento_destino" class="formatselect">
              <option value="" selected>SELECIONE...</option>
              <?php foreach ($aDepartamentos as $aDepartamento) : ?>
                  <option value="<?= $aDepartamento->coddepto ?>">
                    <?= $aDepartamento->descrdepto ?>
                  </option>
                <?php endforeach; ?>
          </select>
        </div>
        <div align="left"><strong class="formatstrong">Motivo:&nbsp;</strong></div>
        <div class="formatdiv" align="left">
          <textarea style="width: 805px;" maxlength="150" name="motivo"></textarea>
          <p>
            <span id="carResTxt" style="font-weight: bold;">150</span> Caracteres Restantes
          </p>
        </div>
    </fieldset>

    <fieldset>
      <legend>Veículos</legend>
      <table class="table">
          <thead>
            <tr>
              <th title="Marcar ou Desmarcar todos" class="th_size" style="cursor: pointer;" onclick="marcaVeiculos(true)">M</th>
              <th class="th_size">Código do Veículo</th>
              <th class="th_size">Placa</th>
              <th class="th_tipo">Tipo</th>
              <th class="th_size">Código Anterior</th>
              <th class="th_size">Unidade Anterior</th>
            </tr>
          </thead>

          <tbody id="table_veiculos">

          </tbody>
      </table>

      <div id="mdtodos" class="text-center">
          <input type="button" value="Processar" onclick="insereTransferencia();">
      </div>
      <span id="formatspan"> </span>
    </fieldset>
  </center>
  </form>

<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>

<script type="text/javascript">

var tableVeiculos = document.getElementById('table_veiculos');

function novoAjax(params, onComplete) {

  var request = new Ajax.Request('vei4_baixatransferencia.RPC.php', {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: onComplete
  });

}

function carregaVeiculos(departamento_atual) {

  js_divCarregando('Aguarde', 'div_aguarde');
  var params = {
    exec: 'buscaVeiculosDepartamentos',
    departamento_atual: departamento_atual
  };

  novoAjax(params, function(e) {

    var veiculos = JSON.parse(e.responseText).veiculos;
    var trs   = [];

    tableVeiculos.innerHTML = '<tr><td colspan="2">' + veiculos.join('') + '</td></tr>';

    veiculos.forEach(function(veiculo, i) {

      var tr = ''
      + '<tr class="bg_' + (i % 2 == 0) + '">'
        + '<td class="text-center">'
          + '<input value="' + veiculo.codigo + '" type="checkbox" name="veiculos[]">'
        + '</td>'
        + '<td class="text-center">'   + veiculo.codigo          + '</td>'
        + '<td class="th_titulo">'     + veiculo.placa           + '</td>'
        + '<td class="text-center">'   + veiculo.tipo            + '</td>'
        + '<td class="text-center">'   + veiculo.condigoAnterior + '</td>'
        + '<td class="text-center">'   + veiculo.unidadeAnterior + '</td>'
      + '</tr>';

      trs.push(tr);

    });

    js_removeObj('div_aguarde');

    tableVeiculos.innerHTML = trs.join('');
    var totalreg = document.getElementById('formatspan');
    if (veiculos.length == 0) {
      tableVeiculos.innerHTML = '<tr><td colspan="6">Nenhum veículo encontrado para o Departamento selecionado!</td></tr>';
      totalreg.innerHTML      = "";
      document.getElementById('mdtodos').style.display = "none";
    }

    else {
       totalreg.innerHTML = "Total de Registros: " + veiculos.length;
       document.getElementById('mdtodos').style.display = "block";
    }

  });

}

function insereTransferencia() {

  var atual    = document.form1.departamento_atual.value;
  var destino  = document.form1.departamento_destino.value;
  var data     = document.form1.data.value;
  var motivo   = document.form1.motivo.value;

  var destinoVazio = destino == '';
  var dataVazio    = data    == '';
  var motivoVazio  = motivo  == '';
  var ckveiculos   = verificaVeiculos();


  if (destinoVazio) {
    alert('Informe Departamento destino!');
    return;
  }

  else if (atual == destino) {
    alert('Departamento atual e destino não podem ser iguais!');
    document.form1.departamento_destino.value = "";
    return;
  }

  else if (dataVazio) {
    alert('Informe data da transferência!');
    return;
  }

  else if (motivoVazio) {
    alert('Informe motivo da transferência!');
    return;
  }

  else if (ckveiculos == false) {
    alert('Informe o(s) veículo(s) para transferência!');
    return;
  }

  else{
    var recVeiculos = document.form1.elements['veiculos[]'];
    var veiculos = [];
      if (recVeiculos) {
      if (recVeiculos['forEach']) {

        recVeiculos.forEach(function (item) {
          if (item.checked) {
              veiculos.push(item.value);
          }
        });

      } else {

        if (recVeiculos.checked) {
            veiculos.push(recVeiculos.value);
        }

      }
    }
    transferenciaVeiculo(veiculos, atual, destino, data, motivo);
  }

}

function transferenciaVeiculo(iVeiculos, iAtual, iDestino, iData, iMotivo) {

  js_divCarregando('Aguarde', 'div_aguarde');
  var params = {
    exec: 'insereTransfVeiculo',
    veiculos: iVeiculos,
    departamento_atual: iAtual,
    departamento_destino: iDestino,
    data: iData,
    motivo: iMotivo
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        js_removeObj('div_aguarde');
        alert('Autorização de transferência realizada com sucesso!');
        comprovante(oRetorno);
      } else {
          js_removeObj('div_aguarde');
          alert(oRetorno.erro);
        return;
      }
    });
}

function verificaVeiculos() {

  var veiculos = document.form1.elements['veiculos[]'];
  var temMarcado = false;

  if (veiculos) {
    if (veiculos['forEach']) {
      veiculos.forEach(function (item) {
        if (!!item.checked) {
          temMarcado = true;

        }
      });

    }
    else {
      if (!!veiculos.checked) {
        temMarcado = true;
      }
    }
  }

  return temMarcado;
}

function marcaVeiculos(valor) {

  var veiculos = document.form1.elements['veiculos[]'];
  if (veiculos) {
    if (veiculos['forEach']) {
      veiculos.forEach(function (item) {
        if (!!item.checked) {
          valor = false
          item.checked = !!valor;
        } else {
            item.checked = !!valor;
          }
      });

    } else {
        if (!!veiculos.checked) {
            valor = false
            item.checked = !!valor;
        } else {
              item.checked = !!valor;
          }
      }
  }

}

function limparCampos() {
  document.form1.data.value   = "";
  document.form1.motivo.value = "";
  document.form1.departamento_atual.value = "";
  document.form1.departamento_destino.value = "";
  document.form1.departamento_atual.onchange;
  carregaVeiculos();
}

function comprovante(oRetorno) {
  var imprimi = confirm("Deseja imprimir comprovante?");
  if (imprimi == true) {
    var query = "";
      query += ("&transferencias=" + oRetorno.transferencia.ve80_sequencial),

      jan = window.open(
        "vei2_comptransfveiculos002.php?" + query,
        "",
        'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0'
      );
      jan.moveTo(0,0);
      limparCampos();
      return;
  } else {
    limparCampos();
    return;
  }
}


var textarea = document.querySelector('textarea');
var res = document.getElementById('carResTxt');
var limiter = 150;
textarea.addEventListener('keyup', verificar);

function verificar(e) {
    var qtdcaracteres = this.value.length;
    var restantesr = limiter - qtdcaracteres;

    if (restantesr < 1) {
        this.value = this.value.slice(0, limiter);
        return res.innerHTML = 0;
    }

    res.innerHTML = restantesr;
}

</script>
