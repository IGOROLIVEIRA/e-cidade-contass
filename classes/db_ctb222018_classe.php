<?
//MODULO: sicom
//CLASSE DA ENTIDADE ctb222018
class cl_ctb222018
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
  var $si98_sequencial = 0;
  var $si98_tiporegistro = 0;
  var $si98_codreduzidomov = 0;
  var $si98_ededucaodereceita = 0;
  var $si98_identificadordeducao = 0;
  var $si98_naturezareceita = 0;
  var $si98_vlrreceitacont = 0;
  var $si98_mes = 0;
  var $si98_reg21 = 0;
  var $si98_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si98_sequencial = int8 = sequencial 
                 si98_tiporegistro = int8 = Tipo do  registro 
                 si98_codreduzidomov = int8 = Código Identificador da Movimentação 
                 si98_ededucaodereceita = int8 = dedução de  receita 
                 si98_identificadordeducao = int8 = Identificador da dedução da receita 
                 si98_naturezareceita = int8 = Natureza da receita 
                 si98_vlrreceitacont = float8 = Valor  correspondente à  receita 
                 si98_mes = int8 = Mês 
                 si98_reg21 = int8 = reg21 
                 si98_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_ctb222018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ctb222018");
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
      $this->si98_sequencial = ($this->si98_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si98_sequencial"] : $this->si98_sequencial);
      $this->si98_tiporegistro = ($this->si98_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si98_tiporegistro"] : $this->si98_tiporegistro);
      $this->si98_codreduzidomov = ($this->si98_codreduzidomov == "" ? @$GLOBALS["HTTP_POST_VARS"]["si98_codreduzidomov"] : $this->si98_codreduzidomov);
      $this->si98_ededucaodereceita = ($this->si98_ededucaodereceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si98_ededucaodereceita"] : $this->si98_ededucaodereceita);
      $this->si98_identificadordeducao = ($this->si98_identificadordeducao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si98_identificadordeducao"] : $this->si98_identificadordeducao);
      $this->si98_naturezareceita = ($this->si98_naturezareceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si98_naturezareceita"] : $this->si98_naturezareceita);
      $this->si98_vlrreceitacont = ($this->si98_vlrreceitacont == "" ? @$GLOBALS["HTTP_POST_VARS"]["si98_vlrreceitacont"] : $this->si98_vlrreceitacont);
      $this->si98_mes = ($this->si98_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si98_mes"] : $this->si98_mes);
      $this->si98_reg21 = ($this->si98_reg21 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si98_reg21"] : $this->si98_reg21);
      $this->si98_instit = ($this->si98_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si98_instit"] : $this->si98_instit);
    } else {
      $this->si98_sequencial = ($this->si98_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si98_sequencial"] : $this->si98_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si98_sequencial)
  {
    $this->atualizacampos();
    if ($this->si98_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si98_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si98_codreduzidomov == null) {
      $this->si98_codreduzidomov = "0";
    }
    if ($this->si98_ededucaodereceita == null) {
      $this->si98_ededucaodereceita = "0";
    }
    if ($this->si98_identificadordeducao == null) {
      $this->si98_identificadordeducao = "0";
    }
    if ($this->si98_naturezareceita == null) {
      $this->si98_naturezareceita = "0";
    }
    if ($this->si98_vlrreceitacont == null) {
      $this->si98_vlrreceitacont = "0";
    }
    if ($this->si98_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si98_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si98_reg21 == null) {
      $this->si98_reg21 = "0";
    }
    if ($this->si98_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si98_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si98_sequencial == "" || $si98_sequencial == null) {
      $result = db_query("select nextval('ctb222018_si98_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ctb222018_si98_sequencial_seq do campo: si98_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si98_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ctb222018_si98_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si98_sequencial)) {
        $this->erro_sql = " Campo si98_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si98_sequencial = $si98_sequencial;
      }
    }
    if (($this->si98_sequencial == null) || ($this->si98_sequencial == "")) {
      $this->erro_sql = " Campo si98_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into ctb222018(
                                       si98_sequencial 
                                      ,si98_tiporegistro 
                                      ,si98_codreduzidomov 
                                      ,si98_ededucaodereceita 
                                      ,si98_identificadordeducao 
                                      ,si98_naturezareceita 
                                      ,si98_vlrreceitacont 
                                      ,si98_mes 
                                      ,si98_reg21 
                                      ,si98_instit 
                       )
                values (
                                $this->si98_sequencial 
                               ,$this->si98_tiporegistro 
                               ,$this->si98_codreduzidomov 
                               ,$this->si98_ededucaodereceita 
                               ,$this->si98_identificadordeducao 
                               ,$this->si98_naturezareceita 
                               ,$this->si98_vlrreceitacont 
                               ,$this->si98_mes 
                               ,$this->si98_reg21 
                               ,$this->si98_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ctb222018 ($this->si98_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ctb222018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ctb222018 ($this->si98_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si98_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
//    $resaco = $this->sql_record($this->sql_query_file($this->si98_sequencial));
//    if (($resaco != false) || ($this->numrows != 0)) {
//      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//      $acount = pg_result($resac, 0, 0);
//      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//      $resac = db_query("insert into db_acountkey values($acount,2010579,'$this->si98_sequencial','I')");
//      $resac = db_query("insert into db_acount values($acount,2010327,2010579,'','" . AddSlashes(pg_result($resaco, 0, 'si98_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010327,2010580,'','" . AddSlashes(pg_result($resaco, 0, 'si98_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010327,2010581,'','" . AddSlashes(pg_result($resaco, 0, 'si98_codreduzidomov')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010327,2010582,'','" . AddSlashes(pg_result($resaco, 0, 'si98_ededucaodereceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010327,2010583,'','" . AddSlashes(pg_result($resaco, 0, 'si98_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010327,2010584,'','" . AddSlashes(pg_result($resaco, 0, 'si98_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010327,2010585,'','" . AddSlashes(pg_result($resaco, 0, 'si98_vlrreceitacont')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010327,2010586,'','" . AddSlashes(pg_result($resaco, 0, 'si98_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010327,2010587,'','" . AddSlashes(pg_result($resaco, 0, 'si98_reg21')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      $resac = db_query("insert into db_acount values($acount,2010327,2011610,'','" . AddSlashes(pg_result($resaco, 0, 'si98_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si98_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ctb222018 set ";
    $virgula = "";
    if (trim($this->si98_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si98_sequencial"])) {
      if (trim($this->si98_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si98_sequencial"])) {
        $this->si98_sequencial = "0";
      }
      $sql .= $virgula . " si98_sequencial = $this->si98_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si98_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si98_tiporegistro"])) {
      $sql .= $virgula . " si98_tiporegistro = $this->si98_tiporegistro ";
      $virgula = ",";
      if (trim($this->si98_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si98_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si98_codreduzidomov) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si98_codreduzidomov"])) {
      if (trim($this->si98_codreduzidomov) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si98_codreduzidomov"])) {
        $this->si98_codreduzidomov = "0";
      }
      $sql .= $virgula . " si98_codreduzidomov = $this->si98_codreduzidomov ";
      $virgula = ",";
    }
    if (trim($this->si98_ededucaodereceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si98_ededucaodereceita"])) {
      if (trim($this->si98_ededucaodereceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si98_ededucaodereceita"])) {
        $this->si98_ededucaodereceita = "0";
      }
      $sql .= $virgula . " si98_ededucaodereceita = $this->si98_ededucaodereceita ";
      $virgula = ",";
    }
    if (trim($this->si98_identificadordeducao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si98_identificadordeducao"])) {
      if (trim($this->si98_identificadordeducao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si98_identificadordeducao"])) {
        $this->si98_identificadordeducao = "0";
      }
      $sql .= $virgula . " si98_identificadordeducao = $this->si98_identificadordeducao ";
      $virgula = ",";
    }
    if (trim($this->si98_naturezareceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si98_naturezareceita"])) {
      if (trim($this->si98_naturezareceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si98_naturezareceita"])) {
        $this->si98_naturezareceita = "0";
      }
      $sql .= $virgula . " si98_naturezareceita = $this->si98_naturezareceita ";
      $virgula = ",";
    }
    if (trim($this->si98_vlrreceitacont) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si98_vlrreceitacont"])) {
      if (trim($this->si98_vlrreceitacont) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si98_vlrreceitacont"])) {
        $this->si98_vlrreceitacont = "0";
      }
      $sql .= $virgula . " si98_vlrreceitacont = $this->si98_vlrreceitacont ";
      $virgula = ",";
    }
    if (trim($this->si98_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si98_mes"])) {
      $sql .= $virgula . " si98_mes = $this->si98_mes ";
      $virgula = ",";
      if (trim($this->si98_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si98_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si98_reg21) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si98_reg21"])) {
      if (trim($this->si98_reg21) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si98_reg21"])) {
        $this->si98_reg21 = "0";
      }
      $sql .= $virgula . " si98_reg21 = $this->si98_reg21 ";
      $virgula = ",";
    }
    if (trim($this->si98_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si98_instit"])) {
      $sql .= $virgula . " si98_instit = $this->si98_instit ";
      $virgula = ",";
      if (trim($this->si98_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si98_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si98_sequencial != null) {
      $sql .= " si98_sequencial = $this->si98_sequencial";
    }
//    $resaco = $this->sql_record($this->sql_query_file($this->si98_sequencial));
//    if ($this->numrows > 0) {
//      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2010579,'$this->si98_sequencial','A')");
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si98_sequencial"]) || $this->si98_sequencial != "") {
//          $resac = db_query("insert into db_acount values($acount,2010327,2010579,'" . AddSlashes(pg_result($resaco, $conresaco, 'si98_sequencial')) . "','$this->si98_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si98_tiporegistro"]) || $this->si98_tiporegistro != "") {
//          $resac = db_query("insert into db_acount values($acount,2010327,2010580,'" . AddSlashes(pg_result($resaco, $conresaco, 'si98_tiporegistro')) . "','$this->si98_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si98_codreduzidomov"]) || $this->si98_codreduzidomov != "") {
//          $resac = db_query("insert into db_acount values($acount,2010327,2010581,'" . AddSlashes(pg_result($resaco, $conresaco, 'si98_codreduzidomov')) . "','$this->si98_codreduzidomov'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si98_ededucaodereceita"]) || $this->si98_ededucaodereceita != "") {
//          $resac = db_query("insert into db_acount values($acount,2010327,2010582,'" . AddSlashes(pg_result($resaco, $conresaco, 'si98_ededucaodereceita')) . "','$this->si98_ededucaodereceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si98_identificadordeducao"]) || $this->si98_identificadordeducao != "") {
//          $resac = db_query("insert into db_acount values($acount,2010327,2010583,'" . AddSlashes(pg_result($resaco, $conresaco, 'si98_identificadordeducao')) . "','$this->si98_identificadordeducao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si98_naturezareceita"]) || $this->si98_naturezareceita != "") {
//          $resac = db_query("insert into db_acount values($acount,2010327,2010584,'" . AddSlashes(pg_result($resaco, $conresaco, 'si98_naturezareceita')) . "','$this->si98_naturezareceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si98_vlrreceitacont"]) || $this->si98_vlrreceitacont != "") {
//          $resac = db_query("insert into db_acount values($acount,2010327,2010585,'" . AddSlashes(pg_result($resaco, $conresaco, 'si98_vlrreceitacont')) . "','$this->si98_vlrreceitacont'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si98_mes"]) || $this->si98_mes != "") {
//          $resac = db_query("insert into db_acount values($acount,2010327,2010586,'" . AddSlashes(pg_result($resaco, $conresaco, 'si98_mes')) . "','$this->si98_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si98_reg21"]) || $this->si98_reg21 != "") {
//          $resac = db_query("insert into db_acount values($acount,2010327,2010587,'" . AddSlashes(pg_result($resaco, $conresaco, 'si98_reg21')) . "','$this->si98_reg21'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//        if (isset($GLOBALS["HTTP_POST_VARS"]["si98_instit"]) || $this->si98_instit != "") {
//          $resac = db_query("insert into db_acount values($acount,2010327,2011610,'" . AddSlashes(pg_result($resaco, $conresaco, 'si98_instit')) . "','$this->si98_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        }
//      }
//    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ctb222018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si98_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ctb222018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si98_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si98_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si98_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si98_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
//    if (($resaco != false) || ($this->numrows != 0)) {
//      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
//        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
//        $acount = pg_result($resac, 0, 0);
//        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
//        $resac = db_query("insert into db_acountkey values($acount,2010579,'$si98_sequencial','E')");
//        $resac = db_query("insert into db_acount values($acount,2010327,2010579,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si98_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010327,2010580,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si98_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010327,2010581,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si98_codreduzidomov')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010327,2010582,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si98_ededucaodereceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010327,2010583,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si98_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010327,2010584,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si98_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010327,2010585,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si98_vlrreceitacont')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010327,2010586,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si98_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010327,2010587,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si98_reg21')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//        $resac = db_query("insert into db_acount values($acount,2010327,2011610,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si98_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
//      }
//    }
    $sql = " delete from ctb222018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si98_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si98_sequencial = $si98_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ctb222018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si98_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ctb222018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si98_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si98_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ctb222018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si98_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ctb222018 ";
    $sql .= "      left  join ctb212018  on  ctb212018.si97_sequencial = ctb222018.si98_reg21";
    $sql .= "      left  join ctb202018  on  ctb202018.si96_sequencial = ctb212018.si97_reg20";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si98_sequencial != null) {
        $sql2 .= " where ctb222018.si98_sequencial = $si98_sequencial ";
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
  function sql_query_file($si98_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ctb222018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si98_sequencial != null) {
        $sql2 .= " where ctb222018.si98_sequencial = $si98_sequencial ";
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
