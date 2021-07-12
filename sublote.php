<?
require("libs/db_conn.php");
$DB_BASE="sap_atual_1611";
echo "\nbase de dados: $DB_BASE\n";
sleep(2);

system("> /tmp/log_sublote.txt");

if(!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "Erro ao conectar com a base ".$DB_BASE;
  exit;
}

$sql1 = "select	j01_matric, j40_refant, j34_setor, j34_quadra, j34_lote, j34_idbql
		from iptubase
		inner join iptuant on j40_matric = j01_matric
		inner join lote on j34_idbql = j01_idbql
		limit 1000";
$result1 = pg_exec($sql1) or die("sql: " . pg_ErrorMessage());

$result = pg_exec("begin;");

for ($record1=0;$record1 < pg_numrows($result1);$record1++) {
  db_fieldsmemory($result1,$record1);
  echo "processando matricula $j01_matric... refant: $j40_refant\n";
  
  $matriz= explode("\.",$j40_refant);
  $lote    = $matriz[3];
  $sublote = $matriz[4];

  if ($sublote != 0 and $lote != $j34_lote) {
    $sql3 = "select * from lote where j34_setor = '$j34_setor' and j34_quadra = '$j34_quadra' and j34_lote = '$j34_lote'";
    $result3 = pg_exec($sql3) or die("sql: " . pg_ErrorMessage());
    if (pg_numrows($result3) == 0) {
      echo "          j34_lote: $j34_lote - lote: $lote - sublote: $sublote\n";
      $sql2 = "update lote set j34_lote = '$lote' where j34_idbql = $j34_idbql";
      $result2 = pg_exec($sql2) or die("sql: " . pg_ErrorMessage());
    } else {
      system("echo \"sql: $j34_setor/$j34_quadra/$j34_lote ja existe... refant: $j40_refant \" >> /tmp/log_sublote.txt");
    }
  }
  
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
