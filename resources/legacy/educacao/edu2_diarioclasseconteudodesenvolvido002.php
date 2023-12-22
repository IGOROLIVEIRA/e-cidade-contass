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

require_once("fpdf151/scpdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");
require_once("std/DBDate.php");
require_once("model/educacao/avaliacao/iFormaObtencao.interface.php");
require_once("model/educacao/avaliacao/iElementoAvaliacao.interface.php");
require_once("model/CgmFactory.model.php");

db_app::import("educacao.*");
db_app::import("educacao.avaliacao.*");
db_app::import("exceptions.*");

$oGet        = db_utils::postMemory($_GET);
$oPdf        = new scpdf('L');
$oEscola     = new Escola($oGet->escola);
$oTurma      = TurmaRepository::getTurmaByCodigo($oGet->turma);
$oCalendario = new Calendario($oGet->calendario);
$aEtapas     = $oTurma->getEtapas();

$aDisciplinas = array();
$oGet->disciplinas = trim($oGet->disciplinas);
if (!empty($oGet->disciplinas)) {
	$aDisciplinas = explode(",", trim($oGet->disciplinas));
}

$oPeriodoAvaliacao = null;

$sNomeEscola       = $oEscola->getNome();
$iCodigoReferencia = $oEscola->getCodigoReferencia();

if ($iCodigoReferencia != null) {
	$sNomeEscola = "{$iCodigoReferencia} - {$sNomeEscola}";
}

$oDadosCabecalho               = new stdClass();
$oDadosCabecalho->sEscola      = $sNomeEscola;
$oDadosCabecalho->iAnoExecucao = $oCalendario->getAnoExecucao();

$oDadosCabecalho->sTurma       = $oTurma->getDescricao();
$oDadosCabecalho->sTurno       = $oTurma->getTurno()->getDescricao();
$oDadosCabecalho->sPeriodo     = '';
$oDadosCabecalho->iPaginas     = $oGet->paginas;
$oDadosCabecalho->sTitulo      = "Conteúdos Desenvolvidos";

/**
 * Como o código recebido pela tela, no caso do registro de ocorrência era da AvaliacaoPeroidica
 * e não o próprio PeriodoAvaliação, foi necessário fazer esta validação para buscar o valor correto.
 */
if ($oGet->lRegistroOcorrencia == "true") {

	$oDadosCabecalho->sTitulo = "Registro de Ocorrências";
	$oAvaliacaoPeriodica      = new AvaliacaoPeriodica($oGet->periodo);
	$oPeriodoAvaliacao        = $oAvaliacaoPeriodica->getPeriodoAvaliacao();
} else {
	$oPeriodoAvaliacao         = new PeriodoAvaliacao($oGet->periodo);
}

$oDadosCabecalho->sPeriodo = $oPeriodoAvaliacao->getDescricao();

$oDaoBimestre = db_utils::getDao('periodocalendario');
$sWhere       = " ed53_i_periodoavaliacao = {$periodo} and ed53_i_calendario = {$calendario}";
$sCampos	  = " ed53_d_inicio inicio,ed53_d_fim fim";
$sSqlBimestre = $oDaoBimestre->sql_query_file(null, $sCampos, null, $sWhere); //print_r($sSqlBimestre);die;
$rsBimestre  = $oDaoBimestre->sql_record($sSqlBimestre);

$datasBim = db_utils::fieldsMemory($rsBimestre,0); //var_dump($datasBim);die;

$oPdf->Open();
$oPdf->SetAutoPageBreak(false);
$oPdf->SetFillColor(230);

/**
 * Percorre as disciplinas selecionadas nos filtros.
 */
