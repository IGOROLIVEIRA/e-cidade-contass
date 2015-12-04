<?
  $acentosfonte = array("Âº","Ã•","Ãµ",'"',"'","Ã£","Ã".chr(-125),"Ã¡","Ã".chr(-127),"Ã©","Ã".chr(-119),"Ã­","Ã".chr(-115),"Ã³","Ã".chr(-109),"Ãº","Ã".chr(-102),"Ã§","Ã".chr(-121),"Ã¢","Ã".chr(-126),"Ãª","Ã".chr(-118),"Ã®","Ã".chr(-114),"Ã´","Ã".chr(-108),"Ã»","Ã".chr(-101),"Ã".chr(-96),"Ã".chr(-128),"Ã¼","Ã".chr(-100));
  $acentostradu = array("º","Õ","õ",'\"',"\'","ã", "Ã","á","Á","é","É","í","Í","ó","Ó","ú","Ú","ç","Ç","â","Â","ê","Ê","î","Î","ô","Ô","û","Û","à","À","ü","Ü");


  $conn = pg_connect("dbname=sam30 user=postgres host=192.168.1.1");
  $result = pg_exec("select id_lei,texto,documento from db_leis");
  $numrows = pg_numrows($result);
  pg_exec("begin");
  for($i = 0;$i < $numrows;$i++) {
    echo "LEI ".pg_result($result,$i,"id_lei")."\n";
	$tam = sizeof($acentosfonte);
	$texto = pg_result($result,$i,"texto");
	$documento = pg_result($result,$i,"documento");
	for($j = 0;$j < $tam;$j++) {
      $texto = str_replace($acentosfonte[$j],$acentostradu[$j],$texto);
      $documento = str_replace($acentosfonte[$j],$acentostradu[$j],$documento);	
	}
	pg_exec("update db_leis set texto = '$texto', documento = '$documento' where id_lei = ".pg_result($result,$i,"id_lei")) or die("ERRO");	
  }
  pg_exec("commit");
?>
