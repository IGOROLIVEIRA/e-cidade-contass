<?
//MODULO: sicom
//CLASSE DA ENTIDADE ops102021
class cl_ops102021
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
  var $si132_sequencial = 0;
  var $si132_tiporegistro = 0;
  var $si132_codorgao = null;
  var $si132_codunidadesub = null;
  var $si132_nroop = 0;
  var $si132_dtpagamento_dia = null;
  var $si132_dtpagamento_mes = null;
  var $si132_dtpagamento_ano = null;
  var $si132_dtpagamento = null;
  var $si132_vlop = 0;
  var $si132_especificacaoop = null;
  var $si132_cpfresppgto = null;
  var $si132_mes = 0;
  var $si132_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si132_sequencial = int8 = sequencial 
                 si132_tiporegistro = int8 = Tipo do  registro 
                 si132_codorgao = varchar(2) = Código do órgão 
                 si132_codunidadesub = varchar(8) = Código da unidade 
                 si132_nroop = int8 = Número da  Ordem de  Pagamento 
                 si132_dtpagamento = date = Data de  pagamento da  OP 
                 si132_vlop = float8 = Valor da OP 
                 si132_especificacaoop = varchar(200) = Especificação da  OP 
                 si132_cpfresppgto = varchar(11) = CPF do  responsável 
                 si132_mes = int8 = Mês 
                 si132_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_ops102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ops102021");
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
      $this->si132_sequencial = ($this->si132_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_sequencial"] : $this->si132_sequencial);
      $this->si132_tiporegistro = ($this->si132_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_tiporegistro"] : $this->si132_tiporegistro);
      $this->si132_codorgao = ($this->si132_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_codorgao"] : $this->si132_codorgao);
      $this->si132_codunidadesub = ($this->si132_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_codunidadesub"] : $this->si132_codunidadesub);
      $this->si132_nroop = ($this->si132_nroop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_nroop"] : $this->si132_nroop);
      if ($this->si132_dtpagamento == "") {
        $this->si132_dtpagamento_dia = ($this->si132_dtpagamento_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_dtpagamento_dia"] : $this->si132_dtpagamento_dia);
        $this->si132_dtpagamento_mes = ($this->si132_dtpagamento_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_dtpagamento_mes"] : $this->si132_dtpagamento_mes);
        $this->si132_dtpagamento_ano = ($this->si132_dtpagamento_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_dtpagamento_ano"] : $this->si132_dtpagamento_ano);
        if ($this->si132_dtpagamento_dia != "") {
          $this->si132_dtpagamento = $this->si132_dtpagamento_ano . "-" . $this->si132_dtpagamento_mes . "-" . $this->si132_dtpagamento_dia;
        }
      }
      $this->si132_vlop = ($this->si132_vlop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_vlop"] : $this->si132_vlop);
      $this->si132_especificacaoop = ($this->si132_especificacaoop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_especificacaoop"] : $this->si132_especificacaoop);
      $this->si132_cpfresppgto = ($this->si132_cpfresppgto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_cpfresppgto"] : $this->si132_cpfresppgto);
      $this->si132_mes = ($this->si132_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_mes"] : $this->si132_mes);
      $this->si132_instit = ($this->si132_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_instit"] : $this->si132_instit);
    } else {
      $this->si132_sequencial = ($this->si132_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si132_sequencial"] : $this->si132_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si132_sequencial)
  {
    $this->atualizacampos();
    if ($this->si132_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si132_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si132_nroop == null) {
      $this->si132_nroop = "0";
    }
    if ($this->si132_dtpagamento == null) {
      $this->si132_dtpagamento = "null";
    }
    if ($this->si132_vlop == null) {
      $this->si132_vlop = "0";
    }
    if ($this->si132_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si132_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si132_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si132_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si132_sequencial == "" || $si132_sequencial == null) {
      $result = db_query("select nextval('ops102021_si132_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ops102021_si132_sequencial_seq do campo: si132_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si132_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ops102021_si132_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si132_sequencial)) {
        $this->erro_sql = " Campo si132_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si132_sequencial = $si132_sequencial;
      }
    }
    if (($this->si132_sequencial == null) || ($this->si132_sequencial == "")) {
      $this->erro_sql = " Campo si132_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into ops102021(
                                       si132_sequencial 
                                      ,si132_tiporegistro 
                                      ,si132_codorgao 
                                      ,si132_codunidadesub 
                                      ,si132_nroop 
                                      ,si132_dtpagamento 
                                      ,si132_vlop 
                                      ,si132_especificacaoop 
                                      ,si132_cpfresppgto 
                                      ,si132_mes 
                                      ,si132_instit 
                       )
                values (
                                $this->si132_sequencial 
                               ,$this->si132_tiporegistro 
                               ,'$this->si132_codorgao' 
                               ,'$this->si132_codunidadesub' 
                               ,$this->si132_nroop 
                               ," . ($this->si132_dtpagamento == "null" || $this->si132_dtpagamento == "" ? "null" : "'" . $this->si132_dtpagamento . "'") . "
                               ,$this->si132_vlop 
                               ,'$this->si132_especificacaoop' 
                               ,'$this->si132_cpfresppgto' 
                               ,$this->si132_mes 
                               ,$this->si132_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ops102021 ($this->si132_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ops102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ops102021 ($this->si132_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si132_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si132_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010927,'$this->si132_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010361,2010927,'','" . AddSlashes(pg_result($resaco, 0, 'si132_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010361,2010928,'','" . AddSlashes(pg_result($resaco, 0, 'si132_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010361,2010929,'','" . AddSlashes(pg_result($resaco, 0, 'si132_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010361,2010930,'','" . AddSlashes(pg_result($resaco, 0, 'si132_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010361,2010931,'','" . AddSlashes(pg_result($resaco, 0, 'si132_nroop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010361,2010932,'','" . AddSlashes(pg_result($resaco, 0, 'si132_dtpagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010361,2010933,'','" . AddSlashes(pg_result($resaco, 0, 'si132_vlop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010361,2010934,'','" . AddSlashes(pg_result($resaco, 0, 'si132_especificacaoop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010361,2010935,'','" . AddSlashes(pg_result($resaco, 0, 'si132_cpfresppgto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010361,2010936,'','" . AddSlashes(pg_result($resaco, 0, 'si132_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010361,2011645,'','" . AddSlashes(pg_result($resaco, 0, 'si132_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si132_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ops102021 set ";
    $virgula = "";
    if (trim($this->si132_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si132_sequencial"])) {
      if (trim($this->si132_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si132_sequencial"])) {
        $this->si132_sequencial = "0";
      }
      $sql .= $virgula . " si132_sequencial = $this->si132_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si132_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si132_tiporegistro"])) {
      $sql .= $virgula . " si132_tiporegistro = $this->si132_tiporegistro ";
      $virgula = ",";
      if (trim($this->si132_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si132_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si132_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si132_codorgao"])) {
      $sql .= $virgula . " si132_codorgao = '$this->si132_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si132_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si132_codunidadesub"])) {
      $sql .= $virgula . " si132_codunidadesub = '$this->si132_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si132_nroop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si132_nroop"])) {
      if (trim($this->si132_nroop) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si132_nroop"])) {
        $this->si132_nroop = "0";
      }
      $sql .= $virgula . " si132_nroop = $this->si132_nroop ";
      $virgula = ",";
    }
    if (trim($this->si132_dtpagamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si132_dtpagamento_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si132_dtpagamento_dia"] != "")) {
      $sql .= $virgula . " si132_dtpagamento = '$this->si132_dtpagamento' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si132_dtpagamento_dia"])) {
        $sql .= $virgula . " si132_dtpagamento = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si132_vlop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si132_vlop"])) {
      if (trim($this->si132_vlop) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si132_vlop"])) {
        $this->si132_vlop = "0";
      }
      $sql .= $virgula . " si132_vlop = $this->si132_vlop ";
      $virgula = ",";
    }
    if (trim($this->si132_especificacaoop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si132_especificacaoop"])) {
      $sql .= $virgula . " si132_especificacaoop = '$this->si132_especificacaoop' ";
      $virgula = ",";
    }
    if (trim($this->si132_cpfresppgto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si132_cpfresppgto"])) {
      $sql .= $virgula . " si132_cpfresppgto = '$this->si132_cpfresppgto' ";
      $virgula = ",";
    }
    if (trim($this->si132_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si132_mes"])) {
      $sql .= $virgula . " si132_mes = $this->si132_mes ";
      $virgula = ",";
      if (trim($this->si132_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si132_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si132_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si132_instit"])) {
      $sql .= $virgula . " si132_instit = $this->si132_instit ";
      $virgula = ",";
      if (trim($this->si132_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si132_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si132_sequencial != null) {
      $sql .= " si132_sequencial = $this->si132_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si132_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010927,'$this->si132_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si132_sequencial"]) || $this->si132_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010361,2010927,'" . AddSlashes(pg_result($resaco, $conresaco, 'si132_sequencial')) . "','$this->si132_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si132_tiporegistro"]) || $this->si132_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010361,2010928,'" . AddSlashes(pg_result($resaco, $conresaco, 'si132_tiporegistro')) . "','$this->si132_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si132_codorgao"]) || $this->si132_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010361,2010929,'" . AddSlashes(pg_result($resaco, $conresaco, 'si132_codorgao')) . "','$this->si132_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si132_codunidadesub"]) || $this->si132_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010361,2010930,'" . AddSlashes(pg_result($resaco, $conresaco, 'si132_codunidadesub')) . "','$this->si132_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si132_nroop"]) || $this->si132_nroop != "")
          $resac = db_query("insert into db_acount values($acount,2010361,2010931,'" . AddSlashes(pg_result($resaco, $conresaco, 'si132_nroop')) . "','$this->si132_nroop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si132_dtpagamento"]) || $this->si132_dtpagamento != "")
          $resac = db_query("insert into db_acount values($acount,2010361,2010932,'" . AddSlashes(pg_result($resaco, $conresaco, 'si132_dtpagamento')) . "','$this->si132_dtpagamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si132_vlop"]) || $this->si132_vlop != "")
          $resac = db_query("insert into db_acount values($acount,2010361,2010933,'" . AddSlashes(pg_result($resaco, $conresaco, 'si132_vlop')) . "','$this->si132_vlop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si132_especificacaoop"]) || $this->si132_especificacaoop != "")
          $resac = db_query("insert into db_acount values($acount,2010361,2010934,'" . AddSlashes(pg_result($resaco, $conresaco, 'si132_especificacaoop')) . "','$this->si132_especificacaoop'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si132_cpfresppgto"]) || $this->si132_cpfresppgto != "")
          $resac = db_query("insert into db_acount values($acount,2010361,2010935,'" . AddSlashes(pg_result($resaco, $conresaco, 'si132_cpfresppgto')) . "','$this->si132_cpfresppgto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si132_mes"]) || $this->si132_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010361,2010936,'" . AddSlashes(pg_result($resaco, $conresaco, 'si132_mes')) . "','$this->si132_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si132_instit"]) || $this->si132_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010361,2011645,'" . AddSlashes(pg_result($resaco, $conresaco, 'si132_instit')) . "','$this->si132_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ops102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si132_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ops102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si132_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si132_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si132_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si132_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010927,'$si132_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010361,2010927,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si132_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010361,2010928,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si132_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010361,2010929,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si132_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010361,2010930,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si132_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010361,2010931,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si132_nroop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010361,2010932,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si132_dtpagamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010361,2010933,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si132_vlop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010361,2010934,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si132_especificacaoop')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010361,2010935,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si132_cpfresppgto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010361,2010936,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si132_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010361,2011645,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si132_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from ops102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si132_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si132_sequencial = $si132_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ops102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si132_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ops102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si132_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si132_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ops102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si132_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ops102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si132_sequencial != null) {
        $sql2 .= " where ops102021.si132_sequencial = $si132_sequencial ";
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
  function sql_query_file($si132_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ops102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si132_sequencial != null) {
        $sql2 .= " where ops102021.si132_sequencial = $si132_sequencial ";
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
