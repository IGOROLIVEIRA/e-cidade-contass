<?php
require_once("model/issqn/alvaraMovimentacao.model.php");

/**
 * @deprecated
 * @see model/issqn/alvara/RenovacaoAlvara.model.php
 */
class alvaraRenovacao extends alvaraMovimentacao {
  
  function __construct($iCodigoAlvara){
    parent::__construct($iCodigoAlvara);
    
  }

}

