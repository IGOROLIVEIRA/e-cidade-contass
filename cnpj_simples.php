<?

include("libs/db_conn.php");
include("libs/db_stdlib.php");

if(!($conn1 = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "Contate com Administrador do Sistema! (Conexão Inválida.)   <br>Sessão terminada, feche seu navegador!\n";
  exit;
}

if(!($conn2 = @pg_connect("host=192.168.78.245 dbname=daeb port=5433 user=postgres"))) {
  echo "Contate com Administrador do Sistema! (Conexão Inválida.)   <br>Sessão terminada, feche seu navegador!\n";
  exit;
}

system("echo > /tmp/cnpj_simples.txt");

$sql = "select * from (
					select 
					x.z01_cgccpf,
					sum(case when arrecad.k00_valor is null then 0 else 1 end)
					from (
								select distinct 
											 z01_cgccpf,
											 z01_numcgm
								from cgm 
								where length(trim(z01_cgccpf)) = 14
							 ) as x
							 left join arrenumcgm 	on x.z01_numcgm = arrenumcgm.k00_numcgm
							 left join arrecad     	on arrecad.k00_numpre = arrenumcgm.k00_numpre and (case when k00_tipo = 3 then arrecad.k00_dtvenc < current_date else 1=1 end)
							 group by x.z01_cgccpf
							 ) as y
							 where sum = 0
						 order by y.z01_cgccpf
		";
$result = pg_exec($conn1, $sql) or die($sql);

for ($x=0; $x < pg_numrows($result); $x++) {
	db_fieldsmemory($result, $x);

  // procura na base daeb
	$sql_daeb = "	select * from cgm 
								inner join arrenumcgm on z01_numcgm = arrenumcgm.k00_numcgm
								inner join arrecad    on arrenumcgm.k00_numpre = arrecad.k00_numpre
								where z01_cgccpf = '$z01_cgccpf'";
	$result_daeb = pg_exec($conn2, $sql_daeb) or die($sql_daeb);

  if (pg_numrows($result_daeb) == 0) {
		system("echo $z01_cgccpf >> /tmp/cnpj_simples.txt");
	}

	echo "$z01_cgccpf -> $x / " . pg_numrows($result) . " - " . (pg_numrows($result_daeb) == 0?"nao achou debito daeb - inserindo ":"achou debito daeb - nao inserindo") . "\n";
	
}

?>
