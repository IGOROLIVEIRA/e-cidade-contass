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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
require ("libs/db_utils.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");
include("classes/db_empempenho_classe.php");
include("classes/db_condataconf_classe.php");
include("classes/db_db_usuarios_classe.php");

$clempempenho = new cl_empempenho;
$clempempenho->rotulo->label();

$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("z01_cgccpf");

db_postmemory($HTTP_POST_VARS);
db_postmemory($_GET);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);


/**
 * controle de encerramento peri. contabil
 */
$clcondataconf = new cl_condataconf;
$resultControle = $clcondataconf->sql_record($clcondataconf->sql_query_file(db_getsession('DB_anousu'),db_getsession('DB_instit'),'c99_data'));
db_fieldsmemory($resultControle,0);

$dtSistema = date("Y-m-d", db_getsession("DB_datausu"));

if($dtSistema > $c99_data){
  $periodo_fechado = 1;
}else{
  $periodo_fechado = 0;
}

/*
* Busca nome do usuário logado
*/

$cldb_usuarios = new cl_db_usuarios;
$resultUsuario = $cldb_usuarios->sql_record($cldb_usuarios->sql_query_file(db_getsession('DB_id_usuario'),'nome'));
db_fieldsmemory($resultUsuario,0);

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
#numempenho { width: 400px; }
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
      <legend>Empenhos</legend>
      <table class="center">
        <tr>
          <td nowrap title="<?=@$Te60_numemp?>">
            <? db_ancora('Seq. Empenho',"js_pesquisae60_numemp(true);",$db_opcao); ?>
          </td>
          <td>
            <?php
              db_input('e60_numemp',8,$Ie60_codemp,true,'text',$db_opcao," onchange='js_pesquisae60_numemp(false);'");
              db_input('z01_nome',30,$Iz01_nome,true,'text',3,'');
              db_input('e60_anousu',4,$Ie60_anousu,true,'hidden',3,'');
            ?>
            <input type="hidden" value="<?=db_getsession('DB_instit')?>" id="instit"/>
            <input type="hidden" value="<?=$periodo_fechado?>" id="periodo_fechado"/>
            <input type="hidden" value="<?=$nome?>" id="nome_usuario"/>
            <input type="button" value="Lançar" id="btn-lancar"/>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <select name="numempenho[]" id="numempenho" size="12" multiple>
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
      <input type="submit" value="Excluir Empenho" onclick="js_excluir();">
    </div>
  </form>
  <?
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>

<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<script type="text/javascript">
var sUrlRpc = 'emp4_exclusaoempenhos.RPC.php';

function js_pesquisae60_numemp(mostra){
  if (mostra==true) {
    js_OpenJanelaIframe('top.corpo','db_iframe_empempenho','func_empempenho.php?emperro=1&pegaAnousu&funcao_js=parent.js_mostraempempenho2|e60_numemp|z01_nome|e60_anousu','Pesquisa',true);
  } else {
     if (document.form1.e60_numemp.value != '') {
        js_OpenJanelaIframe('','db_iframe_empempenho','func_empempenho.php?pesquisa_chave='+document.form1.e60_numemp.value+'&pegaAnousu&funcao_js=parent.js_mostraempempenho&empempenho','Pesquisa',false);
     } else {
       document.form1.e60_anousu.value = '';
      }
  }
}

function js_mostraempempenho(chave1, chave2, erro) {

  document.form1.z01_nome.value = chave1;
  document.form1.e60_anousu.value = chave2;

  if (erro==true) {
    document.form1.e60_numemp.focus();
    document.form1.e60_numemp.value = '';
    return;
  }
  js_divCarregando('Aguarde', 'div_aguarde');
  var oParametro          = new Object();
      oParametro.exec     = 'getVerify';
      oParametro.iEmpenho = document.form1.e60_numemp.value;
      oParametro.iNome    = chave1;
  
  var oDadosRequisicao            = new Object();
      oDadosRequisicao.method     = 'post';
      oDadosRequisicao.parameters = 'json='+Object.toJSON(oParametro);
      oDadosRequisicao.onComplete = mensagem2;
      //alert(mensagem);
  
  new Ajax.Request( sUrlRpc, oDadosRequisicao );

}

