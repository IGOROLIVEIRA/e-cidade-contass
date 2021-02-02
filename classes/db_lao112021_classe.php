<?
//MODULO: sicom
//CLASSE DA ENTIDADE lao112021
class cl_lao112021
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
  var $si35_sequencial = 0;
  var $si35_tiporegistro = 0;
  var $si35_nroleialteracao = null;
  var $si35_tipoleialteracao = 0;
  var $si35_artigoleialteracao = null;
  var $si35_descricaoartigo = null;
  var $si35_vlautorizadoalteracao = 0;
  var $si35_mes = 0;
  var $si35_reg10 = 0;
  var $si35_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si35_sequencial = int8 = sequencial 
                 si35_tiporegistro = int8 = Tipo do  registro 
                 si35_nroleialteracao = int8 = Número da Lei
                 si35_tipoleialteracao = int8 = Tipo de Lei 
                 si35_artigoleialteracao = varchar(6) = Artigo da Lei 
                 si35_descricaoartigo = varchar(512) = Descrição do artigo 
                 si35_vlautorizadoalteracao = float8 = Valor autorizado 
                 si35_mes = int8 = Mês 
                 si35_reg10 = int8 = reg10 
                 si35_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_lao112021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("lao112021");
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
      $this->si35_sequencial = ($this->si35_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si35_sequencial"] : $this->si35_sequencial);
      $this->si35_tiporegistro = ($this->si35_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si35_tiporegistro"] : $this->si35_tiporegistro);
      $this->si35_nroleialteracao = ($this->si35_nroleialteracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si35_nroleialteracao"] : $this->si35_nroleialteracao);
      $this->si35_tipoleialteracao = ($this->si35_tipoleialteracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si35_tipoleialteracao"] : $this->si35_tipoleialteracao);
      $this->si35_artigoleialteracao = ($this->si35_artigoleialteracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si35_artigoleialteracao"] : $this->si35_artigoleialteracao);
      $this->si35_descricaoartigo = ($this->si35_descricaoartigo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si35_descricaoartigo"] : $this->si35_descricaoartigo);
      $this->si35_vlautorizadoalteracao = ($this->si35_vlautorizadoalteracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si35_vlautorizadoalteracao"] : $this->si35_vlautorizadoalteracao);
      $this->si35_mes = ($this->si35_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si35_mes"] : $this->si35_mes);
      $this->si35_reg10 = ($this->si35_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si35_reg10"] : $this->si35_reg10);
      $this->si35_instit = ($this->si35_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si35_instit"] : $this->si35_instit);
    } else {
      $this->si35_sequencial = ($this->si35_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si35_sequencial"] : $this->si35_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si35_sequencial)
  {
    $this->atualizacampos();
    if ($this->si35_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si35_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si35_tipoleialteracao == null) {
      $this->si35_tipoleialteracao = "0";
    }
    if ($this->si35_vlautorizadoalteracao == null) {
      $this->si35_vlautorizadoalteracao = "0";
    }
    if ($this->si35_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si35_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si35_reg10 == null) {
      $this->si35_reg10 = "0";
    }
    if ($this->si35_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si35_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si35_sequencial == "" || $si35_sequencial == null) {
      $result = db_query("select nextval('lao112021_si35_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: lao112021_si35_sequencial_seq do campo: si35_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si35_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from lao112021_si35_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si35_sequencial)) {
        $this->erro_sql = " Campo si35_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si35_sequencial = $si35_sequencial;
      }
    }
    if (($this->si35_sequencial == null) || ($this->si35_sequencial == "")) {
      $this->erro_sql = " Campo si35_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into lao112021(
                                       si35_sequencial 
                                      ,si35_tiporegistro 
                                      ,si35_nroleialteracao 
                                      ,si35_tipoleialteracao 
                                      ,si35_artigoleialteracao 
                                      ,si35_descricaoartigo 
                                      ,si35_vlautorizadoalteracao 
                                      ,si35_mes 
                                      ,si35_reg10 
                                      ,si35_instit 
                       )
                values (
                                $this->si35_sequencial 
                               ,$this->si35_tiporegistro 
                               ,'$this->si35_nroleialteracao' 
                               ,$this->si35_tipoleialteracao 
                               ,'$this->si35_artigoleialteracao' 
                               ,'$this->si35_descricaoartigo' 
                               ,$this->si35_vlautorizadoalteracao 
                               ,$this->si35_mes 
                               ,$this->si35_reg10 
                               ,$this->si35_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "lao112021 ($this->si35_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "lao112021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "lao112021 ($this->si35_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si35_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si35_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009755,'$this->si35_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010263,2009755,'','" . AddSlashes(pg_result($resaco, 0, 'si35_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010263,2009756,'','" . AddSlashes(pg_result($resaco, 0, 'si35_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010263,2009757,'','" . AddSlashes(pg_result($resaco, 0, 'si35_nroleialteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010263,2009758,'','" . AddSlashes(pg_result($resaco, 0, 'si35_tipoleialteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010263,2009759,'','" . AddSlashes(pg_result($resaco, 0, 'si35_artigoleialteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010263,2009760,'','" . AddSlashes(pg_result($resaco, 0, 'si35_descricaoartigo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010263,2009761,'','" . AddSlashes(pg_result($resaco, 0, 'si35_vlautorizadoalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010263,2009762,'','" . AddSlashes(pg_result($resaco, 0, 'si35_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010263,2009763,'','" . AddSlashes(pg_result($resaco, 0, 'si35_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010263,2011549,'','" . AddSlashes(pg_result($resaco, 0, 'si35_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si35_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update lao112021 set ";
    $virgula = "";
    if (trim($this->si35_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si35_sequencial"])) {
      if (trim($this->si35_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si35_sequencial"])) {
        $this->si35_sequencial = "0";
      }
      $sql .= $virgula . " si35_sequencial = $this->si35_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si35_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si35_tiporegistro"])) {
      $sql .= $virgula . " si35_tiporegistro = $this->si35_tiporegistro ";
      $virgula = ",";
      if (trim($this->si35_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si35_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si35_nroleialteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si35_nroleialteracao"])) {
      $sql .= $virgula . " si35_nroleialteracao = '$this->si35_nroleialteracao' ";
      $virgula = ",";
    }
    if (trim($this->si35_tipoleialteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si35_tipoleialteracao"])) {
      if (trim($this->si35_tipoleialteracao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si35_tipoleialteracao"])) {
        $this->si35_tipoleialteracao = "0";
      }
      $sql .= $virgula . " si35_tipoleialteracao = $this->si35_tipoleialteracao ";
      $virgula = ",";
    }
    if (trim($this->si35_artigoleialteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si35_artigoleialteracao"])) {
      $sql .= $virgula . " si35_artigoleialteracao = '$this->si35_artigoleialteracao' ";
      $virgula = ",";
    }
    if (trim($this->si35_descricaoartigo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si35_descricaoartigo"])) {
      $sql .= $virgula . " si35_descricaoartigo = '$this->si35_descricaoartigo' ";
      $virgula = ",";
    }
    if (trim($this->si35_vlautorizadoalteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si35_vlautorizadoalteracao"])) {
      if (trim($this->si35_vlautorizadoalteracao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si35_vlautorizadoalteracao"])) {
        $this->si35_vlautorizadoalteracao = "0";
      }
      $sql .= $virgula . " si35_vlautorizadoalteracao = $this->si35_vlautorizadoalteracao ";
      $virgula = ",";
    }
    if (trim($this->si35_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si35_mes"])) {
      $sql .= $virgula . " si35_mes = $this->si35_mes ";
      $virgula = ",";
      if (trim($this->si35_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si35_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si35_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si35_reg10"])) {
      if (trim($this->si35_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si35_reg10"])) {
        $this->si35_reg10 = "0";
      }
      $sql .= $virgula . " si35_reg10 = $this->si35_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si35_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si35_instit"])) {
      $sql .= $virgula . " si35_instit = $this->si35_instit ";
      $virgula = ",";
      if (trim($this->si35_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si35_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si35_sequencial != null) {
      $sql .= " si35_sequencial = $this->si35_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si35_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009755,'$this->si35_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si35_sequencial"]) || $this->si35_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010263,2009755,'" . AddSlashes(pg_result($resaco, $conresaco, 'si35_sequencial')) . "','$this->si35_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si35_tiporegistro"]) || $this->si35_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010263,2009756,'" . AddSlashes(pg_result($resaco, $conresaco, 'si35_tiporegistro')) . "','$this->si35_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si35_nroleialteracao"]) || $this->si35_nroleialteracao != "")
          $resac = db_query("insert into db_acount values($acount,2010263,2009757,'" . AddSlashes(pg_result($resaco, $conresaco, 'si35_nroleialteracao')) . "','$this->si35_nroleialteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si35_tipoleialteracao"]) || $this->si35_tipoleialteracao != "")
          $resac = db_query("insert into db_acount values($acount,2010263,2009758,'" . AddSlashes(pg_result($resaco, $conresaco, 'si35_tipoleialteracao')) . "','$this->si35_tipoleialteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si35_artigoleialteracao"]) || $this->si35_artigoleialteracao != "")
          $resac = db_query("insert into db_acount values($acount,2010263,2009759,'" . AddSlashes(pg_result($resaco, $conresaco, 'si35_artigoleialteracao')) . "','$this->si35_artigoleialteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si35_descricaoartigo"]) || $this->si35_descricaoartigo != "")
          $resac = db_query("insert into db_acount values($acount,2010263,2009760,'" . AddSlashes(pg_result($resaco, $conresaco, 'si35_descricaoartigo')) . "','$this->si35_descricaoartigo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si35_vlautorizadoalteracao"]) || $this->si35_vlautorizadoalteracao != "")
          $resac = db_query("insert into db_acount values($acount,2010263,2009761,'" . AddSlashes(pg_result($resaco, $conresaco, 'si35_vlautorizadoalteracao')) . "','$this->si35_vlautorizadoalteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si35_mes"]) || $this->si35_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010263,2009762,'" . AddSlashes(pg_result($resaco, $conresaco, 'si35_mes')) . "','$this->si35_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si35_reg10"]) || $this->si35_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010263,2009763,'" . AddSlashes(pg_result($resaco, $conresaco, 'si35_reg10')) . "','$this->si35_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si35_instit"]) || $this->si35_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010263,2011549,'" . AddSlashes(pg_result($resaco, $conresaco, 'si35_instit')) . "','$this->si35_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "lao112021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si35_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "lao112021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si35_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si35_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si35_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si35_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009755,'$si35_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010263,2009755,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si35_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010263,2009756,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si35_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010263,2009757,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si35_nroleialteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010263,2009758,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si35_tipoleialteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010263,2009759,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si35_artigoleialteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010263,2009760,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si35_descricaoartigo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010263,2009761,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si35_vlautorizadoalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010263,2009762,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si35_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010263,2009763,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si35_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010263,2011549,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si35_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from lao112021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si35_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si35_sequencial = $si35_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "lao112021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si35_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "lao112021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si35_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si35_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:lao112021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si35_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from lao112021 ";
    $sql .= "      left  join lao102020  on  lao102020.si34_sequencial = lao112021.si35_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si35_sequencial != null) {
        $sql2 .= " where lao112021.si35_sequencial = $si35_sequencial ";
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
  function sql_query_file($si35_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from lao112021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si35_sequencial != null) {
        $sql2 .= " where lao112021.si35_sequencial = $si35_sequencial ";
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
