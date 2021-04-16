<?
//MODULO: sicom
//CLASSE DA ENTIDADE hablic102021
class cl_hablic102021
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
  var $si57_sequencial = 0;
  var $si57_tiporegistro = 0;
  var $si57_codorgao = null;
  var $si57_codunidadesub = null;
  var $si57_exerciciolicitacao = 0;
  var $si57_nroprocessolicitatorio = null;
  var $si57_tipodocumento = 0;
  var $si57_nrodocumento = null;
  var $si57_objetosocial = null;
  var $si57_orgaorespregistro = 0;
  var $si57_dataregistro_dia = null;
  var $si57_dataregistro_mes = null;
  var $si57_dataregistro_ano = null;
  var $si57_dataregistro = null;
  var $si57_nroregistro = null;
  var $si57_dataregistrocvm_dia = null;
  var $si57_dataregistrocvm_mes = null;
  var $si57_dataregistrocvm_ano = null;
  var $si57_dataregistrocvm = null;
  var $si57_nroregistrocvm = null;
  var $si57_nroinscricaoestadual = null;
  var $si57_ufinscricaoestadual = null;
  var $si57_nrocertidaoregularidadeinss = null;
  var $si57_dtemissaocertidaoregularidadeinss_dia = null;
  var $si57_dtemissaocertidaoregularidadeinss_mes = null;
  var $si57_dtemissaocertidaoregularidadeinss_ano = null;
  var $si57_dtemissaocertidaoregularidadeinss = null;
  var $si57_dtvalidadecertidaoregularidadeinss_dia = null;
  var $si57_dtvalidadecertidaoregularidadeinss_mes = null;
  var $si57_dtvalidadecertidaoregularidadeinss_ano = null;
  var $si57_dtvalidadecertidaoregularidadeinss = null;
  var $si57_nrocertidaoregularidadefgts = null;
  var $si57_dtemissaocertidaoregularidadefgts_dia = null;
  var $si57_dtemissaocertidaoregularidadefgts_mes = null;
  var $si57_dtemissaocertidaoregularidadefgts_ano = null;
  var $si57_dtemissaocertidaoregularidadefgts = null;
  var $si57_dtvalidadecertidaoregularidadefgts_dia = null;
  var $si57_dtvalidadecertidaoregularidadefgts_mes = null;
  var $si57_dtvalidadecertidaoregularidadefgts_ano = null;
  var $si57_dtvalidadecertidaoregularidadefgts = null;
  var $si57_nrocndt = null;
  var $si57_dtemissaocndt_dia = null;
  var $si57_dtemissaocndt_mes = null;
  var $si57_dtemissaocndt_ano = null;
  var $si57_dtemissaocndt = null;
  var $si57_dtvalidadecndt_dia = null;
  var $si57_dtvalidadecndt_mes = null;
  var $si57_dtvalidadecndt_ano = null;
  var $si57_dtvalidadecndt = null;
  var $si57_dthabilitacao_dia = null;
  var $si57_dthabilitacao_mes = null;
  var $si57_dthabilitacao_ano = null;
  var $si57_dthabilitacao = null;
  var $si57_presencalicitantes = 0;
  var $si57_renunciarecurso = 0;
  var $si57_mes = 0;
  var $si57_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si57_sequencial = int8 = sequencial
                 si57_tiporegistro = int8 = Tipo do  registro
                 si57_codorgao = varchar(2) = Código do órgão
                 si57_codunidadesub = varchar(8) = Código da unidade
                 si57_exerciciolicitacao = int8 = Exercício em que  foi instaurado
                 si57_nroprocessolicitatorio = varchar(12) = Número sequencial do processo
                 si57_tipodocumento = int8 = Tipo do  documento
                 si57_nrodocumento = varchar(14) = Número do  documento do  participante
                 si57_objetosocial = varchar(2000) = Objeto Social
                 si57_orgaorespregistro = int8 = Órgão responsável
                 si57_dataregistro = date = Data do Registro
                 si57_nroregistro = varchar(20) = Número do  Registro
                 si57_dataregistrocvm = date = Data do Registro
                 si57_nroregistrocvm = varchar(20) = Número do  Registro
                 si57_nroinscricaoestadual = varchar(30) = Número da  inscrição estadual
                 si57_ufinscricaoestadual = varchar(2) = Sigla da unidade  da Federação
                 si57_nrocertidaoregularidadeinss = varchar(30) = Número da certidão
                 si57_dtemissaocertidaoregularidadeinss = date = Data de emissão  da certidão
                 si57_dtvalidadecertidaoregularidadeinss = date = Data de validade  da certidão
                 si57_nrocertidaoregularidadefgts = varchar(30) = Número da certidão  de regularidade FGTS
                 si57_dtemissaocertidaoregularidadefgts = date = Data de emissão  da certidão r fgts
                 si57_dtvalidadecertidaoregularidadefgts = date = Data de validade  da certidão FGTS
                 si57_nrocndt = varchar(30) = Número da  Certidão Negativa  de Débitos
                 si57_dtemissaocndt = date = Data de emissão  da certidão Negativa
                 si57_dtvalidadecndt = date = Data de validade  da C.N.D.T
                 si57_dthabilitacao = date = Data da habilitação
                 si57_presencalicitantes = int8 = Presença Licitantes
                 si57_renunciarecurso = int8 = Informar a  existência de  renúncia
                 si57_mes = int8 = Mês
                 si57_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_hablic102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("hablic102021");
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
      $this->si57_sequencial = ($this->si57_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_sequencial"] : $this->si57_sequencial);
      $this->si57_tiporegistro = ($this->si57_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_tiporegistro"] : $this->si57_tiporegistro);
      $this->si57_codorgao = ($this->si57_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_codorgao"] : $this->si57_codorgao);
      $this->si57_codunidadesub = ($this->si57_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_codunidadesub"] : $this->si57_codunidadesub);
      $this->si57_exerciciolicitacao = ($this->si57_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_exerciciolicitacao"] : $this->si57_exerciciolicitacao);
      $this->si57_nroprocessolicitatorio = ($this->si57_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_nroprocessolicitatorio"] : $this->si57_nroprocessolicitatorio);
      $this->si57_tipodocumento = ($this->si57_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_tipodocumento"] : $this->si57_tipodocumento);
      $this->si57_nrodocumento = ($this->si57_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_nrodocumento"] : $this->si57_nrodocumento);
      $this->si57_objetosocial = ($this->si57_objetosocial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_objetosocial"] : $this->si57_objetosocial);
      $this->si57_orgaorespregistro = ($this->si57_orgaorespregistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_orgaorespregistro"] : $this->si57_orgaorespregistro);
      if ($this->si57_dataregistro == "") {
        $this->si57_dataregistro_dia = ($this->si57_dataregistro_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dataregistro_dia"] : $this->si57_dataregistro_dia);
        $this->si57_dataregistro_mes = ($this->si57_dataregistro_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dataregistro_mes"] : $this->si57_dataregistro_mes);
        $this->si57_dataregistro_ano = ($this->si57_dataregistro_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dataregistro_ano"] : $this->si57_dataregistro_ano);
        if ($this->si57_dataregistro_dia != "") {
          $this->si57_dataregistro = $this->si57_dataregistro_ano . "-" . $this->si57_dataregistro_mes . "-" . $this->si57_dataregistro_dia;
        }
      }
      $this->si57_nroregistro = ($this->si57_nroregistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_nroregistro"] : $this->si57_nroregistro);
      if ($this->si57_dataregistrocvm == "") {
        $this->si57_dataregistrocvm_dia = ($this->si57_dataregistrocvm_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dataregistrocvm_dia"] : $this->si57_dataregistrocvm_dia);
        $this->si57_dataregistrocvm_mes = ($this->si57_dataregistrocvm_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dataregistrocvm_mes"] : $this->si57_dataregistrocvm_mes);
        $this->si57_dataregistrocvm_ano = ($this->si57_dataregistrocvm_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dataregistrocvm_ano"] : $this->si57_dataregistrocvm_ano);
        if ($this->si57_dataregistrocvm_dia != "") {
          $this->si57_dataregistrocvm = $this->si57_dataregistrocvm_ano . "-" . $this->si57_dataregistrocvm_mes . "-" . $this->si57_dataregistrocvm_dia;
        }
      }
      $this->si57_nroregistrocvm = ($this->si57_nroregistrocvm == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_nroregistrocvm"] : $this->si57_nroregistrocvm);
      $this->si57_nroinscricaoestadual = ($this->si57_nroinscricaoestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_nroinscricaoestadual"] : $this->si57_nroinscricaoestadual);
      $this->si57_ufinscricaoestadual = ($this->si57_ufinscricaoestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_ufinscricaoestadual"] : $this->si57_ufinscricaoestadual);
      $this->si57_nrocertidaoregularidadeinss = ($this->si57_nrocertidaoregularidadeinss == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_nrocertidaoregularidadeinss"] : $this->si57_nrocertidaoregularidadeinss);
      if ($this->si57_dtemissaocertidaoregularidadeinss == "") {
        $this->si57_dtemissaocertidaoregularidadeinss_dia = ($this->si57_dtemissaocertidaoregularidadeinss_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadeinss_dia"] : $this->si57_dtemissaocertidaoregularidadeinss_dia);
        $this->si57_dtemissaocertidaoregularidadeinss_mes = ($this->si57_dtemissaocertidaoregularidadeinss_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadeinss_mes"] : $this->si57_dtemissaocertidaoregularidadeinss_mes);
        $this->si57_dtemissaocertidaoregularidadeinss_ano = ($this->si57_dtemissaocertidaoregularidadeinss_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadeinss_ano"] : $this->si57_dtemissaocertidaoregularidadeinss_ano);
        if ($this->si57_dtemissaocertidaoregularidadeinss_dia != "") {
          $this->si57_dtemissaocertidaoregularidadeinss = $this->si57_dtemissaocertidaoregularidadeinss_ano . "-" . $this->si57_dtemissaocertidaoregularidadeinss_mes . "-" . $this->si57_dtemissaocertidaoregularidadeinss_dia;
        }
      }
      if ($this->si57_dtvalidadecertidaoregularidadeinss == "") {
        $this->si57_dtvalidadecertidaoregularidadeinss_dia = ($this->si57_dtvalidadecertidaoregularidadeinss_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadeinss_dia"] : $this->si57_dtvalidadecertidaoregularidadeinss_dia);
        $this->si57_dtvalidadecertidaoregularidadeinss_mes = ($this->si57_dtvalidadecertidaoregularidadeinss_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadeinss_mes"] : $this->si57_dtvalidadecertidaoregularidadeinss_mes);
        $this->si57_dtvalidadecertidaoregularidadeinss_ano = ($this->si57_dtvalidadecertidaoregularidadeinss_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadeinss_ano"] : $this->si57_dtvalidadecertidaoregularidadeinss_ano);
        if ($this->si57_dtvalidadecertidaoregularidadeinss_dia != "") {
          $this->si57_dtvalidadecertidaoregularidadeinss = $this->si57_dtvalidadecertidaoregularidadeinss_ano . "-" . $this->si57_dtvalidadecertidaoregularidadeinss_mes . "-" . $this->si57_dtvalidadecertidaoregularidadeinss_dia;
        }
      }
      $this->si57_nrocertidaoregularidadefgts = ($this->si57_nrocertidaoregularidadefgts == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_nrocertidaoregularidadefgts"] : $this->si57_nrocertidaoregularidadefgts);
      if ($this->si57_dtemissaocertidaoregularidadefgts == "") {
        $this->si57_dtemissaocertidaoregularidadefgts_dia = ($this->si57_dtemissaocertidaoregularidadefgts_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadefgts_dia"] : $this->si57_dtemissaocertidaoregularidadefgts_dia);
        $this->si57_dtemissaocertidaoregularidadefgts_mes = ($this->si57_dtemissaocertidaoregularidadefgts_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadefgts_mes"] : $this->si57_dtemissaocertidaoregularidadefgts_mes);
        $this->si57_dtemissaocertidaoregularidadefgts_ano = ($this->si57_dtemissaocertidaoregularidadefgts_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadefgts_ano"] : $this->si57_dtemissaocertidaoregularidadefgts_ano);
        if ($this->si57_dtemissaocertidaoregularidadefgts_dia != "") {
          $this->si57_dtemissaocertidaoregularidadefgts = $this->si57_dtemissaocertidaoregularidadefgts_ano . "-" . $this->si57_dtemissaocertidaoregularidadefgts_mes . "-" . $this->si57_dtemissaocertidaoregularidadefgts_dia;
        }
      }
      if ($this->si57_dtvalidadecertidaoregularidadefgts == "") {
        $this->si57_dtvalidadecertidaoregularidadefgts_dia = ($this->si57_dtvalidadecertidaoregularidadefgts_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadefgts_dia"] : $this->si57_dtvalidadecertidaoregularidadefgts_dia);
        $this->si57_dtvalidadecertidaoregularidadefgts_mes = ($this->si57_dtvalidadecertidaoregularidadefgts_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadefgts_mes"] : $this->si57_dtvalidadecertidaoregularidadefgts_mes);
        $this->si57_dtvalidadecertidaoregularidadefgts_ano = ($this->si57_dtvalidadecertidaoregularidadefgts_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadefgts_ano"] : $this->si57_dtvalidadecertidaoregularidadefgts_ano);
        if ($this->si57_dtvalidadecertidaoregularidadefgts_dia != "") {
          $this->si57_dtvalidadecertidaoregularidadefgts = $this->si57_dtvalidadecertidaoregularidadefgts_ano . "-" . $this->si57_dtvalidadecertidaoregularidadefgts_mes . "-" . $this->si57_dtvalidadecertidaoregularidadefgts_dia;
        }
      }
      $this->si57_nrocndt = ($this->si57_nrocndt == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_nrocndt"] : $this->si57_nrocndt);
      if ($this->si57_dtemissaocndt == "") {
        $this->si57_dtemissaocndt_dia = ($this->si57_dtemissaocndt_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocndt_dia"] : $this->si57_dtemissaocndt_dia);
        $this->si57_dtemissaocndt_mes = ($this->si57_dtemissaocndt_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocndt_mes"] : $this->si57_dtemissaocndt_mes);
        $this->si57_dtemissaocndt_ano = ($this->si57_dtemissaocndt_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocndt_ano"] : $this->si57_dtemissaocndt_ano);
        if ($this->si57_dtemissaocndt_dia != "") {
          $this->si57_dtemissaocndt = $this->si57_dtemissaocndt_ano . "-" . $this->si57_dtemissaocndt_mes . "-" . $this->si57_dtemissaocndt_dia;
        }
      }
      if ($this->si57_dtvalidadecndt == "") {
        $this->si57_dtvalidadecndt_dia = ($this->si57_dtvalidadecndt_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecndt_dia"] : $this->si57_dtvalidadecndt_dia);
        $this->si57_dtvalidadecndt_mes = ($this->si57_dtvalidadecndt_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecndt_mes"] : $this->si57_dtvalidadecndt_mes);
        $this->si57_dtvalidadecndt_ano = ($this->si57_dtvalidadecndt_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecndt_ano"] : $this->si57_dtvalidadecndt_ano);
        if ($this->si57_dtvalidadecndt_dia != "") {
          $this->si57_dtvalidadecndt = $this->si57_dtvalidadecndt_ano . "-" . $this->si57_dtvalidadecndt_mes . "-" . $this->si57_dtvalidadecndt_dia;
        }
      }
      if ($this->si57_dthabilitacao == "") {
        $this->si57_dthabilitacao_dia = ($this->si57_dthabilitacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dthabilitacao_dia"] : $this->si57_dthabilitacao_dia);
        $this->si57_dthabilitacao_mes = ($this->si57_dthabilitacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dthabilitacao_mes"] : $this->si57_dthabilitacao_mes);
        $this->si57_dthabilitacao_ano = ($this->si57_dthabilitacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_dthabilitacao_ano"] : $this->si57_dthabilitacao_ano);
        if ($this->si57_dthabilitacao_dia != "") {
          $this->si57_dthabilitacao = $this->si57_dthabilitacao_ano . "-" . $this->si57_dthabilitacao_mes . "-" . $this->si57_dthabilitacao_dia;
        }
      }
      $this->si57_presencalicitantes = ($this->si57_presencalicitantes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_presencalicitantes"] : $this->si57_presencalicitantes);
      $this->si57_renunciarecurso = ($this->si57_renunciarecurso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_renunciarecurso"] : $this->si57_renunciarecurso);
      $this->si57_mes = ($this->si57_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_mes"] : $this->si57_mes);
      $this->si57_instit = ($this->si57_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_instit"] : $this->si57_instit);
    } else {
      $this->si57_sequencial = ($this->si57_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si57_sequencial"] : $this->si57_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si57_sequencial)
  {
    $this->atualizacampos();
    if ($this->si57_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si57_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si57_exerciciolicitacao == null) {
      $this->si57_exerciciolicitacao = "0";
    }
    if ($this->si57_tipodocumento == null) {
      $this->si57_tipodocumento = "0";
    }
    if ($this->si57_orgaorespregistro == null) {
      $this->si57_orgaorespregistro = "0";
    }
    if ($this->si57_dataregistro == null) {
      $this->si57_dataregistro = "null";
    }
    if ($this->si57_dataregistrocvm == null) {
      $this->si57_dataregistrocvm = "null";
    }
    if ($this->si57_dtemissaocertidaoregularidadeinss == null) {
      $this->si57_dtemissaocertidaoregularidadeinss = "null";
    }
    if ($this->si57_dtvalidadecertidaoregularidadeinss == null) {
      $this->si57_dtvalidadecertidaoregularidadeinss = "null";
    }
    if ($this->si57_dtemissaocertidaoregularidadefgts == null) {
      $this->si57_dtemissaocertidaoregularidadefgts = "null";
    }
    if ($this->si57_dtvalidadecertidaoregularidadefgts == null) {
      $this->si57_dtvalidadecertidaoregularidadefgts = "null";
    }
    if ($this->si57_dtemissaocndt == null) {
      $this->si57_dtemissaocndt = "null";
    }
    if ($this->si57_dtvalidadecndt == null) {
      $this->si57_dtvalidadecndt = "null";
    }
    if ($this->si57_dthabilitacao == null) {
      $this->si57_dthabilitacao = "null";
    }
    if ($this->si57_presencalicitantes == null) {
      $this->si57_presencalicitantes = "0";
    }
    if ($this->si57_renunciarecurso == null) {
      $this->si57_renunciarecurso = "0";
    }
    if ($this->si57_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si57_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si57_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si57_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si57_sequencial == "" || $si57_sequencial == null) {
      $result = db_query("select nextval('hablic102021_si57_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: hablic102021_si57_sequencial_seq do campo: si57_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si57_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from hablic102021_si57_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si57_sequencial)) {
        $this->erro_sql = " Campo si57_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si57_sequencial = $si57_sequencial;
      }
    }
    if (($this->si57_sequencial == null) || ($this->si57_sequencial == "")) {
      $this->erro_sql = " Campo si57_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into hablic102021(
                                       si57_sequencial
                                      ,si57_tiporegistro
                                      ,si57_codorgao
                                      ,si57_codunidadesub
                                      ,si57_exerciciolicitacao
                                      ,si57_nroprocessolicitatorio
                                      ,si57_tipodocumento
                                      ,si57_nrodocumento
                                      ,si57_objetosocial
                                      ,si57_orgaorespregistro
                                      ,si57_dataregistro
                                      ,si57_nroregistro
                                      ,si57_dataregistrocvm
                                      ,si57_nroregistrocvm
                                      ,si57_nroinscricaoestadual
                                      ,si57_ufinscricaoestadual
                                      ,si57_nrocertidaoregularidadeinss
                                      ,si57_dtemissaocertidaoregularidadeinss
                                      ,si57_dtvalidadecertidaoregularidadeinss
                                      ,si57_nrocertidaoregularidadefgts
                                      ,si57_dtemissaocertidaoregularidadefgts
                                      ,si57_dtvalidadecertidaoregularidadefgts
                                      ,si57_nrocndt
                                      ,si57_dtemissaocndt
                                      ,si57_dtvalidadecndt
                                      ,si57_dthabilitacao
                                      ,si57_presencalicitantes
                                      ,si57_renunciarecurso
                                      ,si57_mes
                                      ,si57_instit
                       )
                values (
                                $this->si57_sequencial
                               ,$this->si57_tiporegistro
                               ,'$this->si57_codorgao'
                               ,'$this->si57_codunidadesub'
                               ,$this->si57_exerciciolicitacao
                               ,'$this->si57_nroprocessolicitatorio'
                               ,$this->si57_tipodocumento
                               ,'$this->si57_nrodocumento'
                               ,'$this->si57_objetosocial'
                               ,$this->si57_orgaorespregistro
                               ," . ($this->si57_dataregistro == "null" || $this->si57_dataregistro == "" ? "null" : "'" . $this->si57_dataregistro . "'") . "
                               ,'$this->si57_nroregistro'
                               ," . ($this->si57_dataregistrocvm == "null" || $this->si57_dataregistrocvm == "" ? "null" : "'" . $this->si57_dataregistrocvm . "'") . "
                               ,'$this->si57_nroregistrocvm'
                               ,'$this->si57_nroinscricaoestadual'
                               ,'$this->si57_ufinscricaoestadual'
                               ,'$this->si57_nrocertidaoregularidadeinss'
                               ," . ($this->si57_dtemissaocertidaoregularidadeinss == "null" || $this->si57_dtemissaocertidaoregularidadeinss == "" ? "null" : "'" . $this->si57_dtemissaocertidaoregularidadeinss . "'") . "
                               ," . ($this->si57_dtvalidadecertidaoregularidadeinss == "null" || $this->si57_dtvalidadecertidaoregularidadeinss == "" ? "null" : "'" . $this->si57_dtvalidadecertidaoregularidadeinss . "'") . "
                               ,'$this->si57_nrocertidaoregularidadefgts'
                               ," . ($this->si57_dtemissaocertidaoregularidadefgts == "null" || $this->si57_dtemissaocertidaoregularidadefgts == "" ? "null" : "'" . $this->si57_dtemissaocertidaoregularidadefgts . "'") . "
                               ," . ($this->si57_dtvalidadecertidaoregularidadefgts == "null" || $this->si57_dtvalidadecertidaoregularidadefgts == "" ? "null" : "'" . $this->si57_dtvalidadecertidaoregularidadefgts . "'") . "
                               ,'$this->si57_nrocndt'
                               ," . ($this->si57_dtemissaocndt == "null" || $this->si57_dtemissaocndt == "" ? "null" : "'" . $this->si57_dtemissaocndt . "'") . "
                               ," . ($this->si57_dtvalidadecndt == "null" || $this->si57_dtvalidadecndt == "" ? "null" : "'" . $this->si57_dtvalidadecndt . "'") . "
                               ," . ($this->si57_dthabilitacao == "null" || $this->si57_dthabilitacao == "" ? "null" : "'" . $this->si57_dthabilitacao . "'") . "
                               ,$this->si57_presencalicitantes
                               ,$this->si57_renunciarecurso
                               ,$this->si57_mes
                               ,$this->si57_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "hablic102021 ($this->si57_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "hablic102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "hablic102021 ($this->si57_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si57_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si57_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010011,'$this->si57_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010286,2010011,'','" . AddSlashes(pg_result($resaco, 0, 'si57_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010012,'','" . AddSlashes(pg_result($resaco, 0, 'si57_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010013,'','" . AddSlashes(pg_result($resaco, 0, 'si57_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010014,'','" . AddSlashes(pg_result($resaco, 0, 'si57_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010015,'','" . AddSlashes(pg_result($resaco, 0, 'si57_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010016,'','" . AddSlashes(pg_result($resaco, 0, 'si57_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010017,'','" . AddSlashes(pg_result($resaco, 0, 'si57_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010018,'','" . AddSlashes(pg_result($resaco, 0, 'si57_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010019,'','" . AddSlashes(pg_result($resaco, 0, 'si57_objetosocial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010020,'','" . AddSlashes(pg_result($resaco, 0, 'si57_orgaorespregistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010021,'','" . AddSlashes(pg_result($resaco, 0, 'si57_dataregistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010022,'','" . AddSlashes(pg_result($resaco, 0, 'si57_nroregistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010023,'','" . AddSlashes(pg_result($resaco, 0, 'si57_dataregistrocvm')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010024,'','" . AddSlashes(pg_result($resaco, 0, 'si57_nroregistrocvm')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010025,'','" . AddSlashes(pg_result($resaco, 0, 'si57_nroinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010026,'','" . AddSlashes(pg_result($resaco, 0, 'si57_ufinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010027,'','" . AddSlashes(pg_result($resaco, 0, 'si57_nrocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010028,'','" . AddSlashes(pg_result($resaco, 0, 'si57_dtemissaocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010029,'','" . AddSlashes(pg_result($resaco, 0, 'si57_dtvalidadecertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010030,'','" . AddSlashes(pg_result($resaco, 0, 'si57_nrocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010032,'','" . AddSlashes(pg_result($resaco, 0, 'si57_dtemissaocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010033,'','" . AddSlashes(pg_result($resaco, 0, 'si57_dtvalidadecertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010034,'','" . AddSlashes(pg_result($resaco, 0, 'si57_nrocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010036,'','" . AddSlashes(pg_result($resaco, 0, 'si57_dtemissaocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010038,'','" . AddSlashes(pg_result($resaco, 0, 'si57_dtvalidadecndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010039,'','" . AddSlashes(pg_result($resaco, 0, 'si57_dthabilitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010040,'','" . AddSlashes(pg_result($resaco, 0, 'si57_presencalicitantes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010041,'','" . AddSlashes(pg_result($resaco, 0, 'si57_renunciarecurso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2010042,'','" . AddSlashes(pg_result($resaco, 0, 'si57_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010286,2011569,'','" . AddSlashes(pg_result($resaco, 0, 'si57_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si57_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update hablic102021 set ";
    $virgula = "";
    if (trim($this->si57_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_sequencial"])) {
      if (trim($this->si57_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si57_sequencial"])) {
        $this->si57_sequencial = "0";
      }
      $sql .= $virgula . " si57_sequencial = $this->si57_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si57_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_tiporegistro"])) {
      $sql .= $virgula . " si57_tiporegistro = $this->si57_tiporegistro ";
      $virgula = ",";
      if (trim($this->si57_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si57_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si57_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_codorgao"])) {
      $sql .= $virgula . " si57_codorgao = '$this->si57_codorgao' ";
      $virgula = ",";
      if (trim($this->si57_codorgao) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si57_codorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si57_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_codunidadesub"])) {
      $sql .= $virgula . " si57_codunidadesub = '$this->si57_codunidadesub' ";
      $virgula = ",";
      if (trim($this->si57_codunidadesub) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si57_codunidadesub";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si57_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_exerciciolicitacao"])) {
      if (trim($this->si57_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si57_exerciciolicitacao"])) {
        $this->si57_exerciciolicitacao = "0";
        if (trim($this->si57_exerciciolicitacao) == null) {
          $this->erro_sql = " Campo Tipo do  registro nao Informado.";
          $this->erro_campo = "si57_exerciciolicitacao";
          $this->erro_banco = "";
          $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
          $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
          $this->erro_status = "0";

        return false;
      }
      }
      $sql .= $virgula . " si57_exerciciolicitacao = $this->si57_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si57_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si57_nroprocessolicitatorio = '$this->si57_nroprocessolicitatorio' ";
      $virgula = ",";
      if (trim($this->si57_nroprocessolicitatorio) == null) {
        $this->erro_sql = " Campo Número sequencial por ano não Informado.";
        $this->erro_campo = "si57_nroprocessolicitatorio";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si57_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_tipodocumento"])) {
      if (trim($this->si57_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si57_tipodocumento"])) {
        $this->si57_tipodocumento = "0";
      }
      $sql .= $virgula . " si57_tipodocumento = $this->si57_tipodocumento ";
      $virgula = ",";
      if (trim($this->si57_tipodocumento) == null) {
        $this->erro_sql = " Campo Tipo do documento não Informado.";
        $this->erro_campo = "si57_tipodocumento";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si57_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_nrodocumento"])) {
      $sql .= $virgula . " si57_nrodocumento = '$this->si57_nrodocumento' ";
      $virgula = ",";
      if (trim($this->si57_nrodocumento) == null) {
        $this->erro_sql = " Campo Número do documento não Informado.";
        $this->erro_campo = "si57_nrodocumento";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si57_objetosocial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_objetosocial"])) {
      $sql .= $virgula . " si57_objetosocial = '$this->si57_objetosocial' ";
      $virgula = ",";
    }
    if (trim($this->si57_orgaorespregistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_orgaorespregistro"])) {
      if (trim($this->si57_orgaorespregistro) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si57_orgaorespregistro"])) {
        $this->si57_orgaorespregistro = "0";
      }
      $sql .= $virgula . " si57_orgaorespregistro = $this->si57_orgaorespregistro ";
      $virgula = ",";
    }
    if (trim($this->si57_dataregistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_dataregistro_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si57_dataregistro_dia"] != "")) {
      $sql .= $virgula . " si57_dataregistro = '$this->si57_dataregistro' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dataregistro_dia"])) {
        $sql .= $virgula . " si57_dataregistro = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si57_nroregistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_nroregistro"])) {
      $sql .= $virgula . " si57_nroregistro = '$this->si57_nroregistro' ";
      $virgula = ",";
    }
    if (trim($this->si57_dataregistrocvm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_dataregistrocvm_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si57_dataregistrocvm_dia"] != "")) {
      $sql .= $virgula . " si57_dataregistrocvm = '$this->si57_dataregistrocvm' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dataregistrocvm_dia"])) {
        $sql .= $virgula . " si57_dataregistrocvm = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si57_nroregistrocvm) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_nroregistrocvm"])) {
      $sql .= $virgula . " si57_nroregistrocvm = '$this->si57_nroregistrocvm' ";
      $virgula = ",";
    }
    if (trim($this->si57_nroinscricaoestadual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_nroinscricaoestadual"])) {
      $sql .= $virgula . " si57_nroinscricaoestadual = '$this->si57_nroinscricaoestadual' ";
      $virgula = ",";
    }
    if (trim($this->si57_ufinscricaoestadual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_ufinscricaoestadual"])) {
      $sql .= $virgula . " si57_ufinscricaoestadual = '$this->si57_ufinscricaoestadual' ";
      $virgula = ",";
    }
    if (trim($this->si57_nrocertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_nrocertidaoregularidadeinss"])) {
      $sql .= $virgula . " si57_nrocertidaoregularidadeinss = '$this->si57_nrocertidaoregularidadeinss' ";
      $virgula = ",";
    }
    if (trim($this->si57_dtemissaocertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadeinss_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadeinss_dia"] != "")) {
      $sql .= $virgula . " si57_dtemissaocertidaoregularidadeinss = '$this->si57_dtemissaocertidaoregularidadeinss' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadeinss_dia"])) {
        $sql .= $virgula . " si57_dtemissaocertidaoregularidadeinss = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si57_dtvalidadecertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadeinss_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadeinss_dia"] != "")) {
      $sql .= $virgula . " si57_dtvalidadecertidaoregularidadeinss = '$this->si57_dtvalidadecertidaoregularidadeinss' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadeinss_dia"])) {
        $sql .= $virgula . " si57_dtvalidadecertidaoregularidadeinss = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si57_nrocertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_nrocertidaoregularidadefgts"])) {
      $sql .= $virgula . " si57_nrocertidaoregularidadefgts = '$this->si57_nrocertidaoregularidadefgts' ";
      $virgula = ",";
    }
    if (trim($this->si57_dtemissaocertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadefgts_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadefgts_dia"] != "")) {
      $sql .= $virgula . " si57_dtemissaocertidaoregularidadefgts = '$this->si57_dtemissaocertidaoregularidadefgts' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadefgts_dia"])) {
        $sql .= $virgula . " si57_dtemissaocertidaoregularidadefgts = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si57_dtvalidadecertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadefgts_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadefgts_dia"] != "")) {
      $sql .= $virgula . " si57_dtvalidadecertidaoregularidadefgts = '$this->si57_dtvalidadecertidaoregularidadefgts' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadefgts_dia"])) {
        $sql .= $virgula . " si57_dtvalidadecertidaoregularidadefgts = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si57_nrocndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_nrocndt"])) {
      $sql .= $virgula . " si57_nrocndt = '$this->si57_nrocndt' ";
      $virgula = ",";
    }
    if (trim($this->si57_dtemissaocndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocndt_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocndt_dia"] != "")) {
      $sql .= $virgula . " si57_dtemissaocndt = '$this->si57_dtemissaocndt' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocndt_dia"])) {
        $sql .= $virgula . " si57_dtemissaocndt = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si57_dtvalidadecndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecndt_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecndt_dia"] != "")) {
      $sql .= $virgula . " si57_dtvalidadecndt = '$this->si57_dtvalidadecndt' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecndt_dia"])) {
        $sql .= $virgula . " si57_dtvalidadecndt = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si57_dthabilitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_dthabilitacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si57_dthabilitacao_dia"] != "")) {
      $sql .= $virgula . " si57_dthabilitacao = '$this->si57_dthabilitacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dthabilitacao_dia"])) {
        $sql .= $virgula . " si57_dthabilitacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si57_presencalicitantes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_presencalicitantes"])) {
      if (trim($this->si57_presencalicitantes) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si57_presencalicitantes"])) {
        $this->erro_sql = " Campo Presença dos Licitantes não Informado.";
        $this->erro_campo = "si57_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $sql .= $virgula . " si57_presencalicitantes = $this->si57_presencalicitantes ";
      $virgula = ",";
    }
    if (trim($this->si57_renunciarecurso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_renunciarecurso"])) {
      if (trim($this->si57_renunciarecurso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si57_renunciarecurso"])) {
        $this->erro_sql = " Campo Renuncia recurso não Informado.";
        $this->erro_campo = "si57_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $sql .= $virgula . " si57_renunciarecurso = $this->si57_renunciarecurso ";
      $virgula = ",";
    }
    if (trim($this->si57_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_mes"])) {
      $sql .= $virgula . " si57_mes = $this->si57_mes ";
      $virgula = ",";
      if (trim($this->si57_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si57_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si57_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si57_instit"])) {
      $sql .= $virgula . " si57_instit = $this->si57_instit ";
      $virgula = ",";
      if (trim($this->si57_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si57_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si57_sequencial != null) {
      $sql .= " si57_sequencial = $this->si57_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si57_sequencial));
    // if ($this->numrows > 0) {
    //   for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
    //     $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //     $acount = pg_result($resac, 0, 0);
    //     $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
    //     $resac = db_query("insert into db_acountkey values($acount,2010011,'$this->si57_sequencial','A')");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_sequencial"]) || $this->si57_sequencial != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010011,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_sequencial')) . "','$this->si57_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_tiporegistro"]) || $this->si57_tiporegistro != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010012,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_tiporegistro')) . "','$this->si57_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_codorgao"]) || $this->si57_codorgao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010013,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_codorgao')) . "','$this->si57_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_codunidadesub"]) || $this->si57_codunidadesub != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010014,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_codunidadesub')) . "','$this->si57_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_exerciciolicitacao"]) || $this->si57_exerciciolicitacao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010015,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_exerciciolicitacao')) . "','$this->si57_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_nroprocessolicitatorio"]) || $this->si57_nroprocessolicitatorio != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010016,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_nroprocessolicitatorio')) . "','$this->si57_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_tipodocumento"]) || $this->si57_tipodocumento != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010017,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_tipodocumento')) . "','$this->si57_tipodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_nrodocumento"]) || $this->si57_nrodocumento != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010018,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_nrodocumento')) . "','$this->si57_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_objetosocial"]) || $this->si57_objetosocial != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010019,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_objetosocial')) . "','$this->si57_objetosocial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_orgaorespregistro"]) || $this->si57_orgaorespregistro != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010020,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_orgaorespregistro')) . "','$this->si57_orgaorespregistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dataregistro"]) || $this->si57_dataregistro != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010021,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_dataregistro')) . "','$this->si57_dataregistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_nroregistro"]) || $this->si57_nroregistro != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010022,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_nroregistro')) . "','$this->si57_nroregistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dataregistrocvm"]) || $this->si57_dataregistrocvm != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010023,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_dataregistrocvm')) . "','$this->si57_dataregistrocvm'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_nroregistrocvm"]) || $this->si57_nroregistrocvm != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010024,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_nroregistrocvm')) . "','$this->si57_nroregistrocvm'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_nroinscricaoestadual"]) || $this->si57_nroinscricaoestadual != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010025,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_nroinscricaoestadual')) . "','$this->si57_nroinscricaoestadual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_ufinscricaoestadual"]) || $this->si57_ufinscricaoestadual != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010026,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_ufinscricaoestadual')) . "','$this->si57_ufinscricaoestadual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_nrocertidaoregularidadeinss"]) || $this->si57_nrocertidaoregularidadeinss != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010027,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_nrocertidaoregularidadeinss')) . "','$this->si57_nrocertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadeinss"]) || $this->si57_dtemissaocertidaoregularidadeinss != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010028,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_dtemissaocertidaoregularidadeinss')) . "','$this->si57_dtemissaocertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadeinss"]) || $this->si57_dtvalidadecertidaoregularidadeinss != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010029,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_dtvalidadecertidaoregularidadeinss')) . "','$this->si57_dtvalidadecertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_nrocertidaoregularidadefgts"]) || $this->si57_nrocertidaoregularidadefgts != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010030,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_nrocertidaoregularidadefgts')) . "','$this->si57_nrocertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocertidaoregularidadefgts"]) || $this->si57_dtemissaocertidaoregularidadefgts != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010032,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_dtemissaocertidaoregularidadefgts')) . "','$this->si57_dtemissaocertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecertidaoregularidadefgts"]) || $this->si57_dtvalidadecertidaoregularidadefgts != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010033,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_dtvalidadecertidaoregularidadefgts')) . "','$this->si57_dtvalidadecertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_nrocndt"]) || $this->si57_nrocndt != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010034,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_nrocndt')) . "','$this->si57_nrocndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtemissaocndt"]) || $this->si57_dtemissaocndt != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010036,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_dtemissaocndt')) . "','$this->si57_dtemissaocndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dtvalidadecndt"]) || $this->si57_dtvalidadecndt != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010038,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_dtvalidadecndt')) . "','$this->si57_dtvalidadecndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_dthabilitacao"]) || $this->si57_dthabilitacao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010039,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_dthabilitacao')) . "','$this->si57_dthabilitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_presencalicitantes"]) || $this->si57_presencalicitantes != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010040,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_presencalicitantes')) . "','$this->si57_presencalicitantes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_renunciarecurso"]) || $this->si57_renunciarecurso != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010041,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_renunciarecurso')) . "','$this->si57_renunciarecurso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_mes"]) || $this->si57_mes != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2010042,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_mes')) . "','$this->si57_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si57_instit"]) || $this->si57_instit != "")
    //       $resac = db_query("insert into db_acount values($acount,2010286,2011569,'" . AddSlashes(pg_result($resaco, $conresaco, 'si57_instit')) . "','$this->si57_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   }
    // }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "hablic102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si57_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "hablic102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si57_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si57_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si57_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si57_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    // if (($resaco != false) || ($this->numrows != 0)) {
    //   for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
    //     $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //     $acount = pg_result($resac, 0, 0);
    //     $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
    //     $resac = db_query("insert into db_acountkey values($acount,2010011,'$si57_sequencial','E')");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010011,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010012,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010013,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010014,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010015,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010016,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010017,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010018,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010019,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_objetosocial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010020,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_orgaorespregistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010021,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_dataregistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010022,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_nroregistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010023,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_dataregistrocvm')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010024,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_nroregistrocvm')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010025,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_nroinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010026,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_ufinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010027,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_nrocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010028,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_dtemissaocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010029,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_dtvalidadecertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010030,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_nrocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010032,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_dtemissaocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010033,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_dtvalidadecertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010034,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_nrocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010036,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_dtemissaocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010038,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_dtvalidadecndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010039,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_dthabilitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010040,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_presencalicitantes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010041,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_renunciarecurso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2010042,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010286,2011569,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si57_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   }
    // }
    $sql = " delete from hablic102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si57_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si57_sequencial = $si57_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "hablic102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si57_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "hablic102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si57_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si57_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:hablic102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si57_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from hablic102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si57_sequencial != null) {
        $sql2 .= " where hablic102021.si57_sequencial = $si57_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }

  // funcao do sql
  function sql_query_file($si57_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from hablic102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si57_sequencial != null) {
        $sql2 .= " where hablic102021.si57_sequencial = $si57_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
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
