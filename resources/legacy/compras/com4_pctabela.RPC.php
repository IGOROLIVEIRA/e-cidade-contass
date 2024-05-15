<?php
//ini_set("display_errors", true);
require_once('classes/db_pctabela_classe.php');
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

  case "insereTabela":

    try {

      $verificaCodigo = db_query("select pc94_sequencial
                                      from pctabela
                                        where pc94_codmater = {$oParam->codMaterial}
                                          ");

      if (pg_num_rows($verificaCodigo) > 0) {
        throw new Exception("Já existe uma tabela com o código {$oParam->codMaterial}!");
      }

      $oTabela = new cl_pctabela;
      $oTabela->pc94_codmater    = $oParam->codMaterial;
      $oTabela->pc94_dt_cadastro = $data;
      $oTabela->incluir(null);

      if ($oTabela->erro_status != 1) {
          throw new Exception($oTabela->erro_msg);
      }

      $rsTabela = buscaTabela();
      $tabela   = db_utils::fieldsMemory($rsTabela,0);
      $oRetorno->pc94_sequencial = $tabela->pc94_sequencial;

    } catch (Exception $e) {
      $oRetorno->erro = $e->getMessage();
      $oRetorno->status   = 2;
    }

    break;

  case "excluirTabela":

    try {

      $verificaProcessos = db_query("
          SELECT * FROM (
            SELECT pc94_sequencial
                FROM liclicita
                INNER JOIN liclicitem ON liclicita.l20_codigo = liclicitem.l21_codliclicita
                INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
                INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
                INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
                INNER JOIN db_usuarios ON pcproc.pc80_usuario = db_usuarios.id_usuario
                INNER JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                INNER JOIN pcmater pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                INNER JOIN pctabela ON pctabela.pc94_codmater = pcmater.pc01_codmater
            UNION
            SELECT pc94_sequencial
                    FROM pcorcamitem
                      INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
                      INNER JOIN pcorcamitemproc ON pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem
                      INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = pcorcamitemproc.pc31_pcprocitem
                      INNER JOIN pcproc ON pcprocitem.pc81_codproc = pcproc.pc80_codproc
                      INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
                      INNER JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                      INNER JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                      INNER JOIN pctabela ON pctabela.pc94_codmater = pcmater.pc01_codmater
            ) AS tabela
                WHERE tabela.pc94_sequencial = {$oParam->codTabela}
      ");

      if (pg_num_rows($verificaProcessos) > 0) {
          throw new Exception ("Tabela está vinculada em um processo!");
      }

      $resultado1 = db_query("
                      BEGIN;
                      delete
                        from pctabelaitem
                          where pc95_codtabela = {$oParam->codTabela};
                      COMMIT;
                    ");

      if ($resultado1 == false) {
          throw new Exception ("Erro ao excluir itens da tabela!");
      } else {
        $resultado2 = db_query("
                      BEGIN;
                      delete
                        from pctabela
                          where pc94_sequencial = {$oParam->codTabela};
                      COMMIT;
                    ");
        if ($resultado2 == false) {
          throw new Exception ("Erro ao excluir itens da tabela!");
        }
      }

    } catch (Exception $e) {
      $oRetorno->erro   = $e->getMessage();
      $oRetorno->status = 2;
    }

    break;

}

function buscaTabela() {
  $tabela = db_query("select max(pc94_sequencial) as pc94_sequencial from pctabela");
  return $tabela;
}


if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);

?>

