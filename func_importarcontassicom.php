<?php

//ini_set('display_errors', 'On');error_reporting(E_ALL);

require_once ('libs/db_conn.php');
require_once ('libs/db_stdlib.php');
require_once ('libs/db_utils.php');
require_once ("libs/db_app.utils.php");
require_once ('libs/db_conecta.php');
require_once ('dbforms/db_funcoes.php');
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
require_once("libs/JSON.php");
require_once ("classes/db_bancoagencia_classe.php");
require_once ("classes/db_contabancaria_classe.php");
require_once ("model/contabilidade/planoconta/ContaPlanoPCASP.model.php");
require_once ("model/contabilidade/planoconta/ContaCorrente.model.php");
require_once ("model/contabilidade/planoconta/SistemaConta.model.php");
require_once("classes/db_conplanoexe_classe.php");


db_app::import("exceptions.*");

db_postmemory($HTTP_POST_VARS);

$oJson = new services_json();
$oRetorno = new stdClass();
$oRetorno->erro = false;
$oRetorno->status = 1;
$oRetorno->message = '';
$iAno = db_getsession('DB_anousu')-1;

/**
 * Procedimento executado para cadastrar as contas bancárias no sistema, a partir do arquivo CTB do SICOM AM.
 * 1. Busca nas tabelas do CTB os dados das contas bancárias nos meses dos exercícios anteriores ao da sessão.
 * 2. Realiza o cadastro das contas como é feito em Financeiro->Caixa->Cadastros->Contas->Contas Bancárias
 * 3. Do ctb10 busco apenas as que não tem vinculo com o ctb50 onde o situacaoConta for igual a 'E'. 
 *    E o ctb20 so pego as de dezembro para pegar o saldo final e implantar
 */


