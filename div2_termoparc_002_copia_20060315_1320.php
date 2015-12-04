<?
include("libs/db_sql.php");
include("fpdf151/pdf1.php");
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
if ( !isset($parcel) || $parcel == '' ) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Parcelamento não encontrado!');
  exit; 
}
$exercicio = db_getsession("DB_anousu");
$borda = 1; 
$bordat = 1;
$preenc = 0;
$TPagina = 57;
$xnumpre = '';

 $sql="select termo.*,
             v03_descr,
             to_char(length(z01_cgccpf),'99') as leng,
             z01_numcgm, 
             z01_nome,
             case when trim(z01_cgccpf) = ''
	          then '000000000'
		  else z01_cgccpf
	     end as z01_cgccpf, 
             z01_ender, 
	     z01_bairro, 
	     z01_munic, 
	     z01_telef, 
             z01_compl,
	     case when trim(z01_ident) = ''
	          then '0000000000'
		  else z01_ident
	     end as z01_ident,
	     z01_email, 
	     z01_uf,
	     z01_numero,
	     case z01_estciv 
	          when 1 then 'estado civil solteiro,'
		  when 2 then 'estado civil casado,'
		  when 3 then 'estado civil viúvo,'
		  when 4 then 'estado civil divorciado,'
		  else ''
	     end as estciv, 
	     z01_cep,
         nome
      from termo
           inner join
               cgm on z01_numcgm = v07_numcgm
           left outer join termodiv 
                   on v07_parcel = parcel
           left outer join divida 
                   on coddiv = v01_coddiv
           left outer join proced
                   on v03_codigo = v01_proced
           left outer join db_usuarios
                   on db_usuarios.id_usuario = to_number(termo.v07_login,'99999')
      where v07_parcel = $parcel 
";
//pdf
$result=pg_query($sql);
if ( pg_numrows($result) == 0 ) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Parcelamento no. '.$parcel. ' não Encontrado.');
  exit; 
}
db_fieldsmemory($result,0);
$responsavel = $z01_nome;
$numprecerto = $v07_numpre;
if ($leng == '14' ) {
   $cpf = db_formatar($z01_cgccpf,'cnpj');
} else {
   $cpf = db_formatar($z01_cgccpf,'cpf');
}
$head1 = 'Departamento de Fazenda';
$pdf = new PDF1(); // abre a classe
if(!defined('DB_BIBLIOT')){
$pdf->Open(); // abre o relatorio
$pdf->AliasNbPages(); // gera alias para as paginas
}
//$pdf->SetAutoPageBreak(false);
$pdf->SetAutoPageBreak('on',10);
$pdf->AddPage(); // adiciona uma pagina
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220);
$pdf->SetFont('Arial','',11);
/////// TEXTOS E ASSINATURAS
$extenso = $pdf->db_extenso($v07_valor);
$valor = db_formatar($v07_valor,'f');
$instit = db_getsession("DB_instit");
$sqltexto = "select * from db_textos where id_instit = $instit and ( descrtexto like 'termo%' or descrtexto like 'ass%')";
$resulttexto = pg_exec($sqltexto);
for( $xx = 0;$xx < pg_numrows($resulttexto);$xx ++ ){
    db_fieldsmemory($resulttexto,$xx);
    $text  = $descrtexto;
    $$text = db_geratexto($conteudotexto);
}
////////relatorio
$numpar  = $v07_totpar;
$entrada = $v07_vlrent;
$vencent = $v07_datpri;
$vlrpar  = $v07_vlrpar;
$vencpar = $v07_dtvenc;
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell(0,4,"TERMO DE CONFISSÃO DE DÍVIDA E COMPROMISSO DE PAGAMENTO:$v07_parcel",0,"C",0,0);
$pdf->Ln(4);
$pdf->SetFont('Arial','',11);
$pdf->MultiCell(0,5,$termo_p1,0,"J",0,40);

//$sqlorigem = "select k00_numpre as v07_numpre, k00_tipo from arrecad where k00_numpre=$v07_numpre";
//$result = pg_exec($sqlorigem);

$sqlrepar = "select retermo.*, k00_matric as matric,k00_inscr as inscr 
             from retermo 
                  left outer join arrematric a on a.k00_numpre = v07_numpre
                  left outer join arreinscr  b on b.k00_numpre = v07_numpre
             where v07_parcel=$parcel order by retermo.oid limit 1";
