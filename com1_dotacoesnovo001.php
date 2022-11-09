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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_liborcamento.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_solicita_classe.php");
require_once("classes/db_solicitem_classe.php");
require_once("classes/db_solicitemele_classe.php");
require_once("classes/db_solicitemunid_classe.php");
require_once("classes/db_solicitempcmater_classe.php");
require_once("classes/db_pcdotac_classe.php");
require_once("classes/db_pcdotaccontrapartida_classe.php");
require_once("classes/db_solicitatipo_classe.php");
require_once("classes/db_orcreserva_classe.php");
require_once("classes/db_orcreservasol_classe.php");
require_once("classes/db_db_config_classe.php");
require_once("classes/db_pctipocompra_classe.php");
require_once("classes/db_db_depart_classe.php");
require_once("classes/db_pcsugforn_classe.php");
require_once("classes/db_pcparam_classe.php");
require_once("classes/db_protprocesso_classe.php");
require_once("classes/db_solicitemprot_classe.php");
require_once("classes/db_pcproc_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_pactovalormov_classe.php");
require_once("classes/db_pactovalormovsolicitem_classe.php");
require_once("classes/db_orctiporecconveniosolicita_classe.php");
require_once("classes/db_solicitaprotprocesso_classe.php");

db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);

$clsolicita                  = new cl_solicita;
$clsolicitem                 = new cl_solicitem;
$clsolicitemele              = new cl_solicitemele;
$clsolicitemunid             = new cl_solicitemunid;
$clsolicitempcmater          = new cl_solicitempcmater;
$clpcdotac                   = new cl_pcdotac;
$clorcreserva                = new cl_orcreserva;
$clorcreservasol             = new cl_orcreservasol;
$clsolicitatipo              = new cl_solicitatipo;
$clpctipocompra              = new cl_pctipocompra;
$cldb_depart                 = new cl_db_depart;
$clpcsugforn                 = new cl_pcsugforn;
$clpcparam                   = new cl_pcparam;
$cldb_config                 = new cl_db_config;
$clprotprocesso              = new cl_protprocesso;
$clsolicitemprot             = new cl_solicitemprot;
$clpcproc                    = new cl_pcproc;
$clliclicitem                = new cl_liclicitem;
$oDaoContrapartida           = new cl_pcdotaccontrapartida();
$oDaoItemPacto               = new cl_pactovalormovsolicitem();
$oDaoItemPactomov            = new cl_pactovalormov;
$oDaoOrctiporecConvenioPacto = new cl_orctiporecconveniosolicita();
$oDaoProcessoAdministrativo  = new cl_solicitaprotprocesso();

$db_opcao  = 1;

$db_botao  = true;
$confirma  = false;

$result_pcparam = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"), "*"));
db_fieldsmemory($result_pcparam, 0);


