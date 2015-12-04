<?

 class bal_ver {
    var $arq=null;

  function bal_ver($header){
      umask(74);
      $this->arq = fopen("tmp/BAL_VER.TXT",'w+');
      fputs($this->arq,$header);
      fputs($this->arq,"\r\n");
  }  

  function processa($instit=1,$data_ini="",$data_fim="",$orgaotrib) {
    global $nomeinst,$sinal_anterior,$sinal_final;
    global $contador;


   //$where = " c61_instit in (".str_replace('-',', ',$instit).") ";
   /*
   $where = " c61_instit in (1,2)";
   $orgao="0101";
   if(db_getsession("DB_instit")==3){
      $where = " c61_instit in (3)";
      $orgao = "1601";
   }
   */
   $where = " c61_instit in ($instit)";
   $orgao = $orgaotrib;
   $result = db_planocontassaldo(db_getsession("DB_anousu"),$data_ini,$data_fim,false,$where);

   $contador=0;

   $array_teste = array();
   for($x = 0; $x < pg_numrows($result);$x++){
       global $estrutural,$saldo_anterior,$saldo_anterior_debito,$saldo_anterior_credito,$saldo_final,$c60_descr;
       global $c61_reduz,$nivel;
       db_fieldsmemory($result,$x);
 
       // procura se o estrutural ja existe no array 
       $line  = formatar($estrutural,20,'n');
       for($i=0;$i < sizeof($array_teste);$i++){
           if ($line == $array_teste[$i])
	      db_msgbox("acei duplicado o estrutural $array_teste[$i]");
       }
       $array_teste[$x]=$line;
       $line .= $orgao; //'0101';
       if($sinal_anterior=='D'){
           $line .= formatar(round($saldo_anterior,2),13,'v');
           $line .= formatar(0,13,'v');
       }else{
           $line .= formatar(0,13,'v');
           $line .= formatar(round($saldo_anterior,2),13,'v');
       }
       $line .= formatar(round($saldo_anterior_debito,2),13,'v');
       $line .= formatar(round($saldo_anterior_credito,2),13,'v');
       if($sinal_final=='D'){
           $line .= formatar(round($saldo_final,2),13,'v');
           $line .= formatar(0,13,'v');
       }else{
           $line .= formatar(0,13,'v');
           $line .= formatar(round($saldo_final,2),13,'v');
       }
       $line .= formatar($c60_descr,148,'c');
       $line .= ($c61_reduz == 0?'S':'A');

       // pesquisa nivel da conta
  
       $sql = "select fc_nivel_plano2005('$estrutural') as nivel ";
       $resultsis = pg_exec($sql);
       $nivel = pg_result($resultsis,0,'nivel');

       $line .= formatar($nivel,2,'n');
  
       // pesquisa o sistema da conta orcamentaria, financeiro, etc
       $sql = "select c52_descrred
               from conplano 
                   inner join consistema on c60_codsis = c52_codsis
	       where c60_estrut = '$estrutural'";
       $resultsis = pg_exec($sql);
       if(pg_numrows($resultsis)>0){
          $line .= pg_result($resultsis,0,'c52_descrred');
       }else{
          $line .= "F";
       }
       $contador ++;
 
       fputs($this->arq,$line);
       fputs($this->arq,"\r\n");
 
    }
    //  trailer
    $contador = espaco(10-(strlen($contador)),'0').$contador;
    $line = "FINALIZADOR".$contador;
    fputs($this->arq,$line);
    fputs($this->arq,"\r\n");

    fclose($this->arq);

    $teste = "true";
    return $teste;


 }

}

?>

