<?php

namespace App\Domain\Patrimonial\PNCP\Enum;

use ECidade\Enum\Enum;

class ModalidadeCompraEnum extends Enum
{
    const DIALOGO_COMPETITIVO = 2;
    const CONCURSO = 3;
    const CONCORRENCIA_ELETRONICA = 4;
    const CONCORRENCIA_PRESENCIAL = 5;
    const PREGAO_ELETRONICO = 6;
    const PREGAO_PRESENCIAL = 7;
    const DISPENSA_DE_LICITACAO = 8;
    const INEXIGIBILIDADE = 9;
    const MANIFESTACAO_DE_INTERESSE = 10;
    const PRE_QUALIFICACAO = 11;
    const CREDENCIAMENTO = 12;

    public function name()
    {
        $data = [
            self::DIALOGO_COMPETITIVO => 'Di�logo Competitivo',
            self::CONCURSO => 'Concurso',
            self::CONCORRENCIA_ELETRONICA => 'Concorre�ncia - Eletr�nica',
            self::CONCORRENCIA_PRESENCIAL => 'Concorre�ncia - Presencial',
            self::PREGAO_ELETRONICO => 'Preg�o - Eletr�nico',
            self::PREGAO_PRESENCIAL => 'Preg�o - Presencial',
            self::DISPENSA_DE_LICITACAO => 'Dispensa de Licita��o',
            self::INEXIGIBILIDADE => 'Inexigibilidade',
            self::MANIFESTACAO_DE_INTERESSE => 'Manifesta��o de Interesse',
            self::PRE_QUALIFICACAO => 'Pre-qualifica��o',
            self::CREDENCIAMENTO => 'Credenciamento',
        ];
        if (empty($data[$this->getValue()])) {
            throw new \Exception('Op��o inv�lida.');
        }

        return $data[$this->getValue()];
    }
}
