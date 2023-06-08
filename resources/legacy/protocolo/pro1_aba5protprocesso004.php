<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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
//echo '<pre>'; ini_set("display_errors",1);
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_liborcamento.php");
require_once("classes/db_empempenho_classe.php");
require_once("classes/db_orcdotacao_classe.php");
require_once("classes/db_pcmater_classe.php");
require_once("classes/db_cgm_classe.php");
require_once("libs/db_app.utils.php");
require_once("libs/JSON.php");

$clempempenho = new cl_empempenho;
$clpcmater  = new cl_pcmater;
$clcgm    = new cl_cgm;

$clrotulo = new rotulocampo;
$clrotulo->label("o40_descr");
$clrotulo->label("e53_codord");
$clpcmater->rotulo->label();
$clcgm->rotulo->label();

$clempempenho->rotulo->label();

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS['QUERY_STRING'], $aFiltros);

if (isset($aFiltros['protocolo']) && !empty($aFiltros['protocolo'])) {
  $protocolo = $aFiltros['protocolo'];
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
    text-align: center;
}
#inserir{
  padding-left: 17px;
  padding-right: 17px;
  margin-top: 4px;
}
input{
  width:78px;
}
.formulario{
  width: 100%;
}
.ancora{
  width: 16px;
  padding-left:7px;
}
td{
  padding-top: 6px;
}
</style>

</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc" onload="pesquisaProtocolo(document.form1.protocolo.value)">
<br><br>
<center>
<div style="width: 48%;">
<fieldset>
<legend><strong>Ordem de Pagamento</strong></legend>
<form name="form1" method="post">
    <input type="hidden" name="protocolo" value="<?= $protocolo ?>">
    <input type="hidden" name="dattab">
    <input type="hidden" name="valtab">
<table border='0'>
    <table border='0' class="formulario">
      <tr>
        <br/>
        <td width="26%"></td>
        <td align="right" nowrap title="<?=$Te53_codord?>">
          <? db_ancora(@$Le53_codord,"js_buscae53_codord(true, e53_codord_ini)",1); ?>
        </td>
        <td align="left" nowrap>
          <?
            db_input("e53_codord_ini",12,$Ie53_codord,true,"text", 12,"onchange='js_buscae53_codord(false, e53_codord_ini);'");
          ?>
        </td>
        <td class="ancora">
          <? db_ancora("à","js_buscae53_codord(true, e53_codord_fim)",1); ?>
        </td>

        <td>
          <?
            db_input("e53_codord_fim",12,$Ie53_codord,true,"text", 12,"onchange='js_buscae53_codord(false, e53_codord_fim);'");
          ?>
        </td>
        <td width="34%"></td>
      </tr>

      <tr>
        <td align="center" colspan="6">
          <br/>
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
            <th>Nº Ord. Pagamento</th>
            <th class="th_tipo">Nome/Razão Social</th>
            <th class="th_size">Data</th>
            <th class="th_size">Valor</th>
          </tr>
        </thead>

        <tbody id="table_autpagamentos">

        </tbody>
    </table>

    <input id="bt_excluir" style="margin-left: -3px; display: none" type="button" value="Remover" onclick="excluir(<?php echo $protocolo; ?>);">
    <?php if (db_getsession("DB_id_usuario") == 1 || ("DB_coddepto") == 10) : ?>
      <input id="bt_autorizar" style="margin-left: 3px; display: none" type="button" value="Liberar" onclick="autorizar(<?php echo $protocolo; ?>);">
    <?php endif ; ?>
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
  doc.e53_codord_ini.value = '';
  doc.e53_codord_fim.value = '';
}

function js_buscae53_codord(mostra, campo){

  if(campo.name == 'e53_codord_ini'){
    if(mostra==true){
      js_OpenJanelaIframe('','db_iframe_pagordemele_ini','func_prot_pagordemele.php?funcao_js=parent.js_mostracodord1|e53_codord|e50_data|e53_valor','Pesquisa',true);
    }else{
       if(document.form1.e53_codord_ini.value != ''){
          js_OpenJanelaIframe('','db_iframe_pagordemele1','func_prot_pagordemele.php?prot=1&pesquisa_chave='+document.form1.e53_codord_ini.value+'&funcao_js=parent.js_mostracodord_ini','Pesquisa',false);
       }
    }
  }

  if(campo.name == 'e53_codord_fim'){
    if(mostra==true){
      js_OpenJanelaIframe('','db_iframe_pagordemele_fim','func_prot_pagordemele.php?funcao_js=parent.js_mostracodord2|e53_codord|e50_data|e53_valor','Pesquisa',true);
    }else{
       if(document.form1.e53_codord_fim.value != ''){
          js_OpenJanelaIframe('','db_iframe_pagordemele2','func_prot_pagordemele.php?prot=1&pesquisa_chave='+document.form1.e53_codord_fim.value+'&funcao_js=parent.js_mostracodord_fim','Pesquisa',false);
       }
    }
  }

}

