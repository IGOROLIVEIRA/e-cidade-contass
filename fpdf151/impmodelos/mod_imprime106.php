<?php

$iAlt = 4;
$this->objpdf->AddPage();
$top = $this->objpdf->GetY()-3;
$this->objpdf->SetFont('Arial','B',8);
$this->objpdf->SetTextColor(0,0,0);
$this->objpdf->SetFillColor(250,250,250);
$this->objpdf->Rect(10,$top,192,40,'DF');
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
$this->objpdf->Text(170,$top+5,"IPTU ".db_getsession("DB_anousu"));

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

$this->objpdf->sety(58);

$this->objpdf->SetLineWidth(0.05);
if($this->atualizaquant == true){
  $this->qtdcarne += 1;
}
$top = $this->objpdf->GetY();
$this->objpdf->SetFont('Arial','B',8);
$this->objpdf->SetTextColor(0,0,0);
$this->objpdf->SetFillColor(250,250,250);
$this->objpdf->SetX(17);
$this->objpdf->Text(17,$top,$this->prefeitura,0,0,"L",0);
$this->objpdf->SetX(105);
$this->objpdf->Text(105,$top,$this->prefeitura,0,1,"L",0);
$this->objpdf->SetX(170);
$this->objpdf->SetX(17);
$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(17,$top+2,"SETOR TRIBUTÁRIO",0,0,"L",0);
$this->objpdf->SetX(105);
$this->objpdf->Text(105,$top+2,"SETOR TRIBUTÁRIO",0,1,"L",0);
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
$this->objpdf->RoundedRect(10,$y+1,39,6,2,'DF','1234'); // matricula/ inscrição
$this->objpdf->RoundedRect(50,$y+1,20,6,2,'DF','1234'); // cod. de arrecadação
$this->objpdf->RoundedRect(71,$y+1,12,6,2,'DF','1234'); // parcela

$this->objpdf->SetFont('Arial','B',6);
$this->objpdf->Text(165,$y-3,"Data para pagamento : ".$this->dtparapag);
$this->objpdf->Text(58 ,$y-3,"Data para pagamento : ".$this->dtparapag);
$this->objpdf->SetFont('Times','',5);

$this->objpdf->RoundedRect(10,$y+8,73,14,2,'DF','1234'); // nome / endereço
$this->objpdf->RoundedRect(10,$y+23,73,14,2,'DF','1234'); // descrição
$this->objpdf->RoundedRect(10,$y+38,39,7,2,'DF','1234'); // vencimento
$this->objpdf->RoundedRect(50,$y+38,33,7,2,'DF','1234'); // valor

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(13,$y+3,$this->titulo1); // matricula/ inscrição
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(13,$y+6,$this->matricula); // numero da matricula ou inscricao

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(52,$y+3,$this->titulo2); // cod. de arrecadação
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(52,$y+6,$this->descr2); // numpre

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(74,$y+3,$this->titulo5); // Parcela
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(75,$y+6,$this->descr5); // Parcela inicial e total de parcelas

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(13,$y+10,"Contribuinte/Endereço do imóvel"); // contribuinte/endereço
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(13,$y+13,substr($this->descr3_1, 0, 45)."..."); // nome do contribuinte
$this->objpdf->Text(13,$y+17,$this->enderimovel);// // endereço do imovel

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(13,$y+25,"Descrição"); // Descrição

$this->objpdf->SetFont('Arial','B',7);
$xx = $this->objpdf->getx();
$yy = $this->objpdf->gety();

$this->objpdf->setleftmargin(12);
$this->objpdf->setrightmargin(120);
$this->objpdf->sety($y+26);
$this->objpdf->multicell(70,3,$this->descr4_1); // Instruções 1 - linha 1
$this->objpdf->multicell(70,3,$this->descr4_2); // Instruções 1 - linha 2
$this->objpdf->setxy($xx,$yy-2);

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(13,$y+40,$this->titulo6); // Vencimento
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(13,$y+43,$this->descr6); // Data de Vencimento

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(53,$y+40,$this->titulo7); // valor
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(56,$y+43,$this->descr7); // qtd de URM ou valor

