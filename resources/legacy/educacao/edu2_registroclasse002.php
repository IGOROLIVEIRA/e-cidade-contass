<?php
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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");
require_once("std/DBDate.php");
require_once("fpdf151/scpdf.php");

$oGet    = db_utils::postMemory($_GET);
$aTurmas = explode(",", $oGet->turmas);

$oPdf = new scpdf("L");
$oPdf->Open();
$oPdf->AliasNbPages();
$oPdf->SetAutoPageBreak(false);

$lPrimeiraPagina       = true;
$iTotalLinhasImpressao = 45;
$iAlturaLinha          = 4;
$oEscola               = new Escola($oGet->iEscola);

foreach ($aTurmas as $iTurma) {

  $oTurma                = new Turma($iTurma);
  $aMatriculas           = $oTurma->getUltimaMatriculaAlunos();
  $lPrimeiraPagina       = true;
  $iTotalLinhasImpressas = 0;
  $iAluno                = 1;

  foreach ($aMatriculas as $oMatricula) {

    if ($oMatricula->getSituacao() != 'MATRICULADO') {
      continue;
    }

    if ($lPrimeiraPagina || $oPdf->GetY()  > $oPdf->h - 15) {

      $oPdf->AddPage();
      desenharCabecalho($oPdf, $oTurma, $oEscola, $iAlturaLinha);

      $lPrimeiraPagina     = false;
      $iTotalParaImpressao = $iTotalLinhasImpressao;
    }

    $sDataCalculo = date("Y-m-d", db_getsession("DB_datausu"));
    $oIdadeAluno  = $oMatricula->getAluno()->getIdadeNaData(date($sDataCalculo, db_getsession("DB_datausu")));
    $sIdade       = str_pad($oIdadeAluno->anos, 2, "0", STR_PAD_LEFT) . "|";
    $sIdade      .= str_pad($oIdadeAluno->meses, 2, "0", STR_PAD_LEFT);

    $oPdf->Cell(12, $iAlturaLinha,  $oMatricula->getAluno()->getCodigoAluno(), 1, 0, "R");
    $oPdf->Cell(5, $iAlturaLinha,                                    $iAluno, 1, 0, "R");
    $oPdf->Cell(90, $iAlturaLinha,         $oMatricula->getAluno()->getNome(), 1, 0, "L");
    $oPdf->Cell(10, $iAlturaLinha,                                         '', 1, 0, "C");
    $oPdf->Cell(8, $iAlturaLinha,         $oMatricula->getAluno()->getSexo(), 1, 0, "C");
    $oPdf->Cell(50, $iAlturaLinha,                                         '', 1, 0, "C");
    $oPdf->Cell(10, $iAlturaLinha,                                         '', 1, 0, "C");
    $oPdf->Cell(50, $iAlturaLinha,                                         '', 1, 0, "C");
    $oPdf->Cell(10, $iAlturaLinha,                                         '', 1, 0, "C");
    $oPdf->Cell(8, $iAlturaLinha,                                    $sIdade, 1, 0, "C");
    $oPdf->Cell(25, $iAlturaLinha,                                         '', 1, 1, "C");

    $iAluno++;
    $iTotalLinhasImpressas++;
    MatriculaRepository::removerMatricula($oMatricula);
  }

  for ($iLinhaEmBranco = $iTotalLinhasImpressas; $iLinhaEmBranco < $iTotalParaImpressao; $iLinhaEmBranco++) {

    $oPdf->Cell(12, $iAlturaLinha, '', 1, 0, "R");
    $oPdf->Cell(5, $iAlturaLinha, '', 1, 0, "R");
    $oPdf->Cell(90, $iAlturaLinha, '', 1, 0, "L");
    $oPdf->Cell(10, $iAlturaLinha, '', 1, 0, "C");
    $oPdf->Cell(8, $iAlturaLinha, '', 1, 0, "C");
    $oPdf->Cell(50, $iAlturaLinha, '', 1, 0, "C");
    $oPdf->Cell(10, $iAlturaLinha, '', 1, 0, "C");
    $oPdf->Cell(50, $iAlturaLinha, '', 1, 0, "C");
    $oPdf->Cell(10, $iAlturaLinha, '', 1, 0, "C");
    $oPdf->Cell(8, $iAlturaLinha, '', 1, 0, "C");
    $oPdf->Cell(25, $iAlturaLinha, '', 1, 1, "C");
  }
}