$nSeqEstrut         = 1;
$nSeqEstrutBB       = 1;
$nSeqEstrutCAIXA    = 1;
$nSeqEstrutBRADESCO = 1;
$nSeqEstrutITAU     = 1;
$nNivel             = 1;
$nNivelBB           = 1;
$nNivelCAIXA        = 1;
$nNivelBRADESCO     = 1;
$nNivelITAU         = 1;
try{
	$aDadosSicom = getDadosSicom($iAno);	
    //echo "<pre>"; print_r($aDadosSicom);exit;
	if (empty($aDadosSicom)){
		throw new Exception("Não foram importados os arquivos do SICOM!");
	}
    db_inicio_transacao();
	for ($i = 0; $i < count($aDadosSicom) ; $i++ ){
        
        /*salvar($aDadosSicom[$i], $nNivel, $nSeqEstrut);
        $nSeqEstrut++;
        if($nSeqEstrut > 99 && $nNivel==1){
            $nSeqEstrut = 1;
            $nNivel = 2;
        }else if($nSeqEstrut > 99 && $nNivel==2){
            $nSeqEstrut = 1;
            $nNivel = 3;
        }*/
            
        if($aDadosSicom[$i]->si95_banco == '001'){                    
            if($nSeqEstrutBB > 99 && $nNivelBB==1){
                $nSeqEstrutBB = 1;
                $nNivelBB = 2;
            }else if($nSeqEstrutBB > 99 && $nNivelBB==2){
                $nSeqEstrutBB = 1;
                $nNivelBB = 3;
            }
            salvar($aDadosSicom[$i], $nNivelBB, $nSeqEstrutBB);    
            $nSeqEstrutBB++;      
        }else if($aDadosSicom[$i]->si95_banco == 104){
            salvar($aDadosSicom[$i], $nNivelCAIXA, $nSeqEstrutCAIXA);
            $nSeqEstrutCAIXA++;            
        }else if($aDadosSicom[$i]->si95_banco == 237){
            salvar($aDadosSicom[$i], $nNivel, $nSeqEstrutBRADESCO);
            $nSeqEstrutBRADESCO++;
        }else if($aDadosSicom[$i]->si95_banco == 341){
            salvar($aDadosSicom[$i], $nNivel, $nSeqEstrutITAU);
            $nSeqEstrutITAU++;
        }else{
            salvar($aDadosSicom[$i], $nNivel, $nSeqEstrut);
            $nSeqEstrut++;
        }		
	}
	db_fim_transacao(false);
} catch (Exception $eErro) {
	db_fim_transacao(true);
	$oRetorno->erro = true;
	$oRetorno->status = 2;
	$oRetorno->message = $eErro->getMessage();
}
function salvar($oContaSicom, $nNivel, $nSeqEstrut){
	
		$iAno = db_getsession("DB_anousu");
		$iInstituicao = db_getsession("DB_instit");
		$oContaBancaria = new ContaBancaria();
		$oContaBancaria->setDVAgencia($oContaSicom->si95_digitoverificadoragencia);
		$oContaBancaria->setNumeroAgencia($oContaSicom->si95_agencia );
		$oContaBancaria->setCodigoBanco($oContaSicom->si95_banco);
		$oContaBancaria->setNumeroConta($oContaSicom->si95_contabancaria);
		$oContaBancaria->setDVConta($oContaSicom->si95_digitoverificadorcontabancaria);
		$oContaBancaria->setIdentificador('00000000000000');
		$oContaBancaria->setCodigoOperacao('0');
		$oContaBancaria->setTipoConta($oContaSicom->si95_tipoconta);
		$oContaBancaria->setPlanoConta(true);        
		$oContaBancaria->setDescricaoConta($oContaSicom->si95_contabancaria."-".$oContaSicom->si95_digitoverificadorcontabancaria." ".$oContaSicom->si95_desccontabancaria);  
		$oContaBancaria->salvar();
				
		//regra para pegar estrutural
		$sEstruturalCC   = "1111119";
		$sEstruturalAPL  = "1111150";
		$sEstrutualFinal = "";
		
		if($oContaBancaria->getTipoConta() == 1){
			$sEstrutualFinal = $sEstruturalCC;
		}else{
			$sEstrutualFinal = $sEstruturalAPL;
		}
		
		if($oContaBancaria->getCodigoBanco() == '001'){
			
			//banco do brasil
			if($oContaSicom->aSaldos[0]->si96_codfontrecursos == 100 && $oContaBancaria->getTipoConta() == 1){
				if($nNivel ==1){
					$sEstrutualBaseCCNaoVinculadoBB  = "010101";
					$sEstrutualFinal                .= $sEstrutualBaseCCNaoVinculadoBB;
					$sEstrutualFinal                .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
				}elseif($nNivel ==2){
					$sEstrutualBaseCCNaoVinculadoBB2 = "010107";
					$sEstrutualFinal                .= $sEstrutualBaseCCNaoVinculadoBB2;
					$sEstrutualFinal                .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
				}else{
					$sEstrutualBaseCCNaoVinculadoBB3  = "010108";
					$sEstrutualFinal                 .= $sEstrutualBaseCCNaoVinculadoBB3;
					$sEstrutualFinal                 .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
				}								
			}elseif($oContaBancaria->getTipoConta() == 1){
				if($nNivel ==1){
					$sEstrutualBaseCCVinculadoBB  = "020101";
					$sEstrutualFinal             .= $sEstrutualBaseCCVinculadoBB;
					$sEstrutualFinal             .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
				}elseif($nNivel ==2){
					$sEstrutualBaseCCVinculadoBB2  = "020107";
					$sEstrutualFinal              .= $sEstrutualBaseCCVinculadoBB2;
					$sEstrutualFinal              .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
				}else{
					$sEstrutualBaseCCVinculadoBB3  = "020108";
					$sEstrutualFinal              .= $sEstrutualBaseCCVinculadoBB3;
					$sEstrutualFinal              .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
				}				
				
			}else{
				if($nNivel == 1){
					$sEstrutualBaseCCAplicBB  = "010101";
					$sEstrutualFinal         .= $sEstrutualBaseCCAplicBB;
					$sEstrutualFinal         .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
				}elseif($nNivel ==2){
					$sEstrutualBaseCCAplicBB2 = "010107";
					$sEstrutualFinal         .= $sEstrutualBaseCCAplicBB2;
					$sEstrutualFinal 		 .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
				}else{
					$sEstrutualBaseCCAplicBB3 = "010108";
					$sEstrutualFinal         .= $sEstrutualBaseCCAplicBB3;
					$sEstrutualFinal         .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
				}
				
			}
			
		}elseif($oContaBancaria->getCodigoBanco() == 104){
			
			//banco cef
			if($oContaSicom->aSaldos[0]->si96_codfontrecursos == 100 && $oContaBancaria->getTipoConta() == 1){
				$sEstrutualBaseCCNaoVinculadoCAIXA     = "010102";
				$sEstrutualFinal .= $sEstrutualBaseCCNaoVinculadoCAIXA;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}elseif($oContaBancaria->getTipoConta() == 1){
				$sEstrutualBaseCCVinculadoCAIXA        = "020102";
				$sEstrutualFinal .= $sEstrutualBaseCCVinculadoCAIXA;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}else{
				$sEstrutualBaseCCAplicCAIXA            = "010102";
				$sEstrutualFinal .= $sEstrutualBaseCCAplicCAIXA;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}
			
		}elseif ($oContaBancaria->getCodigoBanco() == 341){
			
			//banco itau
			if($oContaSicom->aSaldos[0]->si96_codfontrecursos == 100 && $oContaBancaria->getTipoConta() == 1){
				$sEstrutualBaseCCNaoVinculadoITAU  	   = "010103";
				$sEstrutualFinal .= $sEstrutualBaseCCNaoVinculadoITAU;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}elseif($oContaBancaria->getTipoConta() == 1){
				$sEstrutualBaseCCVinculadoITAU  	   = "020103";
				$sEstrutualFinal .= $sEstrutualBaseCCVinculadoITAU;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}else{
				$sEstrutualBaseCCAplicITAU  	       = "010103";
				$sEstrutualFinal .= $sEstrutualBaseCCAplicITAU;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}
												
		}elseif ($oContaBancaria->getCodigoBanco() == 237){
			
			//banco bradesco
			if($oContaSicom->aSaldos[0]->si96_codfontrecursos == 100 && $oContaBancaria->getTipoConta() == 1){
				$sEstrutualBaseCCNaoVinculadoBRADESCO  = "010104";
				$sEstrutualFinal .= $sEstrutualBaseCCNaoVinculadoBRADESCO;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}elseif($oContaBancaria->getTipoConta() == 1){
				$sEstrutualBaseCCVinculadoBRADESCO     = "020104";
				$sEstrutualFinal .= $sEstrutualBaseCCVinculadoBRADESCO;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}else{
				$sEstrutualBaseCCAplicBRADESCO         = "010104";
				$sEstrutualFinal .= $sEstrutualBaseCCAplicBRADESCO;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}
												
		}else{
			
			if($oContaSicom->aSaldos[0]->si96_codfontrecursos == 100 && $oContaBancaria->getTipoConta() == 1){
				$sEstrutualBaseCCNaoVinculado   = "010199";
				$sEstrutualFinal .= $sEstrutualBaseCCNaoVinculado;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}elseif($oContaBancaria->getTipoConta() == 1){
				$sEstrutualBaseCCVinculado		= "020199";
				$sEstrutualFinal .= $sEstrutualBaseCCVinculado;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}else{
				$sEstrutualBaseCCAplic         	= "010199";
				$sEstrutualFinal .= $sEstrutualBaseCCAplic;
				$sEstrutualFinal .= str_pad($nSeqEstrut, 2, "0", STR_PAD_LEFT);
			}
			
		}		
		$iReduzido = 0;									
		$oPlanoPCASP = new ContaPlanoPCASP();
		$oPlanoPCASP = new ContaPlanoPCASP($oPlanoPCASP->getCodConPorEstrutural($sEstrutualFinal));	
        if($oPlanoPCASP->getCodigoConta() != "" || $oPlanoPCASP->getCodigoConta() != 0){
          $iReduzido = 	1;		
        }
		$oPlanoPCASP->setAno(db_getsession("DB_anousu"));
		$oPlanoPCASP->setEstrutural($sEstrutualFinal);		
		$oPlanoPCASP->setNRegObrig(17);
		$oPlanoPCASP->setFuncao($oContaSicom->si95_contabancaria."-".$oContaSicom->si95_digitoverificadorcontabancaria." ".$oContaSicom->si95_desccontabancaria);
		$oPlanoPCASP->setFinalidade($oContaSicom->si95_contabancaria."-".$oContaSicom->si95_digitoverificadorcontabancaria." ".$oContaSicom->si95_desccontabancaria);
		$oPlanoPCASP->setContraPartida("0");
		$oPlanoPCASP->setDescricao(substr($oContaSicom->si95_contabancaria."-".$oContaSicom->si95_digitoverificadorcontabancaria." ".$oContaSicom->si95_desccontabancaria,0,40));
		$oPlanoPCASP->setContaCorrente(new ContaCorrente(103));
		$oPlanoPCASP->setIdentificadorFinanceiro('F');
		$oPlanoPCASP->setNaturezaSaldo(1);
		$oPlanoPCASP->setClassificacaoConta(new ClassificacaoConta(1));
		$oPlanoPCASP->setSistemaConta(new SistemaConta(6));
		$oPlanoPCASP->setSubSistema(new SubSistemaConta(2));
		$oPlanoPCASP->setContaBancaria($oContaBancaria);
		$oPlanoPCASP->setTipo(2);				
	    $oPlanoPCASP->salvar();	
	    
		//if($iReduzido == 1){
            $oPlanoPCASP->setInstituicao($iInstituicao);
            $oPlanoPCASP->setRecurso($oContaSicom->aSaldos[0]->si96_codfontrecursos);
            $oPlanoPCASP->setCodigoTce($oContaSicom->si95_codctb);
            $oPlanoPCASP->persistirReduzido();  
       //}
		
		
		$clconplanoexe = new cl_conplanoexe;
		$nSaldoConta = 0;
		
		foreach ($oContaSicom->aSaldos as $oSaldo){
			$nSaldoConta = $nSaldoConta + $oSaldo->si96_vlsaldofinalfonte; 
		}
		if ($nSaldoConta < 0){
			$clconplanoexe->c62_vlrcre = $nSaldoConta;
			$clconplanoexe->c62_vlrdeb = 0;
		}else{
			$clconplanoexe->c62_vlrdeb = $nSaldoConta;
			$clconplanoexe->c62_vlrcre = 0;
		}
		$clconplanoexe->c62_anousu = $iAno;
		$clconplanoexe->c62_reduz = $oPlanoPCASP->getReduzido();
		$clconplanoexe->alterar($iAno,$oPlanoPCASP->getReduzido());
		
		
		$clsaltes                    = new cl_saltes;
		$clsaltes->k13_dtimplantacao = "2016-12-31";
		$clsaltes->k13_saldo         = $nSaldoConta;
		$clsaltes->k13_datvlr        = "2016-12-31";
		$clsaltes->k13_conta         = $oPlanoPCASP->getReduzido();
		$clsaltes->k13_reduz         = $oPlanoPCASP->getReduzido();
		$clsaltes->k13_descr         = $oPlanoPCASP->getDescricao();
		$clsaltes->alterar($oPlanoPCASP->getReduzido());
		
	   
}
function getDadosSicom($iAno){

    $sWhere10 = " where si95_instit = " . db_getsession("DB_instit");
    $sCampos  = " si95_sequencial, si95_tiporegistro, si95_codctb, si95_codorgao, lpad(si95_banco,3,0) as si95_banco, si95_agencia, si95_digitoverificadoragencia, ";
    $sCampos .= " si95_contabancaria, si95_digitoverificadorcontabancaria, si95_tipoconta, si95_tipoaplicacao, si95_nroseqaplicacao, ";
    $sCampos .= " si95_desccontabancaria, si95_contaconvenio, si95_nroconvenio::varchar, si95_dataassinaturaconvenio, si95_mes, si95_instit ";

    $sSql10 = "select * from (";
    for($i = 2014; $i < db_getsession('DB_anousu'); $i++){
        
        $sSql10 .= " select {$sCampos} from ctb10{$i} {$sWhere10}  ";
        //$sSql10 .= " select * from ctb10{$i} {$sWhere10} and si95_codctb in (4188,18388) ";
        $sSql10 .= $i+1 == db_getsession('DB_anousu') ? " ) as x " : " union ";
    }
	//echo $sSql10;exit;
    $rCtb10 = db_query($sSql10);
    //db_criatabela($rCtb10);exit;
    $aContas = db_utils::getCollectionByRecord($rCtb10);
    $aContasAgrupadas = array();
    foreach($aContas as $oConta){
        if(!validaContaEncerrada($oConta->si95_codctb,db_getsession('DB_anousu'))) {
            $oConta->aSaldos = getSaldoCTB($oConta->si95_codctb, $iAno);
            $aContasAgrupadas[] = $oConta;
        } else {
            continue;
        }

    }
    return $aContasAgrupadas;   
}

