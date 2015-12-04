<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);

if(isset($btAtualiza)){

$sql= "select munic from db_config where codigo = ".db_getsession("DB_instit");
$result = pg_query($sql) or die($sql);
$munic = pg_result($result,0,0);

  $ipSam = "192.168.0.1";
  $dbSam = "sam30";
  $connSam = pg_connect("host = $ipSam dbname = $dbSam user = postgres");

  $ipDbportal = "192.168.0.243";
  $dbDbportal = "ontem_20060718_1130";
	$portadbportal = 5433;
  $connDbportal = pg_connect("host = $ipDbportal dbname = $dbDbportal port = $portadbportal user = postgres");

	$terminal = 2;

//$data = date("Y-m-d");
$data = "$data_ano-$data_mes-$data_dia";
//echo $data."<br>";

$resultAutent = pg_query($connDbportal, "delete from cornump where k12_data = '$data' and k12_id = $terminal") or die("delete 1");
$resultAutent = pg_query($connDbportal, "delete from corhist where k12_data = '$data' and k12_id = $terminal") or die("delete 2");
$resultAutent = pg_query($connDbportal, "delete from corrente where k12_data = '$data' and k12_id = $terminal") or die("delete 3");

$autent = 1;

$selectAutent = "select autent.*,saltes.k13_plano
		from 
			autent 
			inner join saltes on k12_conta = k13_conta
		where 
			k12_data = '".$data."' and 
			k12_numpre <> ''";
$resultAutent = pg_query($connSam, $selectAutent) or die($selectAutent);

pg_query($connDbportal, "begin") or die("erro no begin");

while($linha = pg_fetch_array($resultAutent)){

   $id = $terminal;   
   // pesquisa id do terminal e soma 1000 no id
   //$sql = "select * from cfautent where k11_ipterm = '$

   $linha["k12_autent"] = $autent++;
   $linha["k12_valor"] = $linha["k12_valor"] * -1;
   $k12_estorn = ($linha["k12_valor"] < 0?"t":"f");

   $insertCorrente = 
    "insert into corrente 
    (
    k12_id, 
    k12_data, 
    k12_autent, 
    k12_hora, 
    k12_conta, 
    k12_valor, 
    k12_estorn,
    k12_instit
    )
    values
    (".$id.", 
    '".$linha["k12_data"]."',
    ".$linha["k12_autent"].",
    '".$linha["k12_hora"]."',
    ".$linha["k13_plano"].",
    ".$linha["k12_valor"].",
    '$k12_estorn',
    " . db_getsession("DB_instit") . "
    )";
   $insert = pg_query($connDbportal, $insertCorrente) or die($insertCorrente);

   if ($insert){

     if( trim($linha["k12_numpre"]) != "" ){
       $sql = "select distinct k10_histor 
               from recibo 
                    left outer join descon on k00_numnov = k10_numpre 
               where k00_numpre like '".substr(trim($linha["k12_numpre"]),0,8)."%'";
       $resrec = pg_exec($connSam,$sql) or die($sql);
       if(pg_numrows($resrec)!=0 && trim(pg_result($resrec,0,0))!=""){
         $sql = "insert into corhist (k12_id,k12_data,k12_autent,k12_histcor)
                              values (".$id.",
                                      '".$linha["k12_data"]."',
                                      ".$linha["k12_autent"].",
                                      '".pg_result($resrec,0,0)."'
                                     )";
         $resrec = pg_exec($connDbportal,$sql) or die($sql);
       }
     }
      


     $numpre = substr($linha["k12_numpre"], 0, 8);
     $numpar = substr($linha["k12_numpre"], 8, 2);
     $numtot = substr($linha["k12_numpre"], 10, 2);
     $numdig = substr($linha["k12_numpre"], 12, 1);

     $receit =  array(
      $linha["k12_rec01"],
      $linha["k12_rec02"],
      $linha["k12_rec03"],
      $linha["k12_rec04"],
      $linha["k12_rec05"],
      $linha["k12_rec06"],
      $linha["k12_rec07"],
      $linha["k12_rec08"],
      $linha["k12_rec09"],
      $linha["k12_rec10"],
      $linha["k12_rec11"],
      $linha["k12_rec12"],
      $linha["k12_rec13"],
      $linha["k12_rec14"],
      $linha["k12_rec15"],
      $linha["k12_rec16"],
      $linha["k12_rec17"],
      $linha["k12_rec18"],
      $linha["k12_rec19"],
      $linha["k12_rec20"]
      );
    
      $contador=1;

     while(list($key, $val) = each ($receit)){
	      if ($val != 0 && $val != ""){
		     $tmp = $key + 1;
		     if ($tmp >= 1 && $tmp <= 9){
		      $vlr = "k12_vlr0".$tmp;
		     } 
		     else{
		      $vlr = "k12_vlr".$tmp;
		     }
		     $linha["$vlr"] = $linha["$vlr"] * -1;
		     $insertCornump = 
		      "
		      insert into cornump
		      (
		      k12_id,
		      k12_data,
		      k12_autent,
		      k12_numpre,
		      k12_numpar,
		      k12_numtot,
		      k12_numdig,
		      k12_receit,
		      k12_valor,
		      k12_numnov
		      )
		      values
		      (
		      ".$id.",
		      '".$linha["k12_data"]."',
		      ".$linha["k12_autent"].",
		      ".(trim($numpre)+$contador).",
		      ".$numpar.",
		      ".$numtot.",
		      ".$numdig.",
		      ".$val.",
		      ".$linha["$vlr"].",
		      0
		      )";
		      $contador ++;
		      $result = pg_query($connDbportal, $insertCornump) or die($insertCornump);
		      if ($result){
			      //;;echo "<script>alert('Atualização Realizada com Sucesso')</script>";
			     // echo "ok <Br>"; 	
			      continue;
		      }
		      else{
			      echo "Erro na Atualização, contact o CPD";
			     exit; 
		      }
	      }   
	}	
    }
    else{
       echo "Erro na Atualização, contate o CPD (2)";
       exit;
    }
}

pg_query($connDbportal, "commit") or die("erro ao comitar");

 echo "<script> alert('Processo de Atualização de Receitas Concluído.'); </script>"; 
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
       <form name='form1' action='atualiza-receita-dbportal.php' method='post'>
           <br>
	   <?
	   db_inputdata("data",@$dia,@$mes,@$ano,true,"text",1);
	   ?>
	   <br>
   	   <input type='submit' name='btAtualiza' value='Processa Data'>
       </form>
    </center>
    </td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>

