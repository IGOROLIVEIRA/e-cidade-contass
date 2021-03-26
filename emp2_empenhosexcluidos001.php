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
//Ocorrência 3414

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_liborcamento.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");
include("classes/db_empenhosexcluidos_classe.php");
include("classes/db_cgm_classe.php");

$clempenhosexcluidos = new cl_empenhosexcluidos;
$clcgm = new cl_cgm;

$clrotulo = new rotulocampo;
$clrotulo->label("z01_numcgm");
$clrotulo->label("z01_nome");

db_postmemory($HTTP_POST_VARS);
db_postmemory($_GET);

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

.empenhos{
  display: block;
  float: left;
  margin-right: 50px;
  margin-left: -240px;
}

.credores{
  display: inline-block;
  position: absolute;
}

#numempenhoexcl, #cgm { width: 400px; }
.formulario .submit {
  margin-top: 10px;
  text-align: center;
}

#botao{
  margin-top: 330px;
  position: absolute;
  margin-left: 175px;}

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
    <div class="empenhos">
    <fieldset>
      <legend>Empenhos</legend>
      <table class="center">
        <tr>
          <td nowrap title="<?=@$Te290_e60_numemp?>">
            <? db_ancora('Empenho',"js_pesquisae290_e60_numemp(true);"); ?>
          </td>
          <td>
            <?php
              db_input('e290_e60_numemp',8,$Ie290_e60_numemp,true,'text',"","onchange='js_pesquisae290_e60_numemp(false);'");
              db_input('e290_z01_nome',30,$Ie290_z01_nome,true,'text',3,"");
              db_input('e290_e60_anousu',4,$Ie290_e60_anousu,true,'hidden',3,"");
            ?>
            <input type="button" value="Lançar" id="btn-lancaremp"/>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <select name="numempenhoexcl[]" id="numempenhoexcl" size="12" multiple>
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
    </div>
    <div class="credores">
    <fieldset>
      <legend>Credores</legend>
      <table class="center">
        <tr>
          <td nowrap title="<?=@$Tz01_numcgm?>">
            <? db_ancora('Credores',"js_pesquisa_cgm(true);"); ?>
          </td>
          <td>
            <?php
              db_input('z01_numcgm',8,$Iz01_numcgm,true,'text',""," onchange='js_pesquisa_cgm(false);'");
              db_input('z01_nome',30,$Iz01_nome,true,'text',3,'');
            ?>
            <input type="button" value="Lançar" id="btn-lanccgm"/>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <select name="cgm[]" id="cgm" size="12" multiple>
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
    </div>
    <div id="botao" class="submit">
      <input type="submit" value="Emitir relatório" onclick="js_emite();">
    </div>
  </form>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script type="text/javascript">


/* INÍCIO - Funções Empenhos Excluídos*/
function js_pesquisae290_e60_numemp(mostra){
  if (mostra==true) {
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empenhosexcluidos','func_empenhosexcluidos.php?funcao_js=parent.js_mostraempempenhoexcl2|e290_e60_numemp|e290_z01_nome|e290_e60_anousu','Pesquisa',true);
  } else {
     if (document.form1.e290_e60_numemp.value != '') {
        js_OpenJanelaIframe('','db_iframe_empenhosexcluidos','func_empenhosexcluidos.php?codemp='+document.form1.e290_e60_numemp.value+'&pesquisa_chave&funcao_js=parent.js_mostraempempenhoexcl','Pesquisa',false);
     } else {
       document.form1.e290_e60_anousu.value = '';
     }
  }

}

function js_mostraempempenhoexcl(chave1, chave2, erro) {
  document.form1.e290_z01_nome.value = chave1;
  document.form1.e290_e60_anousu.value = chave2;

  if (erro==true) {
    document.form1.e290_e60_numemp.focus();
    document.form1.e290_e60_numemp.value = '';
    return;
  }
}

function js_mostraempempenhoexcl2(chave1,chave2,chave3) {
  document.form1.e290_e60_numemp.value = chave1;
  document.form1.e290_z01_nome.value = chave2;
  if (chave3) {
    document.form1.e290_e60_anousu.value = chave3;
  }
  db_iframe_empenhosexcluidos.hide();
}

var optionsEmpExcl = document.getElementById("numempenhoexcl");


function addOptionEmp(codEmpExcl, descEmpExcl) {

  if (!codEmpExcl || !descEmpExcl) {
    alert("Empenho inválido!");
    limparCamposEmp();
    return;
  }

  var jaTem = Array.prototype.filter.call(optionsEmpExcl.children, function(o) {
    return o.value == codEmpExcl;
  });

  if (jaTem.length > 0) {
    alert("Empenho já inserido!");
    limparCamposEmp();
    return;
  }

  var option = document.createElement('option');
  option.id = 'numempenhoexcl';
  option.value = codEmpExcl;
  option.innerHTML = codEmpExcl + ' - ' + descEmpExcl;

  optionsEmpExcl.appendChild(option);

  limparCamposEmp();
}

