<?
//include("libs/db_conecta.php");
//include ("libs/db_stdlib.php");
include ("libs/db_sql.php");
include ("dbforms/db_funcoes.php");
include ("classes/db_protparam_classe.php");
include ("classes/db_certidao_classe.php");
include ("classes/db_certidaocgm_classe.php");
include ("classes/db_certidaoinscr_classe.php");
include ("classes/db_certidaomatric_classe.php");
include ("classes/db_numpref_classe.php");
include ("classes/db_db_docparag_classe.php");
include ("classes/db_db_usuarios_classe.php");
include ("classes/db_db_certidaoweb_classe.php");

$ip = getenv("REMOTE_ADDR");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

//die($DOCUMENT_ROOT);
$textarea ="";
$codproc = "";

if (isset ($cadrecibo) && $cadrecibo == 't') {
	require ('fpdf151/scpdf.php');
} else {
	//echo"aki1111";	exit;
	require ('fpdf151/pdf1.php');
	//echo"aki1111";	exit;
}
$clcertidaoweb    = new cl_db_certidaoweb;
$clcertidao       = new cl_certidao;
$clcertidaocgm    = new cl_certidaocgm;
$clcertidaoinscr  = new cl_certidaoinscr;
$clcertidaomatric = new cl_certidaomatric;
$clnumpref        = new cl_numpref;
$cldb_docparag    = new cl_db_docparag;
$cldb_usuarios    = new cl_db_usuarios;

$dadosbaixaempresa     = "";
$dadosalvaráprovisório = "";
$dadosbaixamatricula   = "";

/********************************** CODIGO DE BARRAS DBPREF **************************************************************/
	
	$mes1 = date("m");
	$ano = date("Y");
	$dia = date("d");
	$hora = date("H");
	$min = date("i");
	$sec = date("s");
	$ip = getenv("REMOTE_ADDR");
	
	//$venc = dateadd(90, $datahoje = "?");
	// @TODO tem que acrescentar o filtro por instituicao w13_instit
	$w13_instit = db_getsession('DB_instit');
	$sqlconfig = "select * from configdbpref where w13_instit = $w13_instit ";
	$resultconfig = pg_query($sqlconfig);
	$linhaconfig  = pg_num_rows($resultconfig);
	if ($linhaconfig>0){
	  db_fieldsmemory($resultconfig, 0);
	}
	$sqlvenc = "select '$ano-$mes1-$dia'::date + '$w13_diasvenccertidao days'::interval as datavenc";
	$resultvenc = pg_query($sqlvenc) or die($sqlvenc);
	db_fieldsmemory($resultvenc, 0);

	$venc = $datavenc;
	$dia2 = substr($venc, 8, 2);
	$mes2 = substr($venc, 5, 2);
	$ano2 = substr($venc, 0, 4);

	$venc = $ano2 . "-" . $mes2 . "-" . $dia2;
	$sequencia = pg_query("select nextval('db_certidaoweb_codcert_seq')") or die("erro ao gerar sequencia");
	$seq2 = pg_result($sequencia, 0, 0);
	$tamanho = strlen($seq2);
	$seq = "";
	for ($i = 0; $i < (7 - $tamanho); $i++) {
		$seq .= "0";
	}
	$seq .= $seq2;
	// @TODO tem que acrescentar o filtro por instituicao w13_instit
	$sql = pg_query("select cgc from db_config where codigo = $w13_instit limit 1");
	for ($i = 0; $i < (pg_numfields($sql)); $i++) {
		@ db_fieldsmemory($sql, 0);
	}
	
	$nros = $seq . $cgc . $ano . $mes1 . $dia . $hora . $min . $sec ;//. $ano2 . $mes2 . $dia2;
	$t1 = strrev($nros);
	
	//************* fim do codigo **********************
//**************************************************************************************************************************//

if (isset ($textarea) && $textarea != "") {
	$historico = $textarea;
} else {
	$textarea = @ $historico;
}
if ($codproc != "") {
	if (strpos($codproc, "/") > 0) {
		$codproc = explode("\/", $codproc);
		$exercicio = $codproc[1];
		$codproc = $codproc[0];
	} else {
		$codproc = $codproc;
		$exercicio = db_getsession("DB_anousu");
	}
} else {
	$codproc = "";
	$exercicio = 0;
}

$rescodimpresso = $clnumpref->sql_record($clnumpref->sql_query(db_getsession("DB_anousu"),db_getsession('DB_instit'),"k03_tipocodcert"));
if ($clnumpref->numrows == 0){
	db_redireciona("db_erros.php?fechar=true&db_erro=Tipo de codificação da certidão não configurada nos parâmetros.");
	exit;
}
db_fieldsmemory($rescodimpresso, 0);
//******************************************** G R A V A   A   C E R T I D A O **********************************************//	

