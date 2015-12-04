<?php

interface ICorrecoes{
  
  // public $sMensagem;
  // public $lErro;

  public function setModoTeste($lModoTeste);
  public function getModoTeste();
  public function run();  
  public function hasError();
  public function getMessage();
  
}