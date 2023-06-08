<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_orcdotacao_classe.php");
include("classes/db_pcmater_classe.php");
include("classes/db_cgm_classe.php");
include("classes/db_empautoriza_classe.php");
require_once("libs/JSON.php");

$clempautoriza = new cl_empautoriza;
$clorcdotacao = new cl_orcdotacao;
$clpcmater  = new cl_pcmater;
$clcgm    = new cl_cgm;

$clrotulo = new rotulocampo;
$clrotulo->label("o40_descr");
$clrotulo->label("e60_emiss");
$clpcmater->rotulo->label();
$clcgm->rotulo->label();

$clempautoriza->rotulo->label();
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
  max-width: 30px;
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
    max-width: 10px;
    text-align: center;;
}
</style>
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

<script>

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
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc" onload="pesquisaProtocolo(document.form1.protocolo.value)">
<br><br>
<center>
<fieldset style="width: 46%;">
<legend>Autorização de Empenhos</legend>
<form name="form1" method="post">
<input type="hidden" name="protocolo" value="<?php echo $protocolo ?>" >
<input type="hidden" name="dattab">
<input type="hidden" name="valtab">
<table border='0'>
<tr height="20px">
<td ></td>
<td ></td>
</tr>
  <tr>
    <td align="right" nowrap > <? db_ancora(@$Le54_autori,"js_pesquisa_aut(true);",1);?>  </td>
    <td align="left" nowrap>
      <?
        db_input("e54_autori",6,$Ie54_autori,true,"text",4,"onchange='js_pesquisa_aut(false);'");
        db_input("z01_nome",40,"",true,"text",3);
      ?>
    </td>
  </tr>

  <tr height="5px">
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td></td>
    <td align="left">
      <input style="margin-left: 110px;" type="button" id="inserir" value="Incluir" onclick="incluir();">
    </td>
  </tr>
  </table>
  <br>
  <table class="table">
    <caption style="font-size: 15px; margin-bottom: 8px;"><strong>Protocolo: <?php echo $protocolo; ?></strong></caption>
      <thead>
        <tr>
          <th title="Marcar ou Desmarcar todos" style="width: 10px; cursor: pointer;" onclick="marcaTodos(true)">M</th>
          <th>Nº Autorização</th>
          <th class="th_tipo">Nome/Razão Social</th>
          <th class="th_size">Data</th>
          <th class="th_size">Valor</th>
        </tr>
      </thead>

      <tbody id="table_autempenhos">

      </tbody>
  </table>
  <td align="left">
    <input id="bt_excluir" style="margin-left: -3px; display: none" type="button" value="Remover" onclick="excluir(<?php echo $protocolo; ?>);">
  </td>
  </form>
</fieldset>
</center>
<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<script>
//--------------------------------
function js_pesquisa_cgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','func_nome','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.z01_numcgm.value != ''){
        js_OpenJanelaIframe('','func_nome','func_nome.php?pesquisa_chave='+document.form1.z01_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgm(erro,chave){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.z01_nome.value = '';
    document.form1.z01_numcgm.focus();
  }
}
function js_mostracgm1(chave1,chave2){
   document.form1.z01_numcgm.value = chave1;
   document.form1.z01_nome.value = chave2;
   func_nome.hide();
}
//--------------------------------

function js_pesquisa_aut(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_protempautoriza','func_prot_empautoriza.php?funcao_js=parent.js_mostraautori1|e54_autori|z01_nome|e54_emiss|e55_vltot','Pesquisa',true);
  }else{
     if(document.form1.e54_autori.value != ''){
        js_OpenJanelaIframe('','db_iframe_protempautoriza','func_prot_empautoriza.php?prot=1&pesquisa_chave='+document.form1.e54_autori.value+'&funcao_js=parent.js_mostraautori','Pesquisa',false);
     }
  }
}
function js_mostraautori(chave1, chave2, chave3, chave4, erro){
  document.form1.e54_autori.value = chave1;
  document.form1.z01_nome.value   = chave2;
  document.form1.dattab.value     = chave3;
  document.form1.valtab.value     = chave4;
  if(erro==true){
    document.form1.e54_autori.focus();
  }
}

function js_mostraautori1(chave1, chave2, chave3, chave4) {
  document.form1.e54_autori.value = chave1;
  document.form1.z01_nome.value   = chave2;
  document.form1.dattab.value     = chave3;
  document.form1.valtab.value     = chave4;

  db_iframe_protempautoriza.hide();

}
//--------------------------------
function novoAjax(params, onComplete) {

  var request = new Ajax.Request('pro4_protocolos.RPC.php', {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: onComplete
  });

}
var table_autempenhos = document.getElementById('table_autempenhos');

