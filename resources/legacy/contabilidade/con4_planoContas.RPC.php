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
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = "";

$iAnoSessao = db_getsession("DB_anousu");
$iInstituicaoSessao = db_getsession("DB_instit");

switch ($oParam->exec) {

  case "getDadosContaPlano":

    $oDaoConPlano = db_utils::getDao("conplano");
    $sSqlCampos   = " conplano.c60_codcon, conplano.c60_estrut, conplano.c60_codsis ";
    $sSqlWhere    = " c60_anousu = {$iAnoSessao} and c61_reduz = {$oParam->iConta} ";
    $sSqlMonta    = $oDaoConPlano->sql_query_reduz(null, $sSqlCampos, null, $sSqlWhere);

    $rsExecutaQueryReduz = $oDaoConPlano->sql_record($sSqlMonta);

    if ($oDaoConPlano->numrows > 0) {

      $oDadosConPlano = db_utils::fieldsMemory($rsExecutaQueryReduz, 0);
      $oRetorno->oDados[] = $oDadosConPlano;
      $oRetorno->status   = 2;
    }

  break;

  case "verificaRecursoContaReduzida":

    $oPlanoConta    = new ContaPlanoPCASP(null, $iAnoSessao, $oParam->iConta, $iInstituicaoSessao);
    $iCodigoRecurso = $oPlanoConta->getRecurso();
    $lLiberaFundeb  = false;
    if ($iCodigoRecurso == ParametroCaixa::getCodigoRecursoFUNDEB($iInstituicaoSessao)) {
      $lLiberaFundeb = true;
    }

    $oRetorno->lUtilizaFundeb = $lLiberaFundeb;

    break;

  case "verificaContaGeral":
    $descricao = strtoupper($oParam->iDescricao);

    $descricao = strtoupper($oParam->iDescricao);
    $clsaltes = new cl_saltes;
    $sSqlCampos   = " distinct  saltes.k13_reduz, saltes.k13_conta, 
                      CASE
                      WHEN NOT saltes.k13_descr ~ '^[0-9]' THEN c63_conta ||'-'|| c63_dvconta ||' '|| saltes.k13_descr 
                      ELSE saltes.k13_descr
                      END AS k13_descr,saltes.k13_saldo,c63_banco,c63_agencia,
                      c63_dvagencia,c63_conta,c63_dvconta,saltes.k13_vlratu,saltes.k13_datvlr,
                      c61_codigo, db83_conta, c60_tipolancamento, c60_subtipolancamento,
                      db83_codigoopcredito, db83_tipoconta   ";
    $sSqlWhere    = "c61_instit = $iInstituicaoSessao and (k13_limite is null or k13_limite >= '".date("Y-m-d",db_getsession("DB_datausu"))."') and c62_anousu = {$iAnoSessao} and ( c60_descr like '%$descricao%' or c63_conta like '%$descricao%' ) ";
    
    $sSqlMonta = $clsaltes->sql_query_anousu(null, $sSqlCampos, "k13_conta", $sSqlWhere);
    $rsExecutaQueryReduz = $clsaltes->sql_record($sSqlMonta);

    if ($clsaltes->numrows > 0) {
      for($i=0;$i<$clsaltes->numrows;$i++){
        $oDadosConPlano = db_utils::fieldsMemory($rsExecutaQueryReduz, $i);
        // Criar um novo objeto
        $objRenomeado = new stdClass();
        // Renomear as chaves e atribuir os valores
        $objRenomeado->campo1 = $oDadosConPlano->k13_reduz;
        $objRenomeado->campo2 = $oDadosConPlano->k13_descr;
        $objRenomeado->campo3 = $oDadosConPlano->c61_codigo;
        $oRetorno->oDados[] = $objRenomeado;
      } 
      $oRetorno->inputField  = $oParam->inputField;
      $oRetorno->inputCodigo = $oParam->inputCodigo;
      $oRetorno->ulField     = $oParam->ulField;
      $oRetorno->status      = 2;
      $oRetorno->tipo        = 1; // Tipo 1 AutoComplete Contas Bancarias 
      
    }
    break;
  case "verificaContaEventoContabil":

    $descricao = strtoupper($oParam->iDescricao);
    /**
     * Verifico que mйtodo utilizar para buscar as contas na conplano
     */
    $oDaoConPlano = db_utils::getDao("conplano");
    $sCamposPlano = " c61_reduz as reduzido, c60_descr  as descricao, c60_tipolancamento, c60_subtipolancamento,c63_conta";
    $sWherePlano = " (c60_descr ilike '%$descricao%' or c63_conta ilike '%$descricao%') ";
    $iAnoSessao = db_getsession("DB_anousu");
    $sMetodoConta = 'getContaDebito';
    if ($oParam->tipoDebCred == 1) {
      $sMetodoConta = "getContaCredito";
    }
    try {
      $oEventoContabil = new EventoContabil(getDocumentoPorTipoInclusao($oParam->iTipoInclusao), $iAnoSessao);
      $aLancamentos    = $oEventoContabil->getEventoContabilLancamento();
      $aInLancamentos  = array();

      foreach ($aLancamentos as $oLancamento) {

        if ($oLancamento->getOrdem() == 1) {

          $aRegrasLancamento = $oLancamento->getRegrasLancamento();

          foreach ($aRegrasLancamento as $oContaRegraLancamento) {

            $aInLancamentos[] = $oContaRegraLancamento->$sMetodoConta();
          }
          break;
        }
        break;
      }
    } catch(Exception $eErro) {
      die($eErro->getMessage());
    }
    $sInLancamentos = implode(",", $aInLancamentos);
    $sWherePlano    .= " and conplanoreduz.c61_reduz in( {$sInLancamentos} )";
    $sSqlDadosConta = $oDaoConPlano->sql_query(null, null, $sCamposPlano, null, $sWherePlano);
    $limit = ' limit 30 ';

    $rsExecutaQueryReduz  = $oDaoConPlano->sql_record($sSqlDadosConta.$limit);

    if ($oDaoConPlano->numrows > 0) {
      for($i=0;$i<$oDaoConPlano->numrows;$i++){
        $oDadosConPlano = db_utils::fieldsMemory($rsExecutaQueryReduz, $i);
        // Criar um novo objeto
        $objRenomeado = new stdClass();
        // Renomear as chaves e atribuir os valores
        $objRenomeado->campo1 = $oDadosConPlano->reduzido;
        $objRenomeado->campo2 = $oDadosConPlano->descricao;
        $objRenomeado->campo3 = $oDadosConPlano->c63_conta;
        $oRetorno->oDados[]   = $objRenomeado;
      }
      $oRetorno->inputField  = $oParam->inputField;
      $oRetorno->inputCodigo = $oParam->inputCodigo;
      $oRetorno->ulField     = $oParam->ulField;
      $oRetorno->status      = 2;
      $oRetorno->tipo        = 1; // Tipo 1 AutoComplete Contas Bancarias 
      
    }
  break;  

  case "verificaContasParaAutoComplete":

    $descricao = strtoupper($oParam->iDescricao);
    $clsaltes = new cl_saltes;
    $sSqlCampos   = " distinct  saltes.k13_reduz, saltes.k13_conta, 
                      CASE
                      WHEN NOT saltes.k13_descr ~ '^[0-9]' THEN c63_conta ||'-'|| c63_dvconta ||' '|| saltes.k13_descr 
                      ELSE saltes.k13_descr
                      END AS k13_descr,saltes.k13_saldo,c63_banco,c63_agencia,
                      c63_dvagencia,c63_conta,c63_dvconta,saltes.k13_vlratu,saltes.k13_datvlr,
                      c61_codigo, db83_conta, c60_tipolancamento, c60_subtipolancamento,
                      db83_codigoopcredito, db83_tipoconta   ";
    $sSqlWhere    = "c61_instit = $iInstituicaoSessao and (k13_limite is null or k13_limite >= '".date("Y-m-d",db_getsession("DB_datausu"))."') and c62_anousu = {$iAnoSessao} and ( c60_descr like '%$descricao%' or c63_conta like '%$descricao%' ) ";
    
    if ($oParam->tiposelecione == 01 || $oParam->tiposelecione == 02){
        if($oParam->tipoDebCred == 2){
          if ( $oParam->tipodaconta == 1){
              $sSqlWhere .= " and db83_tipoconta = ".$oParam->tipodaconta ;
          }
          if ( $oParam->tipodaconta == 2){
              if ($oParam->tiposelecione == 01){
                $sSqlWhere .= "  and ( db83_tipoconta = ".$oParam->tipodaconta."  or db83_tipoconta = 3 )"  ;
              } else{
                $sSqlWhere .= " and db83_tipoconta = ".$oParam->tipodaconta ;
              }
          }
          
          if ( $oParam->tipodaconta == 3){
              $sSqlWhere .= " and db83_tipoconta is null" ;
          }
          $oRetorno->tipoconta   = 2;
        }
        if($oParam->tipoDebCred == 1){
          if ($oParam->codigoconta){
            $sSqlWhere .= " and c63_conta = 
                          ( select 
                                c63_conta
                            from
                                saltes
                            inner join conplanoreduz on
                                conplanoreduz.c61_reduz = saltes.k13_reduz
                                and c61_anousu = $iAnoSessao
                            inner join conplanoexe on
                                conplanoexe.c62_reduz = conplanoreduz.c61_reduz
                                and c61_anousu = c62_anousu
                            inner join conplano on
                                conplanoreduz.c61_codcon = conplano.c60_codcon
                                and c61_anousu = c60_anousu
                            left join conplanoconta on
                                conplanoconta.c63_codcon = conplanoreduz.c61_codcon
                                and conplanoconta.c63_anousu = conplanoreduz.c61_anousu
                            where  k13_reduz = $oParam->codigoconta and c61_anousu = $iAnoSessao
                            )";
            
            if ($oParam->tiposelecione == 02){
              $sSqlWhere .= "  and ( db83_tipoconta = ".$oParam->tipodaconta."  or db83_tipoconta = 3 )"  ;
            } else{
              $sSqlWhere .= " and db83_tipoconta = ".$oParam->tipodaconta ;
            }
          } 
        }
    }
    if ($oParam->tiposelecione == 03){
          if ($oParam->tipoDebCred == 2){
            if ( $oParam->tipodaconta == 1){
                $sSqlWhere .= "  and ( db83_tipoconta = ".$oParam->tipodaconta." or db83_tipoconta = 3 )"  ;
                $oRetorno->tipoconta   = 2;
            }
          } 
          if ($oParam->tipoDebCred == 1){
            if ($oParam->codigoconta){
              $sSqlWhere .= " and c61_codigo = 
                            ( select 
                                  c61_codigo
                              from
                                  saltes
                              inner join conplanoreduz on
                                  conplanoreduz.c61_reduz = saltes.k13_reduz
                                  and c61_anousu = $iAnoSessao
                              inner join conplanoexe on
                                  conplanoexe.c62_reduz = conplanoreduz.c61_reduz
                                  and c61_anousu = c62_anousu
                              inner join conplano on
                                  conplanoreduz.c61_codcon = conplano.c60_codcon
                                  and c61_anousu = c60_anousu
                              left join conplanoconta on
                                  conplanoconta.c63_codcon = conplanoreduz.c61_codcon
                                  and conplanoconta.c63_anousu = conplanoreduz.c61_anousu
                              where  k13_reduz = $oParam->codigoconta and c61_anousu = $iAnoSessao
                              )";
              $sSqlWhere .= " and ( db83_tipoconta = ".$oParam->tipodaconta." or db83_tipoconta = 3 )";
            }
          } 
    }
    if ($oParam->tiposelecione == '04'){
        if ( $oParam->tipodaconta == 1){
            $sSqlWhere .= " and db83_tipoconta = ".$oParam->tipodaconta ;
            $oRetorno->tipoconta   = 2;
        }
    }       
    if ($oParam->tiposelecione == '05'){
        if ($oParam->tipoDebCred == 2){
          if ( $oParam->tipodaconta == 1){
              $sSqlWhere .= " and c61_codigo in ('15000001') and db83_tipoconta = ".$oParam->tipodaconta ;
              $oRetorno->tipoconta   = 2;
          }
        } 
        if ($oParam->tipoDebCred == 1){
          if ( $oParam->tipodaconta == 1){
              $sSqlWhere .= " and c61_codigo in ('15000000') and db83_tipoconta = ".$oParam->tipodaconta ;
          }
        }  
    }
    if ($oParam->tiposelecione == '06'){
        if ($oParam->tipoDebCred == 2){
          if ( $oParam->tipodaconta == 1){
              $sSqlWhere .= " and c61_codigo in ('15000002') and db83_tipoconta = ".$oParam->tipodaconta ;
              $oRetorno->tipoconta   = 2;
          }
        } 
        if ($oParam->tipoDebCred == 1){
          if ( $oParam->tipodaconta == 1){
              $sSqlWhere .= " and c61_codigo in ('15000000') and db83_tipoconta = ".$oParam->tipodaconta ;
          }
      }  
    }
    if ($oParam->tiposelecione == '07'){
      if ($oParam->tipoDebCred == 2){
        if ( $oParam->tipodaconta == 1){
            $sSqlWhere .= " and c61_codigo in ('15700000','15710000','15720000','15750000','16310000','16320000','16330000','16360000','16650000','17000000','17010000','17020000','17030000') and db83_tipoconta = ".$oParam->tipodaconta ;

          }
      } 
      if ($oParam->tipoDebCred == 1){
        if ( $oParam->tipodaconta == 1){
            $sSqlWhere .= " and c61_codigo in ('15000000') and db83_tipoconta = ".$oParam->tipodaconta ;
            $oRetorno->tipoconta   = 2;
        }
      }  
    }
    if ($oParam->tiposelecione == '08'){
        if ( $oParam->tipodaconta == 1){
          $sSqlWhere .= " and db83_tipoconta = ".$oParam->tipodaconta ;
        }
    }
    if ($oParam->tiposelecione == '09'){
        if ($oParam->tipoDebCred == 2){
          if ( $oParam->tipodaconta == 1){
              $sSqlWhere .= " and db83_tipoconta = ".$oParam->tipodaconta ;
              $oRetorno->tipoconta   = 2;
            }
          } 
          if ($oParam->tipoDebCred == 1){
            if ( $oParam->tipodaconta == 3){
                $sSqlWhere .= " and db83_tipoconta is null ";
            }
          }  
    }
    if ($oParam->tiposelecione == '10'){
      if ($oParam->tipoDebCred == 2){
        if ( $oParam->tipodaconta == 3){
            $sSqlWhere .= " and db83_tipoconta is null " ;
          }
        } 
        if ($oParam->tipoDebCred == 1){
          if ( $oParam->tipodaconta == 1){
              $sSqlWhere .= " and db83_tipoconta = ".$oParam->tipodaconta ;
              $oRetorno->tipoconta   = 2;
          }
        }  
    }
    $limit = ' limit 30 ';    
    $sSqlMonta = $clsaltes->sql_query_anousu(null, $sSqlCampos, "k13_conta", $sSqlWhere);

    $rsExecutaQueryReduz = $clsaltes->sql_record($sSqlMonta.$limit);

    if ($clsaltes->numrows > 0) {
      for($i=0;$i<$clsaltes->numrows;$i++){
        $oDadosConPlano = db_utils::fieldsMemory($rsExecutaQueryReduz, $i);
        // Criar um novo objeto
        $objRenomeado = new stdClass();
        // Renomear as chaves e atribuir os valores
        $objRenomeado->campo1 = $oDadosConPlano->k13_reduz;
        $objRenomeado->campo2 = $oDadosConPlano->k13_descr;
        $objRenomeado->campo3 = $oDadosConPlano->c61_codigo;
        $oRetorno->oDados[] = $objRenomeado;
      } 
      $oRetorno->inputField  = $oParam->inputField;
      $oRetorno->inputCodigo = $oParam->inputCodigo;
      $oRetorno->ulField     = $oParam->ulField;
      $oRetorno->status      = 2;
      $oRetorno->tipo        = 1; // Tipo 1 AutoComplete Contas Bancarias 
      
    }
  
    break;
    case "verificaFavorecidoAutoComplete":
      
      $descricao = strtoupper(removerAcentos($oParam->iDescricao));
      $clcgm        = new cl_cgm;
      $sSqlCampos   = " distinct cgm.z01_numcgm, to_ascii(z01_nome) as z01_nome, trim(z01_cgccpf) as z01_cgccpf,
      case
        when length(trim(z01_cgccpf)) = 14 then 'JURIDICA'
        else 'FНSICA'
      end as tipo, trim(z01_ender) as z01_ender,z01_munic, cgm.z01_uf, z01_cep, z01_email,cgm.z01_incest ";
      $sSqlWhere    = " (cgm.z01_numcgm like '%$descricao%' or to_ascii(upper(z01_nome)) like to_ascii('%$descricao%') or z01_cgccpf like '%$descricao%') ";
      $sSqlMonta    = $clcgm->sql_query(null, $sSqlCampos, "to_ascii(z01_nome)",$sSqlWhere);

      $rsExecutaQueryReduz = $clcgm->sql_record($sSqlMonta);
   
      if ($clcgm->numrows > 0) {
        for($i=0;$i<$clcgm->numrows;$i++){
          $oDadosConPlano = db_utils::fieldsMemory($rsExecutaQueryReduz, $i);
          // Criar um novo objeto
          $objRenomeado = new stdClass();
          // Renomear as chaves e atribuir os valores
          $objRenomeado->campo1 = $oDadosConPlano->z01_numcgm;
          $objRenomeado->campo2 = $oDadosConPlano->z01_cgccpf ? formatCnpjCpf($oDadosConPlano->z01_cgccpf)." - ".$oDadosConPlano->z01_nome : $oDadosConPlano->z01_nome ;
          $oRetorno->oDados[] = $objRenomeado;
        } 
        $oRetorno->inputField  = $oParam->inputField;
        $oRetorno->inputCodigo = $oParam->inputCodigo;
        $oRetorno->ulField     = $oParam->ulField;
        $oRetorno->status      = 2;
        $oRetorno->tipo        = 2; // Tipo 2 AutoComplete
      }
    
    break;  
    case "verificaHistoricoAutoComplete":
      
      $descricao = strtoupper($oParam->iDescricao);
      $clconhist = new cl_conhist;
      $sSqlCampos   = " * ";
      $sSqlWhere    = " c50_descr like '%$descricao%'";
      $sSqlMonta    = $clconhist->sql_query(null, $sSqlCampos, "c50_descr", $sSqlWhere);
  
      $rsExecutaQueryReduz = $clconhist->sql_record($sSqlMonta);
  
      if ($clconhist->numrows > 0) {
        for($i=0;$i<$clconhist->numrows;$i++){
          $oDadosConPlano = db_utils::fieldsMemory($rsExecutaQueryReduz, $i);
          // Criar um novo objeto
          $objRenomeado = new stdClass();
          // Renomear as chaves e atribuir os valores
          $objRenomeado->campo1 = $oDadosConPlano->c50_codhist;
          $objRenomeado->campo2 = $oDadosConPlano->c50_descr;
          $objRenomeado->campo3 = $oDadosConPlano->c50_descrcompl;
          $oRetorno->oDados[] = $objRenomeado;
        } 
        $oRetorno->inputField  = $oParam->inputField;
        $oRetorno->inputCodigo = $oParam->inputCodigo;
        $oRetorno->ulField     = $oParam->ulField;
        $oRetorno->status      = 2;
        $oRetorno->tipo        = 2; // Tipo 2 AutoComplete Historicos
      }
    
      break;  
      case "buscarCamposAtivos":

        $oDaoConHist = db_utils::getDao('conhist');
        $dbwhere     = " c50_codhist = $oParam->codhist and c50_ativo = true ";
        $sSqlConHist = $oDaoConHist->sql_query("",$campos="*",$ordem=null,$dbwhere);
        $rsConHist   = $oDaoConHist->sql_record($sSqlConHist);

        if ($oDaoConHist->numrows > 0) {
          $oRetorno->sCodhist = urlencode(db_utils::fieldsMemory($rsConHist, 0)->c50_codhist);
        } else {
          switch ($oParam->codhist) {
            case "9791":
              $oCodhist = 9891;
            break; 
            case "9792":
              $oCodhist = 9892;
            break; 
            case "9793":
              $oCodhist = 9893;
            break; 
            case "9794":
              $oCodhist = 9894;
            break;
            case "9795":
              $oCodhist = 9895;
            break; 
            case "9796":
              $oCodhist = 9896;
            break;
            case "9797":
              $oCodhist = 9897;
            break; 
            case "9798":
              $oCodhist = 9898;
            break; 
            case "9799":
              $oCodhist = 9899;
            break;
          }  
            $dbwhere     = " c50_codhist = $oCodhist and c50_ativo = true ";
            $sSqlConHist = $oDaoConHist->sql_query("",$campos="*",$ordem=null,$dbwhere);
            $rsConHist   = $oDaoConHist->sql_record($sSqlConHist);
            if ($oDaoConHist->numrows > 0) {
              $oRetorno->sCodhist = urlencode(db_utils::fieldsMemory($rsConHist, 0)->c50_codhist);
            }  
               
        }
        break;
        case "buscarFontes":
 
            $clsaltes = new cl_saltes;
            $sSqlCampos   = " c61_codigo ";
            $iAnoSessao = db_getsession("DB_anousu");
            $sSqlWhere    = " c61_instit = $iInstituicaoSessao and (k13_limite is null or k13_limite >= '".date("Y-m-d",db_getsession("DB_datausu"))."') and c62_anousu = {$iAnoSessao} and k13_reduz =  $oParam->iCodigo ";
            $sSqlMonta = $clsaltes->sql_query_anousu(null, $sSqlCampos, "k13_conta", $sSqlWhere);
            $rsExecutaQueryReduz = $clsaltes->sql_record($sSqlMonta);

            if ($clsaltes->numrows > 0) {
              for($i=0;$i<$clsaltes->numrows;$i++){
                $oDadosConPlano = db_utils::fieldsMemory($rsExecutaQueryReduz, $i);
                
              }
              $oRetorno->oFonte = $oDadosConPlano->c61_codigo;
            } 
        break;  

}

