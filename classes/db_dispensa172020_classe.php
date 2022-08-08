<?
//MODULO: sicom
//CLASSE DA ENTIDADE dispensa172020
class cl_dispensa172020
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
  var $si81_sequencial = 0;
  var $si81_tiporegistro = 0;
  var $si81_codorgaoresp = null;
  var $si81_codunidadesubresp = null;
  var $si81_exercicioprocesso = 0;
  var $si81_nroprocesso = null;
  var $si81_tipoprocesso = 0;
  var $si81_tipodocumento = 0;
  var $si81_nrodocumento = null;
  var $si81_nroinscricaoestadual = null;
  var $si81_ufinscricaoestadual = null;
  var $si81_nrocertidaoregularidadeinss = null;
  var $si81_dtemissaocertidaoregularidadeinss_dia = null;
  var $si81_dtemissaocertidaoregularidadeinss_mes = null;
  var $si81_dtemissaocertidaoregularidadeinss_ano = null;
  var $si81_dtemissaocertidaoregularidadeinss = null;
  var $si81_dtvalidadecertidaoregularidadeinss_dia = null;
  var $si81_dtvalidadecertidaoregularidadeinss_mes = null;
  var $si81_dtvalidadecertidaoregularidadeinss_ano = null;
  var $si81_dtvalidadecertidaoregularidadeinss = null;
  var $si81_nrocertidaoregularidadefgts = null;
  var $si81_dtemissaocertidaoregularidadefgts_dia = null;
  var $si81_dtemissaocertidaoregularidadefgts_mes = null;
  var $si81_dtemissaocertidaoregularidadefgts_ano = null;
  var $si81_dtemissaocertidaoregularidadefgts = null;
  var $si81_dtvalidadecertidaoregularidadefgts_dia = null;
  var $si81_dtvalidadecertidaoregularidadefgts_mes = null;
  var $si81_dtvalidadecertidaoregularidadefgts_ano = null;
  var $si81_dtvalidadecertidaoregularidadefgts = null;
  var $si81_nrocndt = null;
  var $si81_dtemissaocndt_dia = null;
  var $si81_dtemissaocndt_mes = null;
  var $si81_dtemissaocndt_ano = null;
  var $si81_dtemissaocndt = null;
  var $si81_dtvalidadecndt_dia = null;
  var $si81_dtvalidadecndt_mes = null;
  var $si81_dtvalidadecndt_ano = null;
  var $si81_dtvalidadecndt = null;
  var $si81_nrolote = 0;
  var $si81_coditem = 0;
  var $si81_quantidade = 0;
  var $si81_vlitem = 0;
  var $si81_mes = 0;
  var $si81_reg10 = 0;
  var $si81_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si81_sequencial = int8 = sequencial 
                 si81_tiporegistro = int8 = Tipo do registro 
                 si81_codorgaoresp = varchar(2) = Código do órgão responsável 
                 si81_codunidadesubresp = varchar(8) = Código da unidade 
                 si81_exercicioprocesso = int8 = Exercício em que  foi instaurado 
                 si81_nroprocesso = varchar(12) = Número sequencial  do processo 
                 si81_tipoprocesso = int8 = Tipo de processo 
                 si81_tipodocumento = int8 = Tipo do  documento 
                 si81_nrodocumento = varchar(14) = Número do  documento 
                 si81_nroinscricaoestadual = varchar(30) = Número da  inscrição estadual 
                 si81_ufinscricaoestadual = varchar(2) = UF da inscrição  estadual 
                 si81_nrocertidaoregularidadeinss = varchar(30) = Número da certidão de R INSS 
                 si81_dtemissaocertidaoregularidadeinss = date = Data de emissão  da certidão 
                 si81_dtvalidadecertidaoregularidadeinss = date = Data de validade  da certidão 
                 si81_nrocertidaoregularidadefgts = varchar(30) = Número da certidão  de R FGTS 
                 si81_dtemissaocertidaoregularidadefgts = date = Data de emissão  da certidão 
                 si81_dtvalidadecertidaoregularidadefgts = date = Data de validade  da certidão 
                 si81_nrocndt = varchar(30) = Número da  Certidão Negativa  de Débitos 
                 si81_dtemissaocndt = date = Data de emissão  da certidão  Negativa 
                 si81_dtvalidadecndt = date = Data de validade  da certidão  Negativa 
                 si81_nrolote = int8 = Número do Lote 
                 si81_coditem = int8 = Código do Item 
                 si81_quantidade = float8 = Quantidade do item 
                 si81_vlitem = float8 = Valor do Item 
                 si81_mes = int8 = Mês 
                 si81_reg10 = int8 = reg10 
                 si81_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_dispensa172020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("dispensa172020");
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
      $this->si81_sequencial = ($this->si81_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_sequencial"] : $this->si81_sequencial);
      $this->si81_tiporegistro = ($this->si81_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_tiporegistro"] : $this->si81_tiporegistro);
      $this->si81_codorgaoresp = ($this->si81_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_codorgaoresp"] : $this->si81_codorgaoresp);
      $this->si81_codunidadesubresp = ($this->si81_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_codunidadesubresp"] : $this->si81_codunidadesubresp);
      $this->si81_exercicioprocesso = ($this->si81_exercicioprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_exercicioprocesso"] : $this->si81_exercicioprocesso);
      $this->si81_nroprocesso = ($this->si81_nroprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_nroprocesso"] : $this->si81_nroprocesso);
      $this->si81_tipoprocesso = ($this->si81_tipoprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_tipoprocesso"] : $this->si81_tipoprocesso);
      $this->si81_tipodocumento = ($this->si81_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_tipodocumento"] : $this->si81_tipodocumento);
      $this->si81_nrodocumento = ($this->si81_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_nrodocumento"] : $this->si81_nrodocumento);
      $this->si81_nroinscricaoestadual = ($this->si81_nroinscricaoestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_nroinscricaoestadual"] : $this->si81_nroinscricaoestadual);
      $this->si81_ufinscricaoestadual = ($this->si81_ufinscricaoestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_ufinscricaoestadual"] : $this->si81_ufinscricaoestadual);
      $this->si81_nrocertidaoregularidadeinss = ($this->si81_nrocertidaoregularidadeinss == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_nrocertidaoregularidadeinss"] : $this->si81_nrocertidaoregularidadeinss);
      if ($this->si81_dtemissaocertidaoregularidadeinss == "") {
        $this->si81_dtemissaocertidaoregularidadeinss_dia = ($this->si81_dtemissaocertidaoregularidadeinss_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadeinss_dia"] : $this->si81_dtemissaocertidaoregularidadeinss_dia);
        $this->si81_dtemissaocertidaoregularidadeinss_mes = ($this->si81_dtemissaocertidaoregularidadeinss_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadeinss_mes"] : $this->si81_dtemissaocertidaoregularidadeinss_mes);
        $this->si81_dtemissaocertidaoregularidadeinss_ano = ($this->si81_dtemissaocertidaoregularidadeinss_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadeinss_ano"] : $this->si81_dtemissaocertidaoregularidadeinss_ano);
        if ($this->si81_dtemissaocertidaoregularidadeinss_dia != "") {
          $this->si81_dtemissaocertidaoregularidadeinss = $this->si81_dtemissaocertidaoregularidadeinss_ano . "-" . $this->si81_dtemissaocertidaoregularidadeinss_mes . "-" . $this->si81_dtemissaocertidaoregularidadeinss_dia;
        }
      }
      if ($this->si81_dtvalidadecertidaoregularidadeinss == "") {
        $this->si81_dtvalidadecertidaoregularidadeinss_dia = ($this->si81_dtvalidadecertidaoregularidadeinss_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadeinss_dia"] : $this->si81_dtvalidadecertidaoregularidadeinss_dia);
        $this->si81_dtvalidadecertidaoregularidadeinss_mes = ($this->si81_dtvalidadecertidaoregularidadeinss_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadeinss_mes"] : $this->si81_dtvalidadecertidaoregularidadeinss_mes);
        $this->si81_dtvalidadecertidaoregularidadeinss_ano = ($this->si81_dtvalidadecertidaoregularidadeinss_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadeinss_ano"] : $this->si81_dtvalidadecertidaoregularidadeinss_ano);
        if ($this->si81_dtvalidadecertidaoregularidadeinss_dia != "") {
          $this->si81_dtvalidadecertidaoregularidadeinss = $this->si81_dtvalidadecertidaoregularidadeinss_ano . "-" . $this->si81_dtvalidadecertidaoregularidadeinss_mes . "-" . $this->si81_dtvalidadecertidaoregularidadeinss_dia;
        }
      }
      $this->si81_nrocertidaoregularidadefgts = ($this->si81_nrocertidaoregularidadefgts == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_nrocertidaoregularidadefgts"] : $this->si81_nrocertidaoregularidadefgts);
      if ($this->si81_dtemissaocertidaoregularidadefgts == "") {
        $this->si81_dtemissaocertidaoregularidadefgts_dia = ($this->si81_dtemissaocertidaoregularidadefgts_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadefgts_dia"] : $this->si81_dtemissaocertidaoregularidadefgts_dia);
        $this->si81_dtemissaocertidaoregularidadefgts_mes = ($this->si81_dtemissaocertidaoregularidadefgts_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadefgts_mes"] : $this->si81_dtemissaocertidaoregularidadefgts_mes);
        $this->si81_dtemissaocertidaoregularidadefgts_ano = ($this->si81_dtemissaocertidaoregularidadefgts_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadefgts_ano"] : $this->si81_dtemissaocertidaoregularidadefgts_ano);
        if ($this->si81_dtemissaocertidaoregularidadefgts_dia != "") {
          $this->si81_dtemissaocertidaoregularidadefgts = $this->si81_dtemissaocertidaoregularidadefgts_ano . "-" . $this->si81_dtemissaocertidaoregularidadefgts_mes . "-" . $this->si81_dtemissaocertidaoregularidadefgts_dia;
        }
      }
      if ($this->si81_dtvalidadecertidaoregularidadefgts == "") {
        $this->si81_dtvalidadecertidaoregularidadefgts_dia = ($this->si81_dtvalidadecertidaoregularidadefgts_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadefgts_dia"] : $this->si81_dtvalidadecertidaoregularidadefgts_dia);
        $this->si81_dtvalidadecertidaoregularidadefgts_mes = ($this->si81_dtvalidadecertidaoregularidadefgts_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadefgts_mes"] : $this->si81_dtvalidadecertidaoregularidadefgts_mes);
        $this->si81_dtvalidadecertidaoregularidadefgts_ano = ($this->si81_dtvalidadecertidaoregularidadefgts_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadefgts_ano"] : $this->si81_dtvalidadecertidaoregularidadefgts_ano);
        if ($this->si81_dtvalidadecertidaoregularidadefgts_dia != "") {
          $this->si81_dtvalidadecertidaoregularidadefgts = $this->si81_dtvalidadecertidaoregularidadefgts_ano . "-" . $this->si81_dtvalidadecertidaoregularidadefgts_mes . "-" . $this->si81_dtvalidadecertidaoregularidadefgts_dia;
        }
      }
      $this->si81_nrocndt = ($this->si81_nrocndt == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_nrocndt"] : $this->si81_nrocndt);
      if ($this->si81_dtemissaocndt == "") {
        $this->si81_dtemissaocndt_dia = ($this->si81_dtemissaocndt_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocndt_dia"] : $this->si81_dtemissaocndt_dia);
        $this->si81_dtemissaocndt_mes = ($this->si81_dtemissaocndt_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocndt_mes"] : $this->si81_dtemissaocndt_mes);
        $this->si81_dtemissaocndt_ano = ($this->si81_dtemissaocndt_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocndt_ano"] : $this->si81_dtemissaocndt_ano);
        if ($this->si81_dtemissaocndt_dia != "") {
          $this->si81_dtemissaocndt = $this->si81_dtemissaocndt_ano . "-" . $this->si81_dtemissaocndt_mes . "-" . $this->si81_dtemissaocndt_dia;
        }
      }
      if ($this->si81_dtvalidadecndt == "") {
        $this->si81_dtvalidadecndt_dia = ($this->si81_dtvalidadecndt_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecndt_dia"] : $this->si81_dtvalidadecndt_dia);
        $this->si81_dtvalidadecndt_mes = ($this->si81_dtvalidadecndt_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecndt_mes"] : $this->si81_dtvalidadecndt_mes);
        $this->si81_dtvalidadecndt_ano = ($this->si81_dtvalidadecndt_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecndt_ano"] : $this->si81_dtvalidadecndt_ano);
        if ($this->si81_dtvalidadecndt_dia != "") {
          $this->si81_dtvalidadecndt = $this->si81_dtvalidadecndt_ano . "-" . $this->si81_dtvalidadecndt_mes . "-" . $this->si81_dtvalidadecndt_dia;
        }
      }
      $this->si81_nrolote = ($this->si81_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_nrolote"] : $this->si81_nrolote);
      $this->si81_coditem = ($this->si81_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_coditem"] : $this->si81_coditem);
      $this->si81_quantidade = ($this->si81_quantidade == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_quantidade"] : $this->si81_quantidade);
      $this->si81_vlitem = ($this->si81_vlitem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_vlitem"] : $this->si81_vlitem);
      $this->si81_mes = ($this->si81_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_mes"] : $this->si81_mes);
      $this->si81_reg10 = ($this->si81_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_reg10"] : $this->si81_reg10);
      $this->si81_instit = ($this->si81_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_instit"] : $this->si81_instit);
    } else {
      $this->si81_sequencial = ($this->si81_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si81_sequencial"] : $this->si81_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si81_sequencial)
  {
    $this->atualizacampos();
    if ($this->si81_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si81_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si81_exercicioprocesso == null) {
      $this->si81_exercicioprocesso = "0";
    }
    if ($this->si81_tipoprocesso == null) {
      $this->si81_tipoprocesso = "0";
    }
    if ($this->si81_tipodocumento == null) {
      $this->si81_tipodocumento = "0";
    }
    if ($this->si81_dtemissaocertidaoregularidadeinss == null) {
      $this->si81_dtemissaocertidaoregularidadeinss = "null";
    }
    if ($this->si81_dtvalidadecertidaoregularidadeinss == null) {
      $this->si81_dtvalidadecertidaoregularidadeinss = "null";
    }
    if ($this->si81_dtemissaocertidaoregularidadefgts == null) {
      $this->si81_dtemissaocertidaoregularidadefgts = "null";
    }
    if ($this->si81_dtvalidadecertidaoregularidadefgts == null) {
      $this->si81_dtvalidadecertidaoregularidadefgts = "null";
    }
    if ($this->si81_dtemissaocndt == null) {
      $this->si81_dtemissaocndt = "null";
    }
    if ($this->si81_dtvalidadecndt == null) {
      $this->si81_dtvalidadecndt = "null";
    }
    if ($this->si81_nrolote == null) {
      $this->si81_nrolote = "0";
    }
    if ($this->si81_coditem == null) {
      $this->si81_coditem = "0";
    }
    if ($this->si81_quantidade == null) {
      $this->si81_quantidade = "0";
    }
    if ($this->si81_vlitem == null) {
      $this->si81_vlitem = "0";
    }
    if ($this->si81_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si81_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si81_reg10 == null) {
      $this->si81_reg10 = "0";
    }
    if ($this->si81_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si81_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si81_sequencial == "" || $si81_sequencial == null) {
      $result = db_query("select nextval('dispensa172020_si81_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: dispensa172020_si81_sequencial_seq do campo: si81_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si81_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from dispensa172020_si81_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si81_sequencial)) {
        $this->erro_sql = " Campo si81_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si81_sequencial = $si81_sequencial;
      }
    }
    if (($this->si81_sequencial == null) || ($this->si81_sequencial == "")) {
      $this->erro_sql = " Campo si81_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into dispensa172020(
                                       si81_sequencial 
                                      ,si81_tiporegistro 
                                      ,si81_codorgaoresp 
                                      ,si81_codunidadesubresp 
                                      ,si81_exercicioprocesso 
                                      ,si81_nroprocesso 
                                      ,si81_tipoprocesso 
                                      ,si81_tipodocumento 
                                      ,si81_nrodocumento 
                                      ,si81_nroinscricaoestadual 
                                      ,si81_ufinscricaoestadual 
                                      ,si81_nrocertidaoregularidadeinss 
                                      ,si81_dtemissaocertidaoregularidadeinss 
                                      ,si81_dtvalidadecertidaoregularidadeinss 
                                      ,si81_nrocertidaoregularidadefgts 
                                      ,si81_dtemissaocertidaoregularidadefgts 
                                      ,si81_dtvalidadecertidaoregularidadefgts 
                                      ,si81_nrocndt 
                                      ,si81_dtemissaocndt 
                                      ,si81_dtvalidadecndt 
                                      ,si81_nrolote 
                                      ,si81_coditem 
                                      ,si81_quantidade 
                                      ,si81_vlitem 
                                      ,si81_mes 
                                      ,si81_reg10 
                                      ,si81_instit 
                       )
                values (
                                $this->si81_sequencial 
                               ,$this->si81_tiporegistro 
                               ,'$this->si81_codorgaoresp' 
                               ,'$this->si81_codunidadesubresp' 
                               ,$this->si81_exercicioprocesso 
                               ,'$this->si81_nroprocesso' 
                               ,$this->si81_tipoprocesso 
                               ,$this->si81_tipodocumento 
                               ,'$this->si81_nrodocumento' 
                               ,'$this->si81_nroinscricaoestadual' 
                               ,'$this->si81_ufinscricaoestadual' 
                               ,'$this->si81_nrocertidaoregularidadeinss' 
                               ," . ($this->si81_dtemissaocertidaoregularidadeinss == "null" || $this->si81_dtemissaocertidaoregularidadeinss == "" ? "null" : "'" . $this->si81_dtemissaocertidaoregularidadeinss . "'") . " 
                               ," . ($this->si81_dtvalidadecertidaoregularidadeinss == "null" || $this->si81_dtvalidadecertidaoregularidadeinss == "" ? "null" : "'" . $this->si81_dtvalidadecertidaoregularidadeinss . "'") . " 
                               ,'$this->si81_nrocertidaoregularidadefgts' 
                               ," . ($this->si81_dtemissaocertidaoregularidadefgts == "null" || $this->si81_dtemissaocertidaoregularidadefgts == "" ? "null" : "'" . $this->si81_dtemissaocertidaoregularidadefgts . "'") . " 
                               ," . ($this->si81_dtvalidadecertidaoregularidadefgts == "null" || $this->si81_dtvalidadecertidaoregularidadefgts == "" ? "null" : "'" . $this->si81_dtvalidadecertidaoregularidadefgts . "'") . " 
                               ,'$this->si81_nrocndt' 
                               ," . ($this->si81_dtemissaocndt == "null" || $this->si81_dtemissaocndt == "" ? "null" : "'" . $this->si81_dtemissaocndt . "'") . " 
                               ," . ($this->si81_dtvalidadecndt == "null" || $this->si81_dtvalidadecndt == "" ? "null" : "'" . $this->si81_dtvalidadecndt . "'") . " 
                               ,$this->si81_nrolote 
                               ,$this->si81_coditem 
                               ,$this->si81_quantidade 
                               ,$this->si81_vlitem 
                               ,$this->si81_mes 
                               ,$this->si81_reg10 
                               ,$this->si81_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "dispensa172020 ($this->si81_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "dispensa172020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "dispensa172020 ($this->si81_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si81_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si81_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010347,'$this->si81_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010310,2010347,'','" . AddSlashes(pg_result($resaco, 0, 'si81_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010348,'','" . AddSlashes(pg_result($resaco, 0, 'si81_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010349,'','" . AddSlashes(pg_result($resaco, 0, 'si81_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010350,'','" . AddSlashes(pg_result($resaco, 0, 'si81_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010351,'','" . AddSlashes(pg_result($resaco, 0, 'si81_exercicioprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010352,'','" . AddSlashes(pg_result($resaco, 0, 'si81_nroprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010353,'','" . AddSlashes(pg_result($resaco, 0, 'si81_tipoprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010354,'','" . AddSlashes(pg_result($resaco, 0, 'si81_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010355,'','" . AddSlashes(pg_result($resaco, 0, 'si81_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010356,'','" . AddSlashes(pg_result($resaco, 0, 'si81_nroinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010357,'','" . AddSlashes(pg_result($resaco, 0, 'si81_ufinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010358,'','" . AddSlashes(pg_result($resaco, 0, 'si81_nrocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010359,'','" . AddSlashes(pg_result($resaco, 0, 'si81_dtemissaocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010360,'','" . AddSlashes(pg_result($resaco, 0, 'si81_dtvalidadecertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010361,'','" . AddSlashes(pg_result($resaco, 0, 'si81_nrocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010362,'','" . AddSlashes(pg_result($resaco, 0, 'si81_dtemissaocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010363,'','" . AddSlashes(pg_result($resaco, 0, 'si81_dtvalidadecertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010364,'','" . AddSlashes(pg_result($resaco, 0, 'si81_nrocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010365,'','" . AddSlashes(pg_result($resaco, 0, 'si81_dtemissaocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010366,'','" . AddSlashes(pg_result($resaco, 0, 'si81_dtvalidadecndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010367,'','" . AddSlashes(pg_result($resaco, 0, 'si81_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010368,'','" . AddSlashes(pg_result($resaco, 0, 'si81_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010369,'','" . AddSlashes(pg_result($resaco, 0, 'si81_quantidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010370,'','" . AddSlashes(pg_result($resaco, 0, 'si81_vlitem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010371,'','" . AddSlashes(pg_result($resaco, 0, 'si81_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2010372,'','" . AddSlashes(pg_result($resaco, 0, 'si81_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010310,2011594,'','" . AddSlashes(pg_result($resaco, 0, 'si81_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  
  // funcao para alteracao
  function alterar($si81_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update dispensa172020 set ";
    $virgula = "";
    if (trim($this->si81_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_sequencial"])) {
      if (trim($this->si81_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si81_sequencial"])) {
        $this->si81_sequencial = "0";
      }
      $sql .= $virgula . " si81_sequencial = $this->si81_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si81_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_tiporegistro"])) {
      $sql .= $virgula . " si81_tiporegistro = $this->si81_tiporegistro ";
      $virgula = ",";
      if (trim($this->si81_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si81_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si81_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_codorgaoresp"])) {
      $sql .= $virgula . " si81_codorgaoresp = '$this->si81_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si81_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_codunidadesubresp"])) {
      $sql .= $virgula . " si81_codunidadesubresp = '$this->si81_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si81_exercicioprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_exercicioprocesso"])) {
      if (trim($this->si81_exercicioprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si81_exercicioprocesso"])) {
        $this->si81_exercicioprocesso = "0";
      }
      $sql .= $virgula . " si81_exercicioprocesso = $this->si81_exercicioprocesso ";
      $virgula = ",";
    }
    if (trim($this->si81_nroprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_nroprocesso"])) {
      $sql .= $virgula . " si81_nroprocesso = '$this->si81_nroprocesso' ";
      $virgula = ",";
    }
    if (trim($this->si81_tipoprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_tipoprocesso"])) {
      if (trim($this->si81_tipoprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si81_tipoprocesso"])) {
        $this->si81_tipoprocesso = "0";
      }
      $sql .= $virgula . " si81_tipoprocesso = $this->si81_tipoprocesso ";
      $virgula = ",";
    }
    if (trim($this->si81_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_tipodocumento"])) {
      if (trim($this->si81_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si81_tipodocumento"])) {
        $this->si81_tipodocumento = "0";
      }
      $sql .= $virgula . " si81_tipodocumento = $this->si81_tipodocumento ";
      $virgula = ",";
    }
    if (trim($this->si81_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_nrodocumento"])) {
      $sql .= $virgula . " si81_nrodocumento = '$this->si81_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si81_nroinscricaoestadual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_nroinscricaoestadual"])) {
      $sql .= $virgula . " si81_nroinscricaoestadual = '$this->si81_nroinscricaoestadual' ";
      $virgula = ",";
    }
    if (trim($this->si81_ufinscricaoestadual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_ufinscricaoestadual"])) {
      $sql .= $virgula . " si81_ufinscricaoestadual = '$this->si81_ufinscricaoestadual' ";
      $virgula = ",";
    }
    if (trim($this->si81_nrocertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_nrocertidaoregularidadeinss"])) {
      $sql .= $virgula . " si81_nrocertidaoregularidadeinss = '$this->si81_nrocertidaoregularidadeinss' ";
      $virgula = ",";
    }
    if (trim($this->si81_dtemissaocertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadeinss_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadeinss_dia"] != "")) {
      $sql .= $virgula . " si81_dtemissaocertidaoregularidadeinss = '$this->si81_dtemissaocertidaoregularidadeinss' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadeinss_dia"])) {
        $sql .= $virgula . " si81_dtemissaocertidaoregularidadeinss = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si81_dtvalidadecertidaoregularidadeinss) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadeinss_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadeinss_dia"] != "")) {
      $sql .= $virgula . " si81_dtvalidadecertidaoregularidadeinss = '$this->si81_dtvalidadecertidaoregularidadeinss' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadeinss_dia"])) {
        $sql .= $virgula . " si81_dtvalidadecertidaoregularidadeinss = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si81_nrocertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_nrocertidaoregularidadefgts"])) {
      $sql .= $virgula . " si81_nrocertidaoregularidadefgts = '$this->si81_nrocertidaoregularidadefgts' ";
      $virgula = ",";
    }
    if (trim($this->si81_dtemissaocertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadefgts_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadefgts_dia"] != "")) {
      $sql .= $virgula . " si81_dtemissaocertidaoregularidadefgts = '$this->si81_dtemissaocertidaoregularidadefgts' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadefgts_dia"])) {
        $sql .= $virgula . " si81_dtemissaocertidaoregularidadefgts = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si81_dtvalidadecertidaoregularidadefgts) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadefgts_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadefgts_dia"] != "")) {
      $sql .= $virgula . " si81_dtvalidadecertidaoregularidadefgts = '$this->si81_dtvalidadecertidaoregularidadefgts' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadefgts_dia"])) {
        $sql .= $virgula . " si81_dtvalidadecertidaoregularidadefgts = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si81_nrocndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_nrocndt"])) {
      $sql .= $virgula . " si81_nrocndt = '$this->si81_nrocndt' ";
      $virgula = ",";
    }
    if (trim($this->si81_dtemissaocndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocndt_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocndt_dia"] != "")) {
      $sql .= $virgula . " si81_dtemissaocndt = '$this->si81_dtemissaocndt' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocndt_dia"])) {
        $sql .= $virgula . " si81_dtemissaocndt = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si81_dtvalidadecndt) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecndt_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecndt_dia"] != "")) {
      $sql .= $virgula . " si81_dtvalidadecndt = '$this->si81_dtvalidadecndt' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecndt_dia"])) {
        $sql .= $virgula . " si81_dtvalidadecndt = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si81_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_nrolote"])) {
      if (trim($this->si81_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si81_nrolote"])) {
        $this->si81_nrolote = "0";
      }
      $sql .= $virgula . " si81_nrolote = $this->si81_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si81_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_coditem"])) {
      if (trim($this->si81_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si81_coditem"])) {
        $this->si81_coditem = "0";
      }
      $sql .= $virgula . " si81_coditem = $this->si81_coditem ";
      $virgula = ",";
    }
    if (trim($this->si81_quantidade) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_quantidade"])) {
      if (trim($this->si81_quantidade) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si81_quantidade"])) {
        $this->si81_quantidade = "0";
      }
      $sql .= $virgula . " si81_quantidade = $this->si81_quantidade ";
      $virgula = ",";
    }
    if (trim($this->si81_vlitem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_vlitem"])) {
      if (trim($this->si81_vlitem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si81_vlitem"])) {
        $this->si81_vlitem = "0";
      }
      $sql .= $virgula . " si81_vlitem = $this->si81_vlitem ";
      $virgula = ",";
    }
    if (trim($this->si81_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_mes"])) {
      $sql .= $virgula . " si81_mes = $this->si81_mes ";
      $virgula = ",";
      if (trim($this->si81_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si81_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si81_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_reg10"])) {
      if (trim($this->si81_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si81_reg10"])) {
        $this->si81_reg10 = "0";
      }
      $sql .= $virgula . " si81_reg10 = $this->si81_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si81_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si81_instit"])) {
      $sql .= $virgula . " si81_instit = $this->si81_instit ";
      $virgula = ",";
      if (trim($this->si81_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si81_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si81_sequencial != null) {
      $sql .= " si81_sequencial = $this->si81_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si81_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010347,'$this->si81_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_sequencial"]) || $this->si81_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010347,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_sequencial')) . "','$this->si81_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_tiporegistro"]) || $this->si81_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010348,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_tiporegistro')) . "','$this->si81_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_codorgaoresp"]) || $this->si81_codorgaoresp != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010349,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_codorgaoresp')) . "','$this->si81_codorgaoresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_codunidadesubresp"]) || $this->si81_codunidadesubresp != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010350,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_codunidadesubresp')) . "','$this->si81_codunidadesubresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_exercicioprocesso"]) || $this->si81_exercicioprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010351,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_exercicioprocesso')) . "','$this->si81_exercicioprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_nroprocesso"]) || $this->si81_nroprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010352,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_nroprocesso')) . "','$this->si81_nroprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_tipoprocesso"]) || $this->si81_tipoprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010353,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_tipoprocesso')) . "','$this->si81_tipoprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_tipodocumento"]) || $this->si81_tipodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010354,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_tipodocumento')) . "','$this->si81_tipodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_nrodocumento"]) || $this->si81_nrodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010355,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_nrodocumento')) . "','$this->si81_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_nroinscricaoestadual"]) || $this->si81_nroinscricaoestadual != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010356,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_nroinscricaoestadual')) . "','$this->si81_nroinscricaoestadual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_ufinscricaoestadual"]) || $this->si81_ufinscricaoestadual != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010357,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_ufinscricaoestadual')) . "','$this->si81_ufinscricaoestadual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_nrocertidaoregularidadeinss"]) || $this->si81_nrocertidaoregularidadeinss != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010358,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_nrocertidaoregularidadeinss')) . "','$this->si81_nrocertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadeinss"]) || $this->si81_dtemissaocertidaoregularidadeinss != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010359,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_dtemissaocertidaoregularidadeinss')) . "','$this->si81_dtemissaocertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadeinss"]) || $this->si81_dtvalidadecertidaoregularidadeinss != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010360,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_dtvalidadecertidaoregularidadeinss')) . "','$this->si81_dtvalidadecertidaoregularidadeinss'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_nrocertidaoregularidadefgts"]) || $this->si81_nrocertidaoregularidadefgts != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010361,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_nrocertidaoregularidadefgts')) . "','$this->si81_nrocertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocertidaoregularidadefgts"]) || $this->si81_dtemissaocertidaoregularidadefgts != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010362,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_dtemissaocertidaoregularidadefgts')) . "','$this->si81_dtemissaocertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecertidaoregularidadefgts"]) || $this->si81_dtvalidadecertidaoregularidadefgts != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010363,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_dtvalidadecertidaoregularidadefgts')) . "','$this->si81_dtvalidadecertidaoregularidadefgts'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_nrocndt"]) || $this->si81_nrocndt != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010364,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_nrocndt')) . "','$this->si81_nrocndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtemissaocndt"]) || $this->si81_dtemissaocndt != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010365,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_dtemissaocndt')) . "','$this->si81_dtemissaocndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_dtvalidadecndt"]) || $this->si81_dtvalidadecndt != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010366,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_dtvalidadecndt')) . "','$this->si81_dtvalidadecndt'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_nrolote"]) || $this->si81_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010367,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_nrolote')) . "','$this->si81_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_coditem"]) || $this->si81_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010368,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_coditem')) . "','$this->si81_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_quantidade"]) || $this->si81_quantidade != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010369,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_quantidade')) . "','$this->si81_quantidade'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_vlitem"]) || $this->si81_vlitem != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010370,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_vlitem')) . "','$this->si81_vlitem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_mes"]) || $this->si81_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010371,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_mes')) . "','$this->si81_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_reg10"]) || $this->si81_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2010372,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_reg10')) . "','$this->si81_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si81_instit"]) || $this->si81_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010310,2011594,'" . AddSlashes(pg_result($resaco, $conresaco, 'si81_instit')) . "','$this->si81_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "dispensa172020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si81_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dispensa172020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si81_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si81_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si81_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si81_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010347,'$si81_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010310,2010347,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010348,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010349,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010350,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010351,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_exercicioprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010352,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_nroprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010353,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_tipoprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010354,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010355,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010356,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_nroinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010357,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_ufinscricaoestadual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010358,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_nrocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010359,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_dtemissaocertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010360,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_dtvalidadecertidaoregularidadeinss')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010361,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_nrocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010362,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_dtemissaocertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010363,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_dtvalidadecertidaoregularidadefgts')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010364,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_nrocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010365,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_dtemissaocndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010366,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_dtvalidadecndt')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010367,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010368,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010369,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_quantidade')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010370,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_vlitem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010371,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2010372,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010310,2011594,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si81_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from dispensa172020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si81_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si81_sequencial = $si81_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "dispensa172020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si81_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dispensa172020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si81_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si81_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:dispensa172020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  
  // funcao do sql
  function sql_query($si81_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dispensa172020 ";
    $sql .= "      left  join dispensa102020  on  dispensa102020.si74_sequencial = dispensa172020.si81_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si81_sequencial != null) {
        $sql2 .= " where dispensa172020.si81_sequencial = $si81_sequencial ";
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
  function sql_query_file($si81_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dispensa172020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si81_sequencial != null) {
        $sql2 .= " where dispensa172020.si81_sequencial = $si81_sequencial ";
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
