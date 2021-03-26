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

if (isset($envia) or @$mostra == 1) {
  $entra=true;
} else {
  $entra=false;
}

$conteudoaparcelar="";
$valoresportipo="";

if((isset($ver_matric) or isset($ver_inscr) or (isset($ver_numcgm))) and (!isset($numpre))){

  $vt = $HTTP_POST_VARS;
  $tam = sizeof($vt);
  $virgula = "";
  $numpar1 = "";
  $numpre1 = "";
  for($i = 0;$i < $tam;$i++) {
    if(db_indexOf(key($vt),"CHECK") > 0){
      $conteudoaparcelar.="XXX" . (!isset($inicial)?"NUMPRE":"INICIAL") . $vt[key($vt)];
      $numpres = $vt[key($vt)];
      $mat = split("N",$numpres);
      for($j = 0;$j < count($mat);$j++) {
        if ($mat[$j] == "") continue;
        $numpre = split("P",$mat[$j]);
        $numpar = split("P",strstr($mat[$j],"P"));
        if(!isset($inicial)){
          $numpar = split("R",$numpar[1]);
          $numpar = $numpar[0];
					$numpre = $numpre[0];
        } else {
					$numpre = $numpre[0];
				}
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
  }

} elseif (isset($numpre)) {
  $numpre1 = $numpre;
  $numpar1 = $numpar;
}

echo "Selecione a regra de parcelamento: ";

$sqlcadtipoparc = "select k40_codigo, k40_descr from cadtipoparc where '". date("Y-m-d",db_getsession("DB_datausu")) . "' >= k40_dtini and '" . date("Y-m-d",db_getsession("DB_datausu")) . "' <= k40_dtfim";
$resultcadtipoparc = pg_exec($sqlcadtipoparc);

if (pg_numrows($resultcadtipoparc) == 0) {
  db_msgbox("Nao existem regras para parcelamento cadastrados na faixa da data atual! Contate suporte!");
  exit;
}

$arr = Array();
for($r=0; $r<pg_numrows($resultcadtipoparc); $r++){
  db_fieldsmemory($resultcadtipoparc,$r);
  $arr[$k40_codigo] = $k40_descr;
}
flush();

db_select("k40_cadtipoparc",$arr,true,1,"onchange='js_reload(this.value)'");

if (!isset($k40_cadtipoparc) and (pg_numrows($resultcadtipoparc) > 0)) {
  $k40_cadtipoparc = pg_result($resultcadtipoparc,0,0);
}

if($entra == false) {

	$cadtipoparc = 0;

	$sqltipoparc = "select *
									from tipoparc
									inner join cadtipoparc on cadtipoparc = k40_codigo
									where maxparc > 1 and '"
									. date("Y-m-d",db_getsession("DB_datausu")) . "' >= k40_dtini and
									'" . date("Y-m-d",db_getsession("DB_datausu")) . "' <= k40_dtfim and
									k40_codigo = $k40_cadtipoparc order by maxparc";
	$resulttipoparc = pg_exec($sqltipoparc) or die($sqltipoparc);
	if (pg_numrows($resulttipoparc) > 0) {
		db_fieldsmemory($resulttipoparc,0);
	} else {
		$k40_todasmarc = false;
	}

	$sqltipoparcdeb = "	select * from cadtipoparcdeb
											where k41_cadtipoparc = $k40_cadtipoparc
											limit 1";
	$resulttipoparcdeb = pg_exec($sqltipoparcdeb);
	$passar = false;

	if(isset($inicial) && $inicial != "") {
		$k03_tipo = 18;
		$totalregistrospassados = $totregistros;
	}

	if (pg_numrows($resulttipoparcdeb) == 0) {
		$passar = true;
	} else {
		$sqltipoparcdeb = "select * from cadtipoparcdeb where k41_cadtipoparc = $k40_cadtipoparc and k41_arretipo = $k03_tipo";
		$resulttipoparcdeb = pg_exec($sqltipoparcdeb);
		if (pg_numrows($resulttipoparcdeb) > 0) {
			$passar = true;
		}
	}

	if (!isset($totalregistrospassados)) {
		$totalregistrospassados = 0;
	}

	if (!isset($totregistros)) {
		$totregistros = 0;
	}

	if (pg_numrows($resulttipoparc) == 0 or ($k40_todasmarc == 't'?$totalregistrospassados <> $totregistros:false) or $passar == false) {
		$desconto = 0;
	} else {
		$desconto = $k40_codigo;
	}

	$tiposparc = "";

	for ( $parcelas=0; $parcelas < pg_numrows($resulttipoparc); $parcelas++ ) {
		db_fieldsmemory($resulttipoparc,$parcelas,true);
		if ($desconto == 0 and 1==2) {
			$descmul = 0;
			$descjur = 0;
		}
		$tiposparc .= $tipoparc . "=" . $maxparc . "=" . $descmul . "=" . $descjur . "=" . (int) $k42_minentrada . "=" . $k40_forma . ($parcelas == (pg_numrows($resulttipoparc) -1)?"":"-");
	}

	if ($tiposparc == "") {
		db_msgbox("Nao existem regras para parcelamento cadastrados na faixa da data atual! Contate suporte!");
		exit;
	}

}

if((isset($inicial) && $inicial != "") and ( $entra == false)) {

  $numpre = $numpre1;
  $sql="select v59_numpre,k00_numpar
  from inicialnumpre
  inner join arrecad on v59_numpre = k00_numpre
  where v59_inicial in ($numpre)
  ";

  $result = pg_query($sql) or die($sql);
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

  $numpre = $numpre1;
  $numpar = $numpar1;

}

if(!session_is_registered("conteudoparc")) {
  session_register("conteudoparc");
  db_putsession("conteudoparc",$conteudoaparcelar);
} else {
  db_putsession("conteudoparc",db_getsession("conteudoparc").$conteudoaparcelar);
}

$matriz	= split("XXX", db_getsession("conteudoparc"));

$novamatrizval = array();

for ($x=0; $x < sizeof($matriz); $x++) {

  if ($matriz[$x] == "") {
    continue;
  }

  if (gettype(strpos($matriz[$x], "NUMPRE")) != "boolean") {
		$tiporeg = "NUMPRE";
	} else {
		$tiporeg = "INICIAL";
	}
	$registro = split($tiporeg, $matriz[$x]);

	$registros = split("N", $registro[1]);
	for ($reg=0; $reg < sizeof($registros); $reg++) {
		if ($registros[$reg] == "") {
			continue;
		}

		if (!in_array($tiporeg . "N ". $registros[$reg], $novamatrizval)) {
			$novamatrizval[] = $tiporeg . "N" . $registros[$reg] . "XXX";
		}

	}

}

$conteudofinal="";
for ($x=0; $x < sizeof($novamatrizval); $x++) {
  $conteudofinal.=$novamatrizval[$x];
}
db_putsession("conteudoparc",$conteudofinal);

?>

<script>

parent.document.form1.japarcelou.value="1";

parent.document.form1.numpresaparcelar.value=parent.document.form1.numpresaparcelar.value + '<?=$numpre1?>' + ',';
parent.document.form1.numparaparcelar.value=parent.document.form1.numparaparcelar.value + '<?=$numpar1?>' + ',';

</script>

<?

//echo "\natual: " . db_getsession("conteudoparc") . "\n";

pg_exec("begin");
$sql = "create temporary table NUMPRES_CALC (k00_numpre integer, k00_numpar integer)";
pg_exec($sql) or die($sql);

$totalvlrhis			= 0;
$totalvlrcor			= 0;
$totalvlrjuros		= 0;
$totalvlrmulta		= 0;
$totalvlrdesconto = 0;
$totaltotal				= 0;

$sql= "create temporary table totalportipo (k03_tipodebito	integer,
																						k00_cadtipoparc	integer,
																						k00_vlrhis			float8,
																						k00_vlrcor			float8,
																						k00_juros				float8,
																						k00_multa				float8,
																						k00_desconto		float8,
																						k00_total				float8)";
pg_exec($sql) or die($sql);
if (@$mostra == 1) {
	echo "<br>begin;<br>";
	echo $sql . ";<br>";
}

$sql= "create temporary table NUMPRES_PARC1 (k00_numpre integer, k00_numpar integer, k03_tipodebito integer)";
pg_exec($sql) or die($sql);
if (@$mostra == 1) {
	echo $sql . ";<br>";
}

$matnumpres = split("XXX",db_getsession("conteudoparc"));
for ($contanumpres=0; $contanumpres < sizeof($matnumpres); $contanumpres++) {
	if ($matnumpres[$contanumpres] == "") {
		continue;
	}

  if (gettype(strpos($matnumpres[$contanumpres], "NUMPRE")) != "boolean") {
		$tiporeg = "NUMPRE";
	} else {
		$tiporeg = "INICIAL";
	}
	$registro = split($tiporeg, $matnumpres[$contanumpres]);

  if ($tiporeg == "NUMPRE") {
		$registros=split("R", $registro[1]);
		$numpre=split("P", $registros[0]);
		$numpar = $numpre[1];
		$numpre = substr($numpre[0],1);

		$sqltipo = "select k03_tipo as k03_tipodebito from arrecad
								inner join arretipo on arrecad.k00_tipo = arretipo.k00_tipo
								where k00_numpre = $numpre
								limit 1";
		$resulttipo = pg_exec($sqltipo) or die($sqltipo);
		db_fieldsmemory($resulttipo, 0);

    $sqlprocura = "select * from NUMPRES_CALC where k00_numpre = $numpre and k00_numpar = $numpar";

	} else {
		$numpre = substr($registro[1],1);

    $sqlprocura = "select * from NUMPRES_CALC where k00_numpre = $numpre and k00_numpar = 0";
	}
	$resultprocura = pg_exec($sqlprocura) or die($sqlprocura);

	if (pg_numrows($resultprocura) == 0) {

		$sqlparc = "insert into NUMPRES_CALC values ($numpre,".($tiporeg == "NUMPRE"?$numpar:"0").")";
		pg_exec($sqlparc) or die($sqlparc);

//		echo "sql: $sqlparc<br>";

		if ($tiporeg == "INICIAL") {
			$sqlcalc = "select k00_numpre, 0 as k00_numpar, fc_calcula(k00_numpre, 0, 0, current_date, current_date, extract (year from current_date)::integer) from (select distinct k00_numpre from inicialnumpre inner join arrecad on k00_numpre = v59_numpre
						where v59_inicial = $numpre) as xxx";
			$k03_tipodebito = 18;
		} else {
			$sqltipo = "select k03_tipo as k03_tipodebito from arrecad
									inner join arretipo on arrecad.k00_tipo = arretipo.k00_tipo
									where k00_numpre = $numpre
									limit 1";
			$resulttipo = pg_exec($sqltipo) or die($sqltipo);
			db_fieldsmemory($resulttipo, 0);

			$sqlcalc = "select $numpre as k00_numpre, $numpar as k00_numpar, fc_calcula($numpre, $numpar, 0, current_date, current_date, extract (year from current_date)::integer)";
		}

		$cadtipoparc = 0;

		$sqltipoparc = "select *
										from tipoparc
										inner join cadtipoparc on cadtipoparc = k40_codigo
										where maxparc > 1 and '"
										. date("Y-m-d",db_getsession("DB_datausu")) . "' >= k40_dtini and
										'" . date("Y-m-d",db_getsession("DB_datausu")) . "' <= k40_dtfim and
										k40_codigo = $k40_cadtipoparc order by maxparc";
		$resulttipoparc = pg_exec($sqltipoparc) or die($sqltipoparc);
		if (pg_numrows($resulttipoparc) > 0) {
			db_fieldsmemory($resulttipoparc,0);
		} else {
			$k40_todasmarc = false;
		}

		$sqltipoparcdeb = "	select * from cadtipoparcdeb
												where k41_cadtipoparc = $k40_cadtipoparc
												limit 1";
		$resulttipoparcdeb = pg_exec($sqltipoparcdeb);
		$passar = false;

		if(isset($inicial) && $inicial != "") {
			$k03_tipodebito = 18;
			$totalregistrospassados = $totregistros;
		}

		if (pg_numrows($resulttipoparcdeb) == 0) {
			$passar = true;
		} else {
			$sqltipoparcdeb = "	select * from cadtipoparcdeb
													where k41_cadtipoparc = $k40_cadtipoparc and
																k41_arretipo = $k03_tipodebito";
			$resulttipoparcdeb = pg_exec($sqltipoparcdeb);
			if (pg_numrows($resulttipoparcdeb) > 0) {
				$passar = true;
			}
		}

		if (!isset($totalregistrospassados)) {
			$totalregistrospassados = 0;
		}

		if (!isset($totregistros)) {
			$totregistros = 0;
		}

		if (pg_numrows($resulttipoparc) == 0 or ($k40_todasmarc == 't'?$totalregistrospassados <> $totregistros:false) or $passar == false) {
			$desconto = 0;
		} else {
			$desconto = $k40_codigo;
		}

		$tiposparc = "";

		for ( $parcelas=0; $parcelas < pg_numrows($resulttipoparc); $parcelas++ ) {
			db_fieldsmemory($resulttipoparc,$parcelas,true);
			if ($desconto == 0 and 1==2) {
				$descmul = 0;
				$descjur = 0;
			}
			$tiposparc .= $tipoparc . "=" . $maxparc . "=" . $descmul . "=" . $descjur . "=" . (int) $k42_minentrada . "=" . $k40_forma . ($parcelas == (pg_numrows($resulttipoparc) -1)?"":"-");
		}

		$sqlcalc_desativado = "select
									 substr(fc_calcula,2,13)::float8 as vlrhis,
									 substr(fc_calcula,15,13)::float8 as vlrcor,
									 substr(fc_calcula,28,13)::float8 as vlrjuros,
									 substr(fc_calcula,41,13)::float8 as vlrmulta,
									 substr(fc_calcula,54,13)::float8 as vlrdesconto,
									 (substr(fc_calcula,15,13)::float8+
									 substr(fc_calcula,28,13)::float8+
									 substr(fc_calcula,41,13)::float8-
									 substr(fc_calcula,54,13)::float8) as vlrtotal
								from ($sqlcalc) as x";
		$resultcalc = pg_exec($sqlcalc) or die($sqlcalc);
		for ($calc=0; $calc < pg_numrows($resultcalc); $calc++) {
			db_fieldsmemory($resultcalc, $calc);

			$totalvlrhis			+= 0 + (float) substr($fc_calcula,01,13);
			$totalvlrcor			+= 0 + (float) substr($fc_calcula,14,13);
			$totalvlrjuros		+= 0 + (float) substr($fc_calcula,27,13);
			$totalvlrmulta		+= 0 + (float) substr($fc_calcula,40,13);
			$totalvlrdesconto += 0 + (float) substr($fc_calcula,53,13);
			$totaltotal				+= 0 + (float) substr($fc_calcula,14,13) + (float) substr($fc_calcula,27,13) + (float) substr($fc_calcula,40,13) - (float) substr($fc_calcula,53,13);

			if ($tiporeg == "NUMPRE") {
				$sqlparc = "insert into NUMPRES_PARC1 values ($numpre,$numpar,$k03_tipodebito)";
			} else {
				$sqlparc = "insert into NUMPRES_PARC1
										select distinct v59_numpre, 0, 18
										from inicialnumpre
										where v59_inicial = $numpre";
			}
			pg_exec($sqlparc) or die($sqlparc);
			if (@$mostra == 1) {
				echo $sqlparc . ";<br>";
			}

			$sqlportipo = "select * from totalportipo where k03_tipodebito = $k03_tipodebito";
			$resultportipo = pg_exec($sqlportipo) or die($sqlportipo);

			$k00_vlrhis		= 0 + (float) substr($fc_calcula,01,13);
			$k00_vlrcor		= 0 + (float) substr($fc_calcula,14,13);
			$k00_juros		= 0 + (float) substr($fc_calcula,27,13);
			$k00_multa		= 0 + (float) substr($fc_calcula,40,13);
			$k00_desconto	= 0 + (float) substr($fc_calcula,53,13);
			$k00_total		= 0 + (float) substr($fc_calcula,14,13) + (float) substr($fc_calcula,27,13) + (float) substr($fc_calcula,40,13) - (float) substr($fc_calcula,53,13);

			if (pg_numrows($resultportipo) == 0) {
				$sql  = "insert into totalportipo values ($k03_tipodebito, $desconto, ";
				$sql .= "$k00_vlrhis, ";
				$sql .= "$k00_vlrcor, ";
				$sql .= "$k00_juros, ";
				$sql .= "$k00_multa, ";
				$sql .= "$k00_desconto, ";
				$sql .= "$k00_total)";
			} else {
				$sql  = "update totalportipo set k00_vlrhis		= k00_vlrhis		+ $k00_vlrhis, ";
				$sql .= "                        k00_vlrcor		= k00_vlrcor		+ $k00_vlrcor, ";
				$sql .= "                        k00_juros		= k00_juros			+ $k00_juros ,";
				$sql .= "                        k00_multa		= k00_multa			+ $k00_multa, ";
				$sql .= "                        k00_desconto = k00_desconto  + $k00_desconto, ";
				$sql .= "                        k00_total		= k00_total			+ $k00_total ";
				$sql .= "where k03_tipodebito = $k03_tipodebito";
			}
			if (@$mostra == 1) {
				echo $sql . ";<br>";
			}
			pg_exec($sql) or die($sql);
//			echo "<br>$sql<br>";

		}

	}

}
$sqltotalportipo = "select
										k03_tipodebito,
										k00_cadtipoparc,
										sum(k00_vlrhis) as k00_vlrhis,
										sum(k00_vlrcor) as k00_vlrcor,
										sum(k00_juros) as k00_juros,
										sum(k00_multa) as k00_multa,
										sum(k00_desconto) as k00_desconto,
										sum(k00_total) as k00_total
										from totalportipo
										group by k03_tipodebito, k00_cadtipoparc";