if (isset($incluir)) {


	$reduzido =  $_POST['reduzido'];
	$estrutural = $_POST['estrutural'];
	$itens = db_query("select * from solicitem where pc11_numero = $pc10_numero;");
	$quantidade_itens = pg_numrows($itens);
	$quantidade_dotacoes = 0;



	for ($i = 0; $i < $quantidade_itens; $i++) {
		$item = db_utils::fieldsMemory($itens, $i);
		$codigo_item =  $item->pc11_codigo;
		$servico = db_query("select * from solicitempcmater inner join pcmater on pc16_codmater = pc01_codmater  where pc16_solicitem = $codigo_item ;");
		$servico = db_utils::fieldsMemory($servico, 0);
		$codele = db_query("select * from solicitemele where pc18_solicitem = $codigo_item ;");
		$codele = db_utils::fieldsMemory($codele, 0);
		$anousu = db_getsession('DB_anousu');
		$elemento =  db_query("select * from orcelemento where o56_codele = $codele->pc18_codele and o56_anousu = $anousu ;");
		$elemento = db_utils::fieldsMemory($elemento, 0);
		$elemento = substr($elemento->o56_elemento, 0, 7);



		if ($servico->pc01_servico == "f") {

			for ($j = 0; $j < count($reduzido); $j++) {
				$quantidade_dotacoes = 0;


				// Verificando se item já possui a dotação a ser lançada
				$dotacao = $reduzido[$j];
				$result =  db_query("select * from pcdotac where pc13_codigo = $codigo_item and pc13_coddot = $dotacao;");

				if (pg_numrows($result) == 0) {


					for ($k = 0; $k < count($reduzido); $k++) {
						if ($elemento == substr($estrutural[$k], 23, 7)) {
							$quantidade_dotacoes++;
						}
					}

					$clpcdotac->pc13_anousu = db_getsession('DB_anousu');
					$clpcdotac->pc13_coddot = $reduzido[$j];
					$clpcdotac->pc13_depto  = db_getsession('DB_coddepto');
					$clpcdotac->pc13_quant  = $item->pc11_quant / $quantidade_dotacoes;
					$clpcdotac->pc13_valor  = $item->pc11_quant / $quantidade_dotacoes;
					$clpcdotac->pc13_codele = $codele->pc18_codele;
					$clpcdotac->pc13_codigo = $codigo_item;
					$clpcdotac->incluir(null);
				}
			}
		} else {

			if ($item->pc11_servicoquantidade == "t") {
				for ($j = 0; $j < count($reduzido); $j++) {
					$quantidade_dotacoes = 0;

					// Verificando se item já possui a dotação a ser lançada
					$dotacao = $reduzido[$j];
					$result =  db_query("select * from pcdotac where pc13_codigo = $codigo_item and pc13_coddot = $dotacao;");

					if (pg_numrows($result) == 0) {

						for ($k = 0; $k < count($reduzido); $k++) {
							if ($elemento == substr($estrutural[$k], 23, 7)) {
								$quantidade_dotacoes++;
							}
						}

						$clpcdotac->pc13_anousu = db_getsession('DB_anousu');
						$clpcdotac->pc13_coddot = $reduzido[$j];
						$clpcdotac->pc13_depto  = db_getsession('DB_coddepto');
						$clpcdotac->pc13_quant  = $item->pc11_quant / $quantidade_dotacoes;
						$clpcdotac->pc13_valor  = $item->pc11_quant / $quantidade_dotacoes;
						$clpcdotac->pc13_codele = $codele->pc18_codele;
						$clpcdotac->pc13_codigo = $codigo_item;
						$clpcdotac->incluir(null);
					}
				}
			} else {
				for ($j = 0; $j < count($reduzido); $j++) {

					$quantidade_dotacoes = 0;


					// Verificando se item já possui a dotação a ser lançada
					$dotacao = $reduzido[$j];
					$result =  db_query("select * from pcdotac where pc13_codigo = $codigo_item and pc13_coddot = $dotacao;");

					if (pg_numrows($result) == 0) {


						for ($k = 0; $k < count($reduzido); $k++) {
							if ($elemento == substr($estrutural[$k], 23, 7)) {
								$quantidade_dotacoes++;
							}
						}

						$clpcdotac->pc13_anousu = db_getsession('DB_anousu');
						$clpcdotac->pc13_coddot = $reduzido[$j];
						$clpcdotac->pc13_depto  = db_getsession('DB_coddepto');
						$clpcdotac->pc13_quant  = 1;
						$clpcdotac->pc13_valor  = 1;
						$clpcdotac->pc13_codele = $codele->pc18_codele;
						$clpcdotac->pc13_codigo = $codigo_item;
						$clpcdotac->incluir(null);
					}
				}
			}
		}
	}
	db_msgbox($clpcdotac->erro_sql);
	db_redireciona("com1_dotacoesnovo001.php?pc11_numero=$pc11_numero");
}

?>
<html>

