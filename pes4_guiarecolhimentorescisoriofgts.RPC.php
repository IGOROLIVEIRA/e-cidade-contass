<?php
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");
require_once("model/pessoal/arquivoGRRF/ArquivoGRRF.model.php");

require_once("classes/db_rhpesrescisao_classe.php");
$oDaoRHPesRescisao = new cl_rhpesrescisao(); 

require_once("classes/db_rhgrrf_classe.php");
$oDaoRHGRRF = new cl_rhgrrf();

require_once("classes/db_rhgrrfcancela_classe.php");
$oDaoRHGRRFCancela = new cl_rhgrrfcancela();

$oJson    = new services_json();
$oParam   = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno = new stdClass();
$oRetorno->iStatus = 1;
$oRetorno->sMsg    = "";

try {

    if ( $oParam->sMethod == "getServidoresRescisao" ) {

        $iAnoUsu = $oParam->iAnoUsu;
        $iMesUsu = str_pad($oParam->iMesUsu,2,'0',STR_PAD_LEFT);        
        
        $sDataCompIni = "{$iAnoUsu}-{$iMesUsu}-01";
        
        $lBisexto = verifica_bissexto($sDataCompIni);

        if ($lBisexto) {
            $iFev = 29;
        } else {
            $iFev = 28;
        }

        $aUltimoDia = array("01"=>"31",
        "02"=>$iFev,
        "03"=>"31",
        "04"=>"30",
        "05"=>"31",
        "06"=>"30",
        "07"=>"31",
        "08"=>"31",
        "09"=>"30",
        "10"=>"31",
        "11"=>"30",
        "12"=>"31");

        $sDataCompFim = "{$iAnoUsu}-{$iMesUsu}-".$aUltimoDia[$iMesUsu];
        $sCampos = "DISTINCT rh01_regist,z01_nome,rh05_recis";
        $sWhere  = "rh05_recis between '{$sDataCompIni}' AND '{$sDataCompFim}' AND rh02_instit = ".db_getsession("DB_instit");
        $sSql = $oDaoRHPesRescisao->sql_servidor_rescisao(null,$sCampos, null, $sWhere);
        
        $rsResult = db_query($sSql);
        $aServidores = array();
        for ($iCont=0; $iCont < pg_num_rows($rsResult); $iCont++) {
            $aServidores[] = db_utils::fieldsMemory($rsResult, $iCont);
        }
        $oRetorno->aListaServidores = $aServidores;   

    } else if ( $oParam->sMethod == "verificaGeracaoGRRF" ) {

        $sWhereVerificaGRRF  = " rh168_ativa is true               ";
        $sWhereVerificaGRRF .= " and rh168_anousu = {$oParam->iAnoUsu} "; 
        $sWhereVerificaGRRF .= " and rh168_mesusu = {$oParam->iMesUsu} ";
        
        $rsVerificaGRRF      = $oDaoRHGRRF->sql_record($oDaoRHGRRF->sql_query_file(null,"*",null,$sWhereVerificaGRRF));

        if ( $oDaoRHGRRF->numrows > 0 ) {
            $lGerado = true;            
            $oRetorno->iCodGRRF = db_utils::fieldsMemory($rsVerificaGRRF,0)->rh168_sequencial;
        } else {
            $lGerado = false;
        }

        $oRetorno->lGerado   = $lGerado;

    } else if ( $oParam->sMethod == "cancelaGeracaoGRRF" ) {

        $iAnoUsu = $oParam->iAnoUsu;
        $iMesUsu = $oParam->iMesUsu;     
        
        db_inicio_transacao();
        
        $sWhereGRRF  = " rh168_ativa is true       ";
        $sWhereGRRF .= " and rh168_anousu = {$iAnoUsu} ";
        $sWhereGRRF .= " and rh168_mesusu = {$iMesUsu} ";
        
        $rsDadosGRRF = $oDaoRHGRRF->sql_record($oDaoRHGRRF->sql_query_file(null,"rh168_sequencial",null,$sWhereGRRF)); 
        
        if ( $oDaoRHGRRF->numrows > 0 ) {

            $oGRRF = db_utils::fieldsMemory($rsDadosGRRF,0);
            
            $oDaoRHGRRF->rh168_sequencial = $oGRRF->rh168_sequencial;
            $oDaoRHGRRF->rh168_ativa      = 'false';
            $oDaoRHGRRF->alterar($oGRRF->rh168_sequencial);

            if ( $oDaoRHGRRF->erro_status == 0 ) {
              throw new Exception($oDaoRHGRRF->erro_msg);   
          }    

          $oDaoRHGRRFCancela->rh169_rhgrrf     = $oGRRF->rh168_sequencial;
          $oDaoRHGRRFCancela->rh169_data       = date('Y-m-d',db_getsession('DB_datausu'));
          $oDaoRHGRRFCancela->rh169_hora       = db_hora();
          $oDaoRHGRRFCancela->rh169_id_usuario = db_getsession('DB_id_usuario');

          $oDaoRHGRRFCancela->incluir(null);

          if ( $oDaoRHGRRFCancela->erro_status == 0 ) {
            throw new Exception($oDaoRHGRRFCancela->erro_msg);   
        }         

        } else {
            throw new Exception("Geração da GRRF para a competência {$iMesUsu} / {$iAnoUsu} não encontrada!");
        }

        db_fim_transacao();

    } else if ( $oParam->sMethod == "downloadAquivo" ) {   

        db_inicio_transacao();
        global $conn;
        $rsOidArquivo    = $oDaoRHGRRF->sql_record($oDaoRHGRRF->sql_query_file($oParam->iCodGRRF,"rh168_arquivo"));
        $iOidArquivo     = db_utils::fieldsMemory($rsOidArquivo,0)->rh168_arquivo;

        $sCaminhoArquivo = "/tmp/GRRF.RE";
        $lGeraArquivo    = pg_lo_export($iOidArquivo,$sCaminhoArquivo,$conn);

        if (!$lGeraArquivo) {
            throw new Exception("Erro ao gerar arquivo GRRF");       
        }
        db_fim_transacao();
        $oRetorno->sCaminhoArquivo = $sCaminhoArquivo;

    }  else if($oParam->sMethod == 'gerarArquivo') {
        $oArquivoGRRF = new ArquivoGRRF();
        $oRetorno->iCodGRRF = $oArquivoGRRF->processar($oParam);
    }

} catch ( Exception $eException ) {
    $oRetorno->iStatus = 2;
    $oRetorno->sMsg    = urlencode(str_replace("\\n","\n",$eException->getMessage()));
    
    if ( db_utils::inTransaction() ) {
        db_inicio_transacao(true);
    }
}

echo $oJson->encode($oRetorno);

?>