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

/**
 *
 */
class DadosCensoAluno2015 extends DadosCensoAluno {

  private $sAluno           = '';
  private $oExportacaoCenso = null;

  public function validarDados(IExportacaoCenso $oExportacaoCenso) {

    $lValidou               = true;
    $this->oExportacaoCenso = $oExportacaoCenso;

    foreach ( $oExportacaoCenso->getDadosProcessadosAluno() as $oDadosAluno ) {

      $this->sAluno   = $oDadosAluno->registro60->codigo_aluno_entidade_escola . " - ";
      $this->sAluno  .= $oDadosAluno->registro60->nome_completo;

      if ( !DadosCensoAluno2015::validaRegistro60($oDadosAluno) ) {
        $lValidou = false;
      }

      if ( !DadosCensoAluno2015::validaRegistro70($oDadosAluno) ) {
        $lValidou = false;
      }

     if ( !DadosCensoAluno2015::validaRegistro80( $oDadosAluno ) ) {
       $lValidou = false;
     }
    }

    return $lValidou;
  }

  /**
   * Valida os dados do registro 60 do layout do censo de 2015
   * Campos não validados pois são validados na geração dos dados do aluno
   *  - tipo_registro
   *  - codigo_escola_inep
   *  - nome_completo (garante que só vem caracteres válidos)
   *  - data_nascimento
   *  - sexo
   *  - cor_raca
   *
   * @param  stdClass $oDadosAluno
   * @return boolean
   */
  public function validaRegistro60($oDadosAluno) {

    $oRegistro60 = $oDadosAluno->registro60;
    $lValidou    = true;

    if (!empty($oRegistro60->identificacao_unica_aluno) && strlen($oRegistro60->identificacao_unica_aluno) < 12) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
      $sMsgErro .= "Código INEP do aluno possui tamanho inferior a 12 dígitos.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
      $lValidou = false;
    }

