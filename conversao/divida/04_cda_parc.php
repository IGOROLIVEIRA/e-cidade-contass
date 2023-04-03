<?

// acerto dos problemas de origem dos parcelamentos do certidao e certidao de parcelamento migrados do sam30

set_time_limit(0);

$str_hora = date( "h:m:s" );

require("db_fieldsmemory.php");
require("db_conn.php");

$sArqLog = "txt/$DB_BASE-".basename(__FILE__).".txt";

db_log("", $sArqLog);
db_log("*** INICIO Script ".basename(__FILE__)." ***", $sArqLog);
db_log("", $sArqLog);

db_log("Arquivo de Log: $sArqLog", $sArqLog);
db_log("    Script PHP: ".basename(__FILE__), $sArqLog);
db_log("", $sArqLog);

db_log("Conectando...", $sArqLog);


// Conexao com as bases de dados do DBPortal e Sam30
include("db_conecta.php");


$sqlano = "select extract (year from now()) as anoatual";
$resultano = pg_query( $conn1, $sqlano) or die(db_log("ERRO SQL: $sqlano", $sArqLog)) ;
db_fieldsmemory( $resultano,0 );

$sql =	"	
      select	termoini.parcel, 
			certter.v14_parcel, 
			termoini.inicial, 
			inicialcert.v51_inicial, 
			certter.v14_certid, 
			inicialcert.v51_certidao,
			termo.v07_numpre,
      termo.v07_dtlanc as dtlanc_dbportal
					from termoini 
					inner join termo on v07_parcel = parcel
					inner join inicialcert on inicialcert.v51_inicial = termoini.inicial 
					inner join certter on certter.v14_certid = inicialcert.v51_certidao 
					where termoini.parcel = certter.v14_parcel
					order by termoini.parcel
				";
// die("\n\n\n $sql \n\n\n");
//          and termoini.parcel = 10597

$result = pg_exec($conn1, $sql) or die(db_log("ERRO SQL: $sql", $sArqLog));

if (pg_num_rows($result) == 0) {
	db_log("sem registros a processar...", $sArqLog);
	exit;
}

$erro = false;

$dtparcelmaior=0;
$dtcertidmaior=0;
$naoachoucertid=0;

$inseridos=0;
$inseridotermoini=0;

pg_exec( $conn1, "begin;") or die(db_log("ERRO SQL DbPortal: begin;", $sArqLog));
pg_exec( $conn2, "begin;") or die(db_log("ERRO SQL Sam30: begin;", $sArqLog));

