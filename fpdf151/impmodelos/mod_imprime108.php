<?php
if(!empty($this->matriculaAnterior) && ($this->matriculaAnterior != $this->matricula)){  
  $this->qtdcarne = 0;  
}

if (($this->qtdcarne % 2 ) == 0 ){
  $this->objpdf->AddPage();
}

$iAlt = 4;
$top = $this->objpdf->GetY()-3;
$this->objpdf->SetFont('Arial','B',8);
$this->objpdf->SetTextColor(0,0,0);
$this->objpdf->SetFillColor(250,250,250);
$this->objpdf->Rect(10,$top,192,50,'DF');
$this->objpdf->Rect(10,$top,147,12,'DF');
$this->objpdf->SetFont('Arial','',4);
$this->objpdf->Image('imagens/files/'.$this->logo,12,$top+2,8);
$this->objpdf->Text(25,$top+4,'');
$this->objpdf->SetFont('Arial','B',11);
$this->objpdf->Text(22,$top+7,'');
$this->objpdf->SetFont('Arial','B',8);
$this->objpdf->Text(50,$top+3,$this->prefeitura);
$this->objpdf->Text(65,$top+6,$this->cnpjprefeitura);
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(62,$top+10,"SETOR TRIBUTÁRIO");

$this->objpdf->SetFont('Arial','B',10);
$this->objpdf->Text(170,$top+8,$this->tipodebito);

$this->objpdf->SetFont('Arial','',6);
$this->objpdf->Rect(10,$top+12,127,6,'DF');
$this->objpdf->Text(12,$top+14.2,"NOME OU RAZÃO SOCIAL");

$this->objpdf->Rect(136,$top+12,21,6,'DF');
$this->objpdf->Text(138,$top+14.2,"CÓDIGO PESSOA");
$this->objpdf->Rect(157,$top+12,45,6,'DF');
$this->objpdf->Text(158,$top+14.2,"CÓDIGO IMÓVEL");

$this->objpdf->SetFont('Arial','',7);
$this->objpdf->Text(12,$top+17,substr($this->nomepessoa,0,78));
$this->objpdf->Text(140,$top+17,$this->cgmpessoa);
$this->objpdf->Text(168,$top+17,$this->matricula);

$this->objpdf->SetFont('Arial','',6);
$this->objpdf->Rect(10,$top+18,192,4,'DF');
$this->objpdf->Text(12,$top+21,"END. DE CORRESPONDÊNCIA: ");
$this->objpdf->SetFont('Arial','',7);
$this->objpdf->Text(44,$top+21,$this->endercorrespondencia);

$this->objpdf->SetLineWidth(0.05);

$this->objpdf->ln(58);
$this->objpdf->SetFont('Arial','B',8);
$this->objpdf->SetTextColor(0,0,0);
$this->objpdf->SetFillColor(250,250,250);
$this->objpdf->SetX(17);
$this->objpdf->Text(17,$top+58,$this->prefeitura,0,0,"L",0);
$this->objpdf->SetX(105);
$this->objpdf->Text(105,$top+58,$this->prefeitura,0,1,"L",0);
$this->objpdf->SetX(170);
$this->objpdf->SetX(17);
$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(17,$top+62,"SETOR TRIBUTÁRIO",0,0,"L",0);
$this->objpdf->SetX(105);
$this->objpdf->Text(105,$top+62,"SETOR TRIBUTÁRIO",0,1,"L",0);
$this->objpdf->Ln(2);
$this->objpdf->SetFont('Arial','B',8);
$this->objpdf->SetX(10);
$this->objpdf->Cell(80,4,$this->tipodebito,0,0,"C",0);
$this->objpdf->SetFont('Arial','B',6);

$this->objpdf->Cell(03,4,'1ª Via Contribuinte',0,0,"R",0);
$this->objpdf->SetFont('Arial','B',8);
$this->objpdf->SetX(105);
$this->objpdf->Cell(90,4,$this->tipodebito,0,0,"C",0);
$this->objpdf->SetFont('Arial','B',6);
$this->objpdf->Cell(05,4,'2ª Via Banco',0,1,"R",0);

$y = $this->objpdf->GetY()-1;
$this->objpdf->Image('imagens/files/'.$this->logo,8,$y-10,8);
$this->objpdf->Image('imagens/files/'.$this->logo,95,$y-10,8);
$this->objpdf->SetFont('Times','',5);

$this->objpdf->RoundedRect(10,$y+1,20,6,2,'DF','1234');// matricula/ inscrição
$this->objpdf->RoundedRect(31,$y+1,20,6,2,'DF','1234');// cod. de arrecadação
$this->objpdf->RoundedRect(52,$y+1,15,6,2,'DF','1234');// parcela guia contribuinte