$result = pg_exec($sqlrepar);
//echo $sqlrepar;exit;

if ( pg_numrows($result) > 0 ) {
  // se for reparcelamento ou diversos...
   if ( pg_result($result,0,'matric') > 0 ) {
      $numero = 'Matr. : '.pg_result($result,0,'matric');
   }else if ( pg_result($result,0,'inscr') > 0 ) {
      $numero = 'Inscr.: '.pg_result($result,0,'inscr');
   }else {
      $numero = 'Cgm : '.pg_result($result,0,'v07_numcgm');
   }
   $xnumpre = pg_result($result,0,'v07_numpre');
   
   $sql = "select a.*,
   		  cadtipo.k03_tipo,
                  coalesce(b.k00_matric) as matric,
                  coalesce(c.k00_inscr)  as inscr
           from arreold a
	   	inner join arretipo on a.k00_tipo = arretipo.k00_tipo
		inner join cadtipo  on arretipo.k03_tipo = cadtipo.k03_tipo
                left outer join arrematric b
                        on b.k00_numpre = a.k00_numpre
                left outer join arreinscr  c
                        on c.k00_numpre = a.k00_numpre         
           where a.k00_numpre = $xnumpre";
//   echo $sql;exit;
   $xtipo    = pg_result(pg_exec($sql),0,"k00_tipo");
   $k03_tipo = pg_result(pg_exec($sql),0,"k03_tipo");
   if ($k03_tipo == 4){
      $sql1 = "select b.*
      from arreold a
           inner join arrematric c on c.k00_numpre = a.k00_numpre
	        inner join proprietario b on b.j01_matric = c.k00_matric where
		a.k00_numpre = $xnumpre limit 1";
      $tipo = 4;
      $setorquadralote = ''; 
   }else{
      if ($k03_tipo == 7){
	 $tipo = 28;
	 $sql1 = "select z01_nome from cgm where z01_numcgm = ".pg_result(pg_exec($sql),0,'k00_numcgm');
	 $z01_nome = pg_result(pg_exec($sql1),0,"z01_nome");
      }else{
	 $tipo = 21;
	 $sql1 = "select z01_nome from cgm where z01_numcgm = ".pg_result(pg_exec($sql),0,'k00_numcgm');
	 $z01_nome = pg_result(pg_exec($sql1),0,"z01_nome");
      }
   }
}else {
   $sql  = "select termo.*,arrecad.*, arrematric.k00_matric as matric, arreinscr.k00_inscr as inscr from termo
            inner join arrecad on arrecad.k00_numpre = termo.v07_numpre 
            left outer join arrematric 
                    on arrematric.k00_numpre = arrecad.k00_numpre
            left outer join arreinscr  
                    on arreinscr.k00_numpre = arrecad.k00_numpre
            left outer join termodiv 
                    on v07_parcel = parcel
            left outer join divida 
                    on coddiv = v01_coddiv
            left outer join proced
                    on v03_codigo = v01_proced
            where v07_parcel = $parcel
            limit 1 ";
   $sql = "select arrecad.k00_tipo, k03_tipo from termo
           inner join arrecad on termo.v07_numpre = arrecad.k00_numpre
	   inner join arretipo on arrecad.k00_tipo = arretipo.k00_tipo
           where v07_parcel = $parcel
           limit 1";
   $tipo = pg_result(pg_exec($sql),0,'k00_tipo');
   $k03_tipo = pg_result(pg_exec($sql),0,'k03_tipo');
   if ($k03_tipo == 13) { // parcelamento do foro
       $sql = "select x.z01_nome as nomematric,
			x.v03_descr, 
			arreold.*, 
			k00_matric as matric, 
			k00_inscr as inscr,
			vlrdescjur,
			vlrdescmul,
			v01_exerc
		from (	select distinct	
			v03_descr,
			z01_nome,
			vlrdescjur,
			vlrdescmul,
			case when termo2.v07_numpre is not null 
				then termo2.v07_numpre 
				else divida.v01_numpre 
			end as numpre,
			case when termo2.v07_numpre is not null 
				then 0
				else divida.v01_numpar
			end as numpar,
			case when termo2.v07_numpre is not null 
				then 0
				else divida.v01_exerc
			end as v01_exerc
		from termo
			inner join termoini	on termoini.parcel = termo.v07_parcel
			inner join inicial	on inicial.v50_inicial = termoini.inicial
			inner join inicialcert	on inicialcert.v51_inicial = inicial.v50_inicial
			inner join certid	on certid.v13_certid = inicialcert.v51_certidao
			left outer join certter	on certter.v14_certid = inicialcert.v51_certidao
			left outer join certdiv	on certdiv.v14_certid = inicialcert.v51_certidao
			left outer join termo termo2 on certter.v14_parcel = termo2.v07_parcel
			left outer join divida	on divida.v01_coddiv = certdiv.v14_coddiv
			left outer join proced	on proced.v03_codigo = divida.v01_proced
			inner join cgm		on termo.v07_numcgm = z01_numcgm
		where termo.v07_parcel = $parcel) as x 
		inner join arreold 		on k00_numpre = x.numpre and (case when x.numpar > 0 then k00_numpar = x.numpar else true end)
		left outer join arrematric 	on arrematric.k00_numpre = arreold.k00_numpre
		left outer join arreinscr  	on arreinscr.k00_numpre  = arreold.k00_numpre
            ";
//	    die($sql);
   } else {
    $sql = "select x.*, arreold.k00_numpre, arreold.k00_numpar, arreold.k00_dtvenc from (
    	    select termodiv.*,
			divida.*,
			v03_descr,
			coalesce(arrematric.k00_matric,0) as matric,
			coalesce(arreinscr.k00_inscr,0) as inscr,
			coalesce(arrecontr.k00_contr,0) as contr,
			case when a.j01_numcgm is not null
				then (select z01_nome from cgm where z01_numcgm =
				a.j01_numcgm)
			end as nomematric,
			case when q02_numcgm is not null
				then (select z01_nome from cgm where z01_numcgm =
				q02_numcgm)
			end as nomeinscr,
			case when b.j01_numcgm is not null
				then (select z01_nome from cgm where z01_numcgm =
				b.j01_numcgm)
			end as nomecontr
		from termodiv 
			inner join	divida		on v01_coddiv = coddiv
              		inner join	proced		on v01_proced = v03_codigo
	      		left outer join	arrematric	on arrematric.k00_numpre = divida.v01_numpre
	      		left outer join	iptubase a	on arrematric.k00_matric = a.j01_matric
	      		left outer join	arreinscr	on arreinscr.k00_numpre  = divida.v01_numpre
	      		left outer join	issbase		on arreinscr.k00_inscr = issbase.q02_inscr
	      		left outer join	arrecontr	on arrecontr.k00_numpre  =  divida.v01_numpre
	      		left outer join	contrib		on arrecontr.k00_contr  =  contrib.d07_contri		      
	      		left outer join	iptubase b	on b.j01_matric = contrib.d07_matric
		where parcel = $parcel) as x
		inner join arreold on arreold.k00_numpre = x.numpreant";
    $sql = "select termodiv.*,
			divida.*,
			v03_descr,
			coalesce(arrematric.k00_matric,0) as matric,
			coalesce(arreinscr.k00_inscr,0) as inscr,
			coalesce(arrecontr.k00_contr,0) as contr,
			case when a.j01_numcgm is not null
				then (select z01_nome from cgm where z01_numcgm =
				a.j01_numcgm)
			end as nomematric,
			case when q02_numcgm is not null
				then (select z01_nome from cgm where z01_numcgm =
				q02_numcgm)
			end as nomeinscr,
			case when b.j01_numcgm is not null
				then (select z01_nome from cgm where z01_numcgm =
				b.j01_numcgm)
			end as nomecontr
		from termodiv 
			inner join	divida		on v01_coddiv = coddiv
              		inner join	proced		on v01_proced = v03_codigo
	      		left outer join	arrematric	on arrematric.k00_numpre = divida.v01_numpre
	      		left outer join	iptubase a	on arrematric.k00_matric = a.j01_matric
	      		left outer join	arreinscr	on arreinscr.k00_numpre  =  divida.v01_numpre
	      		left outer join	issbase		on arreinscr.k00_inscr = issbase.q02_inscr
	      		left outer join	arrecontr	on arrecontr.k00_numpre  =  divida.v01_numpre
	      		left outer join	contrib		on arrecontr.k00_contr  =  contrib.d07_contri
	      		left outer join	iptubase b	on b.j01_matric = contrib.d07_matric
		where parcel = $parcel";
//		echo $sql;exit;
      $tipo = 0;
      if ( pg_result(pg_exec($sql),0,'matric') > 0 ) {
	 $numero = 'Matr. : '.pg_result(pg_exec($sql),0,'matric');
      }elseif ( pg_result(pg_exec($sql),0,'inscr') > 0 ) {
	 $numero = 'Inscr. : '.pg_result(pg_exec($sql),0,'inscr');
      }else {
//	 $numero = 'Cgm : '.pg_result(pg_exec($sql),0,'v07_numcgm');
	 $numero = 'Cgm : '.pg_result(pg_exec($sql),0,'v01_numcgm');
      }
  } 
}
//echo $sql;exit;
$result = pg_exec($sql);
db_fieldsmemory($result,0);

