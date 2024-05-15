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

require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$sWhere = " rh219_instit = " . db_getsession("DB_instit");

$head3 = "Evento 5011 Consulta";
if (!empty($rh219_perapurmes) && !empty($rh219_perapurano)) {
  $head4 = "PERÍODO : ".$rh219_perapurmes." / ".$rh219_perapurano;
}

if (!empty($rh219_perapurano)) {
  $sWhere .= " and rh219_perapurano = $rh219_perapurano ";
}
if (!empty($rh219_perapurmes)) {
  $sWhere .= " and rh219_perapurmes = $rh219_perapurmes ";
}
if (!empty($rh219_perapurano) && empty($rh219_perapurmes)) {
  $sWhere .= " and rh219_perapurmes is null ";
}

$oEvt5011Consulta = db_utils::getDao('evt5011consulta');

$campos = "rh219_perapurano
          ,rh219_perapurmes
          ,case when rh219_indapuracao = 1 then 'Mensal'
          when rh219_indapuracao = 2 then 'Anual (13° salário)'
          else '' end as rh219_indapuracao     
          ,rh219_classtrib
          ,rh219_cnaeprep
          ,rh219_aliqrat
          ,rh219_fap
          ,rh219_aliqratajust     
          ,rh219_fpas             
          ,rh219_vrbccp00         
          ,rh219_baseaposentadoria
          ,rh219_vrsalfam
          ,rh219_vrsalmat
          ,rh219_vrdesccp         
          ,rh219_vrcpseg
          ,rh219_vrcr  
          ,rh219_vrcr + rh219_vrcpseg - rh219_vrsalfam - rh219_vrsalmat  
          as valor_devido_previdencia ";
$sSql = $oEvt5011Consulta->sql_query(null, $campos, "rh219_sequencial desc", $sWhere);
$rsDados = $oEvt5011Consulta->sql_record($sSql);
if ($oEvt5011Consulta->numrows == 0) {
   db_redireciona("db_erros.php?fechar=true&db_erro=Não existem dados nesse período");
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$alt   = 4;

for ($iCont = 0; $iCont < pg_num_rows($rsDados); $iCont++) {

  $oDados = db_utils::fieldsMemory($rsDados, $iCont);

  $pdf->addpage();
  $pdf->Ln(10);
  $pdf->setfont('arial','b',10);
  $pdf->cell(10,$alt,'',0,0,"C",0);
  $pdf->cell(32,$alt,'Período Apuração Ano',"B",0,"L",0);
  $pdf->cell(110,$alt,$oDados->rh219_perapurano,"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Período Apuração Mês',"B",0,"L",0);
  $pdf->cell(110,$alt,$oDados->rh219_perapurmes,"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Tipo de Folha',"B",0,"L",0);
  $pdf->cell(110,$alt,$oDados->rh219_indapuracao,"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Classificação Tributária',"B",0,"L",0);
  $pdf->cell(110,$alt,$oDados->rh219_classtrib,"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Código CNAE',"B",0,"L",0);
  $pdf->cell(110,$alt,$oDados->rh219_cnaeprep,"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Alíquota RAT',"B",0,"L",0);
  $pdf->cell(110,$alt,$oDados->rh219_aliqrat,"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Alíquota FAP',"B",0,"L",0);
  $pdf->cell(110,$alt,$oDados->rh219_fap,"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Alíquota RAT Ajustada',"B",0,"L",0);
  $pdf->cell(110,$alt,$oDados->rh219_aliqratajust,"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Código FPAS',"B",0,"L",0);
  $pdf->cell(110,$alt,$oDados->rh219_fpas,"B",1,"R",0);
  $pdf->Ln(10);

  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Base de Cálculo',"B",0,"L",0);
  $pdf->cell(110,$alt,db_formatar($oDados->rh219_vrbccp00, "f"),"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Aposentadoria Especial',"B",0,"L",0);
  $pdf->cell(110,$alt,db_formatar($oDados->rh219_baseaposentadoria, "f"),"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Salário Família',"B",0,"L",0);
  $pdf->cell(110,$alt,db_formatar($oDados->rh219_vrsalfam, "f"),"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Salário Maternidade',"B",0,"L",0);
  $pdf->cell(110,$alt,db_formatar($oDados->rh219_vrsalmat, "f"),"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Contribuição Segurados',"B",0,"L",0);
  $pdf->cell(110,$alt,db_formatar($oDados->rh219_vrdesccp, "f"),"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Calculado eSocial',"B",0,"L",0);
  $pdf->cell(110,$alt,db_formatar($oDados->rh219_vrcpseg, "f"),"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Contribuição Patronal',"B",0,"L",0);
  $pdf->cell(110,$alt,db_formatar($oDados->rh219_vrcr, "f"),"B",1,"R",0);
  $pdf->Ln($alt/2);
  $pdf->cell(10,$alt,'',0,0,"L",0);
  $pdf->cell(32,$alt,'Total Devido a Previdência',"B",0,"L",0);
  $pdf->cell(110,$alt,db_formatar($oDados->valor_devido_previdencia, "f"),"B",1,"R",0);

}

$pdf->Output();
