<?
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

/**
 * Calcula a quantidade de dias de aviso previo indenizado
 */
function getQuantidadeDiasAviso($recis,$admiss) {
	$oDataRecis = new DateTime($recis);
	$oDataAdmiss = new DateTime($admiss);
	$oAnosAviso = $oDataRecis->diff($oDataAdmiss);
	$quantAviso = 0;
	if ($oAnosAviso->d > 0 || $oAnosAviso->m > 0) {
		$quantAviso = $oAnosAviso->y*3+30;
	} else {
		$quantAviso = $oAnosAviso->y*3+30-3;
	}
	return ($quantAviso < 90 ? $quantAviso : 90);
}

/**
 * Calcula a quantidade de avos(meses de direito com pelo menus 15 dias trabalhados)
 * com base no dias de aviso previo indenizado
 */
function getDiasAvos($recis, $quant_aviso) {

	$oDataRecis = new DateTime($recis);
	$oDataAviso = new DateTime($oDataRecis->format('Y-m-d H:i:s'));
	$oDataAviso->add(new DateInterval("P{$quant_aviso}D"));
	$oDataFinalRecis = new DateTime($oDataRecis->format('Y-m-d H:i:s'));
	$oDataFinalRecis->modify("last day of this month");
	$oDataInicialAviso = new DateTime($oDataAviso->format('Y-m-d H:i:s'));
	$oDataInicialAviso->modify("first day of this month");
	$oDiffDatas = $oDataFinalRecis->diff($oDataInicialAviso);
	$dias_avos = $oDiffDatas->m;
	if ($oDataRecis->diff($oDataFinalRecis)->d >= 15 && $oDataRecis->format("d") < 15) {
	  $dias_avos += 1;
	} 
	if ($oDataAviso->diff($oDataInicialAviso)->d >= 15 ) {
	  $dias_avos += 1;
	}
	return $dias_avos*2.5;
}

/**
 * Insere rubricas especiais na tabela pontofr
 * com a quantidade calculada
 */
function insertRubricasEspeciaisAviso($matriz1, $matriz2, $cfpess) {

    if (empty($cfpess[0]["r11_avisoprevio13"]) || empty($cfpess[0]["r11_avisoprevio13"]) || empty($cfpess[0]["r11_avisoprevio13ferias"])) {
    	db_msgbox("Rúbricas especiais de aviso prévio não cadastradas.");
    	db_redireciona("pes4_rhpesrescis001.php");
    } else {
 
		$matriz2[2] = $cfpess[0]["r11_avisoprevio13"];
		db_insert( "pontofr",$matriz1, $matriz2 );

		$matriz2[2] = $cfpess[0]["r11_avisoprevioferias"];
		db_insert( "pontofr",$matriz1, $matriz2 );

		$matriz2[2] = $cfpess[0]["r11_avisoprevio13ferias"];
		db_insert( "pontofr",$matriz1, $matriz2 );
    }

}