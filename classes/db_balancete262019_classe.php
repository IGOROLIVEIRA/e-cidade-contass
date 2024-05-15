<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete262019
class cl_balancete262019
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
  var $si196_sequencial = 0;
  var $si196_tiporegistro = 0;
  var $si196_contacontabil = 0;
  var $si196_codfundo = null;
  var $si196_tipodocumentopessoaatributosf = 0;
  var $si196_nrodocumentopessoaatributosf = null;
  var $si196_atributosf = null;
  var $si196_saldoinicialpessoaatributosf = 0;
  var $si196_naturezasaldoinicialpessoaatributosf = null;
  var $si196_totaldebitospessoaatributosf = 0;
  var $si196_totalcreditospessoaatributosf = 0;
  var $si196_saldofinalpessoaatributosf = 0;
  var $si196_naturezasaldofinalpessoaatributosf = null;
  var $si196_mes = 0;
  var $si196_instit = 0;
  var $si196_reg10 = null;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si196_sequencial = int8 = si196_sequencial
                 si196_tiporegistro = int8 = si196_tiporegistro
                 si196_contacontabil = int8 = si196_contacontabil
                 si196_codfundo = varchar(8) = si196_codfundo
                 si196_tipodocumentopessoaatributosf = int8 = si196_tipodocumentopessoaatributosf
                 si196_nrodocumentopessoaatributosf = varchar(14) = si196_nrodocumentopessoaatributosf
                 si196_atributosf = varchar(1) = si196_atributosf
                 si196_saldoinicialpessoaatributosf = float8 = si196_saldoinicialpessoaatributosf
                 si196_naturezasaldoinicialpessoaatributosf = varchar(1) = si196_naturezasaldoinicialpessoaatributosf
                 si196_totaldebitospessoaatributosf = float8 = si196_totaldebitospessoaatributosf
                 si196_totalcreditospessoaatributosf = float8 = si196_totalcreditospessoaatributosf
                 si196_saldofinalpessoaatributosf = float8 = si196_saldofinalpessoaatributosf
                 si196_naturezasaldofinalpessoaatributosf = varchar(1) = si196_naturezasaldofinalpessoaatributosf
                 si196_mes = int8 = si196_mes
                 si196_instit = int8 = si196_instit
                 ";

  //funcao construtor da classe
  function cl_balancete262019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete262019");
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
      $this->si196_sequencial = ($this->si196_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_sequencial"] : $this->si196_sequencial);
      $this->si196_tiporegistro = ($this->si196_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_tiporegistro"] : $this->si196_tiporegistro);
      $this->si196_contacontabil = ($this->si196_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_contacontabil"] : $this->si196_contacontabil);
      $this->si196_codfundo = ($this->si196_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_codfundo"] : $this->si196_codfundo);
      $this->si196_tipodocumentopessoaatributosf = ($this->si196_tipodocumentopessoaatributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_tipodocumentopessoaatributosf"] : $this->si196_tipodocumentopessoaatributosf);
      $this->si196_nrodocumentopessoaatributosf = ($this->si196_nrodocumentopessoaatributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_nrodocumentopessoaatributosf"] : $this->si196_nrodocumentopessoaatributosf);
      $this->si196_atributosf = ($this->si196_atributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_atributosf"] : $this->si196_atributosf);
      $this->si196_saldoinicialpessoaatributosf = ($this->si196_saldoinicialpessoaatributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_saldoinicialpessoaatributosf"] : $this->si196_saldoinicialpessoaatributosf);
      $this->si196_naturezasaldoinicialpessoaatributosf = ($this->si196_naturezasaldoinicialpessoaatributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_naturezasaldoinicialpessoaatributosf"] : $this->si196_naturezasaldoinicialpessoaatributosf);
      $this->si196_totaldebitospessoaatributosf = ($this->si196_totaldebitospessoaatributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_totaldebitospessoaatributosf"] : $this->si196_totaldebitospessoaatributosf);
      $this->si196_totalcreditospessoaatributosf = ($this->si196_totalcreditospessoaatributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_totalcreditospessoaatributosf"] : $this->si196_totalcreditospessoaatributosf);
      $this->si196_saldofinalpessoaatributosf = ($this->si196_saldofinalpessoaatributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_saldofinalpessoaatributosf"] : $this->si196_saldofinalpessoaatributosf);
      $this->si196_naturezasaldofinalpessoaatributosf = ($this->si196_naturezasaldofinalpessoaatributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_naturezasaldofinalpessoaatributosf"] : $this->si196_naturezasaldofinalpessoaatributosf);
      $this->si196_mes = ($this->si196_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_mes"] : $this->si196_mes);
      $this->si196_instit = ($this->si196_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_instit"] : $this->si196_instit);
    } else {
      $this->si196_sequencial = ($this->si196_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si196_sequencial"] : $this->si196_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si196_sequencial)
  {
    $this->atualizacampos();
    if ($this->si196_tiporegistro == null) {
      $this->erro_sql = " Campo si196_tiporegistro não informado.";
      $this->erro_campo = "si196_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si196_contacontabil == null) {
      $this->erro_sql = " Campo si196_contacontabil não informado.";
      $this->erro_campo = "si196_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si196_tipodocumentopessoaatributosf == null) {
      $this->erro_sql = " Campo si196_tipodocumentopessoaatributosf não informado.";
      $this->erro_campo = "si196_tipodocumentopessoaatributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si196_nrodocumentopessoaatributosf == null) {
      $this->erro_sql = " Campo si196_nrodocumentopessoaatributosf não informado.";
      $this->erro_campo = "si196_nrodocumentopessoaatributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if ($this->si196_atributosf == null) {
      $this->erro_sql = " Campo si196_atributosf não informado.";
      $this->erro_campo = "si196_atributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if ($this->si196_saldoinicialpessoaatributosf == null) {
      $this->erro_sql = " Campo si196_saldoinicialpessoaatributosf não informado.";
      $this->erro_campo = "si196_saldoinicialpessoaatributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si196_naturezasaldoinicialpessoaatributosf == null) {
      $this->erro_sql = " Campo si196_naturezasaldoinicialpessoaatributosf não informado.";
      $this->erro_campo = "si196_naturezasaldoinicialpessoaatributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si196_totaldebitospessoaatributosf == null) {
      $this->erro_sql = " Campo si196_totaldebitospessoaatributosf não informado.";
      $this->erro_campo = "si196_totaldebitospessoaatributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si196_totalcreditospessoaatributosf == null) {
      $this->erro_sql = " Campo si196_totalcreditospessoaatributosf não informado.";
      $this->erro_campo = "si196_totalcreditospessoaatributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si196_saldofinalpessoaatributosf == null) {
      $this->erro_sql = " Campo si196_saldofinalpessoaatributosf não informado.";
      $this->erro_campo = "si196_saldofinalpessoaatributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si196_naturezasaldofinalpessoaatributosf == null) {
      $this->erro_sql = " Campo si196_naturezasaldofinalpessoaatributosf não informado.";
      $this->erro_campo = "si196_naturezasaldofinalpessoaatributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si196_mes == null) {
      $this->erro_sql = " Campo si196_mes não informado.";
      $this->erro_campo = "si196_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si196_instit == null) {
      $this->erro_sql = " Campo si196_instit não informado.";
      $this->erro_campo = "si196_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if ($si196_sequencial == "" || $si196_sequencial == null) {
      $result = db_query("select nextval('balancete262019_si196_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete262019_si196_sequencial_seq do campo: si196_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si196_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete262019_si196_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si196_sequencial)) {
        $this->erro_sql = " Campo si196_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si196_sequencial = $si196_sequencial;
      }
    }
    if (($this->si196_sequencial == null) || ($this->si196_sequencial == "")) {
      $this->erro_sql = " Campo si196_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into balancete262019(
                                       si196_sequencial
                                      ,si196_tiporegistro
                                      ,si196_contacontabil
                                      ,si196_codfundo
                                      ,si196_tipodocumentopessoaatributosf
                                      ,si196_nrodocumentopessoaatributosf
                                      ,si196_atributosf
                                      ,si196_saldoinicialpessoaatributosf
                                      ,si196_naturezasaldoinicialpessoaatributosf
                                      ,si196_totaldebitospessoaatributosf
                                      ,si196_totalcreditospessoaatributosf
                                      ,si196_saldofinalpessoaatributosf
                                      ,si196_naturezasaldofinalpessoaatributosf
                                      ,si196_mes
                                      ,si196_instit
                                      ,si196_reg10
                       )
                values (
                                $this->si196_sequencial
                               ,$this->si196_tiporegistro
                               ,$this->si196_contacontabil
                               ,'$this->si196_codfundo'
                               ,$this->si196_tipodocumentopessoaatributosf
                               ,'$this->si196_nrodocumentopessoaatributosf'
                               ,'$this->si196_atributosf'
                               ,$this->si196_saldoinicialpessoaatributosf
                               ,'$this->si196_naturezasaldoinicialpessoaatributosf'
                               ,$this->si196_totaldebitospessoaatributosf
                               ,$this->si196_totalcreditospessoaatributosf
                               ,$this->si196_saldofinalpessoaatributosf
                               ,'$this->si196_naturezasaldofinalpessoaatributosf'
                               ,$this->si196_mes
                               ,$this->si196_instit
                               ,$this->si196_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete262019 ($this->si196_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete262019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete262019 ($this->si196_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si196_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->si196_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {

        /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,2011784,'$this->si196_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010197,2011784,'','".AddSlashes(pg_result($resaco,0,'si196_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011785,'','".AddSlashes(pg_result($resaco,0,'si196_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011786,'','".AddSlashes(pg_result($resaco,0,'si196_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011787,'','".AddSlashes(pg_result($resaco,0,'si196_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011788,'','".AddSlashes(pg_result($resaco,0,'si196_saldoinicialpessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011789,'','".AddSlashes(pg_result($resaco,0,'si196_naturezasaldoinicialpessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011790,'','".AddSlashes(pg_result($resaco,0,'si196_totaldebitospessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011791,'','".AddSlashes(pg_result($resaco,0,'si196_totalcreditospessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011792,'','".AddSlashes(pg_result($resaco,0,'si196_saldofinalpessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011793,'','".AddSlashes(pg_result($resaco,0,'si196_naturezasaldofinalpessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011794,'','".AddSlashes(pg_result($resaco,0,'si196_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011795,'','".AddSlashes(pg_result($resaco,0,'si196_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si196_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete262019 set ";
    $virgula = "";
    if (trim($this->si196_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_sequencial"])) {
      $sql .= $virgula . " si196_sequencial = $this->si196_sequencial ";
      $virgula = ",";
      if (trim($this->si196_sequencial) == null) {
        $this->erro_sql = " Campo si196_sequencial não informado.";
        $this->erro_campo = "si196_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_tiporegistro"])) {
      $sql .= $virgula . " si196_tiporegistro = $this->si196_tiporegistro ";
      $virgula = ",";
      if (trim($this->si196_tiporegistro) == null) {
        $this->erro_sql = " Campo si196_tiporegistro não informado.";
        $this->erro_campo = "si196_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_contacontabil"])) {
      $sql .= $virgula . " si196_contacontabil = $this->si196_contacontabil ";
      $virgula = ",";
      if (trim($this->si196_contacontabil) == null) {
        $this->erro_sql = " Campo si196_contacontabil não informado.";
        $this->erro_campo = "si196_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_codfundo"])) {
      $sql .= $virgula . " si196_codfundo = '$this->si196_codfundo' ";
      $virgula = ",";
      if (trim($this->si196_codfundo) == null) {
        $this->erro_sql = " Campo si196_codfundo não informado.";
        $this->erro_campo = "si196_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_tipodocumentopessoaatributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_tipodocumentopessoaatributosf"])) {
      $sql .= $virgula . " si196_tipodocumentopessoaatributosf = $this->si196_tipodocumentopessoaatributosf ";
      $virgula = ",";
      if (trim($this->si196_tipodocumentopessoaatributosf) == null) {
        $this->erro_sql = " Campo si196_tipodocumentopessoaatributosf não informado.";
        $this->erro_campo = "si196_tipodocumentopessoaatributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_nrodocumentopessoaatributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_nrodocumentopessoaatributosf"])) {
      $sql .= $virgula . " si196_nrodocumentopessoaatributosf = '$this->si196_nrodocumentopessoaatributosf' ";
      $virgula = ",";
      if (trim($this->si196_nrodocumentopessoaatributosf) == null) {
        $this->erro_sql = " Campo si196_nrodocumentopessoaatributosf não informado.";
        $this->erro_campo = "si196_nrodocumentopessoaatributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_atributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_atributosf"])) {
      $sql .= $virgula . " si196_atributosf = '$this->si196_atributosf' ";
      $virgula = ",";
      if (trim($this->si196_atributosf) == null) {
        $this->erro_sql = " Campo si196_atributosf não informado.";
        $this->erro_campo = "si196_atributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_saldoinicialpessoaatributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_saldoinicialpessoaatributosf"])) {
      $sql .= $virgula . " si196_saldoinicialpessoaatributosf = $this->si196_saldoinicialpessoaatributosf ";
      $virgula = ",";
      if (trim($this->si196_saldoinicialpessoaatributosf) == null) {
        $this->erro_sql = " Campo si196_saldoinicialpessoaatributosf não informado.";
        $this->erro_campo = "si196_saldoinicialpessoaatributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_naturezasaldoinicialpessoaatributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_naturezasaldoinicialpessoaatributosf"])) {
      $sql .= $virgula . " si196_naturezasaldoinicialpessoaatributosf = '$this->si196_naturezasaldoinicialpessoaatributosf' ";
      $virgula = ",";
      if (trim($this->si196_naturezasaldoinicialpessoaatributosf) == null) {
        $this->erro_sql = " Campo si196_naturezasaldoinicialpessoaatributosf não informado.";
        $this->erro_campo = "si196_naturezasaldoinicialpessoaatributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_totaldebitospessoaatributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_totaldebitospessoaatributosf"])) {
      $sql .= $virgula . " si196_totaldebitospessoaatributosf = $this->si196_totaldebitospessoaatributosf ";
      $virgula = ",";
      if (trim($this->si196_totaldebitospessoaatributosf) == null) {
        $this->erro_sql = " Campo si196_totaldebitospessoaatributosf não informado.";
        $this->erro_campo = "si196_totaldebitospessoaatributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_totalcreditospessoaatributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_totalcreditospessoaatributosf"])) {
      $sql .= $virgula . " si196_totalcreditospessoaatributosf = $this->si196_totalcreditospessoaatributosf ";
      $virgula = ",";
      if (trim($this->si196_totalcreditospessoaatributosf) == null) {
        $this->erro_sql = " Campo si196_totalcreditospessoaatributosf não informado.";
        $this->erro_campo = "si196_totalcreditospessoaatributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_saldofinalpessoaatributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_saldofinalpessoaatributosf"])) {
      $sql .= $virgula . " si196_saldofinalpessoaatributosf = $this->si196_saldofinalpessoaatributosf ";
      $virgula = ",";
      if (trim($this->si196_saldofinalpessoaatributosf) == null) {
        $this->erro_sql = " Campo si196_saldofinalpessoaatributosf não informado.";
        $this->erro_campo = "si196_saldofinalpessoaatributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_naturezasaldofinalpessoaatributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_naturezasaldofinalpessoaatributosf"])) {
      $sql .= $virgula . " si196_naturezasaldofinalpessoaatributosf = '$this->si196_naturezasaldofinalpessoaatributosf' ";
      $virgula = ",";
      if (trim($this->si196_naturezasaldofinalpessoaatributosf) == null) {
        $this->erro_sql = " Campo si196_naturezasaldofinalpessoaatributosf não informado.";
        $this->erro_campo = "si196_naturezasaldofinalpessoaatributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_mes"])) {
      $sql .= $virgula . " si196_mes = $this->si196_mes ";
      $virgula = ",";
      if (trim($this->si196_mes) == null) {
        $this->erro_sql = " Campo si196_mes não informado.";
        $this->erro_campo = "si196_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si196_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si196_instit"])) {
      $sql .= $virgula . " si196_instit = $this->si196_instit ";
      $virgula = ",";
      if (trim($this->si196_instit) == null) {
        $this->erro_sql = " Campo si196_instit não informado.";
        $this->erro_campo = "si196_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si196_sequencial != null) {
      $sql .= " si196_sequencial = $this->si196_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {

      $resaco = $this->sql_record($this->sql_query_file($this->si196_sequencial));
      if ($this->numrows > 0) {

        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {

          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,2011784,'$this->si196_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_sequencial"]) || $this->si196_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011784,'".AddSlashes(pg_result($resaco,$conresaco,'si196_sequencial'))."','$this->si196_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_tiporegistro"]) || $this->si196_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011785,'".AddSlashes(pg_result($resaco,$conresaco,'si196_tiporegistro'))."','$this->si196_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_contacontabil"]) || $this->si196_contacontabil != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011786,'".AddSlashes(pg_result($resaco,$conresaco,'si196_contacontabil'))."','$this->si196_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_atributosf"]) || $this->si196_atributosf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011787,'".AddSlashes(pg_result($resaco,$conresaco,'si196_atributosf'))."','$this->si196_atributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_saldoinicialpessoaatributosf"]) || $this->si196_saldoinicialpessoaatributosf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011788,'".AddSlashes(pg_result($resaco,$conresaco,'si196_saldoinicialpessoaatributosf'))."','$this->si196_saldoinicialpessoaatributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_naturezasaldoinicialpessoaatributosf"]) || $this->si196_naturezasaldoinicialpessoaatributosf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011789,'".AddSlashes(pg_result($resaco,$conresaco,'si196_naturezasaldoinicialpessoaatributosf'))."','$this->si196_naturezasaldoinicialpessoaatributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_totaldebitospessoaatributosf"]) || $this->si196_totaldebitospessoaatributosf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011790,'".AddSlashes(pg_result($resaco,$conresaco,'si196_totaldebitospessoaatributosf'))."','$this->si196_totaldebitospessoaatributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_totalcreditospessoaatributosf"]) || $this->si196_totalcreditospessoaatributosf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011791,'".AddSlashes(pg_result($resaco,$conresaco,'si196_totalcreditospessoaatributosf'))."','$this->si196_totalcreditospessoaatributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_saldofinalpessoaatributosf"]) || $this->si196_saldofinalpessoaatributosf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011792,'".AddSlashes(pg_result($resaco,$conresaco,'si196_saldofinalpessoaatributosf'))."','$this->si196_saldofinalpessoaatributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_naturezasaldofinalpessoaatributosf"]) || $this->si196_naturezasaldofinalpessoaatributosf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011793,'".AddSlashes(pg_result($resaco,$conresaco,'si196_naturezasaldofinalpessoaatributosf'))."','$this->si196_naturezasaldofinalpessoaatributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_mes"]) || $this->si196_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011794,'".AddSlashes(pg_result($resaco,$conresaco,'si196_mes'))."','$this->si196_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si196_instit"]) || $this->si196_instit != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011795,'".AddSlashes(pg_result($resaco,$conresaco,'si196_instit'))."','$this->si196_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete262019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si196_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete262019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si196_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si196_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si196_sequencial = null, $dbwhere = null)
  {

    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {

      if ($dbwhere == null || $dbwhere == "") {

        $resaco = $this->sql_record($this->sql_query_file($si196_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {

        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,2011784,'$si196_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011784,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011785,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011786,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011787,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011788,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_saldoinicialpessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011789,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_naturezasaldoinicialpessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011790,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_totaldebitospessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011791,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_totalcreditospessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011792,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_saldofinalpessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011793,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_naturezasaldofinalpessoaatributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011794,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011795,'','".AddSlashes(pg_result($resaco,$iresaco,'si196_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from balancete262019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si196_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si196_sequencial = $si196_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete262019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si196_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete262019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si196_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si196_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete262019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si196_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete262019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si196_sequencial != null) {
        $sql2 .= " where balancete262019.si196_sequencial = $si196_sequencial ";
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
  function sql_query_file($si196_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete262019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si196_sequencial != null) {
        $sql2 .= " where balancete262019.si196_sequencial = $si196_sequencial ";
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
