<?
  $arquivo = trim(tempnam("/usr/tmp","rp")).".prn";
  $var = db_getsession("DB_nome_modulo")." sistema $DB_DIRPCB ".db_getsession("DB_anousu")." '".db_getsession("DB_datausu")."' '".$HTTP_POST_VARS["progexe"]."' ".db_getsession("DB_orgaounidade")." ".db_sqlformatar(db_getsession("DB_instit"),2,"0")." ".$arquivo;
  $com = "export DIRTMP=/usr/tmp;export DIRPCB=$DB_DIRPCB;$DB_EXEC $var";
  exec($com,$ret);
  if(($fp = fopen($arquivo,"r")) == false) {
    echo "Deu erro abrindo arquivo<br>\n";
    exit;
  }
  $conta = 0;
  $aux = "";
  while(!feof($fp)) {
    $ch = fgetc($fp);
	if($ch == "\n")
	  $conta++;
	else if($conta <= 1)
	  $aux .= $ch;
	if($conta > 1)
	  break;
  }
  fclose($fp);
  if($conta > 1) {
?>
<script>
  window.open('db_mostrarelatorio.php?arquivo=<?=$arquivo?>','_blank','location=0');
//  history.back();
//  location.href = self;
  //location.href='mostrarelatorio.php?arquivo=<?=$arquivo?>';
</script>
<?
  } else {
    echo "<script>alert('$aux')</script>\n";
  }
?>