function incluir() {
  var protocolo        = document.form1.protocolo.value;
  var autorizacao      = document.form1.e54_autori.value;
  var protocoloVazio   = protocolo   == '';
  var autorizacaoVazio = autorizacao == '';
  if (protocoloVazio) {
    alert('Ocorreu um erro na geração do protocolo!');
    return;
  }

  if (autorizacaoVazio) {
    alert('Informe uma autorização de empenho!');
    return;
  }

  incluirAutEmpenho(protocolo,autorizacao);
}

function incluirAutEmpenho(iProtocolo, iAutempenho) {
  var params = {
    exec: 'insereAutEmpenho',
    protocolo: iProtocolo,
    autempenho: iAutempenho
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        pesquisaProtocolo(iProtocolo);
        document.form1.e54_autori.value = "";
        document.form1.z01_nome.value   = "";
        document.form1.dattab.value     = "";
        document.form1.valtab.value     = "";
        document.getElementById('bt_excluir').style.display = "inline-block";
      } else {
          alert(oRetorno.erro);
        }
    });
}

function pesquisaProtocolo(protocolo) {

  var params = {
    exec: 'pesquisaAutProtocolos',
    protocolo: protocolo
  };

  var trs = [];

  novoAjax(params, function(e) {

    var autempenhos = JSON.parse(e.responseText).autempenhos;
    autempenhos.forEach(function(autempenho, i) {

        var tr = ''
        + '<tr id="autempenho'+autempenho.autorizacao+'">'
          + '<td class="text-center">'
            + '<input style="width: 10px;" value="' + autempenho.autorizacao + '" type="checkbox" class="ch_autempenhos" name="autempenhos[]">'
          + '</td>'
          + '<td style="width: 100px;" class="text-center">'     + autempenho.autorizacao + '</td>'
          + '<td>'     + autempenho.razao + '</td>'
          + '<td class="text-center">'   + autempenho.emissao + '</td>'
          + '<td style="width: 80px;" class="text-center">R$ ' +  number_format(autempenho.valor, 2, ',', '.') + '</td>'
        + '</tr>';

        trs.push(tr);

    });

    table_autempenhos.innerHTML = trs.join('');
    var usuario = JSON.parse(e.responseText).id_usuario;
    var id_sessao = <?php echo db_getsession("DB_id_usuario"); ?>;

    if (usuario == id_sessao || id_sessao == 1) {
        document.getElementById('inserir').style.display = "inline-block";
        if (autempenhos.length == 0) {
          table_autempenhos.innerHTML = '<tr><td class="text-center" colspan="5">Nenhuma autorização de empenho foi inserida neste protocolo!</td></tr>';
          document.getElementById('bt_excluir').style.display = "none";
        } else {
            document.getElementById('bt_excluir').style.display = "inline-block";
        }
    } else {
        if (autempenhos.length == 0) {
          table_autempenhos.innerHTML = '<tr><td class="text-center" colspan="5">Nenhuma autorização de empenho foi inserida neste protocolo!</td></tr>';
          document.getElementById('bt_excluir').style.display = "none";
        } else {
          document.getElementById('bt_excluir').style.display = "none";
          document.getElementById('inserir').style.display = "none";
        }
    }
  });
}

function excluir(protocolo) {
  var ckautempenhos  = verificaAutEmpenhos();
  if (ckautempenhos == false) {
    alert('Selecione uma Autorização de Empenho!');
    return;
  }

  var recautempenhos = document.querySelectorAll('.ch_autempenhos');
  var autempenhos = [];

  recautempenhos.forEach(function (item) {
    if (item.checked) {
      autempenhos.push(item.value);
    }
  });

  var params = {
    exec: 'excluirAutEmpenhos',
    autempenhos: autempenhos,
    protocolo:protocolo
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
    if (oRetorno.status == 1) {
      recautempenhos.forEach(function (item) {
        if (item.checked) {
          document.getElementById('autempenho'+item.value).remove();
        }
      });

    } else {
      alert(oRetorno.erro);
      return;
    }
  });
}


function verificaAutEmpenhos() {

  var autempenhos = document.form1.elements['autempenhos[]'];
  var temMarcado = false;

  if (autempenhos) {
    if (autempenhos['forEach']) {
      autempenhos.forEach(function (item) {
        if (!!item.checked) {
          temMarcado = true;
        }
      });

    }
    else {
      if (!!autempenhos.checked) {
        temMarcado = true;
      }
    }
  }

  return temMarcado;
}


function marcaTodos(valor) {

  var checar = document.form1.elements['autempenhos[]'];
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
</script>
</body>
</html>
