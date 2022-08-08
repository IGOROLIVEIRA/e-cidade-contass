<?
//MODULO: sicom
//CLASSE DA ENTIDADE anl102021
class cl_anl102021
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
  var $si110_sequencial = 0;
  var $si110_tiporegistro = 0;
  var $si110_codorgao = null;
  var $si110_codunidadesub = null;
  var $si110_nroempenho = 0;
  var $si110_dtempenho_dia = null;
  var $si110_dtempenho_mes = null;
  var $si110_dtempenho_ano = null;
  var $si110_dtempenho = null;
  var $si110_dtanulacao_dia = null;
  var $si110_dtanulacao_mes = null;
  var $si110_dtanulacao_ano = null;
  var $si110_dtanulacao = null;
  var $si110_nroanulacao = 0;
  var $si110_tipoanulacao = 0;
  var $si110_especanulacaoempenho = null;
  var $si110_vlanulacao = 0;
  var $si110_mes = 0;
  var $si110_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si110_sequencial = int8 = sequencial 
                 si110_tiporegistro = int8 = Tipo do  registro 
                 si110_codorgao = varchar(2) = Código do órgão 
                 si110_codunidadesub = varchar(8) = Código da unidade 
                 si110_nroempenho = int8 = Número do  empenho 
                 si110_dtempenho = date = Data do empenho 
                 si110_dtanulacao = date = Data da Anulação  do empenho 
                 si110_nroanulacao = int8 = Número da  Anulação do  empenho 
                 si110_tipoanulacao = int8 = Tipo de Anulação  do empenho 
                 si110_especanulacaoempenho = varchar(200) = Especificação da  Anulação 
                 si110_vlanulacao = float8 = Valor anulado do  empenho 
                 si110_mes = int8 = Mês 
                 si110_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_anl102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("anl102021");
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
      $this->si110_sequencial = ($this->si110_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_sequencial"] : $this->si110_sequencial);
      $this->si110_tiporegistro = ($this->si110_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_tiporegistro"] : $this->si110_tiporegistro);
      $this->si110_codorgao = ($this->si110_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_codorgao"] : $this->si110_codorgao);
      $this->si110_codunidadesub = ($this->si110_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_codunidadesub"] : $this->si110_codunidadesub);
      $this->si110_nroempenho = ($this->si110_nroempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_nroempenho"] : $this->si110_nroempenho);
      if ($this->si110_dtempenho == "") {
        $this->si110_dtempenho_dia = ($this->si110_dtempenho_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_dtempenho_dia"] : $this->si110_dtempenho_dia);
        $this->si110_dtempenho_mes = ($this->si110_dtempenho_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_dtempenho_mes"] : $this->si110_dtempenho_mes);
        $this->si110_dtempenho_ano = ($this->si110_dtempenho_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_dtempenho_ano"] : $this->si110_dtempenho_ano);
        if ($this->si110_dtempenho_dia != "") {
          $this->si110_dtempenho = $this->si110_dtempenho_ano . "-" . $this->si110_dtempenho_mes . "-" . $this->si110_dtempenho_dia;
        }
      }
      if ($this->si110_dtanulacao == "") {
        $this->si110_dtanulacao_dia = ($this->si110_dtanulacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_dtanulacao_dia"] : $this->si110_dtanulacao_dia);
        $this->si110_dtanulacao_mes = ($this->si110_dtanulacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_dtanulacao_mes"] : $this->si110_dtanulacao_mes);
        $this->si110_dtanulacao_ano = ($this->si110_dtanulacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_dtanulacao_ano"] : $this->si110_dtanulacao_ano);
        if ($this->si110_dtanulacao_dia != "") {
          $this->si110_dtanulacao = $this->si110_dtanulacao_ano . "-" . $this->si110_dtanulacao_mes . "-" . $this->si110_dtanulacao_dia;
        }
      }
      $this->si110_nroanulacao = ($this->si110_nroanulacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_nroanulacao"] : $this->si110_nroanulacao);
      $this->si110_tipoanulacao = ($this->si110_tipoanulacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_tipoanulacao"] : $this->si110_tipoanulacao);
      $this->si110_especanulacaoempenho = ($this->si110_especanulacaoempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_especanulacaoempenho"] : $this->si110_especanulacaoempenho);
      $this->si110_vlanulacao = ($this->si110_vlanulacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_vlanulacao"] : $this->si110_vlanulacao);
      $this->si110_mes = ($this->si110_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_mes"] : $this->si110_mes);
      $this->si110_instit = ($this->si110_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_instit"] : $this->si110_instit);
    } else {
      $this->si110_sequencial = ($this->si110_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si110_sequencial"] : $this->si110_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si110_sequencial)
  {
    $this->atualizacampos();
    if ($this->si110_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si110_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si110_nroempenho == null) {
      $this->si110_nroempenho = "0";
    }
    if ($this->si110_dtempenho == null) {
      $this->si110_dtempenho = "null";
    }
    if ($this->si110_dtanulacao == null) {
      $this->si110_dtanulacao = "null";
    }
    if ($this->si110_nroanulacao == null) {
      $this->si110_nroanulacao = "0";
    }
    if ($this->si110_tipoanulacao == null) {
      $this->si110_tipoanulacao = "0";
    }
    if ($this->si110_vlanulacao == null) {
      $this->si110_vlanulacao = "0";
    }
    if ($this->si110_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si110_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si110_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si110_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si110_sequencial == "" || $si110_sequencial == null) {
      $result = db_query("select nextval('anl102021_si110_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: anl102021_si110_sequencial_seq do campo: si110_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si110_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from anl102021_si110_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si110_sequencial)) {
        $this->erro_sql = " Campo si110_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si110_sequencial = $si110_sequencial;
      }
    }
    if (($this->si110_sequencial == null) || ($this->si110_sequencial == "")) {
      $this->erro_sql = " Campo si110_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into anl102021(
                                       si110_sequencial 
                                      ,si110_tiporegistro 
                                      ,si110_codorgao 
                                      ,si110_codunidadesub 
                                      ,si110_nroempenho 
                                      ,si110_dtempenho 
                                      ,si110_dtanulacao 
                                      ,si110_nroanulacao 
                                      ,si110_tipoanulacao 
                                      ,si110_especanulacaoempenho 
                                      ,si110_vlanulacao 
                                      ,si110_mes 
                                      ,si110_instit 
                       )
                values (
                                $this->si110_sequencial 
                               ,$this->si110_tiporegistro 
                               ,'$this->si110_codorgao' 
                               ,'$this->si110_codunidadesub' 
                               ,$this->si110_nroempenho 
                               ," . ($this->si110_dtempenho == "null" || $this->si110_dtempenho == "" ? "null" : "'" . $this->si110_dtempenho . "'") . "
                               ," . ($this->si110_dtanulacao == "null" || $this->si110_dtanulacao == "" ? "null" : "'" . $this->si110_dtanulacao . "'") . "
                               ,$this->si110_nroanulacao 
                               ,$this->si110_tipoanulacao 
                               ,'$this->si110_especanulacaoempenho' 
                               ,$this->si110_vlanulacao 
                               ,$this->si110_mes 
                               ,$this->si110_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "anl102021 ($this->si110_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "anl102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "anl102021 ($this->si110_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si110_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si110_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010701,'$this->si110_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010339,2010701,'','" . AddSlashes(pg_result($resaco, 0, 'si110_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2010702,'','" . AddSlashes(pg_result($resaco, 0, 'si110_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2010703,'','" . AddSlashes(pg_result($resaco, 0, 'si110_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2010704,'','" . AddSlashes(pg_result($resaco, 0, 'si110_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2010705,'','" . AddSlashes(pg_result($resaco, 0, 'si110_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2010706,'','" . AddSlashes(pg_result($resaco, 0, 'si110_dtempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2010707,'','" . AddSlashes(pg_result($resaco, 0, 'si110_dtanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2010708,'','" . AddSlashes(pg_result($resaco, 0, 'si110_nroanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2010709,'','" . AddSlashes(pg_result($resaco, 0, 'si110_tipoanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2010710,'','" . AddSlashes(pg_result($resaco, 0, 'si110_especanulacaoempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2010711,'','" . AddSlashes(pg_result($resaco, 0, 'si110_vlanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2010712,'','" . AddSlashes(pg_result($resaco, 0, 'si110_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010339,2011623,'','" . AddSlashes(pg_result($resaco, 0, 'si110_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si110_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update anl102021 set ";
    $virgula = "";
    if (trim($this->si110_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_sequencial"])) {
      if (trim($this->si110_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si110_sequencial"])) {
        $this->si110_sequencial = "0";
      }
      $sql .= $virgula . " si110_sequencial = $this->si110_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si110_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_tiporegistro"])) {
      $sql .= $virgula . " si110_tiporegistro = $this->si110_tiporegistro ";
      $virgula = ",";
      if (trim($this->si110_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si110_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si110_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_codorgao"])) {
      $sql .= $virgula . " si110_codorgao = '$this->si110_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si110_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_codunidadesub"])) {
      $sql .= $virgula . " si110_codunidadesub = '$this->si110_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si110_nroempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_nroempenho"])) {
      if (trim($this->si110_nroempenho) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si110_nroempenho"])) {
        $this->si110_nroempenho = "0";
      }
      $sql .= $virgula . " si110_nroempenho = $this->si110_nroempenho ";
      $virgula = ",";
    }
    if (trim($this->si110_dtempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_dtempenho_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si110_dtempenho_dia"] != "")) {
      $sql .= $virgula . " si110_dtempenho = '$this->si110_dtempenho' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si110_dtempenho_dia"])) {
        $sql .= $virgula . " si110_dtempenho = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si110_dtanulacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_dtanulacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si110_dtanulacao_dia"] != "")) {
      $sql .= $virgula . " si110_dtanulacao = '$this->si110_dtanulacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si110_dtanulacao_dia"])) {
        $sql .= $virgula . " si110_dtanulacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si110_nroanulacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_nroanulacao"])) {
      if (trim($this->si110_nroanulacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si110_nroanulacao"])) {
        $this->si110_nroanulacao = "0";
      }
      $sql .= $virgula . " si110_nroanulacao = $this->si110_nroanulacao ";
      $virgula = ",";
    }
    if (trim($this->si110_tipoanulacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_tipoanulacao"])) {
      if (trim($this->si110_tipoanulacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si110_tipoanulacao"])) {
        $this->si110_tipoanulacao = "0";
      }
      $sql .= $virgula . " si110_tipoanulacao = $this->si110_tipoanulacao ";
      $virgula = ",";
    }
    if (trim($this->si110_especanulacaoempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_especanulacaoempenho"])) {
      $sql .= $virgula . " si110_especanulacaoempenho = '$this->si110_especanulacaoempenho' ";
      $virgula = ",";
    }
    if (trim($this->si110_vlanulacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_vlanulacao"])) {
      if (trim($this->si110_vlanulacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si110_vlanulacao"])) {
        $this->si110_vlanulacao = "0";
      }
      $sql .= $virgula . " si110_vlanulacao = $this->si110_vlanulacao ";
      $virgula = ",";
    }
    if (trim($this->si110_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_mes"])) {
      $sql .= $virgula . " si110_mes = $this->si110_mes ";
      $virgula = ",";
      if (trim($this->si110_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si110_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si110_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si110_instit"])) {
      $sql .= $virgula . " si110_instit = $this->si110_instit ";
      $virgula = ",";
      if (trim($this->si110_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si110_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si110_sequencial != null) {
      $sql .= " si110_sequencial = $this->si110_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si110_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010701,'$this->si110_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_sequencial"]) || $this->si110_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010701,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_sequencial')) . "','$this->si110_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_tiporegistro"]) || $this->si110_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010702,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_tiporegistro')) . "','$this->si110_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_codorgao"]) || $this->si110_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010703,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_codorgao')) . "','$this->si110_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_codunidadesub"]) || $this->si110_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010704,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_codunidadesub')) . "','$this->si110_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_nroempenho"]) || $this->si110_nroempenho != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010705,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_nroempenho')) . "','$this->si110_nroempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_dtempenho"]) || $this->si110_dtempenho != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010706,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_dtempenho')) . "','$this->si110_dtempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_dtanulacao"]) || $this->si110_dtanulacao != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010707,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_dtanulacao')) . "','$this->si110_dtanulacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_nroanulacao"]) || $this->si110_nroanulacao != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010708,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_nroanulacao')) . "','$this->si110_nroanulacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_tipoanulacao"]) || $this->si110_tipoanulacao != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010709,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_tipoanulacao')) . "','$this->si110_tipoanulacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_especanulacaoempenho"]) || $this->si110_especanulacaoempenho != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010710,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_especanulacaoempenho')) . "','$this->si110_especanulacaoempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_vlanulacao"]) || $this->si110_vlanulacao != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010711,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_vlanulacao')) . "','$this->si110_vlanulacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_mes"]) || $this->si110_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2010712,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_mes')) . "','$this->si110_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si110_instit"]) || $this->si110_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010339,2011623,'" . AddSlashes(pg_result($resaco, $conresaco, 'si110_instit')) . "','$this->si110_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "anl102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si110_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "anl102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si110_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si110_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si110_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si110_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010701,'$si110_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010339,2010701,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2010702,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2010703,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2010704,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2010705,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2010706,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_dtempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2010707,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_dtanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2010708,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_nroanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2010709,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_tipoanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2010710,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_especanulacaoempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2010711,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_vlanulacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2010712,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010339,2011623,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si110_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from anl102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si110_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si110_sequencial = $si110_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "anl102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si110_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "anl102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si110_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si110_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:anl102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si110_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from anl102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si110_sequencial != null) {
        $sql2 .= " where anl102021.si110_sequencial = $si110_sequencial ";
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
  function sql_query_file($si110_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from anl102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si110_sequencial != null) {
        $sql2 .= " where anl102021.si110_sequencial = $si110_sequencial ";
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
