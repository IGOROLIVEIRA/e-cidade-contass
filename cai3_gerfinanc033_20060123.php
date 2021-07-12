<?
require("fpdf151/scpdf.php");
include("fpdf151/impcarne.php");
include("libs/db_sql.php");
include("classes/db_db_config_classe.php");
include("classes/db_iptubase_classe.php");
db_postmemory($HTTP_POST_VARS);  
db_postmemory($HTTP_SERVER_VARS);
//db_postmemory($HTTP_POST_VARS,2);
//db_postmemory($HTTP_SERVER_VARS,2);exit;
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
$cldb_config = new cl_db_config;
$pdf = new scpdf();
$pdf->Open();
//exit;
//$matric = 23433;
//$tipo_debito = 25;
//$numpre = 2026259;
$result = pg_exec("select codmodelo,k03_tipo from arretipo where k00_tipo = $tipo_debito");
db_fieldsmemory($result,0);
pg_free_result($result);
//die($cldb_config->sql_query(db_getsession("DB_instit"),"nomeinst as prefeitura, munic"));
$resul = $cldb_config->sql_record($cldb_config->sql_query(db_getsession("DB_instit"),"nomeinst as prefeitura, munic"));
db_fieldsmemory($resul,0); // pega o dados da prefa
$munic2 = $munic;
$nomeinst2 = $prefeitura;
if((int) $codmodelo > 0) {
	$impmodelo = (int) $codmodelo;
}else{
	$impmodelo = 1;
}

//=============================================================================================================================

if($k03_tipo == 1 and $impmodelo <> 1){
  if(!isset($matric)) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Para Emissão de Carnê do IPTU Consulte Dados Pela Matrícula.');
    exit;
  }
  $cliptubase = new cl_iptubase;
  //$pdf3 = new scpdf();
  //$pdf3 = new scpdf();
  //$pdf3->Open();
  $pdf2 = new db_impcarne($pdf,$impmodelo);
  //die($cliptubase->proprietario_query($matric));
  $resultpro = $cliptubase->proprietario_record($cliptubase->proprietario_query($matric));
  db_fieldsmemory($resultpro,0);
  
  $pdf2->iptj01_matric      = $j01_matric;
  $pdf2->iptz01_cidade      = $munic2;
  $pdf2->iptprefeitura      = $nomeinst2;
  $pdf2->iptz01_ender       = $z01_ender;
  $pdf2->iptbql             = $j34_setor."/".$j34_quadra."/".$j34_lote;
  $pdf2->iptnomepri         = $nomepri;
  $pdf2->iptproprietario    = $proprietario;
  $pdf2->iptz01_nome        = $z01_nome;
  $pdf2->iptz01_numcgm      = $z01_numcgm;
  $pdf2->iptz01_cgccpf      = $z01_cgccpf;
  $pdf2->iptz01_bairro      = $z01_bairro;
  $pdf2->iptz01_cep         = $z01_cep;
  $pdf2->iptj43_cep         = $j43_cep;
  $pdf2->iptdataemis        = date("d/m/Y",db_getsession("DB_datausu"));
  
  $sql = "select * from arrematric inner join arrecad on arrecad.k00_numpre = arrematric.k00_numpre where k00_matric = $j01_matric and k00_dtvenc < '".date("Y-m-d",db_getsession("DB_datausu"))."' limit 1";
  //die($sql);
  $rsResulant = pg_query($sql);
  $numlin = pg_numrows($rsResulant);
  if($numlin>0){
  	 $pdf2->iptdebant = "Há Débitos Anteriores, favor procurar Setor de Dívida Ativa";
  }
   
  unset($resultpro);

  $vt = $HTTP_POST_VARS;
  $tam = sizeof($vt);
  reset($vt);
  $numpres = "";
  for($i = 0;$i < $tam;$i++) {
    if(db_indexOf(key($vt) ,"CHECK") > 0)
      $numpres .= "N".$vt[key($vt)];  
    next($vt);
  }

  $numpres = explode("N",$numpres);

  $unica = false;
  if(sizeof($numpres)<2){
    $numpres = array("0"=>"0","1"=>$numpre_unica.'P000');
    $unica = true;
  }else{
    if(isset($HTTP_POST_VARS["numpre_unica"])){
       $unica = true; 
    }
  }

//  pg_exec("BEGIN");
  for($volta = 1;$volta < sizeof($numpres);$volta++) {
    $codigos = explode("P",$numpres[$volta]);  
  }

  $resultunica = pg_exec("select j23_anousu from iptucalc inner join iptunump on j20_anousu = j23_anousu and j20_matric = j23_matric where j20_numpre = $codigos[0]");
  db_fieldsmemory($resultunica,0);
  $pdf2->iptj23_anousu = $j23_anousu;

  $resultunica = pg_exec("select * from recibounica where k00_numpre = $codigos[0]");
//  for ($contadorunica=0;$contadorunica < pg_numrows($resultunica);$contadorunica++) {
  if (pg_numrows($resultunica) > 0) {
    db_fieldsmemory($resultunica,0);
    $vencunica = db_formatar($k00_dtvenc,"d");
  }
