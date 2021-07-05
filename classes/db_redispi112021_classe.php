<?
//MODULO: sicom
//CLASSE DA ENTIDADE redispi112021
class cl_redispi112021
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
  var $si184_sequencial = 0;
  var $si184_tiporegistro = 0;
  var $si184_codorgaoresp = null;
  var $si184_codunidadesubresp = null;
  var $si184_codunidadesubrespestadual = null;
  var $si184_exercicioprocesso = 0;
  var $si184_nroprocesso = null;
  var $si184_codobralocal  = null;
  var $si184_tipoprocesso = 0;
  var $si184_classeobjeto = 0;
  var $si184_tipoatividadeobra = 0;
  var $si184_tipoatividadeservico = 0;
  var $si184_dscatividadeservico = '';
  var $si184_tipoatividadeservespecializado = 0;
  var $si184_dscatividadeservespecializado = '';
  var $si184_codfuncao = '';
  var $si184_codsubfuncao = '';
  var $si184_codbempublico = 0;
  var $si184_reg10 = 0;
  var $si184_mes = 0;
  var $si184_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si184_sequencial = int8 = sequencial 
                 si184_tiporegistro = int8 = Tipo do  registro 
                 si184_codorgaoresp = varchar(2) = Código do órgão responsável 
                 si184_codunidadesubresp = varchar(8) = Código da unidade 
                 si184_codunidadesubrespestadual = varchar(4) = Código da unidade responsável 
                 si184_exercicioprocesso = int8 = Exercício em que foi instaurado 
                 si184_nroprocesso = varchar(12) = Número sequencial  do processo 
                 si184_tipoprocesso = int8 = Tipo de processo 
                 si184_classeobjeto = int4 = Classe do objeto 
                 si184_tipoatividadeobra = int4 = Tipo Atividade Obra 
                 si184_tipoatividadeservico = int4 = Tipo Atividade Serviço 
                 si184_dscatividadeservico = varchar(150) = Descrição das atividades do serviço 
                 si184_tipoatividadeserviespecializado = int4 = Tipo Atividade Serviço Técnico Especializado 
                 si184_dscatividadeserviespecializado = varchar(150) = Descrição das atividades do serviço Especializado
                 si184_codfuncao = char(2) = Código da Função 
                 si184_codsubfuncao = char(3) = Código da Subfunção 
                 si184_codbempublico = int4 = Código do Equipamento ou bem público 
                 si184_reg10 = int8 = Registro 10 
                 si184_mes = int8 = Mês 
                 si184_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_redispi112021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("redispi112021");
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
      $this->si184_sequencial = ($this->si184_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_sequencial"] : $this->si184_sequencial);
      $this->si184_tiporegistro = ($this->si184_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_tiporegistro"] : $this->si184_tiporegistro);
      $this->si184_codorgaoresp = ($this->si184_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_codorgaoresp"] : $this->si184_codorgaoresp);
      $this->si184_codunidadesubresp = ($this->si184_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_codunidadesubresp"] : $this->si184_codunidadesubresp);
      $this->si184_codunidadesubrespestadual = ($this->si184_codunidadesubrespestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_codunidadesubrespestadual"] : $this->si184_codunidadesubrespestadual);
      $this->si184_exercicioprocesso = ($this->si184_exercicioprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_exercicioprocesso"] : $this->si184_exercicioprocesso);
      $this->si184_nroprocesso = ($this->si184_nroprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_nroprocesso"] : $this->si184_nroprocesso);
      $this->si184_codobralocal = ($this->si184_codobralocal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_codobralocal"] : $this->si184_codobralocal);
      $this->si184_tipoprocesso = ($this->si184_tipoprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_tipoprocesso"] : $this->si184_tipoprocesso);
      $this->si184_classeobjeto = ($this->si184_classeobjeto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_classeobjeto"] : $this->si184_classeobjeto);
      $this->si184_tipoatividadeobra = ($this->si184_tipoatividadeobra == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_tipoatividadeobra"] : $this->si184_tipoatividadeobra);
      $this->si184_tipoatividadeservico = ($this->si184_tipoatividadeservico == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si184_tipoatividadeservico"] : $this->si184_tipoatividadeservico);
      $this->si184_dscatividadeservico = ($this->si184_dscatividadeservico == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si184_dscatividadeservico"] : $this->si184_dscatividadeservico);
      $this->si184_tipoatividadeservespecializado = ($this->si184_tipoatividadeservespecializado == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si184_tipoatividadeservespecializado"] : $this->si184_tipoatividadeservespecializado);
      $this->si184_dscatividadeservespecializado = ($this->si184_dscatividadeservespecializado == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si184_dscatividadeservespecializado"] : $this->si184_dscatividadeservespecializado);
      $this->si184_codfuncao = ($this->si184_codfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si184_codfuncao"] : $this->si184_codfuncao);
      $this->si184_codsubfuncao = ($this->si184_codsubfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si184_codsubfuncao"] : $this->si184_codsubfuncao);
      $this->si184_codbempublico = ($this->si184_codbempublico == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si184_codbempublico"] : $this->si184_codbempublico);
      $this->si184_reg10 = ($this->si184_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_reg10"] : $this->si184_reg10);
      $this->si184_mes = ($this->si184_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_mes"] : $this->si184_mes);
      $this->si184_instit = ($this->si184_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_instit"] : $this->si184_instit);
    } else {
      $this->si184_sequencial = ($this->si184_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_sequencial"] : $this->si184_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si184_sequencial)
  {
    $this->atualizacampos();
    if ($this->si184_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si184_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si184_exercicioprocesso == null) {
      $this->si184_exercicioprocesso = "0";
    }
    if ($this->si184_tipoprocesso == null) {
      $this->si184_tipoprocesso = "0";
    }

    if ($this->si184_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si184_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si184_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si184_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si184_sequencial == "" || $si184_sequencial == null) {
      $result = db_query("select nextval('redispi112021_si184_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: si184_sequencial_seq do campo: si184_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si184_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from si184_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si184_sequencial)) {
        $this->erro_sql = " Campo si184_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si184_sequencial = $si184_sequencial;
      }
    }
    if (($this->si184_sequencial == null) || ($this->si184_sequencial == "")) {
      $this->erro_sql = " Campo si184_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }

    if($this->si184_codobralocal == null){
        $this->si184_codobralocal = 0;
    }

    if($this->si184_tipoatividadeobra == null){
        $this->si184_tipoatividadeobra = 0;
    }

    if($this->si184_tipoatividadeservespecializado == null){
        $this->si184_tipoatividadeservespecializado = 0;
    }


    $sql = "insert into redispi112021(
                                       si184_sequencial 
                                      ,si184_tiporegistro 
                                      ,si184_codorgaoresp 
                                      ,si184_codunidadesubresp 
                                      ,si184_codunidadesubrespestadual 
                                      ,si184_exercicioprocesso 
                                      ,si184_nroprocesso 
                                      ,si184_codobralocal 
                                      ,si184_tipoprocesso 
                                      ,si184_classeobjeto
                                      ,si184_tipoatividadeobra
                                      ,si184_tipoatividadeservico
                                      ,si184_dscatividadeservico
                                      ,si184_tipoatividadeservespecializado
                                      ,si184_dscatividadeservespecializado
                                      ,si184_codfuncao
                                      ,si184_codsubfuncao
                                      ,si184_codbempublico
                                      ,si184_reg10
                                      ,si184_mes 
                                      ,si184_instit 
                       )
                values (
                                $this->si184_sequencial 
                               ,$this->si184_tiporegistro 
                               ,'$this->si184_codorgaoresp' 
                               ,'$this->si184_codunidadesubresp' 
                               ,'$this->si184_codunidadesubrespestadual' 
                               ,$this->si184_exercicioprocesso 
                               ,'$this->si184_nroprocesso' 
                               ,$this->si184_codobralocal 
                               ,$this->si184_tipoprocesso 
                               ,$this->si184_classeobjeto 
                               ,$this->si184_tipoatividadeobra 
                               ,$this->si184_tipoatividadeservico 
                               ,'$this->si184_dscatividadeservico'
                               ,$this->si184_tipoatividadeservespecializado
                               ,'$this->si184_dscatividadeservespecializado'
                               ,'$this->si184_codfuncao'
                               ,'$this->si184_codsubfuncao'
                               ,$this->si184_codbempublico
                               ,$this->si184_reg10 
                               ,$this->si184_mes 
                               ,$this->si184_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "redispi112021 ($this->si184_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "redispi112021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "redispi112021 ($this->si184_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si184_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);

    return true;
  }

  // funcao para alteracao
  function alterar($si184_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update redispi112021 set ";
    $virgula = "";
    if (trim($this->si184_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_sequencial"])) {
      if (trim($this->si184_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si184_sequencial"])) {
        $this->si184_sequencial = "0";
      }
      $sql .= $virgula . " si184_sequencial = $this->si184_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si184_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_tiporegistro"])) {
      $sql .= $virgula . " si184_tiporegistro = $this->si184_tiporegistro ";
      $virgula = ",";
      if (trim($this->si184_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si184_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si184_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_codorgaoresp"])) {
      $sql .= $virgula . " si184_codorgaoresp = '$this->si184_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si184_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_codunidadesubresp"])) {
      $sql .= $virgula . " si184_codunidadesubresp = '$this->si184_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si184_exercicioprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_exercicioprocesso"])) {
      if (trim($this->si184_exercicioprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si184_exercicioprocesso"])) {
        $this->si184_exercicioprocesso = "0";
      }
      $sql .= $virgula . " si184_exercicioprocesso = $this->si184_exercicioprocesso ";
      $virgula = ",";
    }
    if (trim($this->si184_nroprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_nroprocesso"])) {
      $sql .= $virgula . " si184_nroprocesso = '$this->si184_nroprocesso' ";
      $virgula = ",";
    }
    if (trim($this->si184_tipoprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_tipoprocesso"])) {
      if (trim($this->si184_tipoprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si184_tipoprocesso"])) {
        $this->si184_tipoprocesso = "0";
      }
      $sql .= $virgula . " si184_tipoprocesso = $this->si184_tipoprocesso ";
      $virgula = ",";
    }


    if (trim($this->si184_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_mes"])) {
      $sql .= $virgula . " si184_mes = $this->si184_mes ";
      $virgula = ",";
      if (trim($this->si184_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si184_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si184_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_instit"])) {
      $sql .= $virgula . " si184_instit = $this->si184_instit ";
      $virgula = ",";
      if (trim($this->si184_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si184_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si184_sequencial != null) {
      $sql .= " si184_sequencial = $this->si184_sequencial";
    }


    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "redispi112021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si184_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "redispi112021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si184_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si184_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si184_sequencial = null, $dbwhere = null)
  {

    $sql = " delete from redispi112021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si184_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si184_sequencial = si184_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "redispi112021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si184_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "redispi112021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si184_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si184_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:redispi112021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query($si184_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from redispi112021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si184_sequencial != null) {
        $sql2 .= " where redispi112021.si184_sequencial = si184_sequencial ";
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
  function sql_query_file($si184_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from redispi112021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si184_sequencial != null) {
        $sql2 .= " where redispi112021.si184_sequencial = si184_sequencial ";
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
