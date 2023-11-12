<?php

namespace App\Domain\Saude\Farmacia\Mappers;

class InconsistenciaBnafarMapper
{
    /**
     * @var object
     */
    private $dadosEnviados;

    /**
     * @var array
     */
    private $inconsistencias;

    private $erros = [
        /**
         * O estabelecimento informado n�o consta no CNES.
         */
        'MSG06' => 'id_estabelecimento',
        /**
         * O CNPJ n�o consta no cadastro da Receita Federal.
         */
        'MSG12' => 'id_estabelecimento',
        /**
         * O Tipo de Entrada � inv�lido.
         */
        'MSG14' => 'movimentacao',
        /**
         * O Tipo de Sa�da � inv�lido
         */
        'MSG21' => 'movimentacao',
        /**
         * Para o usuarioSus o CNS n�o foi encontrado no CADSUS.
         */
        'MSG24' => 'cns_paciente',
        /**
         * Para o usuarioSus o CPF n�o foi encontrado na base de dados da Receita Federal.
         */
        'MSG33' => 'cpf_paciente',
        /**
         * Para o usuarioSus � obrigat�rio informar pelo menos o CPF ou CNS.
         */
        'MSG55' => 'cpf_paciente',
    ];

    /**
     * Erros relacionados ao medicamento
     * @var array
     */
    private $errosItem = [
        /**
         * Para o itens[<<posi��o do registro>>].numero o N�mero do Produto � inv�lido.
         */
        'MSG09' => 'numero_produto',
        /**
         * O CNPJ n�o consta no cadastro da Receita Federal.
         */
        'MSG12' => 'id_fabricante',
    ];

    /**
     * Erros relacionados a campos sem necessidade de valida��o e/ou n�o exportados
     * @var array
     */
    private $errosNaoMapeados = [
        /**
         * Para o itens[<<posi��o do registro>>].siglaProgramaSaude o Programa de Sa�de � inv�lido.
         */
        'MSG10',
        /**
         * Para o itens[<<posi��o do registro>>] os campos CNPJ do Fabricante e Fabricante Internacional n�o podem
         * ser preenchidos simultaneamente e/ou n�o foram informados.
         */
        'MSG13',
        /**
         * O registro j� consta na base de dados com o identificador <<c�digo registro>>.
         */
        'MSG15',
        /**
         * O prazo para inclus�o desse registro foi expirado em <<data limite>>.
         */
        'MSG16',
        /**
         * O prazo para reclus�o desse registro foi expirado em <<data limite>>.
         */
        'MSG17',
        /**
         * O prazo para exclus�o desse registro foi expirado em <<data limite>>.
         */
        'MSG18',
        /**
         * Protocolo n�o encontrado.
         */
        'MSG19',
        /**
         * O campo itens[<<posi��o do registro>>].<<campo>> � de preenchimento obrigat�rio
         * quando o produto � do tipo especializado
         */
        'MSG27',
        /**
         * O CID-10 do itens[<<posi��o do registro>>].cid10 � inv�lido
         */
        'MSG29',
        /**
         * Para o procedimentos[<<posi��o do registro>>].numero o N�mero do Procedimento n�o foi encontrado.
         */
        'MSG30',
        /**
         * Para o itens[<<posi��o do registro>>].posologia.unidadeDose[asd] a Unidade da Dose informada � inv�lida
         */
        'MSG34',
        /**
         * Informe somente um par�metro al�m do Ente Federativo
         * para a requisi��o (lista de itens ou c�digo do protocolo).
         */
        'MSG38',
        /**
         * H� �bito declarado para <<campo>> informado.
         */
        'MSG40',
        /**
         * Para o itens[<<posi��o do registro>>].profissionalPrescritor os campos CNS/CPF e N�mero de Registro
         * Profissional/UF n�o podem ser preenchidos simultaneamente e/ou n�o foram informados.
         */
        'MSG42',
        /**
         * O Servi�o <<nome do portf�lio>> est� indispon�vel.
         */
        'MSG44',
        /**
         * O Ente Federativo informado n�o � o mesmo do(s) dado(s) cadastrado(s).
         */
        'MSG51',
        /**
         * Identificador do registro no corpo da mensagem � diferente da url.
         */
        'IDNOTVALID'
    ];

    /**
     * @param object $dadosEnviados
     * @param array $inconsistencias
     */
    public function __construct($dadosEnviados, $inconsistencias)
    {
        $this->dadosEnviados = $dadosEnviados;
        $this->inconsistencias = $inconsistencias;
    }

    /**
     * @return array
     */
    public function get()
    {
        $erros = [];
        foreach ($this->inconsistencias as $inconsistencia) {
            $idEstoqueItem = $this->getIdEstoqueItem($inconsistencia);
            $erro = (object)[
                'campo' => $this->getCampo($inconsistencia, $idEstoqueItem),
                'idMovimentacao' => $this->dadosEnviados->caracterizacao->codigoOrigem,
                'descricao' => utf8_decode($inconsistencia->mensagem) . $this->getAjuda($inconsistencia),
                'idEstoqueItem' => $idEstoqueItem
            ];

            if (property_exists($inconsistencia, 'valorRejeitado')) {
                $erro->valorRejeitado = $inconsistencia->valorRejeitado;
            }

            $erros[] = $erro;
        }

        return $erros;
    }

    /**
     * @param object $inconsistencia
     * @return string|null
     */
    private function getCampo($inconsistencia, $idEstoqueItem)
    {
        if (!array_key_exists($inconsistencia->codigo, $this->erros)
            && !array_key_exists($inconsistencia->codigo, $this->errosItem)) {
            return null;
        }

        $dePara = $this->erros;
        if (array_key_exists($inconsistencia->codigo, $this->errosItem) && $idEstoqueItem !== null) {
            $dePara = $this->errosItem;
        }

        return $dePara[$inconsistencia->codigo];
    }

    private function getAjuda($inconsistencia)
    {
        $msg09 = sprintf(
            'Para corrigir informe corretamente %s no campo %s no %s',
            'o c�digo CATMAT',
            'Farm�cia B�sica',
            'Cadastro de Medicamentos'
        );
        $ajudas = [
            'MSG09' => $msg09
        ];

        if (!array_key_exists($inconsistencia->codigo, $ajudas)) {
            return '';
        }

        return ' ' . $ajudas[$inconsistencia->codigo];
    }

    private function getIdEstoqueItem($inconsistencia)
    {
        if (!array_key_exists($inconsistencia->codigo, $this->errosItem)) {
            return null;
        }

        $matches = [];
        if (!preg_match('/(\[[0-9]+)/', $inconsistencia->mensagem, $matches)) {
            return null;
        }

        $index = substr($matches[0], 1);
        if (!array_key_exists($index, $this->dadosEnviados->itens)) {
            return null;
        }

        $item = $this->dadosEnviados->itens[$index];

        return $item->codigoOrigem;
    }
}
