<?php

require_once("classes/db_tipodereceitarateio_classe.php");

//MODULO: contabilidade
$clentesconsorciadosreceitas->rotulo->label();

$cltipodereceitarateio = new cl_tipodereceitarateio();

?>

<style type="text/css">
#tabela_receitas {
  border: 1px solid #bbb;
  border-collapse: collapse;
  background-color: #fff;
}
#tabela_receitas th,
#tabela_receitas td {
  padding: 6px 13px;
  border: 1px solid #bbb;
}
#tabela_receitas th {
  background-color: #ddd;
}
</style>

<center>
  <fieldset>
    <legend>Tipos de receita</legend>
    <form name="form2" method="post" action="" onsubmit="salvarReceita(this); return false;">
      <?php db_input('c216_sequencial',11,$Ic216_sequencial,true,'hidden',1,""); ?>
      <table border="0">

        <?php if (isset($clentesconsorciados)): ?>

          <tr>
            <td colspan="2">
              <input type="hidden" name="c216_enteconsorciado" value="<?= $c215_sequencial ?>">
            </td>
          </tr>

        <?php else: ?>

          <tr>
            <td nowrap title="<?=@$Tc216_enteconsorciado?>">
               <?=@$Lc216_enteconsorciado?>
            </td>
            <td>
              <?
              db_input('c216_enteconsorciado',11,$Ic216_enteconsorciado,true,'text',1,"")
              ?>
            </td>
          </tr>

        <?php endif; ?>

        <tr>
          <td nowrap title="<?=@$Tc216_tiporeceita?>">
            <?=@$Lc216_tiporeceita?>
          </td>
          <td>
            <?php

              $aTipos     = array();
              $sSQLTipos  = $cltipodereceitarateio->sql_query(null, 'c218_codigo, c218_descricao');
              $rsTipos    = $cltipodereceitarateio->sql_record($sSQLTipos);
              $aRetornoTipos = db_utils::getCollectionByRecord($rsTipos);

              foreach ($aRetornoTipos as $oTipo) {
                $aTipos[$oTipo->c218_codigo] = $oTipo->c218_descricao;
              }

              db_select('c216_tiporeceita', $aTipos, true, 1);

            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tc216_receita?>">
            <?php db_ancora('Código Receita:',"js_pesquisac216_receita(true);",1); ?>
          </td>
          <td>
            <?
            db_input('c216_receita',11,$Ic216_receita,true,'text',1," onchange='js_pesquisac216_receita(false);'")
            ?>
            <input type="text" name="o57_descr" id="o57_descr" size="40" readonly="" style="background-color:#DEB887;">
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tc216_saldo3112?>">
             <strong>Saldo inicial:</strong>
          </td>
          <td>
      <?
      db_input('c216_saldo3112',11,$Ic216_saldo3112,true,'text',1,"")
      ?>
          </td>
        </tr>
         <tr>
          <td nowrap title="<?=@$Tc216_percentual?>">
             <strong>Percentual:</strong>
          </td>
          <td>
      <?
      db_input('c216_percentual',11,$Ic216_percentual,true,'text',1,"")
      ?>
          </td>
        </tr>
      </table>

      <input name="incluir" type="submit" id="db_opcao" value="Incluir">
    </form>

    <table id="tabela_receitas">

    </table>

  </fieldset>
</center>

<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>

<script>

function js_pesquisac216_receita(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_receita','func_orcfontes.php?funcao_js=parent.js_mostrareceita1|o57_codfon|o57_descr','Pesquisa',true);
  }else{
     if(document.form2.c216_receita.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_receita','func_orcfontes.php?pesquisa_chave='+document.form2.c216_receita.value+'&funcao_js=parent.js_mostrareceita&lPesquisaCodigo=true','Pesquisa',false);
     }else{
       document.form2.o57_descr.value = '';
     }
  }
}
function js_mostrareceita(chave,erro){
  document.form2.o57_descr.value = chave;
  if(erro==true){
    document.form2.c216_receita.focus();
    document.form2.c216_receita.value = '';
  }
}
function js_mostrareceita1(chave1,chave2){
  document.form2.c216_receita.value = chave1;
  document.form2.o57_descr.value = chave2;
  db_iframe_receita.hide();
}