$resulttotalportipo = pg_exec($sqltotalportipo) or die($sqltotalportipo);
$valoresportipo="";
for ($x=0; $x < pg_numrows($resulttotalportipo); $x++) {
	db_fieldsmemory($resulttotalportipo, $x);
	$valoresportipo .= $k03_tipodebito . "-" . $k00_cadtipoparc . "-" . $k00_vlrhis . "-" . $k00_vlrcor . "-" . $k00_juros . "-" . $k00_multa . "-" . $k00_desconto . "-" . $k00_total . "=";
}

if(isset($envia) or (@$mostra == 1) ) {

	if (1==2) {

		$matnumpres = split("XXX",db_getsession("conteudoparc"));
		for ($contanumpres=0; $contanumpres < sizeof($matnumpres); $contanumpres++) {
			if ($matnumpres[$contanumpres] == "") {
				continue;
			}

			if (gettype(strpos($matnumpres[$contanumpres], "NUMPRE")) != "boolean") {
				$tiporeg = "NUMPRE";
			} else {
				$tiporeg = "INICIAL";
			}
			$registro = split($tiporeg, $matnumpres[$contanumpres]);

			if ($tiporeg == "NUMPRE") {
				$registros=split("R", $registro[1]);
				$numpre=split("P", $registros[0]);
				$numpar = $numpre[1];
				$numpre = substr($numpre[0],1);
				$sqltipo = "select k03_tipo from arrecad
										inner join arretipo on arrecad.k00_tipo = arretipo.k00_tipo
										where k00_numpre = $numpre
										limit 1";
				$resulttipo = pg_exec($sqltipo) or die($sqltipo);
				db_fieldsmemory($resulttipo, 0);
				$sqlprocura = "select * from NUMPRES_PARC1 where k00_numpre = $numpre and k00_numpar = $numpar";
			} else {
				$numpre = substr($registro[1],1);
				$sqlprocura = "select * from NUMPRES_PARC1 where k00_numpre = $numpre and k00_numpar = 0";
			}
			$resultprocura = pg_exec($sqlprocura) or die($sqlprocura);

			if (pg_numrows($resultprocura) == 0) {

			  if ($tiporeg == "NUMPRE") {
				  $sqlparc = "insert into NUMPRES_PARC1 values ($numpre,$numpar,$k03_tipo)";
				} else {
				  $sqlparc = "insert into NUMPRES_PARC1
											select distinct v59_numpre, 0, 18
											from inicialnumpre
											where v59_inicial = $numpre";
				}
				pg_exec($sqlparc) or die($sqlparc);

				if (@$mostra == 1) {
					echo $sqlparc . ";<br>";
				}

			}

		}
		db_putsession("conteudoparc","");
	} elseif (1==2) {

		$mat = split(",",$numpre);
		$mat1 = split(",",$numpar);
		for($i=0;$i<count($mat);$i++){
			$numpre = $mat[$i];
			$numpar = $mat1[$i];
			$sqlparc = "insert into NUMPRES_PARC1 values ($numpre,".(!isset($inicial)?$numpar:"0").")";
			if (@$mostra == 1) {
				echo $sqlparc . ";<br>";
			}
			pg_exec($sqlparc) or die($sqlparc);
		}
	}

  $totparc=$parc+1;
  $sql= "create temporary table NUMPRES_PARC as select distinct * from NUMPRES_PARC1";
  if (@$mostra == 1) {
    echo $sql . ";<br>";
  }
  pg_exec($sql) or die($sql);
  $sql ="select fc_parcelamento($v07_numcgm,'$datpri_ano-$datpri_mes-$datpri_dia'::date,'$datsec_ano-$datsec_mes-$datsec_dia'::date,$dia,$totparc,$ent,".db_getsession('DB_id_usuario').",$k03_tipo,$k40_cadtipoparc,$desconto,$parcval,$parcult) as retorno";
  if (@$mostra == 1) {
    echo $sql . ";<br>";exit;
  } else {
    $r = pg_exec($sql) or die($sql);
    db_fieldsmemory($r,0);
  }
  ?>
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script>parent.document.getElementById('processando').style.visibility = 'hidden';
  </script>
  <?
  if (@$mostra == 1) {
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
  if (@$mostra != 1) {
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
echo "<input type='hidden' name='ver_matric' value='".@$ver_matric."'>\n";
echo "<input type='hidden' name='ver_inscr' value='".@$ver_inscr."'>\n";
echo "<input type='hidden' name='ver_numcgm' value='".@$ver_numcgm."'>\n";
echo "<input type='hidden' name='numpre' value='".@$numpre1."'>\n";
echo "<input type='hidden' name='numpar' value='".@$numpar1."'>";
echo "<input type='hidden' name='k03_tipo' value='".@$k03_tipo."'>\n";
echo "<input type='hidden' name='tiposparc' value='".@$tiposparc."'>\n";
echo "<input type='hidden' name='valoresportipo' value='".@$valoresportipo."'>\n";
echo "<input type='hidden' name='desconto' value='".@$desconto."'>\n";
echo "<input type='hidden' name='mostra' value=0>\n";
echo "<input type='hidden' name='k40_cadtipoparc' value=".@$k40_cadtipoparc.">\n";
echo "<input type='hidden' name='valortotalcomdesconto' value=".@$valortotalcomdesconto.">\n";
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
<input style="background-color:#DEB887"  type="hidden" name="valortotal" size="10" readonly value='<?=$totaltotal?>'>
<input style="background-color:#DEB887"  type="hidden" name="valorcorr" size="10" readonly value='<?=$totalvlrcor?>'>
<input style="background-color:#DEB887"  type="hidden" name="juros" size="10" readonly value='<?=$totalvlrjuros?>'>
<input style="background-color:#DEB887"  type="hidden" name="multa" size="10" readonly value='<?=$totalvlrmulta?>'>
<tr>
<td>
<strong>Parcelas:</strong>
</td>
<td nowrap>
<input type="text" name="parc" size="10" readonly style="background-color:#DEB887" onChange="js_troca_parc(this)">
<strong>Valor parcela:</strong>
</td>
<td>



<?
if ($k40_permvalparc == 'f') {
  ?>
  <input type="text" name="parcval" size="10" readonly style="background-color:#DEB887" >
  <?
} else {
  ?>
  <input type="text" name="parcval" size="10" onBlur="js_troca_valores_parc(this.value)">
  <?
}

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
<input type="text" name="parcult" size="10" readonly style="background-color:#DEB887">
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

if (date("d",db_getsession("DB_datausu")) >= $k40_diapulames and $k40_diapulames > 0) {
  $pulames = 2;
} else {
  $pulames = 1;
}

if ($k40_vctopadrao > 0) {
  $diapadrao = $k40_vctopadrao;
} else {
  $diapadrao = date("d",db_getsession("DB_datausu"));
}

$sqlsegvenc = "select '" . date("Y",db_getsession("DB_datausu")) . "-" . date("m",db_getsession("DB_datausu")) . "-" . $diapadrao . "'::date + '$pulames months'::interval as segvenc";
$resultsegvenc = pg_exec($sqlsegvenc) or die($sqlsegvenc);
db_fieldsmemory($resultsegvenc,0);
$datsec_dia = substr($segvenc,8,2);
$datsec_mes = substr($segvenc,5,2);
$datsec_ano = substr($segvenc,0,4);

$diaprox = date("d",db_getsession("DB_datausu"));
$diaprox = $diapadrao;
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
db_select('arredondamento',$matarredonda,true,2,"onchange='parcelas.location.href=\"cai3_gerfinanc063.php?valor=$totaltotal&valorcorr=$totalvlrcor&juros=$totalvlrjuros&multa=$totalvlrmulta&valorcomdesconto=$totaltotal&tiposparc=$tiposparc&valoresportipo=$valoresportipo&arredondamento=\"+this.value'");
?>
</td>
</tr>
<tr>
<td>
</td>
<td colspan="2" align="center">
<input type="submit" name="envia" value="Parcelar" onClick="return js_verifica(<?=$k03_tipo?>)">
</td>
</tr>
</table>
</td>

<td>
<iframe name='parcelas' src='cai3_gerfinanc063.php?valoresportipo=<?=$valoresportipo?>&valor=<?=$totaltotal?>&valorcorr=<?=$totalvlrcor?>&juros=<?=$totalvlrjuros?>&multa=<?=$totalvlrmulta?>&valorcomdesconto=<?=$totaltotal?>&arredondamento=D&tiposparc=<?=$tiposparc?>' frameborder='0' align='center' width='350' height='180'>
</iframe>
</td>
</tr>
</table>
<script>
function js_verifica(k03_tipo){
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

    if (k03_tipo == 6 || k03_tipo == 13) {
      if (confirm('Tem certeza de que deseja efetuar um reparcelamento?') == false) {
        return false;
      }
    }

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

  var descontomul = 0
  var descontojur = 0

  var tipo1 = document.form1.tiposparc.value.split("-");
  var ultparc = 2;
  var parcela = Number(document.form1.parc.value);
  var parcela = parcela + 1;

  for (contatipo = 0; contatipo < tipo1.length; contatipo++) {
    var tipo2 = tipo1[contatipo].split("=");

    var forma = tipo2[5];

		var entradaminima = tipo2[4];

    if (parcela >= ultparc && parcela <= tipo2[1]) {
      var descontomul = tipo2[2];
      var descontojur = tipo2[3];
      break;
    }

    var ultparc = tipo2[1];

  }

	var valoresportipo	= document.form1.valoresportipo.value.split("=");
	var valdesconto			= 0;
	var valtotal				= 0;
	var valtotcorr			= 0
	var valtotjuros			= 0;
	var valtotmulta			= 0;

	for (x = 0; x < valoresportipo.length; x++) {
	  if (valoresportipo[x] == '') {
			continue;
		}
		var valores = valoresportipo[x].split('-');

		var cadtipoparc	=	valores[1];
		var valcorr			= new Number(valores[3]);
		var valjuros		= new Number(valores[4]);
		var valmulta		= new Number(valores[5]);

		if (cadtipoparc > 0) {
			valdesconto += (valjuros * descontojur / 100) + (valmulta * descontomul / 100);
			valtotal		+= valcorr + (valjuros + valmulta) - valdesconto;
	  } else {
			valtotal		+= valcorr + valjuros + valmulta;
		}

    valtotcorr	= valtotcorr + valcorr;
		valtotjuros = valtotjuros + valjuros;
		valtotmulta	= valtotmulta + valmulta;

	}

	valtotal = valtotal.toFixed(2);

	if (forma == 2) {
    valor = new Number(document.form1.valorcorr.value);
		valor = valor / (new Number(id) - 1);
		valor = new String(valor);
	} else {
    valor = parcelas.document.getElementById(id).innerHTML;
	}

  if(valor.indexOf(",") != -1){
    valor = new String(valor);
    valor = valor.replace('.','');
    valor = valor.replace(',','.');
    valor = new Number(valor);
  }

  valentrada = Math.round(id);

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

	if (valentrada < entradaminima) {
		valentrada = entradaminima;
	}

  document.form1.ent.value = valentrada;

  if (forma == 2) {

    valtotalsemdesconto = valtotal;

    x = (valtotcorr - document.form1.ent.value)/(document.form1.parc.value-1);
    document.form1.parcval.value = x.toFixed(2);
    x = document.form1.parc.value * document.form1.parcval.value;
//    x = valtotal - eval(x +'+'+ document.form1.ent.value)

    document.form1.parcult.value = (valtotjuros + valtotmulta).toFixed(2);

    parcelas.document.getElementById('vtcomdesconto').innerHTML = valtotalsemdesconto;

  } else {

    x = (valtotal - document.form1.ent.value)/document.form1.parc.value;
    document.form1.parcval.value = x.toFixed(2);
    x = document.form1.parc.value * document.form1.parcval.value;

    x = valtotal - eval(x +'+'+ document.form1.ent.value)
    document.form1.parcult.value = eval(document.form1.parcval.value +'+'+ x).toFixed(2);

    parcelas.document.getElementById('vtcomdesconto').innerHTML = valtotal;

  }

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

		var tipo1 = document.form1.tiposparc.value.split("-");
		var parcela = Number(document.form1.parc.value);
		var parcela = parcela + 1;

		for (contatipo = 0; contatipo < tipo1.length; contatipo++) {
			var tipo2 = tipo1[contatipo].split("=");

			var forma = tipo2[5];

			var entradaminima = tipo2[4];

			if (parcela >= ultparc && parcela <= tipo2[1]) {
				var descontomul = tipo2[2];
				var descontojur = tipo2[3];
				break;
			}

			var ultparc = tipo2[1];

		}

    if(entrada.indexOf(",") != -1){
      entrada = new String(entrada)
      entrada = entrada.replace(',','.');
      document.form1.ent.value = entrada;
    }

		var valoresportipo	= document.form1.valoresportipo.value.split("=");
		var valdesconto			= 0;
		var valtotal				= 0;

		for (x = 0; x < valoresportipo.length; x++) {
			if (valoresportipo[x] == '') {
				continue;
			}
			var valores = valoresportipo[x].split('-');

			var cadtipoparc	=	valores[1];
			var valcorr			= new Number(valores[3]);
			var valjuros		= new Number(valores[4]);
			var valmulta		= new Number(valores[5]);

			if (cadtipoparc > 0) {
				valdesconto += (valjuros * descontojur / 100) + (valmulta * descontomul / 100);
				valtotal		+= valcorr + (valjuros + valmulta) - valdesconto;
			} else {
				valtotal		+= valcorr + valjuros + valmulta;
			}

		}

		valtotal = valtotal.toFixed(2);

		if (forma == 2) {

			quantparcelas = new Number(document.form1.parc.value);
			valorparcela = new Number(document.form1.parcval.value);
			valorultima = new Number(document.form1.parcult.value);
			valentrada = new Number(document.form1.ent.value);

			valortotal = (valorparcela * (quantparcelas - 1)) + valorultima;
			valortotal = Number(document.form1.valorcorr.value);

			valcadaparcela =  (Math.round(( (valortotal - valentrada)/(quantparcelas-1)) * 100))/100;

			document.form1.parcval.value = valcadaparcela;

			valorsomenteparcelas = document.form1.parcval.value * (quantparcelas -2);

			valorultima = valorultima.toFixed(2);

			document.form1.parcult.value = valorultima;

		} else {

			quantparcelas = new Number(document.form1.parc.value);
			valorparcela = new Number(document.form1.parcval.value);
			valorultima = new Number(document.form1.parcult.value);
			valentrada = new Number(document.form1.ent.value);

			valortotal = (valorparcela * (quantparcelas - 1)) + valorultima;
			valortotal = new Number(parcelas.document.getElementById('vtcomdesconto').innerHTML);

			valcadaparcela =  (Math.round(( (valortotal - valentrada)/quantparcelas  ) * 100))/100;

			document.form1.parcval.value = valcadaparcela;

			valorsomenteparcelas = document.form1.parcval.value * (quantparcelas -1);

			valorultima = valortotal - valorsomenteparcelas - valentrada;
			valorultima = valorultima.toFixed(2);

			document.form1.parcult.value = valorultima;

		}

		document.form1.dia.focus();


    for(i=2;i<500;i++){
      parcelas.document.getElementById('val'+i).checked = false;
    }

  }

}
function js_troca_valores_parc(valor) {

	return true;

  if(isNaN(valor)){
    alert('campo valor da parcela deve ser preenchido somente com números');
    document.form1.parcval.value = '';
    document.form1.parcval.focus();
  } else if(valor <= 0){
    alert('Valor da parcela deve ser maior que 0');
    document.form1.parcval.value = '';
    document.form1.parcval.focus();
  }else{

    valentrada = document.form1.ent.value;
    valorparcela = new Number(document.form1.parc.value);
    quantparcelas = new Number(document.form1.parcval.value);
    valorultima = new Number(document.form1.parcult.value);

    valortotal = new Number(parcelas.document.getElementById('vtcomdesconto').innerHTML);

    ultimaparcela = valortotal - valentrada - (quantparcelas * (valorparcela -1));

    ultimaparcela = (Math.round(ultimaparcela*100))/100;

    maximoparc = (valortotal - valentrada) / valorparcela;
    maximoparc = (Math.round(maximoparc*100))/100;

    if (ultimaparcela < 0) {
      alert('Valor de cada parcela nao pode ultrapassar ' + maximoparc);
    } else {
      document.form1.parcult.value = ultimaparcela;
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
function js_reload(valor){
  document.form1.k40_cadtipoparc.value = valor;
  document.form1.submit();
}
</script>
</center>
</form>
</body>
</html>
<?
?>
