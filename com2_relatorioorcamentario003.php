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
 * BUSCO O VALOR TOTAL DO PRECO DE REFERENCIA
 *
 */
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
 * BUSCO O RESUMO DE REFERENCIA
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
//db_criatabela($resultDotacao);exit;
/**
 * BUSCO O TEXTO NO CADASTRO DE PARAGRAFOS
 *
 */
$sqlparag = "select db02_texto AS db02_texto1
	from db_documento 
	inner join db_docparag on db03_docum = db04_docum
	inner join db_tipodoc on db08_codigo  = db03_tipodoc
	inner join db_paragrafo on db04_idparag = db02_idparag 
	where db02_idparag = (SELECT db02_idparag
FROM db_documento
INNER JOIN db_docparag ON db03_docum = db04_docum
INNER JOIN db_tipodoc ON db08_codigo = db03_tipodoc
INNER JOIN db_paragrafo ON db04_idparag = db02_idparag
WHERE db02_descr LIKE 'DECLARAÇÃO DE REC. ORC. E FINANCEIRO TEXTO1') and db03_instit = " . db_getsession("DB_instit")." order by db04_ordem ";
$resparag = pg_query($sqlparag);
db_fieldsmemory( $resparag, 0 );
$head5 = "DECLARAÇÃO DE RECURSOS ORÇAMENTÁRIOS E FINANCEIRO";


$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(false);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(235);
$pdf->addpage('P');
$alt = 3;
$pdf->SetFont('arial','B',14);
$pdf->ln($alt+6);
$pdf->x = 30;
$pdf->Cell(160,6,"DECLARAÇÃO DE RECURSOS ORÇAMENTÁRIOS E FINANCEIRO",0,1,"C",0);
$pdf->ln($alt+3);
$pdf->x = 30;
$pdf->SetFont('arial','',11);
$pdf->MultiCell(160,5,"     Examinando  as  Dotações  constantes  do  orçamento  fiscal  e  levando-se  em  conta  o objeto que se  pretende  contratar, ".mb_strtoupper($objeto,'ISO-8859-1')." , no valor total estimado de R$ ".trim(db_formatar($nTotalItens,'f'))." em atendimento aos dispositivos da Lei 8666/93, informo que existe dotações das quais correrão a despesas:",0,"J",0);

$pdf->ln($alt+3);
$pdf->x = 30;

$pdf->cell(20,6,"Ficha"                           ,1,0,"C",1);
$pdf->cell(40,6,"Cód. orçamentário"               ,1,0,"C",1);
$pdf->cell(60,6,"Projeto Atividade"               ,1,0,"C",1);
$pdf->cell(40,6,"Fonte de Recurso"                ,1,1,"C",1);
$pdf->setfont('arial','',11);
$pdf->x = 30;

if(pg_num_rows($resultDotacao) != 0){
    for ($iCont = 0; $iCont < pg_num_rows($resultDotacao); $iCont++) {
        $pdf->x = 30;
        $oDadosDotacoes = db_utils::fieldsMemory($resultDotacao, $iCont);
        $pdf->cell(20, 6, $oDadosDotacoes->ficha,           1, 0, "C", 0);
        $pdf->cell(40, 6, $oDadosDotacoes->codorcamentario, 1, 0, "C", 0);
        $pdf->cell(60, 6, $oDadosDotacoes->projetoativ,     1, 0, "C", 0);
        $pdf->cell(40, 6, $oDadosDotacoes->fonterecurso,    1, 1, "C", 0);
    }
}else{
    $pdf->x = 30;
    $pdf->setfont('arial','b',11);
    $pdf->cell(190,6,"Nenhum Registro Encontrato."     ,0,1,"C",0);
}
$pdf->ln($alt+3);

$pdf->setfont('arial','',11);
$pdf->x = 30;

$pdf->MultiCell(160,5,"que as despesas atendem ao disposto nos artigos 16 e 17 da Lei Complementar Federal 101/2000, uma vez, foi considerado o impacto na execução orçamentária e também está de acordo com a previsão do Plano Plurianual e da Lei de Diretrizes Orçamentárias para exercício. Informamos ainda que foi verificado o impacto financeiro da despesa e sua inclusão na programação deste órgão.",0,"J",0);
$pdf->ln($alt+9);

$data = db_getsession('DB_datausu');
$sDataExtenso     = db_dataextenso($data);
$pdf->x = 30;
$pdf->cell(160,4,$munic.','.strtoupper($sDataExtenso)                     ,0,1,"C",0);
$pdf->ln($alt+20);
$pdf->cell(95,4,"________________________"                                ,0,0,"C",0);
$pdf->cell(95,4,"________________________"                                ,0,1,"C",0);
$pdf->cell(95,5,"Serviço Contábil"                                        ,0,0,"C",0);
$pdf->cell(95,5,"Serviço Financeiro"                                      ,0,0,"C",0);

$pdf->Output();


?>