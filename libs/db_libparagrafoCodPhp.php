<?php

class libParagrafoCodPhp {
  
  var $oParag = null;
  
  function libParagrafoCodPhp( $oParag  ){
    $this->oParag = $oParag;    
  }
  
  function writeText( $pdf ){    
    
    return eval($this->oParag->db02_texto);    
                             
  }  
  
}