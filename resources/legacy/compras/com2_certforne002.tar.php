<?
include ("libs/db_sql.php");
include ("fpdf151/pdf1.php");
include ("classes/db_pcfornecertif_classe.php");
include ("classes/db_pctipodoccertif_classe.php");
include ("classes/db_pcfornecertifdoc_classe.php");
include ("classes/db_pcfornesubgrupo_classe.php");
include ("classes/db_db_config_classe.php");
include ("classes/db_liccomissaocgm_classe.php");
include ("classes/db_pctipocertifcom_classe.php");
include ("classes/db_pcparam_classe.php");

$clpcfornecertif    = new cl_pcfornecertif;
$clpctipodoccertif  = new cl_pctipodoccertif;
$clpcfornecertifdoc = new cl_pcfornecertifdoc;
$clpcfornesubgrupo  = new cl_pcfornesubgrupo;
$cldb_config        = new cl_db_config;
$clliccomissaocgm   = new cl_liccomissaocgm;
$clpctipocertifcom  = new cl_pctipocertifcom;
$clpcparam          = new cl_pcparam;

$clrotulo = new rotulocampo;
$clrotulo->label('');
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_SERVER_VARS);
//-------------------------------------------------------------------------------------------
$where=" 1=1 ";
if (isset($forne)&&$forne!=""){
	$where .= " and pc74_pcforne=$forne ";
}
if (isset($codigo)&&$codigo!=""){
	$where .= " and pc74_codigo=$codigo ";
}
//die("dfahsdf hlasdhf");
$result=$clpcfornecertif->sql_record($clpcfornecertif->sql_query(null,"*",null,$where));
if ($clpcfornecertif->numrows>0){
	db_fieldsmemory($result,0);	
}else{
	db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado.');
	exit;
}

$res_param = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"),"pc30_comobs"));
if ($clpcparam->numrows > 0){
     db_fieldsmemory($res_param,0); 
}

//-------------------------------------------------------------------------------------------
$alt = 5;
$pdf = new PDF1();
$pdf->Open();
$pdf->AliasNbPages(); 
$pdf->Addpage();
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(220);
$pdf->SetXY('10', '60');

$pdf->SetFont('Arial', 'b', 14);
$pdf->cell(0, 5, "CERTIFICADO DE REGISTRO CADASTRAL N° $pc74_codigo", 0, 1, "C", 0);
$pdf->cell(0, 5, "", 0, 1, "R", 0);

if (@$pc70_obs!=""){
     $pdf->setfont('arial', 'b', 8);
     $pdf->multicell(0,$alt,trim($pc70_obs),0, "J", 0);
     $pdf->ln();
}

$pdf->setfont('arial', 'b', 8);
$pdf->cell(30, $alt, 'Fornecedor :', 1, 0, "R", 0);
$pdf->setfont('arial', '', 7);
$pdf->cell(150, $alt, $pc60_numcgm."-", 1, 0, "L", 0);
$pdf->setx(48);
$pdf->setfont('arial', 'b', 10);
$pdf->cell(50, $alt, $z01_nome, 0, 1, "L", 0);

$pdf->setfont('arial', 'b', 8);
$pdf->cell(30, $alt, 'Endereço', 1, 0, "R", 0);
$pdf->setfont('arial', '', 7);
$pdf->cell(60, $alt,$z01_ender.", ".$z01_numero."/".$z01_compl, 1, 0, "L", 0);
$pdf->setfont('arial', 'b', 8);
$pdf->cell(30, $alt, 'Bairro :', 1, 0, "R", 0);
$pdf->setfont('arial', '', 7);
$pdf->cell(60, $alt, $z01_bairro, 1, 1, "L", 0);

$pdf->setfont('arial', 'b', 8);
$pdf->cell(30, $alt, 'Cidade :', 1, 0, "R", 0);
$pdf->setfont('arial', '', 7);
$pdf->cell(60, $alt, $z01_munic, 1, 0, "L", 0);
$pdf->setfont('arial', 'b', 8);
$pdf->cell(30, $alt, 'Estado :', 1, 0, "R", 0);
$pdf->setfont('arial', '', 7);
$pdf->cell(60, $alt, $z01_uf, 1, 1, "L", 0);

