<?
//MODULO: sicom
//CLASSE DA ENTIDADE caixa132020
class cl_caixa132020
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
  var $si105_sequencial = 0;
  var $si105_tiporegistro = 0;
  var $si105_codreduzido = 0;
  var $si105_ededucaodereceita = 0;
  var $si105_identificadordeducao = 0;
  var $si105_naturezareceita = 0;
  var $si105_codfontcaixa = 0;
  var $si105_vlrreceitacont = 0;
  var $si105_mes = 0;
  var $si105_reg10 = 0;
  var $si105_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si105_sequencial = int8 = sequencial 
                 si105_tiporegistro = int8 = Tipo do registro 
                 si105_codreduzido = int8 = Código reduzido 
                 si105_ededucaodereceita = int8 = dedução de receita 
                 si105_identificadordeducao = int8 = Identificador da dedução da receita 
                 si105_naturezareceita = int8 = Natureza da receita 
                 si105_codfontcaixa = int4 = Fonte recurso do Caixa 
                 si105_vlrreceitacont = float8 = Valor  correspondente à  receita 
                 si105_mes = int8 = Mês 
                 si105_reg10 = int8 = reg10 
                 si105_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_caixa132020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("caixa132020");
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
      $this->si105_sequencial = ($this->si105_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_sequencial"] : $this->si105_sequencial);
      $this->si105_tiporegistro = ($this->si105_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_tiporegistro"] : $this->si105_tiporegistro);
      $this->si105_codreduzido = ($this->si105_codreduzido == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_codreduzido"] : $this->si105_codreduzido);
      $this->si105_ededucaodereceita = ($this->si105_ededucaodereceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_ededucaodereceita"] : $this->si105_ededucaodereceita);
      $this->si105_identificadordeducao = ($this->si105_identificadordeducao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_identificadordeducao"] : $this->si105_identificadordeducao);
      $this->si105_naturezareceita = ($this->si105_naturezareceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_naturezareceita"] : $this->si105_naturezareceita);
      $this->si105_codfontcaixa = ($this->si105_codfontcaixa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_codfontcaixa"] : $this->si105_codfontcaixa);
      $this->si105_vlrreceitacont = ($this->si105_vlrreceitacont == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_vlrreceitacont"] : $this->si105_vlrreceitacont);
      $this->si105_mes = ($this->si105_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_mes"] : $this->si105_mes);
      $this->si105_reg10 = ($this->si105_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_reg10"] : $this->si105_reg10);
      $this->si105_instit = ($this->si105_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_instit"] : $this->si105_instit);
    } else {
      $this->si105_sequencial = ($this->si105_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si105_sequencial"] : $this->si105_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si105_sequencial)
  {
    $this->atualizacampos();
    if ($this->si105_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si105_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si105_codreduzido == null) {
      $this->si105_codreduzido = "0";
    }
    if ($this->si105_ededucaodereceita == null) {
      $this->si105_ededucaodereceita = "0";
    }
    if ($this->si105_identificadordeducao == null) {
      $this->si105_identificadordeducao = "0";
    }
    if ($this->si105_naturezareceita == null) {
      $this->si105_naturezareceita = "0";
    }
    if ($this->si105_codfontcaixa == null) {
      $this->si105_codfontcaixa = "0";
    }
    if ($this->si105_vlrreceitacont == null) {
      $this->si105_vlrreceitacont = "0";
    }
    if ($this->si105_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si105_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si105_reg10 == null) {
      $this->si105_reg10 = "0";
    }
    if ($this->si105_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si105_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si105_sequencial == "" || $si105_sequencial == null) {
      $result = db_query("select nextval('caixa132020_si105_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: caixa132020_si105_sequencial_seq do campo: si105_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si105_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from caixa132020_si105_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si105_sequencial)) {
        $this->erro_sql = " Campo si105_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si105_sequencial = $si105_sequencial;
      }
    }
    if (($this->si105_sequencial == null) || ($this->si105_sequencial == "")) {
      $this->erro_sql = " Campo si105_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into caixa132020(
                                       si105_sequencial 
                                      ,si105_tiporegistro 
                                      ,si105_codreduzido 
                                      ,si105_ededucaodereceita 
                                      ,si105_identificadordeducao 
                                      ,si105_naturezareceita
                                      ,si105_codfontcaixa 
                                      ,si105_vlrreceitacont 
                                      ,si105_mes 
                                      ,si105_reg10 
                                      ,si105_instit 
                       )
                values (
                                $this->si105_sequencial 
                               ,$this->si105_tiporegistro 
                               ,$this->si105_codreduzido 
                               ,$this->si105_ededucaodereceita 
                               ,$this->si105_identificadordeducao 
                               ,$this->si105_naturezareceita 
                               ,$this->si105_codfontcaixa 
                               ,$this->si105_vlrreceitacont 
                               ,$this->si105_mes 
                               ,$this->si105_reg10 
                               ,$this->si105_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "caixa132020 ($this->si105_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "caixa132020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "caixa132020 ($this->si105_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si105_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si105_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010632,'$this->si105_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010334,2010632,'','" . AddSlashes(pg_result($resaco, 0, 'si105_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010334,2010633,'','" . AddSlashes(pg_result($resaco, 0, 'si105_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010334,2010634,'','" . AddSlashes(pg_result($resaco, 0, 'si105_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010334,2010635,'','" . AddSlashes(pg_result($resaco, 0, 'si105_ededucaodereceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010334,2010636,'','" . AddSlashes(pg_result($resaco, 0, 'si105_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010334,2010637,'','" . AddSlashes(pg_result($resaco, 0, 'si105_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010334,2010638,'','" . AddSlashes(pg_result($resaco, 0, 'si105_vlrreceitacont')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010334,2010639,'','" . AddSlashes(pg_result($resaco, 0, 'si105_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010334,2010640,'','" . AddSlashes(pg_result($resaco, 0, 'si105_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010334,2011618,'','" . AddSlashes(pg_result($resaco, 0, 'si105_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si105_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update caixa132020 set ";
    $virgula = "";
    if (trim($this->si105_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si105_sequencial"])) {
      if (trim($this->si105_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si105_sequencial"])) {
        $this->si105_sequencial = "0";
      }
      $sql .= $virgula . " si105_sequencial = $this->si105_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si105_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si105_tiporegistro"])) {
      $sql .= $virgula . " si105_tiporegistro = $this->si105_tiporegistro ";
      $virgula = ",";
      if (trim($this->si105_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si105_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si105_codreduzido) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si105_codreduzido"])) {
      if (trim($this->si105_codreduzido) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si105_codreduzido"])) {
        $this->si105_codreduzido = "0";
      }
      $sql .= $virgula . " si105_codreduzido = $this->si105_codreduzido ";
      $virgula = ",";
    }
    if (trim($this->si105_ededucaodereceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si105_ededucaodereceita"])) {
      if (trim($this->si105_ededucaodereceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si105_ededucaodereceita"])) {
        $this->si105_ededucaodereceita = "0";
      }
      $sql .= $virgula . " si105_ededucaodereceita = $this->si105_ededucaodereceita ";
      $virgula = ",";
    }
    if (trim($this->si105_identificadordeducao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si105_identificadordeducao"])) {
      if (trim($this->si105_identificadordeducao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si105_identificadordeducao"])) {
        $this->si105_identificadordeducao = "0";
      }
      $sql .= $virgula . " si105_identificadordeducao = $this->si105_identificadordeducao ";
      $virgula = ",";
    }
    if (trim($this->si105_naturezareceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si105_naturezareceita"])) {
      if (trim($this->si105_naturezareceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si105_naturezareceita"])) {
        $this->si105_naturezareceita = "0";
      }
      $sql .= $virgula . " si105_naturezareceita = $this->si105_naturezareceita ";
      $virgula = ",";
    }
    if (trim($this->si105_codfontcaixa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si105_codfontcaixa"])) {
      if (trim($this->si105_codfontcaixa) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si105_codfontcaixa"])) {
        $this->si105_codfontcaixa = "0";
      }
      $sql .= $virgula . " si105_codfontcaixa = $this->si105_codfontcaixa ";
      $virgula = ",";
    }
    if (trim($this->si105_vlrreceitacont) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si105_vlrreceitacont"])) {
      if (trim($this->si105_vlrreceitacont) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si105_vlrreceitacont"])) {
        $this->si105_vlrreceitacont = "0";
      }
      $sql .= $virgula . " si105_vlrreceitacont = $this->si105_vlrreceitacont ";
      $virgula = ",";
    }
    if (trim($this->si105_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si105_mes"])) {
      $sql .= $virgula . " si105_mes = $this->si105_mes ";
      $virgula = ",";
      if (trim($this->si105_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si105_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si105_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si105_reg10"])) {
      if (trim($this->si105_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si105_reg10"])) {
        $this->si105_reg10 = "0";
      }
      $sql .= $virgula . " si105_reg10 = $this->si105_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si105_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si105_instit"])) {
      $sql .= $virgula . " si105_instit = $this->si105_instit ";
      $virgula = ",";
      if (trim($this->si105_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si105_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si105_sequencial != null) {
      $sql .= " si105_sequencial = $this->si105_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si105_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010632,'$this->si105_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si105_sequencial"]) || $this->si105_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010334,2010632,'" . AddSlashes(pg_result($resaco, $conresaco, 'si105_sequencial')) . "','$this->si105_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si105_tiporegistro"]) || $this->si105_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010334,2010633,'" . AddSlashes(pg_result($resaco, $conresaco, 'si105_tiporegistro')) . "','$this->si105_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si105_codreduzido"]) || $this->si105_codreduzido != "")
          $resac = db_query("insert into db_acount values($acount,2010334,2010634,'" . AddSlashes(pg_result($resaco, $conresaco, 'si105_codreduzido')) . "','$this->si105_codreduzido'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si105_ededucaodereceita"]) || $this->si105_ededucaodereceita != "")
          $resac = db_query("insert into db_acount values($acount,2010334,2010635,'" . AddSlashes(pg_result($resaco, $conresaco, 'si105_ededucaodereceita')) . "','$this->si105_ededucaodereceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si105_identificadordeducao"]) || $this->si105_identificadordeducao != "")
          $resac = db_query("insert into db_acount values($acount,2010334,2010636,'" . AddSlashes(pg_result($resaco, $conresaco, 'si105_identificadordeducao')) . "','$this->si105_identificadordeducao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si105_naturezareceita"]) || $this->si105_naturezareceita != "")
          $resac = db_query("insert into db_acount values($acount,2010334,2010637,'" . AddSlashes(pg_result($resaco, $conresaco, 'si105_naturezareceita')) . "','$this->si105_naturezareceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si105_vlrreceitacont"]) || $this->si105_vlrreceitacont != "")
          $resac = db_query("insert into db_acount values($acount,2010334,2010638,'" . AddSlashes(pg_result($resaco, $conresaco, 'si105_vlrreceitacont')) . "','$this->si105_vlrreceitacont'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si105_mes"]) || $this->si105_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010334,2010639,'" . AddSlashes(pg_result($resaco, $conresaco, 'si105_mes')) . "','$this->si105_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si105_reg10"]) || $this->si105_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010334,2010640,'" . AddSlashes(pg_result($resaco, $conresaco, 'si105_reg10')) . "','$this->si105_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si105_instit"]) || $this->si105_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010334,2011618,'" . AddSlashes(pg_result($resaco, $conresaco, 'si105_instit')) . "','$this->si105_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "caixa132020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si105_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "caixa132020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si105_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si105_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si105_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si105_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010632,'$si105_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010334,2010632,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si105_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010334,2010633,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si105_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010334,2010634,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si105_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010334,2010635,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si105_ededucaodereceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010334,2010636,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si105_identificadordeducao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010334,2010637,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si105_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010334,2010638,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si105_vlrreceitacont')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010334,2010639,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si105_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010334,2010640,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si105_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010334,2011618,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si105_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from caixa132020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si105_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si105_sequencial = $si105_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "caixa132020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si105_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "caixa132020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si105_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si105_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:caixa132020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si105_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from caixa132020 ";
    $sql .= "      left  join caixa102020  on  caixa102020.si103_sequencial = caixa132020.si105_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si105_sequencial != null) {
        $sql2 .= " where caixa132020.si105_sequencial = $si105_sequencial ";
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
  function sql_query_file($si105_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from caixa132020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si105_sequencial != null) {
        $sql2 .= " where caixa132020.si105_sequencial = $si105_sequencial ";
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