function limparCamposEmp() {
  document.form1.e290_e60_numemp.value  = '';
  document.form1.e290_z01_nome.value  = '';
}

optionsEmpExcl.addEventListener('dblclick', function excluirEmp(e) {
  optionsEmpExcl.removeChild(e.target);
});

document.getElementById('btn-lancaremp').addEventListener('click', function(e) {
  addOptionEmp(
    document.form1.e290_e60_numemp.value,
    document.form1.e290_z01_nome.value
  );
});

/* FIM - Funções Empenhos Excluídos*/


/* INÍCIO - Funções Credores*/

function js_pesquisa_cgm(mostra){
  if (mostra==true) {
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_cgm_empenho.php?funcao_js=parent.js_mostracgm1|e60_numcgm|z01_nome','Pesquisa',true);
  } else {
     if (document.form1.z01_numcgm.value != '') {
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_cgm_empenho.php?pesquisa_chave='+document.form1.z01_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     } else {
       document.form1.z01_nome.value = '';
     }
  }
}

function js_mostracgm(chave,erro){
  document.form1.z01_nome.value = chave;
  if (erro==true) {
    document.form1.z01_nome.value = '';
    document.form1.z01_numcgm.focus();
  }
}
function js_mostracgm1(chave1,chave2){
   document.form1.z01_numcgm.value = chave1;
   document.form1.z01_nome.value = chave2;
   db_iframe_cgm.hide();
}

var optionsCgm = document.getElementById("cgm");


function addOptionCGM(codCgm, descCgm) {

  if (!codCgm || !descCgm) {
    alert("Credor inválido!");
    limparCamposCgm();
    return;
  }

  var jaTem = Array.prototype.filter.call(optionsCgm.children, function(o) {
    return o.value == codCgm;
  });

  if (jaTem.length > 0) {
    alert("Credor já inserido!");
    limparCamposCgm();
    return;
  }

  var option = document.createElement('option');
  option.id = 'cgm';
  option.value = codCgm;
  option.innerHTML = codCgm + ' - ' + descCgm;

  optionsCgm.appendChild(option);

  limparCamposCgm();
}

function limparCamposCgm() {
  document.form1.z01_numcgm.value  = '';
  document.form1.z01_nome.value  = '';
}

optionsCgm.addEventListener('dblclick', function excluirCredor(e) {
  optionsCgm.removeChild(e.target);
});

document.getElementById('btn-lanccgm').addEventListener('click', function(e) {
  addOptionCGM(
    document.form1.z01_numcgm.value,
    document.form1.z01_nome.value
  );
});

/* FIM - Funções Credores*/

function confereDataIni(input) {
  if (document.form1.k168_previni.value == '') {
    alert('Preencha a data na sequência correta.');
    document.form1.k168_previni.focus();
    input.value = '';
  }
}

function js_emite() {
  var dados = {
    datas: {
      inicio: document.form1.k168_previni.value,
      final: document.form1.k168_prevfim.value
    },
    empenhos: Array.prototype.map.call(optionsEmpExcl.children, function(o) {
      return o.value;
    }).join(','),
    credores: Array.prototype.map.call(optionsCgm.children, function(o) {
      return o.value;
    }).join(',')
  };


  var datasVazias   = dados.datas.inicio == '' && dados.datas.final == '';
  var empVazio      = dados.empenhos == '';
  var credorVazio   = dados.credores == '';
  var umaDataVazia  = (dados.datas.inicio != '' && dados.datas.final == '') || (dados.datas.inicio == '' && dados.datas.final != '');

  /*if (datasVazias) {
    alert('Preencha as datas corretamente!');
    return;
  }

  if (umaDataVazia) {
    alert('Preencha as datas corretamente!');
    return;
  }

  else if ((!datasVazias && empVazio) && credorVazio) {
    alert('Informe pelo menos um empenho ou credor!');
    return;
  }

  else if ((!datasVazias && credorVazio) && empVazio) {
    alert('Informe pelo menos um empenho ou credor!');
    return;
  }*/

  if ((empVazio && credorVazio) && datasVazias) {
    alert('Informe o período, ou pelo menos um empenho ou credor!');
    return;
  }

  else if ((empVazio && credorVazio) && umaDataVazia) {
    alert('Preencha as datas corretamente!');
    return;
  }


  var query = "";
  query += datasVazias ? '' : ('datas_inicio=' + dados.datas.inicio + '&datas_final=' + dados.datas.final),
  query += empVazio ? '' : ("&empenho=" + dados.empenhos),
  query += credorVazio ? '' : ("&credor=" + dados.credores),

  jan = window.open(
    "emp2_empenhosexcluidos002.php?" + query,
    "",
    'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0'
  );
  jan.moveTo(0,0);
}

</script>
</body>
</html>

