<?php

require_once("model/licitacao/PortalCompras/Julgamento/Participante.model.php");

class ParticipanteFabrica
{
    /**
     * Cria participante
     *
     * @param array $dados
     * @return Participante
     */
    public function criar(array $dados): Participante
    {
        $participante = new Participante;
        $participante->setCnpj($dados['CNPJ']);
        $participante->setRepresentanteLegal($dados['RepresentanteLegal']['Nome']);
        $participante->setRazaoSocial($dados['RazaoSocial']);
        return $participante;
    }

    /**
     * Cria lista de Participantes
     *
     * @param array $participantes
     * @return array
     */
    public function criarLista(array $participantes): array
    {
        $listaParticipantes = [];
        foreach($participantes as $participante) {
            $listaParticipantes[] = $this->criar($participante);
        }

        return $listaParticipantes;
    }
}