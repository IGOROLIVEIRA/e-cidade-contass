<?
//MODULO: sicom
//CLASSE DA ENTIDADE parpps102021
class cl_parpps102021
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
  var $si156_sequencial = 0;
  var $si156_tiporegistro = 0;
  var $si156_codorgao = null;
  var $si156_tipoplano = 0;
  var $si156_exercicio = 0;
  var $si156_vlsaldofinanceiroexercicioanterior = 0;
  var $si156_vlreceitaprevidenciariaanterior = 0;
  var $si156_vldespesaprevidenciariaanterior = 0;
  var $si156_mes = 0;
  var $si156_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si156_sequencial = int8 = sequencial
                 si156_tiporegistro = int8 = Tipo do  registro
                 si156_codorgao = varchar(2) = Código do órgão
                 si156_tipoplano = int8 = Tipo do plano
                 si156_exercicio = int8 = Exercício
                 si156_vlsaldofinanceiroexercicioanterior = float8 = Valor do Saldo  financeiro
                 si156_vlreceitaprevidenciariaanterior = float8 = Valor executado da receita
                 si156_vldespesaprevidenciariaanterior = float8 = Valor executado da despesa
                 si156_mes = int8 = Mês
                 si156_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_parpps102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("parpps102021");
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
      $this->si156_sequencial = ($this->si156_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si156_sequencial"] : $this->si156_sequencial);
      $this->si156_tiporegistro = ($this->si156_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si156_tiporegistro"] : $this->si156_tiporegistro);
      $this->si156_codorgao = ($this->si156_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si156_codorgao"] : $this->si156_codorgao);
      $this->si156_tipoplano = ($this->si156_tipoplano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si156_tipoplano"] : $this->si156_tipoplano);
      $this->si156_exercicio = ($this->si156_exercicio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si156_exercicio"] : $this->si156_exercicio);
      $this->si156_vlsaldofinanceiroexercicioanterior = ($this->si156_vlsaldofinanceiroexercicioanterior == "" ? @$GLOBALS["HTTP_POST_VARS"]["si156_vlsaldofinanceiroexercicioanterior"] : $this->si156_vlsaldofinanceiroexercicioanterior);
      $this->si156_vlreceitaprevidenciariaanterior = ($this->si156_vlreceitaprevidenciariaanterior == "" ? @$GLOBALS["HTTP_POST_VARS"]["si156_vlreceitaprevidenciariaanterior"] : $this->si156_vlreceitaprevidenciariaanterior);
      $this->si156_vldespesaprevidenciariaanterior = ($this->si156_vldespesaprevidenciariaanterior == "" ? @$GLOBALS["HTTP_POST_VARS"]["si156_vldespesaprevidenciariaanterior"] : $this->si156_vldespesaprevidenciariaanterior);
      $this->si156_mes = ($this->si156_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si156_mes"] : $this->si156_mes);
      $this->si156_instit = ($this->si156_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si156_instit"] : $this->si156_instit);
    } else {
      $this->si156_sequencial = ($this->si156_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si156_sequencial"] : $this->si156_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si156_sequencial)
  {
    $this->atualizacampos();
    if ($this->si156_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si156_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si156_vlsaldofinanceiroexercicioanterior == null) {
      $this->si156_vlsaldofinanceiroexercicioanterior = "0";
    }
    if ($this->si156_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si156_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si156_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si156_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si156_sequencial == "" || $si156_sequencial == null) {
      $result = db_query("select nextval('parpps102021_si156_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: parpps102021_si156_sequencial_seq do campo: si156_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si156_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from parpps102021_si156_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si156_sequencial)) {
        $this->erro_sql = " Campo si156_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si156_sequencial = $si156_sequencial;
      }
    }
    if (($this->si156_sequencial == null) || ($this->si156_sequencial == "")) {
      $this->erro_sql = " Campo si156_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into parpps102021(
                                       si156_sequencial
                                      ,si156_tiporegistro
                                      ,si156_codorgao
                                      ,si156_tipoplano
                                      ,si156_exercicio
                                      ,si156_vlsaldofinanceiroexercicioanterior
                                      ,si156_vlreceitaprevidenciariaanterior
                                      ,si156_vldespesaprevidenciariaanterior
                                      ,si156_mes
                                      ,si156_instit
                       )
                values (
                                $this->si156_sequencial
                               ,$this->si156_tiporegistro
                               ,'$this->si156_codorgao'
                               ,$this->si156_tipoplano
                               ,$this->si156_exercicio
                               ,$this->si156_vlsaldofinanceiroexercicioanterior
                               ,$this->si156_vlreceitaprevidenciariaanterior
                               ,$this->si156_vldespesaprevidenciariaanterior
                               ,$this->si156_mes
                               ,$this->si156_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "parpps102021 ($this->si156_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "parpps102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "parpps102021 ($this->si156_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si156_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si156_sequencial));
    // if (($resaco != false) || ($this->numrows != 0)) {
    //   $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //   $acount = pg_result($resac, 0, 0);
    //   $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
    //   $resac = db_query("insert into db_acountkey values($acount,2011194,'$this->si156_sequencial','I')");
    //   $resac = db_query("insert into db_acount values($acount,2010385,2011194,'','" . AddSlashes(pg_result($resaco, 0, 'si156_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010385,2011195,'','" . AddSlashes(pg_result($resaco, 0, 'si156_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010385,2011374,'','" . AddSlashes(pg_result($resaco, 0, 'si156_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010385,2011196,'','" . AddSlashes(pg_result($resaco, 0, 'si156_vlsaldofinanceiroexercicioanterior')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010385,2011197,'','" . AddSlashes(pg_result($resaco, 0, 'si156_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   $resac = db_query("insert into db_acount values($acount,2010385,2011669,'','" . AddSlashes(pg_result($resaco, 0, 'si156_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    // }

    return true;
  }

  // funcao para alteracao
  function alterar($si156_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update parpps102021 set ";
    $virgula = "";
    if (trim($this->si156_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si156_sequencial"])) {
      if (trim($this->si156_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si156_sequencial"])) {
        $this->si156_sequencial = "0";
      }
      $sql .= $virgula . " si156_sequencial = $this->si156_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si156_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si156_tiporegistro"])) {
      $sql .= $virgula . " si156_tiporegistro = $this->si156_tiporegistro ";
      $virgula = ",";
      if (trim($this->si156_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si156_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si156_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si156_codorgao"])) {
      $sql .= $virgula . " si156_codorgao = '$this->si156_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si156_tipoplano) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si156_tipoplano"])) {
      $sql .= $virgula . " si156_tipoplano = '$this->si156_tipoplano' ";
      $virgula = ",";
    }
    if (trim($this->si156_exercicio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si156_exercicio"])) {
      $sql .= $virgula . " si156_exercicio = '$this->si156_exercicio' ";
      $virgula = ",";
    }
    if (trim($this->si156_vlsaldofinanceiroexercicioanterior) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si156_vlsaldofinanceiroexercicioanterior"])) {
      if (trim($this->si156_vlsaldofinanceiroexercicioanterior) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si156_vlsaldofinanceiroexercicioanterior"])) {
        $this->si156_vlsaldofinanceiroexercicioanterior = "0";
      }
      $sql .= $virgula . " si156_vlsaldofinanceiroexercicioanterior = $this->si156_vlsaldofinanceiroexercicioanterior ";
      $virgula = ",";
    }
    if (trim($this->si156_vlreceitaprevidenciariaanterior) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si156_vlreceitaprevidenciariaanterior"])) {
      if (trim($this->si156_vlreceitaprevidenciariaanterior) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si156_vlreceitaprevidenciariaanterior"])) {
        $this->si156_vlreceitaprevidenciariaanterior = "0";
      }
      $sql .= $virgula . " si156_vlreceitaprevidenciariaanterior = $this->si156_vlreceitaprevidenciariaanterior ";
      $virgula = ",";
    }
    if (trim($this->si156_vldespesaprevidenciariaanterior) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si156_vldespesaprevidenciariaanterior"])) {
      if (trim($this->si156_vldespesaprevidenciariaanterior) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si156_vldespesaprevidenciariaanterior"])) {
        $this->si156_vldespesaprevidenciariaanterior = "0";
      }
      $sql .= $virgula . " si156_vldespesaprevidenciariaanterior = $this->si156_vldespesaprevidenciariaanterior ";
      $virgula = ",";
    }
    if (trim($this->si156_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si156_mes"])) {
      $sql .= $virgula . " si156_mes = $this->si156_mes ";
      $virgula = ",";
      if (trim($this->si156_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si156_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si156_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si156_instit"])) {
      $sql .= $virgula . " si156_instit = $this->si156_instit ";
      $virgula = ",";
      if (trim($this->si156_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si156_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si156_sequencial != null) {
      $sql .= " si156_sequencial = $this->si156_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si156_sequencial));
    // if ($this->numrows > 0) {
    //   for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
    //     $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //     $acount = pg_result($resac, 0, 0);
    //     $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
    //     $resac = db_query("insert into db_acountkey values($acount,2011194,'$this->si156_sequencial','A')");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si156_sequencial"]) || $this->si156_sequencial != "")
    //       $resac = db_query("insert into db_acount values($acount,2010385,2011194,'" . AddSlashes(pg_result($resaco, $conresaco, 'si156_sequencial')) . "','$this->si156_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si156_tiporegistro"]) || $this->si156_tiporegistro != "")
    //       $resac = db_query("insert into db_acount values($acount,2010385,2011195,'" . AddSlashes(pg_result($resaco, $conresaco, 'si156_tiporegistro')) . "','$this->si156_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si156_codorgao"]) || $this->si156_codorgao != "")
    //       $resac = db_query("insert into db_acount values($acount,2010385,2011374,'" . AddSlashes(pg_result($resaco, $conresaco, 'si156_codorgao')) . "','$this->si156_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si156_vlsaldofinanceiroexercicioanterior"]) || $this->si156_vlsaldofinanceiroexercicioanterior != "")
    //       $resac = db_query("insert into db_acount values($acount,2010385,2011196,'" . AddSlashes(pg_result($resaco, $conresaco, 'si156_vlsaldofinanceiroexercicioanterior')) . "','$this->si156_vlsaldofinanceiroexercicioanterior'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si156_mes"]) || $this->si156_mes != "")
    //       $resac = db_query("insert into db_acount values($acount,2010385,2011197,'" . AddSlashes(pg_result($resaco, $conresaco, 'si156_mes')) . "','$this->si156_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     if (isset($GLOBALS["HTTP_POST_VARS"]["si156_instit"]) || $this->si156_instit != "")
    //       $resac = db_query("insert into db_acount values($acount,2010385,2011669,'" . AddSlashes(pg_result($resaco, $conresaco, 'si156_instit')) . "','$this->si156_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   }
    // }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "parpps102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si156_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "parpps102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si156_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si156_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si156_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si156_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    // if (($resaco != false) || ($this->numrows != 0)) {
    //   for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
    //     $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //     $acount = pg_result($resac, 0, 0);
    //     $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
    //     $resac = db_query("insert into db_acountkey values($acount,2011194,'$si156_sequencial','E')");
    //     $resac = db_query("insert into db_acount values($acount,2010385,2011194,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si156_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010385,2011195,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si156_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010385,2011374,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si156_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010385,2011196,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si156_vlsaldofinanceiroexercicioanterior')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010385,2011197,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si156_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //     $resac = db_query("insert into db_acount values($acount,2010385,2011669,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si156_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    //   }
    // }
    $sql = " delete from parpps102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si156_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si156_sequencial = $si156_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "parpps102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si156_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "parpps102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si156_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si156_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:parpps102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si156_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from parpps102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si156_sequencial != null) {
        $sql2 .= " where parpps102021.si156_sequencial = $si156_sequencial ";
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
  function sql_query_file($si156_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from parpps102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si156_sequencial != null) {
        $sql2 .= " where parpps102021.si156_sequencial = $si156_sequencial ";
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
