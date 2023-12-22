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
require_once("model/aberturaRegistroPreco.model.php");
require_once("model/estimativaRegistroPreco.model.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("classes/db_solicitem_classe.php");
require_once("classes/db_solicitempcmater_classe.php");
require_once("classes/db_solicitemunid_classe.php");
require_once("classes/db_solicitemregistropreco_classe.php");
require_once("classes/db_historicomaterial_classe.php");
require_once("classes/db_pcmater_classe.php");
require_once("classes/db_matunid_classe.php");
include("libs/PHPExcel/Classes/PHPExcel.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = '';

switch ($oParam->exec) {

  case "salvarAbertura":

    try {

      db_inicio_transacao();

      if (isset($_SESSION["oSolicita"]) && $_SESSION["oSolicita"] instanceof aberturaRegistroPreco) {
        $oEstimativa = $_SESSION["oSolicita"];
      } else {
        $oSolicita = new aberturaRegistroPreco();
      }

      $oSolicita->setLiberado($oParam->liberado);
      $oSolicita->setResumo(db_stdClass::normalizeStringJsonEscapeString($oParam->resumo));
      $oSolicita->setDataInicio($oParam->datainicio);
      $oSolicita->setDataTermino($oParam->datatermino);
      $oSolicita->save();
      $oRetorno->iCodigoSolicita = $oSolicita->getCodigoSolicitacao();
      $_SESSION["oSolicita"] = $oSolicita;
      $aitens = $oSolicita->getItens();

      foreach ($aitens as $iIndice => $oItem) {

        $oItemRetono = new stdClass;
        $oItemRetono->codigoitem        = $oItem->getCodigoMaterial();
        $oItemRetono->descricaoitem     = $oItem->getDescricaoMaterial();
        $oItemRetono->quantidade        = $oItem->getQuantidade();
        $oItemRetono->automatico        = $oItem->isAutomatico();
        $oItemRetono->resumo            = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
        $oItemRetono->justificativa     = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
        $oItemRetono->prazo             = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
        $oItemRetono->pagamento         = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
        $oItemRetono->unidade           = $oItem->getUnidade();
        $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
        $oItemRetono->indice            = $iIndice;
        $oRetorno->itens[] = $oItemRetono;
      }
      db_fim_transacao(false);
    } catch (Exception $eErro) {

      db_fim_transacao(true);
      $oRetorno->message = urlencode($eErro->getMessage());
      $oRetorno->status  = 2;
    }
    break;
  case "salvarAberturamanutencao":

      try {
  
        db_inicio_transacao();    
        $oSolicita =  $_SESSION["oSolicita"];
        $iCodAbertura = $oSolicita->getCodigoSolicitacao();
        $aberturaRegistro = new aberturaRegistroPreco();
        $aberturaRegistro->alterarResumoAbertura(db_stdClass::normalizeStringJsonEscapeString($oParam->resumo),$iCodAbertura);
        $aberturaRegistro->alterarDataAbertura($oParam,$iCodAbertura);
        db_fim_transacao(false);
      } catch (Exception $eErro) {
  
        db_fim_transacao(true);
        $oRetorno->message = urlencode($eErro->getMessage());
        $oRetorno->status  = 2;
      }
    break;
  case "salvarEstimativa":

    try {
      db_inicio_transacao();

      if (isset($_SESSION["oSolicita"]) && $_SESSION["oSolicita"] instanceof estimativaRegistroPreco) {
        $oEstimativa = $_SESSION["oSolicita"];
      } else {

        $oEstimativa = new estimativaRegistroPreco();
        $oEstimativa->setCodigoAbertura($oParam->iAbertura);
      }

      $oEstimativa->setResumo(utf8_decode(db_stdClass::db_stripTagsJson($oParam->resumo)));
      $oEstimativa->setAlterado(true);
      $oEstimativa->save();
      $oRetorno->iCodigoSolicita = $oEstimativa->getCodigoSolicitacao();

      $aitens = $oEstimativa->getItens();
      $_SESSION["oSolicita"] = $oEstimativa;

      foreach ($aitens as $iIndice => $oItem) {

        $oItemRetono = new stdClass;
        $oItemRetono->codigoitem    = $oItem->getCodigoMaterial();
        $oItemRetono->descricaoitem = $oItem->getDescricaoMaterial();
        $oItemRetono->quantidade    = $oItem->getQuantidade();
        $oItemRetono->automatico    = $oItem->isAutomatico();
        $oItemRetono->resumo        = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
        $oItemRetono->justificativa = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
        $oItemRetono->prazo         = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
        $oItemRetono->pagamento     = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
        $oItemRetono->unidade       = $oItem->getUnidade();
        $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
        $oItemRetono->indice        = $iIndice;
        $oRetorno->itens[] = $oItemRetono;
      }
      db_fim_transacao(false);
    } catch (Exception $eErro) {

      db_fim_transacao(true);
      $oRetorno->message = urlencode($eErro->getMessage());
      $oRetorno->status  = 2;
    }

    break;

  case "alterarItemAbertura":

    try {
      db_inicio_transacao();
      $oSolicita =  $_SESSION["oSolicita"];

      $validaItens = $oSolicita->getItens();

      $aItens    = $oSolicita->getItens();
      $oItem     = $aItens[$oParam->iIndice];
      $oItem->setUnidade($oParam->iUnidade);
      $oItem->save($oSolicita->getCodigoSolicitacao());
      $aitens         = $oSolicita->getItens();

        //Salva o item na tabela historicomaterial para gerar no sicom OC20960
        $clhistoricomaterial = new cl_historicomaterial;
        $clpcmater = new cl_pcmater();
        $clmatunid = new cl_matunid();

        $db150_coditem = $oParam->iCodigoItem.$oParam->iUnidade;

        $rsPcmater = $clpcmater->sql_record($clpcmater->sql_query_file($oParam->iCodigoItem));
        $oPcmater = db_utils::fieldsmemory($rsPcmater, 0);

        $rsMatunid = $clmatunid->sql_record($clmatunid->sql_query_file($oParam->iUnidade));
        $oMatunid = db_utils::fieldsmemory($rsMatunid, 0);

        $rsHistoricoMaterial = $clhistoricomaterial->sql_record($clhistoricomaterial->sql_query(null,"*",null,"db150_coditem =$db150_coditem"));

        if(pg_num_rows($rsHistoricoMaterial) == 0 ){

            //inserir na tabela historico material
            $clhistoricomaterial->db150_tiporegistro              = 10;
            $clhistoricomaterial->db150_coditem                   = $db150_coditem;
            $clhistoricomaterial->db150_pcmater                   = $oParam->iCodigoItem;
            $clhistoricomaterial->db150_dscitem                   = substr($oPcmater->pc01_descrmater.'-'.$oPcmater->pc01_complmater,0,999);
            $clhistoricomaterial->db150_unidademedida             = $oMatunid->m61_descr;
            $clhistoricomaterial->db150_tipocadastro              = 1;
            $clhistoricomaterial->db150_justificativaalteracao    = '';
            $clhistoricomaterial->db150_mes                       = date("m", db_getsession("DB_datausu"));
            $clhistoricomaterial->db150_data                      = date("Y-m-d", db_getsession("DB_datausu"));
            $clhistoricomaterial->db150_instit                    = db_getsession('DB_instit');
            $clhistoricomaterial->incluir(null);

            if ($clhistoricomaterial->erro_status == 0) {
                $oRetorno->status  = 2;
                $oRetorno->message = urlencode($clhistoricomaterial->erro_msg);
            }
        }

      $aitens = $oSolicita->getItens();

      foreach ($aitens as $iIndice => $oItem) {

        $oItemRetono = new stdClass;
        $oItemRetono->codigoitem = $oItem->getCodigoMaterial();
        $oItemRetono->descricaoitem = $oItem->getDescricaoMaterial();
        $oItemRetono->quantidade = $oItem->getQuantidade();
        $oItemRetono->automatico = $oItem->isAutomatico();
        $oItemRetono->resumo = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
        $oItemRetono->justificativa = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
        $oItemRetono->prazo = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
        $oItemRetono->pagamento = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
        $oItemRetono->unidade = $oItem->getUnidade();
        $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
        $oItemRetono->indice = $iIndice;
        $oItemRetono->temestimativa = $lTemEstimativa;

        $oRetorno->itens[] = $oItemRetono;
      }
    
      db_fim_transacao(false);
    } catch (Exception $eErro) {

      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
      db_fim_transacao(true);
    }

    break;

  case "alterarItemAberturaManutencao":

    try {
      db_inicio_transacao();
      $oSolicita =  $_SESSION["oSolicita"];
      $iControle = 0;

      $validaItens = $oSolicita->getItens();
      if (count($validaItens) > 0) {
        foreach ($validaItens as $row) {
          if ($oParam->iCodigoItemNovo == $row->getCodigoMaterial() && $oParam->iCodigoItemNovo != $oParam->iCodigoItem) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode("O item $oParam->iCodigoItemNovo já foi adicionado!!");
            $iControle = 1;
          }
        }
      }
      if ($iControle == 0) {
        $iDescricaoLog = '';
        if($oParam->iCodigoItemNovo != $oParam->iCodigoItem){
          $iDescricaoLog .= 'TROCA DO ITEM '.$oParam->iCodigoItem.' PARA O ITEM '.$oParam->iCodigoItemNovo;
        }
        $rsUnid = db_query("select m61_descr from matunid where m61_codmatunid = ".$oParam->iUnidade);
        $oUnid = db_utils::fieldsMemory($rsUnid, 0);
        $iDescricaoLog .= ' UNIDADE '.$oUnid->m61_descr;

        $rsItens       = db_query("select * from solicitem inner  join solicitempcmater  on  solicitempcmater.pc16_solicitem = solicitem.pc11_codigo inner  join pcmater  on pcmater.pc01_codmater = solicitempcmater.pc16_codmater where pc11_numero = ".$oSolicita->getCodigoSolicitacao()." order by pc11_codigo");
        
        if (pg_num_rows($rsItens) > 0) {
          
          for ($iItem = 0; $iItem < pg_num_rows($rsItens); $iItem++) {

            $oItem = db_utils::fieldsMemory($rsItens, $iItem, false, false, true);
            $oItemSolicitacao = new itemSolicitacao($oItem->pc11_codigo);
            $aItens[]   = $oItemSolicitacao;
            unset($oItem);
          }
        }

        $oItem     = $aItens[$oParam->iIndice];
        db_query("update solicitempcmater set pc16_codmater = ".$oParam->iCodigoItemNovo." where pc16_solicitem = ".$oItem->getCodigoItemSolicitacao());
        db_query("update solicitemunid set pc17_unid = ".$oParam->iUnidade." where pc17_codigo= ".$oItem->getCodigoItemSolicitacao());

        //estimativas compilacao e vinculos 
        
        $rsVinculoSolicita = db_query("select pc53_solicitafilho,pc10_solicitacaotipo from solicitavinculo inner join solicita on pc10_numero = pc53_solicitafilho  where pc53_solicitapai = ".$oSolicita->getCodigoSolicitacao()." order by pc53_solicitafilho ");
        for ($iItens = 0; $iItens < pg_num_rows($rsVinculoSolicita); $iItens++) {
          
          
          $pc53_solicitafilho = db_utils::fieldsMemory($rsVinculoSolicita, $iItens)->pc53_solicitafilho;
          $rsItens       = db_query("select pc11_codigo from solicitem where pc11_numero = ".$pc53_solicitafilho." order by pc11_codigo");
        
          
          if (pg_num_rows($rsItens) > 0) {
            
            for ($iItem = 0; $iItem < pg_num_rows($rsItens); $iItem++) {

              $oItem = db_utils::fieldsMemory($rsItens, $iItem);
              $oItemSolicitacao = new itemSolicitacao($oItem->pc11_codigo);
              $aitens[]   = $oItemSolicitacao;
              unset($oItem);
            }
          }

          $oItem     = $aitens[$oParam->iIndice];
         
          db_query("update solicitempcmater set pc16_codmater = ".$oParam->iCodigoItemNovo." where pc16_solicitem = ".$oItem->getCodigoItemSolicitacao());
          db_query("update solicitemunid set pc17_unid = ".$oParam->iUnidade." where pc17_codigo= ".$oItem->getCodigoItemSolicitacao());
          unset($aitens);
          
        }

        //PRECO DE REFERENCIA
        $rsPrecoReferencia       = db_query("select distinct si01_sequencial,si02_sequencial,si02_coditem from precoreferencia inner join itemprecoreferencia on si02_precoreferencia = si01_sequencial inner join pcprocitem on si01_processocompra = pc81_codproc inner join solicitem on pc11_codigo = pc81_solicitem inner join solicitempcmater on pc16_solicitem = pc11_codigo inner join solicita on pc10_numero = pc11_numero where pc10_numero = (select pc53_solicitafilho from solicitavinculo inner join solicita on pc10_numero = pc53_solicitafilho  where pc53_solicitapai = ".$oSolicita->getCodigoSolicitacao()." and pc10_solicitacaotipo = 6) and si02_coditem = $oParam->iCodigoItemNovo");
             
        if (pg_num_rows($rsPrecoReferencia) > 0) {
          $oItemPreco = db_utils::fieldsMemory($rsPrecoReferencia, 0);
          db_query("update itemprecoreferencia set si02_codunidadeitem = ".$oParam->iUnidade." where si02_sequencial = ".$oItemPreco->si02_sequencial);
        }

        $rsItens       = db_query("select * from solicitem inner  join solicitempcmater  on  solicitempcmater.pc16_solicitem = solicitem.pc11_codigo inner  join pcmater  on pcmater.pc01_codmater = solicitempcmater.pc16_codmater where pc11_numero = ".$oSolicita->getCodigoSolicitacao()." order by pc11_codigo");
        
        if (pg_num_rows($rsItens) > 0) {
          
          for ($iItem = 0; $iItem < pg_num_rows($rsItens); $iItem++) {

            $oItem = db_utils::fieldsMemory($rsItens, $iItem, false, false, true);
            $oItemSolicitacao = new itemSolicitacao($oItem->pc11_codigo);
            $aItensAbertura[]   = $oItemSolicitacao;
            unset($oItem);
          }
        }
        

        foreach ($aItensAbertura as $iIndice => $oItem) {

          $oItemRetono = new stdClass;
          $oItemRetono->codigoitem = $oItem->getCodigoMaterial();
          $oItemRetono->descricaoitem = $oItem->getDescricaoMaterial();
          $oItemRetono->quantidade = $oItem->getQuantidade();
          $oItemRetono->automatico = $oItem->isAutomatico();
          $oItemRetono->resumo = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
          $oItemRetono->justificativa = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
          $oItemRetono->prazo = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
          $oItemRetono->pagamento = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
          $oItemRetono->unidade = $oItem->getUnidade();
          $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
          $oItemRetono->indice = $iIndice;
          $oItemRetono->temestimativa = $lTemEstimativa;

          $oRetorno->itens[] = $oItemRetono;
        }
        db_query("insert into db_manut_log values((select nextval('db_manut_log_manut_sequencial_seq')),'".$iDescricaoLog." REGISTRO DE PRECO ".$oSolicita->getCodigoSolicitacao()."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').",2679,2)");
      }
      db_fim_transacao(false);
    } catch (Exception $eErro) {

      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
      db_fim_transacao(true);
    }

    break;

  case "adicionarItemAbertura":

    try {

      db_inicio_transacao();
      $oSolicita =  $_SESSION["oSolicita"];

      //VALIDANDO SE JÁ FOI ADD O ITEM
      $iControle = 0;
      $validaItens = $oSolicita->getItens();
      if (count($validaItens) > 0) {
        foreach ($validaItens as $row) {
          if ($oParam->iCodigoItem == $row->getCodigoMaterial()) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode("O item $oParam->iCodigoItem já foi adicionado!!");
            $iControle = 1;
          }
        }
      }
      if ($iControle == 0) {
        if ($oSolicita->getTipoSolicitacao() == 3) {
          $oItemNovo = new  itemSolicitacao(null, $oParam->iCodigoItem);
        } else if ($oSolicita->getTipoSolicitacao() == 4) {

          $oItemNovo = new  ItemEstimativa(null, $oParam->iCodigoItem);
          $oItemNovo->setQuantidade($oParam->quantidade);
        }

        $oItemNovo->setResumo(utf8_decode(db_stdClass::db_stripTagsJson($oParam->sResumo)));
        $oItemNovo->setJustificativa(utf8_decode(db_stdClass::db_stripTagsJson($oParam->sJustificativa)));
        $oItemNovo->setPagamento(utf8_decode(db_stdClass::db_stripTagsJson($oParam->sPgto)));
        $oItemNovo->setPrazos(utf8_decode(db_stdClass::db_stripTagsJson($oParam->sPrazo)));
        $oItemNovo->setUnidade($oParam->iUnidade);
        $oItemNovo->setQuantidadeUnidade($oParam->nQuantUnidade);
        $oSolicita->addItem($oItemNovo);
        $lTemEstimativa = false;

        if ($oSolicita instanceof aberturaRegistroPreco) {
          $lTemEstimativa = $oSolicita->hasEstimativas();
        }

          //Salva o item na tabela historicomaterial para gerar no sicom OC20960
          $clhistoricomaterial = new cl_historicomaterial;
          $clpcmater = new cl_pcmater();
          $clmatunid = new cl_matunid();

          $db150_coditem = $oParam->iCodigoItem.$oParam->iUnidade;

          $rsPcmater = $clpcmater->sql_record($clpcmater->sql_query_file($oParam->iCodigoItem));
          $oPcmater = db_utils::fieldsmemory($rsPcmater, 0);

          $rsMatunid = $clmatunid->sql_record($clmatunid->sql_query_file($oParam->iUnidade));
          $oMatunid = db_utils::fieldsmemory($rsMatunid, 0);

          $rsHistoricoMaterial = $clhistoricomaterial->sql_record($clhistoricomaterial->sql_query(null,"*",null,"db150_coditem =$db150_coditem"));

          if(pg_num_rows($rsHistoricoMaterial) == 0 ){

              //inserir na tabela historico material
              $clhistoricomaterial->db150_tiporegistro              = 10;
              $clhistoricomaterial->db150_coditem                   = $db150_coditem;
              $clhistoricomaterial->db150_pcmater                   = $oParam->iCodigoItem;
              $clhistoricomaterial->db150_dscitem                   = substr($oPcmater->pc01_descrmater.'-'.$oPcmater->pc01_complmater,0,999);
              $clhistoricomaterial->db150_unidademedida             = $oMatunid->m61_descr;
              $clhistoricomaterial->db150_tipocadastro              = 1;
              $clhistoricomaterial->db150_justificativaalteracao    = '';
              $clhistoricomaterial->db150_mes                       = date("m", db_getsession("DB_datausu"));
              $clhistoricomaterial->db150_data                      = date("Y-m-d", db_getsession("DB_datausu"));
              $clhistoricomaterial->db150_instit                    = db_getsession('DB_instit');
              $clhistoricomaterial->incluir(null);

              if ($clhistoricomaterial->erro_status == 0) {
                  $oRetorno->status  = 2;
                  $oRetorno->message = urlencode($clhistoricomaterial->erro_msg);
              }
          }

        $aitens = $oSolicita->getItens();

        foreach ($aitens as $iIndice => $oItem) {

          $oItemRetono = new stdClass;
          $oItemRetono->codigoitem = $oItem->getCodigoMaterial();
          $oItemRetono->descricaoitem = $oItem->getDescricaoMaterial();
          $oItemRetono->quantidade = $oItem->getQuantidade();
          $oItemRetono->automatico = $oItem->isAutomatico();
          $oItemRetono->resumo = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
          $oItemRetono->justificativa = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
          $oItemRetono->prazo = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
          $oItemRetono->pagamento = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
          $oItemRetono->unidade = $oItem->getUnidade();
          $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
          $oItemRetono->indice = $iIndice;
          $oItemRetono->temestimativa = $lTemEstimativa;

          $oRetorno->itens[] = $oItemRetono;
        }
      }
          db_fim_transacao(false);
    } catch (Exception $eErro) {

      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
    }

    break;
  case "adicionarItemmanutencao":
    try {
      $aberturaRegistro = new aberturaRegistroPreco();
      
      $iCodAbertura = $oSolicita->getCodigoSolicitacao();

      //VALIDANDO SE JÁ FOI ADD O ITEM
      $iControle = 0;
      $validaItens = $oSolicita->getItens();
      $rsItens       = db_query("select * from solicitem inner  join solicitempcmater  on  solicitempcmater.pc16_solicitem = solicitem.pc11_codigo inner  join pcmater  on pcmater.pc01_codmater = solicitempcmater.pc16_codmater where pc11_numero = $iCodAbertura order by pc11_codigo");
      
      if (pg_num_rows($rsItens) > 0) {
        
        for ($iItem = 0; $iItem < pg_num_rows($rsItens); $iItem++) {

          $oItem = db_utils::fieldsMemory($rsItens, $iItem, false, false, true);
          $oItemSolicitacao = new itemSolicitacao($oItem->pc11_codigo);
          $validaItens[]   = $oItemSolicitacao;

          $aberturaRegistro->ordenarItemmanutencao($oItem->pc11_codigo,$iItem+1);

        }
      }

      if (count($validaItens) > 0) {
        foreach ($validaItens as $row) {
          if ($oParam->iCodigoItem == $row->getCodigoMaterial()) {
            $oRetorno->status  = 2;
            $oRetorno->message = urlencode("O item $oParam->iCodigoItem já foi adicionado!!");
            $iControle = 1;
          }
        }
      }

      //VALIDANDO SE JÁ TEM PRECO DE REFERENCIA
      $rsPrecoReferencia       = db_query("select distinct si01_sequencial from precoreferencia inner join pcprocitem on si01_processocompra = pc81_codproc inner join solicitem on pc11_codigo = pc81_solicitem inner join solicita on pc10_numero = pc11_numero where pc10_numero = (select pc53_solicitafilho from solicitavinculo inner join solicita on pc10_numero = pc53_solicitafilho  where pc53_solicitapai = $iCodAbertura and pc10_solicitacaotipo = 6)");
      
      
      if (pg_num_rows($rsPrecoReferencia) > 0) {
        $oPrecoReferencia = db_utils::fieldsMemory($rsPrecoReferencia, 0);
        $oRetorno->status  = 2;
        $oRetorno->message = urlencode("Não é possivel adicionar item, abertura já possuí preço de referencia número: $oPrecoReferencia->si01_sequencial !!");
        $iControle = 1;
      }
      if ($iControle == 0) {
        
        db_inicio_transacao();

        $iDescricaoLog = 'ADICIONADO ITEM '.$oParam->iCodigoItem;

        //Abertura
        $aberturaRegistro->adicionarItemmanutencao($iCodAbertura,$oParam,pg_num_rows($rsItens)+1,3);


        //Estimativas compilacao e vinculos 
        $rsVinculoSolicita = db_query("select pc53_solicitafilho,pc10_solicitacaotipo from solicitavinculo inner join solicita on pc10_numero = pc53_solicitafilho  where pc53_solicitapai = $iCodAbertura order by pc53_solicitafilho ");
        for ($iItens = 0; $iItens < pg_num_rows($rsVinculoSolicita); $iItens++) {
            
          $pc53_solicitafilho = db_utils::fieldsMemory($rsVinculoSolicita, $iItens)->pc53_solicitafilho;
          $pc10_solicitacaotipo = db_utils::fieldsMemory($rsVinculoSolicita, $iItens)->pc10_solicitacaotipo;
          $aberturaRegistro->adicionarItemmanutencao($pc53_solicitafilho,$oParam,pg_num_rows($rsItens)+1,$pc10_solicitacaotipo);
            
        }

        //Log
        db_query("insert into db_manut_log values((select nextval('db_manut_log_manut_sequencial_seq')),'".$iDescricaoLog." REGISTRO DE PRECO ".$oSolicita->getCodigoSolicitacao()."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').",2679,1)");

        db_fim_transacao(false);
        $lTemEstimativa = false;
        
        $rsItens       = db_query("select * from solicitem inner  join solicitempcmater  on  solicitempcmater.pc16_solicitem = solicitem.pc11_codigo inner  join pcmater  on pcmater.pc01_codmater = solicitempcmater.pc16_codmater where pc11_numero = $iCodAbertura order by pc11_codigo");
      
        if (pg_num_rows($rsItens) > 0) {
          
          for ($iItem = 0; $iItem < pg_num_rows($rsItens); $iItem++) {

            $oItem = db_utils::fieldsMemory($rsItens, $iItem, false, false, true);
            $oItemSolicitacao = new itemSolicitacao($oItem->pc11_codigo);
            $aitens[]   = $oItemSolicitacao;

          }
        }

        foreach ($aitens as $iIndice => $oItem) {

          $oItemRetono = new stdClass;
          $oItemRetono->codigoitem        = $oItem->getCodigoMaterial();
          $oItemRetono->descricaoitem     = $oItem->getDescricaoMaterial();
          $oItemRetono->quantidade        = $oItem->getQuantidade();
          $oItemRetono->automatico        = $oItem->isAutomatico();
          $oItemRetono->resumo            = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
          $oItemRetono->justificativa     = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
          $oItemRetono->prazo             = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
          $oItemRetono->pagamento         = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
          $oItemRetono->unidade           = $oItem->getUnidade();
          $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
          $oItemRetono->indice            = $iIndice;
          $oItemRetono->temestimativa     = $lTemEstimativa;
          $oRetorno->itens[] = $oItemRetono;
        }
      }
    } catch (Exception $eErro) {

      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
    }

    break;
  case "salvarItensAbertura":

    try {

      db_inicio_transacao();
      $oSolicita =  $_SESSION["oSolicita"];
      if ($oSolicita instanceof estimativaRegistroPreco) {
        $oSolicita->setAlterado(true);
      }
      $oSolicita->save();
      db_fim_transacao(false);
    } catch (Exception $eErro) {

      db_fim_transacao(true);
      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
    }
    break;

  case "clearSession":

    unset($_SESSION["oSolicita"]);
    break;

  case "pesquisarAbertura":

    try {

      $lTemEstimativa = false;
      switch ($oParam->tipo) {

        case 3:

          $oSolicita             = new aberturaRegistroPreco($oParam->iSolicitacao);
          $_SESSION["oSolicita"] = $oSolicita;
          if (count($oSolicita->getEstimativas()) > 0) {
            $lTemEstimativa = true;
          }
          break;

        case 4:

          $oSolicita             = new estimativaRegistroPreco($oParam->iSolicitacao);
          $_SESSION["oSolicita"] = $oSolicita;
          $oRetorno->lCorreto    = $oSolicita->isAlterado();

          break;
      }

      $aitens = $oSolicita->getItens();
      foreach ($aitens as $iIndice => $oItem) {

        $oItemRetono = new stdClass;
        $oItemRetono->codigoitem        = $oItem->getCodigoMaterial();
        $oItemRetono->descricaoitem     = $oItem->getDescricaoMaterial();
        $oItemRetono->quantidade        = $oItem->getQuantidade();
        $oItemRetono->automatico        = $oItem->isAutomatico();
        $oItemRetono->resumo            = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
        $oItemRetono->justificativa     = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
        $oItemRetono->prazo             = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
        $oItemRetono->pagamento         = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
        $oItemRetono->unidade           = $oItem->getUnidade();
        $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
        $oItemRetono->indice            = $iIndice;
        $oItemRetono->temestimativa     = $lTemEstimativa;
        $oRetorno->itens[] = $oItemRetono;
      }
      switch ($oSolicita->getTipoSolicitacao()) {


        case 3:

          $oRetorno->datainicio  = db_formatar($oSolicita->getDataInicio(), "d");
          $oRetorno->datatermino = db_formatar($oSolicita->getDataTermino(), "d");
          $oRetorno->liberado    = $oSolicita->isLiberado();
          break;

        case 4:

          $oRetorno->datasolicitacao = db_formatar($oSolicita->getDataSolicitacao(), "d");
          $oRetorno->codigoabertura  = $oSolicita->getCodigoAbertura();
          break;
      }

      $oRetorno->resumo      = urlencode(str_replace("\\n", "\n", urldecode($oSolicita->getResumo())));
      $oRetorno->solicitacao = $oSolicita->getCodigoSolicitacao();
    } catch (Exception $eErro) {

      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
    }
    break;

  case "excluirItens":

    try {

      db_inicio_transacao();
      $oSolicita = $_SESSION["oSolicita"];
      $oSolicita->removerItem($oParam->iItemRemover);
      db_fim_transacao(false);
      $lTemEstimativa = false;
      $aitens = $oSolicita->getItens();
      if ($oSolicita instanceof aberturaRegistroPreco) {
        if ($oSolicita->hasEstimativas()) {
          $lTemEstimativa = true;
        }
      }
      foreach ($aitens as $iIndice => $oItem) {

        $oItemRetono = new stdClass;
        $oItemRetono->codigoitem        = $oItem->getCodigoMaterial();
        $oItemRetono->descricaoitem     = $oItem->getDescricaoMaterial();
        $oItemRetono->quantidade        = $oItem->getQuantidade();
        $oItemRetono->automatico        = $oItem->isAutomatico();
        $oItemRetono->resumo            = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
        $oItemRetono->justificativa     = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
        $oItemRetono->prazo             = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
        $oItemRetono->pagamento         = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
        $oItemRetono->unidade           = $oItem->getUnidade();
        $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
        $oItemRetono->indice            = $iIndice;
        $oItemRetono->temestimativa     = $lTemEstimativa;
        $oRetorno->itens[] = $oItemRetono;
      }
      $iDescricaoLog = 'EXCLUSAO ITEM '.$oParam->iCodigoItem;
      db_query("insert into db_manut_log values((select nextval('db_manut_log_manut_sequencial_seq')),'".$iDescricaoLog." REGISTRO DE PRECO ".$oSolicita->getCodigoSolicitacao()."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').",2679,3)");
    } catch (Exception $eErro) {


      db_fim_transacao(true);
      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
      $aitens = $oSolicita->getItens();
    }
    break;
  case "alterarItens":

    try {

      db_inicio_transacao();
      $oSolicita = $_SESSION["oSolicita"];

      $aitens = $oSolicita->getItens();

      $codigo     = $aitens[$oParam->iIndice]->getCodigoMaterial();
      $quantidade = $aitens[$oParam->iIndice]->getQuantidade();

      $iCodAbertura = $oSolicita->getCodigoSolicitacao();
      
      $estimativaRegistro = new estimativaRegistroPreco();
      
      //ALTERA QUATIDADE DO ITEM
      $estimativaRegistro->adicionarQuantidade($quantidade,$codigo,$iCodAbertura);

      foreach ($aitens as $iIndice => $oItem) {

        $oItemRetono = new stdClass;
        $oItemRetono->codigoitem        = $oItem->getCodigoMaterial();
        $oItemRetono->descricaoitem     = $oItem->getDescricaoMaterial();
        $oItemRetono->quantidade        = $oItem->getQuantidade();
        $oItemRetono->automatico        = $oItem->isAutomatico();
        $oItemRetono->resumo            = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
        $oItemRetono->justificativa     = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
        $oItemRetono->prazo             = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
        $oItemRetono->pagamento         = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
        $oItemRetono->unidade           = $oItem->getUnidade();
        $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
        $oItemRetono->indice            = $iIndice;
        $oItemRetono->temestimativa     = $lTemEstimativa;
        $oRetorno->itens[] = $oItemRetono;
      }

      $oRetorno->message = urlencode("O item $codigo alterado com sucesso!!");

      $iDescricaoLog = 'ALTERACAO ITEM '.$oParam->iCodigoItem;
      db_query("insert into db_manut_log values((select nextval('db_manut_log_manut_sequencial_seq')),'".$iDescricaoLog." REGISTRO DE PRECO ".$oSolicita->getCodigoSolicitacao()."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').",2679,3)");

      db_fim_transacao(false);
    } catch (Exception $eErro) {


      db_fim_transacao(true);
      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
      $aitens = $oSolicita->getItens();
    }
    break;
  case "excluirItensManutencao":

    try {
      db_inicio_transacao();
      
      $oSolicita = $_SESSION["oSolicita"];
      //VALIDANDO SE JÁ FOI ADD O ITEM
      $iControle = 0;
      $aItens = $oSolicita->getItens();
      $descricao = '';
      if (isset($aItens[$oParam->iItemRemover])) {
        $rsPcmater = db_query("select pc16_codmater from solicitempcmater where pc16_solicitem = ".$aItens[$oParam->iItemRemover]->getCodigoItemSolicitacao());
        
        $pcmater = db_utils::fieldsMemory($rsPcmater, 0)->pc16_codmater;
        $rsVinculo = db_query("select pc55_solicitemfilho from solicitemvinculo where pc55_solicitempai = ".$aItens[$oParam->iItemRemover]->getCodigoItemSolicitacao());
        for ($iItens = 0; $iItens < pg_num_rows($rsVinculo); $iItens++) {

          $pc55_solicitemfilho = db_utils::fieldsMemory($rsVinculo, $iItens)->pc55_solicitemfilho;
          $rsItemQuant = db_query("select pc11_quant,pc10_depto from solicitem inner join solicita on pc10_numero=pc11_numero where pc11_codigo = ".$pc55_solicitemfilho);
          $quantidade = db_utils::fieldsMemory($rsItemQuant, 0)->pc11_quant;
          
          if($quantidade != 0){
            
            $iControle = 1;
            $codDepartamento = db_utils::fieldsMemory($rsItemQuant, 0)->pc10_depto;
            $rsDepart = db_query("select descrdepto from db_depart where coddepto = ".$codDepartamento);
            $descrDepart = db_utils::fieldsMemory($rsDepart, 0)->descrdepto;
            $descricao .= "\n $pc55_solicitemfilho departamento $descrDepart ";
          }
          
        }
      }
      
      if($iControle == 1){
        $oRetorno->status  = 2;
        $oRetorno->message = urlencode("Exclusão abortada. Este item possui quantidade lançada na(s) estimativa(s)".$descricao);
      }
        
      if ($iControle == 0) {
        $oSolicita->removerItem($oParam->iItemRemover);
        db_fim_transacao(false);
        $aberturaRegistro = new aberturaRegistroPreco();
      
        $iCodAbertura = $oSolicita->getCodigoSolicitacao();
     
        
        $lTemEstimativa = false;
        $rsItens       = db_query("select * from solicitem inner  join solicitempcmater  on  solicitempcmater.pc16_solicitem = solicitem.pc11_codigo inner  join pcmater  on pcmater.pc01_codmater = solicitempcmater.pc16_codmater where pc11_numero = $iCodAbertura order by pc11_codigo");
      
        if (pg_num_rows($rsItens) > 0) {
          
          for ($iItem = 0; $iItem < pg_num_rows($rsItens); $iItem++) {

            $oItem = db_utils::fieldsMemory($rsItens, $iItem, false, false, true);
            $oItemSolicitacao = new itemSolicitacao($oItem->pc11_codigo);
            $aitens[]   = $oItemSolicitacao;

            $aberturaRegistro->ordenarItemmanutencao($oItem->pc11_codigo,$iItem+1);

          }
        }

        foreach ($aitens as $iIndice => $oItem) {

          $oItemRetono = new stdClass;
          $oItemRetono->codigoitem        = $oItem->getCodigoMaterial();
          $oItemRetono->descricaoitem     = $oItem->getDescricaoMaterial();
          $oItemRetono->quantidade        = $oItem->getQuantidade();
          $oItemRetono->automatico        = $oItem->isAutomatico();
          $oItemRetono->resumo            = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
          $oItemRetono->justificativa     = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
          $oItemRetono->prazo             = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
          $oItemRetono->pagamento         = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
          $oItemRetono->unidade           = $oItem->getUnidade();
          $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
          $oItemRetono->indice            = $iIndice;
          $oItemRetono->temestimativa     = $lTemEstimativa;
          $oRetorno->itens[] = $oItemRetono;
        }
        $iDescricaoLog = 'EXCLUSAO ITEM '.$oParam->iCodigoItem;
        db_query("insert into db_manut_log values((select nextval('db_manut_log_manut_sequencial_seq')),'".$iDescricaoLog." REGISTRO DE PRECO ".$oSolicita->getCodigoSolicitacao()."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').",2679,3)");
      }
    } catch (Exception $eErro) {


      db_fim_transacao(true);
      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
      $aitens = $oSolicita->getItens();
    }
    break;
  case "salvarItensValor":

    try {

      db_inicio_transacao();
      $oSolicita = $_SESSION["oSolicita"];
      $aitens = $oSolicita->getItens();
      if (isset($aitens[$oParam->iIndice])) {
        $aitens[$oParam->iIndice]->setQuantidade($oParam->quantidade);
      }
      db_fim_transacao(true);
    } catch (Exception $eErro) {
      db_fim_transacao(true);
    }
    break;

  case "alterarItem":

    try {

      db_inicio_transacao();
      $oSolicita =  $_SESSION["oSolicita"];
      $aItens    = $oSolicita->getItens();
      $oItem     = $aItens[$oParam->iIndice];
      $oItem->setResumo(utf8_decode(db_stdClass::db_stripTagsJson($oParam->sResumo)));
      $oItem->setJustificativa(utf8_decode(db_stdClass::db_stripTagsJson($oParam->sJustificativa)));
      $oItem->setPagamento(utf8_decode(db_stdClass::db_stripTagsJson($oParam->sPgto)));
      $oItem->setPrazos(utf8_decode(db_stdClass::db_stripTagsJson($oParam->sPrazo)));
      $oItem->save();
      $aitens         = $oSolicita->getItens();
      $lTemEstimativa = false;
      if ($oSolicita instanceof aberturaRegistroPreco) {

        if (count($oSolicita->getEstimativas()) > 0) {
          $lTemEstimativa = true;
        }
      }
      foreach ($aitens as $iIndice => $oItem) {

        $oItemRetono = new stdClass;
        $oItemRetono->codigoitem        = $oItem->getCodigoMaterial();
        $oItemRetono->descricaoitem     = $oItem->getDescricaoMaterial();
        $oItemRetono->quantidade        = $oItem->getQuantidade();
        $oItemRetono->automatico        = $oItem->isAutomatico();
        $oItemRetono->resumo            = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
        $oItemRetono->justificativa     = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
        $oItemRetono->prazo             = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
        $oItemRetono->pagamento         = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
        $oItemRetono->unidade           = $oItem->getUnidade();
        $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
        $oItemRetono->indice            = $iIndice;
        $oItemRetono->temestimativa     = $lTemEstimativa;
        $oRetorno->itens[] = $oItemRetono;
      }
      db_query("insert into db_manut_log values((select nextval('db_manut_log_manut_sequencial_seq')),'ALTERACAO DE ITEM REGISTRO DE PRECO ".$oSolicita->getCodigoSolicitacao()."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').",2679,2)");
      db_fim_transacao(false);
    } catch (Exception $eErro) {

      $oRetorno->status  = 2;
      $oRetorno->message = urlencode($eErro->getMessage());
      db_fim_transacao(true);
    }

    break;

  case "getUltimosOrcamentos":

    require_once("model/itemSolicitacao.model.php");

    $oRetorno->itens   = itemSolicitacao::getUltimosOrcamentos(
      $oParam->iMaterial,
      $oParam->aUnidades,
      $oParam->iFornecedor,
      $oParam->dtInicial,
      $oParam->dtFinal
    );
    $oRetorno->media    = itemSolicitacao::calculaMediaPrecoOrcamentos($oRetorno->itens);
    $oRetorno->unidades = itemSolicitacao::getUnidadesMaterial($oParam->iMaterial);
    break;

  case 'pesquisarEstimativaDepartamento':

    if (isset($oParam->iSolicitacao)) {

      $oSolicita   = new aberturaRegistroPreco($oParam->iSolicitacao);
      $oEstimativa = $oSolicita->getEstimativaPorDepartamento(db_getsession("DB_coddepto"));
      if ($oEstimativa instanceof estimativaRegistroPreco) {

        if (!$oEstimativa->isAnulada()) {

          $sMessage          = "Departamento já possui estimativa lançada para a ";
          $sMessage         .= "Abertura de Registo de preço {$oParam->iSolicitacao}.\n";
          $sMessage         .= "Dados da estimativa:\n";
          $sMessage         .= "Número:{$oEstimativa->getCodigoSolicitacao()}.\n";
          $sMessage         .= "Data Cadastro:" . db_formatar($oEstimativa->getDataSolicitacao(), "d") . ".";
          $oRetorno->status  = 2;
          $oRetorno->message = urlencode($sMessage);
        }
      }
    }
    break;

  case 'anularSolicitacao':

    try {

      db_inicio_transacao();

      $oSolicitacaoCompras = new solicitacaoCompra($oParam->iCodigoSolicitacao);
      $oSolicitacaoCompras->anular(
        db_stdClass::normalizeStringJsonEscapeString($oParam->sMotivo),
        db_stdClass::normalizeStringJsonEscapeString($oParam->sProcessoAdministrativo)
      );

      db_fim_transacao(false);
      $oRetorno->erro = false;
      $oRetorno->mensagem = urlencode(_M('patrimonial.compras.com4_anularsolicitacaocompras001.solicitacao_anulada'));
    } catch (Exception $eErro) {

      db_fim_transacao(true);
      $oRetorno->mensagem = urlencode($eErro->getMessage());
      $oRetorno->erro = true;
    }

    break;

  case 'processaritens':

    //monto o nome do arquivo
    $dir = "libs/Pat_xls_import/";
    $files1 = scandir($dir);
    $files1 = scandir($dir, 1);
    $arquivo = "libs/Pat_xls_import/" . $files1[0];

    //verificar se existe o arquivo
    if (!file_exists($arquivo)) {
      $oRetorno->status = 2;
      $oRetorno->message = urlencode("Erro ! Arquivo de planilha nao existe.");
      $erro = true;
    } else {
      $objPHPExcel = PHPExcel_IOFactory::load($arquivo);
      $objWorksheet = $objPHPExcel->getActiveSheet();

      //monto array com todos as linhas da planilha
      foreach ($objWorksheet->getRowIterator() as $row) {
        $rowIndex = $row->getRowIndex();
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false); //varre todas as células
        foreach ($cellIterator as $cell) {
          $colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
          $val = $cell->getValue();
          $dataArr[$rowIndex][$colIndex] = $val;
        }
      }
    }


    $arrayItensPlanilha = array();
    $oRetorno->erroPlanilha = false;

    foreach ($dataArr as $keyRow => $Row) {
      $objItensPlanilha = new stdClass();



      if ($keyRow >= 2) {

        //encerra o loop caso a linha atual da planilha esteja vazia.
        if ($Row[1] == "" && $Row[2] == "") break;

        foreach ($Row as $keyCel => $cell) {

          // célula do código do material
          if ($keyCel == 1) {

            $objItensPlanilha->codmaterial = $cell;
            $objItensPlanilha->errocodmaterial = "";

            if ($objItensPlanilha->codmaterial != null) {

              $rsMaterial = db_query("select * from pcmater where pc01_codmater = $objItensPlanilha->codmaterial;");
              if (pg_numrows($rsMaterial) == 0) {
                $objItensPlanilha->errocodmaterial = "Codigo do Material nao encontrado";
                $oRetorno->erroPlanilha = true;
              }

              $rsMaterial = db_query("select * from solicitem
              inner join solicitempcmater on pc11_codigo = pc16_solicitem
              where pc11_numero = $oParam->iSolicitacao and pc16_codmater = $objItensPlanilha->codmaterial; ");

              if (pg_numrows($rsMaterial) > 0) {
                $objItensPlanilha->errocodmaterial = "Material cadastrado na solicitação";
                $oRetorno->erroPlanilha = true;
              }
            } else {
              $objItensPlanilha->errocodmaterial = "Campo em branco";
              $oRetorno->erroPlanilha = true;
            }
          }

          // célula do código da unidade
          if ($keyCel == 2) {

            $objItensPlanilha->codunidade = $cell;
            $objItensPlanilha->errocodunidade = "";

            if ($objItensPlanilha->codunidade != null) {
              $rsUnidade = db_query("select * from matunid where m61_codmatunid =  $objItensPlanilha->codunidade;");

              if (pg_numrows($rsUnidade) == 0) {
                $objItensPlanilha->errocodunidade = "Unidade nao cadastrada";
                $oRetorno->erroPlanilha = true;
              }
            } else {
              $objItensPlanilha->errocodunidade = "Campo em branco";
              $oRetorno->erroPlanilha = true;
            }
          }
        }

        $arrayItensPlanilha[] = $objItensPlanilha;
      }
    }

    $oRetorno->itensPlanilha = $arrayItensPlanilha;

    // variável que será utilizada para listagem dos itens com erro ao abrir o pop-up
    $_SESSION["aItensPlanilha"] = $arrayItensPlanilha;

    if ($oRetorno->erroPlanilha == false) {

      $clsolicitem         = new cl_solicitem;
      $clsolicitemunid     = new cl_solicitemunid;
      $clsolicitempcmater  = new cl_solicitempcmater;

      db_inicio_transacao();

      $rsSequencial = db_query("select max (pc11_seq) as sequencial from solicitem where pc11_numero = $oParam->iSolicitacao;");
      $iSquencial = db_utils::fieldsmemory($rsSequencial, 0)->sequencial;

      for ($i = 0; $i < count($arrayItensPlanilha); $i++) {

        $iSquencial++;

        $clsolicitem->pc11_numero = $oParam->iSolicitacao;
        $clsolicitem->pc11_seq    = $iSquencial;
        $clsolicitem->pc11_quant    = "0";
        $clsolicitem->pc11_vlrun  = "0";
        $clsolicitem->pc11_liberado = "t";
        $pc11_codigo = null;
        $clsolicitem->incluir(empty($pc11_codigo) ? null : $pc11_codigo);

        $clsolicitempcmater->pc16_codmater = $arrayItensPlanilha[$i]->codmaterial;
        $clsolicitempcmater->pc16_solicitem = $clsolicitem->pc11_codigo;
        $clsolicitempcmater->incluir($arrayItensPlanilha[$i]->codmaterial, $clsolicitem->pc11_codigo);

        $clsolicitemunid->pc17_unid = $arrayItensPlanilha[$i]->codunidade;
        $clsolicitemunid->pc17_quant = 1;
        $clsolicitemunid->pc17_codigo = $clsolicitem->pc11_codigo;
        $clsolicitemunid->incluir($clsolicitem->pc11_codigo);
      }

      db_fim_transacao(false);

      $oSolicita             = new aberturaRegistroPreco($oParam->iSolicitacao);
      $_SESSION["oSolicita"] = $oSolicita;

      $lTemEstimativa = false;

      if (count($oSolicita->getEstimativas()) > 0) {
        $lTemEstimativa = true;
      }


      $aitens = $oSolicita->getItens();
      foreach ($aitens as $iIndice => $oItem) {

        $oItemRetono = new stdClass;
        $oItemRetono->codigoitem        = $oItem->getCodigoMaterial();
        $oItemRetono->descricaoitem     = $oItem->getDescricaoMaterial();
        $oItemRetono->quantidade        = $oItem->getQuantidade();
        $oItemRetono->automatico        = $oItem->isAutomatico();
        $oItemRetono->resumo            = urlencode(str_replace("\\n", "\n", urldecode($oItem->getResumo())));
        $oItemRetono->justificativa     = urlencode(str_replace("\\n", "\n", urldecode($oItem->getJustificativa())));
        $oItemRetono->prazo             = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPrazos())));
        $oItemRetono->pagamento         = urlencode(str_replace("\\n", "\n", urldecode($oItem->getPagamento())));
        $oItemRetono->unidade           = $oItem->getUnidade();
        $oItemRetono->unidade_descricao = urlencode(itemSolicitacao::getDescricaoUnidade($oItemRetono->unidade));
        $oItemRetono->indice            = $iIndice;
        $oItemRetono->temestimativa     = $lTemEstimativa;
        $oRetorno->itens[] = $oItemRetono;
      }
    }
    break;
}
echo $oJson->encode($oRetorno);
