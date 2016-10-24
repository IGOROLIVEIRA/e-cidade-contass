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

require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("model/pessoal/relatorios/RelatorioFolhaSinteticoAnalitico.model.php");

$oJson               = new services_json();
$oParam              = $oJson->decode(db_stdClass::db_stripTagsJson(str_replace("\\","",$_POST["json"])));

$oRetorno            = new stdClass();
$oRetorno->status    = 1;
$oRetorno->message   = 1;
$lErro               = false;
$sMensagem           = "";


try {

switch($oParam->exec) {

	case 'gerarCsv' :

		$sArquivo     = "tmp/qualificacao.csv";

		$fArquivo     = fopen($sArquivo, "w");

		//echo $oParam->iMes.' '. $oParam->iAno;exit;

		$sSql  = "select z01_cgccpf,
		       z01_pis,
		       z01_nome,
               case
               when z01_nasc is not null then z01_nasc
               else rh01_nasc
               end as z01_nasc
		      from cgm
		      inner join rhpessoal on rh01_numcgm = z01_numcgm
		      where (z01_cgccpf != '00000000000' and z01_cgccpf != '00000000000000')
		      AND ((DATE_PART('YEAR',rh01_admiss) = ".$oParam->iAno." and DATE_PART('MONTH',rh01_admiss)<=" .$oParam->iMes.")
		      and (z01_cgccpf != '' and z01_cgccpf is not null))
		      ";

		$rsResult  = db_query($sSql);

		$aPessoas    =  array();
		$aCpfPessoas = array("00000000000","00000000000000","11111111111","11111111111111","22222222222","22222222222222","33333333333","33333333333333",
			"44444444444","44444444444444","55555555555","55555555555555","66666666666","66666666666666","77777777777","77777777777777","88888888888","88888888888888",
			"99999999999","99999999999999");
		$what = array("'","°",chr(13),chr(10), 'ä','ã','à','á','â','ê','ë','è','é','ï','ì','í','ö','õ','ò','ó','ô','ü','ù','ú','û','À','Á','Ã','É','Í','Ó','Ú','ñ','Ñ','ç','Ç',' ','-','(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' );

		// matriz de saída
		$by   = array('','','','', 'a','a','a','a','a','e','e','e','e','i','i','i','o','o','o','o','o','u','u','u','u','A','A','A','E','I','O','U','n','n','c','C',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ' );
		for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
			$oDados = db_utils::fieldsMemory($rsResult, $iCont);

			if (in_array($oDados->z01_cgccpf, $aCpfPessoas)) {
				continue;
			}

			$oDados->z01_nasc = implode('',array_reverse(explode('-',$oDados->z01_nasc)));

			$aDados = (array) $oDados;

			fputcsv($fArquivo, $aDados, ";");
			unset($aDados);

		}

		fclose($fArquivo);

		$oRetorno->sArquivo = $sArquivo;
		break;

}
/**
 * Encerrando switch escreve a saida json
 */
echo $oJson->encode($oRetorno);

} catch (Exception $oErro){
  $oRetorno->status  = 2;
  $oRetorno->message = $oErro->getMessage();
  echo $oJson->encode($oRetorno);
}

?>