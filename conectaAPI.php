<?php
if(!$t59_ativo){
    $iDBInstituicao = db_getsession("DB_instit");
    $dadosApi     = db_query("select * from cfpatriinstituicao where t59_instituicao = $iDBInstituicao "); // consulta de Dados da API
    $dadosApi     = db_utils::fieldsMemory($dadosApi, 0);
    $t59_ativo    = $dadosApi->t59_ativo;
    $t59_senhaapi = $dadosApi->t59_senhaapi;
    $t59_usuarioapi = $dadosApi->t59_usuarioapi;
    $t59_enderecoapi = $dadosApi->t59_enderecoapi;
}
if($t59_ativo == 't'){
        $curl = curl_init();
        $t59_senhaapi = base64_decode($t59_senhaapi);
        $login = array('email' => $t59_usuarioapi,'senha' => $t59_senhaapi);
        curl_setopt_array($curl, array(
        CURLOPT_URL => $t59_enderecoapi,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $login,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
    ));
  $response = curl_exec($curl);
  if(curl_errno($curl)) 
      echo curl_error($curl);
  else{ 
      $decode = json_decode($response, true);
  }
  curl_close($curl);
  $t59_tokenapi = $decode['token'];
}
if($t59_ativo == 'f'){  
    $t59_senhaapi = base64_decode($t59_senhaapi);
    $t59_tokenapi = base64_decode($t59_tokenapi);
    curl_close($curl); 
    
}  

return $decode['token'];
