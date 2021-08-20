<?php
//ini_set("display_errors", true);
require_once('classes/db_empempenho_classe.php');
require_once('classes/db_protocolos_classe.php');
require_once('classes/db_protempautoriza_classe.php');
require_once('classes/db_protempenhos_classe.php');
require_once('classes/db_protmatordem_classe.php');
require_once('classes/db_protpagordem_classe.php');
require_once('classes/db_protslip_classe.php');
require_once('classes/db_autprotpagordem_classe.php');
require_once('classes/db_autprotslip_classe.php');
require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("std/DBDate.php");
db_postmemory($_POST);

$oJson  = new services_json();
$oParam = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$data = date("Y-m-d");


switch ($oParam->exec) {

  case "autorizacaoOrdemPagamentos";

    try {

      $resultRecec = db_query("
        select p105_sequencial, p105_codord
              from protpagordem
                where p105_protocolo = {$oParam->protocolo} and p105_codord in (".implode(",",$oParam->autpagamentos).")
      ");

      $aAutPagamentos = db_utils::getCollectionByRecord($resultRecec);
      foreach ($aAutPagamentos as $aAutPagamento) {
        $sSQL = "
          select p107_protocolo
            from autprotpagordem
              where p107_codord = {$aAutPagamento->p105_codord}
        ";
        $ordemAutorizada = db_query($sSQL);
        $aOrdemAutorizada = db_utils::fieldsMemory($ordemAutorizada, 0);
        if (empty($aOrdemAutorizada->p107_protocolo)) {
          continue;
        }
        else if ($aOrdemAutorizada->p107_protocolo != $oParam->protocolo) {
          throw new Exception ("A ordem ".$aAutPagamento->p105_codord." já foi liberada no protocolo ".$aOrdemAutorizada->p107_protocolo."!");
        }
      }

      foreach ($aAutPagamentos as $aOrdemPagamento) {
        $resultado = autorizarOrdemPagamento($aOrdemPagamento->p105_codord, $oParam->protocolo, $data);
        if ($resultado == false) {
          throw new Exception ("Erro ao liberar ordem de pagamento!");
        }
      }

    } catch (Exception $e) {
      $oRetorno->erro   = $e->getMessage();
      $oRetorno->status = 2;
    }

  break;

  case "autorizacaoSlips";

    try {

      $resultRecec = db_query("
        select p106_sequencial, p106_slip
              from protslip
                where p106_protocolo = {$oParam->protocolo} and p106_slip in (".implode(",",$oParam->slips).")
      ");

      $aSlips = db_utils::getCollectionByRecord($resultRecec);
      foreach ($aSlips as $aSlip) {
        $sSQL = "
          select p108_protocolo
            from autprotslip
              where p108_slip = {$aSlip->p106_slip}
        ";
        $slipAutorizada = db_query($sSQL);
        $aSlipAutorizada = db_utils::fieldsMemory($slipAutorizada, 0);
        if (empty($aSlipAutorizada->p108_protocolo)) {
          continue;
        }
        else if ($aSlipAutorizada->p108_protocolo != $oParam->protocolo) {
          throw new Exception ("Slip ".$aSlip->p106_slip." já foi liberado no protocolo ".$aSlipAutorizada->p108_protocolo."!");
        }
      }

      foreach ($aSlips as $aSlip) {
        $resultado = autorizarSlip($aSlip->p106_slip, $oParam->protocolo, $data);
        if ($resultado == false) {
          throw new Exception ("Erro ao liberar Slip!");
        }
      }

    } catch (Exception $e) {
      $oRetorno->erro   = $e->getMessage();
      $oRetorno->status = 2;
    }

  break;

  case "salvaCopiaProtocolo";

    try {

      salvaCopiaAutEmpenho($oParam->protocolo, $oParam->copiaProtocolo);
      salvaCopiaEmpenho($oParam->protocolo, $oParam->copiaProtocolo);
      salvaCopiaAutCompra($oParam->protocolo, $oParam->copiaProtocolo);
      salvaCopiaAutPagamento($oParam->protocolo, $oParam->copiaProtocolo, $oParam->instit);
      salvaCopiaSlip($oParam->protocolo, $oParam->copiaProtocolo, $oParam->instit);

    } catch (Exception $e) {
        $oRetorno->erro   = $e->getMessage();
        $oRetorno->status = 2;
    }

  break;

  case "pesquisaProtocolo";

    try {

      $oRetorno->protocolo = pesquisarProtocolo($oParam->protocolo);

    } catch (Exception $e) {
      $oRetorno->erro   = $e->getMessage();
      $oRetorno->status = 2;
    }
  break;

  case "insereProtocolo":

    try {

      $oProtocolo = new cl_protocolos;
      $oProtocolo->p101_id_usuario      = $oParam->usuario;
      $oProtocolo->p101_coddeptoorigem  = $oParam->origem;
      $oProtocolo->p101_coddeptodestino = $oParam->destino;
      $oProtocolo->p101_observacao      = utf8_decode($oParam->observacao);
      $oProtocolo->p101_dt_protocolo    = $data;
      $oProtocolo->p101_hora            = $oParam->hora;
      $oProtocolo->p101_dt_anulado      = '';
      $oProtocolo->incluir(null);

      if ($oProtocolo->erro_status != 1) {
          throw new Exception($oProtocolo->erro_msg);
      }

      $rsProtocolo = buscaUltProtocolo();
      $protocolo   = db_utils::fieldsMemory($rsProtocolo,0);
      $oRetorno->protocolo = $protocolo->p101_sequencial;

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }

    break;

  case "insereAutEmpenho":

    try {

      $verifica = false;
      $verifica = verificaAutEmpenho($oParam->autempenho, $oParam->protocolo);
      if ($verifica == true) {
        throw new Exception("A autorização de empenho ".$oParam->autempenho." já existe para este protocolo!");
      }

      $oAutEmpenho = new cl_protempautoriza;
      $oAutEmpenho->p102_autorizacao = $oParam->autempenho;
      $oAutEmpenho->p102_protocolo   = $oParam->protocolo;
      $oAutEmpenho->incluir(null);

      if ($oAutEmpenho->erro_status != 1) {
        throw new Exception($oAutEmpenho->erro_msg);
      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }

  break;

  case "insereEmpenho":

    try {
      $tamanho = count($oParam->empenho);
      $empenhosCadastrados = array();
      foreach($oParam->empenho as $empenho){
        $verifica = false;
        $verifica = verificaEmpenho($empenho->e60_numemp, $oParam->protocolo);

        if ($verifica == true) {
          if($tamanho > 1){
            $empenhosCadastrados[] = $empenho->e60_numemp;
          }else{
            throw new Exception("O empenho ".$empenho->e60_numemp." já existe para este protocolo!");
          }
        }

      }
      $listaCadastrados = array();
      foreach ($oParam->empenho as $empenho) {
        if(!in_array($empenho->e60_numemp, $empenhosCadastrados)){
          $oEmpenho = new cl_protempenhos;
          $oEmpenho->p103_numemp = $empenho->e60_numemp;
          $oEmpenho->p103_protocolo = $oParam->protocolo;
          $oEmpenho->incluir(null);
        }else{
          $listaCadastrados[] = $empenho->e60_numemp;
        }
    }
    $stringErro = implode(',', $listaCadastrados);
    $qtdCadastrados = count($listaCadastrados);
    if($qtdCadastrados > 1){
      if($qtdCadastrados > 5){
        $primeiroEmpenho = $listaCadastrados[0];
        $ultimoEmpenho = $listaCadastrados[$qtdCadastrados - 1];
        $oRetorno->erro = "Os empenhos do intervalo ".$primeiroEmpenho.' à '.$ultimoEmpenho." já estão cadastrados!";
      }else $oRetorno->erro = "Os empenhos ".$stringErro." já estão cadastrados!";
    }else if($qtdCadastrados == 1){
      $oRetorno->erro = "O empenho ".$stringErro." já está cadastrado!";
    }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status = 2;
    }

  break;

  case "insereAutCompra";

  try {

      $verifica = false;
      $verifica = verificaAutCompra($oParam->autcompra, $oParam->protocolo);
      if ($verifica == true) {
          throw new Exception("A autorização de compra ".$oParam->autcompra." já existe para este protocolo!");
        }
        $oAutCompra = new cl_protmatordem;
        $oAutCompra->p104_codordem  = $oParam->autcompra;
        $oAutCompra->p104_protocolo = $oParam->protocolo;
        $oAutCompra->incluir(null);

        if ($oAutCompra->erro_status != 1) {
          throw new Exception($oAutCompra->erro_msg);
        }

  } catch (Exception $e) {
    $oRetorno->erro = $e->getMessage();
    $oRetorno->status   = 2;
  }

  break;

  case "insereAutPagamento";

  try {

      foreach ($oParam->autpagamento as $autorizacao) {

        $verifica = false;
        $verifica = verificaAutPagamento($autorizacao->e53_codord, $oParam->protocolo);
        if ($verifica == true) {
          throw new Exception("A autorização de pagamento ".$autorizacao->e53_codord." já existe para este protocolo!");
        }
        $oAutPagamento = new cl_protpagordem;
        $oAutPagamento->p105_codord    = $autorizacao->e53_codord;
        $oAutPagamento->p105_protocolo = $oParam->protocolo;
        $oAutPagamento->incluir(null);

        if ($oAutPagamento->erro_status != 1) {
          throw new Exception($oAutPagamento->erro_msg);
        }

        $rsProtocolo = buscaProtocolo($oParam->protocolo);
        $protocolo   = db_utils::fieldsMemory($rsProtocolo,0);
        $departorig  = $protocolo->p101_coddeptoorigem;
        $departdest  = $protocolo->p101_coddeptodestino;

        $rsConfig  = db_query("
                      select p90_autprotocolo from protparam where p90_instit = {$oParam->instit}");
        $configDepart = db_utils::fieldsMemory($rsConfig,0);

        $sSQL = " SELECT p109_sequencial
                    FROM protconfigdepartaut
                      INNER JOIN db_depart dog ON dog.coddepto = p109_coddeptoorigem
                      INNER JOIN db_depart dd ON dd.coddepto = p109_coddeptodestino
                      INNER JOIN db_config ON codigo = p109_instit
                        WHERE p109_instit =  {$oParam->instit}
                         AND p109_coddeptoorigem = {$departorig}
                         AND p109_coddeptodestino = {$departdest}
                ";
        $rsResult = db_query($sSQL);

        if (pg_num_rows($rsResult) > 0 && $configDepart->p90_autprotocolo == 't') {//15, 167
          $sSQL = "
            select p107_protocolo from autprotpagordem where p107_codord = {$autorizacao->e53_codord}
          ";
          $ordemAutorizada = db_query($sSQL);

          if (pg_num_rows($ordemAutorizada) > 0) {
            break;
          } else {
            $resultado = autorizarOrdemPagamento($autorizacao->e53_codord, $oParam->protocolo, $data);
            if ($resultado == false) {
              throw new Exception ("Erro ao liberar ordem de pagamento!");
            }
          }

        }
    }
  } catch (Exception $e) {
    $oRetorno->erro = $e->getMessage();
    $oRetorno->status   = 2;
  }

  break;

  case "insereSlip";

  try {

    $verifica = false;


    foreach ($oParam->slip as $slip) {

        $verifica = verificaSlip($slip->k17_codigo, $oParam->protocolo);
        if ($verifica == true) {
          throw new Exception("O Slip ".$slip->k17_codigo." já existe para este protocolo!");
        }

        $oSlip = new cl_protslip;
        $oSlip->p106_slip    = $slip->k17_codigo;
        $oSlip->p106_protocolo = $oParam->protocolo;
        $oSlip->incluir(null);

        if ($oSlip->erro_status != 1) {
          throw new Exception($oSlip->erro_msg);
        }

        $rsProtocolo = buscaProtocolo($oParam->protocolo);
        $protocolo   = db_utils::fieldsMemory($rsProtocolo,0);
        $departorig  = $protocolo->p101_coddeptoorigem;
        $departdest  = $protocolo->p101_coddeptodestino;

        $rsConfig  = db_query("
                        select p90_autprotocolo from protparam where p90_instit = {$oParam->instit}");
          $configDepart = db_utils::fieldsMemory($rsConfig,0);

          $sSQL = " SELECT p109_sequencial
                      FROM protconfigdepartaut
                        INNER JOIN db_depart dog ON dog.coddepto = p109_coddeptoorigem
                        INNER JOIN db_depart dd ON dd.coddepto = p109_coddeptodestino
                        INNER JOIN db_config ON codigo = p109_instit
                          WHERE p109_instit =  {$oParam->instit}
                           AND p109_coddeptoorigem = {$departorig}
                           AND p109_coddeptodestino = {$departdest}
                  ";
          $rsResult = db_query($sSQL);
          if (pg_num_rows($rsResult) > 0 && $configDepart->p90_autprotocolo == 't') {//15, 167

          $sSQL = "
            select p108_protocolo from autprotslip where p108_slip = {$slip->k17_codigo}
          ";
          $slipAutorizada = db_query($sSQL);
          if (pg_num_rows($slipAutorizada) > 0) {
            break;
          } else {
            $resultado = autorizarSlip($slip->k17_codigo, $oParam->protocolo, $data);
            if ($resultado == false) {
              throw new Exception ("Erro ao liberar slip!");
            }
          }
        }
    }

  } catch (Exception $e) {
    $oRetorno->erro = $e->getMessage();
    $oRetorno->status   = 2;
  }

  break;

  case "pesquisaAutProtocolos";

    try {

      $rsBusca = buscaAutEmpenhos($oParam->protocolo);
      $aAutEmpenhos = db_utils::getCollectionByRecord($rsBusca);
      $oRetorno->id_usuario = buscaIdProtocolo($oParam->protocolo);
      $oRetorno->autempenhos = array();

      foreach ($aAutEmpenhos as $aAutEmpenho) {

        $oAutEmepenho = new stdClass();
        $oAutEmepenho->autorizacao = $aAutEmpenho->e54_autori;
        $oAutEmepenho->razao       = $aAutEmpenho->z01_nome;
        $oAutEmepenho->emissao     = $aAutEmpenho->e54_emiss;
        $oAutEmepenho->valor       = $aAutEmpenho->e55_vltot;

        $oRetorno->autempenhos[] = $oAutEmepenho;

      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case "pesquisaEmpProtocolos";

    try {

      $rsBusca = buscaEmpenhos($oParam->protocolo);
      $aEmpenhos = db_utils::getCollectionByRecord($rsBusca);
      $oRetorno->id_usuario = buscaIdProtocolo($oParam->protocolo);
      $oRetorno->empenhos = array();

      foreach ($aEmpenhos as $aEmpenho) {

        $oEmpenho = new stdClass();
        $oEmpenho->autorizacao = $aEmpenho->e60_codemp;
        $oEmpenho->razao       = $aEmpenho->z01_nome;
        $oEmpenho->emissao     = $aEmpenho->e60_emiss;
        $oEmpenho->valor       = $aEmpenho->e60_vlremp;

        $oRetorno->empenhos[] = $oEmpenho;

      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case "pesquisaAutCompraProtocolos";

    try {

      $rsBusca = buscaAutCompras($oParam->protocolo);
      $aAutCompras = db_utils::getCollectionByRecord($rsBusca);
      $oRetorno->id_usuario = buscaIdProtocolo($oParam->protocolo);
      $oRetorno->autcompras = array();

      foreach ($aAutCompras as $aAutCompra) {

        $oAutCompras = new stdClass();
        $oAutCompras->autorizacao = $aAutCompra->m51_codordem;
        $oAutCompras->razao       = $aAutCompra->z01_nome;
        $oAutCompras->emissao     = $aAutCompra->m51_data;
        $oAutCompras->valor       = $aAutCompra->m51_valortotal;

        $oRetorno->autcompras[] = $oAutCompras;

      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case "pesquisaAutPagProtocolos";

    try {

      $rsBusca = buscaAutPagamentos($oParam->protocolo);
      $aAutPagamentos = db_utils::getCollectionByRecord($rsBusca);
      $oRetorno->id_usuario = buscaIdProtocolo($oParam->protocolo);
      $oRetorno->autpagamentos = array();

      foreach ($aAutPagamentos as $aAutPagamento) {

        $oAutPagamentos = new stdClass();
        $oAutPagamentos->autorizacao = $aAutPagamento->e50_codord;
        $oAutPagamentos->razao       = $aAutPagamento->z01_nome;
        $oAutPagamentos->emissao     = $aAutPagamento->e50_data;
        $oAutPagamentos->valor       = $aAutPagamento->e53_valor;
        $oAutPagamentos->autorizado  = !empty($aAutPagamento->p107_autorizado) ? $aAutPagamento->p107_autorizado : 'f';

        $oRetorno->autpagamentos[] = $oAutPagamentos;

      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case "pesquisaSlipProtocolos";

    try {

      $rsBusca = buscaSlips($oParam->protocolo);
      $aSlips = db_utils::getCollectionByRecord($rsBusca);
      $oRetorno->id_usuario = buscaIdProtocolo($oParam->protocolo);
      $oRetorno->slips = array();

      foreach ($aSlips as $aSlip) {

        $oSlips = new stdClass();
        $oSlips->autorizacao = $aSlip->k17_codigo;
        $oSlips->razao       = $aSlip->z01_nome;
        $oSlips->emissao     = $aSlip->k17_data;
        $oSlips->valor       = $aSlip->k17_valor;
        $oSlips->autorizado  = !empty($aSlip->p108_autorizado) ? $aSlip->p108_autorizado : 'f';

        $oRetorno->slips[] = $oSlips;

      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case "alteraProtocolo";

    try {
      $observacao = utf8_decode($oParam->observacao);
      $resultado = db_query("
        BEGIN;
          update protocolos
            set p101_coddeptodestino = {$oParam->destino}, p101_observacao = '{$observacao}' where p101_sequencial = {$oParam->protocolo};
        COMMIT;
      ");

      if ($resultado == false) {
        throw new Exception ("Erro ao realizar alteração do protocolo!");
      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case "anularProtocolo";

    try {

      $resultado = db_query("
        BEGIN;
          update protocolos
            set p101_dt_anulado = '".date("Y-m-d")."' where p101_sequencial = {$oParam->protocolo};
        COMMIT;
      ");

      if ($resultado == false) {
        throw new Exception ("Erro ao anular protocolo!");
      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case "excluirAutEmpenhos";

    try {

      $resultado = db_query("
            select p102_sequencial
              from protempautoriza
                where p102_protocolo = {$oParam->protocolo} and p102_autorizacao in (".implode(",",$oParam->autempenhos).")
      ");

      $aAutEmpenhos = db_utils::getCollectionByRecord($resultado);
      foreach ($aAutEmpenhos as $aAutEmpenho) {
        $resultado = excluirAutEmpenhos($aAutEmpenho->p102_sequencial);
        if ($resultado == false) {
          throw new Exception ("Erro ao excluir Autorização de Empenho!");
        }
      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case "excluirEmpenhos";

    try {

      $resultado = db_query("
        select protempenhos.p103_sequencial
          from protempenhos
            inner join empempenho on empempenho.e60_numemp = protempenhos.p103_numemp
              where protempenhos.p103_protocolo = {$oParam->protocolo} and empempenho.e60_codemp in (".implode(",",$oParam->empenhos).")
                and empempenho.e60_anousu in (".implode(",",$oParam->anos).")
      ");

      $aEmpenhos = db_utils::getCollectionByRecord($resultado);
      foreach ($aEmpenhos as $aEmpenho) {
        $resultado = excluirEmpenhos($aEmpenho->p103_sequencial);

        if ($resultado == false) {
          throw new Exception ("Erro ao excluir Empenho!");
        }
      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case "excluirAutCompras";

    try {

      $resultado = db_query("
        select p104_sequencial
              from protmatordem
                where p104_protocolo = {$oParam->protocolo} and p104_codordem in (".implode(",",$oParam->autcompras).")
      ");

      $aAutCompras = db_utils::getCollectionByRecord($resultado);
      foreach ($aAutCompras as $aAutCompra) {
        $resultado = excluirAutCompra($aAutCompra->p104_sequencial);

        if ($resultado == false) {
          throw new Exception ("Erro ao excluir Autorização de Compra!");
        }
      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case "excluirAutPagamentos";

    try {

      $resultado = db_query("
        select p105_sequencial, p105_codord
              from protpagordem
                where p105_protocolo = {$oParam->protocolo} and p105_codord in (".implode(",",$oParam->autpagamentos).")
      ");

      $aAutPagamentos = db_utils::getCollectionByRecord($resultado);
      foreach ($aAutPagamentos as $aAutPagamento) {
        $sSQL = "
          select p107_sequencial from autprotpagordem where p107_codord = {$aAutPagamento->p105_codord} and p107_protocolo = {$oParam->protocolo}
        ";
        $ordemAutorizada = db_query($sSQL);
        $aOrdemAutorizada = db_utils::fieldsMemory($ordemAutorizada, 0);
        if (pg_num_rows($ordemAutorizada) > 0) {
          $excluir = db_query("
            BEGIN; delete from autprotpagordem where p107_sequencial = {$aOrdemAutorizada->p107_sequencial}; COMMIT;
          ");
          if ($excluir == false) {
            throw new Exception ("Erro ao excluir a liberação da ordem de pagamento!");
          }
        }

        $resultado = excluirAutPagamento($aAutPagamento->p105_sequencial);
        if ($resultado == false) {
          throw new Exception ("Erro ao excluir Autorização de Pagamento!");
        }
      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case "excluirSlips";

    try {

      $resultado = db_query("
        select p106_sequencial, p106_slip
              from protslip
                where p106_protocolo = {$oParam->protocolo} and p106_slip in (".implode(",",$oParam->slips).")
      ");

      $aSlips = db_utils::getCollectionByRecord($resultado);
      foreach ($aSlips as $aSlip) {
        $sSQL = " select p108_sequencial from autprotslip where p108_slip = {$aSlip->p106_slip} and p108_protocolo = {$oParam->protocolo} ";
        $slipAutorizada = db_query($sSQL);
        $aSlipAutorizada = db_utils::fieldsMemory($slipAutorizada, 0);
        if (pg_num_rows($slipAutorizada) > 0) {
          $excluir = db_query("
            BEGIN; delete from autprotslip where p108_sequencial = {$aSlipAutorizada->p108_sequencial}; COMMIT;
          ");
          if ($excluir == false) {
            throw new Exception ("Erro ao excluir a liberação do slip!");
          }
        }

        $resultado = excluirSlip($aSlip->p106_sequencial);
        if ($resultado == false) {
          throw new Exception ("Erro ao excluir Slip!");
        }
      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }
  break;

  case 'buscaDepartamentosConfig';

    $sSQL = " SELECT p109_sequencial,
               p109_coddeptoorigem,
               dog.descrdepto origem,
               p109_coddeptodestino,
               dd.descrdepto destino
                FROM protconfigdepartaut
                  INNER JOIN db_depart dog ON dog.coddepto = p109_coddeptoorigem
                  INNER JOIN db_depart dd ON dd.coddepto = p109_coddeptodestino
                  INNER JOIN db_config ON codigo = p109_instit
                    WHERE p109_instit =  {$oParam->instit}";
    $rsResult = db_query($sSQL);
    $aDepartConfig = db_utils::getCollectionByRecord($rsResult);
    $oRetorno->departamentos = $aDepartConfig;

  break;

  case 'excluiDepartConfig';
    try {
      $excluir = db_query("
          BEGIN; delete from protconfigdepartaut where p109_sequencial = {$oParam->p109_sequencial}; COMMIT;
        ");
        if ($excluir == false) {
          throw new Exception ("Erro ao excluir configuração!");
        }
    } catch (Exception $e) {
        $oRetorno->erro = $e;
    }
  break;

  case 'pesquisaEmpenhos';
    try{
      $oRetorno->empenhos = pesquisaIntervaloEmpenhos($oParam->inicio, $oParam->dtInicio, $oParam->fim, $oParam->dtFim);
    }catch(Exception $e){
      $oRetorno->erro = $e;
    }

  break;

  case 'pesquisaOrdens';
  try{
    $oRetorno->ordens = pesquisaOrdens($oParam->ordem_ini, $oParam->ordem_fim);
  }catch(Exception $e){
    $oRetorno->erro = $e;
  }
  break;

  case 'pesquisaSlips';
  try{
    $oRetorno->slips = pesquisaSlips($oParam->slip_ini, $oParam->slip_fim);
  }catch(Exception $e){
    $oRetorno->erro = $e;
  }
}

// Funções

function autorizarOrdemPagamento($ordempagamento, $protocolo, $data) {
  $ordemAutorizada = db_query(" select p107_sequencial from autprotpagordem where p107_codord = {$ordempagamento} ");
  try {
    $aOrdemAutorizada = db_utils::fieldsMemory($ordemAutorizada, 0);
      if (!empty($aOrdemAutorizada->p107_sequencial)) {
        $excluir = db_query("
          BEGIN; delete from autprotpagordem where p107_sequencial = {$aOrdemAutorizada->p107_sequencial}; COMMIT;
        ");
        if ($excluir == false) {
          throw new Exception ("Erro ao excluir a liberação da ordem de pagamento {$ordempagamento}!");
        }
      } else {
          $oAutProtPagOrdem = new cl_autprotpagordem;
          $oAutProtPagOrdem->p107_autorizado  = 't';
          $oAutProtPagOrdem->p107_codord      = $ordempagamento;
          $oAutProtPagOrdem->p107_protocolo   = $protocolo;
          $oAutProtPagOrdem->p107_dt_cadastro = $data;
          $oAutProtPagOrdem->incluir(null);

          if ($oAutProtPagOrdem->erro_status != 1) {
            return false;
          }
      }
  }
  catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
  }

  return true;
}

function autorizarSlip($slip, $protocolo, $data) {

  $slipAutorizada = db_query(" select p108_sequencial from autprotslip where p108_slip = {$slip} ");

  try {
    $aSlipAutorizada = db_utils::fieldsMemory($slipAutorizada, 0);
      if (!empty($aSlipAutorizada->p108_sequencial)) {
        $excluir = db_query("
          BEGIN; delete from autprotslip where p108_sequencial = {$aSlipAutorizada->p108_sequencial}; COMMIT;
        ");
        if ($excluir == false) {
          throw new Exception ("Erro ao excluir a liberação do slip {$slip}!");
        }
      } else {
          $oAutProtSlip = new cl_autprotslip;
          $oAutProtSlip->p108_autorizado  = 't';
          $oAutProtSlip->p108_slip        = $slip;
          $oAutProtSlip->p108_protocolo   = $protocolo;
          $oAutProtSlip->p108_dt_cadastro = $data;
          $oAutProtSlip->incluir(null);

          if ($oAutProtSlip->erro_status != 1) {
            return false;
          }
      }
  }
  catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
  }

  return true;
}

function buscaIdProtocolo($protocolo) {

  $sSQL = "select p101_id_usuario from protocolos where p101_sequencial = {$protocolo}";
  $rsConsulta = db_query($sSQL);
  $oId = db_utils::fieldsMemory($rsConsulta,0);
  return $oId->p101_id_usuario;
}

function excluirAutEmpenhos($autempenho) {
  $resultado = db_query("BEGIN; delete from protempautoriza where p102_sequencial = {$autempenho}; COMMIT;");
  return $resultado;
}

function excluirEmpenhos($empenho) {
  $resultado = db_query("BEGIN; delete from protempenhos where p103_sequencial = {$empenho}; COMMIT;");
  return $resultado;
}

function excluirAutCompra($autcompra) {
  $resultado = db_query("BEGIN; delete from protmatordem where p104_sequencial = {$autcompra}; COMMIT;");
  return $resultado;
}

function excluirAutPagamento($autpagamento) {
  $resultado = db_query("BEGIN; delete from protpagordem where p105_sequencial = {$autpagamento}; COMMIT;");
  return $resultado;
}

function excluirSlip($slip) {
  $resultado = db_query("BEGIN; delete from protslip where p106_sequencial = {$slip}; COMMIT;");
  return $resultado;
}

function pesquisarProtocolo($protocolo) {
  $sSQL = "
    SELECT p.p101_sequencial,
      to_char(p.p101_dt_protocolo,'DD/MM/YYYY') p101_dt_protocolo,
       p.p101_hora,
       convert_from(convert_to(p.p101_observacao,'utf-8'),'latin-1') as p101_observacao,
       to_char(p.p101_dt_anulado,'DD/MM/YYYY') p101_dt_anulado,
       o.descrdepto origem,
       d.descrdepto destino,
       u.nome
    FROM protocolos p
    INNER JOIN db_depart o ON o.coddepto = p.p101_coddeptoorigem
    INNER JOIN db_depart d ON d.coddepto = p.p101_coddeptodestino
    INNER JOIN db_usuarios u ON u.id_usuario = p.p101_id_usuario
    WHERE p.p101_sequencial = {$protocolo}
  ";

  $rsConsulta = db_query($sSQL);
  $oProtocolo = db_utils::fieldsMemory($rsConsulta,0);
  return $oProtocolo;
}

function buscaAutEmpenhos($protocolo) {
    $sSQL = "
      SELECT e54_autori,
         z01_nome,
         to_char(e54_emiss,'DD/MM/YYYY') e54_emiss,
         sum(e55_vltot) AS e55_vltot
          FROM
              (SELECT distinct(e54_autori),
                      e54_emiss,
                      e54_anulad,
                      e54_numcgm,
                      z01_nome,
                      e54_instit
               FROM empautoriza
               INNER JOIN cgm ON cgm.z01_numcgm = empautoriza.e54_numcgm
               INNER JOIN db_config ON db_config.codigo = empautoriza.e54_instit
               INNER JOIN db_usuarios ON db_usuarios.id_usuario = empautoriza.e54_login
               INNER JOIN db_depart ON db_depart.coddepto = empautoriza.e54_depto
               INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = empautoriza.e54_codcom
               INNER JOIN concarpeculiar ON concarpeculiar.c58_sequencial = empautoriza.e54_concarpeculiar
               INNER JOIN protempautoriza ON protempautoriza.p102_autorizacao = empautoriza.e54_autori
               INNER JOIN protocolos on protocolos.p101_sequencial = protempautoriza.p102_protocolo
               LEFT JOIN empempaut ON empautoriza.e54_autori = empempaut.e61_autori
               LEFT JOIN empempenho ON empempenho.e60_numemp = empempaut.e61_numemp
               LEFT JOIN empautidot ON e56_autori = empautoriza.e54_autori
               AND e56_anousu=e54_anousu
               LEFT JOIN orcdotacao ON e56_Coddot = o58_coddot
               AND e56_anousu = o58_anousu
               WHERE  protocolos.p101_sequencial = {$protocolo}
              ) AS x
          INNER JOIN empautitem ON e54_autori = e55_autori
            GROUP BY e54_autori,
                     e54_emiss,
                     e54_anulad,
                     z01_nome,
                     e54_instit
            ORDER BY e54_autori
    ";

    $rsConsulta = db_query($sSQL);
    return $rsConsulta;
}

function buscaEmpenhos($protocolo) {
    $sSQL = "
      SELECT e60_numemp,
                e60_codemp || '/' || e60_anousu as e60_codemp,
                z01_nome,
                to_char(e60_emiss,'DD/MM/YYYY') e60_emiss,
                e60_vlremp
    FROM empempenho
    INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
    INNER JOIN protempenhos ON protempenhos.p103_numemp = empempenho.e60_numemp
    INNER JOIN protocolos ON protocolos.p101_sequencial = protempenhos.p103_protocolo
    WHERE protocolos.p101_sequencial = {$protocolo}
    ORDER BY e60_anousu, CAST (e60_codemp AS INTEGER)
    ";

    $rsConsulta = db_query($sSQL);
    return $rsConsulta;
}

function buscaAutCompras($protocolo) {
    $sSQL = "
    SELECT DISTINCT matordem.m51_codordem,
                cgm.z01_nome,
                to_char(matordem.m51_data,'DD/MM/YYYY') m51_data,
                matordem.m51_valortotal
    FROM matordem
    INNER JOIN protmatordem ON protmatordem.p104_codordem = matordem.m51_codordem
    INNER JOIN protocolos ON protocolos.p101_sequencial = protmatordem.p104_protocolo
    INNER JOIN cgm ON cgm.z01_numcgm = matordem.m51_numcgm
    INNER JOIN db_depart ON db_depart.coddepto = matordem.m51_depto
    INNER JOIN matordemitem ON matordemitem.m52_codordem = matordem.m51_codordem
    INNER JOIN empempenho ON empempenho.e60_numemp = matordemitem.m52_numemp
    LEFT JOIN matordemanu ON matordemanu.m53_codordem = matordem.m51_codordem
    WHERE protocolos.p101_sequencial = {$protocolo}
    ORDER BY m51_codordem
    ";
    $rsConsulta = db_query($sSQL);
    return $rsConsulta;
}

function buscaAutPagamentos($protocolo) {
    $sSQL = "
      SELECT pagordem.e50_codord,
       cgm.z01_nome,
       to_char(e50_data,'DD/MM/YYYY') e50_data,
       pagordemele.e53_valor,
       autprotpagordem.p107_autorizado
    FROM pagordemele
    INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
    INNER JOIN protpagordem ON protpagordem.p105_codord = pagordem.e50_codord
    INNER JOIN protocolos    ON protocolos.p101_sequencial = protpagordem.p105_protocolo
    INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
    INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
    INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
      AND orcelemento.o56_anousu = empempenho.e60_anousu
    LEFT JOIN autprotpagordem on autprotpagordem.p107_codord = pagordem.e50_codord
    WHERE protocolos.p101_sequencial = {$protocolo}
    ORDER BY e50_codord
    ";
    $rsConsulta = db_query($sSQL);
    return $rsConsulta;
}

function buscaSlips($protocolo) {
    $sSQL = "
      select distinct slip.k17_codigo,
        to_char(k17_data,'DD/MM/YYYY') k17_data,
        k17_valor,
        z01_nome,
        autprotslip.p108_autorizado
         from slip
           inner join protslip on protslip.p106_slip = slip.k17_codigo
           inner join protocolos on protocolos.p101_sequencial = protslip.p106_protocolo
           left join autprotslip on autprotslip.p108_slip = slip.k17_codigo
           left join conplanoreduz r1 on r1.c61_reduz  = k17_debito
            and r1.c61_instit = k17_instit
           left join conplano c1 on c1.c60_codcon = r1.c61_codcon
            and c1.c60_anousu = r1.c61_anousu
           left join conplanoreduz r2 on r2.c61_reduz = k17_credito
            and r2.c61_instit = k17_instit
           left join conplano c2 on c2.c60_codcon = r2.c61_codcon
            and c2.c60_anousu = r2.c61_anousu
           left join slipnum on slipnum.k17_codigo = slip.k17_codigo
           left join cgm on cgm.z01_numcgm = slipnum.k17_numcgm
           left join slipprocesso on slip.k17_codigo = slipprocesso.k145_slip
              where protocolos.p101_sequencial = {$protocolo}
                order by slip.k17_codigo
    ";
    $rsConsulta = db_query($sSQL);
    return $rsConsulta;
}

function buscaProtocolo($protocolo) {
  $protocolo  = db_query("select p101_coddeptoorigem, p101_coddeptodestino from protocolos where p101_sequencial = {$protocolo}");
  return $protocolo;
}

function buscaUltProtocolo() {
  $protocolo  = db_query("select max(p101_sequencial) as p101_sequencial from protocolos");
  return $protocolo;
}

function verificaAutEmpenho($autorizacao, $protocolo) {
  $retorno = db_query("select p102_sequencial from protempautoriza where p102_autorizacao = {$autorizacao} and p102_protocolo = {$protocolo}");
  if (pg_num_rows($retorno) > 0) {
    return true;
  }
  return false;
}

function verificaEmpenho($empenho, $protocolo) {
  $retorno = db_query("select p103_sequencial from protempenhos where p103_numemp = {$empenho} and p103_protocolo = {$protocolo}");
  if (pg_num_rows($retorno) > 0) {
    return true;
  }
  return false;
}

function verificaAutCompra($autcompra, $protocolo) {
  $retorno = db_query("select p104_sequencial from protmatordem where p104_codordem = {$autcompra} and p104_protocolo = {$protocolo}");
  if (pg_num_rows($retorno) > 0) {
    return true;
  }
  return false;
}

function verificaAutPagamento($autpagamento, $protocolo) {
  $retorno = db_query("select p105_sequencial from protpagordem where p105_codord = {$autpagamento} and p105_protocolo = {$protocolo}");
  if (pg_num_rows($retorno) > 0) {
    return true;
  }
  return false;
}

function verificaSlip($slip, $protocolo) {
  $retorno = db_query("select p106_sequencial from protslip where p106_slip = {$slip} and p106_protocolo = {$protocolo}");
  if (pg_num_rows($retorno) > 0) {
    return true;
  }
  return false;
}

function salvaCopiaAutEmpenho($protocolo, $protocoloCopia) {
  try {

    $rsBusca = buscaAutEmpenhos($protocoloCopia);
    $aAutEmpenhos = db_utils::getCollectionByRecord($rsBusca);

    foreach ($aAutEmpenhos as $aAutEmpenho) {
      $verifica = false;
      $verifica = verificaAutEmpenho($aAutEmpenho->e54_autori, $protocolo);
      if ($verifica == true) {
        continue;
      }
      $oAutEmpenho = new cl_protempautoriza;
      $oAutEmpenho->p102_autorizacao = $aAutEmpenho->e54_autori;
      $oAutEmpenho->p102_protocolo   = $protocolo;
      $oAutEmpenho->incluir(null);

      if ($oAutEmpenho->erro_status != 1) {
        throw new Exception($oAutEmpenho->erro_msg);
      }

    }

  } catch (Exception $e) {
    $oRetorno->erro = $e->getMessage();
    $oRetorno->status   = 2;
  }

}

function salvaCopiaEmpenho($protocolo, $protocoloCopia) {
  try {

    $rsBusca = buscaEmpenhos($protocoloCopia);
    $aEmpenhos = db_utils::getCollectionByRecord($rsBusca);

    foreach ($aEmpenhos as $aEmpenho) {
      $verifica = false;
      $verifica = verificaEmpenho($aEmpenho->e60_numemp, $protocolo);
      if ($verifica == true) {
        continue;
      }
      $oEmpenho = new cl_protempenhos;
      $oEmpenho->p103_numemp    = $aEmpenho->e60_numemp;
      $oEmpenho->p103_protocolo = $protocolo;
      $oEmpenho->incluir(null);

      if ($oEmpenho->erro_status != 1) {
        throw new Exception($oEmpenho->erro_msg);
      }

    }

  } catch (Exception $e) {
    $oRetorno->erro = $e->getMessage();
    $oRetorno->status = 2;
  }
}

function pesquisaIntervaloEmpenhos($emp_inicial, $dtinicio, $emp_final, $dtfim){

  $param_ini = $emp_inicial[0];
  $param_fim = $emp_final[0];

  if($emp_inicial[0] && $emp_final[0]){
    if($emp_inicial[1] && !$emp_final[1]){
      $emp_final[1] = $emp_inicial[1];
    }else if(!$emp_inicial[1] && $emp_final[1]){
      $emp_inicial[1] = $emp_final[1];
    }else if(!$emp_inicial[1] && !$emp_final[1] && $dtinicio){
      $dtfim = $dtinicio;
    }
  }

  if($emp_inicial[1] && $emp_final[1]){
    $dtinicio = '';
    $dtfim = '';
  }

  if($dtinicio)
    $dataInicial = split('-', $dtinicio);
  $oEmpenhos = new cl_empempenho;
  $where = '';

  if($param_ini && $param_fim){
    if($param_fim == $param_ini){
      if($dtinicio != $dtfim){
          $dtfim = $dtinicio;
      }
    }
    if($dtinicio != '' && $dtfim != ''){
      $where  = " e60_codemp::integer >= $param_ini ";
      $where .= " and e60_emiss BETWEEN '$dtinicio' AND '$dtfim' ";

      $where .= " and (CASE WHEN(e60_codemp::integer > $param_fim) ";
      $where .= " THEN (e60_emiss) < '$dtfim' ";
      $where .= " ELSE e60_codemp::integer <= $param_fim AND e60_emiss <= '$dtfim' END)";
      $where .= " and e60_instit = ".db_getsession('DB_instit');
    }
    else{
      if(!$emp_inicial[1]){
        $data = $dataInicial[0];
      }else $data = $emp_inicial[1];
      $where  = " e60_codemp::integer >= ".$emp_inicial[0]." ";
      $where .= " AND e60_anousu >= ".$data." AND e60_anousu <= ".$emp_final[1]."";
      $where .= " AND (CASE WHEN(e60_codemp::integer > $param_fim) ";
      $where .= " THEN (e60_anousu) < ".$emp_final[1]." ";
      $where .= " ELSE e60_codemp::integer <= $param_fim AND e60_anousu <= ".$emp_final[1]." END)";
      $where .= " AND e60_instit = ".db_getsession('DB_instit');
    }
  }

  if($param_ini && !$param_fim){
    $where = " e60_codemp::integer = $param_ini ";
    $where .= " and e60_instit = ".db_getsession('DB_instit');
    if(isset($dtinicio) && !$emp_inicial[1]){
      $where .= " and e60_emiss = '$dtinicio' ";
    }else $where .= " and e60_anousu = ".$emp_inicial[1]."::integer ";
  }

  if($param_fim && !$param_ini){
    $where = " e60_codemp::integer = $param_fim ";
    $where .= " and e60_instit = ".db_getsession('DB_instit');
    if(isset($dtfim) && !$param_fim){
      $where .= " and e60_emiss = '$dtfim' ";
    }else $where .= " and e60_anousu = ".$emp_final[1]."::integer ";
  }

  $campos = "distinct empempenho.e60_numemp, empempenho.e60_codemp, empempenho.e60_anousu";

  $sSql = $oEmpenhos->sql_query(null, $campos, ' e60_numemp, e60_anousu', $where,'', '100');
  $rsSql = $oEmpenhos->sql_record($sSql);


  $empenhos = db_utils::getCollectionByRecord($rsSql);
  return $empenhos;
}

function salvaCopiaAutCompra($protocolo, $protocoloCopia) {
  try {

    $rsBusca = buscaAutCompras($protocoloCopia);
    $aAutCompras = db_utils::getCollectionByRecord($rsBusca);

    foreach ($aAutCompras as $aAutCompra) {

      $verifica = false;
      $verifica = verificaAutCompra($aAutCompra->m51_codordem, $protocolo);
      if ($verifica == true) {
        continue;
      }
      $oAutCompra = new cl_protmatordem;
      $oAutCompra->p104_codordem  = $aAutCompra->m51_codordem;
      $oAutCompra->p104_protocolo = $protocolo;
      $oAutCompra->incluir(null);

      if ($oAutCompra->erro_status != 1) {
        throw new Exception($oAutCompra->erro_msg);
      }

    }

  } catch (Exception $e) {
    $oRetorno->erro = $e->getMessage();
    $oRetorno->status = 2;
  }
}

function salvaCopiaAutPagamento($protocolo, $protocoloCopia, $instituicao) {
  try {

    $rsBusca = buscaAutPagamentos($protocoloCopia);
    $aAutPagamentos = db_utils::getCollectionByRecord($rsBusca);

    $rsProtocolo = buscaProtocolo($protocolo);
    $protoDepart = db_utils::fieldsMemory($rsProtocolo,0);
    $departorig  = $protoDepart->p101_coddeptoorigem;
    $departdest  = $protoDepart->p101_coddeptodestino;

    $rsConfig  = db_query("select p90_autprotocolo from protparam where p90_instit = {$instituicao}");
    $configDepart = db_utils::fieldsMemory($rsConfig,0);

    $sSQL = " SELECT p109_sequencial
                  FROM protconfigdepartaut
                    INNER JOIN db_depart dog ON dog.coddepto = p109_coddeptoorigem
                    INNER JOIN db_depart dd ON dd.coddepto = p109_coddeptodestino
                    INNER JOIN db_config ON codigo = p109_instit
                      WHERE p109_instit =  {$instituicao}
                       AND p109_coddeptoorigem = {$departorig}
                       AND p109_coddeptodestino = {$departdest}
              ";
    $rsResult = db_query($sSQL);

    foreach ($aAutPagamentos as $aAutPagamento) {

      $verifica = false;
      $verifica = verificaAutPagamento($aAutPagamento->e50_codord, $protocolo);
      if ($verifica == true) {
        continue;
      } else {

        $oAutPagamento = new cl_protpagordem;
        $oAutPagamento->p105_codord    = $aAutPagamento->e50_codord;
        $oAutPagamento->p105_protocolo = $protocolo;
        $oAutPagamento->incluir(null);

        if ($oAutPagamento->erro_status != 1) {
          throw new Exception($oAutPagamento->erro_msg);
        }

        if (pg_num_rows($rsResult) > 0 && $configDepart->p90_autprotocolo == 't') {
          $sSQL = "
            select p107_protocolo from autprotpagordem where p107_codord = {$aAutPagamento->e50_codord}
          ";
          $ordemAutorizada = db_query($sSQL);
          if (pg_num_rows($ordemAutorizada) == 0) {
            $resultado = autorizarOrdemPagamento($aAutPagamento->e50_codord, $protocolo, date("Y-m-d"));
            if ($resultado == false) {
              throw new Exception ("Erro ao liberar ordem de pagamento!");
            }
          }

        }
      }
    }

  } catch (Exception $e) {
    $oRetorno->erro = $e->getMessage();
    $oRetorno->status = 2;
  }
}

function salvaCopiaSlip($protocolo, $protocoloCopia, $instituicao) {
  try {

    $rsBusca = buscaSlips($protocoloCopia);
    $aSlips = db_utils::getCollectionByRecord($rsBusca);

    $rsProtocolo = buscaProtocolo($protocolo);
    $protoDepart = db_utils::fieldsMemory($rsProtocolo,0);
    $departorig  = $protoDepart->p101_coddeptoorigem;
    $departdest  = $protoDepart->p101_coddeptodestino;

    $rsConfig  = db_query("select p90_autprotocolo from protparam where p90_instit = {$instituicao}");
    $configDepart = db_utils::fieldsMemory($rsConfig,0);

    $sSQL = " SELECT p109_sequencial
                  FROM protconfigdepartaut
                    INNER JOIN db_depart dog ON dog.coddepto = p109_coddeptoorigem
                    INNER JOIN db_depart dd ON dd.coddepto = p109_coddeptodestino
                    INNER JOIN db_config ON codigo = p109_instit
                      WHERE p109_instit =  {$instituicao}
                       AND p109_coddeptoorigem = {$departorig}
                       AND p109_coddeptodestino = {$departdest}
              ";
    $rsResult = db_query($sSQL);

    foreach ($aSlips as $aSlip) {

      $verifica = false;
      $verifica = verificaSlip($aSlip->k17_codigo, $protocolo);
      if ($verifica == true) {
        continue;
      } else {
          $oSlip = new cl_protslip;
          $oSlip->p106_slip      = $aSlip->k17_codigo;
          $oSlip->p106_protocolo = $protocolo;
          $oSlip->incluir(null);

          if ($oSlip->erro_status != 1) {
            throw new Exception($oSlip->erro_msg);
          }

          if (pg_num_rows($rsResult) > 0 && $configDepart->p90_autprotocolo == 't') {
            $sSQL = "
              select p108_protocolo from autprotslip where p108_slip = {$aSlip->k17_codigo}
            ";
            $ordemSlip = db_query($sSQL);
            if (pg_num_rows($ordemSlip) == 0) {
              $resultado = autorizarSlip($aSlip->k17_codigo, $protocolo, date("Y-m-d"));
              if ($resultado == false) {
                throw new Exception ("Erro ao liberar Slip!");
              }
            }

          }
      }

    }

  } catch (Exception $e) {
    $oRetorno->erro = $e->getMessage();
    $oRetorno->status = 2;
  }
}

function pesquisaOrdens($ordem_ini, $ordem_fim){
  $where = '';

  if($ordem_ini && $ordem_fim){
    $where = " and ";
    $where .= " pagordemele.e53_codord >= $ordem_ini and pagordemele.e53_codord <= $ordem_fim ";
  }

  if($ordem_ini && !$ordem_fim){
    $where = " and ";
    $where .= " pagordemele.e53_codord = $ordem_ini";
  }

  if($ordem_fim && !$ordem_ini){
    $where = " and ";
    $where .= " pagordemele.e53_codord = $ordem_fim";
  }

  $sSql = "SELECT pagordemele.e53_codord
           FROM pagordemele
           INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
           INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
           INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
           INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
           AND orcelemento.o56_anousu = empempenho.e60_anousu
           WHERE e60_instit = ".db_getsession('DB_instit')." ".$where."
           ORDER BY e53_codord, e53_codele limit 100";

  $rsSql = db_query($sSql);
  $ordens = db_utils::getCollectionByRecord($rsSql);
  return $ordens;
}

function pesquisaSlips($slip_ini, $slip_fim){
  $where = '';

  if($slip_ini && $slip_fim){
    $where = " and ";
    $where .= " slip.k17_codigo >= $slip_ini and slip.k17_codigo <= $slip_fim ";
  }

  if($slip_ini && !$slip_fim){
    $where = " and ";
    $where .= " slip.k17_codigo = $slip_ini";
  }

  if($slip_fim && !$slip_ini){
    $where = " and ";
    $where .= " slip.k17_codigo = $slip_fim";
  }

  $ano_usu = db_getsession('DB_datausu');
  $sSql = "SELECT slip.k17_codigo
              FROM slip
              LEFT JOIN conplanoreduz r1 ON r1.c61_reduz = k17_debito
              AND r1.c61_instit = k17_instit AND r1.c61_anousu = $ano_usu
              LEFT JOIN conplano c1 ON c1.c60_codcon = r1.c61_codcon
              AND c1.c60_anousu = r1.c61_anousu
              LEFT JOIN conplanoreduz r2 ON r2.c61_reduz = k17_credito
              AND r2.c61_instit = k17_instit AND r2.c61_anousu= $ano_usu
              LEFT JOIN conplano c2 ON c2.c60_codcon = r2.c61_codcon
              AND c2.c60_anousu = r2.c61_anousu
              LEFT JOIN slipnum ON slipnum.k17_codigo = slip.k17_codigo
              LEFT JOIN cgm ON cgm.z01_numcgm = slipnum.k17_numcgm
              LEFT JOIN slipprocesso ON slip.k17_codigo = slipprocesso.k145_slip
              WHERE k17_instit = ".db_getsession('DB_instit')." ".$where."
              ORDER BY slip.k17_codigo limit 100";


  $rsSql = db_query($sSql);
  $slips = db_utils::getCollectionByRecord($rsSql);
  return $slips;
}

// Fim Funções

if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);

/*
  Funções criadas para popular registros anteriores antes da rotina

  BEGIN;
SELECT fc_startsession();
create or replace
 function insere_autprotpagordem() returns void as $$

   declare
    reg record;

   begin
   -- realiza um loop e busca todas as vendas
   -- no período informado
   for reg in (
    select p105_codord, p105_protocolo, p101_dt_protocolo
     from protpagordem
      inner join protocolos on protocolos.p101_sequencial = protpagordem.p105_protocolo
      left join autprotpagordem on autprotpagordem.p107_codord = protpagordem.p105_codord
       where p101_coddeptoorigem = 31 and p101_coddeptodestino = 10
        and p107_sequencial is null
   )loop

  -- insere na tabela autprotpagordem os resultados da consulta
   insert into autprotpagordem(p107_sequencial, p107_codord, p107_protocolo, p107_dt_cadastro, p107_autorizado)
    values((select nextval('autprotpagordem_p107_sequencial_seq')),reg.p105_codord, reg.p105_protocolo, reg.p101_dt_protocolo, 't');

   end loop;
end
$$
language plpgsql;
COMMIT;



BEGIN;
 SELECT fc_startsession();
 select insere_autprotpagordem();
COMMIT;

-- Função para a tabela autprotslip
BEGIN;
SELECT fc_startsession();
create or replace
 function insere_autprotslip() returns void as $$

   declare
    reg record;

   begin
   -- realiza um loop e busca todas as vendas
   -- no período informado
   for reg in (
    select p106_slip, p106_protocolo, p101_dt_protocolo
     from protslip
      inner join protocolos on protocolos.p101_sequencial = protslip.p106_protocolo
      left join autprotslip on autprotslip.p108_slip = protslip.p106_slip
       where p101_coddeptoorigem = 31 and p101_coddeptodestino = 10
        and p108_sequencial is null
   )loop

  -- insere na tabela autprotslip os resultados da consulta
   insert into autprotslip(p108_sequencial, p108_slip, p108_protocolo, p108_dt_cadastro, p108_autorizado)
    values((select nextval('autprotslip_p108_sequencial_seq')),reg.p106_slip, reg.p106_protocolo, reg.p101_dt_protocolo, 't');

   end loop;
end
$$
language plpgsql;
COMMIT;

BEGIN;
 SELECT fc_startsession();
 select insere_autprotslip();
COMMIT;
*/

?>