/**
 * Busca a última situação da conta e Verifica se a conta está encerrada retornando true, se não, false.
 * @param $iCodCtb
 * @param $iAno
 * @return bool
 *
 */
function validaContaEncerrada($iCodCtb,$iAno){
    $sWhere50 = " where si102_instit = " . db_getsession("DB_instit");
    $sCampos2014 = "si102_sequencial, si102_tiporegistro, si102_codorgao, si102_codctb, 'E' as si102_situacaoconta, si102_dataencerramento as si102_datasituacao, si102_mes, si102_instit";
    $sCampos2015 = "si102_sequencial, si102_tiporegistro, si102_codorgao, si102_codctb, si102_situacaoconta, si102_datasituacao, si102_mes, si102_instit";
    $sCampos2016 = "si102_sequencial, si102_tiporegistro, si102_codorgao, si102_codctb, si102_situacaoconta, si102_datasituacao, si102_mes, si102_instit";
    $sSql50 = "select si102_situacaoconta from (";
    for($i = 2014; $i < $iAno; $i++){
        $sCampos = "*";
        if($i == 2014){
          $sCampos = $sCampos2014;
        }
        $sSql50 .= " select {$sCampos}, {$i} as si102_anousu from ctb50{$i} {$sWhere50} and si102_codctb = $iCodCtb ";

        $sSql50 .= $i+1 == $iAno ? " ) as x " : " union ";
    }
    $sSql50 .= " order by si102_datasituacao ";

    return db_utils::fieldsMemory(db_query($sSql50),0)->si102_situacaoconta == 'E' ? true : false;

}

function getSaldoCTB($iCodCtb, $iAno){

    require_once("classes/db_ctb20{$iAno}_classe.php");
    $sNomeClasseCTB20 = "cl_ctb20{$iAno}";
    $cCtb20 = new $sNomeClasseCTB20;

    $sSql = $cCtb20->sql_query(NULL,"si96_codfontrecursos, si96_vlsaldofinalfonte", NULL, " si96_codctb = {$iCodCtb} and si96_mes = 12 order by 1 ");
    $rRes = $cCtb20->sql_record($sSql);
    if(pg_num_rows($rRes) <= 0){
        $sSql = $cCtb20->sql_query(NULL,"si96_codfontrecursos, si96_vlsaldofinalfonte", NULL, " si96_codctb = {$iCodCtb} and si96_mes = 11 order by 1 ");
          $rRes = $cCtb20->sql_record($sSql);
    }

    return db_utils::getCollectionByRecord($rRes);
}

echo $oJson->encode($oRetorno);
?>
