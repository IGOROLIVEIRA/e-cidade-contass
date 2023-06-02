<?

class receita {
   var $arq=null;

  function receita($header){
     umask(74);
     $this->arq = fopen("tmp/RECEITA.TXT",'w+');
     fputs($this->arq,$header);
     fputs($this->arq,"\r\n");    
  }  

  function acerta_valor ($valor,$quant){
	if($valor<0){
	   $valor *= -1;
	   $valor = "-".formatar($valor,$quant-1,'v');
	}else{
	   $valor = formatar($valor,$quant,'v');
        }
        return $valor;
  }

function processa($instit=1,$data_ini="",$data_fim="",$tribinst =null,$subelemento="") {
     global $o70_instit,$instituicoes,$o70_codrec,$contador,$o70_valor,$nomeinst,$o57_fonte,$o57_fontes,$janeiro,$fevereiro,$marco,$abril,$maio,$junho,$julho,$agosto,$setembro,$outubro,$novembro,$dezembro;
     global $prev_jan,$prev_fev,$prev_mar,$prev_abr,$prev_mai,$prev_jun,$prev_jul,$prev_ago,$prev_set,$prev_out,$prev_nov,$prev_dez;
     $contador=0;

     $xtipo = 0;
     $origem = "B";
     $opcao = 3;
   
     $clreceita_saldo_mes = new cl_receita_saldo_mes;
     $clreceita_saldo_mes->dtini  = $data_ini;
     $clreceita_saldo_mes->dtfim  = $data_fim;
     $clreceita_saldo_mes->instit = $instit;
     $clreceita_saldo_mes->sql_record();
     
//   db_criatabela($clreceita_saldo_mes->result);exit;
     $valortotal = 0;
   
     $mesfim = substr($clreceita_saldo_mes->dtfim,5,2)+0;
     
     //b_criatabela($clreceita_saldo_mes->result);
     //xit;
     
     for($i=1;$i<$clreceita_saldo_mes->numrows;$i++){
	  db_fieldsmemory($clreceita_saldo_mes->result,$i);
        // pesquisa orgaotrib
        $orgaotrib=$instituicoes[$o70_instit];

        $line  = formatar(substr($o57_fonte,1,14),20,'n'); // recompisoção
        $line .= formatar($orgaotrib,4,'n'); 
	
	//if ($janeiro < 0  )
	//  $janeiro = $janeiro * -1;
        $line .= $this->acerta_valor($janeiro,13);
        $line .= $this->acerta_valor($fevereiro,13);
	if($mesfim>2){
           $line .= $this->acerta_valor($marco,13);
           $line .= $this->acerta_valor($abril,13);
	}else{
           $line .= $this->acerta_valor(0,13);
           $line .= $this->acerta_valor(0,13);
	}
	if($mesfim>4){
           $line .= $this->acerta_valor($maio,13);
           $line .= $this->acerta_valor($junho,13);
	}else{
           $line .= $this->acerta_valor(0,13);
           $line .= $this->acerta_valor(0,13);
	}
	if($mesfim>6){
           $line .= $this->acerta_valor($julho,13);
           $line .= $this->acerta_valor($agosto,13);
	}else{
           $line .= $this->acerta_valor(0,13);
           $line .= $this->acerta_valor(0,13);
	}
	if($mesfim>8){
           $line .= $this->acerta_valor($setembro,13);
           $line .= $this->acerta_valor($outubro,13);
	}else{
           $line .= $this->acerta_valor(0,13);
           $line .= $this->acerta_valor(0,13);
	}
	if($mesfim>10){
           $line .= $this->acerta_valor($novembro,13);
           $line .= $this->acerta_valor($dezembro,13);
        }else{
           $line .= $this->acerta_valor(0,13);
           $line .= $this->acerta_valor(0,13);
	}

        $valortotal += $janeiro+$fevereiro+$marco+$abril+$maio+$junho+$julho+$agosto+$setembro+$outubro+$novembro+$dezembro;

    	$line .= $this->acerta_valor($prev_jan+$prev_fev,12);
	$line .= $this->acerta_valor($prev_mar+$prev_abr,12);
	$line .= $this->acerta_valor($prev_mai+$prev_jun,12);
	$line .= $this->acerta_valor($prev_jul+$prev_ago,12);
	$line .= $this->acerta_valor($prev_set+$prev_out,12);
	$line .= $this->acerta_valor($prev_nov+$prev_dez,12);

	//{
	  /*
	    $meta = round($o70_valor/6,2);
            $meta_final = round($o70_valor - round($meta * 5,2),2);
	    
  	    $line .= $this->acerta_valor($meta,12);
	    $line .= $this->acerta_valor($meta,12);
	    $line .= $this->acerta_valor($meta,12);
	    $line .= $this->acerta_valor($meta,12);
	    $line .= $this->acerta_valor($meta,12);
	    $line .= $this->acerta_valor($meta_final,12);
	   */
        //}
        $contador ++;
        fputs($this->arq,$line);
        fputs($this->arq,"\r\n");


	//--------------------------------------
	// acerto de 0.01 centavo do pad ! 

	//--------------------------------------
	
      
     }

//     echo $valortotal;exit;
     //  trailer
     $contador = espaco(10-(strlen($contador)),'0').$contador;
     $line = "FINALIZADOR".$contador;
     fputs($this->arq,$line);
     fputs($this->arq,"\r\n");

     fclose($this->arq);

     @pg_exec("drop table work_plano");

     $teste = "true"; 
     return $teste ;

  }

}



?>
