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


if (isset($incluir)) {


	$itens_processos = db_query("select distinct pc81_codproc from pcprocitem inner join solicitem on pc81_solicitem = pc11_codigo
	where pc81_codprocitem in (select l21_codpcprocitem from liclicitem where l21_codliclicita = $licitacao) 
	order by pc81_codproc ;");

	$dotacao = $_POST['o58_coddot'];
	$elemento_dotacao = $_POST['o50_estrutdespesa'];

	$aCodProcessos = array();
	for ($i = 0; $i < pg_numrows($itens_processos); $i++) {
		$item = db_utils::fieldsMemory($itens_processos, $i);
		$oItem = new stdClass();
		$oItem->codproc =  $item->pc81_codproc;
		$aCodProcessos[] = $oItem;
	}


	for ($i = 0; $i < count($aCodProcessos); $i++) {


		$reduzido =  $_POST['reduzido'];
		$estrutural = $_POST['estrutural'];
		$codigo = $aCodProcessos[$i]->codproc;
		$itens = db_query("select * from solicitem where pc11_codigo in (select pc11_codigo from pcprocitem inner join solicitem on pc81_solicitem = pc11_codigo
		where pc81_codprocitem in (select l21_codpcprocitem from liclicitem where l21_codliclicita = $licitacao and pc81_codproc = $codigo) 
		order by pc81_codproc);");
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

				$quantidade_dotacoes = 0;


				// Verificando se item já possui a dotação a ser lançada
				$result =  db_query("select * from pcdotac where pc13_codigo = $codigo_item and pc13_coddot = $dotacao;");

				for ($k = 0; $k < count($reduzido); $k++) {
					if ($elemento == substr($estrutural[$k], 23, 7)) {
						$quantidade_dotacoes++;
					}
				}



				if (pg_numrows($result) == 0 && $elemento == substr($elemento_dotacao, 23, 7)) {

					$clpcdotac->pc13_anousu = db_getsession('DB_anousu');
					$clpcdotac->pc13_coddot = $dotacao;
					$clpcdotac->pc13_depto  = db_getsession('DB_coddepto');
					$clpcdotac->pc13_quant  = $item->pc11_quant / $quantidade_dotacoes;
					$clpcdotac->pc13_valor  = $item->pc11_quant / $quantidade_dotacoes;
					$clpcdotac->pc13_codele = $codele->pc18_codele;
					$clpcdotac->pc13_codigo = $codigo_item;
					$clpcdotac->incluir(null);
				}
				$quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
				$rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
			} else {

				if ($item->pc11_servicoquantidade == "t") {
					$quantidade_dotacoes = 0;

					// Verificando se item já possui a dotação a ser lançada
					$result =  db_query("select * from pcdotac where pc13_codigo = $codigo_item and pc13_coddot = $dotacao;");

					for ($k = 0; $k < count($reduzido); $k++) {
						if ($elemento == substr($estrutural[$k], 23, 7)) {
							$quantidade_dotacoes++;
						}
					}


					if (pg_numrows($result) == 0 && $elemento == substr($elemento_dotacao, 23, 7)) {

						$clpcdotac->pc13_anousu = db_getsession('DB_anousu');
						$clpcdotac->pc13_coddot = $dotacao;
						$clpcdotac->pc13_depto  = db_getsession('DB_coddepto');
						$clpcdotac->pc13_quant  = $item->pc11_quant / $quantidade_dotacoes;
						$clpcdotac->pc13_valor  = $item->pc11_quant / $quantidade_dotacoes;
						$clpcdotac->pc13_codele = $codele->pc18_codele;
						$clpcdotac->pc13_codigo = $codigo_item;
						$clpcdotac->incluir(null);
					}

					$quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
					$rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
				} else {


					$quantidade_dotacoes = 0;


					// Verificando se item já possui a dotação a ser lançada
					$result =  db_query("select * from pcdotac where pc13_codigo = $codigo_item and pc13_coddot = $dotacao;");

					for ($k = 0; $k < count($reduzido); $k++) {
						if ($elemento == substr($estrutural[$k], 23, 7)) {
							$quantidade_dotacoes++;
						}
					}


					if (pg_numrows($result) == 0 && $elemento == substr($elemento_dotacao, 23, 7)) {



						$clpcdotac->pc13_anousu = db_getsession('DB_anousu');
						$clpcdotac->pc13_coddot = $dotacao;
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

	db_redireciona("com1_dotacoesnovo001lic.php?pc11_numero=$pc11_numero&licitacao=$licitacao");
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

							<td nowrap style="   display: block;">
								<?
								db_input('o56_descr', 50, $Io56_descr, true, 'text', 3);
								?>
							</td>

							<td nowrap style="   display: none;">
								<?
								db_input('o50_estrutdespesa', 50, $Io50_estrutdespesa, true, 'text', $db_opcao);
								?>
							</td>

							<td nowrap style="   display: none;">
								<?
								db_input('pc10_numero', 50, $Ipc10_numero, true, 'text', $db_opcao);
								?>
							</td>


						</tr>




					</table>

				</fieldset>
				<input style="float:center; margin-top:10px;" name="incluir" type="submit" id="incluir" value="Incluir" onclick="return incluirDotacao()">


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



				<br>

			</form>
		</div>
	</div>
</body>

<script>
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
		oRequest.licitacao = <? echo $licitacao; ?>;
		//oRequest.numero = top.corpo.iframe_solicita.document.form1.pc10_numero.value;
		oRequest.exec = "getDotacoesProcItens";
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

		var reduzido = [];
		var estrutural = [];

		for (var i = 0; i < document.getElementsByName("reduzido[]").length; i++) {
			reduzido.push(document.getElementsByName("reduzido[]")[i].value);
		}

		for (var i = 0; i < document.getElementsByName("estrutural[]").length; i++) {
			estrutural.push(document.getElementsByName("estrutural[]")[i].value);
		}

		if (vinculo == null) {

			var sizeItens = oGridItens.aRows.length;

			itens_antigos = oGridItens.aRows;


			oGridItens.clearAll(true);

			for (var i = 0; i < sizeItens; i++) {
				if (i != iSeq) {
					oGridItens.addRow(itens_antigos[i]);

				}
			}
			oGridItens.renderRows();

			for (var i = 0; i < sizeItens; i++) {
				str = top.corpo.iframe_dotacoesnovo.document.getElementsByName('excluir')[i].getAttribute("onclick");
				if (str.includes("true")) {
					top.corpo.iframe_dotacoesnovo.document.getElementsByName('excluir')[i].setAttribute("onclick", "js_excluirLinha(" + i + ", true)");
				} else {
					top.corpo.iframe_dotacoesnovo.document.getElementsByName('excluir')[i].setAttribute("onclick", "js_excluirLinha(" + i + ", null)");

				}
			}

			return false;
		}



		var oRow = oGridItens.aRows[iSeq];
		var dotacao = document.getElementsByName("reduzido[]")[iSeq].value;
		var sMsg = 'Confirma a Exclusão da dotação ' + dotacao + ' ?';

		if (!confirm(sMsg)) {
			return false;
		}

		js_divCarregando('Aguarde, removendo dotação', "msgBox");
		var sUrlRC = "com4_materialsolicitacao.RPC.php";

		var oParam = new Object();
		oParam.exec = "excluirDotacoes";
		oParam.licitacao = <? echo $licitacao; ?>;
		oParam.reduzido = reduzido;
		oParam.estrutural = estrutural;
		oParam.o50_estrutdespesa = estrut;
		oParam.dotacao = dotacao;
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


	indice = 0;

	function incluirDotacao() {

		if (document.getElementById("o58_coddot").value == "") {
			alert('Usuário: Dotação não informada !');
			return false;
		}

		for (var i = 0; i < document.getElementsByName("reduzido[]").length; i++) {

			if (document.getElementsByName("reduzido[]")[i].value == document.getElementById("o58_coddot").value) {
				alert('Usuário: Dotação já incluída');
				return false;
			}
		}


		var sizeItens = oGridItens.aRows.length;

		itens_antigos = oGridItens.aRows;


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


	}

	cod_elementos = "";


	function js_pesquisapc13_coddot(mostra) {


		var sUrl = "com4_materialsolicitacao.RPC.php";

		var oRequest = new Object();
		oRequest.licitacao = <? echo $licitacao; ?>;
		//oRequest.numero = top.corpo.iframe_solicita.document.form1.pc10_numero.value;
		oRequest.exec = "getElementos";
		var oAjax = new Ajax.Request(
			sUrl, {
				method: 'post',
				parameters: 'json=' + js_objectToJson(oRequest),
				onComplete: js_retornogetDotacoes
			}
		);

		var quantidade_itens;


		function js_retornogetDotacoes(oAjax) {
			var oRetorno = eval("(" + oAjax.responseText + ")");
			quantidade_itens = oRetorno.quantidade;
			if (oRetorno.quantidade == 0) {
				alert('Processo(s) de compra não vinculado a licitação ou sem item(ns) cadastrado(s)');
				return false;
			}

			cod_elementos = "";
			var dotacao = document.getElementById('o58_coddot').value;


			for (var i = 0; i < oRetorno.quantidade; i++) {
				elemento = oRetorno.aItens[i].elemento.toString();
				elemento = elemento.substring(0, 7);
				elemento = elemento + ",";
				cod_elementos = elemento + cod_elementos;
			}



			cod_elementos = cod_elementos.substring(0, cod_elementos.length - 1);


			qry = 'obriga_depto=sim';

			qry += '&cod_elementos=' + cod_elementos;

			<? if (@$pc30_passadepart == 't') { ?>
				qry += '&departamento=<?= (db_getsession("DB_coddepto")) ?>';
			<? } ?>
			qry += '&retornadepart=true';
			qry += '&pactoplano=<?= $iPactoPlano ?>';
			if (mostra == true) {
				qry += '&funcao_js=top.corpo.iframe_dotacoesnovo.js_mostraorcdotacao1|o58_coddot|o41_descr';
				js_OpenJanelaIframe('top.corpo.iframe_dotacoesnovo', 'iframe_dotacoesnovo',
					'func_permorcdotacao.php?' + qry, 'Pesquisa', true, '0');
			} else {
				qry += '&pesquisa_chave=' + dotacao;
				js_OpenJanelaIframe('top.corpo.iframe_dotacoesnovo',
					'db_iframe_orcdotacao',
					'func_permorcdotacao.php?' + qry + '&funcao_js=parent.js_mostraorcdotacao', 'Pesquisa', false);
			}


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