<?php
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
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_libdicionario.php");
require_once("libs/db_app.utils.php");
require_once("classes/db_placaixa_classe.php");
require_once("classes/db_placaixarec_classe.php");
require_once("dbforms/db_classesgenericas.php");
require_once("libs/JSON.php");
include("classes/db_tabrec_classe.php");

db_postmemory($HTTP_POST_VARS);

$clplacaixa    = new cl_placaixa;
$clplacaixarec = new cl_placaixarec;
$clrotulo      = new rotulocampo;
$oJson         = new services_json();
$cltabrec      = new cl_tabrec;

$clplacaixa->rotulo->label();
$clrotulo->label("nomeinst");

$clplacaixarec->rotulo->label();
$clrotulo->label("k80_data");
$clrotulo->label("k13_descr");
$clrotulo->label("k02_descr");
$clrotulo->label("k02_drecei");
$clrotulo->label("c61_codigo");
$clrotulo->label("o15_codigo");
$clrotulo->label("z01_numcgm");
$clrotulo->label("z01_nome");
$clrotulo->label("q02_inscr");
$clrotulo->label("j01_matric");

$db_opcao = 1;
$c58_sequencial = "000";
$c58_descr      = "NAO SE APLICA";
/*
 * definimos qual funcao sera usada para consultar a matricula.
* se o campo db_config.db21_usasisagua for true, usamos a func_aguabase.
* se for false, usamos a func_iptubase
*/
$oDaoDBConfig = db_utils::getDao("db_config");
$rsInstit     = $oDaoDBConfig->sql_record($oDaoDBConfig->sql_query_file(db_getsession("DB_instit")));
$oInstit      = db_utils::fieldsMemory($rsInstit, 0);
$sFuncaoBusca = "js_pesquisaMatricula";
if ($oInstit->db21_usasisagua == "t") {
  $sFuncaoBusca = "js_pesquisa_agua";
}
?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?php
    db_app::load("scripts.js");
    db_app::load("prototype.js");
    db_app::load("datagrid.widget.js");
    db_app::load("strings.js");
    db_app::load("grid.style.css");
    db_app::load("estilos.css");
    db_app::load("classes/dbViewAvaliacoes.classe.js");
    db_app::load("widgets/windowAux.widget.js");
    db_app::load("widgets/dbmessageBoard.widget.js");
    db_app::load("dbcomboBox.widget.js");
  ?>
<style>

  #k81_origem {
    width: 95px;
  }
  .tamanho-primeira-col{
    width:150px;
  }

  .input-menor {
    width:100px;
  }

  .input-maior {
    width:400px;
  }

   #k81_codigo {
     width: 95px;
   }
   #k81_codigodescr {
     width: 77%;
   }

   #k81_obs {
     width:100%;
     height: 50px;
   }

</style>

<?

