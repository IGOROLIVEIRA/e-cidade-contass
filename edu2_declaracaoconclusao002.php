<?php
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

require_once("fpdf151/pdfwebseller.php");
require_once("libs/db_stdlibwebseller.php");
require_once("libs/db_utils.php");
require_once("libs/JSON.php");
require_once("libs/db_libdocumento.php");
require_once("std/db_stdClass.php");
include("edu_cabecalhoatolegal.php");

$clmatricula       = new cl_matricula;
$clserie           = new cl_serie;
$oDaoPeriodoEscola = new cl_periodoescola;

$oJson       = new services_json();
$oParametros = new stdClass();
$oGet        = db_utils::postMemory($_GET);

$oParametros->aMatriculas      = $oJson->decode(str_replace("\\", "", $oGet->aMatriculas));

$oParametros->lExibeGradeAluno = $oGet->lExibeGradeAluno == 'S' ? true : false;
$oParametros->iAlturaLinha     = 4;

$oParametros->sObservacao = "";

if (trim($oGet->sObservacao) != '') {
  $oParametros->sObservacao = trim(db_stdClass::db_stripTagsJsonSemEscape($oGet->sObservacao));
}

$oTurma = TurmaRepository::getTurmaByCodigo($oGet->iTurma);

$aParagrafos  = array();
$aDadosAlunos = array();

foreach ($oParametros->aMatriculas as $oMat) {


  $oParagrafo = new libdocumento(5009);
  $oMatricula = new Matricula($oMat->iMatricula);

  $oParagrafo->aluno                    = $oMatricula->getAluno()->getNome();
  $oParagrafo->etapa                    = $oMatricula->getEtapaDeOrigem()->getNome();
  $oParagrafo->turma                    = $oMatricula->getTurma()->getDescricao();
  $oParagrafo->curso                    = $oMatricula->getTurma()->getBaseCurricular()->getCurso()->getNome();
  $oParagrafo->dia_conclusao            = substr($oGet->sData,0,2);
  $oParagrafo->mes_conclusao            = substr($oGet->sData,3,2);
  $oParagrafo->nome_mes_conclusao       = db_mes($oParagrafo->mes_conclusao,1);
  $oParagrafo->ano_conclusao            = substr($oGet->sData,6,4);
  $oParagrafo->ensino = $oMatricula->getTurma()->getBaseCurricular()->getCurso()->getEnsino()->getNome();

  try {

    $oDataNascimento                    = new DBDate($oMatricula->getAluno()->getDataNascimento());
    $oParagrafo->dia_nascimento         = $oDataNascimento->getDia();
    $oParagrafo->mes_nascimento         = DBDate::getMesExtenso((int)$oDataNascimento->getMes());
    $oParagrafo->mes_numeral_nascimento = $oDataNascimento->getMes();
    $oParagrafo->ano_nascimento         = $oDataNascimento->getAno();
  } catch (Exception $oErro) {

    $oParagrafo->dia_nascimento         = "";
    $oParagrafo->mes_nascimento         = "";
    $oParagrafo->mes_numeral_nascimento = "";
    $oParagrafo->ano_nascimento         = "";
  }
  
  $aFiliacao                          = array();

  if ($oMatricula->getAluno()->getNomeMae() != '') {
    $aFiliacao[] = $oMatricula->getAluno()->getNomeMae();
  }
  if ($oMatricula->getAluno()->getNomePai() != '') {
    $aFiliacao[] = $oMatricula->getAluno()->getNomePai();
  }

  $oParagrafo->naturalidade         = $oMatricula->getAluno()->getNaturalidade()->getNome();
  $oParagrafo->estado_naturalidade  = "";
  $oParagrafo->uf_naturalidade      = "";

  if (!empty($oParagrafo->naturalidade)) {

    $oParagrafo->estado_naturalidade  = $oMatricula->getAluno()->getNaturalidade()->getUF()->getNomeEstado();
    $oParagrafo->uf_naturalidade      = $oMatricula->getAluno()->getNaturalidade()->getUF()->getUF();
  }
  $oParagrafo->filiacao               = implode(' e ', $aFiliacao);
  $aParagrafos[]                        = $oParagrafo->getDocParagrafos();

  $oDadosAlunos                         = new stdClass();
  $oDadosAlunos->aParagrafo             = $oParagrafo->getDocParagrafos();
  $aDadosAlunos[]                       = $oDadosAlunos;
}

if (count($aParagrafos) == 0) {
  db_redireciona("db_erros.php?fechar=true&db_erro=" . _M('educacao.escola.edu2_atestadofrequencia.matricula_nao_encontrada'));
}

$dados1 = db_query($conn, "select ed18_c_nome,
                                  j14_nome,
                                  ed18_i_numero,
                                  j13_descr,
                                  ed261_c_nome,
                                  ed260_c_sigla,
                                  ed18_c_email,
                                  ed18_c_logo,
                                  ed18_codigoreferencia
                           from escola
                           inner join bairro  on  bairro.j13_codi = escola.ed18_i_bairro
                           inner join ruas  on  ruas.j14_codigo = escola.ed18_i_rua
                           inner join db_depart  on  db_depart.coddepto = escola.ed18_i_codigo
                           inner join censouf  on  censouf.ed260_i_codigo = escola.ed18_i_censouf
                           inner join censomunic  on  censomunic.ed261_i_codigo = escola.ed18_i_censomunic
                           left join ruascep on ruascep.j29_codigo = ruas.j14_codigo
                           left join logradcep on logradcep.j65_lograd = ruas.j14_codigo
                           left join ceplogradouros on ceplogradouros.cp06_codlogradouro = logradcep.j65_ceplog
                           left join ceplocalidades on ceplocalidades.cp05_codlocalidades = ceplogradouros.cp06_codlocalidade
                           where ed18_i_codigo = " . db_getsession("DB_coddepto"));

$cidadeescola = trim($dados1, 0, "ed261_c_nome");
$estadoescola = trim($dados1, 0, "ed260_c_sigla");

$atualEtapa = $clmatricula->sql_record($clmatricula->sql_query_alunomatriculado(null,
                                                                                "ed11_i_codigo codigo,
                                                                                 ed11_i_sequencia sequencia,
                                                                                 ed11_i_ensino ensino",
                                                                                null,
                                                                                " ed60_i_codigo = {$oMat->iMatricula}"
                                                                               ));
db_fieldsmemory($atualEtapa,0);

$proxEtapa = $clserie->sql_record($clserie->sql_query_file("",
                                                           "serie.ed11_c_descr as proximaetapa",
                                                           null,
                                                           "ed11_i_sequencia = (select ed11_i_sequencia
                                                                                from serie
                                                                                where ed11_i_codigo = {$codigo})+1
                                                                                    and ed11_i_ensino = {$ensino}"
                                                          ));
