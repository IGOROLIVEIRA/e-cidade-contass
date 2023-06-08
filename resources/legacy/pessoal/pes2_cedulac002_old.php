<?

include ("libs/db_stdlib.php");
include ("libs/db_libpessoal.php");
require ("libs/db_conecta.php");
include ("libs/db_sessoes.php");
include ("libs/db_usuariosonline.php");
include("fpdf151/pdf.php");
include("libs/db_sql.php");
include("dbforms/db_funcoes.php");

fpag12g();

function fpag12g() {

	global $pessoal1, $work, $diversos, $d902, $ano, $mes, $subatual;

	$alfab = 'a';
	$ano = '2005';
	$mes13 = 0;
	$subatual = '2006/02';
	$subpes = $subatual;

	$condicao .= " and substr( r01_admiss,1,4 ) <= ".db_sqlformat($ano);
	$condicao .= " and ( r01_recis is null ";
	$condicao .= "       or ( r01_recis is not null and substr(r01_recis,1,4) >= ".db_sqlformat($ano)." ) )";

	$condicao .= " and r01_regist = 230 ";

	$campos = " r01_regist,r01_numcgm,r01_lotac,r01_tpvinc,r01_admiss,";
	$campos .= " r01_recis,r01_tbprev,r01_nasc, z01_numcgm, z01_nome, z01_cgccpf ";
	db_selectmax("pessoal1", "select ".$campos." from pessoal inner join cgm on r01_numcgm = z01_numcgm ".bb_condicaosubpesproc("r01_", $subatual).$condicao);

	//  echo "<br>"."select ".$campos." from pessoal inner join cgm on r01_numcgm = z01_numcgm ".bb_condicaosubpesproc( "r01_", $subatual ).$condicao ;
	//  echo "<br>"."count : ".count($pessoal);

	$work = cria_work_12g();

	//  declare matriz1[ 5 ], matriz2[ 5 ]
	$matriz1[1] = "w_matric";
	$matriz1[2] = "w_nome";
	$matriz1[3] = "w_cpf";
	$matriz1[4] = "w_situa";
	$matriz1[5] = "w_lotac";

	for ($Ipessoal1 = 0; $Ipessoal1 < count($pessoal1); $Ipessoal1 ++) {
		//echo "<br>".$Ipessoal." / ".count($pessoal)."  ".$pessoal[$Ipessoal]["r01_regist"];
		$matriz2[1] = $pessoal1[$Ipessoal1]["r01_regist"];
		$matriz2[2] = $pessoal1[$Ipessoal1]["z01_nome"];
		$matriz2[3] = $pessoal1[$Ipessoal1]["z01_cgccpf"];
		$matriz2[4] = $pessoal1[$Ipessoal1]["r01_tpvinc"];
		$matriz2[5] = $pessoal1[$Ipessoal1]["r01_lotac"];

		db_insert($work, $matriz1, $matriz2);
	}

	$indice = ($alfab = "a" ? " order by w_nome " : " order by w_matric ");

	db_selectmax($work, "select * from ".$work.$indice);

	ficha_12g();

//		for ($Iwork = 0; $Iwork < pg_numrows($res_work); $Iwork ++) {
//			db_fieldsmemory($res_work,$Iwork,0,1);
//
//	db_selectmax($work, "select * from ".$work.$indice);

//	imprime_12g();
$res_work = pg_query("select * from ".$work);
		db_criatabela($res_work);
}