if (count($aDisciplinas) > 0) {

	foreach ($aDisciplinas as $iRegencia) {

		$oRegencia                        = RegenciaRepository::getRegenciaByCodigo($iRegencia);

        $oDadosCabecalho->sNomeDisciplina = $oRegencia->getDisciplina()->getNomeDisciplina();
        $oDadosCabecalho->sEtapa       = $oRegencia->getEtapa()->getNome();

		$oDadosCabecalho->sNomeProfessor = '';
		if (count($oRegencia->getDocentes()) > 0) {

			foreach ($oRegencia->getDocentes() as $oDocente) {

				$oDadosCabecalho->sNomeProfessor = $oDocente->getNome();
				break;
			}
		}

		/**
		 * Busca os conteúdos desenvolvidos por disciplina quando for selecionado para ser lançado conforme diário.
		 */
		$aConteudoDesenvolvido = array();
		if ($oGet->preenchimento == 'diario') {
			$aConteudoDesenvolvido = buscaConteudoDesenvolvidoDiario($oRegencia,$datasBim);
		}


		switch ($oGet->preenchimento) {

			case "manual":

				imprimeManual($oPdf, $oDadosCabecalho);
				break;
			case "diario":

				imprimeDiario($oPdf, $aConteudoDesenvolvido, $oDadosCabecalho);
				break;
		}
	}
} else {
	imprimeManual($oPdf, $oDadosCabecalho);
}

/**
 * Imprime cabecalho do relatório.
 * @param Fpdf $oPdf
 * @param stdClass $oDadosCabecalho dados do cabecalho
 */
