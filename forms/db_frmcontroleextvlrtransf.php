<?
//MODULO: caixa
$clcontroleextvlrtransf->rotulo->label();

// print_r($_GET);
// print_r($_POST);

if (isset($controleext)) {
  $k168_codprevisao = $controleext;
}

if (isset($mes_compet)) {
  $k168_mescompet = $mes_compet;
}

$aMeses = array(
  1 => 'Janeiro',
    'Fevereiro',
    'Março',
    'Abril',
    'Maio',
    'Junho',
    'Julho',
    'Agosto',
    'Setembro',
    'Outubro',
    'Novembro',
    'Dezembro'
);

db_fieldsmemory(db_query("SELECT k167_codcon FROM controleext WHERE k167_sequencial = {$k168_codprevisao}"));

?>
<fieldset>
  <legend>Controle de Recebimentos Mensais</legend>

  <form name="form1" method="post" action="">
    <input title="k168_codprevisao:k167_sequencial" name="k168_codprevisao" id="k168_codprevisao" value="<?= $k168_codprevisao ?>" type="hidden">

    <input name="cod_conta" id="cod_conta" value="<?= $k167_codcon ?>" type="hidden">

    <table>
      <tr>
        <td nowrap title="<?=@$Tk168_mescompet?>" style='width: 260px;'>
          <?=@$Lk168_mescompet?>
          <?php db_select('k168_mescompet', $aMeses, true, 2, "onchange='js_trocaMes(this.value, {$k168_codprevisao})'"); ?>
        </td>

        <td nowrap title="<?=@$Tk168_previni?>" style='width: 270px;'>
          <b>Previsão de recebimento:</b>
          <? db_inputdata('k168_previni',@$k168_previni_dia,@$k168_previni_mes,@$k168_previni_ano,true,'text',$db_opcao,"") ?>
        </td>

        <td nowrap title="<?=@$Tk168_prevfim?>" style='width: 135px;text-align: right;'>
          <b>à:</b>
          <? db_inputdata('k168_prevfim',@$k168_prevfim_dia,@$k168_prevfim_mes,@$k168_prevfim_ano,true,'text',$db_opcao,"") ?>
        </td>
      </tr>

      <tr>
        <td nowrap title="<?=@$Tk168_vlrprev?>" colspan='2' style='text-align: right;'>
          <?=@$Lk168_vlrprev?>
        </td>
        <td>
          <? db_input('k168_vlrprev',22,$Ik168_vlrprev,true,'text',$db_opcao,"") ?>
        </td>
      </tr>
    </table>
    <input name="<?= ($db_opcao == 1 ? "incluir" : "alterar") ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : "Alterar") ?>" <?= ($db_botao == false ? "disabled" : "") ?> >
  </form>

  <div id='lancamentos_recebidos'>

    <table id='quadro_lancamentos'>

    </table>

    <p style='text-align: right;'>
      <b>Total de recebimentos no mês</b>
      <span id='valor_total'>
      </span>
    </p>
  </div>

</fieldset>

<style type="text/css">
#lancamentos_recebidos {
  border: 1px solid #999;
  padding: 10px;
  display: none;
  margin-top: 25px;
}

#lancamentos_recebidos.mostra {
  display: block;
}

#lancamentos_recebidos > p {
  margin: 0;
}

#valor_total {
  border: 1px solid #999999;
  padding: 3px 10px 3px 15px;
  background: #fff;
  box-shadow: inset 1px 1px 2px #ccc;
  border-radius: 3px;

}

.align-right {
  text-align: right;
}

#quadro_lancamentos {
  width: 100%;
  border: 1px solid #999;
  margin-bottom: 15px;
  border-collapse: collapse;
  background-color: #fff;
}
#quadro_lancamentos th,
#quadro_lancamentos td {
  border: 1px solid #999;
  padding: 5px;
}
#quadro_lancamentos th {
  background-color: #cbcbcb;
}
#quadro_lancamentos td {}
</style>

<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>

<script type="text/javascript">

function js_trocaMes(mes, previsao) {
  js_OpenJanelaIframe(
    '',
    'db_iframe_controleextvlrtransf',
    'func_controleextvlrtransf.php?'
      + 'pesquisa_chave=<?= $k168_codprevisao ?>'
      + '&mes_compet=' + document.form1.k168_mescompet.value
      + '&funcao_js=parent.js_preenchepesquisa',
    'Pesquisa',
    false
  );
}

function js_preenchepesquisa(chave1, erro) {

  if (erro === true) {
    location.href = 'cai1_controleextvlrtransf001.php?controleext=<?= $k168_codprevisao ?>&mes_compet=' + document.form1.k168_mescompet.value;
    return false;
  }

  location.href = 'cai1_controleextvlrtransf002.php?controleext=<?= $k168_codprevisao ?>&mes_compet=' + chave1;

}

function js_preencheQuadroLancamentos(e) {

  var lancamentos = JSON.parse(e.responseText).lancamentos;
  var lancamentosRecebidos = document.getElementById('lancamentos_recebidos');
  var objLancamentos = {
    total: 0,
    trs: []
  };

  var ths = '';
  ths += '<tr>'
  ths += '<th>LANÇAMENTO</th>';
  ths += '<th>COD. SLIP</th>';
  ths += '<th>DT. RECEBIMENTO</th>';
  ths += '<th>VALOR RECEBIDO (R$)</th>';
  ths += '</tr>';

  if (lancamentos.length > 0) {
    objLancamentos = lancamentos.reduce(function(obj, lancamento) {
      var tr = "";
      tr += '<tr>';
      tr += '<td>' + lancamento.lancamento + '</td>';
      tr += '<td>' + lancamento.cod_slip + '</td>';
      tr += '<td>' + js_formatar(lancamento.data_recebimento, 'd') + '</td>';
      tr += '<td class="align-right">' + js_formatar(lancamento.valor_recebido, 'f') + '</td>';
      tr += '</tr>';

      obj.total += Number(lancamento.valor_recebido);
      obj.trs.push(tr);

      return obj;

    }, objLancamentos);

    lancamentosRecebidos.classList.add('mostra');
  } else {
    lancamentosRecebidos.classList.remove('mostra');
  }

  document.getElementById('quadro_lancamentos').innerHTML = ths + objLancamentos.trs.join('');
  document.getElementById('valor_total').innerHTML = 'R$ ' + js_formatar(objLancamentos.total, 'f');

}

(function buscaLancamentos() {
  var params = {
    exec: 'buscaLancamentos',
    datas: {
      inicio: document.getElementById('k168_previni').value,
      final:  document.getElementById('k168_prevfim').value,
    },
    mes: document.getElementById('k168_mescompet').value,
    conta: document.getElementById('cod_conta').value
  };

  var request = new Ajax.Request("cai4_processarext.RPC.php", {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: js_preencheQuadroLancamentos
  });
})();

</script>