for ($reg=0; $reg < pg_num_rows($result); $reg++) {
  db_fieldsmemory($result, $reg);

	$sql = "	select	distinct	
										v01_coddiv,
										v01_valor,
										v01_matric, 
										v01_dtcert, 
										v01_exerc, 
										v01_numpre, 
										v01_certid, 
										v13_dtemis, 
										v01_parcel, 
										v07_dtlanc 
						from divida 
						left join certid on v13_certid = v01_certid 
						left join termo on v07_parcel = v01_parcel and v07_numpre = v01_numpre 
						where v01_parcel = '" . str_pad($v14_parcel,6," ", STR_PAD_LEFT) . "'";

  $sqltestando = $sql . " and coalesce(length(trim(v01_certid)),0) = 0";

//	die("\n$sqltestando\n");

	$result_teste = pg_exec($conn2, $sqltestando) or die(db_log("ERRO SQL Sam30: $sqltestando", $sArqLog));
	if (pg_num_rows($result_teste) > 0) {
    $v07_dtlanc = pg_result($result_teste,0,"v07_dtlanc");
    if ($dtlanc_dbportal == "" and $v07_dtlanc != "") {
      db_log("Sam30: atualizando data do parcelamento...", $sArqLog);
      $sqlupdate = "update termo set v07_dtlanc = '$v07_dtlanc' where v07_parcel = $v14_parcel";
      $resultupdate = pg_exec($conn1, $sqlupdate) or die(db_log("ERRO SQL DbPortal: $sqlupdate", $sArqLog));
    }
  }

	$sql .= " order by v01_certid";

	$resultdiv = pg_exec($conn2, $sql) or die(db_log("ERRO SQL Sam30: $sql", $sArqLog));

	$datacertidao = "";

	for ($div=0; $div < pg_num_rows($resultdiv); $div++) {
		db_fieldsmemory($resultdiv, $div);

    if ($datacertidao == "") {
			if ($v01_dtcert != "") {
				$datacertidao = $v01_dtcert;
			} elseif ($v13_dtemis != "") {
				$datacertidao = $v13_dtemis;
			}
		}
			
	}

	db_log("parcel: $v14_parcel - $reg/" . pg_num_rows($result) . " - " . pg_num_rows($resultdiv) . " - dtcert: " . $v01_dtcert . " - v07_dtlanc: " . $v07_dtlanc . " - v13_dtemis: " . $v13_dtemis , $sArqLog);

	if ($datacertidao == "") {
		db_log("sem data de certidao definida", $sArqLog);
		exit;
	}

	if (pg_num_rows($result_teste) > 0) {

		db_log("efetuando acertos...", $sArqLog);

		$sqlnext = "select ultcertid + 1 as ultcertid from pardiv";
		$resultnext = pg_exec($conn1, $sqlnext) or die(db_log("ERRO SQL DbPortal: $sqlnext", $sArqLog));
		db_fieldsmemory($resultnext,0);

    $continua = true;
    while ($continua == true) {
      $sqltesta = "select * from certid where v13_certid = $ultcertid";
      $resulttesta = pg_exec($conn1, $sqltesta) or die(db_log("ERRO SQL DbPortal: $sqltesta", $sArqLog));
      if (pg_num_rows($resulttesta) == 0) {
        $continua=false;
      } else {
        $ultcertid++;
      }
    }

		$sqlupdate = "update pardiv set ultcertid = $ultcertid";
		$resultupdate = pg_exec($conn1, $sqlupdate) or die(db_log("ERRO SQL DbPortal: $sqlupdate", $sArqLog));

		$sqlinsert = "insert into certid (v13_certid, v13_dtemis, v13_login) values ($ultcertid, '$datacertidao', 'dbseller')";
		$resultinsert = pg_exec($conn1, $sqlinsert) or die(db_log("ERRO SQL DbPortal: $sqlinsert", $sArqLog));
		
		for ($div=0; $div < pg_num_rows($resultdiv); $div++) {
			db_fieldsmemory($resultdiv, $div);

      $sqlinsert = "insert into certdiv (v14_certid, v14_coddiv) values ($ultcertid, $v01_coddiv)";			
			$resultinsert = pg_exec($conn1, $sqlinsert) or die(db_log("ERRO SQL DbPortal: $sqlinsert", $sArqLog));

		}

    db_log("  inserindo em inicial...", $sArqLog);
    $sqlinicialseq = "select nextval('inicial_v50_inicial_seq') as v50_inicial";
    $resultinicialseq = pg_exec($conn1, $sqlinicialseq) or die(db_log("ERRO SQL DbPortal: $sqlinicialseq", $sArqLog));
    db_fieldsmemory($resultinicialseq,0);
    
    $insertinicial = "insert into inicial (v50_inicial, v50_advog, v50_data, v50_id_login, v50_codlocal, v50_codmov)
    values ($v50_inicial, $advog, '$datacertidao', 1, 1, 1)";
    $resultinicial = pg_exec($conn1, $insertinicial) or die(db_log("ERRO SQL DbPortal: $insertinicial", $sArqLog));
    
    db_log("     inserindo em inicialmov...", $sArqLog);
    $sqlinicialmovseq = "select nextval('inicialmov_v56_codmov_seq') as v56_codmov";
    $resultinicialmovseq = pg_exec($conn1, $sqlinicialmovseq) or die(db_log("ERRO SQL DbPortal: $sqlinicialmovseq", $sArqLog));
    db_fieldsmemory($resultinicialmovseq,0);
    
    $insertinicialmov = "insert into inicialmov (v56_codmov, v56_inicial, v56_codsit, v56_obs, v56_data, v56_id_login)
                         values ($v56_codmov, $v50_inicial, 1, 'migracao', '$anoatual-01-01', 1)";
    $resultinicialmov = pg_exec($conn1, $insertinicialmov) or die(db_log("ERRO SQL DbPortal: $insertinicialmov", $sArqLog));
    
    $sqlupdateini = "update inicial set v50_codmov = $v56_codmov where v50_inicial = $v50_inicial";
    $resultupdateini = pg_exec($conn1, $sqlupdateini) or die(db_log("ERRO SQL DbPortal: $sqlupdateini", $sArqLog));
    
    db_log("     inserindo em inicialcert...", $sArqLog);
    $insertinicialcert = "insert into inicialcert (v51_inicial, v51_certidao)
                          values ($v50_inicial, $ultcertid)";
    $resultinicialcert = pg_exec($conn1, $insertinicialcert) or die(db_log("ERRO SQL DbPortal: $insertinicialcert", $sArqLog));
    
    db_log("     inserindo em inicialcodforo...", $sArqLog);
    $insertinicialcodforo = "insert into inicialcodforo (v55_inicial, v55_codforo, v55_data, v55_id_login, v55_codvara)
                             values ($v50_inicial, $v50_inicial, '$anoatual-01-01', 1, 1)";
    $resultinicialcodforo = pg_exec($conn1, $insertinicialcodforo) or die(db_log("ERRO SQL DbPortal: $insertinicialcodforo", $sArqLog));
    
    $sqldivida = "select v01_numpre as numpreant 
                  from divida 
                  where v01_coddiv = $v01_coddiv";
    $resultdivida = pg_exec($conn1, $sqldivida) or die(db_log("ERRO SQL DbPortal: $sqldivida", $sArqLog));
    $numpreant = pg_result($resultdivida,0,"numpreant");

    db_log("     inserindo em termoini...", $sArqLog);
    $sqlinsert = "insert into termoini
                  (
                  parcel,
                  inicial,
                  valor,
                  total,
                  numpreant,
                  vlrcor
                  )
                  values
                  (
                  $v14_parcel,
                  $v50_inicial,
                  $v01_valor,
                  $v01_valor,
                  $numpreant,
                  $v01_valor
                  )";
    $resultinsert = pg_exec($conn1, $sqlinsert) or die(db_log("ERRO SQL DbPortal: $sqlinsert", $sArqLog));
    $inseridotermoini++;







    db_log("Sam30: alterando tabela divida (v01_certid = '" . str_pad($ultcertid,6,"0", STR_PAD_LEFT) . "', v01_dtcert = '$datacertidao' where v01_parcel = '" . str_pad($v14_parcel,6," ", STR_PAD_LEFT) . "' and coalesce(length(trim(v01_certid)),0) = 0", $sArqLog);
		$sqlupdate = "update divida set v01_certid = '" . str_pad($ultcertid,6,"0", STR_PAD_LEFT) . "', v01_dtcert = '$datacertidao' where v01_parcel = '" . str_pad($v14_parcel,6," ", STR_PAD_LEFT) . "' and coalesce(length(trim(v01_certid)),0) = 0";
		$resultupdate = pg_exec($conn2, $sqlupdate) or die(db_log("ERRO SQL Sam30: $sqlupdate", $sArqLog));
		
	} else {
		db_log("nao necessitou acertos...", $sArqLog);
	}

	if ($v07_dtlanc >= $datacertidao) {

    db_log("parcel maior", $sArqLog);

		$sqldelete = "delete from certter where v14_certid = $v14_certid";
		$resultdelete = pg_exec($conn1, $sqldelete) or die(db_log("ERRO SQL DbPortal: $sqldelete", $sArqLog));

		$resultdiv = pg_exec($conn2, $sql) or die(db_log("ERRO SQL Sam30: $sql", $sArqLog));

    if (pg_num_rows($result_teste) > 0) {
			$result_teste = pg_exec($conn2, $sqltestando) or die(db_log("ERRO SQL Sam30: $sqltestando", $sArqLog));
			db_log("Sam30  x: " . pg_num_rows($result_teste), $sArqLog);
		}
		
    for ($div=0; $div < pg_num_rows($resultdiv); $div++) {
      db_fieldsmemory($resultdiv, $div);

      $sqldelete = "delete from termodiv where parcel = $v14_parcel and coddiv = $v01_coddiv";
      $resultdelete = pg_exec($conn1, $sqldelete) or die(db_log("ERRO SQL DbPortal: $sqldelete", $sArqLog));

      $sqlupdate = "update arreold set k00_tipo = 34 where k00_numpre = $v01_numpre";
      $resultupdate = pg_exec($conn1, $sqlupdate) or die(db_log("ERRO SQL DbPortal: $sqlupdate", $sArqLog));

      if ($v01_certid == "") {

				db_log("certid zerado - coddiv: $v01_coddiv", $sArqLog);
        db_log("", $sArqLog);
        db_log("", $sArqLog);
        db_log("", $sArqLog);
				db_log("SQL: $sql", $sArqLog);
        db_log("", $sArqLog);
        db_log("", $sArqLog);
				exit;
        
			}

      $sqlcertdiv = "select * from certdiv where v14_certid = $v01_certid and v14_coddiv = $v01_coddiv";
      $resultcertdiv = pg_exec($conn1, $sqlcertdiv) or die(db_log("ERRO SQL DbPortal: $sqlcertdiv", $sArqLog));

      if (pg_num_rows($resultcertdiv) == 0) {

        db_log("inserindo certdiv: $v01_certid - coddiv: $v01_coddiv", $sArqLog);
        
        $sqlprocura = "select * from certid where v13_certid = $v01_certid";
        $resultprocura = pg_exec($conn1, $sqlprocura) or die(db_log("ERRO SQL DbPortal: $sqlprocura", $sArqLog));
        if (pg_num_rows($resultprocura) == 0) {

          $sqlinsert = "insert into certid (v13_certid, v13_dtemis, v13_login) values ($v01_certid, '$datacertidao', 'dbseller')";
          $resultinsert = pg_exec($conn1, $sqlinsert) or die(db_log("ERRO SQL DbPortal: $sqlinsert", $sArqLog));
          $naoachoucertid++;

        }

        $sqlinsert = "insert into certdiv (v14_certid, v14_coddiv) values ($v01_certid, $v01_coddiv)";
        $resultinsert = pg_exec($conn1, $sqlinsert) or die(db_log("ERRO SQL DbPortal: $sqlinsert", $sArqLog));

        $inseridos++;

      } else {
        db_log("ja existe certdiv", $sArqLog);
      }

    }

		$dtparcelmaior++;

	} else {

	  $sqlupdate = "update arrecad set k00_tipo = 34 where k00_numpre = $v07_numpre";
	  $resultupdate = pg_exec($conn1, $sqlupdate) or die(db_log("ERRO SQL DbPortal: $sqlupdate", $sArqLog));

		$sqldelete = "delete from termoini where parcel = $v14_parcel";
		$resultdelete = pg_exec($conn1, $sqldelete) or die(db_log("ERRO SQL DbPortal: $sqldelete", $sArqLog));
		
		$dtcertidmaior++;
		db_log("certid maior", $sArqLog);
		
		$resultdiv = pg_exec($conn2, $sql) or die(db_log("ERRO SQL Sam30: $sql", $sArqLog));

    for ($div=0; $div < pg_num_rows($resultdiv); $div++) {
      db_fieldsmemory($resultdiv, $div);

      $sqldivida = "select v01_numpre as numpreant 
                    from divida 
                    where v01_coddiv = $v01_coddiv";
      $resultdivida = pg_exec($conn1, $sqldivida) or die(db_log("ERRO SQL DbPortal: $sqldivida", $sArqLog));
      $numpreant = pg_result($resultdivida,0,"numpreant");

      $sqltermodiv = "select * from termodiv where parcel = $v14_parcel and coddiv = $v01_coddiv";
      $resulttermodiv = pg_exec($conn1, $sqltermodiv) or die(db_log("ERRO SQL DbPortal: $sqltermodiv", $sArqLog));

      if (pg_num_rows($resulttermodiv) == 0) {

        db_log("inserindo termodiv - termo: $v14_parcel - coddiv: $v01_coddiv", $sArqLog);

        $sqlinsert = "insert into termodiv
                      (
                      parcel,
                      coddiv,
                      valor,
                      total,
                      numpreant,
                      vlrcor
                      )
                      values
                      (
                      $v14_parcel,
                      $v01_coddiv,
                      $v01_valor,
                      $v01_valor,
                      $numpreant,
                      $v01_valor
                      )";
        $resultinsert = pg_exec($conn1, $sqlinsert) or die(db_log("ERRO SQL DbPortal: $sqlinsert", $sArqLog));

				$sqlinsertarreold = "insert into arreold		select 
																										v01_numpre,
																										v01_numpar,
																										v01_numcgm,
																										v01_dtoper,
																										v03_receit,
																										k00_hist,
																										case when v01_valor = 0 then v01_vlrhis else v01_valor end,
																										v01_dtvenc,
																										v01_numtot,
																										v01_numdig,
																										5,
																										0
                                        from divida 
                                        inner join proced on v01_proced = v03_codigo
                                        where v01_coddiv = $v01_coddiv
															";
			  $resultarreold = pg_exec($conn1, $sqlinsertarreold) or die(db_log("ERRO SQL DbPortal: $sqlinsertarreold", $sArqLog));
        
        $inseridos++;

      }

    }
		
	}

}

pg_exec($conn1, "commit;") or die(db_log("ERRO SQL DbPortal: commit;", $sArqLog));
pg_exec($conn2, "commit;") or die(db_log("ERRO SQL Sam30: commit;", $sArqLog));

db_log("", $sArqLog);
db_log("dtparcelmaior: $dtparcelmaior", $sArqLog);
db_log("dtcertidmaior: $dtcertidmaior", $sArqLog);
db_log("inseridos: $inseridos", $sArqLog);
db_log("naoachoucertid: $naoachoucertid", $sArqLog);
db_log("inseridotermoini: $inseridotermoini", $sArqLog);

db_log("", $sArqLog);
db_log("Inicio: $str_hora", $sArqLog);
db_log("Final.: " . date( "h:m:s"), $sArqLog);

db_log("", $sArqLog);
db_log("*** FINAL Script ".basename(__FILE__)." ***", $sArqLog);
db_log("", $sArqLog);


?>
