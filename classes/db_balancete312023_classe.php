<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete312023
class cl_balancete312023
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
  var $si243_sequencial = 0;
  var $si243_tiporegistro = 0;
  var $si243_contacontabil = 0;
  var $si243_codfundo = null;
  var $si243_naturezareceita = 0;
  var $si243_codfontrecursos = 0;
  var $si243_codco = 0;
  var $si243_saldoinicialcre = 0;
  var $si243_naturezasaldoinicialcre = null;
  var $si243_totaldebitoscre = 0;
  var $si243_totalcreditoscre = 0;
  var $si243_nrocontratoop = null;
  var $si243_dataassinaturacontratoop = null;
  var $si243_saldofinalcre = 0;
  var $si243_naturezasaldofinalcre = null;
  var $si243_mes = 0;
  var $si243_instit = 0;
  var $si243_reg10 = null;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si243_sequencial = int8 = si243_sequencial
                 si243_tiporegistro = int8 = si243_tiporegistro
                 si243_contacontabil = int8 = si243_contacontabil
                 si243_codfundo = varchar(8) = si243_codfundo
                 si243_naturezareceita = int8 = si243_naturezareceita
                 si243_codfontrecursos = int8 = si243_codfontrecursos
                 si243_codco = int8 = si243_codco
                 si243_nrocontratoop = varchar(30) = si243_nrocontratoop,
                 si243_dataassinaturacontratoop = date = si243_dataassinaturacontratoop,
                 si243_saldoinicialcre = float8 = si243_saldoinicialcre
                 si243_naturezasaldoinicialcre = varchar(1) = si243_naturezasaldoinicialcre
                 si243_totaldebitoscre = float8 = si243_totaldebitoscre
                 si243_totalcreditoscre = float8 = si243_totalcreditoscre
                 si243_saldofinalcre = float8 = si243_saldofinalcre
                 si243_naturezasaldofinalcre = varchar(1) = si243_naturezasaldofinalcre
                 si243_mes = int8 = si243_mes
                 si243_instit = int8 = si243_instit
                 ";

  //funcao construtor da classe
  function cl_balancete312023()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete312023");
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
      $this->si243_sequencial = ($this->si243_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_sequencial"] : $this->si243_sequencial);
      $this->si243_tiporegistro = ($this->si243_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_tiporegistro"] : $this->si243_tiporegistro);
      $this->si243_contacontabil = ($this->si243_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_contacontabil"] : $this->si243_contacontabil);
      $this->si243_codfundo = ($this->si243_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_codfundo"] : $this->si243_codfundo);
      $this->si243_naturezareceita = ($this->si243_naturezareceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_naturezareceita"] : $this->si243_naturezareceita);
      $this->si243_codfontrecursos = ($this->si243_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_codfontrecursos"] : $this->si243_codfontrecursos);
      $this->si243_saldoinicialcre = ($this->si243_saldoinicialcre == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_saldoinicialcre"] : $this->si243_saldoinicialcre);
      $this->si243_naturezasaldoinicialcre = ($this->si243_naturezasaldoinicialcre == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_naturezasaldoinicialcre"] : $this->si243_naturezasaldoinicialcre);
      $this->si243_totaldebitoscre = ($this->si243_totaldebitoscre == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_totaldebitoscre"] : $this->si243_totaldebitoscre);
      $this->si243_totalcreditoscre = ($this->si243_totalcreditoscre == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_totalcreditoscre"] : $this->si243_totalcreditoscre);
      $this->si243_saldofinalcre = ($this->si243_saldofinalcre == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_saldofinalcre"] : $this->si243_saldofinalcre);
      $this->si243_naturezasaldofinalcre = ($this->si243_naturezasaldofinalcre == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_naturezasaldofinalcre"] : $this->si243_naturezasaldofinalcre);
      $this->si243_mes = ($this->si243_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_mes"] : $this->si243_mes);
      $this->si243_instit = ($this->si243_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_instit"] : $this->si243_instit);
    } else {
      $this->si243_sequencial = ($this->si243_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si243_sequencial"] : $this->si243_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si243_sequencial)
  {
    $this->atualizacampos();
    if ($this->si243_tiporegistro == null) {
      $this->erro_sql = " Campo si243_tiporegistro não informado.";
      $this->erro_campo = "si243_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si243_contacontabil == null) {
      $this->erro_sql = " Campo si243_contacontabil não informado.";
      $this->erro_campo = "si243_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si243_naturezareceita == null) {
      $this->erro_sql = " Campo si243_naturezareceita não informado.";
      $this->erro_campo = "si243_naturezareceita";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si243_codfontrecursos == null) {
      $this->erro_sql = " Campo si243_codfontrecursos não informado.";
      $this->erro_campo = "si243_codfontrecursos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if ($this->si243_saldoinicialcre == null) {
      $this->erro_sql = " Campo si243_saldoinicialcre não informado.";
      $this->erro_campo = "si243_saldoinicialcre";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si243_naturezasaldoinicialcre == null) {
      $this->erro_sql = " Campo si243_naturezasaldoinicialcre não informado.";
      $this->erro_campo = "si243_naturezasaldoinicialcre";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si243_totaldebitoscre == null) {
      $this->erro_sql = " Campo si243_totaldebitoscre não informado.";
      $this->erro_campo = "si243_totaldebitoscre";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si243_totalcreditoscre == null) {
      $this->erro_sql = " Campo si243_totalcreditoscre não informado.";
      $this->erro_campo = "si243_totalcreditoscre";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si243_saldofinalcre == null) {
      $this->erro_sql = " Campo si243_saldofinalcre não informado.";
      $this->erro_campo = "si243_saldofinalcre";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si243_naturezasaldofinalcre == null) {
      $this->erro_sql = " Campo si243_naturezasaldofinalcre não informado.";
      $this->erro_campo = "si243_naturezasaldofinalcre";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si243_mes == null) {
      $this->erro_sql = " Campo si243_mes não informado.";
      $this->erro_campo = "si243_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si243_instit == null) {
      $this->erro_sql = " Campo si243_instit não informado.";
      $this->erro_campo = "si243_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si243_sequencial == "" || $si243_sequencial == null) {
      $result = db_query("select nextval('balancete312023_si243_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete312023_si243_sequencial_seq do campo: si243_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si243_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete312023_si243_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si243_sequencial)) {
        $this->erro_sql = " Campo si243_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si243_sequencial = $si243_sequencial;
      }
    }
    if (($this->si243_sequencial == null) || ($this->si243_sequencial == "")) {
      $this->erro_sql = " Campo si243_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si243_nrocontratoop == null) {
        $this->si243_nrocontratoop = "null";
    }
    if ($this->si243_dataassinaturacontratoop == null) {
        $this->si243_dataassinaturacontratoop = "null";
    }
    $sql = "insert into balancete312023(
                                       si243_sequencial
                                      ,si243_tiporegistro
                                      ,si243_contacontabil
                                      ,si243_codfundo
                                      ,si243_naturezareceita
                                      ,si243_codfontrecursos
                                      ,si243_codco
                                      ,si243_nrocontratoop
                                      ,si243_dataassinaturacontratoop
                                      ,si243_saldoinicialcre
                                      ,si243_naturezasaldoinicialcre
                                      ,si243_totaldebitoscre
                                      ,si243_totalcreditoscre
                                      ,si243_saldofinalcre
                                      ,si243_naturezasaldofinalcre
                                      ,si243_mes
                                      ,si243_instit
                                      ,si243_reg10
                       )
                values (
                                $this->si243_sequencial
                               ,$this->si243_tiporegistro
                               ,$this->si243_contacontabil
                               ,'$this->si243_codfundo'
                               ,$this->si243_naturezareceita
                               ,$this->si243_codfontrecursos
                               ,$this->si243_codco
                               ,".($this->si243_nrocontratoop == "null" || $this->si243_nrocontratoop == ""?"null":"'".$this->si243_nrocontratoop."'")."
                               ,".($this->si243_dataassinaturacontratoop == "null" || $this->si243_dataassinaturacontratoop == ""?"null":"'".$this->si243_dataassinaturacontratoop."'")."
                               ,$this->si243_saldoinicialcre
                               ,'$this->si243_naturezasaldoinicialcre'
                               ,$this->si243_totaldebitoscre
                               ,$this->si243_totalcreditoscre
                               ,$this->si243_saldofinalcre
                               ,'$this->si243_naturezasaldofinalcre'
                               ,$this->si243_mes
                               ,$this->si243_instit
                               ,$this->si243_reg10
                      )";

    $result = db_query($sql) or die($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete312023 ($this->si243_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete312023 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete312023 ($this->si243_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si243_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);

    return true;
  }

  // funcao para alteracao
  function alterar($si243_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete312023 set ";
    $virgula = "";
    if (trim($this->si243_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_sequencial"])) {
      $sql .= $virgula . " si243_sequencial = $this->si243_sequencial ";
      $virgula = ",";
      if (trim($this->si243_sequencial) == null) {
        $this->erro_sql = " Campo si243_sequencial não informado.";
        $this->erro_campo = "si243_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_tiporegistro"])) {
      $sql .= $virgula . " si243_tiporegistro = $this->si243_tiporegistro ";
      $virgula = ",";
      if (trim($this->si243_tiporegistro) == null) {
        $this->erro_sql = " Campo si243_tiporegistro não informado.";
        $this->erro_campo = "si243_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_contacontabil"])) {
      $sql .= $virgula . " si243_contacontabil = $this->si243_contacontabil ";
      $virgula = ",";
      if (trim($this->si243_contacontabil) == null) {
        $this->erro_sql = " Campo si243_contacontabil não informado.";
        $this->erro_campo = "si243_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_codfundo"])) {
      $sql .= $virgula . " si243_codfundo = '$this->si243_codfundo' ";
      $virgula = ",";
      if (trim($this->si243_codfundo) == null) {
        $this->erro_sql = " Campo si243_codfundo não informado.";
        $this->erro_campo = "si243_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_naturezareceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_naturezareceita"])) {
      $sql .= $virgula . " si243_naturezareceita = $this->si243_naturezareceita ";
      $virgula = ",";
      if (trim($this->si243_naturezareceita) == null) {
        $this->erro_sql = " Campo si243_naturezareceita não informado.";
        $this->erro_campo = "si243_naturezareceita";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_codfontrecursos"])) {
      $sql .= $virgula . " si243_codfontrecursos = $this->si243_codfontrecursos ";
      $virgula = ",";
      if (trim($this->si243_codfontrecursos) == null) {
        $this->erro_sql = " Campo si243_codfontrecursos não informado.";
        $this->erro_campo = "si243_codfontrecursos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }

    if (trim($this->si243_saldoinicialcre) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_saldoinicialcre"])) {
      $sql .= $virgula . " si243_saldoinicialcre = $this->si243_saldoinicialcre ";
      $virgula = ",";
      if (trim($this->si243_saldoinicialcre) == null) {
        $this->erro_sql = " Campo si243_saldoinicialcre não informado.";
        $this->erro_campo = "si243_saldoinicialcre";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_naturezasaldoinicialcre) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_naturezasaldoinicialcre"])) {
      $sql .= $virgula . " si243_naturezasaldoinicialcre = '$this->si243_naturezasaldoinicialcre' ";
      $virgula = ",";
      if (trim($this->si243_naturezasaldoinicialcre) == null) {
        $this->erro_sql = " Campo si243_naturezasaldoinicialcre não informado.";
        $this->erro_campo = "si243_naturezasaldoinicialcre";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_totaldebitoscre) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_totaldebitoscre"])) {
      $sql .= $virgula . " si243_totaldebitoscre = $this->si243_totaldebitoscre ";
      $virgula = ",";
      if (trim($this->si243_totaldebitoscre) == null) {
        $this->erro_sql = " Campo si243_totaldebitoscre não informado.";
        $this->erro_campo = "si243_totaldebitoscre";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_totalcreditoscre) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_totalcreditoscre"])) {
      $sql .= $virgula . " si243_totalcreditoscre = $this->si243_totalcreditoscre ";
      $virgula = ",";
      if (trim($this->si243_totalcreditoscre) == null) {
        $this->erro_sql = " Campo si243_totalcreditoscre não informado.";
        $this->erro_campo = "si243_totalcreditoscre";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_saldofinalcre) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_saldofinalcre"])) {
      $sql .= $virgula . " si243_saldofinalcre = $this->si243_saldofinalcre ";
      $virgula = ",";
      if (trim($this->si243_saldofinalcre) == null) {
        $this->erro_sql = " Campo si243_saldofinalcre não informado.";
        $this->erro_campo = "si243_saldofinalcre";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_naturezasaldofinalcre) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_naturezasaldofinalcre"])) {
      $sql .= $virgula . " si243_naturezasaldofinalcre = '$this->si243_naturezasaldofinalcre' ";
      $virgula = ",";
      if (trim($this->si243_naturezasaldofinalcre) == null) {
        $this->erro_sql = " Campo si243_naturezasaldofinalcre não informado.";
        $this->erro_campo = "si243_naturezasaldofinalcre";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_mes"])) {
      $sql .= $virgula . " si243_mes = $this->si243_mes ";
      $virgula = ",";
      if (trim($this->si243_mes) == null) {
        $this->erro_sql = " Campo si243_mes não informado.";
        $this->erro_campo = "si243_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si243_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si243_instit"])) {
      $sql .= $virgula . " si243_instit = $this->si243_instit ";
      $virgula = ",";
      if (trim($this->si243_instit) == null) {
        $this->erro_sql = " Campo si243_instit não informado.";
        $this->erro_campo = "si243_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si243_sequencial != null) {
      $sql .= " si243_sequencial = $this->si243_sequencial";
    }

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete312023 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si243_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete312023 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si243_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si243_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si243_sequencial = null, $dbwhere = null)
  {
    $sql = " delete from balancete312023
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si243_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si243_sequencial = $si243_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete312023 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si243_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete312023 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si243_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si243_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete312023";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si243_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete312023 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si243_sequencial != null) {
        $sql2 .= " where balancete312023.si243_sequencial = $si243_sequencial ";
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
  function sql_query_file($si243_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete312023 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si243_sequencial != null) {
        $sql2 .= " where balancete312023.si243_sequencial = $si243_sequencial ";
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

  function sql_query_vinculo_conta_orcamento($aContas)
  {
            $sSqlVinculoContaOrcamento = " SELECT DISTINCT c60_estrut
                                c60_estrut,
                                o15_codtri,
                                op01_numerocontratoopc,
                                op01_dataassinaturacop,
                                c19_emparlamentar
                                FROM orcreceita
                            INNER JOIN conplanoorcamento on o70_codfon = c60_codcon and o70_anousu = c60_anousu
                            INNER JOIN conplanoorcamentoanalitica ON c61_codcon = c60_codcon AND c61_anousu = c60_anousu
                            INNER JOIN orctiporec ON c61_codigo = o15_codigo
                            INNER JOIN contacorrentedetalhe ON c19_estrutural = c60_estrut AND c61_anousu = c19_conplanoreduzanousu
                            LEFT JOIN taborc on taborc.k02_anousu=o70_anousu and taborc.k02_codrec=o70_codrec
                            LEFT JOIN tabrec on tabrec.k02_codigo=taborc.k02_codigo
                            LEFT JOIN placaixarec on k81_receita = tabrec.k02_codigo
                            LEFT JOIN saltes ON k13_conta=k81_conta
                            LEFT JOIN conplanoreduz on k13_reduz=conplanoreduz.c61_reduz and conplanoreduz.c61_anousu=c60_anousu
                            LEFT JOIN conplanocontabancaria ON c56_codcon=conplanoreduz.c61_codcon and conplanoreduz.c61_anousu=c56_anousu
                            LEFT JOIN contabancaria ON c56_contabancaria=db83_sequencial
                            LEFT JOIN db_operacaodecredito ON db83_codigoopcredito=op01_sequencial
                                WHERE substr(c60_estrut,1 ,1 ) in ('4')
                                AND c19_reduz IN (" . implode(',', $aContas) . ")
                                AND conplanoorcamentoanalitica.c61_instit = " . db_getsession('DB_instit') . "
                                AND conplanoorcamentoanalitica.c61_anousu = " . db_getsession("DB_anousu");
            return $sSqlVinculoContaOrcamento;
  }

  function sql_query_reg31_saldos($aContas, $nContaCorrente, $sEstrut, $nMes, $sWhereEncerramento, $whereEmenda)
  {
            $sSqlReg31saldos = " SELECT
                (SELECT case when round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) = '0.00' then null else round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) end AS saldoinicial
                FROM
                    (SELECT
                    (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                        FROM contacorrente
                        INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                        INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                        AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = " . db_getsession("DB_anousu") . " and c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . "
                        WHERE c19_reduz IN (" . implode(',', $aContas) . ")
                        AND c17_sequencial = {$nContaCorrente}
                        {$whereEmenda}
                        AND c19_estrutural = '{$sEstrut}') AS saldoimplantado,

                    (SELECT sum(c69_valor) AS debito
                        FROM conlancamval
                        INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                        AND conlancam.c70_anousu = conlancamval.c69_anousu
                        INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                        INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                        INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                        INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                        WHERE c28_tipo = 'D'
                            AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                            AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                            AND c19_contacorrente = {$nContaCorrente}
                            AND c19_reduz IN (" . implode(',', $aContas) . ")
                            AND c19_estrutural = '{$sEstrut}'
                            {$whereEmenda}
                            {$sWhereEncerramento}
                        GROUP BY c28_tipo) AS debitoatual,

                    (SELECT sum(c69_valor) AS credito
                        FROM conlancamval
                        INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                        AND conlancam.c70_anousu = conlancamval.c69_anousu
                        INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                        INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                        INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                        INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                        WHERE c28_tipo = 'C'
                            AND DATE_PART('MONTH',c69_data) < " . $nMes . "
                            AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                            AND c19_contacorrente = {$nContaCorrente}
                            AND c19_reduz IN (" . implode(',', $aContas) . ")
                            AND c19_estrutural = '{$sEstrut}'
                            {$whereEmenda}
                            {$sWhereEncerramento}
                        GROUP BY c28_tipo) AS creditoatual) AS movi) AS saldoanterior,

                (SELECT sum(c69_valor)
                FROM conlancamval
                INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                AND conlancam.c70_anousu = conlancamval.c69_anousu
                INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                WHERE c28_tipo = 'C'
                    AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                    AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                    AND c19_contacorrente = {$nContaCorrente}
                    AND c19_reduz IN (" . implode(',', $aContas) . ")
                    AND c19_estrutural = '{$sEstrut}'
                    {$whereEmenda}
                    {$sWhereEncerramento}
                GROUP BY c28_tipo) AS creditos,

                (SELECT sum(c69_valor)
                FROM conlancamval
                INNER JOIN conlancam ON conlancam.c70_codlan = conlancamval.c69_codlan
                AND conlancam.c70_anousu = conlancamval.c69_anousu
                INNER JOIN conlancamdoc ON conlancamdoc.c71_codlan = conlancamval.c69_codlan
                INNER JOIN conhistdoc ON conlancamdoc.c71_coddoc = conhistdoc.c53_coddoc
                INNER JOIN contacorrentedetalheconlancamval ON contacorrentedetalheconlancamval.c28_conlancamval = conlancamval.c69_sequen
                INNER JOIN contacorrentedetalhe ON contacorrentedetalhe.c19_sequencial = contacorrentedetalheconlancamval.c28_contacorrentedetalhe
                WHERE c28_tipo = 'D'
                    AND DATE_PART('MONTH',c69_data) = " . $nMes . "
                    AND DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . "
                    AND c19_contacorrente = {$nContaCorrente}
                    AND c19_reduz IN (" . implode(',', $aContas) . ")
                    AND c19_estrutural = '{$sEstrut}'
                    {$whereEmenda}
                    {$sWhereEncerramento}
                GROUP BY c28_tipo) AS debitos";
        return $sSqlReg31saldos;
  }
}

?>
