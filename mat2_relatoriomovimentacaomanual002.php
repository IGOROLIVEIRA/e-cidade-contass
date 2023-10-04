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

require_once ("fpdf151/pdf.php");
require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_utils.php");
require_once ("dbforms/db_funcoes.php");
require_once ("std/db_stdClass.php");
require_once ("classes/materialestoque.model.php");

$oGet = db_utils::postMemory($_GET);

$aListaWhere         = array();
/**
 * Verificamos os fitros por departamento
 */
if (isset($oGet->listadepart) && !empty($oGet->listadepart)) {

	$sDepartamento = " m70_coddepto in  ($oGet->listadepart) ";
	if (isset($oGet->verdepart) && $oGet->verdepart == "sem") {
		$sDepartamento = " m70_coddepto not in  ($oGet->listadepart) ";
	}
	$aListaWhere[] = $sDepartamento ;
}

/**
 * Verificamos os filtros de material
 */
if (isset($oGet->listamat) && !empty($oGet->listamat)) {

	$sTipoFiltro = " in ";
	if (isset($oGet->vermat) && $oGet->vermat == "sem") {
		$sTipoFiltro = " not in ";
	}
	$sMaterial = " m70_codmatmater {$sTipoFiltro} ({$oGet->listamat}) ";
	$aListaWhere[] = $sMaterial;
}

if (isset($oGet->data_inicial) && !empty($oGet->data_inicial)) {

	$sDataInicial         = implode("-", array_reverse(explode("/", $oGet->data_inicial)));
	$sDatas               = " m80_data >= '{$sDataInicial}' ";
	$aListaWhere[]        = $sDatas;
}

if (isset($oGet->data_final) && !empty($oGet->data_final)) {

	$sDataFinal          = implode("-", array_reverse(explode("/", $oGet->data_final)));
	$sDatas              = " m80_data <= '{$sDataFinal}' ";
	$aListaWhere[]       = $sDatas;
}

/**
 * Verificamos filtro para instituição
 */
$aListaWhere[] = " db_depart.instit = ".db_getsession("DB_instit");

/**
 * Buscar somente materiais
 */
$aListaWhere[]   = "m71_servico is false";

/**
 * Buscar somente Entradas e Saidas manuais
 */
if ($oGet->tipomov == "E") {
	$aListaWhere[]   = "m81_codtipo in (3)";
	$sInformacaoTipo = "Tpo: Entradas";
} else if ($oGet->tipomov == "S") {
	$aListaWhere[]   = "m81_codtipo in (5)";
	$sInformacaoTipo = "Tpo: Saídas";
} else {
  $aListaWhere[]   = "m81_codtipo in (3,5)";
  $sInformacaoTipo = "Tpo: Todos";
}


$sWhere       = implode(" and ", $aListaWhere);

$sSqlDados = "SELECT m80_codigo as codlancamento,
       m70_codmatmater as codmaterial,
       m60_descr as descrimaterial,
       coddepto,
       descrdepto,
       m81_descr,
       sum(m82_quant) AS qtde,
       m80_data,
       m89_precomedio AS precomedio,
       sum(coalesce((m82_quant::numeric * m89_valorunitario::numeric),0)) AS m89_valorfinanceiro,
       m81_codtipo,
	   m80_obs
FROM matestoqueini
INNER JOIN matestoqueinimei ON m80_codigo = m82_matestoqueini
INNER JOIN matestoqueinimeipm ON m82_codigo = m89_matestoqueinimei
INNER JOIN matestoqueitem ON m82_matestoqueitem = m71_codlanc
INNER JOIN matestoque ON m70_codigo = m71_codmatestoque
INNER JOIN matmater ON m70_codmatmater = m60_codmater
INNER JOIN matestoquetipo ON m80_codtipo = m81_codtipo
LEFT JOIN db_depart ON m70_coddepto = coddepto
LEFT JOIN db_departorg ON db01_coddepto = db_depart.coddepto
AND db01_anousu = ".db_getsession("DB_anousu")."
LEFT JOIN orcorgao ON o40_orgao = db_departorg.db01_orgao
AND o40_anousu = ".db_getsession("DB_anousu")."
LEFT JOIN matestoquetransf ON m83_matestoqueini = m80_codigo
LEFT JOIN matestoqueinimeiari ON m49_codmatestoqueinimei = m82_codigo
LEFT JOIN atendrequiitem ON m49_codatendrequiitem = m43_codigo
LEFT JOIN matrequiitem ON m41_codigo = m43_codmatrequiitem
LEFT JOIN matrequi ON m40_codigo = m41_codmatrequi
WHERE {$sWhere}
GROUP BY m80_codigo,
         m70_codmatmater,
         m80_data,
         m81_descr,
         coddepto,
         descrdepto,
         m89_precomedio,
         m60_descr,
         m80_data,
		 m70_codmatmater,m81_codtipo";

$rsDados = db_query($sSqlDados);
$iTotalItens    = pg_num_rows($rsDados);

