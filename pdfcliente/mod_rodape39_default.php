<?
 $this->objpdf->SetFont('Arial','',6);

 $xlin = $xlin + 10;
 
 $this->objpdf->rect($xcol,$xlin+197,60,47,2,'DF','34');
 $this->objpdf->rect($xcol+60,$xlin+197,60,47,2,'DF','34');
 $this->objpdf->rect($xcol+120,$xlin+197,82,47,2,'DF','34');
 $this->objpdf->rect($xcol+120,$xlin+216,32,28,2,'DF','');

 $this->objpdf->rect($xcol,$xlin+191,60,6,2,'DF','12');
 $this->objpdf->rect($xcol+60,$xlin+191,60,6,2,'DF','12');
 $this->objpdf->rect($xcol+120,$xlin+191,82,6,2,'DF','12');

 $this->objpdf->text($xcol+15,$xlin+195,'CONTADORIA GERAL');
 $this->objpdf->text($xcol+82,$xlin+195,'PAGUE-SE');
 $this->objpdf->text($xcol+150,$xlin+195,'TESOURARIA');

 $this->objpdf->text($xcol+12,$xlin+199,'EMPENHADO E CONFERIDO');
 $this->objpdf->line($xcol+5,$xlin+211,$xcol+54,$xlin+211);
 $this->objpdf->text($xcol+26,$xlin+213,'VISTO');

 $this->objpdf->line($xcol+5,$xlin+225,$xcol+54,$xlin+225);
 $this->objpdf->text($xcol+19,$xlin+227,'TÉCNICO CONTÁBIL');

 $this->objpdf->text($xcol+66,$xlin+212,'DATA  ____________/____________/____________');

 $this->objpdf->line($xcol+65,$xlin+225,$xcol+114,$xlin+225);
 $this->objpdf->text($xcol+76,$xlin+227,'SECRETÁRIO(A) DA FAZENDA');

 $this->objpdf->text($xcol+122,$xlin+207,'CHEQUE N'.chr(176));
 $this->objpdf->text($xcol+170,$xlin+207,'DATA');
 $this->objpdf->text($xcol+122,$xlin+215,'BANCO N'.chr(176));
 $this->objpdf->text($xcol+127,$xlin+218,'DOCUMENTO N'.chr(176));
 $this->objpdf->line($xcol+155,$xlin+240,$xcol+200,$xlin+240);
 $this->objpdf->text($xcol+170,$xlin+242,'TESOUREIRO');
 
 // retangulo do recibo
 $this->objpdf->rect($xcol,$xlin+246,202,26,2,'DF','1234');

 $this->objpdf->SetFont('Arial','',7);
 $this->objpdf->text($xcol+90,$xlin+249,'R E C I B O');
 $this->objpdf->text($xcol+45,$xlin+253,'RECEBI(EMOS) DO MUNICÍPIO DE '.$this->municpref.', A IMPORTÂNCIA ABAIXO ESPECIFICADA, REFERENTE À:');
 $this->objpdf->text($xcol+2,$xlin+257,'(     ) PARTE DO VALOR EMPENHADO');
 $this->objpdf->text($xcol+102,$xlin+257,'(     ) SALDO/TOTAL EMPENHADO');
 $this->objpdf->text($xcol+2,$xlin+261,'R$');
 $this->objpdf->text($xcol+102,$xlin+261,'R$');

 $this->objpdf->text($xcol+2,$xlin+265,'EM ________/________/________',0,0,'C',0);
 $this->objpdf->text($xcol+42,$xlin+265,'_________________________________________',0,0,'C',0);
 $this->objpdf->text($xcol+102,$xlin+265,'EM ________/________/________',0,0,'C',0);
 $this->objpdf->text($xcol+142,$xlin+265,'_________________________________________',0,1,'C',0);
 $this->objpdf->SetFont('Arial','',6);
 $this->objpdf->text($xcol+62,$xlin+269,'CREDOR',0,0,'C',0);
 $this->objpdf->text($xcol+162,$xlin+269,'CREDOR',0,1,'C',0);
	   
 $this->objpdf->SetFont('Arial','',4);
 $this->objpdf->Text(2,296,$this->texto); // texto no canhoto do carne
 $this->objpdf->SetFont('Arial','',6);
 $this->objpdf->Text(200,296,($xxx+1).' via'); // texto no canhoto do carne

 $this->objpdf->setfont('Arial','',11);
 $xlin = 169;



?>
