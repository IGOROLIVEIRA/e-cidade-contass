<?php

namespace ECidade\Configuracao\Formulario\Model;

/**
 * Model de Formulario especifico do eSocial
 *
 * @package  ECidade\Configuracao\Formulario\Model
 * @author   Robson de Jesus
 */
class FormularioS2200 extends FormularioEspecificoBase
{

    /**
     * retorna Array com identificadores para colunas da tela de pesquisa
     * dos formulários padrão do eSocial
     * @return array
     */
    static function getIdentColunas()
    {
        return array(
            "matricula-atribuida-ao-trabalhador-pela--4000599",
            "nome-do-trabalhador-4000553",
            "preencher-com-a-data-de-admissao-do-trab-4000603",
            "data-da-entrada-em-exercicio-pelo-servid-4000620"
        );
    }
}