function imprimeCabecalho($oPdf, $oDadosCabecalho)
{

	$oDepartamento = new DBDepartamento(db_getsession("DB_coddepto"));
	$iDepartamento = $oDepartamento->getCodigo();

	$result = db_query("select ed05_t_texto,
							   ed05_d_publicado,
							   ed05_i_aparecerelatorio,
							   ed05_i_ano,
							   ed05_i_codigo,
							   ed05_c_numero,
							   ed05_c_finalidade,
							   ed83_c_descr as dl_tipo,
							   case
							   		when ed05_c_competencia='F' then 'FEDERAL'
									when ed05_c_competencia='E' then 'ESTADUAL'
									else 'MUNICIPAL'
							   end as ed05_c_competencia,
							   ed05_i_ano from atolegal
						inner join tipoato on tipoato.ed83_i_codigo = atolegal.ed05_i_tipoato
						inner join atoescola on atoescola.ed19_i_ato = atolegal.ed05_i_codigo
						where ed19_i_escola = $iDepartamento
							and ed05_i_aparecerelatorio = true
						order by ed05_i_codigo ;");

	$atolegal = db_utils::fieldsMemory($result, 0);

	if ($atolegal->ed05_c_finalidade == "") {
		$atolegalcabecalho = "";
	} else {
		$atolegalcabecalho = $atolegal->ed05_c_finalidade . "/" . $atolegal->dl_tipo . " nº: " .  $atolegal->ed05_c_numero . " DE " . implode("/", array_reverse(explode("-", $atolegal->ed05_d_publicado)));
	}

	$oPdf->AddPage();

	$oPdf->SetFont('arial', 'b', 10);

	$oPdf->Cell(290, 4, mb_strtoupper($oDadosCabecalho->sTitulo) . " - {$oDadosCabecalho->sPeriodo}", 0, 1, "C");
	$oPdf->Cell(290, 4, $oDadosCabecalho->sEscola, 0, 1, "C");
	$oPdf->Cell(290, 4, $atolegalcabecalho, 0, 1, "C");

	$oPdf->Ln();
	$oPdf->SetFont('arial', 'b', 8);
	$oPdf->Cell(40,  4, "", 0, 0, "L");
	$oPdf->Cell(20,  4, "Ano Letivo:", 0, 0, "L");
	$oPdf->Cell(20,  4, $oDadosCabecalho->iAnoExecucao, 0, 0, "L");
	$oPdf->Cell(20,  4, "Etapa:", 0, 0, "R");
	$oPdf->Cell(30,  4, $oDadosCabecalho->sEtapa, 0, 0, "L");
	$oPdf->Cell(15,  4, "Turma:", 0, 0, "R");
	$oPdf->Cell(80,  4, $oDadosCabecalho->sTurma, 0, 0, "L");
	$oPdf->Cell(15,  4, "Turno:", 0, 0, "C");
	$oPdf->Cell(30,  4, $oDadosCabecalho->sTurno, 0, 1, "L");

	if (isset($oDadosCabecalho->sNomeDisciplina)) {

		$oPdf->Cell(16,  4, "Disciplina:", 0, 0, "L");
		$oPdf->Cell(175, 4, $oDadosCabecalho->sNomeDisciplina, 0, 0, "L");
		$oPdf->Cell(30,  4, "Professor:", 0, 0, "R");
		$oPdf->Cell(30,  4, $oDadosCabecalho->sNomeProfessor, 0, 0, "L");
	}

	$oPdf->Ln();
	$oPdf->Ln();
}

/**
 * Imprime somente as linhas para lancamento manual.
 * @param Fpdf $oPdf
 * @param stdClass $oDadosCabecalho dados do cabecalho
 */
function imprimeManual($oPdf, $oDadosCabecalho)
{

		imprimeCabecalho($oPdf, $oDadosCabecalho);

		/**
		 * guarda as posicoes iniciais do eixo x e y antes de comecar a imprimir as linhas.
		 */
		$iPosicaoYInicial = $oPdf->GetY();
		$iPosicaoXInicial = $oPdf->GetX();
		$iMaximoLinha     = 32;

			$oPdf->Cell(20,   5, "Data", 1, 0, "C", 1);
			$oPdf->Cell(255,  5, $oDadosCabecalho->sTitulo, 1, 1, "C", 1);

			for ($iLinha = 0; $iLinha < $iMaximoLinha; $iLinha++) {

				$oPdf->Cell(20,   5, "", 1, 0);
				$oPdf->Cell(255,  5, "", 1, 1);
			}
}

/**
 * Imprime os conteudos desenvolvidos que foram lancados no diario,
 * se nao houver conteudos lancados imprime linhas em branco.
 * @param Fpdf $oPdf
 * @param array $aConteudoDesenvolvido conteudos desenvolvidos lancado no diario
 * @param stdClass $oDadosCabecalho dados cabecalho
 */
function imprimeDiario($oPdf, $aConteudoDesenvolvido, $oDadosCabecalho)
{

		imprimeCabecalho($oPdf, $oDadosCabecalho);

		/**
		 * guarda as posicoes iniciais do eixo x e y antes de comecar a imprimir as linhas.
		 */
		$iPosicaoYInicial = $oPdf->GetY();
		$iPosicaoXInicial = $oPdf->GetX();
		$iMaximoLinha     = 32;

		$oPdf->SetFont('arial', 'b', 7);
		$oPdf->Cell(20,  5, "Data", 1, 0, "C", 1);
		$oPdf->Cell(255, 5, $oDadosCabecalho->sTitulo, 1, 1, "C", 1);

			$oPdf->SetFont('arial', '', 6);

			for ($iLinha = 0; $iLinha < $iMaximoLinha; $iLinha++) {

				$iConteudoImpresso = 0;

				foreach ($aConteudoDesenvolvido as $iIndice => $oConteudo) {

					$oPdf->Cell(20,  5, db_formatar($oConteudo->ed300_datalancamento, 'd'), 1, 0,"C");
					$oPdf->Cell(255, 5, $oConteudo->ed300_auladesenvolvida, 1, 1,"L");
					unset($aConteudoDesenvolvido[$iIndice]);

					$oPdf->SetAutoPageBreak(true,5);
				}
			}
}

/**
 * Busca conteudo desenvolvido lancado no Diario de Classe para a regencia
 * @param Regencia $oRegencia
 * @return array:stdClass
 */
function buscaConteudoDesenvolvidoDiario($oRegencia,$datasBim = null)
{

	$oDaoConteudos = db_utils::getDao('diarioclasse');
	$sWhere 			 = " length(ed300_auladesenvolvida) > 0 and ed58_i_regencia = {$oRegencia->getCodigo()} and ed300_datalancamento between '{$datasBim->inicio}' and '{$datasBim->fim}'";
	$sCampos			 = " distinct ed300_datalancamento, ed300_auladesenvolvida";
	$sSqlConteudo  = $oDaoConteudos->sql_query_faltas(null, $sCampos, "ed300_datalancamento", $sWhere);
	$rsConteudo    = $oDaoConteudos->sql_record($sSqlConteudo);
	$iRegistros    = $oDaoConteudos->numrows;

	$aConteudoDesenvolvido = array();

	if ($iRegistros > 0) {

		for ($i = 0; $i < $iRegistros; $i++) {

			$oConteudo               = db_utils::fieldsMemory($rsConteudo, $i);
			$aConteudoDesenvolvido[] = $oConteudo;
		}
	}

	return $aConteudoDesenvolvido;
}

$oPdf->Output();
