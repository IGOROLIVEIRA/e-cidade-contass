<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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

require_once("fpdf151/pdf.php");
require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");

$oGet = db_utils::postMemory($_GET);

if($tipo == "m") {
  // Se for escolhida alguma matrícula

  $orderBY= " rh01_regist,r14_rubric";

  if(isset($rei) && trim($rei) != "" && isset($ref) && trim($ref) != ""){
    // Se for por intervalos e vier matrícula inicial e final

    $aWhere[] = " rh01_regist between ".$rei." and ".$ref;
  }else if(isset($rei) && trim($rei) != ""){
    // Se for por intervalos e vier somente matrícula inicial
    $aWhere[] = " rh01_regist >= ".$rei;
  }else if(isset($ref) && trim($ref) != ""){
    // Se for por intervalos e vier somente matrícula final
    $aWhere[] = " rh01_regist <= ".$ref;
  }else if(isset($fre) && trim($fre) != ""){
    // Se for por selecionados
    $aWhere[] = " rh01_regist in (".$fre.") ";
  }

}else if($tipo == "l") {
  // Se for escolhida alguma lotação

  $orderBY= " r70_estrut,z01_nome,rh01_regist,r14_rubric";

  if(isset($lti) && trim($lti) != "" && isset($ltf) && trim($ltf) != ""){
    // Se for por intervalos e vier lotação inicial e final
    $aWhere[] = " r70_estrut between '".$lti."' and '".$ltf."' ";
  }else if(isset($lti) && trim($lti) != ""){
    // Se for por intervalos e vier somente lotação inicial
    $aWhere[] = " r70_estrut >= '".$lti."' ";
  }else if(isset($ltf) && trim($ltf) != ""){
    // Se for por intervalos e vier somente lotação final
    $aWhere[] = " r70_estrut <= '".$ltf."' ";
  }else if(isset($flt) && trim($flt) != ""){
    // Se for por selecionados
    $aWhere[] = " r70_estrut in ('".str_replace(",","','",$flt)."') ";
  }


}else if($tipo == "t") {
  // Se for escolhido algum local de trabalho

  $orderBY = " rh55_estrut,z01_nome,rh01_regist,r14_rubric";

  if(isset($lci) && trim($lci) != "" && isset($lcf) && trim($lcf) != ""){
    // Se for por intervalos e vier local inicial e final
    $aWhere[]   = " rh55_estrut between '".$lci."' and '".$lcf."' ";
  }else if(isset($lci) && trim($lci) != ""){
    // Se for por intervalos e vier somente local inicial
    $aWhere[] = " rh55_estrut >= '".$lci."' ";
  }else if(isset($lcf) && trim($lcf) != ""){
    // Se for por intervalos e vier somente local final
    $aWhere[] = " rh55_estrut <= '".$lcf."' ";
  }else if(isset($flc) && trim($flc) != ""){
    // Se for por selecionados
    $aWhere[] = " rh55_estrut in ('".str_replace(",","','",$flc)."') ";
  }

}else if($tipo == "o") {
  // Se for escolhido algum órgão

  $orderBY= " o40_orgao,z01_nome,rh01_regist,r14_rubric";

  if(isset($ori) && trim($ori) != "" && isset($orf) && trim($orf) != ""){
    // Se for por intervalos e vier órgão inicial e final
    $aWhere[] = " o40_orgao between ".$ori." and ".$orf;
  }else if(isset($ori) && trim($ori) != ""){
    // Se for por intervalos e vier somente órgão inicial
    $aWhere[] = " o40_orgao >= ".$ori;
  }else if(isset($orf) && trim($orf) != ""){
    // Se for por intervalos e vier somente órgão final
    $aWhere[] = " o40_orgao <= ".$orf;
  }else if(isset($for) && trim($for) != ""){
    // Se for por selecionados
    $aWhere[] = " o40_orgao in (".$for.") ";
  }

}else if($tipo == "s") {
    // Se for escolhido algum Recurso

  $orderBY= " o15_codigo,o15_descr";

  if(isset($rci) && trim($rci) != "" && isset($rcf) && trim($rcf) != ""){
    // Se for por intervalos e vier recurso inicial e final
    $aWhere[] = " o15_codigo between ".$rci." and ".$rcf;
  }else if(isset($rci) && trim($rci) != ""){
    // Se for por intervalos e vier somente recurso inicial
    $aWhere[] = " o15_codigo >= ".$rci;
  }else if(isset($rcf) && trim($rcf) != ""){
    // Se for por intervalos e vier somente recurso final
    $aWhere[] = " o15_codigo <= ".$rcf;
  }else if(isset($frc) && trim($frc) != ""){
    // Se for por selecionados
    $aWhere[] = " o15_codigo in (".$frc.") ";
  }
}

