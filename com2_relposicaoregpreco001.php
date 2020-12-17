<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_classesgenericas.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_solicita_classe.php");

$clrotulo = new rotulocampo;
$clrotulo->label("pc10_numero");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?php
  db_app::load("scripts.js, strings.js, prototype.js");
  db_app::load("estilos.css, grid.style.css");
?>
<script>
function js_limpacampos() {

  $('dtinicrg').value        = '';
  $('dtfimcrg').value        = '';
  $('dtinivlrg').value       = '';
  $('dtfimvlrg').value       = '';
  $('pc10_numero_ini').value = '';
  $('pc10_numero_fim').value = '';
  $('coddepto').value   = '';
  $('')
}

function js_emite() {

  let dtinicrg            = $F('dtinicrg');
  let dtfimcrg            = $F('dtfimcrg');
  let dtinivlrg           = $F('dtinivlrg');
  let dtfimvlrg           = $F('dtfimvlrg');
  let pc10_numero_ini     = $('pc10_numero_ini').value;
  let pc10_numero_fim     = $('pc10_numero_fim').value;
  let iItens              = $('pcmater').options.length;
  let iDepartamentos      = $('departamento').options.length;
  let iFornecedores       = $('fornecedor').options.length;
  let lQuebraDepartamento = $("lQuebraDepartamento").value;
  let lQuebraFornecedor   = $("lQuebraFornecedor").value;

  let sQuery              = '';

  if (dtinicrg != "" && dtfimcrg != "") {

    if (!js_comparadata(dtinicrg, dtfimcrg, '<=')) {
      alert('Datas de criação do registro inválidas. Verifique!');
      return false;
    }
  }

  if (dtinivlrg != "" && dtfimvlrg != "") {

    if (!js_comparadata(dtinivlrg, dtfimvlrg, '<=')) {

      alert('Datas de validade do Registro inválidas. Verifique!');
      return false;
    }
  }

  if (pc10_numero_ini != "" && pc10_numero_fim != "") {

    if (pc10_numero_fim < pc10_numero_ini) {

      alert('Números da solicitacao inválidos. Verifique!');
      return false;
    }
  }

  if(lQuebraDepartamento == 't' && iDepartamentos == 0){
    alert('Nenhum departamento selecionado. Verifique!')
    return false;
  }

  let vrg    = '';
  var sItens = '';
  for (i = 0; i < iItens; i++) {

    sItens = sItens+vrg+$('pcmater').options[i].value;
    vrg =',';
  }

  vrg = '';
  let sDepartamentos = '';
  for (i = 0; i < iDepartamentos; i++) {

    sDepartamentos = sDepartamentos+vrg+$('departamento').options[i].value;
    vrg =',';
  }

  vrg = '';
  let sFornecedores = '';
  for (let count = 0; count < iFornecedores; count++){
      sFornecedores += vrg+$('fornecedor').options[count].value;
      vrg = ',';
  }

  sQuery += '&dtinicrg='+dtinicrg;
  sQuery += '&dtfimcrg='+dtfimcrg;

  sQuery += '&dtinivlrg='+dtinivlrg;
  sQuery += '&dtfimvlrg='+dtfimvlrg;

  sQuery += '&numini='+pc10_numero_ini;
  sQuery += '&numfim='+pc10_numero_fim;
  sQuery += '&itens='+sItens;
  sQuery += '&departs='+sDepartamentos;
  sQuery += '&fornecedores='+sFornecedores;
  sQuery += '&lQuebraFornecedor='+lQuebraFornecedor;

  if (lQuebraDepartamento == "t") {
	  sUrl = "com2_relposicaoregpreco002.php?";
  } else {
	  sUrl = "com2_relposicaoregpreco_agrupado002.php?";
  }

  jan = window.open(sUrl+sQuery,'',
                    'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');

  jan.moveTo(0,0);
}
</script>
<style>
td {
  white-space: nowrap
}

.fildset-principal table td:first-child {

  width: 90px;
  white-space: nowrap
}

