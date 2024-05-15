<?
//MODULO: sicom
//CLASSE DA ENTIDADE aop112018
class cl_aop112018
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
  var $si138_sequencial = 0;
  var $si138_tiporegistro = 0;
  var $si138_codreduzido = 0;
  var $si138_tipopagamento = 0;
  var $si138_nroempenho = 0;
  var $si138_dtempenho_dia = null;
  var $si138_dtempenho_mes = null;
  var $si138_dtempenho_ano = null;
  var $si138_dtempenho = null;
  var $si138_nroliquidacao = 0;
  var $si138_dtliquidacao_dia = null;
  var $si138_dtliquidacao_mes = null;
  var $si138_dtliquidacao_ano = null;
  var $si138_dtliquidacao = null;
  var $si138_codfontrecursos = 0;
  var $si138_valoranulacaofonte = 0;
  var $si138_codorgaoempop = null;
  var $si138_codunidadeempop = null;
  var $si138_mes = 0;
  var $si138_reg10 = 0;
  var $si138_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si138_sequencial = int8 = sequencial 
                 si138_tiporegistro = int8 = Tipo do  registro 
                 si138_codreduzido = int8 = Código identificador da anulação 
                 si138_tipopagamento = int8 = Tipo do  Pagamento 
                 si138_nroempenho = int8 = Número do  empenho 
                 si138_dtempenho = date = Data do empenho 
                 si138_nroliquidacao = int8 = Número da  liquidação 
                 si138_dtliquidacao = date = Data da  Liquidação do  empenho 
                 si138_codfontrecursos = int8 = Código da fonte de recursos 
                 si138_valoranulacaofonte = float8 = Valor da anulação por fonte 
                 si138_codorgaoempop = varchar(2) = Código do órgão 
                 si138_codunidadeempop = varchar(8) = Código da unidade 
                 si138_mes = int8 = Mês 
                 si138_reg10 = int8 = reg10 
                 si138_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_aop112018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aop112018");
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
      $this->si138_sequencial = ($this->si138_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_sequencial"] : $this->si138_sequencial);
      $this->si138_tiporegistro = ($this->si138_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_tiporegistro"] : $this->si138_tiporegistro);
      $this->si138_codreduzido = ($this->si138_codreduzido == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_codreduzido"] : $this->si138_codreduzido);
      $this->si138_tipopagamento = ($this->si138_tipopagamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_tipopagamento"] : $this->si138_tipopagamento);
      $this->si138_nroempenho = ($this->si138_nroempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_nroempenho"] : $this->si138_nroempenho);
      if ($this->si138_dtempenho == "") {
        $this->si138_dtempenho_dia = ($this->si138_dtempenho_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_dtempenho_dia"] : $this->si138_dtempenho_dia);
        $this->si138_dtempenho_mes = ($this->si138_dtempenho_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_dtempenho_mes"] : $this->si138_dtempenho_mes);
        $this->si138_dtempenho_ano = ($this->si138_dtempenho_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_dtempenho_ano"] : $this->si138_dtempenho_ano);
        if ($this->si138_dtempenho_dia != "") {
          $this->si138_dtempenho = $this->si138_dtempenho_ano . "-" . $this->si138_dtempenho_mes . "-" . $this->si138_dtempenho_dia;
        }
      }
      $this->si138_nroliquidacao = ($this->si138_nroliquidacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_nroliquidacao"] : $this->si138_nroliquidacao);
      if ($this->si138_dtliquidacao == "") {
        $this->si138_dtliquidacao_dia = ($this->si138_dtliquidacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_dtliquidacao_dia"] : $this->si138_dtliquidacao_dia);
        $this->si138_dtliquidacao_mes = ($this->si138_dtliquidacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_dtliquidacao_mes"] : $this->si138_dtliquidacao_mes);
        $this->si138_dtliquidacao_ano = ($this->si138_dtliquidacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_dtliquidacao_ano"] : $this->si138_dtliquidacao_ano);
        if ($this->si138_dtliquidacao_dia != "") {
          $this->si138_dtliquidacao = $this->si138_dtliquidacao_ano . "-" . $this->si138_dtliquidacao_mes . "-" . $this->si138_dtliquidacao_dia;
        }
      }
      $this->si138_codfontrecursos = ($this->si138_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_codfontrecursos"] : $this->si138_codfontrecursos);
      $this->si138_valoranulacaofonte = ($this->si138_valoranulacaofonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_valoranulacaofonte"] : $this->si138_valoranulacaofonte);
      $this->si138_codorgaoempop = ($this->si138_codorgaoempop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_codorgaoempop"] : $this->si138_codorgaoempop);
      $this->si138_codunidadeempop = ($this->si138_codunidadeempop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_codunidadeempop"] : $this->si138_codunidadeempop);
      $this->si138_mes = ($this->si138_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_mes"] : $this->si138_mes);
      $this->si138_reg10 = ($this->si138_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_reg10"] : $this->si138_reg10);
      $this->si138_instit = ($this->si138_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_instit"] : $this->si138_instit);
    } else {
      $this->si138_sequencial = ($this->si138_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si138_sequencial"] : $this->si138_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si138_sequencial)
  {
    $this->atualizacampos();
    if ($this->si138_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si138_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si138_codreduzido == null) {
      $this->si138_codreduzido = "0";
    }
    if ($this->si138_tipopagamento == null) {
      $this->si138_tipopagamento = "0";
    }
    if ($this->si138_nroempenho == null) {
      $this->si138_nroempenho = "0";
    }
    if ($this->si138_dtempenho == null) {
      $this->si138_dtempenho = "null";
    }
    if ($this->si138_nroliquidacao == null) {
      $this->si138_nroliquidacao = "0";
    }
    if ($this->si138_dtliquidacao == null) {
      $this->si138_dtliquidacao = "null";
    }
    if ($this->si138_codfontrecursos == null) {
      $this->si138_codfontrecursos = "0";
    }
    if ($this->si138_valoranulacaofonte == null) {
      $this->si138_valoranulacaofonte = "0";
    }
    if ($this->si138_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si138_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si138_reg10 == null) {
      $this->si138_reg10 = "0";
    }
    if ($this->si138_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si138_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si138_sequencial == "" || $si138_sequencial == null) {
      $result = db_query("select nextval('aop112018_si138_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aop112018_si138_sequencial_seq do campo: si138_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si138_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aop112018_si138_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si138_sequencial)) {
        $this->erro_sql = " Campo si138_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si138_sequencial = $si138_sequencial;
      }
    }
    if (($this->si138_sequencial == null) || ($this->si138_sequencial == "")) {
      $this->erro_sql = " Campo si138_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aop112018(
                                       si138_sequencial 
                                      ,si138_tiporegistro 
                                      ,si138_codreduzido 
                                      ,si138_tipopagamento 
                                      ,si138_nroempenho 
                                      ,si138_dtempenho 
                                      ,si138_nroliquidacao 
                                      ,si138_dtliquidacao 
                                      ,si138_codfontrecursos 
                                      ,si138_valoranulacaofonte 
                                      ,si138_codorgaoempop 
                                      ,si138_codunidadeempop 
                                      ,si138_mes 
                                      ,si138_reg10 
                                      ,si138_instit 
                       )
                values (
                                $this->si138_sequencial 
                               ,$this->si138_tiporegistro 
                               ,$this->si138_codreduzido 
                               ,$this->si138_tipopagamento 
                               ,$this->si138_nroempenho 
                               ," . ($this->si138_dtempenho == "null" || $this->si138_dtempenho == "" ? "null" : "'" . $this->si138_dtempenho . "'") . "
                               ,$this->si138_nroliquidacao 
                               ," . ($this->si138_dtliquidacao == "null" || $this->si138_dtliquidacao == "" ? "null" : "'" . $this->si138_dtliquidacao . "'") . "
                               ,$this->si138_codfontrecursos 
                               ,$this->si138_valoranulacaofonte 
                               ,'$this->si138_codorgaoempop' 
                               ,'$this->si138_codunidadeempop' 
                               ,$this->si138_mes 
                               ,$this->si138_reg10 
                               ,$this->si138_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aop112018 ($this->si138_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aop112018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aop112018 ($this->si138_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si138_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si138_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010994,'$this->si138_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010367,2010994,'','" . AddSlashes(pg_result($resaco, 0, 'si138_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2010995,'','" . AddSlashes(pg_result($resaco, 0, 'si138_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2010996,'','" . AddSlashes(pg_result($resaco, 0, 'si138_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2010997,'','" . AddSlashes(pg_result($resaco, 0, 'si138_tipopagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2010998,'','" . AddSlashes(pg_result($resaco, 0, 'si138_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2010999,'','" . AddSlashes(pg_result($resaco, 0, 'si138_dtempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2011000,'','" . AddSlashes(pg_result($resaco, 0, 'si138_nroliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2011001,'','" . AddSlashes(pg_result($resaco, 0, 'si138_dtliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2011002,'','" . AddSlashes(pg_result($resaco, 0, 'si138_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2011003,'','" . AddSlashes(pg_result($resaco, 0, 'si138_valoranulacaofonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2011004,'','" . AddSlashes(pg_result($resaco, 0, 'si138_codorgaoempop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2011005,'','" . AddSlashes(pg_result($resaco, 0, 'si138_codunidadeempop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2011006,'','" . AddSlashes(pg_result($resaco, 0, 'si138_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2011007,'','" . AddSlashes(pg_result($resaco, 0, 'si138_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010367,2011651,'','" . AddSlashes(pg_result($resaco, 0, 'si138_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si138_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aop112018 set ";
    $virgula = "";
    if (trim($this->si138_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_sequencial"])) {
      if (trim($this->si138_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si138_sequencial"])) {
        $this->si138_sequencial = "0";
      }
      $sql .= $virgula . " si138_sequencial = $this->si138_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si138_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_tiporegistro"])) {
      $sql .= $virgula . " si138_tiporegistro = $this->si138_tiporegistro ";
      $virgula = ",";
      if (trim($this->si138_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si138_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si138_codreduzido) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_codreduzido"])) {
      if (trim($this->si138_codreduzido) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si138_codreduzido"])) {
        $this->si138_codreduzido = "0";
      }
      $sql .= $virgula . " si138_codreduzido = $this->si138_codreduzido ";
      $virgula = ",";
    }
    if (trim($this->si138_tipopagamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_tipopagamento"])) {
      if (trim($this->si138_tipopagamento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si138_tipopagamento"])) {
        $this->si138_tipopagamento = "0";
      }
      $sql .= $virgula . " si138_tipopagamento = $this->si138_tipopagamento ";
      $virgula = ",";
    }
    if (trim($this->si138_nroempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_nroempenho"])) {
      if (trim($this->si138_nroempenho) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si138_nroempenho"])) {
        $this->si138_nroempenho = "0";
      }
      $sql .= $virgula . " si138_nroempenho = $this->si138_nroempenho ";
      $virgula = ",";
    }
    if (trim($this->si138_dtempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_dtempenho_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si138_dtempenho_dia"] != "")) {
      $sql .= $virgula . " si138_dtempenho = '$this->si138_dtempenho' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si138_dtempenho_dia"])) {
        $sql .= $virgula . " si138_dtempenho = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si138_nroliquidacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_nroliquidacao"])) {
      if (trim($this->si138_nroliquidacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si138_nroliquidacao"])) {
        $this->si138_nroliquidacao = "0";
      }
      $sql .= $virgula . " si138_nroliquidacao = $this->si138_nroliquidacao ";
      $virgula = ",";
    }
    if (trim($this->si138_dtliquidacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_dtliquidacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si138_dtliquidacao_dia"] != "")) {
      $sql .= $virgula . " si138_dtliquidacao = '$this->si138_dtliquidacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si138_dtliquidacao_dia"])) {
        $sql .= $virgula . " si138_dtliquidacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si138_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_codfontrecursos"])) {
      if (trim($this->si138_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si138_codfontrecursos"])) {
        $this->si138_codfontrecursos = "0";
      }
      $sql .= $virgula . " si138_codfontrecursos = $this->si138_codfontrecursos ";
      $virgula = ",";
    }
    if (trim($this->si138_valoranulacaofonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_valoranulacaofonte"])) {
      if (trim($this->si138_valoranulacaofonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si138_valoranulacaofonte"])) {
        $this->si138_valoranulacaofonte = "0";
      }
      $sql .= $virgula . " si138_valoranulacaofonte = $this->si138_valoranulacaofonte ";
      $virgula = ",";
    }
    if (trim($this->si138_codorgaoempop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_codorgaoempop"])) {
      $sql .= $virgula . " si138_codorgaoempop = '$this->si138_codorgaoempop' ";
      $virgula = ",";
    }
    if (trim($this->si138_codunidadeempop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_codunidadeempop"])) {
      $sql .= $virgula . " si138_codunidadeempop = '$this->si138_codunidadeempop' ";
      $virgula = ",";
    }
    if (trim($this->si138_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_mes"])) {
      $sql .= $virgula . " si138_mes = $this->si138_mes ";
      $virgula = ",";
      if (trim($this->si138_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si138_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si138_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_reg10"])) {
      if (trim($this->si138_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si138_reg10"])) {
        $this->si138_reg10 = "0";
      }
      $sql .= $virgula . " si138_reg10 = $this->si138_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si138_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si138_instit"])) {
      $sql .= $virgula . " si138_instit = $this->si138_instit ";
      $virgula = ",";
      if (trim($this->si138_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si138_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si138_sequencial != null) {
      $sql .= " si138_sequencial = $this->si138_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si138_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010994,'$this->si138_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_sequencial"]) || $this->si138_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2010994,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_sequencial')) . "','$this->si138_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_tiporegistro"]) || $this->si138_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2010995,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_tiporegistro')) . "','$this->si138_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_codreduzido"]) || $this->si138_codreduzido != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2010996,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_codreduzido')) . "','$this->si138_codreduzido'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_tipopagamento"]) || $this->si138_tipopagamento != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2010997,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_tipopagamento')) . "','$this->si138_tipopagamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_nroempenho"]) || $this->si138_nroempenho != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2010998,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_nroempenho')) . "','$this->si138_nroempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_dtempenho"]) || $this->si138_dtempenho != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2010999,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_dtempenho')) . "','$this->si138_dtempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_nroliquidacao"]) || $this->si138_nroliquidacao != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2011000,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_nroliquidacao')) . "','$this->si138_nroliquidacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_dtliquidacao"]) || $this->si138_dtliquidacao != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2011001,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_dtliquidacao')) . "','$this->si138_dtliquidacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_codfontrecursos"]) || $this->si138_codfontrecursos != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2011002,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_codfontrecursos')) . "','$this->si138_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_valoranulacaofonte"]) || $this->si138_valoranulacaofonte != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2011003,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_valoranulacaofonte')) . "','$this->si138_valoranulacaofonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_codorgaoempop"]) || $this->si138_codorgaoempop != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2011004,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_codorgaoempop')) . "','$this->si138_codorgaoempop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_codunidadeempop"]) || $this->si138_codunidadeempop != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2011005,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_codunidadeempop')) . "','$this->si138_codunidadeempop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_mes"]) || $this->si138_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2011006,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_mes')) . "','$this->si138_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_reg10"]) || $this->si138_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2011007,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_reg10')) . "','$this->si138_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si138_instit"]) || $this->si138_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010367,2011651,'" . AddSlashes(pg_result($resaco, $conresaco, 'si138_instit')) . "','$this->si138_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aop112018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si138_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aop112018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si138_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si138_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si138_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si138_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010994,'$si138_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010367,2010994,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2010995,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2010996,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2010997,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_tipopagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2010998,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2010999,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_dtempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2011000,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_nroliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2011001,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_dtliquidacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2011002,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2011003,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_valoranulacaofonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2011004,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_codorgaoempop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2011005,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_codunidadeempop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2011006,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2011007,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010367,2011651,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si138_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from aop112018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si138_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si138_sequencial = $si138_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aop112018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si138_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aop112018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si138_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si138_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:aop112018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si138_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aop112018 ";
    $sql .= "      left  join aop102018  on  aop102018.si137_sequencial = aop112018.si138_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si138_sequencial != null) {
        $sql2 .= " where aop112018.si138_sequencial = $si138_sequencial ";
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
  function sql_query_file($si138_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aop112018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si138_sequencial != null) {
        $sql2 .= " where aop112018.si138_sequencial = $si138_sequencial ";
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
