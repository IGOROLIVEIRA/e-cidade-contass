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

$head5 = "SOLICITAÇÃO DE PARECER DE DISPONIBILIDADE FINANCEIRA";

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(false);
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(235);
$pdf->addPage('P');
$alt = 3;
$pdf->SetFont('arial','B',12);
$pdf->ln($alt + 4);
$pdf->cell(190,4,"SOLICITAÇÃO DE PARECER DE DISPONIBILIDADE FINANCEIRA",0,1,"C",0);
$pdf->ln($alt + 4);
$pdf->SetFont('arial','',11);
$pdf->x = 30;
$pdf->cell(190,4,"De: Pregoeira/ Comissão permanente de Licitação"  ,0,1,"L",0);
$pdf->x = 30;
$pdf->cell(190,4,"Para: Setor contábil"                             ,0,1,"L",0);
$pdf->ln($alt + 4);
$pdf->x = 30;
$pdf->MultiCell(160,4,"Solicito ao departamento contábil se há no orçamento vigente, disponibilidade financeira que atenda ".mb_strtoupper($objeto,'ISO-8859-1').", no valor total estimado de R$".trim(db_formatar($vlrtotal,'f')),0,"J",0);
$pdf->ln($alt + 4);
$data = db_getsession('DB_datausu');
$sDataExtenso     = db_dataextenso($data);
$pdf->cell(190,4,$munic.','.strtoupper($sDataExtenso)                      ,0,1,"C",0);
$pdf->ln($alt+6);
$pdf->cell(190,4,"________________________"                                ,0,1,"C",0);
$pdf->cell(190,4,"Presidente da CPL"                                       ,0,1,"C",0);
$pdf->cell(190,4,"E/OU Presidente da Comissão de Licitação"                ,0,1,"C",0);

$pdf->Output();

?>