#departamento, #fornecedor{
  width:400px;
  size: 5;
}
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="js_limpacampos();">
<table align="center" width="30%">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
			<form name="form1" method="post" action="" onsubmit="js_limpacampos();">
			<fieldset class="fildset-principal">
			  <legend>
			    <b>Posição do Registro de Preço</b>
			  </legend>
			  <table align="left" border="0" class="table-campos">
			      <tr>
			          <td nowrap align="left"><b>Criação do Registro:</b></td>
			          <td  align="left" nowrap>
			           <?php
			             db_inputdata('dtinicrg',@$dia,@$mes,@$ano,true,'text',1,"");
			             echo " <b>até:</b> ";
			             db_inputdata('dtfimcrg',@$dia2,@$mes2,@$ano2,true,'text',1,"");
			           ?>
			          </td>
			      </tr>
			      <tr>
			          <td nowrap align="left"><b>Validade do Registro:</b></td>
			          <td  align="left" nowrap>
			           <?php
			             db_inputdata('dtinivlrg',@$dia,@$mes,@$ano,true,'text',1,"");
			             echo " <b>até:</b> ";
			             db_inputdata('dtfimvlrg',@$dia2,@$mes2,@$ano2,true,'text',1,"");
			           ?>
			          </td>
			      </tr>
			      <tr>
			        <td nowrap title="<?php echo @$Tpc10_numero?>" align="left">
			         <?php db_ancora("<b>Compilação:</b>","js_pesquisa_pc10_numero_ini(true);",1); ?>
			        </td>
			        <td>
			         <?php db_input('pc10_numero',10,@$Ipc10_numero,true,'text',4," onchange='js_pesquisa_pc10_numero_ini(false);'","pc10_numero_ini" )  ?>
			          <strong><?php db_ancora('à',"js_pesquisa_pc10_numero_fim(true);",1); ?></strong>
			         <?php db_input('pc10_numero',10,@$Ipc10_numero,true,'text',4," onchange='js_pesquisa_pc10_numero_fim(false);'","pc10_numero_fim" )  ?>
			        </td>
            </tr>
            <tr>
              <td nowrap>
                <b>Quebra por departamento:</b>
              </td>
              <td>
                <select name="lQuebraDepartamento" id="lQuebraDepartamento">
                  <option value="t">SIM</option>
                  <option value="f" selected>NÃO</option>
                </select>
              </td>
            </tr>
            <tr id='area_departamento'>
               <td colspan="2">
                <fieldset>
                  <legend>Departamentos</legend>
                  <table align="center" border="0">
                   <tr>
                      <td>
                        <?php db_ancora('Departamento',"js_pesquisa_departamento(true);",1); ?>
                      </td>
                      <td>
                        <?php
                          db_input('coddepto',6,'',true,'text',4," onchange='js_pesquisa_departamento(false);'","");
                          db_input('descrdepto',25, '', true, 'text', 3,"","");
                        ?>
                        <input type="button" value="Lançar" id="btn-lancar"/>
                      </td>
                      <tr>
                        <td colspan="2">
                          <select name="departamento[]" id="departamento" size="5" multiple>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td align="center" colspan="2">
                          <strong>Dois Cliques sobre o item o exclui.</strong>
                        </td>
                      </tr>
                   </tr>
                 </table>
                </fieldset>
               </td>
            </tr>
                <tr>
                    <td nowrap>
                        <b>Quebra por fornecedor:</b>
                    </td>
                    <td>
                        <select name="lQuebraFornecedor" id="lQuebraFornecedor">
                            <option value="t">SIM</option>
                            <option value="f" selected>NÃO</option>
                        </select>
                    </td>
                </tr>
                <tr id='area_fornecedor'>
                    <td colspan="2">
                        <fieldset>
                            <legend>Fornecedores</legend>
                            <table align="center" border="0">
                                <tr>
                                    <td>
									    <?php db_ancora('CGM',"js_pesquisa_fornelicitacao(true);",1); ?>
                                    </td>
                                    <td>
									    <?php
										db_input('z01_numcgm',6,'',true,'text',4," onchange='js_pesquisa_fornelicitacao(false);'","");
										db_input('z01_nome',25, '', true, 'text', 3,"","");
										?>
                                        <input type="button" value="Lançar" id="btn-lancar-fornecedor"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                          <select name="fornecedor[]" id="fornecedor" size="5" multiple></select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" colspan="2">
                                        <strong>Dois Cliques sobre o fornecedor o exclui.</strong>
                                    </td>
                                </tr>
                              </table>
                          </fieldset>
                      </td>
                  </tr>
			      <tr>
                    <td colspan="2">
			            <table align="left" border="0">
			                <tr>
			                    <td>
                                   <?php
                                     $cl_pcmater                 = new cl_arquivo_auxiliar;
                                     $cl_pcmater->nome_botao     = "db_lanca_codmater";
                                     $cl_pcmater->cabecalho      = "<strong>Itens Selecionados para este Relatório</strong>";
                                     $cl_pcmater->codigo         = "pc01_codmater";
                                     $cl_pcmater->descr          = "pc01_descrmater";
                                     $cl_pcmater->nomeobjeto     = 'pcmater';
                                     $cl_pcmater->funcao_js      = 'js_mostra';
                                     $cl_pcmater->funcao_js_hide = 'js_mostra1';
                                     $cl_pcmater->sql_exec       = "";
                                     $cl_pcmater->func_arquivo   = "func_pcmater.php";
                                     $cl_pcmater->nomeiframe     = "db_iframe_itens_pcmater";
                                     $cl_pcmater->localjan       = "";
                                     $cl_pcmater->onclick        = "";
                                     $cl_pcmater->db_opcao       = 2;
                                     $cl_pcmater->tipo           = 2;
                                     $cl_pcmater->top            = 0;
                                     $cl_pcmater->linhas         = 5;
                                     $cl_pcmater->vwidth         = 400;
                                     $cl_pcmater->funcao_gera_formulario();
                                   ?>
			                    </td>
			                </tr>
			           </table>
			         </td>
			      </tr>
        </table>
			</fieldset>
			<table align="center">
			  <tr>
			    <td>&nbsp;</td>
			  </tr>
			  <tr>
			    <td colspan="2" align = "center">
			      <input  name="emiterel" id="emiterel" type="button" value="Emitir Relátorio" onclick="js_emite();" >
			      <input  name="emiterelxls" id="emiterelxls" type="button" value="Exportar xls" onclick="js_emitexls();" >
			    </td>
			  </tr>
			</table>
			</form>
    </td>
  </tr>
