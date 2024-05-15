<?
//echo '<pre>';ini_set("display_errors", true);
require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_app.utils.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("dbforms/db_classesgenericas.php");
require_once ("dbforms/db_funcoes.php");
require_once ("classes/db_orctiporec_classe.php");

$clrotulo = new rotulocampo;
$clrotulo->label("k17_codigo");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

if (isset($aFiltros['protocolo']) && !empty($aFiltros['protocolo'])) {
  $protocolo = $aFiltros['protocolo'];
}

if (isset($aFiltros['pesquisa']) && !empty($aFiltros['pesquisa'])) {
  $pesquisa = $aFiltros['pesquisa'];
}
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

<link href="estilos.css" rel="stylesheet" type="text/css">
<style>
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
  max-width: 49px;
}
.table .th_tipo {
  width: 300px;
  font-size: 12px;
}
.text-center {
  text-align: center;
}
#autorizacao {
    box-shadow: 0 0 0 0;
    border: 0 none;
    outline: 0;
    max-width: 30px;
    text-align: center;;
}
td{
  padding-top:20px;
}
#inserir{
  padding-left: 17px;
  padding-right: 17px;
  margin-top:4px;
  margin-left:12px;
}
input{
  width:78px;
}
.ancora{
  width: 11px;
  padding-left: 11px;
  padding-right: 7px;
}
</style>

</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc" onload="pesquisaProtocolo(document.form1.protocolo.value)">
<br><br>
<center>
<div style="width: 48%;">
<fieldset>
<legend><strong>Slip</strong></legend>
<form name="form1" method="post">
    <input type="hidden" name="protocolo" value="<?= $protocolo ?>">
    <input type="hidden" name="dattab">
    <input type="hidden" name="valtab">
    <table border='0'>
      <tr>
        <td width="20%"></td>
        <td align="left" nowrap title="<?=$Tk17_codigo?>">
           <? db_ancora(@$Lk17_codigo,"js_pesquisak17_codigo(true, k17_codigo_ini);",1);  ?>
        </td>
        <td align="left" nowrap>
          <?
            db_input('k17_codigo_ini',12,$Ik17_codigo,true,'text',$db_opcao," onchange='js_pesquisak17_codigo(false, k17_codigo_ini);'") ;
          ?>
        </td>
        <td class="ancora">
          <? db_ancora("à","js_pesquisak17_codigo(true, k17_codigo_fim);",1);  ?>
        </td>
        <td>
          <?
            db_input('k17_codigo_fim',12,$Ik17_codigo,true,'text',$db_opcao," onchange='js_pesquisak17_codigo(false, k17_codigo_fim);'") ;
          ?>
        </td>
        <td width="33%"></td>
      </tr>
      <tr>
        <td align="center" colspan="6">
          <input type="button" id="inserir" value="Incluir" onclick="incluir();">
        </td>
      </tr>
    </table>
    <br>
    <table class="table">
      <caption style="font-size: 15px; margin-bottom: 8px;"><strong>Protocolo: <?php echo $protocolo; ?></strong></caption>
        <thead>
          <tr>
            <th title="Marcar ou Desmarcar todos" style="width: 10px; cursor: pointer;" onclick="marcaTodos(true)">M</th>
            <th>Nº Slip</th>
            <th class="th_tipo">Nome/Razão Social</th>
            <th class="th_size">Data</th>
            <th class="th_size">Valor</th>
          </tr>
        </thead>

        <tbody id="table_slips">

        </tbody>
    </table>
    <td align="left">
      <input id="bt_excluir" style="margin-left: -3px; display: none" type="button" value="Remover" onclick="excluir(<?php echo $protocolo; ?>);">
      <?php if (db_getsession("DB_id_usuario") == 1 || ("DB_coddepto") == 10) : ?>
        <input id="bt_autorizar" style="margin-left: 3px; display: none" type="button" value="Liberar" onclick="autorizar(<?php echo $protocolo; ?>);">
      <?php endif ; ?>
    </td>
  </table>
</form>
</fieldset>
</div>
</center>
<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<script>

limpaCampos();

function limpaCampos(){
  let doc = document.form1;
  doc.k17_codigo_ini.value = ''
  doc.k17_codigo_fim.value = ''
}

