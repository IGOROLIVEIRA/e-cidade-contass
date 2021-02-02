<?
//MODULO: sicom
//CLASSE DA ENTIDADE ext102021
class cl_ext102021
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
  var $si124_sequencial = 0;
  var $si124_tiporegistro = 0;
  var $si124_codext = 0;
  var $si124_codorgao = null;
  var $si124_tipolancamento = null;
  var $si124_subtipo = null;
  var $si124_desdobrasubtipo = null;
  var $si124_descextraorc = null;
  var $si124_mes = 0;
  var $si124_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si124_sequencial = int8 = sequencial 
                 si124_tiporegistro = int8 = Tipo do  registro 
                 si124_codext = int8 = Código identificador ExtraOrçamentária 
                 si124_codorgao = varchar(2) = Código do órgão
                 si124_tipolancamento = varchar(2) = Tipo de  Lançamento 
                 si124_subtipo = varchar(4) = Subtipo do  Lançamento 
                 si124_desdobrasubtipo = varchar(4) = Desdobramento  do Sub-Tipo 
                 si124_descextraorc = varchar(50) = Descrição da  Extra  Orçamentária 
                 si124_mes = int8 = Mês 
                 si124_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_ext102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ext102021");
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
      $this->si124_sequencial = ($this->si124_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si124_sequencial"] : $this->si124_sequencial);
      $this->si124_tiporegistro = ($this->si124_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si124_tiporegistro"] : $this->si124_tiporegistro);
      $this->si124_codext = ($this->si124_codext == "" ? @$GLOBALS["HTTP_POST_VARS"]["si124_codext"] : $this->si124_codext);
      $this->si124_codorgao = ($this->si124_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si124_codorgao"] : $this->si124_codorgao);
      $this->si124_tipolancamento = ($this->si124_tipolancamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si124_tipolancamento"] : $this->si124_tipolancamento);
      $this->si124_subtipo = ($this->si124_subtipo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si124_subtipo"] : $this->si124_subtipo);
      $this->si124_desdobrasubtipo = ($this->si124_desdobrasubtipo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si124_desdobrasubtipo"] : $this->si124_desdobrasubtipo);
      $this->si124_descextraorc = ($this->si124_descextraorc == "" ? @$GLOBALS["HTTP_POST_VARS"]["si124_descextraorc"] : $this->si124_descextraorc);
      $this->si124_mes = ($this->si124_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si124_mes"] : $this->si124_mes);
      $this->si124_instit = ($this->si124_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si124_instit"] : $this->si124_instit);
    } else {
      $this->si124_sequencial = ($this->si124_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si124_sequencial"] : $this->si124_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si124_sequencial)
  {
    $this->atualizacampos();
    if ($this->si124_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si124_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si124_codext == null) {
      $this->si124_codext = "0";
    }
    if ($this->si124_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si124_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si124_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si124_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si124_sequencial == "" || $si124_sequencial == null) {
      $result = db_query("select nextval('ext102021_si124_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ext102021_si124_sequencial_seq do campo: si124_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si124_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ext102021_si124_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si124_sequencial)) {
        $this->erro_sql = " Campo si124_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si124_sequencial = $si124_sequencial;
      }
    }
    if (($this->si124_sequencial == null) || ($this->si124_sequencial == "")) {
      $this->erro_sql = " Campo si124_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into ext102021(
                                       si124_sequencial 
                                      ,si124_tiporegistro 
                                      ,si124_codext 
                                      ,si124_codorgao
                                      ,si124_tipolancamento 
                                      ,si124_subtipo 
                                      ,si124_desdobrasubtipo 
                                      ,si124_descextraorc 
                                      ,si124_mes 
                                      ,si124_instit 
                       )
                values (
                                $this->si124_sequencial 
                               ,$this->si124_tiporegistro 
                               ,$this->si124_codext 
                               ,'$this->si124_codorgao'
                               ,'$this->si124_tipolancamento' 
                               ,'$this->si124_subtipo' 
                               ,'$this->si124_desdobrasubtipo' 
                               ,'$this->si124_descextraorc' 
                               ,$this->si124_mes 
                               ,$this->si124_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ext102021 ($this->si124_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ext102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ext102021 ($this->si124_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si124_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
//    $resaco = $this->sql_record($this->sql_query_file($this->si124_sequencial));
//    if (($resaco != false) || ($this->numrows != 0)) {
//      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//      $acount = pg_result($resac, 0, 0);
//      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//      $resac = db_query("insert into db_acountkey values($acount,2010857,'$this->si124_sequencial','I')");
//      $resac = db_query("insert into db_acount values($acount,2010353,2010857,'','" . AddSlashes(pg_result($resaco, 0, 'si124_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010353,2010845,'','" . AddSlashes(pg_result($resaco, 0, 'si124_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010353,2010846,'','" . AddSlashes(pg_result($resaco, 0, 'si124_codext')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010353,2010847,'','" . AddSlashes(pg_result($resaco, 0, 'si124_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010353,2010850,'','" . AddSlashes(pg_result($resaco, 0, 'si124_tipolancamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010353,2010851,'','" . AddSlashes(pg_result($resaco, 0, 'si124_subtipo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010353,2010852,'','" . AddSlashes(pg_result($resaco, 0, 'si124_desdobrasubtipo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010353,2010854,'','" . AddSlashes(pg_result($resaco, 0, 'si124_descextraorc')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010353,2010856,'','" . AddSlashes(pg_result($resaco, 0, 'si124_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010353,2011637,'','" . AddSlashes(pg_result($resaco, 0, 'si124_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si124_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ext102021 set ";
    $virgula = "";
    if (trim($this->si124_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si124_sequencial"])) {
      if (trim($this->si124_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si124_sequencial"])) {
        $this->si124_sequencial = "0";
      }
      $sql .= $virgula . " si124_sequencial = $this->si124_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si124_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si124_tiporegistro"])) {
      $sql .= $virgula . " si124_tiporegistro = $this->si124_tiporegistro ";
      $virgula = ",";
      if (trim($this->si124_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si124_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si124_codext) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si124_codext"])) {
      if (trim($this->si124_codext) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si124_codext"])) {
        $this->si124_codext = "0";
      }
      $sql .= $virgula . " si124_codext = $this->si124_codext ";
      $virgula = ",";
    }
    if (trim($this->si124_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si124_codorgao"])) {
      $sql .= $virgula . " si124_codorgao = '$this->si124_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si124_tipolancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si124_tipolancamento"])) {
      $sql .= $virgula . " si124_tipolancamento = '$this->si124_tipolancamento' ";
      $virgula = ",";
    }
    if (trim($this->si124_subtipo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si124_subtipo"])) {
      $sql .= $virgula . " si124_subtipo = '$this->si124_subtipo' ";
      $virgula = ",";
    }
    if (trim($this->si124_desdobrasubtipo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si124_desdobrasubtipo"])) {
      $sql .= $virgula . " si124_desdobrasubtipo = '$this->si124_desdobrasubtipo' ";
      $virgula = ",";
    }
    if (trim($this->si124_descextraorc) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si124_descextraorc"])) {
      $sql .= $virgula . " si124_descextraorc = '$this->si124_descextraorc' ";
      $virgula = ",";
    }
    if (trim($this->si124_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si124_mes"])) {
      $sql .= $virgula . " si124_mes = $this->si124_mes ";
      $virgula = ",";
      if (trim($this->si124_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si124_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si124_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si124_instit"])) {
      $sql .= $virgula . " si124_instit = $this->si124_instit ";
      $virgula = ",";
      if (trim($this->si124_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si124_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si124_sequencial != null) {
      $sql .= " si124_sequencial = $this->si124_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si124_sequencial));
    if ($this->numrows > 0) {
//      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2010857,'$this->si124_sequencial','A')");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si124_sequencial"]) || $this->si124_sequencial != "") {
//          $resac = db_query("insert into db_acount values($acount,2010353,2010857,'" . AddSlashes(pg_result($resaco, $conresaco, 'si124_sequencial')) . "','$this->si124_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si124_tiporegistro"]) || $this->si124_tiporegistro != "") {
//          $resac = db_query("insert into db_acount values($acount,2010353,2010845,'" . AddSlashes(pg_result($resaco, $conresaco, 'si124_tiporegistro')) . "','$this->si124_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si124_codext"]) || $this->si124_codext != "") {
//          $resac = db_query("insert into db_acount values($acount,2010353,2010846,'" . AddSlashes(pg_result($resaco, $conresaco, 'si124_codext')) . "','$this->si124_codext'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si124_codorgao"]) || $this->si124_codorgao != "") {
//          $resac = db_query("insert into db_acount values($acount,2010353,2010847,'" . AddSlashes(pg_result($resaco, $conresaco, 'si124_codorgao')) . "','$this->si124_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si124_tipolancamento"]) || $this->si124_tipolancamento != "") {
//          $resac = db_query("insert into db_acount values($acount,2010353,2010850,'" . AddSlashes(pg_result($resaco, $conresaco, 'si124_tipolancamento')) . "','$this->si124_tipolancamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si124_subtipo"]) || $this->si124_subtipo != "") {
//          $resac = db_query("insert into db_acount values($acount,2010353,2010851,'" . AddSlashes(pg_result($resaco, $conresaco, 'si124_subtipo')) . "','$this->si124_subtipo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si124_desdobrasubtipo"]) || $this->si124_desdobrasubtipo != "") {
//          $resac = db_query("insert into db_acount values($acount,2010353,2010852,'" . AddSlashes(pg_result($resaco, $conresaco, 'si124_desdobrasubtipo')) . "','$this->si124_desdobrasubtipo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si124_descextraorc"]) || $this->si124_descextraorc != "") {
//          $resac = db_query("insert into db_acount values($acount,2010353,2010854,'" . AddSlashes(pg_result($resaco, $conresaco, 'si124_descextraorc')) . "','$this->si124_descextraorc'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si124_mes"]) || $this->si124_mes != "") {
//          $resac = db_query("insert into db_acount values($acount,2010353,2010856,'" . AddSlashes(pg_result($resaco, $conresaco, 'si124_mes')) . "','$this->si124_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si124_instit"]) || $this->si124_instit != "") {
//          $resac = db_query("insert into db_acount values($acount,2010353,2011637,'" . AddSlashes(pg_result($resaco, $conresaco, 'si124_instit')) . "','$this->si124_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ext102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si124_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ext102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si124_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si124_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si124_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si124_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
//      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2010857,'$si124_sequencial','E')");
//        $resac = db_query("insert into db_acount values($acount,2010353,2010857,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si124_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010353,2010845,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si124_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010353,2010846,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si124_codext')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010353,2010847,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si124_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010353,2010850,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si124_tipolancamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010353,2010851,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si124_subtipo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010353,2010852,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si124_desdobrasubtipo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010353,2010854,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si124_descextraorc')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010353,2010856,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si124_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010353,2011637,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si124_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      }
    }
    $sql = " delete from ext102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si124_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si124_sequencial = $si124_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ext102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si124_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ext102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si124_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si124_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ext102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si124_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ext102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si124_sequencial != null) {
        $sql2 .= " where ext102021.si124_sequencial = $si124_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
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
  function sql_query_file($si124_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ext102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si124_sequencial != null) {
        $sql2 .= " where ext102021.si124_sequencial = $si124_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
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
