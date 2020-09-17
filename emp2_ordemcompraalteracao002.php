<?
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

require_once("fpdf151/scpdf.php");
require_once("fpdf151/impcarne.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_matordem_classe.php");
require_once("classes/db_matordemitem_classe.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_pcparam_classe.php");
require_once("classes/db_db_depart_classe.php");
require_once("classes/db_empempitem_classe.php");

$clempempitem = new cl_empempitem;

/*
 * Configurações GED
*/
require_once("integracao_externa/ged/GerenciadorEletronicoDocumento.model.php");
require_once("integracao_externa/ged/GerenciadorEletronicoDocumentoConfiguracao.model.php");
require_once("libs/exceptions/BusinessException.php");

$oGet = db_utils::postMemory($_GET);
$oConfiguracaoGed = GerenciadorEletronicoDocumentoConfiguracao::getInstance();
if ($oConfiguracaoGed->utilizaGED()) {

	if (!$cods) {

		$sMsgErro = "O parâmetro para utilização do GED (Gerenciador Eletrônico de Documentos) está ativado.<br><br>";
		$sMsgErro .= "Neste não é possível informar interválos de códigos ou datas.<br><br>";
		db_redireciona("db_erros.php?fechar=true&db_erro={$sMsgErro}");
		exit;
	}
}

$clmatordem = new cl_matordem;
$clmatordemitem = new cl_matordemitem;
$clempparametro = new cl_empparametro;
$clpcparam = new cl_pcparam;
$oDaoDbDepart = new cl_db_depart;

$sqlpref = "select db_config.*, cgm.z01_incest as inscricaoestadualinstituicao ";
$sqlpref .= "  from db_config                                                     ";
$sqlpref .= " inner join cgm on cgm.z01_numcgm = db_config.numcgm                 ";
$sqlpref .= "	where codigo = " . db_getsession("DB_instit");

$resultpref = db_query($sqlpref);
db_fieldsmemory($resultpref, 0);

$rsPcParam = $clpcparam->sql_record($clpcparam->sql_query(db_getsession("DB_instit")));
if ($clpcparam->numrows > 0) {
	$oParam = db_utils::fieldsMemory($rsPcParam, 0);
} else {
	db_redireciona("db_erros.php?fechar=true&db_erro=Não há parametros configurados para essa instituição.");
}
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$resultItem = $clmatordemitem->sql_record($clmatordemitem->sql_query_servico(null, "*",
	"m52_sequen ASC", 'm51_codordem = ' . $iOrdem.' and m52_sequen in ('.$itens.')'));
db_fieldsmemory($resultItem, 0);

$num_rows = $clmatordemitem->numrows;

$pdf = new scpdf();
$pdf->Open();

$pdf1 = new db_impcarne($pdf, '94');
$pdf1->objpdf->SetTextColor(0, 0, 0);

$flag_imprime = true;

/*
 * Busca o departamento...
 * */
$sSqlDeptoOrigem = $oDaoDbDepart->sql_query_file(null, "*", null, "coddepto = {$m51_deptoorigem}");

$rsOrigem = $oDaoDbDepart->sql_record($sSqlDeptoOrigem);
$sOrigem = db_utils::fieldsMemory($rsOrigem, 0)->descrdepto;
$iOrigem = db_utils::fieldsMemory($rsOrigem, 0)->coddepto;

$sSqlDeptoDestino 	= $oDaoDbDepart->sql_query_file(null, "*", null, "coddepto = {$m51_depto}");
$rsDestino 			= $oDaoDbDepart->sql_record($sSqlDeptoDestino);
$sDestino 			= db_utils::fieldsMemory($rsDestino, 0)->descrdepto;
$iDestino 			= db_utils::fieldsMemory($rsDestino, 0)->coddepto;

$datahj = date("Y-m-d", db_getsession("DB_datausu"));

$pdf1->prefeitura = $nomeinst;
$pdf1->enderpref = trim($ender) . "," . $numero;
$pdf1->municpref = $munic;
$pdf1->uf = $uf;
$pdf1->telefpref = $telef;
$pdf1->logo = $logo;
$pdf1->emailpref = $email;

