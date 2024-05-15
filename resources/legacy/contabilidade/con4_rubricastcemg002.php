<?php
	
/**
 * Carregamos as bibliotecas nescessarias
 */
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("model/contabilidade/EventoContabil.model.php");
require_once("model/contabilidade/EventoContabilLancamento.model.php");
require_once("model/contabilidade/RegraLancamentoContabil.model.php");
db_postmemory($_POST);


/**
 * Verificamos se o arquivo é de extensão CSV e enviamos o mesmo para o tmp.
 * Caso houver um problema em algum desses processos redirecionamos para a página anterior
 * e informamos o ocorrido. 
 */
if ($_FILES['arquivoContasTCEMG']['type'] != 'text/xml') {
  
  $sErrorMessage = "O arquivo enviado não é do formato correto. Favor verificar o arquivo.";
  db_redireciona("con4_rubricastcemg.php?lErro=true&sErrorMessage=".$sErrorMessage);
}
if (!move_uploaded_file($_FILES['arquivoContasTCEMG']['tmp_name'], "/tmp/{$_FILES['arquivoContasTCEMG']['name']}")) {
  
  $sErrorMessage = "Ocorreu um erro na importação do arquivo de implantação. Favor verificar o arquivo.";
  db_redireciona("con4_rubricastcemg.php?lErro=true&sErrorMessage=".$sErrorMessage);
}



/**
 * Carregamos o arquivo de importação de transações na classe DOMDocument e após isso
 * percorremos o mesmo e montamos uma collection com as informações do mesmo
 */
$oDomXML = new DomDocument();
$oDomXML->load('/tmp/'.$_FILES["arquivoContasTCEMG"]['name']);
$aRubricas = array();
$oRubricas = $oDomXML->getElementsByTagName('rubrica');

db_inicio_transacao();

