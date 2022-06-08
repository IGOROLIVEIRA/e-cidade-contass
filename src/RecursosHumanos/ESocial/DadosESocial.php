<?php

namespace ECidade\RecursosHumanos\ESocial;

use ECidade\RecursosHumanos\ESocial\Model\Formulario\Preenchimentos;
use ECidade\RecursosHumanos\ESocial\Formatter\DadosPreenchimento as DadosPreenchimentoFormatter;
use ECidade\RecursosHumanos\ESocial\Model\Configuracao;
use ECidade\RecursosHumanos\ESocial\Model\Formulario\Tipo;
use Exception;

/**
 * Constrói uma coleção com os dados para o envio do eSocial
 *
 * @package ECidade\RecursosHumanos\ESocial
 */
class DadosESocial
{
    private $tipo;

    private $dados;

    /**
     * Responsável pelo preenchimento do formulário
     *
     * @var mixed
     */
    private $responsavelPreenchimento;

    /**
     * Informa o responsável pelo preenchimento. Se não indormado, busca de todos
     *
     * @param mixed $responsavel
     */
    public function setReponsavelPeloPreenchimento($responsavel)
    {
        $this->responsavelPreenchimento = $responsavel;
    }

    /**
     * Retorna todos os preenchimentos e suas respostas para o tipo informado
     *
     * @param integer $tipo
     * @return ECidade\RecursosHumanos\ESocial\Model\Formulario\DadosPreenchimento[]
     */
    public function getPorTipo($tipo, $matricula=null)
    {
        $this->tipo = $tipo;
        // echo $tipo;
        // exit;
        switch ($tipo) {
            case '37':
                return $this->buscaPreenchimentos($matricula);
                break;

            default:
                $preenchimentos = $this->buscaPreenchimentos($matricula);

                $this->buscaRespostas($preenchimentos);
                /**
                 * @todo Quando for o empregador, temos que buscar os dados da escala do servidor do e-cidade.
                 *       Não é possível representar a escala do servidor no formulário.
                 *       Talvez outras informações de outros cadastros também serão buscadas do e-cidade
                 */
                if ($tipo == Tipo::EMPREGADOR) {
                }

                return  $this->dados;

                break;
        }
    }

    /**
     * Busca os preenchimentos conforme o tipo de formulário informado
     *
     * @throws \Exception
     * @return \stdClass[]
     */
    private function buscaPreenchimentos($matricula = null)
    {
        // echo $this->tipo;
        // exit;
        $configuracao = new Configuracao();
        $formularioId = $configuracao->getFormulario($this->tipo);
        $preenchimento = new Preenchimentos();
        $preenchimento->setReponsavelPeloPreenchimento($this->responsavelPreenchimento);
        switch ($this->tipo) {
            case Tipo::SERVIDOR:
                return $preenchimento->buscarUltimoPreenchimentoServidor($formularioId);
            case Tipo::EMPREGADOR:
                return $preenchimento->buscarUltimoPreenchimentoEmpregador($formularioId);
            case Tipo::LOTACAO_TRIBUTARIA:
                return $preenchimento->buscarUltimoPreenchimentoLotacao($formularioId);
            case Tipo::RUBRICA:
            case Tipo::CARGO:
            case Tipo::CARREIRA:
            case Tipo::FUNCAO:
            case Tipo::HORARIO:
            case Tipo::AMBIENTE:
            case Tipo::PROCESSOSAJ:
            case Tipo::PORTUARIO:
            case Tipo::ESTABELECIMENTOS:
            case Tipo::ALTERACAODEDADOS:
            case Tipo::ALTERACAO_CONTRATO:
            case Tipo::TSV_INICIO:
            case Tipo::TSV_ALT_CONTR:
            case Tipo::CD_BENEF_IN:
                return $preenchimento->buscarUltimoPreenchimentoInstituicao($formularioId, $matricula);
            case Tipo::CADASTRAMENTO_INICIAL:
                return $preenchimento->buscarPreenchimentoS2200($formularioId, $matricula);
            default:
                throw new Exception('Tipo não encontrado.');
        }
    }

    /**
     * Busca as respostas de um preenchimento do formulário
     *
     * @param integer $preenchimentos
     */
    private function buscaRespostas($preenchimentos)
    {
        $dadosPreechimento = new DadosPreenchimentoFormatter();
        foreach ($preenchimentos as $preenchimento) {
            $this->dados[] = $dadosPreechimento->formatar(
                $this->tipo,
                $this->identificaResponsavel($preenchimento),
                $preenchimento->inscricao_empregador,
                Preenchimentos::buscaRespostas($preenchimento->preenchimento)
            );
        }
    }


    /**
     * Identifica o responsável pelo preenchimento
     * O responsável é a figura "dona" das respostas/ que preencheu o formulário
     *
     * @param \stdClass $preenchimento
     * @throws \Exception
     * @return integer
     */
    private function identificaResponsavel(\stdClass $preenchimento)
    {
        switch ($this->tipo) {
            case Tipo::SERVIDOR:
                return $preenchimento->matricula;
            case Tipo::EMPREGADOR:
                return $preenchimento->cgm;
            case Tipo::RUBRICA:
                return $preenchimento->pk;
            case Tipo::LOTACAO_TRIBUTARIA:
                return $preenchimento->pk;
            case Tipo::CARGO:
            case Tipo::CARREIRA:
            case Tipo::FUNCAO:
            case Tipo::HORARIO:
            case Tipo::AMBIENTE:
            case Tipo::PROCESSOSAJ:
            case Tipo::PORTUARIO:
            case Tipo::CADASTRAMENTO_INICIAL:
            case Tipo::ESTABELECIMENTOS:
            case Tipo::ALTERACAODEDADOS:
            case Tipo::ALTERACAO_CONTRATO:
            case Tipo::TSV_INICIO:
            case Tipo::TSV_ALT_CONTR:
            case Tipo::CD_BENEF_IN:
                return $preenchimento->pk;
            default:
                throw new Exception('Tipo não encontrado.');
        }
    }
}
