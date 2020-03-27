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
	
		$sSql = "SELECT case when z01_nomecomple is not null then z01_nomecomple else z01_nome end as z01_nome,Z01_numcgm,pc63_contabanco,(pc63_agencia || '-' || pc63_agencia_dig || '/' || pc63_conta || '-' || pc63_conta_dig) AS contafornec
		FROM pagordem JOIN empempenho ON e50_numemp = e60_numemp 
		JOIN cgm ON e60_numcgm = Z01_numcgm  
		LEFT JOIN pcfornecon ON Z01_numcgm = pc63_numcgm 
		LEFT JOIN pcforneconpad ON pc63_contabanco = pc64_contabanco 
		where e50_codord = {$e53_codord} ORDER BY pc64_contabanco";
		$rsResult = db_query($sSql);
		
		$sSql = "SELECT case when z01_nomecomple is not null then z01_nomecomple else z01_nome end as z01_nome,Z01_numcgm,pc63_contabanco,(pc63_agencia || '-' || pc63_agencia_dig || '/' || pc63_conta || '-' || pc63_conta_dig) AS contafornec
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
		/*$sSql = "SELECT ((e53_valor-e53_vlranu-e53_vlrpag)-(SELECT case when sum(e23_valorretencao) is null then 0 else sum(e23_valorretencao) end
		from retencaoreceitas join retencaopagordem on e23_retencaopagordem = e20_sequencial 
		where e23_ativo != false and e20_pagordem = e53_codord)) as valorapagar from pagordemele where e53_codord = {$e53_codord}";*/
		$sSql = "SELECT sum(CASE WHEN (e90_codmov IS NULL
                      AND e97_codforma = 3)
           OR (e91_codmov IS NULL
               AND e97_codforma = 2)
           OR (e97_codforma NOT IN(3,2)
               OR e97_codforma IS NULL) THEN (e81_valor - valorretencao) ELSE 0 END) AS valor,e53_valor
FROM
  (SELECT empagemov.e81_codmov,
          e97_codforma,
          CASE
              WHEN e97_codforma IS NULL THEN 'NDA'
              ELSE e96_descr
          END AS e96_descr,
          e53_vlrpag,
          e81_valor,
          e86_codmov,
          e90_codmov,
          e91_codmov,
          e91_valor,
          e53_valor,
          fc_valorretencaomov(e81_codmov,FALSE) AS valorretencao,
          coalesce(e43_valor,0) AS e43_valor
   FROM empage
   INNER JOIN empagemov ON empagemov.e81_codage = empage.e80_codage
   INNER JOIN empord ON empord.e82_codmov = empagemov.e81_codmov
   INNER JOIN pagordem ON pagordem.e50_codord = empord.e82_codord
   INNER JOIN pagordemele ON pagordemele.e53_codord = pagordem.e50_codord
   INNER JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
   INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
   INNER JOIN db_config ON db_config.codigo = empempenho.e60_instit
   INNER JOIN orcdotacao ON orcdotacao.o58_anousu = empempenho.e60_anousu
   AND orcdotacao.o58_coddot = empempenho.e60_coddot
   INNER JOIN orctiporec ON orctiporec.o15_codigo = orcdotacao.o58_codigo
   INNER JOIN emptipo ON emptipo.e41_codtipo = empempenho.e60_codtipo
   LEFT JOIN corempagemov ON corempagemov.k12_codmov = empagemov.e81_codmov
   LEFT JOIN empageconf ON empageconf.e86_codmov = empord.e82_codmov
   LEFT JOIN empageconfgera ON empageconf.e86_codmov = e90_codmov
   LEFT JOIN empageconfche ON empageconf.e86_codmov = e91_codmov
   AND e91_ativo IS TRUE
   LEFT JOIN empagemovforma ON e97_codmov = e81_codmov
   LEFT JOIN empageforma ON e96_codigo = e97_codforma
   LEFT JOIN empagenotasordem ON e81_codmov = e43_empagemov
   LEFT JOIN empageordem ON e43_ordempagamento = e42_sequencial
   LEFT JOIN pagordemprocesso ON e50_codord = e03_pagordem
   WHERE ((round(e53_valor,2)-round(e53_vlranu,2)-round(e53_vlrpag,2)) > 0
          AND (round(e60_vlremp,2)-round(e60_vlranu,2)-round(e60_vlrpag,2)) > 0)
     AND corempagemov.k12_codmov IS NULL
     AND e81_cancelado IS NULL
     AND e80_data <= '".date("Y-m-d",db_getsession("DB_datausu"))."'
     AND e60_instit = ".db_getsession("DB_instit")."
     AND e50_codord = {$e53_codord}) AS x
