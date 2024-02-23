<?php
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
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("std/DBDate.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlibwebseller.php");
require_once("classes/db_pcmater_classe.php");
db_app::import("exceptions.*");

$oRetorno = new stdClass();
$oRetorno->status = 1;
$oRetorno->message = '';

$oJson = new services_json();
$oParam = $oJson->decode(str_replace('\\', '', $_POST['json']));

function formataData($data, $data_alteracao = '', $material = false) {
    $dataFormatada = !empty($data_alteracao) ?
        DateTime::createFromFormat('d/m/Y', $data)->format('Y-m-d')
        : $data;

    if ($material) {
        $dataAlteracaoFormatada = !empty($data_alteracao)
            ? DateTime::createFromFormat('d/m/Y', $data_alteracao)->format('Y-m-d')
            : $data_alteracao;

        return array(
            'data' => $data,
            'data_alteracao' => $dataAlteracaoFormatada
        );
    }

    return $dataFormatada;
}

switch ($oParam->exec) {
    case 'consultaCodigoMaterial':
      if (empty($oParam->codigoMaterialIinicial)) {
          $oParam->codigoMaterialIinicial = 0;
      }

      if (empty($oParam->codigoMaterialFinal) && !empty($oParam->codigoMaterialIinicial)) {
          $oParam->codigoMaterialFinal = $oParam->codigoMaterialIinicial;
      }

      $intervaloDatas = range($oParam->codigoMaterialIinicial, $oParam->codigoMaterialFinal);
      $intervaloFormatadoParaSql = implode(',', $intervaloDatas);

      $sql = "
                SELECT
                    pc01_codmater AS codigo,
                    CASE
                        WHEN pc01_complmater IS NOT NULL THEN pc01_descrmater || '. ' || pc01_complmater
                        ELSE pc01_descrmater
                    END AS descricao,
                    pc01_data AS data,
                     db150_data AS dataalteracao,
                     db150_coditem,
                   db150_unidademedida,
                   db150_tipocadastro,
                   db150_sequencial,
                   pc01_codmaterant
                FROM
                    pcmater
                LEFT JOIN historicomaterial ON db150_pcmater = pc01_codmater
                WHERE pc01_codmater IN ($intervaloFormatadoParaSql) order by pc01_codmater";

      $rsCodigosMateriais = db_query($sql);
      $oRetorno->materiais = array();

      if (pg_num_rows($rsCodigosMateriais) == 0) {
          $oRetorno->message = urlencode('Não há nenhum material/serviço com o intervalo informado.');
          $oRetorno->status = 2;
          break;
      }

      $oRetorno->materiais = db_utils::getCollectionByRecord(
          $rsCodigosMateriais,
          false,
          false,
          true
      );

      break;

    case 'consultaCodigoMaterialSolicitacao':
        if (empty($oParam->codigoMaterialIinicial)) {
            $oParam->codigoMaterialIinicial = 0;
        }

        if (empty($oParam->codigoMaterialFinal) && !empty($oParam->codigoMaterialIinicial)) {
            $oParam->codigoMaterialFinal = $oParam->codigoMaterialIinicial;
        }

        $sqlintervaloFormatado = "";

        if($oParam->codigoMaterialIinicial){
            $intervaloDatas = range($oParam->codigoMaterialIinicial, $oParam->codigoMaterialFinal);
            $intervaloFormatadoParaSql = implode(',', $intervaloDatas);
            $sqlintervaloFormatado = "and pc01_codmater IN ($intervaloFormatadoParaSql)";
        }

        $sql = "
            SELECT pc01_codmater AS codigo,
                   CASE
                       WHEN pc01_complmater IS NOT NULL THEN pc01_descrmater || '. ' || pc01_complmater
                       ELSE pc01_descrmater
                   END AS descricao,
                   pc01_data AS DATA,
                   db150_data AS dataalteracao,
                   db150_coditem,
                   db150_unidademedida,
                   db150_tipocadastro,
                   db150_sequencial,
                   pc01_codmaterant
            FROM solicitem
            INNER JOIN solicitempcmater ON pc16_solicitem=pc11_codigo
            INNER JOIN pcmater ON pc16_codmater = pc01_codmater
            INNER JOIN historicomaterial on db150_pcmater  = pc01_codmater
            WHERE pc11_numero=$oParam->iSolicitacao $sqlintervaloFormatado
        ";

        $rsCodigosMateriais = db_query($sql);
        $oRetorno->materiais = array();

        if (pg_num_rows($rsCodigosMateriais) == 0) {
            $oRetorno->message = urlencode('Não há nenhum material/serviço com o intervalo informado.');
            $oRetorno->status = 2;
            break;
        }

        $oRetorno->materiais = db_utils::getCollectionByRecord(
            $rsCodigosMateriais,
            false,
            false,
            true
        );

        break;

    case 'consultaCodigoMaterialLicitacao':
        if (empty($oParam->codigoMaterialIinicial)) {
            $oParam->codigoMaterialIinicial = 0;
        }

        if (empty($oParam->codigoMaterialFinal) && !empty($oParam->codigoMaterialIinicial)) {
            $oParam->codigoMaterialFinal = $oParam->codigoMaterialIinicial;
        }

        $sqlintervaloFormatado = "";

        if($oParam->codigoMaterialIinicial){
            $intervaloDatas = range($oParam->codigoMaterialIinicial, $oParam->codigoMaterialFinal);
            $intervaloFormatadoParaSql = implode(',', $intervaloDatas);
            $sqlintervaloFormatado = "and pc01_codmater IN ($intervaloFormatadoParaSql)";
        }

        $sql = "
            SELECT pc01_codmater AS codigo,
                   CASE
                       WHEN pc01_complmater IS NOT NULL THEN pc01_descrmater || '. ' || pc01_complmater
                       ELSE pc01_descrmater
                   END AS descricao,
                   pc01_data AS DATA,
                   db150_data AS dataalteracao,
                   db150_coditem,
                   db150_unidademedida,
                   db150_tipocadastro,
                   db150_sequencial,
                   pc01_codmaterant
            FROM liclicitem
            INNER JOIN pcprocitem ON pc81_codprocitem = l21_codpcprocitem
            INNER JOIN solicitem ON pc81_solicitem = pc11_codigo
            INNER JOIN solicitempcmater ON pc16_solicitem=pc11_codigo
            INNER JOIN pcmater ON pc16_codmater = pc01_codmater
            INNER JOIN historicomaterial on db150_pcmater  = pc01_codmater
            WHERE l21_codliclicita = $oParam->iLicitacao $sqlintervaloFormatado
        ";

        $rsCodigosMateriais = db_query($sql);
        $oRetorno->materiais = array();

        if (pg_num_rows($rsCodigosMateriais) == 0) {
            $oRetorno->message = urlencode('Não há nenhum material/serviço com o intervalo informado.');
            $oRetorno->status = 2;
            break;
        }

        $oRetorno->materiais = db_utils::getCollectionByRecord(
            $rsCodigosMateriais,
            false,
            false,
            true
        );

        break;

    case 'consultaCodigoMaterialContrato':
        if (empty($oParam->codigoMaterialIinicial)) {
            $oParam->codigoMaterialIinicial = 0;
        }

        if (empty($oParam->codigoMaterialFinal) && !empty($oParam->codigoMaterialIinicial)) {
            $oParam->codigoMaterialFinal = $oParam->codigoMaterialIinicial;
        }

        $sqlintervaloFormatado = "";

        if($oParam->codigoMaterialIinicial){
            $intervaloDatas = range($oParam->codigoMaterialIinicial, $oParam->codigoMaterialFinal);
            $intervaloFormatadoParaSql = implode(',', $intervaloDatas);
            $sqlintervaloFormatado = "and pc01_codmater IN ($intervaloFormatadoParaSql)";
        }

        $sql = "
            SELECT pc01_codmater AS codigo,
                   CASE
                       WHEN pc01_complmater IS NOT NULL THEN pc01_descrmater || '. ' || pc01_complmater
                       ELSE pc01_descrmater
                   END AS descricao,
                   pc01_data AS DATA,
                   db150_data AS dataalteracao,
                   db150_coditem,
                   db150_unidademedida,
                   db150_tipocadastro,
                   db150_sequencial,
                   pc01_codmaterant
            FROM acordoposicao
            INNER JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
            INNER JOIN pcmater ON pc01_codmater = ac20_pcmater
            INNER JOIN historicomaterial on db150_pcmater  = pc01_codmater
            where ac26_acordo = $oParam->iContrato $sqlintervaloFormatado
        ";

        $rsCodigosMateriais = db_query($sql);
        $oRetorno->materiais = array();

        if (pg_num_rows($rsCodigosMateriais) == 0) {
            $oRetorno->message = urlencode('Não há nenhum material/serviço com o intervalo informado.');
            $oRetorno->status = 2;
            break;
        }

        $oRetorno->materiais = db_utils::getCollectionByRecord(
            $rsCodigosMateriais,
            false,
            false,
            true
        );

        break;

    case 'consultaCodigoSicom':
        $sql = "
            SELECT pc01_codmater AS codigo,
                   CASE
                       WHEN pc01_complmater IS NOT NULL THEN pc01_descrmater || '. ' || pc01_complmater
                       ELSE pc01_descrmater
                   END AS descricao,
                   pc01_data AS DATA,
                   db150_data AS dataalteracao,
                   db150_coditem,
                   db150_unidademedida,
                   db150_tipocadastro,
                   db150_sequencial,
                   pc01_codmaterant
            FROM historicomaterial
            INNER JOIN pcmater ON pc01_codmater = db150_pcmater
            WHERE db150_coditem = $oParam->codigoMaterialSicom
        ";

        $rsCodigosMateriais = db_query($sql);
        $oRetorno->materiais = array();

        if (pg_num_rows($rsCodigosMateriais) == 0) {
            $oRetorno->message = urlencode('Não há nenhum material/serviço com o código informado.');
            $oRetorno->status = 2;
            break;
        }

        $oRetorno->materiais = db_utils::getCollectionByRecord(
            $rsCodigosMateriais,
            false,
            false,
            true
        );

    break;

    case 'atualizarDatasMateriais' :

      $rsCodigosMateriaisAtualizados = false;
      $clhistoricomaterial = new cl_historicomaterial;
      $clpcmater = new cl_pcmater();

      foreach ($oParam->materiaisParaAtualizacao as $oMaterial) {

          $data = DateTime::createFromFormat('d/m/Y', $oMaterial->data);
          $dataAlteracao = DateTime::createFromFormat('d/m/Y', $oMaterial->data_alteracao);
          $dData_atual = date('d/m/Y', db_getsession('DB_datausu'));
          $dataServidor = DateTime::createFromFormat('d/m/Y', $dData_atual);

          if($data > $dataServidor){
              $oRetorno->message = urlencode('Campo Data maior que data do Servidor');
              $oRetorno->status = 2;
              break;
          }

          if($dataAlteracao > $dataServidor){
              $oRetorno->message = urlencode('Campo Data Alteração maior que data do Servidor');
              $oRetorno->status = 2;
              break;
          }

          $datasFormatadas = formataData($oMaterial->data, $oMaterial->data_alteracao, true);
          $dataFormatada = !empty($oMaterial->data)
              ? $datasFormatadas['data']
              : '';
          $dataAlteracaoFormatada = !empty($oMaterial->data_alteracao)
              ? $datasFormatadas['data_alteracao']
              : '';
          $sql = "
            UPDATE
                pcmater
                SET
                    pc01_data = (SELECT NULLIF('$dataFormatada', '')::DATE)
            WHERE pc01_codmater = {$oMaterial->codigo} ";
          $rsCodigosMateriaisAtualizados = (bool)db_query($sql);


          if (!$rsCodigosMateriaisAtualizados) {
              $oRetorno->message = urlencode('Erro ao atualizar dados do(s) material(ais)/serviço(s)');
              $oRetorno->status = 2;
              break;
          }

          if($oMaterial->data_alteracao){

              $rsHistMat = $clhistoricomaterial->sql_record($clhistoricomaterial->sql_query(null,"*",null,"db150_coditem = $oMaterial->codigo_sicom and db150_tipocadastro = $oMaterial->tipo"));
              $aData = explode('/', $oMaterial->data_alteracao);
              $oMat = db_utils::getCollectionByRecord($rsHistMat,false,false,true);
              $db150_tipocadastro = $oMat[0]->db150_tipocadastro;
              if(pg_num_rows($rsHistMat)) {

                  $clhistoricomaterial->db150_data = $oMaterial->data_alteracao;
                  $clhistoricomaterial->db150_mes = $aData[1];
                  $clhistoricomaterial->db150_sequencial = $oMat[0]->db150_sequencial;
                  $clhistoricomaterial->alterar($oMat[0]->db150_sequencial);

                  if($db150_tipocadastro == "2"){

                      $sql = "
                        UPDATE
                            pcmater
                            SET
                                pc01_dataalteracao = {$oMaterial->data}
                        WHERE pc01_codmater = {$oMaterial->codigo} ";
                        $rsCodigosMateriaisAtualizados = (bool)db_query($sql);

                  }else{

                      $sql = "
                        UPDATE
                            pcmater
                            SET
                                pc01_data = {$oMaterial->data}
                        WHERE pc01_codmater = {$oMaterial->codigo} ";
                      $rsCodigosMateriaisAtualizados = (bool)db_query($sql);

                      $dataMaterial = $oMaterial->data;

                      if($dataMaterial) {

                          $aDataInclusao = explode('/', $oMaterial->data_alteracao);

                          $sql = "
                            UPDATE
                                historicomaterial
                                SET
                                    db150_mes = {$aDataInclusao[1]}
                            WHERE db150_sequencial = {$oMat[0]->db150_sequencial} ";
                          $rsCodigosMateriaisAtualizados = (bool)db_query($sql);
                      }
                  }
              }
          }
      }

      break;

    case 'consultaCodigoSolicitacaoCompra':
      if (empty($oParam->codigoSolicitacaoInicial)) {
        $oParam->codigoSolicitacaoInicial = 0;
      }

      if (empty($oParam->codigoSolicitacaoFinal) && !empty($oParam->codigoSolicitacaoInicial)) {
          $oParam->codigoSolicitacaoFinal = $oParam->codigoSolicitacaoInicial;
      }

      $intervaloDatas = range($oParam->codigoSolicitacaoInicial, $oParam->codigoSolicitacaoFinal);
      $intervaloFormatadoParaSql = implode(",", $intervaloDatas);

      $sql = "
                SELECT
                    pc10_numero AS codigo,
                    pc10_resumo AS resumo,
                    pc10_data AS data
                FROM
                    solicita
                WHERE pc10_numero IN ($intervaloFormatadoParaSql) ";

      $rsCodigosSolicitacoesCompra = db_query($sql);
      $oRetorno->solicitacoesCompra = array();

      if (pg_num_rows($rsCodigosSolicitacoesCompra) == 0) {
          $oRetorno->message = urlencode('Não há nenhuma solicitação de compra com o intervalo informado.');
          $oRetorno->status = 2;
          break;
      }

      $oRetorno->solicitacoesCompra = db_utils::getCollectionByRecord(
          $rsCodigosSolicitacoesCompra,
          false,
          false,
          true
      );

      break;

    case 'atualizarDatasSolictacoesCompra' :
        $rsCodigosSolicitacoesAtualizadas = false;

        foreach ($oParam->solicitacoesParaAtualizacao as $oSolicitacaoCompra) {
            $dataFormatada = !empty($oSolicitacaoCompra->data)
                ? formataData($oSolicitacaoCompra->data)
                : '';

            $sql = "
                UPDATE
                    solicita
                    SET
                        pc10_data = (SELECT NULLIF('$dataFormatada', '')::DATE)
                WHERE pc10_numero = {$oSolicitacaoCompra->codigo} ";

            $rsCodigosSolicitacoesAtualizadas = (bool)db_query($sql);
        }

        if (!$rsCodigosSolicitacoesAtualizadas) {
            $oRetorno->message = urlencode('Erro ao atualizar dados da(s) solicitação(ões) compra.');
            $oRetorno->status = 2;
        }

        break;

    case 'consultaCodigoProcessoCompra':
        if (empty($oParam->codigoProcessoInicial)) {
            $oParam->codigoProcessoInicial = 0;
        }

        if (empty($oParam->codigoProcessoFinal) && !empty($oParam->codigoProcessoInicial)) {
            $oParam->codigoProcessoFinal = $oParam->codigoProcessoInicial;
        }

        $intervaloDatas = range($oParam->codigoProcessoInicial, $oParam->codigoProcessoFinal);
        $intervaloFormatadoParaSql = implode(",", $intervaloDatas);

        $sql = "
                SELECT
                    pc80_codproc AS codigo,
                    pc80_resumo AS resumo,
                    pc80_data AS data
                FROM
                    pcproc
                WHERE pc80_codproc IN ($intervaloFormatadoParaSql) ";

        $rsCodigosProcessosCompra = db_query($sql);
        $oRetorno->processosCompra = array();

        if (pg_num_rows($rsCodigosProcessosCompra) == 0) {
            $oRetorno->message = urlencode('Não há nenhum processo de compra com o intervalo informado.');
            $oRetorno->status = 2;
            break;
        }

        $oRetorno->processosCompra = db_utils::getCollectionByRecord(
            $rsCodigosProcessosCompra,
            false,
            false,
            true
        );

        break;

    case 'atualizarDatasProcessosCompra' :
        $rsCodigosProcessosAtualizados = false;

        foreach ($oParam->processosParaAtualizacao as $oProcessoCompra) {
            $dataFormatada = !empty($oProcessoCompra->data)
                ? formataData($oProcessoCompra->data)
                : '';

            $sql = "
                UPDATE
                    pcproc
                    SET
                        pc80_data = (SELECT NULLIF('$dataFormatada', '')::DATE)
                WHERE pc80_codproc = {$oProcessoCompra->codigo} ";

            $rsCodigosProcessosAtualizados = (bool)db_query($sql);
        }

        if (!$rsCodigosProcessosAtualizados) {
            $oRetorno->message = urlencode('Erro ao atualizar dados do(s) processo(s) de compra.');
            $oRetorno->status = 2;
        }

        break;

    case 'consultaCodigoOrcamentos':
        if (empty($oParam->codigoOrcamentoInicial)) {
            $oParam->codigoOrcamentoInicial = 0;
        }

        if (empty($oParam->codigoOrcamentoFinal) && !empty($oParam->codigoOrcamentoInicial)) {
            $oParam->codigoOrcamentoFinal = $oParam->codigoOrcamentoInicial;
        }

        $intervaloDatas = range($oParam->codigoOrcamentoInicial, $oParam->codigoOrcamentoFinal);
        $intervaloFormatadoParaSql = implode(",", $intervaloDatas);

        $sql = "
                SELECT
                    pc20_codorc AS codigo,
                    pc20_obs AS observacao,
                    pc20_dtate AS data
                FROM
                    pcorcam
                WHERE pc20_codorc IN ($intervaloFormatadoParaSql) ";

        $rsCodigosOrcamentos = db_query($sql);
        $oRetorno->orcamentos = array();

        if (pg_num_rows($rsCodigosOrcamentos) == 0) {
            $oRetorno->message = urlencode('Não há nenhum orçamento com o intervalo informado.');
            $oRetorno->status = 2;
            break;
        }

        $oRetorno->orcamentos = db_utils::getCollectionByRecord(
            $rsCodigosOrcamentos,
            false,
            false,
            true
        );

        break;

    case 'atualizarDatasOrcamentos' :
        $rsCodigosOrcamentosAtualizados = false;

        foreach ($oParam->orcamentosParaAtualizacao as $oOrcamento) {
            $dataFormatada = !empty($oOrcamento->data)
                ? formataData($oOrcamento->data)
                : '';

            $sql = "
                UPDATE
                    pcorcam
                    SET
                        pc20_dtate = (SELECT NULLIF('$dataFormatada', '')::DATE)
                WHERE pc20_codorc = {$oOrcamento->codigo} ";

            $rsCodigosOrcamentosAtualizados = (bool)db_query($sql);
        }

        if (!$rsCodigosOrcamentosAtualizados) {
            $oRetorno->message = urlencode('Erro ao atualizar dados do(s) orçamento(s).');
            $oRetorno->status = 2;
        }

        break;
}
echo $oJson->encode($oRetorno);