<head>
	<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
	<?
	db_app::load("scripts.js, strings.js, prototype.js, datagrid.widget.js, estilos.css");
	?>
	<meta http-equiv="Expires" CONTENT="0">
	<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body style="background-color: #CCCCCC; margin-top:30px;">
	<div class="container">
		<div>
			<form name="form1" method="post" action="">
				<fieldset>
					<legend><strong>Dotações</strong></legend>
					<table border="0">
						<tr>
							<td nowrap title="<?= @$Tpc16_codmater ?>">
								<?
								db_ancora("Dotações:", "js_pesquisapc13_coddot(true);", 1, '', 'pc13_coddot');

								?>
							</td>
							<td>

								<?
								db_input('o58_coddot', 8, $Io58_coddot, true, 'text', $tranca, "onchange='js_pesquisapc13_coddot(false)'");

								?>
							</td>
							<td nowrap style="display: block;">
								<?
								db_input('o56_descr', 50, $Io56_descr, true, 'text', 3);
								?>
							</td>
							<td nowrap style="display: none;">
								<?
								db_input('o50_estrutdespesa', 50, $Io50_estrutdespesa, true, 'text', $db_opcao);
								?>
							</td>

							<td nowrap style="display: none;">
								<?
								db_input('pc10_numero', 50, $Ipc10_numero, true, 'text', $db_opcao);
								?>
							</td>
						</tr>
					</table>

				</fieldset>
				<input style="float:center; margin-top:10px;" name="<?= ($db_opcao == 1 ? "Adicionar Item" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="button" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?> onclick="return incluirDotacao()">
				<table>
					<tr>
						<td>
							<fieldset>
								<legend>Dotações Vinculadas</legend>
								<div id='ctnGridItens' style="width: 650px"></div>
							</fieldset>
						</td>
					</tr>
				</table>
				<input style="float:center; margin-top:10px;display:<? if ($pc30_permsemdotac != "f") {
																		echo "none";
																	} ?>" name="incluir" type="button" value="Liberar Solicitação" onclick="js_liberarSolicitacao()">

			</form>
		</div>
	</div>
</body>

