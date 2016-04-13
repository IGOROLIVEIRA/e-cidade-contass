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
} else {
	
	if ($k00_cgmfornec) {
		/**
		 * Lógica se aplica para pagamentos fracionados.
		 * Busca o valor total da op para verificar se ainda possui saldo para incluir novas ordens bancarias.
		 * @see: Ocorrência 1814.
		 */
		$nValorOrdem = getValorOP($k00_codord);
		$rsResultCodOrd = db_query("SELECT sum(k00_valorpag) as vlpago FROM ordembancariapagamento WHERE k00_codord = {$k00_codord} having sum(k00_valorpag) >= {$nValorOrdem}");
		$rsResultSlip = db_query("SELECT sum(k00_valorpag) as vlpago FROM ordembancariapagamento WHERE k00_slip = {$k17_codigo} having sum(k00_valorpag) >= {$nValorOrdem}");

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

function getValorOP($codordem){
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
     AND e50_codord = {$codordem}) AS x
WHERE e96_descr != 'NDA'
GROUP BY e96_descr,e53_valor";
	$rsResult = db_query($sSql);
	return db_utils::fieldsMemory($rsResult, 0)->e53_valor;
}
