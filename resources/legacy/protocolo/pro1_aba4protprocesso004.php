<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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
require("libs/db_liborcamento.php");
include("classes/db_empempenho_classe.php");
include("classes/db_cgm_classe.php");
include("classes/db_matordem_classe.php");
require_once("libs/JSON.php");

$clmatordem = new cl_matordem;
$clempempenho = new cl_empempenho;
$clcgm    = new cl_cgm;

$clrotulo = new rotulocampo;
$clcgm->rotulo->label();
$clempempenho->rotulo->label();
$clmatordem->rotulo->label();
$clrotulo->label("z01_nome");
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
  max-width: 35px;
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
#inserir{
  padding-left: 19px;
  padding-right: 19px;
  margin-top: 3px;
  margin-left:113px;
}
td{
  padding-top:20px;
}
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#cccccc" onload="pesquisaProtocolo(document.form1.protocolo.value)">
<br><br>
<center>
<div style="width: 48%;">
<fieldset>
<legend>Ordem de Compra</legend>
<form name="form1" method="post">
<input type="hidden" name="protocolo" value="<?= $protocolo ?>">
<input type="hidden" name="dattab">
<input type="hidden" name="valtab">
<table border='0'>

  <tr>
    <td  align="right" nowrap title="<?=$Tm51_codordem?>">
      <? db_ancora(@$Lm51_codordem,"js_pesquisa_matordem(true);",1); ?>
    </td>
    <td align="left" nowrap>
      <?
        db_input("m51_codordem",6,$Im51_codordem,true,"text",4,"onchange='js_pesquisa_matordem(false);'");
        db_input("z01_nome",40,"$Iz01_nome",true,"text",3);
      ?>
    </td>
  </tr>


  <tr>
    <td></td>
    <td align="left">
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
            <th>Nº Ord. Compra</th>
            <th class="th_tipo">Nome/Razão Social</th>
            <th class="th_size">Data</th>
            <th class="th_size">Valor</th>
          </tr>
        </thead>

        <tbody id="table_autcompra">

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

function js_pesquisa_matordem(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_matordem','func_matordemanulada.php?funcao_js=parent.js_mostramatordem1|m51_codordem|z01_nome|m51_data|m51_valortotal','Pesquisa',true);
  }else{
     if(document.form1.m51_codordem.value != ''){
        js_OpenJanelaIframe('','db_iframe_matordem','func_matordemanulada.php?prot=1&pesquisa_chave='+document.form1.m51_codordem.value+'&funcao_js=parent.js_mostramatordem','Pesquisa',false);
     }else{
       document.form1.m51_codordem.value = '';
     }
  }
}
function js_mostramatordem(chave1, chave2, chave3, chave4, erro){
  document.form1.m51_codordem.value = chave1;
  document.form1.z01_nome.value     = chave2;
  document.form1.dattab.value       = chave3;
  document.form1.valtab.value       = chave4;
  console.log(chave1);
  console.log(chave2);
  console.log(chave3);
  console.log(chave4);
  if(erro==true){
    document.form1.m51_codordem.value = '';
    document.form1.m51_codordem.focus();
  }
}
function js_mostramatordem1(chave1, chave2, chave3, chave4){
  document.form1.m51_codordem.value = chave1;
  document.form1.z01_nome.value     = chave2;
  document.form1.dattab.value       = chave3;
  document.form1.valtab.value       = chave4;
  db_iframe_matordem.hide();

}
//------------------------------------------------------

var table_autcompra = document.getElementById('table_autcompra');

function novoAjax(params, onComplete) {

  var request = new Ajax.Request('pro4_protocolos.RPC.php', {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: onComplete
  });

}

function incluir() {
  var protocolo        = document.form1.protocolo.value;
  var autcompra        = document.form1.m51_codordem.value;
  var protocoloVazio   = protocolo == '';
  var autcompraloVazio = autcompra == '';

  if (protocoloVazio) {
    alert('Ocorreu um erro na geração do protocolo!');
    return;
  }

  if (autcompraloVazio) {
    alert('Informe uma ordem de compra!');
    return;
  }

  incluirAutCompra(protocolo,autcompra);
}