function ficha_12g($max = null, $ant = null, $ultmes = null, $mes = null, $data = null, $ufir = null, $sal = null, $sal13 = null, $irrf = null, $familia = null, $previd = null, $privad = null) {

	global $diversos, $ant, $ultmes, $work, $ano, $mes, $ndias, $pessoal,
	       $inssirf, $gerfsal, $gerfres, $gerfcom, $gerfs13, $basesr, $subatual,
	       $w_matric,$w_contr,$w_pensao,$w_irfonte,$w_familia,$w_parte,$w_diaria,$w_aviso,
	       $w_rendim,$w_outros5,$w_sal13,$w_lucro,$w_outros6,$w_privad,$w_dmedic,$w_bruta13,
	       $w_vlirf13,$w_vldep13,$w_previ13,$w_depend,$w_palime13;
	//  $max = lastrec("work");
	$ant = subpes;
	$ultmes = 12;

	//$declare matriz1[ 21 ], matriz2[ 21 ];
	$matriz = array ();
	$matriz2 = array ();

	$matriz1[1]  = "w_salario";
	$matriz1[2]  = "w_contr";
	$matriz1[3]  = "w_pensao";
	$matriz1[4]  = "w_irfonte";
	$matriz1[5]  = "w_familia";
	$matriz1[6]  = "w_parte";
	$matriz1[7]  = "w_diaria";
	$matriz1[8]  = "w_aviso";
	$matriz1[9]  = "w_rendim";
	$matriz1[10] = "w_outros5";
	$matriz1[11] = "w_sal13";
	$matriz1[12] = "w_lucro";
	$matriz1[13] = "w_outros6";
	$matriz1[14] = "w_privad";
	$matriz1[15] = "w_dmedic";
	$matriz1[16] = "w_bruta13";
	$matriz1[17] = "w_vlirf13";
	$matriz1[18] = "w_vldep13";
	$matriz1[19] = "w_previ13";
	$matriz1[20] = "w_depend";
	$matriz1[21] = "w_palime13";

	for ($mes = 1; $mes <= $ultmes; $mes ++) {
		$achoudependentenosalario = false;

		$subpes = $ano."/".db_str($mes, 2, 0, "0");
		$condicaoaux = " and r07_codigo = 'D902'";
		if (db_selectmax("diversos", "select * from pesdiver ".bb_condicaosubpes("r07_").$condicaoaux)) {
			$d902 = $diversos[0]["r07_valor"];
		} else {
			$d902 = 0;
		}
		$data = "01/".db_str($mes, 2, 0, "0")."/".$ano;
		$palime13 = 0;
		$depend = 0;

		$res_ndias = pg_query("select ndias(".$ano.",".$mes.")");
		db_fieldsmemory($res_ndias, 0);

		$diasn = $ndias;
		$res_work = pg_query("select * from ".$work);
		
		$datet = $diasn."/".db_str($mes, 2, 0, "0")."/".$ano;
		for ($Iwork = 0; $Iwork < pg_numrows($res_work); $Iwork ++) {
			db_fieldsmemory($res_work,$Iwork);

			$matricula     = $w_matric;
			$ina           = 0;
			$soma          = 0;
			$soma13        = 0;
			$irrf          = 0;
			$familia       = 0;
			$previd        = 0;
			$privad        = 0;
			$palime        = 0;
			$palime13      = 0;
			$depend        = 0;
			$diaria        = 0;
			$dmedic        = 0;
			$vldep13       = 0;
			$vlirf13       = 0;
			$previ13       = 0;
			$bruta13       = 0;
			$vdeducao65    = 0;
			$vdeducao65_13 = 0;
			$vdeducao      = 0;
			$vdeducao_13   = 0;
			if (empty ($w_matric)) {
				continue;
			}

			$condicaoaux = " and r01_regist = ".$matricula;
			db_selectmax("pessoal", "select *,fc_idade(r01_nasc,'".$datet."') as idade from pessoal ".bb_condicaosubpesproc("r01_",$subpes).$condicaoaux);

			if (count($pessoal) == 0) {
				continue;
			}

			$idade = $pessoal[0]["idade"];
			$mtab  = $pessoal[0]["r01_tbprev"];

			///// VER_IDADE

			$condicaoaux = " and r33_codtab = ".db_sqlformat($mtab +2);
			db_selectmax("inssirf", "select * from inssirf ".bb_condicaosubpesproc("r33_", $subatual).$condicaoaux);
			$condicaoaux = " and r14_regist = ".db_sqlformat($matricula);
			if (db_selectmax("gerfsal", "select * from gerfsal ".bb_condicaosubpesproc("r14_",$subpes).$condicaoaux)) {
				som2000_12g($gerfsal, "r14_", &$soma, &$soma13, &$irrf, &$familia, &$previd, &$privad, &$depend, &$diaria, &$palime, &$palime13, &$dmedic, &$familia, &$vlirf13, &$vldep13, &$previ13, &$bruta13, &$vdeducao65, &$vdeducao65_13, &$vdeducao, &$vdeducao_13);
			}
			$condicaoaux = " and r20_regist = ".db_sqlformat($matricula);
			if (db_selectmax("gerfres", "select * from gerfres ".bb_condicaosubpesproc("r20_",$subpes).$condicaoaux)) {
				som2000_12g($gerfres, "r20_", &$soma, &$soma13, &$irrf, &$familia, &$previd, &$privad, &$depend, &$diaria, &$palime, &$palime13, &$dmedic, &$familia, &$vlirf13, &$vldep13, &$previ13, &$bruta13, &$vdeducao65, &$vdeducao65_13, &$vdeducao, &$vdeducao_13);

			}
			$condicaoaux = " and r35_regist = ".db_sqlformat($matricula);
			if (db_selectmax("gerfs13", "select * from gerfs13 ".bb_condicaosubpesproc("r35_",$subpes).$condicaoaux)) {
				som2000_12g($gerfs13, "r35_", &$soma, &$soma13, &$irrf, &$familia, &$previd, &$privad, &$depend, &$diaria, &$palime, &$palime13, &$dmedic, &$familia, &$vlirf13, &$vldep13, &$previ13, &$bruta13, &$vdeducao65, &$vdeducao65_13, &$vdeducao, &$vdeducao_13);
			}
			$condicaoaux = " and r48_regist = ".db_sqlformat($matricula);
			if (db_selectmax("gerfcom", "select * from gerfcom ".bb_condicaosubpesproc("r48_",$subpes).$condicaoaux)) {

				///  CUIDAR COM AS DEDUCOES R984....;

				som2000_12g($gerfcom, "r48_", &$soma, &$soma13, &$irrf, &$familia, &$previd, &$privad, &$depend, &$diaria, &$palime, &$palime13, &$dmedic, &$familia, &$vlirf13, &$vldep13, &$previ13, &$bruta13, &$vdeducao65, &$vdeducao65_13, &$vdeducao, &$vdeducao_13);
			}

			$soma13 = $bruta13;

			/// LIQUIDO DO 13.SALARIO
			$soma13 -= ($previ13 + $vldep13 + $vlirf13 + $palime13);
			if ($soma13 < 0) {
				$soma13 = 0;
			}
			if ($pessoal[0]["r01_tpvinc"] == "I" || $pessoal[0]["r01_tpvinc"] == "P" && ($idade > 65 || ($idade == 65 && month($pessoal[0]["r01_nasc"]) <= $mes))) {
				if ($vdeducao65 == 0 && $soma < $d902) {
					$vdeducao65 = $d902;
				}
				if ($vdeducao65_13 == 0 && $soma13 < $d902) {
					$vdeducao65_13 = $d902;
				}

				if ($soma >= $vdeducao65) {
					$ina += $vdeducao65;
					$soma -= $vdeducao65;
				} else {
					$ina += $soma;
					$soma = 0;
				}
				if ($soma13 >= $vdeducao65_13) {
					$ina += $vdeducao65_13;
					$soma13 -= $vdeducao65_13;
				}
				elseif ($soma13 > 0) {
					$ina += $soma13;
					$soma13 = 0;
				}
			}

			$campo_w_sal13 = $w_sal13;
			$campo_w_bruta13 = $w_bruta13;
			if ($bruta13 != 0) {
				if ((empty ($pessoal[0]["r01_recis"]) && $mes <= $mes13) || (!empty ($pessoal[0]["r01_recis"]) && $mes <= month($pessoal[0]["r01_recis"])) || (!empty ($pessoal[0]["r01_recis"]) && $mes13 == month($pessoal[0]["r01_recis"])));
				$campo_w_sal13 = 0;
				$campo_w_bruta13 = 0;
			}
		}

		$matriz2[1] = $w_salario += $soma;
		$matriz2[2] = $w_contr   += $previd;
		$matriz2[3] = $w_pensao  += $palime;
		$matriz2[4] = $w_irfonte += $irrf;
		$matriz2[5] = $w_familia += $familia;
		if ($pessoal[0]["r01_tpvinc"] == "I" || $pessoal[0]["r01_tpvinc"] == "P" && $idade >= 65) {
			$matriz2[6] = $w_parte += $ina;
		} else {
			$matriz2[6] = $w_parte + 0;
		}

		$matriz2[7]  = $w_diaria  + $diaria;
		$matriz2[8]  = $w_aviso   + $aviso;
		$matriz2[9]  = $w_rendim  + $rendim;
		$matriz2[10] = $w_outros5 + $outros5;
		if ($soma13 != 0) {
			$matriz2[11] = $campo_w_sal13 += $soma13;
		} else {
			$matriz2[11] = $campo_w_sal13 + 0;
		}
		$matriz2[12] = $w_lucro         +=  $lucro;
		$matriz2[13] = $w_outros6       +=  $outros6;
		$matriz2[14] = $w_privad        += $privad;
		$matriz2[15] = $w_dmedic        += $dmedic;
		$matriz2[16] = $campo_w_bruta13 +=  $bruta13;
		$matriz2[17] = $w_vlirf13       += $vlirf13;
		if ($vldep13 != 0 && $bruta13 != 0) {
			$matriz2[18] = $w_vldep13 += $vldep13;
		} else {
			$matriz2[18] = $w_vldep13 + 0;
		}
		$matriz2[19] = $w_previ13  += $previ13;
		$matriz2[20] = $w_depend   += $depend;
		$matriz2[21] = $w_palime13 += $palime13;

//echo "<br> soma irrf ".$w_irfonte;

		//$select "work";

		$condicaoaux = " where w_matric = ".db_sqlformat($matricula);
		db_update ($work, $matriz1, $matriz2, $condicaoaux);
		//$sqlcommit ();

	}
	$subpes = $ant;
	//////////  $release all except "r11_*" ;
	return;
}

