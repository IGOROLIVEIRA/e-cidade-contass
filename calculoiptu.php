<?
require("libs/db_conn.php");

$DB_BASE="simula";
echo "\nbase de dados: $DB_BASE\n";
sleep(5);

if(!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "Erro ao conectar com a base ".$DB_BASE;
  exit;
}

$sql1 = "select	* 
		from iptubase
		where j01_baixa is null";
$result1 = pg_exec($sql1) or die("sql: " . pg_ErrorMessage());

for ($record1=0;$record1 < pg_numrows($result1);$record1++) {
  db_fieldsmemory($result1,$record1);
  echo "processando matricula $j01_matric...\n";

  $sql2 = "select fc_calculoiptu($j01_matric,2005,'t','t','t','t','f')";
  echo $sql2."\n";
  sleep(999999999);
  $result2 = pg_exec($sql2) or die("sql: " . pg_ErrorMessage());

  echo "\n";

}

echo "ok...";

$result = pg_exec("commit;");

function db_fieldsmemory($recordset,$indice,$formatar="",$mostravar=false){
  $fm_numfields = pg_numfields($recordset);
  for ($i = 0;$i < $fm_numfields;$i++){
    $matriz[$i] = pg_fieldname($recordset,$i);
    global $$matriz[$i];
	$aux = trim(pg_result($recordset,$indice,$matriz[$i]));
	if(!empty($formatar)) {
  	  switch(pg_fieldtype($recordset,$i)) {
	    case "float8":
	    case "float4":
	    case "float":
          $$matriz[$i] = number_format($aux,2,".","");
          if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
		  break;
		case "date":
          if($aux!=""){
		    $data = explode("-",$aux);
		    $$matriz[$i] = $data[2]."/".$data[1]."/".$data[0];
		  }else{
		    $$matriz[$i] = "";
		  }
          if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
		  break;
		default:
          $$matriz[$i] = $aux;		  		
          if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
		  break;
	  }
	} else
  	  switch(pg_fieldtype($recordset,$i)) {
		case "date":
		  $datav = explode("-",$aux);
          $split_data = $matriz[$i]."_dia";
          global $$split_data;
          $$split_data =  @$datav[2];	
          if($mostravar==true) echo $split_data."->".$$split_data."<br";
          $split_data = $matriz[$i]."_mes";
          global $$split_data;
          $$split_data =  @$datav[1];	
          if($mostravar==true) echo $split_data."->".$$split_data."<br>";
          $split_data = $matriz[$i]."_ano";
          global $$split_data;
          $$split_data =  @$datav[0];	 
          if($mostravar==true) echo $split_data."->".$$split_data."<br>";
          $$matriz[$i] = $aux;		  		
          if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
		  break;
		default:
          $$matriz[$i] = $aux;		  		
          if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
		  break;
	  }
  }
}
