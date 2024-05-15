<?
//MODULO: sicom
//CLASSE DA ENTIDADE ideedietal2020
class cl_ideedital2020
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
  var $si186_sequencial = 0;
  var $si186_codidentificador = 0;
  var $si186_cnpj = 0;
  var $si186_codorgao = 0;
  var $si186_tipoorgao = 0;
  var $si186_exercicioreferencia = 0;
  var $si186_mesreferencia = null;
  var $si186_datageracao_dia = null;
  var $si186_datageracao_mes = null;
  var $si186_datageracao_ano = null;
  var $si186_datageracao = null;
  var $si186_codcontroleremessa = null;
  var $si186_codseqremessames = null;
  var $si186_mes = 0;
  var $si186_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si186_sequencial = int8 = sequencial
                 si186_codidentificador = int8 = Código do Município
                 si186_cnpj = varchar(14) = cnpj
                 si186_codorgao = char(3) = Código do Orgão
                 si186_tipoorgao = char(2) = Tipo do Orgão
                 si186_exercicioreferencia = int4 = Exercício de  referência
                 si186_mesreferencia = char(2) = Mês de referência
                 si186_datageracao = date = Data de geração
                 si186_codcontroleremessa = varchar(20) = Código de controle
                 si186_codseqremessames = int4 = Código sequencial da Remessa
                 si186_mes = int8 = Mês
                 si186_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function cl_ideedital2020(){
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ideedital2020");
    $this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }

  //funcao erro
  function erro($mostra, $retorna){
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
      $this->si186_sequencial = ($this->si186_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_sequencial"] : $this->si186_sequencial);
      $this->si186_cnpj = ($this->si186_cnpj == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_cnpj"] : $this->si186_cnpj);
      $this->si186_codorgao = ($this->si186_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_codorgao"] : $this->si186_codorgao);
      $this->si186_tipoorgao = ($this->si186_tipoorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_tipoorgao"] : $this->si186_tipoorgao);
	    $this->si186_exercicioreferencia = ($this->si186_exercicioreferencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_exercicioreferencia"] : $this->si186_exercicioreferencia);
      $this->si186_mesreferencia = ($this->si186_mesreferencia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_mesreferencia"] : $this->si186_mesreferencia);
      if ($this->si186_datageracao == "") {
        $this->si186_datageracao_dia = ($this->si186_datageracao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_datageracao_dia"] : $this->si186_datageracao_dia);
        $this->si186_datageracao_mes = ($this->si186_datageracao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_datageracao_mes"] : $this->si186_datageracao_mes);
        $this->si186_datageracao_ano = ($this->si186_datageracao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_datageracao_ano"] : $this->si186_datageracao_ano);
        if ($this->si186_datageracao_dia != "") {
          $this->si186_datageracao = $this->si186_datageracao_ano . "-" . $this->si186_datageracao_mes . "-" . $this->si186_datageracao_dia;
        }
      }
      $this->si186_codcontroleremessa = ($this->si186_codcontroleremessa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_codcontroleremessa"] : $this->si186_codcontroleremessa);
      $this->si186_codseqremessames = ($this->si186_codseqremessames == "" ? @$GLOBALS["HTTP_POST_VARS"]["$this->si186_codseqremessames"] : $this->si186_codseqremessames);
      $this->si186_mes = ($this->si186_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_mes"] : $this->si186_mes);
      $this->si186_instit = ($this->si186_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_instit"] : $this->si186_instit);
    }
    else {
      $this->si186_sequencial = ($this->si186_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_sequencial"] : $this->si186_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si186_sequencial){
    $this->atualizacampos();
    if ($this->si186_exercicioreferencia == null) {
      $this->si186_exercicioreferencia = "0";
    }
    if ($this->si186_datageracao == null) {
      $this->si186_datageracao = "null";
    }
    if ($this->si186_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si186_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si186_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si186_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }


	if ($si186_sequencial == "" || $si186_sequencial == null) {
      $result = db_query("select nextval('ideedital2020_si186_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ideedital2020_si186_sequencial_seq do campo: si186_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si186_sequencial = pg_result($result, 0, 0);
    }
    else {
      $result = db_query("select last_value from ideedital2020_si186_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si186_sequencial)) {
        $this->erro_sql = " Campo si186_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      else {
        $this->si186_sequencial = $si186_sequencial;
      }
    }
    if (($this->si186_sequencial == null) || ($this->si186_sequencial == "")) {
      $this->erro_sql = " Campo si186_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if($this->si186_codseqremessames == null || $this->si186_codseqremessames == ''){
      $this->si186_codseqremessames = 0;
    }
    $sql = "insert into ideedital2020(
                                       si186_sequencial
                                      ,si186_codidentificador
                                      ,si186_cnpj
                                      ,si186_codorgao
                                      ,si186_tipoorgao
                                      ,si186_exercicioreferencia
                                      ,si186_mesreferencia
                                      ,si186_datageracao
                                      ,si186_codcontroleremessa
                                      ,si186_codseqremessames
                                      ,si186_mes
                                      ,si186_instit
                       )
                values (
                                $this->si186_sequencial
                               ,'$this->si186_codidentificador'
                               ,'$this->si186_cnpj'
                               ,'$this->si186_codorgao'
                               ,'$this->si186_tipoorgao'
                               ,$this->si186_exercicioreferencia
                               ,'$this->si186_mesreferencia'
                               ," . ($this->si186_datageracao == "null" || $this->si186_datageracao == "" ? "null" : "'" . $this->si186_datageracao . "'") . "
                               ,'$this->si186_codcontroleremessa'
                               ,$this->si186_codseqremessames
                               ,$this->si186_mes
                               ,$this->si186_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ideedital2020 ($this->si186_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ideedital2020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      else {
        $this->erro_sql = "ideedital2020 ($this->si186_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si186_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);


    return true;
  }

  // funcao para alteracao
  function alterar($si186_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ideedital2020 set ";
    $virgula = "";
    if (trim($this->si186_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_sequencial"])) {
      if (trim($this->si186_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si186_sequencial"])) {
        $this->si186_sequencial = "0";
      }
      $sql .= $virgula . " si186_sequencial = $this->si186_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si186_cnpj) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_cnpj"])) {
      $sql .= $virgula . " si186_cnpj = '$this->si186_cnpj' ";
      $virgula = ",";
    }
    if (trim($this->si186_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_codorgao"])) {
      $sql .= $virgula . " si186_codorgao = '$this->si186_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si186_tipoorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_tipoorgao"])) {
      $sql .= $virgula . " si186_tipoorgao = '$this->si186_tipoorgao' ";
      $virgula = ",";
    }
    if (trim($this->si186_exercicioreferencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_exercicioreferencia"])) {
      $sql .= $virgula . " si186_exercicioreferencia = '$this->si186_exercicioreferencia' ";
      $virgula = ",";
    }
    if (trim($this->si186_mesreferencia) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_mesreferencia"])) {
      $sql .= $virgula . " si186_mesreferencia = '$this->si186_mesreferencia' ";
      $virgula = ",";
    }

    if (trim($this->si186_datageracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_datageracao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si186_datageracao_dia"] != "")) {
      $sql .= $virgula . " si186_datageracao = '$this->si186_datageracao' ";
      $virgula = ",";
    }
    else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si186_datageracao_dia"])) {
        $sql .= $virgula . " si186_datageracao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si186_codcontroleremessa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_codcontroleremessa"])) {
      $sql .= $virgula . " si186_codcontroleremessa = '$this->si186_codcontroleremessa' ";
      $virgula = ",";
    }
    if (trim($this->si186_codseqremessames) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_codseqremessames"])) {
      $sql .= $virgula . " si186_codseqremessames = '$this->si186_codseqremessames' ";
      $virgula = ",";
    }
    if (trim($this->si186_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_mes"])) {
      $sql .= $virgula . " si186_mes = $this->si186_mes ";
      $virgula = ",";
      if (trim($this->si186_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si186_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si186_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_instit"])) {
      $sql .= $virgula . " si186_instit = $this->si186_instit ";
      $virgula = ",";
      if (trim($this->si186_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si186_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si186_sequencial != null) {
      $sql .= " si186_sequencial = $this->si186_sequencial";
    }

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ideedital2020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si186_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    }
    else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ideedital2020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si186_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      }
      else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si186_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si186_sequencial = null, $dbwhere = null)
  {

    $sql = " delete from ideedital2020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si186_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si186_sequencial = $si186_sequencial ";
      }
    }
    else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ideedital2020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si186_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    }
    else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ideedital2020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si186_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      }
      else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si186_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ideedital2020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  function sql_query($si186_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }
    else {
      $sql .= $campos;
    }
    $sql .= " from ideedital2020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si186_sequencial != null) {
        $sql2 .= " where ideedital2020.si186_sequencial = $si186_sequencial ";
      }
    }
    else if ($dbwhere != "") {
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
  function sql_query_file($si186_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }
    else {
      $sql .= $campos;
    }
    $sql .= " from ideedital2020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si186_sequencial != null) {
        $sql2 .= " where ideedital2020.si186_sequencial = $si186_sequencial ";
      }
    }
    else if ($dbwhere != "") {
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