if ( isset($numprecerto) ) {
   $sqlnomedeb = "select k00_numcgm,z01_nome,z01_cgccpf,to_char(length(z01_cgccpf),'99') as leng 
                  from arrecad 
                       inner join cgm on k00_numcgm = z01_numcgm
                  where k00_numpre = $numprecerto
                  limit 1
                 ";
}else{
   $sqlnomedeb = "select k00_numcgm,z01_nome,z01_cgccpf,to_char(length(z01_cgccpf),'99') as leng 
                  from arreold 
                       inner join cgm on k00_numcgm = z01_numcgm
                  where k00_numpre = $xnumpre
                  limit 1
                 ";
}
if ($matric > 0 ){
   $sqlnomedeb = "select z01_nome,z01_cgccpf,to_char(length(z01_cgccpf),'99') as leng from proprietario where j01_matric = $matric";
}elseif ( $inscr > 0 ){
   $sqlnomedeb = "select z01_nome,z01_cgccpf,to_char(length(z01_cgccpf),'99') as leng from issbase inner join cgm on q02_numcgm = z01_numcgm where q02_inscr = $inscr";
}
$resultnomedeb = pg_exec($sqlnomedeb);
if ( pg_numrows($resultnomedeb) == 0 ) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Numpre não encontrado.');
  exit;
}

