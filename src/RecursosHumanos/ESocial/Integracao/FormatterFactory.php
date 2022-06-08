<?php

namespace ECidade\RecursosHumanos\ESocial\Integracao;

use ECidade\RecursosHumanos\ESocial\Integracao\Formatter;
use ECidade\RecursosHumanos\ESocial\Model\Formulario\Tipo;

class FormatterFactory
{

    public static function get($tipo)
    {

        $path = ECIDADE_PATH . DS . 'src' . DS . 'RecursosHumanos' . DS . 'ESocial' . DS . 'Integracao' . DS . 'Formatter'. DS . 'Templates';

        $formatter = new Formatter\Formatter();
        /*if ($tipo == Tipo::S1000) {
            $formatter = new Formatter\EmpregadorFormatter();
        }*/
        
        if (!file_exists($path. DS . "template{$tipo}.php")) {
            throw new \Exception('Template não encontrado.');
        }
        $formatter->setDePara(require($path . DS . "template{$tipo}.php"));

        return $formatter;
    }
}