function js_mostracodord_ini(chave1, chave2, chave3, chave4, erro){
  document.form1.e53_codord_ini.value   = chave1;
  document.form1.dattab.value       = chave3;
  document.form1.valtab.value       = chave4;
  if(erro==true){
    document.form1.e53_codord_ini.focus();
    document.form1.e53_codord_ini.value = '';
  }
}

function js_mostracodord1(chave1, chave2, chave3, chave4){
  document.form1.e53_codord_ini.value   = chave1;
  document.form1.dattab.value       = chave3;
  document.form1.valtab.value       = chave4;
  db_iframe_pagordemele_ini.hide();

}

function js_mostracodord_fim(chave1, chave2, chave3, chave4, erro){
  document.form1.e53_codord_fim.value   = chave1;
  document.form1.dattab.value       = chave3;
  document.form1.valtab.value       = chave4;
  if(erro==true){
    document.form1.e53_codord_fim.focus();
    document.form1.e53_codord_fim.value = '';
  }
}

function js_mostracodord2(chave1, chave2, chave3, chave4){
  document.form1.e53_codord_fim.value   = chave1;
  document.form1.dattab.value       = chave3;
  document.form1.valtab.value       = chave4;
  db_iframe_pagordemele_fim.hide();

}

var table_autpagamentos = document.getElementById('table_autpagamentos');
function novoAjax(params, onComplete, async=true) {

  var request = new Ajax.Request('pro4_protocolos.RPC.php', {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: onComplete,
    asynchronous: async
  });

}

function pesquisaOrdens(){
  let oParam = new Object();
  let doc = document.form1;

  if(doc.e53_codord_ini.value){
    oParam.ordem_ini = doc.e53_codord_ini.value;
  }
  if(doc.e53_codord_fim.value){
    oParam.ordem_fim = doc.e53_codord_fim.value;
  }

  if(parseInt(oParam.ordem_ini) > parseInt(oParam.ordem_fim)){
      alert('Valor da última ordem é menor que a ordem inicial');
      return false;
    }

  let listaOrdens = [];

  oParam.exec = 'pesquisaOrdens';
  novoAjax(oParam, function(e){
    let response = JSON.parse(e.responseText);
    listaOrdens = [...response.ordens];
  }, false);

  return listaOrdens;
}

function incluir() {
  let doc = document.form1;
  var protocolo      = doc.protocolo.value;
  var protocoloVazio = protocolo == '';

  if (protocoloVazio) {
    alert('Ocorreu um erro na geração do protocolo!');
    return;
  }

  if (!doc.e53_codord_ini.value && !doc.e53_codord_fim.value) {
    alert('Informe pelo menos uma ordem de pagamento!');
    return;
  }

  let aOrdens = pesquisaOrdens();
  let aCodOrdens = [];

  aOrdens.forEach(ordem => {
    aCodOrdens.push(ordem.e53_codord);
  });

  incluirAutPagamento(protocolo, aOrdens);

  if(aCodOrdens.length == 100){
    alert(`Intervalo de 100 registros inseridos ${aCodOrdens[0]} à ${aCodOrdens[aCodOrdens.length - 1]}`);
  }
}