</table>
<?php
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>

if(document.getElementById('lQuebraDepartamento').value = 'f'){
  document.getElementById('area_departamento').style.display = 'none';
}

if(document.getElementById('lQuebraFornecedor').value = 'f'){
    document.getElementById('area_fornecedor').style.display = 'none';
}

var quebraDepartamento = document.getElementById('lQuebraDepartamento');
quebraDepartamento.addEventListener('change', () => {
  document.getElementById('area_departamento').style.display = quebraDepartamento.value == 'f' ? 'none' : '';
});


var quebraFornecedor = document.getElementById('lQuebraFornecedor');
quebraFornecedor.addEventListener('change', () => {
    document.getElementById('area_fornecedor').style.display = quebraFornecedor.value == 'f' ? 'none' : '';
});

function js_pesquisa_pc10_numero_ini(mostra) {
  var lMostra         = mostra;
  var pc10_numero_ini = $('pc10_numero_ini').value;
  var sFuncao         = '&funcao_js=parent.js_mostrapc10_numero_ini';

  var sUrl1           = 'func_solicitacompilacao.php?funcao_js=parent.js_mostrapc10_numero_ini1|pc10_numero';
  var sUrl2           = 'func_solicitacompilacao.php?pesquisa_chave='+pc10_numero_ini+'&tipobusca=1'+sFuncao;

  if (lMostra == true) {
    js_OpenJanelaIframe('top.corpo','db_iframe_solicitacompilacao',sUrl1,'Pesquisa',true);
  } else {

     if (pc10_numero_ini != '') {
        js_OpenJanelaIframe('top.corpo','db_iframe_solicitacompilacao',sUrl2,'Pesquisa',false);
     } else {
       $('pc10_numero_ini').value = '';
     }
  }
  limparCampos('d');
}

function js_mostrapc10_numero_ini(chave,erro) {
  $('pc10_numero_ini').value = chave;
  if (erro == true) {

    $('pc10_numero_ini').value = '';
    $('pc10_numero_ini').focus();
  }
}

function js_mostrapc10_numero_ini1(chave) {

  $('pc10_numero_ini').value = chave;
  db_iframe_solicitacompilacao.hide();
}

function js_pesquisa_pc10_numero_fim(mostra) {

  var lMostra         = mostra;
  var pc10_numero_fim = $('pc10_numero_fim').value;
  var sFuncao         = '&funcao_js=parent.js_mostrapc10_numero_fim';

  var sUrl1           = 'func_solicitacompilacao.php?funcao_js=parent.js_mostrapc10_numero_fim1|pc10_numero';
  var sUrl2           = 'func_solicitacompilacao.php?pesquisa_chave='+pc10_numero_fim+'&tipobusca=1'+sFuncao;

  if (lMostra == true) {
    js_OpenJanelaIframe('top.corpo','db_iframe_solicitacompilacao',sUrl1,'Pesquisa',true);
  } else {

     if (pc10_numero_fim != '') {
       js_OpenJanelaIframe('top.corpo','db_iframe_solicitacompilacao',sUrl2,'Pesquisa',false);
     } else {
       $('pc10_numero_fim').value = '';
     }
  }
  limpaOptions('d');
}

