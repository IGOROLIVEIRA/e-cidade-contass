<?
//MODULO: sicom
//CLASSE DA ENTIDADE regadesao112021
class cl_regadesao112021
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
  var $si68_sequencial = 0;
  var $si68_tiporegistro = 0;
  var $si68_codorgao = null;
  var $si68_codunidadesub = null;
  var $si68_nroprocadesao = null;
  var $si68_exercicioadesao = 0;
  var $si68_nrolote = 0;
  var $si68_dsclote = null;
  var $si68_mes = 0;
  var $si68_reg10 = 0;
  var $si68_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si68_sequencial = int8 = sequencial 
                 si68_tiporegistro = int8 = Tipo do registro 
                 si68_codorgao = varchar(2) = Código do órgão 
                 si68_codunidadesub = varchar(8) = Código da unidade 
                 si68_nroprocadesao = varchar(12) = Número do  processo de  adesão 
                 si68_exercicioadesao = int8 = Exercício do processo de adesão 
                 si68_nrolote = int8 = Número do Lote 
                 si68_dsclote = varchar(250) = Descrição do Lote 
                 si68_mes = int8 = Mês 
                 si68_reg10 = int8 = reg10 
                 si68_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_regadesao112021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("regadesao112021");
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
      $this->si68_sequencial = ($this->si68_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_sequencial"] : $this->si68_sequencial);
      $this->si68_tiporegistro = ($this->si68_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_tiporegistro"] : $this->si68_tiporegistro);
      $this->si68_codorgao = ($this->si68_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_codorgao"] : $this->si68_codorgao);
      $this->si68_codunidadesub = ($this->si68_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_codunidadesub"] : $this->si68_codunidadesub);
      $this->si68_nroprocadesao = ($this->si68_nroprocadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_nroprocadesao"] : $this->si68_nroprocadesao);
      $this->si68_exercicioadesao = ($this->si68_exercicioadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_exercicioadesao"] : $this->si68_exercicioadesao);
      $this->si68_nrolote = ($this->si68_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_nrolote"] : $this->si68_nrolote);
      $this->si68_dsclote = ($this->si68_dsclote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_dsclote"] : $this->si68_dsclote);
      $this->si68_mes = ($this->si68_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_mes"] : $this->si68_mes);
      $this->si68_reg10 = ($this->si68_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_reg10"] : $this->si68_reg10);
      $this->si68_instit = ($this->si68_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_instit"] : $this->si68_instit);
    } else {
      $this->si68_sequencial = ($this->si68_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si68_sequencial"] : $this->si68_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si68_sequencial)
  {
    $this->atualizacampos();
    if ($this->si68_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si68_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si68_exercicioadesao == null) {
      $this->si68_exercicioadesao = "0";
    }
    if ($this->si68_nrolote == null) {
      $this->si68_nrolote = "0";
    }
    if ($this->si68_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si68_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si68_reg10 == null) {
      $this->si68_reg10 = "0";
    }
    if ($this->si68_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si68_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si68_sequencial == "" || $si68_sequencial == null) {
      $result = db_query("select nextval('regadesao112021_si68_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: regadesao112021_si68_sequencial_seq do campo: si68_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si68_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from regadesao112021_si68_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si68_sequencial)) {
        $this->erro_sql = " Campo si68_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si68_sequencial = $si68_sequencial;
      }
    }
    if (($this->si68_sequencial == null) || ($this->si68_sequencial == "")) {
      $this->erro_sql = " Campo si68_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into regadesao112021(
                                       si68_sequencial 
                                      ,si68_tiporegistro 
                                      ,si68_codorgao 
                                      ,si68_codunidadesub 
                                      ,si68_nroprocadesao 
                                      ,si68_exercicioadesao 
                                      ,si68_nrolote 
                                      ,si68_dsclote 
                                      ,si68_mes 
                                      ,si68_reg10 
                                      ,si68_instit 
                       )
                values (
                                $this->si68_sequencial 
                               ,$this->si68_tiporegistro 
                               ,'$this->si68_codorgao' 
                               ,'$this->si68_codunidadesub' 
                               ,'$this->si68_nroprocadesao' 
                               ,$this->si68_exercicioadesao 
                               ,$this->si68_nrolote 
                               ,'$this->si68_dsclote' 
                               ,$this->si68_mes 
                               ,$this->si68_reg10 
                               ,$this->si68_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "regadesao112021 ($this->si68_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "regadesao112021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "regadesao112021 ($this->si68_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si68_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si68_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010184,'$this->si68_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010297,2010184,'','" . AddSlashes(pg_result($resaco, 0, 'si68_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010297,2010185,'','" . AddSlashes(pg_result($resaco, 0, 'si68_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010297,2010186,'','" . AddSlashes(pg_result($resaco, 0, 'si68_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010297,2010187,'','" . AddSlashes(pg_result($resaco, 0, 'si68_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010297,2010188,'','" . AddSlashes(pg_result($resaco, 0, 'si68_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010297,2011311,'','" . AddSlashes(pg_result($resaco, 0, 'si68_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010297,2010190,'','" . AddSlashes(pg_result($resaco, 0, 'si68_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010297,2010191,'','" . AddSlashes(pg_result($resaco, 0, 'si68_dsclote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010297,2010192,'','" . AddSlashes(pg_result($resaco, 0, 'si68_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010297,2010193,'','" . AddSlashes(pg_result($resaco, 0, 'si68_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010297,2011580,'','" . AddSlashes(pg_result($resaco, 0, 'si68_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  
  // funcao para alteracao
  function alterar($si68_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update regadesao112021 set ";
    $virgula = "";
    if (trim($this->si68_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si68_sequencial"])) {
      if (trim($this->si68_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si68_sequencial"])) {
        $this->si68_sequencial = "0";
      }
      $sql .= $virgula . " si68_sequencial = $this->si68_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si68_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si68_tiporegistro"])) {
      $sql .= $virgula . " si68_tiporegistro = $this->si68_tiporegistro ";
      $virgula = ",";
      if (trim($this->si68_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si68_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si68_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si68_codorgao"])) {
      $sql .= $virgula . " si68_codorgao = '$this->si68_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si68_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si68_codunidadesub"])) {
      $sql .= $virgula . " si68_codunidadesub = '$this->si68_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si68_nroprocadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si68_nroprocadesao"])) {
      $sql .= $virgula . " si68_nroprocadesao = '$this->si68_nroprocadesao' ";
      $virgula = ",";
    }
    if (trim($this->si68_exercicioadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si68_exercicioadesao"])) {
      if (trim($this->si68_exercicioadesao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si68_exercicioadesao"])) {
        $this->si68_exercicioadesao = "0";
      }
      $sql .= $virgula . " si68_exercicioadesao = $this->si68_exercicioadesao ";
      $virgula = ",";
    }
    if (trim($this->si68_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si68_nrolote"])) {
      if (trim($this->si68_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si68_nrolote"])) {
        $this->si68_nrolote = "0";
      }
      $sql .= $virgula . " si68_nrolote = $this->si68_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si68_dsclote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si68_dsclote"])) {
      $sql .= $virgula . " si68_dsclote = '$this->si68_dsclote' ";
      $virgula = ",";
    }
    if (trim($this->si68_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si68_mes"])) {
      $sql .= $virgula . " si68_mes = $this->si68_mes ";
      $virgula = ",";
      if (trim($this->si68_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si68_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si68_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si68_reg10"])) {
      if (trim($this->si68_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si68_reg10"])) {
        $this->si68_reg10 = "0";
      }
      $sql .= $virgula . " si68_reg10 = $this->si68_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si68_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si68_instit"])) {
      $sql .= $virgula . " si68_instit = $this->si68_instit ";
      $virgula = ",";
      if (trim($this->si68_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si68_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si68_sequencial != null) {
      $sql .= " si68_sequencial = $this->si68_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si68_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010184,'$this->si68_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si68_sequencial"]) || $this->si68_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010297,2010184,'" . AddSlashes(pg_result($resaco, $conresaco, 'si68_sequencial')) . "','$this->si68_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si68_tiporegistro"]) || $this->si68_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010297,2010185,'" . AddSlashes(pg_result($resaco, $conresaco, 'si68_tiporegistro')) . "','$this->si68_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si68_codorgao"]) || $this->si68_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010297,2010186,'" . AddSlashes(pg_result($resaco, $conresaco, 'si68_codorgao')) . "','$this->si68_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si68_codunidadesub"]) || $this->si68_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010297,2010187,'" . AddSlashes(pg_result($resaco, $conresaco, 'si68_codunidadesub')) . "','$this->si68_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si68_nroprocadesao"]) || $this->si68_nroprocadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010297,2010188,'" . AddSlashes(pg_result($resaco, $conresaco, 'si68_nroprocadesao')) . "','$this->si68_nroprocadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si68_exercicioadesao"]) || $this->si68_exercicioadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010297,2011311,'" . AddSlashes(pg_result($resaco, $conresaco, 'si68_exercicioadesao')) . "','$this->si68_exercicioadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si68_nrolote"]) || $this->si68_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010297,2010190,'" . AddSlashes(pg_result($resaco, $conresaco, 'si68_nrolote')) . "','$this->si68_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si68_dsclote"]) || $this->si68_dsclote != "")
          $resac = db_query("insert into db_acount values($acount,2010297,2010191,'" . AddSlashes(pg_result($resaco, $conresaco, 'si68_dsclote')) . "','$this->si68_dsclote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si68_mes"]) || $this->si68_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010297,2010192,'" . AddSlashes(pg_result($resaco, $conresaco, 'si68_mes')) . "','$this->si68_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si68_reg10"]) || $this->si68_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010297,2010193,'" . AddSlashes(pg_result($resaco, $conresaco, 'si68_reg10')) . "','$this->si68_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si68_instit"]) || $this->si68_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010297,2011580,'" . AddSlashes(pg_result($resaco, $conresaco, 'si68_instit')) . "','$this->si68_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao112021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si68_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao112021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si68_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si68_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si68_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si68_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010184,'$si68_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010297,2010184,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si68_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010297,2010185,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si68_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010297,2010186,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si68_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010297,2010187,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si68_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010297,2010188,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si68_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010297,2011311,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si68_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010297,2010190,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si68_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010297,2010191,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si68_dsclote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010297,2010192,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si68_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010297,2010193,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si68_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010297,2011580,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si68_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from regadesao112021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si68_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si68_sequencial = $si68_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao112021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si68_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao112021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si68_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si68_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:regadesao112021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  
  // funcao do sql
  function sql_query($si68_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao112021 ";
    $sql .= "      left  join regadesao102020  on  regadesao102020.si67_sequencial = regadesao112021.si68_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si68_sequencial != null) {
        $sql2 .= " where regadesao112021.si68_sequencial = $si68_sequencial ";
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
  function sql_query_file($si68_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao112021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si68_sequencial != null) {
        $sql2 .= " where regadesao112021.si68_sequencial = $si68_sequencial ";
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
