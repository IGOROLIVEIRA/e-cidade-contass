<?
//MODULO: sicom
//CLASSE DA ENTIDADE regadesao132019
class cl_regadesao132019
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
  var $si70_sequencial = 0;
  var $si70_tiporegistro = 0;
  var $si70_codorgao = null;
  var $si70_codunidadesub = null;
  var $si70_nroprocadesao = null;
  var $si70_exercicioadesao = 0;
  var $si70_nrolote = 0;
  var $si70_coditem = 0;
  var $si70_mes = 0;
  var $si70_reg10 = 0;
  var $si70_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si70_sequencial = int8 = sequencial 
                 si70_tiporegistro = int8 = Tipo do registro 
                 si70_codorgao = varchar(2) = Código do órgão 
                 si70_codunidadesub = varchar(8) = Código da unidade 
                 si70_nroprocadesao = varchar(12) = Número do  processo 
                 si70_exercicioadesao = int8 = Exercício do processo de adesão 
                 si70_nrolote = int8 = Número do Lote 
                 si70_coditem = int8 = Código do Item 
                 si70_mes = int8 = Mês 
                 si70_reg10 = int8 = reg10 
                 si70_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_regadesao132019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("regadesao132019");
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
      $this->si70_sequencial = ($this->si70_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_sequencial"] : $this->si70_sequencial);
      $this->si70_tiporegistro = ($this->si70_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_tiporegistro"] : $this->si70_tiporegistro);
      $this->si70_codorgao = ($this->si70_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_codorgao"] : $this->si70_codorgao);
      $this->si70_codunidadesub = ($this->si70_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_codunidadesub"] : $this->si70_codunidadesub);
      $this->si70_nroprocadesao = ($this->si70_nroprocadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_nroprocadesao"] : $this->si70_nroprocadesao);
      $this->si70_exercicioadesao = ($this->si70_exercicioadesao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_exercicioadesao"] : $this->si70_exercicioadesao);
      $this->si70_nrolote = ($this->si70_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_nrolote"] : $this->si70_nrolote);
      $this->si70_coditem = ($this->si70_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_coditem"] : $this->si70_coditem);
      $this->si70_mes = ($this->si70_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_mes"] : $this->si70_mes);
      $this->si70_reg10 = ($this->si70_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_reg10"] : $this->si70_reg10);
      $this->si70_instit = ($this->si70_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_instit"] : $this->si70_instit);
    } else {
      $this->si70_sequencial = ($this->si70_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si70_sequencial"] : $this->si70_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si70_sequencial)
  {
    $this->atualizacampos();
    if ($this->si70_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si70_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si70_exercicioadesao == null) {
      $this->si70_exercicioadesao = "0";
    }
    if ($this->si70_nrolote == null) {
      $this->si70_nrolote = "0";
    }
    if ($this->si70_coditem == null) {
      $this->si70_coditem = "0";
    }
    if ($this->si70_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si70_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si70_reg10 == null) {
      $this->si70_reg10 = "0";
    }
    if ($this->si70_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si70_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si70_sequencial == "" || $si70_sequencial == null) {
      $result = db_query("select nextval('regadesao132019_si70_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: regadesao132019_si70_sequencial_seq do campo: si70_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si70_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from regadesao132019_si70_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si70_sequencial)) {
        $this->erro_sql = " Campo si70_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si70_sequencial = $si70_sequencial;
      }
    }
    if (($this->si70_sequencial == null) || ($this->si70_sequencial == "")) {
      $this->erro_sql = " Campo si70_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into regadesao132019(
                                       si70_sequencial 
                                      ,si70_tiporegistro 
                                      ,si70_codorgao 
                                      ,si70_codunidadesub 
                                      ,si70_nroprocadesao 
                                      ,si70_exercicioadesao 
                                      ,si70_nrolote 
                                      ,si70_coditem 
                                      ,si70_mes 
                                      ,si70_reg10 
                                      ,si70_instit 
                       )
                values (
                                $this->si70_sequencial 
                               ,$this->si70_tiporegistro 
                               ,'$this->si70_codorgao' 
                               ,'$this->si70_codunidadesub' 
                               ,'$this->si70_nroprocadesao' 
                               ,$this->si70_exercicioadesao 
                               ,$this->si70_nrolote 
                               ,$this->si70_coditem 
                               ,$this->si70_mes 
                               ,$this->si70_reg10 
                               ,$this->si70_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "regadesao132019 ($this->si70_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "regadesao132019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "regadesao132019 ($this->si70_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si70_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si70_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010204,'$this->si70_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010299,2010204,'','" . AddSlashes(pg_result($resaco, 0, 'si70_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010299,2010205,'','" . AddSlashes(pg_result($resaco, 0, 'si70_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010299,2010206,'','" . AddSlashes(pg_result($resaco, 0, 'si70_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010299,2010207,'','" . AddSlashes(pg_result($resaco, 0, 'si70_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010299,2010208,'','" . AddSlashes(pg_result($resaco, 0, 'si70_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010299,2011313,'','" . AddSlashes(pg_result($resaco, 0, 'si70_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010299,2010210,'','" . AddSlashes(pg_result($resaco, 0, 'si70_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010299,2010211,'','" . AddSlashes(pg_result($resaco, 0, 'si70_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010299,2010212,'','" . AddSlashes(pg_result($resaco, 0, 'si70_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010299,2010213,'','" . AddSlashes(pg_result($resaco, 0, 'si70_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010299,2011582,'','" . AddSlashes(pg_result($resaco, 0, 'si70_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  
  // funcao para alteracao
  function alterar($si70_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update regadesao132019 set ";
    $virgula = "";
    if (trim($this->si70_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si70_sequencial"])) {
      if (trim($this->si70_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si70_sequencial"])) {
        $this->si70_sequencial = "0";
      }
      $sql .= $virgula . " si70_sequencial = $this->si70_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si70_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si70_tiporegistro"])) {
      $sql .= $virgula . " si70_tiporegistro = $this->si70_tiporegistro ";
      $virgula = ",";
      if (trim($this->si70_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si70_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si70_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si70_codorgao"])) {
      $sql .= $virgula . " si70_codorgao = '$this->si70_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si70_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si70_codunidadesub"])) {
      $sql .= $virgula . " si70_codunidadesub = '$this->si70_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si70_nroprocadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si70_nroprocadesao"])) {
      $sql .= $virgula . " si70_nroprocadesao = '$this->si70_nroprocadesao' ";
      $virgula = ",";
    }
    if (trim($this->si70_exercicioadesao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si70_exercicioadesao"])) {
      if (trim($this->si70_exercicioadesao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si70_exercicioadesao"])) {
        $this->si70_exercicioadesao = "0";
      }
      $sql .= $virgula . " si70_exercicioadesao = $this->si70_exercicioadesao ";
      $virgula = ",";
    }
    if (trim($this->si70_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si70_nrolote"])) {
      if (trim($this->si70_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si70_nrolote"])) {
        $this->si70_nrolote = "0";
      }
      $sql .= $virgula . " si70_nrolote = $this->si70_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si70_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si70_coditem"])) {
      if (trim($this->si70_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si70_coditem"])) {
        $this->si70_coditem = "0";
      }
      $sql .= $virgula . " si70_coditem = $this->si70_coditem ";
      $virgula = ",";
    }
    if (trim($this->si70_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si70_mes"])) {
      $sql .= $virgula . " si70_mes = $this->si70_mes ";
      $virgula = ",";
      if (trim($this->si70_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si70_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si70_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si70_reg10"])) {
      if (trim($this->si70_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si70_reg10"])) {
        $this->si70_reg10 = "0";
      }
      $sql .= $virgula . " si70_reg10 = $this->si70_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si70_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si70_instit"])) {
      $sql .= $virgula . " si70_instit = $this->si70_instit ";
      $virgula = ",";
      if (trim($this->si70_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si70_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si70_sequencial != null) {
      $sql .= " si70_sequencial = $this->si70_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si70_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010204,'$this->si70_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si70_sequencial"]) || $this->si70_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010299,2010204,'" . AddSlashes(pg_result($resaco, $conresaco, 'si70_sequencial')) . "','$this->si70_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si70_tiporegistro"]) || $this->si70_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010299,2010205,'" . AddSlashes(pg_result($resaco, $conresaco, 'si70_tiporegistro')) . "','$this->si70_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si70_codorgao"]) || $this->si70_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010299,2010206,'" . AddSlashes(pg_result($resaco, $conresaco, 'si70_codorgao')) . "','$this->si70_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si70_codunidadesub"]) || $this->si70_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010299,2010207,'" . AddSlashes(pg_result($resaco, $conresaco, 'si70_codunidadesub')) . "','$this->si70_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si70_nroprocadesao"]) || $this->si70_nroprocadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010299,2010208,'" . AddSlashes(pg_result($resaco, $conresaco, 'si70_nroprocadesao')) . "','$this->si70_nroprocadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si70_exercicioadesao"]) || $this->si70_exercicioadesao != "")
          $resac = db_query("insert into db_acount values($acount,2010299,2011313,'" . AddSlashes(pg_result($resaco, $conresaco, 'si70_exercicioadesao')) . "','$this->si70_exercicioadesao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si70_nrolote"]) || $this->si70_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010299,2010210,'" . AddSlashes(pg_result($resaco, $conresaco, 'si70_nrolote')) . "','$this->si70_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si70_coditem"]) || $this->si70_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010299,2010211,'" . AddSlashes(pg_result($resaco, $conresaco, 'si70_coditem')) . "','$this->si70_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si70_mes"]) || $this->si70_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010299,2010212,'" . AddSlashes(pg_result($resaco, $conresaco, 'si70_mes')) . "','$this->si70_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si70_reg10"]) || $this->si70_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010299,2010213,'" . AddSlashes(pg_result($resaco, $conresaco, 'si70_reg10')) . "','$this->si70_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si70_instit"]) || $this->si70_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010299,2011582,'" . AddSlashes(pg_result($resaco, $conresaco, 'si70_instit')) . "','$this->si70_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao132019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si70_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao132019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si70_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si70_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si70_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si70_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010204,'$si70_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010299,2010204,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si70_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010299,2010205,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si70_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010299,2010206,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si70_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010299,2010207,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si70_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010299,2010208,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si70_nroprocadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010299,2011313,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si70_exercicioadesao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010299,2010210,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si70_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010299,2010211,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si70_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010299,2010212,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si70_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010299,2010213,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si70_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010299,2011582,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si70_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from regadesao132019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si70_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si70_sequencial = $si70_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "regadesao132019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si70_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "regadesao132019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si70_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si70_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:regadesao132019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  
  // funcao do sql
  function sql_query($si70_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao132019 ";
    $sql .= "      left  join regadesao102019  on  regadesao102019.si67_sequencial = regadesao132019.si70_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si70_sequencial != null) {
        $sql2 .= " where regadesao132019.si70_sequencial = $si70_sequencial ";
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
  function sql_query_file($si70_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from regadesao132019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si70_sequencial != null) {
        $sql2 .= " where regadesao132019.si70_sequencial = $si70_sequencial ";
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
