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

require_once("libs/db_stdlib.php");
require_once("std/db_stdClass.php");
require_once("classes/db_pctabelaitem_classe.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->excluiItem  = false;
$oRetorno->message = '';

switch ($oParam->exec) {

    case "adicionarItem" :

    try {
      db_inicio_transacao();
      $verificaItem = db_query("select pc95_sequencial
                                      from pctabelaitem
                                        where pc95_codmater = {$oParam->iCodigoItem}
                                          and pc95_codtabela = {$oParam->iCodigoTabela}");

      if (pg_num_rows($verificaItem) > 0) {
        throw new Exception("Item já adicionado nesta tabela!");
      }

      $verificaItemTabelas = db_query("select pc95_sequencial,pc95_codtabela 
      from pctabelaitem
        where pc95_codmater = {$oParam->iCodigoItem}
          ");

      $oPctabelaitem    = db_utils::fieldsMemory($verificaItemTabelas, 0);    
          

      if(pg_num_rows($verificaItemTabelas) > 0){
        throw new Exception("Item já adicionado na tabela " . $oPctabelaitem->pc95_codtabela);
      }    

      $clpctabelaitem = new cl_pctabelaitem;
      $clpctabelaitem->pc95_codmater  = $oParam->iCodigoItem;
      $clpctabelaitem->pc95_codtabela = $oParam->iCodigoTabela;
      $clpctabelaitem->incluir(null);
      if ($clpctabelaitem->erro_status == 0) {
        throw new Exception("Erro ao adicionar item.\n{$clpctabelaitem->erro_msg}");
      }
      db_fim_transacao(false);

    } catch (Exception $eErro) {

      db_fim_transacao(true);
      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
    }

    break;

    case "excluirItem" :

    try {

      db_inicio_transacao();
      $clpctabelaitem = new cl_pctabelaitem;
      $sql = " delete from pctabelaitem
                    where pc95_codtabela = {$oParam->iCodigoTabela}
                    and pc95_codmater = {$oParam->iCodigoItem}";


      $resultado = db_query($sql);
      if ($resultado == false) {
        throw new Exception("Erro ao excluir item.\n{$clpctabelaitem->erro_msg}");
      }

      $verificaAutEmpenho = db_query("select e55_item
                                from empautitem
                                where e55_item = {$oParam->iCodigoItem}");

      if (pg_num_rows($verificaAutEmpenho) > 0) {
          throw new Exception("Erro ao excluir item. Item já possui autorização de empenho");
      }

      db_fim_transacao(false);

    } catch (Exception $eErro) {

      db_fim_transacao(true);
      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());

    }
    $sWhere  = " pc95_codtabela = ".$oParam->iCodigoTabela;
    $oRetorno->aItens = $clpctabelaitem->buscarItensTabela($sWhere);

    break;

    case "getItens" :

    try {

      $clpctabelaitem = new cl_pctabelaitem;
      $sWhere  = " pc95_codtabela = ".$oParam->iCodigoTabela;

      $oRetorno->aItens = $clpctabelaitem->buscarItensTabela($sWhere);

    } catch (Exception $eErro) {

      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
    }

    break;
  }

if (isset($oRetorno->erro)) {
  $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);

?>