function soma_12g($campo = null, $sal13 = null, $pre13 = null) {

	$matric = $campo."regist";
	$rubrica = $campo."rubric";
	$valor = $campo."valor";
	$pd = $campo."pd";
	$soma = 0;

	if (str_val($ano) < 1996) {
		while ($work[$Iwork]["w_matric"] == $matric) {
			if ($rubrica == "R913" || $rubrica == "R914" || $rubrica == "R915") {
				if ($pd == 1) {
					$irrf -= $valor;
				} else {
					$irrf += $valor;
				}
			} else {
				if ($rubrica == "R918" || $rubrica == "R919" || $rubrica == "R920" || $rubrica == "R921") {
					$familia += $valor;
				} else {
					if ($rubrica == "R993") {
						$previd += $valor;
					} else {
						if ($pd == 1 && str_val(db_substr($rubrica, 1, 3)) < 950) {
							$soma += $valor;
						}
					}
				}
			}
		}
	} else {
		//     $nreg   = recno();
		$prev13 = 0;
		while ($work[$Iwork]["w_matric"] == $matric) {
			if ($rubrica == "R913" || $rubrica == "R915") {
				$irrf += $valor;
			} else {
				if ($rubrica == "R918" || $rubrica == "R919" || $rubrica == "R920" || $rubrica == "R921") {
					$familia += $valor;
				} else {
					if ($rubrica == "R994" && $campo == "gerfs13->r35_") {
						$soma += $valor;
					}
					if (($rubrica == "R901" || $rubrica == "R903" || $rubrica == "R904" || $rubrica == "R906" || $rubrica == "R907" || $rubrica == "R909" || $rubrica == "R910" || $rubrica == "R912") && $campo != "gerfs13->r35_") {
						if ($inssirf[0]["r33_tipo"] == "O" && $tab != 0) {
							$previd += $valor;
						} else {
							$privad += $valor;
						}
					}
				}
			}
			$mrubr = $rubrica;
			//	$selant = alias();

			///// B004 - BASE IRRF SOBRE SALARIO
			$condicaoaux = " and r09_base = ".db_sqlformat("B004");
			$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
			if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux) && $campo != "gerfs13->r35_") {
				if ($pd == 1) {
					$soma += $valor;
				} else {
					$soma -= $valor;
				}
			}

			///// B005 - BASE IRRF SOBRE FERIAS
			$condicaoaux = " and r09_base = ".db_sqlformat("B005");
			$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
			if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux) && $campo != "gerfs13->r35_") {
				if ($pd == 1) {
					$soma += $valor;
				} else {
					$soma -= $valor;
				}
			}

			//// B904 - PAGTO DE 13 SALARIO FORA DA FOLHA
			$condicaoaux = " and r09_base = ".db_sqlformat("B904");
			$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
			if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux) && $campo != "gerfs13->r35_") {
				if ($pd == 1) {
					$sal13 += $valor;
				} else {
					$sal13 -= $valor;
				}
			}

			//// B905 - PENSAO ALIMENTICIA
			$condicaoaux = " and r09_base = ".db_sqlformat("B905");
			$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
			if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", subatual).$condicaoaux)) {
				if ($pd == 1) {
					$palime -= $valor;
				} else {
					$palime += $valor;
				}
			}

			//// B901 - PLANO DE SAUDE
			$condicaoaux = " and r09_base = ".db_sqlformat("B901");
			$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
			if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
				$dmedic += $valor;
			}
		}
		if ($previd == 0 && $privad == 0) {
			while ($work[$Iwork]["w_matric"] == $matric) {
				$condicaoaux = " and r09_base = ".db_sqlformat("B904");
				$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
				if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux) && $campo != "gerfs13->r35_") {
					if ($pd == 1) {
						$sal13 += $valor;
					} else {
						$sal13 -= $valor;
					}
				}
				$condicaoaux = " and r09_base = ".db_sqlformat("B905");
				$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
				if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
					if ($pd == 1) {
						$palime -= $valor;
					} else {
						$palime += $valor;
					}
				}
				$condicaoaux = " and r09_base = ".db_sqlformat("B901");
				$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
				if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
					$dmedic += $valor;
				}
			}

		}
		if ($previd == 0 && $privad == 0) {
			//	$go nreg;
			while ($work[$Iwork]["w_matric"] == $matric) {
				if (($rubrica == "R901" || $rubrica == "R903" || $rubrica == "R904" || $rubrica == "R906" || $rubrica == "R907" || $rubrica == "R909" || $rubrica == "R910" || $rubrica == "R912") && $campo != "gerfs13->r35_") {
					if ($inssirf[0]["r33_tipo"] == "O") {
						$previd += $valor;
					} else {
						$privad += $valor;
					}
				}
			}
		}
		if ($campo == "gerfs13->r35_" && $soma == 0) {
			//	$selant = alias();
			//	$go nreg;
			$prev13 = 0;
			while ($work[$Iwork]["w_matric"] == $matric) {
				if ($rubrica == "R902" || $rubrica == "R905" || $rubrica == "R908" || $rubrica == "R911") {
					if ($inssirf[0]["r33_tipo"] == "O") {
						$prev13 += $valor;
					} else {
						$prev13 += $valor;
					}
				}
				$mrubr = $rubrica;
				//	   $selant = alias();

				//// B006 - BASE IRRF SOBRE 13 SALARIO
				$condicaoaux = " and r09_base = ".db_sqlformat("B006");
				$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
				if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
					if ($pd == 1) {
						$soma += $valor;
					} else {
						$soma -= $valor;
					}
				}
			}
			$soma = $soma - $prev13;
			if ($soma < 0) {
				$soma = 0;
			}
		}
	}
	return $soma;
}