function js_mostrapc10_numero_fim(chave,erro) {

  $('pc10_numero_fim').value = chave;
  if (erro == true) {

    $('pc10_numero_fim').value = '';
    $('pc10_numero_fim').focus();
  }
}

function js_mostrapc10_numero_fim1(chave1) {

  $('pc10_numero_fim').value = chave1;
  db_iframe_solicitacompilacao.hide();
}

function js_pesquisa_departamento(mostra){
  if (mostra==true) {
    if(document.form1.pc10_numero_ini.value == '' && document.form1.pc10_numero_fim.value == ''){
      alert('Informe o número da compilação!');
      return;
    }
    var numero_ini = document.form1.pc10_numero_ini.value;
    var numero_fim = document.form1.pc10_numero_fim.value;
    js_OpenJanelaIframe('top.corpo','db_iframe_departamento','func_departamento.php?comp_ini='+numero_ini+
      '&comp_fim='+numero_fim+'&funcao_js=parent.js_mostradepart|coddepto|descrdepto','Pesquisa',true);
  } else {
     if (document.form1.coddepto.value != '') {
        js_OpenJanelaIframe('','db_iframe_departamento','func_departamento.php?pesquisa_chave='+document.form1.coddepto.value+'&funcao_js=parent.js_mostradepart1','Pesquisa',false);
     } else {
       document.form1.coddepto.value = '';
      }
  }
}

function js_mostradepart1(chave1, chave2, erro) {
  if (erro==true) {
    document.form1.coddepto.focus();
    document.form1.coddepto.value = '';
    return;
  }
}

function js_mostradepart(chave1,chave2) {
  document.form1.coddepto.value = chave1;
  document.form1.descrdepto.value = chave2;
  db_iframe_departamento.hide();
}

function js_pesquisa_fornelicitacao(mostra){
    if (mostra) {
        if(document.form1.pc10_numero_ini.value == '' && document.form1.pc10_numero_fim.value == ''){
            alert('Informe o número da compilação!');
            return;
        }
        let numero_ini = document.form1.pc10_numero_ini.value;
        let numero_fim = document.form1.pc10_numero_fim.value;
        js_OpenJanelaIframe('top.corpo','db_iframe_fornelicitacao','func_fornelicitacao.php?comp_ini='+numero_ini+
            '&comp_fim='+numero_fim+'&funcao_js=parent.js_mostrafornelicitacao|z01_numcgm|z01_nome','Pesquisa',true);
    } else {
        if (document.form1.z01_numcgm.value != '') {
            js_OpenJanelaIframe('','db_iframe_fornelicitacao','func_fornelicitacao.php?pesquisa_chave='+document.form1.z01_numcgm.value+'&funcao_js=parent.js_mostrafornelicitacao1','Pesquisa',false);
        } else {
            document.form1.z01_numcgm.value = '';
            document.form1.z01_nome.value = '';
        }
    }
}

function js_mostrafornelicitacao1(chave, erro) {

    if (erro) {
        document.form1.z01_numcgm.focus();
        document.form1.z01_numcgm.value = '';
        return;
    }

    document.getElementById('z01_nome').value = chave;
}

function js_mostrafornelicitacao(chave1,chave2) {
    document.form1.z01_numcgm.value = chave1;
    document.form1.z01_nome.value = chave2;
    db_iframe_fornelicitacao.hide();
}

lQuebraDepartamento = document.getElementById('lQuebraDepartamento');
lQuebraDepartamento.addEventListener('click', () => {
    document.getElementById('area_departamento').style.display = lQuebraDepartamento.value == 't' ? '' : 'none';

    if(lQuebraDepartamento.value == 'f'){
        document.getElementById('area_departamento').style.display = 'none';
        limparCampos('d');
        limpaOptions('d');
    }
});

lQuebraFornecedor = document.getElementById('lQuebraFornecedor');
lQuebraFornecedor.addEventListener('click', () => {
    document.getElementById('area_fornecedor').style.display = lQuebraFornecedor.value == 't' ? '' : 'none';

    if(lQuebraFornecedor.value == 'f'){
        document.getElementById('area_fornecedor').style.display = 'none';
        limparCampos('f');
        limpaOptions('f');
    }
});

var optionsDepartamentos = document.getElementById("departamento");
var optionsFornecedores = document.getElementById("fornecedor");

