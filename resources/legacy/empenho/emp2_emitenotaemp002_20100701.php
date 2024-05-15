<?
include("fpdf151/impcarne.php");
include("fpdf151/scpdf.php");
include("libs/db_sql.php");
include("libs/db_utils.php");
include("classes/db_empautitem_classe.php");
include("classes/db_empparametro_classe.php");
include("classes/db_cgmalt_classe.php");
$clempparametro	  = new cl_empparametro;
$clempautitem     = new cl_empautitem;
$clcgmalt         = new cl_cgmalt;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);

$head3 = "CADASTRO DE CÓDIGOS";
//$head5 = "PERÍODO : ".$mes." / ".$ano;

$sqlpref = "select * from db_config where codigo = ".db_getsession("DB_instit");
$resultpref = pg_exec($sqlpref);
db_fieldsmemory($resultpref,0);

$anousu = db_getsession("DB_anousu");
if(isset($e60_numemp) && $e60_numemp != ''){
   $dbwhere     = " e60_numemp = $e60_numemp ";
   $sql         = "select e60_anousu as anousu from empempenho where $dbwhere";
   $res_empenho = @pg_query($sql);
   $numrows_empenho = @pg_numrows($res_empenho);
   if ($numrows_empenho != 0){
     db_fieldsmemory($res_empenho,0);
   }
} else if (isset($e60_codemp) && $e60_codemp !=''){
	      $arr = explode("/",$e60_codemp);
	      if(count($arr) == 2  && isset($arr[1]) && $arr[1] != '' ){
		$dbwhere_ano = " and e60_anousu = ".$arr[1];
    $anousu = $arr[1];
       	      }else{
		$dbwhere_ano = " and e60_anousu = ".db_getsession("DB_anousu");
	      }
      $dbwhere = "e60_codemp='".$arr[0]."'$dbwhere_ano";
	      
}else{
  if( isset($dtini_dia) ){
    $dbwhere = " e60_emiss >= '$dtini_ano-$dtini_mes-$dtini_dia'";
   
    if( isset($dtfim_dia) ){
      $dbwhere .= " and e60_emiss <= '$dtfim_ano-$dtfim_mes-$dtfim_dia'";
    }
  }  
  
}
$sqlemp = "
	select empempenho.*,
	       cgm.* ,
	       o58_orgao,
	       o40_descr,
	       o58_unidade,
	       o41_descr,
	       o58_funcao,
	       o52_descr,
	       o58_subfuncao,
	       o53_descr,
	       o58_programa,
	       o54_descr,
	       o58_projativ,
	       o55_descr,
	       o58_coddot,
	       o41_cnpj,
	       o56_elemento as sintetico,
	       o56_descr as descr_sintetico,
	       o58_codigo,
     	       o15_descr,
	       e61_autori,	    
           pc50_descr,   
	       fc_estruturaldotacao(o58_anousu,o58_coddot) as estrutural,
	       e41_descr,
         c58_descr,
         e56_orctiporec
	from empempenho 
	     left join pctipocompra	on pc50_codcom = e60_codcom
	     inner join orcdotacao 	on o58_coddot = e60_coddot
	                               and o58_instit = ".db_getsession("DB_instit")."
				       and o58_anousu = e60_anousu
	     inner join orcorgao   	on o58_orgao = o40_orgao
	                               and o40_anousu = $anousu
	     inner join orcunidade 	on o58_unidade = o41_unidade
	                               and o58_orgao = o41_orgao
	                               and o41_anousu = o58_anousu
	     inner join orcfuncao  	on o58_funcao = o52_funcao
	     inner join orcsubfuncao  	on o58_subfuncao = o53_subfuncao
	     inner join orcprograma  	on o58_programa = o54_programa
	                               and o54_anousu = o58_anousu
	     inner join orcprojativ  	on o58_projativ = o55_projativ
	                               and o55_anousu = o58_anousu
	     inner join orcelemento 	on o58_codele = o56_codele
	                               and o58_anousu = o56_anousu
	     inner join orctiporec  	on o58_codigo = o15_codigo
	     inner join cgm 		on z01_numcgm = e60_numcgm
       inner join concarpeculiar on concarpeculiar.c58_sequencial = empempenho.e60_concarpeculiar
	     left outer join empempaut	on e60_numemp = e61_numemp
	     left join  empautidot      on e61_autori = e56_autori
	     left outer join emptipo  	on e60_codtipo= e41_codtipo
	where  $dbwhere
	";