//---slip 01
function js_pesquisak17_codigo(mostra, campo){

  if(campo.name == 'k17_codigo_ini'){
    if(mostra==true){
      js_OpenJanelaIframe('','db_iframe_slip_ini','func_slip.php?protocolo=1&funcao_js=parent.js_mostraslip1|k17_codigo|k17_data|k17_valor','Pesquisa',true);
    }else{
      slip01 = new Number(document.form1.k17_codigo_ini.value);
      if(slip01 != ""){
         js_OpenJanelaIframe('','db_iframe_slip_ini','func_slip.php?protocolo=1&pesquisa_chave='+slip01+'&funcao_js=parent.js_mostraslip_ini','Pesquisa',false);
      }else{
          document.form1.k17_codigo_ini.value='';
      }
    }
  }

  if(campo.name == 'k17_codigo_fim'){
    if(mostra==true){
      js_OpenJanelaIframe('','db_iframe_slip_fim','func_slip.php?protocolo=1&funcao_js=parent.js_mostraslip2|k17_codigo|k17_data|k17_valor','Pesquisa',true);
    }else{
      slip02 = new Number(document.form1.k17_codigo_fim.value);
      if(slip02 != ""){
         js_OpenJanelaIframe('','db_iframe_slip_fim','func_slip.php?protocolo=1&pesquisa_chave='+slip02+'&funcao_js=parent.js_mostraslip_fim','Pesquisa',false);
      }else{
          document.form1.k17_codigo_fim.value='';
      }
    }
  }

}
function js_mostraslip_ini(chave1, chave2, chave3, chave4, erro){
  document.form1.dattab.value   = chave3;
  document.form1.valtab.value   = chave4;
  if(erro==true){
    document.form1.k17_codigo_ini.focus();
    document.form1.k17_codigo_ini.value = '';
  }

}

function js_mostraslip1(chave1, chave2, chave3){
  document.form1.k17_codigo_ini.value = chave1;
  document.form1.dattab.value     = chave2;
  document.form1.valtab.value     = chave3;

  db_iframe_slip_ini.hide();
}

function js_mostraslip_fim(chave1, chave2, chave3, chave4, erro){
  document.form1.dattab.value   = chave3;
  document.form1.valtab.value   = chave4;
  if(erro==true){
    document.form1.k17_codigo_fim.focus();
    document.form1.k17_codigo_fim.value = '';
  }

}

function js_mostraslip2(chave1, chave2, chave3){
  document.form1.k17_codigo_fim.value = chave1;
  document.form1.dattab.value     = chave2;
  document.form1.valtab.value     = chave3;

  db_iframe_slip_fim.hide();
}


var table_slips = document.getElementById('table_slips');
function novoAjax(params, onComplete, async=true) {

  var request = new Ajax.Request('pro4_protocolos.RPC.php', {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: onComplete,
    asynchronous: async
  });

}

function pesquisaSlips(){
  let oParam = new Object();
  let doc = document.form1;

  if(doc.k17_codigo_ini.value){
    oParam.slip_ini = doc.k17_codigo_ini.value;
  }
  if(doc.k17_codigo_fim.value){
    oParam.slip_fim = doc.k17_codigo_fim.value;
  }

  if(parseInt(oParam.slip_ini) > parseInt(oParam.slip_fim)){
      alert('Valor do último slip é menor que o slip inicial');
      return false;
    }

  let listaSlips = [];

  oParam.exec = 'pesquisaSlips';
  novoAjax(oParam, function(e){
    let response = JSON.parse(e.responseText);
    listaSlips = [...response.slips];
  }, false);

  return listaSlips;
}

function incluir() {
  var doc = document.form1;
  var protocolo = document.form1.protocolo.value;
  var protocoloVazio    = protocolo == '';

  if (protocoloVazio) {
    alert('Ocorreu um erro na geração do protocolo!');
    return;
  }

  if (!doc.k17_codigo_ini.value && !doc.k17_codigo_fim.value) {
    alert('Informe um Slip!');
    return;
  }

  let aSlips = pesquisaSlips();
  let aCodSlips = [];

  aSlips.forEach(slip => {
    aCodSlips.push(slip.k17_codigo);
  });

  incluirSlip(protocolo, aSlips);

  if(aCodSlips.length == 100){
    alert(`Inseridos 100 registros do intervalo ${aCodSlips[0]} à ${aCodSlips[aCodSlips.length - 1]}`);
  }

}

function incluirSlip(iProtocolo, iSlip) {
  var params = {
    exec: 'insereSlip',
    protocolo: iProtocolo,
    slip: iSlip,
    instit: <?php echo db_getsession("DB_instit"); ?>
  };
  js_divCarregando('Aguarde', 'div_aguarde');
  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        pesquisaProtocolo(iProtocolo);
        document.form1.k17_codigo_ini.value = "";
        document.form1.k17_codigo_fim.value = "";
        document.form1.dattab.value     = "";
        document.form1.valtab.value     = "";
        document.getElementById('bt_excluir').style.display = "inline-block";
        js_removeObj('div_aguarde');
      } else {
          js_removeObj('div_aguarde');
          alert(oRetorno.erro);
        return;
      }
    });
}