function pesquisarEnteConsorciadoReceita(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_entesconsorciadosreceitas','func_entesconsorciadosreceitas.php?funcao_js=parent.preencheEnteConsorciadoReceita|c216_sequencial','Pesquisa',true);
}
function preencheEnteConsorciadoReceita(chave){
  db_iframe_entesconsorciadosreceitas.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}


function getTipo(n) {

  var aTipos = {};

  <?php

  foreach ($aTipos as $key => $sTipo) {
    echo "aTipos[\"{$key}\"] = '{$sTipo}';";
  }

  ?>

  return aTipos[n] ? aTipos[n] : null;

}

function urlProcessar() {
  return "con4_processartiposreceita.RPC.php";
}


function salvarReceita(form) {

  if (!form.c216_tiporeceita.value
    || !form.c216_saldo3112.value
    || !form.c216_receita.value) {

    alert("Preencha os dados corretamente");

    return false;

  }

  var params = {
    exec: 'adicionarReceita',
    dados: {
      sequencial: form.c216_sequencial.value,
      enteConsorciado: form.c216_enteconsorciado.value,
      tipoReceita: form.c216_tiporeceita.value,
      receita: form.c216_receita.value,
      saldo: form.c216_saldo3112.value,
      percentual: form.c216_percentual.value
    }
  };

  var request = new Ajax.Request(urlProcessar(), {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: retornoReceita
  });

}

function retornoReceita(r) {

  var retorno = JSON.parse(r.responseText);

  if (!!retorno.erro) {

    alert(retorno.erro);
    return false;

  } else if (retorno.atualizar) {

    alert(retorno.msg);
    buscaReceitasCadastradas(<?= $c215_sequencial ?>);

  }

}


function carregaTabelaReceitas(r) {

  var dados = JSON.parse(r.responseText).receitas;
  var receitas = document.getElementById('tabela_receitas');
  var aTRs = [];

  var ths = '';
  ths += '<tr>';
  ths += '<th>Tipos</th>';
  ths += '<th>Receita</th>';
  ths += '<th>Saldo</th>';
  ths += '<th>Percentual</th>';
  ths += '<th>Ação</th>';
  ths += '</tr>';

  if (dados.length > 0) {
    dados.forEach(function(receita) {

      var tr = "";
      tr += '<tr>';
      tr += '<td>' + getTipo(receita.tipo) + '</td>';
      tr += '<td>' + receita.codReceita + ' - ' + receita.descReceita + '</td>';
      tr += '<td class="align-right">' + js_formatar(receita.saldo, 'f') + '</td>';
      tr += '<td class="align-right">' + js_formatar(receita.percentual, 'f') + '</td>';
      tr += '<td><input type="button" onclick="excluirReceita(' + receita.sequencial + ');" value="Excluir"></td>';
      tr += '</tr>';

      aTRs.push(tr);

    });
  }

  receitas.innerHTML = ths + aTRs.join('');
}

function excluirReceita(codigo) {

  var params = {
    exec: 'excluirReceita',
    codigo: codigo
  };

  var request = new Ajax.Request(urlProcessar(), {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: retornoReceita
  });

}

function buscaReceitasCadastradas(codigo) {

  document.form2.c216_tiporeceita.value = '';
  document.form2.c216_sequencial.value = '';
  document.form2.c216_saldo3112.value = '';
  document.form2.c216_receita.value = '';
  document.form2.o57_descr.value = '';
  document.form2.c216_percentual.value = '';

  var params = {
    exec: 'buscaReceitasCadastradas',
    enteConsorciado: codigo
  };

  var request = new Ajax.Request(urlProcessar(), {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: carregaTabelaReceitas
  });

}

buscaReceitasCadastradas(<?= $c215_sequencial ?>);

</script>