$result = pg_exec($sqlemp);	
//db_criatabela($result);exit;
if (pg_numrows($result)==0){
   db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado !  ");
}



$pdf = new scpdf();
$pdf->Open();
$pdf1 = new db_impcarne($pdf,'6');
//$pdf1->modelo = 6;
$pdf1->objpdf->SetTextColor(0,0,0);

//   $pdf1->imprime();

//$pdf1->objpdf->Output();

//exit;

//rotina que pega o numero de vias
//add campo e30_impobslicempenho
$result02 = $clempparametro->sql_record($clempparametro->sql_query_file(db_getsession("DB_anousu"),"e30_nroviaemp,e30_numdec,e30_impobslicempenho"));
//echo $clempparametro->sql_query_file(db_getsession("DB_anousu"),"e30_nroviaemp");
if($clempparametro->numrows>0){
  db_fieldsmemory($result02,0);
}     	 
//recebido variavel
$pdf1->nvias   = $e30_nroviaemp;
$pdf1->casadec = $e30_numdec;

//db_criatabela($result); exit;

for ($i = 0;$i < pg_numrows($result);$i++){

  db_fieldsmemory($result,$i);
  $sSqlPacto  = " SELECT distinct pactoplano.* ";
  $sSqlPacto .= "   from empautitem "; 
  $sSqlPacto .= "        inner join pcprocitem on e55_sequen = pc81_codprocitem  ";
  $sSqlPacto .= "        inner join solicitem on pc81_solicitem = pc11_codigo  ";
  $sSqlPacto .= "        inner join orctiporecconveniosolicita on pc11_numero = o78_solicita "; 
  $sSqlPacto .= "        inner join pactoplano on o78_pactoplano = o74_sequencial ";
  $sSqlPacto .= "  where e55_autori= {$e61_autori}";
  $rsPacto    = db_query($sSqlPacto);
  $o74_descricao  = null;
  $o78_pactoplano = null;
  if (@pg_num_rows($rsPacto) > 0) {
       
     $oPacto         = db_utils::fieldsMemory($rsPacto, 0);
     $o74_descricao  = $oPacto->o74_descricao;
     $o78_pactoplano = $oPacto->o74_sequencial;
     
  }
       
   $sqlitem = "select distinct
               case when e62_descr = '' then pc01_descrmater else pc01_descrmater||' ('||e62_descr||')' end as 
               pc01_descrmater,
	             e62_sequen,
	            e62_numemp,
			    e62_quant,
			    e62_vltot,
			    e62_vlrun,
			    e62_codele,
			    o56_elemento,
			    o56_descr,
			    pc81_codproc,
			    pc11_numero,
			    coalesce(trim(pc23_obs),'') as pc23_obs 
		     from empempitem
		          inner join empempenho    on empempenho.e60_numemp = empempitem.e62_numemp
		          inner join pcmater       on pcmater.pc01_codmater = empempitem.e62_item
			  inner join orcelemento   on orcelemento.o56_codele = empempitem.e62_codele and 
			                              orcelemento.o56_anousu = empempenho.e60_anousu
		          left join empempaut      on empempaut.e61_numemp  = empempenho.e60_numemp
	                  left join empautitem     on empautitem.e55_autori = empempaut.e61_autori
  	                  left join pcprocitem     on pcprocitem.pc81_codprocitem = empempitem.e62_sequen
		          left join solicitem      on solicitem.pc11_codigo = pcprocitem.pc81_solicitem
	                  left join liclicitem     on liclicitem.l21_codpcprocitem = empempitem.e62_sequen
	                  left join pcorcamitemlic on pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
	                  left join pcorcamjulg on pcorcamjulg.pc24_orcamitem = pcorcamitemlic.pc26_orcamitem and
			                           pcorcamjulg.pc24_pontuacao = 1
			  left join pcorcamval on pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem and
			                          pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
		     where e62_numemp = '$e60_numemp'
	       order by o56_elemento,pc01_descrmater";
   $resultitem = pg_exec($sqlitem);
   $result_cgmalt=$clcgmalt->sql_record($clcgmalt->sql_query_file(null,"z05_numcgm as z01_numcgm,z05_nome as z01_nome,z05_telef as z01_telef,z05_ender as z01_ender,z05_numero as z01_numero,z05_munic as z01_munic,z05_cgccpf as z01_cgccpf,z05_cep as z01_cep"," abs(z05_data_alt - date '$e60_emiss') asc, z05_sequencia desc limit 1","z05_numcgm = $z01_numcgm and z05_data_alt > '$e60_emiss' "));


   if ($clcgmalt->numrows>0){
     db_fieldsmemory($result_cgmalt,0);
   }

    
   /**
    * Verificamos o cnpj da unidade. caso diferente de null, e diferente do xcnpj da instituição, 
    * mostramso a descrição e o cnpj da unidade
    */
   if ($o41_cnpj != "" && $o41_cnpj!= $cgc) {
     
     $nomeinst = $o41_descr;
     $cgc      = $o41_cnpj;
     
   }
   $pdf1->emptipo        = $e41_descr;
   $pdf1->prefeitura     = $nomeinst;
   $pdf1->enderpref      = $ender.", ".$numero;
   $pdf1->cgcpref        = $cgc;
   $pdf1->municpref      = $munic;
   $pdf1->telefpref      = $telef;
   $pdf1->emailpref      = $email;

   $pdf1->numcgm         = $z01_numcgm;
   $pdf1->nome           = $z01_nome;
   $pdf1->telefone       = $z01_telef;
   $pdf1->ender          = $z01_ender.', '.$z01_numero;
   $pdf1->munic          = $z01_munic;
   $pdf1->cnpj           = $z01_cgccpf;
   $pdf1->cep            = $z01_cep;
   $pdf1->ufFornecedor   = $z01_uf;
   
   $pdf1->dotacao        = $estrutural;
   $pdf1->num_licitacao  = $e60_numerol;
   $pdf1->cod_concarpeculiar   = $e60_concarpeculiar;
   $pdf1->descr_concarpeculiar = substr($c58_descr,0,34);
   $pdf1->logo           = $logo;
   $pdf1->SdescrPacto    = $o74_descricao;
   $pdf1->iPlanoPacto    = $o78_pactoplano;
   $pdf1->contrapartida  = $e56_orctiporec;
   $pdf1->observacaoitem = "pc23_obs";
   $pdf1->Snumeroproc    = "pc81_codproc";
   $pdf1->Snumero        = "pc11_numero";

   
   //Zera as variáveis 
   $pdf1->resumo = "";
   $resumo_lic   = "";
   
   $result_licita = $clempautitem->sql_record($clempautitem->sql_query_lic(null,null,"distinct l20_objeto,l03_descr",null,"e55_autori = $e61_autori "));
   if ($clempautitem->numrows>0){
   		db_fieldsmemory($result_licita,0);
   		$resumo_lic=$l20_objeto;   		
   } else {
   	 $l03_descr  = '';
   	 $l20_objeto = '';
   }
   

   if (isset($resumo_lic)&&$resumo_lic!=""){
 	    if($e30_impobslicempenho=='t'){
	   		$pdf1->resumo = $resumo_lic."\n".$e60_resumo;   		
		}else {
			$pdf1->resumo = $e60_resumo;
		}
   }else{
   		$pdf1->resumo = $e60_resumo;
   }

   
   $Sresumo = $pdf1->resumo;
   $vresumo = explode("\n",$Sresumo);

   if (count($vresumo) > 1){
     $Sresumo   = "";
     $separador = "";
     for ($x = 0; $x < count($vresumo); $x++){
       if (trim($vresumo[$x]) != ""){
         $separador = ". ";
         $Sresumo  .= $vresumo[$x].$separador;
       }
     }
   }

   if (count($vresumo) == 0){
     $Sresumo = str_replace("\n",". ",$Sresumo);
   }

   $Sresumo = str_replace("\r","",$Sresumo);

	 $pdf1->resumo = substr($Sresumo,0,330);

   if (isset($l03_descr)&&($l03_descr!="")){
   		$pdf1->descr_licitacao = $l03_descr;
   }else{
 	$sqllic = "select l03_descr from cflicita where l03_codcom=$e60_codcom and l03_tipo='$e60_tipol'";
 	$rpc    = pg_query($sqllic);

//  system("echo '".$sqllic."\n' >> tmp/logsql.txt"); 

	if (pg_numrows($rpc) > 0 ){
            $pdf1->descr_licitacao = pg_result($rpc,0,0);
	} else {
     	    $pdf1->descr_licitacao = $pc50_descr;

	}   


   }
   //$pdf1->descr_licitacao  = $pc50_descr;
   $pdf1->coddot           = $o58_coddot;
   $pdf1->destino          = $e60_destin;
   //$pdf1->resumo           = $e60_resumo;
   $pdf1->licitacao        = $e60_codtipo;
   $pdf1->recorddositens   = $resultitem;
   $pdf1->linhasdositens   = pg_numrows($resultitem);
   $pdf1->quantitem        = "e62_quant";
   $pdf1->valoritem        = "e62_vltot";
   $pdf1->valor            = "e62_vlrun";
   $pdf1->descricaoitem    = "pc01_descrmater";

   $pdf1->orcado	   = $e60_vlrorc; 
   $pdf1->saldo_ant        = $e60_salant;
   $pdf1->empenhado        = $e60_vlremp;
   $pdf1->numemp           = $e60_numemp;
   $pdf1->codemp           = $e60_codemp;
   $pdf1->numaut           = $e61_autori;
   $pdf1->orgao            = $o58_orgao;
   $pdf1->descr_orgao      = $o40_descr;
   $pdf1->unidade          = $o58_unidade;
   $pdf1->descr_unidade    = $o41_descr;
   $pdf1->funcao           = $o58_funcao;
   $pdf1->descr_funcao     = $o52_descr;
   $pdf1->subfuncao        = $o58_subfuncao;
   $pdf1->descr_subfuncao  = $o53_descr;
   $pdf1->programa         = $o58_programa;
   $pdf1->descr_programa   = $o54_descr;
   $pdf1->projativ         = $o58_projativ;
   $pdf1->descr_projativ   = $o55_descr;
   $pdf1->analitico        = "o56_elemento";
   $pdf1->descr_analitico  = "o56_descr";
   $pdf1->sintetico        = $sintetico;
   $pdf1->descr_sintetico  = $descr_sintetico;
   $pdf1->recurso          = $o58_codigo;
   $pdf1->descr_recurso    = $o15_descr;
   $pdf1->banco            = null;
   $pdf1->agencia          = null;
   $pdf1->conta            = null;
   $sql  = "select c61_codcon
              from conplanoreduz
                   inner join conplano on c60_codcon = c61_codcon and c60_anousu=c61_anousu
                   inner join consistema on c52_codsis = c60_codsis
             where c61_instit   = ".db_getsession("DB_instit")."
               and c61_anousu   =".db_getsession("DB_anousu")."
               and c61_codigo   = $o58_codigo
               and c52_descrred = 'F' ";
   $result_conta = pg_exec($sql);
   //system("echo '".$sql."\n' >> tmp/logsql.txt"); 
   
	 //die ($sql);
   if ($result_conta != false && (pg_numrows($result_conta) == 1)) {
     db_fieldsmemory($result_conta,0);
     $sqlconta     = "select * from conplanoconta where c63_codcon = $c61_codcon and c63_anousu = ".db_getsession("DB_anousu");
     $result_conta = pg_exec($sqlconta);
   
//   system("echo '".$sqlconta."\n' >> tmp/logsql.txt"); 
     
     if (pg_result($result_conta,0) == 1) {
       db_fieldsmemory($result_conta,0);
       $pdf1->banco            = $c63_banco;
       $pdf1->agencia          = $c63_agencia;
       $pdf1->conta            = $c63_conta;
     }
   }

   $pdf1->emissao          = db_formatar($e60_emiss,'d');
   $pdf1->texto            = "";
   //db_getsession("DB_login").'  -  '.date("d-m-Y",db_getsession("DB_datausu")).'    '.db_hora(db_getsession("DB_datausu"));
/*
   // assinatura 1
   $sqlparag = "select db02_texto as assinatura1
                from db_documento
                     inner join db_docparag on db03_docum = db04_docum
                     inner join db_paragrafo on db04_idparag = db02_idparag
                where db03_descr like '%ASSINATURAS EMPENHO%' and db02_descr like '%ASSINATURA 1%' and db03_instit = " . db_getsession("DB_instit");
   $resparag = pg_query($sqlparag);
//   db_criatabela($resparag);
   if ( pg_numrows($resparag) > 0 ) {
      db_fieldsmemory($resparag,0);
      $pdf1->assinatura1 = $assinatura1;
   }

   // assinatura 2

   $sqlparag = "select db02_texto as assinatura2
                from db_documento
                     inner join db_docparag on db03_docum = db04_docum
                     inner join db_paragrafo on db04_idparag = db02_idparag
                where db03_descr like '%ASSINATURAS EMPENHO%' and db02_descr like '%ASSINATURA 2%' and db03_instit = " . db_getsession("DB_instit");
   $resparag = pg_query($sqlparag);

   if ( pg_numrows($resparag) > 0 ) {
      db_fieldsmemory($resparag,0);
      $pdf1->assinatura2 = $assinatura2;
   }


   // assinatura 3

   $sqlparag = "select db02_texto as assinatura3
                from db_documento
                     inner join db_docparag on db03_docum = db04_docum
                     inner join db_paragrafo on db04_idparag = db02_idparag
                where db03_descr like '%ASSINATURAS EMPENHO%' and db02_descr like '%ASSINATURA 3%' and db03_instit = " . db_getsession("DB_instit");
   $resparag = pg_query($sqlparag);

   if ( pg_numrows($resparag) > 0 ) {
      db_fieldsmemory($resparag,0);
      $pdf1->assinatura3 = $assinatura3;
   }
																								  
   // assinatura prefeito

   $sqlparag = "select db02_texto as assinaturaprefeito
                from db_documento
                     inner join db_docparag on db03_docum = db04_docum
                     inner join db_paragrafo on db04_idparag = db02_idparag
                where db03_descr like '%ASSINATURA PREFEITO%' and db02_descr like '%PREFEITO%' and db03_instit = " . db_getsession("DB_instit");
   $resparag = pg_query($sqlparag);

   if ( pg_numrows($resparag) > 0 ) {
      db_fieldsmemory($resparag,0);
      $pdf1->assinaturaprefeito = $assinaturaprefeito;
   }
*/
			  
   $pdf1->imprime();
}
//include("fpdf151/geraarquivo.php");
$pdf1->objpdf->Output();

   
?>
