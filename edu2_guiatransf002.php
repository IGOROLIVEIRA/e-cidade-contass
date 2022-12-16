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
require_once("fpdf151/pdfwebseller.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_stdlibwebseller.php");
require_once("libs/db_libdocumento.php");
require_once("dbforms/db_funcoes.php");
include("edu_cabecalhoatolegal.php");

$cltransfescolarede       = new cl_transfescolarede;
$cltransfescolafora       = new cl_transfescolafora;
$clescoladiretor          = new cl_escoladiretor;
$cldiarioavaliacao        = new cl_diarioavaliacao;
$clprocavaliacao          = new cl_procavaliacao;
$clmatricula              = new cl_matricula;
$clserie                  = new cl_serie;
$clprogressaoparcialaluno = new cl_progressaoparcialaluno();
$escola                   = db_getsession("DB_coddepto");
$resultedu                = eduparametros(db_getsession("DB_coddepto"));

if ($diretor == "") {

  $nome      = "Diretor(a) ou Secretário(a) Escolar nº Reg ou Aut.";

}

if ($tipo == "TR") {

  $campos  = " ed47_c_bolsafamilia,ed47_i_codigo,ed47_v_nome,ed47_d_nasc, ";
  $campos .= " censomunicnat.ed261_c_nome as ed47_i_censomunicnat,censoufnat.ed260_c_sigla as ed47_i_censoufnat, ";
  $campos .= " ed47_v_pai,ed47_v_mae,ed103_d_data as data_transf,ed11_c_descr as descr_serie, ";
  $campos .= " ed10_c_descr as descr_ensino,ed10_c_abrev as abrev_ensino,ed103_t_obs as obs_transf, ";
  $campos .= " ed60_i_turma as turmaorigem,ed57_c_descr as descr_turma,";
  $campos .= " censomunic.ed261_c_nome as cidade,ed60_c_parecer as neeparecer,ed103_i_matricula as codigomatricula,";
  $campos .= " (SELECT ed29_c_descr || ' - ' || ed10_c_abrev ";
  $campos .= "     from turma ";
  $campos .= "         inner join base     on ed31_i_codigo = ed57_i_base ";
  $campos .= "         inner join cursoedu on ed29_i_codigo = ed31_i_curso  ";
  $campos .= "         inner join ensino   on ed10_i_codigo = ed29_i_ensino  ";
  $campos .= "   where ed57_i_codigo = ed60_i_turma) as descr_ensino_anterior,";
  $campos .= " calendario.ed52_i_codigo, escoladestino.ed18_c_nome as escola_destino";
  $result  = $cltransfescolarede->sql_record($cltransfescolarede->sql_query("",
                                                                            $campos,
                                                                            "to_ascii(ed47_v_nome)",
                                                                            " ed103_i_codigo in ($alunos)"
                                                                           )
                                            );
  $linhas  = $cltransfescolarede->numrows;
} else if ($tipo == "TF") {

  $campos  = " ed47_c_bolsafamilia,ed47_i_codigo,ed47_v_nome,ed47_d_nasc, ";
  $campos .= " censomunicnat.ed261_c_nome as ed47_i_censomunicnat,censoufnat.ed260_c_sigla as ed47_i_censoufnat, ";
  $campos .= " ed47_v_pai,ed47_v_mae,ed104_d_data as data_transf,ed104_t_obs as obs_transf, ";
  $campos .= " censomunic.ed261_c_nome as cidade,ed104_i_matricula as codigomatricula, ";
  $campos .= " escolaproc.ed82_i_codigo as escola_destino,ed104_c_concletapa";
  $result  = $cltransfescolafora->sql_record($cltransfescolafora->sql_query("",
                                                                            $campos,
                                                                            "to_ascii(ed47_v_nome)",
                                                                            " ed104_i_codigo in ($alunos)"
                                                                           )
                                            );
  $linhas  = $cltransfescolafora->numrows;
}
if ($linhas == 0) {?>

 <table width='100%'>
  <tr>
   <td align='center'>
    <font color='#FF0000' face='arial'>
     <b>Nenhuma registro encontrado.<br>
     <input type='button' value='Fechar' onclick='window.close()'></b>
    </font>
   </td>
  </tr>
 </table>
 <?
 exit;
}

