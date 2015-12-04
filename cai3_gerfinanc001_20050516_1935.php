<?
//21.833.694.
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_iptubase_classe.php");
include("classes/db_issbase_classe.php");
include("classes/db_cgm_classe.php");
include("dbforms/db_funcoes.php");
include("libs/db_sql.php");
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
$clcgm = new cl_cgm;
$clcgm->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label('j01_matric');
$clrotulo->label('q02_inscr');
$clrotulo->label('k00_numpre');
$clrotulo->label('v07_parcel');
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<style type="text/css">
<!--
.tabcols {
  font-size:11px;
}
.tabcols1 {
  text-align: right;
  font-size:11px;
}
.btcols {
	height: 17px;
	font-size:10px;
}
.links {
	font-weight: bold;
	color: #0033FF;
	text-decoration: none;
	font-size:10px;
    cursor: hand;
}
a.links:hover {
    color:black;
	text-decoration: underline;
}
.links2 {
	font-weight: bold;
	color: #0587CD;
	text-decoration: none;
	font-size:10px;
}
a.links2:hover {
    color:black;
	text-decoration: underline;
}
.nome {
  color:black;  
}
a.nome:hover {
  color:blue;
}
-->
</style>
<script>

function js_MudaLink(nome) {
  document.getElementById('processando').style.visibility = 'visible';
/*
  document.getElementById("RRR").innerHTML = "<br><br><br>";
  for(i in 	document.getElementById('processandoTD').style) {
    document.getElementById("RRR").innerHTML += i + " => " + 	document.getElementById('processandoTD').style[i] + "<br>";
  }
*/
  if(navigator.appName == "Netscape") {
    TIPO = document.getElementById(nome).childNodes[1].firstChild.nodeValue;
  } else {
    TIPO = document.getElementById(nome).innerText;
	document.getElementById('processando').style.top = 113;
  }
//  if(nome.indexOf("tiposemdeb") != -1) 
//    document.getElementById('outrasopcoes').disabled = true;
//  else
//    document.getElementById('outrasopcoes').disabled = false;

  document.getElementById('processandoTD').innerHTML = '<h3>Aguarde, processando ' + TIPO + '...</h3>';
  for(i = 0;i < document.links.length;i++) {
    var L = document.links[i].id;
	if(L!=""){
 	  document.getElementById(L).style.backgroundColor = '#CCCCCC';
	  document.getElementById(L).hideFocus = true;
	}
  }
  document.getElementById(nome).style.backgroundColor = '#E8EE6F';
 
  if(nome.indexOf("tiposemdeb") != -1) {
    document.getElementById('relatorio').disabled = true;
    document.getElementById('enviar').disabled = true;
    document.getElementById('btmarca').disabled = true;    
  } else {
  
  //  document.getElementById('relatorio').disabled = false;
//    document.getElementById('enviar').disabled = false;
   document.getElementById('btmarca').disabled = false;  
	
  }

  document.getElementById('valor1').innerHTML = "0.00";
  document.getElementById('valorcorr1').innerHTML = "0.00";
  document.getElementById('juros1').innerHTML = "0.00";
  document.getElementById('multa1').innerHTML = "0.00";
  document.getElementById('desconto1').innerHTML = "0.00";
  document.getElementById('total1').innerHTML = "0.00";
  
  document.getElementById('valor2').innerHTML = "0.00";
  document.getElementById('valorcorr2').innerHTML = "0.00";
  document.getElementById('juros2').innerHTML = "0.00";
  document.getElementById('multa2').innerHTML = "0.00";
  document.getElementById('desconto2').innerHTML = "0.00";
  document.getElementById('total2').innerHTML = "0.00";
		  
  document.getElementById('valor3').innerHTML = "0.00";
  document.getElementById('valorcorr3').innerHTML = "0.00";
  document.getElementById('juros3').innerHTML = "0.00";
  document.getElementById('multa3').innerHTML = "0.00";
  document.getElementById('desconto3').innerHTML = "0.00";
  document.getElementById('total3').innerHTML = "0.00";
}
function js_relatorio() {
  var numcgm = (typeof(debitos.numcgm)=="undefined")?"":debitos.numcgm;
  var matric = (typeof(debitos.matric)=="undefined")?"":debitos.matric;
  var inscr = (typeof(debitos.inscr)=="undefined")?"":debitos.inscr;
  var numpre = (typeof(debitos.numpre)=="undefined")?"":debitos.numpre;
  var tipo = debitos.tipo;
  alert('Utilizar a emiss�o do relat�rio pelo total dos d�bitos');
/*  jan = window.open('cai3_gerfinanc004.php?tipo='+tipo+'&numcgm='+numcgm+'&matric='+matric+'&inscr='+inscr+'&numpre='+numpre+'&db_datausu='+document.form1.k00_dtoper_ano.value+'-'+document.form1.k00_dtoper_mes.value+'-'+document.form1.k00_dtoper_dia.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);*/
}
function js_emiterecibo() {
  if(document.getElementById('enviar').value != 'Agrupar') {
    var F = debitos.document.form1.elements;
	/*
    var aux = "";
    for(i = 0;i < F.length;i++) {
      if(F[i].type == "checkbox" && F[i].checked == true) {
	    aux += 'N' + F[i].value;
	  }
      }
	
	if(F["ver_matric"].value != "" && F["ver_inscr"].value != "") {
	  alert("Erro(50): fun��o retornou matricula e inscri��o preenchidos.");
	  return false;
	} else if(F["ver_matric"].value != "") {
	  var vm = "&vermatric=" + F["ver_matric"].value; 
	} else if(F["ver_inscr"].value != "") {
	  var vm = "&verinscr=" + F["ver_inscr"].value;
	} else if(F["ver_numcgm"].value != "") {
	  var vm = "&vernumcgm=" + F["ver_numcgm"].value;
	}
	
	var tipo = debitos.tipo;
	*/
//    jan = window.open('cai3_gerfinanc003.php?tipo='+tipo+'&numpres=' + aux + vm,'_blank','width=790,height=530,scrollbars=1,location=0');
    jan = window.open('','reciboweb2','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);
    debitos.document.form1.submit();
    if((elem = debitos.document.getElementById("geracarne")))
      elem.parentNode.removeChild(elem);
 }else{
      var tab = debitos.document.getElementById('tabdebitos');
      for(i = 1;i < tab.rows.length;i++) {	
//      var num = new Number(tab.rows[i].cells[10].innerText);
        var num = new Number(tab.rows[i].cells[10].childNodes[1].nodeValue);
	    num = Math.abs(num);
/*        if(num == 0) {
	      tab.deleteRow(i);
	      i = 0;
 	    }
*/
    }
		
    var cor = "";
    for(i = 1;i < tab.rows.length;i++) {  
      cor = (cor=="#E4F471")?"#EFE029":"#E4F471";
      tab.rows[i].bgColor = cor;
      if(tab.rows[i].cells[16].childNodes[0].attributes["type"].nodeValue == "submit") {
        var elem = debitos.document.getElementById(tab.rows[i].cells[16].childNodes[0].attributes["id"].nodeValue);
	    elem.parentNode.removeChild(elem);
	  }
	  if(tab.rows[i].cells[16].childNodes[0].attributes["type"].nodeValue == "hidden") {
  	    var inp = debitos.document.createElement("INPUT");
	    inp.setAttribute("type","checkbox");
	    inp.setAttribute("name",tab.rows[i].cells[16].childNodes[0].attributes["name"].nodeValue); 
	    inp.setAttribute("id",tab.rows[i].cells[16].childNodes[0].attributes["id"].nodeValue);
	    inp.setAttribute("value",tab.rows[i].cells[16].childNodes[0].attributes["value"].nodeValue);		
        if(navigator.appName == "Netscape")
          inp.addEventListener("click",debitos.js_soma,false);
		else
		  inp.onclick = debitos.js_soma;				  
	    tab.rows[i].cells[16].appendChild(inp);		  
        var elem = debitos.document.getElementById(tab.rows[i].cells[16].childNodes[0].attributes["id"].nodeValue);
	    elem.parentNode.removeChild(elem);
	  }
    }
    document.getElementById("enviar").value = 'Emite Recibo';
	document.getElementById("enviar").disabled = true;
  }
}
function limpaparcela(qual) {
  debitos.document.getElementById(qual).checked=false;  
  debitos.document.getElementById(qual).style.visibility='hidden';  
  document.getElementById("enviar").disabled = true;
}
function js_emitecarne(qualcarne) {
  var chi = debitos.document.createElement("INPUT"); 
  chi.setAttribute("type","hidden");    
  chi.setAttribute("name","geracarne");
  chi.setAttribute("id","geracarne"); 
  if(qualcarne==true) 
     chi.setAttribute("value","banco");  
  else
     chi.setAttribute("value","prefeitura");  
  debitos.document.getElementById('form1').appendChild(chi);  
  js_emiterecibo();
}

function js_verifica(opcaolibera){
  var vari = '';
  for(i = 0;i < document.links.length;i++) {
    L = new String(document.links[i].href);
	if(L.lastIndexOf('cai3_gerfinanc001.php') != -1){
          alert(L.valueOf());
	}
  }
}
function js_outrasopcoes(chave){
   if(chave==1){
     if(debitos.document != ""){
        debitos.document.form1.target="";
        debitos.document.form1.action="cai3_gerfinanc012.php";
        debitos.document.form1.submit();
	 }else{
	    alert("Selecione uma D�vida para dar Desconto.");
	 }
   }
}

function js_emitenotificacao(){
  var chi = debitos.document.createElement("INPUT"); 
  chi.setAttribute("type","hidden");    
  chi.setAttribute("name","notificacao_tipo");
  chi.setAttribute("id","notificacao_tipo"); 
  debitos.document.getElementById('form1').appendChild(chi);  
  debitos.document.getElementById('form1').action='cai3_gerfinanc060.php';  
  debitos.document.getElementById('form1').target='';  
  debitos.document.getElementById('form1').submit();  
}
function js_label(liga,str){
  if(liga=='true'){
    document.getElementById('tab_label').style.visibility='visible';
    document.getElementById('label_numpre').innerHTML=str;
  }else{
    document.getElementById('tab_label').style.visibility='hidden';
  }

}


</script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="DDD"></div>
<div id="processando" style="position:absolute; left:17px; top:113px; width:755px; height:235px; z-index:1; visibility: hidden; background-color: #FFFFFF; layer-background-color: #FFFFFF; border: 1px none #000000;">
<Table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td align="center" valign="middle" id="processandoTD" onclick="document.getElementById('processando').style.visibility='hidden'"></td>
</tr>
</Table>
</div>

	  <table border="1" id="tab_label"  class="cabec" style="position:absolute; z-index:1; background-color:#cccccc; top:350; left:30; visibility: hidden;">      
	    <tr>
	      <td>
	        <font color="darkblue">
		    <span id="label_numpre"> </span>
	        </font>
	      </td>
	   </tr>
	  </table> 
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0"><tr><td height="430" align="left" valign="top" bgcolor="#CCCCCC">
  <center>
    <?	
	$mensagem_semdebitos = false;
	$com_debitos = true;
	if(isset($HTTP_POST_VARS["pesquisar"]) || isset($matricula) || isset($inscricao)) {
	//aqui � pra se clicar no link da matricula em cai3_gerfinanc002.php
	  if(isset($inscricao) && !empty($inscricao))
   	    $HTTP_POST_VARS["q02_inscr"] = $inscricao;
          if(isset($matricula) && !empty($matricula))
	    $HTTP_POST_VARS["j01_matric"] = $matricula;
	
	  if(!empty($HTTP_POST_VARS["z01_numcgm"])) {

             ///////// VERIFICA SE O NUMCGM POSSUI INSCRICOES
	     $clsqlinscricoes = new cl_issbase;
	     $sqlinscr = $clsqlinscricoes->sqlinscricoes_nome($HTTP_POST_VARS["z01_numcgm"]);
	     $resultinscr = pg_exec($sqlinscr);
	     if(pg_numrows($resultinscr) != 0){
	       $outrasinscricoes = true;
	     }else{
	       $outrasinscricoes = false;
	     }
             //////////////////////////////////////////////////////

	    $result = pg_exec("select z01_numcgm as k00_numcgm, z01_nome from cgm where z01_numcgm = ".$HTTP_POST_VARS["z01_numcgm"]);
		if(pg_numrows($result) == 0) {
		  db_msgbox("Numcgm inexistente");
		  db_redireciona();
		  exit;
		} else {
		  db_fieldsmemory($result,0);
		  $resultaux = $result;
	      if(!($result = debitos_tipos_numcgm($HTTP_POST_VARS["z01_numcgm"]))) {
            //db_msgbox('Sem d�bitos a pagar');
			$mensagem_semdebitos = true;
			$result = $resultaux;		
			unset($resultaux);
		  }
		  $arg = "numcgm=".$HTTP_POST_VARS["z01_numcgm"];		  
	    }
	  } else if(!empty($HTTP_POST_VARS["z01_numcgm"])) {
 	    $result = pg_exec("select z01_numcgm as k00_numcgm, z01_nome from cgm where z01_numcgm = ".$HTTP_POST_VARS["db_numcgm"]);
		if(pg_numrows($result) == 0) {
		  db_msgbox("Numcgm inexistente");
		  db_redireciona();
		  exit;
		} else {
		  db_fieldsmemory($result,0);
		  $resultaux = $result;
	      if(!($result = debitos_tipos_numcgm($HTTP_POST_VARS["db_numcgm"]))) {
            //db_msgbox('Sem d�bitos a pagar');
			$mensagem_semdebitos = true;
			$result = $resultaux;
			unset($resultaux);
		  }
		  $arg = "numcgm=".$HTTP_POST_VARS["db_numcgm"];
		}
		
	  } else if(!empty($HTTP_POST_VARS["j01_matric"])) {
  	    $result = pg_exec("select j01_matric,j01_numcgm as k00_numcgm 
		               from iptubase 
		               where j01_matric = ".$HTTP_POST_VARS["j01_matric"]);
	    if(pg_numrows($result) == 0) {
	        db_msgbox("Matr�cula inexistente");
	        db_redireciona();
	        exit;
	    } else {
	        $resultaux = $result;
	        if(!($result = debitos_tipos_matricula($HTTP_POST_VARS["j01_matric"]))) {
                   //db_msgbox('Sem d�bitos a pagar');
		   $mensagem_semdebitos = true;
                   $result = $resultaux;
		   unset($resultaux);
		}
		$arg = "matric=".$HTTP_POST_VARS["j01_matric"];
	    }

            ///////// VERIFICA SE A MATR�CULA POSSUI OUTROS PROPRIET�RIOS
            $resultpropri = pg_exec("select * from propri
	                             where j42_matric = ".$HTTP_POST_VARS["j01_matric"]);
	    if(pg_numrows($resultpropri) != 0){
	       $proprietario = true;
	    }else{
	       $proprietario = false;
	    }
	    
	    ///////// VERIFICAD SE A MATR�CULA POSSUI PROMITENTES
	    $resultpromi = pg_exec("select * from promitente
	                            where j41_matric = ".$HTTP_POST_VARS["j01_matric"]);
	    if(pg_numrows($resultpromi) != 0){
	       $promitente = true;
	    }else{
	       $promitente = false;
	    }
	   ///////////////////////////////////////////////////////////


	    $resultprinc = pg_exec("select z01_cgmpri as z01_numcgm, z01_nome from proprietario_nome
	                            where j01_matric = ".$HTTP_POST_VARS["j01_matric"]);
	    db_fieldsmemory($resultprinc,0); 
	   
	  } else if(!empty($HTTP_POST_VARS["q02_inscr"])) {
  	    $result = pg_exec("select q02_inscr, z01_numcgm, z01_nome from issbase inner join cgm on z01_numcgm = q02_numcgm where q02_inscr = ".$HTTP_POST_VARS["q02_inscr"]);
	    if(pg_numrows($result) == 0) {
	       db_msgbox("Inscri��o inexistente");
	       db_redireciona();
	       exit;
	    } else {
	       db_fieldsmemory($result,0);
               $resultaux = $result;
	       if(!($result = debitos_tipos_inscricao($HTTP_POST_VARS["q02_inscr"]))) {
                  //db_msgbox('Sem d�bitos a pagar');
		  $mensagem_semdebitos = true;
                  $result = $resultaux;
		  unset($resultaux);
	       }
	       $arg = "inscr=".$HTTP_POST_VARS["q02_inscr"];
	    }

	  } else if(!empty($HTTP_POST_VARS["k00_numpre"])) {
	       $result = "select k00_numcgm from db_reciboweb
	       	inner join arrenumcgm on k00_numpre = k99_numpre
	        where k99_numpre_n = ".$HTTP_POST_VARS["k00_numpre"] . "limit 1";
	       $result = pg_exec($result);
	       $numcgm = pg_result($result,0);

	       $result = "select distinct k99_numpre, k99_numpar from db_reciboweb
	       	inner join arrenumcgm on k00_numpre = k99_numpre
	        where k99_numpre_n = ".$HTTP_POST_VARS["k00_numpre"];
	       $result = pg_exec($result);
	       if (pg_numrows($result) > 0) {
		  $msg = "<br><br>Recibo avulso dos seguintes numpres: <br>";
		  for ($registroavulso=0;$registroavulso<pg_numrows($result);$registroavulso++) {
		    $msg .= "numpre: " . pg_result($result,$registroavulso,0). " - parcela: " . pg_result($result,$registroavulso,1);
		    if ($registroavulso != (pg_numrows($result) - 1)) {
		      $msg .= ", <br>";
		    }
		    
		  }
//                  db_msgbox('Recibo avulso relativo aos numpres: ' . $msg . '!');
//		  db_redireciona();
                  echo $msg;
		  db_erro("<br><br>Verifique pelos numpres acessando pelo CGM: " . $numcgm);
	       }

	       $result = "select k00_numcgm as z01_numcgm, z01_nome from arrenumcgm inner join cgm on z01_numcgm = k00_numcgm where k00_numpre = ".$HTTP_POST_VARS["k00_numpre"]." limit 1";
	       $result = pg_exec($result);
	       db_fieldsmemory($result,0);
       	       $result = debitos_tipos_numpre($HTTP_POST_VARS["k00_numpre"]) ;
               if($result == false){
		   $sql = "select a.k00_numcgm 
		           from arrecant a
				        left outer join arrepaga p on a.k00_numpre = p.k00_numpre and a.k00_numpar = p.k00_numpar
				   where a.k00_numpre = ".$HTTP_POST_VARS["k00_numpre"]." limit 1";
//				   where p.k00_numpre is null  and a.k00_numpre = ".$HTTP_POST_VARS["k00_numpre"]." limit 1";
		   $result = pg_exec($sql);
		   if(pg_numrows($result)>0){
		     $com_debitos = false;
		   }else{
		     $result = false ;
		   }
		} else {
		  $resultaux = 1;
		}

		if( $result == false ) {
 
		  $mensagem_semdebitos = true;

                  db_msgbox('Sem d�bitos a pagar ou n�o localizado!');
		  db_redireciona();

		  exit;

		}

	    $arg = "numpre=".$HTTP_POST_VARS["k00_numpre"];
	  } else if(!empty($HTTP_POST_VARS["v07_parcel"])) {
	       $Rec = pg_exec("select v07_numpre from termo where v07_parcel = ".$HTTP_POST_VARS["v07_parcel"]);
	       if(pg_numrows($Rec) == 0)
		  db_erro("Erro(175) n�o foi encontrado numpre pelo codigo do parcelamento ".$HTTP_POST_VARS["v07_parcel"]);
	          if(!($result = debitos_tipos_numpre(pg_result($Rec,0,0)))) {
                    db_msgbox('Sem d�bitos a pagar');
		    $mensagem_semdebitos = true;
		    db_redireciona();
		    exit;		
		  }
	        $k00_numpre = pg_result($Rec,0,"v07_numpre");
		$resultaux = 1;
	        $arg = "numpre=".pg_result($Rec,0,0);
		$Parcelamento = $HTTP_POST_VARS["v07_parcel"];		
		pg_freeresult($Rec);
		
	        $resultcgm = "select k00_numcgm as z01_numcgm, z01_nome from arrenumcgm inner join cgm on z01_numcgm = k00_numcgm where k00_numpre = $k00_numpre limit 1";
	        $resultcgm = pg_exec($resultcgm);
	        db_fieldsmemory($resultcgm,0);

	  }
	  $dados = pg_exec("select z01_ender,z01_munic,z01_uf,z01_cgccpf,z01_ident,z01_numero,z01_compl 
	                    from cgm where z01_numcgm = $z01_numcgm");
	  db_fieldsmemory($dados,0);	  

          ////////////////    VERIFICA SE O NUMCGM POSSUI MATR�CULA CADASTRADAS
          $clsqlamatriculas = new cl_iptubase;
          $sqlmatric = $clsqlamatriculas->sqlmatriculas_nome($z01_numcgm);
          $resultmatric = pg_exec($sqlmatric);
          if(pg_numrows($resultmatric) != 0){
	     $outrasmatriculas = true;
	  }else{
	     $outrasmatriculas = false;
	  }
	  
          ////////////////      VERIFICA SE O NUMCGM POSSUI SOCIOS
          $clsqlinscricoes = new cl_issbase;
          $sqlsocios = $clsqlinscricoes->sqlinscricoes_socios(0,$z01_numcgm,"cgmsocio.z01_nome");
	  $resultsocios = pg_exec($sqlsocios);

	  if(pg_numrows($resultsocios) != 0){
	      $socios = true;
	  }else{
	      $socios = false;
	  }
          ///////////////////////////////////////////////////////////////////	    
	  
	?>
        <table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr> 
            <td colspan="2"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td width="33%"> <table width="104%" border="0" cellspacing="0" cellpadding="0">
                      <tr> 
                        <td nowrap title="Clique Aqui para ver os dados cadastrais." class="tabcols"><strong style=\"color:blue\><a href='' onclick='js_mostracgm();return false;'>CGM:&nbsp;</a></strong></td>
                        <td class="tabcols" nowrap title="Clique Aqui para ver os dados cadastrais."> 
                          <input class="btcols" type="text" name="z01_numcgm" value="<?=@$z01_numcgm?>" size="5" readonly> 
                          &nbsp;&nbsp;&nbsp; 
                          <?
					  parse_str($arg);
					  if(isset($matric))
					    $Label = "<a href='' onclick='js_mostrabic_matricula();return false;'>Matr�cula:</a>";
					  else if(isset($inscr))
					    $Label = "<a href='' onclick='js_mostrabic_inscricao();return false;'>Inscri��o:</a>";
					  else if(isset($numpre))
					    $Label = "Numpre:";
					  else if(isset($Parcelamento))
					    $Label = "Parcelamento:";
					  if(isset($Label))
					  echo "<strong style=\"color:blue\">$Label</strong> <input style=\"border: 1px solid blue;font-weight: bold;background-color:#80E6FF\" class=\"btcols\" type=\"text\" name=\"Label\" value=\"".@$matric.@$inscr.@$numpre.@$Parcelamento."\" size=\"10\" readonly>\n";
					  ?>
                        </td>
                      </tr>
                      <tr> 
                        <td nowrap class="tabcols"><strong>Nome:</strong></td>
                        <td nowrap><input class="btcols" type="text" name="z01_nome" value="<?=@$z01_nome?>" size="46" readonly> 
                          &nbsp;</td>
                      </tr>
                      <tr> 
                        <td nowrap class="tabcols"><strong>Endere�o:</strong></td>
                        <td nowrap><input class="btcols" type="text" name="z01_ender" value="<?=@$z01_ender.($z01_numero!=""?", ":"").$z01_numero.($z01_compl!=""?"/":"").$z01_compl?>" size="46" readonly> 
                        </td>
                      </tr>
                      <tr> 
                        <td nowrap class="tabcols"><strong>Munic�pio:</strong></td>
                        <td><input class="btcols" type="text" name="z01_munic" value="<?=@$z01_munic?>" size="20" readonly> 
                          <strong class="tabcols">UF:</strong> <input class="btcols" type="text" name="z01_uf" value="<?=@$z01_uf?>" size="2" maxlength="2" readonly=""> 
                          &nbsp;</td>
                      </tr>
                      <form name="formatu" action="cai3_gerfinanc001.php" method="post">
                        <tr> 
                          <td height="21" colspan="2" nowrap class="tabcols"> 
                            <?
						if(isset($HTTP_POST_VARS["j01_matric"]) && !empty($HTTP_POST_VARS["j01_matric"]))
                           echo "<input type=\"hidden\" name=\"j01_matric\"  value=\"".$HTTP_POST_VARS["j01_matric"]."\">";
						if(isset($HTTP_POST_VARS["q02_inscr"]) && !empty($HTTP_POST_VARS["q02_inscr"]))
                           echo "<input type=\"hidden\" name=\"q02_inscr\"  value=\"".$HTTP_POST_VARS["q02_inscr"]."\">";
						if(isset($HTTP_POST_VARS["z01_numcgm"]) && !empty($HTTP_POST_VARS["z01_numcgm"]))
                           echo "<input type=\"hidden\" name=\"z01_numcgm\"  value=\"".$HTTP_POST_VARS["z01_numcgm"]."\">";
						if(isset($HTTP_POST_VARS["v07_parcel"]) && !empty($HTTP_POST_VARS["v07_parcel"]))
                           echo "<input type=\"hidden\" name=\"v07_parcel\"  value=\"".$HTTP_POST_VARS["v07_parcel"]."\">";
						if(isset($HTTP_POST_VARS["k00_numpre"]) && !empty($HTTP_POST_VARS["k00_numpre"]))
                           echo "<input type=\"hidden\" name=\"k00_numpre\"  value=\"".$HTTP_POST_VARS["k00_numpre"]."\">";
						?>
                            &nbsp; 
                            <input name="retornar" type="button" id="retornar" value="Nova Pesquisa" title="Inicio da Consulta" onclick="location.href='cai3_gerfinanc001.php'"> 
                            &nbsp;&nbsp; <input name="pesquisar" type="submit" id="pesquisar"  title="Atualiza a Consulta" value="Atualizar">	
                            &nbsp;&nbsp; <input name="voltar" type="button" id="voltar" value="<<" title="Retorna" onclick="debitos.history.back()"> 
                            &nbsp;&nbsp; <input name="avanca" type="button" id="avanca" value=">>" title="Avan�a" onclick="debitos.history.forward()"> 
		  
		  
		  <?
		  //este select � pra ver se o cgm esta no ruas e tb tem CPF/CNPJ para deixar preenchido o responsavel pelo parcelamento
		  $re_cgm = pg_query("select * from cgm c left join db_cgmruas r on r.z01_numcgm = c.z01_numcgm where c.z01_numcgm = $z01_numcgm and trim(c.z01_cgccpf) <> ''");
		  if(pg_numrows($re_cgm) > 0){
		    $id_resp_parc = $z01_numcgm;
		    $resp_parc = $z01_nome;
		  }
		  ?>
		  
		  <input name="id_resp_parc"  id="id_resp_parc" type="hidden" value="<?=@$id_resp_parc?>"><!--este dois inputs guardam o respons�vel pelo parcelamento
		  para q qdo ele escolha outra divida para parcelar ele traga automaticamento o ultimo nome que foi preenchido-->
		  <input name="resp_parc"  id="resp_parc" type="hidden" value="<?=@$resp_parc?>">
                          </td>
                      </form>
                    </table></td>
                  <td width="67%" valign="top"> 
                    <?
		    $numrows = pg_numrows($result);
			   echo "<script>
			   function js_envia(chave){
			     debitos.location.href=chave+document.form1.k00_dtoper_ano.value+'-'+document.form1.k00_dtoper_mes.value+'-'+document.form1.k00_dtoper_dia.value;		        
			   }
			   </script>
				  ";
            echo "<table border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\n<tr class=\"links\">\n<td valign=\"top\" style=\"font-size:11px\"><form name=\"form2\" method=\"post\" target=\"debitos\">\n";
	  	    if(isset($resultaux)) {
		      for($i = 0;$i < $numrows;$i++) {
//+document.form1.k00_dtoper_ano.value+'-'+document.form1.k00_dtoper_mes.value+'-'+document.form1.k00_dtoper_dia.value)		        
                         if(pg_result($result,$i,"k00_tipo")=='34'){
			   $nome_arquivo='cai3_gerfinanc050.php';  
			 }else if(pg_result($result,$i,"k00_tipo")=='19'){
			   $nome_arquivo='cai3_gerfinanc040.php';  
			 }else{
			   $nome_arquivo='cai3_gerfinanc002.php';  
			 }
               echo "
				<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
				    <td valign=\"center\" class=\"links\" id=\"tipodeb$i\">
				      <a title=\"".pg_result($result,$i,"k00_tipo")."\" class=\"links\" href=\"\" id=\"tipodeb$i\" onClick=\"js_MudaLink('tipodeb$i');js_envia('$nome_arquivo?".$arg."&tipo=".pg_result($result,$i,"k00_tipo")."&emrec=".pg_result($result,$i,"k00_emrec")."&agnum=".pg_result($result,$i,"k00_agnum")."&agpar=".pg_result($result,$i,"k00_agpar")."&db_datausu=');return false;\" target=\"debitos\">".pg_result($result,$i,"k00_descr")."&nbsp;</a>
				    </td>
				  </tr>
				</table>\n";
			    if($i == 8)
			      echo "</td><td style=\"font-size:11px\" valign=\"top\">\n";
		      }
			}


			
		    // notificao fiscal
			echo "</td><td style=\"font-size:11px\" valign=\"top\">\n";
			$tipo_pesq = split("=",$arg);
 			
			
			
			/* eu "DENIS" comentei essas linhas para naum dar pau na consulta, pq eu estou fazendo
			o m�dulo fiscal ainda, qdo estiver pronto a gente tira daqui e arruma
			$sql = "select fiscal.*,y13_notifi
		                from fiscal
			 	     left outer join auto on y01_notifi = y13_notifi
			        where y01_dtanul is null and y13_notifi is null ";
			if($tipo_pesq[0] == "numcgm"){
			  $sql = $sql . " and y01_numcgm = ".$tipo_pesq[1];
			}else if($tipo_pesq[0] == "matric"){
			  $sql = $sql . " and y01_matric = ".$tipo_pesq[1];
			}else if($tipo_pesq[0] == "inscr"){
			  $sql = $sql . " and y01_inscr = ".$tipo_pesq[1];
			}
	        $dados = pg_exec($sql);
            if(pg_numrows($dados)>0){
		      echo "
			  	 <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
				    <td valign=\"top\" class=\"links2\" id=\"tiposemdeb1\">
			          <a class=\"links2\" onClick=\"js_MudaLink('tiposemdeb1')\" id=\"tiposemdeb1\" href=\"cai3_gerfinanc015.php?\" target=\"debitos\">NOTIFICA��ES LAN�ADAS</a>
                    </td>
				 </tr>
				 </table>\n";
		    }
			if($tipo_pesq[0] == "numcgm" || $tipo_pesq[0] == "inscr"){
  		      $sql    = "select levanta.*
		                 from levanta
				   	     where y06_dtanul is null ";
			  if($tipo_pesq[0] == "numcgm"){
			    $sql = $sql . " and y06_numcgm = ".$tipo_pesq[1];
			  }else if($tipo_pesq[0] == "inscr"){
			    $sql = $sql . " and y06_inscr = ".$tipo_pesq[1];
			  }
	          $dados = pg_exec($sql);
              if(pg_numrows($dados)>0){
		        echo "
			  	 <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
				    <td valign=\"top\" class=\"links2\" id=\"tiposemdeb2\">
				      <a class=\"links2\" onClick=\"js_MudaLink('tiposemdeb2')\" id=\"tiposemdeb2\"  href=\"cai4_gerfinanc006.php?\" target=\"debitos\">LEVANTAMENTO FISCAL</a>
					</td> 
				  </tr>
				 </table>\n";




		      }
			}*/
                        if($tipo_pesq[0] != "numpre" ){ 
	
			$sql_c = "select k00_dtvenc 
			        from arrenumcgm
				inner join arrecad 	on arrecad.k00_numpre = arrenumcgm.k00_numpre
				inner join arretipo 	on arretipo.k00_tipo = arrecad.k00_tipo
				inner join cadtipo  	on arretipo.k03_tipo = cadtipo.k03_tipo
				and k03_parcano = 'f'
				";
			if($tipo_pesq[0] == "numcgm"){
			  $sql_c = $sql_c . " where arrenumcgm.k00_numcgm = ".$tipo_pesq[1];
			}else if($tipo_pesq[0] == "matric"){
			  $sql_c = $sql_c . "   inner join arrematric on arrematric.k00_numpre = arrecad.k00_numpre
			                 where k00_matric = ".$tipo_pesq[1];
			}else if($tipo_pesq[0] == "inscr"){
			  $sql_c = $sql_c . "   inner join arreinscr on arreinscr.k00_numpre = arrecad.k00_numpre
			                 where k00_inscr = ".$tipo_pesq[1];
			}else{
			   $sql_c = $sql_c . " where arrecad.k00_numpre = ".$tipo_pesq[1];
			}
			$sql = $sql_c . " and k00_dtvenc < '".date("Y-m-d",db_getsession("DB_datausu"))."'";
			$sql = $sql . " limit 1 ";
			echo $sql;exit;
	        $dados = pg_exec($sql);
            if(pg_numrows($dados)>0){
		      echo "
  			  	 <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
				    <td valign=\"top\" class=\"links2\" id=\"tiposemdeb3\">
			          <a class=\"links2\" onClick=\"js_MudaLink('tiposemdeb3')\" id=\"tiposemdeb3\"  href=\"cai3_gerfinanc006.php?".base64_encode("tipo_cert=1&".$arg)."\" target=\"debitos\">CERTID�O POSITIVA</a>
                    </td>
				  </tr>
				 </table>\n";
            }else{

			$sql_c = "select k00_dtvenc 
			        from arrenumcgm
				inner join arrecad 	on arrecad.k00_numpre = arrenumcgm.k00_numpre
				inner join arretipo 	on arretipo.k00_tipo = arrecad.k00_tipo
				inner join cadtipo  	on arretipo.k03_tipo = cadtipo.k03_tipo
				and k03_parcelamento = 't'
				";
			if($tipo_pesq[0] == "numcgm"){
			  $sql_c = $sql_c . " where arrenumcgm.k00_numcgm = ".$tipo_pesq[1];
			}else if($tipo_pesq[0] == "matric"){
			  $sql_c = $sql_c . "   inner join arrematric on arrematric.k00_numpre = arrecad.k00_numpre
			                 where k00_matric = ".$tipo_pesq[1];
			}else if($tipo_pesq[0] == "inscr"){
			  $sql_c = $sql_c . "   inner join arreinscr on arreinscr.k00_numpre = arrecad.k00_numpre
			                 where k00_inscr = ".$tipo_pesq[1];
			}else{
			   $sql_c = $sql_c . " where arrecad.k00_numpre = ".$tipo_pesq[1];
			}
	
			  $sql = $sql_c . " limit 1 ";
//			  echo $sql;
	          $dados = pg_exec($sql);
              if(pg_numrows($dados)>0){
  		        echo "
		  	    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
				    <td valign=\"top\" class=\"links2\" id=\"tiposemdeb4\">
				      <a class=\"links2\" onClick=\"js_MudaLink('tiposemdeb4')\" id=\"tiposemdeb4\"  href=\"cai3_gerfinanc006.php?".base64_encode("tipo_cert=0&".$arg)."\" target=\"debitos\">CERTID�O REGULAR</a>
                    </td>
				  </tr>
				</table>\n";					  
			  }else{
		        echo "
		     	 <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
				    <td valign=\"top\" class=\"links2\" id=\"tiposemdeb5\">
				      <a class=\"links2\" onClick=\"js_MudaLink('tiposemdeb5')\" id=\"tiposemdeb5\"  href=\"cai3_gerfinanc006.php?".base64_encode("tipo_cert=2&".$arg)."\" target=\"debitos\">CERTID�O NEGATIVA</a>
                    </td>
				  </tr>
				</table>\n";					  
		      }
			}



                    if (@$outrasmatriculas == true ){
                        echo "
			    <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
			      <tr>
			         <td valign=\"top\" class=\"links2\" id=\"outrasmatriculas\">
			            <a class=\"links2\" onClick=\"js_MudaLink('outrasmatr�culas')\" id=\"outrasmatriculas\"  href=\"cai3_gerfinanc018.php?opcao=matricula&numcgm=".$z01_numcgm."\" target=\"debitos\">MATR�CULAS CADASTRADAS</a>
				 </td>
			      </tr>
			    </table>\n";
		     }
		    if (@$outrasinscricoes == true ){
		        echo "
		            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		              <tr>
		                 <td valign=\"top\" class=\"links2\" id=\"outrasinscricoes\">
		                    <a class=\"links2\" onClick=\"js_MudaLink('outrasinscricoes')\" id=\"outrasinscricoes\"  href=\"cai3_gerfinanc018.php?opcao=inscricao&numcgm=".$z01_numcgm."&inscricao=".@$tipo_pesq[1]."\" target=\"debitos\">INSCRI��ES CADASTRADAS</a>
                                 </td>
                              </tr>
                            </table>\n";
                     }
                    if (@$proprietario == true ){
                        echo "
                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                              <tr>
                                 <td valign=\"top\" class=\"links2\" id=\"proprietarios\">
                                    <a class=\"links2\" onClick=\"js_MudaLink('proprietarios')\" id=\"proprietarios\"  href=\"cai3_gerfinanc018.php?opcao=proprietario&matricula=".$tipo_pesq[1]."\" target=\"debitos\">OUTROS PROPRIET�RIOS</a>
                                 </td>
                              </tr>
                            </table>\n";
                     }
                    if (@$socios == true ){
		        echo "
                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                              <tr>
                                 <td valign=\"top\" class=\"links2\" id=\"socios\">
                                    <a class=\"links2\" onClick=\"js_MudaLink('socios')\" id=\"socios\"  href=\"cai3_gerfinanc018.php?opcao=socios&numcgm=$z01_numcgm\" target=\"debitos\">S�CIOS</a>
                                 </td>
                              </tr>
                            </table>\n";
                     }
                    if (@$promitente == true ){
                        echo "
                            <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
                              <tr>
                                 <td valign=\"top\" class=\"links2\" id=\"promitentes\">
                                    <a class=\"links2\" onClick=\"js_MudaLink('promitentes')\" id=\"promitentes\"  href=\"cai3_gerfinanc018.php?opcao=promitente&matricula=".$tipo_pesq[1]."\" target=\"debitos\">PROMITENTES</a>
                                 </td>
                              </tr>
                            </table>\n";
                     }
                        // pesquisa pagamentos
          }

                        $sql = " select arrepaga.k00_numpre 
			        from arrepaga ";
			if($tipo_pesq[0] == "numcgm"){
                          $sql = $sql . " inner join arrenumcgm on arrepaga.k00_numpre = arrenumcgm.k00_numpre
                                         where arrenumcgm.k00_numcgm = ".$tipo_pesq[1];
                        }else if($tipo_pesq[0] == "matric"){
			  $sql = $sql . "   inner join arrematric on arrematric.k00_numpre = arrepaga.k00_numpre
			                 where k00_matric = ".$tipo_pesq[1];
			}else if($tipo_pesq[0] == "inscr"){
			  $sql = $sql . "   inner join arreinscr on arreinscr.k00_numpre = arrepaga.k00_numpre
			                 where k00_inscr = ".$tipo_pesq[1];
			}else{
			   $sql = $sql . " where k00_numpre = ".$tipo_pesq[1];
			}
			$sql = $sql . " limit 1";
//echo $sql;
            $dados = pg_exec($sql);
            if(pg_numrows($dados)>0){
                      echo "
                                 <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
		                  <tr>
		                    <td valign=\"top\" class=\"links2\" id=\"tiposemdeb6\">
		                     <a class=\"links2\" onClick=\"js_MudaLink('tiposemdeb6')\" id=\"tiposemdeb6\"  href=\"cai3_gerfinanc008.php?".base64_encode("tipo_cert=1&".$arg)."\" target=\"debitos\">PAGAMENTOS EFETUADOS</a>
				    </td>
                                  </tr>
                                 </table>\n";
                        }

                                                // pesquisa descontos efetuados
                        $sql = " select p.k00_numpre
                                from arrecant 
                                    left outer join arrepaga p on p.k00_numpre = arrecant.k00_numpre and p.k00_numpar = arrecant.k00_numpar ";
                        if($tipo_pesq[0] == "numcgm"){
                         $sql = "  select p.k00_numpre
                                   from arrenumcgm 
                                        inner join arrecant on arrecant.k00_numpre = arrenumcgm.k00_numpre
                                        left outer join arrepaga p on p.k00_numpre = arrecant.k00_numpre and p.k00_numpar = arrecant.k00_numpar 
			           where arrenumcgm.k00_numcgm = ".$tipo_pesq[1];
                        }else if($tipo_pesq[0] == "matric"){
                          $sql = " select p.k00_numpre
                                   from arrematric 
                                        inner join arrecant on arrecant.k00_numpre = arrematric.k00_numpre
                                        left outer join arrepaga p on p.k00_numpre = arrecant.k00_numpre and p.k00_numpar = arrecant.k00_numpar 
                                    where k00_matric = ".$tipo_pesq[1];
                        }else if($tipo_pesq[0] == "inscr"){
                          $sql = " select p.k00_numpre
                                   from arreinscr 
                                        inner join arrecant on arrecant.k00_numpre = arreinscr.k00_numpre
                                        left outer join arrepaga p on p.k00_numpre = arrecant.k00_numpre and p.k00_numpar = arrecant.k00_numpar 
                                   where k00_inscr = ".$tipo_pesq[1];
                        }else{
                           $sql = $sql . " where arrecant.k00_numpre = ".$tipo_pesq[1];
                        }
                        $sql = $sql . " and p.k00_numpre is null limit 1";
//echo $sql;
$dados = pg_exec($sql);

            if(pg_numrows($dados)>0){
		      echo "
  			  	 <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
				    <td valign=\"top\" class=\"links2\" id=\"tipodesconto7\">
		   	              <a class=\"links2\" onClick=\"js_MudaLink('tipodesconto7')\" id=\"tipodesconto7\"  href=\"cai3_gerfinanc016.php?".base64_encode("tipo_cert=1&".$arg)."\" target=\"debitos\">CANCEL. EFETUADOS</a>
                                    </td>
				  </tr>
				 </table>\n";					  
			}
		    echo "</td>\n</tr>\n</table>\n";

			if($mensagem_semdebitos==false and $com_debitos==true){
		      echo "
  			  	 <table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
				  <tr>
				    <td valign=\"top\" class=\"links2\" id=\"tiposemdebitototal\">
			              <a class=\"links\" href=\"\" onClick=\"js_MudaLink('tiposemdebitototal');js_envia('cai3_gerfinanc010.php?".$arg."&db_datausu=');return false;\" id=\"tiposemdebitototal\"  target=\"debitos\">TOTAL DE D�BITOS</a>
                                    </td>
				  </tr>
				 </table>\n";					  
            }
		  ?>
                  </td>
                </tr>
			      <td height="2"></form> 
</table>
              </td>
          </tr>
          <tr> 
            <td colspan="2" align="center" valign="middle"> <table border="0" cellspacing="0" cellpadding="0">
                <tr> 
                  <td> 
                    <!--iframe height="205" width="755" name="debitos" src="cai3_gerfinanc002.php?matricula=<?=@$matricula?>&inscricao=<?=$inscricao?>&tipo2=<?=@$tipo2?>"></iframe-->
                    <iframe id="debitos" height="235" width="755" name="debitos" src="cai3_gerfinanc007.php?<?=$arg?>"></iframe> 
                  </td>
                </tr>
                <tr> 
                  <td align="right"> <table border="1" bordercolor="#000000" cellspacing="0" cellpadding="0" width="100%">
                      <tr bgcolor="#666666"> 
                        <th style="font-size:11px">Valor</th>
                        <th style="font-size:11px">Valor Corr.</th>
                        <th style="font-size:11px">Juros</th>
                        <th style="font-size:11px">Multa</th>
                        <th style="font-size:11px">Desconto</th>
                        <th style="font-size:11px">Total</th>
                      </tr>
                      <tr> 
                        <td class="tabcols1"><font id="valor1">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="valorcorr1">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="juros1">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="multa1">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="desconto1">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="total1">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                      </tr>
                      <tr> 
                        <td class="tabcols1"><font id="valor2">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="valorcorr2">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="juros2">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="multa2">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="desconto2">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="total2">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                      </tr>
                      <tr> 
                        <td class="tabcols1"><font id="valor3">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="valorcorr3">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="juros3">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="multa3">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="desconto3">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                        <td class="tabcols1"><font id="total3">0.00</font><img src="imagens/alinha.gif" border="0" width="5"></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td height="24"> 
              <input type="button" name="btmarca" id="btmarca" value="Marcar" onClick="debitos.js_marca()"> 
              <input type="button" name="enviar" id="enviar" value="Recibo" onClick="return js_emiterecibo()" disabled> 
              <input type="button" name="relatorio" id="relatorio" value="Relatorio" onClick="js_relatorio()" disabled> 
              <input type="button" id="btcarne" name="btcarne" onClick="js_emitecarne(true)" value="Carne Banco" disabled>
              <input type="button" id="btcarnep" name="btcarnep" onClick="js_emitecarne(false)" value="Carne Pref." disabled> 
              <input type="button" name="btparc" id="btparc" value="Parcelamento" onClick="js_parc()" disabled> 
              <input type="button" name="btcda" id="btcda" value="Certid�o" onClick="js_certidao()" disabled> 
              <input type="button" id="btnotifica" name="btnotifica" onClick="js_emitenotificacao(false)" value="Notifica��o" disabled style='visibility:hidden'> 
            </td>
	    <script>
	    function js_parc(){
	      numpre = "";
	      deb = debitos.document.form1
	      nump = "";
	      x = 0;
	      for(i=0;i<deb.length;i++) {
	        if (deb.k03_parcelamento.value == 't') {
		  if (deb.elements[i].type == "checkbox") {
		    if (deb.elements[i].checked == true) {
		      numpre = deb.elements[i].value.split("N");
		      numpre = numpre[0].split("P")
		      if(nump == ""){
			nump = numpre[0];
		      }else{
		        if(numpre[0] != nump){
		          alert('Voc� deve reparcelar um parcelamento de cada vez!')
		          x = 1;
			  break;
			}
		        nump = numpre[0]
		      }
		    }
		  }
		}
              }
	      if(x == 0){
		debitos.document.form1.action = 'cai3_gerfinanc062.php?valor='+document.getElementById('total2').innerHTML;
		debitos.document.form1.target = '_self';
		debitos.document.form1.submit();
	      }
	    }
	    function js_certidao(){
	      deb = debitos.document.form1
	      debitos.document.form1.action = 'cai3_gerfinanc064.php?valor='+document.getElementById('total2').innerHTML;
	      debitos.document.form1.target = '_self';
	      debitos.document.form1.submit();
	    }
	    </script>
			<form name="form1" method="post">
            <td nowrap title="Data para c�lculo dos acr�scimos no sistema"> <strong>Data 
              Pagamento:</strong> 
              <?
			//
			$k00_dtoper = date('Y-m-d',db_getsession("DB_datausu"));
			$k00_dtoper_dia = date('d',db_getsession("DB_datausu"));
			$k00_dtoper_mes = date('m',db_getsession("DB_datausu"));
			$k00_dtoper_ano = date('Y',db_getsession("DB_datausu"));
			//
			$Ik00_dtoper = '9';
			db_inputdata('k00_dtoper',$k00_dtoper_dia,$k00_dtoper_mes,$k00_dtoper_ano,true,'text',4);
			?>
            </td>
			</form>
          </tr>
        </table>
    <?
	} else {
	?>
    <form name="form1" method="post">
<br><br>	
          <table border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td height="25" title="<?=$Tz01_nome?>"> 
                <?
				db_ancora($Lz01_nome,'js_mostranomes(true);',4)
				?>
              </td>
              <td height="25"> 
                <?
				db_input("z01_numcgm",6,$Iz01_numcgm,true,'text',4," onchange='js_mostranomes(false);'")
				?>
                <?
				db_input("z01_nome",40,$Iz01_nome,true,'text',5)
				?>
              </td>
            </tr>
            <tr> 
              <td height="25" title="<?=$Tj01_matric?>"> 
                <?
				db_ancora($Lj01_matric,'js_mostramatricula(true);',2)
				?>
              </td>
              <td height="25"> 
                <?
				db_input("j01_matric",8,$Ij01_matric,true,'text',4)
				?>
              </td>
            </tr>
            <tr> 
              <td height="25" title="<?=$Tq02_inscr?>"> 
                <?
				db_ancora($Lq02_inscr,'js_mostrainscricao(true);',4)
				?>
              </td>
              <td height="25"> 
                <?
				db_input("q02_inscr",8,$Iq02_inscr,true,'text',4)
				?>
              </td>
            </tr>
            <tr> 
              <td height="25" title="<?=$Tk00_numpre?>"> 
                <?
				db_ancora($Lk00_numpre,'js_mostranumpre(true);',3)
				?>
              </td>
              <td height="25"> 
                <?
				db_input("k00_numpre",8,$Ik00_numpre,true,'text',4)
				?>
              </td>
            </tr>
            <tr> 
              <td height="25" title="<?=$Tv07_parcel?>"> 
                <?
				db_ancora($Lv07_parcel,'js_mostraparcel(true);',3)
				?>
              </td>
              <td height="25"> 
                <?
				db_input("v07_parcel",8,$Iv07_parcel,true,'text',4)
				?>
              </td>
            </tr>
            <tr> 
              <td height="25">&nbsp;</td>
              <td height="25"><input onClick="if((this.form.v07_parcel.value=='' && this.form.z01_numcgm.value=='' && this.form.j01_matric.value=='' && this.form.q02_inscr.value=='' && this.form.k00_numpre.value=='')) { alert('Informe numcgm, matricula, inscri��o, parcelamento ou numpre!');return false; }"  type="submit" value="Pesquisar" name="pesquisar"></td>
            </tr>
          </table>
        </form>
    <?
	}
	?>
  </center>
</td></tr>
</table>
<? 
 db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
// mostra os dados do cgm do contribuinte
function js_mostracgm(){
  func_nome.jan.location.href = 'prot3_conscgm002.php?fechar=func_nome&numcgm=<?=@$z01_numcgm?>';
  func_nome.mostraMsg();
  func_nome.show();
  func_nome.focus();
}


// esta funcao � utilizada quando clicar na matricula ap�s pesquisar
// a mesma
function js_mostrabic_matricula(){
  func_nome.jan.location.href = 'cad3_conscadastro_002.php?cod_matricula=<?=@$matric?>';
  func_nome.mostraMsg();
  func_nome.show();
  func_nome.focus();
}
// esta funcao � utilizada quando clicar na inscricao ap�s pesquisar
// a mesma
function js_mostrabic_inscricao(){
  func_nome.jan.location.href = 'iss3_consinscr003.php?numeroDaInscricao=<?=@$inscr?>';
  func_nome.mostraMsg();
  func_nome.show();
  func_nome.focus();
}


function js_mostranomes(mostra){
  if(mostra==true){
    func_nome.jan.location.href = 'func_nome.php?funcao_js=parent.js_preenche|0|1';
    func_nome.mostraMsg();
    func_nome.show();
    func_nome.focus();
  }else{
    func_nome.jan.location.href = 'func_nome.php?pesquisa_chave='+document.form1.z01_numcgm.value+'&funcao_js=parent.js_preenche1';	
  }
}
 function js_preenche(chave,chave1){
   document.form1.z01_numcgm.value = chave;
   document.form1.z01_nome.value = chave1;
   func_nome.hide();
 }
 function js_preenche1(chave,chave1){
   document.form1.z01_nome.value = chave;
   if(chave1==true){
      document.form1.z01_numcgm.value = "";
      document.form1.z01_numcgm.focus();
   }
}


function js_mostramatricula(mostra){
  if(mostra==true){
    func_nome.jan.location.href = 'func_iptubase.php?funcao_js=parent.js_preenchematricula|0|1';
    func_nome.mostraMsg();
    func_nome.show();
    func_nome.focus();
  }else{
    func_nome.jan.location.href = 'func_iptubase.php?pesquisa_chave='+document.form1.j01_matric.value+'&funcao_js=parent.js_preenchematricula';	
  }
}
 function js_preenchematricula(chave,chave1){
   document.form1.j01_matric.value = chave;
   document.form1.z01_nome.value = chave1;
   func_nome.hide();
 }
function js_mostrainscricao(mostra){
  if(mostra==true){
    func_nome.jan.location.href = 'func_issbase.php?funcao_js=parent.js_preencheinscricao|0|1';
    func_nome.mostraMsg();
    func_nome.show();
    func_nome.focus();
  }else{
    func_nome.jan.location.href = 'func_issbase.php?pesquisa_chave='+document.form1.q02_inscr.value+'&funcao_js=parent.js_preencheinscricao';	
  }
}
 function js_preencheinscricao(chave,chave1){
   document.form1.q02_inscr.value = chave;
   document.form1.z01_nome.value = chave1;
   func_nome.hide();
 }
 
  if(document.form1.z01_numcgm)
    document.form1.z01_numcgm.focus();
	<?
	if($mensagem_semdebitos == true){
	  echo "alert('Sem d�bitos a Pagar')";
	}
	?>
	
//document.getElementById('outrasopcoes').disabled = true;


function js_mostradetalhes(chave){
  func_nome.jan.location.href = chave;
  func_nome.mostraMsg();
  func_nome.show();
  func_nome.focus();
}

</script>

<?

$func_nome = new janela('func_nome','');
$func_nome ->posX=1;
$func_nome ->posY=20;
$func_nome ->largura=780;
$func_nome ->altura=430;
$func_nome ->titulo="Pesquisa";
$func_nome ->iniciarVisivel = false;
$func_nome ->mostrar();

$fnome = new janela('fnome','');
$fnome ->posX=20;
$fnome ->posY=20;
$fnome ->largura=770;
$fnome ->altura=430;
$fnome ->titulo="Pesquisa";
$fnome ->iniciarVisivel = false;
$fnome ->mostrar();

?>

