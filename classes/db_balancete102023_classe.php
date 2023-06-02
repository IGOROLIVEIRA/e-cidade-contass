<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete102023
class cl_balancete102023
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
  var $si177_sequencial = 0;
  var $si177_tiporegistro = 0;
  var $si177_contacontaabil = 0;
  var $si177_codfundo = null;
  var $si177_saldoinicial = 0;
  var $si177_naturezasaldoinicial = null;
  var $si177_totaldebitos = 0;
  var $si177_totalcreditos = 0;
  var $si177_saldofinal = 0;
  var $si177_naturezasaldofinal = null;
  var $si177_mes = 0;
  var $si177_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si177_sequencial = int8 = si177_sequencial
                 si177_tiporegistro = int8 = si177_tiporegistro
                 si177_contacontaabil = int8 = si177_contacontaabil
                 si177_codfundo = varchar(8) = si177_codfundo
                 si177_saldoinicial = float8 = si177_saldoinicial
                 si177_naturezasaldoinicial = varchar(1) = si177_naturezasaldoinicial
                 si177_totaldebitos = float8 = si177_totaldebitos
                 si177_totalcreditos = float8 = si177_totalcreditos
                 si177_saldofinal = float8 = si177_saldofinal
                 si177_naturezasaldofinal = varchar(1) = si177_naturezasaldofinal
                 si177_mes = int8 = si177_mes
                 si177_instit = int8 = si177_instit
                 ";

  //funcao construtor da classe
  function cl_balancete102023()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete102023");
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
      $this->si177_sequencial = ($this->si177_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_sequencial"] : $this->si177_sequencial);
      $this->si177_tiporegistro = ($this->si177_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_tiporegistro"] : $this->si177_tiporegistro);
      $this->si177_contacontaabil = ($this->si177_contacontaabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_contacontaabil"] : $this->si177_contacontaabil);
      $this->si177_codfundo = ($this->si177_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_codfundo"] : $this->si177_codfundo);
      $this->si177_saldoinicial = ($this->si177_saldoinicial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_saldoinicial"] : $this->si177_saldoinicial);
      $this->si177_naturezasaldoinicial = ($this->si177_naturezasaldoinicial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_naturezasaldoinicial"] : $this->si177_naturezasaldoinicial);
      $this->si177_totaldebitos = ($this->si177_totaldebitos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_totaldebitos"] : $this->si177_totaldebitos);
      $this->si177_totalcreditos = ($this->si177_totalcreditos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_totalcreditos"] : $this->si177_totalcreditos);
      $this->si177_saldofinal = ($this->si177_saldofinal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_saldofinal"] : $this->si177_saldofinal);
      $this->si177_naturezasaldofinal = ($this->si177_naturezasaldofinal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_naturezasaldofinal"] : $this->si177_naturezasaldofinal);
      $this->si177_mes = ($this->si177_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_mes"] : $this->si177_mes);
      $this->si177_instit = ($this->si177_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_instit"] : $this->si177_instit);
    } else {
      $this->si177_sequencial = ($this->si177_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_sequencial"] : $this->si177_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si177_sequencial)
  {
    $this->atualizacampos();
    if ($this->si177_tiporegistro == null) {
      $this->erro_sql = " Campo si177_tiporegistro não informado.";
      $this->erro_campo = "si177_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si177_contacontaabil == null) {
      $this->erro_sql = " Campo si177_contacontaabil não informado.";
      $this->erro_campo = "si177_contacontaabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si177_saldoinicial == null) {
      $this->erro_sql = " Campo si177_saldoinicial não informado.";
      $this->erro_campo = "si177_saldoinicial";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si177_naturezasaldoinicial == null) {
      $this->erro_sql = " Campo si177_naturezasaldoinicial não informado.";
      $this->erro_campo = "si177_naturezasaldoinicial";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si177_totaldebitos == null) {
      $this->erro_sql = " Campo si177_totaldebitos não informado.";
      $this->erro_campo = "si177_totaldebitos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si177_totalcreditos == null) {
      $this->erro_sql = " Campo si177_totalcreditos não informado.";
      $this->erro_campo = "si177_totalcreditos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si177_saldofinal == null) {
      $this->erro_sql = " Campo si177_saldofinal não informado.";
      $this->erro_campo = "si177_saldofinal";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si177_naturezasaldofinal == null) {
      $this->erro_sql = " Campo si177_naturezasaldofinal não informado.";
      $this->erro_campo = "si177_naturezasaldofinal";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si177_mes == null) {
      $this->erro_sql = " Campo si177_mes não informado.";
      $this->erro_campo = "si177_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si177_instit == null) {
      $this->erro_sql = " Campo si177_instit não informado.";
      $this->erro_campo = "si177_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si177_sequencial == "" || $si177_sequencial == null) {
      $result = db_query("select nextval('balancete102023_si177_sequencial_seq')");

      if ($result == false) {
        $this->erro_banco = str_replace("", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete102023_si177_sequencial_seq do campo: si177_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si177_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete102023_si177_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si177_sequencial)) {
        $this->erro_sql = " Campo si177_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si177_sequencial = $si177_sequencial;
      }
    }
    if (($this->si177_sequencial == null) || ($this->si177_sequencial == "")) {
      $this->erro_sql = " Campo si177_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into balancete102023(
                                       si177_sequencial
                                      ,si177_tiporegistro
                                      ,si177_contacontaabil
                                      ,si177_codfundo
                                      ,si177_saldoinicial
                                      ,si177_naturezasaldoinicial
                                      ,si177_totaldebitos
                                      ,si177_totalcreditos
                                      ,si177_saldofinal
                                      ,si177_naturezasaldofinal
                                      ,si177_mes
                                      ,si177_instit
                       )
                values (
                                $this->si177_sequencial
                               ,$this->si177_tiporegistro
                               ,$this->si177_contacontaabil
                               ,'$this->si177_codfundo'
                               ,$this->si177_saldoinicial
                               ,'$this->si177_naturezasaldoinicial'
                               ,$this->si177_totaldebitos
                               ,$this->si177_totalcreditos
                               ,$this->si177_saldofinal
                               ,'$this->si177_naturezasaldofinal'
                               ,$this->si177_mes
                               ,$this->si177_instit
                      )";

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete102023 ($this->si177_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete102023 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete102023 ($this->si177_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si177_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);

    return true;
  }

  // funcao para alteracao
  function alterar($si177_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete102023 set ";
    $virgula = "";
    if (trim($this->si177_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_sequencial"])) {
      $sql .= $virgula . " si177_sequencial = $this->si177_sequencial ";
      $virgula = ",";
      if (trim($this->si177_sequencial) == null) {
        $this->erro_sql = " Campo si177_sequencial não informado.";
        $this->erro_campo = "si177_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si177_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_tiporegistro"])) {
      $sql .= $virgula . " si177_tiporegistro = $this->si177_tiporegistro ";
      $virgula = ",";
      if (trim($this->si177_tiporegistro) == null) {
        $this->erro_sql = " Campo si177_tiporegistro não informado.";
        $this->erro_campo = "si177_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si177_contacontaabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_contacontaabil"])) {
      $sql .= $virgula . " si177_contacontaabil = $this->si177_contacontaabil ";
      $virgula = ",";
      if (trim($this->si177_contacontaabil) == null) {
        $this->erro_sql = " Campo si177_contacontaabil não informado.";
        $this->erro_campo = "si177_contacontaabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si177_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_codfundo"])) {
      $sql .= $virgula . " si177_codfundo = '$this->si177_codfundo' ";
      $virgula = ",";
      if (trim($this->si177_codfundo) == null) {
        $this->erro_sql = " Campo si177_codfundo não informado.";
        $this->erro_campo = "si177_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si177_saldoinicial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_saldoinicial"])) {
      $sql .= $virgula . " si177_saldoinicial = $this->si177_saldoinicial ";
      $virgula = ",";
      if (trim($this->si177_saldoinicial) == null) {
        $this->erro_sql = " Campo si177_saldoinicial não informado.";
        $this->erro_campo = "si177_saldoinicial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si177_naturezasaldoinicial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_naturezasaldoinicial"])) {
      $sql .= $virgula . " si177_naturezasaldoinicial = '$this->si177_naturezasaldoinicial' ";
      $virgula = ",";
      if (trim($this->si177_naturezasaldoinicial) == null) {
        $this->erro_sql = " Campo si177_naturezasaldoinicial não informado.";
        $this->erro_campo = "si177_naturezasaldoinicial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si177_totaldebitos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_totaldebitos"])) {
      $sql .= $virgula . " si177_totaldebitos = $this->si177_totaldebitos ";
      $virgula = ",";
      if (trim($this->si177_totaldebitos) == null) {
        $this->erro_sql = " Campo si177_totaldebitos não informado.";
        $this->erro_campo = "si177_totaldebitos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si177_totalcreditos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_totalcreditos"])) {
      $sql .= $virgula . " si177_totalcreditos = $this->si177_totalcreditos ";
      $virgula = ",";
      if (trim($this->si177_totalcreditos) == null) {
        $this->erro_sql = " Campo si177_totalcreditos não informado.";
        $this->erro_campo = "si177_totalcreditos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si177_saldofinal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_saldofinal"])) {
      $sql .= $virgula . " si177_saldofinal = $this->si177_saldofinal ";
      $virgula = ",";
      if (trim($this->si177_saldofinal) == null) {
        $this->erro_sql = " Campo si177_saldofinal não informado.";
        $this->erro_campo = "si177_saldofinal";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si177_naturezasaldofinal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_naturezasaldofinal"])) {
      $sql .= $virgula . " si177_naturezasaldofinal = '$this->si177_naturezasaldofinal' ";
      $virgula = ",";
      if (trim($this->si177_naturezasaldofinal) == null) {
        $this->erro_sql = " Campo si177_naturezasaldofinal não informado.";
        $this->erro_campo = "si177_naturezasaldofinal";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si177_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_mes"])) {
      $sql .= $virgula . " si177_mes = $this->si177_mes ";
      $virgula = ",";
      if (trim($this->si177_mes) == null) {
        $this->erro_sql = " Campo si177_mes não informado.";
        $this->erro_campo = "si177_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si177_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_instit"])) {
      $sql .= $virgula . " si177_instit = $this->si177_instit ";
      $virgula = ",";
      if (trim($this->si177_instit) == null) {
        $this->erro_sql = " Campo si177_instit não informado.";
        $this->erro_campo = "si177_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si177_sequencial != null) {
      $sql .= " si177_sequencial = $this->si177_sequencial";
    }

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      $this->erro_sql = "balancete102023 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si177_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete102023 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si177_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si177_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si177_sequencial = null, $dbwhere = null)
  {

    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {

      if ($dbwhere == null || $dbwhere == "") {

        $resaco = $this->sql_record($this->sql_query_file($si177_sequencial));
      } else {

        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));

      }
    }


    $sql = " delete from balancete102023
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si177_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si177_sequencial = $si177_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      $this->erro_sql = "balancete102023 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si177_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete102023 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si177_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si177_sequencial;
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
      $this->erro_banco = str_replace("", "", @pg_last_error());
      $this->erro_sql = "Erro ao selecionar os registros.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $this->numrows = pg_num_rows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Record Vazio na Tabela:balancete102023";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si177_sequencial = null, $campos_filtro = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    $campos = "*";
    if ($campos_filtro != "*") {
        $campos = $campos_filtro;
    }
    $sql .= $campos;
    $sql .= " from balancete102023 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si177_sequencial != null) {
        $sql2 .= " where balancete102023.si177_sequencial = $si177_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= "  order by {$ordem}";
    }

    return $sql;
  }

  // funcao do sql
  function sql_query_file($si177_sequencial = null, $campos_filtro = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    $campos = "*";
    if ($campos_filtro != "*") {
        $campos = $campos_filtro;
    }
    $sql .= $campos;
    $sql .= " from balancete102023 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si177_sequencial != null) {
        $sql2 .= " where balancete102023.si177_sequencial = $si177_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by {$ordem}";
    }

    return $sql;
  }

  function sql_query_reg10_saldo_janeiro($sDataInicial, $sDataFinal, $sEncerramento, $iAnoUsu, $codcon)
  {
    $sSql = " select sinal_anterior,sinal_final,sum(saldoinicial) saldoinicial, sum(debitos) debitos, sum(creditos) creditos from(SELECT estrut_mae,
                                           estrut,
                                           c61_reduz,
                                           c61_codcon,
                                           c61_codigo,
                                           c60_descr,
                                           c60_finali,
                                           c61_instit,
                                           round(substr(fc_planosaldonovo,3,14)::float8,2)::float8 AS saldoinicial,
                                           round(substr(fc_planosaldonovo,17,14)::float8,2)::float8 AS debitos,
                                           round(substr(fc_planosaldonovo,31,14)::float8,2)::float8 AS creditos,
                                           round(substr(fc_planosaldonovo,45,14)::float8,2)::float8 AS saldo_final,
                                           substr(fc_planosaldonovo,59,1)::varchar(1) AS sinal_anterior,
                                           substr(fc_planosaldonovo,60,1)::varchar(1) AS sinal_final
                                    FROM
                                      (SELECT p.c60_estrut AS estrut_mae,
                                              p.c60_estrut AS estrut,
                                              c61_reduz,
                                              c61_codcon,
                                              c61_codigo,
                                              p.c60_descr,
                                              p.c60_finali,
                                              r.c61_instit,
                                              fc_planosaldonovo(" . $iAnoUsu . ",c61_reduz,'" . $sDataInicial . "','" . $sDataFinal . "',{$sEncerramento})
                                       FROM conplanoexe e
                                       INNER JOIN conplanoreduz r ON r.c61_anousu = c62_anousu
                                       AND r.c61_reduz = c62_reduz
                                       INNER JOIN conplano p ON r.c61_codcon = c60_codcon
                                       AND r.c61_anousu = c60_anousu
                                       LEFT OUTER JOIN consistema ON c60_codsis = c52_codsis
                                       WHERE c62_anousu = " . db_getsession('DB_anousu') . "
                                         AND c61_instit IN (" . db_getsession('DB_instit') . ")
						 AND c61_codcon = {$codcon} ) AS x) as y where saldoinicial > 0 or debitos > 0 or creditos > 0 group by 1,2";
    return $sSql;
  }

  function sql_query_reg10($debugEstrut=null, $whereNumRegistro=null, $sWhere10=null, $nAnoUsu, $nMes, $iInstit)
  {
    $sqlReg10 = "select ";
    $sqlReg10 .= "       tiporegistro, ";
    $sqlReg10 .= "       contacontabil, ";
    $sqlReg10 .= "       coalesce(saldoinicialano,0) saldoinicialano, ";
    $sqlReg10 .= "       coalesce(debito,0) debito, ";
    $sqlReg10 .= "       coalesce(credito,0) credito, ";
    $sqlReg10 .= "       codcon, ";
    $sqlReg10 .= "       c61_reduz, ";
    $sqlReg10 .= "       c60_nregobrig, ";
    $sqlReg10 .= "       c60_identificadorfinanceiro, ";
    $sqlReg10 .= "       case when c60_naturezasaldo = 1 then 'D' when c60_naturezasaldo = 2 then 'C' else 'C' end as c60_naturezasaldo ";
    $sqlReg10 .= "            from ";
    $sqlReg10 .= "               (select 10 as tiporegistro, ";
    $sqlReg10 .= "                       case when c209_tceestrut is null then substr(c60_estrut,1,9) else c209_tceestrut end as contacontabil, ";
    $sqlReg10 .= "                       (select sum(c69_valor) as credito from conlancamval where c69_credito = c61_reduz and DATE_PART('YEAR',c69_data) = " . $nAnoUsu . " and  DATE_PART('MONTH',c69_data) <= {$nMes}) as credito, ";
    $sqlReg10 .= "                       (select sum(c69_valor) as debito from conlancamval where c69_debito = c61_reduz and DATE_PART('YEAR',c69_data) = " . $nAnoUsu . " and  DATE_PART('MONTH',c69_data) <= {$nMes}) as debito, ";
    $sqlReg10 .= "                       (c62_vlrdeb - c62_vlrcre) as saldoinicialano,c61_reduz, c60_nregobrig, ";
    $sqlReg10 .= "                       c60_codcon as codcon, c60_identificadorfinanceiro,c60_naturezasaldo ";
    $sqlReg10 .= "                 from contabilidade.conplano ";
    $sqlReg10 .= "			inner join conplanoreduz on c61_codcon = c60_codcon and c61_anousu = c60_anousu and c61_instit = " . $iInstit ;
    $sqlReg10 .= "           inner join conplanoexe on c62_reduz = c61_reduz and c61_anousu = c62_anousu ";
    $sqlReg10 .= "           left join vinculopcasptce on substr(c60_estrut,1,9) = c209_pcaspestrut ";
    $sqlReg10 .= "                where {$debugEstrut} {$whereNumRegistro} c60_anousu = " . $nAnoUsu . " {$sWhere10} ) as x ";
    $sqlReg10 .= "           where  debito != 0 or credito != 0 or saldoinicialano != 0 order by contacontabil ";
//echo $sqlReg10;
    return $sqlReg10;
  }

}