if ($codproc && $codproc != "") {
	$proc = ",conforme processo N".chr(176)." $codproc, ";
}
$sqlerro = false;
db_inicio_transacao();
if ($tipo == 1) {
	$clcertidao->p50_tipo = "p";
} else if ($tipo == 2) {
	$clcertidao->p50_tipo = "n";
} else {
	$clcertidao->p50_tipo = "r";
}
$id_usu = @$_SESSION["id"];
if($id_usu==""){
	$id_usu="1";
}
$hj = date("Y-m-d", db_getsession('DB_datausu'));
$clcertidao->p50_idusuario = $id_usu;
$clcertidao->p50_data = $hj;
$clcertidao->p50_hora = db_hora();
$clcertidao->p50_ip = $ip;
if (isset ($historico) && $historico != "") {
	$clcertidao->p50_hist = $historico. ($codproc != '' ? ", processo N".chr(176).": ".$codproc : '');
} else {
	$clcertidao->p50_hist = " ". ($codproc != '' ? "Processo N".chr(176).": ".$codproc : '');
}
//echo "ccccccccc".db_getsession("DB_instit"); exit;
$clcertidao->p50_web = 'true';
$clcertidao->p50_codproc = $codproc;
$clcertidao->p50_exerc = $exercicio;
$clcertidao->p50_codimpresso = '';
$clcertidao->p50_instit = db_getsession("DB_instit");
$clcertidao->incluir(null);
if ($clcertidao->erro_status == '0') {
	$erro_msg = $clcertidao->erro_msg."--- Inclusão Certidão";
	db_redireciona("db_erros.php?fechar=true&db_erro=$erro_msg");
	$sqlerro = true;
}
if (isset ($titulo) && $titulo == 'CGM') {
	$numcgm = $origem;
	$clcertidaocgm->p49_sequencial = $clcertidao->p50_sequencial;
	$clcertidaocgm->p49_numcgm = $numcgm;
	$clcertidaocgm->incluir();
		
	if ($clcertidaocgm->erro_status == '0') {
		$erro_msg = $clcertidaocgm->erro_msg."--- Inclusão Certidão CGM";
		db_redireciona("db_erros.php?fechar=true&db_erro=$erro_msg");
		$sqlerro = true;
	}
	
} else if (isset ($titulo) && $titulo == 'MATRICULA') {
	$matric = $origem;
	$clcertidaomatric->p47_sequencial = $clcertidao->p50_sequencial;
	$clcertidaomatric->p47_matric = $matric;
	$clcertidaomatric->incluir();
	if ($clcertidaomatric->erro_status == '0') {
		$erro_msg = $clcertidaomatric->erro_msg."--- Inclusão Certidão Matricula";
		db_redireciona("db_erros.php?fechar=true&db_erro=$erro_msg");
		$sqlerro = true;
	}
} else if (isset ($titulo) && $titulo == 'INSCRICAO') {
	$inscr = $origem;
	$clcertidaoinscr->p48_sequencial = $clcertidao->p50_sequencial;
	$clcertidaoinscr->p48_inscr = $inscr;
	$clcertidaoinscr->incluir();
	if ($clcertidaoinscr->erro_status == '0') {
		$erro_msg = $clcertidaoinscr->erro_msg."--- Inclusão Certidão Inscrição";
		db_redireciona("db_erros.php?fechar=true&db_erro=$erro_msg");
		$sqlerro = true;
	}
}
//die($k03_tipocodcert);
if ($k03_tipocodcert != 0) {
	if ($k03_tipocodcert == 5) {
		$codimpresso = $codproc."/".$exercicio;
	} else {
		$iInstit     = db_getsession("DB_instit");
		$iTipoCodigo = $k03_tipocodcert;
		$sTipoCertidao = $clcertidao->p50_tipo;
		$codimpresso = pg_result(pg_query("select fc_numerocertidao($iInstit,$iTipoCodigo,'{$sTipoCertidao}')"),0);
		//die($codimpresso); 
	} 
	/*
	if ($k03_tipocodcert == 1) {
		//sequencial geral
		$codimpresso = $clcertidao->p50_sequencial;
	} else if ($k03_tipocodcert == 2) {
		//codigo do processo
		$codimpresso = $codproc."/".$exercicio;
	} else if ($k03_tipocodcert == 3) {
		//sequencial por tipo
		$sql = "select count(*) as codimpresso from certidao where p50_tipo = '".$clcertidao->p50_tipo."'";
		$rescodimpresso = $clcertidao->sql_record($sql);
		if ($clcertidao->numrows > 0) {
			db_fieldsmemory($rescodimpresso, 0);
		} else {
			$codimpresso = 1;
		}
	} else {
		$codimpresso = $clcertidao->p50_sequencial;
	}
	*/
	
	$clcertidaoalt = new cl_certidao;
	$clcertidaoalt->p50_sequencial = $clcertidao->p50_sequencial;
	$clcertidaoalt->p50_codimpresso = $codimpresso;
	$clcertidaoalt->alterar($clcertidao->p50_sequencial);
	if ($clcertidaoalt->erro_status == '0') {
		$erro_msg = $clcertidaoalt->erro_msg."--- Inclusão do código do processo de impressão";
		db_redireciona("db_erros.php?fechar=true&db_erro=$erro_msg");
		$sqlerro = true;
	}
	// linha incluida para atualizar a classe clcertidao com o codigo a ser impresso pois abaixo o programa trata somente a clcertidao
	$clcertidao->p50_codimpresso = $clcertidaoalt->p50_codimpresso;
}
//die($clcertidao->p50_codimpresso);