$this->objpdf->RoundedRect(95,$y+1,40,6,2,'DF','1234'); // matricula / inscricao
$this->objpdf->RoundedRect(136,$y+1,20,6,2,'DF','1234'); // cod. arrecadacao
$this->objpdf->RoundedRect(157,$y+1,20,6,2,'DF','1234'); // parcela
$this->objpdf->RoundedRect(178,$y+1,23,6,2,'DF','1234'); // livre

$this->objpdf->RoundedRect(95,$y+8,82,13,2,'DF','1234'); // nome / endereco
$this->objpdf->RoundedRect(95,$y+22,106,13,2,'DF','1234'); // descrição
$this->objpdf->RoundedRect(178,$y+8,23,6,2,'DF','1234'); // vencimento
$this->objpdf->RoundedRect(178,$y+15,23,6,2,'DF','1234'); // valor

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(97,$y+3,$this->titulo8); // matricula / inscricao
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(97,$y+6,$this->matricula); // numero da matricula ou inscricao

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(138,$y+3,$this->titulo9); // cod. de arrecadação
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(138,$y+6,$this->descr9); // numpre

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(161,$y+3,$this->titulo10); // parcela
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(162,$y+6,$this->descr10); // parcela e total das parcelas

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(180,$y+3,$this->titulo13); // livre
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(183,$y+6,$this->descr13); // livre

//guia banco
$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(97,$y+10,"Contribuinte/Endereço do imóvel"); // contribuinte / endereço
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(97,$y+13,$this->descr11_1); // nome do contribuinte

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(97,$y+24,"Descrição"); // descrição
$this->objpdf->SetFont('Arial','B',7);

$xx = $this->objpdf->getx();
$yy = $this->objpdf->gety();
$this->objpdf->setleftmargin(97);
$this->objpdf->setrightmargin(2);
$this->objpdf->sety($y+25);
$this->objpdf->Text(97,$y+17,$this->enderimovel);// endereo do imovel

// mensagem de instruções da guia prefeitura
$this->objpdf->SetFont('Arial','B',5);
$this->objpdf->multicell(100,2,substr($this->descr12_1,0,274)); // Instruções 2 - linha 1
$this->objpdf->multicell(100,2,$this->descr12_2); // Instruções 2 - linha 2
$this->objpdf->setxy($xx,$yy);

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(180,$y+10,$this->titulo14); // vencimento
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(180,$y+13,$this->descr14); // data de vencimento

$this->objpdf->SetFont('Arial','',5);
$this->objpdf->Text(180,$y+17,$this->titulo15); // valor
$this->objpdf->SetFont('Arial','B',7);
$this->objpdf->Text(180,$y+20,$this->descr15); // total de URM ou valor

$this->objpdf->SetLineWidth(0.05);
$this->objpdf->SetDash(1,1);
$this->objpdf->Line(93,$y-15,93,$y+57.2); // linha tracejada vertical
$this->objpdf->SetDash();
$this->objpdf->Ln(70);
$this->objpdf->SetFillColor(0,0,0);
$this->objpdf->SetFont('Arial','',10);

$this->objpdf->SetFont('Arial','',4);
$this->objpdf->TextWithDirection(2,$y+30,$this->texto,'U'); // texto no canhoto do carne
$this->objpdf->TextWithDirection(85,$y+35,'A U T E N T I C A C A O   M E C Â N I C A','U'); // texto no canhoto do carne
$this->objpdf->TextWithDirection(203,$y+35,'A U T E N T I C A C A O   M E C Â N I C A','U'); // texto no canhoto do carne
$this->objpdf->SetFont('Arial','',7);

// mensagem do canto inferior esquerdo da guia do contribuinte
$this->objpdf->Text(10,$y+48,$this->descr16_1); //
$this->objpdf->Text(10,$y+51,$this->descr16_2); //
$this->objpdf->Text(10,$y+54,$this->descr16_3); //

if ($this->linha_digitavel != null) {
  $this->objpdf->Text(105,$y+38,$this->linha_digitavel);
}
if ($this->codigo_barras != null) {
  $this->objpdf->int25(95,$y+39,$this->codigo_barras,15,0.341);
}

$this->objpdf->SetLineWidth(0.05);
$this->objpdf->SetDash(1,1);
$this->objpdf->Line(0,$this->objpdf->gety()-12, $this->objpdf->w ,$this->objpdf->gety()-12); // linha tracejada horizontal
$this->objpdf->SetDash();
