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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_liborcamento.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");
include("classes/db_controleext_classe.php");
include("classes/db_controleextvlrtransf_classe.php");

$clcontroleext = new cl_controleext;
$clcontroleext->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("c60_codcon");
$clrotulo->label("c60_descr");

db_postmemory($HTTP_POST_VARS);
db_postmemory($_GET);

$db_opcao = 1;
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
#codcontas { width: 400px; }
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
    <table align="center" cellspacing='0' border="0">
      <tr>
        <td nowrap title="<?=@$Tk168_previni?>" style='width: 270px;'>
          <b>Período de referência:</b>
          <? db_inputdata('k168_previni',@$k168_previni_dia,@$k168_previni_mes,@$k168_previni_ano,true,'text',$db_opcao,"") ?>
        </td>

        <td nowrap title="<?=@$Tk168_prevfim?>" style='width: 135px;text-align: right;'>
          <b>à:</b>
          <? db_inputdata('k168_prevfim',@$k168_prevfim_dia,@$k168_prevfim_mes,@$k168_prevfim_ano,true,'text',$db_opcao,"onchange='confereDataIni(this)'") ?>
        </td>
      </tr>
    </table>
    <fieldset>
      <legend>Contas</legend>
      <table class="center">
        <tr>
          <td nowrap title="<?=@$Tk167_codcon?>">
            <? db_ancora('Conta',"js_pesquisak167_codcon(true);",$db_opcao); ?>
          </td>
          <td>
            <?php
              db_input('k167_codcon',8,$Ik167_codcon,true,'text',$db_opcao," onchange='js_pesquisak167_codcon(false);'");
              db_input('c60_descr',30,$Ic60_descr,true,'text',3,'');
              db_input('k167_anousu',4,$Ik167_anousu,true,'hidden',3,'');
            ?>
            <input type="button" value="Lançar" id="btn-lancar" />
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <select name="codcontas[]" id="codcontas" size="12" multiple ondblclick="js_excluir_itemcodcontas()">
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
      <input type="submit" value="Emitir relatório" onclick="js_emite();">
    </div>
  </form>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script type="text/javascript">
function js_pesquisak167_codcon(mostra){
  if(mostra==true){
    // c60_codsis = 7
    js_OpenJanelaIframe('','db_iframe_conplano','func_controleext.php?funcao_js=parent.js_mostraconplano1|c60_codcon|c60_descr|c60_anousu&controleext','Pesquisa',true);
  }else{
     if(document.form1.k167_codcon.value != ''){
        js_OpenJanelaIframe('','db_iframe_conplano','func_controleext.php?codcon='+document.form1.k167_codcon.value+'&pegaAnousu&funcao_js=parent.js_mostraconplano&controleext','Pesquisa',false);
     }else{
       document.form1.c60_codcon.value = '';
     }
  }
}
function js_mostraconplano(chave1, chave2, erro) {
  document.form1.c60_descr.value = chave1;
  document.form1.k167_anousu.value = chave2;

  if(erro==true){
    document.form1.k167_codcon.focus();
    document.form1.k167_codcon.value = '';
    return;
  }
}

function js_mostraconplano1(chave1,chave2,chave3) {
  document.form1.k167_codcon.value = chave1;
  document.form1.c60_descr.value = chave2;
  document.form1.k167_anousu.value = chave3;
  db_iframe_conplano.hide();
}


function confereDataIni(input) {
  if (document.form1.k168_previni.value == '') {
    alert('Preencha a data na sequência correta.');
    document.form1.k168_previni.focus();
    input.value = '';
  }
}

var optionsContas = document.getElementById("codcontas");


function addOption(anoUsu, codConta, descConta) {

  if (!codConta || !descConta) {
    alert("Conta inválida");
    limparCampos();
    return;
  }

  var jaTem = Array.prototype.filter.call(optionsContas.children, function(o) {
    return o.value == codConta;
  });

  if (jaTem.length > 0) {
    alert("Conta já inserida.");
    limparCampos();
    return;
  }

  var option = document.createElement('option');
  option.value = codConta+"-"+anoUsu;
  option.innerText = codConta + ' - ' + descConta;

  optionsContas.appendChild(option);

  limparCampos();
}

function limparCampos() {
  document.form1.k167_anousu.value  = '';
  document.form1.k167_codcon.value  = '';
  document.form1.c60_descr.value    = '';
}

optionsContas.addEventListener('dblclick', function excluirConta(e) {
  optionsContas.removeChild(e.target);
});

document.getElementById('btn-lancar').addEventListener('click', function(e) {
  addOption(
    document.form1.k167_anousu.value,
    document.form1.k167_codcon.value,
    document.form1.c60_descr.value
  );
});


function js_emite() {
  var dados = {
    datas: {
      inicio: document.form1.k168_previni.value,
      final: document.form1.k168_prevfim.value
    },
    conta: Array.prototype.map.call(optionsContas.children, function(o) {
      return (o.value).split("-")[0];
    }).join(','),
    anosContas: Array.prototype.map.call(optionsContas.children, function(o) {
      return (o.value).split("-")[1];
    }).join(',')
  };
  var aAnos = (dados.anosContas).split(",");
  var contasAnosDiferentesPeriodo = false;
  for(i=0; i<aAnos.length; i++){
    if(aAnos[i] != (dados.datas.inicio).split("/")[2]){
      contasAnosDiferentesPeriodo = true;
    }
  }

  var datasVazias   = dados.datas.inicio == '' && dados.datas.final == '';
  var contaVazia    = dados.conta == '';
  var umaDataVazia  = (dados.datas.inicio != '' && dados.datas.final == '')
                    || (dados.datas.inicio == '' && dados.datas.final != '');
  var anosDiferentes = (dados.datas.inicio).split("/")[2] != (dados.datas.final).split("/")[2];


  if (umaDataVazia) {
    alert('Preencha o período de referência corretamente.');
    return;
  }

  if (datasVazias) {
    alert('Preencha o período de referência.');
    return;
  }

  if(anosDiferentes){
    alert("O período de referência deverá ser do mesmo ano de cadastro da conta.");
    return;
  }

  if(contasAnosDiferentesPeriodo && contaVazia == false){
    alert("As contas selecionadas deverão ser do mesmo ano do período de referência.");
    return;
  }

  var query = "";
  query += datasVazias ? '' : ('datas_inicio=' + dados.datas.inicio + '&datas_final=' + dados.datas.final),
  query += contaVazia ? '' : ("&conta=" + dados.conta),

  jan = window.open(
    "cai2_controleext002.php?" + query,
    "",
    'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0'
  );
  jan.moveTo(0,0);
}

</script>
</body>
</html>