    if ( !DBString::isNomeValido($oRegistro60->nome_completo, DBString::NOME_REGRA_2) ) {

      $sMsgErro  = "Nome do Aluno(a) {$this->sAluno} dever possuir nome e sobrenome.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * valida a filiação do aluno
     * 0 - Não declarado/Ignorado;
     * 1 - Pai e/ou Mãe
     */
    switch ($oRegistro60->filiacao) {

      case 0:

        if (!empty($oRegistro60->nome_mae) || !empty($oRegistro60->nome_pai) ) {

          $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
          $sMsgErro .= "Nome do pai e/ou mãe só devem ser informadados quando a filiação for igual a: Pai e/ou Mãe.";
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
          $lValidou = false;
        }

        break;
      case 1:

          if (empty($oRegistro60->nome_mae) && empty($oRegistro60->nome_pai) ) {

            $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
            $sMsgErro .= "Quando informado filiação: Pai e/ou Mãe, deve ser informado o nome da mãe ou do pai.";
            $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
            $lValidou = false;
          }

          if (!empty($oRegistro60->nome_mae) &&
              !DBString::isNomeValido($oRegistro60->nome_mae, DBString::NOME_REGRA_4) ) {

            $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
            $sMsgErro .= " nome da mãe ({$oRegistro60->nome_mae}) possui mais de 4 letras repetidas em sequência.";
            $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
            $lValidou = false;
          }

          if (!empty($oRegistro60->nome_pai) &&
              !DBString::isNomeValido($oRegistro60->nome_pai, DBString::NOME_REGRA_4) ) {

            $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
            $sMsgErro .= " nome da pai ({$oRegistro60->nome_pai}) possui mais de 4 letras repetidas em sequência.";
            $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
            $lValidou = false;
          }
        break;
    }

    if ( $oRegistro60->nacionalidade_aluno == 1 ) {

      /**
       * Linha 14: Valida se a Nascionalidade do aluno é brasileira e se a UF de Nascimento foi preenchida
       */
      if ( $oRegistro60->uf_nascimento == '' ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Obrigatório informar UF de nascimento quando a nascionalidade for Brasileira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }


      /**
       * Linha 15: Valida se a Nascionalidade do aluno é brasileira e se o Município de Nascimento foi preenchido
       */
      if ( $oRegistro60->municipio_nascimento == '' ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Obrigatório informar Município de nascimento quando a nascionalidade for Brasileira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /**
     * Linha 16: Método DadosCensoAluno::setDadosIdenficacao já valida se pelo menos alguma outra deficiência foi preenchida.
     */

    if ( $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao == 1 ) {

      /**
       * Linha 17: Quando informado Cegueira, o mesmo não deve possuir baixa visão, surdez ou surdocegueira
       */
      $aNecessidadesCegueira = array(
         $oRegistro60->tipos_defic_transtorno_baixa_visao,
         $oRegistro60->tipos_defic_transtorno_surdez,
         $oRegistro60->tipos_defic_transtorno_surdocegueira
      );

      if ( $oRegistro60->tipos_defic_transtorno_cegueira == 1 && in_array( 1, $aNecessidadesCegueira ) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Cegueira, o mesmo não deve ter informado baixa visão, surdez ou surdocegueira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 18: Quando informado baixa visão, o mesmo não deve possuir cegueira ou surdocegueira
       */
      $aNecessidadesBaixaVisao = array(
        $oRegistro60->tipos_defic_transtorno_cegueira,
        $oRegistro60->tipos_defic_transtorno_surdocegueira
      );

      if ( $oRegistro60->tipos_defic_transtorno_baixa_visao == 1 && in_array( 1, $aNecessidadesBaixaVisao ) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Baixa Visão, o mesmo não deve ter informado cegueira ou surdocegueira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 19: Quando informado Surdez, o mesmo não deve possuir cegueira, deficiência auditiva ou surdocegueira
       */
      $aNecessidadesSurdez = array(
        $oRegistro60->tipos_defic_transtorno_cegueira,
        $oRegistro60->tipos_defic_transtorno_auditiva,
        $oRegistro60->tipos_defic_transtorno_surdocegueira
      );

      if ( $oRegistro60->tipos_defic_transtorno_surdez == 1 && in_array( 1, $aNecessidadesSurdez )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Surdez, o mesmo não deve ter informado cegueira, deficiência ";
        $sMsgErro .= "auditiva ou surdocegueira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 20: Quando informado deficiência auditiva, o mesmo não deve possuir surdez ou surdocegueira
       */
      $aNecessidadesDeficienciaAuditiva = array(
        $oRegistro60->tipos_defic_transtorno_surdez,
        $oRegistro60->tipos_defic_transtorno_surdocegueira
      );

      if ( $oRegistro60->tipos_defic_transtorno_auditiva == 1 && in_array( 1, $aNecessidadesDeficienciaAuditiva ) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Deficiência Auditiva, o mesmo não deve ter informado surdez ou surdocegueira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 21: Quando informado Surdocegueira, o mesmo não deve possuir cegueira, baixa visão, surdez ou deficiência
       *           auditiva.
       */
      $aNecessidadesSurdocegueira = array(
        $oRegistro60->tipos_defic_transtorno_cegueira,
        $oRegistro60->tipos_defic_transtorno_baixa_visao,
        $oRegistro60->tipos_defic_transtorno_surdez,
        $oRegistro60->tipos_defic_transtorno_auditiva
      );

      if ( $oRegistro60->tipos_defic_transtorno_surdocegueira == 1 && in_array( 1, $aNecessidadesSurdocegueira ) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Surdocegueira, o mesmo não deve ter informado cegueira, baixa visão, surdez ";
        $sMsgErro .= "ou deficiência auditiva.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 24: Já realiza esta validação no método DadosCensoAluno::setDadosIdenficacao
       */

      /**
       * Linha 25: Quando informado Autismo Infantil, o mesmo não deve possuir síndrome de Asperger, síndrome de Rett
       *           ou transtorno desintegrativo da infância.
       */
      $aNecessidadesAutismoInfantil = array(
        $oRegistro60->tipos_defic_transtorno_def_asperger,
        $oRegistro60->tipos_defic_transtorno_def_sindrome_rett,
        $oRegistro60->tipos_defic_transtorno_desintegrativo_infancia
      );

      if ( $oRegistro60->tipos_defic_transtorno_def_autismo_infantil == 1 && in_array( 1, $aNecessidadesAutismoInfantil ) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Autismo Infantil, o mesmo não deve ter informado síndrome de Asperger, ";
        $sMsgErro .= "síndrome de Rett ou transtorno desintegrativo da infância.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 26: Quando informado Síndrome de Asperger, o mesmo não deve possuir Autismo Infantil, síndrome de Rett
       *           ou transtorno desintegrativo da infância.
       */
      $aNecessidadesAsperger = array(
        $oRegistro60->tipos_defic_transtorno_def_autismo_infantil,
        $oRegistro60->tipos_defic_transtorno_def_sindrome_rett,
        $oRegistro60->tipos_defic_transtorno_desintegrativo_infancia
      );

      if ( $oRegistro60->tipos_defic_transtorno_def_asperger == 1 && in_array( 1, $aNecessidadesAsperger ) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Síndrome de Asperger, o mesmo não deve ter informado autismo infantil, ";
        $sMsgErro .= "síndrome de Rett ou transtorno desintegrativo da infância.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /**
     * Linha 22: Quando informado Deficiência Física, tambem deve ser informado que o aluno possui Transtorno Global do
     *           Desenvolvimento ou Altas Habilidades/Superdotação.
     */
    if ( $oRegistro60->tipos_defic_transtorno_def_fisica == 1 &&
         $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao == 0 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Deficiência Física, deve ser informado que o mesmo possui transtorno global ";
        $sMsgErro .= "do desenvolvimento ou altas habilidades/superdotação.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
    }

    /**
     * Linha 23: Quando informado Deficiência Intelectual, tambem deve ser informado que o aluno possui Transtorno
     *           Global do Desenvolvimento ou Altas Habilidades/Superdotação.
     */
    if ( $oRegistro60->tipos_defic_transtorno_def_intelectual == 1 &&
         $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao == 0 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Deficiência Intelectual, deve ser informado que o mesmo possui transtorno global ";
        $sMsgErro .= "do desenvolvimento ou altas habilidades/superdotação.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
    }

    /* Validação 27 */
    if ( $oRegistro60->tipos_defic_transtorno_def_sindrome_rett == 1 ) {

      if ( $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Alunos com deficiência, transtorno global do desenvolvimento";
        $sMsgErro .= " ou altas habilidades/superdotação deve estar setado com SIM. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_def_autismo_infantil )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Autismo Infantil deve estar setado com NÃO. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_def_asperger )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Síndrome de Asperger deve estar setado com NÃO. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_desintegrativo_infancia )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Transtorno desintegrativo da infância deve estar setado com NÃO. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /* Validação 28 */
    if ( $oRegistro60->tipos_defic_transtorno_desintegrativo_infancia == 1 ) {

      if ( $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Alunos com deficiência, transtorno global do desenvolvimento";
        $sMsgErro .= " ou altas habilidades/superdotação deve estar setado com SIM. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_def_autismo_infantil )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Autismo Infantil deve estar setado com NÃO. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_def_asperger )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Síndrome de Asperger deve estar setado com NÃO. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_def_sindrome_rett )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Síndrome de Rett deve estar setado com NÃO. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /* Validação 29 */
    if ( $oRegistro60->tipos_defic_transtorno_altas_habilidades == 1 ) {

      if ( $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Alunos com deficiência, transtorno global do desenvolvimento";
        $sMsgErro .= " ou altas habilidades/superdotação deve estar setado com SIM. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /* Validações 30 - 39 */
    $aRecursosNecessariosINEP = array(
      $oRegistro60->recurso_auxilio_ledor,
      $oRegistro60->recurso_auxilio_transcricao,
      $oRegistro60->recurso_auxilio_interprete,
      $oRegistro60->recurso_auxilio_interprete_libras,
      $oRegistro60->recurso_auxilio_leitura_labial,
      $oRegistro60->recurso_auxilio_prova_ampliada_16,
      $oRegistro60->recurso_auxilio_prova_ampliada_20,
      $oRegistro60->recurso_auxilio_prova_ampliada_24,
      $oRegistro60->recurso_auxilio_prova_braille
    );

    /* Campos 17 - 28 */
    $aDeficiencias = array(
      $oRegistro60->tipos_defic_transtorno_cegueira,
      $oRegistro60->tipos_defic_transtorno_baixa_visao,
      $oRegistro60->tipos_defic_transtorno_surdez,
      $oRegistro60->tipos_defic_transtorno_auditiva,
      $oRegistro60->tipos_defic_transtorno_surdocegueira,
      $oRegistro60->tipos_defic_transtorno_def_fisica,
      $oRegistro60->tipos_defic_transtorno_def_intelectual,
      $oRegistro60->tipos_defic_transtorno_def_multipla,
      $oRegistro60->tipos_defic_transtorno_def_autismo_infantil,
      $oRegistro60->tipos_defic_transtorno_def_asperger,
      $oRegistro60->tipos_defic_transtorno_def_sindrome_rett,
      $oRegistro60->tipos_defic_transtorno_desintegrativo_infancia
    );

    if ( in_array( 1, $aRecursosNecessariosINEP )) {

      if ( $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Alunos com deficiência, transtorno global do desenvolvimento";
        $sMsgErro .= " ou altas habilidades/superdotação deve estar setado com SIM. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !isset( $aDeficiencias[1] )
            && $oRegistro60->tipos_defic_transtorno_altas_habilidades == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Nenhum Recurso para participação em avaliações do INEP deve estar setado com SIM. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    } else {

      $aDeficienciasSemDefFisicaIntelectual = $aDeficiencias;
      array_splice( $aDeficienciasSemDefFisicaIntelectual, 5, 2 );
      $aDeficienciasSemDefFisicaIntelectual = array_count_values( $aDeficienciasSemDefFisicaIntelectual );
      if ( isset( $aDeficienciasSemDefFisicaIntelectual[1] )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao menos um Recurso para participação em avaliações do INEP deve ser marcado para o aluno. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /* Remove os itens 19, 20 e 24 */
    array_splice( $aDeficiencias, 2, 2 );
    array_splice( $aDeficiencias, 5, 1 );
    /* Validação 30 */
    if ( $oRegistro60->recurso_auxilio_ledor == 1 ) {

      if ( !in_array( 1, $aDeficiencias )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Auxílio ledor ao menos um dos tipos de deficiência dever ser informado: \n";
        $sMsgErro .= "Cegueira, Baixa Visão, Surdocegueira, Deficiência Física, Deficiência Intelectual, ";
        $sMsgErro .= "Deficiência Múltipla, Autismo Infantil, Síndrome de Asperger, Síndrome de Rett ou Transtorno desintegrativo da infância";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Validação 31 */
    if ( $oRegistro60->recurso_auxilio_transcricao == 1 ) {

      if ( !in_array( 1, $aDeficiencias )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Auxílio transcrição ao menos um dos tipos de deficiência dever ser informado: \n";
        $sMsgErro .= "Cegueira, Baixa Visão, Surdocegueira, Deficiência Física, Deficiência Intelectual, ";
        $sMsgErro .= "Deficiência Múltipla, Autismo Infantil, Síndrome de Asperger, Síndrome de Rett ou Transtorno desintegrativo da infância";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Validação 32 */
    if ( $oRegistro60->recurso_auxilio_interprete == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Guia-Intérprete o tipo de deficiência Surdocegueira deve ser informado. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_leitura_labial == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Guia-Intérprete o recurso Leitura Labial não deve ser informado. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* 33 */
    if ( $oRegistro60->recurso_auxilio_interprete_libras == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_surdez != 1
              && $oRegistro60->tipos_defic_transtorno_auditiva != 1
                && $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Intérprete de Libras ao menos um dos tipos de deficiência dever ser informado: \n";
        $sMsgErro .= "Surdez, Deficiência auditiva ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_leitura_labial == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Intérprete de Libras o recurso Leitura Labial não deve ser informado. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Validação 34 */
    if ( $oRegistro60->recurso_auxilio_leitura_labial == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_surdez != 1
              && $oRegistro60->tipos_defic_transtorno_auditiva != 1
                && $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Leitura Labial ao menos um dos tipos de deficiência dever ser informado: \n";
        $sMsgErro .= "Surdez, Deficiência auditiva ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_interprete == 1
            || $oRegistro60->recurso_auxilio_interprete_libras == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Leitura Labial os recursos Guia-Intérprete e ";
        $sMsgErro .= "Intérprete de Libras não devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Validação 35 */
    if ( $oRegistro60->recurso_auxilio_prova_ampliada_16 == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_baixa_visao != 1
            && $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 16) ao menos um dos tipos de deficiência dever ser informado: \n";
        $sMsgErro .= "Baixa visão ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_prova_ampliada_20 == 1
            || $oRegistro60->recurso_auxilio_prova_ampliada_24 == 1
              || $oRegistro60->recurso_auxilio_prova_braille == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 16) os recursos Prova Ampliada - Fonte Tamanho 20, ";
        $sMsgErro .= "Fonte Tamanho 24 ou Prova em Braille não devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Validação 36 */
    if ( $oRegistro60->recurso_auxilio_prova_ampliada_20 == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_baixa_visao != 1
            && $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 20) ao menos um dos tipos de deficiência dever ser informado: \n";
        $sMsgErro .= "Baixa visão ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_prova_ampliada_16 == 1
            || $oRegistro60->recurso_auxilio_prova_ampliada_24 == 1
              || $oRegistro60->recurso_auxilio_prova_braille == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 20) os recursos Prova Ampliada - Fonte Tamanho 16, ";
        $sMsgErro .= "Fonte Tamanho 24 ou Prova em Braille não devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Validação 37 */
    if ( $oRegistro60->recurso_auxilio_prova_ampliada_24 == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_baixa_visao != 1
            && $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 24) ao menos um dos tipos de deficiência dever ser informado: \n";
        $sMsgErro .= "Baixa visão ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_prova_ampliada_16 == 1
            || $oRegistro60->recurso_auxilio_prova_ampliada_20 == 1
              || $oRegistro60->recurso_auxilio_prova_braille == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 24) os recursos Prova Ampliada - Fonte Tamanho 16, ";
        $sMsgErro .= "Fonte Tamanho 20 ou Prova em Braille não devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Validação 38 */
    if ( $oRegistro60->recurso_auxilio_prova_braille == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_cegueira != 1
            && $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova em Braille ao menos um dos tipos de deficiência dever ser informado: \n";
        $sMsgErro .= "Cegueira ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_prova_ampliada_16 == 1
            || $oRegistro60->recurso_auxilio_prova_ampliada_20 == 1
              || $oRegistro60->recurso_auxilio_prova_ampliada_24 == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova em Braille os recursos Prova Ampliada - Fonte Tamanho 16, ";
        $sMsgErro .= "Fonte Tamanho 20 ou Fonte Tamanho 24 não devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Validação 39 */
    if ( $oRegistro60->recurso_auxilio_nenhum == 1 ) {

      array_pop( $aRecursosNecessariosINEP );
      if ( in_array( 1, $aRecursosNecessariosINEP )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Nenhum recurso deve ser informado. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->tipos_defic_transtorno_cegueira == 1
            || $oRegistro60->tipos_defic_transtorno_surdocegueira == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Nenhum Recurso os tipos de deficiência Cegueira ou Surdocegueira ";
        $sMsgErro .= "não devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    return $lValidou;
  }

  /**
   * Validações referentes ao registro 80 - VÍNCULO (MATRÍCULA)
   * @param $oDadosAluno
   * @return bool
   */
  public function validaRegistro80( $oDadosAluno ) {

    $lValidou = true;

    foreach( $oDadosAluno->registro80 as $oMatricula ) {

      $oTurma       = DadosCensoAluno::getTurmaAluno( $this->oExportacaoCenso, $oMatricula->codigo_turma_entidade_escola );

      $aTransportes = array(
         $oMatricula->rodoviario_vans_kombi,
         $oMatricula->rodoviario_microonibus,
         $oMatricula->rodoviario_onibus,
         $oMatricula->rodoviario_bicicleta,
         $oMatricula->rodoviario_tracao_animal,
         $oMatricula->rodoviario_outro,
         $oMatricula->aquaviario_embarcacao_5_pessoas,
         $oMatricula->aquaviario_embarcacao_5_a_15_pessoas,
         $oMatricula->aquaviario_embarcacao_15_a_35_pessoas,
         $oMatricula->aquaviario_embarcacao_mais_de_35_pessoas,
         $oMatricula->ferroviario_trem_metro
      );

      $aEtapasMultiEtapa     = array( 12, 13, 22, 23, 24, 51, 56, 58, 64 );
      $aEtapasPermitidas[12] = array( 4, 5, 6, 7, 8, 9, 10, 11 );
      $aEtapasPermitidas[13] = array( 4, 5, 6, 7, 8, 9, 10, 11 );
      $aEtapasPermitidas[22] = array( 14, 15, 16, 17, 18, 19, 20, 21, 41 );
      $aEtapasPermitidas[23] = array( 14, 15, 16, 17, 18, 19, 20, 21, 41 );
      $aEtapasPermitidas[24] = array( 4, 5, 6, 7, 8, 9, 10, 11, 14, 15, 16, 17, 18, 19, 20, 21, 41 );
      $aEtapasPermitidas[56] = array( 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 14, 15, 16, 17, 18, 19, 20, 21, 41 );
      $aEtapasPermitidas[64] = array( 39, 40 );
      $aEtapasPermitidas[72] = array( 69, 70 );

      if( $oTurma->etapa_ensino_turma == 3 && !in_array( $oMatricula->turma_unificada, array( 1, 2 ) ) ) {

        $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
        $sMensagem .= "Deve ser informada a turma Unificada do Aluno";
        $this->oExportacaoCenso->logErro( $sMensagem, ExportacaoCenso2015::LOG_ALUNO );
        $lValidou = false;
      }

      if( in_array( $oTurma->etapa_ensino_turma, $aEtapasMultiEtapa ) ) {

        if (!in_array($oMatricula->codigo_etapa_multi_etapa, $aEtapasPermitidas[$oTurma->etapa_ensino_turma])) {

          $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
          $sMensagem .= "Turma: {$oTurma->nome_turma}";
          $sMensagem .= " Etapa do aluno em turma multietapa fora das etapas permitidas.";
          $this->oExportacaoCenso->logErro( $sMensagem, ExportacaoCenso2015::LOG_ALUNO );
          $lValidou = false;
        }
      }

      if( $oTurma->mediacao_didatico_pedagogica == 1 ) {

        if( !in_array( $oTurma->tipo_atendimento, array(4,5) ) 
            && empty($oMatricula->recebe_escolarizacao_outro_espaco)) {

          $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
          $sMensagem .= "O campo 'Recebe escolarização em outro espaço' deve ser informado.";
          $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
          $lValidou = false;
        }

        if( $oMatricula->recebe_escolarizacao_outro_espaco == 1 ) {

          if( $oTurma->tipo_atendimento != 1 ) {

            $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
            $sMensagem .= "Quando informado 'Recebe escolarização em outro espaço' com o valor";
            $sMensagem .= " 1-Em Hospital, o campo 'Tipo de Atendimento' da turma deve ser informado com o valor";
            $sMensagem .= " 1-Classe hospitalar.";
            $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
            $lValidou = false;
          }
        }
      }

      if( $oMatricula->transporte_escolar_publico  == 0 && $oMatricula->poder_publico_transporte_escolar != "" ) {

        $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
        $sMensagem .= "O campo 'Poder Público responsável pelo transporte escolar' não pode ser informado, Aluno não";
        $sMensagem .= " utiliza transporte público.";
        $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if( $oMatricula->transporte_escolar_publico == 1 ) {

        if( $oMatricula->poder_publico_transporte_escolar == "" ) {

          $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
          $sMensagem .= "Deve ser informado o poder público responsável.";
          $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
          $lValidou = false;
        }

        $aTransportes = array_count_values( $aTransportes );

        if( isset( $aTransportes[0] ) && $aTransportes[0] == 0 ) {

          $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
          $sMensagem .= "Informado que o aluno utiliza transporte publico. Ao menos uma das opções de transporte público";
          $sMensagem .= " deve ser selecionada.";
          $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
          $lValidou = false;
        }

        if( isset( $aTransportes[1] ) && $aTransportes[1] > 3 ) {

          $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
          $sMensagem .= "Permitido informar no máximo 3 opções de transporte público.";
          $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
          $lValidou = false;
        }
      }
    }

    return $lValidou;
  }

  /**
   * Validações referentes ao registro 70 - DOCUMENTOS E ENDEREÇO
   * @param $oDadosAluno
   * @return bool
   */
  public function validaRegistro70($oDadosAluno) {

    $oRegistro70 = $oDadosAluno->registro70;
    $oRegistro60 = $oDadosAluno->registro60;
    $lValidou    = true;
    $oAlunoDao   = new cl_aluno();

    $aDocumentosNacionalidadeBrasileira = array(
      $oRegistro70->numero_identidade         != '' ? true : false,
      $oRegistro70->orgao_emissor_identidade  != '' ? true : false,
      $oRegistro70->uf_identidade             != '' ? true : false,
      $oRegistro70->data_expedicao_identidade != '' ? true : false,
      $oRegistro70->certidao_civil            != '' ? true : false,
      $oRegistro70->tipo_certidao_civil       != '' ? true : false,
      $oRegistro70->numero_termo              != '' ? true : false,
      $oRegistro70->folha                     != '' ? true : false,
      $oRegistro70->livro                     != '' ? true : false,
      $oRegistro70->data_emissao_certidao     != '' ? true : false,
      $oRegistro70->uf_cartorio               != '' ? true : false,
      $oRegistro70->municipio_cartorio        != '' ? true : false,
      $oRegistro70->codigo_cartorio           != '' ? true : false,
      $oRegistro70->numero_matricula          != '' ? true : false,
      $oRegistro70->numero_cpf                != '' ? true : false
    );

    /**
     * Validação do campo 5 ao campo 18 referente a Nacionalidade do Aluno
     */
    if ( $oRegistro60->nacionalidade_aluno == 3 && in_array(true, $aDocumentosNacionalidadeBrasileira) ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Número de identidade, Orgão Emissor da Identidade, UF da Identidade, Data da Expedição da Identidade, ";
      $sMsgErro .= "Certidão Civil, Tipo de Certidão Civil, Número do Termo, Folha, Livro, Data de Emissão da Certidão,  ";
      $sMsgErro .= "UF do Cartório, Município do Cartório, Código do Cartório e Número da Matrícula( Registro Civil - Certidão Nova ) ";
      $sMsgErro .= "devem ser preenchido apenas por alunos com nacionalidade Brasileira ";
      $sMsgErro .= "ou Brasileira - nascido no exterior ou naturalizado";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    $aDocumentosIdentidade = array(
      $oRegistro70->numero_identidade,
      $oRegistro70->uf_identidade,
      $oRegistro70->orgao_emissor_identidade,
      $oRegistro70->data_expedicao_identidade
    );

    $iDocumentosIdentidadeInformados = 0;
    foreach ($aDocumentosIdentidade as $oDocumentoIdentidade) {

      if ( $oDocumentoIdentidade != "" ) {
        $iDocumentosIdentidadeInformados++;
      }
    }

    /**
     * Validação do campo 5 ao campo 8 referente a obrigatoriedade de preenchimento
     */
    if ( $iDocumentosIdentidadeInformados > 0 && $iDocumentosIdentidadeInformados < 4 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Ao preencher uma das seguintes informações da identidade (Número de Identidade, Órgão Emissor da ";
      $sMsgErro .= "Identidade, UF da Identidade ou Data de Expedição da Identidade), todas as outras devem ser informadas.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    if (    trim( $oRegistro70->tipo_certidao_civil ) == ''
         && (    trim( $oRegistro70->numero_termo    ) != ''
              || trim( $oRegistro70->uf_cartorio     ) != ''
              || trim( $oRegistro70->codigo_cartorio ) != ''
            )
       ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Tipo de certidão não informado.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    if( $oRegistro70->situacaodocumentacao == 0 ) {

      $aDocumentosAluno = array(
                                 trim( $oRegistro70->numero_identidade ),
                                 trim( $oRegistro70->complemento_identidade ),
                                 trim( $oRegistro70->orgao_emissor_identidade ),
                                 trim( $oRegistro70->uf_identidade ),
                                 trim( $oRegistro70->data_expedicao_identidade ),
                                 trim( $oRegistro70->certidao_civil ),
                                 trim( $oRegistro70->tipo_certidao_civil ),
                                 trim( $oRegistro70->numero_termo ),
                                 trim( $oRegistro70->folha ),
                                 trim( $oRegistro70->livro ),
                                 trim( $oRegistro70->data_emissao_certidao ),
                                 trim( $oRegistro70->uf_cartorio ),
                                 trim( $oRegistro70->municipio_cartorio ),
                                 trim( $oRegistro70->codigo_cartorio ),
                                 trim( $oRegistro70->numero_matricula ),
                                 trim( $oRegistro70->numero_cpf ),
                                 trim( $oRegistro70->documento_estrangeiro_passaporte )
                               );

      $iTotalDocumentos         = count( $aDocumentosAluno );
      $iDocumentosNaoInformados = 0;

      foreach( $aDocumentosAluno as $sDocumento ) {

        if( empty( $sDocumento ) ) {
          $iDocumentosNaoInformados++;
        }
      }

      if( $iTotalDocumentos == $iDocumentosNaoInformados ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "Informado que o aluno possui documentação, porém nenhum foi informado.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /**
     * Validações referentes ao campo 9
     */
    if ( $oRegistro70->certidao_civil == 1 ) {

      if ( $oRegistro70->numero_matricula != '' ){

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "Quando informado Certidão Civil igual a 'Modelo Antigo', o Número da Matrícula não deve ser informado.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }

      if (    trim( $oRegistro70->tipo_certidao_civil ) == ''
           || trim( $oRegistro70->numero_termo        ) == ''
           || trim( $oRegistro70->uf_cartorio         ) == ''
           || trim( $oRegistro70->codigo_cartorio     ) == '' ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "Quando informado Certidão Civil igual a 'Modelo Antigo', os campos Tipo de Certidão Civil, ";
        $sMsgErro .= "Número do Termo, UF do Cartório e Código do Cartório devem ser preenchidos.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty($oRegistro70->data_emissao_certidao) ) {

        $oDtNascimento = new DBDate($oRegistro60->data_nascimento);
        $oDtCertidao   = new DBDate($oRegistro70->data_emissao_certidao);
        if ( $oDtCertidao->getTimeStamp() < $oDtNascimento->getTimeStamp() ) {

          $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
          $sMsgErro .= "Data de Nascimento deve ser menor que a data de Emissão da Certidão.";
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
          $lValidou = false;
        }
      }
    }

    /**
     * Validações referentes ao campo 9
     */
    if ( $oRegistro70->certidao_civil == 2 ) {

      if ( $oRegistro70->numero_matricula == '' ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "Quando informado Certidão Civil igual a 'Modelo Novo', o Número da Matrícula deve ser informado.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }

      $aDocumentosTipoCertidao = array(
        $oRegistro70->tipo_certidao_civil   != '' ? true : false,
        $oRegistro70->numero_termo          != '' ? true : false,
        $oRegistro70->folha                 != '' ? true : false,
        $oRegistro70->livro                 != '' ? true : false,
        $oRegistro70->data_emissao_certidao != '' ? true : false,
        $oRegistro70->uf_cartorio           != '' ? true : false,
        $oRegistro70->municipio_cartorio    != '' ? true : false,
        $oRegistro70->codigo_cartorio       != '' ? true : false
      );

      if ( in_array( true, $aDocumentosTipoCertidao) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "Quando informado Certidão Civil igual a 'Modelo Novo', os campos Tipo de Certidão Civil, ";
        $sMsgErro .= "Número do Termo, Folha, Livro, Data de Emissão da Cerditão, UF do Cartório Município do Cartório ";
        $sMsgErro .= "e Código do Cartório não devem ser preenchidos.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Validações referentes ao campo 18
       *
       */
      if ( $oRegistro70->numero_matricula != '' ) {

        $sCamposAluno = " ed47_i_codigo, ed47_v_nome ";
        $sWhereAluno  = " ed47_certidaomatricula = '{$oRegistro70->numero_matricula}'";
        $sWhereAluno .= " and ed47_i_codigo <> {$oRegistro70->codigo_aluno_entidade}";
        $sSqlAluno    = $oAlunoDao->sql_query_file( null, $sCamposAluno, null, $sWhereAluno );
        $rsAluno      = db_query( $sSqlAluno );

        if ( !$rsAluno || pg_num_rows($rsAluno) > 0 ) {

          $aAlunoMatricula = array();
          for ($iContador=0; $iContador < pg_num_rows($rsAluno); $iContador++) {

            $oAluno = db_utils::fieldsMemory($rsAluno, $iContador);
            $aAlunoMatricula[] = $oAluno->ed47_i_codigo . '-' . $oAluno->ed47_v_nome;
          }

          $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
          $sMsgErro .= "Número da Matrícula (Registro Civil - Certidão Nova) repetido no(s) seguinte(s) aluno(s):\n";
          $sMsgErro .= implode("\n", $aAlunoMatricula);
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
          $lValidou = false;
        }
      }

      try {
         DadosCensoAluno::validarCertidadaoNova($oRegistro70->numero_matricula, $this->oExportacaoCenso->getAnoCenso());
      } catch(Exception $eErroCertidao) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "Número da Matrícula (Registro Civil - Certidão Nova) inválida.".$eErroCertidao->getMessage();
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /**
     * Validações referentes ao campo 10
     */

    $oAluno = new Aluno( $oRegistro70->codigo_aluno_entidade );

    if ( $oRegistro70->tipo_certidao_civil == 2 && $oAluno->getIdade() < 10 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Quando informado Tipo de Certidão igual a 'Casamento', o aluno não pode ter idade inferior a 10 anos.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * Validações referentes ao campo 19
     */
    if ($oRegistro70->numero_cpf != "") {

      if (!DBString::isCPF($oRegistro70->numero_cpf)) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= $oRegistro70->numero_cpf . " não é um CPF válido";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /**
     * Validações referentes ao campo 20
     */
    if (    $oRegistro70->documento_estrangeiro_passaporte != ''
         && $oRegistro60->nacionalidade_aluno != 3 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Quando informado Documento Estrangeiro/Passaporte, a Nacionalidade do aluno deve ser igual a 'Estrangeira'.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * Validações referentes ao campo 21
     */
    if (!empty($oRegistro70->numero_identificacao_social)) {

      if (!parent::ValidaNIS($oRegistro70->numero_identificacao_social)) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "Número NIS do aluno é inválido.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }

      $sCamposAluno = " ed47_i_codigo, ed47_v_nome ";
      $sWhereAluno  = " ed47_c_nis = '{$oRegistro70->numero_identificacao_social}' ";
      $sWhereAluno .= " and ed47_i_codigo <> {$oRegistro70->codigo_aluno_entidade} ";
      $sSqlAluno    = $oAlunoDao->sql_query_file( null, $sCamposAluno, null, $sWhereAluno );
      $rsAluno      = db_query( $sSqlAluno );

      if ( !$rsAluno || pg_num_rows($rsAluno) > 0 ) {

        $aMsgNIS = array();
        for ($iContador=0; $iContador < pg_num_rows($rsAluno); $iContador++) {

          $oAluno    = db_utils::fieldsMemory($rsAluno, $iContador);
          $aMsgNIS[] = $oAluno->ed47_i_codigo . '-' . $oAluno->ed47_v_nome;
        }

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "Número NIS do aluno repetido no(s) seguinte(s) aluno(s):\n";
        $sMsgErro .= implode("\n", $aMsgNIS);
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }
    }

    $aDadosEndereco = array(
      $oRegistro70->cep,
      $oRegistro70->endereco,
      $oRegistro70->uf,
      $oRegistro70->municipio
    );

    $iDadosEnderecoInformado = 0;
    foreach ($aDadosEndereco as $oDadoEndereco) {

      if ( $oDadoEndereco != "" ) {
        $iDadosEnderecoInformado++;
      }
    }

    /**
     * Vaçodações referentes aos campos 23, 24, 28 e 29
     */
    if ( $iDadosEnderecoInformado > 0 && $iDadosEnderecoInformado < 4 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Ao preencher uma das seguintes informações do endereço residencial (CEP, Endereço, UF ou Município) ";
      $sMsgErro .= "todas as outras devem ser informadas.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * Vaçodações referentes aos campos 25
     */
    if ( $oRegistro70->numero != '' && $iDadosEnderecoInformado < 4 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Ao preencher o número do endereço residencial, os campos CEP, Endereço, UF e Município ";
      $sMsgErro .= "devem ser informados.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * Vaçodações referentes aos campos 26
     */
    if ( $oRegistro70->complemento != '' && $iDadosEnderecoInformado < 4 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Ao preencher o complemento do endereço residencial, os campos CEP, Endereço, UF e Município ";
      $sMsgErro .= "devem ser informados.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * Vaçodações referentes aos campos 27
     */
    if ( $oRegistro70->bairro != '' && $iDadosEnderecoInformado < 4 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Ao preencher o bairro do endereço residencial, os campos CEP, Endereço, UF e Município ";
      $sMsgErro .= "devem ser informados.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    return $lValidou;
  }
}