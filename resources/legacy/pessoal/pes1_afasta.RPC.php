<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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

require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("classes/db_afasta_classe.php");

$oJson               = new services_json();
$oParam              = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\", "", $_POST["json"])));
$oAfasta             = new cl_afasta;

$oRetorno            = new stdClass();
$oRetorno->status    = 1;
$oRetorno->message   = 1;
$lErro               = false;
$sMensagem           = "";


try {

	switch ($oParam->exec) {

		case 'possuiAnteriores':

			$iMatricula = $oParam->iMatricula;
			$iAno       = $oParam->iAno;
			$iMes       = $oParam->iMes;

			$sWherePossuiAnteriores = "r45_anousu = {$iAno} and r45_mesusu = {$iMes} and r45_regist = {$iMatricula}";
			$sSqlPossuiAnteriores   = $oAfasta->sql_query_file(null, "*", null, $sWherePossuiAnteriores);
			$rsPossuiAnteriores     = $oAfasta->sql_record($sSqlPossuiAnteriores);

			if ($oAfasta->numrows > 0) {
				$oRetorno->status  = 1;
			} else {
				$oRetorno->status  = 2;
			}

			break;

		case 'verificarAfastamentos':

			$iMatricula = $oParam->iMatricula;
			$iAno       = $oParam->iAno;
			$iMes       = $oParam->iMes;
			$iDate = implode("-", (array_reverse(explode("/", $oParam->iDateAfast))));

			$iDataAfast = date('d/m/Y', strtotime('-1 months', strtotime($iDate)));
			$iDataAfast2 = date('d/m/Y', strtotime('-2 months', strtotime($iDate)));
			$arrayDate = array($iDataAfast, $iDataAfast2);
			foreach ($arrayDate as $date) {
				$sWherePossuiAnteriores = "r45_anousu = date_part('month','$date'::date) AND r45_mesusu = date_part('year','$date'::date) and r45_regist = {$iMatricula} AND r45_situac IN (3,6)";
				$sSqlPossuiAnteriores   = $oAfasta->sql_query_file(null, "*", null, $sWherePossuiAnteriores);
				$rsPossuiAnteriores     = $oAfasta->sql_record($sSqlPossuiAnteriores);

				if ($oAfasta->numrows > 0) {
					$iPossuiAnteriores = 1;
				} else {
					$iPossuiAnteriores = 2;
				}
			}
			$oRetorno->status  = $iPossuiAnteriores;

			break;
	}

	$oRetorno->sDados = "";
	echo $oJson->encode($oRetorno);
} catch (Exception $oErro) {

	//echo  $oErro->getMessage();
	$oRetorno->status  = 2;
	$oRetorno->message = $oErro->getMessage();
	echo $oJson->encode($oRetorno);
}