if (trim($sel) != "") {
  
  $oDaoSelecao = db_utils::getDao('selecao');
  $result_selecao = $oDaoSelecao->sql_record($oDaoSelecao->sql_query_file($sel,db_getsession("DB_instit")," r44_descr, r44_where "));
  if ($oDaoSelecao->numrows > 0) {
    db_fieldsmemory($result_selecao, 0);
    $aWhere[] = $r44_where;
  }
}

$oDaoRhpesrescisao = db_utils::getDao('rhpesrescisao');
$sCampos  = "DISTINCT rh16_pis,rh01_admiss,h13_tpcont,z01_nome,z01_mae,rh16_ctps_n,rh16_ctps_s,rh16_ctps_uf,rh01_sexo,rh01_instru,rh01_nasc,rh02_hrssem,rh37_cbo,";
$sCampos .= "rh15_data,r59_movsef,rh05_recis,r59_codsaq,rh05_taviso,rh05_aviso,z01_cgccpf,rh115_descricao,rh115_sigla,h13_descr,h13_codigo";
$sOrdem = "rh16_pis,rh01_admiss,h13_tpcont";

$sDataCompIni = "{$ano}-{$mes}-01";
$lBisexto = verifica_bissexto($sDataCompIni);
if ($lBisexto) {
    $iFev = 29;
} else {
    $iFev = 28;
}
$aUltimoDia = array("01"=>"31",
"02"=>$iFev,
"03"=>"31",
"04"=>"30",
"05"=>"31",
"06"=>"30",
"07"=>"31",
"08"=>"31",
"09"=>"30",
"10"=>"31",
"11"=>"30",
"12"=>"31");
$sDataCompFim = "{$ano}-{$mes}-".$aUltimoDia[$mes];
$sWhere  = "rh05_recis between '{$sDataCompIni}' AND '{$sDataCompFim}' AND rh02_instit = ".db_getsession("DB_instit");
if (count($aWhere)) {
	$sWhere .= " AND ".implode(" AND ", $aWhere);
}

$rsResult= $oDaoRhpesrescisao->sql_record($oDaoRhpesrescisao->sql_relatorios_termo_rescisao(null, $sCampos, $sOrdem, $sWhere));

if ($oDaoRhpesrescisao->numrows == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não foram encontrados servidores com rescisão em '.$mes.' / '.$ano);
}

$oDaoDbConfig = db_utils::getDao("db_config");
$rsDBConfig   = $oDaoDbConfig->sql_record($oDaoDbConfig->sql_query_file(db_getsession("DB_instit")));
$oConfig = db_utils::fieldsMemory($rsDBConfig, 0);


$oPdf = new PDF();
$oPdf->open();
$oPdf->SetFillColor(190);
$oPdf->SetAutoPageBreak('on',0);
$altTotal = 10;
$altLabel = 4;
$altField = 5;

