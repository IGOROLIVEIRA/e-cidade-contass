<?
//die("emiss $emisscarne ");
set_time_limit(0);
if((isset($HTTP_POST_VARS["numpre_unica"]) && $HTTP_POST_VARS["numpre_unica"] != "" ) || ( isset($HTTP_POST_VARS["geracarne"]) && !isset($HTTP_POST_VARS["calculavalor"]))) {
  include("cai3_gerfinanc033.php");
  exit;
} 

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

//se for submit, ele cria o recibo
if(isset($HTTP_POST_VARS["ver_matric"]) && !isset($HTTP_POST_VARS["calculavalor"])) {
  global $HTTP_SESSION_VARS;
  if(isset($db_datausu)){
    if(!checkdate(substr($db_datausu,5,2),substr($db_datausu,8,2),substr($db_datausu,0,4))){
       echo "Data para cálculo inválida. <br><br>";
       echo "Data deverá se superior a : ".date('Y-m-d',$HTTP_SESSION_VARS["DB_datausu"]);
  //	 exit;
    }
    if(mktime(0,0,0,substr($db_datausu,5,2),substr($db_datausu,8,2),substr($db_datausu,0,4)) < 
       mktime(0,0,0,date('m',$HTTP_SESSION_VARS["DB_datausu"]),date('d',$HTTP_SESSION_VARS["DB_datausu"]),date('Y',$HTTP_SESSION_VARS["DB_datausu"])) ){
       echo "Data não permitida para cálculo. <br><br>";
       echo "Data deverá se superior a : ".date('Y-m-d',$HTTP_SESSION_VARS["DB_datausu"]);
  //	 exit;
    }
    $DB_DATACALC = mktime(0,0,0,substr($db_datausu,5,2),substr($db_datausu,8,2),substr($db_datausu,0,4));
  }else{
    $DB_DATACALC = $HTTP_SESSION_VARS["DB_datausu"];
  }
  include("fpdf151/scpdf.php");
  include("cai3_gerfinanc003.php");
  exit;
  
} else {
  require("libs/db_stdlib.php");
  require("libs/db_conecta.php");
  require("libs/db_sessoes.php");
  require("libs/db_sql.php");
  if(isset($HTTP_POST_VARS["calculavalor"])) {

    $vt = $HTTP_POST_VARS;
    $tam = sizeof($vt);
    reset($vt);
    $j = 0;
    for($i = 0;$i < $tam;$i++) {
      if(db_indexOf(key($vt) ,"VAL") > 0)
	$valores[$j++] = $vt[key($vt)];
	  next($vt);
    } 
    $j = 0;
    reset($vt);
    for($i = 0;$i < $tam;$i++) {
      if(db_indexOf(key($vt),"CHECK") > 0)
	    $numpres[$j++] = $vt[key($vt)];
	  next($vt);
    }
    if(isset($valores)){

      if(sizeof($valores) != sizeof($numpres)) {
	db_erro("Matriz inválida!",1);
      }
      //  echo sizeof($valores)." ".sizeof($numpres)."<br>";
      $tam = sizeof($valores);
      pg_exec("BEGIN");
      for($i = 0;$i < $tam;$i++) {
	$mat = explode("P",$numpres[$i]);
	$numpre = $mat[0];	  
	$numpar = $mat[1];
	$valores[$i] = $valores[$i] + 0;
	$sql = "update issvar set q05_vlrinf = ".$valores[$i]." where q05_numpre = $numpre and q05_numpar = $numpar";
	pg_exec($sql) or die("Erro(37) atualizando issvar: ".pg_errormessage());
      }
      pg_exec("COMMIT");
    }
    
    $tipo = 3;

  }

if(isset($db_datausu)){
  if(!checkdate(substr($db_datausu,5,2),substr($db_datausu,8,2),substr($db_datausu,0,4))){
     echo "Data para Cálculo Inválida. <br><br>";
     echo "Data deverá se superior a : ".date('Y-m-d',db_getsession("DB_datausu"));
//	 exit;
  }
  if(mktime(0,0,0,substr($db_datausu,5,2),substr($db_datausu,8,2),substr($db_datausu,0,4)) < 
     mktime(0,0,0,date('m',db_getsession("DB_datausu")),date('d',db_getsession("DB_datausu")),date('Y',db_getsession("DB_datausu"))) ){
     echo "Data não permitida para cálculo. <br><br>";
     echo "Data deverá se superior a : ".date('Y-m-d',db_getsession("DB_datausu"));
//	 exit;
  }
  $DB_DATACALC = mktime(0,0,0,substr($db_datausu,5,2),substr($db_datausu,8,2),substr($db_datausu,0,4));
}else{
  $DB_DATACALC = db_getsession("DB_datausu");
}

?>
<html>
<head>
<title>Documento sem t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="scripts/scripts.js"></script>
<script>
function js_emiteunica(numpre){
  document.form1.numpre_unica.value = numpre; 
//  document.form1.target="";
  jan = window.open('','reciboweb2','width=790,height=530,scrollbars=1,location=0');
  jan.moveTo(0,0);
  document.form1.submit();
  document.form1.numpre_unica.value = ""; 
}

function js_soma1(obj,linha) {
  linha = ((typeof(linha)=="undefined") || (typeof(linha)=="object")?2:linha);
  var F = obj;
  var emrec = '<?=$emrec?>';
  var tab = document.getElementById('tabdebitos');
  if(emrec == 't'){
    parent.document.getElementById("enviar").disabled = false;//botao emite recibo
    if (document.form1.k03_permparc.value == 't') {
      parent.document.getElementById("btparc").disabled = false;//botao parcelamento
    }
    parent.document.getElementById("btcda").disabled = false;//botao certidao
    parent.document.getElementById("btcancela").disabled = false;//botao certidao
    parent.document.getElementById("btcarne").disabled = false;//botao emite carne	
    parent.document.getElementById("btjust").disabled = false;//botao justifica
    parent.document.getElementById("btnotifica").disabled = false;	  
    parent.document.getElementById("btcarnep").disabled = false;//botao emite carne	
  }
  var indi = js_parse_int(obj.id);	  

  var valor     = parent.document.getElementById('valor'+linha).innerHTML;
  var valorcorr = parent.document.getElementById('valorcorr'+linha).innerHTML;
  var juros     = parent.document.getElementById('juros'+linha).innerHTML;
  var multa     = parent.document.getElementById('multa'+linha).innerHTML;
  var deconto   = parent.document.getElementById('desconto'+linha).innerHTML;
  var total     = parent.document.getElementById('total'+linha).innerHTML;

  if(obj.checked == true){
    valor += new Number(document.getElementById('valor'+indi).value.replace(",",""));
    valorcorr += new Number(document.getElementById('valorcorr'+indi).value.replace(",",""));
    juros += new Number(document.getElementById('juros'+indi).value.replace(",",""));
    multa += new Number(document.getElementById('multa'+indi).value.replace(",",""));
    desconto += new Number(document.getElementById('desconto'+indi).value.replace(",",""));
    total += new Number(document.getElementById('total'+indi).value.replace(",",""));
  }else{
    valor -= new Number(document.getElementById('valor'+indi).value.replace(",",""));
    valorcorr -= new Number(document.getElementById('valorcorr'+indi).value.replace(",",""));
    juros -= new Number(document.getElementById('juros'+indi).value.replace(",",""));
    multa -= new Number(document.getElementById('multa'+indi).value.replace(",",""));
    desconto -= new Number(document.getElementById('desconto'+indi).value.replace(",",""));
    total -= new Number(document.getElementById('total'+indi).value.replace(",",""));
  }

  parent.document.getElementById('valor'+linha).innerHTML = valor.toFixed(2);
  parent.document.getElementById('valorcorr'+linha).innerHTML = valorcorr.toFixed(2);
  parent.document.getElementById('juros'+linha).innerHTML = juros.toFixed(2);
  parent.document.getElementById('multa'+linha).innerHTML = multa.toFixed(2);
  parent.document.getElementById('desconto'+linha).innerHTML = desconto.toFixed(2);
  parent.document.getElementById('total'+linha).innerHTML = total.toFixed(2);
  if(linha == 2) {
    valor = Number(parent.document.getElementById('valor1').innerHTML) - valor;
    valorcorr = Number(parent.document.getElementById('valorcorr1').innerHTML) - valorcorr;
    juros = Number(parent.document.getElementById('juros1').innerHTML) - juros;
    multa = Number(parent.document.getElementById('multa1').innerHTML) - multa;
    desconto = Number(parent.document.getElementById('desconto1').innerHTML) - desconto;
    total = Number(parent.document.getElementById('total1').innerHTML) - total;

	parent.document.getElementById('valor3').innerHTML = valor.toFixed(2);
    parent.document.getElementById('valorcorr3').innerHTML = valorcorr.toFixed(2);
    parent.document.getElementById('juros3').innerHTML = juros.toFixed(2);
    parent.document.getElementById('multa3').innerHTML = multa.toFixed(2);
    parent.document.getElementById('desconto3').innerHTML = desconto.toFixed(2);
    parent.document.getElementById('total3').innerHTML = total.toFixed(2);
  }

}


function js_soma(linha) {
  linha = ((typeof(linha)=="undefined") || (typeof(linha)=="object")?2:linha);
  var F = document.form1;
  var valor = 0;
  var valorcorr = 0;
  var juros = 0;
  var multa = 0;
  var desconto = 0;
  var total = 0;
  var emrec = '<?=$emrec?>';
  var k03_tipo = '<?=$k03_tipo?>';

  var permissao_parcelamento = <?=db_permissaomenu(db_getsession("DB_anousu"),81,3415)?>;
  var permissao_certidao     = <?=db_permissaomenu(db_getsession("DB_anousu"),81,4125)?>;
  var permissao_cancelar     = <?=db_permissaomenu(db_getsession("DB_anousu"),81,4554)?>;
  var permissao_justif       = <?=db_permissaomenu(db_getsession("DB_anousu"),81,5024)?>;


  var tab = document.getElementById('tabdebitos');


//  alert(parent.document.getElementById('tipo').value);

  if(emrec == 't'){
    parent.document.getElementById("enviar").disabled = false;//botao emite recibo
    parent.document.getElementById("btcarne").disabled = false;//botao carne	
    parent.document.getElementById("btnotifica").disabled = false;	  

    parent.document.getElementById("btparc").disabled = true; // botao parcelamento
    parent.document.getElementById("btcda").disabled = true; // botao certidao
    parent.document.getElementById("btcancela").disabled = true; // botao cancela debitos
    parent.document.getElementById("btjust").disabled = true; // botao justifica

    if (document.form1.k03_permparc.value == 't' && permissao_parcelamento == true && linha > 1) {
      parent.document.getElementById("btparc").disabled = false; // botao parcelamento
    }

    if (permissao_certidao == true && (k03_tipo == 5 || k03_tipo == 6) && linha > 1) {
      parent.document.getElementById("btcda").disabled = false; // botao certidao
    }

    if (permissao_cancelar == true && linha > 1) {
      parent.document.getElementById("btcancela").disabled = false; // botao cancela debitos
    }

    if (permissao_justif == true && linha > 1) {
      parent.document.getElementById("btjust").disabled = false; // botao justifique debitos
    }
    
    parent.document.getElementById("btcarnep").disabled = false; //botao emite carne

  }

  for(var i = 0;i < F.length;i++) {
    if((F.elements[i].type == "checkbox" || F.elements[i].type == "submit") && (F.elements[i].checked == true || linha == 1)) {
      var indi = js_parse_int(F.elements[i].id);	  
	  valor += new Number(document.getElementById('valor'+indi).value.replace(",",""));
      valorcorr += new Number(document.getElementById('valorcorr'+indi).value.replace(",",""));
      juros += new Number(document.getElementById('juros'+indi).value.replace(",",""));
      multa += new Number(document.getElementById('multa'+indi).value.replace(",",""));
      desconto += new Number(document.getElementById('desconto'+indi).value.replace(",",""));
      total += new Number(document.getElementById('total'+indi).value.replace(",",""));
    }
  }
  parent.document.getElementById('valor'+linha).innerHTML = valor.toFixed(2);
  parent.document.getElementById('valorcorr'+linha).innerHTML = valorcorr.toFixed(2);
  parent.document.getElementById('juros'+linha).innerHTML = juros.toFixed(2);
  parent.document.getElementById('multa'+linha).innerHTML = multa.toFixed(2);
  parent.document.getElementById('desconto'+linha).innerHTML = desconto.toFixed(2);
  parent.document.getElementById('total'+linha).innerHTML = total.toFixed(2);
  if(linha == 2) {
    valor = Number(parent.document.getElementById('valor1').innerHTML) - valor;
    valorcorr = Number(parent.document.getElementById('valorcorr1').innerHTML) - valorcorr;
    juros = Number(parent.document.getElementById('juros1').innerHTML) - juros;
    multa = Number(parent.document.getElementById('multa1').innerHTML) - multa;
    desconto = Number(parent.document.getElementById('desconto1').innerHTML) - desconto;
    total = Number(parent.document.getElementById('total1').innerHTML) - total;
    parent.document.getElementById('valor3').innerHTML = valor.toFixed(2);
    parent.document.getElementById('valorcorr3').innerHTML = valorcorr.toFixed(2);
    parent.document.getElementById('juros3').innerHTML = juros.toFixed(2);
    parent.document.getElementById('multa3').innerHTML = multa.toFixed(2);
    parent.document.getElementById('desconto3').innerHTML = desconto.toFixed(2);
    parent.document.getElementById('total3').innerHTML = total.toFixed(2);
  }

  if(emrec == 't') {
    var aux = 0;
    for(i = 0;i < F.length;i++) {
      if(F.elements[i].type == "checkbox")
	    if(F.elements[i].checked == true)
	      aux = 1;
    }  
    if(aux == 0) {
      parent.document.getElementById("enviar").disabled = true

//      if (document.form1.k03_permparc.value == 't') {
         parent.document.getElementById("btparc").disabled = true
//      }

      parent.document.getElementById("btcda").disabled = true
      parent.document.getElementById("btcancela").disabled = true
      parent.document.getElementById("btjust").disabled = true
      
      parent.document.getElementById("btcarne").disabled = true	  
      parent.document.getElementById("btcarnep").disabled = true	  
      parent.document.getElementById("btnotifica").disabled = true	  
      document.getElementById('marca').innerHTML = "M";
      parent.document.getElementById('btmarca').value = "Marcar Todas";
    }
  }
}
function js_marca() {
  
  var ID = document.getElementById('marca');
  var BT = parent.document.getElementById('btmarca');
  if(!ID)
    return false;
  var F = document.form1;
  if(ID.innerHTML == 'M') {
    var dis = true;
	ID.innerHTML = 'D';
	BT.value = "Desmarcar";
  } else {
    var dis = false;
	ID.innerHTML = 'M';
	BT.value = "Marcar";
  }
  for(i = 0;i < F.elements.length;i++) {
    if(F.elements[i].type == "checkbox"){
      if(F.elements[i].style.visibility!="hidden")
        F.elements[i].checked = dis;
    }
  }
  js_soma(this,2);
}
</script>
<style type="text/css">
<!--
.borda {
	border-right-width: 1px;
	border-right-style: solid;
	border-right-color: #000000;
}
-->
</style>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->

function js_desconto(chave){
  location.href="cai3_gerfinanc012.php?k00_numpre="+chave;
}

</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="parent.document.getElementById('processando').style.visibility = 'hidden'">
<center>
<?
//verifica se clicou no link da matricula
if(isset($inscricao) && !empty($inscricao)) {
  $inscr = $inscricao;
  $tipo = $tipo2;
}
if(isset($matricula) && !empty($matricula)) {
  $matric = $matricula;
  $tipo = $tipo2;
}

//verifica o tipo e da o select dependendo se é numcgm, matric numpre ou inscr
if(isset($tipo)) {
  if($tipo == 3) {
    if(isset($numcgm))
      if(($result = debitos_numcgm_var($numcgm,0,$tipo,$DB_DATACALC,db_getsession("DB_anousu"))))
	    echo "<script> numcgm = '$numcgm'; </script>\n";
	  else
	    db_redireciona("cai3_gerfinanc007.php?erro1=1");
    else if(isset($inscr))	  
      if(($result = debitos_inscricao_var($inscr,0,$tipo,$DB_DATACALC,db_getsession("DB_anousu"))))
	    echo "<script> inscr = '$inscr'; </script>\n";
	  else
	    db_redireciona("cai3_gerfinanc007.php?erro1=1");
	else if(isset($numpre))
	  if(($result = debitos_numpre_var($numpre,0,$tipo,$DB_DATACALC,db_getsession("DB_anousu"))))
	    echo "<script> numpre = '$numpre'; </script>\n";
	  else
	    db_redireciona("cai3_gerfinanc007.php?erro1=1");
} else {
    if(isset($numcgm) && !empty($numcgm)) {
      if(($result = debitos_numcgm($numcgm,0,$tipo,$DB_DATACALC,db_getsession("DB_anousu"))))
	    echo "<script> numcgm = '$numcgm'; </script>\n";
	  else
	    db_redireciona("cai3_gerfinanc007.php?erro1=1");
    } else if(isset($matric) && !empty($matric)) {
      if(($result = debitos_matricula($matric,0,$tipo,$DB_DATACALC,db_getsession("DB_anousu"))))
	    echo "<script> matric = '$matric'; </script>\n";
	  else
	    db_redireciona("cai3_gerfinanc007.php?erro1=1");
    } else if(isset($inscr) && !empty($inscr)) {
      if(($result = debitos_inscricao($inscr,0,$tipo,$DB_DATACALC,db_getsession("DB_anousu"))))
	    echo "<script> inscr = '$inscr'; </script>\n";	  
	  else
	    db_redireciona("cai3_gerfinanc007.php?erro1=1");
    } else if(isset($numpre) && !empty($numpre)) {
      if(($result = debitos_numpre($numpre,0,$tipo,$DB_DATACALC,db_getsession("DB_anousu"))))
	    echo "<script> numpre = '$numpre'; </script>\n";	  
	  else
	    db_redireciona("cai3_gerfinanc007.php?erro1=1");
	}
}
//echo "x: " . pg_numrows($result) . "\n";
//db_criatabela($result);
  $numrows = pg_numrows($result);
  echo "<form name=\"form1\" id=\"form1\" method=\"post\" target=\"reciboweb2\">\n";
  echo "<input type=\"hidden\" name=\"H_ANOUSU\" value=\"".db_getsession("DB_anousu")."\">\n";  
  echo "<input type=\"hidden\" name=\"H_DATAUSU\" value=\"".$DB_DATACALC."\">\n";    
  if ( $numrows > 0 ) {
     echo "<input type=\"hidden\" name=\"ver_matric\" value=\"".@pg_result($result,0,"k00_matric")."\">\n";
     echo "<input type=\"hidden\" name=\"ver_inscr\" value=\"".@pg_result($result,0,"k00_inscr")."\">\n";
     echo "<input type=\"hidden\" name=\"ver_numcgm\" value=\"".@pg_result($result,0,"k00_numcgm")."\">\n";
     echo "<input type=\"hidden\" name=\"certidao\" value=\"".@$certidao."\">\n";
  }

  
  $result_k03_tipo = pg_exec("select cadtipo.k03_tipo,k03_parcelamento,k03_permparc from arretipo inner join cadtipo on arretipo.k03_tipo = cadtipo.k03_tipo where k00_tipo = $tipo");
  db_fieldsmemory($result_k03_tipo,0);
  echo "<input type=\"hidden\" name=\"tipo_debito\" value=\"".$tipo."\">\n";  
  echo "<input type=\"hidden\" name=\"k03_tipo\" value=\"".$k03_tipo."\">\n";  
  echo "<input type=\"hidden\" name=\"k03_parcelamento\" value=\"".$k03_parcelamento."\">\n";
  echo "<input type=\"hidden\" name=\"k03_permparc\" value=\"".$k03_permparc."\">\n";
  echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" id=\"tabdebitos\">\n";
//cria o cabeçalho 
  echo "<tr bgcolor=\"#FFCC66\">\n";
  echo "<th title=\"Outras Informações\" class=\"borda\" style=\"font-size:12px\" nowrap>O</th>\n";
  echo "<th title=\"Notificações\" class=\"borda\" style=\"font-size:12px\" nowrap>N</th>\n";
  echo "<th title=\"Código de Arrecadação\" class=\"borda\" style=\"font-size:12px\" nowrap>Numpre</th>\n";
  echo "<th title=\"Parcela\" class=\"borda\" style=\"font-size:12px\" nowrap>P</th>\n";
  echo "<th title=\"Total de Parcela\" class=\"borda\" style=\"font-size:12px\" nowrap>T</th>\n";
  
  //Se for divida ativa mostra o exercicio da divida
  if($k03_tipo==5){
  	echo "<th title=\"Exercício\" class=\"borda\" style=\"font-size:12px\" nowrap>Exercício</th>\n";
  }else if($k03_tipo==6 or $k03_tipo==13){//Se for parcelamento mostra o Nº do parcelamento 
  	echo "<th title=\"Parcelamento\" class=\"borda\" style=\"font-size:12px\" nowrap>Parcelamento</th>\n";
  }
  
  echo "<th title=\"Data de Lançamento\" class=\"borda\" style=\"font-size:12px\" nowrap>Dt. oper.</th>\n";
  echo "<th title=\"Data de Vencimento\" class=\"borda\" style=\"font-size:12px\" nowrap>Dt. Venc.</th>\n";
  echo "<th title=\"Histórico do Lançamento\" class=\"borda\" style=\"font-size:12px\" nowrap>Histórico</th>\n";
  
  //Verifica se agrupado por numpre, cria link pra passar pro nivel 2, mostrando todos os numpres
  if(!empty($inscr))
    $arg = "inscr=".$inscr;
  else if(!empty($numcgm))
    $arg = "numcgm=".$numcgm;
  else if(!empty($matric))
    $arg = "matric=".$matric;
  else if(!empty($numpre))
    $arg = "numpre=".$numpre;
  if(@$agnum == 't') {
    echo "<th title=\"Lista por parcela\" class=\"borda\" style=\"font-size:12px\" nowrap><a href=\"cai3_gerfinanc002.php?".$arg."&tipo=$tipo&verificaagrupar=1&agnump=f&agpar=t&emrec=".$emrec."&db_datausu=".date("Y-m-d",$DB_DATACALC)."&inscr=".@$inscr."&matric=".@$matric."&k03_tipo=".@$k03_tipo."&numpre=".@$numpre."&numcgm=".@$numcgm."\">Rec</a></th>\n";
  } else {
    echo "<th title=\"Receita\" class=\"borda\" style=\"font-size:12px\" nowrap>Rec</th>\n";
  }
  echo "<th title=\"Descrição Receita\" class=\"borda\" style=\"font-size:12px\" nowrap>Receita</th>\n";
  echo "<th title=\"Valor Lançado\" class=\"borda\" style=\"font-size:12px\" nowrap>Val.</th>\n";
  echo "<th title=\"Valor Corrigido\" class=\"borda\" style=\"font-size:12px\" nowrap>Val Cor.</th>\n";
  echo "<th title=\"Valor Juros\" class=\"borda\" style=\"font-size:12px\" nowrap>Jur.</th>\n";
  echo "<th title=\"Valor Multa\" class=\"borda\" style=\"font-size:12px\" nowrap>Mul.</th>\n";
  echo "<th title=\"Valor Desconto\" class=\"borda\" style=\"font-size:12px\" nowrap>Desc.</th>\n";                  
  echo "<th title=\"Total a Pagar\" class=\"borda\" style=\"font-size:12px\" nowrap>Tot.</th>\n";  
  echo "<th title=\"Marca/Desmarca Todas\" class=\"borda\" style=\"font-size:12px\" nowrap><a id=\"marca\" href=\"\" style=\"color:black\" onclick=\"js_marca();return false\">M</a>
		<input type=\"hidden\" name=\"numpre_unica\">
  </th>\n";
  echo "</tr>\n";
  //verifica se foi clicado no link agrupar e recria as variaveis do QUERY_STRING pra atualizar o agnump e agpar
  if(isset($verificaagrupar)) {
    parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
  }


  // calcular totregistros...
  $j = 0;
  $elementos2[0] = "";
  for($i = 0;$i < $numrows;$i++) {
    if(!in_array(pg_result($result,$i,"k00_numpre"),$elementos2)) {
      $elementos2[$j++] = pg_result($result,$i,"k00_numpre");
    }
  }
  
  $totregistros = 0;

  for($i = 0;$i < sizeof($elementos2);$i++) {
    
    for($j = 0;$j < $numrows;$j++) {
      if($elementos2[$i] == pg_result($result,$j,"k00_numpre")) {
	if(pg_result($result,$j,"k00_numpar") != @pg_result($result,$j+1,"k00_numpar") || ($elementos2[$i] != @pg_result($result,$j+1,"k00_numpre")) ) {
	  $totregistros++;
	}
      }
    }
    
  }

  echo "<input type=\"hidden\" name=\"totregistros\" value=\"".@$totregistros."\">\n";

  
  //if com 3 partes. Primeiro se é pra agrupar por numpre, segundo se é pra agrupar por parcela e terceiro mostra o default
  //agrupar por numpre
  if(@$agnum == 't') {

  /******************************************************************************************/
    //cria um array com os elementos não repetidos
	$j = 0;
	$vlrtotal = 0;
	$elementos[0] = "";
    for($i = 0;$i < $numrows;$i++) {
      if(!in_array(pg_result($result,$i,"k00_numpre"),$elementos)) {
        $REGISTRO[$j] = pg_fetch_array($result,$i);
	    $elementos[$j++] = pg_result($result,$i,"k00_numpre");
	  }
	}
	//faz a mao...
      for($i = 0;$i < sizeof($elementos);$i++) {
      $valor = 0;
      $valorcorr = 0;
      $juros = 0;
      $multa = 0;
      $desconto = 0;
      $total = 0;
      $separador = "";
      $numpres = "";
      
      for($j = 0;$j < $numrows;$j++) {
	if($elementos[$i] == pg_result($result,$j,"k00_numpre")) {
	  if(pg_result($result,$j,"k00_numpar") != @pg_result($result,$j+1,"k00_numpar") || ($elementos[$i] != @pg_result($result,$j+1,"k00_numpre")) ) {
	    $numpres .= $separador.pg_result($result,$j,"k00_numpre")."P".pg_result($result,$j,"k00_numpar");
	    $separador = "N";
	  }
	  $valor += (float)pg_result($result,$j,"vlrhis");
	  $valorcorr += (float)pg_result($result,$j,"vlrcor");
	  $juros += (float)pg_result($result,$j,"vlrjuros");
	  $multa += (float)pg_result($result,$j,"vlrmulta");
	  $desconto += (float)pg_result($result,$j,"vlrdesconto");
	  $total += (float)pg_result($result,$j,"total"); 
	}
      }	  
      
      /**************************/
          $vlrtotal += $REGISTRO[$i]["total"];
          $dtoper = $REGISTRO[$i]["k00_dtoper"];
	  //$dtoper = pg_result($result,$i,"k00_dtoper");
	  $dtoper = mktime(0,0,0,substr($dtoper,5,2),substr($dtoper,8,2),substr($dtoper,0,4));
	  //if($dtoper > time())
	  //  $corDtoper = "#FF5151";
	  //else
	  $corDtoper = "";
	  $dtvenc = $REGISTRO[$i]["k00_dtvenc"];
	  $dtvenc = mktime(23,59,0,substr($dtvenc,5,2),substr($dtvenc,8,2),substr($dtvenc,0,4));
	  if($dtvenc < $DB_DATACALC ) //time())
	    $corDtvenc = "red";
	  else{
	    if(date("d/m/Y",$dtvenc) == date("d/m/Y",$DB_DATACALC) ) //time())
	      $corDtvenc = "blue";
            else
	      $corDtvenc = "";	  
          }
	 //*****CABEÇALHO  ;border:none

      // unica
//	  if($elementos_parcelas[$i]==1){
            $sql_resultunica = "select *,
                 substr(fc_calcula,2,13)::float8 as uvlrhis,
                 substr(fc_calcula,15,13)::float8 as uvlrcor,
                 substr(fc_calcula,28,13)::float8 as uvlrjuros,
                 substr(fc_calcula,41,13)::float8 as uvlrmulta,
                 substr(fc_calcula,54,13)::float8 as uvlrdesconto,
                 (substr(fc_calcula,15,13)::float8+
                 substr(fc_calcula,28,13)::float8+
                 substr(fc_calcula,41,13)::float8-
                 substr(fc_calcula,54,13)::float8) as utotal
				 from (
				 select r.k00_numpre,r.k00_dtvenc as dtvencunic, r.k00_dtoper as dtoperunic,r.k00_percdes,
				        fc_calcula(r.k00_numpre,0,0,r.k00_dtvenc,r.k00_dtvenc,".db_getsession("DB_anousu").")
                 from recibounica r
				 where r.k00_numpre = ".$elementos[$i]." and r.k00_dtvenc >= ".$DB_DATACALC."
				 ) as unica";
	    $resultunica = pg_query($sql_resultunica);
		for($unicont=0;$unicont<pg_numrows($resultunica);$unicont++){
          db_fieldsmemory($resultunica,$unicont);
		  if($dtvencunic>=date('Y-m-d',$DB_DATACALC)){
  		    $dtvencunic = db_formatar($dtvencunic,'d');
		    $dtoperunic = db_formatar($dtoperunic,'d');
		    $corunica = "#009933";
            $uvlrcorr = 0;
			
			$histdesc = "";
		    $resulthist = pg_exec("select k00_dtoper as dtlhist,k00_hora, login,substr(k00_histtxt,0,80) as k00_histtxt
		                       from arrehist 
							        left outer join db_usuarios on id_usuario = k00_id_usuario
							   where k00_numpre = ".$elementos[$i]." and k00_numpar = 0");
            if(pg_numrows($resulthist)>0){
		      for($di=0;$di<pg_numrows($resulthist);$di++){
		        db_fieldsmemory($resulthist,$di);
		        $histdesc .= $dtlhist." ".$k00_hora." ".$login." ".$k00_histtxt."\n";
              } 		
		    }

	
	 echo "<tr bgcolor=\"$corunica\">\n";	
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap></td>\n";	  
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap></td>\n";	  
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap title=\"".$histdesc."\">".$k00_numpre."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>00</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>00</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".$dtoperunic."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".$dtvencunic."</td>\n";	
	 echo "<td colspan=\"3\" class=\"borda\" style=\"font-size:11px;color:white\" nowrap>Parcela Única com $k00_percdes% desconto</td>\n";
//          echo "<td class=\"borda\" style=\"font-size:11px\" nowrap></td>\n";
//         echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>Parcela Única</td>\n";
   
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrhis,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrcorr,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrjuros,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrmulta,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrdesconto,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($utotal,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"center\" nowrap>
		     <input type=\"button\" style=\"border:none;background-color:write\" name=\"unica\" onclick=\"js_emiteunica(".$k00_numpre.")\" value=\"U\">";
		 echo "  </td>\n
	 </tr>";



	

			

			
		  }
	    }	
 //     }
      //

      $noti_sql = "select k53_numpre
                   from notidebitos
		   where k53_numpre = ".$REGISTRO[$i]["k00_numpre"]."
		   limit 1";
      $noti_result = pg_exec($noti_sql);
      $temnoti = false;
      if(pg_numrows($noti_result)){
	 $temnoti = true;

      }

      echo "<label for=\"CHECK$i\"><tr style=\"cursor: hand\" bgcolor=\"".(@$cor = (@$cor=="#E4F471"?"#EFE029":"#E4F471"))."\">\n";	
      echo "<td title=\"Informações Adicionais\" class=\"borda\" style=\"font-size:11px\" nowrap onclick=\"parent.js_mostradetalhes('cai3_gerfinanc005.php?".base64_encode($tipo."#".$REGISTRO[$i]["k00_numpre"]."#"."0")."','','width=600,height=500,scrollbars=1')\"><a href=\"\" onclick=\"return false;\">
	  MI</a></td>\n";
      if($temnoti){	  
        echo "<td title=\"Notificações Informadas\" class=\"borda\" style=\"font-size:11px\" nowrap onclick=\"parent.js_mostradetalhes('cai3_gerfinanc061.php?chave1=numpre&chave=".$REGISTRO[$i]["k00_numpre"]."','','width=700,height=500,scrollbars=1')\"><a href=\"\" onclick=\"return false;\">
	  N</a></td>\n";
      }else{
        echo "<td title=\"Sem Notificações Informadas\" class=\"borda\" style=\"font-size:11px\" nowrap >&nbsp</td>\n";
	 
      }

      echo "<td class=\"borda\" style=\"font-size:11px\" nowrap><input style=\"border:none;background-color:$cor\" onclick=\"location.href='cai3_gerfinanc008.php?".base64_encode("numpre=".$REGISTRO[$i]["k00_numpre"])."'\" type=\"button\" value=\"".$REGISTRO[$i]["k00_numpre"]."\"></td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" nowrap><input type=\"hidden\" id=\"parc$i\" value=\"0#".$REGISTRO[$i]["k00_numtot"]."#".$REGISTRO[$i]["k00_numpre"]."\">0 </td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".$REGISTRO[$i]["k00_numtot"]."</td>\n";

      //Se for divida ativa mostra o exercicio Select para buscar o exercicio
      if($k03_tipo==5){
      	$result_exerc = pg_exec("select distinct v01_exerc from divida where v01_numpre =".$REGISTRO[$i]["k00_numpre"]);
      	if (pg_numrows($result_exerc)==1){
      	db_fieldsmemory($result_exerc,0);
      	}
      	echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"\" value=\"\">".@$v01_exerc."&nbsp;</td>\n";      
      }else if($k03_tipo==6 or $k03_tipo==13){//Se for parcelamento mostra o Nº do parcelamento select para buscar o Nº do parcelamento
      	$result_parcel = pg_exec("select distinct v07_parcel from termo where v07_numpre =".$REGISTRO[$i]["k00_numpre"]);
      	if (pg_numrows($result_parcel)==1){
      	db_fieldsmemory($result_parcel,0);
      	}
      	echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"\" value=\"\">".@$v07_parcel."&nbsp;</td>\n";      
      }
      echo "<td class=\"borda\" style=\"font-size:11px\" ".($corDtoper==""?"":"bgcolor=$corDtoper")." nowrap>".date("d-m-Y",$dtoper)."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" ".($corDtvenc==""?"":"bgcolor=$corDtvenc")." nowrap>".date("d-m-Y",$dtvenc)."</td>\n";	
      echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".(trim($REGISTRO[$i]["k01_descr"])==""?"&nbsp":$REGISTRO[$i]["k01_descr"])."</td>\n";
   echo "<td title=\"Lista por parcela\" class=\"borda\" style=\"font-size:11px\" nowrap><a href=\"cai3_gerfinanc002.php?numpre=".$elementos[$i]."&tipo=$tipo&verificaagrupar=1&agnump=f&agpar=t&emrec=".$emrec."&db_datausu=".date("Y-m-d",$DB_DATACALC)."&inscr=".@$inscr."&matric=".@$matric."&numpre="."&k03_tipo=".@$k03_tipo.@$numpre."&numcgm=".@$numcgm."\">AP</a></td>\n";
   echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".(trim($REGISTRO[$i]["k02_descr"])==""?"&nbsp":$REGISTRO[$i]["k02_descr"])."</td>\n";

   echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"valor$i\" value=\"".$valor."\">".number_format($valor,2,".",",")."</td>\n";
   echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"valorcorr$i\" value=\"".$valorcorr."\">".number_format($valorcorr,2,".",",")."</td>\n";
   echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"juros$i\" value=\"".$juros."\">".number_format($juros,2,".",",")."</td>\n";
   echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"multa$i\" value=\"".$multa."\">".number_format($multa,2,".",",")."</td>\n";
   echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"desconto$i\" value=\"".$desconto."\">".number_format($desconto,2,".",",")."</td>\n";
   echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"total$i\" value=\"".$total."\">".number_format($total,2,".",",")."</td>\n";

/*
   echo "<td class=\"borda\" style=\"font-size:11px\" id=\"valor$i\" align=\"right\" nowrap>".number_format($valor,2,".",",")."</td>\n";
   echo "<td class=\"borda\" style=\"font-size:11px\" id=\"valorcorr$i\" align=\"right\" nowrap>".number_format($valorcorr,2,".",",")."</td>\n";
   echo "<td class=\"borda\" style=\"font-size:11px\" id=\"juros$i\" align=\"right\" nowrap>".number_format($juros,2,".",",")."</td>\n";
   echo "<td class=\"borda\" style=\"font-size:11px\" id=\"multa$i\" align=\"right\" nowrap>".number_format($multa,2,".",",")."</td>\n";
   echo "<td class=\"borda\" style=\"font-size:11px\" id=\"desconto$i\" align=\"right\" nowrap>".number_format($desconto,2,".",",")."</td>\n";
   echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"total$i\" value=\"".$total."\">".number_format($total,2,".",",")."</td>\n";		
*/

//      if($emrec == "t")
	 echo "<td class=\"borda\" style=\"font-size:11px\" id=\"coluna$i\" nowrap>".($tipo==3?"<input type=\"submit\" name=\"calculavalor\" id=\"calculavalor$i\" value=\"Calcular\">":"")."<input style=\"visibility:'visible'\" type=\"".($tipo==3?"hidden":"checkbox")."\" value=\"".$numpres."\" onclick=\"js_soma(2)\" id=\"CHECK$i\" name=\"CHECK$i\" ".((abs($REGISTRO[$i]["k00_valor"])!=0 && $tipo==3)?"disabled":"")."></td>\n";
//      else
//	    echo "<td class=\"borda\" style=\"font-size:11px\" id=\"coluna$i\" nowrap>&nbsp;</td>\n";
       echo "</tr></label>\n"; 
       /***************************/
     }  
//agrupar por parcela
} else if($agpar == 't') {
/**********************************************************************************************/
//cria um array com os numpres não repetidos
     $j = 0;
     $elementos_numpres[0] = "";
 for($i = 0;$i < $numrows;$i++) {
   if(!in_array(pg_result($result,$i,"k00_numpre"),$elementos_numpres)) {
	 $elementos_numpres[$j++] = pg_result($result,$i,"k00_numpre");
       }
     }
     //contador unico para nomear os inputs
     $ContadorUnico = 0;
     $bool = 1;
     //faz a mao..
 for($x = 0;$x < sizeof($elementos_numpres);$x++) {
       //cria um array com as parcelas do numpre não repetidos
       if($bool == 0) {
     $ConfCor1 = "#77EE20";
     $ConfCor2 = "#A9F471";
	     $bool = 1;
	} else {
     $ConfCor1 = "#EFE029";
     $ConfCor2 = "#E4F471";
	     $bool = 0;
       }	  
       $f = 0;	  
   $vlrtotal = 0;
       if(isset($elementos_parcelas))
	 unset($elementos_parcelas);
       $elementos_parcelas[0] = "";
   for($r = 0;$r < $numrows;$r++) {
	 if($elementos_numpres[$x] == pg_result($result,$r,"k00_numpre"))
     if(!in_array(pg_result($result,$r,"k00_numpar"),$elementos_parcelas)) {
	   $REGISTRO[$f] = pg_fetch_array($result,$r);
	       $elementos_parcelas[$f++] = pg_result($result,$r,"k00_numpar");
	 }
       }
   for($i = 0;$i < sizeof($elementos_parcelas);$i++) {
	 $numpres = "";
	 $separador = "";
	 $valor = 0;
     $valorcorr = 0;
     $juros = 0;
     $multa = 0;
     $desconto = 0;
     $total = 0;
	 for($j = 0;$j < $numrows;$j++) {
	   if($elementos_parcelas[$i] == pg_result($result,$j,"k00_numpar") && $elementos_numpres[$x] == pg_result($result,$j,"k00_numpre")) {		    
          if(pg_result($result,$j,"k00_numpar") != @pg_result($result,$j+1,"k00_numpar") || (	$elementos_numpres[$x] != @pg_result($result,$j+1,"k00_numpre")) ) {
		       $numpres .= $separador.$elementos_numpres[$x]."P".$elementos_parcelas[$i];
	   $separador = "N";
		     }			
		 $valor += (float)pg_result($result,$j,"vlrhis");
	 $valorcorr += (float)pg_result($result,$j,"vlrcor");
	 $juros += (float)pg_result($result,$j,"vlrjuros");
	 $multa += (float)pg_result($result,$j,"vlrmulta");
	 $desconto += (float)pg_result($result,$j,"vlrdesconto");
	 $total += (float)pg_result($result,$j,"total"); 		    
	       }
	 }	  
	 /**************************/
     $vlrtotal += $REGISTRO[$i]["total"];
	 $dtoper = $REGISTRO[$i]["k00_dtoper"];
	 $dtoper = mktime(0,0,0,substr($dtoper,5,2),substr($dtoper,8,2),substr($dtoper,0,4));
	 //if($dtoper > time())
	 //  $corDtoper = "#FF5151";
	 //else
	 $corDtoper = "";
	 $dtvenc = $REGISTRO[$i]["k00_dtvenc"];
	 $dtvenc = mktime(23,59,0,substr($dtvenc,5,2),substr($dtvenc,8,2),substr($dtvenc,0,4));
	  if($dtvenc < $DB_DATACALC ) //time())
	    $corDtvenc = "red";
	  else{
	    if(date("d/m/Y",$dtvenc) == date("d/m/Y",$DB_DATACALC) ) //time())
	      $corDtvenc = "blue";
            else
	      $corDtvenc = "";	
         }
/*	 if($dtvenc < time())
	   $corDtvenc = "red";
	 else
	   $corDtvenc = "";	  
*/
   // unica
       if($elementos_parcelas[$i]==1){
	 $sqlunica = "select k00_numpre,dtvencunic,dtoperunic,k00_percdes,
	      substr(fc_calcula,2,13)::float8 as uvlrhis,
	      substr(fc_calcula,15,13)::float8 as uvlrcor,
	      substr(fc_calcula,28,13)::float8 as uvlrjuros,
	      substr(fc_calcula,41,13)::float8 as uvlrmulta,
	      substr(fc_calcula,54,13)::float8 as uvlrdesconto,
	      (substr(fc_calcula,15,13)::float8+
	      substr(fc_calcula,28,13)::float8+
	      substr(fc_calcula,41,13)::float8-
	      substr(fc_calcula,54,13)::float8) as utotal
			      from (
			      select r.k00_numpre,r.k00_dtvenc as dtvencunic, r.k00_dtoper as dtoperunic,r.k00_percdes,
				     fc_calcula(k00_numpre,0,0,k00_dtvenc,k00_dtvenc,".db_getsession("DB_anousu").")
	      from recibounica r
			      where r.k00_numpre = ".$elementos_numpres[$x]." and r.k00_dtvenc >= ".$DB_DATACALC."
			      ) as unica";
	     $resultunica = pg_exec($sqlunica);
	     for($unicont=0;$unicont<pg_numrows($resultunica);$unicont++){
       db_fieldsmemory($resultunica,$unicont);
	       if($dtvencunic>=date('Y-m-d',$DB_DATACALC)){
		 $dtvencunic = db_formatar($dtvencunic,'d');
		 $dtoperunic = db_formatar($dtoperunic,'d');
		 $corunica = "#009933";
	 $uvlrcorr = 0;
			$histdesc = "";
		    $resulthist = pg_exec("select k00_dtoper as dtlhist,k00_hora, login,substr(k00_histtxt,0,80) as k00_histtxt
		                       from arrehist 
							        left outer join db_usuarios on id_usuario = k00_id_usuario
							   where k00_numpre = ".$elementos_numpres[$x]." and k00_numpar = 0");
            if(pg_numrows($resulthist)>0){
		      for($di=0;$di<pg_numrows($resulthist);$di++){
		        db_fieldsmemory($resulthist,$di);
		        $histdesc .= $dtlhist." ".$k00_hora." ".$login." ".$k00_histtxt."\n";
              } 		
		    }

	 echo "<tr bgcolor=\"$corunica\">\n";	
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap></td>\n";	  
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap></td>\n";	  
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap title=\"".$histdesc."\">".$k00_numpre."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>00</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>00</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".$dtoperunic."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".$dtvencunic."</td>\n";	
	 echo "<td colspan=\"3\" class=\"borda\" style=\"font-size:11px;color:white\" nowrap>Parcela Única com $k00_percdes% desconto</td>\n";
//          echo "<td class=\"borda\" style=\"font-size:11px\" nowrap></td>\n";
//         echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>Parcela Única</td>\n";
    
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrhis,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrcorr,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrjuros,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrmulta,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrdesconto,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($utotal,2,".",",")."</td>\n";
	 echo "<td class=\"borda\" style=\"font-size:11px\" align=\"center\" nowrap>
		     <input type=\"button\" style=\"border:none;background-color:write\" name=\"unica\" onclick=\"js_emiteunica(".$k00_numpre.")\" value=\"U\">";
		 echo "  </td>\n
	 </tr>";
	   }
	     }	
   }
   //
   
      $temnoti = false;

      if (sizeof($REGISTRO[$i]) > 0) {
	$noti_sql = "select k53_numpre
		     from notidebitos
		     where k53_numpre = ".$REGISTRO[$i]["k00_numpre"]." and
			   k53_numpar = ".$REGISTRO[$i]["k00_numpar"]."
		     limit 1";
	$noti_result = pg_exec($noti_sql);
	if(pg_numrows($noti_result)){
	   $temnoti = true;
	}
      }



     echo "<label for=\"CHECK$ContadorUnico\"><tr style=\"cursor: hand\" bgcolor=\"".($cor = (@$cor==$ConfCor2?$ConfCor1:$ConfCor2))."\">\n";	
     echo "<td title=\"Informações Adicionais\" class=\"borda\" style=\"font-size:11px\" nowrap onclick=\"parent.js_mostradetalhes('cai3_gerfinanc005.php?".base64_encode($tipo."#".$REGISTRO[$i]["k00_numpre"]."#".$REGISTRO[$i]["k00_numpar"])."','','width=600,height=500,scrollbars=1')\"><a href=\"\" onclick=\"return false;\">
     MI</a></td>\n";	  

     if($temnoti){	  
        echo "<td title=\"Notificações Informadas\" class=\"borda\" style=\"font-size:11px\" nowrap onclick=\"parent.js_mostradetalhes('cai3_gerfinanc061.php?chave1=numpre&chave=".$REGISTRO[$i]["k00_numpre"]."&chave2=".$REGISTRO[$i]["k00_numpar"]."','','width=700,height=500,scrollbars=1')\"><a href=\"\" onclick=\"return false;\">
	  N</a></td>\n";
     }else{
        echo "<td title=\"Notificações Informadas\" class=\"borda\" style=\"font-size:11px\" nowrap >
	  &nbsp</td>\n";
	 
     }

     echo "<td class=\"borda\" style=\"font-size:11px\" nowrap><input style=\"border:none;background-color:$cor\" onclick=\"location.href='cai3_gerfinanc008.php?".base64_encode("numpre=".$elementos_numpres[$x])."'\" type=\"button\" value=\"".$elementos_numpres[$x]."\"></td>\n";
     echo "<td class=\"borda\" style=\"font-size:11px\" nowrap><input type=\"hidden\" id=\"parc$i\" value=\"".$elementos_parcelas[$i]."#".$REGISTRO[$i]["k00_numtot"]."#".$elementos_numpres[$x]."\">".$elementos_parcelas[$i]."</td>\n";
     echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".$REGISTRO[$i]["k00_numtot"]."</td>\n";


      //Se for divida ativa mostra o exercicio Select para buscar o exercicio
      if($k03_tipo==5){
      	$result_exerc = pg_exec("select distinct v01_exerc from divida where v01_numpre =".$REGISTRO[$i]["k00_numpre"]);
      	if (pg_numrows($result_exerc)==1){
      	db_fieldsmemory($result_exerc,0);
      	}
      	echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"\" value=\"\">".@$v01_exerc."&nbsp;</td>\n";      
      }else if($k03_tipo==6 or $k03_tipo==13){//Se for parcelamento mostra o Nº do parcelamento select para buscar o Nº do parcelamento
      	$result_parcel = pg_exec("select distinct v07_parcel from termo where v07_numpre =".$REGISTRO[$i]["k00_numpre"]);
      	if (pg_numrows($result_parcel)==1){
      	db_fieldsmemory($result_parcel,0);
      	}
      	echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"\" value=\"\">".@$v07_parcel."&nbsp;</td>\n";      
      }
     
     echo "<td class=\"borda\" style=\"font-size:11px\" ".($corDtoper==""?"":"bgcolor=$corDtoper")." nowrap>".date("d-m-Y",$dtoper)."</td>\n";
     echo "<td class=\"borda\" style=\"font-size:11px\" ".($corDtvenc==""?"":"bgcolor=$corDtvenc")." nowrap>".date("d-m-Y",$dtvenc)."</td>\n";	
     echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".(trim($REGISTRO[$i]["k01_descr"])==""?"&nbsp":$REGISTRO[$i]["k01_descr"])."</td>\n";
     echo "<td title=\"Lista por receita\" class=\"borda\" style=\"font-size:11px\" nowrap><a href=\"cai3_gerfinanc002.php?".$arg."&tipo=$tipo&agnump=f&agpar=f&emrec=".$emrec."&db_datausu=".date("Y-m-d",$DB_DATACALC)."&numcgm=".@$numcgm."&inscr=".@$inscr."&matric=".@$matric."&k03_tipo=".@$k03_tipo."&numpre=".@$numpre."\">DE</a></td>\n";
        echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".(trim($REGISTRO[$i]["k02_descr"])==""?"&nbsp":$REGISTRO[$i]["k02_descr"])."</td>\n";
       
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"valor$ContadorUnico\" value=\"".$valor."\">".number_format($valor,2,".",",")."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"valorcorr$ContadorUnico\" value=\"".$valorcorr."\">".number_format($valorcorr,2,".",",")."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"juros$ContadorUnico\" value=\"".$juros."\">".number_format($juros,2,".",",")."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"multa$ContadorUnico\" value=\"".$multa."\">".number_format($multa,2,".",",")."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"desconto$ContadorUnico\" value=\"".$desconto."\">".number_format($desconto,2,".",",")."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"total$ContadorUnico\" value=\"".$total."\">".number_format($total,2,".",",")."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" id=\"coluna$ContadorUnico\" nowrap>".($tipo==3?"<input type=\"submit\" name=\"calculavalor\" id=\"calculavalor$ContadorUnico\" value=\"Calcular\">":"")."<input style=\"visibility:'visible'\" type=\"".($tipo==3?"hidden":"checkbox")."\" value=\"".$numpres."\" onclick=\"js_soma(2)\" id=\"CHECK$ContadorUnico\" name=\"CHECK".$ContadorUnico++."\" ".((abs($REGISTRO[$i]["k00_valor"])!=0 && $tipo==3)?"disabled":"")."></td>\n";
/*	   
	   
	    echo "<td class=\"borda\" style=\"font-size:11px\" id=\"valor$ContadorUnico\" align=\"right\" nowrap>".number_format($valor,2,".",",")."</td>\n";
        echo "<td class=\"borda\" style=\"font-size:11px\" id=\"valorcorr$ContadorUnico\" align=\"right\" nowrap>".number_format($valorcorr,2,".",",")."</td>\n";
        echo "<td class=\"borda\" style=\"font-size:11px\" id=\"juros$ContadorUnico\" align=\"right\" nowrap>".number_format($juros,2,".",",")."</td>\n";
        echo "<td class=\"borda\" style=\"font-size:11px\" id=\"multa$ContadorUnico\" align=\"right\" nowrap>".number_format($multa,2,".",",")."</td>\n";
        echo "<td class=\"borda\" style=\"font-size:11px\" id=\"desconto$ContadorUnico\" align=\"right\" nowrap>".number_format($desconto,2,".",",")."</td>\n";
        echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"total$ContadorUnico\" value=\"".$total."\">".number_format($total,2,".",",")."</td>\n";		
*/

//        if($emrec == "t")
//        else
//	      echo "<td class=\"borda\" style=\"font-size:11px\" id=\"coluna$ContadorUnico\" nowrap>&nbsp;</td>\n";
	    echo "</tr></label>\n"; 
	    /***************************/
	  }  
    }
  } else {//NIVEL NORMAL

  /**************************************************************************************************************/
    //cria um array com os numpres não repetidos
	$j = 0;
	$elementos_numpres[0] = "";
    for($i = 0;$i < $numrows;$i++) {	  
      if(!in_array(pg_result($result,$i,"k00_numpre"),$elementos_numpres))
	    $elementos_numpres[$j++] = pg_result($result,$i,"k00_numpre");
	}				
    for($i = 0;$i < sizeof($elementos_numpres);$i++) {
      $auxValor = 0;
	  $auxValorcorr = 0;
	  $auxJuros = 0;
	  $auxMulta = 0;
	  $auxDesconto = 0;
	  $auxTotal = 0;
      for($j = 0;$j < $numrows;$j++) {   	        	 
	    if($elementos_numpres[$i] == pg_result($result,$j,"k00_numpre")) {
		  if(pg_result($result,$j,"k00_numpar") == @pg_result($result,($j+1),"k00_numpar")) {
		    $auxValor += (float)pg_result($result,$j,"vlrhis");
		    $auxValorcorr += (float)pg_result($result,$j,"vlrcor");
		    $auxJuros += (float)pg_result($result,$j,"vlrjuros");
		    $auxMulta += (float)pg_result($result,$j,"vlrmulta");
		    $auxDesconto += (float)pg_result($result,$j,"vlrdesconto");
		    $auxTotal += (float)pg_result($result,$j,"total");															
			$SomaDasParcelasValor[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] = $auxValor;
			$SomaDasParcelasValorcorr[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] = $auxValorcorr;
			$SomaDasParcelasJuros[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] = $auxJuros;
			$SomaDasParcelasMulta[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] = $auxMulta;
			$SomaDasParcelasDesconto[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] = $auxDesconto;
			$SomaDasParcelasTotal[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] = $auxTotal;												
			//echo $elementos_numpres[$i]." == ".pg_result($result,$j,"k00_numpar")." == ".@pg_result($result,$j+1,"k00_numpar")." == ".$aux."<br>";
		  } else {
            $auxValor = 0;
   	        $auxValorcorr = 0;
	        $auxJuros = 0;
	        $auxMulta = 0;
	        $auxDesconto = 0;
	        $auxTotal = 0;
			/*			
		    $SomaDasParcelasValor[$elementos_numpres[$i]][@pg_result($result,$j+1,"k00_numpar")] = "0";
            $SomaDasParcelasValorcorr[$elementos_numpres[$i]][@pg_result($result,$j+1,"k00_numpar")] = 0;
            $SomaDasParcelasJuros[$elementos_numpres[$i]][@pg_result($result,$j+1,"k00_numpar")] = 0;
            $SomaDasParcelasMulta[$elementos_numpres[$i]][@pg_result($result,$j+1,"k00_numpar")] = 0;
            $SomaDasParcelasDesconto[$elementos_numpres[$i]][@pg_result($result,$j+1,"k00_numpar")] = 0;
            $SomaDasParcelasTotal[$elementos_numpres[$i]][@pg_result($result,$j+1,"k00_numpar")] = 0;
             */
	        @$SomaDasParcelasValor[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] += pg_result($result,$j,"vlrhis");
	        @$SomaDasParcelasValorcorr[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] += pg_result($result,$j,"vlrcor");
	        @$SomaDasParcelasJuros[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] += pg_result($result,$j,"vlrjuros");
	        @$SomaDasParcelasMulta[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] += pg_result($result,$j,"vlrmulta");
	        @$SomaDasParcelasDesconto[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] += pg_result($result,$j,"vlrdesconto");												
	        @$SomaDasParcelasTotal[$elementos_numpres[$i]][pg_result($result,$j,"k00_numpar")] += pg_result($result,$j,"total");
		  }
		} else {		  		  				      
          //unset($SomaDasParcelasValor, $SomaDasParcelasValorcorr, $SomaDasParcelasJuros, $SomaDasParcelasMulta, $SomaDasParcelasDesconto, $SomaDasParcelasTotal);			  
		  continue;
	    }
	  }
	}	
    $vlrtotal = 0;
	$verf_parc = "";
	$cont = 0;
	$cont2 = 0;	
	$bool = 0;
	$bool2 = 0;	
    $ConfCor1 = "#EFE029";
    $ConfCor2 = "#E4F471";
 
    $listaunica = true;
    for($i = 0;$i < $numrows;$i++) {
	  if($elementos_numpres[$cont] != pg_result($result,$i,"k00_numpre")) {
	    $listaunica = true;
	    $cont++;
	    if($bool == 0) {
          $ConfCor1 = "#77EE20";
          $ConfCor2 = "#A9F471";
		  $bool = 1;
	     } else {
          $ConfCor1 = "#EFE029";
          $ConfCor2 = "#E4F471";
		  $bool = 0;
		}
	  }
      $vlrtotal += pg_result($result,$i,"total");
	  $dtoper = pg_result($result,$i,"k00_dtoper");
	  $dtoper = mktime(0,0,0,substr($dtoper,5,2),substr($dtoper,8,2),substr($dtoper,0,4));
	  //if($dtoper > time())
	  //  $corDtoper = "#FF5151";
	  //else
	  $corDtoper = "";
	  $dtvenc = pg_result($result,$i,"k00_dtvenc");
	  $dtvenc = mktime(23,59,0,substr($dtvenc,5,2),substr($dtvenc,8,2),substr($dtvenc,0,4));

	  if( $dtvenc < $DB_DATACALC ) //time())
	    $corDtvenc = "red";
	  else{
	    if(date("d/m/Y",$dtvenc) == date("d/m/Y",$DB_DATACALC) ) //time())
	      $corDtvenc = "blue";
            else
	      $corDtvenc = "";	
          }
/*	  if($dtvenc < time())
	    $corDtvenc = "red";
	  else
	    $corDtvenc = "";
*/
	  if(pg_result($result,$i,"k00_numpar") == @$salva_parcela) {
	    $cor = $ConfCor1;
	  } else {
  	    $cor = $ConfCor2;
	    if(pg_result($result,$i,"k00_numpar") == @pg_result($result,$i+1,"k00_numpar"))
	      $salva_parcela = "";
	    else
	      $salva_parcela = @pg_result($result,$i+1,"k00_numpar");		
	  }	
      // unica
          if($tipo!=3){
	  if(($elementos_numpres[$cont] == pg_result($result,$i,"k00_numpre")) && $listaunica) {
//	    if($verf_parc != pg_result($result,$i,"k00_numpar") && $emrec == "t") {
	    $listaunica = false;
	    $resultunica = pg_query(
		        "select *,
                 substr(fc_calcula,2,13)::float8 as uvlrhis,
                 substr(fc_calcula,15,13)::float8 as uvlrcor,
                 substr(fc_calcula,28,13)::float8 as uvlrjuros,
                 substr(fc_calcula,41,13)::float8 as uvlrmulta,
                 substr(fc_calcula,54,13)::float8 as uvlrdesconto,
                 (substr(fc_calcula,15,13)::float8+
                 substr(fc_calcula,28,13)::float8+
                 substr(fc_calcula,41,13)::float8-
                 substr(fc_calcula,54,13)::float8) as utotal
				 from (
				 select r.k00_numpre,r.k00_dtvenc as dtvencunic, r.k00_dtoper as dtoperunic, r.k00_percdes,
				        fc_calcula(r.k00_numpre,0,0,r.k00_dtvenc,r.k00_dtvenc,".db_getsession("DB_anousu").")
                 from recibounica r
				 where r.k00_numpre = ".pg_result($result,$i,"k00_numpre")." and r.k00_dtvenc >= ".$DB_DATACALC."
				 ) as unica");
		for($unicont=0;$unicont<pg_numrows($resultunica);$unicont++){
          db_fieldsmemory($resultunica,$unicont);
 		  if($dtvencunic>=date('Y-m-d',$DB_DATACALC)){
		    $dtvencunic = db_formatar($dtvencunic,'d');
		    $dtoperunic = db_formatar($dtoperunic,'d');
		    $corunica = "#009933";
            $uvlrcorr = 0;
						$histdesc = "";
		    $resulthist = pg_exec("select k00_dtoper as dtlhist,k00_hora, login,substr(k00_histtxt,0,80) as k00_histtxt
		                       from arrehist 
							        left outer join db_usuarios on id_usuario = k00_id_usuario
							   where k00_numpre = ".pg_result($result,$i,"k00_numpre")." and k00_numpar = 0");
            if(pg_numrows($resulthist)>0){
		      for($di=0;$di<pg_numrows($resulthist);$di++){
		        db_fieldsmemory($resulthist,$di);
		        $histdesc .= $dtlhist." ".$k00_hora." ".$login." ".$k00_histtxt."\n";
              } 		
		    }

            echo "<tr bgcolor=\"$corunica\">\n";	
            echo "<td class=\"borda\" style=\"font-size:11px\" nowrap></td>\n";	  
            echo "<td class=\"borda\" style=\"font-size:11px\" nowrap></td>\n";	  
            echo "<td class=\"borda\" style=\"font-size:11px\" nowrap title=\"".$histdesc."\">".$k00_numpre."</td>\n";
            echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>00</td>\n";
            echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>00</td>\n";
            echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".$dtoperunic."</td>\n";
            echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".$dtvencunic."</td>\n";	
            echo "<td colspan=\"3\" class=\"borda\" style=\"font-size:11px;color:white\" nowrap>Parcela Única com $k00_percdes% desconto</td>\n";
//          echo "<td class=\"borda\" style=\"font-size:11px\" nowrap></td>\n";
 //         echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>Parcela Única</td>\n";
       
            echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrhis,2,".",",")."</td>\n";
            echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrcorr,2,".",",")."</td>\n";
            echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrjuros,2,".",",")."</td>\n";
            echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrmulta,2,".",",")."</td>\n";
            echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($uvlrdesconto,2,".",",")."</td>\n";
            echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap>".number_format($utotal,2,".",",")."</td>\n";
            echo "<td class=\"borda\" style=\"font-size:11px\" align=\"center\" nowrap>
		        <input type=\"button\" style=\"border:none;background-color:write\" name=\"unica\" onclick=\"js_emiteunica('$k00_numpre')\" value=\"U\">";
		    echo "  </td>\n
            </tr>";
	      }
		}	
	  }
}
      //
      $noti_sql = "select k53_numpre
                   from notidebitos
		   where k53_numpre = ".pg_result($result,$i,"k00_numpre")." and
                         k53_numpar = ".pg_result($result,$i,"k00_numpar")."
		   limit 1";
      $noti_result = pg_exec($noti_sql);
      $temnoti = false;
      if(pg_numrows($noti_result)){
	 $temnoti = true;

      }


      echo "<label for=\"CHECK$i\"><tr style=\"cursor: hand\" bgcolor=\"".$cor."\">\n";	
      echo "<td title=\"Informações Adicionais\" class=\"borda\" style=\"font-size:11px; cursos:hand\" nowrap onclick=\"parent.js_mostradetalhes('cai3_gerfinanc005.php?".base64_encode($tipo."#".pg_result($result,$i,"k00_numpre")."#".pg_result($result,$i,"k00_numpar"))."','','width=600,height=500,scrollbars=1')\"><a href=\"\" onclick=\"return false;\">
	  MI</a></td>\n";

      if($temnoti){	  
        echo "<td title=\"Notificações Informadas\" class=\"borda\" style=\"font-size:11px\" nowrap onclick=\"parent.js_mostradetalhes('cai3_gerfinanc061.php?chave1=numpre&chave=".pg_result($result,$i,"k00_numpre")."&chave2=".pg_result($result,$i,"k00_numpar")."','','width=700,height=500,scrollbars=1')\"><a href=\"\" onclick=\"return false;\">
	  N</a></td>\n";
      }else{
        echo "<td title=\"Notificações Informadas\" class=\"borda\" style=\"font-size:11px\" nowrap >
	  &nbsp</td>\n";
	 
      }

  

      echo "<td class=\"borda\" style=\"font-size:11px\" nowrap><input style=\"border:none;background-color:$cor\" onclick=\"location.href='cai3_gerfinanc008.php?".base64_encode("numpre=".pg_result($result,$i,"k00_numpre"))."'\" type=\"button\" value=\"".pg_result($result,$i,"k00_numpre")."\"></td>\n";

//      echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".pg_result($result,$i,"k00_numpre")."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".(trim(pg_result($result,$i,"k00_numpar"))==""?"&nbsp":pg_result($result,$i,"k00_numpar"))."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".(trim(pg_result($result,$i,"k00_numtot"))==""?"&nbsp":pg_result($result,$i,"k00_numtot"))."</td>\n";



      //Se for divida ativa mostra o exercicio Select para buscar o exercicio
      if($k03_tipo==5){
      	$result_exerc = pg_exec("select distinct v01_exerc from divida where v01_numpre =".pg_result($result,$i,"k00_numpre"));
      	if (pg_numrows($result_exerc)==1){
      	db_fieldsmemory($result_exerc,0);
      	}
      	echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"\" value=\"\">".@$v01_exerc."&nbsp;</td>\n";      
      }else if($k03_tipo==6){//Se for parcelamento mostra o Nº do parcelamento select para buscar o Nº do parcelamento
      	$result_parcel = pg_exec("select distinct v07_parcel from termo where v07_numpre =".pg_result($result,$i,"k00_numpre"));
      	if (pg_numrows($result_parcel)==1){
      	db_fieldsmemory($result_parcel,0);
      	}
      	echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"\" value=\"\">".@$v07_parcel."&nbsp;</td>\n";      
      }





      
      echo "<td class=\"borda\" style=\"font-size:11px\" ".($corDtoper==""?"":"bgcolor=$corDtoper")." nowrap>".date("d-m-Y",$dtoper)."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" ".($corDtvenc==""?"":"bgcolor=$corDtvenc")." nowrap>".date("d-m-Y",$dtvenc)."</td>\n";	

//      if($tipo==3) 
//        echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".pg_result($result,$i,"q05_aliq")."</td>\n";
//      else
        echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".(trim(pg_result($result,$i,"k01_descr"))==""?"&nbsp":pg_result($result,$i,"k01_descr"))."</td>\n";
      
      echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".(trim(pg_result($result,$i,"k00_receit"))==""?"&nbsp":pg_result($result,$i,"k00_receit"))."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" nowrap>".(trim(pg_result($result,$i,"k02_descr"))==""?"&nbsp":pg_result($result,$i,"k02_descr"))."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"valor$i\" value=\"".$SomaDasParcelasValor[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")]."\">".(trim(pg_result($result,$i,"vlrhis"))==""?"&nbsp":((abs(pg_result($result,$i,"k00_valor"))==0 && $tipo==3)?"<input style=\"height: 16px;font-size=12px\" onfocus=\"if(parent.document.getElementById('enviar').value == 'Agrupar') parent.document.getElementById('enviar').disabled = true;\" type=\"text\" name=\"VAL".$i."\" value=\"".abs(pg_result($result,$i,"valor_variavel"))."\" size=\"5\">":number_format(pg_result($result,$i,"vlrhis"),2,".",",")))."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"valorcorr$i\" value=\"".$SomaDasParcelasValorcorr[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")]."\">".(trim(pg_result($result,$i,"vlrcor"))==""?"&nbsp":number_format(pg_result($result,$i,"vlrcor"),2,".",","))."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"juros$i\" value=\"".$SomaDasParcelasJuros[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")]."\">".(trim(pg_result($result,$i,"vlrjuros"))==""?"&nbsp":number_format(pg_result($result,$i,"vlrjuros"),2,".",","))."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"multa$i\" value=\"".$SomaDasParcelasMulta[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")]."\">".(trim(pg_result($result,$i,"vlrmulta"))==""?"&nbsp":number_format(pg_result($result,$i,"vlrmulta"),2,".",","))."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"desconto$i\" value=\"".$SomaDasParcelasDesconto[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")]."\">".(trim(pg_result($result,$i,"vlrdesconto"))==""?"&nbsp":number_format(pg_result($result,$i,"vlrdesconto"),2,".",","))."</td>\n";
      echo "<td class=\"borda\" style=\"font-size:11px\" align=\"right\" nowrap><input type=\"hidden\" id=\"total$i\" value=\"".$SomaDasParcelasTotal[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")]."\">".(trim(pg_result($result,$i,"total"))==""?"&nbsp":number_format(pg_result($result,$i,"total"),2,".",","))."</td>\n";

/*
echo "<script>alert('kjkjk');</script>";
      $SomaDasParcelasValor[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")] = "QQ";
      $SomaDasParcelasValorcorr[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")] = 0;
      $SomaDasParcelasJuros[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")] = 0;
      $SomaDasParcelasMulta[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")] = 0;
      $SomaDasParcelasDesconto[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")] = 0;
      $SomaDasParcelasTotal[pg_result($result,$i,"k00_numpre")][pg_result($result,$i,"k00_numpar")] = 0;
*/

	  if($elementos_numpres[$cont2] == pg_result($result,$i,"k00_numpre")) {
//	    if($verf_parc != pg_result($result,$i,"k00_numpar") && $emrec == "t") {
	    if($verf_parc != pg_result($result,$i,"k00_numpar")) {
          echo "<td class=\"borda\" style=\"font-size:11px\" id=\"coluna$i\" nowrap>".($tipo==3?"<input type=\"submit\"  onclick=\"this.form.target = ''\" name=\"calculavalor\" id=\"calculavalor$i\" value=\"Calcular\">":"")."<input style=\"visibility:'visible'\" type=\"".($tipo==3?"hidden":"checkbox")."\" value=\"".pg_result($result,$i,"k00_numpre")."P".pg_result($result,$i,"k00_numpar")."\" onclick=\"js_soma(2)\" id=\"CHECK$i\" name=\"CHECK$i\" ".((abs(pg_result($result,$i,"k00_valor"))!=0 && $tipo==3)?"disabled":"")."></td>\n";
	      $verf_parc = pg_result($result,$i,"k00_numpar");
	    } else {
	      $verf_parc = pg_result($result,$i,"k00_numpar");
	      echo "<td class=\"borda\" style=\"font-size:11px\" id=\"coluna$i\" nowrap>&nbsp;</td>\n";		
        }
	  } else {
 	    $cont2++;
        $verf_parc = pg_result($result,$i,"k00_numpar");
//		if($emrec == "t")
          echo "<td class=\"borda\" style=\"font-size:11px\" id=\"coluna$i\" nowrap>".($tipo==3?"<input type=\"submit\" onclick=\"this.form.target = ''\" name=\"calculavalor\" id=\"calculavalor$i\" value=\"Calcular\">":"")."<input style=\"visibility:'visible'\" type=\"".($tipo==3?"hidden":"checkbox")."\" value=\"".pg_result($result,$i,"k00_numpre")."P".pg_result($result,$i,"k00_numpar")."\" onclick=\"js_soma(2)\" id=\"CHECK$i\" name=\"CHECK$i\" ".((abs(pg_result($result,$i,"k00_valor"))!=0 && $tipo==3)?"disabled":"")."></td>\n";
//        else
//		  echo "<td class=\"borda\" style=\"font-size:11px\" id=\"coluna$i\" nowrap>&nbsp;</td>\n";				  
	  }
/*
      if(pg_result($result,$i,"k00_numpre") == @pg_result($result,$i + 1,"k00_numpre")) {
	    if($verf_parc != pg_result($result,$i,"k00_numpar") && $emrec == "t") {
          echo "<td class=\"borda\" style=\"font-size:11px\" id=\"coluna$i\" nowrap>".($tipo==3?"<input type=\"submit\" name=\"calculavalor\" id=\"calculavalor$i\" value=\"Calcular\">":"")."<input type=\"".($tipo==3?"hidden":"checkbox")."\" value=\"".pg_result($result,$i,"k00_numpre")."P".pg_result($result,$i,"k00_numpar")."\" onclick=\"js_soma(2)\" id=\"CHECK$i\" name=\"CHECK$i\" ".((abs(pg_result($result,$i,"k00_valor"))!=0 && $tipo==3)?"disabled":"")."></td>\n";
	      $verf_parc = pg_result($result,$i,"k00_numpar");
	    } else {
	      $verf_parc = pg_result($result,$i,"k00_numpar");
	      echo "<td class=\"borda\" style=\"font-size:11px\" id=\"coluna$i\" nowrap>&nbsp;</td>\n";		
        }
	  } else if($emrec == "t")
        echo "<td class=\"borda\" style=\"font-size:11px\" id=\"coluna$i\" nowrap>".($tipo==3?"<input type=\"submit\" name=\"calculavalor\" id=\"calculavalor$i\" value=\"Calcular\">":"")."<input type=\"".($tipo==3?"hidden":"checkbox")."\" value=\"".pg_result($result,$i,"k00_numpre")."P".pg_result($result,$i,"k00_numpar")."\" onclick=\"js_soma(2)\" id=\"CHECK$i\" name=\"CHECK$i\" ".((abs(pg_result($result,$i,"k00_valor"))!=0 && $tipo==3)?"disabled":"")."></td>\n";
	 */
	  echo "</tr></label>\n"; 

	  
	}
  }	////////****************************************************************************************/
  echo "</table>\n</form>\n";
  echo "<script>
          parent.document.getElementById('valor1').innerHTML = \"0.00\";
          parent.document.getElementById('valorcorr1').innerHTML = \"0.00\";
          parent.document.getElementById('juros1').innerHTML = \"0.00\";
          parent.document.getElementById('multa1').innerHTML = \"0.00\";
          parent.document.getElementById('desconto1').innerHTML = \"0.00\";
          parent.document.getElementById('total1').innerHTML = \"0.00\";

          parent.document.getElementById('valor2').innerHTML = \"0.00\";
          parent.document.getElementById('valorcorr2').innerHTML = \"0.00\";
          parent.document.getElementById('juros2').innerHTML = \"0.00\";
          parent.document.getElementById('multa2').innerHTML = \"0.00\";
          parent.document.getElementById('desconto2').innerHTML = \"0.00\";
          parent.document.getElementById('total2').innerHTML = \"0.00\";
		  
          parent.document.getElementById('valor3').innerHTML = \"0.00\";
          parent.document.getElementById('valorcorr3').innerHTML = \"0.00\";
          parent.document.getElementById('juros3').innerHTML = \"0.00\";
          parent.document.getElementById('multa3').innerHTML = \"0.00\";
          parent.document.getElementById('desconto3').innerHTML = \"0.00\";
          parent.document.getElementById('total3').innerHTML = \"0.00\";
          parent.document.getElementById('relatorio').disabled = false;  
          js_soma(1)
		</script>\n";  
}
?>
</center>
</body>
</html>
<script>
/*
  parent.document.getElementById('valor').innerText = '&nbsp;';
  parent.document.getElementById('valorcorr').innerText = '&nbsp;';
  parent.document.getElementById('juros').innerText = '&nbsp;';
  parent.document.getElementById('multa').innerText = '&nbsp';
  parent.document.getElementById('desconto').innerText = '&nbsp;';
  parent.document.getElementById('total').innerText = '&nbsp;';
  */
  parent.document.getElementById('btmarca').value = "Marcar Todas";
  parent.document.getElementById('enviar').disabled = true;
  var tipo = <?=(!isset($tipo)?-1:$tipo)?>;
  if(tipo == 3) {
    parent.document.getElementById('enviar').value = 'Agrupar';
    parent.document.getElementById('enviar').disabled = false;
  }
</script>
<?
}
?>
