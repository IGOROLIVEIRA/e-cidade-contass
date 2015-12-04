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
   * Campos n�o validados pois s�o validados na gera��o dos dados do aluno
   *  - tipo_registro
   *  - codigo_escola_inep
   *  - nome_completo (garante que s� vem caracteres v�lidos)
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
      $sMsgErro .= "C�digo INEP do aluno possui tamanho inferior a 12 d�gitos.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
      $lValidou = false;
    }

    if ( !DBString::isNomeValido($oRegistro60->nome_completo, DBString::NOME_REGRA_2) ) {

      $sMsgErro  = "Nome do Aluno(a) {$this->sAluno} dever possuir nome e sobrenome.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * valida a filia��o do aluno
     * 0 - N�o declarado/Ignorado;
     * 1 - Pai e/ou M�e
     */
    switch ($oRegistro60->filiacao) {

      case 0:

        if (!empty($oRegistro60->nome_mae) || !empty($oRegistro60->nome_pai) ) {

          $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
          $sMsgErro .= "Nome do pai e/ou m�e s� devem ser informadados quando a filia��o for igual a: Pai e/ou M�e.";
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
          $lValidou = false;
        }

        break;
      case 1:

          if (empty($oRegistro60->nome_mae) && empty($oRegistro60->nome_pai) ) {

            $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
            $sMsgErro .= "Quando informado filia��o: Pai e/ou M�e, deve ser informado o nome da m�e ou do pai.";
            $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
            $lValidou = false;
          }

          if (!empty($oRegistro60->nome_mae) &&
              !DBString::isNomeValido($oRegistro60->nome_mae, DBString::NOME_REGRA_4) ) {

            $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
            $sMsgErro .= " nome da m�e ({$oRegistro60->nome_mae}) possui mais de 4 letras repetidas em sequ�ncia.";
            $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
            $lValidou = false;
          }

          if (!empty($oRegistro60->nome_pai) &&
              !DBString::isNomeValido($oRegistro60->nome_pai, DBString::NOME_REGRA_4) ) {

            $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
            $sMsgErro .= " nome da pai ({$oRegistro60->nome_pai}) possui mais de 4 letras repetidas em sequ�ncia.";
            $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
            $lValidou = false;
          }
        break;
    }

    if ( $oRegistro60->nacionalidade_aluno == 1 ) {

      /**
       * Linha 14: Valida se a Nascionalidade do aluno � brasileira e se a UF de Nascimento foi preenchida
       */
      if ( $oRegistro60->uf_nascimento == '' ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Obrigat�rio informar UF de nascimento quando a nascionalidade for Brasileira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }


      /**
       * Linha 15: Valida se a Nascionalidade do aluno � brasileira e se o Munic�pio de Nascimento foi preenchido
       */
      if ( $oRegistro60->municipio_nascimento == '' ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Obrigat�rio informar Munic�pio de nascimento quando a nascionalidade for Brasileira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /**
     * Linha 16: M�todo DadosCensoAluno::setDadosIdenficacao j� valida se pelo menos alguma outra defici�ncia foi preenchida.
     */

    if ( $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao == 1 ) {

      /**
       * Linha 17: Quando informado Cegueira, o mesmo n�o deve possuir baixa vis�o, surdez ou surdocegueira
       */
      $aNecessidadesCegueira = array(
         $oRegistro60->tipos_defic_transtorno_baixa_visao,
         $oRegistro60->tipos_defic_transtorno_surdez,
         $oRegistro60->tipos_defic_transtorno_surdocegueira
      );

      if ( $oRegistro60->tipos_defic_transtorno_cegueira == 1 && in_array( 1, $aNecessidadesCegueira ) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Cegueira, o mesmo n�o deve ter informado baixa vis�o, surdez ou surdocegueira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 18: Quando informado baixa vis�o, o mesmo n�o deve possuir cegueira ou surdocegueira
       */
      $aNecessidadesBaixaVisao = array(
        $oRegistro60->tipos_defic_transtorno_cegueira,
        $oRegistro60->tipos_defic_transtorno_surdocegueira
      );

      if ( $oRegistro60->tipos_defic_transtorno_baixa_visao == 1 && in_array( 1, $aNecessidadesBaixaVisao ) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Baixa Vis�o, o mesmo n�o deve ter informado cegueira ou surdocegueira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 19: Quando informado Surdez, o mesmo n�o deve possuir cegueira, defici�ncia auditiva ou surdocegueira
       */
      $aNecessidadesSurdez = array(
        $oRegistro60->tipos_defic_transtorno_cegueira,
        $oRegistro60->tipos_defic_transtorno_auditiva,
        $oRegistro60->tipos_defic_transtorno_surdocegueira
      );

      if ( $oRegistro60->tipos_defic_transtorno_surdez == 1 && in_array( 1, $aNecessidadesSurdez )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Surdez, o mesmo n�o deve ter informado cegueira, defici�ncia ";
        $sMsgErro .= "auditiva ou surdocegueira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 20: Quando informado defici�ncia auditiva, o mesmo n�o deve possuir surdez ou surdocegueira
       */
      $aNecessidadesDeficienciaAuditiva = array(
        $oRegistro60->tipos_defic_transtorno_surdez,
        $oRegistro60->tipos_defic_transtorno_surdocegueira
      );

      if ( $oRegistro60->tipos_defic_transtorno_auditiva == 1 && in_array( 1, $aNecessidadesDeficienciaAuditiva ) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Defici�ncia Auditiva, o mesmo n�o deve ter informado surdez ou surdocegueira.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 21: Quando informado Surdocegueira, o mesmo n�o deve possuir cegueira, baixa vis�o, surdez ou defici�ncia
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
        $sMsgErro .= "Quando aluno possuir Surdocegueira, o mesmo n�o deve ter informado cegueira, baixa vis�o, surdez ";
        $sMsgErro .= "ou defici�ncia auditiva.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 24: J� realiza esta valida��o no m�todo DadosCensoAluno::setDadosIdenficacao
       */

      /**
       * Linha 25: Quando informado Autismo Infantil, o mesmo n�o deve possuir s�ndrome de Asperger, s�ndrome de Rett
       *           ou transtorno desintegrativo da inf�ncia.
       */
      $aNecessidadesAutismoInfantil = array(
        $oRegistro60->tipos_defic_transtorno_def_asperger,
        $oRegistro60->tipos_defic_transtorno_def_sindrome_rett,
        $oRegistro60->tipos_defic_transtorno_desintegrativo_infancia
      );

      if ( $oRegistro60->tipos_defic_transtorno_def_autismo_infantil == 1 && in_array( 1, $aNecessidadesAutismoInfantil ) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Autismo Infantil, o mesmo n�o deve ter informado s�ndrome de Asperger, ";
        $sMsgErro .= "s�ndrome de Rett ou transtorno desintegrativo da inf�ncia.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Linha 26: Quando informado S�ndrome de Asperger, o mesmo n�o deve possuir Autismo Infantil, s�ndrome de Rett
       *           ou transtorno desintegrativo da inf�ncia.
       */
      $aNecessidadesAsperger = array(
        $oRegistro60->tipos_defic_transtorno_def_autismo_infantil,
        $oRegistro60->tipos_defic_transtorno_def_sindrome_rett,
        $oRegistro60->tipos_defic_transtorno_desintegrativo_infancia
      );

      if ( $oRegistro60->tipos_defic_transtorno_def_asperger == 1 && in_array( 1, $aNecessidadesAsperger ) ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir S�ndrome de Asperger, o mesmo n�o deve ter informado autismo infantil, ";
        $sMsgErro .= "s�ndrome de Rett ou transtorno desintegrativo da inf�ncia.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /**
     * Linha 22: Quando informado Defici�ncia F�sica, tambem deve ser informado que o aluno possui Transtorno Global do
     *           Desenvolvimento ou Altas Habilidades/Superdota��o.
     */
    if ( $oRegistro60->tipos_defic_transtorno_def_fisica == 1 &&
         $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao == 0 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Defici�ncia F�sica, deve ser informado que o mesmo possui transtorno global ";
        $sMsgErro .= "do desenvolvimento ou altas habilidades/superdota��o.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
    }

    /**
     * Linha 23: Quando informado Defici�ncia Intelectual, tambem deve ser informado que o aluno possui Transtorno
     *           Global do Desenvolvimento ou Altas Habilidades/Superdota��o.
     */
    if ( $oRegistro60->tipos_defic_transtorno_def_intelectual == 1 &&
         $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao == 0 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Quando aluno possuir Defici�ncia Intelectual, deve ser informado que o mesmo possui transtorno global ";
        $sMsgErro .= "do desenvolvimento ou altas habilidades/superdota��o.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
    }

    /* Valida��o 27 */
    if ( $oRegistro60->tipos_defic_transtorno_def_sindrome_rett == 1 ) {

      if ( $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Alunos com defici�ncia, transtorno global do desenvolvimento";
        $sMsgErro .= " ou altas habilidades/superdota��o deve estar setado com SIM. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_def_autismo_infantil )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Autismo Infantil deve estar setado com N�O. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_def_asperger )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo S�ndrome de Asperger deve estar setado com N�O. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_desintegrativo_infancia )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Transtorno desintegrativo da inf�ncia deve estar setado com N�O. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /* Valida��o 28 */
    if ( $oRegistro60->tipos_defic_transtorno_desintegrativo_infancia == 1 ) {

      if ( $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Alunos com defici�ncia, transtorno global do desenvolvimento";
        $sMsgErro .= " ou altas habilidades/superdota��o deve estar setado com SIM. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_def_autismo_infantil )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Autismo Infantil deve estar setado com N�O. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_def_asperger )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo S�ndrome de Asperger deve estar setado com N�O. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty( $oRegistro60->tipos_defic_transtorno_def_sindrome_rett )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo S�ndrome de Rett deve estar setado com N�O. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /* Valida��o 29 */
    if ( $oRegistro60->tipos_defic_transtorno_altas_habilidades == 1 ) {

      if ( $oRegistro60->alunos_deficiencia_transtorno_desenv_superdotacao != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Campo Alunos com defici�ncia, transtorno global do desenvolvimento";
        $sMsgErro .= " ou altas habilidades/superdota��o deve estar setado com SIM. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /* Valida��es 30 - 39 */
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
        $sMsgErro .= "Campo Alunos com defici�ncia, transtorno global do desenvolvimento";
        $sMsgErro .= " ou altas habilidades/superdota��o deve estar setado com SIM. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !isset( $aDeficiencias[1] )
            && $oRegistro60->tipos_defic_transtorno_altas_habilidades == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Nenhum Recurso para participa��o em avalia��es do INEP deve estar setado com SIM. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    } else {

      $aDeficienciasSemDefFisicaIntelectual = $aDeficiencias;
      array_splice( $aDeficienciasSemDefFisicaIntelectual, 5, 2 );
      $aDeficienciasSemDefFisicaIntelectual = array_count_values( $aDeficienciasSemDefFisicaIntelectual );
      if ( isset( $aDeficienciasSemDefFisicaIntelectual[1] )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao menos um Recurso para participa��o em avalia��es do INEP deve ser marcado para o aluno. \n";

        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /* Remove os itens 19, 20 e 24 */
    array_splice( $aDeficiencias, 2, 2 );
    array_splice( $aDeficiencias, 5, 1 );
    /* Valida��o 30 */
    if ( $oRegistro60->recurso_auxilio_ledor == 1 ) {

      if ( !in_array( 1, $aDeficiencias )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Aux�lio ledor ao menos um dos tipos de defici�ncia dever ser informado: \n";
        $sMsgErro .= "Cegueira, Baixa Vis�o, Surdocegueira, Defici�ncia F�sica, Defici�ncia Intelectual, ";
        $sMsgErro .= "Defici�ncia M�ltipla, Autismo Infantil, S�ndrome de Asperger, S�ndrome de Rett ou Transtorno desintegrativo da inf�ncia";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Valida��o 31 */
    if ( $oRegistro60->recurso_auxilio_transcricao == 1 ) {

      if ( !in_array( 1, $aDeficiencias )) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Aux�lio transcri��o ao menos um dos tipos de defici�ncia dever ser informado: \n";
        $sMsgErro .= "Cegueira, Baixa Vis�o, Surdocegueira, Defici�ncia F�sica, Defici�ncia Intelectual, ";
        $sMsgErro .= "Defici�ncia M�ltipla, Autismo Infantil, S�ndrome de Asperger, S�ndrome de Rett ou Transtorno desintegrativo da inf�ncia";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Valida��o 32 */
    if ( $oRegistro60->recurso_auxilio_interprete == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Guia-Int�rprete o tipo de defici�ncia Surdocegueira deve ser informado. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_leitura_labial == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Guia-Int�rprete o recurso Leitura Labial n�o deve ser informado. \n";
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
        $sMsgErro .= "Ao informar Int�rprete de Libras ao menos um dos tipos de defici�ncia dever ser informado: \n";
        $sMsgErro .= "Surdez, Defici�ncia auditiva ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_leitura_labial == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Int�rprete de Libras o recurso Leitura Labial n�o deve ser informado. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Valida��o 34 */
    if ( $oRegistro60->recurso_auxilio_leitura_labial == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_surdez != 1
              && $oRegistro60->tipos_defic_transtorno_auditiva != 1
                && $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Leitura Labial ao menos um dos tipos de defici�ncia dever ser informado: \n";
        $sMsgErro .= "Surdez, Defici�ncia auditiva ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_interprete == 1
            || $oRegistro60->recurso_auxilio_interprete_libras == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Leitura Labial os recursos Guia-Int�rprete e ";
        $sMsgErro .= "Int�rprete de Libras n�o devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Valida��o 35 */
    if ( $oRegistro60->recurso_auxilio_prova_ampliada_16 == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_baixa_visao != 1
            && $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 16) ao menos um dos tipos de defici�ncia dever ser informado: \n";
        $sMsgErro .= "Baixa vis�o ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_prova_ampliada_20 == 1
            || $oRegistro60->recurso_auxilio_prova_ampliada_24 == 1
              || $oRegistro60->recurso_auxilio_prova_braille == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 16) os recursos Prova Ampliada - Fonte Tamanho 20, ";
        $sMsgErro .= "Fonte Tamanho 24 ou Prova em Braille n�o devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Valida��o 36 */
    if ( $oRegistro60->recurso_auxilio_prova_ampliada_20 == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_baixa_visao != 1
            && $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 20) ao menos um dos tipos de defici�ncia dever ser informado: \n";
        $sMsgErro .= "Baixa vis�o ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_prova_ampliada_16 == 1
            || $oRegistro60->recurso_auxilio_prova_ampliada_24 == 1
              || $oRegistro60->recurso_auxilio_prova_braille == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 20) os recursos Prova Ampliada - Fonte Tamanho 16, ";
        $sMsgErro .= "Fonte Tamanho 24 ou Prova em Braille n�o devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Valida��o 37 */
    if ( $oRegistro60->recurso_auxilio_prova_ampliada_24 == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_baixa_visao != 1
            && $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 24) ao menos um dos tipos de defici�ncia dever ser informado: \n";
        $sMsgErro .= "Baixa vis�o ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_prova_ampliada_16 == 1
            || $oRegistro60->recurso_auxilio_prova_ampliada_20 == 1
              || $oRegistro60->recurso_auxilio_prova_braille == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova Ampliada (Fonte Tamanho 24) os recursos Prova Ampliada - Fonte Tamanho 16, ";
        $sMsgErro .= "Fonte Tamanho 20 ou Prova em Braille n�o devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Valida��o 38 */
    if ( $oRegistro60->recurso_auxilio_prova_braille == 1 ) {

      if ( $oRegistro60->tipos_defic_transtorno_cegueira != 1
            && $oRegistro60->tipos_defic_transtorno_surdocegueira != 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova em Braille ao menos um dos tipos de defici�ncia dever ser informado: \n";
        $sMsgErro .= "Cegueira ou Surdocegueira. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if ( $oRegistro60->recurso_auxilio_prova_ampliada_16 == 1
            || $oRegistro60->recurso_auxilio_prova_ampliada_20 == 1
              || $oRegistro60->recurso_auxilio_prova_ampliada_24 == 1 ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}:\n";
        $sMsgErro .= "Ao informar Prova em Braille os recursos Prova Ampliada - Fonte Tamanho 16, ";
        $sMsgErro .= "Fonte Tamanho 20 ou Fonte Tamanho 24 n�o devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }
    /* Valida��o 39 */
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
        $sMsgErro .= "Ao informar Nenhum Recurso os tipos de defici�ncia Cegueira ou Surdocegueira ";
        $sMsgErro .= "n�o devem ser informados. \n";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }
    }

    return $lValidou;
  }

  /**
   * Valida��es referentes ao registro 80 - V�NCULO (MATR�CULA)
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
          $sMensagem .= "O campo 'Recebe escolariza��o em outro espa�o' deve ser informado.";
          $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
          $lValidou = false;
        }

        if( $oMatricula->recebe_escolarizacao_outro_espaco == 1 ) {

          if( $oTurma->tipo_atendimento != 1 ) {

            $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
            $sMensagem .= "Quando informado 'Recebe escolariza��o em outro espa�o' com o valor";
            $sMensagem .= " 1-Em Hospital, o campo 'Tipo de Atendimento' da turma deve ser informado com o valor";
            $sMensagem .= " 1-Classe hospitalar.";
            $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
            $lValidou = false;
          }
        }
      }

      if( $oMatricula->transporte_escolar_publico  == 0 && $oMatricula->poder_publico_transporte_escolar != "" ) {

        $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
        $sMensagem .= "O campo 'Poder P�blico respons�vel pelo transporte escolar' n�o pode ser informado, Aluno n�o";
        $sMensagem .= " utiliza transporte p�blico.";
        $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
        $lValidou = false;
      }

      if( $oMatricula->transporte_escolar_publico == 1 ) {

        if( $oMatricula->poder_publico_transporte_escolar == "" ) {

          $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
          $sMensagem .= "Deve ser informado o poder p�blico respons�vel.";
          $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
          $lValidou = false;
        }

        $aTransportes = array_count_values( $aTransportes );

        if( isset( $aTransportes[0] ) && $aTransportes[0] == 0 ) {

          $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
          $sMensagem .= "Informado que o aluno utiliza transporte publico. Ao menos uma das op��es de transporte p�blico";
          $sMensagem .= " deve ser selecionada.";
          $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
          $lValidou = false;
        }

        if( isset( $aTransportes[1] ) && $aTransportes[1] > 3 ) {

          $sMensagem  = "Aluno(a) {$this->sAluno}: \n";
          $sMensagem .= "Permitido informar no m�ximo 3 op��es de transporte p�blico.";
          $this->oExportacaoCenso->logErro($sMensagem, ExportacaoCenso2015::LOG_ALUNO);
          $lValidou = false;
        }
      }
    }

    return $lValidou;
  }

  /**
   * Valida��es referentes ao registro 70 - DOCUMENTOS E ENDERE�O
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
     * Valida��o do campo 5 ao campo 18 referente a Nacionalidade do Aluno
     */
    if ( $oRegistro60->nacionalidade_aluno == 3 && in_array(true, $aDocumentosNacionalidadeBrasileira) ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "N�mero de identidade, Org�o Emissor da Identidade, UF da Identidade, Data da Expedi��o da Identidade, ";
      $sMsgErro .= "Certid�o Civil, Tipo de Certid�o Civil, N�mero do Termo, Folha, Livro, Data de Emiss�o da Certid�o,  ";
      $sMsgErro .= "UF do Cart�rio, Munic�pio do Cart�rio, C�digo do Cart�rio e N�mero da Matr�cula( Registro Civil - Certid�o Nova ) ";
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
     * Valida��o do campo 5 ao campo 8 referente a obrigatoriedade de preenchimento
     */
    if ( $iDocumentosIdentidadeInformados > 0 && $iDocumentosIdentidadeInformados < 4 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Ao preencher uma das seguintes informa��es da identidade (N�mero de Identidade, �rg�o Emissor da ";
      $sMsgErro .= "Identidade, UF da Identidade ou Data de Expedi��o da Identidade), todas as outras devem ser informadas.";
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
      $sMsgErro .= "Tipo de certid�o n�o informado.";
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
        $sMsgErro .= "Informado que o aluno possui documenta��o, por�m nenhum foi informado.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /**
     * Valida��es referentes ao campo 9
     */
    if ( $oRegistro70->certidao_civil == 1 ) {

      if ( $oRegistro70->numero_matricula != '' ){

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "Quando informado Certid�o Civil igual a 'Modelo Antigo', o N�mero da Matr�cula n�o deve ser informado.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }

      if (    trim( $oRegistro70->tipo_certidao_civil ) == ''
           || trim( $oRegistro70->numero_termo        ) == ''
           || trim( $oRegistro70->uf_cartorio         ) == ''
           || trim( $oRegistro70->codigo_cartorio     ) == '' ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "Quando informado Certid�o Civil igual a 'Modelo Antigo', os campos Tipo de Certid�o Civil, ";
        $sMsgErro .= "N�mero do Termo, UF do Cart�rio e C�digo do Cart�rio devem ser preenchidos.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }

      if ( !empty($oRegistro70->data_emissao_certidao) ) {

        $oDtNascimento = new DBDate($oRegistro60->data_nascimento);
        $oDtCertidao   = new DBDate($oRegistro70->data_emissao_certidao);
        if ( $oDtCertidao->getTimeStamp() < $oDtNascimento->getTimeStamp() ) {

          $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
          $sMsgErro .= "Data de Nascimento deve ser menor que a data de Emiss�o da Certid�o.";
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
          $lValidou = false;
        }
      }
    }

    /**
     * Valida��es referentes ao campo 9
     */
    if ( $oRegistro70->certidao_civil == 2 ) {

      if ( $oRegistro70->numero_matricula == '' ) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "Quando informado Certid�o Civil igual a 'Modelo Novo', o N�mero da Matr�cula deve ser informado.";
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
        $sMsgErro .= "Quando informado Certid�o Civil igual a 'Modelo Novo', os campos Tipo de Certid�o Civil, ";
        $sMsgErro .= "N�mero do Termo, Folha, Livro, Data de Emiss�o da Cerdit�o, UF do Cart�rio Munic�pio do Cart�rio ";
        $sMsgErro .= "e C�digo do Cart�rio n�o devem ser preenchidos.";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }

      /**
       * Valida��es referentes ao campo 18
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
          $sMsgErro .= "N�mero da Matr�cula (Registro Civil - Certid�o Nova) repetido no(s) seguinte(s) aluno(s):\n";
          $sMsgErro .= implode("\n", $aAlunoMatricula);
          $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
          $lValidou = false;
        }
      }

      try {
         DadosCensoAluno::validarCertidadaoNova($oRegistro70->numero_matricula, $this->oExportacaoCenso->getAnoCenso());
      } catch(Exception $eErroCertidao) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "N�mero da Matr�cula (Registro Civil - Certid�o Nova) inv�lida.".$eErroCertidao->getMessage();
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /**
     * Valida��es referentes ao campo 10
     */

    $oAluno = new Aluno( $oRegistro70->codigo_aluno_entidade );

    if ( $oRegistro70->tipo_certidao_civil == 2 && $oAluno->getIdade() < 10 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Quando informado Tipo de Certid�o igual a 'Casamento', o aluno n�o pode ter idade inferior a 10 anos.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * Valida��es referentes ao campo 19
     */
    if ($oRegistro70->numero_cpf != "") {

      if (!DBString::isCPF($oRegistro70->numero_cpf)) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= $oRegistro70->numero_cpf . " n�o � um CPF v�lido";
        $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
        $lValidou = false;
      }
    }

    /**
     * Valida��es referentes ao campo 20
     */
    if (    $oRegistro70->documento_estrangeiro_passaporte != ''
         && $oRegistro60->nacionalidade_aluno != 3 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Quando informado Documento Estrangeiro/Passaporte, a Nacionalidade do aluno deve ser igual a 'Estrangeira'.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * Valida��es referentes ao campo 21
     */
    if (!empty($oRegistro70->numero_identificacao_social)) {

      if (!parent::ValidaNIS($oRegistro70->numero_identificacao_social)) {

        $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
        $sMsgErro .= "N�mero NIS do aluno � inv�lido.";
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
        $sMsgErro .= "N�mero NIS do aluno repetido no(s) seguinte(s) aluno(s):\n";
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
     * Va�oda��es referentes aos campos 23, 24, 28 e 29
     */
    if ( $iDadosEnderecoInformado > 0 && $iDadosEnderecoInformado < 4 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Ao preencher uma das seguintes informa��es do endere�o residencial (CEP, Endere�o, UF ou Munic�pio) ";
      $sMsgErro .= "todas as outras devem ser informadas.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * Va�oda��es referentes aos campos 25
     */
    if ( $oRegistro70->numero != '' && $iDadosEnderecoInformado < 4 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Ao preencher o n�mero do endere�o residencial, os campos CEP, Endere�o, UF e Munic�pio ";
      $sMsgErro .= "devem ser informados.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * Va�oda��es referentes aos campos 26
     */
    if ( $oRegistro70->complemento != '' && $iDadosEnderecoInformado < 4 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Ao preencher o complemento do endere�o residencial, os campos CEP, Endere�o, UF e Munic�pio ";
      $sMsgErro .= "devem ser informados.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    /**
     * Va�oda��es referentes aos campos 27
     */
    if ( $oRegistro70->bairro != '' && $iDadosEnderecoInformado < 4 ) {

      $sMsgErro  = "Aluno(a) {$this->sAluno}: \n";
      $sMsgErro .= "Ao preencher o bairro do endere�o residencial, os campos CEP, Endere�o, UF e Munic�pio ";
      $sMsgErro .= "devem ser informados.";
      $this->oExportacaoCenso->logErro($sMsgErro, ExportacaoCensoBase::LOG_ALUNO);
      $lValidou = false;
    }

    return $lValidou;
  }
}