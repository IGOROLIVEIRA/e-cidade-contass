<?
//MODULO: sicom
//CLASSE DA ENTIDADE ext202020
class cl_ext202020
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
  var $si165_sequencial = 0;
  var $si165_tiporegistro = 0;
  var $si165_codorgao = null;
  var $si165_codext = 0;
  var $si165_codfontrecursos = 0;
  var $si165_vlsaldoanteriorfonte = 0;
  var $si165_natsaldoanteriorfonte = null;
  var $si165_totaldebitos = 0;
  var $si165_totalcreditos = 0;
  var $si165_vlsaldoatualfonte = 0;
  var $si165_natsaldoatualfonte = null;
  var $si165_mes = 0;
  var $si165_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si165_sequencial = int8 = sequencial 
                 si165_tiporegistro = int8 = Tipo do  registro 
                 si165_codorgao = varchar(2) = Código do órgão 
                 si165_codext = int8 = Código identificador 
                 si165_codfontrecursos = int8 = Código da fonte  de recursos
                 si165_totaldebitos = float8 = Total de débitos realizados no mês
                 si165_totalcreditos = float8 = Total de créditos realizados no mês
                 si165_vlsaldoanteriorfonte = float8 = Saldo anterior da  extraorçamentária 
                 si165_vlsaldoatualfonte = float8 = Saldo atual da Extraorçamentária 
                 si165_mes = int8 = Mês 
                 si165_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_ext202020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ext202020");
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
      $this->si165_sequencial = ($this->si165_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_sequencial"] : $this->si165_sequencial);
      $this->si165_tiporegistro = ($this->si165_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_tiporegistro"] : $this->si165_tiporegistro);
      $this->si165_codorgao = ($this->si165_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_codorgao"] : $this->si165_codorgao);
      $this->si165_codext = ($this->si165_codext == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_codext"] : $this->si165_codext);
      $this->si165_codfontrecursos = ($this->si165_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_codfontrecursos"] : $this->si165_codfontrecursos);
      $this->si165_vlsaldoanteriorfonte = ($this->si165_vlsaldoanteriorfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_vlsaldoanteriorfonte"] : $this->si165_vlsaldoanteriorfonte);
      $this->si165_natsaldoanteriorfonte = ($this->si165_natsaldoanteriorfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_natsaldoanteriorfonte"] : $this->si165_natsaldoanteriorfonte);
      $this->si165_vlsaldoatualfonte = ($this->si165_vlsaldoatualfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_vlsaldoatualfonte"] : $this->si165_vlsaldoatualfonte);
      $this->si165_natsaldoatualfonte = ($this->si165_natsaldoatualfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_natsaldoatualfonte"] : $this->si165_natsaldoatualfonte);
      $this->si165_mes = ($this->si165_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_mes"] : $this->si165_mes);
      $this->si165_instit = ($this->si165_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_instit"] : $this->si165_instit);
    } else {
      $this->si165_sequencial = ($this->si165_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si165_sequencial"] : $this->si165_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si165_sequencial)
  {
    $this->atualizacampos();
    if ($this->si165_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si165_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si165_codext == null) {
      $this->si165_codext = "0";
    }
    if ($this->si165_codfontrecursos == null) {
      $this->si165_codfontrecursos = "0";
    }
    if ($this->si165_totaldebitos == null) {
      $this->si165_totaldebitos = "0";
    }
    if ($this->si165_totalcreditos == null) {
      $this->si165_totalcreditos = "0";
    }
    if ($this->si165_vlsaldoanteriorfonte == null) {
      $this->si165_vlsaldoanteriorfonte = "0";
    }
    if ($this->si165_vlsaldoatualfonte == null) {
      $this->si165_vlsaldoatualfonte = "0";
    }
    if ($this->si165_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si165_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si165_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si165_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si165_sequencial == "" || $si165_sequencial == null) {
      $result = db_query("select nextval('ext202020_si165_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ext202020_si165_sequencial_seq do campo: si165_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si165_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ext202020_si165_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si165_sequencial)) {
        $this->erro_sql = " Campo si165_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si165_sequencial = $si165_sequencial;
      }
    }
    if (($this->si165_sequencial == null) || ($this->si165_sequencial == "")) {
      $this->erro_sql = " Campo si165_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into ext202020(
                                       si165_sequencial 
                                      ,si165_tiporegistro 
                                      ,si165_codorgao 
                                      ,si165_codext 
                                      ,si165_codfontrecursos 
                                      ,si165_vlsaldoanteriorfonte 
                                      ,si165_natsaldoanteriorfonte
                                      ,si165_totaldebitos
                                      ,si165_totalcreditos
                                      ,si165_vlsaldoatualfonte
                                      ,si165_natsaldoatualfonte 
                                      ,si165_mes 
                                      ,si165_instit 
                       )
                values (
                                $this->si165_sequencial 
                               ,$this->si165_tiporegistro 
                               ,'$this->si165_codorgao' 
                               ,$this->si165_codext 
                               ,$this->si165_codfontrecursos 
                               ,$this->si165_vlsaldoanteriorfonte
                               ,'$this->si165_natsaldoanteriorfonte'
                               ,$this->si165_totaldebitos
                               ,$this->si165_totalcreditos
                               ,$this->si165_vlsaldoatualfonte
                               ,'$this->si165_natsaldoatualfonte' 
                               ,$this->si165_mes 
                               ,$this->si165_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ext202020 ($this->si165_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ext202020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ext202020 ($this->si165_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si165_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si165_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
//      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//      $acount = pg_result($resac, 0, 0);
//      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//      $resac = db_query("insert into db_acountkey values($acount,2011346,'$this->si165_sequencial','I')");
//      $resac = db_query("insert into db_acount values($acount,2010396,2011346,'','" . AddSlashes(pg_result($resaco, 0, 'si165_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010396,2011340,'','" . AddSlashes(pg_result($resaco, 0, 'si165_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010396,2011341,'','" . AddSlashes(pg_result($resaco, 0, 'si165_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010396,2011342,'','" . AddSlashes(pg_result($resaco, 0, 'si165_codext')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010396,2011343,'','" . AddSlashes(pg_result($resaco, 0, 'si165_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010396,2011344,'','" . AddSlashes(pg_result($resaco, 0, 'si165_vlsaldoanteriorfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010396,2011345,'','" . AddSlashes(pg_result($resaco, 0, 'si165_vlsaldoatualfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010396,2011529,'','" . AddSlashes(pg_result($resaco, 0, 'si165_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010396,2011678,'','" . AddSlashes(pg_result($resaco, 0, 'si165_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si165_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ext202020 set ";
    $virgula = "";
    if (trim($this->si165_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si165_sequencial"])) {
      if (trim($this->si165_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si165_sequencial"])) {
        $this->si165_sequencial = "0";
      }
      $sql .= $virgula . " si165_sequencial = $this->si165_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si165_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si165_tiporegistro"])) {
      $sql .= $virgula . " si165_tiporegistro = $this->si165_tiporegistro ";
      $virgula = ",";
      if (trim($this->si165_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si165_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si165_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si165_codorgao"])) {
      $sql .= $virgula . " si165_codorgao = '$this->si165_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si165_codext) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si165_codext"])) {
      if (trim($this->si165_codext) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si165_codext"])) {
        $this->si165_codext = "0";
      }
      $sql .= $virgula . " si165_codext = $this->si165_codext ";
      $virgula = ",";
    }
    if (trim($this->si165_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si165_codfontrecursos"])) {
      if (trim($this->si165_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si165_codfontrecursos"])) {
        $this->si165_codfontrecursos = "0";
      }
      $sql .= $virgula . " si165_codfontrecursos = $this->si165_codfontrecursos ";
      $virgula = ",";
    }
    if (trim($this->si165_vlsaldoanteriorfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si165_vlsaldoanteriorfonte"])) {
      if (trim($this->si165_vlsaldoanteriorfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si165_vlsaldoanteriorfonte"])) {
        $this->si165_vlsaldoanteriorfonte = "0";
      }
      $sql .= $virgula . " si165_vlsaldoanteriorfonte = $this->si165_vlsaldoanteriorfonte ";
      $virgula = ",";
    }
    if (trim($this->si165_vlsaldoatualfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si165_vlsaldoatualfonte"])) {
      if (trim($this->si165_vlsaldoatualfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si165_vlsaldoatualfonte"])) {
        $this->si165_vlsaldoatualfonte = "0";
      }
      $sql .= $virgula . " si165_vlsaldoatualfonte = $this->si165_vlsaldoatualfonte ";
      $virgula = ",";
    }
    if (trim($this->si165_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si165_mes"])) {
      $sql .= $virgula . " si165_mes = $this->si165_mes ";
      $virgula = ",";
      if (trim($this->si165_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si165_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si165_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si165_instit"])) {
      $sql .= $virgula . " si165_instit = $this->si165_instit ";
      $virgula = ",";
      if (trim($this->si165_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si165_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si165_sequencial != null) {
      $sql .= " si165_sequencial = $this->si165_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si165_sequencial));
    if ($this->numrows > 0) {
//      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2011346,'$this->si165_sequencial','A')");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si165_sequencial"]) || $this->si165_sequencial != "") {
//          $resac = db_query("insert into db_acount values($acount,2010396,2011346,'" . AddSlashes(pg_result($resaco, $conresaco, 'si165_sequencial')) . "','$this->si165_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si165_tiporegistro"]) || $this->si165_tiporegistro != "") {
//          $resac = db_query("insert into db_acount values($acount,2010396,2011340,'" . AddSlashes(pg_result($resaco, $conresaco, 'si165_tiporegistro')) . "','$this->si165_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si165_codorgao"]) || $this->si165_codorgao != "") {
//          $resac = db_query("insert into db_acount values($acount,2010396,2011341,'" . AddSlashes(pg_result($resaco, $conresaco, 'si165_codorgao')) . "','$this->si165_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si165_codext"]) || $this->si165_codext != "") {
//          $resac = db_query("insert into db_acount values($acount,2010396,2011342,'" . AddSlashes(pg_result($resaco, $conresaco, 'si165_codext')) . "','$this->si165_codext'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si165_codfontrecursos"]) || $this->si165_codfontrecursos != "") {
//          $resac = db_query("insert into db_acount values($acount,2010396,2011343,'" . AddSlashes(pg_result($resaco, $conresaco, 'si165_codfontrecursos')) . "','$this->si165_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si165_vlsaldoanteriorfonte"]) || $this->si165_vlsaldoanteriorfonte != "") {
//          $resac = db_query("insert into db_acount values($acount,2010396,2011344,'" . AddSlashes(pg_result($resaco, $conresaco, 'si165_vlsaldoanteriorfonte')) . "','$this->si165_vlsaldoanteriorfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si165_vlsaldoatualfonte"]) || $this->si165_vlsaldoatualfonte != "") {
//          $resac = db_query("insert into db_acount values($acount,2010396,2011345,'" . AddSlashes(pg_result($resaco, $conresaco, 'si165_vlsaldoatualfonte')) . "','$this->si165_vlsaldoatualfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si165_mes"]) || $this->si165_mes != "") {
//          $resac = db_query("insert into db_acount values($acount,2010396,2011529,'" . AddSlashes(pg_result($resaco, $conresaco, 'si165_mes')) . "','$this->si165_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si165_instit"]) || $this->si165_instit != "") {
//          $resac = db_query("insert into db_acount values($acount,2010396,2011678,'" . AddSlashes(pg_result($resaco, $conresaco, 'si165_instit')) . "','$this->si165_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ext202020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si165_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ext202020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si165_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si165_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si165_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si165_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
//      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2011346,'$si165_sequencial','E')");
//        $resac = db_query("insert into db_acount values($acount,2010396,2011346,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si165_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010396,2011340,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si165_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010396,2011341,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si165_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010396,2011342,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si165_codext')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010396,2011343,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si165_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010396,2011344,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si165_vlsaldoanteriorfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010396,2011345,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si165_vlsaldoatualfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010396,2011529,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si165_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010396,2011678,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si165_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      }
    }
    $sql = " delete from ext202020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si165_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si165_sequencial = $si165_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ext202020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si165_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ext202020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si165_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si165_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ext202020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si165_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ext202020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si165_sequencial != null) {
        $sql2 .= " where ext202020.si165_sequencial = $si165_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
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
  function sql_query_file($si165_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ext202020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si165_sequencial != null) {
        $sql2 .= " where ext202020.si165_sequencial = $si165_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
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
