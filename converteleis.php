<?
  $acentosfonte = array("º","Õ","õ",'"',"'","ã","�".chr(-125),"á","�".chr(-127),"é","�".chr(-119),"í","�".chr(-115),"ó","�".chr(-109),"ú","�".chr(-102),"ç","�".chr(-121),"â","�".chr(-126),"ê","�".chr(-118),"î","�".chr(-114),"ô","�".chr(-108),"û","�".chr(-101),"�".chr(-96),"�".chr(-128),"ü","�".chr(-100));
  $acentostradu = array("�","�","�",'\"',"\'","�", "�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�");


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
