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

//con4_empenhopassivo.RPC.php
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once('libs/db_app.utils.php');
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("std/DBTime.php");
require_once("std/DBDate.php");
include("libs/PHPExcel/Classes/PHPExcel.php");
require_once("classes/db_veicretirada_classe.php");
require_once("classes/db_veicdevolucao_classe.php");
require_once("classes/db_veiculos_classe.php");
require_once("classes/db_cgm_classe.php");
require_once("classes/db_veicmotoristas_classe.php");
require_once("classes/db_veicabast_classe.php");
require_once("classes/db_empempenho_classe.php");
require_once("classes/db_empveiculos_classe.php");
require_once("classes/db_empresto_classe.php");
require_once("classes/db_pcmater_classe.php");


$oJson             = new services_json();
//$oParam            = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));
$oParam           = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$oRetorno->status  = 1;

$clempempitem = new cl_empempitem();
$clpcmater    = new cl_pcmater();

$aDadosRetorno      = array();

          

  switch ($oParam->exec) {

    /**
     * Busca informaçao do intes do empenho
     */

    case 'buscarItens':

        
        $sq = $clempempitem->sql_record($clempempitem->sql_query($oParam->numemp,"","*","e62_numemp"));
        $arrayResult = array();
        if($clempempitem->numrows>0){
          //$objValorItens = new stdClass(); clpcmater
          $op = 0;
          for($i=0;$i<$clempempitem->numrows;$i++){
            $resultItem = db_utils::fieldsMemory($sq, $op);
            $objValorItens = new stdClass();
            $objValorItens->ordem = $op+1;
            $objValorItens->item = $resultItem->e62_item;

            $resultPcmater = $clpcmater->sql_record($clpcmater->sql_query($resultItem->e62_item,"*",null,""));

            //if($clpcmater->numrows>0){
              $resultPc = db_utils::fieldsMemory($resultPcmater,0);
              $objValorItens->descr = urlencode($resultPc->pc01_descrmater);
              
            //}
            $objValorItens->quant = $resultItem->e62_quant;
            $objValorItens->vlrun = $resultItem->e62_vlrun;
            $arrayResult[$op] = $objValorItens;
            $op++;
          }
          
          $oRetorno->itens = $arrayResult;

        }else{
          $oRetorno->status  = 3;
        }
        
    break;


    
  }
echo json_encode($oRetorno);