$this->objpdf->RoundedRect(68,$y+1,17,6,2,'DF','1234');// vencimento
$this->objpdf->RoundedRect(68,$y+8,17,6,2,'DF','1234');// valor documento
$this->objpdf->RoundedRect(68,$y+15,17,6,2,'DF','1234');// desconto
$this->objpdf->RoundedRect(68,$y+22,17,6,2,'DF','1234');// multa
$this->objpdf->RoundedRect(68,$y+29,17,6,2,'DF','1234');// juros
$this->objpdf->RoundedRect(68,$y+36,17,6,2,'DF','1234');// valor total

$this->objpdf->RoundedRect(10,$y+8,57,16,2,'DF','1234');// nome / endereço
$this->objpdf->RoundedRect(10,$y+25,57,17,2,'DF','1234');// instruçoes

$this->objpdf->SetFont('Arial','B',6);
$this->objpdf->Text(165,$y-3,"Data para pagamento : ".$this->dtparapag);
$this->objpdf->Text(58 ,$y-3,"Data para pagamento : ".$this->dtparapag);
$this->objpdf->SetFont('Times','',5);

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(13,$y+3,$this->titulo1);// matricula/ inscrição
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(13,$y+6,$this->matricula);// numero da matricula ou inscricao

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(32,$y+3,$this->titulo2);// cod. de arrecadação
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(33,$y+6,$this->descr2);// numpre

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(53,$y+3,$this->titulo5);// Parcela guia contribuinte
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(55,$y+6,$this->descr5);// Parcela inicial e total de parcelas

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(13,$y+10,$this->titulo3);// contribuinte/endereço
$this->objpdf->SetFont('Arial','B',6);
$xx = $this->objpdf->getx();
$yy = $this->objpdf->gety();
$this->objpdf->setleftmargin(12);
$this->objpdf->setrightmargin(2);
$this->objpdf->sety($y+10);
$this->objpdf->MultiCell(55,3,$this->descr3_1);// nome do contribuinte
$this->objpdf->MultiCell(55,3,$this->enderimovel);// endereço
$this->objpdf->MultiCell(55,3,$this->descr17);// Setor/Quadra/Lote
$this->objpdf->setxy($xx,$yy);

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(13,$y+27,$this->titulo4);// Instruções

$this->objpdf->SetFont('Arial','B',6);
$xx = $this->objpdf->getx();
$yy = $this->objpdf->gety();
$this->objpdf->setleftmargin(10);
$this->objpdf->setrightmargin(2);
$this->objpdf->sety($y+28);

$intnumrows = count($this->arraycodreceitas);
for($x=0;$x<$intnumrows;$x++){
  if( !empty($this->arrayvalreceitas[$x])){
    $this->objpdf->multicell(57,3,$this->arraydescrreceitas[$x].': R$'. db_formatar($this->arrayvalreceitas[$x], 'f'));// Instruções 1 - linha 1
  }
}

$this->objpdf->multicell(57,3,$this->descr4_2);// Instruções 1 - linha 2
$this->objpdf->setxy($xx,$yy-1);

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(69,$y+3,$this->titulo6);// Vencimento
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(70,$y+6,$this->descr6);// Data de Vencimento

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(69,$y+10,"Valor documento");// Valor do documento
$this->objpdf->SetFont('Arial','B',6);
$this->objpdf->Text(69,$y+13,!empty($this->valororigem) ? $this->valororigem : $this->iptuvlrcor);

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(69,$y+17,"Desconto");// valor do desconto
$this->objpdf->SetFont('Arial','B',6);
$this->objpdf->Text(69,$y+20,$this->valorDesconto);

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(69,$y+24,"Multa");// valor da multa
$this->objpdf->SetFont('Arial','B',6);
$this->objpdf->Text(69,$y+27,$this->valorMulta);

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(69,$y+31,"Juros");// valor do juros
$this->objpdf->SetFont('Arial','B',6);
$this->objpdf->Text(69,$y+34,$this->valorJuros);

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(69,$y+38,$this->titulo7." Total");// valor total
$this->objpdf->SetFont('Arial','B',6);
$this->objpdf->Text(69,$y+41,$this->valtotal);

$this->objpdf->RoundedRect(95,$y+1,20,6,2,'DF','1234');// matricula / inscricao
$this->objpdf->RoundedRect(116,$y+1,25,6,2,'DF','1234');// cod. arrecadacao
$this->objpdf->RoundedRect(142,$y+1,15,6,2,'DF','1234');// parcela
$this->objpdf->RoundedRect(158,$y+1,19,6,2,'DF','1234');// livre

$this->objpdf->RoundedRect(95,$y+8,82,14,2,'DF','1234');// nome / endereco
$this->objpdf->RoundedRect(95,$y+23,82,20,2,'DF','1234');// instrucoes

////////  COLUNA COM OS VALOR DO DOC,DESCONTO, MULTA, JUROS, VLR TOTAL...