$pdf->setfont('arial', 'b', 8);
$pdf->cell(30, $alt, 'Cep :', 1, 0, "R", 0);
$pdf->setfont('arial', '', 7);
$pdf->cell(60, $alt, $z01_cep, 1, 0, "L", 0);
$pdf->setfont('arial', 'b', 8);
$pdf->cell(30, $alt, 'CNPJ :', 1, 0, "R", 0);
$pdf->setfont('arial', '', 7);
$pdf->cell(60, $alt,$z01_cgccpf, 1, 1, "L", 0);

//$pdf->cell(1, 5,"", 0, 1, "L", 0);
$pdf->ln();

if ($pc60_obs!=""){
  $pdf->setfont('arial', 'b', 10);
  $pdf->cell(0, 8, 'OBJETO SOCIAL DA EMPRESA :', 0, 0, "L", 0);
  $pdf->cell(0, 8, "", 0, 1, "R", 0);
  $pdf->setfont('arial', 'b', 8);
  $pdf->multicell(180,$alt,@$pc60_obs,1, "L", 0);
  $pdf->ln();
}

//-------------------------------------------------------------------------------------------
$result_doc=$clpctipodoccertif->sql_record($clpctipodoccertif->sql_query(null,"*",null,"pc72_pctipocertif=$pc74_pctipocertif"));
//-------------------------------------------------------------------------------------------

if ($pc30_comobs == "t"){
     $br = 0;
} else {
     $br = 1;
}

$pdf->setfont('arial', 'b', 8);
$pdf->cell(100, $alt, "DESCRIÇÃO DOS DOCUMENTOS", 1, 0, "C", 0);
$pdf->cell(30,  $alt, "VALIDADE", 1, $br, "C", 0);

if ($pc30_comobs == "t"){
     $pdf->cell(60, $alt, "OBSERVAÇÃO", 1, 1, "C", 0);
}     