db_fim_transacao($sqlerro);

//**************************************************************************************************************************//
if (isset ($textarea) && $textarea != "") {
	$historico = $textarea;
} else {
	$textarea = @ $historico;
} 
$codtipodoc = 0;
$sql = "select nomeinst,ender,munic,uf,telef,email,url,logo from db_config where prefeitura = true and codigo = $w13_instit ";
$result = pg_query($sql);
if(pg_num_rows($result) > 0){
	db_fieldsmemory($result, 0);
}

if($w13_tipocertidao == '3') {
  $w13_tipocertidao = $indconj;
}

if ($tipo == 1) {
	// certidao positiva 
	$tipocer = "CERTIDÃO POSITIVA DE DÉBITO";
	if (isset ($matric)) {
		
	  $codtipodoc = $w13_tipocertidao == '1' ?  1028 : 2028 ;
		//$codtipodoc = 1028;
		$codtipo = 26;
		
		
		$sql = "select * from proprietario where j01_matric = $matric";
		$result = pg_query($sql);
		db_fieldsmemory($result, 0);
		
    if (isset ($j01_baixa) && $j01_baixa != "") {
      $situinscr           = "Situação da matrícula : MATRÍCULA BAIXADA ";
      $dadosbaixamatricula = "Matricula Baixada em: ".db_formatar($j01_baixa,'d');
    } else {
      $situinscr           = "Situação da matrícula : MATRÍCULA ATIVA ";

    }
     
		db_sel_instit(null, "db21_usasisagua");
		if($db21_usasisagua == 't') {
		  $sSqlEndImovel = "select j14_nome, x01_numero, x11_complemento, j13_descr, x01_quadra
                          from aguabase
                         inner join ruas       on j14_codigo = x01_codrua
                         inner join aguaconstr on x11_matric = x01_matric
												 inner join bairro     on j13_codi   = x01_codbairro
												 where x01_matric = $matric";
		  $rSqlEndImovel = pg_query($sSqlEndImovel);
		  db_fieldsmemory($rSqlEndImovel, 0); 	
		}
		
	} else	if (isset ($numcgm)) {
		
		$codtipodoc = $w13_tipocertidao == '1' ?  1030 : 2030 ;
		//$codtipodoc = 1030;
		$codtipo = 27;
		$sql = "select trim(z01_nome) as z01_nome,* from cgm where z01_numcgm = $numcgm";
		$result = pg_query($sql);
		db_fieldsmemory($result, 0);
					
	} else	if (isset ($inscr)) {
		
		$codtipodoc = $w13_tipocertidao == '1' ?  1029 : 2029 ;
		//$codtipodoc = 1029;
		$codtipo = 28;
		$sql = "select * from empresa where q02_inscr = $inscr";
		$result = pg_query($sql);
		db_fieldsmemory($result, 0);
		
    if (isset ($q02_dtbaix) && $q02_dtbaix != "") {
      $situinscr         = "Situação do alvará : ALVARÁ BAIXADO ";
      $dadosbaixaempresa = "Alvará Baixado em: ".db_formatar($q02_dtbaix,'d');
    } else {
      $situinscr         = "Situação do alvará : ALVARÁ ATIVO ";
    }       
    
    $sql2 = " select q07_inscr, 
                     q07_perman, 
                     min(q07_datain) as q07_datain, 
                     max(q07_datafi) as q07_datafi 
                from tabativ 
               where q07_inscr = {$inscr} 
                             and q07_perman = false 
           group by  q07_inscr, q07_perman ";
    //die($sql2);
    $result2 = pg_query($sql2);
    
    if (pg_num_rows($result2) > 0) {
      db_fieldsmemory($result2, 0);
    }

    if (pg_num_rows($result2) > 0) {
      $dadosalvaráprovisório = "Alvará Provisório Válido entre : (".db_formatar($q07_datain,'d')." e ".db_formatar($q07_datafi,'d').")";
    } 			
	}
} else	if ($tipo == 2) {
	// certidao negativa
	$tipocer = "CERTIDÃO NEGATIVA";
	if (isset ($matric)) {
		
		$codtipodoc = $w13_tipocertidao == '1' ?  1022 : 2022 ;
		//$codtipodoc = 1022;
		$codtipo = 29;
		$sql = "select * from proprietario where j01_matric = $matric";
		$result = pg_query($sql);
		db_fieldsmemory($result, 0);
		
	  if (isset ($j01_baixa) && $j01_baixa != "") {
      $situinscr           = "Situação da matrícula : MATRÍCULA BAIXADA ";
      $dadosbaixamatricula = "Matricula Baixada em: ".db_formatar($j01_baixa,'d');
    } else {
      $situinscr           = "Situação da matrícula : MATRÍCULA ATIVA ";
    }

    db_sel_instit(null, "db21_usasisagua");    
    if($db21_usasisagua == 't') {
      $sSqlEndImovel = "select j14_nome, x01_numero, x11_complemento, j13_descr, x01_quadra
                          from aguabase
                         inner join ruas       on j14_codigo = x01_codrua
                         inner join aguaconstr on x11_matric = x01_matric
                         inner join bairro     on j13_codi   = x01_codbairro
                         where x01_matric = $matric";
      $rSqlEndImovel = pg_query($sSqlEndImovel);
      db_fieldsmemory($rSqlEndImovel, 0);   
    }
			
	} else	if (isset ($numcgm)) {
	
		$codtipodoc = $w13_tipocertidao == '1' ?  1024 : 2024 ;
		//$codtipodoc = 1024;
		$codtipo = 30;
		$sql = "select trim(z01_nome) as z01_nome,* from cgm where z01_numcgm = $numcgm";
		$result = pg_query($sql);
		db_fieldsmemory($result, 0);		
				
	} else if (isset ($inscr)) {
		
		$codtipodoc = $w13_tipocertidao == '1' ?  1023 : 2023 ;
		//$codtipodoc = 1023;
		$codtipo = 31;
		$sql = "select * from empresa where q02_inscr = $inscr";
		$result = pg_query($sql);
		db_fieldsmemory($result, 0);
		
	    if (isset ($q02_dtbaix) && $q02_dtbaix != "") {
      $situinscr         = "Situação do alvará : ALVARÁ BAIXADO ";
      $dadosbaixaempresa = "Alvará Baixado em: ".db_formatar($q02_dtbaix,'d');
    } else {
      $situinscr         = "Situação do alvará : ALVARÁ ATIVO ";
    }
            
    $sql2 = " select q07_inscr, 
                     q07_perman, 
                     min(q07_datain) as q07_datain, 
                     max(q07_datafi) as q07_datafi 
                from tabativ 
               where q07_inscr = {$inscr} 
                             and q07_perman = false 
           group by  q07_inscr, q07_perman ";
    //die($sql2);
    $result2 = pg_query($sql2);
    
    if (pg_num_rows($result2) > 0) {
      db_fieldsmemory($result2, 0);
    }
    
    if (pg_num_rows($result2) > 0) {
      $dadosalvaráprovisório = "Alvará Provisório Válido entre : (".db_formatar($q07_datain,'d')." e ".db_formatar($q07_datafi,'d').")";
    }	
				
	}
} else {
	// certidao regular
	$tipocer = "CERTIDÃO POSITIVA COM EFEITO DE NEGATIVA";
	if (isset ($matric)) {
		$codtipo = 32;
		$codtipodoc = $w13_tipocertidao == '1' ?  1025 : 2025 ;
		//$codtipodoc = 1025;
		$sql = "select * from proprietario where j01_matric = $matric";
		$result = pg_query($sql);
		db_fieldsmemory($result, 0);
		
	  if (isset ($j01_baixa) && $j01_baixa != "") {
      $situinscr           = "Situação da matrícula : MATRÍCULA BAIXADA ";
      $dadosbaixamatricula = "Matricula Baixada em: ".db_formatar($j01_baixa,'d');
    } else {
      $situinscr           = "Situação da matrícula : MATRÍCULA ATIVA ";
    }
    

    db_sel_instit(null, "db21_usasisagua");    
    if($db21_usasisagua == 't') {
      $sSqlEndImovel = "select j14_nome, x01_numero, x11_complemento, j13_descr, x01_quadra
                          from aguabase
                         inner join ruas       on j14_codigo = x01_codrua
                         inner join aguaconstr on x11_matric = x01_matric
                         inner join bairro     on j13_codi   = x01_codbairro
                         where x01_matric = $matric";
      $rSqlEndImovel = pg_query($sSqlEndImovel);
      db_fieldsmemory($rSqlEndImovel, 0);   
    }
		
	} else	if (isset ($numcgm)) {
	
		$codtipodoc = $w13_tipocertidao == '1' ?  1027 : 2027 ;
		//$codtipodoc = 1027;
		$codtipo = 33;
		$sql = "select trim(z01_nome) as z01_nome,* from cgm where z01_numcgm = $numcgm";
		$result = pg_query($sql);
		db_fieldsmemory($result, 0);	
					
	} else	if (isset ($inscr)) {
		$codtipo = 34;
		$codtipodoc = $w13_tipocertidao == '1' ?  1026 : 2026 ;
		//$codtipodoc = 1026;
		$sql = "select * from empresa where q02_inscr = $inscr";
		$result = pg_query($sql);
		db_fieldsmemory($result, 0);
		
    if (isset ($q02_dtbaix) && $q02_dtbaix != "") {
      $situinscr         = "Situação do alvará : ALVARÁ BAIXADO ";
      $dadosbaixaempresa = "Alvará Baixado em: ".db_formatar($q02_dtbaix,'d');
    } else {
      $situinscr         = "Situação do alvará : ALVARÁ ATIVO ";
    }
    
    $sql2 = " select q07_inscr, 
                     q07_perman, 
                     min(q07_datain) as q07_datain, 
                     max(q07_datafi) as q07_datafi 
                from tabativ 
               where q07_inscr = {$inscr} 
                             and q07_perman = false 
           group by  q07_inscr, q07_perman ";
    //die($sql2);
    $result2 = pg_query($sql2);
    
    if (pg_num_rows($result2) > 0) {
      db_fieldsmemory($result2, 0);
    }    

    if (pg_num_rows($result2) > 0) {
      $dadosalvaráprovisório = "Alvará Provisório Válido entre : (".db_formatar($q07_datain,'d')." e ".db_formatar($q07_datafi,'d').")";
    } 
					
	}
}
//****************************************    P D F   ******************************************************// 

