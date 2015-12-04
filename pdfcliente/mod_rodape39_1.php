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
 

 $xlin = 169;



?>