if (isset($arquivo) && (isset($k81_conta) && $k81_conta != '')) {

  if (move_uploaded_file($_FILES['arquivo']['tmp_name'], "tmp/".$_FILES['arquivo']['name'])) {

  	$aReceita = array();
  	$aEstrutNaoEncontrato = array();
  	$oArquivo = fopen("tmp/".$_FILES['arquivo']['name'], "r");
  	while (!feof($oArquivo)) {

  		$sLinhaArquivo = fgets($oArquivo);
  		if (strlen($sLinhaArquivo) < 51) {
  			continue;
  		}
  		$k02_estorc = "4".substr($sLinhaArquivo, 12, 10);
  		$sql = $cltabrec->sql_query_inst("","tabrec.*","k02_codigo"," k02_estorc like '$k02_estorc%' ");
  		$result = db_query($sql);
  	  if (pg_num_rows($result) == 0) {
  	  	$aEstruNaoEncontrato[] = $k02_estorc;
  			continue;
  		}
  		$oDadosRec = db_utils::fieldsMemory($result, 0);

  	  $oReceita = new stdClass();
      //Receita
      $oReceita->iReceitaPlanilha = "";//$F('codigo_receitaplanilha');
      $oReceita->k81_receita      = $oDadosRec->k02_codigo;//$F('k81_receita');
      $oReceita->k02_drecei       = urldecode(utf8_encode($oDadosRec->k02_drecei));//$F('k02_drecei');

      //Conta
      $oReceita->k81_conta        = $k81_conta;
      $oReceita->k13_descr        = $k13_descr;

      //Origem
      $sSqlCgm = "select numcgm from db_config where codigo = ".db_getsession("DB_instit");
		  $rsResultCgm = db_query($sSqlCgm);
		  $iCgm = db_utils::fieldsMemory($rsResultCgm, 0)->numcgm;
      $oReceita->k81_origem       = 1;
      $oReceita->k81_numcgm       = $iCgm;
      $oReceita->q02_inscr        = "";
      $oReceita->j01_matric       = "";

      //Recurso
      $oReceita->k81_codigo       = 1;
      $oReceita->k81_codigodescr  = "RECUROS LIVRE";

      //Característica Peculiar
      $oReceita->c58_sequencial   = "000";

      //Data Recebimento
      $data = substr($sLinhaArquivo, 1, 8);
      $oReceita->k81_datareceb    = $data[4].$data[5].$data[6].$data[7]."-".$data[2].$data[3]."-".$data[0].$data[1];//$F('k81_datareceb');

      //Dados Adicionais
      $oReceita->k81_valor        = $valor = ((float)substr($sLinhaArquivo, 34, 14))/100;//$F('k81_valor');
      $oReceita->k81_obs          = 'Integração sistema tributário';//$F('k81_obs');
      $oReceita->recurso          = $oDadosRec->recurso;//$F('recurso');
      $oReceita->k81_operbanco    = substr($sLinhaArquivo, 9, 3);//$F('k81_operbanco');
      $aReceita[] = $oReceita;

    }
  	fclose($oArquivo);

  	echo "<script> alert('Os seguintes estruturais (".implode(",", $aEstruNaoEncontrato).") não foram encontrados');</script>";

    $jsReceita = $oJson->encode($aReceita);
    echo "<script> jsReceita = ". $jsReceita . ";</script>";

  } else {
    db_msgbox("Erro ao copiar o arquivo {$_FILES['origem']['name']}. ");
  }

} else if (isset($arquivo)) {
	db_msgbox("É necessário selecionar uma conta e um arquivo.");
}

?>

</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>

<form name="form1" method="post" action="<?=$db_action?>" enctype="multipart/form-data">

<fieldset style="margin-top: 30px; width: 800px;">
  <legend><strong>Planilha de Arrecadação</strong></legend>



<!-- Dados Receita -->
<fieldset style="width:95%; margin-top: 20px">
<legend><b>Receita</b></legend>
  <table border="0" width="100%">


    <!-- Código Conta -->
    <tr>
      <td class='tamanho-primeira-col' nowrap title="<?=@$Tk81_conta?>">
          <?
          db_ancora($Lk81_conta,"js_pesquisaConta(true);",$db_opcao);
          ?>
      </td>
      <td colspan='3'>
        <?
        db_input('k81_conta' ,10,$Ik81_conta,true,'text',2,"onchange='js_pesquisaConta(false);'");
        db_input('c61_codigo',5,$Ic61_codigo,true,'text',3);
        db_input('k13_descr' ,50,$Ik13_descr,true,'text',3,"class='input-maior'");
        ?>
      </td>
    </tr>

    <tr>
     <td>
     <b>Arquivo:</b>
     </td>
     <td>
     <?
     db_input('arquivo', 50, '', true, 'file', 1);
     ?>
     </td>
    </tr>

  </table>
</fieldset>
<br>

<input type='submit'  value='Importar'               id ='importar'  />
<div id='ctnReceitas' style="margin-top: 20px;"></div>

</fieldset>
<input type="button" value='Salvar Planilha'      id='salvar'  style="margin-top: 10px;" onclick='js_salvarPlanilha()'/>
<input type="button" value='Nova Planilha'        id='excluir' style="margin-top: 10px;" onclick='js_novaReceita()' />
</form>
</center>

<?php
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>

