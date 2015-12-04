<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("dbforms/db_funcoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_db_config_classe.php");

$cldb_config = new cl_db_config;


db_postmemory($HTTP_POST_VARS);
$situacao = "";
$erro=false;

$result=$cldb_config->sql_record($cldb_config->sql_query_file(db_getsession("DB_instit"),"cgc"));
db_fieldsmemory($result,0);

if(isset($processar)){
  // recebe codbco,codage,tamanho
  // verifica banco e agencia
  db_postmemory($_FILES["arqret"]);
  $arq_name    = basename($name);
  $arq_type    = $type;  
  $arq_tmpname = basename($tmp_name);
  $arq_size    = $size;
  $arq_array = file($tmp_name);
  
  system("cp -f ".$tmp_name." ".$DOCUMENT_ROOT."/tmp");

  $result = pg_exec("select 	k15_conta, k13_descr, k15_codbco, k15_codage, k15_posbco, k15_taman,
  				k15_codbco,k15_codage,k15_posbco,k15_poslan,k15_numbco,
                            	k15_pospag,k15_posvlr,k15_posacr,k15_posdes,
							k15_posced,k15_poscon,k15_posjur,k15_posmul, 
							k15_taman, k15_posdta,k15_numpre,k15_numpar,
							k15_pdmes,k15_pdano,k15_plmes,k15_plano,k15_ppmes,k15_ppano
                     from cadban
					      left outer join saltes on k15_conta = k13_conta
                     where k15_codbco = $k15_codbco and 
					       k15_codage  = '$k15_codage'");
  if(pg_numrows($result)==0){
    $erro_msg =  "Banco / Agencia nao cadastrados.";
    $erro = true;
  }
  if($erro==false){
    db_fieldsmemory($result,0);
    
    $_tamanprilinha = $arq_array[0];
    $atipo = substr($arq_array[0],0,3);
    $totalproc = sizeof($arq_array)-2;
    $priregistro = 1;
    $acodbco = substr($arq_array[0],substr($k15_posbco,0,3),substr($k15_posbco,3,3));

    if ($cgc == '88073291000199') { // bage
      if ( substr($arq_name,0,4) == "daeb" ) {

	if ( substr($arq_array[0],0,3) == "826" ) {
	  $_tamanprilinha = str_repeat(" ",$k15_taman);
	  $atipo          = "XXX";
          $totalproc = sizeof($arq_array);
          $priregistro = 0;
          $acodbco = 999;

	}

      }
    }

    if( strlen($_tamanprilinha) != $k15_taman){
      $erro_msg =  "Tamanho do registro [".strlen($arq_array[0])."] Sistema : [" .$k15_taman."] Inválido.";
      $erro = true;
    }else{
      if($k15_codbco != $acodbco and $atipo != "BSJ"){
        $erro_msg =  "Banco Digitado [$k15_codbco] não confere com o arquivo [$acodbco] especificado.";
        $erro = true;
      }else{
        $situacao = 1;
        $resultv = pg_exec("select codret as codretexiste,
                             k15_codbco as bancoexiste,
							 k15_codage as agenciaexiste,
							 dtarquivo as dtarquivoexiste
                      from disarq where arqret = '$arq_name'");
        if(pg_numrows($resultv)!=0)
           db_fieldsmemory($resultv,0); 
	  }






            $totalvalorpago=0;


              

	    for($i=$priregistro;$i <= $totalproc - ($priregistro == 0?1:0);$i++){
	      // grava arquivo disbanco

	      if($k15_taman==242){
		    if(substr($arq_array[$i],7,1)!='3' or substr($arq_array[$i],13,1)!='T' ){
		       continue;
		    }	
	      }
	      if($k15_taman==402){
		    if(substr($arq_array[$i],0,1) == '9'){
		       continue;
		    }	
	      }

	      if(substr($k15_plano,3,3)=='002')
		$dtarq = '20'.substr($arq_array[$i],substr($k15_plano,0,3)-1,substr($k15_plano,3,3));
	      else
		$dtarq = substr($arq_array[$i],substr($k15_plano,0,3)-1,substr($k15_plano,3,3));

	      $dtarq .= "-".substr($arq_array[$i],substr($k15_plmes,0,3)-1,substr($k15_plmes,3,3));
	      $dtarq .= "-".substr($arq_array[$i],substr($k15_poslan,0,3)-1,substr($k15_poslan,3,3));

	      if(substr($k15_ppano,3,3)=='002')
		$dtpago = '20'.substr($arq_array[$i],substr($k15_ppano,0,3)-1,substr($k15_ppano,3,3));
	      else
		$dtpago = substr($arq_array[$i],substr($k15_ppano,0,3)-1,substr($k15_ppano,3,3));

	      $dtpago .= "-".substr($arq_array[$i],substr($k15_ppmes,0,3)-1,substr($k15_ppmes,3,3));
	      $dtpago .= "-".substr($arq_array[$i],substr($k15_pospag,0,3)-1,substr($k15_pospag,3,3));
	      if ( $dtpago == '0000-00-00' ){
		   $dtpago = $dtarquivo;
		   $dtarq  = $dtarquivo;
	      }

	      $vlrpago	= (substr($arq_array[$i],substr($k15_posvlr,0,3)-1,substr($k15_posvlr,3,3))/100)+0;
	      $vlrjuros	= (substr($arq_array[$i],substr($k15_posjur,0,3)-1,substr($k15_posjur,3,3))/100)+0;
	      $vlrmulta	= (substr($arq_array[$i],substr($k15_posmul,0,3)-1,substr($k15_posmul,3,3))/100)+0;
	      $vlracres	= (substr($arq_array[$i],substr($k15_posacr,0,3)-1,substr($k15_posacr,3,3))/100)+0;
	      $vlrdesco	= (substr($arq_array[$i],substr($k15_posdes,0,3)-1,substr($k15_posdes,3,3))/100)+0;
	      $convenio	=  substr($arq_array[$i],substr($k15_poscon,0,3)-1,substr($k15_poscon,3,3));
	      $cedente	=  substr($arq_array[$i],substr($k15_posced,0,3)-1,substr($k15_posced,3,3));

              $totalvalorpago += $vlrpago;

	    }















	  
	}
  }
}else if(isset($geradisbanco)){
  $situacao = 2; 
  $result = pg_exec("select k15_codbco,k15_codage,k15_posbco,k15_poslan,k15_numbco,
                            k15_pospag,k15_posvlr,k15_posacr,k15_posdes,
							k15_posced,k15_poscon,k15_posjur,k15_posmul, 
							k15_taman, k15_posdta,k15_numpre,k15_numpar,
							k15_pdmes,k15_pdano,k15_plmes,k15_plano,k15_ppmes,k15_ppano
                     from cadban
                     where k15_codbco = $k15_codbco and 
					       k15_codage  = '$k15_codage'");
  db_fieldsmemory($result,0);
  $arq_array = file($DOCUMENT_ROOT."/tmp/".$arqret);
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
<body bgcolor=#CCCCCC bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>
</table>
<?
if($situacao == ""){
  include("forms/db_caiarq001.php");
}else if($situacao == 1){
  include("forms/db_caiarq002.php");
}else if($situacao == 2){
  include("forms/db_caiarq003.php");
}
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if($situacao == 1){
 if(isset($codretexiste) && $codretexiste!=""){
    echo "<script>
	  if(confirm('Já Existe uma Arquivo com este nome no sistema. \\n Banco: $bancoexiste \\n Agencia: $agenciaexiste \\n Data: ".db_formatar($dtarquivoexiste,'d')."')==false){
	    location.href='cai4_baixabanco001.php';
	  }
	  </script>";
	flush();
  }
}

if($situacao == 2){

  echo "<script>
        function js_termometro(xvar){
		document.form1.processa.value = xvar;
        }
        </script>";

  flush();
  // grava arquivo disarq
  pg_exec("begin");

  if(substr($k15_pdano,3,3)=='002')
    $dtarquivo = '20'.substr($arq_array[0],substr($k15_pdano,0,3)-1,substr($k15_pdano,3,3));
  else
    $dtarquivo = substr($arq_array[0],substr($k15_pdano,0,3)-1,substr($k15_pdano,3,3));

  $dtarquivo .= "-".substr($arq_array[0],substr($k15_pdmes,0,3)-1,substr($k15_pdmes,3,3));
  $dtarquivo .= "-".substr($arq_array[0],substr($k15_posdta,0,3)-1,substr($k15_posdta,3,3));
  

  if ($cgc == '88073291000199') { // bage
    if ( substr($arqname,0,4) == "daeb" ) {

      if ( substr($arq_array[0],0,3) == "826" ) {
	$dtarquivo = substr($arqname,4,8);
      }
      
    }
    
  }

  $result = pg_exec("select nextval('disarq_codret_seq') as codret");
  db_fieldsmemory($result,0);
  //echo "insert into disarq (codret ,k15_codbco ,k15_codage   ,arqret   ,dtretorno,id_usuario, dtarquivo,k00_conta)
  //                                 values ($codret,$k15_codbco,'$k15_codage','$arqname','".date('Y-m-d',db_getsession("DB_datausu"))."',".db_getsession("DB_id_usuario").",'".$dtarquivo."',$k15_conta)";

  //exit;

//  die("insert into disarq (codret ,k15_codbco ,k15_codage   ,arqret   ,dtretorno,id_usuario, dtarquivo,k00_conta,autent)
//                                 values ($codret,$k15_codbco,'$k15_codage','$arqname','".date('Y-m-d',db_getsession("DB_datausu"))."',".db_getsession("DB_id_usuario").",'".$dtarquivo."',$k15_conta,'f')");  

  $sqldisarq = "insert into disarq (codret ,k15_codbco ,k15_codage   ,arqret   ,dtretorno,id_usuario, dtarquivo,k00_conta,autent)
                                 values ($codret,$k15_codbco,'$k15_codage','$arqname','".date('Y-m-d',db_getsession("DB_datausu"))."',".db_getsession("DB_id_usuario").",'".$dtarquivo."',$k15_conta,'f')";  
//  die($sqldisarq);
  $result = pg_exec($sqldisarq);

  $achou_arrecant = 0;

  $k15_numpreori = $k15_numpre;
  $k15_numparori = $k15_numpar;
  $priregistro=1;

  if ($cgc == '88073291000199') { // bage
    if ( substr($arqname,0,4) == "daeb" ) {
      $priregistro=0;
    }
  }

  //
  // Processa Registros do Arquivo para Gravar em DISBANCO
  //
  for($i=$priregistro;$i <= $totalproc - ($priregistro == 0?1:0);$i++) {
    // Testa tipo do registro
    if(substr($arq_array[$i],0,1) <> "G") {
      continue;
    }

    // grava arquivo disbanco
    $k15_numpre = $k15_numpreori;
    $k15_numpar = $k15_numparori;
    
    if($k15_taman==242){
      if(substr($arq_array[$i],7,1)!='3' or substr($arq_array[$i],13,1)!='T' ){
        continue;
      }	
    }

    if($k15_taman==402){
      if(substr($arq_array[$i],0,1) == '9'){
        continue;
      }	
    }

    $numpre		= substr($arq_array[$i],substr($k15_numpre,0,3)-1,substr($k15_numpre,3,3));

    if ($cgc == '88073291000199') { // bage
      if (substr($numpre,0,2) == "00") {
        if ( substr($arqname,0,4) == "daeb" ) {
          $k15_numpre = "034008";
          $k15_numpar = "042003";
        } else {
          $k15_numpre = "071008";
          $k15_numpar = "079003";
        }
      }
    }

    $numbco		= substr($arq_array[$i],substr($k15_numbco,0,3)-1,substr($k15_numbco,3,3));
    $numpre		= substr($arq_array[$i],substr($k15_numpre,0,3)-1,substr($k15_numpre,3,3));
    $numpar		= substr($arq_array[$i],substr($k15_numpar,0,3)-1,substr($k15_numpar,3,3));

//    echo($k15_numpre . "<br>");
//    echo("numpre: $numpre <br>");
//    echo $arq_array[$i] . "<br>";
//    exit;
    
    if($k15_codage=='01449' and $k15_codbco == 1){ // alegrete
      if ((substr($arq_array[$i],78,3) == "101") and (substr($arq_array[$i],70,1) != "6")){
        $numpre = "05" . $numpre;
      } else {
        $numpre = substr($arq_array[$i],substr($k15_numpre,0,3)-1,(int) substr($k15_numpre,3,3) + 1);
        $numpar = substr($arq_array[$i],substr($k15_numpar,0,3),(int) substr($k15_numpar,3,3) + 1);
      }

      //		echo("numpre: $numpre - numpar: $numpar - posnumpre: $k15_numpre - posnumpar: $k15_numpar - teste: " . substr($arq_array[$i],78,3) . "<br>" );
      if ($i >= 120) exit;
    } elseif ($k15_codage=='00110' and $k15_codbco == 41){
      $sqlbanco = "select k00_numpre, k00_numpar from arrebanco where k00_numbco = '01" . substr($arq_array[$i],6,13) . "'";
      $resultbanco = pg_exec($sqlbanco);
      if (pg_numrows($resultbanco) == 0) {
        echo "<script>alert('Numbco " . substr($arq_array[$i],6,13). " nao encontrado!');</script>";
        continue;
      } else {
        db_fieldsmemory($resultbanco,0,true);
        $numpre = $k00_numpre;
        $numpar = $k00_numpar;
      }
    }

    //$dtarq		= substr($arq_array[$i],substr($k15_poslan,0,3)-1,substr($k15_poslan,3,3));

    if(substr($k15_plano,3,3)=='002')
      $dtarq = '20'.substr($arq_array[$i],substr($k15_plano,0,3)-1,substr($k15_plano,3,3));
    else
      $dtarq = substr($arq_array[$i],substr($k15_plano,0,3)-1,substr($k15_plano,3,3));

    $dtarq .= "-".substr($arq_array[$i],substr($k15_plmes,0,3)-1,substr($k15_plmes,3,3));
    $dtarq .= "-".substr($arq_array[$i],substr($k15_poslan,0,3)-1,substr($k15_poslan,3,3));

    //$dtpago		= substr($arq_array[$i],substr($k15_pospag,0,3)-1,substr($k15_pospag,3,3));
    if(substr($k15_ppano,3,3)=='002')
      $dtpago = '20'.substr($arq_array[$i],substr($k15_ppano,0,3)-1,substr($k15_ppano,3,3));
    else
      $dtpago = substr($arq_array[$i],substr($k15_ppano,0,3)-1,substr($k15_ppano,3,3));

    $dtpago .= "-".substr($arq_array[$i],substr($k15_ppmes,0,3)-1,substr($k15_ppmes,3,3));
    $dtpago .= "-".substr($arq_array[$i],substr($k15_pospag,0,3)-1,substr($k15_pospag,3,3));
    if ( $dtpago == '0000-00-00' ){
         $dtpago = $dtarquivo;
         $dtarq  = $dtarquivo;
    }
//     echo $dtpago.'    '.$dtarquivo."<br>";
    $vlrpago	= (substr($arq_array[$i],substr($k15_posvlr,0,3)-1,substr($k15_posvlr,3,3))/100)+0;
    $vlrjuros	= (substr($arq_array[$i],substr($k15_posjur,0,3)-1,substr($k15_posjur,3,3))/100)+0;
    $vlrmulta	= (substr($arq_array[$i],substr($k15_posmul,0,3)-1,substr($k15_posmul,3,3))/100)+0;
    $vlracres	= (substr($arq_array[$i],substr($k15_posacr,0,3)-1,substr($k15_posacr,3,3))/100)+0;
    $vlrdesco	= (substr($arq_array[$i],substr($k15_posdes,0,3)-1,substr($k15_posdes,3,3))/100)+0;
    $convenio	=  substr($arq_array[$i],substr($k15_poscon,0,3)-1,substr($k15_poscon,3,3));
    $cedente	=  substr($arq_array[$i],substr($k15_posced,0,3)-1,substr($k15_posced,3,3));

		//
		// D A E B
		//
		if( $cgc == '90940172000138' ) {

			echo "<script>js_termometro(".$i.");</script>";
			flush();


			$dia_venc = (int)substr($arq_array[$i], 56, 2);
			$mes_venc = (int)substr($arq_array[$i], 58, 2);
			$ano_venc = 2000 + (int)substr($arq_array[$i], 60, 2);

			$dtvenc =  "$ano_venc-$mes_venc-$dia_venc";
			
			// Proximo K34_SEQUENCIAL
			$resdisbancotxt = pg_exec("select nextval('disbancotxt_k34_sequencial_seq') as k34_sequencial");
			db_fieldsmemory($resdisbancotxt,0);
				
			// Insere em DISBANCOTXT
			$sqldisbancotxt = "
					insert into disbancotxt(k34_sequencial, k34_numpremigra, k34_valor, k34_dtvenc, k34_dtpago, k34_codret) 
					values ($k34_sequencial, '$numpre', $vlrpago, '$dtvenc', '$dtpago', $codret)";
			pg_exec($sqldisbancotxt);

			$funcaoNumpre = 'fc_numpre_daeb';

			$sql = "select $funcaoNumpre('$numpre') as ehnumpre";

			$res = pg_query($sql);

			db_fieldsmemory($res, 0);
			
			// Verifica se eh ou nao um numpre do DBPortal
			if($ehnumpre=='f') {
				// procura antigo e grava na disbancotxt, disbancotxtreg, disbanco

				// Separa informacoes do Processamento antigo
				$matric = (int)substr($numpre,  0, 6);
				$exerc  = (int)substr($numpre,  8, 2);
				$parc   = (int)substr($numpre, 10, 2);
				
				$sqlarrecad = "
						select 	arrecad.k00_numpre, 
								    arrecad.k00_numpar,
										arrecad.k00_valor as k00_valor,
										round(fc_corre(arrecad.k00_receit, arrecad.k00_dtvenc, arrecad.k00_valor, '$dtvenc', 99999, arrecad.k00_dtvenc),2)::float8 as k00_vlrcor,
										round(fc_juros(arrecad.k00_receit, arrecad.k00_dtvenc, '$dtvenc', arrecad.k00_dtoper, false, 99999),2)::float8 as k00_vlrjur,
										round(fc_multa(arrecad.k00_receit, arrecad.k00_dtvenc, '$dtvenc', arrecad.k00_dtoper, 99999),2)::float8 as k00_vlrmul
						from arrecad
						inner join arrematric on arrematric.k00_numpre = arrecad.k00_numpre
						where arrematric.k00_matric = $matric ";
						
				$sqlarrecant = "
						select 	arrecant.k00_numpre, 
									  arrecant.k00_numpar,
										arrecant.k00_valor as k00_valor,
										round(fc_corre(arrecant.k00_receit, arrecant.k00_dtvenc, arrecant.k00_valor, '$dtvenc', 99999, arrecant.k00_dtvenc),2)::float8 as k00_vlrcor,
										round(fc_juros(arrecant.k00_receit, arrecant.k00_dtvenc, '$dtvenc', arrecant.k00_dtoper, false, 99999),2)::float8 as k00_vlrjur,
										round(fc_multa(arrecant.k00_receit, arrecant.k00_dtvenc, '$dtvenc', arrecant.k00_dtoper, 99999),2)::float8 as k00_vlrmul
						from arrecant
						inner join arrematric on arrematric.k00_numpre = arrecant.k00_numpre
						where arrematric.k00_matric = $matric and arrecant.k00_dtvenc = '$dtvenc' ";

				switch ($exerc) {
					// Divida Ativa
					case 66:
						$sqlarrecad  .= "and   arrecad.k00_tipo = 5 ";
						$sqlarrecant .= "and   arrecant.k00_tipo = 5 ";

						if($parc<>0) {
							if($parc > 80) {
								$ano = 1900 + $parc;
							} else {
								$ano = 2000 + $parc;
							}
							
							$sqlarrecad  .= "and   extract(year from arrecad.k00_dtoper) = $ano ";
							$sqlarrecant .= "and   extract(year from arrecant.k00_dtoper) = $ano ";
						} else {
							$ano = 0;
						}
						//echo "Exerc: $exerc <br> Parc: $parc <br>";
						//die($sqlarrecad);
						break;

					// Parcelamento
					case 77:
						$parc = ($parc==0)?100:$parc;
						
						$sqlarrecad .= "
								and   arrecad.k00_tipo = 6
								and   arrecad.k00_numpar = $parc ";
						$sqlarrecant .= "
								and   arrecant.k00_tipo = 6
								and   arrecant.k00_numpar = $parc ";

						$ano  = 0;
						$parc = 0;
						break;
						
					default:
						
						$anousu = (int)db_getsession("DB_anousu");
						
						if($exerc > 80) {
							$ano = 1900 + $exerc;
						} else {
							$ano = 2000 + $exerc;
						}

						if($ano == $anousu) {
							$sqlarrecad  .= "and   arrecad.k00_tipo = 37 ";
							$sqlarrecant .= "and   arrecant.k00_tipo = 37 ";
							$ano = $anousu;
						} else {
							$sqlarrecad  .= "and   arrecad.k00_tipo = 5 ";
							$sqlarrecad  .= "and   extract(year from arrecad.k00_dtoper) = $ano ";
							$sqlarrecant .= "and   arrecant.k00_tipo = 5 ";
							$sqlarrecant .= "and   extract(year from arrecant.k00_dtoper) = $ano ";
						}

						if($parc > 0 ) {
							$sqlarrecad  .= "and   arrecad.k00_numpar = $parc";
							$sqlarrecant .= "and   arrecant.k00_numpar = $parc";
						}

						break;

				}
				
				$sqltaxas = "select * from migra_stm070_taxas where matricula = $matric and ano = $ano and mes = $parc";

				$restaxas = pg_query($sqltaxas) or die($sqltaxas);

				/*if(pg_num_rows($restaxas) == 0) {
					echo "
						DtArq    : $dtarq    <br>
						DtPago   : $dtpago   <br>
						VlrPago  : $vlrpago  <br>
						VlrJuros : $vlrjuros <br>
						VlrMulta : $vlrmulta <br>
						VlrAcres : $vlracres <br>
						VlrDesco : $vlrdesco <br>
						Convenio : $convenio <br>
						Cedente  : $cedente  <br>
						Numpre   : $numpre   <br>
						Numpar   : $numpar   <br>
						EhNumpre : $ehnumpre <br>
						Matric   : $matric   <br>
						Exerc    : $exerc    <br>
						Parc     : $parc     <br>
						Soma     : $soma     <br>
						SqlTaxas : $sqltaxas <br>
					";
		      die("");
				}*/


				$sqlparc = "";

				for($w=0; $w<pg_num_rows($restaxas); $w++) {
					db_fieldsmemory($restaxas, $w);

					$tipo = ($cod_hist==30)?6:$cod_hist;

					$sqlparc .= "
							union
							select 	arrecad.k00_numpre, 
											arrecad.k00_numpar,
											arrecad.k00_valor,
											round(fc_corre(arrecad.k00_receit, arrecad.k00_dtvenc, arrecad.k00_valor, '$dtvenc', 99999, arrecad.k00_dtvenc),2)::float8 as k00_vlrcor,
											round(fc_juros(arrecad.k00_receit, arrecad.k00_dtvenc, '$dtvenc', arrecad.k00_dtoper, false, 99999),2)::float8 as k00_vlrjur,
											round(fc_multa(arrecad.k00_receit, arrecad.k00_dtvenc, '$dtvenc', arrecad.k00_dtoper, 99999),2)::float8 as k00_vlrmul
							from arrecad
							inner join arrematric on arrematric.k00_numpre = arrecad.k00_numpre
							where arrematric.k00_matric = $matric 
							and   arrecad.k00_tipo      = $tipo 
							and   arrecad.k00_numpar    = $parcela "; 
/*							union
							select 	arrecant.k00_numpre, 
											arrecant.k00_numpar,
											arrecant.k00_valor,
											round(fc_corre(arrecant.k00_receit, arrecant.k00_dtvenc, arrecant.k00_valor, '$dtvenc', 99999, arrecant.k00_dtvenc),2)::float8 as k00_vlrcor,
											round(fc_juros(arrecant.k00_receit, arrecant.k00_dtvenc, '$dtvenc', arrecant.k00_dtoper, false, 99999),2)::float8 as k00_vlrjur,
											round(fc_multa(arrecant.k00_receit, arrecant.k00_dtvenc, '$dtvenc', arrecant.k00_dtoper, 99999),2)::float8 as k00_vlrmul
							from arrecant
							inner join arrematric on arrematric.k00_numpre = arrecant.k00_numpre
							where arrematric.k00_matric = $matric 
							and   arrecant.k00_dtvenc   = '$dtvenc' 
							and   arrecant.k00_tipo     = $tipo 
							and   arrecant.k00_numpar   = $parcela 
							";*/

				}

				$sqlprocessa = "select 	x.k00_numpre,
																x.k00_numpar,
																sum(x.k00_valor)  as k00_valor,
																sum(x.k00_vlrcor) as k00_vlrcor,
																sum(x.k00_vlrjur) as k00_vlrjur,
																sum(x.k00_vlrmul) as k00_vlrmul
												from    (" . $sqlarrecad . " union " . $sqlarrecant . $sqlparc . ") x
												group by x.k00_numpre, x.k00_numpar";

//if($numpre == '00729822060155') {				
//die($sqlprocessa);
//}


				$resprocessa = pg_exec($sqlprocessa);

				$soma = 0;

				for($indx=0; $indx<pg_num_rows($resprocessa); $indx++) {
					db_fieldsmemory($resprocessa, $indx);

					// Proximo IDRET
					$result = pg_exec("select nextval('disbanco_idret_seq') as nextidret");
					db_fieldsmemory($result,0);
				
					$valor_total = $k00_vlrcor + $k00_vlrjur + $k00_vlrmul ;
				
					$soma += $valor_total;
					
					// Insere em DISBANCO	
					$sql = "insert into disbanco 
										(codret,idret,k15_codbco,k15_codage,k00_numbco,dtarq,dtpago,vlrpago,
							 			 vlrjuros,vlrmulta,vlracres,vlrdesco,cedente,vlrtot,classi,k00_numpre,k00_numpar,convenio)
									values ($codret, $nextidret, $k15_codbco, '$k15_codage', '$numbco', '$dtarq', '$dtpago',
									        $valor_total, 0, 0, 0, 0, '$cedente',
												  $valor_total, false, $k00_numpre, $k00_numpar, '$convenio')";
					pg_exec($sql);
					
					// Proximo K35_SEQUENCIAL
					$result = pg_exec("select nextval('disbancotxtreg_k35_sequencial_s') as k35_sequencial");
					db_fieldsmemory($result,0);

					// Insere em DISBANCOTXTREG
					pg_exec("
							insert into disbancotxtreg (k35_sequencial, k35_disbancotxt, k35_idret) 
							values ($k35_sequencial, $k34_sequencial, $nextidret)");
				}

				// calcula diferenca do valor do TXT e valor encontrado
				$diferenca = $vlrpago - $soma;

				// Caso seja uma diferenca < 1.00 entao soma a ultima
				if(abs($diferenca) <= 1) {
					// altera ultimo registro do disbanco
					pg_exec("update disbanco set vlrpago = vlrpago + $diferenca, vlrtot = vlrtot + $diferenca
									 where idret = $nextidret");
				}

				// e casou houve alguma diferenca guarda na disbancotxt
				if($diferenca <> 0) {
					// guarda diferenca na disbancotxt
					pg_exec("update disbancotxt set k34_diferenca = $diferenca where k34_sequencial = $k34_sequencial");
				}


			/*	if( strval($soma) <> strval($vlrpago) && $soma > 0 ) {
					echo "
						DtArq    : $dtarq    <br>
						DtPago   : $dtpago   <br>
						VlrPago  : $vlrpago  <br>
						VlrJuros : $vlrjuros <br>
						VlrMulta : $vlrmulta <br>
						VlrAcres : $vlracres <br>
						VlrDesco : $vlrdesco <br>
						Convenio : $convenio <br>
						Cedente  : $cedente  <br>
						Numpre   : $numpre   <br>
						Numpar   : $numpar   <br>
						EhNumpre : $ehnumpre <br>
						Matric   : $matric   <br>
						Exerc    : $exerc    <br>
						Parc     : $parc     <br>
						Soma     : $soma     <br>
						SqlProces: $sqlprocessa <br><br><br>
					";
		      //die("");
				}
				//die($sqlprocessa);*/
			} else {
				// grava disbanco
				//pg_exec("commit");
				//die("Numpre DbPortal");
				
				$k00_numpre = (int)$numpre;

				$sql = "select * from recibopaga where k00_numnov = $k00_numpre";
				$res = pg_exec($sql);

				if(pg_num_rows($res)>0) {
					$numpar = 0;
				}

				// Proximo IDRET
				$result = pg_exec("select nextval('disbanco_idret_seq') as nextidret");
				db_fieldsmemory($result,0);
				
				// Insere em DISBANCO	
				$sql = "insert into disbanco 
										(codret,idret,k15_codbco,k15_codage,k00_numbco,dtarq,dtpago,vlrpago,
							 			 vlrjuros,vlrmulta,vlracres,vlrdesco,cedente,vlrtot,classi,k00_numpre,k00_numpar,convenio)
								values ($codret, $nextidret, $k15_codbco, '$k15_codage', '$numbco', '$dtarq', '$dtpago',
								        $vlrpago, 0, 0, 0, 0, '$cedente',
											  $vlrpago, false, $numpre, $numpar, '$convenio')";
				pg_exec($sql);
				
				// Proximo K35_SEQUENCIAL
				$result = pg_exec("select nextval('disbancotxtreg_k35_sequencial_s') as k35_sequencial");
				db_fieldsmemory($result,0);

				// Insere em DISBANCOTXTREG
				pg_exec("
						insert into disbancotxtreg (k35_sequencial, k35_disbancotxt, k35_idret) 
						values ($k35_sequencial, $k34_sequencial, $nextidret)");

			}

			
			
			continue;	
		}

    if($k15_codage=='88888'){

          $sqlverresult = "select arrematric.k00_numpre, numpremigra.k00_numpar as numpre_migra, arrematric.k00_matric
                           from numpremigra 
                           inner join arrematric on arrematric.k00_matric = numpremigra.k00_matric
                           where numpremigra.k00_numpre = $convenio";
	  $verresult = pg_exec($sqlverresult);
	  if(pg_numrows($verresult)!=false){
   	    $numpre_migra = pg_result($verresult,0,0);
   	    $numpar       = pg_result($verresult,0,1);
	    $matric       = pg_result($verresult,0,2);
	  }	
     
          $sqlverresult = "select k00_numpar from numpremigra where numpremigra.k00_numpre = $convenio";
	  $verresult = pg_exec($sqlverresult);
	  if (pg_result($verresult,0) == "0") { // unica
	    $sqlverresult = "select arrecad.k00_numpre, arrecad.k00_numpar, sum(arrecad.k00_valor) as k00_valor
				    from numpremigra 
				    inner join arrematric on arrematric.k00_matric = numpremigra.k00_matric
				    inner join arrecad    on arrecad.k00_numpre    = arrematric.k00_numpre
				    where numpremigra.k00_numpre = $convenio
				    and arrecad.k00_tipo = 5 and k00_dtoper >= '2004-01-01' group by arrecad.k00_numpre, arrecad.k00_numpar";
	  } else {
	    $sqlverresult = "select arrecad.k00_numpre, arrecad.k00_numpar, sum(arrecad.k00_valor) as k00_valor
				    from numpremigra 
				    inner join arrematric on arrematric.k00_matric = numpremigra.k00_matric
				    inner join arrecad    on arrecad.k00_numpre    = arrematric.k00_numpre and arrecad.k00_numpar = numpremigra.k00_numpar
				    where numpremigra.k00_numpre = $convenio
				    and arrecad.k00_tipo = 5 and k00_dtoper >= '2004-01-01' group by arrecad.k00_numpre, arrecad.k00_numpar";
	  }
	  $verresult = pg_exec($sqlverresult);
//	  echo $sqlverresult;exit;
	  if(pg_numrows($verresult) != false){
   	    $numpre = pg_result($verresult,0,0);
	  }	
    }
//echo "dtarq: ".$dtarq."  -  dtpago: ".$dtpago."<br>";

    if (1 == 2) {

      echo "<script>";
      echo "js_termometro($i);";
      echo "alert('registro: $i ');";
      echo "alert('codret: $codret');";
      echo "alert('codage: $codage');";
      echo "alert('numpre: $numpre');";
      echo "alert('numbco: $numbco');";
      echo "alert('dtarq: $dtarq');";
      echo "alert('dtpago: $dtpago');";
      echo "alert('vlrpago: $vlrpago');";
      echo "alert('vlrjuros: $vlrjuros');";
      echo "alert('vlrmulta: $vlrmulta');";
      echo "alert('vlracres: $vlracres');";
      echo "alert('vlrdesco: $vlrdesco');";
      echo "alert('vlrabat: $vlrabat');";
      echo "alert('cedente: $cedente');</script>";
      exit;

   }

   if($k15_codage=='88888') {

      if (pg_numrows($verresult) > 0) {
	for ($xresult=0;$xresult<pg_numrows($verresult);$xresult++) {
	  $xtotal += pg_result($verresult,$xresult,2);
	}
	$xxtotal=0;
	echo "<br>passou arrecad... xxtotal: $xxtotal - convenio: $convenio - numpre_migra: $numpre_migra - numpar: $numpar - matric: $matric<br>";
	for ($xresult=0;$xresult<pg_numrows($verresult);$xresult++) {
	  $xpago  = pg_result($verresult,$xresult,2);
          $numpre = pg_result($verresult,$xresult,0);
          $numpar = pg_result($verresult,$xresult,1);
    //      echo "xpago: $xpago\n";
    //      echo "xtotal: $xtotal\n";
    //      echo "vlrpago: $vlrpago\n";exit;
          $vlrpagonew = round($vlrpago * ($xpago / $xtotal),2);
          $xxtotal += $vlrpagonew;

	  if ($xresult == pg_numrows($verresult) - 1) {
	    $diferenca = $vlrpago - $xxtotal;
	    $vlrpagonew += $diferenca;
	    $xxtotal += $diferenca;
	  }
	  
	  $result = pg_exec("select nextval('disbanco_idret_seq') as idret");
	  db_fieldsmemory($result,0);
	  $sqlresult = " insert into disbanco 
			 (codret,idret,k15_codbco,k15_codage,k00_numbco,dtarq,dtpago,vlrpago,
			 vlrjuros,vlrmulta,vlracres,vlrdesco,cedente,vlrtot,classi,k00_numpre,k00_numpar,convenio)
			 values 
			 ($codret,$idret,$k15_codbco,'$k15_codage','$numbco','$dtarq','$dtpago',$vlrpagonew,
			 $vlrjuros,$vlrmulta,$vlracres,$vlrdesco,'$cedente',
			 $vlrpagonew+$vlrjuros+$vlrmulta+$vlracres-$vlrdesco,false,$numpre+0,$numpar+0,'$convenio')";
//	echo $sqlresult;exit;
	  $result = pg_exec($sqlresult);
	  echo "<script>js_termometro(".$i.");</script>";
	  flush();
	  echo "<br>xtotal: $xtotal - xxtotal: $xxtotal - vlrpago: $vlrpago - vlrpagonew: $vlrpagonew<br>";
	}
  //      exit;
      } else {
	$achou_arrecant = 1;
	$sqlverresult = "select arrecant.k00_numpre, arrecant.k00_numpar, sum(arrecant.k00_valor) as k00_valor
			  from numpremigra 
			  inner join arrematric on arrematric.k00_matric = numpremigra.k00_matric
			  inner join arrecant    on arrecant.k00_numpre    = arrematric.k00_numpre and arrecant.k00_numpar = numpremigra.k00_numpar
			  where numpremigra.k00_numpre = $convenio
			  and arrecant.k00_tipo = 5 and k00_dtoper >= '2004-01-01' group by arrecant.k00_numpre, arrecant.k00_numpar";
	$verresult = pg_exec($sqlverresult);
//	  echo $sqlverresult;exit;
        if (pg_numrows($verresult) > 0) {
          echo "<br>passou arrecant... xxtotal: $xxtotal - convenio: $convenio - numpre_migra: $numpre_migra - numpar: $numpar - matric: $matric<br>";
	}
      }
    } else {

      $result = pg_exec("select nextval('disbanco_idret_seq') as idret");
      db_fieldsmemory($result,0);

      if ($cgc == '88811922000120') { // guaiba

	if ($numpar+0 == 2) {

	  $sql = "select k00_tipo from arrecad where k00_numpre = $numpre limit 1";
	  $result = pg_exec($sql) or die("erro: ".pg_errormessage());

	  if (pg_numrows($result) > 0) {
		  
	    db_fieldsmemory($result,0);

	    if ($k00_tipo == 1) {

	      $result = pg_exec("select nextval('numpref_k03_numpre_seq') as k03_numpre");
	      db_fieldsmemory($result,0);

	      $result = pg_exec("select fc_numbco($k15_codbco,'$k15_codage')");
	      db_fieldsmemory($result,0);
		  
	      $sql = "insert into db_reciboweb values($numpre,1,$k03_numpre,$k15_codbco,'$k15_codage','$fc_numbco')";
  //	    echo($sql . "\n");
	      pg_exec($sql) or die("inserindo em db_reciboweb: ".pg_errormessage()); 

	      $sql = "insert into db_reciboweb values($numpre,2,$k03_numpre,$k15_codbco,'$k15_codage','$fc_numbco')";
  //	    echo($sql . "\n");
	      pg_exec($sql) or die("inserindo em db_reciboweb: ".pg_errormessage()); 

	      // roda funcao fc_recibo pra gerar o recibo
	      $sql = "select fc_recibo($k03_numpre,'" . date("Y-m-d",db_getsession("DB_datausu")) . "','2005-11-30',".db_getsession("DB_anousu").")";
  //	    die($sql . "\n");
	      $recibo = pg_exec($sql);

//              echo("mudei: $numpre - $numpar - para: $k03_numpre<br>");

	      $numpre = $k03_numpre;
	      $numpar = 0;

	    }

	  }

	}

      }
      
      $sqlinsert = " insert into disbanco 
			 (codret,idret,k15_codbco,k15_codage,k00_numbco,dtarq,dtpago,vlrpago,
			  vlrjuros,vlrmulta,vlracres,vlrdesco,cedente,vlrtot,classi,k00_numpre,k00_numpar,convenio)
					   values 
		     ($codret,$idret,$k15_codbco,'$k15_codage','$numbco','$dtarq','$dtpago',$vlrpago,
		     $vlrjuros,$vlrmulta,$vlracres,$vlrdesco,'$cedente',
		     $vlrpago+$vlrjuros+$vlrmulta+$vlracres-$vlrdesco,false,$numpre+0,$numpar+0,'$convenio')";

      $result = pg_exec($sqlinsert);
      if ($result == false) {
	echo $i;
	exit;
      }
      echo "<script>js_termometro(".$i.");</script>";

      flush();
    }

  }

  $sql = "select dtarq, sum(vlrpago) from disbanco where codret = $codret group by dtarq";
  $result = pg_exec($sql);

  $total = 0;

  for ($x=0;$x < pg_numrows($result); $x++) {
    db_fieldsmemory($result,$x,true);
    echo "data: $dtarq - valor: " . db_formatar($sum,"f") . "<br>";
    $total += $sum;
  }
  echo "total: " . db_formatar($total,"f") . "<br>";
  
//  echo "\nterminou...\n";
  if ($achou_arrecant == 0) {
    pg_exec("end");
    echo "<script>alert('Documento processado!');location.href='cai4_baixabanco002.php';</script>";
  }else{
    echo "<script>alert('Documento nao processado porque tem pagamentos!');location.href='cai4_baixabanco001.php';</script>";
  }
}
if($erro == true){
  echo "<script>alert('".$erro_msg."');</script>";
}

?>
