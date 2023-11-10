<?php

namespace App\Domain\Patrimonial\PNCP\Enum;

use ECidade\Enum\Enum;

class AmparoLegalEnum extends Enum
{
    const ART_28_I = 1;
    const ART_28_II = 2;
    const ART_28_III = 3;
    const ART_28_IV = 4;
    const ART_28_V = 5;
    const ART_74_I = 6;
    const ART_74_II = 7;
    const ART_74_III_A = 8;
    const ART_74_III_B = 9;
    const ART_74_III_C = 10;
    const ART_74_III_D = 11;
    const ART_74_III_E = 12;
    const ART_74_III_F = 13;
    const ART_74_III_G = 14;
    const ART_74_III_H = 15;
    const ART_74_IV = 16;
    const ART_74_V = 17;
    const ART_75_I = 18;
    const ART_75_II = 19;
    const ART_75_III_A = 20;
    const ART_75_III_B = 21;
    const ART_75_IV_A = 22;
    const ART_75_IV_B = 23;
    const ART_75_IV_C = 24;
    const ART_75_IV_D = 25;
    const ART_75_IV_E = 26;
    const ART_75_IV_F = 27;
    const ART_75_IV_G = 28;
    const ART_75_IV_H = 29;
    const ART_75_IV_I = 30;
    const ART_75_IV_J = 31;
    const ART_75_IV_K = 32;
    const ART_75_IV_L = 33;
    const ART_75_IV_M = 34;
    const ART_75_V = 35;
    const ART_75_VI = 36;
    const ART_75_VII = 37;
    const ART_75_VIII = 38;
    const ART_75_IX = 39;
    const ART_75_X = 40;
    const ART_75_XI = 41;
    const ART_75_XII = 42;
    const ART_75_XIII = 43;
    const ART_75_XIV = 44;
    const ART_75_XV = 45;
    const ART_75_XVI = 46;
    const ART_78_I = 47;
    const ART_78_II = 48;
    const ART_78_III = 49;
    const ART_74_CAPUT = 50;
    const ART_29_CAPUT = 51;
    const ART_24_INCISO_1 = 52;
    const ART_25_INCISO_1 = 53;
    const ART_34 = 54;
    const ART_11_C_I = 55;
    const ART_11_C_II = 56;
    const ART_24_C_I = 57;
    const ART_24_C_II = 58;
    const ART_24_C_III = 59;
    protected static $dePara = [
        ModalidadeCompraEnum::DIALOGO_COMPETITIVO => [
            self::ART_28_V
        ],
        ModalidadeCompraEnum::CONCURSO => [
            self::ART_28_III
        ],
        ModalidadeCompraEnum::CONCORRENCIA_ELETRONICA => [
            self::ART_28_II
        ],
        ModalidadeCompraEnum::CONCORRENCIA_PRESENCIAL => [
            self::ART_28_II
        ],
        ModalidadeCompraEnum::PREGAO_ELETRONICO => [
            self::ART_28_I
        ],
        ModalidadeCompraEnum::PREGAO_PRESENCIAL => [
            self::ART_28_I
        ],
        ModalidadeCompraEnum::DISPENSA_DE_LICITACAO => [
            InstrumentoConvocatorioEnum::AVISO_DE_CONTRATACOES_DIRETA => [
                self::ART_75_I,
                self::ART_75_II,
                self::ART_75_III_A,
                self::ART_75_III_B,
                self::ART_75_IV_A,
                self::ART_75_IV_B,
                self::ART_75_IV_C,
                self::ART_75_IV_D,
                self::ART_75_IV_E,
                self::ART_75_IV_F,
                self::ART_75_IV_G,
                self::ART_75_IV_H,
                self::ART_75_IV_I,
                self::ART_75_IV_J,
                self::ART_75_IV_K,
                self::ART_75_IV_L,
                self::ART_75_IV_M,
                self::ART_75_V,
                self::ART_75_VI,
                self::ART_75_VII,
                self::ART_75_VIII,
                self::ART_75_IX,
                self::ART_75_X,
                self::ART_75_XI,
                self::ART_75_XII,
                self::ART_75_XIII,
                self::ART_75_XIV,
                self::ART_75_XV,
                self::ART_75_XVI,
            ],
            InstrumentoConvocatorioEnum::ATO_QUE_AUTORIZA_CONTRATACAO_DIRETA => [
                self::ART_75_I,
                self::ART_75_II,
                self::ART_75_III_A,
                self::ART_75_III_B,
                self::ART_75_IV_A,
                self::ART_75_IV_B,
                self::ART_75_IV_C,
                self::ART_75_IV_D,
                self::ART_75_IV_E,
                self::ART_75_IV_F,
                self::ART_75_IV_G,
                self::ART_75_IV_H,
                self::ART_75_IV_I,
                self::ART_75_IV_J,
                self::ART_75_IV_K,
                self::ART_75_IV_L,
                self::ART_75_IV_M,
                self::ART_75_V,
                self::ART_75_VI,
                self::ART_75_VII,
                self::ART_75_VIII,
                self::ART_75_IX,
                self::ART_75_X,
                self::ART_75_XI,
                self::ART_75_XII,
                self::ART_75_XIII,
                self::ART_75_XIV,
                self::ART_75_XV,
                self::ART_75_XVI,
                self::ART_29_CAPUT,
                self::ART_24_INCISO_1,
                self::ART_25_INCISO_1,
                self::ART_34,
                self::ART_11_C_I,
                self::ART_11_C_II,
                self::ART_24_C_I,
                self::ART_24_C_II,
                self::ART_24_C_III,
            ]
        ],
        ModalidadeCompraEnum::INEXIGIBILIDADE => [
            self::ART_74_I,
            self::ART_74_II,
            self::ART_74_III_A,
            self::ART_74_III_B,
            self::ART_74_III_C,
            self::ART_74_III_D,
            self::ART_74_III_E,
            self::ART_74_III_F,
            self::ART_74_III_G,
            self::ART_74_III_H,
            self::ART_74_IV,
            self::ART_74_V,
            self::ART_74_CAPUT
        ],
        ModalidadeCompraEnum::MANIFESTACAO_DE_INTERESSE => [
            self::ART_78_III,
        ],
        ModalidadeCompraEnum::PRE_QUALIFICACAO => [
            self::ART_78_II
        ],
        ModalidadeCompraEnum::CREDENCIAMENTO => [
            self::ART_78_I
        ]
    ];

