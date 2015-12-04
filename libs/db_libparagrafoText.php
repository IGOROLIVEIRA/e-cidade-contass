<?php

class libParagrafoText{
  
  var $oParag = null;
  
  function libParagrafoText( $oParag ){
    $this->oParag = $oParag;    
  }
  
  function writeText( $oPdf ){
    
    return $oPdf->MultiCell( $this->oParag->db02_largura,
                             $this->oParag->db02_altura,
                             $this->oParag->db02_texto,
                             0,
                             strtoupper( $this->oParag->db02_alinhamento ),
                             0,
                             $this->oParag->db02_inicia );
                             
  }  
  
}
