<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_utils.php");
include_once("libs/db_sessoes.php");
include_once("libs/db_usuariosonline.php");
include_once("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);

if ($e53_codord) {
	$sSql = "select e82_codmov as movimento 
	from empord join empagemovforma on e82_codmov = e97_codmov 
	join empageconf on e86_codmov = e97_codmov where e86_correto = 't' and e82_codord = {$e53_codord}";
	
	$rsResult = db_query($sSql);
	if (pg_num_rows($rsResult) == 0) {
		$oDados = new stdClass();
		$oDados->erro = true;
		echo json_encode($oDados);
	} else {
	
		$sSql = "SELECT z01_nome,Z01_numcgm,pc63_contabanco,(pc63_agencia || '-' || pc63_agencia_dig || '/' || pc63_conta || '-' || pc63_conta_dig) AS contafornec 
		FROM pagordem JOIN empempenho ON e50_numemp = e60_numemp 
		JOIN cgm ON e60_numcgm = Z01_numcgm  
		LEFT JOIN pcfornecon ON Z01_numcgm = pc63_numcgm 
		LEFT JOIN pcforneconpad ON pc63_contabanco = pc64_contabanco 
		where e50_codord = {$e53_codord} ORDER BY pc64_contabanco";
		$rsResult = db_query($sSql);
		
		$sSql = "SELECT z01_nome,Z01_numcgm,pc63_contabanco,(pc63_agencia || '-' || pc63_agencia_dig || '/' || pc63_conta || '-' || pc63_conta_dig) AS contafornec 
		FROM pagordemconta
		JOIN cgm ON e49_numcgm = Z01_numcgm 
		LEFT JOIN pcfornecon ON Z01_numcgm = pc63_numcgm 
		LEFT JOIN pcforneconpad ON pc63_contabanco = pc64_contabanco  
		where e49_codord = {$e53_codord} ORDER BY pc64_contabanco";
		$rsResultPagordemconta = db_query($sSql);
		
	  if (pg_num_rows($rsResultPagordemconta) > 0) {
	    
	  	for ($iCont = 0; $iCont < pg_num_rows($rsResultPagordemconta); $iCont++) {
			
			  $oDados = db_utils::fieldsMemory($rsResultPagordemconta, $iCont);
		    $aValores[] = $oDados;
			
		  }
		  
	  } else {
		
		  for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
			
			  $oDados = db_utils::fieldsMemory($rsResult, $iCont);
		    $aValores[] = $oDados;
			
		  }
		
	  }
		$sSql = "SELECT ((e53_valor-e53_vlranu-e53_vlrpag)-(SELECT case when sum(e23_valorretencao) is null then 0 else sum(e23_valorretencao) end 
		from retencaoreceitas join retencaopagordem on e23_retencaopagordem = e20_sequencial 
		where e23_ativo != false and e20_pagordem = e53_codord)) as valorapagar from pagordemele where e53_codord = {$e53_codord}";
		$rsResult = db_query($sSql);
		$aValores[0]->valorapagar = db_utils::fieldsMemory($rsResult, 0)->valorapagar;
		echo json_encode($aValores);
	
	}
} else {
	
	if ($k00_cgmfornec) {

		$rsResultCodOrd = db_query("SELECT * FROM ordembancariapagamento WHERE k00_codord = {$k00_codord}");
		$rsResultSlip = db_query("SELECT * FROM ordembancariapagamento WHERE k00_slip = {$k17_codigo}");
		
		if ($k00_contabanco == '') {
			$k00_contabanco = 0;
		}
		
		if (pg_num_rows($rsResultCodOrd) == 0 && pg_num_rows($rsResultSlip) == 0) {
			if ($k00_codord == '') {
				$k00_codord = 'null';
			} else {
				$k17_codigo = 'null';
			}
			// Ocorrência 756	- incluído na linha 84 o campo k00_dtvencpag para salvar na tabela
			if($k00_dtvencpag == '' || $k00_dtvencpag == '--'){
				$k00_dtvencpag = 'null';
			}else{
				$k00_dtvencpag = "'".$k00_dtvencpag."'";
			}
			$sSql = "INSERT INTO ordembancariapagamento VALUES (nextval('ordembancariapagamento_k00_sequencial_seq'),
			{$k00_codordembancaria},{$k00_codord},{$k00_cgmfornec},{$k00_valor},{$k00_contabanco},{$k17_codigo},'{$k00_formapag}',{$k00_dtvencpag})";
			
		  db_query($sSql);
		  $oDados = new stdClass();
		  $oDados->erro = false;
		  echo json_encode($oDados);
		} else {
			$oDados = new stdClass();
		  $oDados->erro = true;
		  echo json_encode($oDados);
		}
		 
	} else {
		
	  if ($codord_excluir) {
	  	$rsResultExcluir = db_query("SELECT * FROM ordembancariapagamento WHERE k00_codord = {$codord_excluir}");
	  	if (pg_num_rows($rsResultExcluir) > 0) {
	  	  db_query("DELETE FROM ordembancariapagamento WHERE k00_codord = {$codord_excluir}");	
	  	} else {
	  		db_query("DELETE FROM ordembancariapagamento WHERE k00_slip = {$codord_excluir}");
	  	}
		  
	  } else {
	  	
	  	if ($k17_codigo) {
	  		
	  		$sSql = "SELECT k17_valor,z01_nome,z01_numcgm,pc63_contabanco,(pc63_agencia || '-' || pc63_agencia_dig || '/' || pc63_conta || '-' || pc63_conta_dig) AS contafornec 
	  		FROM slip s JOIN slipnum sn ON s.k17_codigo = sn.k17_codigo 
	  		JOIN cgm ON sn.k17_numcgm = z01_numcgm 
	  		LEFT JOIN pcfornecon ON z01_numcgm = pc63_numcgm
	  		LEFT JOIN pcforneconpad ON pc63_contabanco = pc64_contabanco
	  		WHERE s.k17_codigo = {$k17_codigo} ORDER BY pc64_contabanco";
	  		$rsResult = db_query($sSql);
		
		    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
			
			    $oDados = db_utils::fieldsMemory($rsResult, $iCont);
		      $aValores[] = $oDados;
			
		    }
		    $rsResult = db_query($sSql);
		    echo json_encode($aValores);
	  		
	  	}
	  	
	  }
	
	}
	
}