for($iCont = 0; $iCont < $oDaoRhpesrescisao->numrows; $iCont++) {

    $oResult = db_utils::fieldsMemory($rsResult, $iCont);
	$oPdf->AddPage();
	$oPdf->SetFont('arial','b',9);
	$oPdf->cell(192,5,"TERMO DE RESCISÃO DO CONTRATO DE TRABALHO",0,1,"C",1);
	$oPdf->cell(192,$altLabel,"",0,1,"C",0);

	//CABECALHO
	addHeader($oPdf, "EMPREGADOR");

	// LINHA
	$oDados = new stdClass();
	$oDados->label = "01 CNPJ/CEI";
	$oDados->value = $oConfig->cgc;
	$oDados->size = 50;
	$oDados->ln = false;
	addField($oPdf, $oDados);

	$oDados->label = "02 Razão Social/Nome";
	$oDados->value = $oConfig->nomeinst;
	$oDados->size = 142;
	$oDados->ln = true;
	addField($oPdf, $oDados);

	// CABECALHO
	addHeader($oPdf, "TRABALHADOR");

	//LINHA
	$oDados->label = "03 PIS/PASEP";
	$oDados->value = $oResult->rh16_pis;
	$oDados->size = 50;
	$oDados->ln = false;
	addField($oPdf, $oDados);

	$oDados->label = "04 Nome";
	$oDados->value = $oResult->z01_nome;
	$oDados->size = 142;
	$oDados->ln = true;
	addField($oPdf, $oDados);

	//LINHA
	$oDados->label = "05 CTPS (no, série, UF)";
	$oDados->value = "$oResult->rh16_ctps_n, $oResult->rh16_ctps_s, $oResult->rh16_ctps_uf";
	$oDados->size = 32;
	$oDados->ln = false;
	addField($oPdf, $oDados);

	$oDados->label = "06 CPF";
	$oDados->value = db_formatar($oResult->z01_cgccpf, 'cpf');
	$oDados->size = 32;
	$oDados->ln = false;
	addField($oPdf, $oDados);

	$oDados->label = "07 Data de Nascimento";
	$oDados->value = db_formatar($oResult->rh01_nasc, 'd');
	$oDados->size = 32;
	$oDados->ln = false;
	addField($oPdf, $oDados);

	$oDados->label = "08 Nome da Mãe";
	$oDados->value = $oResult->z01_mae;
	$oDados->size = 96;
	$oDados->ln = true;
	addField($oPdf, $oDados);

	// CABECALHO
	addHeader($oPdf, "CONTRATO");

	//LINHA
	$oDados->label = "09 Causa do Afastamento";
	$oDados->value = $oResult->rh115_descricao;
	$oDados->size = 192;
	$oDados->ln = true;
	addField($oPdf, $oDados);

	//LINHA
	$oDados->label = "10 Data de Admissão";
	$oDados->value = db_formatar($oResult->rh01_admiss, 'd');
	$oDados->size = 32;
	$oDados->ln = false;
	addField($oPdf, $oDados);

	$oDados->label = "11 Data do Aviso Prévio";
	$oDados->value = db_formatar($oResult->rh05_aviso, 'd');
	$oDados->size = 32;
	$oDados->ln = false;
	addField($oPdf, $oDados);

	$oDados->label = "12 Data de Afastamento";
	$oDados->value = db_formatar($oResult->rh05_recis, 'd');
	$oDados->size = 32;
	$oDados->ln = false;
	addField($oPdf, $oDados);

	$oDados->label = "13 Cód. Afast.";
	$oDados->value = $oResult->rh115_sigla;
	$oDados->size = 32;
	$oDados->ln = false;
	addField($oPdf, $oDados);

	$oDados->label = "14 Pensão Alimentícia (%) (FGTS)";
	$oDados->value = "";
	$oDados->size = 64;
	$oDados->ln = true;
	addField($oPdf, $oDados);

	//LINHA
	$oDados->label = "15 Categoria do Trabalhador";
	$oDados->value = "$oResult->h13_tpcont - $oResult->h13_descr";
	$oDados->size = 192;
	$oDados->ln = true;
	addField($oPdf, $oDados);
	
	$oPdf->Ln(12);

	$text = "Foi realizada a rescisão do contrato de trabalho do trabalhador acima qualificado, nos termos do artigo n.o 477 da Consolidação das Leis do
	Trabalho (CLT). A assistência à rescisão prevista no § 1o do art. n.o 477 da CLT não é devida, tendo em vista a duração do contrato de
	trabalho não ser superior a um ano de serviço e não existir previsão de assistência à rescisão contratual em Acordo ou Convenção Coletiva
	de Trabalho da categoria a qual pertence o trabalhador.";
	addText($oPdf, $text);

	$oPdf->Ln(16);

	$text = "No dia ____ / ____/________ foi realizado, nos termos do art. 23 da Instrução Normativa/SRT n.o 15/2010, o efetivo pagamento das
	verbas rescisórias especificadas no corpo do TRCT, no valor líquido de R$
	,o qual, devidamente rubricado pelas partes, é
	parte integrante do presente Termo de Quitação.";
	addText($oPdf, $text);

	$oPdf->Ln(16);

	$text = "____________________/___, ____ de _______________________ de _______.";
	$oPdf->cell(192,4,$text,0,1,"L",0);
	$oPdf->Ln(16);

	$underlinaText = "__________________________________________________________    ";
	$oPdf->cell(192,4,$underlinaText,0,1,"L",0);
	$text = "      Assinatura do Empregador ou Preposto";
	$oPdf->cell(192,4,$text,0,1,"L",0);
	$oPdf->Ln(16);
	$oPdf->cell(96,4,$underlinaText,0,0,"L",0);
	$oPdf->cell(96,4,$underlinaText,0,1,"L",0);
	$text = "                Assinatura do Trabalhador";
	$oPdf->cell(96,4,$text,0,0,"L",0);
	$text = "      Assinatura do Responsável Legal do Trabalhador";
	$oPdf->cell(96,4,$text,0,1,"L",0);

	$oPdf->Ln(32);
	$oPdf->cell(192,4,"    Informações à CAIXA:",1,1,"L",0);

	$oPdf->Ln(8);
	$oPdf->cell(192,4,"A ASSISTÊNCIA NO ATO DE RESCISÃO CONTRATUAL É GRATUITA.",0,1,"C",1);
	$oPdf->cell(192,4,"Pode o trabalhador iniciar ação judicial quanto aos créditos resultantes das relações de trabalho até o limite de dois",0,1,"C",1);
	$oPdf->cell(192,4,"anos após a extinção do contrato de trabalho (Inc. XXIX, Art. 7o da Constituição Federal/1988).",0,1,"C",1);

}

