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

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";
require_once "libs/db_liborcamento.php";
require_once "libs/db_libcontabilidade.php";
require_once "fpdf151/PDFDocument.php";
require_once "fpdf151/PDFTable.php";

$oParametro         = json_decode(str_replace("\\", "", $_POST["json"]));
$oRetorno           = new stdClass();
$oRetorno->erro     = false;
$oRetorno->mensagem = "";

try {

  db_inicio_transacao();

  switch ($oParametro->exec) {

    /**
     * Valida se os recursos do balanço financeiro estão configurados no relatório
     */
    case 'validarBalancoFinanceiro':

      $oRetorno->lEmiteLista = false;
      $oRetorno->sArquivo    = '';

      $oBalancoFinanceiro = new BalancoFinanceiroDcasp(db_getsession("DB_anousu"), $oParametro->relatorio, $oParametro->periodo);
      $oBalancoFinanceiro->setInstituicoes( str_replace('-', ', ', $oParametro->instituicao) );

      /**
       * Gera o relatório com os recursos não configurados
       */
      if (!$oBalancoFinanceiro->validarRecursos($oParametro->exercicioAnterior)) {

        $aRecursos = $oBalancoFinanceiro->getRecursosNaoConfigurados();
        $oRetorno->lEmiteLista = true;

        $oPdf = new PDFTable();
        $oPdf->setPercentWidth(true);
        $oPdf->setHeaders(array(
            "Código do Recurso",
            "Descrição"
          ));

        $oPdf->setColumnsAlign(array(
            PDFDocument::ALIGN_CENTER,
            PDFDocument::ALIGN_LEFT
          ));

        $oPdf->setColumnsWidth(array(
            "20",
            "80"
          ));

        $oPdf->setMulticellColumns(array(1));

        foreach ($aRecursos as $oRecurso) {

          $oPdf->addLineInformation(array(
              $oRecurso->getCodigo(),
              $oRecurso->getDescricao()
            ));
        }

        $oPdfDocument = new PDFDocument();
        $oPdfDocument->addHeaderDescription("Balanço Financeiro");
        $oPdfDocument->addHeaderDescription("");
        $oPdfDocument->addHeaderDescription("Recursos que possuem movimentações no exercício atual ou no exercício anterior e não estão configurados no relatório.");
        $oPdfDocument->SetFillColor(235);
        $oPdfDocument->open();

        $oPdf->printOut($oPdfDocument, false);
        $oRetorno->sArquivo = $oPdfDocument->savePDF();
      }

      break;
  }

  db_fim_transacao(false);

} catch (Exception $eErro) {

  db_fim_transacao(true);
  $oRetorno->erro     = true;
  $oRetorno->mensagem = $eErro->getMessage();
}

$oRetorno->mensagem = urlencode($oRetorno->mensagem);
echo json_encode($oRetorno);