$pdf->setfont('arial', '', 7);
for($w=0;$w<$clpctipodoccertif->numrows;$w++){
	db_fieldsmemory($result_doc,$w);
	$pdf->cell(100, $alt, $pc72_pcdoccertif."-".$pc71_descr, 1, 0, "L", 0);
	$result_df=$clpcfornecertifdoc->sql_record($clpcfornecertifdoc->sql_query_file(null,"*",null,"pc75_pcfornecertif=$pc74_codigo and pc75_pcdoccertif=$pc72_pcdoccertif"));
	if ($clpcfornecertifdoc->numrows>0){
		db_fieldsmemory($result_df,0);
		$validade = db_formatar($pc75_validade,'d');
	}else{
		$validade = "Não apresentado";
	}

        $pdf->cell(30, $alt,$validade, 1, $br, "C", 0);

        if ($pc30_comobs == "t"){
	     $pdf->multicell(60,$alt,$pc75_obs,1,"L",0);
        }
}
//-------------------------------------------------------------------------------------------
$result_sub=$clpcfornesubgrupo->sql_record($clpcfornesubgrupo->sql_query(null,"*",null,"pc76_pcforne=$pc60_numcgm"));
if ($clpcfornesubgrupo->numrows>0){
    $pdf->cell(1, 5,"", 0, 1, "L", 0);
    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(80, $alt,"GRUPOS DE FORNECIMENTO", 1, 1, "C", 0);
    $pdf->setfont('arial', '', 7);
    for($w=0;$w<$clpcfornesubgrupo->numrows;$w++){
	  db_fieldsmemory($result_sub,$w);
          if ($pdf->gety() > $pdf->h - 30){
               $pdf->Addpage();
               $pdf->SetXY('10', '60');
               $pdf->SetFont('Arial', 'b', 14);
               $pdf->cell(0, 5, "CERTIFICADO DE REGISTRO CADASTRAL N° $pc74_codigo", 0, 1, "C", 0);
               $pdf->cell(0, 5, "", 0, 1, "R", 0);
     
               $pdf->setfont('arial', 'b', 8);
               $pdf->cell(30, $alt, 'Fornecedor :', 1, 0, "R", 0);
               $pdf->setfont('arial', '', 7);
               $pdf->cell(150, $alt, $pc60_numcgm."-", 1, 0, "L", 0);
               $pdf->setx(48);
               $pdf->setfont('arial', 'b', 10);
               $pdf->cell(50, $alt, $z01_nome, 0, 1, "L", 0);
/*	       
               $pdf->setfont('arial', 'b', 8);
               $pdf->cell(30, $alt, 'Fornecedor :', 1, 0, "R", 0);
               $pdf->setfont('arial', '', 7);
               $pdf->cell(150, $alt, $pc60_numcgm."-".$z01_nome, 1, 1, "L", 0);
*/
               $pdf->setfont('arial', 'b', 8);
               $pdf->cell(30, $alt, 'Endereço', 1, 0, "R", 0);
               $pdf->setfont('arial', '', 7);
               $pdf->cell(60, $alt,$z01_ender.", ".$z01_numero."/".$z01_compl, 1, 0, "L", 0);
               $pdf->setfont('arial', 'b', 8);
               $pdf->cell(30, $alt, 'Bairro :', 1, 0, "R", 0);
               $pdf->setfont('arial', '', 7);
               $pdf->cell(60, $alt, $z01_bairro, 1, 1, "L", 0);

               $pdf->setfont('arial', 'b', 8);
               $pdf->cell(30, $alt, 'Cidade :', 1, 0, "R", 0);
               $pdf->setfont('arial', '', 7);
               $pdf->cell(60, $alt, $z01_munic, 1, 0, "L", 0);
               $pdf->setfont('arial', 'b', 8);
               $pdf->cell(30, $alt, 'Estado :', 1, 0, "R", 0);
               $pdf->setfont('arial', '', 7);
               $pdf->cell(60, $alt, $z01_uf, 1, 1, "L", 0);

               $pdf->setfont('arial', 'b', 8);
               $pdf->cell(30, $alt, 'Cep :', 1, 0, "R", 0);
               $pdf->setfont('arial', '', 7);
               $pdf->cell(60, $alt, $z01_cep, 1, 0, "L", 0);
               $pdf->setfont('arial', 'b', 8);
               $pdf->cell(30, $alt, 'CNPJ :', 1, 0, "R", 0);
               $pdf->setfont('arial', '', 7);
               $pdf->cell(60, $alt,$z01_cgccpf, 1, 1, "L", 0);

               $pdf->cell(1, 5,"", 0, 1, "L", 0);
               $pdf->setfont('arial', 'b', 8);
               $pdf->cell(80, $alt,"GRUPOS DE FORNECIMENTO", 1, 1, "C", 0);
               $pdf->setfont('arial', '', 7);
          }
//-------------------------------------------------------------------------------------------
	  $pdf->cell(80, $alt,$pc76_pcsubgrupo."-".$pc04_descrsubgrupo, 1, 1, "L", 0);	  
    }
}
//-------------------------------------------------------------------------------------------
$pdf->SetFont('Arial','b',12);
$pdf->ln();
if (@$pc70_parag2!=""){
  $pdf->setfont('arial', 'b', 8);
  $pdf->multicell(0,$alt,@$pc70_parag2,0, "J", 0);
}
$numrows_comissao=0;
$result_certifcom=$clpctipocertifcom->sql_record($clpctipocertifcom->sql_query(null,"*",null,"pc77_pctipocertif = $pc74_pctipocertif"));
if($clpctipocertifcom->numrows>0){
	db_fieldsmemory($result_certifcom,0);
	$result_comissao=$clliccomissaocgm->sql_record($clliccomissaocgm->sql_query(null, "z01_nome", null, "l31_liccomissao = $pc77_liccomissao"));
	$numrows_comissao=$clliccomissaocgm->numrows;
	if($clliccomissaocgm->numrows > 0){
   		db_fieldsmemory($result_comissao,0);
	}
}