//  }
 /*
  $sqlparag = "select db02_texto as agencias 
	       from db_documento 
	       inner join db_docparag on db03_docum = db04_docum 
	       inner join db_paragrafo on db04_idparag = db02_idparag 
	       where db03_docum = 27 and db02_descr ilike '%Agencias%' and db03_instit = " . db_getsession("DB_instit");
  $resparag = pg_query($sqlparag);

  if ( pg_numrows($resparag) == 0 ) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Configure o documento 27 como Agencias!');
    exit; 
  }
  db_fieldsmemory($resparag,0);*/
    
  if( $unica == 't'){
        $sql =  "select *,
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
			 where r.k00_numpre = ".$codigos[0]." and r.k00_dtvenc >= '".date('Y-m-d',db_getsession("DB_datausu"))."'::date 
			 ) as unica order by dtvencunic desc";
      $linha = 220;
      $resultfin = pg_query($sql);

   if($resultfin!=false){
//      for($unicont=0;$unicont<pg_numrows($resultfin);$unicont++){
        db_fieldsmemory($resultfin,0);
        $pdf2->iptk00_percdes = $k00_percdes;
        $uvlrcor = db_formatar($uvlrcor,'f');
        $pdf2->iptuvlrcor = $uvlrcor;
        
        $vlrhis = db_formatar($uvlrhis,'f'); 		  
        
        $vlrdesconto = db_formatar($uvlrdesconto,'f');
        $pdf2->iptuvlrdesconto = $vlrdesconto;
          		  
        $vlrtotal = db_formatar($utotal,'f'); 		 
        $vlrbar = db_formatar(str_replace('.','',str_pad(number_format($utotal,2,"","."),11,"0",STR_PAD_LEFT)),'s','0',11,'e');
        
        $pdf2->ipttotal = $vlrtotal;

        $resultnumbco = pg_exec("select numbanco from db_config where codigo = " . db_getsession("DB_instit"));
        $numbanco = pg_result($resultnumbco,0) ;// deve ser tirado do db_config

        $numpre = db_numpre($k00_numpre).'000'; //db_formatar(0,'s',3,'e');
        $dtvenc = str_replace("-","",$dtvencunic);
        $resultcod = pg_exec("select fc_febraban('816'||'$vlrbar'||'".$numbanco."'||$dtvenc||'000000'||'$numpre')");
        db_fieldsmemory($resultcod,0);
        $dtvencunic = db_formatar($dtvencunic,'d'); 		  
		$pdf2->iptdtvencunic = $dtvencunic; 
        $codigo_barras   = substr($fc_febraban,0,strpos($fc_febraban,','));
        $linha_digitavel = substr($fc_febraban,strpos($fc_febraban,',')+1);

        $pdf2->iptcodigo_barras = $codigo_barras;
        $pdf2->iptlinha_digitavel = $linha_digitavel;


//        $pdf->SetFont('Times','B',8);
        // C O D I G O   D E  B A R R A S 
//        $pdf->SetDash(0.8,0.8);
//        $pdf->Line(05,$linha-9,203,$linha-9);
//        $pdf->SetDash();
//        $pdf->Text(32,$linha-2,$pref); 
//        $pdf->Text(35,$linha+2,$estado); 
//        $linha = $linha + 05;
//        $pdf->SetFont('Times','',10);
//        $pdf->Text(15,$linha+3,$linha_digitavel);
//        $pdf->SetFillColor(0,0,0);
//        $linha = $linha + 5;
//        $pdf->int25(5,$linha,$codigo_barras,15,0.341);
//        
//      }
    }
    pg_free_result($resultfin);
  } 
  $sql = "select sum(j22_valor) as vlredi
          from iptucale
	  where j22_anousu = $j23_anousu and
	        j22_matric = $j01_matric";
  $sqlres = pg_exec($sql);
  if(pg_numrows($sqlres)>0){
    db_fieldsmemory($sqlres,0);
  }else{
    $vlredi = 0;
  }
  $sql = "select j23_vlrter, j23_aliq
          from iptucalc
	  where j23_anousu = $j23_anousu and
	        j23_matric = $j01_matric";
  $sqlres = pg_exec($sql);
  if(pg_numrows($sqlres)>0){
    db_fieldsmemory($sqlres,0);
    $pdf2->iptj23_aliq = $j23_aliq; 
  }else{
    $j23_vlrter = 0;
    $j23_aliq = 0;
  }
   $j23_vlrter += $vlredi;
   $pdf2->iptj23_vlrter = db_formatar($j23_vlrter,'f');

   $pdf2->imprime();
   $pdf2->objpdf->Output();
   exit;	
}else{ 

/////// COMEÇO DA GERAÇÃO DOS CARNES, MODELO 1

//if( ( $tipo_debito==2 ) || ( $tipo_debito==6 ) || ( $tipo_debito==21 ) ||  ( $tipo_debito==25 ) || ( $tipo_debito==26) || ( $tipo_debito==4) || ( $tipo_debito==28) || ( $tipo_debito==3)) {
$result = pg_exec("select * from arretipo where k00_tipo = $tipo_debito");
db_fieldsmemory($result,0);
$result = pg_exec("select *
                   from db_config 
   	 	   where codigo = ".db_getsession('DB_instit'));

db_fieldsmemory($result,0);

//$pdf = new scpdf();
//$pdf->Open();
$impmodelo = 1;
$pdf1 = new db_impcarne($pdf,$impmodelo);

$pdf1->prefeitura = $nomeinst;
if(strtoupper($munic) == 'BAGE'){
  $pdf1->secretaria = 'SECRETARIA DA FAZENDA';
}else{
  $pdf1->secretaria = 'SECRETARIA DE FINANÇAS';
}

$pdf1->tipodebito = $k00_descr;
$pdf1->logo = $logo;

$pdf->SetMargins(5,2);
////  
pg_exec("BEGIN");
db_postmemory( $HTTP_POST_VARS);
$vt = $HTTP_POST_VARS;
$tam = sizeof($vt);
reset($vt);
$numpres = "";
for($i = 0;$i < $tam;$i++) {
  if(db_indexOf(key($vt) ,"CHECK") > 0)
    $numpres .= "N".$vt[key($vt)];  
  next($vt);
}
$sounica = $numpres;
$numpres = explode("N",$numpres);

$unica = 2;
if(sizeof($numpres)<2){
  $numpres = array("0"=>"0","1"=>$numpre_unica.'P000');
    $unica = 1;
}else{
  if(isset($HTTP_POST_VARS["numpre_unica"])){
    if(strtoupper($munic) == 'BAGE'){ 
      if ($numpre_unica != ''){
       $unica = 1;
      }
    }else{
       $unica = 1;
    }
  }
}
sizeof($numpres);
if(isset($geracarne) && $geracarne=='banco')
  $pagabanco = 't';
else
  $pagabanco = 'f';
  
  
for($volta = 1;$volta < sizeof($numpres);$volta++) {
  $k00_numpre = substr($numpres[$volta],0,strpos($numpres[$volta],'P'));  
  
  $resulttipo = pg_exec("select k00_descr,k00_codbco,k00_codage,k00_txban,k00_rectx,
                            k00_hist1,k00_hist2,k00_hist3,k00_hist4,k00_hist5,
                            k00_hist6,k00_hist7,k00_hist8 
                     from arretipo 
		     where k00_tipo = $tipo_debito
                    ");
  db_fieldsmemory($resulttipo,0);

  if ( $k03_tipo==16 ){
     $sql28 = "select b.* 
               from diversos a 
                    left outer join procdiver b on a.dv05_procdiver=b.dv09_procdiver 
               where dv05_numpre = $k00_numpre limit 1";
     $result28 = pg_exec($sql28);
     if (pg_numrows($result28) > 0){
        db_fieldsmemory($result28,0);
        $pdf1->tipodebito = 'PARCELAMENTO DE '.$dv09_descr;
     }
  }
  if ( ( $tipo_debito==28 ) || ( $tipo_debito==25) ){
     if ( $tipo_debito==28 ){
        $sql25 = "select * 
                  from termo 
                       inner join termodiver on v07_parcel = dv10_parcel 
                       inner join diversos on dv10_coddiver = dv05_coddiver 
                       inner join procdiver on dv05_procdiver=dv09_procdiver
                  where v07_numpre = $k00_numpre";

     }else{

     $sql25 = "select * 
               from diversos a 
                    left outer join procdiver b on a.dv05_procdiver=b.dv09_procdiver 
               where dv05_numpre = $k00_numpre 
               order by a.dv05_coddiver desc limit 1";

     }
//echo $sql25;exit;
     $result25 = pg_exec($sql25);
     db_fieldsmemory($result25,0);
     @$obs = substr($obs,0,20);
     $pdf1->tipodebito = $dv09_descr;

     if ( $dv05_procdiver == 1284 ){
        $pdf1->secretaria = 'FUNDO MUNICIPAL DE HABITAÇÃO';
     //   $texto1  = 'PRESTAÇÃO DE LOTE URBANIZADO - LOT. SOL NASCENTE';
        $k00_hist1 = 'Convênio SEHAB nº 72/99 - Programa Especial do Funco de Desenvolvimento Social. Aprovação do Conselho Estadual de Habitação em 08/09/1999';
     }else if ( $dv05_procdiver == 221 ){
        $pdf1->secretaria = 'FUNDO MUNICIPAL DE HABITAÇÃO';
     //   $texto1  = 'PRESTAÇÃO DE LOTE URBANIZADO COM CASA - LOT. POR-DO-SOL';
        $k00_hist1  = 'Lei Municipal nº 3049/2002, de 04/12/2002. Aprovação do Conselho Estadual de Habitação em dez/2002';
     }
  }
  $proprietario = '';
  $xender = '';
  $xbairro = '';
  if(!empty($HTTP_POST_VARS["ver_matric"])) {
     $descr = 'Matricula';
     $Identificacao = pg_exec("select *
   	                       from proprietario
		  	       where j01_matric = ".$HTTP_POST_VARS["ver_matric"]." limit 1");
     db_fieldsmemory($Identificacao,0);
     $proprietario = $z01_nome;
     if(strtoupper($munic) == 'BAGE'){
       $xender = $nomepri.', '.$j39_numero.'  '.$j39_compl;
     }else{
       $xender = strtoupper($z01_ender).($z01_numero == ""?"":', '.$z01_numero.'  '.$z01_compl);
     }
     $xbairro = $z01_bairro;
     $numero = $HTTP_POST_VARS["ver_matric"].'  SQL:'.$j34_setor.'-'.$j34_quadra.'-'.$j34_lote;

  } else if(!empty($HTTP_POST_VARS["ver_inscr"])) {
     $descr = 'Inscrição';
     $Identificacao = pg_exec("select * from empresa where q02_inscr = ".$HTTP_POST_VARS["ver_inscr"]);
     db_fieldsmemory($Identificacao,0); 
     $numero = $HTTP_POST_VARS["ver_inscr"].' / '.$q07_ativ;

  } else {
     $numero = $HTTP_POST_VARS["ver_numcgm"];
     $descr = 'CGM';
     $Identificacao = pg_exec("select z01_nome,z01_ender,z01_munic,z01_uf,z01_cep,''::bpchar as nomepri,''::bpchar as j39_compl,''::bpchar as j39_numero,z01_bairro as j13_descr 
                               from cgm
	  		       where z01_numcgm = ".$HTTP_POST_VARS["ver_numcgm"]);
     db_fieldsmemory($Identificacao,0); 
  }

//if ( ( $tipo_debito==6 ) || ( $tipo_debito== 21 ) || ( $tipo_debito== 26 ) || ( $tipo_debito== 28 ) ) { 
  if ( ( $k03_tipo==6 ) || ( $k03_tipo== 17 ) || ( $k03_tipo== 16 ) || ( $k03_tipo== 13 )) {
         $sqltipodeb = "
                select  termo.*,z01_nome,z01_ender,z01_numero,z01_compl,z01_bairro,
			coalesce(k00_matric,0) as matric,
			coalesce(k00_inscr,0) as inscr
		from termo
			left outer join arrematric	on v07_numpre = arrematric.k00_numpre
			left outer join arreinscr	on v07_numpre = arreinscr.k00_numpre
			inner join cgm 			on v07_numcgm = z01_numcgm
                        where v07_numpre = $k00_numpre
                  ";
         $sqltipodeb = "
		select z.*, z01_nome,z01_ender,z01_numero,z01_compl,z01_bairro from (
			select 	x.*,
				case when x.matric <> 0 then case when j41_numcgm is not null then promitente.j41_numcgm else iptubase.j01_numcgm end else case when x.inscr <> 0 then issbase.q02_numcgm else arrecad.k00_numcgm end end as z01_numcgm
				from (
				select  termo.*,
					coalesce(k00_matric,0) as matric,
					coalesce(k00_inscr,0) as inscr
				from termo
					left outer join arrematric	on v07_numpre = arrematric.k00_numpre
					left outer join arreinscr	on v07_numpre = arreinscr.k00_numpre
					where v07_numpre = $k00_numpre) as x
			left join iptubase		on j01_matric = x.matric
	                left outer join promitente      on j01_matric = j41_matric and promitente.j41_tipopro is true
			left join issbase		on q02_inscr  = x.inscr
			inner join arrecad on v07_numpre = k00_numpre) as z
		inner join cgm on z.z01_numcgm = cgm.z01_numcgm
                  ";
    $resulttipodeb = pg_exec($sqltipodeb);
    if ( pg_numrows($resulttipodeb) == 0) {
        db_redireciona('db_erros.php?fechar=true&db_erro=Parcelamento sem termo cadastrado.');
        exit;
    }else{
       db_fieldsmemory($resulttipodeb,0);
    }
  } 
  $exercicio = '';
  if ( $k03_tipo==6 ) {
     $sqldivida = "select distinct v01_exerc 
                   from termodiv 
                        inner join divida on v01_coddiv = coddiv 
                   where parcel = $v07_parcel";
     $resultdivida = pg_exec($sqldivida);
     $traco = '';
     $exercicio = ' - Exerc : ';
     for ($k = 0;$k < pg_numrows($resultdivida);$k++){  
       $exercicio .= $traco.substr(pg_result($resultdivida,$k,"v01_exerc"),2,2);
       $traco = '-';
     }
  }
//  if(!empty($HTTP_POST_VARS["ver_matric"])) {
//    $sqlcgm = "select * from cgm where z01_numcgm = $z01_numcgm";
//    $resultcgm = pg_exec($sqlcgm);
    
//    db_fieldsmemory($resultcgm,0);
//  }
  if($unica == 1){

   $sql =  "select *,
            substr(fc_calcula,2,13)::float8 as uvlrhis,
            substr(fc_calcula,15,13)::float8 as uvlrcor,
            substr(fc_calcula,28,13)::float8 as uvlrjuros,
            substr(fc_calcula,41,13)::float8 as uvlrmulta,
            substr(fc_calcula,54,13)::float8 as uvlrdesconto,
            (substr(fc_calcula,15,13)::float8+
            substr(fc_calcula,28,13)::float8+
            substr(fc_calcula,41,13)::float8-
            substr(fc_calcula,54,13)::float8) as utotal,
            substr(fc_calcula,77,17)::float8 as qinfla,
            substr(fc_calcula,94,4)::varchar(5) as ninfla

			 from (
			 select r.k00_numpre,r.k00_dtvenc as dtvencunic, r.k00_dtoper as dtoperunic,r.k00_percdes,
			        fc_calcula(r.k00_numpre,0,0,r.k00_dtvenc,r.k00_dtvenc,".db_getsession("DB_anousu").")
         from recibounica r
			 where r.k00_numpre = ".$k00_numpre." and r.k00_dtvenc >= '".date('Y-m-d',db_getsession("DB_datausu"))."'::date 
			 ) as unica order by dtvencunic desc";
      $linha = 220;
      $resultfin = pg_query($sql);
   if($resultfin!=false){
      for($unicont=0;$unicont<pg_numrows($resultfin);$unicont++){
        db_fieldsmemory($resultfin,$unicont);
        $vlrhis = db_formatar($uvlrhis,'f'); 		  
        $vlrdesconto = db_formatar($uvlrdesconto,'f'); 		  
        $vlrtotal = db_formatar($utotal,'f'); 		  
        $vlrbar = db_formatar(str_replace('.','',str_pad(number_format($utotal,2,"","."),11,"0",STR_PAD_LEFT)),'s','0',11,'e');
//        $vlrbar = "0".str_replace('.','',str_pad(number_format($utotal,2,"","."),11,"0",STR_PAD_LEFT));
//	$numbanco = "4268" ;// deve ser tirado do db_config
	$resultnumbco = pg_exec("select numbanco from db_config where codigo = " . db_getsession("DB_instit"));
	$numbanco = pg_result($resultnumbco,0) ;// deve ser tirado do db_config
  
        $sqlvalor = "select k00_impval from arretipo where k00_tipo = $tipo_debito";
        db_fieldsmemory(pg_exec($sqlvalor),0);
        $comvalor = 't';
        $tipoconvenio = "816";
        if ($k00_impval == 't' ){
           $k00_valor = $utotal;
           $vlrbar = db_formatar(str_replace('.','',str_pad(number_format($k00_valor,2,"","."),11,"0",STR_PAD_LEFT)),'s','0',11,'e');
//           $vlrbar = "0".str_replace('.','',str_pad(number_format($k00_valor,2,"","."),11,"0",STR_PAD_LEFT));
//           if($utotal > 999.99)
//             $vlrbar = "0".$vlrbar;
//           if($utotal > 9999.99)
//             $vlrbar = "0".$vlrbar;
//           if($utotal > 99999.99)
//	     $vlrbar = "0".$vlrbar;
           $ninfla = '';
//           if ( $utotal == 0 || db_getsession(DB_anousu == substr($dtvencunic,1,2)) ){
           if ( $utotal == 0 ){
              $comvalor     = 'f';
              $tipoconvenio = "817";
              $vlrbar       = "00000000000";
           }
        }else{
           $k00_valor    = $qinfla;
           $comvalor     = 'f';
           $tipoconvenio = "817";
           $vlrbar       = "00000000000";
        }

        $numpre = db_numpre($k00_numpre).'000'; //db_formatar(0,'s',3,'e');
        $dtvenc = str_replace("-","",$dtvencunic);
        $resultcod = pg_exec("select fc_febraban('$tipoconvenio'||'$vlrbar'||'".$numbanco."'||$dtvenc||'000000'||'$numpre')");
        db_fieldsmemory($resultcod,0);
        $dtvencunic = db_formatar($dtvencunic,'d'); 		  
		
        $codigo_barras   = substr($fc_febraban,0,strpos($fc_febraban,','));
        $linha_digitavel = substr($fc_febraban,strpos($fc_febraban,',')+1);

        global $pdf;
        $pdf1->titulo1   = $descr; 
        $pdf1->descr1    = $numero; 
        $pdf1->descr2    = db_numpre($k00_numpre,0).'000'; //.db_formatar($k00_numpar,'s',"0",3,"e"); 
        if (isset($obs)){
           $pdf1->titulo13  = 'Observação';
           $pdf1->descr13   = $obs;
        } 
        if ( $k03_tipo==2 ){
           $pdf1->titulo4   = 'Atividade'; 
           $pdf1->descr4_1    = '- '.$q07_ativ.'-'.$q03_descr; 
           $pdf1->titulo13  = 'Atividade';
           $pdf1->descr13   = $q07_ativ;
        }else if ( ( $k03_tipo==6 ) || ( $k03_tipo==13)  ){
           $pdf1->titulo4   = 'Parcelamento';
           $pdf1->descr4_1    = '- '.$v07_parcel.$exercicio;
	   $pdf1->titulo13 = 'Parcelamento';
	   $pdf1->descr13  = $v07_parcel;
        }
        $pdf1->descr5    = 'UNICA'; 
        $pdf1->descr6    = $dtvencunic; 
        $pdf1->titulo8   = $descr;
        $pdf1->descr8    = $numero; 
        $pdf1->descr9    = db_numpre($k00_numpre,0).'000';
        $pdf1->descr10   = 'UNICA';
        if(!empty($HTTP_POST_VARS["ver_matric"])) {
            $pdf1->descr11_1 = $proprietario;
            $pdf1->descr11_2 = $xender;
            $pdf1->descr3_1  = $proprietario;
            $pdf1->descr3_2  = $xender;
        }else{
            $pdf1->descr11_1 = $z01_nome;
            $pdf1->descr11_2 = strtoupper($z01_ender).($z01_numero == ""?"":', '.$z01_numero.'  '.$z01_compl);
            $pdf1->descr3_1  = $z01_nome;   
            $pdf1->descr3_2  = strtoupper($z01_ender).($z01_numero == ""?"":', '.$z01_numero.'  '.$z01_compl);
        }
        if ( $pagabanco == 't'){
           $pdf1->descr12_1 = '- LOCAIS DE PAGAMENTO ATÉ O VENCIMENTO: BANCO DO BRASIL, BANRISUL, CAIXA ECONÔMICA FEDERAL, LOTÉRICAS E CONVENIADAS.'; 
	}else{
           $pdf1->descr12_1 = '- LOCAIS DE PAGAMENTO ATÉ O VENCIMENTO: BANCO DO BRASIL, BANRISUL, CAIXA ECONÔMICA FEDERAL, LOTÉRICAS E CONVENIADAS.'; 
        }
        $pdf1->descr14   = $dtvencunic;
        if ($tipoconvenio == '817'){
           if ( $k03_tipo == 3 ){
              $sqlaliq = "select q05_aliq from issvar where q05_numpre = $k00_numpre and q05_numpar = $k00_numpar";
              $pdf1->descr4_1   = $k00_numpar.'a PARCELA   -   Alíquota '.pg_result(pg_exec($sqlaliq),"q05_aliq").'%     EXERCÍCIO : '.$H_ANOUSU;
           }
           $pdf1->titulo7  = 'Valor Pago'; 
           $pdf1->titulo15 = 'Valor Pago';
           $pdf1->titulo13 = 'Valor da Receita Tributável';
        }else{
           $pdf1->descr15   = ($ninfla==''?'R$  '.db_formatar($k00_valor,'f'):$ninfla.'  '.$k00_valor);
           $pdf1->descr7    = ($ninfla==''?'R$  '.db_formatar($k00_valor,'f'):$ninfla.'  '.$k00_valor); 
        }
        $pdf1->descr12_2 = '- PARCELA ÚNICA COM '.$k00_percdes.'% DE DESCONTO NO IPTU.'; 
        $pdf1->linha_digitavel = $linha_digitavel;
        $pdf1->codigo_barras   = $codigo_barras;
        
//        debug($pdf1);exit;
        $pdf1->imprime();
      }
   }
   $unica = 2;
   if ( $sounica == ''){
      $pdf1->objpdf->Output();
      exit;
   }
}

//// FIM PARCELA UNICA

  $result = pg_exec("select fc_numbco($k00_codbco,'$k00_codage')");
  db_fieldsmemory($result,0);
 
  $valores = explode("P",$numpres[$volta]);
  $k00_numpre = $valores[0];
  $k00_numpar = $valores[1];  
  $k03_anousu = $H_ANOUSU;
//  echo $k00_numpre.'  '.$k00_numpar.'  '.$H_DATAUSU.'  '.$H_ANOUSU;exit;
  $DadosPagamento = debitos_numpre_carne($k00_numpre,$k00_numpar,$H_DATAUSU,$H_ANOUSU);
  db_fieldsmemory($DadosPagamento,0);
  $sql1 = "select case when k00_dtvenc > '".date("Y-m-d",$H_DATAUSU)."' then
             k00_dtvenc else '".date("Y-m-d",$H_DATAUSU)."'end as k00_dtvenc  ,k00_numtot 
           from arrecad 
           where k00_numpre = $k00_numpre 
             and k00_numpar = $k00_numpar 
           limit 1";  
  db_fieldsmemory(pg_exec($sql1),0);
  $k00_dtvenc = db_formatar($k00_dtvenc,'d');
  $sqlvalor = "select k00_impval from arretipo where k00_tipo = $tipo_debito";
  db_fieldsmemory(pg_exec($sqlvalor),0);
  $comvalor = 't';
  $tipoconvenio = "816";
  $ss = $ninfla;
  if ($k00_impval == 't' ){
      $k00_valor = $total;
      $vlrbar = db_formatar(str_replace('.','',str_pad(number_format($k00_valor,2,"","."),11,"0",STR_PAD_LEFT)),'s','0',11,'e');
//      if($total > 999.99)
//        $vlrbar = "0".$vlrbar;
//      if($total > 9999.99)
//        $vlrbar = "0".$vlrbar;
//      if($total > 99999.99)
//        $vlrbar = "0".$vlrbar;

       $ninfla = '';
      if ( ( $total == 0 ) || ( substr($k00_dtvenc,6,4) > date("Y",$H_DATAUSU)) ){
         $comvalor     = 'f';
         $tipoconvenio = "817";
         $vlrbar       = "00000000000";
         if ( $total != 0 ){
           $k00_valor = $qinfla;
           $ninfla = $ss;
         }
      }
  }else{
      $k00_valor    = $qinfla;
      $comvalor     = 'f';
      $tipoconvenio = "817";
      $vlrbar       = "00000000000";
  }

//  $numbanco = "4268" ;// deve ser tirado do db_config
  $resultnumbco = pg_exec("select numbanco from db_config where codigo = " . db_getsession("DB_instit"));
  $numbanco = pg_result($resultnumbco,0) ;// deve ser tirado do db_config

  $numpre = db_numpre($k00_numpre).db_formatar($k00_numpar,'s',"0",3,"e");
  $dtvenc = substr($k00_dtvenc,6,4).substr($k00_dtvenc,3,2).substr($k00_dtvenc,0,2);   
  $resultcod = pg_exec("select fc_febraban('$tipoconvenio'||'$vlrbar'||'$numbanco'||$dtvenc||'000000'||'$numpre')");

  db_fieldsmemory($resultcod,0);
  $codigo_barras   = substr($fc_febraban,0,strpos($fc_febraban,','));
  $linha_digitavel = substr($fc_febraban,strpos($fc_febraban,',')+1);

  $result = pg_exec("select k15_local,k15_aceite,k15_carte,k15_espec,k15_ageced
 		     from cadban
                     where k15_codbco = $k00_codbco 
                       and k15_codage = '$k00_codage'");
  if(pg_numrows($result) > 0) {	
    $k15_local=pg_result($result,0,0);
    $k15_aceite=pg_result($result,0,1);
    $k15_carte=pg_result($result,0,2);
    $k15_espec=pg_result($result,0,3);
    $k15_ageced=pg_result($result,0,4);
    $fc_numbco=$fc_numbco;
    $dt_hoje=date('d/m/Y',$H_DATAUSU);
  }
  $numpre = db_sqlformat($k00_numpre,8,'0').'000999';
  $numpre = $numpre . db_CalculaDV($numpre,11);

  $numbanco   = $fc_numbco;
  global $pdf;
  $pdf1->descr12_2 = ''; 
  $pdf1->titulo1   = $descr; 
  $pdf1->descr1    = $numero; 
  $pdf1->descr2    = db_numpre($k00_numpre,0).db_formatar($k00_numpar,'s',"0",3,"e");
  if(!empty($HTTP_POST_VARS["ver_matric"])) {
      $pdf1->descr11_1 = $proprietario;
      $pdf1->descr11_2 = $xender;
      $pdf1->descr11_3 = $xbairro;
      $pdf1->descr3_1 = $proprietario;
      $pdf1->descr3_2 = $xender;
      $pdf1->descr3_3 = $xbairro;
  }else{
      $pdf1->descr11_1 = $z01_nome;
      $pdf1->descr11_2 = strtoupper($z01_ender).($z01_numero == ""?"":', '.$z01_numero.'  '.$z01_compl);
      $pdf1->descr11_3  = $z01_bairro;
      $pdf1->descr3_1  = $z01_nome;   
      $pdf1->descr3_2  = strtoupper($z01_ender).($z01_numero == ""?"":', '.$z01_numero.'  '.$z01_compl);
      $pdf1->descr3_3  = $z01_bairro;
  }
  if ( $k00_hist1 == '' || $k00_hist2 == '' ){
     $pdf1->descr4_1 = $k00_numpar.'a PARCELA'; 
     if ($k03_tipo == 16) {
       $sqldiversos = "select distinct dv05_obs from termo inner join termodiver on dv10_parcel = v07_parcel inner join diversos on dv05_coddiver = dv10_coddiver where v07_numpre = $k00_numpre";
       $resultdiversos = pg_exec($sqldiversos);
       if (pg_numrows($resultdiversos) > 0) {
	 db_fieldsmemory($resultdiversos,0,true);
	 $pdf1->descr4_2 = substr($dv05_obs,0,100);
       }
       
     } elseif ($k03_tipo == 7) {
       
       $sqldiversos = "select distinct dv05_obs from diversos where dv05_numpre = $k00_numpre";
       $resultdiversos = pg_exec($sqldiversos);
       if (pg_numrows($resultdiversos) > 0) {
	 db_fieldsmemory($resultdiversos,0,true);
	 $pdf1->descr4_2 = substr($dv05_obs,0,100);
       }

     }
  }else{
     $pdf1->descr4_1 = $k00_hist1; 
     $pdf1->descr4_2 = $k00_hist2; 
  }
  if (isset($obs)){
     $pdf1->titulo13  = 'Observação';
     $pdf1->descr13   = $obs;
  } 
  if ( $k03_tipo==2 ){
     $pdf1->titulo4   = 'Atividade'; 
     $pdf1->descr4_1    = '- '.$q07_ativ.'-'.$q03_descr; 
     $pdf1->titulo13  = 'Atividade';
     $pdf1->descr13   = $q07_ativ;
  }else if ( ( $k03_tipo==6 ) || ( $k03_tipo==13 )){
     $pdf1->titulo4   = 'Parcelamento';
     $pdf1->descr4_1    = '- '.$v07_parcel.$exercicio;
     $pdf1->titulo13 = 'Parcelamento';
     $pdf1->descr13  = $v07_parcel;
  }
  $pdf1->descr5    = $k00_numpar.' / '.$k00_numtot; 
  $pdf1->descr6    = $k00_dtvenc; 
  $pdf1->titulo8   = $descr;
  $pdf1->descr8    = $numero; 
  $pdf1->descr9    = db_numpre($k00_numpre,0).db_formatar($k00_numpar,'s',"0",3,"e");
  $pdf1->descr10   = $k00_numpar.' / '.$k00_numtot;;
  $pdf1->descr14   = $k00_dtvenc;
  if ($total == 0){
      if ( $k03_tipo == 3 ){
         $sqlaliq = "select q05_aliq from issvar where q05_numpre = $k00_numpre and q05_numpar = $k00_numpar";
         $pdf1->descr4_1   = $k00_numpar.'a PARCELA   -   Alíquota '.pg_result(pg_exec($sqlaliq),"q05_aliq").'%     EXERCÍCIO : '.$H_ANOUSU;
      }
      $pdf1->titulo7  = 'Valor Pago'; 
      $pdf1->titulo15 = 'Valor Pago';
      $pdf1->titulo13 = 'Valor da Receita Tributável';
      $pdf1->descr15   = '';
      $pdf1->descr7    = ''; 
  }else{
      $pdf1->descr15   = ($ninfla==''?'R$  '.db_formatar($k00_valor,'f'):$ninfla.'  '.$k00_valor);
      $pdf1->descr7    = ($ninfla==''?'R$  '.db_formatar($k00_valor,'f'):$ninfla.'  '.$k00_valor); 
  }
    $rsmsgcarne = pg_query("select k03_msgcarne, k03_msgbanco from numpref where k03_anousu = ".db_getsession("DB_anousu"));
    if (pg_numrows($rsmsgcarne)>0){
       db_fieldsmemory($rsmsgcarne,0);     
    }
  if ( $pagabanco == 't'){
       if (isset($k03_msgbanco)&&$k03_msgbanco!=""){
            $pdf1->descr12_1 = $k03_msgbanco;
       }
  }else{
        $pdf1->descr12_1 = '- O PAGAMENTO DEVERÁ SER EFETUADO SOMENTE NA PREFEITURA.';
  }
  $sqlparag = "select db02_texto 
	       from db_documento 
	       inner join db_docparag on db03_docum = db04_docum 
	       inner join db_paragrafo on db04_idparag = db02_idparag 
	       where db03_docum = 27 and db02_descr ilike '%MENSAGEM CARNE%' and db03_instit = " . db_getsession("DB_instit");
  $resparag = pg_query($sqlparag);
    if (isset($k03_msgcarne)&&$k03_msgcarne!=""){
       $pdf1->descr16_1 = substr($k03_msgcarne,0,50);
       $pdf1->descr16_2 = substr($k03_msgcarne,50,50);
       $pdf1->descr16_3 = substr($k03_msgcarne,100,50);
    }else{
       $pdf1->descr16_1 = "  ";  
    //}
//  $pdf1->descr16_1 = 'O valor da parcela será atualizado pela URM Municipal';
//  $pdf1->descr16_2 = 'no primeiro dia útil de cada ano, conforme Lei Municipal n'.chr(186);
//  $pdf1->descr16_3 = '2955/2002.';
  //} else {
    db_fieldsmemory($resparag,0);
    $pdf1->descr16_1 = substr($db02_texto,0,55);
    $pdf1->descr16_2 = substr($db02_texto,55,55);
    $pdf1->descr16_3 = substr($db02_texto,110,55);
  }
  $pdf1->texto     = db_getsession('DB_login').' - '.date("d-m-Y - H-i").'   '.db_base_ativa();
  $pdf1->linha_digitavel = $linha_digitavel;
  $pdf1->codigo_barras   = $codigo_barras;
  $pdf1->imprime();
}
 pg_exec("COMMIT");

$pdf1->objpdf->Output();
}

?>
