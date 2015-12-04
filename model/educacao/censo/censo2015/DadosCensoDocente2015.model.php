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

define( "MENSAGENS_DADOSCENSODOCENTE2015", "educacao.escola.DadosCensoDocente2015." );

class DadosCensoDocente2015 extends DadosCensoDocente {

  private   $sDadosDocente     = '';
  private   $oExportacaoCenso  = '';
  protected $aEtapasCensoTurma = array(1, 2, 3, 65);

  /**
   * Valida os dados do arquivo
   * @param IExportacaoCenso $oExportacaoCenso  Importacao do censo
   * @return boolean
   */
  public function validarDados( IExportacaoCenso $oExportacaoCenso ) {

    $lDadosValidos          = true;
    $this->oExportacaoCenso = $oExportacaoCenso;
    $aDadosDocente          = $oExportacaoCenso->getDadosProcessadosDocente();

    foreach( $aDadosDocente as $oDadosCensoDocente ) {

      $this->sDadosDocente  = $oDadosCensoDocente->registro30->numcgm . " - " . $oDadosCensoDocente->registro30->nome_completo;
      $this->sDadosDocente .= " - Data de Nascimento: " . $oDadosCensoDocente->registro30->data_nascimento;

      $oRegistro30 = $oDadosCensoDocente->registro30;
      $oRegistro40 = $oDadosCensoDocente->registro40;
      $oRegistro50 = $oDadosCensoDocente->registro50;
      $aRegistro51 = $oDadosCensoDocente->registro51;

      if( !DadosCensoDocente2015::validacoesRegistro30( $oRegistro30 ) ) {
        $lDadosValidos = false;
      }

      if( !DadosCensoDocente2015::validacoesRegistro40( $oRegistro30, $oRegistro40 ) ) {
        $lDadosValidos = false;
      }

      if( !DadosCensoDocente2015::validacoesRegistro50( $oRegistro50 ) ) {
        $lDadosValidos = false;
      }

      if( !DadosCensoDocente2015::validacoesRegistro51( $oRegistro30, $aRegistro51 ) ) {
        $lDadosValidos = false;
      }
    }

    return $lDadosValidos;
  }

