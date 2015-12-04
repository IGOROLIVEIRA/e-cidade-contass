<?

// considerando apenas matriculas da zona 4 e que tenham apenas taxa calculada sem imposto lancado (isentos de imposto)

require("db_conn.php");

global $log;
$log=inicialog(basename(__FILE__));

$conn_origem = conecta($DB_IP_ORIGEM, $DB_BASE_ORIGEM, $DB_PORTA_ORIGEM , $log);
$conn_destino = conecta($DB_IP_DESTINO, $DB_BASE_DESTINO, $DB_PORTA_DESTINO, $log);

$exerc = 2007;
$zona = 4;

$sql = "select	x.*,
				(select count(distinct k00_numpar) from arrecad where k00_numpre = x.j20_numpre and arrecad.k00_dtvenc < current_date) as atrasadas_prefa
					from (
								select	j23_matric, 
												j20_numpre, 
												coalesce(( select sum(j21_valor) from iptucalv where iptucalv.j21_anousu = iptucalc.j23_anousu and iptucalv.j21_matric = iptucalc.j23_matric and iptucalv.j21_codhis = 2),0) as val_lixo,
												coalesce(( select sum(j21_valor) from iptucalv where iptucalv.j21_anousu = iptucalc.j23_anousu and iptucalv.j21_matric = iptucalc.j23_matric and iptucalv.j21_codhis in (1, 5)),0) as val_imposto
								from	(
											select distinct j46_matric
											from iptuisen 
											inner join iptubase on iptubase.j01_matric = iptuisen.j46_matric
											inner join lote			on iptubase.j01_idbql = lote.j34_idbql
											where lote.j34_zona = $zona and iptuisen.j46_tipo in (117, 118, 162, 211, 212, 213, 216, 217, 218) 
											) as x
								inner join iptucalc on x.j46_matric = iptucalc.j23_matric and iptucalc.j23_anousu = $exerc
								left  join iptunump on iptunump.j20_anousu = iptucalc.j23_anousu and iptunump.j20_matric = iptucalc.j23_matric 
							) as x 
							order by j23_matric";

$result = executa( $conn_origem, $sql, $log);

db_msg("matricula;val_lixo;val_imposto;atrasadas_prefeitura;atrasadas_daeb", $log);

for ($x=0; $x < pg_numrows($result); $x++) {
	db_fieldsmemory($result, $x);

  $sql_procura = "select	x22_matric, 
													sum(atrasadas) as atrasadas_daeb
									from (	select	distinct x22_matric, 
																	x22_numpre, 
																	x22_mes, 
																	(	select count(distinct extract (month from k00_dtvenc)) 
																		from arrecad 
																		where k00_numpre = x22_numpre and 
																					k00_dtvenc < current_date) as atrasadas 
													from aguacalc 
													inner join aguacalcval on x22_codcalc = x23_codcalc 
													inner join aguaconsumotipo on x23_codconsumotipo = x25_codconsumotipo 
													where x22_exerc = $exerc and x22_matric = $j23_matric) as x group by x22_matric";
	$result_procura = executa( $conn_destino, $sql_procura, $log);

	if (pg_numrows($result_procura) == 0) {
		$atrasadas_daeb = 0;
	} else {
		db_fieldsmemory($result_procura, 0);
	}

  db_msg("$j23_matric;" . trim(db_formatar($val_lixo,"f")) . ";" . trim(db_formatar($val_imposto,"f")) . ";$atrasadas_prefa;$atrasadas_daeb", $log);

}

?>
