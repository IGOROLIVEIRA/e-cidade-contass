<?php 

/**
 * InformacaoCalculoAtuarial
 * 
 * @package Calculo Atuarial
 * @author Rafael Nery <rafael.nery@dbseller.com.br>
 */
abstract class InformacaoCalculoAtuarial {

  /**
   * Retorna as InFormações do Objeto no Formato de Array
   *
   * @abstract
   * @access public
   * @return void
   */
  abstract public function toArray();
}