$sqlDbconfig = "select * from db_config where codigo = ".db_getsession('DB_instit');
$rsDbconfig = pg_query($sqlDbconfig);
db_fieldsmemory($rsDbconfig, 0);

if (isset ($cadrecibo) && $cadrecibo == 't') {
	$pdf = new scpdf(); // abre a classe
} else {
	$pdf = new PDF1(); // abre a classe
}
$sqlparag = "select db02_texto
			   from db_documento
			    	inner join db_docparag on db03_docum = db04_docum
        			inner join db_tipodoc on db08_codigo  = db03_tipodoc
		     		inner join db_paragrafo on db04_idparag = db02_idparag
			 where db03_tipodoc = 1017 and db03_instit = " . db_getsession("DB_instit")." order by db04_ordem ";
			 
$resparag = pg_query($sqlparag);

if ( pg_numrows($resparag) == 0 ) {
	// $head1 = 'Departamento de Fazenda';
     //agu$head1 = 'SECRETARIA DE FINANÇAS';
}else{
     db_fieldsmemory( $resparag, 0 );
     $head1 = $db02_texto;
}
$pdf->Open(); // abre o relatorio
$pdf->AliasNbPages(); // gera alias para as paginas
$pdf->AddPage(); // adiciona uma pagina
$pdf->SetAutoPageBreak('on', 0);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(255);
if (isset ($cadrecibo) && $cadrecibo == 't') {
	$pdf->settopmargin(1);
	$pdf->SetFont('Arial', 'B', 12);
	$pdf->Image('imagens/files/Brasao.png', 20, 10, 15);	
	$pdf->sety(15);
	$pdf->setfont('Arial', 'B', 18);
	$pdf->Multicell(0, 8, $nomeinst, 0, "C", 0); // prefeitura
}
$y = $pdf->gety();
$pdf->sety($y);
//die($cldb_docparag->sql_query("","","db_docparag.*,db02_texto,db02_descr,db02_espaca,db02_alinha,db02_inicia","db04_ordem"," db03_tipodoc = $codtipodoc "));
$result = $cldb_docparag->sql_record($cldb_docparag->sql_query("","","db_docparag.*,db02_texto,db02_descr,db02_espaca,db02_alinha,db02_inicia","db04_ordem"," db03_tipodoc = $codtipodoc "));
$numrows = $cldb_docparag->numrows;   
if ($numrows==0){
	db_redireciona("db_erros.php?fechar=true&db_erro=Documento não configurado.");
	exit;
}
$logofundo = substr($logo,0,strpos($logo,"."));
/*   F U N D O   D O   D O C U M E N T O  */        
if (file_exists('imagens/files/Brasaocnd.jpg')){
	$pdf->Image('imagens/files/Brasaocnd.jpg',60,80,100);
}
$nome="";
$result_usu=$cldb_usuarios->sql_record($cldb_usuarios->sql_query(db_getsession("DB_id_usuario"),"nome"));
if ($cldb_usuarios->numrows>0){
	db_fieldsmemory($result_usu,0);
}
  $data= date("Y-m-d",db_getsession("DB_datausu")); 	
  $data=split('-',$data);
  $dia=$data[2];
  $mes=$data[1];
  $ano=$data[0];
  $mes=db_mes($mes);
  $data=" $dia de $mes de $ano ";
  
  $nome="";
  
