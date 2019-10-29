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
$clorcdotacao = new cl_orcdotacao;
$clpcmater  = new cl_pcmater;
$clcgm    = new cl_cgm;

$clrotulo = new rotulocampo;
$clrotulo->label("o40_descr");
$clrotulo->label("e53_codord");
$clpcmater->rotulo->label();
$clcgm->rotulo->label();

$clempempenho->rotulo->label();
$clorcdotacao->rotulo->label();

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
  max-width: 20px;
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
td{
  padding-top: 7px;
}
input{
  width:78px;
}
#ancora_a{
  width: 17px;
  padding-left: 7px;
  padding-right: 7px;
  padding-top: 25px;
}
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc" onload="pesquisaProtocolo(document.form1.protocolo.value)">
<br/><br/>
<center>
<div style="width: 48%;">
<fieldset>
  <legend><strong>Empenho</strong></legend>
  <form name="form1" method="post">
  <input type="hidden" name="protocolo" value="<?= $protocolo ?>">
  <input type="hidden" name="dattab">
  <input type="hidden" name="valtab">
    <table border='0' width="100%">
      <tr>
        <td width="24%"></td>
        <td align="left">
          <? db_ancora('Empenho:',"js_pesquisae60_codemp(true, e60_codemp_ini);",1);  ?>
        </td>
        <td>
         <?
           db_input("e60_codemp_ini",15,$Ie60_codemp,true,"text",4,"onchange='js_pesquisae60_codemp(false, e60_codemp_ini);'");
           db_input('e60_anousu_ini','','',true, 'hidden', '');
         ?>
        </td>
        <td id="ancora_a">
          <? db_ancora('à',"js_pesquisae60_codemp(true, e60_codemp_fim);",1);  ?>
          &nbsp;&nbsp;
        </td>
        <td>
          <?
            db_input("e60_codemp_fim",15,$Ie60_codemp,true,"text",4,"onchange='js_pesquisae60_codemp(false, e60_codemp_fim);'");
            db_input('e60_anousu_fim','','',true, 'hidden', '');
          ?>
        </td>
        <td width="35%"></td>
      </tr>
      <tr>
        <td align="center" colspan="6">
          <input type="button" id="inserir" value="Incluir" onclick="incluir();">
        </td>
      </tr>
    </table>
    <br>
    <table class="table">
      <caption style="font-size: 15px; margin-bottom: 8px;"><strong>Protocolo: <?php echo $protocolo; ?> </strong></caption>
        <thead>
          <tr>
            <th title="Marcar ou Desmarcar todos" style="width: 10px; cursor: pointer;" onclick="marcaTodos(true)">M</th>
            <th>Nº Empenho</th>
            <th class="th_tipo">Nome/Razão Social</th>
            <th class="th_size">Data</th>
            <th class="th_size">Valor</th>
          </tr>
        </thead>

        <tbody id="table_empenhos">

        </tbody>
    </table>
    <td align="left">
      <input id="bt_excluir" style="margin-left: -3px; display: none" type="button" value="Remover" onclick="excluir(<?php echo $protocolo; ?>);">
    </td>
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
  doc.e60_codemp_ini.value = '';
  doc.e60_codemp_fim.value = '';
  doc.e60_anousu_ini.value = '';
  doc.e60_anousu_fim.value = '';
}

//--------------------------------
function js_pesquisae60_codemp(mostra, campo){

  if(campo.name == 'e60_codemp_ini'){
    if(mostra==true){
      js_OpenJanelaIframe('','db_iframe_empempenho1','func_empempenho.php?funcao_js=parent.js_mostraempempenho1|e60_numemp|z01_nome|e60_emiss|e60_vlremp|e60_codemp','Pesquisa',true);
    }else{
      js_OpenJanelaIframe('','db_iframe_empempenho01','func_empempenho.php?protocolo=2&pesquisa_chave='+document.form1.e60_codemp_ini.value+'&funcao_js=parent.js_mostraempempenho_ini','Pesquisa',false);
    }
  }

  if(campo.name == 'e60_codemp_fim'){
    if(mostra==true){
      js_OpenJanelaIframe('','db_iframe_empempenho2','func_empempenho.php?funcao_js=parent.js_mostraempempenho2|e60_numemp|z01_nome|e60_emiss|e60_vlremp|e60_codemp','Pesquisa',true);
    }else{
      js_OpenJanelaIframe('','db_iframe_empempenho02','func_empempenho.php?protocolo=2&pesquisa_chave='+document.form1.e60_codemp_fim.value+'&funcao_js=parent.js_mostraempempenho_fim','Pesquisa',false);
    }
  }

}

function js_mostraempempenho_ini(chave1, chave2, chave3, chave4, chave5){
  document.form1.valtab.value         = chave4;
  if(chave5){
    document.form1.e60_anousu_ini.value = chave3;
    document.form1.e60_codemp_ini.value = chave5;
  }
}

function js_mostraempempenho1(chave1, chave2, chave3, chave4, chave5){
  let emiss = new Date(chave3);
  document.form1.valtab.value         = chave4;
  if(chave5){
    document.form1.e60_anousu_ini.value = chave3;
    document.form1.e60_codemp_ini.value = chave5+'/'+emiss.getFullYear();
  }

  db_iframe_empempenho1.hide();
}