function js_mostraempempenho2(chave1,chave2,chave3) {
  document.form1.e60_numemp.value = chave1;
  document.form1.z01_nome.value = chave2;
  if (chave3) {
    document.form1.e60_anousu.value = chave3;
  }
  db_iframe_empempenho.hide();
}

var optionsEmpenhos = document.getElementById("numempenho");

function addOption(anoUsu, numEmp, razSoc) {

  if (!numEmp || !razSoc) {
    alert("Empenho inválido!");
    limparCampos();
    return;
  }

  if (document.form1.periodo_fechado.value == 0) {
    alert("A data atual está fora do ano contábil válido!");
    limparCampos();
    return;
  }

  var jaTem = Array.prototype.filter.call(optionsEmpenhos.children, function(o) {
    return o.value == numEmp;
  });

  if (jaTem.length > 0) {
    alert("Empenho já inserido.");
    limparCampos();
    return;
  }

  var option = document.createElement('option');
  option.value = numEmp;
  option.innerHTML = numEmp + ' - ' + razSoc;
  optionsEmpenhos.appendChild(option);

  limparCampos();
}

function limpar() {
  optionsEmpenhos.innerHTML = "";
}

function limparCampos() {
  document.form1.e60_anousu.value  = '';
  document.form1.e60_numemp.value  = '';
  document.form1.z01_nome.value   = '';
  document.form1.numempenho.value  = '';
}

optionsEmpenhos.addEventListener('dblclick', function excluirEmpenho(e) {
  optionsEmpenhos.removeChild(e.target);
});

document.getElementById('btn-lancar').addEventListener('click', function(e) {
  addOption(
    document.form1.e60_anousu.value,
    document.form1.e60_numemp.value,
    document.form1.z01_nome.value
  );
});


function js_excluir() {
  var dados = {
    inst: {
      instit: document.form1.instit.value
    },
    usuarionome: {
      nome_usuario: document.form1.nome_usuario.value
    },
    empenho: Array.prototype.map.call(optionsEmpenhos.children, function(o) {
      return o.value;
    }).join(',')
  };

  var empenhoVazio = dados.empenho == '';

  if (empenhoVazio) {
    alert('Informe pelo menos um código de empenho!');
    return;
  }

  else{
    js_exclui_empenho(dados.empenho, dados.inst.instit, dados.usuarionome.nome_usuario);
  }

}

function js_exclui_empenho(iEmpenho, iInstit, iNome){

  js_divCarregando('Aguarde', 'div_aguarde');
  var oParametro          = new Object();
      oParametro.exec     = 'insereEmpenhoExcluido';
      oParametro.iEmpenho = iEmpenho;
      oParametro.iInstit  = iInstit;
      oParametro.iNome    = iNome;

  var oDadosRequisicao            = new Object();
      oDadosRequisicao.method     = 'post';
      oDadosRequisicao.parameters = 'json='+Object.toJSON(oParametro);
      oDadosRequisicao.onComplete = mensagem;
      new Ajax.Request( sUrlRpc, oDadosRequisicao );
}

function mensagem(oResponse) {
  js_removeObj('div_aguarde');
  var oRetorno = JSON.parse(oResponse.responseText);
  if (oRetorno.status == 1) {
    alert('Exclusão realizada com sucesso!');
    limpar();
    return;
  }
  else {
    alert(oRetorno.message);
  }
}

function mensagem2(oResponse) {
  js_removeObj('div_aguarde');
  var oRetorno = JSON.parse(oResponse.responseText);
  if (oRetorno.status == 1) {
    alert('Exclusão realizada com sucesso!');
    limpar();
    return;
  }
  else {
    alert(oRetorno.message);
    document.form1.e60_numemp.value = '';
    document.form1.z01_nome.value = '';
    document.form1.e60_anousu.value = '';

    return;
  }
}

</script>
</body>
</html>