function som2000_12g($arquivo, $campo, $soma, $soma13, $irrf, $familia, $previd, $privad, $depend, $diaria, $palime, $palime13, $dmedic, $familia, $vlirf13, $vldep13, $previ13, $bruta13, $vdeducao65, $vdeducao65_13, $vdeducao, $vdeducao_13) {

	global $ano, $mes, $subatual, $mrubr, $work;
	//$matric  = $campo."regist";
	//$rubrica = $campo."rubric";
	//$valor   = $campo."valor";
	//$pd      = $campo."pd";

	//$lercomplementar = iif(  subpes >= dataalteraferias, true, false );

	$lercomplementar = true;

	for ($Iarquivo = 0; $Iarquivo < count($arquivo); $Iarquivo ++) {
		//echo '   arquivo : '.$arquivo[$Iarquivo]["$campo"."rubric"].'   sdfsdf ';
		$mrubr = $arquivo[$Iarquivo]["$campo"."rubric"];
		//echo "<br>"." Mes  ".$mes."  rubrica ".$arquivo[$Iarquivo]["$campo"."rubric"]." Valor : ".$arquivo[$Iarquivo]["$campo"."valor"];
		//echo "<br><br>"." mes :   ".$mes."  soma  ".$soma;
		if (($arquivo[$Iarquivo]["$campo"."rubric"] == "R981" || $arquivo[$Iarquivo]["$campo"."rubric"] == "R983")) {
			if ($campo != "r48_" || ($campo == "r48_" && $lercomplementar)) {
				$soma += $arquivo[$Iarquivo]["$campo"."valor"];
			}
		} else {
			if ($arquivo[$Iarquivo]["$campo"."rubric"] == "R982") {
				if (($campo != "r48_") || ($campo == "r48_" && $lercomplementar)) {
					$bruta13 += $arquivo[$Iarquivo]["$campo"."valor"];
				}
			} else {
				if ($arquivo[$Iarquivo]["$campo"."rubric"] == "R984") {
					if ($campo == "r35_") {
		//echo "<br>"." Mes  ".$mes."  rubrica ".$arquivo[$Iarquivo]["$campo"."rubric"]." Valor : ".$arquivo[$Iarquivo]["$campo"."valor"]."  campo  :  ".$campo;
						if (!empty ($vldep13) && !empty ($arquivo[$Iarquivo]["$campo"."valor"])) {
							$vldep13 = 0;
						}
						$vldep13 += $arquivo[$Iarquivo]["$campo"."valor"];
					//	echo "<br>".$vldep13;
					} else
						if ($campo == "r48_" && $lercomplementar) {
							if (empty ($depend)) {
								$depend += $arquivo[$Iarquivo]["$campo"."valor"];
							}
						} else
							if ($campo != "r48_") {
								$depend += $arquivo[$Iarquivo]["$campo"."valor"];
							}
				}
				if ($lercomplementar && $arquivo[$Iarquivo]["$campo"."rubric"] == "R997" || $arquivo[$Iarquivo]["$campo"."rubric"] == "R999") {
					if ($campo == "r35_") {
						if (!empty ($vdeducao65_13) && !empty ($arquivo[$Iarquivo]["$campo"."valor"])) {
							$vdeducao65_13 = 0;
						}
						$vdeducao65_13 += $arquivo[$Iarquivo]["$campo"."valor"];
					} else
						if ($campo == "r48_" && $lercomplementar) {
							if (empty ($vdeducao65)) {
								$vdeducao65 += $arquivo[$Iarquivo]["$campo"."valor"];
							}
						} else
							if ($campo == "r31_") {
								if (empty ($vdeducao65)) {
									$vdeducao65 += $arquivo[$Iarquivo]["$campo"."valor"];
								}
							} else
								if ($campo != "r48_") {
									$vdeducao65 += $arquivo[$Iarquivo]["$campo"."valor"];
								}
				}

				//$selant = alias();
				//// B911 - BASE BRUTA PAGA FOLHA DA FOLHA
				$condicaoaux = " and r09_base = ".db_sqlformat("B911");
				$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
				if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
		
					if ($arquivo[$Iarquivo]["$campo"."pd"] == 2) {
						$soma -= $arquivo[$Iarquivo]["$campo"."valor"];
					} else {
						$soma += $arquivo[$Iarquivo]["$campo"."valor"];
					}
				}
				if (($campo != "r48_") || ($campo == "r48_" && $lercomplementar)) {

					//// DESCONTO IRRF EXCETO 13 SALARIO
					$condicaoaux = " and r09_base = ".db_sqlformat("B906");
					$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
					if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
						if ($arquivo[$Iarquivo]["$campo"."pd"] == 2) {
							$irrf += $arquivo[$Iarquivo]["$campo"."valor"];
						} else {
							$irrf -= $arquivo[$Iarquivo]["$campo"."valor"];
						}
					}
					
					//// B909 - DESCONTO IRRF DO 13 SALARIO
					$condicaoaux = " and r09_base = ".db_sqlformat("B909");
					$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
					if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
						if ($pd == 2) {
							$vlirf13 -= $arquivo[$Iarquivo]["$campo"."valor"];
						} else {
							$vlirf13 += $arquivo[$Iarquivo]["$campo"."valor"];
						}
					}

					//// B908 - DESCONTO DA PREVIDENCIA DO 13 SALARIO
					$condicaoaux = " and r09_base = ".db_sqlformat("B908");
					$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
					if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
						if ($arquivo[$Iarquivo]["$campo"."pd"] == 2) {
							$previ13 += $arquivo[$Iarquivo]["$campo"."valor"];
						} else {
							$previ13 -= $arquivo[$Iarquivo]["$campo"."valor"];
						}
					}

					//// B907 - DECONTO DA PREVIDENCIA EXCETO 13 SALARIO
					$condicaoaux = " and r09_base = ".db_sqlformat("B907");
					$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
					if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
						if ($inssirf[0]["r33_tipo"] == "O" && $pessoal[$Ipessoal]["r01_tbprev"] != 0) {
							if ($arquivo[$Iarquivo]["$campo"."pd"] == 2) {
								$previd += $arquivo[$Iarquivo]["$campo"."valor"];
							} else {
								$previd -= $arquivo[$Iarquivo]["$campo"."valor"];
							}
						} else {
							if ($arquivo[$Iarquivo]["$campo"."pd"] == 2) {
								$privad += $arquivo[$Iarquivo]["$campo"."valor"];
							} else {
								$privad -= $arquivo[$Iarquivo]["$campo"."valor"];
							}
						}
					}

					//// B910 - DESCONTO PREVIDENCIA PRIVADA DO 13 SALARIO
					$condicaoaux = " and r09_base = ".db_sqlformat("B910");
					$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
					if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
						if ($arquivo[$Iarquivo]["$campo"."pd"] == 2) {
							$privad += $arquivo[$Iarquivo]["$campo"."valor"];
						} else {
							$privad -= $arquivo[$Iarquivo]["$campo"."valor"];
						}
					}
				}

				/// B905 - PENSAO ALIMENTICIA
				$condicaoaux = " and r09_base = ".db_sqlformat("B905");
				$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
				if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
					if ($campo == "r35_" || (db_val($mrubr) >= 4000 && db_val($mrubr) < 6000)) {
						if ($arquivo[$Iarquivo]["$campo"."pd"] == 1) {
							$palime13 -= $arquivo[$Iarquivo]["$campo"."valor"];
						} else {
							$palime13 += $arquivo[$Iarquivo]["$campo"."valor"];
						}
					} else {
						if ($arquivo[$Iarquivo]["$campo"."pd"] == 1) {
							$palime -= $arquivo[$Iarquivo]["$campo"."valor"];
						} else {
							$palime += $arquivo[$Iarquivo]["$campo"."valor"];
						}

						$condicaoaux = " and r09_base = ".db_sqlformat("B004");
						$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
						if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpes("r09_").$condicaoaux)) {
		//echo "<br>"." campo 3".$campo."  rubrica ".$arquivo[$Iarquivo]["$campo"."rubric"];
							if ($arquivo[$Iarquivo]["$campo"."pd"] == 1) {
								$soma -= $arquivo[$Iarquivo]["$campo"."valor"];
							} else {
								$soma += $arquivo[$Iarquivo]["$campo"."valor"];
							}
						}
					}
				}

				//// B902 - SALARIO FAMILIA 
				$condicaoaux = " and r09_base = ".db_sqlformat("B902");
				$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
				if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
					if ($arquivo[$Iarquivo]["$campo"."pd"] == 1) {
						$familia += $arquivo[$Iarquivo]["$campo"."valor"];
					} else {
						$familia -= $arquivo[$Iarquivo]["$campo"."valor"];
					}
				}

				//// B903 - DIARIAS E AJUDA DE CUSTO
				$condicaoaux = " and r09_base = ".db_sqlformat("B903");
				$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
				if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
					if ($arquivo[$Iarquivo]["$campo"."pd"] == 1) {
						$diaria += $arquivo[$Iarquivo]["$campo"."valor"];
					} else {
						$diaria -= $arquivo[$Iarquivo]["$campo"."valor"];
					}
				}

				//// B901 - PLANO DE SAUDE
				$condicaoaux = " and r09_base = ".db_sqlformat("B901");
				$condicaoaux .= " and r09_rubric = ".db_sqlformat($mrubr);
				if (db_selectmax("basesr", "select * from basesr ".bb_condicaosubpesproc("r09_", $subatual).$condicaoaux)) {
					if ($arquivo[$Iarquivo]["$campo"."pd"] == 1) {
						$dmedic -= $arquivo[$Iarquivo]["$campo"."valor"];
					} else {
						$dmedic += $arquivo[$Iarquivo]["$campo"."valor"];
					}
				}
			}

		}
	}
	return;
}

