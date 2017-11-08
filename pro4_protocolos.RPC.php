<?php
//ini_set("display_errors", true);
require_once('classes/db_protocolos_classe.php');
require_once('classes/db_protempautoriza_classe.php');
require_once('classes/db_protempenhos_classe.php');
require_once('classes/db_protmatordem_classe.php');
require_once('classes/db_protpagordem_classe.php');
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
$instituicao = db_getsession("DB_instit");
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$data = date("Y-m-d");


switch ($oParam->exec) {

  case "pesquisaProtocolo";

    try {

      $oRetorno->protocolo = pesquisarProtocolo($oParam->protocolo);

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
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

      $rsProtocolo = buscaProtocolo();
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

      $verifica = false;
      $verifica = verificaEmpenho($oParam->empenho, $oParam->protocolo);
      if ($verifica == true) {
        throw new Exception("O empenho ".$oParam->empenho." já existe para este protocolo!");
      }
      $oEmpenho = new cl_protempenhos;
      $oEmpenho->p103_numemp    = $oParam->empenho;
      $oEmpenho->p103_protocolo = $oParam->protocolo;
      $oEmpenho->incluir(null);

      if ($oEmpenho->erro_status != 1) {
        throw new Exception($oEmpenho->erro_msg);
      }

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
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

      $verifica = false;
      $verifica = verificaAutPagamento($oParam->autpagamento, $oParam->protocolo);
        if ($verifica == true) {
          throw new Exception("A autorização de pagamento ".$oParam->autpagamento." já existe para este protocolo!");
        }
        $oAutPagamento = new cl_protpagordem;
        $oAutPagamento->p105_codord    = $oParam->autpagamento;
        $oAutPagamento->p105_protocolo = $oParam->protocolo;
        $oAutPagamento->incluir(null);

        if ($oAutPagamento->erro_status != 1) {
          throw new Exception($oAutPagamento->erro_msg);
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
        $oAutEmepenho->autorizacao     = $aAutEmpenho->e54_autori;
        $oAutEmepenho->razao           = $aAutEmpenho->z01_nome;
        $oAutEmepenho->emissao         = $aAutEmpenho->e54_emiss;
        $oAutEmepenho->valor = $aAutEmpenho->e55_vltot;

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
        $oEmpenho->autorizacao     = $aEmpenho->e60_codemp;
        $oEmpenho->razao           = $aEmpenho->z01_nome;
        $oEmpenho->emissao         = $aEmpenho->e60_emiss;
        $oEmpenho->valor = $aEmpenho->e60_vlremp;

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
        $oAutCompras->autorizacao     = $aAutCompra->m51_codordem;
        $oAutCompras->razao           = $aAutCompra->z01_nome;
        $oAutCompras->emissao         = $aAutCompra->m51_data;
        $oAutCompras->valor = $aAutCompra->m51_valortotal;

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
        $oAutPagamentos->autorizacao     = $aAutPagamento->e50_codord;
        $oAutPagamentos->razao           = $aAutPagamento->z01_nome;
        $oAutPagamentos->emissao         = $aAutPagamento->e50_data;
        $oAutPagamentos->valor = $aAutPagamento->e53_valor;

        $oRetorno->autpagamentos[] = $oAutPagamentos;

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
        select p105_sequencial
              from protpagordem
                where p105_protocolo = {$oParam->protocolo} and p105_codord in (".implode(",",$oParam->autpagamentos).")
      ");

      $aAutPagamentos = db_utils::getCollectionByRecord($resultado);
      foreach ($aAutPagamentos as $aAutPagamento) {
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

}

function buscaIdProtocolo($protocolo) {

  $sSQL = "select p101_id_usuario from protocolos where p101_sequencial = {$protocolo}";
  $rsConsulta = db_query($sSQL);
  $oId = db_utils::fieldsMemory($rsConsulta,0);
  return $oId->p101_id_usuario;
}

function excluirAutEmpenhos($autempenho) {
  $resultado = db_query("
                BEGIN;
                delete
                  from protempautoriza
                    where p102_sequencial = {$autempenho};
                COMMIT;
              ");
  return $resultado;
}

function excluirEmpenhos($empenho) {
  $resultado = db_query("
                BEGIN;
                delete
                  from protempenhos
                    where p103_sequencial = {$empenho};
                COMMIT;
              ");
  return $resultado;
}

function excluirAutCompra($autcompra) {
  $resultado = db_query("
                BEGIN;
                delete
                  from protmatordem
                    where p104_sequencial = {$autcompra};
                COMMIT;
              ");
  return $resultado;
}

function excluirAutPagamento($autpagamento) {
  $resultado = db_query("
                BEGIN;
                delete
                  from protpagordem
                    where p105_sequencial = {$autpagamento};
                COMMIT;
              ");
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
  //print_r($sSQL);die;
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
    WHERE protocolos.p101_sequencial = {$protocolo} and empempenho.e60_instit = {$instituicao}
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
       pagordemele.e53_valor
    FROM pagordemele
    INNER JOIN pagordem ON pagordem.e50_codord = pagordemele.e53_codord
    INNER JOIN protpagordem ON protpagordem.p105_codord = pagordem.e50_codord
    INNER JOIN protocolos    ON protocolos.p101_sequencial = protpagordem.p105_protocolo
    INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
    INNER JOIN orcelemento ON orcelemento.o56_codele = pagordemele.e53_codele
    INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
    AND orcelemento.o56_anousu = empempenho.e60_anousu
    WHERE e60_instit = 1
        AND protocolos.p101_sequencial = {$protocolo}
    ORDER BY e50_codord
    ";
    $rsConsulta = db_query($sSQL);
    return $rsConsulta;
}

function buscaProtocolo() {
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

if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);

?>