$numer = "";
if ($k03_tipocodcert != 0) {
	$numer = " Nº $codimpresso ";
}
//$numer = " ".$clcertidao->p50_sequencial;
$pdf->SetFont('Arial','b',15);
$pdf->cell(0,10,$tipocer.$numer,0,1,"C",0);
$pdf->ln();
$pdf->ln();
for($i=0; $i<$numrows; $i++){
   db_fieldsmemory($result,$i);
   if ($db02_descr=='CODIGO PHP'){
   	   eval($db02_texto);
   }else{
	   $pdf->SetFont('Arial','',12);
	   $pdf->SetX($db02_alinha);   
	   $texto=db_geratexto($db02_texto);
	   $pdf->SetFont('Arial','',12);
	   $pdf->cell(15,6,"",0,0,"R",0);
	   $pdf->MultiCell("0",4+$db02_espaca,$texto,"0","J",0,$db02_inicia+0);
	   $pdf->cell(0,6,"",0,1,"R",0);
	   
   }
}
$pdf->SetX(@ $x +80);
$y = $pdf->GetY();
$x = $pdf->GetX();
$pdf->SetXY($x +80, $y +10);

//****************************************   	FIM PDF   ******************************************************//

/************************************   R O D A P E (recibo)   D A   C N D  *******************************************************/
if (isset ($cadrecibo) && $cadrecibo == 't') {
	$y = $pdf->w - 20;
} else {
	$y = $pdf->GetY() - 20;
}
//  $mostrarecibo => parametro q define se mostra ou naun mostra o recibo no rodape da cnd...
//	$cadrecibo = 't';
if (isset ($cadrecibo) && $cadrecibo == 't') {
	$dtimp = date("Y-m-d", db_getsession('DB_datausu'));
	$y = $pdf->w - 28;
	$x = $pdf->GetX();
	$pdf->SetXY($x, $y +3);
	$pdf->RoundedRect(5, $y +36, 80, 28, '', '1234');
	$pdf->Ln(17);
	$TamLetra = 7;
	$alt = 4;
	$b = 0;
	$rsRecibo = pg_query("select * from recibo inner join tabrec on k00_receit = k02_codigo where k00_numpre = $k03_numpre");
	$intNumrows = pg_numrows($rsRecibo);
	if ($intNumrows == 0) {
		db_redireciona('db_erros.php?fechar=true&db_erro=Recibo não cadastrado');
	}
	$valortotal = 0;
	for ($ii = 0; $ii < $intNumrows; $ii ++) {
		db_fieldsmemory($rsRecibo, $ii);
		if ($ii == 0) {
			$taxa1 = $k02_drecei;
			$valor1 = $k00_valor;
		}
		if ($ii == 1) {
			$taxa2 = $k02_drecei;
			$valor2 = $k00_valor;
		}
		if ($ii == 2) {
			$taxa3 = $k02_drecei;
			$valor3 = $k00_valor;
		}
		$valortotal += $k00_valor;
	}
	
	//*******************************************************************************************************************//		

	$y = $pdf->GetY();
	$x = $pdf->GetX();
	$pdf->SetXY($x, $y +18);
	$pdf->SetFont('Arial', 'B', $TamLetra -2);
	$pdf->cell(20, 3, "$titulo", $b, 0, "L", 0); //cgm matricula ou inscricao
	$pdf->cell(20, 3, "Dt impr.", $b, 0, "L", 0);
	$pdf->cell(20, 3, "Dt Venc", $b, 0, "L", 0);
	$pdf->cell(20, 3, "", $b, 1, "L", 0);

	$pdf->SetFont('Arial', 'B', $TamLetra);
	$pdf->SetFont('Arial', '', $TamLetra);

	$pdf->SetFont('Arial', '', $TamLetra);
	$pdf->cell(20, $alt, "$origem", $b, 0, "L", 0); //cgm matricula ou inscricao
	$pdf->cell(20, $alt, db_formatar($dtimp, "d"), $b, 0, "L", 0);
	$pdf->cell(20, $alt, db_formatar($k00_dtvenc, "d"), $b, 0, "L", 0);

	$pdf->SetFont('Arial', 'B', $TamLetra);
	$pdf->cell(20, $alt, "Valor", $b, 0, "C", 0);
	$pdf->SetFont('Arial', 'B', $TamLetra +1);
	$pdf->cell(110, $alt, "DOCUMENTO VÁLIDO SOMENTE APOS AUTENTICAÇÃO MECANICA ", $b, 1, "C", 0);

	$pdf->SetFont('Arial', 'B', $TamLetra);
	$pdf->SetFont('Arial', '', $TamLetra -1);

	if (isset ($taxa1) && $taxa1 != "") {
		$pdf->cell(60, $alt, "$taxa1", "B", 0, "L", 0);
		$pdf->cell(20, $alt, "$valor1", $b, 0, "C", 0);
		$pdf->SetFont('Arial', 'B', $TamLetra +1);
		$pdf->cell(110, $alt, "OU COMPROVANTE DE QUITAÇÃO", $b, 1, "C", 0);
	} else {
		$pdf->cell(60, $alt, "", $b, 0, "L", 0);
		$pdf->cell(20, $alt, "", $b, 0, "C", 0);
		$pdf->cell(110, $alt, "", $b, 1, "C", 0);
	}

	$pdf->SetFont('Arial', '', $TamLetra -1);

	if (isset ($taxa2) && $taxa2 != "") {
		$pdf->cell(60, $alt, "$taxa2", "B", 0, "L", 0);
		$pdf->cell(20, $alt, "$valor2", $b, 0, "C", 0);
	} else {
		$pdf->cell(60, $alt, "", $b, 0, "L", 0);
		$pdf->cell(20, $alt, "", $b, 0, "C", 0);
	}

	$pdf->SetFont('Arial', 'B', $TamLetra +1);
	$pdf->cell(110, $alt, " A U T E N T I C A Ç Ã O   M E C Â N I C A ", $b, 1, "C", 0);

	$pdf->SetFont('Arial', '', $TamLetra -1);
	if (isset ($taxa3) && $taxa3 != "") {
		$pdf->cell(60, $alt, "$taxa3", "B", 0, "L", 0);
		$pdf->cell(20, $alt, "$valor3", $b, 1, "C", 0);
	} else {
		$pdf->cell(60, $alt, "", $b, 0, "L", 0);
		$pdf->cell(20, $alt, "", $b, 1, "C", 0);
	}

	$pdf->SetFont('Arial', 'B', $TamLetra -1);
	$pdf->cell(60, $alt, "Valor Total : ", $b, 0, "R", 0);
	$pdf->cell(20, $alt, "$valortotal", $b, 1, "C", 0);

	$y = $pdf->GetY();
	$x = $pdf->GetX();
	$pdf->SetXY($x, $y +10);

	/******************************************************************************************************************************************/

	$pdf->RoundedRect(5, $y +9, 200, 41, 0, '', '1234');

	$pdf->SetFont('Arial', 'B', $TamLetra -2);
	$pdf->cell(110, 3, "", $b, 0, "L", 0);
	$pdf->cell(20, 3, "$titulo", $b, 0, "L", 0); //cgm matricula ou inscricao
	$pdf->cell(20, 3, "Dt impr.", $b, 0, "L", 0);
	$pdf->cell(20, 3, "Dt Venc", $b, 0, "L", 0);
	$pdf->cell(20, 3, "", $b, 1, "L", 0);

	$pdf->SetFont('Arial', 'B', $TamLetra);
	$pdf->cell(40, $alt, "CONTRIBUINTE: ", $b, 0, "L", 0);
	$pdf->SetFont('Arial', '', $TamLetra);
	$pdf->cell(70, $alt, @ $z01_nome, $b, 0, "L", 0);

	$pdf->SetFont('Arial', '', $TamLetra);
	$pdf->cell(20, $alt, "$origem", $b, 0, "L", 0); //cgm matricula ou inscricao
	$pdf->cell(20, $alt, db_formatar($dtimp, "d"), $b, 0, "L", 0);
	$pdf->cell(20, $alt, db_formatar($k00_dtvenc, "d"), $b, 0, "L", 0);

	$pdf->SetFont('Arial', 'B', $TamLetra);
	$pdf->cell(20, $alt, "Valor", $b, 1, "C", 0);

	$pdf->SetFont('Arial', 'B', $TamLetra);
	$pdf->cell(40, $alt, "ENDEREÇO: ", $b, 0, "L", 0);
	$pdf->SetFont('Arial', '', $TamLetra);
	$pdf->cell(70, $alt, trim(@ $z01_ender).", ".trim(@ $z01_numero)."  ".trim(@ $z01_compl), $b, 0, "L", 0);

	$pdf->SetFont('Arial', '', $TamLetra -1);
	if (isset ($taxa1) && $taxa1 != "") {
		$pdf->cell(60, $alt, "$taxa1", "B", 0, "L", 0);
		$pdf->cell(20, $alt, "$valor1", $b, 1, "C", 0);
	} else {
		$pdf->cell(60, $alt, "", $b, 0, "L", 0);
		$pdf->cell(20, $alt, "", $b, 1, "C", 0);
	}

	$pdf->SetFont('Arial', 'B', $TamLetra);
	$pdf->cell(40, $alt, "MUNICIPIO:", $b, 0, "L", 0);
	$pdf->SetFont('Arial', '', $TamLetra);
	$pdf->cell(70, $alt, @ $z01_munic."/".@ $z01_uf." - ".substr(@ $z01_cep, 0, 5)."-".substr(@ $z01_cep, $alt, 3), $b, 0, "L", 0);

	$pdf->SetFont('Arial', '', $TamLetra -1);
	if (isset ($taxa2) && $taxa2 != "") {
		$pdf->cell(60, $alt, "$taxa2", "B", 0, "L", 0);
		$pdf->cell(20, $alt, "$valor2", $b, 1, "C", 0);
	} else {
		$pdf->cell(60, $alt, "", $b, 0, "L", 0);
		$pdf->cell(20, $alt, "", $b, 1, "C", 0);
	}

	$pdf->cell(40, $alt, "", $b, 0, "L", 0);
	$pdf->cell(70, $alt, "", $b, 0, "L", 0);

	$pdf->SetFont('Arial', '', $TamLetra -1);
	if (isset ($taxa3) && $taxa3 != "") {
		$pdf->cell(60, $alt, "$taxa3", "B", 0, "L", 0);
		$pdf->cell(20, $alt, "$valor3", $b, 1, "C", 0);
	} else {
		$pdf->cell(60, $alt, "", $b, 0, "L", 0);
		$pdf->cell(20, $alt, "", $b, 1, "C", 0);
	}

	$pdf->cell(40, $alt, "", $b, 0, "L", 0);
	$pdf->cell(70, $alt, "", $b, 0, "L", 0);
	$pdf->SetFont('Arial', 'B', $TamLetra);
	$pdf->cell(60, $alt, "Valor Total : ", $b, 0, "R", 0);
	$pdf->cell(20, $alt, "$valortotal", $b, 1, "C", 0);

	$pdf->SetFont('Arial', '', $TamLetra +1);
	$pdf->cell(110, $alt, "$linhadigitavel", $b, 0, "C", 0);
	$pdf->SetFont('Arial', 'B', $TamLetra);
	$pdf->cell(80, $alt, "", 0, 1, "C", 0);

	$pdf->cell(40, $alt, "", $b, 0, "L", 0);
	$pdf->cell(70, $alt, "", $b, 0, "L", 0);
	$pdf->SetFont('Arial', 'B', $TamLetra);
	$pdf->cell(80, $alt, " A U T E N T I C A Ç Ã O   M E C Â N I C A  ", 0, 1, "C", 0);

	$y = $pdf->GetY();
	$x = $pdf->GetX();
	$pdf->SetXY($x, $y);

	$pdf->SetFillColor(000);
	$pdf->int25($x, $y -4, $codigobarras, 13, 0.341);

}

	$pdf->Sety(150);
	$pdf->Sety(252);
	$y = $pdf->GetY();
	$pdf->MultiCell(90, 5, '', 0, "C", 0);
	$pdf->SetFillColor(000);
	$pdf->MultiCell(180, 3, "Código de Autenticidade da Certidão", 0, "R", 0);
	$pdf->MultiCell(180, 15, $t1, 0, "R", 0);
	$pdf->int25(95, 270, $t1, 15, 0.341);
	
