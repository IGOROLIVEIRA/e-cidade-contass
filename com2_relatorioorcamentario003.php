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
$sqlvlrtotal = "select sum(si02_vlprecoreferencia)  as vlrtotal from precoreferencia 
inner join itemprecoreferencia on si02_precoreferencia = si01_sequencial
where si01_processocompra = $processodecompras";
$resultpreco = db_query($sqlvlrtotal);
db_fieldsmemory($resultpreco,0);

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
$pdf->SetFont('arial','B',12);
$pdf->ln($alt+6);
$pdf->Cell(190,6,"DECLARAÇÃO DE RECURSOS ORÇAMENTÁRIOS E FINANCEIRO",0,1,"C",0);
$pdf->ln($alt+3);
$pdf->SetFont('arial','',11);
$pdf->MultiCell(190,4,"     Examinando as Dotações constantes do orçamento fiscal e levando-se em conta os serviços que se pretende contratar, cujo objeto é ".mb_strtoupper($objeto,'ISO-8859-1')." , no valor total estimado de R$ ".trim(db_formatar($vlrtotal,'f'))." em atendimento aos dispositivos da Lei 8666/93, informo que existe dotações das quais correrão a despesas:",0,"J",0);

$pdf->ln($alt+3);
$pdf->cell(30,4,"Ficha"                           ,1,0,"C",1);
$pdf->cell(50,4,"Cód. orçamentário"               ,1,0,"C",1);
$pdf->cell(60,4,"Projeto Atividade"               ,1,0,"C",1);
$pdf->cell(50,4,"Fonte de Recurso"                ,1,1,"C",1);
$pdf->setfont('arial','',11);
if(pg_num_rows($resultDotacao) != 0){
    for ($iCont = 0; $iCont < pg_num_rows($resultDotacao); $iCont++) {
        $oDadosDotacoes = db_utils::fieldsMemory($resultDotacao, $iCont);
        $pdf->cell(30, 5, $oDadosDotacoes->ficha,           1, 0, "C", 0);
        $pdf->cell(50, 5, $oDadosDotacoes->codorcamentario, 1, 0, "C", 0);
        $pdf->cell(60, 5, $oDadosDotacoes->projetoativ,     1, 0, "C", 0);
        $pdf->cell(50, 5, $oDadosDotacoes->fonterecurso,    1, 1, "C", 0);
    }
}else{
    $pdf->setfont('arial','b',11);
    $pdf->cell(190,4,"Nenhum Registro Encontrato."     ,0,1,"C",0);
}
$pdf->ln($alt+3);

$pdf->setfont('arial','',11);
$pdf->MultiCell(190,4,"que as despesas atendem ao disposto nos artigos 16 e 17 da Lei Complementar Federal 101/2000, uma vez, foi considerado o impacto na execução orçamentária e também está de acordo com a previsão do Plano Plurianual e da Lei de Diretrizes Orçamentárias para exercício. Informamos ainda que foi verificado o impacto financeiro da despesa e sua inclusão na programação deste órgão.",0,"J",0);
$pdf->ln($alt+9);

$data = db_getsession('DB_datausu');
$sDataExtenso     = db_dataextenso($data);
$pdf->cell(190,4,$munic.','.strtoupper($sDataExtenso)                     ,0,1,"C",0);
$pdf->ln($alt+5);
$pdf->cell(95,4,"________________________"                                ,0,0,"C",0);
$pdf->cell(95,4,"________________________"                                ,0,1,"C",0);
$pdf->cell(95,5,"Serviço Contábil"                                        ,0,0,"C",0);
$pdf->cell(95,5,"Serviço Financeiro"                                      ,0,0,"C",0);
$pdf->ln($alt+3);

$pdf->Output();


?>