<?
//MODULO: sicom
//CLASSE DA ENTIDADE caixa122018
class cl_caixa122018
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
  var $si104_sequencial = 0;
  var $si104_tiporegistro = 0;
  var $si104_codreduzido = 0;
  var $si104_codfontecaixa = 0;
  var $si104_tipomovimentacao = 0;
  var $si104_tipoentrsaida = null;
  var $si104_descrmovimentacao = null;
  var $si104_valorentrsaida = 0;
  var $si104_codctbtransf = 0;
  var $si104_codfontectbtransf = 0;
  var $si104_mes = 0;
  var $si104_reg10 = 0;
  var $si104_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si104_sequencial = int8 = sequencial 
                 si104_tiporegistro = int8 = Tipo do  registro 
                 si104_codreduzido = int8 = Código Identificador da Movimentação 
                 si104_codfontecaixa = int8 = Código da fonte de recursos
                 si104_tipomovimentacao = int8 = Tipo de  movimentação 
                 si104_tipoentrsaida = varchar(2) = Tipo de entrada ou  saída 
                 si104_descrmovimentacao = varchar(50) = Descrição da  Movimentação 
                 si104_valorentrsaida = float8 = Valor  correspondente entrada ou saída 
                 si104_codctbtransf = int8 = Código Identificador da Conta Bancária 
                 si104_codfontectbtransf = int8 = Código da fonte de recursos ctb 
                 si104_mes = int8 = Mês 
                 si104_reg10 = int8 = reg10 
                 si104_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_caixa122018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("caixa122018");
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
      $this->si104_sequencial = ($this->si104_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_sequencial"] : $this->si104_sequencial);
      $this->si104_tiporegistro = ($this->si104_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_tiporegistro"] : $this->si104_tiporegistro);
      $this->si104_codreduzido = ($this->si104_codreduzido == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_codreduzido"] : $this->si104_codreduzido);
      $this->si104_tipomovimentacao = ($this->si104_tipomovimentacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_tipomovimentacao"] : $this->si104_tipomovimentacao);
      $this->si104_tipoentrsaida = ($this->si104_tipoentrsaida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_tipoentrsaida"] : $this->si104_tipoentrsaida);
      $this->si104_descrmovimentacao = ($this->si104_descrmovimentacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_descrmovimentacao"] : $this->si104_descrmovimentacao);
      $this->si104_valorentrsaida = ($this->si104_valorentrsaida == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_valorentrsaida"] : $this->si104_valorentrsaida);
      $this->si104_codctbtransf = ($this->si104_codctbtransf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_codctbtransf"] : $this->si104_codctbtransf);
      $this->si104_codfontectbtransf = ($this->si104_codfontectbtransf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_codfontectbtransf"] : $this->si104_codfontectbtransf);
      $this->si104_mes = ($this->si104_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_mes"] : $this->si104_mes);
      $this->si104_reg10 = ($this->si104_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_reg10"] : $this->si104_reg10);
      $this->si104_instit = ($this->si104_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_instit"] : $this->si104_instit);
    } else {
      $this->si104_sequencial = ($this->si104_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si104_sequencial"] : $this->si104_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si104_sequencial)
  {
    $this->atualizacampos();
    if ($this->si104_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si104_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si104_codreduzido == null) {
      $this->si104_codreduzido = "0";
    }
    if ($this->si104_codfontecaixa == null) {
      $this->si104_codfontecaixa = "0";
    }
    if ($this->si104_tipomovimentacao == null) {
      $this->si104_tipomovimentacao = "0";
    }
    if ($this->si104_valorentrsaida == null) {
      $this->si104_valorentrsaida = "0";
    }
    if ($this->si104_codctbtransf == null) {
      $this->si104_codctbtransf = "0";
    }
    if ($this->si104_codfontectbtransf == null) {
      $this->si104_codfontectbtransf = "0";
    }
    if ($this->si104_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si104_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si104_reg10 == null) {
      $this->si104_reg10 = "0";
    }
    if ($this->si104_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si104_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si104_sequencial == "" || $si104_sequencial == null) {
      $result = db_query("select nextval('caixa122018_si104_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: caixa122018_si104_sequencial_seq do campo: si104_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si104_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from caixa122018_si104_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si104_sequencial)) {
        $this->erro_sql = " Campo si104_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si104_sequencial = $si104_sequencial;
      }
    }
    if (($this->si104_sequencial == null) || ($this->si104_sequencial == "")) {
      $this->erro_sql = " Campo si104_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into caixa122018(
                                       si104_sequencial 
                                      ,si104_tiporegistro 
                                      ,si104_codreduzido
                                      ,si104_codfontecaixa 
                                      ,si104_tipomovimentacao 
                                      ,si104_tipoentrsaida 
                                      ,si104_descrmovimentacao 
                                      ,si104_valorentrsaida 
                                      ,si104_codctbtransf 
                                      ,si104_codfontectbtransf 
                                      ,si104_mes 
                                      ,si104_reg10 
                                      ,si104_instit 
                       )
                values (
                                $this->si104_sequencial 
                               ,$this->si104_tiporegistro 
                               ,$this->si104_codreduzido 
                               ,$this->si104_codfontecaixa
                               ,$this->si104_tipomovimentacao 
                               ,'$this->si104_tipoentrsaida' 
                               ,'$this->si104_descrmovimentacao' 
                               ,$this->si104_valorentrsaida 
                               ,$this->si104_codctbtransf 
                               ,$this->si104_codfontectbtransf 
                               ,$this->si104_mes 
                               ,$this->si104_reg10 
                               ,$this->si104_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "caixa122018 ($this->si104_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "caixa122018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "caixa122018 ($this->si104_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si104_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si104_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010622,'$this->si104_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010333,2010622,'','" . AddSlashes(pg_result($resaco, 0, 'si104_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010333,2010623,'','" . AddSlashes(pg_result($resaco, 0, 'si104_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010333,2010624,'','" . AddSlashes(pg_result($resaco, 0, 'si104_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010333,2010625,'','" . AddSlashes(pg_result($resaco, 0, 'si104_tipomovimentacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010333,2010626,'','" . AddSlashes(pg_result($resaco, 0, 'si104_tipoentrsaida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010333,2010627,'','" . AddSlashes(pg_result($resaco, 0, 'si104_descrmovimentacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010333,2010628,'','" . AddSlashes(pg_result($resaco, 0, 'si104_valorentrsaida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010333,2010629,'','" . AddSlashes(pg_result($resaco, 0, 'si104_codctbtransf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010333,2011327,'','" . AddSlashes(pg_result($resaco, 0, 'si104_codfontectbtransf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010333,2010630,'','" . AddSlashes(pg_result($resaco, 0, 'si104_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010333,2010631,'','" . AddSlashes(pg_result($resaco, 0, 'si104_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010333,2011617,'','" . AddSlashes(pg_result($resaco, 0, 'si104_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si104_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update caixa122018 set ";
    $virgula = "";
    if (trim($this->si104_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_sequencial"])) {
      if (trim($this->si104_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si104_sequencial"])) {
        $this->si104_sequencial = "0";
      }
      $sql .= $virgula . " si104_sequencial = $this->si104_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si104_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_tiporegistro"])) {
      $sql .= $virgula . " si104_tiporegistro = $this->si104_tiporegistro ";
      $virgula = ",";
      if (trim($this->si104_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si104_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si104_codreduzido) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_codreduzido"])) {
      if (trim($this->si104_codreduzido) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si104_codreduzido"])) {
        $this->si104_codreduzido = "0";
      }
      $sql .= $virgula . " si104_codreduzido = $this->si104_codreduzido ";
      $virgula = ",";
    }
    if (trim($this->si104_codfontecaixa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_codfontecaixa"])) {
      if (trim($this->si104_codfontecaixa) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si104_codfontecaixa"])) {
        $this->si104_codfontecaixa = "0";
      }
      $sql .= $virgula . " si104_codfontecaixa = $this->si104_codfontecaixa ";
      $virgula = ",";
    }
    if (trim($this->si104_tipomovimentacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_tipomovimentacao"])) {
      if (trim($this->si104_tipomovimentacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si104_tipomovimentacao"])) {
        $this->si104_tipomovimentacao = "0";
      }
      $sql .= $virgula . " si104_tipomovimentacao = $this->si104_tipomovimentacao ";
      $virgula = ",";
    }
    if (trim($this->si104_tipoentrsaida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_tipoentrsaida"])) {
      $sql .= $virgula . " si104_tipoentrsaida = '$this->si104_tipoentrsaida' ";
      $virgula = ",";
    }
    if (trim($this->si104_descrmovimentacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_descrmovimentacao"])) {
      $sql .= $virgula . " si104_descrmovimentacao = '$this->si104_descrmovimentacao' ";
      $virgula = ",";
    }
    if (trim($this->si104_valorentrsaida) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_valorentrsaida"])) {
      if (trim($this->si104_valorentrsaida) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si104_valorentrsaida"])) {
        $this->si104_valorentrsaida = "0";
      }
      $sql .= $virgula . " si104_valorentrsaida = $this->si104_valorentrsaida ";
      $virgula = ",";
    }
    if (trim($this->si104_codctbtransf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_codctbtransf"])) {
      if (trim($this->si104_codctbtransf) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si104_codctbtransf"])) {
        $this->si104_codctbtransf = "0";
      }
      $sql .= $virgula . " si104_codctbtransf = $this->si104_codctbtransf ";
      $virgula = ",";
    }
    if (trim($this->si104_codfontectbtransf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_codfontectbtransf"])) {
      if (trim($this->si104_codfontectbtransf) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si104_codfontectbtransf"])) {
        $this->si104_codfontectbtransf = "0";
      }
      $sql .= $virgula . " si104_codfontectbtransf = $this->si104_codfontectbtransf ";
      $virgula = ",";
    }
    if (trim($this->si104_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_mes"])) {
      $sql .= $virgula . " si104_mes = $this->si104_mes ";
      $virgula = ",";
      if (trim($this->si104_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si104_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si104_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_reg10"])) {
      if (trim($this->si104_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si104_reg10"])) {
        $this->si104_reg10 = "0";
      }
      $sql .= $virgula . " si104_reg10 = $this->si104_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si104_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si104_instit"])) {
      $sql .= $virgula . " si104_instit = $this->si104_instit ";
      $virgula = ",";
      if (trim($this->si104_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si104_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si104_sequencial != null) {
      $sql .= " si104_sequencial = $this->si104_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si104_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010622,'$this->si104_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_sequencial"]) || $this->si104_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2010622,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_sequencial')) . "','$this->si104_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_tiporegistro"]) || $this->si104_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2010623,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_tiporegistro')) . "','$this->si104_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_codreduzido"]) || $this->si104_codreduzido != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2010624,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_codreduzido')) . "','$this->si104_codreduzido'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_tipomovimentacao"]) || $this->si104_tipomovimentacao != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2010625,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_tipomovimentacao')) . "','$this->si104_tipomovimentacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_tipoentrsaida"]) || $this->si104_tipoentrsaida != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2010626,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_tipoentrsaida')) . "','$this->si104_tipoentrsaida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_descrmovimentacao"]) || $this->si104_descrmovimentacao != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2010627,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_descrmovimentacao')) . "','$this->si104_descrmovimentacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_valorentrsaida"]) || $this->si104_valorentrsaida != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2010628,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_valorentrsaida')) . "','$this->si104_valorentrsaida'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_codctbtransf"]) || $this->si104_codctbtransf != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2010629,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_codctbtransf')) . "','$this->si104_codctbtransf'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_codfontectbtransf"]) || $this->si104_codfontectbtransf != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2011327,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_codfontectbtransf')) . "','$this->si104_codfontectbtransf'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_mes"]) || $this->si104_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2010630,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_mes')) . "','$this->si104_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_reg10"]) || $this->si104_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2010631,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_reg10')) . "','$this->si104_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si104_instit"]) || $this->si104_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010333,2011617,'" . AddSlashes(pg_result($resaco, $conresaco, 'si104_instit')) . "','$this->si104_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "caixa122018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si104_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "caixa122018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si104_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si104_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si104_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si104_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010622,'$si104_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010333,2010622,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010333,2010623,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010333,2010624,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010333,2010625,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_tipomovimentacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010333,2010626,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_tipoentrsaida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010333,2010627,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_descrmovimentacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010333,2010628,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_valorentrsaida')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010333,2010629,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_codctbtransf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010333,2011327,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_codfontectbtransf')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010333,2010630,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010333,2010631,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010333,2011617,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si104_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from caixa122018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si104_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si104_sequencial = $si104_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "caixa122018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si104_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "caixa122018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si104_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si104_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:caixa122018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si104_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from caixa122018 ";
    $sql .= "      left  join caixa102018  on  caixa102018.si103_sequencial = caixa122018.si104_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si104_sequencial != null) {
        $sql2 .= " where caixa122018.si104_sequencial = $si104_sequencial ";
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
  function sql_query_file($si104_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from caixa122018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si104_sequencial != null) {
        $sql2 .= " where caixa122018.si104_sequencial = $si104_sequencial ";
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
