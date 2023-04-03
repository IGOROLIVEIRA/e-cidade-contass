<?php

require_once "TestesEstruturaBasica.php";
require_once "ITestes.interface.php";

class TemplateExemploTeste extends TestesAbstract implements ITestes {
  
  private $sMensagem = "";
  private $lErro     = false;

  function __construct(){
  }  

  public function run() {
    
    global $pConexao;

    //Mensagem de saída padrçao caso não tenha ocorrido erro.
    $this->sMensagem = "mensagem de sucesso";
    $this->initLog(basename(__FILE__));
    
    // se ocorreu algum erro ou inconsistencia devemos setar o atributo lErro como true
    $this->lErro     = true;
    
    // se ocorreu algum erro devemos registrar uma mensagem de erro para saida do script
    $this->sMensagem = "Encontrado registros duplicados no arrecad.";
    
    $this->log($this->sMensagem);

  }

  public function hasError() {
    return $this->lErro;
  }

  public function getMessage(){
    return $this->sMensagem;  
  }



}
