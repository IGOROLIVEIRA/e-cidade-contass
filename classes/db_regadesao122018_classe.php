<?
//MODULO: sicom
//CLASSE DA ENTIDADE regadesao122018
class cl_regadesao122018
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
  var $si69_sequencial = 0;
  var $si69_tiporegistro = 0;
  var $si69_codorgao = null;
  var $si69_codunidadesub = null;
  var $si69_nroprocadesao = null;
  var $si69_exercicioadesao = 0;
  var $si69_coditem = 0;
  var $si69_nroitem = 0;
  var $si69_mes = 0;
  var $si69_reg10 = 0;
  var $si69_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si69_sequencial = int8 = sequencial 
                 si69_tiporegistro = int8 = Tipo do registro 
                 si69_codorgao = varchar(2) = Código do órgão 
                 si69_codunidadesub = varchar(8) = Código da unidade 
                 si69_nroprocadesao = varchar(12) = Número do  processo 
                 si69_exercicioadesao = int8 = Exercício do processo de adesão 
                 si69_coditem = int8 = Código do Item 
                 si69_nroitem = int8 = Número do Item 
                 si69_mes = int8 = Mês 
                 si69_reg10 = int8 = reg10 
                 si69_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_regadesao122018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("regadesao122018");
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
      $this->si69_sequencial = ($this->si69_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_sequencial"] : $this->si69_sequencial);
      $this->si69_tiporegistro = ($this->si69_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_tiporegistro"] : $this->si69_tiporegistro);
      $this->si69_codorgao = ($this->si69_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_codorgao"] : $this->si69_codorgao);
      $this->si69_codunidadesub = ($this->si69_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_codunidadesub"] : $this->si69_codunidadesub);
      $this->si69_nroprocadesao = ($this->si69_nroprocadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_nroprocadesao"] : $this->si69_nroprocadesao);
      $this->si69_exercicioadesao = ($this->si69_exercicioadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_exercicioadesao"] : $this->si69_exercicioadesao);
      $this->si69_coditem = ($this->si69_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_coditem"] : $this->si69_coditem);
      $this->si69_nroitem = ($this->si69_nroitem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_nroitem"] : $this->si69_nroitem);
      $this->si69_mes = ($this->si69_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_mes"] : $this->si69_mes);
      $this->si69_reg10 = ($this->si69_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_reg10"] : $this->si69_reg10);
      $this->si69_instit = ($this->si69_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_instit"] : $this->si69_instit);
    } else {
      $this->si69_sequencial = ($this->si69_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si69_sequencial"] : $this->si69_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si69_sequencial)
  {
    $this->atualizacampos();
    if ($this->si69_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si69_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si69_exercicioadesao == null) {
      $this->si69_exercicioadesao = "0";
    }
    if ($this->si69_coditem == null) {
      $this->si69_coditem = "0";
    }
    if ($this->si69_nroitem == null) {
      $this->si69_nroitem = "0";
    }
    if ($this->si69_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si69_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si69_reg10 == null) {
      $this->si69_reg10 = "0";
    }
    if ($this->si69_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si69_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si69_sequencial == "" || $si69_sequencial == null) {
      $result = db_query("select nextval('regadesao122018_si69_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: regadesao122018_si69_sequencial_seq do campo: si69_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si69_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from regadesao122018_si69_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si69_sequencial)) {
        $this->erro_sql = " Campo si69_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si69_sequencial = $si69_sequencial;
      }
    }
    if (($this->si69_sequencial == null) || ($this->si69_sequencial == "")) {
      $this->erro_sql = " Campo si69_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into regadesao122018(
                                       si69_sequencial 
                                      ,si69_tiporegistro 
                                      ,si69_codorgao 
                                      ,si69_codunidadesub 
                                      ,si69_nroprocadesao 
                                      ,si69_exercicioadesao 
                                      ,si69_coditem 
                                      ,si69_nroitem 
                                      ,si69_mes 
                                      ,si69_reg10 
                                      ,si69_instit 
                       )
                values (
                                $this->si69_sequencial 
                               ,$this->si69_tiporegistro 
                               ,'$this->si69_codorgao' 
                               ,'$this->si69_codunidadesub' 
                               ,'$this->si69_nroprocadesao' 
                               ,$this->si69_exercicioadesao 
                               ,$this->si69_coditem 
                               ,$this->si69_nroitem 
                               ,$this->si69_mes 
                               ,$this->si69_reg10 
                               ,$this->si69_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "regadesao122018 ($this->si69_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "regadesao122018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "regadesao122018 ($this->si69_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si69_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si69_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010194,'$this->si69_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010298,2010194,'','" . AddSlashes(pg_result($resaco, 0, 'si69_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010298,2010195,'','" . AddSlashes(pg_result($resaco, 0, 'si69_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010298,2010196,'','" . AddSlashes(pg_result($resaco, 0, 'si69_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010298,2010197,'','" . AddSlashes(pg_result($resaco, 0, 'si69_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010298,2010198,'','" . AddSlashes(pg_result($resaco, 0, 'si69_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010298,2011312,'','" . AddSlashes(pg_result($resaco, 0, 'si69_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010298,2010200,'','" . AddSlashes(pg_result($resaco, 0, 'si69_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010298,2010201,'','" . AddSlashes(pg_result($resaco, 0, 'si69_nroitem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010298,2010202,'','" . AddSlashes(pg_result($resaco, 0, 'si69_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010298,2010203,'','" . AddSlashes(pg_result($resaco, 0, 'si69_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010298,2011581,'','" . AddSlashes(pg_result($resaco, 0, 'si69_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  
  // funcao para alteracao
  function alterar($si69_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update regadesao122018 set ";
    $virgula = "";
    if (trim($this->si69_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si69_sequencial"])) {
      if (trim($this->si69_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si69_sequencial"])) {
        $this->si69_sequencial = "0";
      }
      $sql .= $virgula . " si69_sequencial = $this->si69_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si69_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si69_tiporegistro"])) {
      $sql .= $virgula . " si69_tiporegistro = $this->si69_tiporegistro ";
      $virgula = ",";
      if (trim($this->si69_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si69_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si69_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si69_codorgao"])) {
      $sql .= $virgula . " si69_codorgao = '$this->si69_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si69_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si69_codunidadesub"])) {
      $sql .= $virgula . " si69_codunidadesub = '$this->si69_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si69_nroprocadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si69_nroprocadesao"])) {
      $sql .= $virgula . " si69_nroprocadesao = '$this->si69_nroprocadesao' ";
      $virgula = ",";
    }
    if (trim($this->si69_exercicioadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si69_exercicioadesao"])) {
      if (trim($this->si69_exercicioadesao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si69_exercicioadesao"])) {
        $this->si69_exercicioadesao = "0";
      }
      $sql .= $virgula . " si69_exercicioadesao = $this->si69_exercicioadesao ";
      $virgula = ",";
    }
    if (trim($this->si69_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si69_coditem"])) {
      if (trim($this->si69_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si69_coditem"])) {
        $this->si69_coditem = "0";
      }
      $sql .= $virgula . " si69_coditem = $this->si69_coditem ";
      $virgula = ",";
    }
    if (trim($this->si69_nroitem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si69_nroitem"])) {
      if (trim($this->si69_nroitem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si69_nroitem"])) {
        $this->si69_nroitem = "0";
      }
      $sql .= $virgula . " si69_nroitem = $this->si69_nroitem ";
      $virgula = ",";
    }
    if (trim($this->si69_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si69_mes"])) {
      $sql .= $virgula . " si69_mes = $this->si69_mes ";
      $virgula = ",";
      if (trim($this->si69_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si69_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si69_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si69_reg10"])) {
      if (trim($this->si69_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si69_reg10"])) {
        $this->si69_reg10 = "0";
      }
      $sql .= $virgula . " si69_reg10 = $this->si69_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si69_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si69_instit"])) {
      $sql .= $virgula . " si69_instit = $this->si69_instit ";
      $virgula = ",";
      if (trim($this->si69_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si69_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si69_sequencial != null) {
      $sql .= " si69_sequencial = $this->si69_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si69_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010194,'$this->si69_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si69_sequencial"]) || $this->si69_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010298,2010194,'" . AddSlashes(pg_result($resaco, $conresaco, 'si69_sequencial')) . "','$this->si69_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si69_tiporegistro"]) || $this->si69_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010298,2010195,'" . AddSlashes(pg_result($resaco, $conresaco, 'si69_tiporegistro')) . "','$this->si69_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si69_codorgao"]) || $this->si69_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010298,2010196,'" . AddSlashes(pg_result($resaco, $conresaco, 'si69_codorgao')) . "','$this->si69_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si69_codunidadesub"]) || $this->si69_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010298,2010197,'" . AddSlashes(pg_result($resaco, $conresaco, 'si69_codunidadesub')) . "','$this->si69_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si69_nroprocadesao"]) || $this->si69_nroprocadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010298,2010198,'" . AddSlashes(pg_result($resaco, $conresaco, 'si69_nroprocadesao')) . "','$this->si69_nroprocadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si69_exercicioadesao"]) || $this->si69_exercicioadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010298,2011312,'" . AddSlashes(pg_result($resaco, $conresaco, 'si69_exercicioadesao')) . "','$this->si69_exercicioadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si69_coditem"]) || $this->si69_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010298,2010200,'" . AddSlashes(pg_result($resaco, $conresaco, 'si69_coditem')) . "','$this->si69_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si69_nroitem"]) || $this->si69_nroitem != "")
          $resac = db_query("insert into db_acount values($acount,2010298,2010201,'" . AddSlashes(pg_result($resaco, $conresaco, 'si69_nroitem')) . "','$this->si69_nroitem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si69_mes"]) || $this->si69_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010298,2010202,'" . AddSlashes(pg_result($resaco, $conresaco, 'si69_mes')) . "','$this->si69_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si69_reg10"]) || $this->si69_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010298,2010203,'" . AddSlashes(pg_result($resaco, $conresaco, 'si69_reg10')) . "','$this->si69_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si69_instit"]) || $this->si69_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010298,2011581,'" . AddSlashes(pg_result($resaco, $conresaco, 'si69_instit')) . "','$this->si69_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao122018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si69_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao122018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si69_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si69_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si69_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si69_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010194,'$si69_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010298,2010194,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si69_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010298,2010195,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si69_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010298,2010196,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si69_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010298,2010197,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si69_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010298,2010198,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si69_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010298,2011312,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si69_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010298,2010200,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si69_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010298,2010201,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si69_nroitem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010298,2010202,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si69_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010298,2010203,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si69_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010298,2011581,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si69_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from regadesao122018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si69_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si69_sequencial = $si69_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao122018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si69_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao122018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si69_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si69_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:regadesao122018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  
  // funcao do sql
  function sql_query($si69_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao122018 ";
    $sql .= "      left  join regadesao102018  on  regadesao102018.si67_sequencial = regadesao122018.si69_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si69_sequencial != null) {
        $sql2 .= " where regadesao122018.si69_sequencial = $si69_sequencial ";
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
  function sql_query_file($si69_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao122018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si69_sequencial != null) {
        $sql2 .= " where regadesao122018.si69_sequencial = $si69_sequencial ";
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