<script>
	document.getElementById('pc10_numero').value = parent.iframe_solicita.document.getElementById('pc10_numero').value;

	oGridItens = new DBGrid('oGridItens');
	oGridItens.nameInstance = 'oGridItens';
	oGridItens.setCellAlign(['center', 'center', "center"]);
	oGridItens.setCellWidth(["20%", "70%", "10%"]);
	oGridItens.setHeader(["Reduzido", "Estrutural", "Ação"]);

	oGridItens.setHeight(200);
	oGridItens.show($('ctnGridItens'));



	function carregaDotacoes() {


		var sUrl = "com4_materialsolicitacao.RPC.php";

		var oRequest = new Object();
		oRequest.numero = <? echo $pc10_numero; ?>;
		oRequest.exec = "getDotacoes";
		var oAjax = new Ajax.Request(
			sUrl, {
				method: 'post',
				parameters: 'json=' + js_objectToJson(oRequest),
				onComplete: js_retornogetDotacoes
			}
		);

		function js_retornogetDotacoes(oAjax) {
			var oRetorno = eval("(" + oAjax.responseText + ")");

			oGridItens.clearAll(true);
			var aLinha = new Array();
			for (var i = 0; i < oRetorno.aItens.length; i++) {

				aLinha[0] = "  <input style='text-align:center; width:90%; border:none;' readonly='' type='text'  name='reduzido[]' value='" + oRetorno.aItens[i].reduzido + "'>";
				aLinha[1] = "  <input style='text-align:center; width:90%; border:none;' readonly='' type='text'  name='estrutural[]' value='" + oRetorno.aItens[i].estrutural + "'>";
				excluirLinha = 'onclick=js_excluirLinha(0,true,' + "'" + oRetorno.aItens[i].reduzido + "'," + "'" + oRetorno.aItens[i].estrutural + "'" + ")";
				aLinha[2] = " <input type='button' name='excluir' value='E'" + excluirLinha + ">";

				oGridItens.addRow(aLinha);

			}

			oGridItens.renderRows();

			indice = oRetorno.aItens.length;


		}


	}

	carregaDotacoes();

	function js_excluirLinha(iSeq, vinculo, dot, estrut) {

		var oRow = oGridItens.aRows[iSeq];
		var reduzido = [];
		var estrutural = [];

		for (var i = 0; i < document.getElementsByName("reduzido[]").length; i++) {
			reduzido.push(document.getElementsByName("reduzido[]")[i].value);
		}

		for (var i = 0; i < document.getElementsByName("estrutural[]").length; i++) {
			estrutural.push(document.getElementsByName("estrutural[]")[i].value);
		}

		var dotacao = document.getElementsByName("reduzido[]")[iSeq].value;

		var sMsg = 'Confirma a Exclusão da dotação ' + dotacao + ' ?';

		if (!confirm(sMsg)) {
			return false;
		}

		js_divCarregando('Aguarde, removendo dotação', "msgBox");
		var sUrlRC = "com4_materialsolicitacao.RPC.php";

		var oParam = new Object();
		oParam.exec = "excluirDotacoesCompras";
		oParam.numero = CurrentWindow.corpo.iframe_solicita.document.form1.pc10_numero.value;
		oParam.dotacao = dot;
		oParam.reduzido = reduzido;
		oParam.estrutural = estrutural;
		oParam.o50_estrutdespesa = estrut;


		var oAjax = new Ajax.Request(sUrlRC, {
			method: "post",
			parameters: 'json=' + Object.toJSON(oParam),
			onComplete: js_retornoExcluirDotacoes
		});

	}

	function js_retornoExcluirDotacoes(oAjax) {

		js_removeObj('msgBox');
		var oRetorno = eval("(" + oAjax.responseText + ")");
		if (oRetorno.erro == false) {
			alert('Dotação Excluída com sucesso');
			carregaDotacoes();

		} else {
			alert(oRetorno.message.urlDecode());
		}
	}

	function js_liberarSolicitacao() {
		var sUrl = "com4_materialsolicitacao.RPC.php";
		var oRequest = new Object();
		oRequest.numero = parent.iframe_solicita.document.getElementById('pc10_numero').value;
		oRequest.exec = "liberarSolicitacaoRotinaDotacao";
		var oAjax = new Ajax.Request(
			sUrl, {
				method: 'post',
				parameters: 'json=' + js_objectToJson(oRequest),
				onComplete: js_retornoliberarSolicitacao
			}
		);

	}

	function js_retornoliberarSolicitacao(oAjax) {
		var oRetorno = eval("(" + oAjax.responseText + ")");

		if (oRetorno.erro == true) {
			alert(oRetorno.message.urlDecode());
			return false;

		} else {
			alert('Solicitação de compra Liberada !');
		}

		numero = CurrentWindow.corpo.iframe_solicita.document.form1.pc10_numero.value;
		data = CurrentWindow.corpo.iframe_solicita.document.form1.pc10_data.value;
		descrdepto = CurrentWindow.corpo.iframe_solicita.document.form1.descrdepto.value;


		parent.window.location.href = "com1_pcproc001.php?pc10_numero=" + numero + "&data=" + data + "&descrdepto=" + descrdepto + "";


	}

	function js_salvarDotacoes() {
		var sUrl = "com4_materialsolicitacao.RPC.php";

		var dotacao = document.getElementById("o58_coddot").value;
		var reduzido = [];
		var estrutural = [];
		var pc30_permsemdotac = '<? echo $pc30_permsemdotac; ?>';
		var o50_estrutdespesa = document.getElementById('o50_estrutdespesa').value;


		var oRequest = new Object();



		if (document.getElementsByName("reduzido[]").length == 0 && pc30_permsemdotac == "f") {
			alert('Usuário, é necessário inserir no mínimo 1 dotação na aba Dotações.');
			return false;
		}


		if (pc30_permsemdotac == "f") {
			pc30_permsemdotac = false;
		} else {
			pc30_permsemdotac = true;
		}

		for (var i = 0; i < document.getElementsByName("reduzido[]").length; i++) {
			reduzido.push(document.getElementsByName("reduzido[]")[i].value);
		}

		for (var i = 0; i < document.getElementsByName("estrutural[]").length; i++) {
			estrutural.push(document.getElementsByName("estrutural[]")[i].value);
		}

		oRequest.reduzido = reduzido;
		oRequest.estrutural = estrutural;
		oRequest.numero = parent.iframe_solicita.document.getElementById('pc10_numero').value;
		oRequest.pc30_permsemdotac = pc30_permsemdotac;
		oRequest.dotacao = dotacao;
		oRequest.o50_estrutdespesa = o50_estrutdespesa;


		oRequest.exec = "salvarDotacoes";
		var oAjax = new Ajax.Request(
			sUrl, {
				method: 'post',
				parameters: 'json=' + js_objectToJson(oRequest),
				onComplete: js_retornoSalvarDotacoes
			}
		);

	}

	function js_retornoSalvarDotacoes(oAjax) {
		var oRetorno = eval("(" + oAjax.responseText + ")");

		if (oRetorno.erro == true) {
			alert(oRetorno.message.urlDecode());
			return false;

		}

		document.getElementById("o58_coddot").value = "";
		document.getElementById("o56_descr").value = "";


		carregaDotacoes();


	}



	indice = 0;

	function incluirDotacao() {

		if (document.getElementById("o58_coddot").value == "") {
			alert('Usuário: Dotação não informada !');
			return false;
		}

		var sizeItens = oGridItens.aRows.length;

		itens_antigos = oGridItens.aRows;


		for (var i = 0; i < document.getElementsByName("reduzido[]").length; i++) {

			if (document.getElementsByName("reduzido[]")[i].value == document.getElementById("o58_coddot").value) {
				alert('Usuário: Dotação já incluída');
				return false;
			}
		}


		oGridItens.clearAll(true);

		for (var i = 0; i < sizeItens; i++) {
			oGridItens.addRow(itens_antigos[i]);
		}

		indice = sizeItens;

		var aLinha = new Array();

		o50_estrutdespesa = document.getElementById('o50_estrutdespesa').value;
		reduzido = document.getElementById('o58_coddot').value;

		aLinha[0] = "  <input style='text-align:center; width:90%; border:none;' readonly='' type='text'  name='reduzido[]' value='" + reduzido + "'>";
		aLinha[1] = "  <input style='text-align:center; width:90%; border:none;' readonly='' type='text'  name='estrutural[]' value='" + o50_estrutdespesa + "'>";
		aLinha[2] = " <input type='button' name='excluir' value='E' onclick='js_excluirLinha(" + indice + ",null)'>";



		oGridItens.addRow(aLinha);



		oGridItens.renderRows();

		indice++;

		js_salvarDotacoes();


	}

	function js_pesquisapc13_coddot(mostra) {
		var cod_elementos = "";
		var dotacao = document.getElementById('o58_coddot').value;

		if (parent.iframe_solicitem.document.getElementsByName('descrelemento[]').length == 0 || parent.iframe_solicitem.document.getElementsByName('codigo[]')[0].value == 0) {
			alert('Solicitação de compras sem item(ns) cadastrado(s)');
			return false;
		}

		for (var i = 0; i < parent.iframe_solicitem.document.getElementsByName('descrelemento[]').length; i++) {
			elemento = '';
			elemento = parent.iframe_solicitem.document.getElementsByName('descrelemento[]')[i].value;
			elemento = elemento.split("-");
			elemento = elemento[1];
			elemento = elemento.trim();
			elemento = elemento.substring(0, 7);
			elemento = elemento + ",";
			cod_elementos += elemento;
			//teste += "'" + parent.iframe_solicitem.document.getElementsByName('descrelemento[]')[i].value + "'" + ",";
		}

		cod_elementos = cod_elementos.substring(0, cod_elementos.length - 1);

		qry = 'obriga_depto=sim';
		if (parent.iframe_solicitem.document.getElementsByName('codele[]').length != 0) {
			qry += '&cod_elementos=' + cod_elementos;
		}
		<? if (@$pc30_passadepart == 't') { ?>
			qry += '&departamento=<?= (db_getsession("DB_coddepto")) ?>';
		<? } ?>
		qry += '&retornadepart=true';
		qry += '&pactoplano=<?= $iPactoPlano ?>';
		if (mostra == true) {
			qry += '&funcao_js=CurrentWindow.corpo.iframe_dotacoesnovo.js_mostraorcdotacao1|o58_coddot|o41_descr';
			js_OpenJanelaIframe('CurrentWindow.corpo.iframe_dotacoesnovo', 'iframe_dotacoesnovo',
				'func_permorcdotacao.php?' + qry, 'Pesquisa', true, '0');
		} else {
			qry += '&pesquisa_chave=' + dotacao;
			js_OpenJanelaIframe('CurrentWindow.corpo.iframe_dotacoesnovo',
				'db_iframe_orcdotacao',
				'func_permorcdotacao.php?' + qry + '&funcao_js=parent.js_mostraorcdotacao', 'Pesquisa', false);
		}
	}

	function js_mostraorcdotacao(chave1, chave2, erro) {
		document.getElementById("o56_descr").value = chave1;
		document.form1.o50_estrutdespesa.value = chave2;

		if (erro) {
			document.getElementById("o58_coddot").value = "";
		}
	}

	function js_mostraorcdotacao1(chave1, chave2, chave3) {

		document.form1.o58_coddot.value = chave1;
		document.form1.o56_descr.value = chave2;
		document.form1.o50_estrutdespesa.value = chave3;
		iframe_dotacoesnovo.hide();
	}