$head1 = "GUIA DE TRANSFERÊNCIA";
$pdf   = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
for ($x=0;$x<$linhas;$x++) {

  db_fieldsmemory($result,$x);
  $pdf->addpage("P");
  if ($tipo == "TF") {

  	$campos      = " ed47_i_codigo, ed47_c_bolsafamilia, serie.ed11_i_codigo codigo, serie.ed11_c_descr as descr_serie, ";
  	$campos     .= " ensino.ed10_c_descr as descr_ensino, ed10_c_abrev as abrev_ensino,ed11_i_ensino ensino, ";
  	$campos     .= " matricula.ed60_i_turma as turmaorigem, turma.ed57_c_descr as descr_turma, ";
  	$campos     .= " matricula.ed60_c_parecer as neeparecer,";
  	$campos     .= " calendario.ed52_i_codigo";
    $result_matr = $clmatricula->sql_record($clmatricula->sql_query("",
                                                                    $campos,
                                                                    "",
                                                                    " ed60_i_codigo = $codigomatricula"
                                                                   )
                                                                 );
    db_fieldsmemory($result_matr,0);

    $result_serieseg = $clserie->sql_record($clserie->sql_query_file("",
                                                                     "serie.ed11_c_descr as serie_seg",
                                                                     null,
                                                                     "ed11_i_sequencia = (select ed11_i_sequencia from serie where ed11_i_codigo = {$codigo})+1 and ed11_i_ensino = {$ensino}"
                                                                     )
                                                                    );

    db_fieldsmemory($result_serieseg,0);

  }

  $dia_nasc             = substr($ed47_d_nasc,8,2);
  $mes_nasc             = substr($ed47_d_nasc,5,2);
  $ano_nasc             = substr($ed47_d_nasc,0,4);
  $dia_transf           = substr($data_transf,8,2);
  $mes_transf           = substr($data_transf,5,2);
  $ano_transf           = substr($data_transf,0,4);
  $ed47_i_censomunicnat = $ed47_i_censomunicnat!=""?$ed47_i_censomunicnat:".........................................
                                                                           ........................";
  $ed47_i_censoufnat    = $ed47_i_censoufnat!=""?$ed47_i_censoufnat:".........";

  $pdf->setfont('arial', 'b', 10);
  $pdf->multicell(192, 1,  "","LRT", "C", 0, 0);
  $pdf->multicell(192, 120, "Declaração de Transferência", "LR",  "C", 0, 0);
  $pdf->setfont('arial', '', 9);

  $aFiliacao = array();

  if ($ed47_v_mae != '') {
    $aFiliacao[] = $ed47_v_mae;
  }
  if ($ed47_v_pai != '') {
    $aFiliacao[] = $ed47_v_pai;
  }

  $sEtapa  = $descr_serie;
  $sEtapaSeg = $serie_seg;
  $sEnsino =  "{$descr_ensino}";

  unset($sTexto);
  $oParagrafo                         = new libdocumento(5010);
  $oParagrafo->nome_aluno             = $ed47_v_nome;
  $oParagrafo->municipio_naturalidade = $ed47_i_censomunicnat;
  $oParagrafo->estado_naturalidade    = $ed47_i_censoufnat;
  $oParagrafo->dia_nascimento         = $dia_nasc;
  $oParagrafo->mes_nascimento         = db_mes($mes_nasc,1);
  $oParagrafo->ano_nascimento         = $ano_nasc;
  $oParagrafo->filiacao               = implode(' e ', $aFiliacao);
  $oParagrafo->dia_transferencia      = $dia_transf;
  $oParagrafo->mes_transferencia      = db_mes($mes_transf,1);
  $oParagrafo->ano_transferencia      = $ano_transf;
  $oParagrafo->etapa                  = $sEtapa;
  $oParagrafo->ensino                 = $sEnsino;

  $oDadosAlunos                       = new stdClass();
  $oDadosAlunos->aParagrafo           = $oParagrafo->getDocParagrafos();

  if($ed104_c_concletapa == 2){
    $sTexto = "Declaro para os devidos fins que se fizerem necessários que o(a) aluno(a) {$oParagrafo->nome_aluno} natural de {$oParagrafo->municipio_naturalidade}, no estado de {$oParagrafo->estado_naturalidade}, nascido(a) aos {$oParagrafo->dia_nascimento} de {$oParagrafo->mes_nascimento} do ano de {$oParagrafo->ano_nascimento}, filho(a) de {$oParagrafo->filiacao} concluiu em {$oParagrafo->dia_transferencia} de {$oParagrafo->mes_transferencia} de {$oParagrafo->ano_transferencia}, o(a) {$oParagrafo->etapa} do(a) {$oParagrafo->ensino} nesta escola, estando apto a matricular-se no {$sEtapaSeg} do(a) {$oParagrafo->ensino}, conforme legislação vigente.";
  } else{
    $sTexto = "Declaro para os devidos fins que se fizerem necessários que o(a) aluno(a) {$oParagrafo->nome_aluno} natural de {$oParagrafo->municipio_naturalidade}, no estado de {$oParagrafo->estado_naturalidade}, nascido(a) aos {$oParagrafo->dia_nascimento} de {$oParagrafo->mes_nascimento} do ano de {$oParagrafo->ano_nascimento}, filho(a) de {$oParagrafo->filiacao} cursou até {$oParagrafo->dia_transferencia} de {$oParagrafo->mes_transferencia} de {$oParagrafo->ano_transferencia}, o(a) {$oParagrafo->etapa} do(a) {$oParagrafo->ensino} nesta escola, estando apto a continuar seus estudos em qualquer instituição de ensino, conforme legislação vigente.";
  }
  $altY   = $pdf->getY();

  $pdf->cell(6, 30, "", "L", 0, "R", 0);
  $pdf->setXY(16,140);
  $pdf->multicell(180, 4, $sTexto, 0, "J", 0, 0);
  $pdf->setXY(196, $altY);
  $pdf->cell(6, 30, "", "R", 1, "R", 0);

  $altY = $pdf->getY();

  $pdf->cell(6, 15, "", "L", 0, "R", 0);
  $pdf->setXY(16,$altY);

  if ($bolsafamilia == 1) {
    $bolsa = "";
  } else {

   if ($ed47_c_bolsafamilia == "S") {
     $bolsa = "Bolsa Família Ativa";
   }else{
     $bolsa = "";
   }
 }

 $pdf->SetX(10);
 $pdf->setfillcolor(225);

 $iAno              = db_getsession("DB_anousu");
 $sSqlAnoCalendario = $clmatricula->sql_query($codigomatricula, "calendario.ed52_i_ano");
 $rsAnoCalendario   = $clmatricula->sql_record($sSqlAnoCalendario);

 if ($rsAnoCalendario && $clmatricula->numrows > 0) {
   $iAnoCalendario = db_utils::fieldsMemory($rsAnoCalendario, 0)->ed52_i_ano;
 }

 /**
  * Variáveis para controle da impressão da observação, limitando os caracteres impressos até determinado limite da
  * página
  */
 $iPosicaoYObservacao = 76;
 $iDiferencaLinhas    = $pdf->GetY() - $iPosicaoYObservacao;
 $iLimiteLinhas       = 38 - ($iDiferencaLinhas / 4);
 $iCaracteresLinha    = 82;
 $iLimiteCaracteres   = $iCaracteresLinha * $iLimiteLinhas;

 /**
  * Busca informações sobre progressão parcial caso exista para jogar junto as observações.
  */
  $sCampoProgressaoParcialAluno  = 'ed232_c_descr, ed114_ano, ed11_c_descr';
  $sWhereProgressaoParcialAluno  = "     ed114_aluno = {$ed47_i_codigo}";
  $sWhereProgressaoParcialAluno .= " and ed114_situacaoeducacao = " . ProgressaoParcialAluno::ATIVA;
  $sSqlProgressaoParcialAluno = $clprogressaoparcialaluno->sql_query_aluno_em_progressao(
                                                                                          null,
                                                                                          $sCampoProgressaoParcialAluno,
                                                                                          'ed114_ano',
                                                                                          $sWhereProgressaoParcialAluno
                                                                                        );

  $rsProgressaoParcialAluno = $clprogressaoparcialaluno->sql_record($sSqlProgressaoParcialAluno);

  $aDisciplinas = array();
  for ($iContProgressaoAluno = 0; $iContProgressaoAluno < $clprogressaoparcialaluno->numrows; $iContProgressaoAluno++) {

    $oProgressaoParcialAluno = db_utils::fieldsMemory($rsProgressaoParcialAluno, $iContProgressaoAluno);

    $sIndice = $oProgressaoParcialAluno->ed114_ano.'->'.$oProgressaoParcialAluno->ed11_c_descr;

    if (array_key_exists($sIndice, $aDisciplinas)) {
      $aDisciplinas[$sIndice] .= $oProgressaoParcialAluno->ed232_c_descr.'   ';
    } else {
      $aDisciplinas[$sIndice] = $oProgressaoParcialAluno->ed232_c_descr.'   ';
    }
  }

  $sObsProgressaoParcialAluno = '';
  $lQuebraLinha               = true;

  foreach ($aDisciplinas as $sIndice => $sDisciplina) {

    $aIndice = explode("->", $sIndice);
    $sDisciplina = trim($sDisciplina);
    $sDisciplina = str_replace('   ', ', ', $sDisciplina);

    if ($lQuebraLinha) {

      $lQuebraLinha                = false;
      $sObsProgressaoParcialAluno  = "O aluno possui progressão na etapa {$aIndice[1]} no ano {$aIndice[0]}";
      $sObsProgressaoParcialAluno .= " nas disciplinas {$sDisciplina}.";
    } else {
      $sObsProgressaoParcialAluno .= "\nna etapa {$aIndice[1]} no ano {$aIndice[0]} nas disciplinas {$sDisciplina}.";
    }
  }

 $oCalendario = CalendarioRepository::getCalendarioByCodigo($ed52_i_codigo);
 $sDataInicio = $oCalendario->getDataInicio()->getDate('d/m/Y');
 $sDataFim    = $oCalendario->getDataFinal()->getDate('d/m/Y');

 $sEscolaDestino = $escola_destino;
 if ($tipo == 'TF') {
   $oEscola        = new EscolaProcedencia($escola_destino);
   $sEscolaDestino = $oEscola->getNome();
 }

 $completar = 240 - $pdf->getY();
 $pdf->multicell(192, $completar, "", "LR", "J", 0, 0);
 $pdf->multicell(192, 4, "{$cidade}, {$dia_transf} de ".db_mes($mes_transf,1)." de {$ano_transf}.", "LR", "C", 0, 0);
 $pdf->multicell(192, 8, "", "LR", "C", 0, 0);
 $pdf->multicell(192, 4, "___________________________________________________", "LR", "C", 0, 0);
 $pdf->multicell(192, 4, $nome, "LR", "C", 0, 0);
 $pdf->multicell(192, 4, $funcao, "LR", "C", 0, 0);
 $pdf->multicell(192, 6, "", "LRB", "C", 0, 0);
}

$pdf->Output();