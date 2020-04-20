<?
//MODULO: sicom
//CLASSE DA ENTIDADE ralic112020
class cl_ralic112020
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
  var $si181_sequencial = 0;
  var $si181_tiporegistro = 0;
  var $si181_codorgaoresp = null;
  var $si181_codunidadesubresp = null;
  var $si181_codunidadesubrespestadual = null;
  var $si181_exerciciolicitacao = 0;
  var $si181_codobralocal = 0;
  var $si181_classeobjeto = 0;
  var $si181_tipoatividadeobra = 0;
  var $si181_tipoatividadeservico = null;
  var $si181_dsctividadeservico = '';
  var $si181_tipoatividadeservespecializado = 0;
  var $si181_dscatividadeservespecializado = '';
  var $si181_codfuncao = '';
  var $si181_codsubfuncao = '';
  var $si181_codbempublico = 0;
  var $si181_mes = 0;
  var $si181_instit = 0;
  var $si181_reg10 = 0;
  var $campos = "
                 si181_sequencial = int8 = sequencial
                 si181_tiporegistro = int8 = Tipo do registro
                 si181_codorgaoresp = varchar(2) = Código do órgão
                 si181_codunidadesubresp = varchar(8) = Código da unidade
                 si181_codunidadesubrespestadual = varchar(4) = Código da unidade responsável
                 si181_exerciciolicitacao = int8 = Exercício da licitação
                 si181_nroprocessolicitatorio = varchar(12) = Número sequencial do processo
                 si181_codobralocal = int8 = Número sequencial do processo
                 si181_classeobjeto = int8 = Classe do objeto
                 si181_tipoatividadeobra = int8 = Atividade da obra
                 si181_tipoatividadeservico = int8 = Atividade do serviço
                 si181_dscatividadeservico = varchar(150) = Classe do objeto
                 si181_tipoatividadeservespecializado = int8 = Serviço técnico especializado
                 si181_dscatividadeservespecializado = varchar(150) = Descrição do Serviço especializado
                 si181_codfuncao = varchar(2) = Código da função
                 si181_codsubfuncao = varchar(3) = Código da função
                 si181_codbempublico = int8 = Código do equipamento
                 si181_mes = int8 = Mês
                 si181_instit = int8 = Instituição
                 ";
  // cria propriedade com as variaveis do arquivo

  //funcao construtor da classe
  function cl_ralic112020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ralic112020");
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
      $this->si181_sequencial = ($this->si181_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_sequencial"] : $this->si181_sequencial);
      $this->si181_tiporegistro = ($this->si181_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_tiporegistro"] : $this->si181_tiporegistro);
      $this->si181_codorgaoresp = ($this->si181_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codorgaoresp"] : $this->si181_codorgaoresp);
      $this->si181_codunidadesubresp = ($this->si181_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codunidadesubresp"] : $this->si181_codunidadesubresp);
      $this->si181_codunidadesubrespestadual = ($this->si181_codunidadesubrespestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codunidadesubrespestadual"] : $this->si181_codunidadesubrespestadual);
      $this->si181_exerciciolicitacao = ($this->si181_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_exerciciolicitacao"] : $this->si181_exerciciolicitacao);
      $this->si181_nroprocessolicitatorio = ($this->si181_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_nroprocessolicitatorio"] : $this->si181_nroprocessolicitatorio);
      $this->si181_codobralocal = ($this->si181_codobralocal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codobralocal"] : $this->si181_codobralocal);
      $this->si181_classeobjeto = ($this->si181_classeobjeto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_classeobjeto"] : $this->si181_classeobjeto);
      $this->si181_tipoatividadeobra = ($this->si181_tipoatividadeobra == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_tipoatividadeobra"] : $this->si181_tipoatividadeobra);
      $this->si181_tipoatividadeservico = ($this->si181_tipoatividadeservico == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_tipoatividadeservico"] : $this->si181_tipoatividadeservico);
      $this->si181_dscatividadeservico = ($this->si181_dscatividadeservico == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_dscatividadeservico"] : $this->si181_dscatividadeservico);
      $this->si181_tipoatividadeservespecializado = ($this->si181_tipoatividadeservespecializado == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_tipoatividadeservespecializado"] : $this->si181_tipoatividadeservespecializado);
      $this->si181_dscatividadeservespecializado = ($this->si181_dscatividadeservespecializado == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_dscatividadeservespecializado"] : $this->si181_dscatividadeservespecializado);
      $this->si181_codfuncao = ($this->si181_codfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codfuncao"] : $this->si181_codfuncao);
      $this->si181_codsubfuncao = ($this->si181_codsubfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codsubfuncao"] : $this->si181_codsubfuncao);
      $this->si181_codbempublico = ($this->si181_codbempublico == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_codbempublico"] : $this->si181_codbempublico);
      $this->si181_reg10 = ($this->si181_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_reg10"] : $this->si181_reg10);
      $this->si181_mes = ($this->si181_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_mes"] : $this->si181_mes);
      $this->si181_instit = ($this->si181_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_instit"] : $this->si181_instit);
    } else {
      $this->si181_sequencial = ($this->si181_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si181_sequencial"] : $this->si181_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si181_sequencial)
  {
    $this->atualizacampos();
    if ($this->si181_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si181_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si181_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si181_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si181_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si181_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si181_sequencial == "" || $si181_sequencial == null) {
      $result = db_query("select nextval('ralic112020_si181_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ralic112020_si181_sequencial_seq do campo: si181_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si181_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ralic112020_si181_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si181_sequencial)) {
        $this->erro_sql = " Campo si181_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si181_sequencial = $si181_sequencial;
      }
    }
    if (($this->si181_sequencial == null) || ($this->si181_sequencial == "")) {
      $this->erro_sql = " Campo si181_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if(!$this->si181_tipoatividadeservico){
      $this->si181_tipoatividadeservico = 'null';
    }

    if(!$this->si181_tipoatividadeservespecializado){
      $this->si181_tipoatividadeservespecializado = 'null';
    }


    $sql = "insert into ralic112020(
                                       si181_sequencial
                                      ,si181_tiporegistro
                                      ,si181_codorgaoresp
                                      ,si181_codunidadesubresp
                                      ,si181_codunidadesubrespestadual
                                      ,si181_exerciciolicitacao
                                      ,si181_nroprocessolicitatorio
                                      ,si181_codobralocal
                                      ,si181_classeobjeto
                                      ,si181_tipoatividadeobra
                                      ,si181_tipoatividadeservico
                                      ,si181_dscatividadeservico
                                      ,si181_tipoatividadeservespecializado
                                      ,si181_dscatividadeservespecializado
                                      ,si181_codfuncao
                                      ,si181_codsubfuncao
                                      ,si181_codbempublico
                                      ,si181_reg10
                                      ,si181_mes
                                      ,si181_instit
                       )
                values (
                                $this->si181_sequencial
                               ,$this->si181_tiporegistro
                               ,'$this->si181_codorgaoresp'
                               ,'$this->si181_codunidadesubresp'
                               ,'$this->si181_codunidadesubrespestadual'
                               ,$this->si181_exerciciolicitacao
                               ,'$this->si181_nroprocessolicitatorio'
                               ,$this->si181_codobralocal
                               ,$this->si181_classeobjeto
                               ,$this->si181_tipoatividadeobra
                               ,$this->si181_tipoatividadeservico 
                               ,'$this->si181_dsctividadeservico'
                               ,$this->si181_tipoatividadeservespecializado
                               ,'$this->si181_dscatividadeservespecializado'
                               ,'$this->si181_codfuncao'
                               ,'$this->si181_codsubfuncao'
                               ,$this->si181_codbempublico
                               ,$this->si181_reg10
                               ,$this->si181_mes
                               ,$this->si181_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ralic112020 ($this->si181_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ralic112020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ralic112020 ($this->si181_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si181_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si181_sequencial));

    return true;
  }

  // funcao para alteracao
  function alterar($si181_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ralic112020 set ";
    $virgula = "";
    if (trim($this->si181_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_sequencial"])) {
      if (trim($this->si181_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si181_sequencial"])) {
        $this->si181_sequencial = "0";
      }
      $sql .= $virgula . " si181_sequencial = $this->si181_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si181_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_tiporegistro"])) {
      $sql .= $virgula . " si181_tiporegistro = $this->si181_tiporegistro ";
      $virgula = ",";
      if (trim($this->si181_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si181_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si181_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codorgaoresp"])) {
      $sql .= $virgula . " si181_codorgaoresp = '$this->si181_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si181_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_codunidadesubresp"])) {
      $sql .= $virgula . " si181_codunidadesubresp = '$this->si181_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si181_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_exerciciolicitacao"])) {
      if (trim($this->si181_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si181_exerciciolicitacao"])) {
        $this->si181_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si181_exerciciolicitacao = $this->si181_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si181_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si181_nroprocessolicitatorio = '$this->si181_nroprocessolicitatorio' ";
      $virgula = ",";
    }




    if (trim($this->si181_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_mes"])) {
      $sql .= $virgula . " si181_mes = $this->si181_mes ";
      $virgula = ",";
      if (trim($this->si181_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si181_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si181_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si181_instit"])) {
      $sql .= $virgula . " si181_instit = $this->si181_instit ";
      $virgula = ",";
      if (trim($this->si181_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si181_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si181_sequencial != null) {
      $sql .= " si181_sequencial = $this->si181_sequencial";
    }

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ralic112020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si181_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ralic112020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si181_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si181_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si181_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si181_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    $sql = " delete from ralic112020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si181_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si181_sequencial = $si181_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ralic112020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si181_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ralic112020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si181_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si181_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ralic112020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si181_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ralic112020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si181_sequencial != null) {
        $sql2 .= " where ralic112020.si181_sequencial = $si181_sequencial ";
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
  function sql_query_file($si181_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ralic112020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si181_sequencial != null) {
        $sql2 .= " where ralic112020.si181_sequencial = $si181_sequencial ";
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