function getDocumentoPorTipoInclusao($iTipoOperacao) {

  $iCodigoDocumento = 0;
  switch ($iTipoOperacao) {

    /**
     * Transferencia Financeira
     */
    case 1:
  	case 2:
  	  $iCodigoDocumento = 120;
	    break;
  	case 3:
  	case 4:
  	  $iCodigoDocumento = 130;
	  break;

		/**
		 * Transferencia Bancaria
		 */
  	case 5:
  	case 6:
  	  $iCodigoDocumento = 140;
		break;

    /**
     * Cauзгo
     */
  	case 7:
  	case 8:
  	  $iCodigoDocumento = 150;
	  break;
  	case 9:
  	case 10:
  	  $iCodigoDocumento = 151;
	  break;

	  /**
	   * Depуsito de Diversas Origens
	   */
  	case 11:
  	case 12:
  	  $iCodigoDocumento = 160;
  	break;

  	case 13:
  	case 14:
  	  $iCodigoDocumento = 161;
    break;
    
    /**
      * Reconhecimento de perdas
      */
    case 15:
    case 16:
      $iCodigoDocumento = 164;
    break;

    /**
     * Reconhecimento de ganhos RPPS
     */
    case 17:
    case 18:
        $iCodigoDocumento = 166;
    break;
  }

  return $iCodigoDocumento;
}

function formatCnpjCpf($value)
{
  $CPF_LENGTH = 11;
  $cnpj_cpf = preg_replace("/\D/", '', $value);
  
  if (strlen($cnpj_cpf) === $CPF_LENGTH) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  } 
  
  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function removerAcentos($string) {
  $acentos = array(
      'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Я',
      'а', 'б', 'в', 'г', 'д', 'е', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'я'
  );
  
  $semAcentos = array(
      'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 'ss',
      'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y'
  );
  
  $stringSemAcentos = str_replace($acentos, $semAcentos, $string);
  $stringSemAcentos = preg_replace('/[^a-zA-Z0-9 ]/', '', $stringSemAcentos);
  return $stringSemAcentos;
}

echo $oJson->encode($oRetorno);
?>