function addOption(codigo, descricao, element='') {

    if(document.getElementById('pc10_numero_ini').value == '' && document.getElementById('pc10_numero_ini').value == ''){
        alert('Informe o número da compilação');
        limparCampos('');
        return;
    }

    if (!codigo || !descricao) {
        alert(element == 'd' ? 'Departamento' : 'Fornecedor' + " inválido!");
        limparCampos(element);
        return;
    }

    let aOptions = element == 'd' ? optionsDepartamentos : optionsFornecedores;
    let jaTem = Array.prototype.filter.call(aOptions.children, (o) => {
        return o.value == codigo;
    });


    if (jaTem.length > 0) {
        alert(element == 'd' ? 'Departamento' : 'Fornecedor' + " já inserido.");
        limparCampos(element);
        return;
    }

    let option = document.createElement('option');
    option.value = codigo;
    option.innerHTML = codigo + ' - ' + descricao;
    aOptions.appendChild(option);

    limparCampos(element);
}

function limpaOptions(param = '') {
    if(param == 'd'){
        optionsDepartamentos.innerHTML = "";
    }else{
        optionsFornecedores.innerHTML = "";
    }
}

function limparCampos(param = '') {
    if(param == 'd') {
        document.form1.coddepto.value  = '';
        document.form1.descrdepto.value  = '';
    }else{
        document.form1.z01_numcgm.value  = '';
        document.form1.z01_nome.value  = '';
    }
}

optionsDepartamentos.addEventListener('dblclick', (e) => {
  optionsDepartamentos.removeChild(e.target);
});

optionsFornecedores.addEventListener('dblclick', (e) => {
    optionsFornecedores.removeChild(e.target);
});

document.getElementById('btn-lancar').addEventListener('click', function(e) {
    addOption(
        document.form1.coddepto.value,
        document.form1.descrdepto.value,
        'd'
  );
});

document.getElementById('btn-lancar-fornecedor').addEventListener('click', (e) => {
    addOption(document.form1.z01_numcgm.value, document.form1.z01_nome.value, 'f');
});

function js_emitexls() {
    var dtinicrg            = $F('dtinicrg');
    var dtfimcrg            = $F('dtfimcrg');
    var dtinivlrg           = $F('dtinivlrg');
    var dtfimvlrg           = $F('dtfimvlrg');
    var pc10_numero_ini     = $('pc10_numero_ini').value;
    var pc10_numero_fim     = $('pc10_numero_fim').value;
    var iItens              = $('pcmater').options.length;
    var iDepartamentos      = $('departamento').options.length;
    var iFornecedores       = $('fornecedor').options.length;
    var lQuebraDepartamento = $("lQuebraDepartamento").value;
    var lQuebraFornecedor   = $("lQuebraFornecedor").value;
    var sQuery              = '';

    if (dtinicrg != "" && dtfimcrg != "") {

        if (!js_comparadata(dtinicrg, dtfimcrg, '<=')) {
            alert('Datas de criação do registro inválidas. Verifique!');
            return false;
        }
    }

    if (dtinivlrg != "" && dtfimvlrg != "") {

        if (!js_comparadata(dtinivlrg, dtfimvlrg, '<=')) {

            alert('Datas de validade do Registro inválidas. Verifique!');
            return false;
        }
    }

    if (pc10_numero_ini != "" && pc10_numero_fim != "") {

        if (pc10_numero_fim < pc10_numero_ini) {

            alert('Números da solicitacao inválidos. Verifique!');
            return false;
        }
    }

    if(lQuebraDepartamento == 't' && iDepartamentos == 0){
        alert('Nenhum departamento selecionado. Verifique!');
        return false;
    }

    var vrg    = '';
    let sItens = '';
    for (let i = 0; i < iItens; i++) {

        sItens = sItens+vrg+$('pcmater').options[i].value;
        vrg =',';
    }

    vrg    = '';
    let sDepartamentos = '';

    for (let i = 0; i < iDepartamentos; i++) {
        sDepartamentos += vrg+$('departamento').options[i].value;
        vrg =',';
    }

    vrg    = '';
    let sFornecedores = '';

    for (let count = 0; count < iFornecedores; count++) {
        sFornecedores += vrg + $('fornecedor').options[count].value;
        vrg =',';
    }

    sQuery += '&dtinicrg='+dtinicrg;
    sQuery += '&dtfimcrg='+dtfimcrg;

    sQuery += '&dtinivlrg='+dtinivlrg;
    sQuery += '&dtfimvlrg='+dtfimvlrg;

    sQuery += '&numini='+pc10_numero_ini;
    sQuery += '&numfim='+pc10_numero_fim;
    sQuery += '&itens='+sItens;
    sQuery += '&departs='+sDepartamentos;
    sQuery += '&fornecedores='+sFornecedores;
    sQuery += '&lQuebraFornecedor='+lQuebraFornecedor;

    sUrl = "com2_gerarxlsposicaoregpreco.php?";

    const jan = window.open(sUrl+sQuery,'',
        'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
}

</script>