$result_munic=$cldb_config->sql_record($cldb_config->sql_query_file());
if($cldb_config->numrows > 0){
     db_fieldsmemory($result_munic,0);
}

$pdf->setfont('arial', 'b', 8);
if (strtoupper($munic) == "BAGE"){
     $pdf->setfont('arial', 'b', 6);
     $pdf->ln(10);
}

$dia = date ('d',db_getsession("DB_datausu"));
$mes = date ('m',db_getsession("DB_datausu"));
$ano = date ('Y',db_getsession("DB_datausu"));
$mes = db_mes($mes);
$pdf->cell(60,4,"DATA DA INCLUSÃO DO REGISTRO: " . db_formatar($pc74_data,"d"),0,1,"L",0);
$pdf->ln(10);
$pdf->cell(175,4,"$munic, $dia de $mes de $ano. ",0,1,"R",0);
$pdf->ln(20);

$sqlparag = "select db02_descr, db02_texto
	     from db_documento
	   	  inner join db_docparag on db03_docum = db04_docum
       		  inner join db_tipodoc on db08_codigo  = db03_tipodoc
	     	  inner join db_paragrafo on db04_idparag = db02_idparag
		  where db03_tipodoc = 1201 and db03_instit = " . db_getsession("DB_instit")." order by db04_ordem ";
			 
$resparag = pg_query($sqlparag) or die($sqlparag);

$assinatura_diretor = "";
if (pg_numrows($resparag) == 0) {
  $assinatura_diretor = "ASSINATURA";
} else {
  for($i = 0; $i < pg_numrows($resparag); $i++){
      db_fieldsmemory($resparag,$i);
      $assinatura_diretor = $db02_texto;
      $pdf->cell(200,4,$assinatura_diretor,0,1,"C",0);
      $pdf->ln(12);
  }
}

//$pdf->cell(90,4,"___________________________",0,1,"C",0);
//$pdf->cell(90,4,"",0,0,"C",0);

// Alterado conforme tarefa 1536
//if (strtoupper($munic) == "BAGE"){
//     $pdf->cell(60,4,"ADRIANA APARECIDA SABROZA KISATA",0,0,"C",0);
//     $pdf->cell(60,4,"JOCIMARA GOMES DOS SANTOS",0,0,"C",0);
//     $pdf->cell(60,4,"EDITHE MARIA FIGHERA PILON",0,1,"C",0);
//     $pdf->cell(60,4,"SECRETÁRIO(A) DA FAZENDA",0,0,"C",0);
//     $pdf->cell(60,4,"PRESIDENTE DA COMISSÃO DE CADASTRO",0,0,"C",0);
//     $pdf->cell(60,4,"SUPERVISOR(A) DEPTO. DE COMPRAS",0,1,"C",0);
//} else {
  if ($db02_descr == "CODIGO PHP") {
       eval($db02_texto);
  } else {
       if (trim($assinatura_diretor) == ""){
            $pdf->cell(200,4,$assinatura_diretor,0,1,"C",0);
            $pdf->cell(200,4,"DIRETOR(A) DEPARTAMENTO DE COMPRAS",0,1,"C",0);
            $pdf->ln(12);
       }
  }

     $conta=0;
     if ($numrows_comissao!=0){
          for ($x=0; $x < $clliccomissaocgm->numrows; $x++) {
                db_fieldsmemory($result_comissao, $x);
 
                $pdf->cell(90,4,$z01_nome,0,0,"C",0);
                if ($conta++ == 1 or $x == pg_numrows($result_comissao) - 1) {
                     $pdf->ln();
                     for ($a=0; $a < 2; $a++) {
                           $pdf->cell(90,4,"MEMBRO",0,0,"C",0);
                           if ($x == pg_numrows($result_comissao) - 1) {
                                break;
                           } 
                     }
                     $pdf->ln(12);
                     $conta=0;
                }
          }     
     }   
//}

$pdf->Output();

?>