    public function name()
    {
        $data = [
            self::ART_28_I => 'Lei 14.133/2021, Art. 28, I',
            self::ART_28_II => 'Lei 14.133/2021, Art. 28, II',
            self::ART_28_III => 'Lei 14.133/2021, Art. 28, III',
            self::ART_28_IV => 'Lei 14.133/2021, Art. 28, IV',
            self::ART_28_V => 'Lei 14.133/2021, Art. 28, V',
            self::ART_74_I => 'Lei 14.133/2021, Art. 74, I',
            self::ART_74_II => 'Lei 14.133/2021, Art. 74, II',
            self::ART_74_III_A => 'Lei 14.133/2021, Art. 74, III, a',
            self::ART_74_III_B => 'Lei 14.133/2021, Art. 74, III, b',
            self::ART_74_III_C => 'Lei 14.133/2021, Art. 74, III, c',
            self::ART_74_III_D => 'Lei 14.133/2021, Art. 74, III, d',
            self::ART_74_III_E => 'Lei 14.133/2021, Art. 74, III, e',
            self::ART_74_III_F => 'Lei 14.133/2021, Art. 74, III, f',
            self::ART_74_III_G => 'Lei 14.133/2021, Art. 74, III, g',
            self::ART_74_III_H => 'Lei 14.133/2021, Art. 74, III, h',
            self::ART_74_IV => 'Lei 14.133/2021, Art. 74, IV',
            self::ART_74_V => 'Lei 14.133/2021, Art. 74, V',
            self::ART_75_I => 'Lei 14.133/2021, Art. 75, I',
            self::ART_75_II => 'Lei 14.133/2021, Art. 75, II',
            self::ART_75_III_A => 'Lei 14.133/2021, Art. 75, III, a',
            self::ART_75_III_B => 'Lei 14.133/2021, Art. 75, III, b',
            self::ART_75_IV_A => 'Lei 14.133/2021, Art. 75, IV, a',
            self::ART_75_IV_B => 'Lei 14.133/2021, Art. 75, IV, b',
            self::ART_75_IV_C => 'Lei 14.133/2021, Art. 75, IV, c',
            self::ART_75_IV_D => 'Lei 14.133/2021, Art. 75, IV, d',
            self::ART_75_IV_E => 'Lei 14.133/2021, Art. 75, IV, e',
            self::ART_75_IV_F => 'Lei 14.133/2021, Art. 75, IV, f',
            self::ART_75_IV_G => 'Lei 14.133/2021, Art. 75, IV, g',
            self::ART_75_IV_H => 'Lei 14.133/2021, Art. 75, IV, h',
            self::ART_75_IV_I => 'Lei 14.133/2021, Art. 75, IV, i',
            self::ART_75_IV_J => 'Lei 14.133/2021, Art. 75, IV, j',
            self::ART_75_IV_K => 'Lei 14.133/2021, Art. 75, IV, k',
            self::ART_75_IV_L => 'Lei 14.133/2021, Art. 75, IV, l',
            self::ART_75_IV_M => 'Lei 14.133/2021, Art. 75, IV, m',
            self::ART_75_V => 'Lei 14.133/2021, Art. 75, V',
            self::ART_75_VI => 'Lei 14.133/2021, Art. 75, VI',
            self::ART_75_VII => 'Lei 14.133/2021, Art. 75, VII',
            self::ART_75_VIII => 'Lei 14.133/2021, Art. 75, VIII',
            self::ART_75_IX => 'Lei 14.133/2021, Art. 75, IX',
            self::ART_75_X => 'Lei 14.133/2021, Art. 75, X',
            self::ART_75_XI => 'Lei 14.133/2021, Art. 75, XI',
            self::ART_75_XII => 'Lei 14.133/2021, Art. 75, XII',
            self::ART_75_XIII => 'Lei 14.133/2021, Art. 75, XIII',
            self::ART_75_XIV => 'Lei 14.133/2021, Art. 75, XIV',
            self::ART_75_XV => 'Lei 14.133/2021, Art. 75, XV',
            self::ART_75_XVI => 'Lei 14.133/2021, Art. 75, XVI',
            self::ART_78_I => 'Lei 14.133/2021, Art. 78, I',
            self::ART_78_II => 'Lei 14.133/2021, Art. 78, II',
            self::ART_78_III => 'Lei 14.133/2021, Art. 78, IIII',
            self::ART_74_CAPUT => 'Lei 14.133/2021, Art. 74, caput',
            self::ART_29_CAPUT => 'Lei 14.284/2021, Art. 29, caput',
            self::ART_24_INCISO_1 => 'Lei 14.284/2021, Art. 24 § 1º',
            self::ART_25_INCISO_1 => 'Lei 14.284/2021, Art. 25 § 1º',
            self::ART_34 => 'Lei 14.284/2021, Art. 34',
            self::ART_11_C_I => 'Lei 9.636/1998, Art. 11',
            self::ART_11_C_II => 'Lei 9.636/1998, Art. 11-C, II',
            self::ART_24_C_I => 'Lei 9.636/1998, Art. 24-C, I',
            self::ART_24_C_II => 'Lei 9.636/1998, Art. 24-C, II',
            self::ART_24_C_III => 'Lei 9.636/1998, Art. 24-C, III',
        ];
        if (empty($data[$this->getValue()])) {
            throw new \Exception('Opção inválida.');
        }

        return $data[$this->getValue()];
    }

    public static function getAmparosLegais($modalidadeCompra, $modoDisputa = null)
    {
        $amparos = self::$dePara[$modalidadeCompra];
        if (intval($modalidadeCompra) === ModalidadeCompraEnum::DISPENSA_DE_LICITACAO && (
                intval($modoDisputa) === InstrumentoConvocatorioEnum::AVISO_DE_CONTRATACOES_DIRETA ||
                intval($modoDisputa) === InstrumentoConvocatorioEnum::ATO_QUE_AUTORIZA_CONTRATACAO_DIRETA
            )) {
            $amparos = self::$dePara[$modalidadeCompra][$modoDisputa];
        }
        $amparosLegais = [];
        if (count($amparos) > 1) {
            $amparosLegais[] = (object)[
                'codigo' => 0,
                'descricao' => 'Selecione'
            ];
        }
        foreach ($amparos as $amparo) {
            $amparoLegalEnum = new self($amparo);
            $amparosLegais[] = (object)[
                'codigo' => $amparoLegalEnum->value,
                'descricao' => $amparoLegalEnum->name(),
            ];
        }
        return $amparosLegais;
    }
}