<script>
var iAlteracao      = null;
var iIndiceReceitas = 0;
var aReceitas       = new Array();
function js_gridReceitas() {

	   oGridReceitas = new DBGrid('ctnReceitas');
	   oGridReceitas.nameInstance = 'oGridReceitas';
	   //oGridReceitas.setCheckbox(0);
	   oGridReceitas.setCellWidth(new Array(
	                                         '45%',
	                                         '45%',
	                                         '10%'));

	   oGridReceitas.setCellAlign(new Array(
	                                         'left',
	                                         'left',
	                                         'right'));


	   oGridReceitas.setHeader(new Array(
	                                      'Dados da Conta',
	                                      'Conta Tesouraria',
	                                      'Valor'));


	   //oGridReceitas.aHeaders[0].lDisplayed = false;
	   //oGridReceitas.aHeaders[1].lDisplayed = false;
	   //oGridReceitas.aHeaders[5].lDisplayed = false;
	   oGridReceitas.setHeight(100);
	   oGridReceitas.show($('ctnReceitas'));
	   oGridReceitas.clearAll(true);
	  }

/**
 * Função para Adicionar uma Receita na Grid
 */
function js_addReceita () {

  for (var i = 0; i < jsReceita.length; i++) {

	  var oReceita = jsReceita[i];
    oReceita.iIndice               = "a"+iIndiceReceitas;
    aReceitas["a"+iIndiceReceitas] = oReceita;
    iIndiceReceitas++;
  }

  js_renderizarGrid();
  $('k81_conta').value  = '';
  $('c61_codigo').value = '';
  $('k13_descr').value  = '';
  //alert("Receita inserida com sucesso!");
  //js_limpaFormularioReceita();
}

/**
 * Função para redesenhar a grid na tela
 */
function js_renderizarGrid() {

   oGridReceitas.clearAll(true);

  for (var iIndice in aReceitas) {

    var oReceita = aReceitas[iIndice];

    if (typeof(oReceita) == 'function') {
      continue;
    }
    var aRow = new Array();
    //aRow[0]  = iIndice;
    aRow[0]  = oReceita.k81_conta + " - " + oReceita.k13_descr;
    aRow[1]  = oReceita.k81_receita + " - " + oReceita.k02_drecei;
    aRow[2]  = js_formatar(oReceita.k81_valor, "f");
    //aRow[4]  = "<input type='button' onclick=js_mostraReceita(\'"+iIndice+"\') value='A'/>";
    oGridReceitas.addRow(aRow);
  }
  oGridReceitas.renderRows();
}

/**
 *   CONTA
 */
function js_pesquisaConta(lMostra) {

 recurso = 0;
 var sFuncao   = 'funcao_js=parent.js_mostraSaltes|k13_conta|k13_descr|c61_codigo';
 var sPesquisa = 'func_saltesrecurso.php?recurso='+recurso+'&'+sFuncao+'&data_limite=<?=date("Y-m-d",db_getsession("DB_datausu"))?>'


 if (!lMostra){

   if ($F('k81_conta')== '') {
      $('k13_descr').value = '';
   } else {

     sFuncao   = 'funcao_js=parent.js_preencheSaltes';
     sPesquisa = 'func_saltesrecurso.php?pesquisa_chave='+$('k81_conta').value+'&'+sFuncao+'&data_limite=<?=date("Y-m-d",db_getsession("DB_datausu"))?>'
   }
 }
 js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_saltes',sPesquisa+'&data_limite=<?=date("Y-m-d",db_getsession("DB_datausu"))?>','Pesquisa',lMostra);
}


function js_preencheSaltes(iCodigoConta,sDescricao,iCodigoRecurso,lErro) {

 $('k81_conta') .value = iCodigoConta;
 $('k13_descr') .value = sDescricao;
 $('c61_codigo').value = iCodigoRecurso;

 if (iAlteracao != null) {
   return;
 }

 if(lErro) {

   $('k81_conta')  .focus();
   $('k81_conta')  .value = '';

 }

}

