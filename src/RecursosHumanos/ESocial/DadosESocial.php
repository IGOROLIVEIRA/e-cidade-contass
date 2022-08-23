<?php

namespace ECidade\RecursosHumanos\ESocial;

use ECidade\RecursosHumanos\ESocial\Model\Formulario\Preenchimentos;
use ECidade\RecursosHumanos\ESocial\Formatter\DadosPreenchimento as DadosPreenchimentoFormatter;
use ECidade\RecursosHumanos\ESocial\Model\Configuracao;
use ECidade\RecursosHumanos\ESocial\Model\Formulario\Tipo;
use Exception;

/**
 * Constr�i uma cole��o com os dados para o envio do eSocial
 *
 * @package ECidade\RecursosHumanos\ESocial
 */
class DadosESocial
{
    private $tipo;

    private $dados;

    /**
     * Respons�vel pelo preenchimento do formul�rio
     *
     * @var mixed
     */
    private $responsavelPreenchimento;

    /**
     * Informa o respons�vel pelo preenchimento. Se n�o indormado, busca de todos
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
    public function getPorTipo($tipo, $matricula = null)
    {
        $this->tipo = $tipo;
        //echo $tipo;
        //exit;
        switch ($tipo) {
            case Tipo::AFASTAMENTO_TEMPORARIO:
            case Tipo::CADASTRAMENTO_INICIAL:
            case Tipo::REMUNERACAO_TRABALHADOR:
            case Tipo::RUBRICA:
            case Tipo::REMUNERACAO_SERVIDOR:
            case Tipo::DESLIGAMENTO:
                return $this->buscaPreenchimentos($matricula);
                break;
            default:
                $preenchimentos = $this->buscaPreenchimentos($matricula);

                $this->buscaRespostas($preenchimentos);
                /**
                 * @todo Quando for o empregador, temos que buscar os dados da escala do servidor do e-cidade.
                 *       N�o � poss�vel representar a escala do servidor no formul�rio.
                 *       Talvez outras informa��es de outros cadastros tamb�m ser�o buscadas do e-cidade
                 */
                if ($tipo == Tipo::EMPREGADOR) {
                }

                return  $this->dados;

                break;
        }
    }

    /**
     * Busca os preenchimentos conforme o tipo de formul�rio informado
     *
     * @throws \Exception
     * @return \stdClass[]
     */
    private function buscaPreenchimentos($matricula = null)
    {
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
                return $preenchimento->buscarPreenchimentoS1010($formularioId, $matricula);
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
            case Tipo::REMUNERACAO_TRABALHADOR:
                return $preenchimento->buscarPreenchimentoS1200($formularioId, $matricula);
            case Tipo::REMUNERACAO_SERVIDOR:
                return $preenchimento->buscarPreenchimentoS1202($formularioId, $matricula);
            case Tipo::PAGAMENTOS_RENDIMENTOS:
                return $preenchimento->buscarPreenchimentoS1210($formularioId, $matricula);
            case Tipo::AFASTAMENTO_TEMPORARIO:
                return $preenchimento->buscarPreenchimentoS2230($formularioId, $matricula);
            case Tipo::CADASTRO_BENEFICIO:
                return $preenchimento->buscarPreenchimentoS2410($formularioId, $matricula);
            case Tipo::DESLIGAMENTO:
                return $preenchimento->buscarPreenchimento($this->tipo, $matricula);
            default:
                throw new Exception('Tipo n�o encontrado.');
        }
    }

    /**
     * Busca as respostas de um preenchimento do formul�rio
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
     * Identifica o respons�vel pelo preenchimento
     * O respons�vel � a figura "dona" das respostas/ que preencheu o formul�rio
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
                throw new Exception('Tipo n�o encontrado.');
        }
    }
}