db_fieldsmemory($proxEtapa,0);

$oPdf = new PDF();
$oPdf->AliasNbPages();
$oPdf->setFillColor(220);
$oPdf->Open();
$oPdf->SetAutoPageBreak(false, 10);
$head1 = "DECLARAÇÃO DE TRANSFERÊNCIA";

if (db_getsession("DB_modulo") != 1100747) {

  $aTelefones = $oTurma->getEscola()->getTelefones();
  $head2      = "Escola: {$oTurma->getEscola()->getNome()}";

  if (count($aTelefones) > 0) {

    $head3 = "Telefone: {$aTelefones[0]->iDDD} {$aTelefones[0]->iNumero}";
  }
}

$sObservacao  = $oParametros->sObservacao;
foreach ($aDadosAlunos as $oDadosAlunos) {

  $oPdf->addpage("P");

  $sTexto        = $oDadosAlunos->aParagrafo[1]->oParag->db02_texto;
  $oDepartamento = new DBDepartamento(db_getsession("DB_coddepto"));
  $iDepartamento = $oDepartamento->getCodigo();
  $sDepartamento = $oDepartamento->getNomeDepartamento();
  
  $sTexto        = "Declaro para os devidos fins que se fizerem necessários que o(a) aluno(a) {$oParagrafo->aluno} natural de {$oParagrafo->naturalidade} no estado de {$oParagrafo->estado_naturalidade}, nascido(a) em {$oParagrafo->dia_nascimento} de {$oParagrafo->mes_nascimento} do ano de {$oParagrafo->ano_nascimento}, filho(a) de {$oParagrafo->filiacao} concluiu em {$oParagrafo->dia_conclusao} de {$oParagrafo->nome_mes_conclusao} de {$oParagrafo->ano_conclusao}, o(a) {$oParagrafo->etapa} do(a) {$oParagrafo->curso} nesta escola, estando apto a matricular-se no {$proximaetapa} do {$oParagrafo->curso}, conforme legislação vigente.";

  $oPdf->setfont('arial', 'b', 12);
  $oPdf->SetY($oPdf->getY() + 10);
  $oPdf->Cell(192, $oParametros->iAlturaLinha, "Declaração de Transferência", 0, 1, "C");
  $oPdf->Ln($oParametros->iAlturaLinha * 15); //modifica a posicao do paragrafo no relatório

  $oPdf->setfont('arial', '', 10);
  $oPdf->setXY(16, $oPdf->GetY());
  $oPdf->multicell(180, $oParametros->iAlturaLinha, $sTexto, 0, "J", 0, 0);
  $oPdf->Ln($oParametros->iAlturaLinha * 2);
  $oPdf->setXY(16, $oPdf->GetY());

  $oParametros->sObservacao = '';
  if (!empty($oDadosAlunos->sObservacaoMatricula)) {
    $oParametros->sObservacao = "{$oDadosAlunos->sObservacaoMatricula}\n{$sObservacao}";
  } else if (empty($sObservacao)) {
    $oParametros->sObservacao = "";
  } else {
    $oParametros->sObservacao = $sObservacao;
  }

  if ($oParametros->sObservacao != "") {
    $oPdf->multicell(180, $oParametros->iAlturaLinha, "OBS.: {$oParametros->sObservacao}", 0, "J", 0, 0);
  }


  $oPdf->Ln($oParametros->iAlturaLinha * 2);

  $oDiaAtual   = new DBDate(date("Y-m-d"));
  $sMunicipio  = $oTurma->getEscola()->getDepartamento()->getInstituicao()->getMunicipio();

  $DiaExtenso  = " {$sMunicipio}, " . $oDiaAtual->getDia() . " de " . DBDate::getMesExtenso((int)$oDiaAtual->getMes());
  $DiaExtenso .= "  de " . $oDiaAtual->getAno();


  $oPdf->Cell(192, $oParametros->iAlturaLinha, $DiaExtenso, 0, 1, "C");

  $oPdf->Ln($oParametros->iAlturaLinha * 4);


  $oPdf->Line(50, $oPdf->GetY(), 152, $oPdf->GetY());
  $oPdf->Ln(1);
  $oPdf->Cell("192", $oParametros->iAlturaLinha, "Diretor (a) nº Aut. ou Secretário (a) Escolar nº Aut.", 0, 1, "C");

  /**
   * Calculo para verificar se os dados da assinatura caberão na pagina atual
   */
  if ($oPdf->GetY() + 40 > $oPdf->h - 15) {
    $oPdf->AddPage();
  }

  $oPdf->SetY($oPdf->h - 40);

  $oPdf->ln($oParametros->iAlturaLinha);

}

$oPdf->Output();
