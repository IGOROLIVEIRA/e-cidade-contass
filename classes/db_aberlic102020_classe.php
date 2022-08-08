<?
//MODULO: sicom
//CLASSE DA ENTIDADE aberlic102020
class cl_aberlic102020
{
  // cria variaveis de erro
  var $rotulo = null;
  var $query_sql = null;
  var $numrows = 0;
  var $numrows_incluir = 0;
  var $numrows_alterar = 0;
  var $numrows_excluir = 0;
  var $erro_status = null;
  var $erro_sql = null;
  var $erro_banco = null;
  var $erro_msg = null;
  var $erro_campo = null;
  var $pagina_retorno = null;
  // cria variaveis do arquivo
  var $si46_sequencial = 0;
  var $si46_tiporegistro = 0;
  var $si46_tipocadastro = 1;
  var $si46_codorgaoresp = null;
  var $si46_codunidadesubresp = null;
  var $si46_exerciciolicitacao = 0;
  var $si46_nroprocessolicitatorio = null;
  var $si46_codmodalidadelicitacao = 0;
  var $si46_nroedital = 0;
  var $si46_exercicioedital = 0;
  var $si46_naturezaprocedimento = 0;
  var $si46_dtabertura_dia = null;
  var $si46_dtabertura_mes = null;
  var $si46_dtabertura_ano = null;
  var $si46_dtabertura = null;
  var $si46_dteditalconvite_dia = null;
  var $si46_dteditalconvite_mes = null;
  var $si46_dteditalconvite_ano = null;
  var $si46_dteditalconvite = null;
  var $si46_dtpublicacaoeditaldo_dia = null;
  var $si46_dtpublicacaoeditaldo_mes = null;
  var $si46_dtpublicacaoeditaldo_ano = null;
  var $si46_dtpublicacaoeditaldo = null;
  var $si46_dtpublicacaoeditalveiculo1_dia = null;
  var $si46_dtpublicacaoeditalveiculo1_mes = null;
  var $si46_dtpublicacaoeditalveiculo1_ano = null;
  var $si46_dtpublicacaoeditalveiculo1 = null;
  var $si46_veiculo1publicacao = null;
  var $si46_dtpublicacaoeditalveiculo2_dia = null;
  var $si46_dtpublicacaoeditalveiculo2_mes = null;
  var $si46_dtpublicacaoeditalveiculo2_ano = null;
  var $si46_dtpublicacaoeditalveiculo2 = null;
  var $si46_veiculo2publicacao = null;
  var $si46_dtrecebimentodoc_dia = null;
  var $si46_dtrecebimentodoc_mes = null;
  var $si46_dtrecebimentodoc_ano = null;
  var $si46_dtrecebimentodoc = null;
  var $si46_tipolicitacao = 0;
  var $si46_naturezaobjeto = 0;
  var $si46_objeto = null;
  var $si46_regimeexecucaoobras = 0;
  var $si46_nroconvidado = 0;
  var $si46_clausulaprorrogacao = null;
  var $si46_unidademedidaprazoexecucao = 0;
  var $si46_prazoexecucao = 0;
  var $si46_formapagamento = null;
  var $si46_criterioaceitabilidade = null;
  var $si46_criterioadjudicacao = null;
  var $si46_processoporlote = 0;
  var $si46_criteriodesempate = 0;
  var $si46_destinacaoexclusiva = 0;
  var $si46_subcontratacao = 0;
  var $si46_limitecontratacao = 0;
  var $si46_mes = 0;
  var $si46_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si46_sequencial = int8 = sequencial
                 si46_tiporegistro = int8 = Tipo do registro
                 si46_tipocadastro = int8 = Tipo de cadastro
                 si46_codorgaoresp = varchar(2) = Código do órgão
                 si46_codunidadesubresp = varchar(8) = Código da unidade
                 si46_exerciciolicitacao = int8 = Exercício
                 si46_exercicioedital = int8 = Exercício Edital
                 si46_nroprocessolicitatorio = varchar(12) = Número sequencial do processo
                 si46_codmodalidadelicitacao = int8 = Modalidade da Licitação
                 si46_nroedital = int8 = Número sequencial do edital por exercício
                 si46_naturezaprocedimento = int8 = Natureza do Procedimento
                 si46_dtabertura = date = Data de abertura
                 si46_dteditalconvite = date = Data de emissão
                 si46_dtpublicacaoeditaldo = date = Data de publicação do edital
                 si46_dtpublicacaoeditalveiculo1 = date = Data de Publicação do edital no veículo
                 si46_veiculo1publicacao = varchar(50) = Nome do veículo   de divulgação
                 si46_dtpublicacaoeditalveiculo2 = date = Data de Publicação    do edital
                 si46_veiculo2publicacao = varchar(50) = Nome do veículo
                 si46_dtrecebimentodoc = date = Data prevista para  recebimento
                 si46_tipolicitacao = int8 = Tipo de licitação
                 si46_naturezaobjeto = int8 = Natureza do objeto
                 si46_objeto = varchar(500) = Objeto da licitação
                 si46_regimeexecucaoobras = int8 = Regime de  execução para    obras
                 si46_nroconvidado = int8 = Número de   convidados
                 si46_clausulaprorrogacao = varchar(250) = se  existente a  cláusula de   prorrogação
                 si46_unidademedidaprazoexecucao = int8 = Unidade de medida
                 si46_prazoexecucao = int8 = Prazo para entrega  do objeto
                 si46_formapagamento = varchar(80) = Descrição da forma    de pagamento
                 si46_criterioaceitabilidade = varchar(80) = Descrição do critério de aceitabilidade
                 si46_criterioadjudicacao = int8 = Informar critério de adjudicação
                 si46_processoporlote = int8 = Informar
                 si46_criteriodesempate = int8 = Licitação com    preferência
                 si46_destinacaoexclusiva = int8 = Destinação exclusiva
                 si46_subcontratacao = int8 = Subcontratação
                 si46_limitecontratacao = int8 = Limite para a  contratação
                 si46_mes = int8 = Mês
                 si46_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_aberlic102020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aberlic102020");
    $this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }

  //funcao erro
  function erro($mostra, $retorna)
  {
    if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
      echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
      if ($retorna == true) {
        echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
      }
    }
  }

  // funcao para atualizar campos
  function atualizacampos($exclusao = false)
  {
    if ($exclusao == false) {
      $this->si46_sequencial = ($this->si46_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_sequencial"] : $this->si46_sequencial);
      $this->si46_tiporegistro = ($this->si46_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_tiporegistro"] : $this->si46_tiporegistro);
      $this->si46_tipocadastro = ($this->si46_tipocadastro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_tipocadastro"] : $this->si46_tipocadastro);
      $this->si46_codorgaoresp = ($this->si46_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_codorgaoresp"] : $this->si46_codorgaoresp);
      $this->si46_codunidadesubresp = ($this->si46_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_codunidadesubresp"] : $this->si46_codunidadesubresp);
      $this->si46_exerciciolicitacao = ($this->si46_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_exerciciolicitacao"] : $this->si46_exerciciolicitacao);
      $this->si46_exercicioedital = ($this->si46_exercicioedital == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_exercicioedital"] : $this->si46_exercicioedital);
      $this->si46_nroprocessolicitatorio = ($this->si46_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_nroprocessolicitatorio"] : $this->si46_nroprocessolicitatorio);
      $this->si46_codmodalidadelicitacao = ($this->si46_codmodalidadelicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_codmodalidadelicitacao"] : $this->si46_codmodalidadelicitacao);
      $this->si46_nroedital = ($this->si46_nroedital == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_nroedital"] : $this->si46_nroedital);
      $this->si46_naturezaprocedimento = ($this->si46_naturezaprocedimento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_naturezaprocedimento"] : $this->si46_naturezaprocedimento);
      if ($this->si46_dtabertura == "") {
        $this->si46_dtabertura_dia = ($this->si46_dtabertura_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtabertura_dia"] : $this->si46_dtabertura_dia);
        $this->si46_dtabertura_mes = ($this->si46_dtabertura_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtabertura_mes"] : $this->si46_dtabertura_mes);
        $this->si46_dtabertura_ano = ($this->si46_dtabertura_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtabertura_ano"] : $this->si46_dtabertura_ano);
        if ($this->si46_dtabertura_dia != "") {
          $this->si46_dtabertura = $this->si46_dtabertura_ano . "-" . $this->si46_dtabertura_mes . "-" . $this->si46_dtabertura_dia;
        }
      }
      if ($this->si46_dteditalconvite == "") {
        $this->si46_dteditalconvite_dia = ($this->si46_dteditalconvite_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dteditalconvite_dia"] : $this->si46_dteditalconvite_dia);
        $this->si46_dteditalconvite_mes = ($this->si46_dteditalconvite_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dteditalconvite_mes"] : $this->si46_dteditalconvite_mes);
        $this->si46_dteditalconvite_ano = ($this->si46_dteditalconvite_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dteditalconvite_ano"] : $this->si46_dteditalconvite_ano);
        if ($this->si46_dteditalconvite_dia != "") {
          $this->si46_dteditalconvite = $this->si46_dteditalconvite_ano . "-" . $this->si46_dteditalconvite_mes . "-" . $this->si46_dteditalconvite_dia;
        }
      }
      if ($this->si46_dtpublicacaoeditaldo == "") {
        $this->si46_dtpublicacaoeditaldo_dia = ($this->si46_dtpublicacaoeditaldo_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditaldo_dia"] : $this->si46_dtpublicacaoeditaldo_dia);
        $this->si46_dtpublicacaoeditaldo_mes = ($this->si46_dtpublicacaoeditaldo_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditaldo_mes"] : $this->si46_dtpublicacaoeditaldo_mes);
        $this->si46_dtpublicacaoeditaldo_ano = ($this->si46_dtpublicacaoeditaldo_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditaldo_ano"] : $this->si46_dtpublicacaoeditaldo_ano);
        if ($this->si46_dtpublicacaoeditaldo_dia != "") {
          $this->si46_dtpublicacaoeditaldo = $this->si46_dtpublicacaoeditaldo_ano . "-" . $this->si46_dtpublicacaoeditaldo_mes . "-" . $this->si46_dtpublicacaoeditaldo_dia;
        }
      }
      if ($this->si46_dtpublicacaoeditalveiculo1 == "") {
        $this->si46_dtpublicacaoeditalveiculo1_dia = ($this->si46_dtpublicacaoeditalveiculo1_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo1_dia"] : $this->si46_dtpublicacaoeditalveiculo1_dia);
        $this->si46_dtpublicacaoeditalveiculo1_mes = ($this->si46_dtpublicacaoeditalveiculo1_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo1_mes"] : $this->si46_dtpublicacaoeditalveiculo1_mes);
        $this->si46_dtpublicacaoeditalveiculo1_ano = ($this->si46_dtpublicacaoeditalveiculo1_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo1_ano"] : $this->si46_dtpublicacaoeditalveiculo1_ano);
        if ($this->si46_dtpublicacaoeditalveiculo1_dia != "") {
          $this->si46_dtpublicacaoeditalveiculo1 = $this->si46_dtpublicacaoeditalveiculo1_ano . "-" . $this->si46_dtpublicacaoeditalveiculo1_mes . "-" . $this->si46_dtpublicacaoeditalveiculo1_dia;
        }
      }
      $this->si46_veiculo1publicacao = ($this->si46_veiculo1publicacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_veiculo1publicacao"] : $this->si46_veiculo1publicacao);
      if ($this->si46_dtpublicacaoeditalveiculo2 == "") {
        $this->si46_dtpublicacaoeditalveiculo2_dia = ($this->si46_dtpublicacaoeditalveiculo2_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo2_dia"] : $this->si46_dtpublicacaoeditalveiculo2_dia);
        $this->si46_dtpublicacaoeditalveiculo2_mes = ($this->si46_dtpublicacaoeditalveiculo2_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo2_mes"] : $this->si46_dtpublicacaoeditalveiculo2_mes);
        $this->si46_dtpublicacaoeditalveiculo2_ano = ($this->si46_dtpublicacaoeditalveiculo2_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo2_ano"] : $this->si46_dtpublicacaoeditalveiculo2_ano);
        if ($this->si46_dtpublicacaoeditalveiculo2_dia != "") {
          $this->si46_dtpublicacaoeditalveiculo2 = $this->si46_dtpublicacaoeditalveiculo2_ano . "-" . $this->si46_dtpublicacaoeditalveiculo2_mes . "-" . $this->si46_dtpublicacaoeditalveiculo2_dia;
        }
      }
      $this->si46_veiculo2publicacao = ($this->si46_veiculo2publicacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_veiculo2publicacao"] : $this->si46_veiculo2publicacao);
      if ($this->si46_dtrecebimentodoc == "") {
        $this->si46_dtrecebimentodoc_dia = ($this->si46_dtrecebimentodoc_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtrecebimentodoc_dia"] : $this->si46_dtrecebimentodoc_dia);
        $this->si46_dtrecebimentodoc_mes = ($this->si46_dtrecebimentodoc_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtrecebimentodoc_mes"] : $this->si46_dtrecebimentodoc_mes);
        $this->si46_dtrecebimentodoc_ano = ($this->si46_dtrecebimentodoc_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_dtrecebimentodoc_ano"] : $this->si46_dtrecebimentodoc_ano);
        if ($this->si46_dtrecebimentodoc_dia != "") {
          $this->si46_dtrecebimentodoc = $this->si46_dtrecebimentodoc_ano . "-" . $this->si46_dtrecebimentodoc_mes . "-" . $this->si46_dtrecebimentodoc_dia;
        }
      }
      $this->si46_tipolicitacao = ($this->si46_tipolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_tipolicitacao"] : $this->si46_tipolicitacao);
      $this->si46_naturezaobjeto = ($this->si46_naturezaobjeto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_naturezaobjeto"] : $this->si46_naturezaobjeto);
      $this->si46_objeto = ($this->si46_objeto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_objeto"] : $this->si46_objeto);
      $this->si46_regimeexecucaoobras = ($this->si46_regimeexecucaoobras == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_regimeexecucaoobras"] : $this->si46_regimeexecucaoobras);
      $this->si46_nroconvidado = ($this->si46_nroconvidado == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_nroconvidado"] : $this->si46_nroconvidado);
      $this->si46_clausulaprorrogacao = ($this->si46_clausulaprorrogacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_clausulaprorrogacao"] : $this->si46_clausulaprorrogacao);
      $this->si46_unidademedidaprazoexecucao = ($this->si46_unidademedidaprazoexecucao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_unidademedidaprazoexecucao"] : $this->si46_unidademedidaprazoexecucao);
      $this->si46_prazoexecucao = ($this->si46_prazoexecucao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_prazoexecucao"] : $this->si46_prazoexecucao);
      $this->si46_formapagamento = ($this->si46_formapagamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_formapagamento"] : $this->si46_formapagamento);
      $this->si46_criterioaceitabilidade = ($this->si46_criterioaceitabilidade == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_criterioaceitabilidade"] : $this->si46_criterioaceitabilidade);
      $this->si46_criterioadjudicacao = ($this->si46_criterioadjudicacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_criterioadjudicacao"] : $this->si46_criterioadjudicacao);
      $this->si46_processoporlote = ($this->si46_processoporlote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_processoporlote"] : $this->si46_processoporlote);
      $this->si46_criteriodesempate = ($this->si46_criteriodesempate == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_criteriodesempate"] : $this->si46_criteriodesempate);
      $this->si46_destinacaoexclusiva = ($this->si46_destinacaoexclusiva == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_destinacaoexclusiva"] : $this->si46_destinacaoexclusiva);
      $this->si46_subcontratacao = ($this->si46_subcontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_subcontratacao"] : $this->si46_subcontratacao);
      $this->si46_limitecontratacao = ($this->si46_limitecontratacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_limitecontratacao"] : $this->si46_limitecontratacao);
      $this->si46_mes = ($this->si46_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_mes"] : $this->si46_mes);
      $this->si46_instit = ($this->si46_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_instit"] : $this->si46_instit);
    } else {
      $this->si46_sequencial = ($this->si46_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si46_sequencial"] : $this->si46_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si46_sequencial)
  {
    $this->atualizacampos();
    if ($this->si46_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si46_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si46_tipocadastro == null) {
      $this->si46_tipocadastro = 1;
    }
    if ($this->si46_exerciciolicitacao == null) {
      $this->si46_exerciciolicitacao = "0";
    }
    if ($this->si46_exercicioedital == null) {
      $this->si46_exercicioedital = "0";
    }
    if ($this->si46_codmodalidadelicitacao == null) {
      $this->si46_codmodalidadelicitacao = "0";
    }
    if ($this->si46_nroedital == null) {
      $this->si46_nroedital = "0";
    }
    if ($this->si46_naturezaprocedimento == null) {
      $this->si46_naturezaprocedimento = "0";
    }
    if ($this->si46_dtabertura == null) {
      $this->si46_dtabertura = "null";
    }
    if ($this->si46_dteditalconvite == null) {
      $this->si46_dteditalconvite = "null";
    }
    if ($this->si46_dtpublicacaoeditaldo == null) {
      $this->si46_dtpublicacaoeditaldo = "null";
    }
    if ($this->si46_dtpublicacaoeditalveiculo1 == null) {
      $this->si46_dtpublicacaoeditalveiculo1 = "null";
    }
    if ($this->si46_dtpublicacaoeditalveiculo2 == null) {
      $this->si46_dtpublicacaoeditalveiculo2 = "null";
    }
    if ($this->si46_dtrecebimentodoc == null) {
      $this->si46_dtrecebimentodoc = "null";
    }
    if ($this->si46_tipolicitacao == null) {
      $this->si46_tipolicitacao = "0";
    }
    if ($this->si46_naturezaobjeto == null) {
      $this->si46_naturezaobjeto = "0";
    }
    if ($this->si46_regimeexecucaoobras == null) {
      $this->si46_regimeexecucaoobras = "0";
    }
    if ($this->si46_nroconvidado == null) {
      $this->si46_nroconvidado = "0";
    }
    if ($this->si46_unidademedidaprazoexecucao == null) {
      $this->si46_unidademedidaprazoexecucao = "0";
    }
    if ($this->si46_prazoexecucao == null) {
      $this->si46_prazoexecucao = "0";
    }
    if ($this->si46_criterioadjudicacao == null) {
      $this->si46_criterioadjudicacao = "3";
    }
    if ($this->si46_processoporlote == null) {
      $this->si46_processoporlote = "0";
    }
    if ($this->si46_criteriodesempate == null) {
      $this->si46_criteriodesempate = "0";
    }
    if ($this->si46_destinacaoexclusiva == null) {
      $this->si46_destinacaoexclusiva = "0";
    }
    if ($this->si46_subcontratacao == null) {
      $this->si46_subcontratacao = "0";
    }
    if ($this->si46_limitecontratacao == null) {
      $this->si46_limitecontratacao = "0";
    }
    if ($this->si46_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si46_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si46_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si46_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si46_sequencial == "" || $si46_sequencial == null) {
      $result = db_query("select nextval('aberlic102020_si46_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aberlic102020_si46_sequencial_seq do campo: si46_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si46_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aberlic102020_si46_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si46_sequencial)) {
        $this->erro_sql = " Campo si46_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si46_sequencial = $si46_sequencial;
      }
    }
    if (($this->si46_sequencial == null) || ($this->si46_sequencial == "")) {
      $this->erro_sql = " Campo si46_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aberlic102020(
                                       si46_sequencial
                                      ,si46_tiporegistro
                                      ,si46_tipocadastro
                                      ,si46_codorgaoresp
                                      ,si46_codunidadesubresp
                                      ,si46_exerciciolicitacao
                                      ,si46_nroprocessolicitatorio
                                      ,si46_codmodalidadelicitacao
                                      ,si46_nroedital
                                      ,si46_naturezaprocedimento
                                      ,si46_dtabertura
                                      ,si46_dteditalconvite
                                      ,si46_dtpublicacaoeditaldo
                                      ,si46_dtpublicacaoeditalveiculo1
                                      ,si46_veiculo1publicacao
                                      ,si46_dtpublicacaoeditalveiculo2
                                      ,si46_veiculo2publicacao
                                      ,si46_dtrecebimentodoc
                                      ,si46_tipolicitacao
                                      ,si46_naturezaobjeto
                                      ,si46_objeto
                                      ,si46_regimeexecucaoobras
                                      ,si46_nroconvidado
                                      ,si46_clausulaprorrogacao
                                      ,si46_unidademedidaprazoexecucao
                                      ,si46_prazoexecucao
                                      ,si46_formapagamento
                                      ,si46_criterioaceitabilidade
                                      ,si46_criterioadjudicacao
                                      ,si46_processoporlote
                                      ,si46_criteriodesempate
                                      ,si46_destinacaoexclusiva
                                      ,si46_subcontratacao
                                      ,si46_limitecontratacao
                                      ,si46_exercicioedital
                                      ,si46_mes
                                      ,si46_instit
                       )
                values (
                                $this->si46_sequencial
                               ,$this->si46_tiporegistro
                               ,$this->si46_tipocadastro
                               ,'$this->si46_codorgaoresp'
                               ,'$this->si46_codunidadesubresp'
                               ,$this->si46_exerciciolicitacao
                               ,'$this->si46_nroprocessolicitatorio'
                               ,$this->si46_codmodalidadelicitacao
                               ,$this->si46_nroedital
                               ,$this->si46_naturezaprocedimento
                               ," . ($this->si46_dtabertura == "null" || $this->si46_dtabertura == "" ? "null" : "'" . $this->si46_dtabertura . "'") . "
                               ," . ($this->si46_dteditalconvite == "null" || $this->si46_dteditalconvite == "" ? "null" : "'" . $this->si46_dteditalconvite . "'") . "
                               ," . ($this->si46_dtpublicacaoeditaldo == "null" || $this->si46_dtpublicacaoeditaldo == "" ? "null" : "'" . $this->si46_dtpublicacaoeditaldo . "'") . "
                               ," . ($this->si46_dtpublicacaoeditalveiculo1 == "null" || $this->si46_dtpublicacaoeditalveiculo1 == "" ? "null" : "'" . $this->si46_dtpublicacaoeditalveiculo1 . "'") . "
                               ,'$this->si46_veiculo1publicacao'
                               ," . ($this->si46_dtpublicacaoeditalveiculo2 == "null" || $this->si46_dtpublicacaoeditalveiculo2 == "" ? "null" : "'" . $this->si46_dtpublicacaoeditalveiculo2 . "'") . "
                               ,'$this->si46_veiculo2publicacao'
                               ," . ($this->si46_dtrecebimentodoc == "null" || $this->si46_dtrecebimentodoc == "" ? "null" : "'" . $this->si46_dtrecebimentodoc . "'") . "
                               ,$this->si46_tipolicitacao
                               ,$this->si46_naturezaobjeto
                               ,'$this->si46_objeto'
                               ,$this->si46_regimeexecucaoobras
                               ,$this->si46_nroconvidado
                               ,'$this->si46_clausulaprorrogacao'
                               ,$this->si46_unidademedidaprazoexecucao
                               ,$this->si46_prazoexecucao
                               ,'$this->si46_formapagamento'
                               ,'$this->si46_criterioaceitabilidade'
                               ,$this->si46_criterioadjudicacao
                               ,$this->si46_processoporlote
                               ,$this->si46_criteriodesempate
                               ,$this->si46_destinacaoexclusiva
                               ,$this->si46_subcontratacao
                               ,$this->si46_limitecontratacao
                               ,$this->si46_exercicioedital
                               ,$this->si46_mes
                               ,$this->si46_instit
                      )";
    
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aberlic102020 ($this->si46_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aberlic102020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aberlic102020 ($this->si46_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si46_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    // $resaco = $this->sql_record($this->sql_query_file($this->si46_sequencial));
    // if (($resaco != false) || ($this->numrows != 0)) {
    //   $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //   $acount = pg_result($resac, 0, 0);
    //   $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
    //   $resac = db_query("insert into db_acountkey values($acount,2009863,'$this->si46_sequencial','I')");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009863,'','" . AddSlashes(pg_result($resaco, 0, 'si46_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009864,'','" . AddSlashes(pg_result($resaco, 0, 'si46_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009865,'','" . AddSlashes(pg_result($resaco, 0, 'si46_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009866,'','" . AddSlashes(pg_result($resaco, 0, 'si46_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009867,'','" . AddSlashes(pg_result($resaco, 0, 'si46_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009868,'','" . AddSlashes(pg_result($resaco, 0, 'si46_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009869,'','" . AddSlashes(pg_result($resaco, 0, 'si46_codmodalidadelicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009870,'','" . AddSlashes(pg_result($resaco, 0, 'si46_nroedital')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009871,'','" . AddSlashes(pg_result($resaco, 0, 'si46_naturezaprocedimento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009872,'','" . AddSlashes(pg_result($resaco, 0, 'si46_dtabertura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009873,'','" . AddSlashes(pg_result($resaco, 0, 'si46_dteditalconvite')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009875,'','" . AddSlashes(pg_result($resaco, 0, 'si46_dtpublicacaoeditaldo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009876,'','" . AddSlashes(pg_result($resaco, 0, 'si46_dtpublicacaoeditalveiculo1')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009877,'','" . AddSlashes(pg_result($resaco, 0, 'si46_veiculo1publicacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009878,'','" . AddSlashes(pg_result($resaco, 0, 'si46_dtpublicacaoeditalveiculo2')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009879,'','" . AddSlashes(pg_result($resaco, 0, 'si46_veiculo2publicacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009880,'','" . AddSlashes(pg_result($resaco, 0, 'si46_dtrecebimentodoc')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009881,'','" . AddSlashes(pg_result($resaco, 0, 'si46_tipolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009882,'','" . AddSlashes(pg_result($resaco, 0, 'si46_naturezaobjeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009883,'','" . AddSlashes(pg_result($resaco, 0, 'si46_objeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009884,'','" . AddSlashes(pg_result($resaco, 0, 'si46_regimeexecucaoobras')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009885,'','" . AddSlashes(pg_result($resaco, 0, 'si46_nroconvidado')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009886,'','" . AddSlashes(pg_result($resaco, 0, 'si46_clausulaprorrogacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009887,'','" . AddSlashes(pg_result($resaco, 0, 'si46_unidademedidaprazoexecucao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009888,'','" . AddSlashes(pg_result($resaco, 0, 'si46_prazoexecucao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009889,'','" . AddSlashes(pg_result($resaco, 0, 'si46_formapagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009891,'','" . AddSlashes(pg_result($resaco, 0, 'si46_criterioaceitabilidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009892,'','" . AddSlashes(pg_result($resaco, 0, 'si46_criterioadjudicacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009893,'','" . AddSlashes(pg_result($resaco, 0, 'si46_processoporlote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009894,'','" . AddSlashes(pg_result($resaco, 0, 'si46_criteriodesempate')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009895,'','" . AddSlashes(pg_result($resaco, 0, 'si46_destinacaoexclusiva')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009896,'','" . AddSlashes(pg_result($resaco, 0, 'si46_subcontratacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009897,'','" . AddSlashes(pg_result($resaco, 0, 'si46_limitecontratacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2009898,'','" . AddSlashes(pg_result($resaco, 0, 'si46_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010275,2011560,'','" . AddSlashes(pg_result($resaco, 0, 'si46_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    // }

    return true;
  }

  // funcao para alteracao
  function alterar($si46_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aberlic102020 set ";
    $virgula = "";
    if (trim($this->si46_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_sequencial"])) {
      if (trim($this->si46_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_sequencial"])) {
        $this->si46_sequencial = "0";
      }
      $sql .= $virgula . " si46_sequencial = $this->si46_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si46_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_tiporegistro"])) {
      $sql .= $virgula . " si46_tiporegistro = $this->si46_tiporegistro ";
      $virgula = ",";
      if (trim($this->si46_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si46_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si46_tipocadastro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_tipocadastro"])) {
      $sql .= $virgula . " si46_tipocadastro = $this->si46_tipocadastro ";
      $virgula = ",";
      if (trim($this->si46_tipocadastro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si46_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si46_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_codorgaoresp"])) {
      $sql .= $virgula . " si46_codorgaoresp = '$this->si46_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si46_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_codunidadesubresp"])) {
      $sql .= $virgula . " si46_codunidadesubresp = '$this->si46_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si46_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_exerciciolicitacao"])) {
      if (trim($this->si46_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_exerciciolicitacao"])) {
        $this->si46_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si46_exerciciolicitacao = $this->si46_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si46_exercicioedital) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_exercicioedital"])) {
      if (trim($this->si46_exercicioedital) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_exercicioedital"])) {
        $this->si46_exercicioedital = "0";
      }
      $sql .= $virgula . " si46_exercicioedital = $this->si46_exercicioedital ";
      $virgula = ",";
    }
    if (trim($this->si46_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si46_nroprocessolicitatorio = '$this->si46_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si46_codmodalidadelicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_codmodalidadelicitacao"])) {
      if (trim($this->si46_codmodalidadelicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_codmodalidadelicitacao"])) {
        $this->si46_codmodalidadelicitacao = "0";
      }
      $sql .= $virgula . " si46_codmodalidadelicitacao = $this->si46_codmodalidadelicitacao ";
      $virgula = ",";
    }
    if (trim($this->si46_nroedital) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_nroedital"])) {
      if (trim($this->si46_nroedital) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_nroedital"])) {
        $this->si46_nroedital = "0";
      }
      $sql .= $virgula . " si46_nroedital = $this->si46_nroedital ";
      $virgula = ",";
    }
    if (trim($this->si46_naturezaprocedimento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_naturezaprocedimento"])) {
      if (trim($this->si46_naturezaprocedimento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_naturezaprocedimento"])) {
        $this->si46_naturezaprocedimento = "0";
      }
      $sql .= $virgula . " si46_naturezaprocedimento = $this->si46_naturezaprocedimento ";
      $virgula = ",";
    }
    if (trim($this->si46_dtabertura) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_dtabertura_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si46_dtabertura_dia"] != "")) {
      $sql .= $virgula . " si46_dtabertura = '$this->si46_dtabertura' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dtabertura_dia"])) {
        $sql .= $virgula . " si46_dtabertura = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si46_dteditalconvite) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_dteditalconvite_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si46_dteditalconvite_dia"] != "")) {
      $sql .= $virgula . " si46_dteditalconvite = '$this->si46_dteditalconvite' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dteditalconvite_dia"])) {
        $sql .= $virgula . " si46_dteditalconvite = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si46_dtpublicacaoeditaldo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditaldo_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditaldo_dia"] != "")) {
      $sql .= $virgula . " si46_dtpublicacaoeditaldo = '$this->si46_dtpublicacaoeditaldo' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditaldo_dia"])) {
        $sql .= $virgula . " si46_dtpublicacaoeditaldo = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si46_dtpublicacaoeditalveiculo1) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo1_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo1_dia"] != "")) {
      $sql .= $virgula . " si46_dtpublicacaoeditalveiculo1 = '$this->si46_dtpublicacaoeditalveiculo1' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo1_dia"])) {
        $sql .= $virgula . " si46_dtpublicacaoeditalveiculo1 = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si46_veiculo1publicacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_veiculo1publicacao"])) {
      $sql .= $virgula . " si46_veiculo1publicacao = '$this->si46_veiculo1publicacao' ";
      $virgula = ",";
    }
    if (trim($this->si46_dtpublicacaoeditalveiculo2) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo2_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo2_dia"] != "")) {
      $sql .= $virgula . " si46_dtpublicacaoeditalveiculo2 = '$this->si46_dtpublicacaoeditalveiculo2' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo2_dia"])) {
        $sql .= $virgula . " si46_dtpublicacaoeditalveiculo2 = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si46_veiculo2publicacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_veiculo2publicacao"])) {
      $sql .= $virgula . " si46_veiculo2publicacao = '$this->si46_veiculo2publicacao' ";
      $virgula = ",";
    }
    if (trim($this->si46_dtrecebimentodoc) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_dtrecebimentodoc_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si46_dtrecebimentodoc_dia"] != "")) {
      $sql .= $virgula . " si46_dtrecebimentodoc = '$this->si46_dtrecebimentodoc' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dtrecebimentodoc_dia"])) {
        $sql .= $virgula . " si46_dtrecebimentodoc = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si46_tipolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_tipolicitacao"])) {
      if (trim($this->si46_tipolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_tipolicitacao"])) {
        $this->si46_tipolicitacao = "0";
      }
      $sql .= $virgula . " si46_tipolicitacao = $this->si46_tipolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si46_naturezaobjeto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_naturezaobjeto"])) {
      if (trim($this->si46_naturezaobjeto) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_naturezaobjeto"])) {
        $this->si46_naturezaobjeto = "0";
      }
      $sql .= $virgula . " si46_naturezaobjeto = $this->si46_naturezaobjeto ";
      $virgula = ",";
    }
    if (trim($this->si46_objeto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_objeto"])) {
      $sql .= $virgula . " si46_objeto = '$this->si46_objeto' ";
      $virgula = ",";
    }
    if (trim($this->si46_regimeexecucaoobras) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_regimeexecucaoobras"])) {
      if (trim($this->si46_regimeexecucaoobras) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_regimeexecucaoobras"])) {
        $this->si46_regimeexecucaoobras = "0";
      }
      $sql .= $virgula . " si46_regimeexecucaoobras = $this->si46_regimeexecucaoobras ";
      $virgula = ",";
    }
    if (trim($this->si46_nroconvidado) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_nroconvidado"])) {
      if (trim($this->si46_nroconvidado) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_nroconvidado"])) {
        $this->si46_nroconvidado = "0";
      }
      $sql .= $virgula . " si46_nroconvidado = $this->si46_nroconvidado ";
      $virgula = ",";
    }
    if (trim($this->si46_clausulaprorrogacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_clausulaprorrogacao"])) {
      $sql .= $virgula . " si46_clausulaprorrogacao = '$this->si46_clausulaprorrogacao' ";
      $virgula = ",";
    }
    if (trim($this->si46_unidademedidaprazoexecucao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_unidademedidaprazoexecucao"])) {
      if (trim($this->si46_unidademedidaprazoexecucao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_unidademedidaprazoexecucao"])) {
        $this->si46_unidademedidaprazoexecucao = "0";
      }
      $sql .= $virgula . " si46_unidademedidaprazoexecucao = $this->si46_unidademedidaprazoexecucao ";
      $virgula = ",";
    }
    if (trim($this->si46_prazoexecucao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_prazoexecucao"])) {
      if (trim($this->si46_prazoexecucao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_prazoexecucao"])) {
        $this->si46_prazoexecucao = "0";
      }
      $sql .= $virgula . " si46_prazoexecucao = $this->si46_prazoexecucao ";
      $virgula = ",";
    }
    if (trim($this->si46_formapagamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_formapagamento"])) {
      $sql .= $virgula . " si46_formapagamento = '$this->si46_formapagamento' ";
      $virgula = ",";
    }
    if (trim($this->si46_criterioaceitabilidade) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_criterioaceitabilidade"])) {
      $sql .= $virgula . " si46_criterioaceitabilidade = '$this->si46_criterioaceitabilidade' ";
      $virgula = ",";
    }
    if (trim($this->si46_criterioadjudicacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_criterioadjudicacao"])) {
      $sql .= $virgula . " si46_criterioadjudicacao = $this->si46_criterioadjudicacao ";
      $virgula = ",";
    }
    if (trim($this->si46_processoporlote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_processoporlote"])) {
      if (trim($this->si46_processoporlote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_processoporlote"])) {
        $this->si46_processoporlote = "0";
      }
      $sql .= $virgula . " si46_processoporlote = $this->si46_processoporlote ";
      $virgula = ",";
    }
    if (trim($this->si46_criteriodesempate) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_criteriodesempate"])) {
      if (trim($this->si46_criteriodesempate) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_criteriodesempate"])) {
        $this->si46_criteriodesempate = "0";
      }
      $sql .= $virgula . " si46_criteriodesempate = $this->si46_criteriodesempate ";
      $virgula = ",";
    }
    if (trim($this->si46_destinacaoexclusiva) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_destinacaoexclusiva"])) {
      if (trim($this->si46_destinacaoexclusiva) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_destinacaoexclusiva"])) {
        $this->si46_destinacaoexclusiva = "0";
      }
      $sql .= $virgula . " si46_destinacaoexclusiva = $this->si46_destinacaoexclusiva ";
      $virgula = ",";
    }
    if (trim($this->si46_subcontratacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_subcontratacao"])) {
      if (trim($this->si46_subcontratacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_subcontratacao"])) {
        $this->si46_subcontratacao = "0";
      }
      $sql .= $virgula . " si46_subcontratacao = $this->si46_subcontratacao ";
      $virgula = ",";
    }
    if (trim($this->si46_limitecontratacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_limitecontratacao"])) {
      if (trim($this->si46_limitecontratacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si46_limitecontratacao"])) {
        $this->si46_limitecontratacao = "0";
      }
      $sql .= $virgula . " si46_limitecontratacao = $this->si46_limitecontratacao ";
      $virgula = ",";
    }
    if (trim($this->si46_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_mes"])) {
      $sql .= $virgula . " si46_mes = $this->si46_mes ";
      $virgula = ",";
      if (trim($this->si46_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si46_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si46_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si46_instit"])) {
      $sql .= $virgula . " si46_instit = $this->si46_instit ";
      $virgula = ",";
      if (trim($this->si46_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si46_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si46_sequencial != null) {
      $sql .= " si46_sequencial = $this->si46_sequencial";
    }
    // $resaco = $this->sql_record($this->sql_query_file($this->si46_sequencial));
    // if ($this->numrows > 0) {
    //   for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
    //     $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //     $acount = pg_result($resac, 0, 0);
    //     $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
    //     $resac = db_query("insert into db_acountkey values($acount,2009863,'$this->si46_sequencial','A')");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_sequencial"]) || $this->si46_sequencial != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009863,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_sequencial')) . "','$this->si46_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_tiporegistro"]) || $this->si46_tiporegistro != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009864,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_tiporegistro')) . "','$this->si46_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_codorgaoresp"]) || $this->si46_codorgaoresp != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009865,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_codorgaoresp')) . "','$this->si46_codorgaoresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_codunidadesubresp"]) || $this->si46_codunidadesubresp != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009866,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_codunidadesubresp')) . "','$this->si46_codunidadesubresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_exerciciolicitacao"]) || $this->si46_exerciciolicitacao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009867,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_exerciciolicitacao')) . "','$this->si46_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_nroprocessolicitatorio"]) || $this->si46_nroprocessolicitatorio != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009868,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_nroprocessolicitatorio')) . "','$this->si46_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_codmodalidadelicitacao"]) || $this->si46_codmodalidadelicitacao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009869,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_codmodalidadelicitacao')) . "','$this->si46_codmodalidadelicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_nroedital"]) || $this->si46_nroedital != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009870,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_nroedital')) . "','$this->si46_nroedital'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_naturezaprocedimento"]) || $this->si46_naturezaprocedimento != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009871,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_naturezaprocedimento')) . "','$this->si46_naturezaprocedimento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dtabertura"]) || $this->si46_dtabertura != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009872,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_dtabertura')) . "','$this->si46_dtabertura'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dteditalconvite"]) || $this->si46_dteditalconvite != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009873,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_dteditalconvite')) . "','$this->si46_dteditalconvite'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditaldo"]) || $this->si46_dtpublicacaoeditaldo != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009875,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_dtpublicacaoeditaldo')) . "','$this->si46_dtpublicacaoeditaldo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo1"]) || $this->si46_dtpublicacaoeditalveiculo1 != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009876,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_dtpublicacaoeditalveiculo1')) . "','$this->si46_dtpublicacaoeditalveiculo1'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_veiculo1publicacao"]) || $this->si46_veiculo1publicacao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009877,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_veiculo1publicacao')) . "','$this->si46_veiculo1publicacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dtpublicacaoeditalveiculo2"]) || $this->si46_dtpublicacaoeditalveiculo2 != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009878,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_dtpublicacaoeditalveiculo2')) . "','$this->si46_dtpublicacaoeditalveiculo2'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_veiculo2publicacao"]) || $this->si46_veiculo2publicacao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009879,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_veiculo2publicacao')) . "','$this->si46_veiculo2publicacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_dtrecebimentodoc"]) || $this->si46_dtrecebimentodoc != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009880,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_dtrecebimentodoc')) . "','$this->si46_dtrecebimentodoc'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_tipolicitacao"]) || $this->si46_tipolicitacao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009881,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_tipolicitacao')) . "','$this->si46_tipolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_naturezaobjeto"]) || $this->si46_naturezaobjeto != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009882,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_naturezaobjeto')) . "','$this->si46_naturezaobjeto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_objeto"]) || $this->si46_objeto != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009883,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_objeto')) . "','$this->si46_objeto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_regimeexecucaoobras"]) || $this->si46_regimeexecucaoobras != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009884,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_regimeexecucaoobras')) . "','$this->si46_regimeexecucaoobras'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_nroconvidado"]) || $this->si46_nroconvidado != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009885,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_nroconvidado')) . "','$this->si46_nroconvidado'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_clausulaprorrogacao"]) || $this->si46_clausulaprorrogacao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009886,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_clausulaprorrogacao')) . "','$this->si46_clausulaprorrogacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_unidademedidaprazoexecucao"]) || $this->si46_unidademedidaprazoexecucao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009887,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_unidademedidaprazoexecucao')) . "','$this->si46_unidademedidaprazoexecucao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_prazoexecucao"]) || $this->si46_prazoexecucao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009888,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_prazoexecucao')) . "','$this->si46_prazoexecucao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_formapagamento"]) || $this->si46_formapagamento != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009889,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_formapagamento')) . "','$this->si46_formapagamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_criterioaceitabilidade"]) || $this->si46_criterioaceitabilidade != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009891,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_criterioaceitabilidade')) . "','$this->si46_criterioaceitabilidade'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_criterioadjudicacao"]) || $this->si46_criterioadjudicacao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009892,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_criterioadjudicacao')) . "','$this->si46_criterioadjudicacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_processoporlote"]) || $this->si46_processoporlote != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009893,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_processoporlote')) . "','$this->si46_processoporlote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_criteriodesempate"]) || $this->si46_criteriodesempate != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009894,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_criteriodesempate')) . "','$this->si46_criteriodesempate'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_destinacaoexclusiva"]) || $this->si46_destinacaoexclusiva != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009895,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_destinacaoexclusiva')) . "','$this->si46_destinacaoexclusiva'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_subcontratacao"]) || $this->si46_subcontratacao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009896,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_subcontratacao')) . "','$this->si46_subcontratacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_limitecontratacao"]) || $this->si46_limitecontratacao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009897,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_limitecontratacao')) . "','$this->si46_limitecontratacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_mes"]) || $this->si46_mes != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2009898,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_mes')) . "','$this->si46_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si46_instit"]) || $this->si46_instit != "")
    //       $resac = db_query("insert into db_acount values($acount,2010275,2011560,'" . AddSlashes(pg_result($resaco, $conresaco, 'si46_instit')) . "','$this->si46_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   }
    // }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aberlic102020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si46_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aberlic102020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si46_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si46_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si46_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si46_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    // if (($resaco != false) || ($this->numrows != 0)) {
    //   for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
    //     $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //     $acount = pg_result($resac, 0, 0);
    //     $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
    //     $resac = db_query("insert into db_acountkey values($acount,2009863,'$si46_sequencial','E')");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009863,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009864,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009865,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009866,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009867,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009868,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009869,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_codmodalidadelicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009870,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_nroedital')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009871,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_naturezaprocedimento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009872,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_dtabertura')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009873,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_dteditalconvite')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009875,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_dtpublicacaoeditaldo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009876,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_dtpublicacaoeditalveiculo1')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009877,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_veiculo1publicacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009878,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_dtpublicacaoeditalveiculo2')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009879,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_veiculo2publicacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009880,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_dtrecebimentodoc')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009881,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_tipolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009882,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_naturezaobjeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009883,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_objeto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009884,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_regimeexecucaoobras')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009885,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_nroconvidado')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009886,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_clausulaprorrogacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009887,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_unidademedidaprazoexecucao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009888,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_prazoexecucao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009889,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_formapagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009891,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_criterioaceitabilidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009892,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_criterioadjudicacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009893,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_processoporlote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009894,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_criteriodesempate')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009895,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_destinacaoexclusiva')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009896,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_subcontratacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009897,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_limitecontratacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2009898,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010275,2011560,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si46_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   }
    // }
    $sql = " delete from aberlic102020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si46_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si46_sequencial = $si46_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aberlic102020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si46_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aberlic102020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si46_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si46_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao do recordset
  function sql_record($sql)
  {
    $result = db_query($sql);
    if ($result == false) {
      $this->numrows = 0;
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "Erro ao selecionar os registros.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Record Vazio na Tabela:aberlic102020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si46_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from aberlic102020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si46_sequencial != null) {
        $sql2 .= " where aberlic102020.si46_sequencial = $si46_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }

  // funcao do sql
  function sql_query_file($si46_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from aberlic102020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si46_sequencial != null) {
        $sql2 .= " where aberlic102020.si46_sequencial = $si46_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }
}

?>