if ($iTotalItens > 25000) {

	$sMsgErro  = "Não foi possível gerar o relatório. Muitos registros foram encontrados. <br>";
	$sMsgErro .= "Por favor, refine sua busca. ";
	db_redireciona("db_erros.php?fechar=true&db_erro=$sMsgErro");
}

if ($iTotalItens > 0) {

	/**
	 * Agrupamos os Itens Sinteticamente
	 */
	$aDepartamentos = array();
	$aMateriais      = array();
	for($iCont = 0; $iCont < $iTotalItens; $iCont++) {

		$oItem = db_utils::fieldsMemory($rsDados, $iCont);

		$oMaterial                                 = new stdClass();
		$oMaterial->iCodLancamento                 = $oItem->codlancamento;
		$oMaterial->iCodMaterial                   = $oItem->codmaterial;
		$oMaterial->sDescricaoItem                 = $oItem->descrimaterial;
		$oMaterial->iCodigoAlmoxarifado            = $oItem->coddepto;
		$oMaterial->sDescricaoAlmoxarifado         = $oItem->descrdepto;
		$oMaterial->sDescricaoTipo                 = $oItem->m81_descr;
		$oMaterial->dData                          = $oItem->m80_data;
		$oMaterial->nQuantidade                    = $oItem->qtde;
		$oMaterial->nPrecoMedio                    = $oItem->precomedio;
		$oMaterial->nValor                         = $oItem->m89_valorfinanceiro;
		$oMaterial->iTipo                          = $oItem->m81_codtipo;
		$oMaterial->sObservacao                    = $oItem->m80_obs;
		$aMateriais[] = $oMaterial;

		/**
		 * Array dos Departamentos
		 */
		$aDepartamentos[$oItem->coddepto][]          = $oMaterial;

	}
	//echo "<pre>";print_r($aDepartamentos);exit;
} else {
	db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros cadastrados.');
}

/**
 * Cabeçalho do Relatório
 */
$sInformacaoData = "";
if (!empty($oGet->data_inicial) && !empty($oGet->data_final)) {
	$sInformacaoData = "Período: De {$oGet->data_inicial} Até {$oGet->data_final}";
}


$head3 = "Relatório de Movimentação Manual";
$head4 = $sInformacaoTipo;
$head5 = $sInformacaoData;


/**
 * Variável de Configuração do Relatório
 */

$lPrimeiraCelula = true;
$iLinhaAltura    = 4;


$oPdf = new PDF();
$oPdf->Open();
$oPdf->AliasNbPages();
$oPdf->setfillcolor(235);

/**
 * Verifica o tipo a ser impresso do relatório recebido pelo parâmetro: $oGet->quebrapordepartamento
 */
if (isset($oGet->quebrapordepartamento) && $oGet->quebrapordepartamento == "S") {

	foreach ($aDepartamentos as $aDepartamento) {

		$oTotal = new stdClass;
		$iContador = 0;
		addHeader($oPdf);
		foreach ($aDepartamento as $oItem) {

			if ($oItem->iTipo == 3) {
				$oTotal->nEntradas += $oItem->nValor;
			} else {
				$oTotal->nSaidas   += $oItem->nValor;
			}

			if ($oPdf->gety() > $oPdf->h - 30) {

				$oPdf->addPage('L');
				addHeader($oPdf);
			}
			$iPreenche = 0;

			if ($iContador % 2 != 0){
				$iPreenche = 1;
			}

			addLinha($oPdf, $oItem, $iPreenche);
			$lPrimeiraCelula = false;
			$iContador++;
		}
		if ($oPdf->gety() > $oPdf->h - 30) {
			$oPdf->addPage('L');
		}
		addTotalizador($oPdf,$oTotal);
		$lPrimeiraCelula = true;
	}

} else {

  $oTotal = new stdClass;
  $iContador = 0;
	foreach ($aMateriais as $oItem) {

		if ($oItem->iTipo == 3) {
			$oTotal->nEntradas += $oItem->nValor;
		} else {
			$oTotal->nSaidas   += $oItem->nValor;
		}

		if ($oPdf->gety() > $oPdf->h - 30 || $lPrimeiraCelula) {

			$oPdf->addPage('L');
			addHeader($oPdf);
		}
		$iPreenche = 0;

		if ($iContador % 2 != 0){
			$iPreenche = 1;
		}

		addLinha($oPdf, $oItem, $iPreenche);
		$lPrimeiraCelula = false;
		$iContador++;
	}
	if ($oPdf->gety() > $oPdf->h - 30) {
		$oPdf->addPage('L');
	}
	addTotalizador($oPdf,$oTotal);

}



/**
 * Insere cabeçalho para relatório
 * @param object $oPdf
 */
