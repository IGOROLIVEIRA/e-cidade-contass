<?
//MODULO: sicom
//CLASSE DA ENTIDADE ddc402017
class cl_ddc402017
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
  var $si178_sequencial = 0;
  var $si178_tiporegistro = 0;
  var $si178_codorgao = 0;
  var $si178_passivoatuarial = 0;
  var $si178_vlsaldoanterior = 0;
  var $si178_vlsaldoatual = 0;
  var $si178_mes = 0;
  var $si178_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si178_sequencial = int8 = Campo Sequencial 
                 si178_tiporegistro = int8 = tipo registro 
                 si178_codorgao = varchar(2) = cod orgao
                 si178_passivoatuarial = int8 = passivoatuarial 
                 si178_vlsaldoanterior = float8 = vlsaldoanterior 
                 si178_vlsaldoatual = float8 = vlSaldoAtual 
                 si178_mes = int8 = mes 
                 si178_instit = int8 = instituicao 
                 ";

  //funcao construtor da classe
  function cl_ddc402017()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ddc402017");
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
      $this->si178_sequencial = ($this->si178_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_sequencial"] : $this->si178_sequencial);
      $this->si178_tiporegistro = ($this->si178_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_tiporegistro"] : $this->si178_tiporegistro);
      $this->si178_codorgao = ($this->si178_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_codorgao"] : $this->si178_codorgao);
      $this->si178_passivoatuarial = ($this->si178_passivoatuarial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_passivoatuarial"] : $this->si178_passivoatuarial);
      $this->si178_vlsaldoanterior = ($this->si178_vlsaldoanterior == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_vlsaldoanterior"] : $this->si178_vlsaldoanterior);
      $this->si178_vlsaldoatual = ($this->si178_vlsaldoatual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_vlsaldoatual"] : $this->si178_vlsaldoatual);
      $this->si178_mes = ($this->si178_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_mes"] : $this->si178_mes);
      $this->si178_instit = ($this->si178_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_instit"] : $this->si178_instit);
    } else {
      $this->si178_sequencial = ($this->si178_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_sequencial"] : $this->si178_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si178_sequencial)
  {
    $this->atualizacampos();
    if ($this->si178_tiporegistro == null) {
      $this->erro_sql = " Campo tipo registro não informado.";
      $this->erro_campo = "si178_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si178_codorgao == null) {
      $this->erro_sql = " Campo cod orgao não informado.";
      $this->erro_campo = "si178_codorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si178_passivoatuarial == null) {
      $this->erro_sql = " Campo passivoatuarial não informado.";
      $this->erro_campo = "si178_passivoatuarial";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si178_vlsaldoanterior == null) {
      $this->erro_sql = " Campo vlsaldoanterior não informado.";
      $this->erro_campo = "si178_vlsaldoanterior";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si178_vlsaldoatual == null) {
      $this->erro_sql = " Campo vlSaldoAtual não informado.";
      $this->erro_campo = "si178_vlsaldoatual";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si178_mes == null) {
      $this->erro_sql = " Campo mes não informado.";
      $this->erro_campo = "si178_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si178_instit == null) {
      $this->erro_sql = " Campo instituicao não informado.";
      $this->erro_campo = "si178_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si178_sequencial == "" || $si178_sequencial == null) {
      $result = db_query("select nextval('ddc402017_si178_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ddc402017_si178_sequencial_seq do campo: si178_sequencial";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si178_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ddc402017_si178_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si178_sequencial)) {
        $this->erro_sql = " Campo si178_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si178_sequencial = $si178_sequencial;
      }
    }
    if (($this->si178_sequencial == null) || ($this->si178_sequencial == "")) {
      $this->erro_sql = " Campo si178_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into ddc402017(
                                       si178_sequencial 
                                      ,si178_tiporegistro 
                                      ,si178_codorgao 
                                      ,si178_passivoatuarial 
                                      ,si178_vlsaldoanterior 
                                      ,si178_vlsaldoatual 
                                      ,si178_mes 
                                      ,si178_instit 
                       )
                values (
                                $this->si178_sequencial 
                               ,$this->si178_tiporegistro 
                               ,$this->si178_codorgao 
                               ,$this->si178_passivoatuarial 
                               ,$this->si178_vlsaldoanterior 
                               ,$this->si178_vlsaldoatual 
                               ,$this->si178_mes 
                               ,$this->si178_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ddc402017 ($this->si178_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "ddc402017 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql = "ddc402017 ($this->si178_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->si178_sequencial;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
        && ($lSessaoDesativarAccount === false))
    ) {

      $resaco = $this->sql_record($this->sql_query_file($this->si178_sequencial));
      /*if(($resaco!=false)||($this->numrows!=0)){

        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,1009343,'$this->si178_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010201,1009343,'','".AddSlashes(pg_result($resaco,0,'si178_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,1009338,'','".AddSlashes(pg_result($resaco,0,'si178_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,1009339,'','".AddSlashes(pg_result($resaco,0,'si178_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,1009340,'','".AddSlashes(pg_result($resaco,0,'si178_passivoatuarial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,1009341,'','".AddSlashes(pg_result($resaco,0,'si178_vlsaldoanterior'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,1009342,'','".AddSlashes(pg_result($resaco,0,'si178_vlsaldoatual'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,1009344,'','".AddSlashes(pg_result($resaco,0,'si178_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,1009345,'','".AddSlashes(pg_result($resaco,0,'si178_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
      }*/
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si178_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ddc402017 set ";
    $virgula = "";
    if (trim($this->si178_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_sequencial"])) {
      $sql .= $virgula . " si178_sequencial = $this->si178_sequencial ";
      $virgula = ",";
      if (trim($this->si178_sequencial) == null) {
        $this->erro_sql = " Campo Campo Sequencial não informado.";
        $this->erro_campo = "si178_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si178_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_tiporegistro"])) {
      $sql .= $virgula . " si178_tiporegistro = $this->si178_tiporegistro ";
      $virgula = ",";
      if (trim($this->si178_tiporegistro) == null) {
        $this->erro_sql = " Campo tipo registro não informado.";
        $this->erro_campo = "si178_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si178_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_codorgao"])) {
      $sql .= $virgula . " si178_codorgao = $this->si178_codorgao ";
      $virgula = ",";
      if (trim($this->si178_codorgao) == null) {
        $this->erro_sql = " Campo cod orgao não informado.";
        $this->erro_campo = "si178_codorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si178_passivoatuarial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_passivoatuarial"])) {
      $sql .= $virgula . " si178_passivoatuarial = $this->si178_passivoatuarial ";
      $virgula = ",";
      if (trim($this->si178_passivoatuarial) == null) {
        $this->erro_sql = " Campo passivoatuarial não informado.";
        $this->erro_campo = "si178_passivoatuarial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si178_vlsaldoanterior) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_vlsaldoanterior"])) {
      $sql .= $virgula . " si178_vlsaldoanterior = $this->si178_vlsaldoanterior ";
      $virgula = ",";
      if (trim($this->si178_vlsaldoanterior) == null) {
        $this->erro_sql = " Campo vlsaldoanterior não informado.";
        $this->erro_campo = "si178_vlsaldoanterior";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si178_vlsaldoatual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_vlsaldoatual"])) {
      $sql .= $virgula . " si178_vlsaldoatual = $this->si178_vlsaldoatual ";
      $virgula = ",";
      if (trim($this->si178_vlsaldoatual) == null) {
        $this->erro_sql = " Campo vlSaldoAtual não informado.";
        $this->erro_campo = "si178_vlsaldoatual";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si178_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_mes"])) {
      $sql .= $virgula . " si178_mes = $this->si178_mes ";
      $virgula = ",";
      if (trim($this->si178_mes) == null) {
        $this->erro_sql = " Campo mes não informado.";
        $this->erro_campo = "si178_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si178_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_instit"])) {
      $sql .= $virgula . " si178_instit = $this->si178_instit ";
      $virgula = ",";
      if (trim($this->si178_instit) == null) {
        $this->erro_sql = " Campo instituicao não informado.";
        $this->erro_campo = "si178_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si178_sequencial != null) {
      $sql .= " si178_sequencial = $this->si178_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
        && ($lSessaoDesativarAccount === false))
    ) {

      $resaco = $this->sql_record($this->sql_query_file($this->si178_sequencial));
      if ($this->numrows > 0) {

        /*for($conresaco=0;$conresaco<$this->numrows;$conresaco++){

          $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,1009343,'$this->si178_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si178_sequencial"]) || $this->si178_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010201,1009343,'".AddSlashes(pg_result($resaco,$conresaco,'si178_sequencial'))."','$this->si178_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si178_tiporegistro"]) || $this->si178_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010201,1009338,'".AddSlashes(pg_result($resaco,$conresaco,'si178_tiporegistro'))."','$this->si178_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si178_codorgao"]) || $this->si178_codorgao != "")
            $resac = db_query("insert into db_acount values($acount,1010201,1009339,'".AddSlashes(pg_result($resaco,$conresaco,'si178_codorgao'))."','$this->si178_codorgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si178_passivoatuarial"]) || $this->si178_passivoatuarial != "")
            $resac = db_query("insert into db_acount values($acount,1010201,1009340,'".AddSlashes(pg_result($resaco,$conresaco,'si178_passivoatuarial'))."','$this->si178_passivoatuarial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si178_vlsaldoanterior"]) || $this->si178_vlsaldoanterior != "")
            $resac = db_query("insert into db_acount values($acount,1010201,1009341,'".AddSlashes(pg_result($resaco,$conresaco,'si178_vlsaldoanterior'))."','$this->si178_vlsaldoanterior',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si178_vlsaldoatual"]) || $this->si178_vlsaldoatual != "")
            $resac = db_query("insert into db_acount values($acount,1010201,1009342,'".AddSlashes(pg_result($resaco,$conresaco,'si178_vlsaldoatual'))."','$this->si178_vlsaldoatual',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si178_mes"]) || $this->si178_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010201,1009344,'".AddSlashes(pg_result($resaco,$conresaco,'si178_mes'))."','$this->si178_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si178_instit"]) || $this->si178_instit != "")
            $resac = db_query("insert into db_acount values($acount,1010201,1009345,'".AddSlashes(pg_result($resaco,$conresaco,'si178_instit'))."','$this->si178_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        }*/
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "ddc402017 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->si178_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ddc402017 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->si178_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->si178_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si178_sequencial = null, $dbwhere = null)
  {

    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
        && ($lSessaoDesativarAccount === false))
    ) {

      if ($dbwhere == null || $dbwhere == "") {

        $resaco = $this->sql_record($this->sql_query_file($si178_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {

        /*for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

          $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,1009343,'$si178_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010201,1009343,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,1009338,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,1009339,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_codorgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,1009340,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_passivoatuarial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,1009341,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_vlsaldoanterior'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,1009342,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_vlsaldoatual'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,1009344,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,1009345,'','".AddSlashes(pg_result($resaco,$iresaco,'si178_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        }*/
      }
    }
    $sql = " delete from ddc402017
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si178_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si178_sequencial = $si178_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "ddc402017 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $si178_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ddc402017 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $si178_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $si178_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "Erro ao selecionar os registros.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Record Vazio na Tabela:ddc402017";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si178_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ddc402017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si178_sequencial != null) {
        $sql2 .= " where ddc402017.si178_sequencial = $si178_sequencial ";
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
  function sql_query_file($si178_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ddc402017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si178_sequencial != null) {
        $sql2 .= " where ddc402017.si178_sequencial = $si178_sequencial ";
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