</script>

</html>
<?
if (isset($incluir) || (isset($importar) && $confirma == true)) {


	$db_opcaoBtnRegistroPreco = 3;
	if ($sqlerro == true) {
		db_msgbox(str_replace("\n", "\\n", $erro_msg));
		if ($clsolicita->erro_campo != "") {
			echo "<script> document.form1." . $clsolicita->erro_campo . ".style.backgroundColor='#99A9AE';</script>";
			echo "<script> document.form1." . $clsolicita->erro_campo . ".focus();</script>";
		};
	} else {

		if (isset($param) && trim($param) != "") {
			$parametro = "&param=alterar&param_ant=incluir";
			if (isset($codproc2) && trim($codproc2) != "" && $codproc2 > 0) {
				$parametro .= "&codproc=" . $codproc2;
			}
			if (isset($codliclicita2) && trim($codliclicita2) != "" && $codliclicita2 > 0) {
				$parametro .= "&codliclicita=" . $codliclicita2;
			}
		} else {
			$parametro = "";
		}

		if ($pc30_contrandsol == 't') {
			db_msgbox("Controle da solicitação ativo!!É necessário efetuar o andamento inicial após a inclusão dos itens!!");
		}
		if (isset($importar) && trim($importar) != "") {

			if ($ano_imp != db_getsession("DB_anousu")) {

				echo "<script>
	              if (confirm('ATENÇÃO: \\n Solicitação de outro ano!!\\nDeseja incluir os itens com suas respectivas Dotações?')) {
								  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_solicita','db_iframe_dotac','com4_altdotacsol001.php?importado=$importar&codnovo=$pc10_numero','Dotações',true);
								} else {
				          location.href='com1_solicita005.php?db_opcaoBtnRegistroPreco=3&liberaaba=true&chavepesquisa=$pc10_numero';
				        }
						  </script>";
			} else {
				db_redireciona("com1_solicita005.php?db_opcaoBtnRegistroPreco=3&liberaaba=true&chavepesquisa=$pc10_numero$parametro");
			}
		} else {
			db_redireciona("com1_solicita005.php?db_opcaoBtnRegistroPreco=1&liberaaba=true&chavepesquisa=$pc10_numero$parametro");
		}
	}
}

if (isset($confirma) && $confirma == false && isset($importar)) {

	$db_opcaoBtnRegistroPreco = 3;
	$sQueryString = "";
	if (isset($pc54_solicita)) {
		$sQueryString = "&pc54_solicita={$pc54_solicita}";
	}

	echo "<script>

		      if(confirm('ATENÇÃO: \\nSerão importados os itens, as dotações e os fornecedores sugeridos desta solicitação.\\nDeseja continuar?')){
		      	location.href = 'com1_solicita004.php?lBloqueiaAncoraRegistro=1&db_opcaoBtnRegistroPreco=3$sQueryString&importar=$importar&conf=true';
		      }
		    </script>";
}
?>