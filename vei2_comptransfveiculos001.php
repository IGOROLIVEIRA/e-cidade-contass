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
 *  Voce deve ter recebido uma copia da ]Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//Ocorrência 3414
//init_set("display_errors", true);
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
require ("libs/db_utils.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");
include("classes/db_transferenciaveiculos_classe.php");

$cltransferenciaveiculos = new cl_transferenciaveiculos;
$cltransferenciaveiculos->rotulo->label();

$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("z01_cgccpf");

db_postmemory($HTTP_POST_VARS);
db_postmemory($_GET);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);


?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
.bold { font-weight: bold; }
.formulario {
  width: 500px;
  margin-top: 30px;
  margin-left: auto;
  margin-right: auto;
}
.formulario fieldset {
  margin-top: 10px;
}
.center {
  margin-left: auto;
  margin-right: auto;
}
#numtransferencia { width: 400px; }
.formulario .submit {
  margin-top: 10px;
  text-align: center;
}
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
  <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
      <td width="360" height="18">&nbsp;</td>
      <td width="263">&nbsp;</td>
      <td width="25">&nbsp;</td>
      <td width="140">&nbsp;</td>
    </tr>
  </table>
  <br>
  <form name="form1" class="formulario" id="formulario_relatorio" onsubmit="return false;">
    <fieldset>
      <legend>Transferência de Veículos</legend>
      <table class="center">
        <tr>
          <td nowrap title="<?=@$Tve80_sequencial?>">
            <? db_ancora('Transferência',"js_pesquisave80_sequencial(true);"); ?>
          </td>
          <td>
            <?php
              db_input('ve80_sequencial',8,$Ive80_sequencial,true,'text',""," onchange='js_pesquisave80_sequencial(false);'");
              db_input('descrdepto',33,$Idescrdepto,true,'text',3,'');
            ?>
            <input type="button" value="Lançar" id="btn-lancar"/>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <select name="numtransferencia[]" id="numtransferencia" size="12" multiple>
            </select>
          </td>
        </tr>
        <tr>
          <td align="center" colspan="2">
            <strong>Dois Cliques sobre o item o exclui.</strong>
          </td>
        </tr>
      </table>
    </fieldset>

    <div class="center submit">
      <input type="submit" value="Emitir Relatório" onclick="js_emitir();">
    </div>
  </form>
  <?
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>

<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<script type="text/javascript">

function js_pesquisave80_sequencial(mostra){
  if (mostra==true) {
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_transferenciaveiculos','func_transferenciaveiculos.php?funcao_js=parent.js_mostratransferencia2|ve80_sequencial|descrdepto','Pesquisa',true);
  } else {
     if (document.form1.ve80_sequencial.value != '') {
        js_OpenJanelaIframe('','db_iframe_transferenciaveiculos','func_transferenciaveiculos.php?codT='+document.form1.ve80_sequencial.value+'&pesquisa_chave&funcao_js=parent.js_mostratransferencia','Pesquisa',false);
     }
  }
}

function js_mostratransferencia(chave1, erro) {
  document.form1.descrdepto.value = chave1;

  if (erro==true) {
    console.log("descrdepto : " + erro);
    document.form1.ve80_sequencial.focus();
    document.form1.ve80_sequencial.value = '';
    return;
  }
}

function js_mostratransferencia2(chave1,chave2) {
  document.form1.ve80_sequencial.value = chave1;
  document.form1.descrdepto.value = chave2;
  db_iframe_transferenciaveiculos.hide();
}

var optionsTransferencias = document.getElementById("numtransferencia");

function addOption(numTransf, dTransf) {

  if (!numTransf || !dTransf) {
    alert("Transferência inválida!");
    limparCampos();
    return;
  }

  var jaTem = Array.prototype.filter.call(optionsTransferencias.children, function(o) {
    return o.value == numTransf;
  });

  if (jaTem.length > 0) {
    alert("Transferência já inserida.");
    limparCampos();
    return;
  }

  var option = document.createElement('option');
  option.value = numTransf;
  option.innerText = numTransf + ' - ' + dTransf + ' (DESTINO)';
  optionsTransferencias.appendChild(option);

  limparCampos();
}

function limpar() {
  optionsTransferencias.innerHTML = "";
}

function limparCampos() {
  document.form1.ve80_sequencial.value  = '';
  document.form1.descrdepto.value = '';
}

optionsTransferencias.addEventListener('dblclick', function excluirTransferencia(e) {
  optionsTransferencias.removeChild(e.target);
});

document.getElementById('btn-lancar').addEventListener('click', function(e) {
  addOption(
    document.form1.ve80_sequencial.value,
    document.form1.descrdepto.value
  );
});


function js_emitir() {
  var dados = {
    transferencias: Array.prototype.map.call(optionsTransferencias.children, function(o) {
      return o.value;
    }).join(',')
  };

  var transferenciaVazio = dados.transferencias == '';

  if (transferenciaVazio) {
    alert('Informe pelo menos uma Transferência!');
    return;
  }

  var query = "";
  query += transferenciaVazio ? '' : ("&transferencias=" + dados.transferencias),

  jan = window.open(
    "vei2_comptransfveiculos002.php?" + query,
    "",
    'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0'
  );
  jan.moveTo(0,0);

}


</script>
</body>
</html>

