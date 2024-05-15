<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

require_once ("fpdf151/pdf.php");
require_once ("libs/db_liborcamento.php");
require_once ("libs/db_sql.php");
require_once("classes/db_orctiporec_classe.php");
require_once("model/orcamento/ReceitaContabilRepository.model.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

use model\caixa\relatorios\ReceitaPeriodoTesourariaPDF;
use model\caixa\relatorios\ReceitaPeriodoTesourariaCSV;
use repositories\caixa\relatorios\ReceitaPeriodoTesourariaRepositoryLegacy;

require_once "model/caixa/relatorios/ReceitaPeriodoTesourariaPDF.model.php";
require_once "model/caixa/relatorios/ReceitaPeriodoTesourariaCSV.model.php";
require_once "repositories/caixa/relatorios/ReceitaPeriodoTesourariaRepositoryLegacy.php";

$sDesdobramento = $desdobrar;
$sTipo = $sinana;
$sTipoReceita = $tipo;
$iFormaArrecadacao = $formarrecadacao;
$sOrdem = $ordem;
$dDataInicial = $datai;
$dDataFinal = $dataf;
$iEmendaParlamentar = $emparlamentar;
$iRegularizacaoRepasse = $regrepasse;
$iInstituicao = db_getsession("DB_instit");
$sReceitas = $codrec;
$sEstrutura = $estrut;
$sContas = $conta;
$sContribuintes = $contribuinte;
$iRecurso = $recurso;
$iFormato = $formatoRelatorio;

$oReceitaPeriodoTesourariaRepository = new ReceitaPeriodoTesourariaRepositoryLegacy(
    $sTipo,
    $sTipoReceita,
    $iFormaArrecadacao,
    $sOrdem,
    $dDataInicial,
    $dDataFinal,
    $sDesdobramento,
    $iEmendaParlamentar,
    $iRegularizacaoRepasse,
    $iInstituicao,
    $sReceitas,
    $sEstrutura,
    $sContas,
    $sContribuintes,
    $iRecurso
);

if ($iFormato == 1) {
    $oRelatorioReceitaPeriodoTesouraria = new ReceitaPeriodoTesourariaCSV(
        $sTipo,
        $sTipoReceita,
        $iFormaArrecadacao,
        $dDataInicial,
        $dDataFinal,
        $oReceitaPeriodoTesourariaRepository);
} else {
    $oRelatorioReceitaPeriodoTesouraria = new ReceitaPeriodoTesourariaPDF(
        $sTipo,
        $sTipoReceita,
        $iFormaArrecadacao,
        $dDataInicial,
        $dDataFinal,
        $oReceitaPeriodoTesourariaRepository);
}

$oRelatorioReceitaPeriodoTesouraria->processar();
?>
