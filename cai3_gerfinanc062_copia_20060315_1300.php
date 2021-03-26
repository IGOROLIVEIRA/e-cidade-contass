<?
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
require("libs/db_sql.php");
require("classes/db_termo_classe.php");
require("classes/db_cgm_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);

$clcgm = new cl_cgm;
if(isset($ver_matric) or isset($ver_inscr) or (isset($ver_numcgm))){
  $vt = $HTTP_POST_VARS;
  $tam = sizeof($vt);
  $virgula = "";
  $numpar1 = "";
  $numpre1 = "";
  for($i = 0;$i < $tam;$i++) {
    if(db_indexOf(key($vt),"CHECK") > 0){
      $numpres = $vt[key($vt)];
      $mat = split("N",$numpres);
      for($j = 0;$j < count($mat);$j++) {
        $numpre = split("P",$mat[$j]);
        $numpar = split("P",strstr($mat[$j],"P"));
        if(!isset($inicial)){
          $numpar = $numpar[1];
	}
        $numpre = $numpre[0];
        $numpar1 .= $virgula.$numpar;
        $numpre1 .= $virgula.$numpre;
        $virgula = ",";
      }
    }
  next($vt);
  }

  $tam = sizeof($vt);
  reset($vt);
  $numpres = "";
  for($i = 0;$i < $tam;$i++) {
    if(db_indexOf(key($vt) ,"CHECK") > 0){
      $numpres .= "N".$vt[key($vt)];
    }
    next($vt);
  }
  $numpres = split("N",$numpres);
  $totalregistrospassados=0;
  for($i = 0;$i < sizeof($numpres);$i++) {
    $valores = split("P",$numpres[$i]);
    $totalregistrospassados+=sizeof($valores)-1;
//     echo "$i - " . $numpres[$i] . "<br>";
  }


  $cadtipoparc = 0;

  $sqltipoparc = "select      *
			      from tipoparc
			      inner join cadtipoparc
			      on cadtipoparc = k40_codigo
			      where maxparc > 1 and '"
			      . date("Y-m-d",db_getsession("DB_datausu")) . "' >= k40_dtini and
			      '" . date("Y-m-d",db_getsession("DB_datausu")) . "' <= k40_dtfim order by maxparc";
  $resulttipoparc = pg_exec($sqltipoparc);
  if (pg_numrows($resulttipoparc) > 0) {
    db_fieldsmemory($resulttipoparc,0);
  } else {
    $k40_todasmarc = false;
  }


  $sqltipoparcdeb = "select * from cadtipoparcdeb limit 1";
  $resulttipoparcdeb = pg_exec($sqltipoparcdeb);
  $passar = false;

  if(isset($inicial) && $inicial != "") {
    $k03_tipo = 18;
    $totalregistrospassados = $totregistros;
  }

  if (pg_numrows($resulttipoparcdeb) == 0) {
    $passar = true;
  } else {
    $sqltipoparcdeb = "select * from cadtipoparcdeb where k41_cadtipoparc = $cadtipoparc and k41_arretipo = $k03_tipo";
    $resulttipoparcdeb = pg_exec($sqltipoparcdeb);
    if (pg_numrows($resulttipoparcdeb) > 0) {
      $passar = true;
    }
  }



//    echo("totalregistrospassados: $totalregistrospassados<br>");
//    echo("totregistros: $totregistros<br>");
//    echo("quantidade registros resulttipoparc: " . pg_numrows($resulttipoparc) . "<br>");
//    exit;



  if (pg_numrows($resulttipoparc) == 0 or ($k40_todasmarc == 't'?$totalregistrospassados <> $totregistros:false) or $passar == false) {
    $desconto = 0;
  } else {
    $desconto = 1;
  }

//  die("desconto: $desconto\n");

  $tiposparc = "";

  for ( $parcelas=0; $parcelas < pg_numrows($resulttipoparc); $parcelas++ ) {
    db_fieldsmemory($resulttipoparc,$parcelas,true);
    if ($desconto == 0) {
      $descmul = 0;
      $descjur = 0;
    }
    $tiposparc .= $tipoparc . "=" . $maxparc . "=" . $descmul . "=" . $descjur . ($parcelas == (pg_numrows($resulttipoparc) -1)?"":"-");
  }

  if ($tiposparc == "") {
    db_msgbox("Nao existem regras para parcelamento cadastrados na faixa da data atual! Contate suporte!");
    exit;
  }

}

if(isset($inicial) && $inicial != ""){
   $numpre = $numpre1;
   $sql="select v59_numpre,k00_numpar
		  from inicialnumpre
		  inner join arrecad on v59_numpre = k00_numpre
		  where v59_inicial in ($numpre)
  ";
   $result = pg_query($sql);
   $numrows= pg_numrows($result);
   $virgula = "";
   $numpar1 = "";
   $numpre1 = "";
   $k03_tipo = 18;
   for($j = 0;$j < $numrows;$j++) {
     db_fieldsmemory($result,$j);
     $numpar1 .= $virgula.$k00_numpar;
     $numpre1 .= $virgula.$v59_numpre;
     $virgula = ",";
   }
}

?>

<script>

  parent.document.form1.japarcelou.value="1";

  parent.document.form1.numpresaparcelar.value=parent.document.form1.numpresaparcelar.value + '<?=$numpre1?>' + ',';
  parent.document.form1.numparaparcelar.value=parent.document.form1.numparaparcelar.value + '<?=$numpar1?>' + ',';

</script>

<?

//echo "numpre1: $numpre1 - $numpresaparcelar\n";
//echo "numpar1: $numpar1 - $numparaparcelar\n";

if(isset($envia) or (@$mostra == 1)) {

  pg_exec("BEGIN");
  $sql= "create temporary table NUMPRES_PARC1 (k00_numpre integer, k00_numpar integer)";
  if ($mostra == 1) {
    echo "begin;<br>";
    echo $sql . ";<br>";
  }
  pg_exec($sql);

  $mat = split(",",$numpre);
  $mat1 = split(",",$numpar);
  for($i=0;$i<count($mat);$i++){
    $numpre = $mat[$i];
    $numpar = $mat1[$i];
    $sqlparc = "insert into NUMPRES_PARC1 values ($numpre,".(!isset($inicial)?$numpar:"0").")";
    if ($mostra == 1) {
      echo $sqlparc . ";<br>";
    }
    pg_exec($sqlparc);
  }
  $totparc=$parc+1;
  $sql= "create temporary table NUMPRES_PARC as select distinct * from NUMPRES_PARC1";
  if ($mostra == 1) {
    echo $sql . ";<br>";
  }
  pg_exec($sql);
  $sql ="select fc_parcelamento($v07_numcgm,'$datpri_ano-$datpri_mes-$datpri_dia','$datsec_ano-$datsec_mes-$datsec_dia',$dia,$totparc,$ent,".db_getsession('DB_id_usuario').",$k03_tipo,$desconto) as retorno";
  if ($mostra == 1) {
    echo $sql . ";<br>";
  } else {
    $r = pg_exec($sql);
    db_fieldsmemory($r,0);
  }
  ?>
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script>parent.document.getElementById('processando').style.visibility = 'hidden';
  </script>
  <?
  if ($mostra == 1) {
    echo "<br>";
  } else {
    if($retorno == 1){
      echo $retorno;
      $parc = split(":",$retorno);
      pg_exec("COMMIT");
    }else{
      echo "Ocorreu um erro durante o processamento\n".$retorno;
      pg_exec("ROLLBACK");
    }
  }
?>
<script>
  function js_emite(){
    window.open('div2_termoparc_002.php?parcel=<?=$parc[1]?>','','width=790,height=530,scrollbars=1,location=0');
    parent.document.getElementById('pesquisar').click()
  }
</script>
<?
  if ($mostra != 1) {
    ?>
      <input type='button' value='OK' <?=(@$retorno == 1?'onClick="js_emite();"':'')?>>
    <?
  }
  exit;
}
$cltermo = new cl_termo;
$cltermo->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
?>
<html>
<head>
<title>Documento sem t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="parent.document.getElementById('processando').style.visibility = 'hidden'">
<form name="form1" method="post" action="">
<?
echo "<input type='hidden' name='numpre' value='".@$numpre1."'>\n";
echo "<input type='hidden' name='numpar' value='".@$numpar1."'>";
echo "<input type='hidden' name='k03_tipo' value='".@$k03_tipo."'>\n";
echo "<input type='hidden' name='tiposparc' value='".@$tiposparc."'>\n";
echo "<input type='hidden' name='desconto' value='".@$desconto."'>\n";
echo "<input type='hidden' name='mostra' value=0>\n";

?>
<center>
<table border="1" width="100%">
<input type="hidden" name="matric" value="<?=@$ver_matric?>">
<tr>
  <td  align="center" colspan="2" style='border: 1px outset #cccccc'>
  <a onclick='js_mostra()'>
  <b>Parcelamento de Dívida</b>
  </td>
</tr>
<tr>

  <td valign="top">
    <table>
      <tr nowrap>
	<td nowrap title="<?=@$Tv07_numcgm?>">
	   <?
	   db_ancora(@$Lv07_numcgm,"js_pesquisav07_numcgm(true);",1);
	   ?>
	</td>
	<td nowrap colspan="2">
    <?
    db_input('v07_numcgm',6,$Iv07_numcgm,true,'hidden',1," onchange='js_pesquisav07_numcgm(false);'")
    ?>
	   <?
    db_input('z01_nome',35,$Iz01_nome,true,'text',3,'')
	   ?>
	</td>
      </tr>
          <input style="background-color:#DEB887"  type="hidden" name="valortotal" size="10" readonly value='<?=$valor?>'>
          <input style="background-color:#DEB887"  type="hidden" name="valorcorr" size="10" readonly value='<?=$valorcorr?>'>
          <input style="background-color:#DEB887"  type="hidden" name="juros" size="10" readonly value='<?=$juros?>'>
          <input style="background-color:#DEB887"  type="hidden" name="multa" size="10" readonly value='<?=$multa?>'>
      <tr>
        <td>
          <strong>Parcelas:</strong>
        </td>
        <td nowrap>
          <input type="text" name="parc" size="10" readonly style="background-color:#DEB887" onChange="js_troca_parc(this)">
	  <strong>Valor parcela:</strong>
	</td>
	<td>
          <input type="text" name="parcval" size="10" readonly style="background-color:#DEB887" >
          <?
	  if(isset($inicial)){
	  ?>
	  <input type="hidden" name="inicial">
	  <?
	  }
	  ?>
        </td>
      </tr>
      <tr>
        <td>
          <strong>Entrada:</strong>
        </td>
        <td nowrap>
          <input type="text" name="ent" size="10" onBlur="js_troca_valores(this.value)">
	  <strong>Última parcela:</strong>
	</td>
	<td>
          <input type="text" name="parcult" size="10" readonly style="background-color:#DEB887" >
        </td>
      </tr>
      <tr>
	<td nowrap title="">
	  <strong>Primeiro vencimento:</strong>
	</td>
	<td>
    <?
    $datpri_dia = date("d",db_getsession("DB_datausu"));
    $datpri_mes = date("m",db_getsession("DB_datausu"));
    $datpri_ano = date("Y",db_getsession("DB_datausu"));
    db_inputdata('datpri',@$datpri_dia,@$datpri_mes,@$datpri_ano,true,'text',1,"")
    ?>
	</td>
      </tr>
      <tr>
	<td nowrap title="">
          <strong>Segundo vencimento:</strong>
	</td>
	<td>
    <?

    $sqlsegvenc = "select '" . date("Y",db_getsession("DB_datausu")) . "-" . date("m",db_getsession("DB_datausu")) . "-" . date("d",db_getsession("DB_datausu")) . "'::date + '1 months'::interval as segvenc";
    $resultsegvenc = pg_exec($sqlsegvenc);
    db_fieldsmemory($resultsegvenc,0);
    $datsec_dia = substr($segvenc,8,2);
    $datsec_mes = substr($segvenc,5,2);
    $datsec_ano = substr($segvenc,0,4);

//    $datsec_dia = date("d",db_getsession("DB_datausu"));
//    $datsec_mes = (date("m",db_getsession("DB_datausu"))) + 1;
//    $datsec_ano = date("Y",db_getsession("DB_datausu"));
//    if ($datsec_mes == 13) {
//      $datsec_mes = 01;
//      $datsec_ano++;
//    }
    $diaprox = date("d",db_getsession("DB_datausu"));
    db_inputdata('datsec',@$datsec_dia,@$datsec_mes,@$datsec_ano,true,'text',1,"");
    ?>
	</td>
      </tr>
      <tr>
        <td>
          <strong>Dia dos próximos vencimentos:</strong>
        </td>
        <td>
          <input type="text" name="dia" size="10" value="<?=$diaprox?>">
        </td>
      </tr>
      <tr>
        <td>
          <strong>Tipo de arredondamento:</strong>
        </td>
	<td>
	<?
   	$matarredonda = array ("I"=>"Próximo inteiro","D"=>"Próximo decimal","N"=>"Não arredonda");
	db_select('arredondamento',$matarredonda,true,2,"onchange='parcelas.location.href=\"cai3_gerfinanc063.php?valor=$valor&arredondamento=\"+this.value'");
	?>
	</td>
      </tr>
      <tr>
        <td>
	</td>
	<td colspan="2" align="center">
	  <input type="submit" name="envia" value="Parcelar" onClick="return js_verifica()">
	</td>
      </tr>
    </table>
  </td>

  <td>
    <iframe name='parcelas' src='cai3_gerfinanc063.php?valor=<?=$valor?>&valorcorr=<?=$valorcorr?>&juros=<?=$juros?>&multa=<?=$multa?>&valorcomdesconto=<?=$valor?>&arredondamento=D&tiposparc=<?=$tiposparc?>' frameborder='0' align='center' width='350' height='180'>
    </iframe>
  </td>
</tr>
</table>
<script>
function js_verifica(){
  f = document.form1;
  alerta = '';
  if(f.parc.value == ""){
    alerta += "Parcelas\n"
  }
  if(f.dia.value == ""){
    alerta += "Dia dos próximos vencimentos\n"
  }
  if(f.v07_numcgm.value == ""){
    alerta += "Responsável\n"
  }
  if(alerta != ""){
    alert('verifique o(s) campo(s)\n '+ alerta);
    return false;
  }else{
    parent.document.getElementById('processandoTD').innerHTML = '<h3>Aguarde, processando <?(!isset($inicial)?'PARCELAMENTO':'INICIAL FORO')?>...</h3>';
    parent.document.getElementById('processando').style.visibility = 'visible';
    return true;
  }
  return false;
}
function js_troca_parc(obj){

  if(isNaN(obj.value)){
    alert('campo parcela deve ser preenchido somente com números');
    obj.value = '';
    obj.focus();
  }else{
    valor = parcelas.document.getElementById('vt').innerHTML;
    total = valor/obj.value
    document.form1.parcval.value = total.toFixed(2);
    if(isNaN(parcelas.document.getElementById('val'+obj.value))){
      parcelas.document.getElementById('val'+obj.value).checked = true;
      parcelas.document.getElementById('val'+obj.value).focus();
    }
    document.form1.ent.value = total.toFixed(2);
  }
}
var x = 0;
var y = 0;
function js_valparc(id){

  if(parcelas.document.getElementById('vt').innerHTML != document.form1.valortotal.value){
    js_troca_valores('0');
  }

  valor = parcelas.document.getElementById(id).innerHTML;

  if(valor.indexOf(",") != -1){
    valor = new String(valor)
    valor = valor.replace('.','');
    valor = valor.replace(',','.');
    valor = new Number(valor)
  }

  valentrada = Math.round(id)

  if (document.form1.arredondamento.value == "D" ) {

    dezena = valentrada / 10
    _contador = 1

    while (_contador <= 10) {
      if (Math.round(dezena * valentrada) != dezena * valentrada) {
	 valentrada = valentrada + 1
	 dezena = valentrada / 10
	 _contador++
      } else {
	break
      }
    }

  } else {

    if (document.form1.arredondamento.value == "I" ) {
      valentrada = Math.round(valor)
    } else {
      valentrada = valor
    }

  }

  document.form1.ent.value = valentrada;

  var descontomul = 0
  var descontojur = 0

  var tipo1 = document.form1.tiposparc.value.split("-");
  var ultparc = 2;
  var parcela = Number(document.form1.parc.value);
  var parcela = parcela + 1;

  for (contatipo = 0; contatipo < tipo1.length; contatipo++) {
    var tipo2 = tipo1[contatipo].split("=");

//    alert(tipo2[0] + ' - ' + tipo2[1] + ' - ' + tipo2[2] + ' - ' + ultparc + ' - ' + parcela);
    if (parcela >= ultparc && parcela <= tipo2[1]) {
      var descontomul = tipo2[2];
      var descontojur = tipo2[3];
      break;
    }

    var ultparc = tipo2[1];

  }

  if (1 == 2) {

    if (document.form1.parc.value <= 5) {
      desconto = 10;
    } else if (document.form1.parc.value <= 11) {
      desconto = 9;
    } else if (document.form1.parc.value <= 17) {
      desconto = 8;
    } else if (document.form1.parc.value <= 23) {
      desconto = 7;
    } else if (document.form1.parc.value <= 47) {
      desconto = 6;
    } else if (document.form1.parc.value <= 71) {
      desconto = 5;
    }

  }

//  alert(desconto);

    juros = new Number(document.form1.juros.value)
    multa = new Number(document.form1.multa.value)

//    valdesconto = (document.form1.juros.value + document.form1.multa.value) * desconto / 100;
    valdesconto = (juros * descontojur / 100) + (multa * descontomul / 100);
    valdesconto = valdesconto.toFixed(2);

    valorcorr = Number(document.form1.valorcorr.value);

    valtotal = valorcorr + (juros + multa) - valdesconto;
    valtotal = valtotal.toFixed(2);




//  x = (document.form1.valortotal.value - document.form1.ent.value)/document.form1.parc.value;
  x = (valtotal - document.form1.ent.value)/document.form1.parc.value;
  document.form1.parcval.value = x.toFixed(2);
  x = document.form1.parc.value * document.form1.parcval.value;
//  x = document.form1.valortotal.value - eval(x +'+'+ document.form1.ent.value)
  x = valtotal - eval(x +'+'+ document.form1.ent.value)
  document.form1.parcult.value = eval(document.form1.parcval.value +'+'+ x).toFixed(2);



  parcelas.document.getElementById('vtcomdesconto').innerHTML = valtotal;




}
function js_troca_valores(entrada){

  if(isNaN(entrada)){
    alert('campo entrada deve ser preenchido somente com números');
    document.form1.ent.value = '';
    document.form1.ent.focus();
  } else if(entrada <= 0){
    alert('Entrada deve ser maior que 0');
    document.form1.ent.value = '';
    document.form1.ent.focus();
  }else{
    if(entrada.indexOf(",") != -1){
      entrada = new String(entrada)
      entrada = entrada.replace(',','.');
      document.form1.ent.value = entrada;
    }
    valorparcela = new Number(document.form1.parc.value);
    quantparcelas = new Number(document.form1.parcval.value);
    valorultima = new Number(document.form1.parcult.value);
    valortotal = (valorparcela * quantparcelas) + valorultima;

    x = (valortotal - document.form1.ent.value)/document.form1.parc.value;
    document.form1.parcval.value = x.toFixed(2);
    x = document.form1.parc.value * document.form1.parcval.value;
    x = valortotal - eval(x +'+'+ document.form1.ent.value)
    document.form1.parcult.value = eval(document.form1.parcval.value +'+'+ x).toFixed(2);

    parcelas.document.getElementById('vtcomdesconto').innerHTML = valortotal;

    for(i=2;i<500;i++){
      parcelas.document.getElementById('val'+i).checked = false;
    }

  }

  document.form1.dia.focus();
}
function js_pesquisav07_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_nome.php?testanome=true&funcao_js=parent.debitos.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.v07_numcgm.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_nome.php?testanome=true&pesquisa_chave='+document.form1.v07_numcgm.value+'&funcao_js=parent.debitos.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgm(erro,chave){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.v07_numcgm.focus();
    document.form1.v07_numcgm.value = '';
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.v07_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  if(parent.document.getElementById('id_resp_parc').value == "")
    parent.document.getElementById('id_resp_parc').value = chave1;
  if(parent.document.getElementById('resp_parc').value == "")
    parent.document.getElementById('resp_parc').value = chave2;
  CurrentWindow.corpo.db_iframe_cgm.hide();
}
onload = js_pnome();
function js_pnome(){
  if(parent.document.getElementById('id_resp_parc').value != "")
    document.form1.v07_numcgm.value = parent.document.getElementById('id_resp_parc').value;
  if(parent.document.getElementById('resp_parc').value != "")
    document.form1.z01_nome.value = parent.document.getElementById('resp_parc').value;
}
function js_mostra(){
  document.form1.mostra.value = 1;
  document.form1.submit();
}
</script>
</center>
</form>
</body>
</html>
<?
?>
