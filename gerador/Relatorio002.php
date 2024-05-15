<? 
  include(__DIR__ . "/../fpdf151/pdfger.php");
  // variaveis de cabeçalho;
  db_postmemory($HTTP_SERVER_VARS);
if($limite==0||$limite=="" ){
  unset($limit);
}else{
  $limit=" limit ".$limite;
}
  $resultsql = pg_exec(str_replace('\\','','select  rh01_regist,
        z01_nome,
        rh37_descr,
        r70_descr,
        rh02_codreg
   from rhpessoal
                inner join cgm on z01_numcgm = rh01_numcgm
                inner join rhfuncao on rh01_funcao = rh37_funcao
                inner join rhlota on rh01_lotac = r70_codigo
                inner join rhpessoalmov on rh01_regist =rh02_regist
                left join rhpesrescisao on rh02_seqpes = rh05_seqpes
                inner join rhregime on rh02_codreg = rh30_codreg
   where rh01_admiss between \\\'1996-01-01\\\' and \\\'2006-07-31\\\'
                and rh02_codreg = 1
                and rh05_recis is null
                and rh02_anousu = 2006
                and rh02_mesusu = 07
  order by rh01_lotac, rh37_descr'.@$limit));
  if($resultsql==false){
    echo "Verifique os dados a serem gerados.<br>";
    echo "select  rh01_regist,
        z01_nome,
        rh37_descr,
        r70_descr,
        rh02_codreg
   from rhpessoal
                inner join cgm on z01_numcgm = rh01_numcgm
                inner join rhfuncao on rh01_funcao = rh37_funcao
                inner join rhlota on rh01_lotac = r70_codigo
                inner join rhpessoalmov on rh01_regist =rh02_regist
                left join rhpesrescisao on rh02_seqpes = rh05_seqpes
                inner join rhregime on rh02_codreg = rh30_codreg
   where rh01_admiss between \\\'1996-01-01\\\' and \\\'2006-07-31\\\'
                and rh02_codreg = 1
                and rh05_recis is null
                and rh02_anousu = 2006
                and rh02_mesusu = 07
  order by rh01_lotac, rh37_descr";
  }
  $head1 = $nome;
  $head2 = "";
  $head3 = "";
  $head4 = $titulo;
  $head5 = "";
  $head6 = "";
  $head7 = "";
  $head8 = substr($finalidade, 0,30);
  $head9 = substr($finalidade,30,30);
  $DB_instit = db_getsession("DB_instit");
  $pdf = new PDF();
  $pdf->Open();
  $pdf->AliasNbPages();
 $pdf->AddPage($visualizacao);
 // monta cabecalho do relatório
 $pdf->setY(40);
 $pdf->setX(5);
 $clrotulolov = new rotulolov;
 $fm_numfields = pg_numfields($resultsql);
 $tamanho = array();
 if($visualizacao=="L"){
   $maxlargura=300;
 }else{
       $maxlargura=185;
 }
 $nova="";
 $cabecfonte_0="courier";
 $cabeccortexto_0="0#0#0";
 $cabectamanho_0="9";
 $cabecn_0="B";
 $cabeci_0="";
 $cabecs_0="";
 $cabeccortexto_0="0#0#0";
 $cabeccorborda_0="0#0#0";
 $cabeccorfundo_0="255#255#255";
 $cabecaltura_0="4";
 $cabeclargura_0="20";
 $corpfonte_0="courier";
 $corpopcao_0="nenhuma";
 $corpcortexto_0="0#0#0";
 $corptamanho_0="9";
 $corpn_0="";
 $corpi_0="";
 $corps_0="";
 $corpcorborda_0="255#255#255";
 $corpcorfundo_0="255#255#255";
 $corpaltura_0="4";
 $corplargura_0="20";
 $cabecfonte_1="courier";
 $cabeccortexto_1="0#0#0";
 $cabectamanho_1="9";
 $cabecn_1="B";
 $cabeci_1="";
 $cabecs_1="";
 $cabeccortexto_1="0#0#0";
 $cabeccorborda_1="0#0#0";
 $cabeccorfundo_1="255#255#255";
 $cabecaltura_1="4";
 $cabeclargura_1="75";
 $corpfonte_1="courier";
 $corpopcao_1="nenhuma";
 $corpcortexto_1="0#0#0";
 $corptamanho_1="9";
 $corpn_1="";
 $corpi_1="";
 $corps_1="";
 $corpcorborda_1="255#255#255";
 $corpcorfundo_1="255#255#255";
 $corpaltura_1="4";
 $corplargura_1="75";
 $cabecfonte_2="courier";
 $cabeccortexto_2="0#0#0";
 $cabectamanho_2="9";
 $cabecn_2="B";
 $cabeci_2="";
 $cabecs_2="";
 $cabeccortexto_2="0#0#0";
 $cabeccorborda_2="0#0#0";
 $cabeccorfundo_2="255#255#255";
 $cabecaltura_2="4";
 $cabeclargura_2="55";
 $corpfonte_2="courier";
 $corpopcao_2="nenhuma";
 $corpcortexto_2="0#0#0";
 $corptamanho_2="9";
 $corpn_2="";
 $corpi_2="";
 $corps_2="";
 $corpcorborda_2="255#255#255";
 $corpcorfundo_2="255#255#255";
 $corpaltura_2="4";
 $corplargura_2="55";
 $cabecfonte_3="courier";
 $cabeccortexto_3="0#0#0";
 $cabectamanho_3="9";
 $cabecn_3="B";
 $cabeci_3="";
 $cabecs_3="";
 $cabeccortexto_3="0#0#0";
 $cabeccorborda_3="0#0#0";
 $cabeccorfundo_3="255#255#255";
 $cabecaltura_3="4";
 $cabeclargura_3="95";
 $corpfonte_3="courier";
 $corpopcao_3="nenhuma";
 $corpcortexto_3="0#0#0";
 $corptamanho_3="9";
 $corpn_3="";
 $corpi_3="";
 $corps_3="";
 $corpcorborda_3="255#255#255";
 $corpcorfundo_3="255#255#255";
 $corpaltura_3="4";
 $corplargura_3="95";
 $cabecfonte_4="courier";
 $cabeccortexto_4="0#0#0";
 $cabectamanho_4="9";
 $cabecn_4="B";
 $cabeci_4="";
 $cabecs_4="";
 $cabeccortexto_4="0#0#0";
 $cabeccorborda_4="0#0#0";
 $cabeccorfundo_4="255#255#255";
 $cabecaltura_4="4";
 $cabeclargura_4="12";
 $corpfonte_4="courier";
 $corpopcao_4="nenhuma";
 $corpcortexto_4="0#0#0";
 $corptamanho_4="9";
 $corpn_4="";
 $corpi_4="";
 $corps_4="";
 $corpcorborda_4="255#255#255";
 $corpcorfundo_4="255#255#255";
 $corpaltura_4="4";
 $corplargura_4="12";
 for ($i = 0;$i < $fm_numfields;$i++){
   $cabecfonte="cabecfonte_".$i;
   $cabectamanho="cabectamanho_".$i;
   $n="cabecn_".$i;
   $it="cabeci_".$i;
   $s="cabecs_".$i;
   $pdf->SetFont($$cabecfonte,@$$s.@$$n.@$$it ,$$cabectamanho);
   $cabeccortexto="cabeccortexto_".$i;
   $cor=split("#", $$cabeccortexto);
   $pdf->SetTextColor(@$cor[0],@$cor[1],@$cor[2]);
   $cabeccorborda="cabeccorborda_".$i;
   $cor=split("#", $$cabeccorborda);
   $pdf->SetDrawColor(@$cor[0],@$cor[1],@$cor[2]);
   $cabeccorfundo="cabeccorfundo_".$i;
   $cor=split("#", $$cabeccorfundo);
   $pdf->SetFillColor(@$cor[0],@$cor[1],@$cor[2]);
   $clrotulolov->label(pg_fieldname($resultsql,$i));
   $cabecaltura="cabecaltura_".$i;
   $cabeclargura="cabeclargura_".$i;
   $x=$pdf->getx();
   if($$cabeclargura+$x > $maxlargura){
     $pdf->ln($$cabecaltura);//não funciona 
     $pdf->setX(5);
   }
   $pdf->Cell($$cabeclargura,$$cabecaltura,$clrotulolov->titulo,"LRBT",($i==($fm_numfields-1)?1:0),"",1);
   if($clrotulolov->tamanho==""){
 	  $tamanho[$i] = 20;
   }else{
 	  $tamanho[$i] = (($clrotulolov->tamanho>strlen($clrotulolov->titulo)?$clrotulolov->tamanho:strlen($clrotulolov->titulo))*2)+2;
   }
 }
  $pdf->ln(2);
 // corpo do relatório
 $linha = 0;
 for ($xi=0;$xi<pg_numrows($resultsql);$xi++){
   $pdf->setX(5);
   //db_fieldsmemory($resultsql,$i);
   for ($c=0;$c<$fm_numfields;$c++){
     $corpfonte="corpfonte_".$c;
     $corptamanho="corptamanho_".$c;
     $n="corpn_".$c;
     $it="corpi_".$c;
     $s="corps_".$c;
     $pdf->SetFont($$corpfonte,$$s.$$n.$$it ,$$corptamanho);
   $corpcortexto="corpcortexto_".$c;
   $cor=split("#", $$corpcortexto);
   $pdf->SetTextColor(@$cor[0],@$cor[1],@$cor[2]);
   $corpcorborda="corpcorborda_".$c;
   $cor=split("#", $$corpcorborda);
   $pdf->SetDrawColor(@$cor[0],@$cor[1],@$cor[2]);
   //cores que irão intercalar
   $corpcorfundo="corpcorfundo_".$c;
   if($$corpcorfundo =="255#255#255"){
     if($xi % 2!=0){
      $cor=split("#","255#255#255");
      $pdf->SetFillColor(@$cor[0],@$cor[1],@$cor[2]);
     }else{
      $cor=split("#","200#200#200");
      $pdf->SetFillColor(@$cor[0],@$cor[1],@$cor[2]);
     }
   }else{
         $corpcorfundo="corpcorfundo_".$c;
         $cor=split("#",$$corpcorfundo);
         $pdf->SetFillColor(@$cor[0],@$cor[1],@$cor[2]);
   }
     $corpaltura="corpaltura_".$c;
     $corplargura="corplargura_".$c;
     $x=$pdf->getx();
     if($$corplargura+$x > $maxlargura) {
      $pdf->ln($$corpaltura);
      $pdf->setX(5);
     }
     $y=$pdf->getY();
     if($visualizacao=="L"){
       if($y>=180){
         $nova=true; 
       }
     }else{
           if($y>=270){
              $nova=true; 
            }
     }
     if($c<($fm_numfields-1)){
       $quebra=0;
     }else{
          $quebra=1;
     } 
     $pdf->Cell($$corplargura,$$corpaltura,pg_result($resultsql,$xi,$c),1,$quebra,"",1);
   } 
   if($nova==true){
     $nova = false;
     //Imprime cabeçalho, caso pdf tenha mais de uam pagina 
     $pdf->AddPage($visualizacao);
     $pdf->setX(5);
     for ($cabec=0;$cabec < $fm_numfields;$cabec++){
       $cabecfonte="cabecfonte_".$cabec;
       $cabectamanho="cabectamanho_".$cabec;
       $n="cabecn_".$cabec;
       $it="cabeci_".$cabec;
       $s="cabecs_".$cabec;
       $pdf->SetFont($$cabecfonte,$$s.$$n.$$it ,$$cabectamanho);
       $cabeccortexto="cabeccortexto_".$cabec;
       $cor=split("#", $$cabeccortexto);
       $pdf->SetTextColor(@$cor[0],@$cor[1],@$cor[2]);
       $cabeccorborda="cabeccorborda_".$cabec;
       $cor=split("#", $$cabeccorborda);
       $pdf->SetDrawColor(@$cor[0],@$cor[1],@$cor[2]);
       $cabeccorfundo="cabeccorfundo_".$cabec;
       $cor=split("#", $$cabeccorfundo);
       $pdf->SetFillColor(@$cor[0],@$cor[1],@$cor[2]);
       $clrotulolov->label(pg_fieldname($resultsql,$cabec));
       $cabecaltura="cabecaltura_".$cabec;     
       $cabeclargura="cabeclargura_".$cabec;     
       $x=$pdf->getx(); 
       if($$cabeclargura+$x > $maxlargura){
         $pdf->ln($$altura);//não funciona   
         $pdf->setX(5);
       } 
       $clrotulolov->label(pg_fieldname($resultsql,$cabec));
       $pdf->Cell($$cabeclargura,$$cabecaltura,$clrotulolov->titulo,"LRBT",($cabec==($fm_numfields-1)?1:0),"L",1);
       //$pdf->Cell((($clrotulolov->tamanho>strlen($clrotulolov->titulo)?$clrotulolov->tamanho:strlen($clrotulolov->titulo))*2)+2,4,$clrotulolov->titulo,"LRBT",($cabec==($fm_numfields-1)?1:0),"L",0);
     }
     $pdf->ln(1);	   
   } 
 }
 $pdf->setX(5);
 for($s=0;$s<$fm_numfields;$s++){
       $corpopcao="corpopcao_".$s;
       $corplargura="corplargura_".$s;
       $pdf->SetFillColor(200,200,200);
       if($s<($fm_numfields-1)){
         $quebra=0;
       }else{
             $quebra=1;
       }
       if($$corpopcao!="nenhuma"){
         $pdf->Cell($$corplargura,4,"Total",1,$quebra,"LRBT",1);
       }else{
         $pdf->Cell($$corplargura,4,"",1,$quebra,"LRBT",0);
       }
     }
       $pdf->setX(5);
       $soma=0;
       $contador=0;
       $preenchido=0;
       for($cc=0;$cc<$fm_numfields;$cc++){
         if($cc<($fm_numfields-1)){
           $quebra=0;
         }else{
            $quebra=1;
         }
         $corplargura="corplargura_".$cc;
         $pdf->SetFillColor(200,200,200);
         $corpopcao="corpopcao_".$cc;
         switch($$corpopcao){
                case "somar":
                       for($d=0; $d< pg_numrows($resultsql) ; $d++){
                         $result=pg_result($resultsql, $d, $cc);
                         $soma+=$result;
                       }
                      $pdf->Cell($$corplargura,4,$soma,1,$quebra,"LRBT",1);
                       break;
                case "preenchidos":
                      for($d=0; $d< pg_numrows($resultsql) ; $d++){
                       $result=pg_result($resultsql, $d, $cc);
                        if($result!=""){
                           $preenchido+=1;
                        }
                      }
                      $pdf->Cell($$corplargura,4,$preenchido,1,$quebra,"LRBT",1);
                      break;
                case "contar":
                    for($d=0; $d< pg_numrows($resultsql) ; $d++){
                       $result=pg_result($resultsql, $d, $cc);
                       $contador+=1;
                     }
                     $pdf->Cell($$corplargura,4,$contador,1,$quebra,"LRBT",1);
                     break;
                case "nenhuma";
                     $pdf->Cell($$corplargura,4,"",0,$quebra,"LRBT",0);
                     break;
       }
     }
 //$pdf->Cell(200,2,"","",1,"L",0);
 //$pdf->Cell(200,0,"","LRBT",1,"L",0);
  //$tmpfile=tempnam("tmp","tmp.pdf");
 $pdf->Output();
?>