WHERE e96_descr != 'NDA'
GROUP BY e96_descr,e53_valor";
		$rsResult = db_query($sSql);
		$aValores[0]->valorapagar = db_utils::fieldsMemory($rsResult, 0)->valor;
		echo json_encode($aValores);
	
	}
} else if ($e43_ordempagamento) {
	$sSql = "SELECT (sum(e43_valor)-sum(fc_valorretencaomov(e81_codmov,FALSE))) AS vlliquido
		FROM empagenotasordem
		INNER JOIN empagemov ON empagemov.e81_codmov = empagenotasordem.e43_empagemov
		INNER JOIN empageordem ON empageordem.e42_sequencial = empagenotasordem.e43_ordempagamento
		INNER JOIN empage ON empage.e80_codage = empagemov.e81_codage
		LEFT JOIN empord ON empagemov.e81_codmov = e82_codmov
		LEFT JOIN pagordem ON e82_codord = e50_codord
		WHERE e43_ordempagamento = {$e43_ordempagamento}";
		$rsResult = db_query($sSql);
		$aValores->vlliquido = db_utils::fieldsMemory($rsResult, 0)->vlliquido;

		echo json_encode($aValores);
} else {

  $aOrdem = array();
	if (!empty($ordemauxiliar)) {

		$sSql = "SELECT e43_valor-fc_valorretencaomov(e81_codmov,FALSE) as k00_valor,fc_valorretencaomov(e81_codmov,FALSE) AS valorretencao,e50_codord as k00_codord,slip.k17_codigo,z01_numcgm AS k00_cgmfornec,z01_nome,pc63_contabanco as k00_contabanco,(pc63_agencia || '-' || pc63_agencia_dig || '/' || pc63_conta || '-' || pc63_conta_dig) AS contafornec
			FROM empagenotasordem
			INNER JOIN empagemov ON empagemov.e81_codmov = empagenotasordem.e43_empagemov
			LEFT JOIN empageordem ON empageordem.e42_sequencial = empagenotasordem.e43_ordempagamento
			LEFT JOIN empage ON empage.e80_codage = empagemov.e81_codage
			LEFT JOIN empord ON empagemov.e81_codmov = e82_codmov
			LEFT JOIN pagordem ON e82_codord = e50_codord
			LEFT JOIN empempenho ON empempenho.e60_numemp = empagemov.e81_numemp
			LEFT JOIN empageslip ON empagemov.e81_codmov = empageslip.e89_codmov
			LEFT JOIN slip ON empageslip.e89_codigo = slip.k17_codigo
			LEFT JOIN slipnum ON slipnum.k17_codigo = slip.k17_codigo
			LEFT JOIN cgm ON (cgm.z01_numcgm = empempenho.e60_numcgm) OR (cgm.z01_numcgm = slipnum.k17_numcgm)
			LEFT JOIN pcfornecon ON cgm.z01_numcgm = pcfornecon.pc63_numcgm
			LEFT JOIN pcforneconpad ON pcfornecon.pc63_contabanco = pcforneconpad.pc64_contabanco
		  WHERE e43_ordempagamento = {$ordemauxiliar}";
    $rsResult = db_query($sSql);
    for ($iCont=0; $iCont < pg_num_rows($rsResult); $iCont++) { 
    	$oOrdem = db_utils::fieldsMemory($rsResult, $iCont);
    	$oOrdem->z01_nome = urlencode($oOrdem->z01_nome);
    	$aOrdem[] = $oOrdem;
    }
		
	} else if (!empty($k00_codord) || !empty($k17_codigo)) {

		$oDados = new stdClass();
		$oDados->k00_codord     = $k00_codord;
		$oDados->k17_codigo     = $k17_codigo;
		$oDados->k00_cgmfornec  = $k00_cgmfornec;
		$oDados->k00_valor      = $k00_valor;
		$oDados->k00_contabanco = $k00_contabanco;
		$aOrdem[] = $oDados;

	}
	// Ocorrência 756	- incluído na linha 84 o campo k00_dtvencpag para salvar na tabela
	if($k00_dtvencpag == '' || $k00_dtvencpag == '--'){
		$k00_dtvencpag = 'null';
	}else{
		$k00_dtvencpag = "'".$k00_dtvencpag."'";
	}

	if (!empty($k00_cgmfornec) || !empty($ordemauxiliar) ) {
		
		db_inicio_transacao();
		foreach ($aOrdem as $oDados) {
			
			/**
			 * Lógica se aplica para pagamentos fracionados.
			 * Busca o valor total da op para verificar se ainda possui saldo para incluir novas ordens bancarias.
			 * @see: Ocorrência 1814.
			 */
			$nValorOrdem = getValorOP($oDados->k00_codord, $oDados->k17_codigo);
			if (!empty($oDados->k00_codord)) {
			  $rsResultCodOrd = db_query("SELECT sum(k00_valorpag) as vlpago FROM ordembancariapagamento WHERE k00_codord = {$oDados->k00_codord} having sum(k00_valorpag) >= {$nValorOrdem}");
			}
			if (!empty($oDados->k17_codigo)) {
			  $rsResultSlip = db_query("SELECT sum(k00_valorpag) as vlpago FROM ordembancariapagamento WHERE k00_slip = {$oDados->k17_codigo} having sum(k00_valorpag) >= {$nValorOrdem}");
		  }
			if ($oDados->k00_contabanco == '') {
				$oDados->k00_contabanco = 0;
			}
			
			if (pg_num_rows($rsResultCodOrd) == 0 && pg_num_rows($rsResultSlip) == 0) {
				if ($oDados->k00_codord == '') {
					$oDados->k00_codord = 'null';
				} 
				if ($oDados->k17_codigo == '') {
					$oDados->k17_codigo = 'null';
				}
				if ($ordemauxiliar == '') {
					$ordemauxiliar = 'null';
				}
				$sSql = "SELECT nextval('ordembancariapagamento_k00_sequencial_seq')";
				$oDados->k00_sequencial = db_utils::fieldsMemory(db_query($sSql),0)->nextval;
				
				$sSql = "INSERT INTO ordembancariapagamento VALUES ({$oDados->k00_sequencial},
				{$k00_codordembancaria},{$oDados->k00_codord},{$oDados->k00_cgmfornec},{$oDados->k00_valor},{$oDados->k00_contabanco},{$oDados->k17_codigo},'{$k00_formapag}',{$k00_dtvencpag},{$ordemauxiliar})";
				db_query($sSql);

		  } else {
		  	db_fim_transacao(true);
			  $oDados = new stdClass();
		    $oDados->erro = true;
		    break;
	 	  }

	  }
	  db_fim_transacao(false);
	  if (!isset($oDados->erro)) {
	    $oDados = new stdClass();
	    $oDados->aOrdem = $aOrdem;
	    $oDados->erro   = false;
	  }
	  echo json_encode($oDados);
		 
	} else {
		
	  if ($cod_excluir) {
	  	  db_query("DELETE FROM ordembancariapagamento WHERE k00_sequencial = {$cod_excluir}");			  
	  } else {
	  	
	  	if ($k17_codigo) {
	  		
	  		$sSql = "SELECT k17_valor,case when z01_nomecomple is not null then z01_nomecomple else z01_nome end as z01_nome,z01_numcgm,pc63_contabanco,(pc63_agencia || '-' || pc63_agencia_dig || '/' || pc63_conta || '-' || pc63_conta_dig) AS contafornec
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

function getValorOP($codOrdem,$codSlip){
	if (empty($codOrdem)) {
		$sWhere = " corempagemov.k12_codmov IS NULL AND k17_codigo = {$codSlip} ";
	} else {
		$sWhere = " (((round(e53_valor,2)-round(e53_vlranu,2)-round(e53_vlrpag,2)) > 0
             AND (round(e60_vlremp,2)-round(e60_vlranu,2)-round(e60_vlrpag,2)) > 0)
					   OR (K17_DTANU IS NULL AND K17_DTESTORNO IS NULL))
					     AND corempagemov.k12_codmov IS NULL
					     AND e81_cancelado IS NULL
					     AND e80_data <= '".date("Y-m-d",db_getsession("DB_datausu"))."'
					     AND e60_instit = ".db_getsession("DB_instit")."
					     AND e50_codord = {$codOrdem}
					AND e96_descr != 'NDA'
					AND e97_codforma IS NOT NULL ";
	}
	$sSql = "SELECT CASE WHEN e53_valor IS NULL THEN k17_valor ELSE e53_valor END AS valor
   FROM empage
   LEFT JOIN empagemov ON empagemov.e81_codage = empage.e80_codage
   LEFT JOIN empord ON empord.e82_codmov = empagemov.e81_codmov
   LEFT JOIN pagordem ON pagordem.e50_codord = empord.e82_codord
   LEFT JOIN pagordemele ON pagordemele.e53_codord = pagordem.e50_codord
   LEFT JOIN empempenho ON empempenho.e60_numemp = pagordem.e50_numemp
   LEFT JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
   LEFT JOIN db_config ON db_config.codigo = empempenho.e60_instit
   LEFT JOIN orcdotacao ON orcdotacao.o58_anousu = empempenho.e60_anousu
   AND orcdotacao.o58_coddot = empempenho.e60_coddot
   LEFT JOIN orctiporec ON orctiporec.o15_codigo = orcdotacao.o58_codigo
   LEFT JOIN emptipo ON emptipo.e41_codtipo = empempenho.e60_codtipo
   LEFT JOIN corempagemov ON corempagemov.k12_codmov = empagemov.e81_codmov
   LEFT JOIN empageconf ON empageconf.e86_codmov = empord.e82_codmov
   LEFT JOIN empageconfgera ON empageconf.e86_codmov = e90_codmov
   LEFT JOIN empageconfche ON empageconf.e86_codmov = e91_codmov
   AND e91_ativo IS TRUE
   LEFT JOIN empagemovforma ON e97_codmov = e81_codmov
   LEFT JOIN empageforma ON e96_codigo = e97_codforma
   LEFT JOIN empageslip ON empagemov.e81_codmov = empageslip.e89_codmov
	 LEFT JOIN slip ON empageslip.e89_codigo = slip.k17_codigo
   LEFT JOIN empagenotasordem ON e81_codmov = e43_empagemov
   LEFT JOIN empageordem ON e43_ordempagamento = e42_sequencial
   LEFT JOIN pagordemprocesso ON e50_codord = e03_pagordem 
   WHERE {$sWhere}";
	$rsResult = db_query($sSql);
	$nValor = db_utils::fieldsMemory($rsResult, 0)->valor;
	return empty($nValor) ? 0.00 : $nValor;

}