function addHeader($oPdf) {


	$iAlturaLinha  = 4;
	$iLarguraLinha = 10;
	$iBorda        = 1;


	$oPdf->setfont('arial', 'b', 7);

	$oPdf->cell(20,$iAlturaLinha, "Cod. Lan",$iBorda, 0, "C", 1);
	$oPdf->cell(20,$iAlturaLinha, "Material",$iBorda, 0, "C", 1);
	$oPdf->cell(99,$iAlturaLinha, "Descrição do Material", 1, 0, "L", 1);
	$oPdf->cell(30,$iAlturaLinha, "Tipo",$iBorda, 0, "L", 1);
	$oPdf->cell(40,$iAlturaLinha, "Almoxarifado",$iBorda, 0, "C", 1);
	$oPdf->cell(25,$iAlturaLinha, "Quant.",$iBorda, 0, "C", 1);
	$oPdf->cell(25,$iAlturaLinha, "Valor",$iBorda, 0, "C", 1);
	$oPdf->cell(20,$iAlturaLinha, "Data",$iBorda, 1, "C", 1);
}


/**
 * Insere os dados para relatório
 * @param object $oPdf
 * @param object $oItem
 * @param integer $iPreenche pinta a linha
 */

function addLinha($oPdf, $oItem, $iPreenche = 0){

	$iAlturaLinha  = 4;
	$iLarguraLinha = 0;
	$iBorda        = 0;

	$sAlmoxarifado       = "{$oItem->iCodigoAlmoxarifado} - {$oItem->sDescricaoAlmoxarifado}";

  	$iNovaAlturaLinha = getAlturaLinha($iAlturaLinha,$oItem->sDescricaoItem,$sAlmoxarifado);
  	$oPdf->cell(20,$iNovaAlturaLinha, $oItem->iCodLancamento,$iBorda, 0, "C", $iPreenche);
	$oPdf->cell(20,$iNovaAlturaLinha, $oItem->iCodMaterial,$iBorda, 0, "C", $iPreenche);
  	multCell($oPdf,99,$iAlturaLinha,$iNovaAlturaLinha,ltrim($oItem->sDescricaoItem),$iBorda,"J",$iPreenche,0);
	$oPdf->cell(30,$iNovaAlturaLinha, substr($oItem->sDescricaoTipo,0,18),$iBorda, 0, "L", $iPreenche);
	multCell($oPdf,40,$iAlturaLinha,$iNovaAlturaLinha,$sAlmoxarifado,$iBorda,"C",$iPreenche,0);
	$oPdf->cell(25,$iNovaAlturaLinha, $oItem->nQuantidade,$iBorda, 0, "C", $iPreenche);
	$oPdf->cell(25,$iNovaAlturaLinha, db_formatar($oItem->nValor,'f'),$iBorda, 0, "C", $iPreenche);
	$oPdf->cell(20,$iNovaAlturaLinha, date("d/m/Y",strtotime($oItem->dData)),$iBorda, 1, "C", $iPreenche);
	$iAlturaCelulaObservacao = $oPdf->NbLines(279, $oItem->sObservacao) + 2;
	$oPdf->MultiCell(279,$iAlturaCelulaObservacao,"Observação: ". $oItem->sObservacao, 1, 'L', 0);

}

function getAlturaLinha($iAlturaLinha, $sDescricaoItem, $sAlmoxarifado) {
	$aDiv = array();
	$aDiv[] = round((strlen($sDescricaoItem)/80),0);
	$aDiv[] = round((strlen($sAlmoxarifado)/32),0);
	return ($iAlturaLinha*(max($aDiv)+1));
}

function multCell($oPdf,$iTam,$iAlturaLinha,$iNovaAlturaLinha,$sTexto,$iBorda,$iAlinha,$iPreenche,$iIndent) {
	$pos_x = $oPdf->x;
	$pos_y = $oPdf->y;
	$oPdf->cell($iTam,$iNovaAlturaLinha,"",$iBorda,0,"",$iPreenche);
  $oPdf->x = $pos_x;
  $oPdf->multicell($iTam,$iAlturaLinha,$sTexto,0,$iAlinha,0,$iIndent);
  $oPdf->x = $pos_x+$iTam;
  $oPdf->y = $pos_y;
}

/**
 * Insere totalizados para relatório
 * @param  Object  $oPdf                   
 * @param  Object  $oTotal             
 */
function addTotalizador($oPdf, $oTotal) {

  $oPdf->cell(279, 1, '', "T", 1, "C", 0);
  $oPdf->setfont('arial', 'B', 8);
  $iAlturaLinha  = 4;

  $oPdf->cell(234, $iAlturaLinha, 'Valor Total de Entradas Manuais:', 0, 0, "R", 0);
  $oPdf->cell(25, $iAlturaLinha, db_formatar($oTotal->nEntradas,'f'), 0, 1, "R", 0);  
  $oPdf->cell(234, $iAlturaLinha, 'Valor Total de Saídas Manuais:', 0, 0, "R", 0);
  $oPdf->cell(25, $iAlturaLinha, db_formatar($oTotal->nSaidas,'f'), 0, 1, "R", 0);

}

$oPdf->Output();

?>
