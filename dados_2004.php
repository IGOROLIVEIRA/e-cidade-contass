<?

$info_periodo =" Maio à Dezembro";

$it_instituicao = str_replace('-',', ',$db_selinstit); 

if ($it_instituicao == 1 ){
  //-- receita
  $gua_mai= 3927027.01;
  $gua_jun= 3748812.87;
  $gua_jul= 3734889.63;
  $gua_ago= 4271938.85;
  $gua_set= 3360960.21;
  $gua_out= 3634929.23;
  $gua_nov= 4242514.39;
  $gua_dez= 6699523.92;
   //--dados da despesa
  $gua_dmai= 1965387.62;
  $gua_djun= 1998121.20;
  $gua_djul= 2834715.98;
  $gua_dago= 1970720.70;
  $gua_dset= 2074566.01;
  $gua_dout= 1995134.34;
  $gua_dnov= 1993535.07;
  $gua_ddez= 2437875.74;

  
  $soma_rec_2004 = ($gua_mai+$gua_jun+$gua_jul+$gua_ago+$gua_set+$gua_out+$gua_nov+$gua_dez);
  $soma_desp_2004 = ($gua_dmai+$gua_djun+$gua_djul+$gua_dago+$gua_dset+$gua_dout+$gua_dnov+$gua_ddez);

} else if ($it_instituicao==2){ // camara
  // receita
  $gua_mai= 3927027.01;
  $gua_jun= 3748812.87;
  $gua_jul= 3734889.63;
  $gua_ago= 4271938.85;
  $gua_set= 3360960.21;
  $gua_out= 3634929.23;
  $gua_nov= 4242514.39;
  $gua_dez= 6699523.92;
  //--dados da despesa
  $gua_dmai= 0;
  $gua_djun= 0;
  $gua_djul= 0;
  $gua_dago= 0;
  $gua_dset= 0;
  $gua_dout= 0;
  $gua_dnov= 0;
  $gua_ddez= 0;
 
  $soma_rec_2004 = ($gua_mai+$gua_jun+$gua_jul+$gua_ago+$gua_set+$gua_out+$gua_nov+$gua_dez);
  //$soma_desp_2004 = ($gua_dmai+$gua_djun+$gua_djul+$gua_dago+$gua_dset+$gua_dout+$gua_dnov+$gua_ddez);
  $soma_desp_2004 = 1562639.78;
} else {

  $gua_mai= 3927027.01;
  $gua_jun= 3748812.87;
  $gua_jul= 3734889.63;
  $gua_ago= 4271938.85;
  $gua_set= 3360960.21;
  $gua_out= 3634929.23;
  $gua_nov= 4242514.39;
  $gua_dez= 6699523.92;
  //--dados da despesa
  $gua_dmai= 1965387.62;
  $gua_djun= 1998121.20;
  $gua_djul= 2834715.98;
  $gua_dago= 1970720.70;
  $gua_dset= 2074566.01;
  $gua_dout= 1995134.34;
  $gua_dnov= 1993535.07;
  $gua_ddez= 2437875.74;

  $soma_rec_2004 = ($gua_mai+$gua_jun+$gua_jul+$gua_ago+$gua_set+$gua_out+$gua_nov+$gua_dez);
  $soma_desp_2004 = ($gua_dmai+$gua_djun+$gua_djul+$gua_dago+$gua_dset+$gua_dout+$gua_dnov+$gua_ddez);
}


?>