if ( pg_numrows($result) == 0 ) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Parcelamento no. '.$parcel. ' não Encontrado na Dívida.');
  exit;
}
if (pg_result($resultnomedeb,0,"leng") == '14' ) {
     $xcpf = db_formatar(pg_result($resultnomedeb,0,"z01_cgccpf"),'cnpj');
} else {
     $xcpf = db_formatar(pg_result($resultnomedeb,0,"z01_cgccpf"),'cpf');
}
if ( $tipo == 21 ){
   $nomedeb = 'Reparcelamento de Dívida Ativa em débitos de '.trim(pg_result($resultnomedeb,0,"z01_nome")).' CPF/CNPJ '.$xcpf;
   $exerc = "PARCELA";
}else if ( $tipo == 4 ){
   $nomedeb = 'Contribuição de Melhorias em débitos de '.trim(pg_result($resultnomedeb,0,"z01_nome")).' CPF/CNPJ '.$xcpf;
   $exerc = "PARCELA";
}else if ( $tipo == 28 ){
//   $nomedeb = 'Parcelamento de diversos em débitos de '.pg_result(pg_exec($sql1),0,"proprietario");
//   $nomedeb = 'Parcelamento de diversos em débitos de '.pg_result(pg_exec($sql1),0,"proprietario");
   $nomedeb = 'Parcelamento de diversos em débitos de '.trim(pg_result($resultnomedeb,0,"z01_nome")).' CPF/CNPJ '.$xcpf;
   $exerc = "PARCELA";
}else {
   if ( $tipo == 30 ) {
      if ( pg_result($result,0,"matric") > 0 ) {
	 $nomedeb = 'Parcelamento do Foro em débitos de '.trim(pg_result($resultnomedeb,0,"z01_nome")).' CPF/CNPJ '.$xcpf;
      } else if ( pg_result($result,0,"inscr") > 0 ) {
	 $nomedeb = 'Parcelamento do Foro em débitos de '.trim(pg_result($resultnomedeb,0,"z01_nome")).' CPF/CNPJ '.$xcpf;
      } else {
	 $nomedeb =  'Parcelamento do Foro em débitos de '.trim(pg_result($resultnomedeb,0,"z01_nome")).' CPF/CNPJ '.$xcpf;
      }
   } else {
      if ( pg_result($result,0,"matric") > 0 ) {
	 $nomedeb = ' '.trim(pg_result($resultnomedeb,0,"z01_nome")).' CPF/CNPJ '.$xcpf;
      } else if ( pg_result($result,0,"inscr") > 0 ) {
	 $nomedeb = 'Dívida Ativa em débitos de '.trim(pg_result($resultnomedeb,0,"z01_nome")).' CPF/CNPJ '.$xcpf;
      } else if ( pg_result($result,0,"contr") > 0 ) {
	 $nomedeb =  'Contribuição de Melhorias em débitos de '.trim(pg_result($resultnomedeb,0,"z01_nome")).' CPF/CNPJ '.$xcpf;
      } else {
	 $nomedeb =  'debitos por nome em débitos de '.trim(pg_result($resultnomedeb,0,"z01_nome")).' CPF/CNPJ '.$xcpf;
      }
   }
   $exerc = "EXERC";
}
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell(0,8,$nomedeb,0,1,0,0);
$num = pg_numrows($result);
$linha = 20;
//$pdf->Ln(4);
$Tv01_vlrhis = 0;
$Tv01_valor  = 0;
$Tmulta      = 0;
$Tjuros      = 0;
$Tdesconto   = 0;
$Tv01_valor  = 0;
$Total       = 0;
$pdf->SetFont('Arial','B',7);
$pdf->Cell(15,4,'MAT/INSC',1,0,"C",1);
$pdf->Cell(15,4,$exerc,1,0,"C",1);
$pdf->Cell(15,4,"VENC.",1,0,"C",1);
$pdf->Cell(30,4,"PROCEDÊNCIA",1,0,"C",1);
$pdf->Cell(18,4,"HISTÓRICO",1,0,"C",1);
$pdf->Cell(18,4,"CORRIGIDO",1,0,"C",1);
$pdf->Cell(18,4,"MULTA",1,0,"C",1);
$pdf->Cell(18,4,"JUROS",1,0,"C",1);
$pdf->Cell(18,4,"DESCONTO",1,0,"C",1);
$pdf->Cell(20,4,"TOTAL",1,1,"C",1);

