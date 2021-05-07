<?
//MODULO: sicom
//CLASSE DA ENTIDADE ralic122021
class cl_ralic122021
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
  var $si182_sequencial = 0;
  var $si182_tiporegistro = 0;
  var $si182_codorgaoresp = null;
  var $si182_codunidadesubresp = null;
  var $si182_codunidadesubrespestadual = null;
  var $si182_exercicioprocesso = 0;
  var $si182_nroprocessolicitatorio = 0;
  var $si182_codobralocal = 0;
  var $si182_logradouro = 0;
  var $si182_numero = 0;
  var $si182_bairro = '';
  var $si182_distrito = '';
  var $si182_municipio = '';
  var $si182_cep = '';
  var $si182_latitude = '';
  var $si182_longitude = '';
  var $si182_nrolote = '';
  var $si182_codbempublico = '';
  var $si182_mes = 0;
  var $si182_instit = 0;
  var $si182_reg10 = 0;
  var $campos = "
                 si182_sequencial = int8 = sequencial
                 si182_tiporegistro = int8 = Tipo do registro
                 si182_codorgaoresp = varchar(2) = Código do órgão
                 si182_codunidadesubresp = varchar(8) = Código da unidade
                 si182_codunidadesubrespestadual = varchar(4) = Código da unidade responsável
                 si182_exercicioprocesso = int8 = Exercício da dispensa ou inexigibilidade
                 si182_nroprocessolicitatorio = varchar(12) = Número sequencial do processo
                 si182_codobralocal = int8 = Código identificador das obras e serviços
                 si182_logradouro = varchar(100) = Nome do logradouro
                 si182_numero = int4 = Número
                 si182_bairro = varchar(100) = Nome do bairro
                 si182_distrito = varchar(100) = Nome do distrito
                 si182_municipio = varchar(50) = Nome do município
                 si182_cep = int8 = Número do CEP
                 si182_latitude = int4 = Graus da Latitude
                 si182_longitude = int4 = Graus da Longitude
                 si182_nrolote = int4 = Número Lote
                 si182_codbempublico = int4 = Código Bem Público
                 si182_mes = int8 = Mês
                 si182_instit = int8 = Instituição
                 si182_reg10 = int8 = Registro 10

                 ";
  // cria propriedade com as variaveis do arquivo

  //funcao construtor da classe
  function cl_ralic122021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ralic122021");
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
      $this->si182_sequencial = ($this->si182_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_sequencial"] : $this->si182_sequencial);
      $this->si182_tiporegistro = ($this->si182_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_tiporegistro"] : $this->si182_tiporegistro);
      $this->si182_codorgaoresp = ($this->si182_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_codorgaoresp"] : $this->si182_codorgaoresp);
      $this->si182_codunidadesubresp = ($this->si182_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_codunidadesubresp"] : $this->si182_codunidadesubresp);
      $this->si182_codunidadesubrespestadual = ($this->si182_codunidadesubrespestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_codunidadesubrespestadual"] : $this->si182_codunidadesubrespestadual);
      $this->si182_exercicioprocesso = ($this->si182_exercicioprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_exercicioprocesso"] : $this->si182_exercicioprocesso);
      $this->si182_nroprocessolicitatorio = ($this->si182_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_nroprocessolicitatorio"] : $this->si182_nroprocessolicitatorio);
      $this->si182_codobralocal = ($this->si182_codobralocal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_codobralocal"] : $this->si182_codobralocal);
      $this->si182_logradouro = ($this->si182_logradouro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_logradouro"] : $this->si182_logradouro);
      $this->si182_numero = ($this->si182_numero == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_numero"] : $this->si182_numero);
      $this->si182_bairro = ($this->si182_bairro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_bairro"] : $this->si182_bairro);
      $this->si182_distrito = ($this->si182_distrito == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_distrito"] : $this->si182_distrito);
      $this->si182_municipio = ($this->si182_municipio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_municipio"] : $this->si182_municipio);
      $this->si182_cep = ($this->si182_cep == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_cep"] : $this->si182_cep);
      $this->si182_latitude = ($this->si182_latitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si182_latitude"] : $this->si182_latitude);
      $this->si182_longitude = ($this->si182_longitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si182_longitude"] : $this->si182_longitude);
      $this->si182_nrolote = ($this->si182_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si182_nrolote"] : $this->si182_nrolote);
      $this->si182_codbempublico = ($this->si182_codbempublico == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si182_codbempublico"] : $this->si182_codbempublico);
      $this->si182_reg10 = ($this->si182_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_reg10"] : $this->si182_reg10);
      $this->si182_mes = ($this->si182_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_mes"] : $this->si182_mes);
      $this->si182_instit = ($this->si182_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_instit"] : $this->si182_instit);
    } else {
      $this->si182_sequencial = ($this->si182_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_sequencial"] : $this->si182_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si182_sequencial)
  {
    $this->atualizacampos();
    if ($this->si182_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si182_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si182_cep == null) {
      $this->si182_cep = 0;
    }

    if ($this->si182_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si182_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si182_codbempublico == null) {
      $this->erro_sql = " Campo Código do Bem Público não Informado.";
      $this->erro_campo = "si182_codbempublico";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si182_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si182_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si182_sequencial == "" || $si182_sequencial == null) {
      $result = db_query("select nextval('ralic122021_si182_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ralic122021_si182_sequencial_seq do campo: si182_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si182_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ralic122021_si182_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si182_sequencial)) {
        $this->erro_sql = " Campo si182_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si182_sequencial = $si182_sequencial;
      }
    }
    if (($this->si182_sequencial == null) || ($this->si182_sequencial == "")) {
      $this->erro_sql = " Campo si182_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if (!$this->si182_numero || $this->si182_numero == null) {
      $this->si182_numero = 0;
    }
    $sql = "insert into ralic122021(
                                       si182_sequencial
                                      ,si182_tiporegistro
                                      ,si182_codorgaoresp
                                      ,si182_codunidadesubresp
                                      ,si182_codunidadesubrespestadual
                                      ,si182_exercicioprocesso
                                      ,si182_nroprocessolicitatorio
                                      ,si182_codobralocal
                                      ,si182_logradouro
                                      ,si182_numero
                                      ,si182_bairro
                                      ,si182_distrito
                                      ,si182_municipio
                                      ,si182_cep
                                      ,si182_latitude
                                      ,si182_longitude
                                      ,si182_nrolote
                                      ,si182_codbempublico
                                      ,si182_reg10
                                      ,si182_mes
                                      ,si182_instit
                       )
                values (
                                $this->si182_sequencial
                               ,$this->si182_tiporegistro
                               ,'$this->si182_codorgaoresp'
                               ,'$this->si182_codunidadesubresp'
                               ,'$this->si182_codunidadesubrespestadual'
                               ,$this->si182_exercicioprocesso
                               ,'$this->si182_nroprocessolicitatorio'
                               ,$this->si182_codobralocal
                               ,'$this->si182_logradouro'
                               ,$this->si182_numero
                               ,'$this->si182_bairro'
                               ,'$this->si182_distrito'
                               ,'$this->si182_municipio'
                               ,$this->si182_cep
                               ,$this->si182_latitude
                               ,$this->si182_longitude
                               ,$this->si182_nrolote
                               ,$this->si182_codbempublico
                               ,$this->si182_reg10
                               ,$this->si182_mes
                               ,$this->si182_instit
                      )";

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ralic122021 ($this->si182_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ralic122021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ralic122021 ($this->si182_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si182_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si182_sequencial));

    return true;
  }

  // funcao para alteracao
  function alterar($si182_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ralic122021 set ";
    $virgula = "";
    if (trim($this->si182_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_sequencial"])) {
      if (trim($this->si182_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si182_sequencial"])) {
        $this->si182_sequencial = "0";
      }
      $sql .= $virgula . " si182_sequencial = $this->si182_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si182_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_tiporegistro"])) {
      $sql .= $virgula . " si182_tiporegistro = $this->si182_tiporegistro ";
      $virgula = ",";
      if (trim($this->si182_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si182_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si182_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_codorgaoresp"])) {
      $sql .= $virgula . " si182_codorgaoresp = '$this->si182_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si182_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_codunidadesubresp"])) {
      $sql .= $virgula . " si182_codunidadesubresp = '$this->si182_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si182_exercicioprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_exercicioprocesso"])) {
      if (trim($this->si182_exercicioprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si182_exercicioprocesso"])) {
        $this->si182_exercicioprocesso = "0";
      }
      $sql .= $virgula . " si182_exercicioprocesso = $this->si182_exercicioprocesso ";
      $virgula = ",";
    }
    if (trim($this->si182_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si182_nroprocessolicitatorio = '$this->si182_nroprocessolicitatorio' ";
      $virgula = ",";
    }




    if (trim($this->si182_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_mes"])) {
      $sql .= $virgula . " si182_mes = $this->si182_mes ";
      $virgula = ",";
      if (trim($this->si182_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si182_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si182_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_instit"])) {
      $sql .= $virgula . " si182_instit = $this->si182_instit ";
      $virgula = ",";
      if (trim($this->si182_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si182_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si182_sequencial != null) {
      $sql .= " si182_sequencial = $this->si182_sequencial";
    }

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ralic122021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si182_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ralic122021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si182_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si182_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si182_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si182_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    $sql = " delete from ralic122021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si182_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si182_sequencial = $si182_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ralic122021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si182_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ralic122021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si182_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si182_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ralic122021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si182_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ralic122021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si182_sequencial != null) {
        $sql2 .= " where ralic122021.si182_sequencial = $si182_sequencial ";
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
  function sql_query_file($si182_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ralic122021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si182_sequencial != null) {
        $sql2 .= " where ralic122021.si182_sequencial = $si182_sequencial ";
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