function js_mostraempempenho_fim(chave1, chave2, chave3, chave4, chave5){
  document.form1.valtab.value         = chave4;
  if(chave5){
    document.form1.e60_anousu_fim.value = chave3;
    document.form1.e60_codemp_fim.value = chave5;
  }

}

function js_mostraempempenho2(chave1, chave2, chave3, chave4, chave5){
  let emiss = new Date(chave3);
  document.form1.valtab.value         = chave4;
  if(chave5){
    document.form1.e60_anousu_fim.value = chave3;
    document.form1.e60_codemp_fim.value = chave5+'/'+emiss.getFullYear();
  }
  db_iframe_empempenho2.hide();
}

//--------------------------------

function js_pesquisa_empenho(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_empempenho','func_empempenho.php?funcao_js=parent.js_mostraempenho1|e60_numemp|z01_nome|e60_emiss|e60_vlremp|e60_codemp','Pesquisa',true);
  }else{
     if(document.form1.e60_numemp.value != ''){
        js_OpenJanelaIframe('','db_iframe_empempenho','func_empempenho.php?protocolo=1&pesquisa_chave='+document.form1.e60_numemp.value+'&funcao_js=parent.js_mostraempenho','Pesquisa',false);
     }else{
       document.form1.z01_nome1.value = '';
     }
  }
}
function js_mostraempenho(chave1, chave2, chave3, chave4, chave5){
  document.form1.e60_numemp.value = chave2;
  document.form1.z01_nome.value   = chave1;
  document.form1.z01_nome1.value  = chave1;
  document.form1.dattab.value     = chave3;
  document.form1.valtab.value     = chave4;
  document.form1.e60_codemp.value = chave5;

}
function js_mostraempenho1(chave1, chave2, chave3, chave4, chave5){
  document.form1.e60_numemp.value = chave1;
  document.form1.z01_nome.value   = chave2;
  document.form1.z01_nome1.value  = chave2;
  document.form1.dattab.value     = chave3;
  document.form1.valtab.value     = chave4;
  document.form1.e60_codemp.value = chave5;
  db_iframe_empempenho.hide();

}

//--------------------------------

function novoAjax(params, onComplete, async=true) {
  var request = new Ajax.Request('pro4_protocolos.RPC.php', {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: onComplete,
    asynchronous: async
  });

}
var table_empenhos = document.getElementById('table_empenhos');

function pesquisaEmpenhos(){
  let oParam = new Object();
  let doc = document.form1;

  let empIni = doc.e60_codemp_ini.value.split('/');
  let empFim = doc.e60_codemp_fim.value.split('/');

  if(!empIni[1] && empFim[1]){
    empIni[1] = empFim[1];
  }

  if(empFim[1] && !empIni[1]){
    empFim[1] = empIni[1]
  }

  if(doc.e60_codemp_ini.value){
    oParam.inicio = empIni;
    oParam.dtInicio = doc.e60_anousu_ini.value;
  }

  if(doc.e60_codemp_fim.value){
    oParam.fim = empFim;
    oParam.dtFim = doc.e60_anousu_fim.value;
  }

  if(empIni[1] && empFim[1]){
    if(parseInt(empIni[1]) > parseInt(empFim[1])){
      alert('Data do empenho final é menor que o empenho inicial. Verifique!');
      return false;
    }
    if(parseInt(empIni[0]) > parseInt(empFim[0])){
      alert('Empenho inicial é maior que o empenho Final. Verifique!');
      return false;
    }
  }

  if(parseInt(empIni[0]) > parseInt(empFim[0])){
    alert('Valor do último empenho é menor que o empenho inicial');
    return false;
  }

  if(parseInt(empIni[1]) > parseInt(empFim[1])){
    alert('Data do empenho inicial é maior que o empenho final');
    return false;
  }

  let listaEmpenhos = [];
  oParam.exec = 'pesquisaEmpenhos';
  novoAjax(oParam, function(e){
    let response = JSON.parse(e.responseText);
    listaEmpenhos = [...response.empenhos];
  }, false);

  return listaEmpenhos;
}

function incluir() {
  var protocolo   = document.form1.protocolo.value;
  var empenho_ini = document.form1.e60_codemp_ini.value;
  var empenho_fim = document.form1.e60_codemp_fim.value;
  var protocoloVazio = protocolo == '';

  if (protocoloVazio) {
    alert('Ocorreu um erro na geração do protocolo!');
    return;
  }

  if (!empenho_ini && !empenho_fim) {
    alert('Informe um intervalo de empenho');
    return;
  }

  let aEmpenhos = [];
  aEmpenhos = pesquisaEmpenhos();

  if(aEmpenhos.length == 0)
    aEmpenhos = pesquisaEmpenhos();

  incluirEmpenho(protocolo, aEmpenhos);

}

