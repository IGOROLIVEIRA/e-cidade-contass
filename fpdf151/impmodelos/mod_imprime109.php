<?php

//// RECIBO
$this->objpdf->AliasNbPages();
$this->objpdf->AddPage();
$this->objpdf->setAutoPageBreak(1,1);
$this->objpdf->settopmargin(1);
$this->objpdf->line(2,148.5,208,148.5);
$xlin = 20;
$xcol = 4;
for ($i = 0;$i < 2;$i++){

  $this->totaldesc   = 0;
  $this->totalrec    = 0;
  $this->totalacres  = 0;
  $this->objpdf->setfillcolor(245);
  $this->objpdf->roundedrect($xcol-2,$xlin-18,206,144.5,2,'DF','1234');
  $this->objpdf->setfillcolor(255,255,255);  
  $this->objpdf->Setfont('Arial','B',11);
  $this->objpdf->text(170,$xlin-13,'DAM VÁLIDO ATÉ: ');
  $this->objpdf->text(180,$xlin-8,$this->descr14);  //Data de vencimento
  //Via
  if( $i == 0 ){
    $str_via = 'Contribuinte';
  }else{
    $str_via = 'Caixa';
  }
  $this->objpdf->Setfont('Arial','B',8);
  $this->objpdf->text(178,$xlin-1,($i+1).'ª Via '.$str_via );

  $this->objpdf->Image('imagens/files/'.$this->logo,15,$xlin-17,12);
  $this->objpdf->Setfont('Arial','B',9);
  $this->objpdf->text(40,$xlin-15,$this->prefeitura);
  $this->objpdf->Setfont('Arial','',9);
  $this->objpdf->text(40,$xlin-11,$this->enderpref . ' ' . $this->numeropref . ' - '. $this->bairropref);
  $this->objpdf->text(40,$xlin-8,$this->municpref . ' - ' . $this->uf_config);
  $this->objpdf->text(40,$xlin-8,$this->telefpref . ' - ' . $this->emailpref);
  $this->objpdf->text(40,$xlin-11,$this->enderpref);
  $this->objpdf->text(40,$xlin-8,$this->municpref);
  $this->objpdf->text(40,$xlin-5,$this->telefpref);
  $this->objpdf->text($xcol+60,$xlin-5,"CNPJ: ");
  $this->objpdf->text($xcol+70,$xlin-5,db_formatar($this->cgcpref,'cnpj'));
  $this->objpdf->text(40,$xlin-2,$this->emailpref);
  $this->objpdf->text($xcol+100,$xlin-5,$this->tipodebito);
  
  $this->objpdf->Roundedrect($xcol,$xlin+2,$xcol+198,20,2,'DF','1234');
  $this->objpdf->Setfont('Arial','',6);
  $this->objpdf->text($xcol+2,$xlin+4,'Identificação:');
  $this->objpdf->Setfont('Arial','',8);
  $this->objpdf->text($xcol+2,$xlin+7,'Nome: ');
  $this->objpdf->text($xcol+17,$xlin+7,$this->descr3_1); //Nome do contribuinte
  $this->objpdf->text($xcol+2,$xlin+11,'Endereço :');
  $this->objpdf->text($xcol+17,$xlin+11,$this->descr3_2); //Endereço do contribuinte

  $this->objpdf->text($xcol+2,  $xlin+15, 'Bairro: ');
  $this->objpdf->text($xcol+17, $xlin+15, $this->bairrocontri);//Bairro do Contribuinte

  $this->objpdf->text($xcol+2,$xlin+19,'Município: ');
  $this->objpdf->text($xcol+17,$xlin+19,"{$this->munic}");//Município do Contribuinte
  $this->objpdf->text($xcol+75,$xlin+15,'CEP: ');
  $this->objpdf->text($xcol+82,$xlin+15,db_formatar($this->cep,'cep')); //CEP do Contribuinte

  $this->objpdf->text($xcol+128,  $xlin, 'Data: '. date("d-m-Y",db_getsession("DB_datausu")). ' Hora: '.date("H:i:s"));

  $this->objpdf->text($xcol+75,$xlin+19,'CNPJ/CPF: ');
  $this->objpdf->text($xcol+90,$xlin+19,db_formatar($this->cgccpf,(strlen($this->cgccpf)<12?'cpf':'cnpj')));//CPF/CNPJ do Contribuinte

  $this->objpdf->Setfont('Arial','',6);

  if ($this->hasQrCode) {
      $this->objpdf->Roundedrect($xcol,$xlin+24,165,35,2,'DF','1234');
      $this->objpdf->Roundedrect($xcol+167,$xlin+24,35,35,2,'DF','1234');
      $this->objpdf->Image($this->qrcode, 176, $xlin+29, 25, 25, 'png');
      $this->objpdf->SetFont('Arial','',5);
      $this->objpdf->Text(173,$xlin+27,'Pague com PIX'); // livre
  } else {
      $this->objpdf->Roundedrect($xcol,$xlin+24,202,35,2,'DF','1234');
  }
  
  $this->objpdf->sety($xlin+25);
  $maiscol = 0;
  $yy = $this->objpdf->gety();

  $this->objpdf->setx($xcol+3+$maiscol);
  $this->objpdf->Setfont('Arial','',5);
  $this->objpdf->multicell(150,4,'INFORMAÇÕES:');
  $this->objpdf->multicell(150,3,$this->descr4_1); // Instruções 1 - linha 1
  $this->objpdf->multicell(160,3,$this->descr4_2); // Instruções 1 - linha 2
  $this->objpdf->multicell(160,3,$this->descr16_1); // Instruções 1 - linha 2
  $this->objpdf->multicell(160,3,$this->descr16_2); // Instruções 1 - linha 2
  $this->objpdf->multicell(160,3,$this->descr16_3); // Instruções 1 - linha 2

  $this->objpdf->sety($xlin+24);
  $maiscol = 0;
  $yy = $this->objpdf->gety();

  $this->objpdf->Roundedrect($xcol,$xlin+61,165,40,2,'DF','1234');
  $this->objpdf->SetY($xlin+62);
  $this->objpdf->SetX($xcol+3);

  $this->objpdf->Setfont('Arial','',5);
  $this->objpdf->multicell(150,5,'HISTÓRICO:');
  $this->objpdf->multicell(150,3,'INSCRIÇÃO: ' .$this->nrinscr);
  $this->objpdf->multicell(150,3,substr($this->descr12_1,0,274)); // Instruções 2 - linha 1
  $this->objpdf->multicell(150,3,$this->descr12_2); // Instruções 2 - linha 2  
  $this->objpdf->SetX($xcol+3);
  //dados do desconto

  $this->objpdf->Roundedrect(171,$xlin+61,35,9,2,'DF','1234');
  $this->objpdf->Roundedrect(171,$xlin+71,35,9,2,'DF','1234');
  $this->objpdf->Roundedrect(171,$xlin+81.5,35,9,2,'DF','1234');
  $this->objpdf->Roundedrect(171,$xlin+92,35,9,2,'DF','1234');

  $this->objpdf->Setfont('Arial','',6);
  $this->objpdf->text(173,$xlin+64,'Valor Original');
  $this->objpdf->text(173,$xlin+73,'( + ) Valor Correção');
  $this->objpdf->text(173,$xlin+83.5,'( - ) Desconto ');
  $this->objpdf->text(173,$xlin+94,'( + ) Mora / Multa');

  if(isset($this->lEmiteVal)){
    if( $this->lEmiteVal == false){
      $totalrec   = "";
      $totaldesc  = "";
      $totalacres = "";
      $valtotal   = "";
    }else{
      $totalrec   = $this->totalrec;
      $totaldesc  = abs($this->totaldesc);
      $totalacres = $this->totalacres;
      $valtotal   = $this->valtotal;
    }
  }else{
    $totalrec   = db_formatar($this->totalrec,'f');
    $totaldesc  = db_formatar(abs($this->totaldesc),'f');
    $totalacres = db_formatar($this->totalacres,'f');
    $valtotal   = $this->valtotal;
  }

  $this->objpdf->setfont('Arial','',10);
  $this->objpdf->setxy(181,$xlin+62);
  $this->objpdf->cell(25,9,!empty($this->valororigem) ? $this->valororigem : $this->iptuvlrcor,0,0,"R");
  $this->objpdf->setxy(181,$xlin+71);
  $this->objpdf->cell(25,9,$this->valorJuros,0,0,"R");
  $this->objpdf->setxy(181,$xlin+81.5);
  $this->objpdf->cell(25,9,$this->valorDesconto,0,0,"R");
  $this->objpdf->setxy(181,$xlin+92);
  $this->objpdf->cell(25,9,$this->valorMulta,0,0,"R");

  $this->objpdf->setx(15);

  ///Totais
  $this->objpdf->Setfont('Arial','',6);
  $this->objpdf->Roundedrect(97,$xlin+102,35,9,2,'DF','1234');
  $this->objpdf->Roundedrect(134,$xlin+102,35,9,2,'DF','1234');
  $this->objpdf->Roundedrect(171,$xlin+102,35,9,2,'DF','1234');
  $this->objpdf->text(105,$xlin+104,'Código de Arrecadação');
  $this->objpdf->text(146,$xlin+104,'Vencimento');
  $this->objpdf->text(173,$xlin+104,'( = ) Valor Cobrado R$');
  $this->objpdf->setfont('Arial','',10);
  $this->objpdf->text(142,$xlin+109,$this->descr6); // Data de Vencimento
  $this->objpdf->text(105,$xlin+109,$this->descr2); //Numpre - Código arrecadação
  $this->objpdf->setfont('Arial','b',10);
  $this->objpdf->setxy(181,($xlin+103));
  $this->objpdf->cell(25,9,$this->valtotal,0,0,"R"); //Total de URM ou valor

  $this->objpdf->SetFont('Arial','B',5);
  $this->objpdf->text(140,$xlin+114,"A   U   T   E   N   T   I   C   A   Ç   Ã   O      M   E   C   Â   N   I   C   A");

  if (isset($this->k12_codautent)){
    $this->objpdf->SetFont('Arial','',8);
    $this->objpdf->text(138,$xlin+122,$this->k12_codautent);
  }

  $this->objpdf->setfillcolor(0,0,0);
  $this->objpdf->SetFont('Arial','',4);
  $this->objpdf->TextWithDirection(1.5,$xlin+60,$this->texto,'U'); // texto no canhoto do carne
  $this->objpdf->TextWithDirection(1.5,$xlin+60,$this->texto . ' - ' . ($i == 1?'2ª VIA - CONTRIBUINTE':'1ª VIA - PREFEITURA'),'U'); // texto no canhoto do carne
 
  if ($i != 0){
    $this->objpdf->setfont('Arial','',11);
    $this->objpdf->text(15,$xlin+114,$this->linha_digitavel);
    $this->objpdf->int25(10,$y+284,$this->codigo_barras,11,0.341);
  }

  $xlin = 169;
}

?>
