<?php

namespace App\Domain\Patrimonial\Ouvidoria\Services;

use App\Domain\Patrimonial\Ouvidoria\Model\Atendimento\Atendimento;

class AtendimentoJsonService
{
    public static function findJson($numero, $ano, $instituicao)
    {

        $atendimento = new Atendimento();
        $atendimento = $atendimento->numero($numero)
            ->ano($ano)
            ->instituicao($instituicao);

        if (!$atendimento->exists()) {
            throw new \Exception("Atendimento n�o encontrado!");
        }

        $atendimento = $atendimento->first();

        if (!$atendimento->has('atendimentoProcessoEletronico')) {
            throw new \Exception("Atendimento n�o foi criado atrav�s do processo eletr�nico ");
        }


        return [
            'json' => $atendimento->atendimentoProcessoEletronico->ov33_informacoesprocesso,
               'atendimento_id' => $atendimento->getCodigo()
        ];
    }

    /**
     * @throws \Exception
     */
    public static function update($atendimentoId, $json)
    {

        require_once(modification(ECIDADE_PATH . 'model/ouvidoria/AtendimentoProcessoEletronico.model.php'));

        $atendimentoProcessoEletronico = \AtendimentoProcessoEletronico::findByAtendimento(
            $atendimentoId
        );

        if (!$atendimentoProcessoEletronico) {
            throw new \Exception("N�o encontrado a solicita��o de atendimento!");
        }


        $atendimentoProcessoEletronico->setInformacoesProcesso(
            $json
        );

        $atendimentoProcessoEletronico->save();
    }
}