function incluirAutCompra(iProtocolo, iAutcompra) {
  var params = {
    exec: 'insereAutCompra',
    protocolo: iProtocolo,
    autcompra: iAutcompra
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        pesquisaProtocolo(iProtocolo);
        document.form1.m51_codordem.value = "";
        document.form1.z01_nome.value   = "";
        document.form1.dattab.value     = "";
        document.form1.valtab.value     = "";
        document.getElementById('bt_excluir').style.display = "inline-block";
      } else {
          alert(oRetorno.erro);
        return;
      }
    });
}

function pesquisaProtocolo(protocolo) {

  var params = {
    exec: 'pesquisaAutCompraProtocolos',
    protocolo: protocolo
  };

  var trs = [];

  novoAjax(params, function(e) {

    var autcompras = JSON.parse(e.responseText).autcompras;
    autcompras.forEach(function(autcompra, i) {

      var tr = ''
        + '<tr id="autcompra'+autcompra.autorizacao+'">'
          + '<td class="text-center">'
            + '<input style="width: 10px;" value="' + autcompra.autorizacao + '" type="checkbox" class="ch_autcompras" name="autcompras[]">'
          + '</td>'
          + '<td style="width: 100px;" class="text-center">'   + autcompra.autorizacao + '</td>'
          + '<td>'     + autcompra.razao + '</td>'
          + '<td class="text-center">'   + autcompra.emissao + '</td>'
          + '<td style="width: 80px;" class="text-center">R$ ' +  number_format(autcompra.valor, 2, ',', '.') + '</td>'
        + '</tr>';

        trs.push(tr);

    });

    table_autcompra.innerHTML = trs.join('');
    var usuario = JSON.parse(e.responseText).id_usuario;
    var id_sessao = <?php echo db_getsession("DB_id_usuario"); ?>;

    if (usuario == id_sessao || id_sessao == 1) {
        document.getElementById('inserir').style.display = "inline-block";
        if (autcompras.length == 0) {
          table_autcompra.innerHTML = '<tr><td class="text-center" colspan="5">Nenhuma autorização de empenho foi inserida neste protocolo!</td></tr>';
          document.getElementById('bt_excluir').style.display = "none";
        } else {
            document.getElementById('bt_excluir').style.display = "inline-block";
        }
    } else {
        if (autcompras.length == 0) {
          table_autcompra.innerHTML = '<tr><td class="text-center" colspan="5">Nenhuma autorização de empenho foi inserida neste protocolo!</td></tr>';
          document.getElementById('bt_excluir').style.display = "none";
        } else {
          document.getElementById('bt_excluir').style.display = "none";
          document.getElementById('inserir').style.display = "none";
        }
    }

  });
}

function excluir(protocolo) {
  var ckautcompras  = verificaAutCompras();
  if (ckautcompras == false) {
    alert('Selecione uma Ordem de Compra!');
    return;
  }

  var recautcompras = document.querySelectorAll('.ch_autcompras');
  var autcompras = [];

  recautcompras.forEach(function (item) {
    if (item.checked) {
      autcompras.push(item.value);
    }
  });

  var params = {
    exec: 'excluirAutCompras',
    autcompras: autcompras,
    protocolo:protocolo
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
    if (oRetorno.status == 1) {
      recautcompras.forEach(function (item) {
        if (item.checked) {
          document.getElementById('autcompra'+item.value).remove();
        }
      });
    } else {
      alert(oRetorno.erro);
      return;
    }
  });
}

function verificaAutCompras() {

  var autcompras = document.form1.elements['autcompras[]'];
  var temMarcado = false;

  if (autcompras) {
    if (autcompras['forEach']) {
      autcompras.forEach(function (item) {
        if (!!item.checked) {
          temMarcado = true;
        }
      });

    }
    else {
      if (!!autcompras.checked) {
        temMarcado = true;
      }
    }
  }

  return temMarcado;
}


function marcaTodos(valor) {

  var autcompras = document.form1.elements['autcompras[]'];
  if (autcompras) {
    if (autcompras['forEach']) {
      autcompras.forEach(function (item) {
        if (!!item.checked) {
          valor = false
          item.checked = !!valor;
        } else {
            item.checked = !!valor;
          }
      });

    } else {
        if (!!autcompras.checked) {
            valor = false
            autcompras.checked = !!valor;
        } else {
              autcompras.checked = !!valor;
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
