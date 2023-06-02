<?php
//ini_set('display_errors','on');
//require_once("fpdf151/fpdf.php");
include("fpdf151/pdf.php");
require_once("std/DBDate.php");
include("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
require_once("classes/db_pcproc_classe.php");
db_postmemory($HTTP_GET_VARS);
$clpcproc = new cl_pcproc();

/**
 * BUSCO DADOS DA INSTITUICAO
 *
 */


$sql = "select nomeinst,
bairro,
cgc,
trim(ender)||','||trim(cast(numero as text)) as ender,
upper(munic) as munic,
uf,
telef,
email,
url,
logo, 
db12_extenso
from db_config 
inner join db_uf on db12_uf = uf
where codigo = ".db_getsession("DB_instit");
$result = db_query($sql);
db_fieldsmemory($result,0);

/**
 * BUSCO TIPO DE PRECO DE REFERENCIA
 */

$rsLotes = db_query("select distinct  pc68_sequencial,pc68_nome
from
    pcproc
join pcprocitem on
    pc80_codproc = pc81_codproc
left join processocompraloteitem on
    pc69_pcprocitem = pcprocitem.pc81_codprocitem
left join processocompralote on
    pc68_sequencial = pc69_processocompralote
where
    pc80_codproc = {$codigo_preco}
    and pc68_sequencial is not null
    order by pc68_sequencial asc");

$tipoReferencia = " (sum(pc23_vlrun)/count(pc23_orcamforne)) ";


$rsResultado = db_query("select pc80_criterioadjudicacao from pcproc where pc80_codproc = {$codigo_preco}");
$criterio    = db_utils::fieldsMemory($rsResultado, 0)->pc80_criterioadjudicacao;
$sCondCrit   = ($criterio == 3 || empty($criterio)) ? " AND pc23_valor <> 0 " : "";

/**
 * GET ITENS
 */
$sSql = "select * from (SELECT
                pc01_codmater,
                case when pc01_complmater is not null and pc01_complmater != pc01_descrmater then pc01_descrmater ||'. '|| pc01_complmater
		     else pc01_descrmater end as pc01_descrmater,
                m61_abrev,
                sum(pc11_quant) as pc11_quant,
                pc69_seq,
                pc11_seq
from (
SELECT DISTINCT pc01_servico,
                pc11_codigo,
                pc11_seq,
                pc11_quant,
                pc11_prazo,
                pc11_pgto,
                pc11_resum,
                pc11_just,
                m61_abrev,
                m61_descr,
                pc17_quant,
                pc01_codmater,
                pc01_descrmater,pc01_complmater,
                pc10_numero,
                pc90_numeroprocesso AS processo_administrativo,
                (pc11_quant * pc11_vlrun) AS pc11_valtot,
                m61_usaquant,
                pc69_seq
FROM solicitem
INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
LEFT JOIN solicitaprotprocesso ON solicitaprotprocesso.pc90_solicita = solicita.pc10_numero
LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
LEFT JOIN pcprocitem ON pcprocitem.pc81_solicitem = solicitem.pc11_codigo
LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
LEFT JOIN orcelemento ON solicitemele.pc18_codele = orcelemento.o56_codele
left join processocompraloteitem on
		pc69_pcprocitem = pcprocitem.pc81_codprocitem
left join processocompralote on
			pc68_sequencial = pc69_processocompralote
AND orcelemento.o56_anousu = " . db_getsession("DB_anousu") . "
WHERE pc81_codproc = {$processodecompras}
  AND pc10_instit = " . db_getsession("DB_instit") . "
ORDER BY pc11_seq) as x GROUP BY
                pc01_codmater,
                pc11_seq,
                pc01_descrmater,pc01_complmater,m61_abrev,pc69_seq ) as matquan join
(SELECT DISTINCT
                pc11_seq,
                {$tipoReferencia} as si02_vlprecoreferencia,
                                     case when pc80_criterioadjudicacao = 1 then
                     round((sum(pc23_perctaxadesctabela)/count(pc23_orcamforne)),2)
                     when pc80_criterioadjudicacao = 2 then
                     round((sum(pc23_percentualdesconto)/count(pc23_orcamforne)),2)
                     end as mediapercentual,
                pc01_codmater,
                si01_datacotacao,
                pc80_criterioadjudicacao,
                pc01_tabela,
                pc01_taxa,
                si01_justificativa
FROM pcproc
JOIN pcprocitem ON pc80_codproc = pc81_codproc
JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
JOIN solicitem ON pc81_solicitem = pc11_codigo
JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
JOIN pcmater ON pc16_codmater = pc01_codmater
JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
WHERE pc80_codproc = {$processodecompras} {$sCondCrit} and pc23_vlrun <> 0
GROUP BY pc11_seq, pc01_codmater,si01_datacotacao,si01_justificativa,pc80_criterioadjudicacao,pc01_tabela,pc01_taxa
ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by matquan.pc11_seq asc";
$resultpreco = db_query($sSql) or die(pg_last_error());

for ($iCont = 0; $iCont < pg_num_rows($resultpreco); $iCont++) {

       $oResult = db_utils::fieldsMemory($resultpreco, $iCont);

       //    if($quant_casas){
       $lTotal = round($oResult->si02_vlprecoreferencia, 2) * $oResult->pc11_quant;
       $nTotalItens += $lTotal;
}

/**
 * BUSCO O VALOR TOTAL DO PRECO DE REFERENCIA
 *
 */
$sqlObjeto = "select pc80_resumo as objeto from pcproc where pc80_codproc = $processodecompras";
$resultObjeto = db_query($sqlObjeto);
db_fieldsmemory($resultObjeto,0);

/**
 * BUSCO OS DADOS DA DOTACAO
 *
 */
$sqlDotacao = "SELECT DISTINCT pc13_coddot AS ficha,
                o15_codtri AS fonterecurso,
                o58_projativ AS projetoativ,
                o56_elemento as codorcamentario
FROM pcproc
INNER JOIN pcprocitem ON pcprocitem.pc81_codproc = pcproc.pc80_codproc 
INNER JOIN solicitem ON pcprocitem.pc81_solicitem = solicitem.pc11_codigo
INNER JOIN pcdotac ON pcdotac.pc13_codigo = solicitem.pc11_codigo
INNER JOIN orcdotacao ON (orcdotacao.o58_anousu,orcdotacao.o58_coddot) = (pcdotac.pc13_anousu,pcdotac.pc13_coddot)
INNER JOIN orctiporec ON orctiporec.o15_codigo = orcdotacao.o58_codigo
INNER JOIN orcelemento on (orcelemento.o56_codele,orcelemento.o56_anousu) = (orcdotacao.o58_codele,orcdotacao.o58_anousu)
WHERE pc80_codproc = $processodecompras";
$resultDotacao = db_query($sqlDotacao);

$head5 = "SOLICITAÇÃO DE PARECER DE DISPONIBILIDADE FINANCEIRA";

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(false);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(235);
$pdf->addPage('P');
$alt = 3;
$pdf->SetFont('arial','B',14);
$pdf->ln($alt + 4);
$pdf->cell(190,4,"SOLICITAÇÃO DE PARECER DE DISPONIBILIDADE FINANCEIRA",0,1,"C",0);
$pdf->ln($alt + 4);
$pdf->SetFont('arial','',11);
$pdf->x = 30;
$pdf->cell(190,5,"De: Pregoeira/ Comissão permanente de Licitação"  ,0,1,"L",0);
$pdf->x = 30;
$pdf->cell(190,5,"Para: Setor contábil"                             ,0,1,"L",0);
$pdf->ln($alt + 4);
$pdf->x = 30;
$pdf->MultiCell(160,5,"     Solicito ao departamento contábil se há no orçamento vigente, disponibilidade financeira que atenda ".mb_strtoupper($objeto,'ISO-8859-1').", no valor total estimado de R$".trim(db_formatar($nTotalItens,'f')),0,"J",0);
$pdf->ln($alt + 20);
$data = db_getsession('DB_datausu');
$sDataExtenso     = db_dataextenso($data);
$pdf->cell(190,4,$munic.','.strtoupper($sDataExtenso)                      ,0,1,"C",0);
$pdf->ln($alt+20);
$pdf->cell(190,5,"________________________"                                ,0,1,"C",0);
$pdf->cell(190,5,"Presidente da CPL"                                       ,0,1,"C",0);
$pdf->cell(190,5,"e/ou Presidente da Comissão de Licitação"                ,0,1,"C",0);

$pdf->Output();

?>