<?php

 include(__DIR__ . "/../../libs/db_conn.php");
 if (!($conn = @pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "Erro ao conectar com a base de dados";
  exit;
 }

 $aHistCalc = array();
 $aHistCalc[0]["cod"] = 400;
 $aHistCalc[0]["descr"] = "RECIBO JUROS";
 $aHistCalc[1]["cod"] = 401;
 $aHistCalc[1]["descr"] = "RECIBO MULTA";
 $aHistCalc[2]["cod"] = 500;
 $aHistCalc[2]["descr"] = "RECIBO JUROS";
 $aHistCalc[3]["cod"] = 501;
 $aHistCalc[3]["descr"] = "RECIBO MULTA";
 $aHistCalc[4]["cod"] = 502;
 $aHistCalc[4]["descr"] = "RECIBO PROTOCOLO";
 $aHistCalc[5]["cod"] = 503;
 $aHistCalc[5]["descr"] = "RECIBO PLANILHA";
 $aHistCalc[6]["cod"] = 602;
 $aHistCalc[6]["descr"] = "PGTO RECIBO PROTOCOL";
 $aHistCalc[7]["cod"] = 605;
 $aHistCalc[7]["descr"] = "CONTRIB.MELHORIA";
 $aHistCalc[8]["cod"] = 705;
 $aHistCalc[8]["descr"] = "PAGTO CONT.MELH";
 $aHistCalc[9]["cod"] = 707;
 $aHistCalc[9]["descr"] = "RECIBO ITBI";
 $aHistCalc[10]["cod"] = 807;
 $aHistCalc[10]["descr"] = "PAG. RECIBO ITBI";
 $aHistCalc[11]["cod"] = 918;
 $aHistCalc[11]["descr"] = "DESCONTO";
 $aHistCalc[12]["cod"] = 990;
 $aHistCalc[12]["descr"] = "PAGTO PARCELA UNICA";
 $aHistCalc[13]["cod"] = 991;
 $aHistCalc[13]["descr"] = "PAGTO PARCELA";
 $aHistCalc[14]["cod"] = 1000;
 $aHistCalc[14]["descr"] = "AUTENTICA PLANILHA";
 $aHistCalc[15]["cod"] = 1001;
 $aHistCalc[15]["descr"] = "ESTORNA PLANILHA";
 $aHistCalc[16]["cod"] = 1018;
 $aHistCalc[16]["descr"] = "PAGTO DESCONTO";

 $lErro = false;
 pg_query("Begin");
 pg_query("select fc_startsession()");
 for ($x = 0 ; $x < count($aHistCalc); $x ++) {
 	$rsHistCalc = pg_query("select * from histcalc where k01_codigo = ".$aHistCalc[$x]["cod"]);
 	if (pg_num_rows($rsHistCalc) == 0) {
 		
 		$rsInsert = pg_query("insert into histcalc(k01_codigo,k01_descr,k01_tipo) values(".$aHistCalc[$x]["cod"].",'".$aHistCalc[$x]["descr"]."','')");
 		if (!$rsInsert) {
 			echo "Erro ao incluir o histórico ".$aHistCalc[$x]["cod"]." - ".$aHistCalc[$x]["descr"]." Erro: ".pg_last_error()."\n";
 			$lErro = true;
 		}
 	}
 }
 
 if ($lErro) {
 	echo "Operacao nao realizada!\n";
 	pg_query("rollback");
 } else {
 	echo "Operacao realizada com sucesso!\n";
 	pg_query("commit");
 }
 
?>