function js_mostraSaltes (iCodigoConta,sDescricao,iCodigoRecurso) {

 $('k81_conta').value = iCodigoConta;
 $('k13_descr').value = sDescricao;
 $('c61_codigo').value = iCodigoRecurso;

 db_iframe_saltes.hide();

}

function js_salvarPlanilha() {

	  //if (lMenuAlteracao && !$F('k80_codpla')) {
	    //alert("Selecione uma planilha para alteração.");
	    //return false;
	    //}
	  var aReceitasPlanilha = new Array();

	  for (var iIndice in aReceitas) {

	    var oReceitaTela = aReceitas[iIndice];

	    if (typeof(oReceitaTela) == 'function') {
	      continue;
	    }

	    var oReceita                       = new Object();
	        oReceita.iReceitaPlanilha      = oReceitaTela.iReceitaPlanilha;
	        oReceita.iOrigem               = oReceitaTela.k81_origem;
	        oReceita.iCgm                  = oReceitaTela.k81_numcgm;
	        oReceita.iInscricao            = oReceitaTela.q02_inscr;
	        oReceita.iMatricula            = oReceitaTela.j01_matric;
	        oReceita.iCaracteriscaPeculiar = oReceitaTela.c58_sequencial;
	        oReceita.iContaTesouraria      = oReceitaTela.k81_conta;
	        oReceita.sObservacao           = encodeURIComponent(tagString(oReceitaTela.k81_obs));
	        oReceita.nValor                = oReceitaTela.k81_valor;
	        oReceita.iRecurso              = oReceitaTela.recurso;
	        oReceita.iReceita              = oReceitaTela.k81_receita;
	        oReceita.dtRecebimento         = oReceitaTela.k81_datareceb;
	        oReceita.sOperacaoBancaria     = oReceitaTela.k81_operbanco;

	    aReceitasPlanilha.push(oReceita);
	  }

	  if (aReceitasPlanilha.length == 0) {

	    alert("Não é possível incluir uma planilha zerada.");
	    return false;
	  }

	  var sMensagemSalvar  = "Deseja salvar a planilha de arrecadação?\n\n";
	  sMensagemSalvar     += "Este procedimento pode demandar algum tempo.";
	  if (!confirm(sMensagemSalvar)) {
	    return false;
	  }

	  js_divCarregando("Aguarde, salvando planilha de arrecadação...", "msgBox");

	  var oParametro                 = new Object();
	  oParametro.exec                = 'salvarPlanilha';
	  oParametro.k144_numeroprocesso = '';//encodeURIComponent(tagString($F('k144_numeroprocesso')));

	  oParametro.iCodigoPlanilha = '';//$F("k80_codpla");
	  oParametro.aReceitas       = aReceitasPlanilha;
	  sRPC                       = 'cai4_planilhaarrecadacao.RPC.php';

	  var oAjax = new Ajax.Request(sRPC,
	              {
	               method: 'post',
	               parameters: 'json='+Object.toJSON(oParametro),
	               onComplete: js_completaSalvar
	               });

	}
function js_completaSalvar (oAjax) {

	  js_removeObj('msgBox');
	  var oRetorno = eval("("+oAjax.responseText+")");
	  if (oRetorno.status == 1) {

	    if (confirm(oRetorno.message.urlDecode())) {

	      var sUrlOpen = "cai2_emiteplanilha002.php?codpla="+oRetorno.iCodigoPlanilha;
	      var oJanelaRelatorio = window.open(sUrlOpen,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	    }
	    //js_novaReceita();
	  } else {
	    alert(oRetorno.message.urlDecode());
	  }
	  js_novaReceita();
	  //document.form1.reset();
	}

function js_novaReceita(){

	   //document.form1.reset();
	   $('k81_conta').value  = '';
     $('c61_codigo').value = '';
     $('k13_descr').value  = '';
	   oGridReceitas.clearAll(true);
	   aReceitas       = new Array();
	   iIndiceReceitas = 0;
	   iAlteracao      = null;
}

js_gridReceitas();
<?php
if (isset($arquivo)) {
	echo "js_addReceita();";
}
?>
</script>