  /**
   * Validações referentes ao Registro 30
   * @param $oRegistro30
   * @return bool
   * @throws Exception
   */
  public function validacoesRegistro30( $oRegistro30 ) {

    $lDadosValidos = true;

    if( $oRegistro30->codigo_docente_entidade_escola == '' ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "Códido do docente na escola não informado.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    $sNome = trim( $oRegistro30->nome_completo );
    if( !DBString::isNomeValido( $sNome, DBString::NOME_REGRA_2 ) ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "O nome deve ser composto de nome e sobrenome.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    if( !DBString::isNomeValido( $sNome, DBString::NOME_REGRA_4 ) ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "O nome não deve conter 4 letras repetidas em sequência.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    $sEmail = trim( $oRegistro30->email );

    if( !empty( $sEmail ) ) {

      if( !DBString::validarTamanhoMaximo( $sEmail, 100 ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "O email excede o limite de caracteres permitidos( 100 ).";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }

      if( !DBString::isEmail( $sEmail ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "O email não é válido - Aceitos somente os seguintes caracteres entre parentêses:\n";
        $sMsgErro .= "(ABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789 @ . - _). Deve possuir os caracteres \"@\" e \".\", ";
        $sMsgErro .= "e caracteres alfanuméricos antes e depois de cada.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }
    }

    if( empty( $oRegistro30->data_nascimento ) ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "Data de nascimento não informada.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    if( !empty( $oRegistro30->data_nascimento ) ) {

      $oDataNascimento = new DBDate( $oRegistro30->data_nascimento );
      $sDataAtual      = date( 'd/m/Y' );
      $oDataAtual      = new DBDate( $sDataAtual );
      $iIntervalo      = DBDate::calculaIntervaloEntreDatas( $oDataAtual, $oDataNascimento, 'y' );

      if( $iIntervalo < 14 || $iIntervalo > 95 ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "Idade do docente não pode ser menor que 14 ou maior que 95 anos.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }
    }

    if( !empty( $oRegistro30->nome_completo_mae ) ) {

      $sNomeMae = trim( $oRegistro30->nome_completo_mae );
      if( !DBString::isNomeValido( $sNomeMae, DBString::NOME_REGRA_3 ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "O nome da mãe deve ser composto de nome e sobrenome.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }

      if( !DBString::isNomeValido( $sNomeMae, DBString::NOME_REGRA_4 ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "O nome da mãe não deve conter 4 letras repetidas em sequência.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }
    }

    if(    $oRegistro30->pais_origem == 76
        && $oRegistro30->nacionalidade_docente != 1
        && $oRegistro30->nacionalidade_docente != 2 ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "País de origem deve ser BRASIL quando selecionada nacionalidade: \n";
      $sMsgErro .= " - Brasileira;\n - Brasileira nascido no Exterior.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    if (    $oRegistro30->nacionalidade_docente == 3
         && $oRegistro30->pais_origem == 76
       ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "País de origem deve diferente de BRASIL quando nacionalidade:\n";
      $sMsgErro .= " - Estrangeira.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    if( $oRegistro30->nacionalidade_docente == 1 ) {

      if( empty( $oRegistro30->uf_nascimento ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "País de origem informado como BRASIL. É necessário informar a UF de nascimento.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }

      if( empty( $oRegistro30->municipio_nascimento ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "País de origem informado como BRASIL. É necessário informar o Município de nascimento.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }
    }

    /**
     * Chamado método para validações especifícas referentes a Necessidades Especiais
     */
    if( !DadosCensoDocente2015::validacoesNecessidadesEspeciais( $oRegistro30 ) ) {
      $lDadosValidos = false;
    }

    return $lDadosValidos;
  }

  /**
   * Validações referentes ao Registro 40
   * @param $oRegistro30
   * @param $oRegistro40
   * @return bool
   */
  public function validacoesRegistro40( $oRegistro30, $oRegistro40 ) {

    $lDadosValidos = true;

    if( $oRegistro30->nacionalidade_docente != 3 ) {

      if( empty( $oRegistro40->numero_cpf ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "CPF não informado.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }

      if( !empty( $oRegistro40->numero_cpf ) && !DBString::isCPF( $oRegistro40->numero_cpf ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "CPF informado não é válido.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }
    }

    /**
     * Chamado método responsável pelas validações referentes ao endereço residencial
     */
    if( !DadosCensoDocente2015::validacoesEnderecoResidencial( $oRegistro40 ) ) {
      $lDadosValidos = false;
    }

    return $lDadosValidos;
  }

  /**
   * Validações referentes ao Registro 50
   * @param $oRegistro50
   * @return bool
   */
  public function validacoesRegistro50( $oRegistro50 ) {

    $lDadosValidos = true;

    if( $oRegistro50->escolaridade == 6 ) {

      if(    $oRegistro50->situacao_curso_superior_1         === ''
          || $oRegistro50->codigo_curso_superior_1           === ''
          || $oRegistro50->tipo_instituicao_curso_superior_1 === ''
          || $oRegistro50->instituicao_curso_superior_1      === ''
        ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "Informada escolaridade Superior, sendo obrigatório informar ao menos uma formação superior.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }
    }

    if(    $oRegistro50->especifico_educacao_especial                      == 0
        && $oRegistro50->nenhum 											                     == 0
        && $oRegistro50->outros 											                     == 0
        && $oRegistro50->educ_relacoes_etnicorraciais_his_cult_afro_brasil == 0
        && $oRegistro50->direitos_crianca_adolescente 				             == 0
        && $oRegistro50->genero_diversidade_sexual 					               == 0
        && $oRegistro50->especifico_educacao_direitos_humanos              == 0
        && $oRegistro50->especifico_educacao_ambiental 			               == 0
        && $oRegistro50->especifico_educacao_campo 						             == 0
        && $oRegistro50->especifico_educacao_indigena 				             == 0
        && $oRegistro50->especifico_eja 											             == 0
        && $oRegistro50->especifico_ensino_medio 							             == 0
        && $oRegistro50->especifico_anos_finais_ensino_fundamental         == 0
        && $oRegistro50->especifico_anos_iniciais_ensino_fundamental       == 0
        && $oRegistro50->especifico_pre_escola_4_5_anos                    == 0
        && $oRegistro50->especifico_creche_0_3_anos 		                   == 0
      ) {

      $sMsgErro      = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro     .= "É necessário selecionar ao menos uma opção entre as existentes para Outros Cursos";
      $sMsgErro     .= " (Recursos Humanos -> Formação -> Outros Dados -> Outros Cursos)";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    if(    $oRegistro50->codigo_curso_superior_1 != ""
        && $oRegistro50->codigo_curso_superior_2 == ""
        && $oRegistro50->codigo_curso_superior_3 == ""
      ) {

      if( $oRegistro50->situacao_curso_superior_1 == 2 ) {

        if(    $oRegistro50->pos_graduacao                != ""
            || $oRegistro50->pos_graduacao_doutorado      != ""
            || $oRegistro50->pos_graduacao_mestrado       != ""
            || $oRegistro50->pos_graduacao_especializacao != ""
           ) {

          $sMsgErro      = "Docente CGM {$this->sDadosDocente}: \n";
          $sMsgErro     .= "Docente possui apenas uma graduação, a qual está em andamento. Logo, não deve ser";
          $sMsgErro     .= " selecionada nenhuma opção referente a Pós-Graduação.";
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
          $lDadosValidos = false;
        }
      }

      if(    $oRegistro50->situacao_curso_superior_1    == 1
          && empty( $oRegistro50->pos_graduacao )
          && empty( $oRegistro50->pos_graduacao_doutorado )
          && empty( $oRegistro50->pos_graduacao_mestrado )
          && empty( $oRegistro50->pos_graduacao_especializacao )
        ) {

        $sMsgErro      = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro     .= "É necessário selecionar ao menos uma opção entre as existentes para Outros Cursos referentes a Pós-Graduação";
        $sMsgErro     .= " (Recursos Humanos -> Formação -> Outros Dados -> Outros Cursos)";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }

      if(    $oRegistro50->situacao_curso_superior_1 == 1
          || $oRegistro50->codigo_curso_superior_2   == 1
          || $oRegistro50->codigo_curso_superior_3   == 1
        ) {

        if (    $oRegistro50->pos_graduacao == 1
             && (    $oRegistro50->pos_graduacao_doutorado      == 1
                  || $oRegistro50->pos_graduacao_mestrado       == 1
                  || $oRegistro50->pos_graduacao_especializacao == 1
                )
          ) {

          $sMsgErro      = "Docente CGM {$this->sDadosDocente}: \n";
          $sMsgErro     .= " Quando informado \"Nenhum\" a \"Pós-Graduação\" não pode-se marcar outra opção. ";
          $sMsgErro     .= " (Recursos Humanos -> Formação -> Outros Dados -> Outros Cursos)";
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
          $lDadosValidos = false;
        }

        if(    $oRegistro50->nenhum == 1
            && (    $oRegistro50->especifico_educacao_especial                      == 1
                 || $oRegistro50->outros                                            == 1
                 || $oRegistro50->educ_relacoes_etnicorraciais_his_cult_afro_brasil == 1
                 || $oRegistro50->direitos_crianca_adolescente                      == 1
                 || $oRegistro50->genero_diversidade_sexual                         == 1
                 || $oRegistro50->especifico_educacao_direitos_humanos              == 1
                 || $oRegistro50->especifico_educacao_ambiental                     == 1
                 || $oRegistro50->especifico_educacao_campo                         == 1
                 || $oRegistro50->especifico_educacao_indigena                      == 1
                 || $oRegistro50->especifico_eja                                    == 1
                 || $oRegistro50->especifico_ensino_medio                           == 1
                 || $oRegistro50->especifico_anos_finais_ensino_fundamental         == 1
                 || $oRegistro50->especifico_anos_iniciais_ensino_fundamental       == 1
                 || $oRegistro50->especifico_pre_escola_4_5_anos                    == 1
                 || $oRegistro50->especifico_creche_0_3_anos                        == 1
               )
          ) {

          $sMsgErro      = "Docente CGM {$this->sDadosDocente}: \n";
          $sMsgErro     .= " Quando informado \"Nenhum\" a \"Outros Cursos\" não pode-se marcar outra opção. ";
          $sMsgErro     .= " (Recursos Humanos -> Formação -> Outros Dados -> Outros Cursos)";
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
          $lDadosValidos = false;
        }
      }
    }

    $aOutrosCursos = array(
      $oRegistro50->especifico_creche_0_3_anos,
      $oRegistro50->especifico_pre_escola_4_5_anos,
      $oRegistro50->especifico_anos_iniciais_ensino_fundamental,
      $oRegistro50->especifico_anos_finais_ensino_fundamental,
      $oRegistro50->especifico_ensino_medio,
      $oRegistro50->especifico_eja,
      $oRegistro50->especifico_educacao_indigena,
      $oRegistro50->especifico_educacao_campo,
      $oRegistro50->especifico_educacao_ambiental,
      $oRegistro50->especifico_educacao_direitos_humanos,
      $oRegistro50->genero_diversidade_sexual,
      $oRegistro50->direitos_crianca_adolescente,
      $oRegistro50->educ_relacoes_etnicorraciais_his_cult_afro_brasil,
      $oRegistro50->outros
    );

    if ( $oRegistro50->nenhum == 1 ) {

      if ( in_array(1, $aOutrosCursos) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "Caso selecionado a opção 'Nenhum' em Outros Cursos, as demais opções não podem estar selecionadas.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }
    }

    return $lDadosValidos;
  }

  /**
   * Validações referentes ao Registro 51
   * @param $oRegistro30
   * @param $aRegistro51
   * @return bool
   */
  public function validacoesRegistro51( $oRegistro30, $aRegistro51 ) {

    $lDadosValidos = true;
    $aDadosDaTurma = $this->oExportacaoCenso->getDadosProcessadosTurma();

    if( count( $aRegistro51 ) == 0 ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "Docente possui horário de regência, porém não está vinculado a nenhuma turma.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    foreach( $aRegistro51 as $oRegistro51 ) {

      if( $oRegistro51->identificacao_unica_inep != $oRegistro30->identificacao_unica_docente_inep ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "Informado códigos INEP diferentes para o docente.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }

      if( $oRegistro51->codigo_docente_entidade_escola != $oRegistro30->codigo_docente_entidade_escola ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "Informado códigos do sistema diferentes para o docente.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }

      foreach( $aDadosDaTurma as $oDadosTurma ) {

        if( $oRegistro51->codigo_turma_entidade_escola != $oDadosTurma->codigo_turma_entidade_escola ) {
          continue;
        }

        /**
         * 1 - Docente
         * 2 - Auxiliar/Assistente Educacional
         * 3 - Profissional/Monitor de Atividade Complementar
         * 4 - Tradutor Intérprete de LIBRAS
         */
        $aFuncoesValidacao = array( 1, 2, 3, 4 );
        if(    in_array( $oRegistro51->funcao_exerce_escola_turma, $aFuncoesValidacao )
            && $oDadosTurma->mediacao_didatico_pedagogica == 3 ) {

          $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
          $sMsgErro .= "Turma [ {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma} ] a qual";
          $sMsgErro .= " o docente possui vínculo, possui mediação didático-pedagógica do tipo Educação a Distância.";
          $sMsgErro .= " Funções exercidas permitidas neste caso são:\n";
          $sMsgErro .= " Docente Titular ou Docente Tutor";
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
          $lDadosValidos = false;
        }

        if(    !in_array( $oRegistro51->funcao_exerce_escola_turma, $aFuncoesValidacao )
            && $oDadosTurma->mediacao_didatico_pedagogica != 3 ) {

          $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
          $sMsgErro .= "Turma [ {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma} ] a qual";
          $sMsgErro .= " o docente possui vínculo, possui mediação didático-pedagógica do tipo Presencial ou .";
          $sMsgErro .= " Semipresencial. Funções exercidas não permitidas neste caso são:\n";
          $sMsgErro .= " Docente Titular ou Docente Tutor";
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
          $lDadosValidos = false;
        }

        if( $oRegistro51->funcao_exerce_escola_turma == 3 && $oDadosTurma->tipo_atendimento != 4 ) {

          $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
          $sMsgErro .= "Docente com função Profissional/Monitor de Atividade Complementar só pode ser vinculado";
          $sMsgErro .= " a uma turma de Atividade Complementar.";
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
          $lDadosValidos = false;
        }

        $aFuncoesDocente = array( 1, 5, 6 );
        if(    !in_array( $oRegistro51->funcao_exerce_escola_turma, $aFuncoesDocente )
            && empty( $oRegistro51->situacao_funcional_contratacao_vinculo ) ) {

          $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
          $sMsgErro .= "Obrigatório informar o Regime de Contratação/Tipo de Vínculo para profissionais com função";
          $sMsgErro .= " de Docente.";
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
          $lDadosValidos = false;
        }

        $aDisciplinasDocente = array(
          $oRegistro51->codigo_disciplina_1,
          $oRegistro51->codigo_disciplina_2,
          $oRegistro51->codigo_disciplina_3,
          $oRegistro51->codigo_disciplina_4,
          $oRegistro51->codigo_disciplina_5,
          $oRegistro51->codigo_disciplina_6,
          $oRegistro51->codigo_disciplina_7,
          $oRegistro51->codigo_disciplina_8,
          $oRegistro51->codigo_disciplina_9,
          $oRegistro51->codigo_disciplina_10,
          $oRegistro51->codigo_disciplina_11,
          $oRegistro51->codigo_disciplina_12,
          $oRegistro51->codigo_disciplina_13
        );

        $aControleDisciplinasDocente = array_count_values( $aDisciplinasDocente );

        if ( in_array( $oRegistro51->funcao_exerce_escola_turma, $aFuncoesDocente )) {

          /**
           * 4 - Atividade complementar
           * 5 - Atendimento Educacional Especializado( AEE )
           */
          $aTipoAtendimentoACAEE = array( 4, 5 );
          if (    $oRegistro51->funcao_exerce_escola_turma == 2
              && in_array( $oDadosTurma->tipo_atendimento, $aTipoAtendimentoACAEE ) ) {

            $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
            $sMsgErro .= "Turma [ {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma} ] a qual";
            $sMsgErro .= " o docente possui vínculo, é do tipo Atividade Complementar/AEE. Função exercida não";
            $sMsgErro .= " permitidas neste caso:\nAuxiliar/Assistente Educacional";
            $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
            $lDadosValidos = false;
          }

          /**
           * Validações para casos em que a turma que o docente encontra-se vinculado, não trata-se de turma AEE/AC
           */
          if( !in_array( $oDadosTurma->tipo_atendimento, $aTipoAtendimentoACAEE ) ) {

            $aEtapaEnsino = array( 1, 2, 3, 65 );
            if (    !in_array($oDadosTurma->etapa_ensino_turma, $aEtapaEnsino)
                 && isset( $aControleDisciplinasDocente[''] )
                 && count( $aControleDisciplinasDocente ) == 1
               ) {

              $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
              $sMsgErro .= "Turma [ {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma} ]: \n";
              $sMsgErro .= "Docente encontra-se vinculado a turma, porém não foi informada a disciplina.";
              $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
              $lDadosValidos = false;
            }

            $oTurma    = new Turma($oDadosTurma->codigo_turma_entidade_escola);
            $aRegencia = $oTurma->getDisciplinas();
            $aDisciplinaRegencia = array();

            foreach( $aRegencia as $oRegencia ) {

              $oDisciplinaRegencia   = $oRegencia->getDisciplina();
              $aDisciplinaRegencia[] = $oDisciplinaRegencia->getCodigoCensoDisciplina();
            }

            foreach( $aDisciplinasDocente as $iChave => $iDisciplinaDocente ) {

              if (  !empty($iDisciplinaDocente) && !in_array($iDisciplinaDocente, $aDisciplinaRegencia)) {

                $oDisciplina = DisciplinaRepository::getDisciplinaByCodigoCenso( $iDisciplinaDocente );
                $sMsgErro    = "Docente CGM {$this->sDadosDocente}: \n";
                $sMsgErro   .= "Turma [ {$oDadosTurma->codigo_turma_entidade_escola} - {$oDadosTurma->nome_turma} ].";
                $sMsgErro   .= " Disciplina {$oDisciplina->getNomeDisciplina()} não está vinculada a turma";
                $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
                $lDadosValidos = false;
              }
            }
          }
        }
      }
    }

    return $lDadosValidos;
  }

  /**
   * Método responsável por realizar as validações referentes as Necessidades Especiais
   * @param $oRegistro30
   * @return bool
   */
  public function validacoesNecessidadesEspeciais( $oRegistro30 ) {

    $lDadosValidos = true;

    /**
     * Array para validar se ao selecionar Cegueira, outros tipos de deficiencia não permitidas foram marcadas
     */
    $aDeficienciaCegueira = array(
                                   $oRegistro30->tipos_deficiencia_baixa_visao,
                                   $oRegistro30->tipos_deficiencia_surdez,
                                   $oRegistro30->tipos_deficiencia_surdocegueira
                                 );

    if( $oRegistro30->tipos_deficiencia_cegueira == 1 && in_array(1, $aDeficienciaCegueira) ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "Ao informar necessidade Cegueira, os seguintes tipos de deficiência não podem ser informados:\n";
      $sMsgErro .= "Baixa Visão, Surdez e Surdocegueira.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    /**
     * Array para validar se ao selecionar Baixa Visão, outros tipos de deficiencia não permitidas foram marcadas
     */
    $aDeficienciaBaixaVisao = array(
                                     $oRegistro30->tipos_deficiencia_cegueira,
                                     $oRegistro30->tipos_deficiencia_surdocegueira
                                   );

    if( $oRegistro30->tipos_deficiencia_baixa_visao == 1 && in_array(1, $aDeficienciaBaixaVisao) ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "Ao informar necessidade Baixa Visão, os seguintes tipos de deficiência não podem ser informados:\n";
      $sMsgErro .= "Cegueira e Surdocegueira.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    /**
     * Array para validar se ao selecionar Surdez, outros tipos de deficiencia não permitidas foram marcadas
     */
    $aDeficienciaSurdez = array(
                                 $oRegistro30->tipos_deficiencia_cegueira,
                                 $oRegistro30->tipos_deficiencia_auditiva,
                                 $oRegistro30->tipos_deficiencia_surdocegueira
                               );



    if( $oRegistro30->tipos_deficiencia_surdez == 1 && in_array(1, $aDeficienciaSurdez) ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "Ao informar necessidade Surdez, os seguintes tipos de deficiência não podem ser informados:\n";
      $sMsgErro .= "Cegueira, Deficiência Auditiva e Surdocegueira.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    /**
     * Array para validar se ao selecionar Deficiência Auditiva, outros tipos de deficiência não permitidas foram marcadas
     */
    $aDeficienciaDeficienciaAuditiva = array(
                                              $oRegistro30->tipos_deficiencia_surdez,
                                              $oRegistro30->tipos_deficiencia_surdocegueira
                                            );

    if( $oRegistro30->tipos_deficiencia_auditiva == 1 && in_array(1, $aDeficienciaDeficienciaAuditiva) ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "Ao informar necessidade Deficiência Auditiva, os seguintes tipos de deficiência não podem ser informados:\n";
      $sMsgErro .= "Surdez e Surdocegueira.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    /**
     * Array para validar se ao selecionar Surdocegueira, outros tipos de deficiência não permitidas foram marcadas
     */
    $aDeficienciaSurdocegueira = array(
                                        $oRegistro30->tipos_deficiencia_cegueira,
                                        $oRegistro30->tipos_deficiencia_baixa_visao,
                                        $oRegistro30->tipos_deficiencia_surdez,
                                        $oRegistro30->tipos_deficiencia_auditiva
                                      );

    if( $oRegistro30->tipos_deficiencia_surdocegueira == 1 && in_array(1, $aDeficienciaSurdocegueira) ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "Ao informar necessidade Surdocegueira, os seguintes tipos de deficiência não podem ser informados:\n";
      $sMsgErro .= "Cegueira, Baixa Visão, Surdez e Deficiência Auditiva.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    return $lDadosValidos;
  }

  /**
   * Método responsável por realizar as validações referentes aos dados de endereço residencial
   * @param $oRegistro40
   * @return bool
   */
  public function validacoesEnderecoResidencial( $oRegistro40 ) {

    $lDadosValidos = true;

    if( !empty( $oRegistro40->cep ) && !DBNumber::isInteger( $oRegistro40->cep ) ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "CEP informado não é válido.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    $aCamposEnderecoResidencial = array( 'cep', 'endereco', 'uf', 'municipio' );
    $iTotalCamposPreenchidos    = 0;

    foreach( $aCamposEnderecoResidencial as $sCamposEnderecoResidencial ) {

      if( $oRegistro40->{$sCamposEnderecoResidencial} !== '' ) {
        $iTotalCamposPreenchidos++;
      }
    }

    if( $iTotalCamposPreenchidos > 0 && $iTotalCamposPreenchidos < 4 ) {

      $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
      $sMsgErro .= "Ao informar um dos seguintes campos, todos devem ser preenchidos: CEP, Endereço, UF e Município.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
      $lDadosValidos = false;
    }

    if( $oRegistro40->endereco !== '' ) {

      if( preg_match ( '/[^a-z0-9ªº\s\-.,\/]+/i',  $oRegistro40->endereco ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "Endereço possui caracteres inválidos. Caracteres permitidos( entre parentêses ):\n";
        $sMsgErro .= "(ABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789 ./ -ªº ,)";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }

      if( !DBString::validarTamanhoMaximo( $oRegistro40->endereco, 100 ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "Endereço excede o tamanho máximo permitido( 100 caracteres ).";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }
    }

    $aDadosEnderecoResidencial   = array();

    $oDadosComplemento             = new stdClass();
    $oDadosComplemento->sCampo     = 'complemento';
    $oDadosComplemento->sValor     = $oRegistro40->complemento;
    $oDadosComplemento->iTamanho   = 20;
    $oDadosComplemento->sDescricao = 'Complemento do endereço';
    $aDadosEnderecoResidencial[]   = $oDadosComplemento;

    $oDadosNumero                = new stdClass();
    $oDadosNumero->sCampo        = 'numero_endereco';
    $oDadosNumero->sValor        = $oRegistro40->numero_endereco;
    $oDadosNumero->iTamanho      = 10;
    $oDadosNumero->sDescricao    = 'Número do endereço';
    $aDadosEnderecoResidencial[] = $oDadosNumero;

    $oDadosBairro                = new stdClass();
    $oDadosBairro->sCampo        = 'bairro';
    $oDadosBairro->sValor        = $oRegistro40->bairro;
    $oDadosBairro->iTamanho      = 50;
    $oDadosBairro->sDescricao    = 'Bairro';
    $aDadosEnderecoResidencial[] = $oDadosBairro;

    foreach( $aDadosEnderecoResidencial as $oDadosEndereco ) {

      if( $oDadosEndereco->sValor === '' ) {
        continue;
      }

      if( $iTotalCamposPreenchidos < 4 ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "{$oDadosEndereco->sDescricao} informado. É necessário informar os seguintes campos: CEP, Endereço, UF e Município.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }

      if( preg_match ( '/[^a-z0-9ªº\s\-.,\/]+/i',  $oDadosEndereco->sValor ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "{$oDadosEndereco->sDescricao} possui caracteres inválidos. Caracteres permitidos( entre parentêses ):\n";
        $sMsgErro .= "(ABCDEFGHIJKLMNOPQRSTUVWXYZ 0123456789 ./ -ªº ,)";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }

      if( !DBString::validarTamanhoMaximo( $oDadosEndereco->sValor, $oDadosEndereco->iTamanho ) ) {

        $sMsgErro  = "Docente CGM {$this->sDadosDocente}: \n";
        $sMsgErro .= "{$oDadosEndereco->sDescricao} excede o tamanho máximo permitido( {$oDadosEndereco->iTamanho} caracteres ).";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_DOCENTE);
        $lDadosValidos = false;
      }
    }

    return $lDadosValidos;
  }
}