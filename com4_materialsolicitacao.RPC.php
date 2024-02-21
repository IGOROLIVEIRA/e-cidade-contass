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
require_once "libs/JSON.php";
require_once("libs/db_utils.php");
require_once("classes/db_pcdotac_classe.php");



$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->erro    = false;
$oRetorno->message = '';



try {

  db_inicio_transacao();

  switch ($oParam->exec) {

    case "distribuicaoDotacoes":


      $result_itemdotacao = db_query("select * from pcdotac where pc13_codigo = $oParam->item;");
      $itemdotacao = db_utils::fieldsMemory($result_itemdotacao, 0);
      if (pg_numrows($result_itemdotacao) == 0) {
        $clpcdotac = new cl_pcdotac;


        $reduzido =  $oParam->reduzido;
        $estrutural = $oParam->estrutural;
        $pc10_numero = $oParam->numero;
        $itens = db_query("select * from solicitem where pc11_numero = $pc10_numero and pc11_codigo = $oParam->item;");
        $quantidade_itens = pg_numrows($itens);
        $quantidade_dotacoes = 0;

        $item = db_utils::fieldsMemory($itens, 0);
        $codigo_item =  $item->pc11_codigo;
        $servico = db_query("select * from solicitempcmater inner join pcmater on pc16_codmater = pc01_codmater  where pc16_solicitem = $codigo_item ;");
        $servico = db_utils::fieldsMemory($servico, 0);
        $codele = db_query("select * from solicitemele where pc18_solicitem = $codigo_item ;");
        $codele = db_utils::fieldsMemory($codele, 0);
        $anousu = db_getsession('DB_anousu');
        $elemento =  db_query("select * from orcelemento where o56_codele = $codele->pc18_codele and o56_anousu = $anousu ;");
        $elemento = db_utils::fieldsMemory($elemento, 0);
        $elemento = substr($elemento->o56_elemento, 0, 7);

        if ($servico->pc01_servico == "f") {

          $quantidade_dotacoes = 0;

          for ($k = 0; $k < count($reduzido); $k++) {


            if ($elemento == substr($estrutural[$k], 23, 7)) {

              $quantidade_dotacoes++;

              $clpcdotac->pc13_anousu = db_getsession('DB_anousu');
              $clpcdotac->pc13_coddot = $reduzido[$k];
              $clpcdotac->pc13_depto  = db_getsession('DB_coddepto');
              $clpcdotac->pc13_quant  = $item->pc11_quant / $quantidade_dotacoes;
              $clpcdotac->pc13_valor  = $item->pc11_quant / $quantidade_dotacoes;
              $clpcdotac->pc13_codele = $codele->pc18_codele;
              $clpcdotac->pc13_codigo = $codigo_item;
              $clpcdotac->incluir(null);
            }
            //$quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
            //$rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
          }
        } else {

          if ($item->pc11_servicoquantidade == "t") {

            $quantidade_dotacoes = 0;

            for ($k = 0; $k < count($reduzido); $k++) {


              if ($elemento == substr($estrutural[$k], 23, 7)) {
                $quantidade_dotacoes++;

                $clpcdotac->pc13_anousu = db_getsession('DB_anousu');
                $clpcdotac->pc13_coddot = $reduzido[$k];
                $clpcdotac->pc13_depto  = db_getsession('DB_coddepto');
                $clpcdotac->pc13_quant  = $item->pc11_quant / $quantidade_dotacoes;
                $clpcdotac->pc13_valor  = $item->pc11_quant / $quantidade_dotacoes;
                $clpcdotac->pc13_codele = $codele->pc18_codele;
                $clpcdotac->pc13_codigo = $codigo_item;
                $clpcdotac->incluir(null);
              }
              //$quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
              //$rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
            }
          } else {

            $quantidade_dotacoes = 0;

            for ($k = 0; $k < count($reduzido); $k++) {


              if ($elemento == substr($estrutural[$k], 23, 7)) {
                $quantidade_dotacoes++;

                $clpcdotac->pc13_anousu = db_getsession('DB_anousu');
                $clpcdotac->pc13_coddot = $reduzido[$k];
                $clpcdotac->pc13_depto  = db_getsession('DB_coddepto');
                $clpcdotac->pc13_quant  = 1;
                $clpcdotac->pc13_valor  = 1;
                $clpcdotac->pc13_codele = $codele->pc18_codele;
                $clpcdotac->pc13_codigo = $codigo_item;
                $clpcdotac->incluir(null);
              }
            }
          }
        }



        $clpcdotac = new cl_pcdotac;


        $reduzido =  $oParam->reduzido;
        $estrutural = $oParam->estrutural;
        $pc10_numero = $oParam->numero;
        $itens = db_query("select * from solicitem where pc11_numero = $pc10_numero;");
        $quantidade_itens = pg_numrows($itens);

        for ($i = 0; $i < $quantidade_itens; $i++) {
          $item = db_utils::fieldsMemory($itens, $i);
          $codigo_item =  $item->pc11_codigo;
          $servico = db_query("select * from solicitempcmater inner join pcmater on pc16_codmater = pc01_codmater  where pc16_solicitem = $codigo_item ;");
          $servico = db_utils::fieldsMemory($servico, 0);
          $codele = db_query("select * from solicitemele where pc18_solicitem = $codigo_item ;");
          $codele = db_utils::fieldsMemory($codele, 0);
          $anousu = db_getsession('DB_anousu');
          $elemento =  db_query("select * from orcelemento where o56_codele = $codele->pc18_codele and o56_anousu = $anousu ;");
          $elemento = db_utils::fieldsMemory($elemento, 0);
          $elemento = substr($elemento->o56_elemento, 0, 7);

          if ($servico->pc01_servico == "f") {
            $quantidade_dotacoes = 0;

            for ($k = 0; $k < count($reduzido); $k++) {
              if ($elemento == substr($estrutural[$k], 23, 7)) {
                $quantidade_dotacoes++;
              }
            }


            if ($quantidade_dotacoes > 0) {

              $quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
              $rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
            }
          } else {

            if ($item->pc11_servicoquantidade == "t") {

              $quantidade_dotacoes = 0;

              for ($k = 0; $k < count($reduzido); $k++) {
                if ($elemento == substr($estrutural[$k], 23, 7)) {
                  $quantidade_dotacoes++;
                }
              }


              if ($quantidade_dotacoes > 0) {
                $quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
                $rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
              }
            }
          }
        }
      }

      break;

    case "getDadosMaterial":

      if (empty($oParam->iCodigoMaterial)) {
        throw new Exception("Código do material não informado.");
      }

      $oDaoMaterial = new cl_pcmater();
      $sSqlMaterial = $oDaoMaterial->sql_query_file(null, "pcmater.pc01_complmater", null, "pc01_codmater = {$oParam->iCodigoMaterial}");
      $rsMateiral   = $oDaoMaterial->sql_record($sSqlMaterial);

      if ($oDaoMaterial->numrows < 1) {
        throw new Exception("Material {$oParam->iCodigoMaterial} não encontrado.");
      }

      $oDadosMaterial = db_utils::fieldsMemory($rsMateiral, 0);

      $oRetorno->dados = new StdClass();
      $oRetorno->dados->descricaocomplemento = urlencode($oDadosMaterial->pc01_complmater);

      break;

    case "getDadosElementos":

      $clpcmaterele = new cl_pcmaterele();

      $sql_record = $clpcmaterele->sql_record($clpcmaterele->sql_query($oParam->pc_mat, null, "o56_codele,o56_descr,o56_elemento,pc01_complmater", "o56_descr"));
      $dad_select = array();
      for ($i = 0; $i < $clpcmaterele->numrows; $i++) {
        db_fieldsmemory($sql_record, $i);

        $dad_select[$i][0] = $o56_codele;
        $dad_select[$i][1] = $o56_elemento;
        $dad_select[$i][2] = urlencode($o56_descr);
        $dad_select[$i][3] = urlencode($pc01_complmater);
      }

      $arrayRetornoEle = array();
      foreach ($dad_select as $keyRow => $Row) {

        $objValorEle = new stdClass();
        foreach ($Row as $keyCel => $cell) {

          if ($keyCel == 0) {
            $objValorEle->codigo   =  $cell;
          }
          if ($keyCel == 1) {
            $objValorEle->elemento    =  $cell;
          }
          if ($keyCel == 2) {
            $objValorEle->nome    =  $cell;
          }

          if ($keyCel == 3) {
            $objValorEle->complemento    =  $cell;
          }
        }

        $arrayRetornoEle[] = $objValorEle;
      }

      $oRetorno->dados = $arrayRetornoEle;

      break;

    case "getItens":

      $clsolicitem = new cl_solicitem;
      $res_itens = $clsolicitem->sql_record($clsolicitem->sql_query_pcmater(null, "pc11_codigo as codigo", "pc11_codigo", "pc11_numero= " . $oParam->numero));
      if ($clsolicitem->numrows > 0) {
        $virgula = "";
        $codigos = "pc11_codigo in (";
        for ($i = 0; $i < $clsolicitem->numrows; $i++) {

          db_fieldsmemory($res_itens, $i);
          $codigos .= $virgula . $codigo;
          $virgula = ", ";
        }
        $codigos .= ") and";
      }
      $sCampos = "pc01_servico,
      pc11_seq,
      pc11_codigo,
      pc11_numero,
      pc11_quant,
      pc11_servicoquantidade,
      pc01_codmater,
      case when pc16_codmater is null then substr(pc11_resum,1,40)
           else substr(pc01_descrmater,1,40)
      end as pc01_descrmater,
      m61_descr,
      m61_codmatunid,
      pc18_codele,
      o56_codele,
      o56_descr,
      o56_elemento";
      $sql = $clsolicitem->sql_query_item_processo_compras(null, $sCampos, "pc11_seq desc", "$codigos pc11_numero= " . $oParam->numero);
      $rsResult = db_query($sql);

      $aItens          = array();

      for ($i = 0; $i < pg_numrows($rsResult); $i++) {
        $oItem = new stdClass();
        $item = db_utils::fieldsMemory($rsResult, $i);
        $oItem->pc11_seq =  $item->pc11_seq;
        $oItem->pc01_codmater =  $item->pc01_codmater;
        $oItem->pc01_descrmater =  urlencode($item->pc01_descrmater);
        $oItem->pc11_codigo = $item->pc11_codigo;
        $oItem->m61_descr =   urlencode($item->m61_descr);
        $oItem->m61_codmatunid =  $item->m61_codmatunid;
        $oItem->pc11_quant =  $item->pc11_quant;
        $oItem->pc11_servicoquantidade =  $item->pc11_servicoquantidade;
        $oItem->pc18_codele =  $item->pc18_codele;
        $oItem->o56_codele = $item->o56_codele;
        $oItem->o56_elemento  =  $item->o56_elemento;
        $oItem->o56_descr = urlencode($item->o56_descr);
        $oItem->pc01_servico = $item->pc01_servico;


        $aItens[] = $oItem;
      }

      $oRetorno->quantidade = pg_numrows($rsResult);
      $oRetorno->aItens = $aItens;
      $oRetorno->sql = $sql;
      break;

    case "getDotacoes":

      $anousu = db_getsession('DB_anousu');
      $sql = "select o58_coddot,fc_estruturaldotacao(o58_anousu,o58_coddot) as o50_estrutdespesa from orcdotacao
      inner join orcelemento on o56_codele = o58_codele and o56_anousu = o58_anousu
      where o58_coddot in ((select distinct pc13_coddot from solicitem
      inner join pcdotac on pc11_codigo = pc13_codigo where pc11_numero = $oParam->numero)) and o58_anousu = $anousu";
      $rsResult = db_query($sql);

      $aItens = array();

      for ($i = 0; $i < pg_numrows($rsResult); $i++) {
        $oItem = new stdClass();
        $item = db_utils::fieldsMemory($rsResult, $i);
        $oItem->reduzido =  $item->o58_coddot;
        $oItem->estrutural =  $item->o50_estrutdespesa;

        $aItens[] = $oItem;
      }

      $oRetorno->quantidade = pg_numrows($rsResult);
      $oRetorno->aItens = $aItens;
      $oRetorno->sql = $sql;
      break;



    case "getDotacoesProcItens":
      $licitacao = $oParam->licitacao;
      $anousu = db_getsession('DB_anousu');
      $sql = " select distinct o58_coddot,fc_estruturaldotacao(o58_anousu,o58_coddot) as o50_estrutdespesa,o56_elemento from pcdotac
      inner join orcdotacao on o58_coddot = pc13_coddot
      inner join orcelemento on o56_codele = o58_codele and o56_anousu = o58_anousu
      where o58_anousu = $anousu and pc13_codigo in (select pc11_codigo from pcprocitem inner join solicitem on pc81_solicitem = pc11_codigo
      where pc81_codprocitem in (select l21_codpcprocitem from liclicitem where l21_codliclicita = $licitacao));";
      $rsResult = db_query($sql);

      $aItens = array();

      for ($i = 0; $i < pg_numrows($rsResult); $i++) {
        $oItem = new stdClass();
        $item = db_utils::fieldsMemory($rsResult, $i);
        $oItem->reduzido =  $item->o58_coddot;
        $oItem->estrutural =  $item->o50_estrutdespesa;
        $oItem->elemento = $item->o56_elemento;

        $aItens[] = $oItem;
      }

      $oRetorno->quantidade = pg_numrows($rsResult);
      $oRetorno->aItens = $aItens;
      $oRetorno->sql = $sql;
      break;

    case "getElementos":
      $licitacao = $oParam->licitacao;
      $anousu = db_getsession('DB_anousu');
      $sql = " select * from solicitem
      inner join solicitemele on pc11_codigo = pc18_solicitem
      inner join orcelemento on o56_codele = pc18_codele
      where pc11_codigo in (select pc11_codigo from pcprocitem inner join solicitem on pc81_solicitem = pc11_codigo
       where pc81_codprocitem in (select l21_codpcprocitem from liclicitem where l21_codliclicita = $licitacao)) and o56_anousu = $anousu;";
      $rsResult = db_query($sql);

      $aItens = array();

      for ($i = 0; $i < pg_numrows($rsResult); $i++) {
        $oItem = new stdClass();
        $item = db_utils::fieldsMemory($rsResult, $i);
        $oItem->elemento = $item->o56_elemento;

        $aItens[] = $oItem;
      }

      $oRetorno->quantidade = pg_numrows($rsResult);
      $oRetorno->aItens = $aItens;
      $oRetorno->sql = $sql;
      break;

    case "excluirDotacoes":


      $clpcdotac = new cl_pcdotac;

      $licitacao = $oParam->licitacao;
      $itens_processos = db_query("select distinct pc81_codproc from pcprocitem inner join solicitem on pc81_solicitem = pc11_codigo
      where pc81_codprocitem in (select l21_codpcprocitem from liclicitem where l21_codliclicita = $licitacao)
      order by pc81_codproc ;");



      $aCodProcessos = array();
      for ($i = 0; $i < pg_numrows($itens_processos); $i++) {
        $item = db_utils::fieldsMemory($itens_processos, $i);
        $oItem = new stdClass();
        $oItem->codproc =  $item->pc81_codproc;
        $aCodProcessos[] = $oItem;
      }

      for ($i = 0; $i < count($aCodProcessos); $i++) {

        $pc81_codproc = $aCodProcessos[$i]->codproc;
        $pc10_numero = db_query("select pc11_numero from pcprocitem inner join solicitem on pc81_solicitem = pc11_codigo where pc81_codproc = $pc81_codproc limit 1;");
        $pc10_numero = db_utils::fieldsMemory($pc10_numero, 0);
        $pc10_numero = $pc10_numero->pc11_numero;


        $reduzido =  $oParam->reduzido;
        $estrutural = $oParam->estrutural;
        $itens = db_query("select * from solicitem where pc11_numero = $pc10_numero;");
        $quantidade_itens = pg_numrows($itens);
        $quantidade_dotacoes = 0;
        $dotacao = $oParam->dotacao;
        $elemento_dotacao = $oParam->o50_estrutdespesa;

        for ($i = 0; $i < $quantidade_itens; $i++) {
          $item = db_utils::fieldsMemory($itens, $i);
          $codigo_item =  $item->pc11_codigo;
          $servico = db_query("select * from solicitempcmater inner join pcmater on pc16_codmater = pc01_codmater  where pc16_solicitem = $codigo_item ;");
          $servico = db_utils::fieldsMemory($servico, 0);
          $codele = db_query("select * from solicitemele where pc18_solicitem = $codigo_item ;");
          $codele = db_utils::fieldsMemory($codele, 0);
          $anousu = db_getsession('DB_anousu');
          $elemento =  db_query("select * from orcelemento where o56_codele = $codele->pc18_codele and o56_anousu = $anousu ;");
          $elemento = db_utils::fieldsMemory($elemento, 0);
          $elemento = substr($elemento->o56_elemento, 0, 7);

          if ($servico->pc01_servico == "f") {

            $quantidade_dotacoes = 0;


            for ($k = 0; $k < count($reduzido); $k++) {
              if ($elemento == substr($estrutural[$k], 23, 7)) {
                $quantidade_dotacoes++;
              }
            }

            if ($quantidade_dotacoes != 1) {
              $quantidade_dotacoes--;
            }


            if ($elemento == substr($elemento_dotacao, 23, 7)) {

              $quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
              $rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
            }
          } else {

            if ($item->pc11_servicoquantidade == "t") {

              $quantidade_dotacoes = 0;


              for ($k = 0; $k < count($reduzido); $k++) {
                if ($elemento == substr($estrutural[$k], 23, 7)) {
                  $quantidade_dotacoes++;
                }
              }

              if ($quantidade_dotacoes != 1) {
                $quantidade_dotacoes--;
              }


              if ($elemento == substr($elemento_dotacao, 23, 7)) {

                $quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
                $rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
              }
            }
          }
        }
      }


      $anousu = db_getsession('DB_anousu');
      $sql = "delete from pcdotac where pc13_coddot = $oParam->dotacao and
      pc13_codigo in (select pc11_codigo from pcprocitem inner join solicitem on pc81_solicitem = pc11_codigo
      where pc81_codprocitem in (select l21_codpcprocitem from liclicitem where l21_codliclicita = $oParam->licitacao));";
      $rsResult = db_query($sql);

      $oRetorno->sql = $sql;

      if (!$rsResult) {
        $oRetorno->erro  = true;
        $oRetorno->message = "Erro ao excluir dotação";
      }

      break;
    case "excluirDotacoesCompras":

      $clpcdotac = new cl_pcdotac;


      $reduzido =  $oParam->reduzido;
      $estrutural = $oParam->estrutural;
      $pc10_numero = $oParam->numero;
      $itens = db_query("select * from solicitem where pc11_numero = $pc10_numero;");
      $quantidade_itens = pg_numrows($itens);
      $quantidade_dotacoes = 0;
      $dotacao = $oParam->dotacao;
      $elemento_dotacao = $oParam->o50_estrutdespesa;




      for ($i = 0; $i < $quantidade_itens; $i++) {
        $item = db_utils::fieldsMemory($itens, $i);
        $codigo_item =  $item->pc11_codigo;
        $servico = db_query("select * from solicitempcmater inner join pcmater on pc16_codmater = pc01_codmater  where pc16_solicitem = $codigo_item ;");
        $servico = db_utils::fieldsMemory($servico, 0);
        $codele = db_query("select * from solicitemele where pc18_solicitem = $codigo_item ;");
        $codele = db_utils::fieldsMemory($codele, 0);
        $anousu = db_getsession('DB_anousu');
        $elemento =  db_query("select * from orcelemento where o56_codele = $codele->pc18_codele and o56_anousu = $anousu ;");
        $elemento = db_utils::fieldsMemory($elemento, 0);
        $elemento = substr($elemento->o56_elemento, 0, 7);

        if ($servico->pc01_servico == "f") {

          $quantidade_dotacoes = 0;


          for ($k = 0; $k < count($reduzido); $k++) {
            if ($elemento == substr($estrutural[$k], 23, 7)) {
              $quantidade_dotacoes++;
            }
          }

          if ($quantidade_dotacoes != 1) {
            $quantidade_dotacoes--;
          }


          if ($elemento == substr($elemento_dotacao, 23, 7)) {

            $quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
            $rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
          }
        } else {

          if ($item->pc11_servicoquantidade == "t") {

            $quantidade_dotacoes = 0;


            for ($k = 0; $k < count($reduzido); $k++) {
              if ($elemento == substr($estrutural[$k], 23, 7)) {
                $quantidade_dotacoes++;
              }
            }

            if ($quantidade_dotacoes != 1) {
              $quantidade_dotacoes--;
            }


            if ($elemento == substr($elemento_dotacao, 23, 7)) {

              $quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
              $rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
            }
          }
        }
      }


      $sql = "delete from pcdotac where pc13_coddot = $oParam->dotacao and
      pc13_codigo in ((select pc11_codigo from solicitem where pc11_numero = $oParam->numero));";
      $rsResult = db_query($sql);

      $oRetorno->sql = $sql;

      echo pg_last_error();
      if (!$rsResult) {
        $oRetorno->erro  = true;
        $oRetorno->message = "Erro ao excluir dotação";
      }

      break;

    case "liberarSolicitacaoRotinaDotacao":

      $pc10_numero = $oParam->numero;


      $itens = db_query("select * from solicitem where pc11_numero = $pc10_numero;");

      $quantidade_itens = pg_numrows($itens);




      for ($i = 0; $i < $quantidade_itens; $i++) {
        $item = db_utils::fieldsMemory($itens, $i);
        $pc11_codigo =  $item->pc11_codigo;
        $result = db_query("select * from pcdotac where pc13_codigo = $pc11_codigo;");
        $resultpcmater = db_query("select * from solicitempcmater where pc16_solicitem = $pc11_codigo;");
        $pcmater = db_utils::fieldsMemory($resultpcmater, 0);

        if (pg_numrows($result) == 0) {
          $oRetorno->erro  = true;
          throw new Exception(" Usuário: Item $pcmater->pc16_codmater sem dotação vinculada.");
        }
      }


      $rsResult = db_query("UPDATE solicitem SET pc11_liberado = true WHERE pc11_numero = $pc10_numero");
      $rsResult = db_query("UPDATE solicita SET pc10_correto = true WHERE pc10_numero = $pc10_numero");



      /* Ordenação do sequencial dos itens  */
      $aItens  = array();

      $itens = db_query("select * from solicitem where pc11_numero = $pc10_numero;");


      $quantidade_itens = pg_numrows($itens);

      for ($i = 0; $i < $quantidade_itens; $i++) {
        $item = db_utils::fieldsMemory($itens, $i);
        $oItem = new stdClass();
        $oItem->pc11_codigo = $item->pc11_codigo;
        $oItem->pc11_seq = $item->pc11_seq;
        $aItens[] = $oItem;
      }

      // Ordenação dos arrays conforme sequencial

      usort(

        $aItens,

        function ($a, $b) {

          if ($a->pc11_seq == $b->pc11_seq) return 0;

          return (($a->pc11_seq < $b->pc11_seq) ? -1 : 1);
        }
      );

      for ($i = 0; $i < count($aItens); $i++) {
        $aItens[$i]->pc11_seq = $i + 1;
        $sequencial = $aItens[$i]->pc11_seq;
        $codigo = $aItens[$i]->pc11_codigo;
        $rsResult = db_query("UPDATE solicitem SET pc11_seq = $sequencial WHERE pc11_codigo = $codigo");

        if (!$rsResult) {
          $oRetorno->erro  = true;
          $oRetorno->message = "Erro ao realziar ordenação do sequencial dos itens da solicitação";
        }
      }

      $oRetorno->message =  urlencode($oRetorno->message);

      break;


    case "liberarSolicitacao":
      $pc10_numero = $oParam->numero;
      $rsResult = db_query("UPDATE solicitem SET pc11_liberado = true WHERE pc11_numero = $pc10_numero");

      if (!$rsResult) {
        $oRetorno->erro  = true;
        $oRetorno->message = "Erro ao liberar solicitação";
      }

      $rsResult = db_query("UPDATE solicita SET pc10_correto = true WHERE pc10_numero = $pc10_numero");

      if (!$rsResult) {
        $oRetorno->erro  = true;
        $oRetorno->message = "Erro ao liberar solicitação";
      }

      /* Ordenação do sequencial dos itens  */
      $aItens  = array();

      $itens = db_query("select * from solicitem where pc11_numero = $pc10_numero;");

      if (!$itens) {
        $oRetorno->erro  = true;
        $oRetorno->message = "Erro ao consultar itens da solicitação";
      }

      $quantidade_itens = pg_numrows($itens);

      for ($i = 0; $i < $quantidade_itens; $i++) {
        $item = db_utils::fieldsMemory($itens, $i);
        $oItem = new stdClass();
        $oItem->pc11_codigo = $item->pc11_codigo;
        $oItem->pc11_seq = $item->pc11_seq;
        $aItens[] = $oItem;
      }

      // Ordenação dos arrays conforme sequencial

      usort(

        $aItens,

        function ($a, $b) {

          if ($a->pc11_seq == $b->pc11_seq) return 0;

          return (($a->pc11_seq < $b->pc11_seq) ? -1 : 1);
        }
      );

      for ($i = 0; $i < count($aItens); $i++) {
        $aItens[$i]->pc11_seq = $i + 1;
        $sequencial = $aItens[$i]->pc11_seq;
        $codigo = $aItens[$i]->pc11_codigo;
        $rsResult = db_query("UPDATE solicitem SET pc11_seq = $sequencial WHERE pc11_codigo = $codigo");

        if (!$rsResult) {
          $oRetorno->erro  = true;
          $oRetorno->message = "Erro ao realziar ordenação do sequencial dos itens da solicitação";
        }
      }

      $oRetorno->message =  urlencode($oRetorno->message);

      break;

    case "salvarDotacoes":

      $clpcdotac = new cl_pcdotac;


      $reduzido =  $oParam->reduzido;
      $estrutural = $oParam->estrutural;
      $pc10_numero = $oParam->numero;
      $itens = db_query("select * from solicitem where pc11_numero = $pc10_numero;");
      $quantidade_itens = pg_numrows($itens);
      $quantidade_dotacoes = 0;
      $dotacao = $oParam->dotacao;
      $elemento_dotacao = $oParam->o50_estrutdespesa;

      for ($i = 0; $i < $quantidade_itens; $i++) {
        $item = db_utils::fieldsMemory($itens, $i);
        $codigo_item =  $item->pc11_codigo;
        $servico = db_query("select * from solicitempcmater inner join pcmater on pc16_codmater = pc01_codmater  where pc16_solicitem = $codigo_item ;");
        $servico = db_utils::fieldsMemory($servico, 0);
        $codele = db_query("select * from solicitemele where pc18_solicitem = $codigo_item ;");
        $codele = db_utils::fieldsMemory($codele, 0);
        $anousu = db_getsession('DB_anousu');
        $elemento =  db_query("select * from orcelemento where o56_codele = $codele->pc18_codele and o56_anousu = $anousu ;");
        $elemento = db_utils::fieldsMemory($elemento, 0);
        $elemento = substr($elemento->o56_elemento, 0, 7);

        if ($servico->pc01_servico == "f") {

          $quantidade_dotacoes = 0;

          // Verificando se item já possui a dotação a ser lançada
          $result =  db_query("select * from pcdotac where pc13_codigo = $codigo_item and pc13_coddot = $dotacao;");


          for ($k = 0; $k < count($reduzido); $k++) {
            if ($elemento == substr($estrutural[$k], 23, 7)) {
              $quantidade_dotacoes++;
            }
          }


          if (pg_numrows($result) == 0 && $elemento == substr($elemento_dotacao, 23, 7)) {

            $clpcdotac->pc13_anousu = db_getsession('DB_anousu');
            $clpcdotac->pc13_coddot = $dotacao;
            $clpcdotac->pc13_depto  = db_getsession('DB_coddepto');
            $clpcdotac->pc13_quant  = $item->pc11_quant / $quantidade_dotacoes;
            $clpcdotac->pc13_valor  = $item->pc11_quant / $quantidade_dotacoes;
            $clpcdotac->pc13_codele = $codele->pc18_codele;
            $clpcdotac->pc13_codigo = $codigo_item;
            $clpcdotac->incluir(null);
            $quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
            $rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
          }
        } else {

          if ($item->pc11_servicoquantidade == "t") {

            $quantidade_dotacoes = 0;

            // Verificando se item já possui a dotação a ser lançada
            $result =  db_query("select * from pcdotac where pc13_codigo = $codigo_item and pc13_coddot = $dotacao;");
            for ($k = 0; $k < count($reduzido); $k++) {
              if ($elemento == substr($estrutural[$k], 23, 7)) {
                $quantidade_dotacoes++;
              }
            }

            if (pg_numrows($result) == 0 && $elemento == substr($elemento_dotacao, 23, 7)) {



              $clpcdotac->pc13_anousu = db_getsession('DB_anousu');
              $clpcdotac->pc13_coddot = $dotacao;
              $clpcdotac->pc13_depto  = db_getsession('DB_coddepto');
              $clpcdotac->pc13_quant  = $item->pc11_quant / $quantidade_dotacoes;
              $clpcdotac->pc13_valor  = $item->pc11_quant / $quantidade_dotacoes;
              $clpcdotac->pc13_codele = $codele->pc18_codele;
              $clpcdotac->pc13_codigo = $codigo_item;
              $clpcdotac->incluir(null);
              $quantidade_valor =  $item->pc11_quant / $quantidade_dotacoes;
              $rsResult = db_query("UPDATE pcdotac SET pc13_quant = $quantidade_valor,pc13_valor = $quantidade_valor WHERE pc13_codigo = $codigo_item");
            }
          } else {

            $quantidade_dotacoes = 0;


            // Verificando se item já possui a dotação a ser lançada
            $result =  db_query("select * from pcdotac where pc13_codigo = $codigo_item and pc13_coddot = $dotacao;");
            for ($k = 0; $k < count($reduzido); $k++) {
              if ($elemento == substr($estrutural[$k], 23, 7)) {
                $quantidade_dotacoes++;
              }
            }


            if (pg_numrows($result) == 0 && $elemento == substr($elemento_dotacao, 23, 7)) {



              $clpcdotac->pc13_anousu = db_getsession('DB_anousu');
              $clpcdotac->pc13_coddot = $dotacao;
              $clpcdotac->pc13_depto  = db_getsession('DB_coddepto');
              $clpcdotac->pc13_quant  = 1;
              $clpcdotac->pc13_valor  = 1;
              $clpcdotac->pc13_codele = $codele->pc18_codele;
              $clpcdotac->pc13_codigo = $codigo_item;
              $clpcdotac->incluir(null);
            }
          }
        }
      }

      $oRetorno->message = $clpcdotac->erro_sql;


      break;
  }

  db_fim_transacao(false);
} catch (Exception $eErro) {

  db_fim_transacao(true);
  $oRetorno->erro  = true;
  $oRetorno->message = urlencode($eErro->getMessage());
}


echo $oJson->encode($oRetorno);