if ($opcao == 0) {

	$aEstruturaisReceita = array();
	$aEstruturaisDespesa = array();

	foreach ($oRubricas as $oRubrica) {
		
		$oRubricaAtual = new stdClass();
		
		if($oRubrica->getAttribute('tipo') == 'R'){
			$rubrica = '4'.$oRubrica->getAttribute('estrutural');
		}else{
			$rubrica = '3'.$oRubrica->getAttribute('estrutural');
		}
		
		$oRubricaAtual->estrutural 	  = str_pad(implode(explode(".", $rubrica)), 15, "0", STR_PAD_RIGHT);
		$oRubricaAtual->elemento 	    = str_pad(implode(explode(".", $rubrica)), 13, "0", STR_PAD_RIGHT); 
		$oRubricaAtual->descricao 	  = substr(utf8_decode($oRubrica->getAttribute('descricao')), 0, 50);
		$oRubricaAtual->finalidade 	  = utf8_decode($oRubrica->getAttribute('descricao')); 
		$oRubricaAtual->nivel 		    = $oRubrica->getAttribute('nivel'); 
		$oRubricaAtual->tipo 		      = $oRubrica->getAttribute('tipo');
		$oRubricaAtual->naturezasaldo = $oRubricaAtual->tipo == 'R'? 1 : 2;
		
		if ($oRubricaAtual->tipo == 'R') {
		  $aEstruturaisReceita[] = substr($oRubricaAtual->estrutural, 1, 10);
		} else if ($oRubricaAtual->tipo == 'D') {
			$aEstruturaisDespesa[] = substr($oRubricaAtual->estrutural, 1, 8);
		} 
		
		$sSql = "SELECT * FROM conplanoorcamento WHERE c60_estrut = '{$oRubricaAtual->estrutural}' and c60_anousu > ".db_getsession("DB_anousu");
		$rsResultCont = db_query($sSql);
		
	
		
		/**
		 * Caso não exista este estrutural para os proximos anos, novos registros serao incluidos
		 */
		if (pg_num_rows($rsResultCont) == 0) {
		
			$rsResultSeq = db_query("select nextval('conplanoorcamento_c60_codcon_seq')");
		  $oRubricaAtual->codigo 	      = db_utils::fieldsMemory($rsResultSeq, 0)->nextval;
			/**
			 * inserir as rubricas para os 4 proximos depois do ano atual do sistema
			 */
			for ($iAno = db_getsession("DB_anousu")+1; $iAno < db_getsession("DB_anousu")+5; $iAno++) {
			
		    $sSqlConplano = "INSERT INTO conplanoorcamento VALUES ($oRubricaAtual->codigo,{$iAno},'{$oRubricaAtual->estrutural}',
		    '{$oRubricaAtual->descricao}','{$oRubricaAtual->finalidade}',2,1,0,'N',{$oRubricaAtual->naturezasaldo})";
		
		    $sSqlOrcelemento = "INSERT INTO orcelemento VALUES ($oRubricaAtual->codigo,{$iAno},'{$oRubricaAtual->elemento}','{$oRubricaAtual->descricao}',
		    '{$oRubricaAtual->finalidade}','t')";
		
		    $sSqlOrcfontes = "INSERT INTO orcfontes VALUES ($oRubricaAtual->codigo,{$iAno},'{$oRubricaAtual->estrutural}','{$oRubricaAtual->descricao}',
		    '{$oRubricaAtual->finalidade}')";
		    
				$rsResult = db_query($sSqlConplano);
			  if ($oRubricaAtual->tipo == 'D') {
			    $rsResult = db_query($sSqlOrcelemento);
		    } else {
			    $rsResult = db_query($sSqlOrcfontes);
		    }
		  
		    if ($oRubricaAtual->nivel != 'S') {
		  	
		  	  $c61_codigo = 1;
		      if ($oRubricaAtual->tipo == 'R') {
			      $rsResult = db_query("select o15_codigo from orctiporec where o15_codtri = '{$oRubricaAtual->nivel}' order by o15_codigo");
			      $c61_codigo = db_utils::fieldsMemory($rsResult, 0)->o15_codigo;
		      }
		      if ($c61_codigo == "") {
		      	$c61_codigo = 1;
		      }
		  
		      $rsResult = db_query("select nextval('conplanoorcamentoanalitica_c61_reduz_seq')");
		      $c61_reduz = db_utils::fieldsMemory($rsResult, 0)->nextval;
		  	  $sSqlConplanoAnalitica = "INSERT INTO conplanoorcamentoanalitica VALUES ($oRubricaAtual->codigo,{$iAno},
		  	  $c61_reduz,".db_getsession("DB_instit").",$c61_codigo,0)";
		  	  $rsResult = db_query($sSqlConplanoAnalitica);
		  	
		    }
		  
		  }
		
		  /**
		 * Caso exista este estrutural para os proximos anos, os registros serao atualizados
		 */
		} else {
			
			/**
			 * atualizar as rubricas para os 4 proximos depois do ano atual do sistema
			 */
		  for ($iAno = db_getsession("DB_anousu")+1; $iAno < db_getsession("DB_anousu")+5; $iAno++) {
			
			  $sSql = "SELECT c60_codcon FROM conplanoorcamento WHERE c60_estrut = '{$oRubricaAtual->estrutural}' and c60_anousu = {$iAno}";
		    $rsResult = db_query($sSql);
		    if (pg_num_rows($rsResult) == 0) {
		    	continue;
		    }
		    $iCodCon = db_utils::fieldsMemory($rsResult, 0)->c60_codcon;
		    
		    $sSqlConplano = "UPDATE conplanoorcamento SET c60_descr = '{$oRubricaAtual->descricao}', c60_finali = '{$oRubricaAtual->finalidade}'
		    WHERE c60_codcon = {$iCodCon} AND c60_anousu = {$iAno}";
		
		    $sSqlOrcelemento = "UPDATE orcelemento SET o56_descr = '{$oRubricaAtual->descricao}', o56_finali = '{$oRubricaAtual->finalidade}' 
		    WHERE o56_codele = {$iCodCon} AND o56_anousu = {$iAno}";
		
		    $sSqlOrcfontes = "UPDATE orcfontes SET o57_descr = '{$oRubricaAtual->descricao}',o57_finali = '{$oRubricaAtual->finalidade}' 
		    WHERE o57_codfon = {$iCodCon} AND o57_anousu = {$iAno}";
		    
				$rsResult = db_query($sSqlConplano);
			  if ($oRubricaAtual->tipo == 'D') {
			    $rsResult = db_query($sSqlOrcelemento);
		    } else {
			    $rsResult = db_query($sSqlOrcfontes);
		    }
		  
		  }
			
		}
	  if (pg_last_error() != '') {
      die(pg_last_error());
    }
	}

	/**
	 * atualizar as rubricas dos 4 proximos anos depois do ano atual do sistema
	 */
	for ($iAno = db_getsession("DB_anousu")+1; $iAno < db_getsession("DB_anousu")+5; $iAno++) {
		  	
	  $sSql = "SELECT c61_codcon FROM conplanoorcamentoanalitica WHERE c61_anousu = $iAno";
		$rsResult = db_query($sSql);	
		for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
			
			$iCodCon = db_utils::fieldsMemory($rsResult, $iCont)->c61_codcon;
			
			$sSql = "SELECT c60_estrut FROM conplanoorcamento WHERE c60_anousu = {$iAno} AND c60_codcon = {$iCodCon}";
		  $rsResult2 = db_query($sSql);
		  
		  $sRubrica = db_utils::fieldsMemory($rsResult2, 0)->c60_estrut;
		  
		  if (substr($sRubrica, 0, 1) == '3') {
		  
		    if (!in_array(substr($sRubrica, 1, 8), $aEstruturaisDespesa)) {
		  	
		      /*if ($sRubrica == '411120101040000') {
		    		echo "despesa $sRubrica";
		    	}
		      if ($sRubrica == '411120101030000') {
		    		echo "despesa $sRubrica";
		    	}*/
		    	
			  	$sSqlConplano = "UPDATE conplanoorcamento SET c60_descr = 'DESATIVADO EM {$iAno}'
			    WHERE c60_codcon = {$iCodCon} AND c60_anousu = {$iAno}";
			    $rsResult3 = db_query($sSqlConplano);
			  	
			    $sSqlOrcelemento = "UPDATE orcelemento SET o56_descr = 'DESATIVADO EM {$iAno}' 
			    WHERE o56_codele = {$iCodCon} AND o56_anousu = {$iAno}";
			    $rsResult3 = db_query($sSqlOrcelemento);
			
			    $sSqlOrcfontes = "UPDATE orcfontes SET o57_descr = 'DESATIVADO EM {$iAno}' 
			    WHERE o57_codfon = {$iCodCon} AND o57_anousu = {$iAno}";
			    $rsResult3 = db_query($sSqlOrcfontes);
		  	
		    }	
		    
		  } else {
		  	
		    if (!in_array(substr($sRubrica, 1, 10), $aEstruturaisReceita)) {
		    	/*if ($sRubrica == '411120101040000') {
		    		echo "receita $sRubrica";
		    	}
		      if ($sRubrica == '411120101030000') {
		    		echo "receita $sRubrica";
		    	}*/
			  	$sSqlConplano = "UPDATE conplanoorcamento SET c60_descr = 'DESATIVADO EM {$iAno}'
			    WHERE c60_codcon = {$iCodCon} AND c60_anousu = {$iAno}";
			    $rsResult3 = db_query($sSqlConplano);
			  	
			    $sSqlOrcelemento = "UPDATE orcelemento SET o56_descr = 'DESATIVADO EM {$iAno}' 
			    WHERE o56_codele = {$iCodCon} AND o56_anousu = {$iAno}";
			    $rsResult3 = db_query($sSqlOrcelemento);
			
			    $sSqlOrcfontes = "UPDATE orcfontes SET o57_descr = 'DESATIVADO EM {$iAno}' 
			    WHERE o57_codfon = {$iCodCon} AND o57_anousu = {$iAno}";
			    $rsResult3 = db_query($sSqlOrcfontes);
		  	
		    }
		  	
		  }
		  
		}
		 
	}

} else {

	foreach ($oRubricas as $oRubrica) {
		
		$oRubricaAtual = new stdClass();
		
		if($oRubrica->getAttribute('tipo') == 'R'){
			$rubrica = '4'.$oRubrica->getAttribute('estrutural');
		}else{
			$rubrica = '3'.$oRubrica->getAttribute('estrutural');
		}
		
		$oRubricaAtual->estrutural 	  = str_pad(implode(explode(".", $rubrica)), 15, "0", STR_PAD_RIGHT);
		$oRubricaAtual->elemento 	    = str_pad(implode(explode(".", $rubrica)), 13, "0", STR_PAD_RIGHT); 
		$oRubricaAtual->descricao 	  = substr(utf8_decode($oRubrica->getAttribute('descricao')), 0, 50);
		$oRubricaAtual->finalidade 	  = utf8_decode($oRubrica->getAttribute('descricao')); 
		$oRubricaAtual->nivel 		    = $oRubrica->getAttribute('nivel'); 
		$oRubricaAtual->tipo 		      = $oRubrica->getAttribute('tipo');
		$oRubricaAtual->naturezasaldo = $oRubricaAtual->tipo == 'R'? 1 : 2;
		
	  for ($iAno = db_getsession("DB_anousu")+1; $iAno < db_getsession("DB_anousu")+5; $iAno++) {
		  
	  	$sSql = "SELECT * FROM conplanoorcamento WHERE c60_estrut = '{$oRubricaAtual->estrutural}' and c60_anousu = {$iAno}";
		  $rsResultCont = db_query($sSql);
		  $oConPlano = db_utils::fieldsMemory($rsResultCont, 0);
		  
		  $sSql = "SELECT * FROM conplanoorcamentoanalitica WHERE c61_codcon = {$oConPlano->c60_codcon} and c61_anousu = {$iAno}";
		  $rsResultAnalitica = db_query($sSql);
		  
		  if (pg_num_rows($rsResultAnalitica) > 0 && $oRubricaAtual->nivel != 'S') {
		  	
		  	$c61_codigo = 1;
		  	$rsResult   = db_query("select o15_codigo from orctiporec where o15_codtri = '{$oRubricaAtual->nivel}' order by o15_codigo");
			  $c61_codigo = db_utils::fieldsMemory($rsResult, 0)->o15_codigo;
		    if ($c61_codigo == "") {
		      $c61_codigo = 1;
		    }
		  	$sSqlUpdate = "UPDATE conplanoorcamentoanalitica set c61_codigo = {$c61_codigo} WHERE c61_codcon = {$oConPlano->c60_codcon} and c61_anousu = {$iAno}";
		  	$rsResult   = db_query($sSqlUpdate);
		  	
		  } else if (pg_num_rows($rsResultAnalitica) > 0 && $oRubricaAtual->nivel == 'S') {
		  	
		  	$sSqlDelete = "DELETE FROM conplanoorcamentoanalitica WHERE c61_codcon = {$oConPlano->c60_codcon} and c61_anousu = {$iAno}";
		  	$rsResult   = db_query($sSqlUpdate);
		  	
		  } else if (pg_num_rows($rsResultAnalitica) == 0 && $oRubricaAtual->nivel != 'S') {
		  	
		    $c61_codigo = 1;
		  	$rsResult   = db_query("select o15_codigo from orctiporec where o15_codtri = '{$oRubricaAtual->nivel}' order by o15_codigo");
			  $c61_codigo = db_utils::fieldsMemory($rsResult, 0)->o15_codigo;
		    if ($c61_codigo == "") {
		      $c61_codigo = 1;
		    }
		    $rsResult = db_query("select nextval('conplanoorcamentoanalitica_c61_reduz_seq')");
		    $c61_reduz = db_utils::fieldsMemory($rsResult, 0)->nextval;
		  	$sSqlConplanoAnalitica = "INSERT INTO conplanoorcamentoanalitica VALUES ($oConPlano->c60_codcon,{$iAno},
		  	$c61_reduz,".db_getsession("DB_instit").",$c61_codigo,0)";
		  	$rsResult = db_query($sSqlConplanoAnalitica);
		  	
		  }
		  
	  }
		
	}

}

db_fim_transacao();

$sMessage = "Salvo com sucesso!";
 db_redireciona("con4_rubricastcemg.php?sMessage=".$sMessage);

?>