function incluirEmpenho(iProtocolo, iEmpenho) {
  var params = {
    exec: 'insereEmpenho',
    protocolo: iProtocolo,
    empenho: iEmpenho
  };
  js_divCarregando('Aguarde', 'div_aguarde');
  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        if(oRetorno.erro){
          alert(oRetorno.erro);
        }

        if(iEmpenho.length == 100){
          let priEmp = iEmpenho[0];
          let ultEmp = iEmpenho[iEmpenho.length - 1];
          alert(`Inseridos 100 registros do intervalo ${priEmp.e60_numemp}/${priEmp.e60_anousu} à ${ultEmp.e60_numemp}/${ultEmp.e60_anousu}`);
        }
        pesquisaProtocolo(iProtocolo);
        document.form1.e60_numemp.value = "";
        document.form1.e60_codemp_ini.value = "";
        document.form1.e60_codemp_fim.value = "";
        document.form1.dattab.value     = "";
        document.form1.valtab.value     = "";
        document.getElementById('bt_excluir').style.display = "inline-block";

      } else {
          alert(oRetorno.erro);
          return oRetorno.empenho;
      }
    }, false);
    js_removeObj('div_aguarde');
}

function pesquisaProtocolo(protocolo) {

  var params = {
    exec: 'pesquisaEmpProtocolos',
    protocolo: protocolo
  };

  var trs   = [];
  novoAjax(params, function(e) {

    var empenhos = JSON.parse(e.responseText).empenhos;
    empenhos.forEach(function(empenho, i) {

      var tr = ''
        + '<tr id="empenho'+empenho.autorizacao+'">'
          + '<td class="text-center">'
            + '<input width: 10px; value="' + empenho.autorizacao + '" type="checkbox" class="ch_empenhos"  name="empenhos[]">'
          + '</td>'
          + '<td class="text-center">'     + empenho.autorizacao + '</td>'
          + '<td>'     + empenho.razao + '</td>'
          + '<td class="text-center">'   + empenho.emissao + '</td>'
          + '<td style="width: 80px;" class="text-center">R$ ' +  number_format(empenho.valor, 2, ',', '.') + '</td>'
        + '</tr>';

        trs.push(tr);

    });

    table_empenhos.innerHTML = trs.join('');
    var usuario = JSON.parse(e.responseText).id_usuario;
    var id_sessao = <?php echo db_getsession("DB_id_usuario"); ?>;

    if (usuario == id_sessao || id_sessao == 1) {
        document.getElementById('inserir').style.display = "inline-block";
        if (empenhos.length == 0) {
          table_empenhos.innerHTML = '<tr><td class="text-center" colspan="5">Nenhuma autorização de empenho foi inserida neste protocolo!</td></tr>';
          document.getElementById('bt_excluir').style.display = "none";
        } else {
            document.getElementById('bt_excluir').style.display = "inline-block";
        }
    } else {
        if (empenhos.length == 0) {
          table_empenhos.innerHTML = '<tr><td class="text-center" colspan="5">Nenhuma autorização de empenho foi inserida neste protocolo!</td></tr>';
          document.getElementById('bt_excluir').style.display = "none";
        } else {
          document.getElementById('bt_excluir').style.display = "none";
          document.getElementById('inserir').style.display = "none";
        }
    }
  });
}

function excluir(protocolo) {
  var ckempenhos  = verificaEmpenhos();
  if (ckempenhos == false) {
    alert('Selecione um Empenho!');
    return;
  }

  var recEmpenhos = document.querySelectorAll('.ch_empenhos');
  var empenhos = [];
  var anos = [];

  recEmpenhos.forEach(function (item) {
    if (item.checked) {
      var empenhoAno = item.value.split("/");
      var empenho    = empenhoAno[0];
      var ano        = empenhoAno[1];
      empenhos.push("'"+empenho+"'");
      anos.push(ano);
    }
  });

  var e60_anousu = anos.filter(function(este, i) {
    return anos.indexOf(este) == i;
  })

  var params = {
    exec: 'excluirEmpenhos',
    empenhos: empenhos,
    anos:e60_anousu,
    protocolo:protocolo
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
    if (oRetorno.status == 1) {
      recEmpenhos.forEach(function (item) {
        if (item.checked) {
          document.getElementById('empenho'+item.value).remove();
        }
      });
    } else {
      alert(oRetorno.erro);
      return;
    }
  });
  limpaCampos();
}

function verificaEmpenhos() {

  var empenhos = document.form1.elements['empenhos[]'];
  var temMarcado = false;

  if (empenhos) {
    if (empenhos['forEach']) {
      empenhos.forEach(function (item) {
        if (!!item.checked) {
          temMarcado = true;
        }
      });

    }
    else {
      if (!!empenhos.checked) {
        temMarcado = true;
      }
    }
  }

  return temMarcado;
}


function marcaTodos(valor) {

  var checar = document.form1.elements['empenhos[]'];
  if (checar) {
    if (checar['forEach']) {
      checar.forEach(function (item) {
        if (!!item.checked) {
          valor = false
          item.checked = !!valor;
        } else {
            item.checked = !!valor;
          }
      });

    } else {
        if (!!checar.checked) {
            valor = false
            checar.checked = !!valor;
        } else {
              checar.checked = !!valor;
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
