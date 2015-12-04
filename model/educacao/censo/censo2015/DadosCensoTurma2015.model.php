<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */


class DadosCensoTurma2015 extends DadosCensoTurma {

  /**
   * Valida os dados do arquivo
   * @param IExportacaoCenso $oExportacaoCenso da Importacao do censo
   * @return boolean
   */
  public function validarDados(IExportacaoCenso $oExportacaoCenso) {

    $lDadosValidos = true;
    $aDadosDaTurma = $oExportacaoCenso->getDadosProcessadosTurma();
    $oDadosEscola  = $oExportacaoCenso->getDadosProcessadosEscola();
    $aDadosDocente = $oExportacaoCenso->getDadosProcessadosDocente();
    $aTurmaSemProfissional  = array();

    /**
     * Busca todas as turmas que possuem vinculo com docente
     */
    foreach ( $aDadosDocente as $aRegistros ) {

      foreach ( $aRegistros->registro51 as $oRegistroDocente ) {
        array_push($aTurmaSemProfissional, $oRegistroDocente->codigo_turma_entidade_escola);
      }
    }



    foreach ($aDadosDaTurma as $oDadosTurma) {

      /**
       * Validado se o codigo INEP da turma esta vazio
       */
      if ( $oDadosTurma->codigo_turma_inep !== '' ) {

        $sMsgErro  = "Turma {$oDadosTurma->nome_turma}: ";
        $sMsgErro .= "Código da Turma INEP deve estar vazio.";
        $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
        $lDadosValidos = false;
      }
      /**
       * Valida se o código da turma Entidade/Escola foi preenchida pelo sistema
       */
      if ( empty($oDadosTurma->codigo_turma_entidade_escola) ) {

        $sMsgErro  = "Turma {$oDadosTurma->nome_turma}: ";
        $sMsgErro .= "Código da Turma na Entidade/Escola não atribuído pelo próprio sistema do usuário migrador.";
        $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
        $lDadosValidos = false;
      }

      /**
       * Valida se o Código da Turma na Entidade/Escola contém mais de 20 caracteres
       */
      if ( strlen($oDadosTurma->codigo_turma_entidade_escola) > 20 ) {

        $sMsgErro  = "Turma {$oDadosTurma->nome_turma}: ";
        $sMsgErro .= "Código da Turma na Entidade/Escola deve conter no máximo 20 caracteres.";
        $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
        $lDadosValidos = false;
      }


      /**
       * Valida se o nome da turma foi informado
       */
      if ( empty($oDadosTurma->nome_turma) ) {

        $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
        $sMsgErro .= "Nome da Turma é um campo obrigatório.";
        $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
        $lDadosValidos = false;
      }

      /**
       * Valida se o nome da turma contém mais de 80 caracteres
       */
      if ( strlen($oDadosTurma->nome_turma) > 80 ) {

        $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
        $sMsgErro .= "Nome da Turma deve conter no máximo 80 caracteres.";
        $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
        $lDadosValidos = false;
      }

      /**
       * Valida para aceitar somente os caracteres (ABCDEFGHIJKLMNOPQRSTUWXYZ 0123456789ªº-)
       */
      if ( preg_match ('/[^a-z0-9ªº\s\-]+/i',  $oDadosTurma->nome_turma) == 1 ) {

        $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
        $sMsgErro .= "Nome da turma contém excesso de espaços.";
        $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
        $lDadosValidos = false;
      }

      /**
       * Valida obrigatoriedade do campo mediação didático-pedagógica
       */
      if ( empty($oDadosTurma->mediacao_didatico_pedagogica) ) {

        $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
        $sMsgErro .= "Tipo de mediação didático-pedagógica não informado.";
        $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
        $lDadosValidos = false;
      }

      $aValidacaoDidaticoComum = array(
        'Horário da Turma - Horário Inicial - Hora'   => $oDadosTurma->horario_turma_horario_inicial_hora,
        'Horário da Turma - Horário Inicial - Minuto' => $oDadosTurma->horario_turma_horario_inicial_minuto,
        'Horário da Turma - Horário Final - Hora'     => $oDadosTurma->horario_turma_horario_final_hora,
        'Horário da Turma - Horário Final - Minuto'   => $oDadosTurma->horario_turma_horario_final_minuto,
        'Domigo'                                      => $oDadosTurma->dia_semana_domingo,
        'Segunda-feira'                               => $oDadosTurma->dia_semana_segunda,
        'Terça-feira'                                 => $oDadosTurma->dia_semana_terca,
        'Quarta-feira'                                => $oDadosTurma->dia_semana_quarta,
        'Quinta-feira'                                => $oDadosTurma->dia_semana_quinta,
        'Sexta-feira'                                 => $oDadosTurma->dia_semana_sexta,
        'Sábado'                                      => $oDadosTurma->dia_semana_sabado
      );

      $oDaoTurmaAcMatricula = new cl_turmaacmatricula();
      $sMensagemErro = "";
      foreach ( $aValidacaoDidaticoComum as $sDescricao => $sValor ) {

        /**
         * Valida se os campos 7 ao 17 estão todos preenchidos
         */
        if ( $oDadosTurma->mediacao_didatico_pedagogica == 1 ) {

          if ( $sValor === "" ) {

            $sMensagemErro .= "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
            $sMensagemErro .= "Campo {$sDescricao} não pode ser vazio.";
            $lDadosValidos = false;
          }
        } else {

        /**
         * Valida se os campos 7 ao 17 estão todos vazios
         */
          if ( $sValor !== "" ) {

            $sMensagemErro .= "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
            $sMensagemErro .= "Campo {$sDescricao} deve ser vazio.";
            $lDadosValidos = false;
          }
        }
      }

      if ( !empty($sMensagemErro) ) {
        $oExportacaoCenso->logErro($sMensagemErro, ExportacaoCensoBase::LOG_TURMA);
      }

      if ( $oDadosTurma->mediacao_didatico_pedagogica == 2 ) {

        /**
         * Valida se o Tipo de Atendimento informado está dentro dos valores:
         *   0 - Não se aplica
         *   1 - Classe hospitalar
         *   2 - Unidade de internação socioeducativa
         *   3 - Unidade prisional
         */
        $aValorTipoAtendimento = array('0','1','2','3');
        if ( !in_array($oDadosTurma->tipo_atendimento, $aValorTipoAtendimento) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Tipo de atendimento deve conter um dos seguintes valores: Não se aplica, Classe hospitalar, ";
          $sMsgErro .= "Unidade de internação socioeducativa ou Unidade prisional.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }

        /**
         * Valida se a Etapa de Ensino informado está dentro dos valores: 69, 70, 71 e 72
         */
        $aEtapaEnsino = array('69','70','71','72');
        if ( !in_array($oDadosTurma->etapa_ensino_turma, $aEtapaEnsino) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Valor inválido para a etapa de ensino.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }
      }

      if ( $oDadosTurma->mediacao_didatico_pedagogica == 3 ) {

        /**
         * Valida se o Tipo de Atendimento informado está dentro dos valores:
         *   0 - Não se aplica
         *   1 - Classe hospitalar
         *   2 - Unidade de internação socioeducativa
         *   3 - Unidade prisional
         */
        $aValorTipoAtendimento = array('0','1','2','3');
        if ( !in_array($oDadosTurma->tipo_atendimento, $aValorTipoAtendimento) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Tipo de atendimento deve conter um dos seguintes valores: Não se aplica, Classe hospitalar, ";
          $sMsgErro .= "Unidade de internação socioeducativa ou Unidade prisional.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }

        /**
         * Valida se a Modalidade de Ensino informado está dentro dos valores:
         *   1 - Ensino Regular
         *   3 - Educação de Jovens e Adultos (EJA)
         * @var array
         */
        $aModalidadeEnsino = array('1','3');
        if ( !in_array($oDadosTurma->modalidade_turma, $aModalidadeEnsino) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Modalidade de ensino deve conter um dos seguintes valores: Ensino Regular ou Educação de Jovens e Adultos (EJA).";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }

        /**
         * Valida se a Etapa de Ensino informado está dentro dos valores: '30','31','32','33','34','35','36','37',
         * '38','39','40','44','45','60','62','64','67','68'
         */
        $aEtapaEnsino = array('30','31','32','33','34','35','36','37','38','39','40','44','45','60','62','64','67','68');
        if ( !in_array($oDadosTurma->etapa_ensino_turma, $aEtapaEnsino) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Valor inválido para a etapa de ensino.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }
      }

      /**
       * Validações executadas quando a mediação didatico pedagogica for igual a 1 - Presencial
       */
      if ( $oDadosTurma->mediacao_didatico_pedagogica == 1 ) {

        /**
         * Valida os minutos das horas iniciais e finais.
         */
        $aMinutosValidos = array('00', '05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');

        if ( !in_array($oDadosTurma->horario_turma_horario_inicial_minuto, $aMinutosValidos) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Valor inválido para minuto inicial da turma.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }

        if ( !in_array($oDadosTurma->horario_turma_horario_final_minuto, $aMinutosValidos) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Valor inválido para minuto final da turma.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }

        /**
         * Valida se ao menos um dia da semana foi informado.
         * @var array
         */
        $aDiasSemana = array(
          $oDadosTurma->dia_semana_domingo,
          $oDadosTurma->dia_semana_segunda,
          $oDadosTurma->dia_semana_terca,
          $oDadosTurma->dia_semana_quarta,
          $oDadosTurma->dia_semana_quinta,
          $oDadosTurma->dia_semana_sexta,
          $oDadosTurma->dia_semana_sabado
        );

        if ( !in_array(1, $aDiasSemana) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Ao menos um dia da semana deve ser informado.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }

        /**
         * Verifica se o campo dependencia administrativa é igual a Estadual ou Municipal
         */
        if (   $oDadosEscola->registro00->dependencia_administrativa != 2
            && $oDadosEscola->registro00->dependencia_administrativa != 3
           ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "O campo Dependência Administrativa deve ser igual a Estadual ou Municipal.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }

        /**
         * Validações referentes a linha 19 - Turma participante do Programa Mais Educação/Ensino Médio
         */

        if ( $oDadosTurma->tipo_atendimento == 1 || ($oDadosTurma->tipo_atendimento == 5 && $oDadosTurma->turma_participante_mais_educacao_ensino_medio_inov == 1) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Campo Tipo de Atendimento não pode receber os valores: Classe hospitalar e Atendimento Educacional Especializado (AEE).";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }

        /**
         * Realiza validações para Turma Participante do Programa Mais Educação/Ensino Médio Inovador não deve ser informado
         */
        if ( $oDadosTurma->tipo_atendimento != 4 ) {

          $aModalidade  = array('1','2','4');
          $aEtapaEnsino = array('4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21',
                                '22','23','24','25','26','27','28','29','35','36','37','38','41');
          if ( $oDadosTurma->turma_participante_mais_educacao_ensino_medio_inov == 1 &&
              ( !in_array($oDadosTurma->modalidade_turma, $aModalidade) &&
                !in_array($oDadosTurma->etapa_ensino_turma, $aEtapaEnsino) ) ) {

            $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
            $sMsgErro .= "Campo Turma Participante do Programa Mais Educação/Ensino Médio Inovador não deve ser informado.";
            $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
            $lDadosValidos = false;
          }
        }
      }

     /**
      * Validações referente ao Código do Tipo de Atividade Complementar
      */
      $aTipoAtividade = array(
        $oDadosTurma->codigo_tipo_atividade_complementar_1,
        $oDadosTurma->codigo_tipo_atividade_complementar_2,
        $oDadosTurma->codigo_tipo_atividade_complementar_3,
        $oDadosTurma->codigo_tipo_atividade_complementar_4,
        $oDadosTurma->codigo_tipo_atividade_complementar_5,
        $oDadosTurma->codigo_tipo_atividade_complementar_6
      );

      $aTipoAtividade = array_filter($aTipoAtividade);

      if ( $oDadosTurma->tipo_atendimento == 4 ) {

        if ( empty($aTipoAtividade) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Ao menos um código do Tipo de Atividade deve ser informado quando Tipo de Atendimento for igual a Atividade Complementar.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        } else {

          $aTipoAtividade = array_count_values($aTipoAtividade);
          $sMensagemErro  = '';

          foreach ( $aTipoAtividade as $iCodigoAtividade => $iOcorrencia ) {

            if ( $iOcorrencia > 1 ) {

              $sMensagemErro .= "Código da Atividade {$iCodigoAtividade} informado {$iOcorrencia} vezes.";
              $lDadosValidos = false;
            }
          }
          if ( !empty($sMensagemErro) ) {
            $oExportacaoCenso->logErro($sMensagemErro, ExportacaoCensoBase::LOG_TURMA);
          }
        }
      } else {

        if ( !empty( $aTipoAtividade ) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Campo código do Tipo de Atividade não deve ser informado quando Tipo de Atendimento for diferente de Atividade Complementar.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }
      }

      /**
       * Valida se a escola fornece Atividade Complementar e se há turmas informadas com este tipo de atividade
       */
      if ( $oDadosEscola->registro10->atividade_complementar == 0 && $oDadosTurma->tipo_atendimento == 4 ) {

        $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
        $sMsgErro .= "Tipo de atendimento não pode ser Atividade Complementar quando a Escola não à oferece.";
        $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
        $lDadosValidos = false;
      }

      /**
       * Valida se a escola fornece Atendimento Educacional Especializado (AEE) e se há turmas informadas com este tipo de atividade
       */
      if ( $oDadosEscola->registro10->atendimento_educacional_especializado == 0 && $oDadosTurma->tipo_atendimento == 5 ) {

        $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
        $sMsgErro .= "Tipo de atendimento não pode ser Atendimento Educacional Especializado (AEE) quando a Escola não à oferece.";
        $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
        $lDadosValidos = false;
      }

      if ( $oDadosTurma->tipo_atendimento == 4 || $oDadosTurma->tipo_atendimento == 5 ) {

        $sWhereTurmaAcMatricula  = " ed269_i_turmaac = {$oDadosTurma->codigo_turma_entidade_escola} ";
        $sWhereTurmaAcMatricula .= " AND ed269_d_data <= '{$oExportacaoCenso->getDataCenso()}' ";
        $sSqlTurmaAcMatricula    = $oDaoTurmaAcMatricula->sql_query("","1","ed268_c_descr",$sWhereTurmaAcMatricula);
        $sRsTurmaAcMatricula     = $oDaoTurmaAcMatricula->sql_record($sSqlTurmaAcMatricula);

        if ( $oDaoTurmaAcMatricula->numrows == 0 ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= " Não possui nenhum aluno matriculado. ";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }
      }
      /**
       * Validações referentes a Atividade do Atendimento Educacional Especializado (AEE)
       */
      if ( $oDadosTurma->tipo_atendimento == 5 ) {

        $aAtividadeEducacionalEspecializada = array(
          $oDadosTurma->aee_ensino_sistema_braille,
          $oDadosTurma->aee_ensino_uso_recursos_opticos_nao_opticos,
          $oDadosTurma->aee_estrategias_desenvolvimento_processos_mentais,
          $oDadosTurma->aee_tecnicas_orientacao_mobilidade,
          $oDadosTurma->aee_ensino_lingua_brasileira_sinais_libras,
          $oDadosTurma->aee_ensino_comunicacao_alternativa_aumentativa,
          $oDadosTurma->aee_estrategia_enriquecimento_curricular,
          $oDadosTurma->aee_ensino_uso_soroban,
          $oDadosTurma->aee_ensino_usabilidade_funcionalidades_informatica,
          $oDadosTurma->aee_ensino_lingua_portuguesa_modalidade_escrita,
          $oDadosTurma->aee_estrategias_autonomia_ambiente_escolar
        );

        if ( !in_array(1, $aAtividadeEducacionalEspecializada) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Ao menos uma Atividade Educacional Especializada (AEE) deve ser informada.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }
      }

      /**
       * Valida se a modalidade da turma é compatível com a modalidade da escola
       */
      if( $oDadosTurma->tipo_atendimento != 4 && $oDadosTurma->tipo_atendimento != 5 ) {

        if (   ($oDadosTurma->modalidade_turma == 1 && $oDadosEscola->registro10->modalidade_ensino_regular != 1)
            || ($oDadosTurma->modalidade_turma == 2 && $oDadosEscola->registro10->modalidade_educacao_especial_modalidade_substutiva != 1)
            || ($oDadosTurma->modalidade_turma == 3 && $oDadosEscola->registro10->modalidade_educacao_jovens_adultos != 1)
            || ($oDadosTurma->modalidade_turma == 4 && $oDadosEscola->registro10->modalidade_educacao_profissional != 1)
           ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Modalidade da Turma deve ser compatível com a Modalidade da Escola.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }

        /**
         * Valida se a etapa de ensino corresponde ao tipo de atendimento especifico.
         */
        if ( $oDadosTurma->tipo_atendimento == 1 ) {

          $aEtapaEnsino = array( '1', '2', '3', '56' );

          if ( in_array( $oDadosTurma->etapa_ensino_turma, $aEtapaEnsino) ) {

            $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
            $sMsgErro .= "Etapa de Ensino inválida para o Tipo de Atendimento informado.";
            $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
            $lDadosValidos = false;
          }
        }
      }

      /**
       * Valida se o codigo do curso tecnico inormado corresponde a etapa de ensino correta.
       */
      if ( !empty( $oDadosTurma->codigo_curso_educacao_profissional ) ) {

        $aEtapaEnsino = array( '30', '31', '32', '33', '34', '39', '40', '64', '74' );
        if ( !in_array($oDadosTurma->etapa_ensino_turma, $aEtapaEnsino) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Código do Curso Técnico inválido para a Etapa de Ensino informada.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }
      }

      /**
       *
       */

      $aEtapaEnsino = array( '1', '2', '3', '65' );
      $aDisciplinas = array(
        $oDadosTurma->disciplinas_turma_fisica,
        $oDadosTurma->disciplinas_turma_matematica,
        $oDadosTurma->disciplinas_turma_biologia,
        $oDadosTurma->disciplinas_turma_ciencias,
        $oDadosTurma->disciplinas_turma_lingua_literatura_portuguesa,
        $oDadosTurma->disciplinas_lingua_literatura_estrangeira_inglesa,
        $oDadosTurma->disciplinas_lingua_literatura_estrangeira_espanhol,
        $oDadosTurma->disciplinas_lingua_literatura_estrangeira_outra,
        $oDadosTurma->disciplinas_turma_artes,
        $oDadosTurma->disciplinas_turma_educacao_fisica,
        $oDadosTurma->disciplinas_turma_historia,
        $oDadosTurma->disciplinas_turma_geografia,
        $oDadosTurma->disciplinas_turma_filosofia,
        $oDadosTurma->disciplinas_turma_informatica_computacao,
        $oDadosTurma->disciplinas_turma_disciplinas_profissionalizantes,
        $oDadosTurma->disciplinas_turma_voltadas_atendimento_necessidade,
        $oDadosTurma->disciplinas_turma_voltadas_diversidade_sociocultur,
        $oDadosTurma->disciplinas_turma_libras,
        $oDadosTurma->disciplinas_turma_disciplinas_pedagogicas,
        $oDadosTurma->disciplinas_turma_ensino_religioso,
        $oDadosTurma->disciplinas_turma_lingua_indigena,
        $oDadosTurma->disciplinas_turma_estudos_sociais,
        $oDadosTurma->disciplinas_turma_sociologia,
        $oDadosTurma->disciplinas_lingua_literatura_estrangeira_frances,
        $oDadosTurma->disciplinas_turma_outras
      );

      /**
       * Validado para quando tipo de ensino for infantil não permitir informar disciplinas
       * OBS.:Utilizamos a função strlen para que as possições contendo 0 fossem mantidas
       */
      $aDisciplinasPreenchidas = array_filter( $aDisciplinas, 'strlen' );

      if ( ($oDadosTurma->tipo_atendimento == 4 || $oDadosTurma->tipo_atendimento == 5)
           || in_array($oDadosTurma->etapa_ensino_turma, $aEtapaEnsino)
         ) {

        if ( !empty($aDisciplinasPreenchidas) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Tipo de Atendimento ou Etapa do Ensino não permitem disciplinas.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }
      } else {

        if ( count($aDisciplinas) != count($aDisciplinasPreenchidas) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Todos os campos referentes as Disciplinas devem ser informados.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        } else {

          $aDisciplinasPreenchidasCount = array_count_values($aDisciplinasPreenchidas);

          if ( in_array(2, $aDisciplinasPreenchidasCount) ) {

            if ( $oDadosTurma->mediacao_didatico_pedagogica == 3 ) {

              $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
              $sMsgErro .= "Quando turma oferece disciplinas sem docente a Mediação didático-pedagógica deve ser";
              $sMsgErro .= " diferente 3 - Educação a Distância.";
              $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
              $lDadosValidos = false;
            }
          }
        }
      }

      /**
       * Valida se a Turma sem profissional escolar possui vinculo com docente...
       */
      $aDisciplinasPreenchidasCount = array_count_values($aDisciplinasPreenchidas);

      /**
       * ...se o valor definido esta setado como turma sem docente e se há docente vinculado a esta turma
       */
      if ( $oDadosTurma->turma_sem_docente == 1 && in_array(1, $aDisciplinasPreenchidasCount)) {

        if ( in_array($oDadosTurma->codigo_turma_entidade_escola, $aTurmaSemProfissional) ) {

          $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
          $sMsgErro .= "Para turma sem profissional, não pode haver turma sem docente vinculado.";
          $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
          $lDadosValidos = false;
        }
      }

      /**
       * ...se o valor definido esta como turma com docente e se há pelo menos 1 docente vinculado a turma
       */
      if ( $oDadosTurma->turma_sem_docente === 0 && !in_array($oDadosTurma->codigo_turma_entidade_escola, $aTurmaSemProfissional)) {

        $sMsgErro  = "Turma {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma}: ";
        $sMsgErro .= "Turma deve possuir docente vinculado.";
        $oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_TURMA);
        $lDadosValidos = false;
      }



    }

    return $lDadosValidos;
  }
}