function desenharCabecalho(scpdf $oPdf, Turma $oTurma, Escola $oEscola, $iAlturaLinha)
{

  $sNomeEscola       = $oEscola->getNome();
  $iCodigoReferencia = $oEscola->getCodigoReferencia();

  if ($iCodigoReferencia != null) {
    $sNomeEscola = "{$iCodigoReferencia} - {$sNomeEscola}";
  }

  $oDepartamento = new DBDepartamento(db_getsession("DB_coddepto"));
  $iDepartamento = $oDepartamento->getCodigo();


  $result = db_query("select ed05_t_texto,ed05_d_publicado,ed05_i_aparecerelatorio,ed05_i_ano,ed05_i_codigo, ed05_c_numero, ed05_c_finalidade, ed83_c_descr as dl_tipo,
  case when ed05_c_competencia='F' then 'FEDERAL' when ed05_c_competencia='E' then 'ESTADUAL' else 'MUNICIPAL'
  end as ed05_c_competencia, ed05_i_ano from atolegal inner join tipoato on tipoato.ed83_i_codigo
  = atolegal.ed05_i_tipoato inner join atoescola on atoescola.ed19_i_ato = atolegal.ed05_i_codigo
  where ed19_i_escola = $iDepartamento and ed05_i_aparecerelatorio = true order by ed05_i_codigo ;");

  $atolegal = db_utils::fieldsMemory($result, 0);

  if ($atolegal->ed05_c_finalidade == "") {
    $atolegalcabecalho = "";
  } else {
    $atolegalcabecalho = $atolegal->ed05_c_finalidade . "/" . $atolegal->dl_tipo . " nº: " .  $atolegal->ed05_c_numero . " DE " . implode("/", array_reverse(explode("-", $atolegal->ed05_d_publicado))) . ", " . $atolegal->ed05_t_texto;
  }



  $iAnoCalendario    = $oTurma->getCalendario()->getAnoExecucao();
  $oPdf->SetFont("arial", 'b', 8);
  $oPdf->Cell($oPdf->w - 20, $iAlturaLinha, $sNomeEscola, "B", 1, "L");
  $oPdf->Cell($oPdf->w - 20, $iAlturaLinha, $atolegalcabecalho, "B", 1, "L");

  $oPdf->Cell(270, $iAlturaLinha, "LISTAGEM POR TURMA PARA REGISTRO", 0, 1, "C");
  $oPdf->SetFont("arial", 'b', 8);
  $oPdf->Cell(10, $iAlturaLinha, "Turno:", 0, 0, "L");
  $oPdf->SetFont("arial", '', 8);
  $oPdf->Cell(70, $iAlturaLinha, $oTurma->getTurno()->getDescricao(), 0, 0, "L");
  $oPdf->SetFont("arial", 'b', 8);
  $oPdf->Cell(10, $iAlturaLinha, "Curso:", 0, 0, "L");
  $oPdf->SetFont("arial", '', 8);
  $oPdf->Cell(80, $iAlturaLinha, $oTurma->getBaseCurricular()->getCurso()->getNome(), 0, 0, "L");
  $oPdf->SetFont("arial", 'b', 8);
  $oPdf->Cell(12, $iAlturaLinha, "Turma:", 0, 0, "L");
  $oPdf->SetFont("arial", '', 8);
  $oPdf->Cell(80, $iAlturaLinha, $oTurma->getDescricao(), 0, 0, "L");
  $oPdf->SetFont("arial", 'b', 8);
  $oPdf->Cell(8, $iAlturaLinha, "Ano:", 0, 0, "L");
  $oPdf->SetFont("arial", '', 8);
  $oPdf->Cell(50, $iAlturaLinha, $iAnoCalendario, 0, 1, "L");

  $oPdf->SetFont("arial", 'b', 8);
  $oPdf->Cell(12, $iAlturaLinha,                       "Código", 1, 0, "C");
  $oPdf->Cell(5, $iAlturaLinha,                           "Nº", 1, 0, "C");
  $oPdf->Cell(90, $iAlturaLinha,                         "Nome", 1, 0, "C");
  $oPdf->Cell(10, $iAlturaLinha,                        "Horas", 1, 0, "C");
  $oPdf->Cell(8, $iAlturaLinha,                         "Sexo", 1, 0, "C");
  $oPdf->Cell(50, $iAlturaLinha,                "Escola Origem", 1, 0, "C");
  $oPdf->Cell(10, $iAlturaLinha,                         "Data", 1, 0, "C");
  $oPdf->Cell(50, $iAlturaLinha,               "Escola Destino", 1, 0, "C");
  $oPdf->Cell(10, $iAlturaLinha,                         "Data", 1, 0, "C");
  $oPdf->Cell(8, $iAlturaLinha,                        "Idade", 1, 0, "C");
  $oPdf->Cell(25, $iAlturaLinha, "Ret Transf {$iAnoCalendario}", 1, 1, "C");
  $oPdf->SetFont("arial", '', 6);
}

$oPdf->Output();
