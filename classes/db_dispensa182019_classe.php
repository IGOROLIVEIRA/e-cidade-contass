<?
//MODULO: sicom
//CLASSE DA ENTIDADE dispensa182019
class cl_dispensa182019
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
  var $si82_sequencial = 0;
  var $si82_tiporegistro = 0;
  var $si82_codorgaoresp = null;
  var $si82_codunidadesubresp = null;
  var $si82_exercicioprocesso = 0;
  var $si82_nroprocesso = null;
  var $si82_tipoprocesso = 0;
  var $si82_tipodocumento = 0;
  var $si82_nrodocumento = null;
  var $si82_datacredenciamento_dia = null;
  var $si82_datacredenciamento_mes = null;
  var $si82_datacredenciamento_ano = null;
  var $si82_datacredenciamento = null;
  var $si82_nrolote = 0;
  var $si82_coditem = 0;
  var $si82_nroinscricaoestadual = null;
  var $si82_ufinscricaoestadual = null;
  var $si82_nrocertidaoregularidadeinss = null;
  var $si82_dataemissaocertidaoregularidadeinss_dia = null;
  var $si82_dataemissaocertidaoregularidadeinss_mes = null;
  var $si82_dataemissaocertidaoregularidadeinss_ano = null;
  var $si82_dataemissaocertidaoregularidadeinss = null;
  var $si82_dtvalidadecertidaoregularidadeinss_dia = null;
  var $si82_dtvalidadecertidaoregularidadeinss_mes = null;
  var $si82_dtvalidadecertidaoregularidadeinss_ano = null;
  var $si82_dtvalidadecertidaoregularidadeinss = null;
  var $si82_nrocertidaoregularidadefgts = null;
  var $si82_dtemissaocertidaoregularidadefgts_dia = null;
  var $si82_dtemissaocertidaoregularidadefgts_mes = null;
  var $si82_dtemissaocertidaoregularidadefgts_ano = null;
  var $si82_dtemissaocertidaoregularidadefgts = null;
  var $si82_dtvalidadecertidaoregularidadefgts_dia = null;
  var $si82_dtvalidadecertidaoregularidadefgts_mes = null;
  var $si82_dtvalidadecertidaoregularidadefgts_ano = null;
  var $si82_dtvalidadecertidaoregularidadefgts = null;
  var $si82_nrocndt = null;
  var $si82_dtemissaocndt_dia = null;
  var $si82_dtemissaocndt_mes = null;
  var $si82_dtemissaocndt_ano = null;
  var $si82_dtemissaocndt = null;
  var $si82_dtvalidadecndt_dia = null;
  var $si82_dtvalidadecndt_mes = null;
  var $si82_dtvalidadecndt_ano = null;
  var $si82_dtvalidadecndt = null;
  var $si82_mes = 0;
  var $si82_reg10 = 0;
  var $si82_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si82_sequencial = int8 = sequencial 
                 si82_tiporegistro = int8 = Tipo do registro 
                 si82_codorgaoresp = varchar(2) = Código do órgão  responsável 
                 si82_codunidadesubresp = varchar(8) = Código da unidade 
                 si82_exercicioprocesso = int8 = Exercício em que  foi instaurado 
                 si82_nroprocesso = varchar(12) = Número sequencial do processo 
                 si82_tipoprocesso = int8 = Tipo de processo 
                 si82_tipodocumento = int8 = Tipo do documento 
                 si82_nrodocumento = varchar(14) = Número do  documento 
                 si82_datacredenciamento = date = Data do  credenciamento 
                 si82_nrolote = int8 = Número do Lote 
                 si82_coditem = int8 = Código do Item 
                 si82_nroinscricaoestadual = varchar(30) = Número da  Inscrição estadual 
                 si82_ufinscricaoestadual = varchar(2) = UF da inscrição  estadual 
                 si82_nrocertidaoregularidadeinss = varchar(30) = Número da certidão  de R do INSS 
                 si82_dataemissaocertidaoregularidadeinss = date = Data de emissão  da certidão 
                 si82_dtvalidadecertidaoregularidadeinss = date = Data de validade  da certidão 
                 si82_nrocertidaoregularidadefgts = varchar(30) = Número da certidão  de regularidade 
                 si82_dtemissaocertidaoregularidadefgts = date = Data de emissão  da certidão 
                 si82_dtvalidadecertidaoregularidadefgts = date = Data de validade  da certidã 
                 si82_nrocndt = varchar(30) = Número da  Certidão Negativa  de Débitos 
                 si82_dtemissaocndt = date = Data de emissão  da certidão 
                 si82_dtvalidadecndt = date = Data de validade  da certidão 
                 si82_mes = int8 = Mês 
                 si82_reg10 = int8 = reg10 
                 si82_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_dispensa182019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("dispensa182019");
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
      $this->si82_sequencial = ($this->si82_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_sequencial"] : $this->si82_sequencial);
      $this->si82_tiporegistro = ($this->si82_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_tiporegistro"] : $this->si82_tiporegistro);
      $this->si82_codorgaoresp = ($this->si82_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_codorgaoresp"] : $this->si82_codorgaoresp);
      $this->si82_codunidadesubresp = ($this->si82_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_codunidadesubresp"] : $this->si82_codunidadesubresp);
      $this->si82_exercicioprocesso = ($this->si82_exercicioprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_exercicioprocesso"] : $this->si82_exercicioprocesso);
      $this->si82_nroprocesso = ($this->si82_nroprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_nroprocesso"] : $this->si82_nroprocesso);
      $this->si82_tipoprocesso = ($this->si82_tipoprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_tipoprocesso"] : $this->si82_tipoprocesso);
      $this->si82_tipodocumento = ($this->si82_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_tipodocumento"] : $this->si82_tipodocumento);
      $this->si82_nrodocumento = ($this->si82_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_nrodocumento"] : $this->si82_nrodocumento);
      if ($this->si82_datacredenciamento == "") {
        $this->si82_datacredenciamento_dia = ($this->si82_datacredenciamento_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_datacredenciamento_dia"] : $this->si82_datacredenciamento_dia);
        $this->si82_datacredenciamento_mes = ($this->si82_datacredenciamento_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_datacredenciamento_mes"] : $this->si82_datacredenciamento_mes);
        $this->si82_datacredenciamento_ano = ($this->si82_datacredenciamento_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_datacredenciamento_ano"] : $this->si82_datacredenciamento_ano);
        if ($this->si82_datacredenciamento_dia != "") {
          $this->si82_datacredenciamento = $this->si82_datacredenciamento_ano . "-" . $this->si82_datacredenciamento_mes . "-" . $this->si82_datacredenciamento_dia;
        }
      }
      $this->si82_nrolote = ($this->si82_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_nrolote"] : $this->si82_nrolote);
      $this->si82_coditem = ($this->si82_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_coditem"] : $this->si82_coditem);
      $this->si82_nroinscricaoestadual = ($this->si82_nroinscricaoestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_nroinscricaoestadual"] : $this->si82_nroinscricaoestadual);
      $this->si82_ufinscricaoestadual = ($this->si82_ufinscricaoestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_ufinscricaoestadual"] : $this->si82_ufinscricaoestadual);
      $this->si82_nrocertidaoregularidadeinss = ($this->si82_nrocertidaoregularidadeinss == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_nrocertidaoregularidadeinss"] : $this->si82_nrocertidaoregularidadeinss);
      if ($this->si82_dataemissaocertidaoregularidadeinss == "") {
        $this->si82_dataemissaocertidaoregularidadeinss_dia = ($this->si82_dataemissaocertidaoregularidadeinss_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dataemissaocertidaoregularidadeinss_dia"] : $this->si82_dataemissaocertidaoregularidadeinss_dia);
        $this->si82_dataemissaocertidaoregularidadeinss_mes = ($this->si82_dataemissaocertidaoregularidadeinss_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dataemissaocertidaoregularidadeinss_mes"] : $this->si82_dataemissaocertidaoregularidadeinss_mes);
        $this->si82_dataemissaocertidaoregularidadeinss_ano = ($this->si82_dataemissaocertidaoregularidadeinss_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dataemissaocertidaoregularidadeinss_ano"] : $this->si82_dataemissaocertidaoregularidadeinss_ano);
        if ($this->si82_dataemissaocertidaoregularidadeinss_dia != "") {
          $this->si82_dataemissaocertidaoregularidadeinss = $this->si82_dataemissaocertidaoregularidadeinss_ano . "-" . $this->si82_dataemissaocertidaoregularidadeinss_mes . "-" . $this->si82_dataemissaocertidaoregularidadeinss_dia;
        }
      }
      if ($this->si82_dtvalidadecertidaoregularidadeinss == "") {
        $this->si82_dtvalidadecertidaoregularidadeinss_dia = ($this->si82_dtvalidadecertidaoregularidadeinss_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadeinss_dia"] : $this->si82_dtvalidadecertidaoregularidadeinss_dia);
        $this->si82_dtvalidadecertidaoregularidadeinss_mes = ($this->si82_dtvalidadecertidaoregularidadeinss_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadeinss_mes"] : $this->si82_dtvalidadecertidaoregularidadeinss_mes);
        $this->si82_dtvalidadecertidaoregularidadeinss_ano = ($this->si82_dtvalidadecertidaoregularidadeinss_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadeinss_ano"] : $this->si82_dtvalidadecertidaoregularidadeinss_ano);
        if ($this->si82_dtvalidadecertidaoregularidadeinss_dia != "") {
          $this->si82_dtvalidadecertidaoregularidadeinss = $this->si82_dtvalidadecertidaoregularidadeinss_ano . "-" . $this->si82_dtvalidadecertidaoregularidadeinss_mes . "-" . $this->si82_dtvalidadecertidaoregularidadeinss_dia;
        }
      }
      $this->si82_nrocertidaoregularidadefgts = ($this->si82_nrocertidaoregularidadefgts == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_nrocertidaoregularidadefgts"] : $this->si82_nrocertidaoregularidadefgts);
      if ($this->si82_dtemissaocertidaoregularidadefgts == "") {
        $this->si82_dtemissaocertidaoregularidadefgts_dia = ($this->si82_dtemissaocertidaoregularidadefgts_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocertidaoregularidadefgts_dia"] : $this->si82_dtemissaocertidaoregularidadefgts_dia);
        $this->si82_dtemissaocertidaoregularidadefgts_mes = ($this->si82_dtemissaocertidaoregularidadefgts_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocertidaoregularidadefgts_mes"] : $this->si82_dtemissaocertidaoregularidadefgts_mes);
        $this->si82_dtemissaocertidaoregularidadefgts_ano = ($this->si82_dtemissaocertidaoregularidadefgts_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocertidaoregularidadefgts_ano"] : $this->si82_dtemissaocertidaoregularidadefgts_ano);
        if ($this->si82_dtemissaocertidaoregularidadefgts_dia != "") {
          $this->si82_dtemissaocertidaoregularidadefgts = $this->si82_dtemissaocertidaoregularidadefgts_ano . "-" . $this->si82_dtemissaocertidaoregularidadefgts_mes . "-" . $this->si82_dtemissaocertidaoregularidadefgts_dia;
        }
      }
      if ($this->si82_dtvalidadecertidaoregularidadefgts == "") {
        $this->si82_dtvalidadecertidaoregularidadefgts_dia = ($this->si82_dtvalidadecertidaoregularidadefgts_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadefgts_dia"] : $this->si82_dtvalidadecertidaoregularidadefgts_dia);
        $this->si82_dtvalidadecertidaoregularidadefgts_mes = ($this->si82_dtvalidadecertidaoregularidadefgts_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadefgts_mes"] : $this->si82_dtvalidadecertidaoregularidadefgts_mes);
        $this->si82_dtvalidadecertidaoregularidadefgts_ano = ($this->si82_dtvalidadecertidaoregularidadefgts_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadefgts_ano"] : $this->si82_dtvalidadecertidaoregularidadefgts_ano);
        if ($this->si82_dtvalidadecertidaoregularidadefgts_dia != "") {
          $this->si82_dtvalidadecertidaoregularidadefgts = $this->si82_dtvalidadecertidaoregularidadefgts_ano . "-" . $this->si82_dtvalidadecertidaoregularidadefgts_mes . "-" . $this->si82_dtvalidadecertidaoregularidadefgts_dia;
        }
      }
      $this->si82_nrocndt = ($this->si82_nrocndt == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_nrocndt"] : $this->si82_nrocndt);
      if ($this->si82_dtemissaocndt == "") {
        $this->si82_dtemissaocndt_dia = ($this->si82_dtemissaocndt_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocndt_dia"] : $this->si82_dtemissaocndt_dia);
        $this->si82_dtemissaocndt_mes = ($this->si82_dtemissaocndt_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocndt_mes"] : $this->si82_dtemissaocndt_mes);
        $this->si82_dtemissaocndt_ano = ($this->si82_dtemissaocndt_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocndt_ano"] : $this->si82_dtemissaocndt_ano);
        if ($this->si82_dtemissaocndt_dia != "") {
          $this->si82_dtemissaocndt = $this->si82_dtemissaocndt_ano . "-" . $this->si82_dtemissaocndt_mes . "-" . $this->si82_dtemissaocndt_dia;
        }
      }
      if ($this->si82_dtvalidadecndt == "") {
        $this->si82_dtvalidadecndt_dia = ($this->si82_dtvalidadecndt_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecndt_dia"] : $this->si82_dtvalidadecndt_dia);
        $this->si82_dtvalidadecndt_mes = ($this->si82_dtvalidadecndt_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecndt_mes"] : $this->si82_dtvalidadecndt_mes);
        $this->si82_dtvalidadecndt_ano = ($this->si82_dtvalidadecndt_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecndt_ano"] : $this->si82_dtvalidadecndt_ano);
        if ($this->si82_dtvalidadecndt_dia != "") {
          $this->si82_dtvalidadecndt = $this->si82_dtvalidadecndt_ano . "-" . $this->si82_dtvalidadecndt_mes . "-" . $this->si82_dtvalidadecndt_dia;
        }
      }
      $this->si82_mes = ($this->si82_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_mes"] : $this->si82_mes);
      $this->si82_reg10 = ($this->si82_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_reg10"] : $this->si82_reg10);
      $this->si82_instit = ($this->si82_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_instit"] : $this->si82_instit);
    } else {
      $this->si82_sequencial = ($this->si82_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si82_sequencial"] : $this->si82_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si82_sequencial)
  {
    $this->atualizacampos();
    if ($this->si82_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si82_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si82_exercicioprocesso == null) {
      $this->si82_exercicioprocesso = "0";
    }
    if ($this->si82_tipoprocesso == null) {
      $this->si82_tipoprocesso = "0";
    }
    if ($this->si82_tipodocumento == null) {
      $this->si82_tipodocumento = "0";
    }
    if ($this->si82_datacredenciamento == null) {
      $this->si82_datacredenciamento = "null";
    }
    if ($this->si82_nrolote == null) {
      $this->si82_nrolote = "0";
    }
    if ($this->si82_coditem == null) {
      $this->si82_coditem = "0";
    }
    if ($this->si82_dataemissaocertidaoregularidadeinss == null) {
      $this->si82_dataemissaocertidaoregularidadeinss = "null";
    }
    if ($this->si82_dtvalidadecertidaoregularidadeinss == null) {
      $this->si82_dtvalidadecertidaoregularidadeinss = "null";
    }
    if ($this->si82_dtemissaocertidaoregularidadefgts == null) {
      $this->si82_dtemissaocertidaoregularidadefgts = "null";
    }
    if ($this->si82_dtvalidadecertidaoregularidadefgts == null) {
      $this->si82_dtvalidadecertidaoregularidadefgts = "null";
    }
    if ($this->si82_dtemissaocndt == null) {
      $this->si82_dtemissaocndt = "null";
    }
    if ($this->si82_dtvalidadecndt == null) {
      $this->si82_dtvalidadecndt = "null";
    }
    if ($this->si82_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si82_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si82_reg10 == null) {
      $this->si82_reg10 = "0";
    }
    if ($this->si82_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si82_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si82_sequencial == "" || $si82_sequencial == null) {
      $result = db_query("select nextval('dispensa182019_si82_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: dispensa182019_si82_sequencial_seq do campo: si82_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si82_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from dispensa182019_si82_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si82_sequencial)) {
        $this->erro_sql = " Campo si82_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si82_sequencial = $si82_sequencial;
      }
    }
    if (($this->si82_sequencial == null) || ($this->si82_sequencial == "")) {
      $this->erro_sql = " Campo si82_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into dispensa182019(
                                       si82_sequencial 
                                      ,si82_tiporegistro 
                                      ,si82_codorgaoresp 
                                      ,si82_codunidadesubresp 
                                      ,si82_exercicioprocesso 
                                      ,si82_nroprocesso 
                                      ,si82_tipoprocesso 
                                      ,si82_tipodocumento 
                                      ,si82_nrodocumento 
                                      ,si82_datacredenciamento 
                                      ,si82_nrolote 
                                      ,si82_coditem 
                                      ,si82_nroinscricaoestadual 
                                      ,si82_ufinscricaoestadual 
                                      ,si82_nrocertidaoregularidadeinss 
                                      ,si82_dataemissaocertidaoregularidadeinss 
                                      ,si82_dtvalidadecertidaoregularidadeinss 
                                      ,si82_nrocertidaoregularidadefgts 
                                      ,si82_dtemissaocertidaoregularidadefgts 
                                      ,si82_dtvalidadecertidaoregularidadefgts 
                                      ,si82_nrocndt 
                                      ,si82_dtemissaocndt 
                                      ,si82_dtvalidadecndt 
                                      ,si82_mes 
                                      ,si82_reg10 
                                      ,si82_instit 
                       )
                values (
                                $this->si82_sequencial 
                               ,$this->si82_tiporegistro 
                               ,'$this->si82_codorgaoresp' 
                               ,'$this->si82_codunidadesubresp' 
                               ,$this->si82_exercicioprocesso 
                               ,'$this->si82_nroprocesso' 
                               ,$this->si82_tipoprocesso 
                               ,$this->si82_tipodocumento 
                               ,'$this->si82_nrodocumento' 
                               ," . ($this->si82_datacredenciamento == "null" || $this->si82_datacredenciamento == "" ? "null" : "'" . $this->si82_datacredenciamento . "'") . " 
                               ,$this->si82_nrolote 
                               ,$this->si82_coditem 
                               ,'$this->si82_nroinscricaoestadual' 
                               ,'$this->si82_ufinscricaoestadual' 
                               ,'$this->si82_nrocertidaoregularidadeinss' 
                               ," . ($this->si82_dataemissaocertidaoregularidadeinss == "null" || $this->si82_dataemissaocertidaoregularidadeinss == "" ? "null" : "'" . $this->si82_dataemissaocertidaoregularidadeinss . "'") . " 
                               ," . ($this->si82_dtvalidadecertidaoregularidadeinss == "null" || $this->si82_dtvalidadecertidaoregularidadeinss == "" ? "null" : "'" . $this->si82_dtvalidadecertidaoregularidadeinss . "'") . " 
                               ,'$this->si82_nrocertidaoregularidadefgts' 
                               ," . ($this->si82_dtemissaocertidaoregularidadefgts == "null" || $this->si82_dtemissaocertidaoregularidadefgts == "" ? "null" : "'" . $this->si82_dtemissaocertidaoregularidadefgts . "'") . " 
                               ," . ($this->si82_dtvalidadecertidaoregularidadefgts == "null" || $this->si82_dtvalidadecertidaoregularidadefgts == "" ? "null" : "'" . $this->si82_dtvalidadecertidaoregularidadefgts . "'") . " 
                               ,'$this->si82_nrocndt' 
                               ," . ($this->si82_dtemissaocndt == "null" || $this->si82_dtemissaocndt == "" ? "null" : "'" . $this->si82_dtemissaocndt . "'") . " 
                               ," . ($this->si82_dtvalidadecndt == "null" || $this->si82_dtvalidadecndt == "" ? "null" : "'" . $this->si82_dtvalidadecndt . "'") . " 
                               ,$this->si82_mes 
                               ,$this->si82_reg10 
                               ,$this->si82_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "dispensa182019 ($this->si82_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "dispensa182019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "dispensa182019 ($this->si82_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si82_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si82_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010373,'$this->si82_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010311,2010373,'','" . AddSlashes(pg_result($resaco, 0, 'si82_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010374,'','" . AddSlashes(pg_result($resaco, 0, 'si82_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010375,'','" . AddSlashes(pg_result($resaco, 0, 'si82_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010376,'','" . AddSlashes(pg_result($resaco, 0, 'si82_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010377,'','" . AddSlashes(pg_result($resaco, 0, 'si82_exercicioprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010378,'','" . AddSlashes(pg_result($resaco, 0, 'si82_nroprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010379,'','" . AddSlashes(pg_result($resaco, 0, 'si82_tipoprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010380,'','" . AddSlashes(pg_result($resaco, 0, 'si82_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010381,'','" . AddSlashes(pg_result($resaco, 0, 'si82_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010382,'','" . AddSlashes(pg_result($resaco, 0, 'si82_datacredenciamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010383,'','" . AddSlashes(pg_result($resaco, 0, 'si82_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010384,'','" . AddSlashes(pg_result($resaco, 0, 'si82_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010385,'','" . AddSlashes(pg_result($resaco, 0, 'si82_nroinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010386,'','" . AddSlashes(pg_result($resaco, 0, 'si82_ufinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010387,'','" . AddSlashes(pg_result($resaco, 0, 'si82_nrocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010388,'','" . AddSlashes(pg_result($resaco, 0, 'si82_dataemissaocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010390,'','" . AddSlashes(pg_result($resaco, 0, 'si82_dtvalidadecertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010391,'','" . AddSlashes(pg_result($resaco, 0, 'si82_nrocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010392,'','" . AddSlashes(pg_result($resaco, 0, 'si82_dtemissaocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010393,'','" . AddSlashes(pg_result($resaco, 0, 'si82_dtvalidadecertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010394,'','" . AddSlashes(pg_result($resaco, 0, 'si82_nrocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010395,'','" . AddSlashes(pg_result($resaco, 0, 'si82_dtemissaocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010396,'','" . AddSlashes(pg_result($resaco, 0, 'si82_dtvalidadecndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010397,'','" . AddSlashes(pg_result($resaco, 0, 'si82_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2010398,'','" . AddSlashes(pg_result($resaco, 0, 'si82_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010311,2011595,'','" . AddSlashes(pg_result($resaco, 0, 'si82_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  
  // funcao para alteracao
  function alterar($si82_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update dispensa182019 set ";
    $virgula = "";
    if (trim($this->si82_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_sequencial"])) {
      if (trim($this->si82_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si82_sequencial"])) {
        $this->si82_sequencial = "0";
      }
      $sql .= $virgula . " si82_sequencial = $this->si82_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si82_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_tiporegistro"])) {
      $sql .= $virgula . " si82_tiporegistro = $this->si82_tiporegistro ";
      $virgula = ",";
      if (trim($this->si82_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si82_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si82_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_codorgaoresp"])) {
      $sql .= $virgula . " si82_codorgaoresp = '$this->si82_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si82_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_codunidadesubresp"])) {
      $sql .= $virgula . " si82_codunidadesubresp = '$this->si82_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si82_exercicioprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_exercicioprocesso"])) {
      if (trim($this->si82_exercicioprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si82_exercicioprocesso"])) {
        $this->si82_exercicioprocesso = "0";
      }
      $sql .= $virgula . " si82_exercicioprocesso = $this->si82_exercicioprocesso ";
      $virgula = ",";
    }
    if (trim($this->si82_nroprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_nroprocesso"])) {
      $sql .= $virgula . " si82_nroprocesso = '$this->si82_nroprocesso' ";
      $virgula = ",";
    }
    if (trim($this->si82_tipoprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_tipoprocesso"])) {
      if (trim($this->si82_tipoprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si82_tipoprocesso"])) {
        $this->si82_tipoprocesso = "0";
      }
      $sql .= $virgula . " si82_tipoprocesso = $this->si82_tipoprocesso ";
      $virgula = ",";
    }
    if (trim($this->si82_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_tipodocumento"])) {
      if (trim($this->si82_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si82_tipodocumento"])) {
        $this->si82_tipodocumento = "0";
      }
      $sql .= $virgula . " si82_tipodocumento = $this->si82_tipodocumento ";
      $virgula = ",";
    }
    if (trim($this->si82_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_nrodocumento"])) {
      $sql .= $virgula . " si82_nrodocumento = '$this->si82_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si82_datacredenciamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_datacredenciamento_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si82_datacredenciamento_dia"] != "")) {
      $sql .= $virgula . " si82_datacredenciamento = '$this->si82_datacredenciamento' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si82_datacredenciamento_dia"])) {
        $sql .= $virgula . " si82_datacredenciamento = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si82_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_nrolote"])) {
      if (trim($this->si82_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si82_nrolote"])) {
        $this->si82_nrolote = "0";
      }
      $sql .= $virgula . " si82_nrolote = $this->si82_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si82_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_coditem"])) {
      if (trim($this->si82_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si82_coditem"])) {
        $this->si82_coditem = "0";
      }
      $sql .= $virgula . " si82_coditem = $this->si82_coditem ";
      $virgula = ",";
    }
    if (trim($this->si82_nroinscricaoestadual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_nroinscricaoestadual"])) {
      $sql .= $virgula . " si82_nroinscricaoestadual = '$this->si82_nroinscricaoestadual' ";
      $virgula = ",";
    }
    if (trim($this->si82_ufinscricaoestadual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_ufinscricaoestadual"])) {
      $sql .= $virgula . " si82_ufinscricaoestadual = '$this->si82_ufinscricaoestadual' ";
      $virgula = ",";
    }
    if (trim($this->si82_nrocertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_nrocertidaoregularidadeinss"])) {
      $sql .= $virgula . " si82_nrocertidaoregularidadeinss = '$this->si82_nrocertidaoregularidadeinss' ";
      $virgula = ",";
    }
    if (trim($this->si82_dataemissaocertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_dataemissaocertidaoregularidadeinss_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si82_dataemissaocertidaoregularidadeinss_dia"] != "")) {
      $sql .= $virgula . " si82_dataemissaocertidaoregularidadeinss = '$this->si82_dataemissaocertidaoregularidadeinss' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dataemissaocertidaoregularidadeinss_dia"])) {
        $sql .= $virgula . " si82_dataemissaocertidaoregularidadeinss = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si82_dtvalidadecertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadeinss_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadeinss_dia"] != "")) {
      $sql .= $virgula . " si82_dtvalidadecertidaoregularidadeinss = '$this->si82_dtvalidadecertidaoregularidadeinss' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadeinss_dia"])) {
        $sql .= $virgula . " si82_dtvalidadecertidaoregularidadeinss = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si82_nrocertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_nrocertidaoregularidadefgts"])) {
      $sql .= $virgula . " si82_nrocertidaoregularidadefgts = '$this->si82_nrocertidaoregularidadefgts' ";
      $virgula = ",";
    }
    if (trim($this->si82_dtemissaocertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocertidaoregularidadefgts_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocertidaoregularidadefgts_dia"] != "")) {
      $sql .= $virgula . " si82_dtemissaocertidaoregularidadefgts = '$this->si82_dtemissaocertidaoregularidadefgts' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocertidaoregularidadefgts_dia"])) {
        $sql .= $virgula . " si82_dtemissaocertidaoregularidadefgts = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si82_dtvalidadecertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadefgts_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadefgts_dia"] != "")) {
      $sql .= $virgula . " si82_dtvalidadecertidaoregularidadefgts = '$this->si82_dtvalidadecertidaoregularidadefgts' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadefgts_dia"])) {
        $sql .= $virgula . " si82_dtvalidadecertidaoregularidadefgts = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si82_nrocndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_nrocndt"])) {
      $sql .= $virgula . " si82_nrocndt = '$this->si82_nrocndt' ";
      $virgula = ",";
    }
    if (trim($this->si82_dtemissaocndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocndt_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocndt_dia"] != "")) {
      $sql .= $virgula . " si82_dtemissaocndt = '$this->si82_dtemissaocndt' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocndt_dia"])) {
        $sql .= $virgula . " si82_dtemissaocndt = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si82_dtvalidadecndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecndt_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecndt_dia"] != "")) {
      $sql .= $virgula . " si82_dtvalidadecndt = '$this->si82_dtvalidadecndt' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecndt_dia"])) {
        $sql .= $virgula . " si82_dtvalidadecndt = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si82_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_mes"])) {
      $sql .= $virgula . " si82_mes = $this->si82_mes ";
      $virgula = ",";
      if (trim($this->si82_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si82_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si82_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_reg10"])) {
      if (trim($this->si82_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si82_reg10"])) {
        $this->si82_reg10 = "0";
      }
      $sql .= $virgula . " si82_reg10 = $this->si82_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si82_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si82_instit"])) {
      $sql .= $virgula . " si82_instit = $this->si82_instit ";
      $virgula = ",";
      if (trim($this->si82_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si82_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si82_sequencial != null) {
      $sql .= " si82_sequencial = $this->si82_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si82_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010373,'$this->si82_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_sequencial"]) || $this->si82_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010373,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_sequencial')) . "','$this->si82_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_tiporegistro"]) || $this->si82_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010374,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_tiporegistro')) . "','$this->si82_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_codorgaoresp"]) || $this->si82_codorgaoresp != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010375,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_codorgaoresp')) . "','$this->si82_codorgaoresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_codunidadesubresp"]) || $this->si82_codunidadesubresp != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010376,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_codunidadesubresp')) . "','$this->si82_codunidadesubresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_exercicioprocesso"]) || $this->si82_exercicioprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010377,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_exercicioprocesso')) . "','$this->si82_exercicioprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_nroprocesso"]) || $this->si82_nroprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010378,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_nroprocesso')) . "','$this->si82_nroprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_tipoprocesso"]) || $this->si82_tipoprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010379,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_tipoprocesso')) . "','$this->si82_tipoprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_tipodocumento"]) || $this->si82_tipodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010380,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_tipodocumento')) . "','$this->si82_tipodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_nrodocumento"]) || $this->si82_nrodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010381,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_nrodocumento')) . "','$this->si82_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_datacredenciamento"]) || $this->si82_datacredenciamento != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010382,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_datacredenciamento')) . "','$this->si82_datacredenciamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_nrolote"]) || $this->si82_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010383,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_nrolote')) . "','$this->si82_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_coditem"]) || $this->si82_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010384,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_coditem')) . "','$this->si82_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_nroinscricaoestadual"]) || $this->si82_nroinscricaoestadual != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010385,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_nroinscricaoestadual')) . "','$this->si82_nroinscricaoestadual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_ufinscricaoestadual"]) || $this->si82_ufinscricaoestadual != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010386,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_ufinscricaoestadual')) . "','$this->si82_ufinscricaoestadual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_nrocertidaoregularidadeinss"]) || $this->si82_nrocertidaoregularidadeinss != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010387,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_nrocertidaoregularidadeinss')) . "','$this->si82_nrocertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dataemissaocertidaoregularidadeinss"]) || $this->si82_dataemissaocertidaoregularidadeinss != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010388,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_dataemissaocertidaoregularidadeinss')) . "','$this->si82_dataemissaocertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadeinss"]) || $this->si82_dtvalidadecertidaoregularidadeinss != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010390,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_dtvalidadecertidaoregularidadeinss')) . "','$this->si82_dtvalidadecertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_nrocertidaoregularidadefgts"]) || $this->si82_nrocertidaoregularidadefgts != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010391,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_nrocertidaoregularidadefgts')) . "','$this->si82_nrocertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocertidaoregularidadefgts"]) || $this->si82_dtemissaocertidaoregularidadefgts != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010392,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_dtemissaocertidaoregularidadefgts')) . "','$this->si82_dtemissaocertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecertidaoregularidadefgts"]) || $this->si82_dtvalidadecertidaoregularidadefgts != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010393,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_dtvalidadecertidaoregularidadefgts')) . "','$this->si82_dtvalidadecertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_nrocndt"]) || $this->si82_nrocndt != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010394,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_nrocndt')) . "','$this->si82_nrocndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dtemissaocndt"]) || $this->si82_dtemissaocndt != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010395,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_dtemissaocndt')) . "','$this->si82_dtemissaocndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_dtvalidadecndt"]) || $this->si82_dtvalidadecndt != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010396,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_dtvalidadecndt')) . "','$this->si82_dtvalidadecndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_mes"]) || $this->si82_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010397,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_mes')) . "','$this->si82_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_reg10"]) || $this->si82_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2010398,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_reg10')) . "','$this->si82_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si82_instit"]) || $this->si82_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010311,2011595,'" . AddSlashes(pg_result($resaco, $conresaco, 'si82_instit')) . "','$this->si82_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "dispensa182019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si82_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dispensa182019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si82_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si82_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si82_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si82_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010373,'$si82_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010311,2010373,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010374,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010375,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010376,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010377,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_exercicioprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010378,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_nroprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010379,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_tipoprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010380,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010381,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010382,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_datacredenciamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010383,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010384,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010385,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_nroinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010386,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_ufinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010387,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_nrocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010388,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_dataemissaocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010390,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_dtvalidadecertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010391,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_nrocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010392,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_dtemissaocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010393,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_dtvalidadecertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010394,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_nrocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010395,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_dtemissaocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010396,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_dtvalidadecndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010397,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2010398,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010311,2011595,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si82_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from dispensa182019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si82_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si82_sequencial = $si82_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "dispensa182019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si82_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dispensa182019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si82_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si82_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:dispensa182019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  
  // funcao do sql
  function sql_query($si82_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dispensa182019 ";
    $sql .= "      left  join dispensa102019  on  dispensa102019.si74_sequencial = dispensa182019.si82_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si82_sequencial != null) {
        $sql2 .= " where dispensa182019.si82_sequencial = $si82_sequencial ";
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
  function sql_query_file($si82_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dispensa182019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si82_sequencial != null) {
        $sql2 .= " where dispensa182019.si82_sequencial = $si82_sequencial ";
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
