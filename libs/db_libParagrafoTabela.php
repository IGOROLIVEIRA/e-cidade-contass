<?php

class libParagrafoTabela {
  
  var $oParag = null;
  var $aTabela = array();      
  
  function libParagrafoTabela( $oParag, $aTabela ){
    
    $this->oParag  = $oParag;
    $this->aTabela = $aTabela;
    
  }
  
  function writeText( $oPdf, $aTabela ){
/*    
    foreach () {
      
      
    }
  */  
//  $this->
    return $oPdf->MultiCell( $this->oParag->db02_largura,
                             $this->oParag->db02_altura,
                             $this->oParag->db02_texto,
                             0,
                             strtoupper( $this->oParag->db02_alinhamento ),
                             0,
                             $this->oParag->db02_inicia );
                             
  }  

}