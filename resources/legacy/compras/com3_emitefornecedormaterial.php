<?php
require_once("fpdf151/pdf.php");
require_once("fpdf151/impcarne.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_pcprocitem_classe.php");
require_once("classes/db_empautitem_classe.php");

db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);

	if (!empty($pc01_codmater) && !empty($pc04_codsubgrupo) ) {
	$sSql = "select distinct pc01_codmater, z01_numcgm,z01_nome,z01_cgccpf,z01_telef  
			from pcorcam
			inner join pcorcamitem on pcorcamitem.pc22_codorc = pcorcam.pc20_codorc 
			left join pcorcamforne on pcorcamforne.pc21_codorc = pcorcam.pc20_codorc 
			left join cgm on cgm.z01_numcgm = pcorcamforne.pc21_numcgm 
			inner join pcorcamitemproc on pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem 
			inner join pcprocitem on pcprocitem.pc81_codprocitem= pcorcamitemproc.pc31_pcprocitem 
			inner join solicitem on solicitem.pc11_codigo= pcprocitem.pc81_solicitem 
			inner join pcdotac on pc13_codigo=solicitem.pc11_codigo 
			left join solicitempcmater on solicitempcmater.pc16_solicitem= solicitem.pc11_codigo 
			left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater 
			left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo 
			left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo 
			left join solicitemele on solicitemele.pc18_solicitem= solicitem.pc11_codigo 
			left join solicitemunid on solicitemunid.pc17_codigo= solicitem.pc11_codigo 
			left join matunid on matunid.m61_codmatunid= solicitemunid.pc17_unid 
			left join pcorcamjulg on pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne and pcorcamjulg.pc24_orcamitem=pcorcamitem.pc22_orcamitem 
			left join pcorcamval on pcorcamval.pc23_orcamforne=pcorcamforne.pc21_orcamforne and pcorcamval.pc23_orcamitem=pcorcamitem.pc22_orcamitem
			 where pcmater.pc01_codmater = ". $pc01_codmater ." 
			 and pcsubgrupo.pc04_codsubgrupo = ".$pc04_codsubgrupo;
	}if (empty($pc01_codmater) && !empty($pc04_codsubgrupo) ) {
		
	$sSql = "select distinct pc01_codmater, z01_numcgm,z01_nome,z01_cgccpf,z01_telef  
				from pcorcam
				inner join pcorcamitem on pcorcamitem.pc22_codorc = pcorcam.pc20_codorc 
				left join pcorcamforne on pcorcamforne.pc21_codorc = pcorcam.pc20_codorc 
				left join cgm on cgm.z01_numcgm = pcorcamforne.pc21_numcgm 
				inner join pcorcamitemproc on pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem 
				inner join pcprocitem on pcprocitem.pc81_codprocitem= pcorcamitemproc.pc31_pcprocitem 
				inner join solicitem on solicitem.pc11_codigo= pcprocitem.pc81_solicitem 
				inner join pcdotac on pc13_codigo=solicitem.pc11_codigo 
				left join solicitempcmater on solicitempcmater.pc16_solicitem= solicitem.pc11_codigo 
				left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater 
				left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo 
				left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo 
				left join solicitemele on solicitemele.pc18_solicitem= solicitem.pc11_codigo 
				left join solicitemunid on solicitemunid.pc17_codigo= solicitem.pc11_codigo 
				left join matunid on matunid.m61_codmatunid= solicitemunid.pc17_unid 
				left join pcorcamjulg on pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne and pcorcamjulg.pc24_orcamitem=pcorcamitem.pc22_orcamitem 
				left join pcorcamval on pcorcamval.pc23_orcamforne=pcorcamforne.pc21_orcamforne and pcorcamval.pc23_orcamitem=pcorcamitem.pc22_orcamitem
			 where pcsubgrupo.pc04_codsubgrupo = ".$pc04_codsubgrupo;
	
	}if (!empty($pc01_codmater) && empty($pc04_codsubgrupo) ) {
	$sSql = "select distinct pc01_codmater, z01_numcgm,z01_nome,z01_cgccpf,z01_telef  
			from pcorcam
			inner join pcorcamitem on pcorcamitem.pc22_codorc = pcorcam.pc20_codorc 
			left join pcorcamforne on pcorcamforne.pc21_codorc = pcorcam.pc20_codorc 
			left join cgm on cgm.z01_numcgm = pcorcamforne.pc21_numcgm 
			inner join pcorcamitemproc on pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem 
			inner join pcprocitem on pcprocitem.pc81_codprocitem= pcorcamitemproc.pc31_pcprocitem 
			inner join solicitem on solicitem.pc11_codigo= pcprocitem.pc81_solicitem 
			inner join pcdotac on pc13_codigo=solicitem.pc11_codigo 
			left join solicitempcmater on solicitempcmater.pc16_solicitem= solicitem.pc11_codigo 
			left join pcmater on pcmater.pc01_codmater = solicitempcmater.pc16_codmater 
			left join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo 
			left join pctipo on pctipo.pc05_codtipo = pcsubgrupo.pc04_codtipo 
			left join solicitemele on solicitemele.pc18_solicitem= solicitem.pc11_codigo 
			left join solicitemunid on solicitemunid.pc17_codigo= solicitem.pc11_codigo 
			left join matunid on matunid.m61_codmatunid= solicitemunid.pc17_unid 
			left join pcorcamjulg on pcorcamjulg.pc24_orcamforne = pcorcamforne.pc21_orcamforne and pcorcamjulg.pc24_orcamitem=pcorcamitem.pc22_orcamitem 
			left join pcorcamval on pcorcamval.pc23_orcamforne=pcorcamforne.pc21_orcamforne and pcorcamval.pc23_orcamitem=pcorcamitem.pc22_orcamitem 
			 where pcmater.pc01_codmater = ". $pc01_codmater;
	}
	
	$pdf = new PDF();
	$pdf->Open();
	$pdf->SetFillColor(235);
	$head3 = "FORNECEDORES POR MATERIAL";
	$head4 = "Exercício: ".db_getsession('DB_anousu');
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',8);
	$rsResultTabela = pg_query($sSql);
	/*$pdf->Image("imagens/files/e-cidade_logo_o.jpg", 20,0,30,30);
	$pdf->Text('53', '10', 'CIAS CONSORCIO INTERMUNICIPAL ALIANCA PARA A SAUDE');
	$pdf->Text('53', '13', 'AVENIDA AFONSO PENA, 2336, 13 ANDAR');
	$pdf->Text('53', '16', '3832185900 - CNPJ:97.550.393/0001-49');
	$pdf->Text('53', '19', 'www.saude.mg.gov.br');
	$pdf->Rect('150', '3', '50','20');
	$pdf->Text('152', '10', 'FORNECEDORES POR MATERIA');
	$pdf->Text('152', '13', 'Exercício: '.db_getsession('DB_anousu'));*/
	//$pdf->ln(15);
	$pdf->Cell(190,10,'Relatório de fornecedores por tipo de fornecimento e prestação  de serviços',1,'','C');
	$pdf->ln(12);
	$pdf->Cell(20,10,'Código',1,'','C');
	$pdf->Cell(60,10,'Fornecedores',1,'','C');
	$pdf->Cell(30,10,'CPF / CNPJ',1,'','C');
	$pdf->Cell(30,10,'Telefone',1,'','C');
	$pdf->Cell(50,10,'Fornecimento / Prestação de Serviço',1,'','C');
	$pdf->ln();
	$pdf->SetFont('Arial','',6.5);
	
	for ($iCont = 0; $iCont < pg_num_rows($rsResultTabela); $iCont++) {
	  db_fieldsmemory($rsResultTabela,$iCont);
	  $subgrupo = '';
	  
	  $sSql = "select distinct pc04_descrsubgrupo from pcmater  
			 inner join empempitem on empempitem.e62_item = pcmater.pc01_codmater
			 inner join empempenho on empempitem.e62_numemp = empempenho.e60_numemp
			 inner join cgm on cgm.z01_numcgm = empempenho.e60_numcgm
			 inner join pcsubgrupo on pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo 
			 where cgm.z01_numcgm = ". $z01_numcgm;
	  
	  $rsResultSubGrupos = pg_query($sSql);
	  
	  for ($iCont2 = 0; $iCont2 < pg_num_rows($rsResultSubGrupos); $iCont2++) {
	    db_fieldsmemory($rsResultSubGrupos,$iCont2);
	    
	    $subgrupo .= $pc04_descrsubgrupo.' |'; 
	    
	  }
	  
	  if (strlen($subgrupo) > 32) {               
       $aSubgrupo = quebrar_texto($subgrupo,32);
       $alt_novo = count($aSubgrupo);                  
      } else {
       $alt_novo = 2.5;
      }
	  
	  $pdf->Cell(20,4*$alt_novo,$z01_numcgm,1,'','C');
	  $pdf->Cell(60,4*$alt_novo,$z01_nome,1,'','L');
	  $pdf->Cell(30,4*$alt_novo,$z01_cgccpf,1,'','C');
	  $pdf->Cell(30,4*$alt_novo,$z01_telef,1,'','C');
	  
	  $i = 0;
	  if (strlen($subgrupo) > 32) {
                 $pos_x = $pdf->x;
                 $pos_y = $pdf->y;
                 foreach ($aSubgrupo as $subgrupo_novo) {
                 		 $i++;	
                 		 if($i == count($aSubgrupo)){
                 		 	$borda = 'BR';
                 		 }else{
                 		 	$borda = 'R';
                 		 }
                         $pdf->cell(50,4,substr($subgrupo_novo,0,32),$borda,1,"L");
                         $pdf->x=$pos_x;
                 }
                 $pdf->x = $pdf->lMargin;
      } else {
                 $pdf->cell(50,(4*$alt_novo),substr($subgrupo,0,32),'RB',1,"L");
      } 
	  
	  //db_criatabela($rsResultSubGrupos);exit;
	  
	  /*if(pg_num_rows($rsResultSubGrupos) > 2) {
	  	
	    $pdf->MultiCell(50,4,$subgrupo,1,1,'L');
	  }else{
	  	$pdf->Cell(50,4*pg_num_rows($rsResultSubGrupos),$subgrupo,1,1,'L');
	  }*/
	}
	$pdf->Output();
	
	function quebrar_texto($texto,$tamanho){

	$aTexto = explode(" ", $texto);
	$string_atual = "";
	foreach ($aTexto as $word) {
		$string_ant = $string_atual;
		$string_atual .= " ".$word;
		if (strlen($string_atual) > $tamanho) {
			$aTextoNovo[] = $string_ant;
			$string_ant   = "";
			$string_atual = $word;
		}
	}
	$aTextoNovo[] = $string_atual;
	return $aTextoNovo;

	}
	