$np = 0;
$npa = 0;


$totalzaojur=0;
$totalzaomul=0;

for($i=0;$i<$num;$i++) {

   if ( $xnumpre > 0 || $tipo == 30 ) {
     db_fieldsmemory($result,$i);
     $dtlanc = mktime(0,0,0,substr($v07_dtlanc,5,2),substr($v07_dtlanc,8,2),substr($v07_dtlanc,0,4));
     $debitos = debitos_numpre_old($k00_numpre,0,$k00_tipo,$dtlanc,substr($v07_dtlanc,0,4),$k00_numpar,'','');

     db_fieldsmemory($debitos,0);
     $multa      = $vlrmulta;
     $juros      = $vlrjuros;

     if($np==$k00_numpre && $npa==$k00_numpar)
       continue;
     else{
       $np=$k00_numpre;
       $npa=$k00_numpar;
     }

   } else {
      db_fieldsmemory($result,$i);
   }

   $totalzaojur += $juros;
   $totalzaomul += $multa;
   
}

//die("x: $totalzao");

for($i=0;$i<$num;$i++) {
   if($pdf->GetY() > ( $pdf->h - 30 )){
      $linha = 0;
      $pdf->AddPage();
      $pdf->SetFont('Arial','B',7);
      $pdf->Cell(15,4,'MAT/INSC',1,0,"C",1);
      $pdf->Cell(15,4,$exerc,1,0,"C",1);
      $pdf->Cell(15,4,"VENC.",1,0,"C",1);
      $pdf->Cell(30,4,"PROCEDÊNCIA",1,0,"C",1);
      $pdf->Cell(18,4,"HISTÓRICO",1,0,"C",1);
      $pdf->Cell(18,4,"CORRIGIDO",1,0,"C",1);
      $pdf->Cell(18,4,"MULTA",1,0,"C",1);
      $pdf->Cell(18,4,"JUROS",1,0,"C",1);
      $pdf->Cell(18,4,"DESCONTO",1,0,"C",1);
      $pdf->Cell(20,4,"TOTAL",1,1,"C",1);
   }

   if ( $xnumpre > 0 || $tipo == 30 ) {
     db_fieldsmemory($result,$i);
     $dtlanc = mktime(0,0,0,substr($v07_dtlanc,5,2),substr($v07_dtlanc,8,2),substr($v07_dtlanc,0,4));
     $debitos = debitos_numpre_old($k00_numpre,0,$k00_tipo,$dtlanc,substr($v07_dtlanc,0,4),$k00_numpar,'','');

     db_fieldsmemory($debitos,0);
//     $v01_exerc  = substr($k00_dtoper,0,4);
     $v01_vlrhis = $vlrhis;
     $v01_dtvenc = $k00_dtvenc;
     $valor      = $vlrhis;
     $multa      = $vlrmulta;
     $juros      = $vlrjuros;
     $desconto   = $vlrdesconto;

     if($np==$k00_numpre && $npa==$k00_numpar)
       continue;
     else{
       $np=$k00_numpre;
       $npa=$k00_numpar;
     }

   } else {
      db_fieldsmemory($result,$i);
   }
   if ( @$matric > 0 ){
      $xnumero = 'M-'.$matric;
   }else if (@$inscr > 0){
      $xnumero = 'I-'.$inscr;
   }else{
      $xnumero = ''; 
   }

   if ($k03_tipo == 6) {
     $juros = $juros + $vlrdescjur;
     $multa = $multa + $vlrdescmul;
     $desconto = $vlrdescjur + $vlrdescmul;
   }

   if ($k03_tipo == 13) {

//     die("juros: $juros - multa: $multa - vlrdescjur: $vlrdescjur - totalzao: $totalzao =========== \n");

     if ($juros > 0) {
	   $vlrdescjur = $juros / $totalzaojur * $vlrdescjur;
	 }

	 if ($multa > 0) {
	   $vlrdescmul = $multa / $totalzaomul * $vlrdescmul;
	 }
     
//     $juros = $juros + $vlrdescjur;
//     $multa = $multa + $vlrdescmul;
     $desconto = $vlrdescjur + $vlrdescmul;

   }
   
   $pdf->SetFont('Arial','',7);
   $pdf->Cell(15,4,$xnumero,1,0,"C",0);
   $pdf->Cell(15,4,$v01_exerc,1,0,"C",0);
   $pdf->cell(15,4,db_formatar($v01_dtvenc,'d'),1,0,"C",0);
   $pdf->Cell(30,4,(@$v03_descr==''?"Parcelamento: ".$parcel:$v03_descr),1,0,"L",0);
   $pdf->Cell(18,4,number_format($valor,2,",","."),1,0,"R",0);
   $pdf->Cell(18,4,number_format($vlrcor,2,",","."),1,0,"R",0);
   $pdf->Cell(18,4,number_format($multa,2,",","."),1,0,"R",0);
   $pdf->Cell(18,4,number_format($juros,2,",","."),1,0,"R",0);
   $pdf->Cell(18,4,number_format($desconto,2,",","."),1,0,"R",0);
   $pdf->Cell(20,4,number_format($vlrcor+$multa+$juros-$desconto,2,",","."),1,1,"R",0);
   $Tv01_vlrhis += $valor;
   $Tv01_valor  += $vlrcor;
   $Tmulta      += $multa     ;
   $Tjuros      += $juros     ;
   $Tdesconto   += $desconto  ;
   $Total       += $vlrcor+$multa+$juros-$desconto;
}
$pdf->SetFont('Arial','B',7);
$pdf->Cell(15,6,'Total',1,0,"L",0);
$pdf->cell(60,6,'',1,0,"c",0);
$pdf->Cell(18,6,number_format($Tv01_vlrhis,2,",","."),1,0,"R",0);
$pdf->Cell(18,6,number_format($Tv01_valor,2,",","."),1,0,"R",0);
$pdf->Cell(18,6,number_format($Tmulta,2,",","."),1,0,"R",0);
$pdf->Cell(18,6,number_format($Tjuros,2,",","."),1,0,"R",0);
$pdf->Cell(18,6,number_format($Tdesconto,2,",","."),1,0,"R",0);
$pdf->Cell(20,6,number_format($Total,2,",","."),1,1,"R",0);
//$pdf->Cell(20,6,number_format($v07_valor,2,",","."),1,1,"R",0);


