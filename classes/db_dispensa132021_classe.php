<?
//MODULO: sicom
//CLASSE DA ENTIDADE dispensa132021
class cl_dispensa132021
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
  var $si77_sequencial = 0;
  var $si77_tiporegistro = 0;
  var $si77_codorgaoresp = null;
  var $si77_codunidadesubresp = null;
  var $si77_exercicioprocesso = 0;
  var $si77_nroprocesso = null;
  var $si77_tipoprocesso = 0;
  var $si77_nrolote = 0;
  var $si77_coditem = 0;
  var $si77_mes = 0;
  var $si77_reg10 = 0;
  var $si77_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si77_sequencial = int8 = sequencial 
                 si77_tiporegistro = int8 = Tipo do registro 
                 si77_codorgaoresp = varchar(2) = Código do órgão  responsável 
                 si77_codunidadesubresp = varchar(8) = Código da unidade 
                 si77_exercicioprocesso = int8 = Exercício em que   foi instaurado 
                 si77_nroprocesso = varchar(12) = Número sequencial  do processo 
                 si77_tipoprocesso = int8 = Tipo de processo 
                 si77_nrolote = int8 = Número do Lote 
                 si77_coditem = int8 = Código do item 
                 si77_mes = int8 = Mês 
                 si77_reg10 = int8 = reg10 
                 si77_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_dispensa132021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("dispensa132021");
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
      $this->si77_sequencial = ($this->si77_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_sequencial"] : $this->si77_sequencial);
      $this->si77_tiporegistro = ($this->si77_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_tiporegistro"] : $this->si77_tiporegistro);
      $this->si77_codorgaoresp = ($this->si77_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_codorgaoresp"] : $this->si77_codorgaoresp);
      $this->si77_codunidadesubresp = ($this->si77_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_codunidadesubresp"] : $this->si77_codunidadesubresp);
      $this->si77_exercicioprocesso = ($this->si77_exercicioprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_exercicioprocesso"] : $this->si77_exercicioprocesso);
      $this->si77_nroprocesso = ($this->si77_nroprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_nroprocesso"] : $this->si77_nroprocesso);
      $this->si77_tipoprocesso = ($this->si77_tipoprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_tipoprocesso"] : $this->si77_tipoprocesso);
      $this->si77_nrolote = ($this->si77_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_nrolote"] : $this->si77_nrolote);
      $this->si77_coditem = ($this->si77_coditem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_coditem"] : $this->si77_coditem);
      $this->si77_mes = ($this->si77_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_mes"] : $this->si77_mes);
      $this->si77_reg10 = ($this->si77_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_reg10"] : $this->si77_reg10);
      $this->si77_instit = ($this->si77_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_instit"] : $this->si77_instit);
    } else {
      $this->si77_sequencial = ($this->si77_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si77_sequencial"] : $this->si77_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si77_sequencial)
  {
    $this->atualizacampos();
    if ($this->si77_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si77_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si77_exercicioprocesso == null) {
      $this->si77_exercicioprocesso = "0";
    }
    if ($this->si77_tipoprocesso == null) {
      $this->si77_tipoprocesso = "0";
    }
    if ($this->si77_nrolote == null) {
      $this->si77_nrolote = "0";
    }
    if ($this->si77_coditem == null) {
      $this->si77_coditem = "0";
    }
    if ($this->si77_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si77_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si77_reg10 == null) {
      $this->si77_reg10 = "0";
    }
    if ($this->si77_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si77_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si77_sequencial == "" || $si77_sequencial == null) {
      $result = db_query("select nextval('dispensa132021_si77_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: dispensa132021_si77_sequencial_seq do campo: si77_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si77_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from dispensa132021_si77_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si77_sequencial)) {
        $this->erro_sql = " Campo si77_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si77_sequencial = $si77_sequencial;
      }
    }
    if (($this->si77_sequencial == null) || ($this->si77_sequencial == "")) {
      $this->erro_sql = " Campo si77_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into dispensa132021(
                                       si77_sequencial 
                                      ,si77_tiporegistro 
                                      ,si77_codorgaoresp 
                                      ,si77_codunidadesubresp 
                                      ,si77_exercicioprocesso 
                                      ,si77_nroprocesso 
                                      ,si77_tipoprocesso 
                                      ,si77_nrolote 
                                      ,si77_coditem 
                                      ,si77_mes 
                                      ,si77_reg10 
                                      ,si77_instit 
                       )
                values (
                                $this->si77_sequencial 
                               ,$this->si77_tiporegistro 
                               ,'$this->si77_codorgaoresp' 
                               ,'$this->si77_codunidadesubresp' 
                               ,$this->si77_exercicioprocesso 
                               ,'$this->si77_nroprocesso' 
                               ,$this->si77_tipoprocesso 
                               ,$this->si77_nrolote 
                               ,$this->si77_coditem 
                               ,$this->si77_mes 
                               ,$this->si77_reg10 
                               ,$this->si77_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "dispensa132021 ($this->si77_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "dispensa132021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "dispensa132021 ($this->si77_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si77_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si77_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010293,'$this->si77_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010306,2010293,'','" . AddSlashes(pg_result($resaco, 0, 'si77_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010306,2010294,'','" . AddSlashes(pg_result($resaco, 0, 'si77_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010306,2010295,'','" . AddSlashes(pg_result($resaco, 0, 'si77_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010306,2010296,'','" . AddSlashes(pg_result($resaco, 0, 'si77_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010306,2010297,'','" . AddSlashes(pg_result($resaco, 0, 'si77_exercicioprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010306,2010298,'','" . AddSlashes(pg_result($resaco, 0, 'si77_nroprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010306,2010299,'','" . AddSlashes(pg_result($resaco, 0, 'si77_tipoprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010306,2010300,'','" . AddSlashes(pg_result($resaco, 0, 'si77_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010306,2010301,'','" . AddSlashes(pg_result($resaco, 0, 'si77_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010306,2010302,'','" . AddSlashes(pg_result($resaco, 0, 'si77_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010306,2010303,'','" . AddSlashes(pg_result($resaco, 0, 'si77_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010306,2011590,'','" . AddSlashes(pg_result($resaco, 0, 'si77_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    return true;
  }
  
  // funcao para alteracao
  function alterar($si77_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update dispensa132021 set ";
    $virgula = "";
    if (trim($this->si77_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_sequencial"])) {
      if (trim($this->si77_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si77_sequencial"])) {
        $this->si77_sequencial = "0";
      }
      $sql .= $virgula . " si77_sequencial = $this->si77_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si77_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_tiporegistro"])) {
      $sql .= $virgula . " si77_tiporegistro = $this->si77_tiporegistro ";
      $virgula = ",";
      if (trim($this->si77_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si77_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si77_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_codorgaoresp"])) {
      $sql .= $virgula . " si77_codorgaoresp = '$this->si77_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si77_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_codunidadesubresp"])) {
      $sql .= $virgula . " si77_codunidadesubresp = '$this->si77_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si77_exercicioprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_exercicioprocesso"])) {
      if (trim($this->si77_exercicioprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si77_exercicioprocesso"])) {
        $this->si77_exercicioprocesso = "0";
      }
      $sql .= $virgula . " si77_exercicioprocesso = $this->si77_exercicioprocesso ";
      $virgula = ",";
    }
    if (trim($this->si77_nroprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_nroprocesso"])) {
      $sql .= $virgula . " si77_nroprocesso = '$this->si77_nroprocesso' ";
      $virgula = ",";
    }
    if (trim($this->si77_tipoprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_tipoprocesso"])) {
      if (trim($this->si77_tipoprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si77_tipoprocesso"])) {
        $this->si77_tipoprocesso = "0";
      }
      $sql .= $virgula . " si77_tipoprocesso = $this->si77_tipoprocesso ";
      $virgula = ",";
    }
    if (trim($this->si77_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_nrolote"])) {
      if (trim($this->si77_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si77_nrolote"])) {
        $this->si77_nrolote = "0";
      }
      $sql .= $virgula . " si77_nrolote = $this->si77_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si77_coditem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_coditem"])) {
      if (trim($this->si77_coditem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si77_coditem"])) {
        $this->si77_coditem = "0";
      }
      $sql .= $virgula . " si77_coditem = $this->si77_coditem ";
      $virgula = ",";
    }
    if (trim($this->si77_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_mes"])) {
      $sql .= $virgula . " si77_mes = $this->si77_mes ";
      $virgula = ",";
      if (trim($this->si77_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si77_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si77_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_reg10"])) {
      if (trim($this->si77_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si77_reg10"])) {
        $this->si77_reg10 = "0";
      }
      $sql .= $virgula . " si77_reg10 = $this->si77_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si77_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si77_instit"])) {
      $sql .= $virgula . " si77_instit = $this->si77_instit ";
      $virgula = ",";
      if (trim($this->si77_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si77_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si77_sequencial != null) {
      $sql .= " si77_sequencial = $this->si77_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si77_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010293,'$this->si77_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_sequencial"]) || $this->si77_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2010293,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_sequencial')) . "','$this->si77_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_tiporegistro"]) || $this->si77_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2010294,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_tiporegistro')) . "','$this->si77_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_codorgaoresp"]) || $this->si77_codorgaoresp != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2010295,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_codorgaoresp')) . "','$this->si77_codorgaoresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_codunidadesubresp"]) || $this->si77_codunidadesubresp != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2010296,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_codunidadesubresp')) . "','$this->si77_codunidadesubresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_exercicioprocesso"]) || $this->si77_exercicioprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2010297,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_exercicioprocesso')) . "','$this->si77_exercicioprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_nroprocesso"]) || $this->si77_nroprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2010298,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_nroprocesso')) . "','$this->si77_nroprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_tipoprocesso"]) || $this->si77_tipoprocesso != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2010299,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_tipoprocesso')) . "','$this->si77_tipoprocesso'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_nrolote"]) || $this->si77_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2010300,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_nrolote')) . "','$this->si77_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_coditem"]) || $this->si77_coditem != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2010301,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_coditem')) . "','$this->si77_coditem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_mes"]) || $this->si77_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2010302,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_mes')) . "','$this->si77_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_reg10"]) || $this->si77_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2010303,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_reg10')) . "','$this->si77_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si77_instit"]) || $this->si77_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010306,2011590,'" . AddSlashes(pg_result($resaco, $conresaco, 'si77_instit')) . "','$this->si77_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "dispensa132021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si77_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dispensa132021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si77_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si77_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si77_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si77_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010293,'$si77_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010306,2010293,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010306,2010294,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010306,2010295,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010306,2010296,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010306,2010297,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_exercicioprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010306,2010298,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_nroprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010306,2010299,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_tipoprocesso')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010306,2010300,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010306,2010301,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_coditem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010306,2010302,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010306,2010303,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010306,2011590,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si77_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from dispensa132021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si77_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si77_sequencial = $si77_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "dispensa132021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si77_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "dispensa132021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si77_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si77_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:dispensa132021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  
  // funcao do sql
  function sql_query($si77_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dispensa132021 ";
    $sql .= "      left  join dispensa102020  on  dispensa102020.si74_sequencial = dispensa132021.si77_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si77_sequencial != null) {
        $sql2 .= " where dispensa132021.si77_sequencial = $si77_sequencial ";
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
  function sql_query_file($si77_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from dispensa132021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si77_sequencial != null) {
        $sql2 .= " where dispensa132021.si77_sequencial = $si77_sequencial ";
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
