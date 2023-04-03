<?

class _db_fields {
  //
}

class db_utils {
  
  
  function db_utils()
  {
    
  }
  
  function fieldsMemory($rs, $idx, $formata=false, $mostra = false, $lEncode=false)
  {
    $oFields      = new _db_fields();
    $numFields    = pg_num_fields($rs);
    $iTotalLinhas = pg_num_rows($rs); 
    for ($i = 0; $i < $numFields; $i++) {
      
      $sValor     = "";
      $sFieldName = @pg_field_name($rs, $i);
      $sFieldType = @pg_field_type($rs, $i);
      if ($iTotalLinhas > 0) {
         $sValor = trim(@pg_result($rs, $idx, $sFieldName));
      }
      if ($formata) {
        
        switch ($sFieldType) {
          
        case "date" :
          if ($sValor != null) {
            $sValor = implode('/',array_reverse(explode("-",$sValor)));
          }
        break;
        default :
          $sValor  = stripslashes($sValor);
         break;
        }
        
      }
      if ($mostra) {
        echo $sFieldName ." => ".$sValor." <br>";
      }
      if ($lEncode){

         switch ($sFieldType){

           case "bpchar":
              $sValor = urlencode($sValor);
           break;
           case "varchar":
              $sValor = urlencode($sValor);
           break;
           case "text":
              $sValor = urlencode($sValor);
           break;
           
         }
      }
      
      $oFields->$sFieldName = $sValor;
    }
    return $oFields;
  }
  
  function postMemory($aVetor, $mostra=false)
  {
    
    $oFields   = new _db_fields();
    for ($i = 0; $i < count($aVetor); $i++) {
      
      $sFieldName     = key($aVetor);
      $sValor         = current($aVetor);
      if ($mostra) {
        
        echo $sFieldName ." => ".$sValor." <br>";
      }
      
      $oFields->$sFieldName = $sValor;
      next($aVetor);
    }
    return $oFields;
  }

  /**
   * @description Metodo para carregar o arquivo de definiÃ§Ã£o da classe requerida;
   * @param  string sClasse - nome da classe a ser carregada
   *
   */

  function getDao( $sClasse, $rInstance = true ){
  
     if (!class_exists("cl_{$sClasse}")){
        require_once "classes/db_{$sClasse}_classe.php";     
     }

     if ($rInstance){
       
        eval ("\$objRet = new cl_{$sClasse};");
        return $objRet;

     }
  }

  /**
   * @description Metodo para retornar uma colecao de objetos por um record
   * @param  recordset - recordset a ser convertido em coleção de objetos db_utils
   * 
   * @return array()   - retorna um array(colecao de objetos) db_utils
   *
   */

  function getColectionByRecord($rsRecordset, $lFormata=false, $lMostra=false, $lEncode=false) {

    $iINumRows = @pg_num_rows($rsRecordset);
    $aDButils  = array();
    if ( $iINumRows > 0 ){

      for ($iIndice = 0; $iIndice < $iINumRows; $iIndice++ ) {
        $aDButils[] = self::fieldsMemory($rsRecordset,$iIndice,$lFormata,$lMostra,$lEncode);
      }
      

    } 
    
   return $aDButils;
     
  }

  
  /**
   * testa se a existe transacao ativa na conexao corrente;.
   * @return boolean
   */
  
  function inTransaction(){
    
    global $conn; 
    $isIntransaction = false;
    $lStatus = pg_transaction_status($conn);                              
    switch($lStatus){
    
      // sem transacao em  (0)
       case  PGSQL_TRANSACTION_IDLE:
         
         $isIntransaction = false;
         break;
         
       //em Transacao Ativa, comando sendo executado  (1)
       case PGSQL_TRANSACTION_ACTIVE:
         
         
         $isIntransaction = true;
         break;
         
      
       //transacao em andamento  (2)
       case PGSQL_TRANSACTION_INTRANS:

         $isIntransaction = true;
         break;
         
       //transacao com erro  (3)
       case  PGSQL_TRANSACTION_INERROR:
       
         $isIntransaction = false;
         break;   
         
       //falha na conexao; (4);
       case PGSQL_TRANSACTION_UNKNOWN:
         
         $isIntransaction = false;
         break;   
       
    }
    return $isIntransaction; 
  }

	function isUTF8($string) {
	  if ( mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1') == 'UTF-8'){
	  	return true; 
	  } else {
	  	return false;
	  }
	}  

  function isLATIN1($string) {
    if ( mb_detect_encoding($string.'x', 'UTF-8, ISO-8859-1') == 'ISO-8859-1') {
      return true; 
    } else {
      return false;
    }     
  }  	
	
}

?>
