<?
//MODULO: sicom
//CLASSE DA ENTIDADE julglic202021
class cl_julglic202021
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
  var $si61_sequencial = 0;
  var $si61_tiporegistro = 0;
  var $si61_codorgao = null;
  var $si61_codunidadesub = null;
  var $si61_exerciciolicitacao = 0;
  var $si61_nroprocessolicitatorio = null;
  var $si61_tipodocumento = 0;
  var $si61_nrodocumento = null;
  var $si61_nrolote = 0;
  var $si61_coditem = null;
  var $si61_percdesconto = 0;
  var $si61_mes = 0;
  var $si61_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si61_sequencial = int8 = sequencial 
                 si61_tiporegistro = int8 = Tipo do registro 
                 si61_codorgao = varchar(2) = Código do órgão 
                 si61_codunidadesub = varchar(8) = Código da unidade 
                 si61_exerciciolicitacao = int8 = Exercício em que  foi instaurado 
                 si61_nroprocessolicitatorio = varchar(12) = Número sequencial do processo 
                 si61_tipodocumento = int8 = Tipo de documento 
                 si61_nrodocumento = varchar(14) = Número do  documento 
                 si61_nrolote = int8 = Número do lote  licitado 
                 si61_coditem = varchar(15) = Código do Item 
                 si61_percdesconto = float8 = Percentual do  desconto 
                 si61_mes = int8 = Mês 
                 si61_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_julglic202021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("julglic202021");
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
      $this->si61_sequencial = ($this->si61_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_sequencial"] : $this->si61_sequencial);
      $this->si61_tiporegistro = ($this->si61_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_tiporegistro"] : $this->si61_tiporegistro);
      $this->si61_codorgao = ($this->si61_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_codorgao"] : $this->si61_codorgao);
      $this->si61_codunidadesub = ($this->si61_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_codunidadesub"] : $this->si61_codunidadesub);
      $this->si61_exerciciolicitacao = ($this->si61_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_exerciciolicitacao"] : $this->si61_exerciciolicitacao);
      $this->si61_nroprocessolicitatorio = ($this->si61_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_nroprocessolicitatorio"] : $this->si61_nroprocessolicitatorio);
      $this->si61_tipodocumento = ($this->si61_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_tipodocumento"] : $this->si61_tipodocumento);
      $this->si61_nrodocumento = ($this->si61_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_nrodocumento"] : $this->si61_nrodocumento);
      $this->si61_nrolote = ($this->si61_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_nrolote"] : $this->si61_nrolote);
      $this->si61_coditem = ($this->si61_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_coditem"] : $this->si61_coditem);
      $this->si61_percdesconto = ($this->si61_percdesconto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_percdesconto"] : $this->si61_percdesconto);
      $this->si61_mes = ($this->si61_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_mes"] : $this->si61_mes);
      $this->si61_instit = ($this->si61_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_instit"] : $this->si61_instit);
    } else {
      $this->si61_sequencial = ($this->si61_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si61_sequencial"] : $this->si61_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si61_sequencial)
  {
    $this->atualizacampos();
    if ($this->si61_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si61_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si61_exerciciolicitacao == null) {
      $this->si61_exerciciolicitacao = "0";
    }
    if ($this->si61_tipodocumento == null) {
      $this->si61_tipodocumento = "0";
    }
    if ($this->si61_nrolote == null) {
      $this->si61_nrolote = "0";
    }
    if ($this->si61_percdesconto == null) {
      $this->si61_percdesconto = "0";
    }
    if ($this->si61_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si61_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si61_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si61_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si61_sequencial == "" || $si61_sequencial == null) {
      $result = db_query("select nextval('julglic202021_si61_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: julglic202021_si61_sequencial_seq do campo: si61_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si61_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from julglic202021_si61_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si61_sequencial)) {
        $this->erro_sql = " Campo si61_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si61_sequencial = $si61_sequencial;
      }
    }
    if (($this->si61_sequencial == null) || ($this->si61_sequencial == "")) {
      $this->erro_sql = " Campo si61_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into julglic202021(
                                       si61_sequencial 
                                      ,si61_tiporegistro 
                                      ,si61_codorgao 
                                      ,si61_codunidadesub 
                                      ,si61_exerciciolicitacao 
                                      ,si61_nroprocessolicitatorio 
                                      ,si61_tipodocumento 
                                      ,si61_nrodocumento 
                                      ,si61_nrolote 
                                      ,si61_coditem 
                                      ,si61_percdesconto 
                                      ,si61_mes 
                                      ,si61_instit 
                       )
                values (
                                $this->si61_sequencial 
                               ,$this->si61_tiporegistro 
                               ,'$this->si61_codorgao' 
                               ,'$this->si61_codunidadesub' 
                               ,$this->si61_exerciciolicitacao 
                               ,'$this->si61_nroprocessolicitatorio' 
                               ,$this->si61_tipodocumento 
                               ,'$this->si61_nrodocumento' 
                               ,$this->si61_nrolote 
                               ,'$this->si61_coditem' 
                               ,$this->si61_percdesconto 
                               ,$this->si61_mes 
                               ,$this->si61_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "julglic202021 ($this->si61_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "julglic202021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "julglic202021 ($this->si61_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si61_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si61_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010097,'$this->si61_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010290,2010097,'','" . AddSlashes(pg_result($resaco, 0, 'si61_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2010098,'','" . AddSlashes(pg_result($resaco, 0, 'si61_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2010099,'','" . AddSlashes(pg_result($resaco, 0, 'si61_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2010100,'','" . AddSlashes(pg_result($resaco, 0, 'si61_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2010101,'','" . AddSlashes(pg_result($resaco, 0, 'si61_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2010102,'','" . AddSlashes(pg_result($resaco, 0, 'si61_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2010103,'','" . AddSlashes(pg_result($resaco, 0, 'si61_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2010104,'','" . AddSlashes(pg_result($resaco, 0, 'si61_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2010105,'','" . AddSlashes(pg_result($resaco, 0, 'si61_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2010106,'','" . AddSlashes(pg_result($resaco, 0, 'si61_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2010107,'','" . AddSlashes(pg_result($resaco, 0, 'si61_percdesconto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2010108,'','" . AddSlashes(pg_result($resaco, 0, 'si61_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010290,2011573,'','" . AddSlashes(pg_result($resaco, 0, 'si61_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si61_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update julglic202021 set ";
    $virgula = "";
    if (trim($this->si61_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_sequencial"])) {
      if (trim($this->si61_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si61_sequencial"])) {
        $this->si61_sequencial = "0";
      }
      $sql .= $virgula . " si61_sequencial = $this->si61_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si61_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_tiporegistro"])) {
      $sql .= $virgula . " si61_tiporegistro = $this->si61_tiporegistro ";
      $virgula = ",";
      if (trim($this->si61_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si61_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si61_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_codorgao"])) {
      $sql .= $virgula . " si61_codorgao = '$this->si61_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si61_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_codunidadesub"])) {
      $sql .= $virgula . " si61_codunidadesub = '$this->si61_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si61_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_exerciciolicitacao"])) {
      if (trim($this->si61_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si61_exerciciolicitacao"])) {
        $this->si61_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si61_exerciciolicitacao = $this->si61_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si61_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si61_nroprocessolicitatorio = '$this->si61_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si61_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_tipodocumento"])) {
      if (trim($this->si61_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si61_tipodocumento"])) {
        $this->si61_tipodocumento = "0";
      }
      $sql .= $virgula . " si61_tipodocumento = $this->si61_tipodocumento ";
      $virgula = ",";
    }
    if (trim($this->si61_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_nrodocumento"])) {
      $sql .= $virgula . " si61_nrodocumento = '$this->si61_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si61_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_nrolote"])) {
      if (trim($this->si61_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si61_nrolote"])) {
        $this->si61_nrolote = "0";
      }
      $sql .= $virgula . " si61_nrolote = $this->si61_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si61_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_coditem"])) {
      $sql .= $virgula . " si61_coditem = '$this->si61_coditem' ";
      $virgula = ",";
    }
    if (trim($this->si61_percdesconto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_percdesconto"])) {
      if (trim($this->si61_percdesconto) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si61_percdesconto"])) {
        $this->si61_percdesconto = "0";
      }
      $sql .= $virgula . " si61_percdesconto = $this->si61_percdesconto ";
      $virgula = ",";
    }
    if (trim($this->si61_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_mes"])) {
      $sql .= $virgula . " si61_mes = $this->si61_mes ";
      $virgula = ",";
      if (trim($this->si61_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si61_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si61_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si61_instit"])) {
      $sql .= $virgula . " si61_instit = $this->si61_instit ";
      $virgula = ",";
      if (trim($this->si61_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si61_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si61_sequencial != null) {
      $sql .= " si61_sequencial = $this->si61_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si61_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010097,'$this->si61_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_sequencial"]) || $this->si61_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010097,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_sequencial')) . "','$this->si61_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_tiporegistro"]) || $this->si61_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010098,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_tiporegistro')) . "','$this->si61_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_codorgao"]) || $this->si61_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010099,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_codorgao')) . "','$this->si61_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_codunidadesub"]) || $this->si61_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010100,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_codunidadesub')) . "','$this->si61_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_exerciciolicitacao"]) || $this->si61_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010101,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_exerciciolicitacao')) . "','$this->si61_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_nroprocessolicitatorio"]) || $this->si61_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010102,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_nroprocessolicitatorio')) . "','$this->si61_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_tipodocumento"]) || $this->si61_tipodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010103,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_tipodocumento')) . "','$this->si61_tipodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_nrodocumento"]) || $this->si61_nrodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010104,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_nrodocumento')) . "','$this->si61_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_nrolote"]) || $this->si61_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010105,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_nrolote')) . "','$this->si61_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_coditem"]) || $this->si61_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010106,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_coditem')) . "','$this->si61_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_percdesconto"]) || $this->si61_percdesconto != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010107,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_percdesconto')) . "','$this->si61_percdesconto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_mes"]) || $this->si61_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2010108,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_mes')) . "','$this->si61_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si61_instit"]) || $this->si61_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010290,2011573,'" . AddSlashes(pg_result($resaco, $conresaco, 'si61_instit')) . "','$this->si61_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "julglic202021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si61_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "julglic202021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si61_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si61_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si61_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si61_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010097,'$si61_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010290,2010097,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2010098,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2010099,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2010100,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2010101,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2010102,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2010103,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2010104,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2010105,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2010106,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2010107,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_percdesconto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2010108,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010290,2011573,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si61_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from julglic202021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si61_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si61_sequencial = $si61_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "julglic202021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si61_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "julglic202021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si61_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si61_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:julglic202021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si61_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from julglic202021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si61_sequencial != null) {
        $sql2 .= " where julglic202021.si61_sequencial = $si61_sequencial ";
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
  function sql_query_file($si61_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from julglic202021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si61_sequencial != null) {
        $sql2 .= " where julglic202021.si61_sequencial = $si61_sequencial ";
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
