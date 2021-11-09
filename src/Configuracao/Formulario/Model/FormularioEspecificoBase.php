<?php

namespace ECidade\Configuracao\Formulario\Model;

/**
 * Model de Formulario especifico do eSocial
 *
 * @package  ECidade\Configuracao\Formulario\Model
 * @author   Robson de Jesus
 */
abstract class FormularioEspecificoBase {

	/**
     * retorna Array com identificadores para colunas da tela de pesquisa
     * dos formulários padrão do eSocial
     * @return array
     */
    static function getIdentColunas() 
    {
    	return array();
    }

}