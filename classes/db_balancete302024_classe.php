<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete302024
class cl_balancete302024
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
  var $si242_sequencial = 0;
  var $si242_tiporegistro = 0;
  var $si242_contacontaabil = 0;
  var $si242_codfundo = null;
  var $si242_codorgao = null;
  var $si242_codunidadesub = null;
  var $si242_codfuncao = null;
  var $si242_codsubfuncao = null;
  var $si242_codprograma = null;
  var $si242_idacao = null;
  var $si242_idsubacao = null;
  var $si242_naturezadespesa = 0;
  var $si242_subelemento = null;
  var $si242_codfontrecursos = 0;
  var $si242_codco = 0;
  var $si242_saldoinicialcde = 0;
  var $si242_naturezasaldoinicialcde = null;
  var $si242_totaldebitoscde = 0;
  var $si242_totalcreditoscde = 0;
  var $si242_saldofinalcde = 0;
  var $si242_naturezasaldofinalcde = null;
  var $si242_mes = 0;
  var $si242_instit = 0;
  var $si242_reg10 = null;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si242_sequencial = int8 = si242_sequencial
                 si242_tiporegistro = int8 = si242_tiporegistro
                 si242_contacontaabil = int8 = si242_contacontaabil
                 si242_codfundo = varchar(8) = si242_codfundo
                 si242_codorgao = varchar(2) = si242_codorgao
                 si242_codunidadesub = varchar(8) = si242_codunidadesub
                 si242_codfuncao = varchar(2) = si242_codfuncao
                 si242_codsubfuncao = varchar(3) = si242_codsubfuncao
                 si242_codprograma = text = si242_codprograma
                 si242_idacao = varchar(4) = si242_idacao
                 si242_idsubacao = varchar(4) = si242_idsubacao
                 si242_naturezadespesa = int8 = si242_naturezadespesa
                 si242_subelemento = varchar(2) = si242_subelemento
                 si242_codfontrecursos = int8 = si242_codfontrecursos
                 si242_codco = int8 = si242_codco
                 si242_saldoinicialcde = float8 = si242_saldoinicialcde
                 si242_naturezasaldoinicialcde = varchar(1) = si242_naturezasaldoinicialcde
                 si242_totaldebitoscde = float8 = si242_totaldebitoscde
                 si242_totalcreditoscde = float8 = si242_totalcreditoscde
                 si242_saldofinalcde = float8 = si242_saldofinalcde
                 si242_naturezasaldofinalcde = varchar(1) = si242_naturezasaldofinalcde
                 si242_mes = int8 = si242_mes
                 si242_instit = int8 = si242_instit
                 ";

  //funcao construtor da classe
  function cl_balancete302024()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete302024");
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
      $this->si242_sequencial = ($this->si242_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_sequencial"] : $this->si242_sequencial);
      $this->si242_tiporegistro = ($this->si242_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_tiporegistro"] : $this->si242_tiporegistro);
      $this->si242_contacontaabil = ($this->si242_contacontaabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_contacontaabil"] : $this->si242_contacontaabil);
      $this->si242_codfundo = ($this->si242_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_codfundo"] : $this->si242_codfundo);
      $this->si242_codorgao = ($this->si242_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_codorgao"] : $this->si242_codorgao);
      $this->si242_codunidadesub = ($this->si242_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_codunidadesub"] : $this->si242_codunidadesub);
      $this->si242_codfuncao = ($this->si242_codfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_codfuncao"] : $this->si242_codfuncao);
      $this->si242_codsubfuncao = ($this->si242_codsubfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_codsubfuncao"] : $this->si242_codsubfuncao);
      $this->si242_codprograma = ($this->si242_codprograma == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_codprograma"] : $this->si242_codprograma);
      $this->si242_idacao = ($this->si242_idacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_idacao"] : $this->si242_idacao);
      $this->si242_idsubacao = ($this->si242_idsubacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_idsubacao"] : $this->si242_idsubacao);
      $this->si242_naturezadespesa = ($this->si242_naturezadespesa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_naturezadespesa"] : $this->si242_naturezadespesa);
      $this->si242_subelemento = ($this->si242_subelemento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_subelemento"] : $this->si242_subelemento);
      $this->si242_codfontrecursos = ($this->si242_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_codfontrecursos"] : $this->si242_codfontrecursos);
      $this->si242_saldoinicialcde = ($this->si242_saldoinicialcde == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_saldoinicialcde"] : $this->si242_saldoinicialcde);
      $this->si242_naturezasaldoinicialcde = ($this->si242_naturezasaldoinicialcde == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_naturezasaldoinicialcde"] : $this->si242_naturezasaldoinicialcde);
      $this->si242_totaldebitoscde = ($this->si242_totaldebitoscde == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_totaldebitoscde"] : $this->si242_totaldebitoscde);
      $this->si242_totalcreditoscde = ($this->si242_totalcreditoscde == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_totalcreditoscde"] : $this->si242_totalcreditoscde);
      $this->si242_saldofinalcde = ($this->si242_saldofinalcde == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_saldofinalcde"] : $this->si242_saldofinalcde);
      $this->si242_naturezasaldofinalcde = ($this->si242_naturezasaldofinalcde == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_naturezasaldofinalcde"] : $this->si242_naturezasaldofinalcde);
      $this->si242_mes = ($this->si242_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_mes"] : $this->si242_mes);
      $this->si242_instit = ($this->si242_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_instit"] : $this->si242_instit);
    } else {
      $this->si242_sequencial = ($this->si242_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si242_sequencial"] : $this->si242_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si242_sequencial)
  {
    $this->atualizacampos();
    if ($this->si242_tiporegistro == null) {
      $this->erro_sql = " Campo si242_tiporegistro não informado.";
      $this->erro_campo = "si242_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_contacontaabil == null) {
      $this->erro_sql = " Campo si242_contacontaabil não informado.";
      $this->erro_campo = "si242_contacontaabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_codorgao == null) {
      $this->erro_sql = " Campo si242_codorgao não informado.";
      $this->erro_campo = "si242_codorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_codunidadesub == null) {
      $this->erro_sql = " Campo si242_codunidadesub não informado.";
      $this->erro_campo = "si242_codunidadesub";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_codfuncao == null) {
      $this->erro_sql = " Campo si242_codfuncao não informado.";
      $this->erro_campo = "si242_codfuncao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_codsubfuncao == null) {
      $this->erro_sql = " Campo si242_codsubfuncao não informado.";
      $this->erro_campo = "si242_codsubfuncao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_codprograma == null) {
      $this->erro_sql = " Campo si242_codprograma não informado.";
      $this->erro_campo = "si242_codprograma";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_idacao == null) {
      $this->erro_sql = " Campo si242_idacao não informado.";
      $this->erro_campo = "si242_idacao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_idsubacao == null) {
      $this->si242_idsubacao = " ";
    }
    if ($this->si242_naturezadespesa == null) {
      $this->erro_sql = " Campo si242_naturezadespesa não informado.";
      $this->erro_campo = "si242_naturezadespesa";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_subelemento == null) {
      $this->erro_sql = " Campo si242_subelemento não informado.";
      $this->erro_campo = "si242_subelemento";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_codfontrecursos == null) {
      $this->erro_sql = " Campo si242_codfontrecursos não informado.";
      $this->erro_campo = "si242_codfontrecursos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if ($this->si242_saldoinicialcde == null) {
      $this->erro_sql = " Campo si242_saldoinicialcde não informado.";
      $this->erro_campo = "si242_saldoinicialcde";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_naturezasaldoinicialcde == null) {
      $this->erro_sql = " Campo si242_naturezasaldoinicialcde não informado.";
      $this->erro_campo = "si242_naturezasaldoinicialcde";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_totaldebitoscde == null) {
      $this->erro_sql = " Campo si242_totaldebitoscde não informado.";
      $this->erro_campo = "si242_totaldebitoscde";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_totalcreditoscde == null) {
      $this->erro_sql = " Campo si242_totalcreditoscde não informado.";
      $this->erro_campo = "si242_totalcreditoscde";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_saldofinalcde == null) {
      $this->erro_sql = " Campo si242_saldofinalcde não informado.";
      $this->erro_campo = "si242_saldofinalcde";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_naturezasaldofinalcde == null) {
      $this->erro_sql = " Campo si242_naturezasaldofinalcde não informado.";
      $this->erro_campo = "si242_naturezasaldofinalcde";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_mes == null) {
      $this->erro_sql = " Campo si242_mes não informado.";
      $this->erro_campo = "si242_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si242_instit == null) {
      $this->erro_sql = " Campo si242_instit não informado.";
      $this->erro_campo = "si242_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if ($si242_sequencial == "" || $si242_sequencial == null) {
      $result = db_query("select nextval('balancete302024_si242_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete302024_si242_sequencial_seq do campo: si242_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si242_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete302024_si242_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si242_sequencial)) {
        $this->erro_sql = " Campo si242_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si242_sequencial = $si242_sequencial;
      }
    }
    if (($this->si242_sequencial == null) || ($this->si242_sequencial == "")) {
      $this->erro_sql = " Campo si242_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into balancete302024(
                                       si242_sequencial
                                      ,si242_tiporegistro
                                      ,si242_contacontaabil
                                      ,si242_codfundo
                                      ,si242_codorgao
                                      ,si242_codunidadesub
                                      ,si242_codfuncao
                                      ,si242_codsubfuncao
                                      ,si242_codprograma
                                      ,si242_idacao
                                      ,si242_idsubacao
                                      ,si242_naturezadespesa
                                      ,si242_subelemento
                                      ,si242_codfontrecursos
                                      ,si242_codco
                                      ,si242_saldoinicialcde
                                      ,si242_naturezasaldoinicialcde
                                      ,si242_totaldebitoscde
                                      ,si242_totalcreditoscde
                                      ,si242_saldofinalcde
                                      ,si242_naturezasaldofinalcde
                                      ,si242_mes
                                      ,si242_instit
                                      ,si242_reg10
                       )
                values (
                                $this->si242_sequencial
                               ,$this->si242_tiporegistro
                               ,$this->si242_contacontaabil
                               ,'$this->si242_codfundo'
                               ,'$this->si242_codorgao'
                               ,'$this->si242_codunidadesub'
                               ,'$this->si242_codfuncao'
                               ,'$this->si242_codsubfuncao'
                               ,'$this->si242_codprograma'
                               ,'$this->si242_idacao'
                               ,'$this->si242_idsubacao'
                               ,$this->si242_naturezadespesa
                               ,'$this->si242_subelemento'
                               ,$this->si242_codfontrecursos
                               ,$this->si242_codco
                               ,$this->si242_saldoinicialcde
                               ,'$this->si242_naturezasaldoinicialcde'
                               ,$this->si242_totaldebitoscde
                               ,$this->si242_totalcreditoscde
                               ,$this->si242_saldofinalcde
                               ,'$this->si242_naturezasaldofinalcde'
                               ,$this->si242_mes
                               ,$this->si242_instit
                               ,$this->si242_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete302024 ($this->si242_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete302024 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete302024 ($this->si242_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si242_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);

    return true;
  }

  // funcao para alteracao
  function alterar($si242_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete302024 set ";
    $virgula = "";
    if (trim($this->si242_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_sequencial"])) {
      $sql .= $virgula . " si242_sequencial = $this->si242_sequencial ";
      $virgula = ",";
      if (trim($this->si242_sequencial) == null) {
        $this->erro_sql = " Campo si242_sequencial não informado.";
        $this->erro_campo = "si242_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_tiporegistro"])) {
      $sql .= $virgula . " si242_tiporegistro = $this->si242_tiporegistro ";
      $virgula = ",";
      if (trim($this->si242_tiporegistro) == null) {
        $this->erro_sql = " Campo si242_tiporegistro não informado.";
        $this->erro_campo = "si242_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_contacontaabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_contacontaabil"])) {
      $sql .= $virgula . " si242_contacontaabil = $this->si242_contacontaabil ";
      $virgula = ",";
      if (trim($this->si242_contacontaabil) == null) {
        $this->erro_sql = " Campo si242_contacontaabil não informado.";
        $this->erro_campo = "si242_contacontaabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_codfundo"])) {
      $sql .= $virgula . " si242_codfundo = '$this->si242_codfundo' ";
      $virgula = ",";
      if (trim($this->si242_codfundo) == null) {
        $this->erro_sql = " Campo si242_codfundo não informado.";
        $this->erro_campo = "si242_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_codorgao"])) {
      $sql .= $virgula . " si242_codorgao = '$this->si242_codorgao' ";
      $virgula = ",";
      if (trim($this->si242_codorgao) == null) {
        $this->erro_sql = " Campo si242_codorgao não informado.";
        $this->erro_campo = "si242_codorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_codunidadesub"])) {
      $sql .= $virgula . " si242_codunidadesub = '$this->si242_codunidadesub' ";
      $virgula = ",";
      if (trim($this->si242_codunidadesub) == null) {
        $this->erro_sql = " Campo si242_codunidadesub não informado.";
        $this->erro_campo = "si242_codunidadesub";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_codfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_codfuncao"])) {
      $sql .= $virgula . " si242_codfuncao = '$this->si242_codfuncao' ";
      $virgula = ",";
      if (trim($this->si242_codfuncao) == null) {
        $this->erro_sql = " Campo si242_codfuncao não informado.";
        $this->erro_campo = "si242_codfuncao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_codsubfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_codsubfuncao"])) {
      $sql .= $virgula . " si242_codsubfuncao = '$this->si242_codsubfuncao' ";
      $virgula = ",";
      if (trim($this->si242_codsubfuncao) == null) {
        $this->erro_sql = " Campo si242_codsubfuncao não informado.";
        $this->erro_campo = "si242_codsubfuncao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_codprograma) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_codprograma"])) {
      $sql .= $virgula . " si242_codprograma = '$this->si242_codprograma' ";
      $virgula = ",";
      if (trim($this->si242_codprograma) == null) {
        $this->erro_sql = " Campo si242_codprograma não informado.";
        $this->erro_campo = "si242_codprograma";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_idacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_idacao"])) {
      $sql .= $virgula . " si242_idacao = '$this->si242_idacao' ";
      $virgula = ",";
      if (trim($this->si242_idacao) == null) {
        $this->erro_sql = " Campo si242_idacao não informado.";
        $this->erro_campo = "si242_idacao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_idsubacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_idsubacao"])) {
      $sql .= $virgula . " si242_idsubacao = '$this->si242_idsubacao' ";
      $virgula = ",";
      if (trim($this->si242_idsubacao) == null) {
        $this->erro_sql = " Campo si242_idsubacao não informado.";
        $this->erro_campo = "si242_idsubacao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_naturezadespesa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_naturezadespesa"])) {
      $sql .= $virgula . " si242_naturezadespesa = $this->si242_naturezadespesa ";
      $virgula = ",";
      if (trim($this->si242_naturezadespesa) == null) {
        $this->erro_sql = " Campo si242_naturezadespesa não informado.";
        $this->erro_campo = "si242_naturezadespesa";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_subelemento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_subelemento"])) {
      $sql .= $virgula . " si242_subelemento = '$this->si242_subelemento' ";
      $virgula = ",";
      if (trim($this->si242_subelemento) == null) {
        $this->erro_sql = " Campo si242_subelemento não informado.";
        $this->erro_campo = "si242_subelemento";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_codfontrecursos"])) {
      $sql .= $virgula . " si242_codfontrecursos = $this->si242_codfontrecursos ";
      $virgula = ",";
      if (trim($this->si242_codfontrecursos) == null) {
        $this->erro_sql = " Campo si242_codfontrecursos não informado.";
        $this->erro_campo = "si242_codfontrecursos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }

    if (trim($this->si242_saldoinicialcde) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_saldoinicialcde"])) {
      $sql .= $virgula . " si242_saldoinicialcde = $this->si242_saldoinicialcde ";
      $virgula = ",";
      if (trim($this->si242_saldoinicialcde) == null) {
        $this->erro_sql = " Campo si242_saldoinicialcde não informado.";
        $this->erro_campo = "si242_saldoinicialcde";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_naturezasaldoinicialcde) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_naturezasaldoinicialcde"])) {
      $sql .= $virgula . " si242_naturezasaldoinicialcde = '$this->si242_naturezasaldoinicialcde' ";
      $virgula = ",";
      if (trim($this->si242_naturezasaldoinicialcde) == null) {
        $this->erro_sql = " Campo si242_naturezasaldoinicialcde não informado.";
        $this->erro_campo = "si242_naturezasaldoinicialcde";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_totaldebitoscde) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_totaldebitoscde"])) {
      $sql .= $virgula . " si242_totaldebitoscde = $this->si242_totaldebitoscde ";
      $virgula = ",";
      if (trim($this->si242_totaldebitoscde) == null) {
        $this->erro_sql = " Campo si242_totaldebitoscde não informado.";
        $this->erro_campo = "si242_totaldebitoscde";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_totalcreditoscde) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_totalcreditoscde"])) {
      $sql .= $virgula . " si242_totalcreditoscde = $this->si242_totalcreditoscde ";
      $virgula = ",";
      if (trim($this->si242_totalcreditoscde) == null) {
        $this->erro_sql = " Campo si242_totalcreditoscde não informado.";
        $this->erro_campo = "si242_totalcreditoscde";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_saldofinalcde) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_saldofinalcde"])) {
      $sql .= $virgula . " si242_saldofinalcde = $this->si242_saldofinalcde ";
      $virgula = ",";
      if (trim($this->si242_saldofinalcde) == null) {
        $this->erro_sql = " Campo si242_saldofinalcde não informado.";
        $this->erro_campo = "si242_saldofinalcde";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_naturezasaldofinalcde) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_naturezasaldofinalcde"])) {
      $sql .= $virgula . " si242_naturezasaldofinalcde = '$this->si242_naturezasaldofinalcde' ";
      $virgula = ",";
      if (trim($this->si242_naturezasaldofinalcde) == null) {
        $this->erro_sql = " Campo si242_naturezasaldofinalcde não informado.";
        $this->erro_campo = "si242_naturezasaldofinalcde";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_mes"])) {
      $sql .= $virgula . " si242_mes = $this->si242_mes ";
      $virgula = ",";
      if (trim($this->si242_mes) == null) {
        $this->erro_sql = " Campo si242_mes não informado.";
        $this->erro_campo = "si242_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si242_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si242_instit"])) {
      $sql .= $virgula . " si242_instit = $this->si242_instit ";
      $virgula = ",";
      if (trim($this->si242_instit) == null) {
        $this->erro_sql = " Campo si242_instit não informado.";
        $this->erro_campo = "si242_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si242_sequencial != null) {
      $sql .= " si242_sequencial = $this->si242_sequencial";
    }

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete302024 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si242_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete302024 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si242_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si242_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si242_sequencial = null, $dbwhere = null)
  {
    $sql = " delete from balancete302024
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si242_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si242_sequencial = $si242_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete302024 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si242_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete302024 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si242_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si242_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete302024";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si242_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete302024 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si242_sequencial != null) {
        $sql2 .= " where balancete302024.si242_sequencial = $si242_sequencial ";
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
  function sql_query_file($si242_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete302024 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si242_sequencial != null) {
        $sql2 .= " where balancete302024.si242_sequencial = $si242_sequencial ";
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

  function sql_saldo_balanceteReg30($aContas, $sWhere, $iCoddot, $nMes, $nContaCorrente, $sWhereEncerramento)
  {
    $sSqlRegSaldos = " SELECT
                                          (SELECT case when round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) = '0.00' then null else round(coalesce(saldoimplantado,0) + coalesce(debitoatual,0) - coalesce(creditoatual,0),2) end AS saldoinicial
                                           FROM
                                             (SELECT
                                                (SELECT CASE WHEN c29_debito > 0 THEN c29_debito WHEN c29_credito > 0 THEN -1 * c29_credito ELSE 0 END AS saldoanterior
                                                 FROM contacorrente
                                                 INNER JOIN contacorrentedetalhe ON contacorrente.c17_sequencial = contacorrentedetalhe.c19_contacorrente
                                                 INNER JOIN contacorrentesaldo ON contacorrentesaldo.c29_contacorrentedetalhe = contacorrentedetalhe.c19_sequencial
                                                 AND contacorrentesaldo.c29_mesusu = 0 and contacorrentesaldo.c29_anousu = " . db_getsession("DB_anousu") . " and c19_conplanoreduzanousu = " . db_getsession("DB_anousu") . "
                                                 WHERE c19_reduz IN (" . implode(',', $aContas) . ") " . $sWhere . "
                                                   AND c17_sequencial = {$nContaCorrente}
                                                   AND c19_orcdotacao = {$iCoddot}) AS saldoimplantado,

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
                                                     AND c19_reduz IN (" . implode(',', $aContas) . ") " . $sWhere . "
                                                     AND c19_instit = " . db_getsession("DB_instit") . "
                                                     AND c19_orcdotacao = {$iCoddot}
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
                                                     AND c19_reduz IN (" . implode(',', $aContas) . ") " . $sWhere . "
                                                     AND c19_instit = " . db_getsession("DB_instit") . "
                                                     AND c19_orcdotacao = {$iCoddot}
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
                                             AND c19_reduz IN (" . implode(',', $aContas) . ") " . $sWhere . "
                                             AND c19_instit = " . db_getsession("DB_instit") . "
                                             AND c19_orcdotacao = {$iCoddot}
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
                                             AND c19_reduz IN (" . implode(',', $aContas) . ") " . $sWhere . "
                                             AND c19_instit = " . db_getsession("DB_instit") . "
                                             AND c19_orcdotacao = {$iCoddot}
                                             {$sWhereEncerramento}
                                           GROUP BY c28_tipo) AS debitos";

        return $sSqlRegSaldos;
  }

  function sql_query_dotacoes($aNaturDespTipoDespesa, $iNregobrig, $aContas, $nMes)
  {
    $sSqlDotacoes = "select distinct o58_coddot as c73_coddot,
                            si09_codorgaotce as codorgao,
                            case when o41_subunidade != 0 or not null then
                            lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0)||lpad(o41_subunidade::integer,3,0)
                            else lpad((case when o40_codtri = '0' or null then o40_orgao::varchar else o40_codtri end),2,0)||lpad((case when o41_codtri = '0' or null then o41_unidade::varchar else o41_codtri end),3,0) end as codunidadesub,
                            o58_funcao as codfuncao,
                            o58_subfuncao as codsubfuncao,
                            o58_programa as codprograma,
                            o58_projativ as idacao,
                            o55_origemacao as idsubacao,
                            substr(o56_elemento,2,12) as naturezadadespesa,
                            substr(o56_elemento,8,2) as subelemento,
                            o15_codigo, o15_codtri as codfontrecursos,
                            e60_numemp,
                            case
                                when si09_tipoinstit IN (5,6)
                                    and substr(o56_elemento,2,8) in ({$aNaturDespTipoDespesa})
                                    and $iNregobrig = 30 then e60_tipodespesa
                                else 0
                            end as e60_tipodespesa, e60_emendaparlamentar, e60_esferaemendaparlamentar
                from conlancamval
                inner join contacorrentedetalheconlancamval on c69_sequen = c28_conlancamval
                inner join contacorrentedetalhe on c19_sequencial = c28_contacorrentedetalhe
                inner join empempenho on c19_numemp = e60_numemp
                inner join empelemento on e64_numemp = e60_numemp
                inner join orcdotacao on e60_coddot = o58_coddot and e60_anousu = o58_anousu
                inner join orcunidade on o41_anousu = o58_anousu and o41_orgao = o58_orgao and o41_unidade = o58_unidade
                inner join orcorgao on o40_orgao = o41_orgao and o40_anousu = o41_anousu
                inner join orcelemento ON o56_codele = e64_codele and e60_anousu = o56_anousu
                inner join orcprojativ on o58_anousu = o55_anousu and o58_projativ = o55_projativ
                inner join orctiporec ON o58_codigo = o15_codigo
                    left join infocomplementaresinstit on  o58_instit = si09_instit
                where o58_instit = " . db_getsession('DB_instit') . " and DATE_PART('YEAR',c69_data) = " . db_getsession("DB_anousu") . " and DATE_PART('MONTH',c69_data) <= {$nMes}
                and (c69_credito in (" . implode(',', $aContas) . ") or c69_debito in (" . implode(',', $aContas) . "))";

     return $sSqlDotacoes;
  }
}

?>