$pdf1->inscricaoestadual = '';
if ($db21_usasisagua == 't') {
	$pdf1->inscricaoestadualinstituicao = "Inscrição Estadual: " . $inscricaoestadualinstituicao;
}

$pdf1->numordem = $m51_codordem;
$pdf1->dataordem = $m51_data;
$pdf1->coddepto = $m51_depto;
$pdf1->descrdepto = $sDestino;
$pdf1->numcgm = $m51_numcgm;
$pdf1->nome = $z01_nome;
$pdf1->email = $z01_email;
$pdf1->cnpj = $z01_cgccpf;
$pdf1->cgc = $cgc;
$pdf1->url = $url;
$pdf1->ender = $z01_ender;
$pdf1->munic = $z01_munic;
$pdf1->bairro = strlen($z01_bairro) > 18 ? substr($z01_bairro, 0, 18) . '.' : $z01_bairro;
$pdf1->cep = $z01_cep;
$pdf1->ufFornecedor = $z01_uf;
$pdf1->numero = $z01_numero;
$pdf1->compl = $z01_compl;
$pdf1->contato = $z01_telcon;
$pdf1->telef_cont = $z01_telef;
$pdf1->telef_fax = $z01_fax;
$pdf1->recorddositens = $resultItem;
$pdf1->linhasdositens = $num_rows;
$pdf1->emissao = $datahj;
$pdf1->obs = $m51_obs;
$pdf1->sTipoCompra = 'pc50_descr'; //campo do pg_result
$pdf1->empempenho = 'e60_codemp';
$pdf1->anousuemp = 'e60_anousu';
$pdf1->quantitem = 'm52_quant';
$pdf1->unid = 'm61_abrev';
$pdf1->condpag = 'e54_conpag';
$pdf1->destino = 'e54_destin';
$pdf1->obs_ordcom_orcamval = "e55_marca";
$pdf1->sOrigem = $iOrigem . " - " . $sOrigem;
$anousu = db_getsession("DB_anousu");
$result_numdec = $clempparametro->sql_record($clempparametro->sql_query_file($anousu));

if ($clempparametro->numrows > 0) {

	db_fieldsmemory($result_numdec, 0);

} else {

	$e30_numdec = 4;

}
$pdf1->numdec = $e30_numdec;
$pdf1->valoritem = 'm52_valor';
$pdf1->vlrunitem = 'm52_vlruni'	;
$pdf1->descricaoitem = 'pc01_descrmater';
$pdf1->codmater = 'pc01_codmater';
$pdf1->observacaoitem = 'e62_descr';
$pdf1->depto = $m51_depto;
$pdf1->prazoent = $m51_prazoent;

$pdf1->Snumeroproc = "pc81_codproc";
$pdf1->Snumero = "pc11_numero";
$pdf1->obs_ordcom_orcamval = "pc23_obs";

$pdf1->imprime();


if ($flag_imprime == true) {

	if ($oConfiguracaoGed->utilizaGED()) {

		try {

			if (!empty($cods)) {
				$m51_codordem_ini = $cods;
			}

			$sTipoDocumento = GerenciadorEletronicoDocumentoConfiguracao::ORDEM_COMPRA;

			$oGerenciador = new GerenciadorEletronicoDocumento();
			$oGerenciador->setLocalizacaoOrigem("tmp/");
			$oGerenciador->setNomeArquivo("{$sTipoDocumento}_{$m51_codordem_ini}.pdf");

			$oStdDadosGED = new stdClass();
			$oStdDadosGED->nome = $sTipoDocumento;
			$oStdDadosGED->tipo = "NUMERO";
			$oStdDadosGED->valor = $m51_codordem_ini;
			$pdf1->objpdf->Output("tmp/{$sTipoDocumento}_{$m51_codordem_ini}.pdf");
			$oGerenciador->moverArquivo(array($oStdDadosGED));

		} catch (Exception $eErro) {

			db_redireciona("db_erros.php?fechar=true&db_erro=" . $eErro->getMessage());
		}
	} else {

		$pdf1->objpdf->Output();
	}


} else {
	db_redireciona("db_erros.php?fechar=true&db_erro=Verifique a(s) ordem(ns) selecionada(s).");
}


?>