$pdf->Ln(2);
if($pdf->GetY() > ( $pdf->h - 40 )){
   $pdf->AddPage();
}
   $pdf->SetFont('Arial','B',9);
   $pdf->Cell(95,6,"DADOS DA ENTRADA",1,0,"C",1);
   $pdf->Cell(95,6,"DADOS DAS PARCELAS",1,1,"C",1);
   $y = $pdf->GetY();
   if ($entrada > 0){
      $numpar = $numpar-1;
   }
   $pdf->SetFont('Arial','',9);
   $pdf->Cell(50,5,'Valor da Entrada ',1,0,"L",0);
   $pdf->Cell(45,5,db_formatar($entrada,'f'),1,1,"R",0);
   $pdf->Cell(50,5,'Data do Vencimento ','LRTB',0,"L",0);
   $pdf->Cell(45,5,db_formatar($vencent,'d'),'LRTB',1,"R",0);
   $pdf->Cell(50,5,'Número do Parcelamento','LRB',0,"L",0);
   $pdf->Cell(45,5,$parcel,'LRB',1,"R",0);
   $pdf->SetXY(105,$y);
   $pdf->Cell(50,5,'Numero de Parcelas ',1,0,"L",0);
   $pdf->Cell(45,5,$numpar,1,1,"R",0);
   $pdf->SetX(105);
   $pdf->Cell(50,5,'Valor das Parcelas a Partir de ',1,0,"L",0);
   $pdf->Cell(45,5,db_formatar($vlrpar,'f'),1,1,"R",0);
   $pdf->SetX(105);
   $pdf->Cell(50,5,'Data do Vencimento ',1,0,"L",0);
   $pdf->Cell(45,5,db_formatar($vencpar,'d'),1,1,"R",0);
   $pdf->SetFont('Arial','',11);