//$arqpdf = $pdf->GeraArquivoTemp(); 
$nomearq = $pdf->GeraArquivoTemp(); 
$arqpdf =  $nomearq;
//echo "bbbbbbbbb $arqpdf";
$pdf->Output($arqpdf, false, true);

// Para ler conteudo do arquivo pdf gerado
//$arquivograva = fopen($arqpdf, "rb");
//$dados = fread($arquivograva, filesize($arqpdf));
//fclose($arquivograva);

// Depois de Carregar o conteudo do arquivo
//header('Accept-Ranges: bytes');
//header('Keep-Alive: timeout=15, max=100');
//header('Content-type: Application/x-pdf');
//header('Content-Disposition: attachment; filename="'.$nomearq.'"');
//echo $dados;

if ($sqlerro == false) {
 // echo "xxxxxxxxxxxxxxxxxxxxx";
		db_inicio_transacao();
		$localrecebeanexo = $arqpdf;
		// Para ler conteudo do arquivo pdf gerado
		if ($sqlerro == false && trim($localrecebeanexo) != "") {
			$arquivograva = fopen($localrecebeanexo, "rb");
			if ($arquivograva == false) {
				//echo "erro aruivograva";
				///exit;
			}
			$dados = fread($arquivograva, filesize($localrecebeanexo));
			
			if ($dados == false) {
				//echo "erro fread";
				//exit;
			}
			fclose($arquivograva);
			$oidgrava = pg_lo_create();
			if ($oidgrava == false) {
				// echo "erro pg_lo_create";
				//exit;
			}
			
			if (isset ($titulo) && $titulo == 'CGM') {
				$sqlcgm="select z01_nome from cgm where z01_numcgm = $origem";
			}elseif(isset ($titulo) && $titulo == 'INSCRICAO') {
				$sqlcgm="select z01_nome from cgm inner join issbase on q02_numcgm= z01_numcgm where q02_inscr = $origem";	
			}elseif(isset ($titulo) && $titulo == 'MATRICULA') {
				$sqlcgm="select z01_nome from cgm inner join iptubase on j01_numcgm = z01_numcgm where j01_matric = $origem";	
			}
			$resultcgm= pg_query($sqlcgm);
			$linhascgm=pg_num_rows($resultcgm);
			if ($linhascgm>0){
				db_fieldsmemory($resultcgm, 0);
			}
			
			$clcertidaoweb->codcert = $clcertidao->p50_sequencial;
			$clcertidaoweb->tipocer = $tipo;
			$clcertidaoweb->cerdtemite = $ano . "-" . $mes1 . "-" . $dia;
			$clcertidaoweb->cerhora = $hora . ":" . $min . ":" . $sec;
			$clcertidaoweb->cerdtvenc = $venc;
			$clcertidaoweb->cerip = $ip;
			$clcertidaoweb->ceracesso = $t1;
			$clcertidaoweb->cercertidao = $oidgrava;
			$clcertidaoweb->cernomecontr = $z01_nome;
			$clcertidaoweb->cerhtml = "x";
			$clcertidaoweb->cerweb = true;
			$clcertidaoweb->incluir();
			$erro_msg = $clcertidaoweb->erro_msg;
			if ($clcertidaoweb->erro_status == 0) {
				$sqlerro = true;
				db_msgbox("Erro ao gerar certidao! Contate suporte!");
				exit;
			}
			
				
			$objeto = pg_lo_open($conn, $oidgrava, "w");
			if ($objeto != false) {
				$erro = pg_lo_write($objeto, $dados);
				if ($erro == false) {
					//echo "erro pg_lo_write";
					//exit;
				}
				pg_lo_close($objeto);
			} else {
				$erro_msg ("Operação Cancelada!!");
				$sqlerro = true;
		}
		}
		
		db_fim_transacao($sqlerro);

	}
//echo "arq = $arqpdf  ;
echo "<script>location.href='".$arqpdf."'</script>";
/*
// echo "<br>depoissssssssss $nomearq";
// Depois de Carregar o conteudo do arquivo
header('Accept-Ranges: bytes');
header('Keep-Alive: timeout=15, max=100');
header('Content-type: Application/x-pdf');
header('Content-Disposition: attachment; filename="'.$nomearq.'"');
//die("kakakak");
echo $dados;
*/
?>
