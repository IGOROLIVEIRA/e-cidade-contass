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
            "informar-o-nome-do-cargo-4000625",
            "nome-do-trabalhador-4000553",
            "descricao-da-rubrica",
            "preencher-com-o-numero-do-cpf-do-trabalh-4000552"
        );
    }
}
