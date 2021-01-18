<?
//MODULO: sicom
//CLASSE DA ENTIDADE pessoa102021
class cl_pessoa102021
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
  var $si12_sequencial = 0;
  var $si12_tiporegistro = 0;
  var $si12_tipodocumento = 0;
  var $si12_nrodocumento = null;
  var $si12_nomerazaosocial = null;
  var $si12_tipocadastro = 0;
  var $si12_justificativaalteracao = null;
  var $si12_mes = 0;
  var $si12_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si12_sequencial = int8 = sequencial 
                 si12_tiporegistro = int8 = Tipo do  registro 
                 si12_tipodocumento = int8 = Tipo do  documento 
                 si12_nrodocumento = varchar(14) = Número do  documento  da pessoa 
                 si12_nomerazaosocial = varchar(120) = razão social 
                 si12_tipocadastro = int8 = Tipo de  Cadastro 
                 si12_justificativaalteracao = varchar(100) = Justificativa  para a  alteração 
                 si12_mes = int8 = Mês 
                 si12_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_pessoa102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("pessoa102021");
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
      $this->si12_sequencial = ($this->si12_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si12_sequencial"] : $this->si12_sequencial);
      $this->si12_tiporegistro = ($this->si12_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si12_tiporegistro"] : $this->si12_tiporegistro);
      $this->si12_tipodocumento = ($this->si12_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si12_tipodocumento"] : $this->si12_tipodocumento);
      $this->si12_nrodocumento = ($this->si12_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si12_nrodocumento"] : $this->si12_nrodocumento);
      $this->si12_nomerazaosocial = ($this->si12_nomerazaosocial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si12_nomerazaosocial"] : $this->si12_nomerazaosocial);
      $this->si12_tipocadastro = ($this->si12_tipocadastro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si12_tipocadastro"] : $this->si12_tipocadastro);
      $this->si12_justificativaalteracao = ($this->si12_justificativaalteracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si12_justificativaalteracao"] : $this->si12_justificativaalteracao);
      $this->si12_mes = ($this->si12_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si12_mes"] : $this->si12_mes);
      $this->si12_instit = ($this->si12_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si12_instit"] : $this->si12_instit);
    } else {
      $this->si12_sequencial = ($this->si12_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si12_sequencial"] : $this->si12_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si12_sequencial)
  {
    $this->atualizacampos();
    if ($this->si12_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si12_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si12_tipodocumento == null) {
      $this->si12_tipodocumento = "0";
    }
    if ($this->si12_tipocadastro == null) {
      $this->si12_tipocadastro = "0";
    }
    if ($this->si12_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si12_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si12_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si12_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si12_sequencial == "" || $si12_sequencial == null) {
      $result = db_query("select nextval('pessoa102021_si12_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: pessoa102021_si12_sequencial_seq do campo: si12_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si12_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from pessoa102021_si12_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si12_sequencial)) {
        $this->erro_sql = " Campo si12_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si12_sequencial = $si12_sequencial;
      }
    }
    if (($this->si12_sequencial == null) || ($this->si12_sequencial == "")) {
      $this->erro_sql = " Campo si12_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into pessoa102021(
                                       si12_sequencial 
                                      ,si12_tiporegistro 
                                      ,si12_tipodocumento 
                                      ,si12_nrodocumento 
                                      ,si12_nomerazaosocial 
                                      ,si12_tipocadastro 
                                      ,si12_justificativaalteracao 
                                      ,si12_mes 
                                      ,si12_instit 
                       )
                values (
                                $this->si12_sequencial 
                               ,$this->si12_tiporegistro 
                               ,$this->si12_tipodocumento 
                               ,'$this->si12_nrodocumento' 
                               ,'$this->si12_nomerazaosocial' 
                               ,$this->si12_tipocadastro 
                               ,'$this->si12_justificativaalteracao' 
                               ,$this->si12_mes 
                               ,$this->si12_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "pessoa102021 ($this->si12_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "pessoa102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "pessoa102021 ($this->si12_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si12_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si12_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009588,'$this->si12_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010240,2009588,'','" . AddSlashes(pg_result($resaco, 0, 'si12_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010240,2009587,'','" . AddSlashes(pg_result($resaco, 0, 'si12_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010240,2009589,'','" . AddSlashes(pg_result($resaco, 0, 'si12_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010240,2009590,'','" . AddSlashes(pg_result($resaco, 0, 'si12_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010240,2009591,'','" . AddSlashes(pg_result($resaco, 0, 'si12_nomerazaosocial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010240,2011298,'','" . AddSlashes(pg_result($resaco, 0, 'si12_tipocadastro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010240,2011299,'','" . AddSlashes(pg_result($resaco, 0, 'si12_justificativaalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010240,2009733,'','" . AddSlashes(pg_result($resaco, 0, 'si12_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010240,2011531,'','" . AddSlashes(pg_result($resaco, 0, 'si12_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si12_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update pessoa102021 set ";
    $virgula = "";
    if (trim($this->si12_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si12_sequencial"])) {
      if (trim($this->si12_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si12_sequencial"])) {
        $this->si12_sequencial = "0";
      }
      $sql .= $virgula . " si12_sequencial = $this->si12_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si12_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si12_tiporegistro"])) {
      $sql .= $virgula . " si12_tiporegistro = $this->si12_tiporegistro ";
      $virgula = ",";
      if (trim($this->si12_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si12_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si12_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si12_tipodocumento"])) {
      if (trim($this->si12_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si12_tipodocumento"])) {
        $this->si12_tipodocumento = "0";
      }
      $sql .= $virgula . " si12_tipodocumento = $this->si12_tipodocumento ";
      $virgula = ",";
    }
    if (trim($this->si12_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si12_nrodocumento"])) {
      $sql .= $virgula . " si12_nrodocumento = '$this->si12_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si12_nomerazaosocial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si12_nomerazaosocial"])) {
      $sql .= $virgula . " si12_nomerazaosocial = '$this->si12_nomerazaosocial' ";
      $virgula = ",";
    }
    if (trim($this->si12_tipocadastro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si12_tipocadastro"])) {
      if (trim($this->si12_tipocadastro) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si12_tipocadastro"])) {
        $this->si12_tipocadastro = "0";
      }
      $sql .= $virgula . " si12_tipocadastro = $this->si12_tipocadastro ";
      $virgula = ",";
    }
    if (trim($this->si12_justificativaalteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si12_justificativaalteracao"])) {
      $sql .= $virgula . " si12_justificativaalteracao = '$this->si12_justificativaalteracao' ";
      $virgula = ",";
    }
    if (trim($this->si12_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si12_mes"])) {
      $sql .= $virgula . " si12_mes = $this->si12_mes ";
      $virgula = ",";
      if (trim($this->si12_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si12_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si12_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si12_instit"])) {
      $sql .= $virgula . " si12_instit = $this->si12_instit ";
      $virgula = ",";
      if (trim($this->si12_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si12_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si12_sequencial != null) {
      $sql .= " si12_sequencial = $this->si12_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si12_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009588,'$this->si12_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si12_sequencial"]) || $this->si12_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010240,2009588,'" . AddSlashes(pg_result($resaco, $conresaco, 'si12_sequencial')) . "','$this->si12_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si12_tiporegistro"]) || $this->si12_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010240,2009587,'" . AddSlashes(pg_result($resaco, $conresaco, 'si12_tiporegistro')) . "','$this->si12_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si12_tipodocumento"]) || $this->si12_tipodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010240,2009589,'" . AddSlashes(pg_result($resaco, $conresaco, 'si12_tipodocumento')) . "','$this->si12_tipodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si12_nrodocumento"]) || $this->si12_nrodocumento != "")
          $resac = db_query("insert into db_acount values($acount,2010240,2009590,'" . AddSlashes(pg_result($resaco, $conresaco, 'si12_nrodocumento')) . "','$this->si12_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si12_nomerazaosocial"]) || $this->si12_nomerazaosocial != "")
          $resac = db_query("insert into db_acount values($acount,2010240,2009591,'" . AddSlashes(pg_result($resaco, $conresaco, 'si12_nomerazaosocial')) . "','$this->si12_nomerazaosocial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si12_tipocadastro"]) || $this->si12_tipocadastro != "")
          $resac = db_query("insert into db_acount values($acount,2010240,2011298,'" . AddSlashes(pg_result($resaco, $conresaco, 'si12_tipocadastro')) . "','$this->si12_tipocadastro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si12_justificativaalteracao"]) || $this->si12_justificativaalteracao != "")
          $resac = db_query("insert into db_acount values($acount,2010240,2011299,'" . AddSlashes(pg_result($resaco, $conresaco, 'si12_justificativaalteracao')) . "','$this->si12_justificativaalteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si12_mes"]) || $this->si12_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010240,2009733,'" . AddSlashes(pg_result($resaco, $conresaco, 'si12_mes')) . "','$this->si12_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si12_instit"]) || $this->si12_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010240,2011531,'" . AddSlashes(pg_result($resaco, $conresaco, 'si12_instit')) . "','$this->si12_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "pessoa102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si12_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "pessoa102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si12_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si12_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si12_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si12_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009588,'$si12_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010240,2009588,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si12_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010240,2009587,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si12_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010240,2009589,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si12_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010240,2009590,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si12_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010240,2009591,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si12_nomerazaosocial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010240,2011298,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si12_tipocadastro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010240,2011299,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si12_justificativaalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010240,2009733,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si12_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010240,2011531,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si12_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from pessoa102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si12_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si12_sequencial = $si12_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "pessoa102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si12_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "pessoa102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si12_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si12_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:pessoa102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si12_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from pessoa102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si12_sequencial != null) {
        $sql2 .= " where pessoa102021.si12_sequencial = $si12_sequencial ";
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
  function sql_query_file($si12_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from pessoa102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si12_sequencial != null) {
        $sql2 .= " where pessoa102021.si12_sequencial = $si12_sequencial ";
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
