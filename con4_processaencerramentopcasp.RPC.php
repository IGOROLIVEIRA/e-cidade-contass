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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("libs/db_libcontabilidade.php");
require_once ("dbforms/db_funcoes.php");
require_once ("classes/lancamentoContabil.model.php");

$oParam             = json_decode(str_replace("\\", "", $_POST["json"]));
$oRetorno           = new stdClass();
$oRetorno->erro     = false;
$oRetorno->sMessage = '';

$sMensagens = "patrimonial.compras.com4_manifestarinteresseregistroprecoporvalor.";

$aTiposEncerramento = array(
    'rp' => EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR,
    'vp' => EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS,
    'no' => EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE,
    'is' => EncerramentoExercicio::ENCERRAR_IMPLANTACAO_SALDOS,
    'tx' => EncerramentoExercicio::TRANSFERENCIA_CREDITOS_EMPENHADOS_RP
);

try {

  db_inicio_transacao();

  switch ($oParam->sExecucao) {

    case "encerramentosRealizados":

      $oEncerramentoExercicio = new EncerramentoExercicio( new Instituicao(db_getsession("DB_instit")),
          db_getsession("DB_anousu") );

      $aEncerramentos = $oEncerramentoExercicio->getEncerramentosRealizados();

      $aTiposEncerramentoValor  = array_flip($aTiposEncerramento);
      $oRetorno->aEncerramentos = array(
          $aTiposEncerramentoValor[EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR] => in_array(EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR, $aEncerramentos),
          $aTiposEncerramentoValor[EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS] => in_array(EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS, $aEncerramentos),
          $aTiposEncerramentoValor[EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE] => in_array(EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE, $aEncerramentos),
          $aTiposEncerramentoValor[EncerramentoExercicio::ENCERRAR_IMPLANTACAO_SALDOS] => in_array(EncerramentoExercicio::ENCERRAR_IMPLANTACAO_SALDOS, $aEncerramentos),
          $aTiposEncerramentoValor[EncerramentoExercicio::TRANSFERENCIA_CREDITOS_EMPENHADOS_RP] => pg_num_rows($oEncerramentoExercicio->getTransferenciasRealizadas()) > 0 ? true : false
      );

      break;

    case "processarEncerramento":

      $oEncerramentoExercicio = new EncerramentoExercicio( new Instituicao(db_getsession("DB_instit")),
          db_getsession("DB_anousu") );

      if (empty($oParam->sTipo)) {
        throw new Exception("Tipo de encerramento não informado.");
      }

      if (!in_array($oParam->sTipo, array_keys($aTiposEncerramento))) {
        throw new Exception("O Tipo de encerramento informado é inválido.");
      }

      if (empty($oParam->sData)) {
        throw new Exception("Data dos lançamentos não informada.");
      }

      $oDataLancamentos  = new DBDate($oParam->sData);
      $oDataEncerramento = new DBDate( date("d/m/Y", db_getsession("DB_datausu")) );

      $iTipoEncerramento = $aTiposEncerramento[$oParam->sTipo];
      $aEncerramentos    = $oEncerramentoExercicio->getEncerramentosRealizados();

      $oEncerramentoExercicio->setDataEncerramento($oDataEncerramento);
      $oEncerramentoExercicio->setDataLancamento($oDataLancamentos);

      $lEncerramentoSistemaOrcamentario   = in_array(EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE, $aEncerramentos);
      $lEncerramentoRestosPagar           = in_array(EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR, $aEncerramentos);
      $lEncerramentoVariacoesPatrimoniais = in_array(EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS, $aEncerramentos);
      $lEncerramentoImplantacaoSaldos     = in_array(EncerramentoExercicio::ENCERRAR_IMPLANTACAO_SALDOS, $aEncerramentos);

      $clCondataconf = new cl_condataconf ();
      $iAnoUsu = db_getsession('DB_anousu');
      $iInstit = db_getsession('DB_instit');
      $clCondataconf->c99_data     = $iAnoUsu.'-12-30';
      $clCondataconf->c99_datapat  = $iAnoUsu.'-12-30';
      $clCondataconf->c99_data_dia = '30';
      $clCondataconf->c99_data_mes = '12';
      $clCondataconf->c99_data_ano = $iAnoUsu;
      $clCondataconf->c99_anousu   = $iAnoUsu;
      $clCondataconf->c99_instit   = $iInstit;
      $clCondataconf->c99_usuario  = db_getsession("DB_id_usuario");

      $rsCondataconf = $clCondataconf->sql_record($clCondataconf->sql_query_file($iAnoUsu,$iInstit));

      if ($rsCondataconf == false || $clCondataconf->numrows == 0) {
        $clCondataconf->incluir($iAnoUsu,$iInstit);
      }else{
        $clCondataconf->alterar($iAnoUsu,$iInstit);
      }

      if ($iTipoEncerramento == EncerramentoExercicio::TRANSFERENCIA_CREDITOS_EMPENHADOS_RP) {

        /**
         * Processamento já foi realizado
         */
        if (pg_num_rows($oEncerramentoExercicio->getTransferenciasRealizadas()) > 0) {
          throw new BusinessException('Transferência dos créditos empenhados para RP já processado para o exercício.');
        }

        $oEncerramentoExercicio->encerrar(EncerramentoExercicio::TRANSFERENCIA_CREDITOS_EMPENHADOS_RP);

      } else {
        if ($iTipoEncerramento == EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE) {

          /**
           * Processamento já foi realizado
           */
          if ($lEncerramentoSistemaOrcamentario && $lEncerramentoRestosPagar) {
            throw new BusinessException('Restos a Pagar / Natureza Orçamentária e Controle já processado para o exercício.');
          }

          /**
           * Tentativa de processar fora de ordem
           */
          if (!$lEncerramentoVariacoesPatrimoniais) {
            throw new BusinessException('O Encerramento das Variações Patrimoniais deve ser processado primeiro.');
          }

          $oEncerramentoExercicio->encerrar(EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE);
          $oEncerramentoExercicio->encerrar(EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR);
        } else if ($iTipoEncerramento == EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS) {

          /**
           * Processamento já foi realizado
           */
          if ($lEncerramentoVariacoesPatrimoniais) {
            throw new BusinessException('Encerramento das Variações Patrimoniais já processado para o exercício.');
          }

          $oEncerramentoExercicio->encerrar(EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS);
        } else if ($iTipoEncerramento == EncerramentoExercicio::ENCERRAR_IMPLANTACAO_SALDOS) {

          //Validando se ja foi processado.
          if ($lEncerramentoImplantacaoSaldos) {
            throw new BusinessException("Implantação de Saldos já processado para o exercício.");
          }

          //Validando ordem do processamento.
          if (!$lEncerramentoVariacoesPatrimoniais || !$lEncerramentoRestosPagar || !$lEncerramentoSistemaOrcamentario) {

            $sErro  = "A Implantação de Saldos deve ser processada após os processamentos do Encerramento das Variações ";
            $sErro .= "Patrimoniais e Restos a Pagar / Natureza Orçamentária e Controle.";
            throw new BusinessException($sErro);
          }
          $oEncerramentoExercicio->encerrar(EncerramentoExercicio::ENCERRAR_IMPLANTACAO_SALDOS);
        }
      }
        /*Encerramento Patrimonial OC 8874*/
        $c99_anousu = db_getsession("DB_anousu");
        $c99_instit = db_getsession("DB_instit");
        $c99_data = $oParam->sData;
        $c99_usuario = db_getsession("DB_id_usuario");

        $clcondataconf = new cl_condataconf();
        $clcondataconf->c99_anousu  = $c99_anousu;
        $clcondataconf->c99_instit  = $c99_instit;
        $clcondataconf->c99_data    = $c99_data;
        $clcondataconf->c99_datapat = $c99_data;
        $clcondataconf->c99_usuario = $c99_usuario;
        $clcondataconf->c99_anousu  = $c99_anousu;

        $rsConDataConf = $clcondataconf->sql_record($clcondataconf->sql_query_file($c99_anousu,$c99_instit));

        //  Se não houver um registro criado
        if($rsConDataConf == false || $clcondataconf->numrows == 0) {
          $clcondataconf->incluir($c99_anousu,$c99_instit);
        }else{
          $clcondataconf->alterar($c99_anousu,$c99_instit);
        }
        /*fim OC 8874*/
      

      break;

    case "desprocessarEncerramento":

      $oEncerramentoExercicio = new EncerramentoExercicio( new Instituicao(db_getsession("DB_instit")),
          db_getsession("DB_anousu") );

      if (empty($oParam->sTipo)) {
        throw new Exception("Tipo de encerramento não informado.");
      }

      if (!in_array($oParam->sTipo, array_keys($aTiposEncerramento))) {
        throw new Exception("O Tipo de encerramento informado é inválido.");
      }

      $iTipoEncerramento = $aTiposEncerramento[$oParam->sTipo];
      $aEncerramentos    = $oEncerramentoExercicio->getEncerramentosRealizados();

      $lEncerramentoSistemaOrcamentario   = in_array(EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE, $aEncerramentos);
      $lEncerramentoRestosPagar           = in_array(EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR, $aEncerramentos);
      $lEncerramentoVariacoesPatrimoniais = in_array(EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS, $aEncerramentos);
      $lEncerramentoImplantacaoSaldos     = in_array(EncerramentoExercicio::ENCERRAR_IMPLANTACAO_SALDOS, $aEncerramentos);

      $clCondataconf = new cl_condataconf ();
      $iAnoUsu = db_getsession('DB_anousu');
      $iInstit = db_getsession('DB_instit');
      $clCondataconf->c99_data     = $iAnoUsu.'-12-30';
      $clCondataconf->c99_datapat  = $iAnoUsu.'-12-30';
      $clCondataconf->c99_data_dia = '30';
      $clCondataconf->c99_data_mes = '12';
      $clCondataconf->c99_data_ano = $iAnoUsu;
      $clCondataconf->c99_anousu   = $iAnoUsu;
      $clCondataconf->c99_instit   = $iInstit;
      $clCondataconf->c99_usuario  = db_getsession("DB_id_usuario");

      $rsCondataconf = $clCondataconf->sql_record($clCondataconf->sql_query_file($iAnoUsu,$iInstit));

      if($rsCondataconf == false || $clCondataconf->numrows == 0) {
        $clCondataconf->incluir($iAnoUsu,$iInstit);
      }else{
        $clCondataconf->alterar($iAnoUsu,$iInstit);
      }

      if ($iTipoEncerramento == EncerramentoExercicio::TRANSFERENCIA_CREDITOS_EMPENHADOS_RP) {

        if (pg_num_rows($oEncerramentoExercicio->getTransferenciasRealizadas()) == 0) {
          throw new BusinessException('Transferência dos créditos empenhados para RP não processado ou já cancelado para o exercício.');
        }

        $oEncerramentoExercicio->cancelarTransferencia();

      } elseif ($iTipoEncerramento == EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE) {

        /**
         * Cancelamento já foi realizado ou o processamento não foi realizado
         */
        if (!$lEncerramentoSistemaOrcamentario && !$lEncerramentoRestosPagar) {
          throw new BusinessException('Restos a Pagar / Natureza Orçamentária e Controle não processado ou já cancelado para o exercício.');
        }

        $oEncerramentoExercicio->cancelar(EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR);
        $oEncerramentoExercicio->cancelar(EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE);
      } else if ($iTipoEncerramento == EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS) {

        /**
         * Cancelamento já foi realizado
         */
        if (!$lEncerramentoVariacoesPatrimoniais) {
          throw new BusinessException('Encerramento das Variações Patrimoniais não processado ou já cancelado para o exercício.');
        }

        /**
         * Tentativa de cancelar fora de ordem
         */
        if ($lEncerramentoSistemaOrcamentario && $lEncerramentoRestosPagar) {
          throw new BusinessException('Restos a Pagar / Natureza Orçamentária e Controle deve ser cancelado primeiro.');
        }
        $oEncerramentoExercicio->cancelar(EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS);
      } else if($iTipoEncerramento == EncerramentoExercicio::ENCERRAR_IMPLANTACAO_SALDOS) {

        if (!$lEncerramentoImplantacaoSaldos) {
          throw new BusinessException("Implantação de Saldos não processado ou já cancelado para o exercício.");
        }
        $oEncerramentoExercicio->cancelarImplantacaoSaldos();
      }

      $clCondataconf = new cl_condataconf ();
      $iAnoUsu = db_getsession('DB_anousu');
      $iInstit = db_getsession('DB_instit');
      $clCondataconf->c99_data     = $iAnoUsu.'-12-31';
      $clCondataconf->c99_datapat  = $iAnoUsu.'-12-31';
      $clCondataconf->c99_data_dia = '31';
      $clCondataconf->c99_data_mes = '12';
      $clCondataconf->c99_data_ano = $iAnoUsu;
      $clCondataconf->c99_anousu   = $iAnoUsu;
      $clCondataconf->c99_instit   = $iInstit;
      $clCondataconf->c99_usuario  = db_getsession("DB_id_usuario");

      $rsCondataconf = $clCondataconf->sql_record($clCondataconf->sql_query_file($iAnoUsu,$iInstit));

      if($rsCondataconf == false || $clCondataconf->numrows == 0) {
        $clCondataconf->incluir($iAnoUsu,$iInstit);
      }else{
        $clCondataconf->alterar($iAnoUsu,$iInstit);
      }

      break;

    case "buscarRegras":

      $oEncerramentoExercicio = new EncerramentoExercicio( new Instituicao(db_getsession("DB_instit")),
          db_getsession("DB_anousu") );

      $oRetorno->aRegras = $oEncerramentoExercicio->getRegrasNaturezaOrcamentaria();

      break;

    case "salvarRegra":

      if (empty($oParam->contadevedora)) {
        throw new Exception("Conta Devedora não informada.");
      }

      if (empty($oParam->contacredora)) {
        throw new Exception("Conta Credora não informada.");
      }

      $oDaoRegrasEncerramento = new cl_regraencerramentonaturezaorcamentaria();

      $oDaoRegrasEncerramento->c117_sequencial       = null;
      $oDaoRegrasEncerramento->c117_anousu           = db_getsession("DB_anousu");
      $oDaoRegrasEncerramento->c117_instit           = db_getsession("DB_instit");
      $oDaoRegrasEncerramento->c117_contadevedora    = $oParam->contadevedora;
      $oDaoRegrasEncerramento->c117_contacredora     = $oParam->contacredora;
      $oDaoRegrasEncerramento->c117_contareferencia  = $oParam->contareferencia;

      $oDaoRegrasEncerramento->incluir(null);

      if ($oDaoRegrasEncerramento->erro_status == 0) {
        throw new Exception($oDaoRegrasEncerramento->erro_msg);
      }

      break;

    case "removerRegra":

      if (empty($oParam->iCodigoRegra)) {
        throw new Exception("Código da Regra não informado.");
      }

      $oDaoRegrasEncerramento = new cl_regraencerramentonaturezaorcamentaria();

      $oDaoRegrasEncerramento->excluir( null,
          "c117_sequencial = {$oParam->iCodigoRegra} "
          . "and c117_anousu = " . db_getsession("DB_anousu")
          . " and c117_instit = " . db_getsession("DB_instit") );

      if ($oDaoRegrasEncerramento->erro_status == 0) {
        throw new Exception($oDaoRegrasEncerramento->erro_msg);
      }

      break;
    case "importarRegra":

      $oDaoRegrasEncerramento = new cl_regraencerramentonaturezaorcamentaria();

      $oDaoRegrasEncerramento->excluir( null,
          " c117_anousu = " . db_getsession("DB_anousu")
          . " and c117_instit = " . db_getsession("DB_instit") );

      $iAno = db_getsession("DB_anousu")-1;

      $sSqlImportarRegras  = " INSERT INTO regraencerramentonaturezaorcamentaria ";
      $sSqlImportarRegras .= "SELECT nextval('regraencerramentonaturezaorcamentaria_c117_sequencial_seq') AS ";
      $sSqlImportarRegras .= "       c117_sequencial, ";
      $sSqlImportarRegras .= db_getsession("DB_anousu")."       as c117_anousu, ";
      $sSqlImportarRegras .= "       c117_instit, ";
      $sSqlImportarRegras .= "       c117_contadevedora, ";
      $sSqlImportarRegras .= "       c117_contacredora, ";
      $sSqlImportarRegras .= "       c117_contareferencia ";
      $sSqlImportarRegras .= "FROM   regraencerramentonaturezaorcamentaria WHERE  c117_anousu = {$iAno}";
      $sSqlImportarRegras .= "       AND c117_instit = ". db_getsession("DB_instit") ;

      $oDaoRegrasEncerramento->sql_record($sSqlImportarRegras);

      break;
    case "removerRegrasSelecionadas":

      if (empty($oParam->aCodigoRegra)) {
        throw new Exception("Nenhuma regra selecionada.");
      }

      $oDaoRegrasEncerramento = new cl_regraencerramentonaturezaorcamentaria();
      $aRegras = array();
      foreach ($oParam->aCodigoRegra as $regra){
        $aRegras[] = $regra[0];
      }

      $oDaoRegrasEncerramento->excluir( null,
      "c117_sequencial in (".implode(',', $aRegras).") "
      . "and c117_anousu = " . db_getsession("DB_anousu")
      . " and c117_instit = " . db_getsession("DB_instit") );
      
      if ($oDaoRegrasEncerramento->erro_status == 0) {
        throw new Exception($oDaoRegrasEncerramento->erro_msg);
      }
        
      break;
    case "alterarRegra":
      if (empty($oParam->iSequencial)) {
        throw new Exception("Nenhuma regra selecionada.");
      }
      
      $oDaoRegrasEncerramento = new cl_regraencerramentonaturezaorcamentaria();
      $oDaoRegrasEncerramento->c117_sequencial = $oParam->iSequencial;
      $oDaoRegrasEncerramento->c117_contadevedora = $oParam->sCtCredora;
      $oDaoRegrasEncerramento->c117_contacredora = $oParam->sCtDevedora;
      $oDaoRegrasEncerramento->c117_contareferencia = $oParam->sCtReferencia;
      
      $oDaoRegrasEncerramento->sql_record($oDaoRegrasEncerramento->sql_query($oParam->iSequencial));
      
      if ($oDaoRegrasEncerramento->numrows > 0) {
        $oDaoRegrasEncerramento->alterar($oParam->iSequencial);
      } else {        
        throw new Exception("Regra não encontrada.");        
      }

      if ($oDaoRegrasEncerramento->erro_status == 0) {
        throw new Exception($oDaoRegrasEncerramento->erro_msg);
      }
      break;
    case "importaRegrasCsv":
      $oArquivos = db_utils::postMemory($_FILES);
      if (strtolower(substr($oArquivos->regrasCSV['name'], -4)) != '.csv') {
        throw new BusinessException("Arquivo importado com formato inválido! Arquivo deve ser do formato CSV.");
      }
      
      if (trim(file_get_contents($oArquivos->regrasCSV['tmp_name'])) == "") {
        throw new BusinessException("Não é possível importar arquivo vazio.");
      }
      
      $oArquivo = new File($oArquivos->regrasCSV['tmp_name']);
      $linhas = file($oArquivos->regrasCSV['tmp_name'], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
      $dadosArray = array_map('str_getcsv', $linhas);
      $iRegrasSalvas = 0;
      
      foreach($dadosArray as $dadosRegra){
        $regra = explode(';', $dadosRegra[0]);
        if (count($regra) == 3){
          $oDaoRegrasEncerramento = new cl_regraencerramentonaturezaorcamentaria();
          $oDaoRegrasEncerramento->c117_sequencial = null;
          $oDaoRegrasEncerramento->c117_anousu     = db_getsession("DB_anousu");
          $oDaoRegrasEncerramento->c117_instit     = db_getsession("DB_instit");

          if ($regra[0] != '' && is_numeric($regra[0])) {
            $oDaoRegrasEncerramento->c117_contadevedora = $regra[0];
          } else {
            continue;
          }
          if ($regra[1] != '' && is_numeric($regra[1])) {
            $oDaoRegrasEncerramento->c117_contacredora = $regra[1];
          } else {
            continue;
          }
          if ($regra[2] == 'D' || $regra[2] == 'C') {
            $oDaoRegrasEncerramento->c117_contareferencia = $regra[2];
          } else {
            continue;
          }
          $oDaoRegrasEncerramento->incluir(null);
          if ($oDaoRegrasEncerramento->erro_status != 0) {
            $iRegrasSalvas++;
          }
        }
      }
      if ($iRegrasSalvas > 0){
        $oRetorno->sMessage = $iRegrasSalvas." regras foram importadas com sucesso!";
      } else {
        $oRetorno->sMessage = "Houve um erro para importar regras.";
      }      

      break;
  }

  db_fim_transacao(false);

} catch (Exception $eErro){

  db_fim_transacao(true);

  $oRetorno->erro     = true;
  $oRetorno->sMessage = urlencode($eErro->getMessage());
}

echo json_encode($oRetorno);