$pdf->Ln(2);
$pdf->MultiCell(0,5,$termo_p2,0,"J",0,40);
if ( $pdf->GetY() > 248) {
   $pdf->AddPage();
}
$pdf->MultiCell(0,5,$termo_p3,0,"J",0,40);
if ( $pdf->GetY() > 248) {
   $pdf->AddPage();
}
$pdf->MultiCell(0,5,$termo_p4,0,"J",0,40);
if ( $pdf->GetY() > 248) {
   $pdf->AddPage();
}
$diaTermo = substr($v07_dtlanc,8,2);
$mesTermo = substr($v07_dtlanc,5,2);
$anoTermo = substr($v07_dtlanc,0,4);

//Exibe data do dia
//$pdf->MultiCell(0,8,$nomeinst.', '.date('d')." de ".db_mes( date('m'))." de ".date('Y').'.',0,0,"R",0);
if ( $pdf->GetY() > 248) {
   $pdf->AddPage();
}
//Exibe data de lancamento do termo
$pdf->MultiCell(0,8,$nomeinst.', '.$diaTermo." de ".db_mes($mesTermo)." de ".$anoTermo.'.',0,0,"R",0);

$pdf->MultiCell(0,4,"\n\n\n".trim($responsavel)."\n"."Contribuinte ou representante legal",0,"C",0);
$pdf->Ln(5);

if ( $pdf->GetY() > 248) {
   $pdf->AddPage();
}

$pdf->MultiCell(0,4,$termo_p5,0,"J",0,0);
$y = $pdf->GetY();
$pdf->MultiCell(90,4,$ass_secfaz,0,"C",0);
$pdf->SetXY(110,$y);
if ( @$GLOBALS["DB_id_usuario"] == 24 ) {
  $pdf->MultiCell(90,4,$ass_coodiv,0,"C",0);
} else if ( @$GLOBALS["DB_id_usuario"] == 35 ) {
  $pdf->MultiCell(90,4,$ass_chfsec,0,"C",0);
} else {
  $pdf->MultiCell(90,4,$ass_chediv,0,"C",0);
}

if(!defined('DB_BIBLIOT'))

$pdf->Output();

