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
            self::DIALOGO_COMPETITIVO => 'Diálogo Competitivo',
            self::CONCURSO => 'Concurso',
            self::CONCORRENCIA_ELETRONICA => 'Concorreência - Eletrônica',
            self::CONCORRENCIA_PRESENCIAL => 'Concorreência - Presencial',
            self::PREGAO_ELETRONICO => 'Pregão - Eletrônico',
            self::PREGAO_PRESENCIAL => 'Pregão - Presencial',
            self::DISPENSA_DE_LICITACAO => 'Dispensa de Licitação',
            self::INEXIGIBILIDADE => 'Inexigibilidade',
            self::MANIFESTACAO_DE_INTERESSE => 'Manifestação de Interesse',
            self::PRE_QUALIFICACAO => 'Pre-qualificação',
            self::CREDENCIAMENTO => 'Credenciamento',
        ];
        if (empty($data[$this->getValue()])) {
            throw new \Exception('Opção inválida.');
        }

        return $data[$this->getValue()];
    }
}
