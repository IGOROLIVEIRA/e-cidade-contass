<?php

namespace App\Domain\Patrimonial\PNCP\Enum;

use ECidade\Enum\Enum;

class InstrumentoConvocatorioEnum extends Enum
{
    const EDITAL = 1;
    const AVISO_DE_CONTRATACOES_DIRETA = 2;
    const ATO_QUE_AUTORIZA_CONTRATACAO_DIRETA = 3;
    protected static $dePara = [
        ModalidadeCompraEnum::DIALOGO_COMPETITIVO => [
            InstrumentoConvocatorioEnum::EDITAL
        ],
        ModalidadeCompraEnum::CONCURSO => [
            InstrumentoConvocatorioEnum::EDITAL
        ],
        ModalidadeCompraEnum::CONCORRENCIA_ELETRONICA => [
            InstrumentoConvocatorioEnum::EDITAL
        ],
        ModalidadeCompraEnum::CONCORRENCIA_PRESENCIAL => [
            InstrumentoConvocatorioEnum::EDITAL
        ],
        ModalidadeCompraEnum::PREGAO_ELETRONICO => [
            InstrumentoConvocatorioEnum::EDITAL
        ],
        ModalidadeCompraEnum::PREGAO_PRESENCIAL => [
            InstrumentoConvocatorioEnum::EDITAL
        ],
        ModalidadeCompraEnum::DISPENSA_DE_LICITACAO => [
            InstrumentoConvocatorioEnum::AVISO_DE_CONTRATACOES_DIRETA,
            InstrumentoConvocatorioEnum::ATO_QUE_AUTORIZA_CONTRATACAO_DIRETA
        ],
        ModalidadeCompraEnum::INEXIGIBILIDADE => [
            InstrumentoConvocatorioEnum::ATO_QUE_AUTORIZA_CONTRATACAO_DIRETA
        ],
        ModalidadeCompraEnum::MANIFESTACAO_DE_INTERESSE => [
            InstrumentoConvocatorioEnum::EDITAL
        ],
        ModalidadeCompraEnum::PRE_QUALIFICACAO => [
            InstrumentoConvocatorioEnum::EDITAL
        ],
        ModalidadeCompraEnum::CREDENCIAMENTO => [
            InstrumentoConvocatorioEnum::EDITAL
        ]
    ];

    public function name()
    {
        $data = [
          self::EDITAL => 'Edital',
          self::AVISO_DE_CONTRATACOES_DIRETA => 'Aviso de Contratação Direta',
          self::ATO_QUE_AUTORIZA_CONTRATACAO_DIRETA => 'Ato que Autoriza a Contratação Direta'
        ];

        if (empty($data[$this->getValue()])) {
            throw new \Exception('Opção inválida.');
        }

        return $data[$this->getValue()];
    }

    public static function getInstrumentoConvocatorio($modalidadeCompra)
    {
        $instrumentos = self::$dePara[$modalidadeCompra];
        $instrumentoConvocatorio = [];
        $instrumentoConvocatorio[] = (object)[
            'codigo' => 0,
            'descricao' => 'Selecione'
        ];

        foreach ($instrumentos as $instrumento) {
            $instrumentoConvocatorioEnum = new self($instrumento);
            $instrumentoConvocatorio[] = (object)[
                'codigo' => $instrumentoConvocatorioEnum->value,
                'descricao' => $instrumentoConvocatorioEnum->name(),
            ];
        }
        return $instrumentoConvocatorio;
    }
}