$oPdf->Output();

function addField($oPdf, $oDados) {
	$iPosX = $oPdf->GetX();
	$iPosY = $oPdf->GetY();
	$oPdf->cell($oDados->size,4,$oDados->label,"LTR",1,"L",0);
	$oPdf->SetX($iPosX);
    $oPdf->cell($oDados->size,5,$oDados->value,"LBR",1,"L",0);
    if (!$oDados->ln) {
    	$oPdf->SetY($iPosY);
    	$oPdf->SetX($oDados->size+$iPosX);
    }
}

function addHeader($oPdf, $text) {
	$oPdf->SetFont('arial','b',7);
    $oPdf->cell(192,4,$text,1,1,"C",1);
    $oPdf->SetFont('arial','',7);
}

function addText($oPdf ,$text) {
	$aText = splitText($text, 173);
    multiCell($oPdf, $aText, 4, 192, 0);
}

function splitText($texto,$tamanho) {

	$aTexto = explode(" ", $texto);
	$string_atual = "";
	foreach ($aTexto as $word) {
		$string_ant = $string_atual;
		$string_atual .= " ".$word;
		if (strlen($string_atual) > $tamanho) {
			$aTextoNovo[] = $string_ant;
			$string_ant   = "";
			$string_atual = $word;
		}
	}
	$aTextoNovo[] = $string_atual;
	return $aTextoNovo;

}

function multiCell($oPdf,$aTexto,$iTamFixo,$iTamCampo, $iBorda = 1) {

	$iTam = $iTamFixo*(count($aTexto));
	$pos_x = $oPdf->x;
	$pos_y = $oPdf->y;
	$oPdf->cell($iTamCampo, $iTam, "", $iBorda, 0, 'L');
	$oPdf->x = $pos_x;
	$oPdf->y = $pos_y;
	foreach ($aTexto as $sProcedimento) {
		$sProcedimento=ltrim($sProcedimento);
		$oPdf->cell($iTamCampo, $iTamFixo, $sProcedimento, 0, 1, 'L');
		$oPdf->x=$pos_x;
	}
	$oPdf->x = $pos_x+$iTamCampo;
	$oPdf->y = $pos_y;
}