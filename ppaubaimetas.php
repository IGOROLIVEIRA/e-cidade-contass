<?php

require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

$sSql  = " select 12 as tipoRegistro, '02' as codOrgao , 
               	lpad(o58_orgao,2,0)||lpad(o58_unidade,3,0) as codUnidadeSub,lpad(o58_funcao,2,0) 
               	as funcao,lpad(o58_subfuncao,3,0) as subfuncao, lpad(o58_programa,4,0) 
               	as programa, lpad(o58_projativ, 4,0) as projeto, ' ' as subacao, '1,00' 
               	as metas1Ano,'1,00' as metas2Ano,'1,00' as metas3Ano,'1,00' 
               	as metas4Ano,o58_valor from orcdotacao where o58_instit = 2 and o58_anousu = 2014";

 	

$rsMetas = db_query($sSql);

$aDadosAgrupados = array();
 
for ($iContador = 0; $iContador < pg_num_rows($rsMetas); $iContador++) {
    	
    	$oMeta =  db_utils::fieldsMemory($rsMetas, $iContador);
		
    	
    	$sHash = $oMeta->projeto;
    	$oDadosMeta = array();
    	
    	if(!isset($aDadosAgrupados[$sHash])){
    		
	    	$oDadosMeta['tipoRegistro'] 	= $oMeta->tiporegistro;
	    	$oDadosMeta['codOrgao'] 		= $oMeta->codorgao;
	    	$oDadosMeta['codUnidadeSub'] 	= $oMeta->codunidadesub;
	    	$oDadosMeta['funcao'] 		    = $oMeta->funcao;
	    	$oDadosMeta['subfuncao'] 		= $oMeta->subfuncao;
	    	$oDadosMeta['programa'] 		= $oMeta->programa;
	    	$oDadosMeta['projeto'] 		    = $oMeta->projeto;
	    	$oDadosMeta['subacao'] 		    = " ";
	    	$oDadosMeta['metas1Ano'] 		= $oMeta->metas1ano;
	    	$oDadosMeta['metas2Ano'] 		= $oMeta->metas2ano;
	    	$oDadosMeta['metas3Ano'] 		= $oMeta->metas3ano;
	    	$oDadosMeta['metas4Ano']		= $oMeta->metas4ano;
	    	$oDadosMeta['recursos1ano']   = 0;
	    	$oDadosMeta['recursos2ano']   = 0;
	    	$oDadosMeta['recursos3ano']   = 0;
	    	$oDadosMeta['recursos4ano']   = 0;
		        
		    $aDadosAgrupados[$sHash] = $oDadosMeta;
		    
    	}
    	 	
    	
    	$aDadosAgrupados[$sHash]['recursos1ano']   += $oMeta->o58_valor;
	    $aDadosAgrupados[$sHash]['recursos2ano']   += $oMeta->o58_valor;
	    $aDadosAgrupados[$sHash]['recursos3ano']   += $oMeta->o58_valor;
	    $aDadosAgrupados[$sHash]['recursos4ano']   += $oMeta->o58_valor;
	    
	  
}	    
			//echo "<pre>";
	        //print_r($aDadosAgrupados);
	        $aDados = array();
	        foreach ($aDadosAgrupados as $oFonteRecurso) {
				$oFonteRecurso['recursos1ano'] = number_format(abs($oFonteRecurso['recursos1ano']), 2, ",", "");
				$oFonteRecurso['recursos2ano'] = number_format(abs(($oFonteRecurso['recursos1ano'] * (1.045)) ), 2, ",", "");
				$oFonteRecurso['recursos3ano'] = number_format(abs($oFonteRecurso['recursos2ano'] * (1.045)), 2, ",", "");
	    		$oFonteRecurso['recursos4ano'] = number_format(abs($oFonteRecurso['recursos3ano']* (1.045)), 2, ",", "");
	    		$aDados[] = $oFonteRecurso;
	    	}
		
	  	    $delimitador = ';';
			$f = fopen('tmp/AMP.csv', 'w');
			if ($f) { 
			        
			        foreach ($aDados as $linha) {
			        	
			            fputcsv($f, $linha, $delimitador);
			        }
			        fclose($f);
			        
			}
		
		
         
		echo "<a href=\"tmp/AMP.csv\" />arquivo</a>";exit;

?>