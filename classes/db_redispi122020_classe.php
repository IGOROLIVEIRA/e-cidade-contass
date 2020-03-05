<?
//MODULO: sicom
//CLASSE DA ENTIDADE redispi122020
class cl_redispi122020
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
  var $si185_sequencial = 0;
  var $si185_tiporegistro = 0;
  var $si185_codorgaoresp = null;
  var $si185_codunidadesubresp = null;
  var $si185_codunidadesubrespestadual = null;
  var $si185_exercicioprocesso = 0;
  var $si185_nroprocesso = null;
  var $si185_codobralocal  = null;
  var $si185_logradouro  = null;
  var $si185_numero  = 0;
  var $si185_bairro  = '';
  var $si185_cidade  = '';
  var $si185_cep  = '';
  var $si185_graulatitude  = 0;
  var $si185_minutolatitude  = 0;
  var $si185_segundolatitude  = 0;
  var $si185_graulongitude  = 0;
  var $si185_minutolongitude  = 0;
  var $si185_segundolongitude  = 0;
  var $si185_reg10 = 0;
  var $si185_mes = 0;
  var $si185_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si185_sequencial = int8 = sequencial 
                 si185_tiporegistro = int8 = Tipo do  registro 
                 si185_codorgaoresp = varchar(2) = Código do órgão responsável 
                 si185_codunidadesubresp = varchar(8) = Código da unidade 
                 si185_codunidadesubrespestadual = varchar(4) = Código da unidade responsável 
                 si185_exercicioprocesso = int8 = Exercício em que foi instaurado 
                 si185_nroprocesso = varchar(12) = Número sequencial  do processo 
                 si185_logradouro  = varchar(100) = Logradouro
                 si185_numero  = int4 = Número 
                 si185_bairro  = varchar(100) = Nome do Bairro;
                 si185_cidade  = varchar(100) = Nome da cidade;
                 si185_cep  = int4 = Número do CEP;
                 si185_graulatitude = int4 = Coordenada em Graus Latitude;
                 si185_minutolatitude  = int4 = Coordenada em Minuto da Latitude;
                 si185_segundolatitude  = int4 = Coordenada em Segundo da Latitude;
                 si185_graulongitude  = int4 = Coordenada em Graus da Longitude;
                 si185_minutolongitude  = int4 = Coordenada em Minuto da Longitude;
                 si185_segundolongitude  = int4 = Coordenada em Minuto da Longitude;
                 si185_reg10 = int8 = Registro 10 
                 si185_mes = int8 = Mês 
                 si185_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_redispi122020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("redispi122020");
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
      $this->si185_sequencial = ($this->si185_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_sequencial"] : $this->si185_sequencial);
      $this->si185_tiporegistro = ($this->si185_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_tiporegistro"] : $this->si185_tiporegistro);
      $this->si185_codorgaoresp = ($this->si185_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_codorgaoresp"] : $this->si185_codorgaoresp);
      $this->si185_codunidadesubresp = ($this->si185_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_codunidadesubresp"] : $this->si185_codunidadesubresp);
      $this->si185_codunidadesubrespestadual = ($this->si185_codunidadesubrespestadual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_codunidadesubrespestadual"] : $this->si185_codunidadesubrespestadual);
      $this->si185_exercicioprocesso = ($this->si185_exercicioprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_exercicioprocesso"] : $this->si185_exercicioprocesso);
      $this->si185_nroprocesso = ($this->si185_nroprocesso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_nroprocesso"] : $this->si185_nroprocesso);
      $this->si185_codobralocal = ($this->si185_codobralocal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_codobralocal"] : $this->si185_codobralocal);
      $this->si185_logradouro = ($this->si185_logradouro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_logradouro"] : $this->si185_logradouro);
      $this->si185_numero = ($this->si185_numero == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_numero"] : $this->si185_numero);
      $this->si185_bairro = ($this->si185_bairro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_bairro"] : $this->si185_bairro);
      $this->si185_cidade = ($this->si185_cidade == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_cidade"] : $this->si185_cidade);
      $this->si185_cep = ($this->si185_cep == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_cep"] : $this->si185_cep);
      $this->si185_graulatitude = ($this->si185_graulatitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_graulatitude"] : $this->si185_graulatitude);
      $this->si185_minutolatitude = ($this->si185_minutolatitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_minutolatitude"] : $this->si185_minutolatitude);
      $this->si185_segundolatitude = ($this->si185_segundolatitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_segundolatitude"] : $this->si185_segundolatitude);
      $this->si185_graulongitude = ($this->si185_graulongitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_graulongitude"] : $this->si185_graulongitude);
      $this->si185_minutolongitude = ($this->si185_minutolongitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_minutolongitude"] : $this->si185_minutolongitude);
      $this->si185_segundolongitude = ($this->si185_segundolongitude == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_segundolongitude"] : $this->si185_segundolongitude);
      $this->si185_reg10 = ($this->si185_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_reg10"] : $this->si185_reg10);
      $this->si185_mes = ($this->si185_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_mes"] : $this->si185_mes);
      $this->si185_instit = ($this->si185_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_instit"] : $this->si185_instit);
    } else {
      $this->si185_sequencial = ($this->si185_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si185_sequencial"] : $this->si185_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si185_sequencial)
  {
    $this->atualizacampos();
    if ($this->si185_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si185_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si185_exercicioprocesso == null) {
      $this->si185_exercicioprocesso = "0";
    }


    if ($this->si185_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si185_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si185_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si185_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    if ($si185_sequencial == "" || $si185_sequencial == null) {
      $result = db_query("select nextval('redispi122020_si185_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: si185_sequencial_seq do campo: si185_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si185_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from si185_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si185_sequencial)) {
        $this->erro_sql = " Campo si185_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si185_sequencial = $si185_sequencial;
      }
    }
    if (($this->si185_sequencial == null) || ($this->si185_sequencial == "")) {
      $this->erro_sql = " Campo si185_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }

    if($this->si185_codobralocal == null){
      $this->si185_codobralocal = 0;
    }

    if($this->si185_cep == null){
      $this->si185_cep = 0;
    }

    $sql = "insert into redispi122020(
                                       si185_sequencial 
                                      ,si185_tiporegistro 
                                      ,si185_codorgaoresp 
                                      ,si185_codunidadesubresp 
                                      ,si185_codunidadesubrespestadual 
                                      ,si185_exercicioprocesso 
                                      ,si185_nroprocesso 
                                      ,si185_codobralocal 
                                      ,si185_logradouro 
                                      ,si185_numero 
                                      ,si185_bairro 
                                      ,si185_cidade 
                                      ,si185_cep 
                                      ,si185_graulatitude 
                                      ,si185_minutolatitude 
                                      ,si185_segundolatitude
                                      ,si185_graulongitude 
                                      ,si185_minutolongitude 
                                      ,si185_segundolongitude 
                                      ,si185_reg10
                                      ,si185_mes 
                                      ,si185_instit 
                       )
                values (
                                $this->si185_sequencial 
                               ,$this->si185_tiporegistro 
                               ,'$this->si185_codorgaoresp' 
                               ,'$this->si185_codunidadesubresp' 
                               ,'$this->si185_codunidadesubrespestadual' 
                               ,$this->si185_exercicioprocesso 
                               ,'$this->si185_nroprocesso' 
                               ,$this->si185_codobralocal 
                               ,'$this->si185_logradouro' 
                               ,$this->si185_numero 
                               ,'$this->si185_bairro' 
                               ,'$this->si185_cidade' 
                               ,$this->si185_cep 
                               ,$this->si185_graulatitude 
                               ,$this->si185_minutolatitude 
                               ,$this->si185_segundolatitude
                               ,$this->si185_graulongitude 
                               ,$this->si185_minutolongitude 
                               ,$this->si185_segundolongitude
                               ,$this->si185_reg10 
                               ,$this->si185_mes 
                               ,$this->si185_instit 
                      )";

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "redispi122020 ($this->si185_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "redispi122020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "redispi122020 ($this->si185_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si185_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);

    return true;
  }

  // funcao para alteracao
  function alterar($si185_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update redispi122020 set ";
    $virgula = "";
    if (trim($this->si185_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si185_sequencial"])) {
      if (trim($this->si185_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si185_sequencial"])) {
        $this->si185_sequencial = "0";
      }
      $sql .= $virgula . " si185_sequencial = $this->si185_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si185_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si185_tiporegistro"])) {
      $sql .= $virgula . " si185_tiporegistro = $this->si185_tiporegistro ";
      $virgula = ",";
      if (trim($this->si185_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si185_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si185_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si185_codorgaoresp"])) {
      $sql .= $virgula . " si185_codorgaoresp = '$this->si185_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si185_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si185_codunidadesubresp"])) {
      $sql .= $virgula . " si185_codunidadesubresp = '$this->si185_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si185_exercicioprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si185_exercicioprocesso"])) {
      if (trim($this->si185_exercicioprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si185_exercicioprocesso"])) {
        $this->si185_exercicioprocesso = "0";
      }
      $sql .= $virgula . " si185_exercicioprocesso = $this->si185_exercicioprocesso ";
      $virgula = ",";
    }
    if (trim($this->si185_nroprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si185_nroprocesso"])) {
      $sql .= $virgula . " si185_nroprocesso = '$this->si185_nroprocesso' ";
      $virgula = ",";
    }
    if (trim($this->si185_tipoprocesso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si185_tipoprocesso"])) {
      if (trim($this->si185_tipoprocesso) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si185_tipoprocesso"])) {
        $this->si185_tipoprocesso = "0";
      }
      $sql .= $virgula . " si185_tipoprocesso = $this->si185_tipoprocesso ";
      $virgula = ",";
    }


    if (trim($this->si185_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si185_mes"])) {
      $sql .= $virgula . " si185_mes = $this->si185_mes ";
      $virgula = ",";
      if (trim($this->si185_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si185_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si185_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si185_instit"])) {
      $sql .= $virgula . " si185_instit = $this->si185_instit ";
      $virgula = ",";
      if (trim($this->si185_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si185_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si185_sequencial != null) {
      $sql .= " si185_sequencial = $this->si185_sequencial";
    }


    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "redispi122020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si185_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "redispi122020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si185_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si185_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si185_sequencial = null, $dbwhere = null)
  {

    $sql = " delete from redispi122020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si185_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si185_sequencial = si185_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "redispi122020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si185_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "redispi122020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si185_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si185_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:redispi122020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query($si185_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from redispi122020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si185_sequencial != null) {
        $sql2 .= " where redispi122020.si185_sequencial = si185_sequencial ";
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
  function sql_query_file($si185_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from redispi122020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si185_sequencial != null) {
        $sql2 .= " where redispi122020.si185_sequencial = si185_sequencial ";
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
