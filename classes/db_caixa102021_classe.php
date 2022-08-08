<?
//MODULO: sicom
//CLASSE DA ENTIDADE caixa102021
class cl_caixa102021
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
  var $si103_sequencial = 0;
  var $si103_tiporegistro = 0;
  var $si103_codorgao = null;
  var $si103_vlsaldoinicial = 0;
  var $si103_vlsaldofinal = 0;
  var $si103_mes = 0;
  var $si103_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si103_sequencial = int8 = sequencial 
                 si103_tiporegistro = int8 = Tipo do  registro 
                 si103_codorgao = varchar(2) = Código do órgão 
                 si103_vlsaldoinicial = float8 = Valor do saldo no  início do mês 
                 si103_vlsaldofinal = float8 = Valor do Saldo do  Final do Mês 
                 si103_mes = int8 = Mês 
                 si103_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_caixa102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("caixa102021");
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
      $this->si103_sequencial = ($this->si103_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si103_sequencial"] : $this->si103_sequencial);
      $this->si103_tiporegistro = ($this->si103_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si103_tiporegistro"] : $this->si103_tiporegistro);
      $this->si103_codorgao = ($this->si103_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si103_codorgao"] : $this->si103_codorgao);
      $this->si103_vlsaldoinicial = ($this->si103_vlsaldoinicial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si103_vlsaldoinicial"] : $this->si103_vlsaldoinicial);
      $this->si103_vlsaldofinal = ($this->si103_vlsaldofinal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si103_vlsaldofinal"] : $this->si103_vlsaldofinal);
      $this->si103_mes = ($this->si103_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si103_mes"] : $this->si103_mes);
      $this->si103_instit = ($this->si103_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si103_instit"] : $this->si103_instit);
    } else {
      $this->si103_sequencial = ($this->si103_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si103_sequencial"] : $this->si103_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si103_sequencial)
  {
    $this->atualizacampos();
    if ($this->si103_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si103_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si103_vlsaldoinicial == null) {
      $this->si103_vlsaldoinicial = "0";
    }
    if ($this->si103_vlsaldofinal == null) {
      $this->si103_vlsaldofinal = "0";
    }
    if ($this->si103_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si103_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si103_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si103_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si103_sequencial == "" || $si103_sequencial == null) {
      $result = db_query("select nextval('caixa102021_si103_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: caixa102021_si103_sequencial_seq do campo: si103_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si103_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from caixa102021_si103_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si103_sequencial)) {
        $this->erro_sql = " Campo si103_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si103_sequencial = $si103_sequencial;
      }
    }
    if (($this->si103_sequencial == null) || ($this->si103_sequencial == "")) {
      $this->erro_sql = " Campo si103_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into caixa102021(
                                       si103_sequencial 
                                      ,si103_tiporegistro 
                                      ,si103_codorgao 
                                      ,si103_vlsaldoinicial 
                                      ,si103_vlsaldofinal 
                                      ,si103_mes 
                                      ,si103_instit 
                       )
                values (
                                $this->si103_sequencial 
                               ,$this->si103_tiporegistro 
                               ,'$this->si103_codorgao' 
                               ,$this->si103_vlsaldoinicial 
                               ,$this->si103_vlsaldofinal 
                               ,$this->si103_mes 
                               ,$this->si103_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "caixa102021 ($this->si103_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "caixa102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "caixa102021 ($this->si103_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si103_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si103_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010621,'$this->si103_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010332,2010621,'','" . AddSlashes(pg_result($resaco, 0, 'si103_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2010616,'','" . AddSlashes(pg_result($resaco, 0, 'si103_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2010617,'','" . AddSlashes(pg_result($resaco, 0, 'si103_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2010618,'','" . AddSlashes(pg_result($resaco, 0, 'si103_vlsaldoinicial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2010619,'','" . AddSlashes(pg_result($resaco, 0, 'si103_vlsaldofinal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2010620,'','" . AddSlashes(pg_result($resaco, 0, 'si103_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2011616,'','" . AddSlashes(pg_result($resaco, 0, 'si103_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si103_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update caixa102021 set ";
    $virgula = "";
    if (trim($this->si103_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si103_sequencial"])) {
      if (trim($this->si103_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si103_sequencial"])) {
        $this->si103_sequencial = "0";
      }
      $sql .= $virgula . " si103_sequencial = $this->si103_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si103_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si103_tiporegistro"])) {
      $sql .= $virgula . " si103_tiporegistro = $this->si103_tiporegistro ";
      $virgula = ",";
      if (trim($this->si103_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si103_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si103_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si103_codorgao"])) {
      $sql .= $virgula . " si103_codorgao = '$this->si103_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si103_vlsaldoinicial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si103_vlsaldoinicial"])) {
      if (trim($this->si103_vlsaldoinicial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si103_vlsaldoinicial"])) {
        $this->si103_vlsaldoinicial = "0";
      }
      $sql .= $virgula . " si103_vlsaldoinicial = $this->si103_vlsaldoinicial ";
      $virgula = ",";
    }
    if (trim($this->si103_vlsaldofinal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si103_vlsaldofinal"])) {
      if (trim($this->si103_vlsaldofinal) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si103_vlsaldofinal"])) {
        $this->si103_vlsaldofinal = "0";
      }
      $sql .= $virgula . " si103_vlsaldofinal = $this->si103_vlsaldofinal ";
      $virgula = ",";
    }
    if (trim($this->si103_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si103_mes"])) {
      $sql .= $virgula . " si103_mes = $this->si103_mes ";
      $virgula = ",";
      if (trim($this->si103_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si103_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si103_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si103_instit"])) {
      $sql .= $virgula . " si103_instit = $this->si103_instit ";
      $virgula = ",";
      if (trim($this->si103_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si103_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si103_sequencial != null) {
      $sql .= " si103_sequencial = $this->si103_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si103_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010621,'$this->si103_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si103_sequencial"]) || $this->si103_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010621,'" . AddSlashes(pg_result($resaco, $conresaco, 'si103_sequencial')) . "','$this->si103_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si103_tiporegistro"]) || $this->si103_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010616,'" . AddSlashes(pg_result($resaco, $conresaco, 'si103_tiporegistro')) . "','$this->si103_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si103_codorgao"]) || $this->si103_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010617,'" . AddSlashes(pg_result($resaco, $conresaco, 'si103_codorgao')) . "','$this->si103_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si103_vlsaldoinicial"]) || $this->si103_vlsaldoinicial != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010618,'" . AddSlashes(pg_result($resaco, $conresaco, 'si103_vlsaldoinicial')) . "','$this->si103_vlsaldoinicial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si103_vlsaldofinal"]) || $this->si103_vlsaldofinal != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010619,'" . AddSlashes(pg_result($resaco, $conresaco, 'si103_vlsaldofinal')) . "','$this->si103_vlsaldofinal'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si103_mes"]) || $this->si103_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010620,'" . AddSlashes(pg_result($resaco, $conresaco, 'si103_mes')) . "','$this->si103_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si103_instit"]) || $this->si103_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2011616,'" . AddSlashes(pg_result($resaco, $conresaco, 'si103_instit')) . "','$this->si103_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "caixa102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si103_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "caixa102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si103_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si103_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si103_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si103_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010621,'$si103_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010332,2010621,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si103_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2010616,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si103_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2010617,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si103_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2010618,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si103_vlsaldoinicial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2010619,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si103_vlsaldofinal')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2010620,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si103_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2011616,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si103_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from caixa102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si103_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si103_sequencial = $si103_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "caixa102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si103_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "caixa102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si103_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si103_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:caixa102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si103_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from caixa102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si103_sequencial != null) {
        $sql2 .= " where caixa102021.si103_sequencial = $si103_sequencial ";
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
  function sql_query_file($si103_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from caixa102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si103_sequencial != null) {
        $sql2 .= " where caixa102021.si103_sequencial = $si103_sequencial ";
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