function incluirAutPagamento(iProtocolo, iAutPagamento) {
  var params = {
    exec: 'insereAutPagamento',
    protocolo: iProtocolo,
    autpagamento: iAutPagamento,
    instit: <?php echo db_getsession("DB_instit"); ?>
  };
  js_divCarregando('Aguarde', 'div_aguarde');
  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        pesquisaProtocolo(iProtocolo);
        document.form1.e53_codord_ini.value = "";
        document.form1.e53_codord_fim.value = "";
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
    exec: 'pesquisaAutPagProtocolos',
    protocolo: protocolo
  };

  var trs = [];

  novoAjax(params, function(e) {

    var autpagamentos = JSON.parse(e.responseText).autpagamentos;

    autpagamentos.forEach(function(autpagamento, i) {
      var cor = autpagamento.autorizado == "t" ? " style=\"background-color:#D1F07C\"" : " style=\"background-color:#ffffff\"";
      var tr = ''
        + '<tr id="autpagamento'+autpagamento.autorizacao+'"'+cor+'>'
          + '<td class="text-center">'
            + '<input id=autorizacao value="'+autpagamento.autorizacao+'" type="checkbox" class="ch_autpagamentos" name="autpagamentos[]">'
          + '</td>'
          + '<td style="width: 125px;" class="text-center">'+autpagamento.autorizacao+'</td>'
          + '<td>'+autpagamento.razao+'</td>'
          + '<td class="text-center">'   + autpagamento.emissao + '</td>'
          + '<td style="width: 80px;" class="text-center">R$ '+number_format(autpagamento.valor, 2, ',', '.')+'</td>'
        + '</tr>';
        trs.push(tr);
    });

    table_autpagamentos.innerHTML = trs.join('');
    var usuario = JSON.parse(e.responseText).id_usuario;
    var id_sessao = <?php echo db_getsession("DB_id_usuario"); ?>;
    var id_depart = <?php echo db_getsession("DB_coddepto"); ?>;

    if (usuario == id_sessao || id_sessao == 1) {
        document.getElementById('inserir').style.display = "inline-block";
        if (autpagamentos.length == 0) {
          table_autpagamentos.innerHTML = '<tr><td class="text-center" colspan="5">Nenhuma autorização de empenho foi inserida neste protocolo!</td></tr>';
          document.getElementById('bt_excluir').style.display   = "none";
          if (id_depart == 10 || id_depart == 31 || id_sessao == 1) {
            document.getElementById('bt_autorizar').style.display = "none";
          }
        } else {
            document.getElementById('bt_excluir').style.display   = "inline-block";
            if (id_depart == 10 || id_depart == 31 || id_sessao == 1) {
              document.getElementById('bt_autorizar').style.display = "inline-block";
            }
        }
    } else {
        if (autpagamentos.length == 0) {
          table_autpagamentos.innerHTML = '<tr><td class="text-center" colspan="5">Nenhuma autorização de empenho foi inserida neste protocolo!</td></tr>';
          document.getElementById('bt_excluir').style.display   = "none";
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
  var ckautpagamentos  = verificaAutPagamentos();
  if (ckautpagamentos == false) {
    alert('Selecione uma Ordem de Pagamento para excluí-la!');
    return;
  }

  var recautpagamentos = document.querySelectorAll('.ch_autpagamentos');
  var autpagamentos = [];

  recautpagamentos.forEach(function (item) {
    if (item.checked) {
      autpagamentos.push(item.value);
    }
  });

  var params = {
    exec: 'excluirAutPagamentos',
    autpagamentos: autpagamentos,
    protocolo:protocolo
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
    if (oRetorno.status == 1) {
      recautpagamentos.forEach(function (item) {
        if (item.checked) {
          document.getElementById('autpagamento'+item.value).remove();
        }
      });
    } else {
      alert(oRetorno.erro);
      return;
    }
  });
  limpaCampos();
}

function verificaAutPagamentos() {

  var autpagamentos = document.form1.elements['autpagamentos[]'];
  var temMarcado = false;

  if (autpagamentos) {
    if (autpagamentos['forEach']) {
      autpagamentos.forEach(function (item) {
        if (!!item.checked) {
          temMarcado = true;
        }
      });

    }
    else {
      if (!!autpagamentos.checked) {
        temMarcado = true;
      }
    }
  }

  return temMarcado;
}

function autorizar(protocolo) {
  var ckautpagamentos  = verificaAutPagamentos();
  if (ckautpagamentos == false) {
    alert('Selecione uma Ordem de Pagamento!');
    return;
  }

  var recautpagamentos = document.querySelectorAll('.ch_autpagamentos');
  var autpagamentos = [];

  recautpagamentos.forEach(function (item) {
    if (item.checked) {
      autpagamentos.push(item.value);
    }
  });

  var params = {
    exec: 'autorizacaoOrdemPagamentos',
    autpagamentos: autpagamentos,
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

  var autpagamentos = document.form1.elements['autpagamentos[]'];
  if (autpagamentos) {
    if (autpagamentos['forEach']) {
      autpagamentos.forEach(function (item) {
        if (!!item.checked) {
          valor = false
          item.checked = !!valor;
        } else {
            item.checked = !!valor;
          }
      });

    } else {
        if (!!autpagamentos.checked) {
            valor = false
            autpagamentos.checked = !!valor;
        } else {
              autpagamentos.checked = !!valor;
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
