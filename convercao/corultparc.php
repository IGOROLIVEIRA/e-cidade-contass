<?
set_time_limit(0);
$base = "auto_bag_1604";
$host = "192.168.0.37";

$conn = pg_connect("dbname=$base user=postgres host=$host") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');
echo 'Aguarde conectando na base de dados... ';
system("echo 'BEGIN;' > /tmp/logconver.sql;");
pg_query("BEGIN;");
$sqlNumpres = "
		select distinct on (k00_numpre)
			   k00_numpre,
			   k00_numpar as par,
			   k00_receit,
			   k00_valor
		   from arrecad
		where k00_valor < 0
		  and k00_hist not in (918,33)
		  and k00_tipo in (6,26,30,28)
		group by k00_numpre,
			 k00_numpar,
			 k00_receit,
			 k00_valor
		order by k00_numpre,
			 k00_numpar desc  ;"; 

//die($sqlNumpres);
$rsNumpres = pg_query($sqlNumpres) or die($sqlNumpres);
$numrows   = pg_numrows($rsNumpres);
echo "executou o sql \n";
for($i=0;$i<$numrows;$i++){
    db_fieldsmemory($rsNumpres,$i);
    if($par>0){
      $par--; 
    }
    $sqlArrecad = "select k00_numpre, 
                          k00_numpar, 
                          k00_receit,
			  k00_valor as val 
		     from arrecad 
		   where k00_numpre = $k00_numpre 
		     and k00_numpar = $par 
		     and k00_receit = $k00_receit;";
//    die($sqlArrecad);
    $rsArrecad  =  pg_query($sqlArrecad) or die (" F A L H O U  S E L E C T  A R R E C A D +++---".$sqlArrecad."\n");
    $num        =  pg_numrows($rsArrecad);
    if($num==0){
      echo " C O N T I N U E =>  ||-- k00_numpre = $k00_numpre   ||    k00_numpar = $par   ||   k00_receit = $k00_receit --|| \n";
      continue;      
    }
    db_fieldsmemory($rsArrecad,0);
    if($val > 0){	
        if($par>0){
           $par++;
	}
	$sql = "UPDATE arrecad SET k00_valor = $val where k00_numpre = $k00_numpre and k00_numpar = $par and k00_receit = $k00_receit;";
        pg_query($sql) or die(" F A L H O U   U P D A T E --+++ ".$sql."\n");
	echo $sql."\n";
	system("echo '".$sql."'>> /tmp/logconver.sql;");
    }else{
         echo "||-- k00_numpre = $k00_numpre   ||    k00_numpar = $par   ||   k00_receit = $k00_receit --|| \n";
    }
}

//pg_query("ROLLBACK;");
pg_query("COMMIT;");







function db_fieldsmemory($recordset, $indice, $formatar = "", $mostravar = false) {
		//#00#//db_fieldsmemory
		//#10#//Esta funcao cria as variáveis de uma determinada linha de um record set, sendo o nome da variável
		//#10#//o nome do campo no record set e seu conteúdo o conteúdo da variável
		//#15#//db_fieldsmemory($recordset,$indice,$formatar="",$mostravar=false);
		//#20#//Record Set        : Record set que será pesquisado
		//#20#//Indice            : Número da linha (índice) que será caregada as funções
		//#20#//Formatar          : Se formata as variáveis conforme o tipo no banco de dados
		//#20#//                    true = Formatar      false = Não Formatar (Padrão = false)
		//#20#//Mostrar Variáveis : Mostrar na tela as variáveis que estão sendo geradas
		//#99#//Esta função é bastante utilizada quando se faz um for para percorrer um record set.
		//#99#//Exemplo: 
		//#99#//db_fieldsmemory($result,0);
		//#99#//Cria todas as variáveis com o conteúdo de cada uma sendo o valor do campo
	$fm_numfields = pg_numfields($recordset);
	$fm_numrows = pg_numrows($recordset);
	//if(pg_numrows($recordset)==0){
	// echo "RecordSet Vazio: <br>";
	// for ($i = 0;$i < $fm_numfields;$i++){
	//    echo pg_fieldname($recordset,$i)."<br>";
	// }
	// exit;
	// }
	for ($i = 0; $i < $fm_numfields; $i ++) {
		$matriz[$i] = pg_fieldname($recordset, $i);
		//if($fm_numrows==0){
		//  $aux = trim(pg_result($recordset,$indice,$matriz[$i]));
		//  echo "Record set vazio->".$aux;
		//  continue;
		//}

		global $$matriz[$i];
		$aux = trim(pg_result($recordset, $indice, $matriz[$i]));
		if (!empty ($formatar)) {
			switch (pg_fieldtype($recordset, $i)) {
				case "float8" :
				case "float4" :
				case "float" :
					$$matriz[$i] = number_format($aux, 2, ".", "");
					if ($mostravar == true)
						echo $matriz[$i]."->".$$matriz[$i]."<br>";
					break;
				case "date" :
					if ($aux != "") {
						$data = explode("-", $aux);
						$$matriz[$i] = $data[2]."/".$data[1]."/".$data[0];
					} else {
						$$matriz[$i] = "";
					}
					if ($mostravar == true)
						echo $matriz[$i]."->".$$matriz[$i]."<br>";
					break;
				default :
					$$matriz[$i] = $aux;
					if ($mostravar == true)
						echo $matriz[$i]."->".$$matriz[$i]."<br>";
					break;
			}
		} else
			switch (pg_fieldtype($recordset, $i)) {
				case "date" :
					$datav = explode("-", $aux);
					$split_data = $matriz[$i]."_dia";
					global $$split_data;
					$$split_data = @ $datav[2];
					if ($mostravar == true)
						echo $split_data."->".$$split_data."<br";
					$split_data = $matriz[$i]."_mes";
					global $$split_data;
					$$split_data = @ $datav[1];
					if ($mostravar == true)
						echo $split_data."->".$$split_data."<br>";
					$split_data = $matriz[$i]."_ano";
					global $$split_data;
					$$split_data = @ $datav[0];
					if ($mostravar == true)
						echo $split_data."->".$$split_data."<br>";
					$$matriz[$i] = $aux;
					if ($mostravar == true)
						echo $matriz[$i]."->".$$matriz[$i]."<br>";
					break;
				default :
					$$matriz[$i] = $aux;
					if ($mostravar == true)
						echo $matriz[$i]."->".$$matriz[$i]."<br>";
					break;
			}

		//	  echo $matriz[$i] . " - " . pg_fieldtype($recordset,$i) . " - " . $aux . " - " . gettype($$matriz[$i]) . "<br>";

	}

}


?>