function cria_work_12g() {

	//   $declare campo[26],tipo[26],tam[26],dec[26];
	$work = "arq1";
	$campo[1]  = "w_matric";
	$campo[2]  = "w_nome";
	$campo[3]  = "w_cpf";
	$campo[4]  = "w_salario";
	$campo[5]  = "w_contr";
	$campo[6]  = "w_pensao";
	$campo[7]  = "w_irfonte";
	$campo[8]  = "w_familia";
	$campo[9]  = "w_parte";
	$campo[10] = "w_diaria";
	$campo[11] = "w_aviso";
	$campo[12] = "w_rendim";
	$campo[13] = "w_outros5";
	$campo[14] = "w_sal13";
	$campo[15] = "w_lucro";
	$campo[16] = "w_outros6";
	$campo[17] = "w_situa";
	$campo[18] = "w_privad";
	$campo[19] = "w_dmedic";
	$campo[20] = "w_bruta13";
	$campo[21] = "w_vlirf13";
	$campo[22] = "w_vldep13";
	$campo[23] = "w_previ13";
	$campo[24] = "w_depend";
	$campo[25] = "w_palime13";
	$campo[26] = "w_lotac";

	$tipo[1]  = "n";
	$tipo[2]  = "c";
	$tipo[3]  = "c";
	$tipo[4]  = "n";
	$tipo[5]  = "n";
	$tipo[6]  = "n";
	$tipo[7]  = "n";
	$tipo[8]  = "n";
	$tipo[9]  = "n";
	$tipo[10] = "n";
	$tipo[11] = "n";
	$tipo[12] = "n";
	$tipo[13] = "n";
	$tipo[14] = "n";
	$tipo[15] = "n";
	$tipo[16] = "n";
	$tipo[17] = "c";
	$tipo[18] = "n";
	$tipo[19] = "n";
	$tipo[20] = "n";
	$tipo[21] = "n";
	$tipo[22] = "n";
	$tipo[23] = "n";
	$tipo[26] = "n";
	$tipo[25] = "n";
	$tipo[26] = "c";

	$tam[1]   = 6;
	$tam[2]   = 40;
	$tam[3]   = 11;
	$tam[4]   = 15;
	$tam[5]   = 15;
	$tam[6]   = 15;
	$tam[7]   = 15;
	$tam[8]   = 15;
	$tam[9]   = 15;
	$tam[10]  = 15;
	$tam[11]  = 15;
	$tam[12]  = 15;
	$tam[13]  = 15;
	$tam[14]  = 15;
	$tam[15]  = 15;
	$tam[16]  = 15;
	$tam[17]  = 1;
	$tam[18]  = 15;
	$tam[19]  = 15;
	$tam[20]  = 15;
	$tam[21]  = 15;
	$tam[22]  = 15;
	$tam[23]  = 15;
	$tam[24]  = 15;
	$tam[25]  = 15;
	$tam[26]  = 4;

	$dec[1]   = 0;
	$dec[2]   = 0;
	$dec[3]   = 0;
	$dec[4]   = 2;
	$dec[5]   = 2;
	$dec[6]   = 2;
	$dec[7]   = 2;
	$dec[8]   = 2;
	$dec[9]   = 2;
	$dec[10]  = 2;
	$dec[11]  = 2;
	$dec[12]  = 2;
	$dec[13]  = 2;
	$dec[14]  = 2;
	$dec[15]  = 2;
	$dec[16]  = 2;
	$dec[17]  = 0;
	$dec[18]  = 2;
	$dec[19]  = 2;
	$dec[20]  = 2;
	$dec[21]  = 2;
	$dec[22]  = 2;
	$dec[23]  = 2;
	$dec[24]  = 2;
	$dec[25]  = 2;
	$dec[26]  = 0;

	db_criatemp($work, $campo, $tipo, $tam, $dec, "work");

	return $work;
}
function imprime_12g(){
global $work,$pdf;

$indice = " order by ";
if( $glm == "o"){
   $indice .= " w_lotac, w_nome ";
}else{
   $indice .= " w_lotac, w_nome";
}else{
   $indice .= " w_nome";
}
global $work1;
db_selectmax( "work1", "select * from ".$work .$indice );

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;

   for($Iwork=0;$Iwork<count($work1);$Iwork++){
      //  para 1998 calcular o item abaixo.;
      $liq_13salario = $work1[$Iwork]["w_bruta13"] - $work1[$Iwork]["w_previ13"] - $work1[$Iwork]["w_vlirf13"] - $work1[$Iwork]["w_vldep13"] - $work1[$Iwork]["w_palime13"];
      //
      //// vale somente para bage, tirar qdo fazer em php, pois passaremos para outra instituiçao;
      if( db_val($work1[$Iwork]["w_lotac"]) >= 2200 and db_val($work1[$Iwork]["w_lotac"]) <= 2300){
         $d08_nome = "fundo de pensao e aposent. do servidor";
         $d08_cgc  = "04025494000110";
      }

          "Ministério da Fazenda               |          Comprovante de Rendimentos Pagos";
          "Secretaria da Receita Federal       |                  e de Retencao de         ";
          "                                    |              Imposto de Renda na Fonte    ";
          "                                    |                 Ano Calendario: "+$ano+"    ";
          "------------------------------------+------------------------------------------+";

         "1 - Fonte pagadora pessoa juridica ou pessoa fisica";
         "    Razao Social                                          Cnpj/Cpf";
              1234567890123456789012345678901234567890              11.111.111/1111-11;
         "    ".str_pad($d08_nome,40).bb_space(14).db_formatar($d08_cgc,"@r 99.999.999/9999-99");
         "    natureza do rendimento";
         "                          ";

         "2 - pessoa fisica beneficiaria dos rendimentos                                  ";
         "    cpf              nome completo                                  ";
         "    ".db_formatar($work1[$Iwork]["w_cpf"],"@r 999.999.999/99")."   ".$work1[$Iwork]["w_nome"];

         "3 - rendimentos tributaveis, deducoes e imposto retido na fonte                 ";
         "    01 - total dos rendimentos (inclusive ferias)............... ".db_formatar($work1[$Iwork]["w_salario"],"999,999,999.99");
         "    02 - contribuicao previdenciaria oficial.................... ".db_formatar($work1[$Iwork]["w_contr"],"999,999,999.99");
         "    03 - contribuicao a previdencia privada .................... ".db_formatar($work1[$Iwork]["w_privad"],"999,999,999.99") ;
         "    04 - pensao judicial (informe o beneficio no campo 06)...... ".db_formatar($work1[$Iwork]["w_pensao"],"999,999,999.99");
         "    05 - imposto retido na fonte................................ ".db_formatar($work1[$Iwork]["w_irfonte"],"999,999,999.99");

         "4 - rendimentos isentos e nao tributaveis                                       ";
         "    01 - parte dos proventos de aposentados (65 anos ou mais)... ".db_formatar($work1[$Iwork]["w_parte"],"999,999,999.99");
         "    02 - diarias e ajuda de custo............................... ".db_formatar($work1[$Iwork]["w_diaria"],"999,999,999.99");
         "    03 - pensao, aposent ou ref p/molest grave ou inv permanente ".db_formatar($work1[$Iwork]["w_aviso"],"999,999,999.99");
         "    04 - rendimento/lucro distribuido........................... ".db_formatar($work1[$Iwork]["w_rendim"],"999,999,999.99");
         "    05 - valores pagos ao titular/socio de micro/pequena empresa "."          0,00";
         "    06 - indenizacoes rescisao contrato, pdv e acidente trabalho "."          0,00";
         "    07 - outros (especificar)................................... ".db_formatar($work1[$Iwork]["w_outros5"],"999,999,999.99");

         "5 - rendimentos sujeitos a tributacao exclusiva (rendimento liquido)            ";
         "    01 - decimo terceiro salario................................ ".db_formatar($work1[$Iwork]["w_sal13"],"999,999,999.99");
         "    02 - outros (especificar)................................... ".db_formatar($work1[$Iwork]["w_outros6"],"999,999,999.99");

         "6 - informacoes complementares                                                  ";
         if( $work1[$Iwork]["w_dmedic"] != 0){
            "    desp medicas, planos de saude e reembolso p/ empregador .... ".db_formatar($work1[$Iwork]["w_dmedic"],"999,999,999.99");
         }
         if( db_val($ano) >= 1997){
            "    13o salario --- base bruta p/ irf ...........................".db_formatar($work1[$Iwork]["w_bruta13"],"999,999,999.99");
            "                    previdencia .................................".db_formatar($work1[$Iwork]["w_previ13"],"999,999,999.99");
            "                    vlrs ref dependentes.........................".db_formatar($work1[$Iwork]["w_vldep13"],"999,999,999.99");
            "                    irf .........................................".db_formatar($work1[$Iwork]["w_vlirf13"],"999,999,999.99");
            "                    pensao ......................................".db_formatar($work1[$Iwork]["w_palime13"],"999,999,999.99");
         }
         "registro : ".db_str($work1[$Iwork]["w_matric"],6)."-".db_mod11(db_str($work1[$Iwork]["w_matric"],6))." lotacao : ".$work1[$Iwork]["w_lotac"];

         "7 - responsavel pelas informacoes                                               ";
         "           nome                               data              assinatura     ";
         "responsavel+"     "+dtoc(date())+"   ______________________";
   }
   $pdf->Output();   
}   
?>