function pesquisaProtocolo(protocolo) {

  var params = {
    exec: 'pesquisaSlipProtocolos',
    protocolo: protocolo
  };

  var trs = [];

  novoAjax(params, function(e) {

    var slips = JSON.parse(e.responseText).slips;

    slips.forEach(function(slip, i) {

      var cor = slip.autorizado == "t" ? " style=\"background-color:#D1F07C\"" : " style=\"background-color:#ffffff\"";
      var tr = ''
        + '<tr id="slip'+slip.autorizacao+'"'+cor+'>'
          + '<td class="text-center">'
            + '<input id=autorizacao value="' + slip.autorizacao + '" type="checkbox" class="ch_slips" name="slips[]">'
          + '</td>'
          + '<td style="width: 125px;" class="text-center">'   + slip.autorizacao + '</td>'
          + '<td>'     + slip.razao + '</td>'
          + '<td class="text-center">'   + slip.emissao + '</td>'
          + '<td style="width: 80px;" class="text-center">R$ ' +  number_format(slip.valor, 2, ',', '.') + '</td>'
        + '</tr>';

        trs.push(tr);

    });

    table_slips.innerHTML = trs.join('');
    var usuario = JSON.parse(e.responseText).id_usuario;
    var id_sessao = <?php echo db_getsession("DB_id_usuario"); ?>;
    var id_depart = <?php echo db_getsession("DB_coddepto"); ?>;

    if (usuario == id_sessao || id_sessao == 1) {
        document.getElementById('inserir').style.display = "inline-block";
        if (slips.length == 0) {
          table_slips.innerHTML = '<tr><td class="text-center" colspan="5">Nenhum Slip foi inserido neste protocolo!</td></tr>';
          document.getElementById('bt_excluir').style.display = "none";
          if (id_depart == 10 || id_depart == 31 || id_sessao == 1) {
            document.getElementById('bt_autorizar').style.display = "none";
          }
        } else {
            document.getElementById('bt_excluir').style.display = "inline-block";
            if (id_depart == 10 || id_depart == 31 || id_sessao == 1) {
              document.getElementById('bt_autorizar').style.display = "inline-block";
            }
        }
    } else {
        if (slips.length == 0) {
          table_slips.innerHTML = '<tr><td class="text-center" colspan="5">Nenhum Slip foi inserido neste protocolo!</td></tr>';
          document.getElementById('bt_excluir').style.display = "none";
          if (id_depart == 10 || id_depart == 31 || id_sessao == 1) {
            document.getElementById('bt_autorizar').style.display = "none";
          }
        } else {
          document.getElementById('bt_excluir').style.display = "none";
          document.getElementById('inserir').style.display = "none";
          if (id_depart == 10 || id_depart == 31 || id_sessao == 1) {
              document.getElementById('bt_autorizar').style.display = "none";
          }
        }
    }

  });
}

function excluir(protocolo) {
  var ckslips  = verificaSlips();
  if (ckslips == false) {
    alert('Selecione um Slip!');
    return;
  }

  var recslips = document.querySelectorAll('.ch_slips');
  var slips = [];

  recslips.forEach(function (item) {
    if (item.checked) {
      slips.push(item.value);
    }
  });

  var params = {
    exec: 'excluirSlips',
    slips: slips,
    protocolo:protocolo
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
    if (oRetorno.status == 1) {
      recslips.forEach(function (item) {
        if (item.checked) {
          document.getElementById('slip'+item.value).remove();
        }
      });
    } else {
      alert(oRetorno.erro);
      return;
    }
  });
}

function verificaSlips() {

  var slips = document.form1.elements['slips[]'];
  var temMarcado = false;

  if (slips) {
    if (slips['forEach']) {
      slips.forEach(function (item) {
        if (!!item.checked) {
          temMarcado = true;
        }
      });

    }
    else {
      if (!!slips.checked) {
        temMarcado = true;
      }
    }
  }

  return temMarcado;
}

function autorizar(protocolo) {
  var ckslips  = verificaSlips();
  if (ckslips == false) {
    alert('Selecione um Slip!');
    return;
  }

  var recslips = document.querySelectorAll('.ch_slips');
  var slips = [];

  recslips.forEach(function (item) {
    if (item.checked) {
      slips.push(item.value);
    }
  });

  var params = {
    exec: 'autorizacaoSlips',
    slips: slips,
    protocolo:protocolo
  };

  js_divCarregando('Aguarde', 'div_aguarde');
  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
    if (oRetorno.status == 1) {
      pesquisaProtocolo(protocolo);
      js_removeObj('div_aguarde');
    } else {
      js_removeObj('div_aguarde');
      alert(oRetorno.erro);
      return;
    }
  });
}

function marcaTodos(valor) {

  var slips = document.form1.elements['slips[]'];
  if (slips) {
    if (slips['forEach']) {
      slips.forEach(function (item) {
        if (!!item.checked) {
          valor = false
          item.checked = !!valor;
        } else {
            item.checked = !!valor;
          }
      });

    } else {
        if (!!slips.checked) {
            valor = false
            slips.checked = !!valor;
        } else {
              slips.checked = !!valor;
          }
      }
  }
}

function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number+'').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

</script>
</body>
</html>