$this->objpdf->RoundedRect(178,$y+1,23,6,2,'DF','1234');// vencimento
$this->objpdf->RoundedRect(178,$y+8,23,6,2,'DF','1234');// valor documento
$this->objpdf->RoundedRect(178,$y+15,23,6,2,'DF','1234');// valor desconto
$this->objpdf->RoundedRect(178,$y+22,23,6,2,'DF','1234');// valor multa
$this->objpdf->RoundedRect(178,$y+29,23,6,2,'DF','1234');// valor juros
$this->objpdf->RoundedRect(178,$y+36,23,6,2,'DF','1234');// valor total

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(97,$y+3,$this->titulo8);// matricula / inscricao
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(97,$y+6,$this->matricula);// numero da matricula ou inscricao

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(117,$y+3,$this->titulo9);// cod. de arrecadação
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(119,$y+6,$this->descr9);// numpre

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(143,$y+3,$this->titulo10);// parcela
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(146,$y+6,$this->descr10);// parcela e total das parcelas

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(159,$y+3,$this->titulo13);// livre
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(162,$y+6,$this->descr13);// livre

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(97,$y+10,$this->titulo11);// contribuinte / endereço
$this->objpdf->SetFont('Arial','B',7);
$xx = $this->objpdf->getx();
$yy = $this->objpdf->gety();
$this->objpdf->setleftmargin(96);
$this->objpdf->setrightmargin(2);
$this->objpdf->sety($y+10);
$this->objpdf->MultiCell(97,3,$this->descr11_1);// nome do contribuinte
$this->objpdf->MultiCell(97,3,$this->enderimovel);// endereço
$this->objpdf->MultiCell(97,3,$this->descr17);// Setor/Quadra/Lote
$this->objpdf->setxy($xx,$yy);

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(97,$y+25,$this->titulo12);// instruções
$this->objpdf->SetFont('Arial','B',6);
$xx = $this->objpdf->getx();
$yy = $this->objpdf->gety();
$this->objpdf->setleftmargin(96);
$this->objpdf->setrightmargin(2);
$this->objpdf->sety($y+26);

// mensagem de instruções da guia prefeitura
  if ($this->hasQrCode) {
      $this->objpdf->multicell(60, 2, $this->descr12_3);// Instruções 2 - linha 1
      $this->objpdf->multicell(60, 2, "Pague com PIX utilizando o QRCode ao lado ---->");
      $this->objpdf->Image($this->qrcode,158,$y+24, 17, 17, 'png');
  } else {
      $this->objpdf->multicell(80, 2, $this->descr12_3);// Instruções 2 - linha 1
  }
$this->objpdf->setxy($xx,$yy);

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(180,$y+3,$this->titulo14);// vencimento
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(180,$y+6,$this->descr14);// data de vencimento

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(180,$y+10,"Valor Documento");// valor do documento
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(180,$y+13,!empty($this->valororigem) ? $this->valororigem : $this->iptuvlrcor);// total de URM ou valoraqui

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(180,$y+17,"Desconto");// valor
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(180,$y+20,$this->valorDesconto);// total de URM ou valor

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(180,$y+24,"Multa");// valor
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(180,$y+27,$this->valorMulta);// total de URM ou valor

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(180,$y+31,"Juros");// valor
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(180,$y+34,$this->valorJuros);// total de URM ou valor

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(180,$y+38,$this->titulo15." Total");// valor
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(180,$y+41,$this->valtotal);// total de URM ou valor

$this->objpdf->SetLineWidth(0.05);
$this->objpdf->SetDash(1,1);
$this->objpdf->Line(93,$y-15,93,$y+57.2); // linha tracejada vertical
$this->objpdf->SetDash();
$this->objpdf->Ln(70);
$this->objpdf->SetFillColor(0,0,0);
$this->objpdf->SetFont('Arial','',10);

$this->objpdf->SetFont('Arial','',4);
$this->objpdf->TextWithDirection(2,$y+30,$this->texto,'U'); // texto no canhoto do carne
$this->objpdf->TextWithDirection(87,$y+35,'A U T E N T I C A C A O   M E C Â N I C A','U'); // texto no canhoto do carne
$this->objpdf->TextWithDirection(203,$y+35,'A U T E N T I C A C A O   M E C Â N I C A','U'); // texto no canhoto do carne
$this->objpdf->SetFont('Arial','',7);

// mensagem do canto inferior esquerdo da guia do contribuinte
$this->objpdf->Text(10,$y+48,$this->descr16_1); //
$this->objpdf->Text(10,$y+51,$this->descr16_2); //
$this->objpdf->Text(10,$y+54,$this->descr16_3); //

$y += 7;
if ($this->linha_digitavel != null) {
  $this->objpdf->Text(105,$y+38,$this->linha_digitavel);
}
if ($this->codigo_barras != null) {
  $this->objpdf->int25(95,$y+39,$this->codigo_barras,11,0.341);
}
$y += 15;

$this->objpdf->SetLineWidth(0.05);
$this->objpdf->SetDash(1,1);
$this->objpdf->Line(0,$this->objpdf->gety()-12, $this->objpdf->w ,$this->objpdf->gety()-12); // linha tracejada horizontal
$this->objpdf->SetDash();

$this->qtdcarne += 1;

$this->matriculaAnterior = $this->matricula;
